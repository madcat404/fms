<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.08.27>
	// Description:	<블랙리스트 업로드(스팸아웃)>	
    // Last Modified: <25.09.12> - Refactored for PHP 8.x, Security, and Stability
	// =============================================
    //nas 또는 fms서버 재시작으로 인하여 마운트가 끈어진 경우 재마운트 필요
    //nas 경로가 달라진 경우 filename 재작성 필요 
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';      
    require '../vendor/autoload.php';
    
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Shared\Date;

    $filename = '../../../../mnt3/blacklist.xlsx'; // 읽어들일 엑셀 파일의 경로와 파일명을 지정한다.
  

    // --- Main Execution ---
    echo "블랙리스트 처리를 시작합니다: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";

    // DB 연결 확인
    if ($connect === false) {
        die("데이터베이스 연결에 실패했습니다. 스크립트를 중단합니다.");
    }

    // 파일 존재 및 읽기 권한 확인
    if (!is_readable($filename)) {
        die("엑셀 파일을 찾을 수 없거나 읽을 수 없습니다. 경로: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8'));
    }

    try {
        // --- 파일 로드 ---
        $spreadsheet = IOFactory::load($filename);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        // --- 헤더 확인 및 시작 행 동적 결정 ---
        $cellB1Value = $worksheet->getCell('B1')->getValue();
        // B1 셀의 값이 유효한 IP 주소인지 확인
        if (filter_var(trim($cellB1Value), FILTER_VALIDATE_IP)) {
            $startRow = 1; // B1이 IP 주소이면 1행부터 시작
            echo "1행 B열이 IP 주소이므로 1행부터 처리를 시작합니다.<br>";
        } else {
            $startRow = 2; // B1이 IP 주소가 아니면 2행부터 시작 (헤더로 간주)
            echo "1행 B열이 IP 주소가 아니므로 헤더로 간주하고 2행부터 처리를 시작합니다.<br>";
        }

        echo "총 " . ($highestRow - ($startRow - 1)) . "개의 행을 처리합니다.<br>";

        $processedCount = 0;
        $insertCount = 0;
        $updateCount = 0;

        // --- 행 반복 및 처리 ---
        for ($row = $startRow; $row <= $highestRow; ++$row) {
            try {
                // --- 데이터 추출 및 기본 검증 ---
                $dataB = trim($worksheet->getCell('B' . $row)->getValue() ?? ''); // IP
                if (empty($dataB)) {
                    continue; // IP가 없으면 건너뛰기
                }

                // --- 데이터 변환 ---
                $excelDateValue = $worksheet->getCell('A' . $row)->getValue();
                $dataA = Date::excelToDateTimeObject($excelDateValue)->format('Y-m-d'); // 날짜

                $dataC = trim($worksheet->getCell('C' . $row)->getValue() ?? ''); // 국가
                $dataD = trim($worksheet->getCell('D' . $row)->getValue() ?? ''); // ID
                $dataF = trim($worksheet->getCell('F' . $row)->getValue() ?? ''); // PW
                
                $dataD = str_replace('@iwin.kr', '', $dataD);
                $anlab = $dataB . ';';

                // 기존 로직에 따라 내부 IP 및 KR 국가 건너뛰기
                if (strpos($dataB, '192.168') === 0 || $dataC === 'KR') {
                    continue;
                }

                // --- DB 처리 (파라미터화된 쿼리 사용) ---
                $checkSql = "SELECT ip, attack_try FROM CONNECT.dbo.BLACKLIST WHERE ip = ?";
                $checkStmt = sqlsrv_query($connect, $checkSql, [$dataB]);
                if ($checkStmt === false) {
                    throw new Exception("IP 확인 쿼리 실패");
                }
                
                $existingRecord = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);

                if ($existingRecord) {
                    // 기존 레코드 업데이트
                    $newTryCount = $existingRecord['attack_try'] + 1;
                    $updateSql = "UPDATE CONNECT.dbo.BLACKLIST SET attack_try = ? WHERE ip = ?";
                    $updateStmt = sqlsrv_query($connect, $updateSql, [$newTryCount, $dataB]);
                    if ($updateStmt === false) {
                        throw new Exception("UPDATE 쿼리 실패");
                    }
                    $updateCount++;
                } else {
                    // 신규 레코드 삽입
                    $insertSql = "INSERT INTO CONNECT.dbo.BLACKLIST(ip, anlab, COUNTRY, note, dt, attack_note, attack_try, attack_id, attack_pw) VALUES (?, ?, ?, '자체 수집', ?, 'smtp 로그인 실패', '1', ?, ?)";
                    $insertParams = [$dataB, $anlab, $dataC, $dataA, $dataD, $dataF];
                    $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
                    if ($insertStmt === false) {
                        throw new Exception("INSERT 쿼리 실패");
                    }
                    $insertCount++;
                }
                $processedCount++;

            } catch (Throwable $t) {
                // 행 처리 중 오류 발생 시 로그만 남기고 계속 진행
                error_log("오류 발생 (행: {$row}): " . $t->getMessage());
                continue;
            }
        }

        echo "----------------------------------------<br>";
        echo "블랙리스트 처리 완료.<br>";
        echo "총 처리된 행: {$processedCount}<br>";
        echo "신규 추가: {$insertCount} 건<br>";
        echo "카운트 업데이트: {$updateCount} 건<br>";

    } catch (Throwable $t) {
        // 파일 로드 등 스크립트의 주요 오류 처리
        echo "스크립트 실행 중 심각한 오류가 발생했습니다: " . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8');
    } finally {
        // DB 연결 종료
        if (isset($connect)) {
            sqlsrv_close($connect);
        }
    }