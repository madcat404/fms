<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <25.12.01>
    // Description: <인원 엑셀 데이터 DB 자동 업로드 (통합 테이블 구조 반영)>
    // Last Modified: <25.12.01> - Updated for specific DB Schema
    // =============================================

    // --- Setup and Includes ---
    include '../session/ip_session.php';
    include '../DB/DB2.php';
    require_once '../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;

    // --- Helper Function: 셀 데이터 숫자 변환 (빈값/문자 -> 0) ---
    function getNumValue($worksheet, $cellAddress) {
        $val = $worksheet->getCell($cellAddress)->getCalculatedValue();
        return is_numeric($val) ? $val : 0;
    }

    // --- Main Execution ---
    echo "인원현황 보고서 처리를 시작합니다.<br>";

    try {
        // --- 1. 날짜 변수 설정 ---
        $today = new DateTime();
        $YY = $today->format('Y');
        $MM = $today->format('n');
        $MM2 = $today->format('m');
        $D = $today->format('j');
        $Day_formatted = $today->format('Y-m-d'); // SORTING_DATE에 들어갈 값

        $filename = "../../../../mnt4/{$YY}년/{$MM}월/일일현황보고({$MM2}월 {$D}일).xlsx";
        echo "대상 파일: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";

        // --- 2. DB 및 파일 확인 ---
        if ($connect === false) {
            throw new Exception("데이터베이스 연결에 실패했습니다.");
        }
        if (!is_readable($filename)) {
            throw new Exception("엑셀 파일을 찾을 수 없거나 읽을 수 없습니다.");
        }      

        // --- 3. 엑셀 파일 로드 ---
        $spreadsheet = IOFactory::load($filename);
        $worksheet = $spreadsheet->getSheet(2); // 3번째 시트

        // --- 4. 데이터 추출 (한 번에 모든 행 읽기) ---
        
        // [A] 관리직 (Row 4) -> SAMU_...
        $SAMU_TOTAL     = getNumValue($worksheet, 'B3');
        $SAMU_FOREIGN   = getNumValue($worksheet, 'E4');
        $SAMU_ANNUAL    = getNumValue($worksheet, 'G4');
        $SAMU_OFFICIAL  = getNumValue($worksheet, 'I4');
        $SAMU_EDUCATION = getNumValue($worksheet, 'K4');
        $SAMU_BISINESS  = getNumValue($worksheet, 'M4'); 
        $SAMU_ABSENCE   = getNumValue($worksheet, 'O4');

        // [B] 퍼스트인 생산직 (Row 8) -> FIRSTIN_FIELD_...
        $FIELD_TOTAL     = getNumValue($worksheet, 'B7');
        $FIELD_SICK      = getNumValue($worksheet, 'E8');
        $FIELD_ANNUAL    = getNumValue($worksheet, 'G8');
        $FIELD_OFFICIAL  = getNumValue($worksheet, 'I8');
        $FIELD_EDUCATION = getNumValue($worksheet, 'K8');
        $FIELD_BISINESS  = getNumValue($worksheet, 'M8');
        $FIELD_NIGHT     = getNumValue($worksheet, 'O8');

        // [C] 파견직 (Row 12) -> FIRSTIN_NONFIELD_...
        $NONFIELD_TOTAL     = getNumValue($worksheet, 'B11');
        $NONFIELD_DISPATCH  = getNumValue($worksheet, 'E12');
        $NONFIELD_ANNUAL    = getNumValue($worksheet, 'G12');
        $NONFIELD_OFFICIAL  = getNumValue($worksheet, 'I12');
        $NONFIELD_EDUCATION = getNumValue($worksheet, 'K12');
        $NONFIELD_BISINESS  = getNumValue($worksheet, 'M12');
        $NONFIELD_SICK      = getNumValue($worksheet, 'O12');


        // --- [추가됨] 5. 중복 데이터 확인 (SORTING_DATE 기준) ---
        $checkSql = "SELECT COUNT(*) AS cnt FROM CONNECT.dbo.ATTEND WHERE SORTING_DATE = ?";
        $checkStmt = sqlsrv_query($connect, $checkSql, [$Day_formatted]);

        if ($checkStmt === false) {
            throw new Exception("중복 확인 쿼리 실패: " . print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
        
        // 데이터가 이미 존재하면 (cnt > 0)
        if ($row['cnt'] > 0) {
            echo "<hr><h2>처리 건너뜀 (중복 데이터)</h2>";
            echo "<strong>{$Day_formatted}</strong> 날짜의 데이터가 이미 DB에 존재합니다.<br>";
            echo "중복 입력을 방지하기 위해 INSERT를 수행하지 않았습니다.<br>";
        } 
        else {
            // --- 6. DB INSERT 실행 (데이터가 없을 때만 실행) ---
            
            $sql = "INSERT INTO CONNECT.dbo.ATTEND (
                        SAMU_TOTAL, SAMU_FOREIGN, SAMU_ANNUAL, SAMU_OFFICIAL, SAMU_EDUCATION, SAMU_BISINESS, SAMU_ABSENCE,
                        FIRSTIN_FIELD_TOTAL, FIRSTIN_FIELD_SICK, FIRSTIN_FIELD_ANNUAL, FIRSTIN_FIELD_OFFICIAL, FIRSTIN_FIELD_EDUCATION, FIRSTIN_FIELD_BISINESS, FIRSTIN_FIELD_NIGHT,
                        FIRSTIN_NONFIELD_TOTAL, FIRSTIN_NONFIELD_DISPATCH, FIRSTIN_NONFIELD_ANNUAL, FIRSTIN_NONFIELD_OFFICIAL, FIRSTIN_NONFIELD_EDUCATION, FIRSTIN_NONFIELD_BISINESS, FIRSTIN_NONFIELD_SICK,
                        SORTING_DATE
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?,
                        ?, ?, ?, ?, ?, ?, ?,
                        ?, ?, ?, ?, ?, ?, ?,
                        ?
                    )";

            // 파라미터 바인딩
            $params = [
                // SAMU (7개)
                $SAMU_TOTAL, $SAMU_FOREIGN, $SAMU_ANNUAL, $SAMU_OFFICIAL, $SAMU_EDUCATION, $SAMU_BISINESS, $SAMU_ABSENCE,
                // FIELD (7개)
                $FIELD_TOTAL, $FIELD_SICK, $FIELD_ANNUAL, $FIELD_OFFICIAL, $FIELD_EDUCATION, $FIELD_BISINESS, $FIELD_NIGHT,
                // NONFIELD (7개)
                $NONFIELD_TOTAL, $NONFIELD_DISPATCH, $NONFIELD_ANNUAL, $NONFIELD_OFFICIAL, $NONFIELD_EDUCATION, $NONFIELD_BISINESS, $NONFIELD_SICK,
                // DATE
                $Day_formatted
            ];

            $stmt = sqlsrv_query($connect, $sql, $params);

            if ($stmt === false) {
                throw new Exception("INSERT 쿼리 실패: " . print_r(sqlsrv_errors(), true));
            }

            echo "<hr><h2>처리 완료</h2>";
            echo "{$Day_formatted} 날짜의 데이터(관리직/생산직/파견직)가 성공적으로 저장되었습니다.<br>";
        }

    } catch (Throwable $t) {
        echo "스크립트 실행 중 오류가 발생했습니다: " . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8');
    } finally {
        if (isset($connect4)) { mysqli_close($connect4); }
        if (isset($connect)) { sqlsrv_close($connect); }
    }
?>