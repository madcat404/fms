<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <23.03.06>
    // Description: <전기 API 모듈>
    // Last Modified: <25.09.16> - Refactored with Upsert Logic
    // =============================================

    // --- Setup and Includes ---
    set_time_limit(120);
    require_once __DIR__ . '/../session/session_check.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    include_once __DIR__ . '/../DB/DB2.php';   

    use PhpOffice\PhpSpreadsheet\IOFactory;

    // --- Configuration ---
    const KEPCO_API_KEY = '09990s97u5pp0959fq1v';
    const KEPCO_CUST_NO = '0433209253';

    // --- Main Execution ---
    echo "전기 사용량 데이터 처리를 시작합니다.<br>";

    try {
        // --- 1. 날짜 변수 설정 ---
        $yesterday = (new DateTime())->modify('-1 day');
        $today = new DateTime();
        $yesterday_api_format = $yesterday->format('Ymd'); // API 호출용 (어제)
        $today_db_format = $today->format('Y-m-d');      // DB 저장용 (오늘)
        
        echo "API 조회 대상 날짜: {$yesterday->format('Y-m-d')}<br>";
        echo "DB 저장 대상 날짜: {$today_db_format}<br>";

        // --- 2. DB 확인 ---
        if ($connect === false) {
            throw new Exception("데이터베이스 연결에 실패했습니다.");
        }

        // --- 3. API 호출 ---
        $url = sprintf(
            "https://opm.kepco.co.kr:11080/OpenAPI/getDayLpData.do?custNo=%s&date=%s&mrhm=0000&serviceKey=%s&returnType=01",
            KEPCO_CUST_NO, $yesterday_api_format, KEPCO_API_KEY
        );
        echo "API 호출 중...<br>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError || $httpCode !== 200) {
            throw new Exception("API 호출 실패 (HTTP 코드: {$httpCode}, 오류: {$curlError})");
        }
        echo "API 호출 성공.<br>";

        // --- 4. XML 파싱 및 데이터 처리 ---
        $xml = simplexml_load_string($response);
        // KEPCO API의 응답 헤더 태그(cmmMsgHeader)를 정확히 확인합니다.
        if ($xml === false || (string)$xml->cmmMsgHeader->returnCode !== '00') {
            $errorMessage = $xml ? (string)$xml->cmmMsgHeader->errMsg : 'XML 파싱 실패';
            throw new Exception("API 응답 오류: " . $errorMessage);
        }

        $dayLpData = $xml->dayLpDataInfoList[0]->dayLpDataInfo[0] ?? null;
        if ($dayLpData === null) {
            throw new Exception("XML 데이터 구조에서 사용량 정보를 찾을 수 없습니다.");
        }

        $total_electricity = 0.0;
        for ($h = 0; $h < 24; $h++) {
            for ($m = 0; $m < 60; $m += 15) {
                if ($h === 0 && $m === 0) continue;
                $time_suffix = sprintf('%02d%02d', $h, $m);
                $prop_name = 'pwr_qty' . $time_suffix;
                if (isset($dayLpData->$prop_name)) {
                    $total_electricity += (float)$dayLpData->$prop_name;
                }
            }
        }
        if (isset($dayLpData->pwr_qty2400)) {
            $total_electricity += (float)$dayLpData->pwr_qty2400;
        }
        
        echo "계산된 총 사용량: {$total_electricity} kWh<br>";

        // --- 5. 데이터베이스 작업 (Upsert: 데이터가 있으면 UPDATE, 없으면 INSERT) ---
        echo "DB 작업 시작 (대상 날짜: {$today_db_format})... ";

        $checkSql = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.READ_METER WHERE SORTING_DATE = ?";
        $checkStmt = sqlsrv_query($connect, $checkSql, [$today_db_format]);
        if ($checkStmt === false) {
            throw new Exception("기존 데이터 확인 쿼리 실패: " . print_r(sqlsrv_errors(), true));
        }
        $rowCount = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)['cnt'];

        if ($rowCount > 0) {
            // 데이터가 있으면 UPDATE (덮어쓰기)
            $updateSql = "UPDATE CONNECT.dbo.READ_METER SET ELECTRICITY = ? WHERE SORTING_DATE = ?";
            $updateParams = [$total_electricity, $today_db_format];
            $updateStmt = sqlsrv_query($connect, $updateSql, $updateParams);
            if ($updateStmt === false) {
                throw new Exception("UPDATE 쿼리 실패: " . print_r(sqlsrv_errors(), true));
            }
            echo "기존 데이터를 덮어썼습니다.";
        } else {
            // 데이터가 없으면 INSERT (신규 입력)
            $insertSql = "INSERT INTO CONNECT.dbo.READ_METER(ELECTRICITY, SORTING_DATE) VALUES (?, ?)";
            $insertParams = [$total_electricity, $today_db_format];
            $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
            if ($insertStmt === false) {
                throw new Exception("INSERT 쿼리 실패: " . print_r(sqlsrv_errors(), true));
            }
            echo "새 데이터를 입력했습니다.";
        }
        echo "<br>";

        // --- 6. 결과에 따른 메일 발송 ---
        if ($total_electricity == 0) {
            echo "전기 사용량이 0이므로, 경고 메일을 발송합니다.<br>";
            $mailerUrl = "http://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "/mailer.php?type=electricity_data_error";
            $mailResult = file_get_contents($mailerUrl);
            if ($mailResult === false) {
                echo "경고 메일 발송 API 호출에 실패했습니다.<br>";
            } else {
                echo "메일 발송 결과: " . htmlspecialchars($mailResult) . "<br>";
            }
        }

        echo "<hr><h2>최종 처리 완료</h2>";

    } catch (Throwable $t) {
        echo "<h2 style='color:red;'>스크립트 실행 중 오류가 발생했습니다</h2>";
        echo "<pre>" . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
        echo "오류가 발생하여, 경고 메일을 발송합니다.<br>";
        $mailerUrl = "http://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "/mailer.php?type=electricity_data_error";
        $mailResult = file_get_contents($mailerUrl);
        if ($mailResult === false) {
            echo "경고 메일 발송 API 호출에 실패했습니다.<br>";
        } else {
            echo "메일 발송 결과: " . htmlspecialchars($mailResult) . "<br>";
        }
    } finally {
        if (isset($connect)) { sqlsrv_close($connect); }
    }
?>