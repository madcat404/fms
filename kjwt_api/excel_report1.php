<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <23.06.13>
    // Description: <매출 엑셀 데이터 db 자동 업로드>
    // Last Modified: <25.09.15> - Refactored for PHP 8.x, Security, and Stability
    // Update Note: <26.01.06> - C17(병합셀) 전년도 감지 로직 강화 및 디버깅 추가
    // =============================================

    // --- Setup and Includes ---
    set_time_limit(0); 
    
    require_once __DIR__ . '/../session/session_check.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    include_once __DIR__ . '/../DB/DB2.php';     

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Shared\Date; 

    // --- Main Execution ---
    echo "일일 매출 보고서 처리를 시작합니다.<br>";

    try {
        // --- 1. 날짜 변수 설정 ---
        $today = new DateTime();
        $tomorrow = (new DateTime())->modify('+1 day');

        $YY = $today->format('Y');      // 현재 연도 (예: 2026)
        $MM = $today->format('n');
        $MM2 = $today->format('m');
        $D = $today->format('j');
        $D2 = $today->format('d');
        
        $Plus1Day_formatted = $tomorrow->format('Y-m-d'); 

        // --- 2. 파일명 탐색 ---
        $base_path_prefix = "../../../../mnt4/{$YY}년/{$MM}월/일일현황보고";
        
        $possible_suffixes = [
            "({$MM2}월 {$D}일).xlsx",   
            "({$MM2}월 {$D2}일).xlsx",  
            "({$MM}월 {$D}일).xlsx",    
            "({$MM}월 {$D2}일).xlsx"    
        ];

        $filename = null;

        foreach ($possible_suffixes as $suffix) {
            $temp_path = $base_path_prefix . $suffix;
            if (is_readable($temp_path)) {
                $filename = $temp_path;
                echo "파일을 찾았습니다: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";
                break;
            }
        }

        // --- 3. DB 및 파일 확인 ---
        if ($connect === false) {
            throw new Exception("데이터베이스 연결에 실패했습니다.");
        }

        if ($filename === null || !is_readable($filename)) {
            $search_hint = htmlspecialchars($base_path_prefix, ENT_QUOTES, 'UTF-8') . "(...날짜...).xlsx";
            throw new Exception("엑셀 파일을 찾을 수 없습니다.<br>탐색 경로 패턴: {$search_hint}");
        }

        // --- 4. 엑셀 로드 및 C17(연도) 정밀 분석 ---
        $spreadsheet = IOFactory::load($filename);
        $worksheet = $spreadsheet->getSheet(2); // 3번째 시트
        
        // C17 셀 값 읽기 (병합된 셀이라도 좌상단 좌표인 C17로 접근하면 값 획득 가능)
        $c17Cell = $worksheet->getCell('C17');
        $c17Value = $c17Cell->getValue();           // 원본 값 (숫자 or 텍스트)
        $c17Formatted = $c17Cell->getFormattedValue(); // 화면에 보이는 값 (예: "2025년")
        
        // [디버깅] 실제 읽은 값 출력 (문제가 계속되면 이 출력을 확인해주세요)
        echo "<b>[C17 셀 분석]</b> 원본값: '{$c17Value}', 포맷값: '{$c17Formatted}' <br>";

        $detectedYear = null;

        // 1) 엑셀 날짜 형식(숫자)인 경우
        if (Date::isDateTime($c17Cell)) {
            $detectedYear = Date::excelToDateTimeObject($c17Value)->format('Y');
        } 
        // 2) 텍스트 형식인 경우 (예: "2025년", "2025")
        else {
            // 숫자 4자리를 찾아서 연도로 인식
            if (preg_match('/(\d{4})/', (string)$c17Formatted, $matches)) {
                $detectedYear = (int)$matches[1];
            } elseif (preg_match('/(\d{4})/', (string)$c17Value, $matches)) {
                $detectedYear = (int)$matches[1];
            }
        }

        // --- 5. 날짜(SORTING_DATE) 확정 로직 ---
        $finalSortingDate = $Plus1Day_formatted; // 기본값: 내일 날짜

        // 감지된 연도가 있고, 현재 연도($YY)보다 작다면 (예: 2025 < 2026) -> 과거 데이터(마감)로 판단
        if ($detectedYear && $detectedYear < (int)$YY) {
            $finalSortingDate = "{$detectedYear}-12-31"; // 해당 연도의 말일로 고정
            echo "<span style='color:blue; font-weight:bold;'>[과거 연도 감지]</span> C17 셀에서 <b>{$detectedYear}년</b>이 확인되었습니다.<br>";
            echo "-> 날짜를 <b>{$finalSortingDate}</b>로 고정하여 처리합니다.<br>";
        } else {
            echo "일반 일일 보고로 처리합니다 (날짜: {$finalSortingDate}). <br>";
            if ($detectedYear) {
                echo "(C17 셀 연도: {$detectedYear}, 시스템 연도: {$YY})<br>";
            } else {
                echo "(C17 셀에서 연도를 찾지 못했습니다)<br>";
            }
        }

        // --- 6. 기존 데이터 삭제 ---
        echo "기존 데이터 삭제 중 (대상 날짜: {$finalSortingDate})... ";
        
        $deleteSql = "DELETE FROM CONNECT.dbo.SALES WHERE SORTING_DATE = ?";
        $deleteStmt = sqlsrv_query($connect, $deleteSql, [$finalSortingDate]);
        
        if ($deleteStmt === false) {
            throw new Exception("기존 데이터 삭제 실패: " . print_r(sqlsrv_errors(), true));
        }
        echo "완료.<br>";

        // --- 7. 데이터 처리 및 입력 ---
        $insertCount = 0;
        $processedKinds = [];

        $rowsToProcess = [
            20 => '히터', 22 => '발열핸들(열선)', 24 => '통풍(이원컴포텍)',
            26 => '통풍', 28 => '통합ECU', 30 => '일반ECU',
            32 => '기타', 33 => '합계'
        ];

        foreach ($rowsToProcess as $rowNum => $expectedKind) {
            try {
                $dataF = $worksheet->getCell('F' . $rowNum)->getCalculatedValue();
                $dataK = $worksheet->getCell('K' . $rowNum)->getCalculatedValue();
                $dataP = $worksheet->getCell('P' . $rowNum)->getCalculatedValue();

                $y_money = is_numeric($dataF) ? $dataF : 0;
                $m_money = is_numeric($dataK) ? $dataK : 0;
                $d_money = is_numeric($dataP) ? $dataP : 0;

                // 확정된 $finalSortingDate 사용
                $insertSql = "INSERT INTO CONNECT.dbo.SALES(KIND, Y_MONEY, M_MONEY, D_MONEY, SORTING_DATE) VALUES (?, ?, ?, ?, ?)";
                $insertParams = [$expectedKind, $y_money, $m_money, $d_money, $finalSortingDate];
                
                $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
                if ($insertStmt === false) {
                    throw new Exception("INSERT 쿼리 실패 (행: {$rowNum}): " . print_r(sqlsrv_errors(), true));
                }
                $insertCount++;
                $processedKinds[] = $expectedKind;

            } catch (Throwable $t) {
                error_log("오류 발생 (행: {$rowNum}): " . $t->getMessage());
            }
        }

        echo "<hr><h2>처리 완료</h2>";
        echo "총 {$insertCount}개의 레코드가 성공적으로 추가되었습니다.<br>";
        echo "처리된 항목: " . htmlspecialchars(implode(', ', $processedKinds), ENT_QUOTES, 'UTF-8');

    } catch (Throwable $t) {
        echo "<h2 style='color:red;'>스크립트 실행 중 심각한 오류가 발생했습니다</h2>";
        echo "메시지: " . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8');
    } finally {
        if (isset($connect4)) { mysqli_close($connect4); }
        if (isset($connect)) { sqlsrv_close($connect); }
    }
?>