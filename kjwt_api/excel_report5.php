<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <25.12.01>
    // Description: <인원 엑셀 데이터 DB 자동 업로드 (통합 테이블 구조 반영)>
    // Last Modified: <25.12.01> - Updated for specific DB Schema
    // Update Note: <26.01.06> - 다양한 파일명 날짜 형식 지원 추가
    // =============================================

    // --- Setup and Includes ---
    set_time_limit(0); // 실행 시간 제한 없음
    require_once __DIR__ . '/../session/session_check.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    include_once __DIR__ . '/../DB/DB2.php'; 

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
        $MM = $today->format('n');  // 월 (앞에 0 없음)
        $MM2 = $today->format('m'); // 월 (앞에 0 있음)
        $D = $today->format('j');   // 일 (앞에 0 없음)
        $D2 = $today->format('d');  // 일 (앞에 0 있음) - 추가됨
        
        $Day_formatted = $today->format('Y-m-d'); // SORTING_DATE에 들어갈 값

        // --- 2. 다양한 파일명 형식 탐색 ---
        // 파일의 기본 경로 (디렉토리 + 파일명 접두사)
        $base_path_prefix = "../../../../mnt4/{$YY}년/{$MM}월/일일현황보고";
        
        // 가능한 날짜 형식 조합 (우선순위 순서대로 배열 배치)
        $possible_suffixes = [
            "({$MM2}월 {$D}일).xlsx",   // 예: (01월 5일).xlsx
            "({$MM2}월 {$D2}일).xlsx",  // 예: (01월 05일).xlsx
            "({$MM}월 {$D}일).xlsx",    // 예: (1월 5일).xlsx
            "({$MM}월 {$D2}일).xlsx"    // 예: (1월 05일).xlsx
        ];

        $filename = null; // 최종 선택된 파일명을 담을 변수

        // 후보군을 순회하며 파일 존재 여부 확인
        foreach ($possible_suffixes as $suffix) {
            $temp_path = $base_path_prefix . $suffix;
            if (is_readable($temp_path)) {
                $filename = $temp_path;
                echo "파일을 찾았습니다: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";
                break; // 파일을 찾으면 루프 종료
            }
        }

        // --- 3. DB 및 파일 예외 처리 ---
        if ($connect === false) {
            throw new Exception("데이터베이스 연결에 실패했습니다.");
        }

        // 파일이 설정되지 않았거나 읽을 수 없는 경우
        if ($filename === null || !is_readable($filename)) {
            // 디버깅을 위해 탐색한 경로 힌트 출력
            $search_hint = htmlspecialchars($base_path_prefix, ENT_QUOTES, 'UTF-8') . "(...날짜...).xlsx";
            throw new Exception("엑셀 파일을 찾을 수 없습니다.<br>탐색 경로 패턴: {$search_hint}<br>가능한 모든 날짜 형식을 확인했지만 파일이 없습니다.");
        }

        // --- 4. 엑셀 파일 로드 ---
        $spreadsheet = IOFactory::load($filename);
        $worksheet = $spreadsheet->getSheet(2); // 3번째 시트

        // --- 5. 데이터 추출 (한 번에 모든 행 읽기) ---
        
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


        // --- 6. 중복 데이터 확인 (SORTING_DATE 기준) ---
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
            // --- 7. DB INSERT 실행 (데이터가 없을 때만 실행) ---
            
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