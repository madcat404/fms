<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <23.07.08>
    // Description: <수주 엑셀 데이터 db 자동 업로드>
    // Last Modified: <25.09.16> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    // --- Setup and Includes ---
    set_time_limit(0);
    require_once __DIR__ . '/../session/session_check.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    include_once __DIR__ . '/../DB/DB2.php'; 

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Shared\Date;

    /**
    * 엑셀의 날짜 값을 처리하는 헬퍼 함수
    */
    function processDateValue($value)
    {
        if (trim($value) === '-' || empty($value)) {
            return "-"; // 값이 '-' 이거나 비어있으면 '-' 반환
        }
        try {
            // 숫자 값인 경우, 엑셀 날짜로 간주하고 변환 시도
            if (is_numeric($value)) {
                $dateTime = Date::excelToDateTimeObject($value);
                // 1900년, 1899년 등 잘못된 변환이 아닌지 확인
                if ($dateTime->format('Y') > 2000) {
                    return $dateTime->format('Y-m-d');
                }
            }
            // 유효한 날짜 숫자가 아니면, 원래의 문자열 값 반환
            return (string) $value;
        } catch (Throwable $t) {
            // 날짜 변환 중 오류 발생 시, 원래 값 반환
            return (string) $value;
        }
    }

    // --- Main Execution ---
    echo "수주 일정 데이터 처리를 시작합니다.<br>";

    try {
        // --- 1. 경로 및 파일 확인 ---
        $filename = '../../../../mnt3/fms용 개발차종별 단계별 상세 일정.xlsx';
        echo "대상 파일: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";

        if ($connect === false) { throw new Exception("데이터베이스 연결 실패"); }
        if (!is_readable($filename)) { throw new Exception("엑셀 파일을 찾을 수 없거나 읽을 수 없음"); }

        // --- 2. 기존 데이터 삭제 ---
        $currentYear = date('Y');
        echo "기존 DEVELOP 테이블에서 {$currentYear}년도 데이터를 삭제합니다... ";
        $deleteSql = "DELETE FROM CONNECT.dbo.DEVELOP WHERE YEAR(sorting_date) = ?";
        $deleteStmt = sqlsrv_query($connect, $deleteSql, [$currentYear]);
        if ($deleteStmt === false) {
            throw new Exception("올해 데이터 삭제(DELETE) 실패: " . print_r(sqlsrv_errors(), true));
        }
        echo "완료.<br>";

        // --- 3. 엑셀 파일 처리 ---
        echo "엑셀 파일 로드 중 ... ";
        $spreadsheet = IOFactory::load($filename);
        echo "완료.<br>";

        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $insertCount = 0;

        echo "데이터 처리 시작...<br>";
        // --- 행 반복 처리 ---
        for ($i = 5; $i <= $highestRow; $i++) {
            try {
                $dataB = trim($worksheet->getCell('B' . $i)->getValue() ?? '');
                if (empty($dataB)) {
                    echo "B열이 비어있어 처리를 중단합니다. (행: {$i})<br>";
                    break; // 데이터의 끝으로 간주하고 종료
                }

                $dataA = $worksheet->getCell('A' . $i)->getValue();
                $dataC = processDateValue($worksheet->getCell('C' . $i)->getValue());
                $dataD = processDateValue($worksheet->getCell('D' . $i)->getValue());
                $dataE = processDateValue($worksheet->getCell('E' . $i)->getValue());
                $dataF = processDateValue($worksheet->getCell('F' . $i)->getValue());
                $dataG = processDateValue($worksheet->getCell('G' . $i)->getValue());
                $dataH = $worksheet->getCell('H' . $i)->getValue();
                $dataI = $worksheet->getCell('I' . $i)->getValue();
                $dataJ_raw = $worksheet->getCell('J' . $i)->getValue();
                $dataJ = (trim($dataJ_raw) === '-' || trim($dataJ_raw) === '0' || empty($dataJ_raw)) ? "-" : $dataJ_raw;

                // --- DB INSERT (Parameterized) ---
                $insertSql = "INSERT INTO CONNECT.dbo.DEVELOP(EXCEL_NO, CAR, PROTO, P1, P2, M, SOP, CAR_MAKER, SEAT_MAKER, VOLUME) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insertParams = [$dataA, $dataB, $dataC, $dataD, $dataE, $dataF, $dataG, $dataH, $dataI, $dataJ];
                
                $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
                if ($insertStmt === false) {
                    throw new Exception("INSERT 쿼리 실패: " . print_r(sqlsrv_errors(), true));
                }
                $insertCount++;

            } catch (Throwable $t) {
                error_log("오류 발생 (행: {$i}): " . $t->getMessage());
                continue;
            }
        }

        echo "<hr><h2>최종 처리 완료</h2>";
        echo "총 {$insertCount}개의 레코드가 성공적으로 추가되었습니다.<br>";

    } catch (Throwable $t) {
        echo "<h2 style='color:red;'>스크립트 실행 중 심각한 오류가 발생했습니다</h2>";
        echo "<pre>" . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
    } finally {
        if (isset($connect4)) { mysqli_close($connect4); }
        if (isset($connect)) { sqlsrv_close($connect); }
    }
?>