<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <25.12.01>
    // Description: <2025년 엑셀 파일 월별 분할 처리 (Timeout 방지)>
    // =============================================

    include '../session/ip_session.php';
    include '../DB/DB2.php';
    require_once '../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;

    // --- 실행 시간 설정 ---
    set_time_limit(0); // PHP 내부 실행 시간 제한 해제
    ini_set('memory_limit', '1024M'); // 메모리 부족 방지
    
    // 출력 버퍼를 비워 브라우저에 즉시 진행상황 표시
    if (ob_get_level()) ob_end_clean();
    ob_implicit_flush(true);

    // --- Helper: 셀 데이터 숫자 변환 ---
    function getNumValue($worksheet, $cellAddress) {
        $val = $worksheet->getCell($cellAddress)->getCalculatedValue();
        return is_numeric($val) ? $val : 0;
    }

    // --- 파라미터 받기 (현재 처리할 월) ---
    // URL에 ?month=1 처럼 넘어옴. 없으면 1월부터 시작
    $targetMonth = isset($_GET['month']) ? (int)$_GET['month'] : 1;
    $targetYear = 2025;

    // 13월이 되면 종료
    if ($targetMonth > 12) {
        echo "<h1>모든 작업이 완료되었습니다. (1월 ~ 12월)</h1>";
        exit;
    }

    echo "<h1>{$targetYear}년 {$targetMonth}월 데이터 처리 중...</h1>";
    echo "<div style='border:1px solid #ccc; padding:10px; height:300px; overflow-y:scroll;'>";

    $rootPath = "../../../../mnt4"; 
    $totalSuccess = 0;
    $totalSkip = 0;
    $totalError = 0;
    $processedMonth = false; // 해당 월 폴더가 실제로 존재했는지 확인

    try {
        if ($connect === false) throw new Exception("데이터베이스 연결 실패");

        // 1. 2025년 폴더 탐색
        foreach (glob($rootPath . "/{$targetYear}년") as $yearPath) {
            
            // 2. 월 폴더 탐색
            // 1월, 01월 등 표기가 다를 수 있으므로 전체를 읽어서 숫자로 비교
            foreach (glob($yearPath . '/*월') as $monthPath) {
                
                $monthDirName = basename($monthPath);
                $monthVal = intval(preg_replace('/[^0-9]/', '', $monthDirName)); 

                // [중요] 현재 타겟 월이 아니면 건너뜀
                if ($monthVal !== $targetMonth) {
                    continue;
                }

                $processedMonth = true;

                // 3. 해당 월의 엑셀 파일 탐색
                foreach (glob($monthPath . '/일일현황보고*.xlsx') as $filePath) {
                    
                    $fileName = basename($filePath);

                    // 날짜 파싱 (예: 06월 02일, 6월 2일)
                    if (preg_match('/일일현황보고\s*\(\s*(\d{1,2})월\s*(\d{1,2})일\s*\)/u', $fileName, $matches)) {
                        
                        $mVal = $matches[1];
                        $dVal = $matches[2];
                        $sortingDate = sprintf('%04d-%02d-%02d', $targetYear, $mVal, $dVal);
                        
                        echo "Processing: $fileName ... ";

                        try {
                            // 중복 검사
                            $checkSql = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.ATTEND WHERE SORTING_DATE = ?";
                            $checkStmt = sqlsrv_query($connect, $checkSql, [$sortingDate]);
                            $row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);

                            if ($row['cnt'] > 0) {
                                echo "<span style='color:orange;'>[SKIP]</span><br>";
                                $totalSkip++;
                                continue; 
                            }

                            // 엑셀 로드
                            $spreadsheet = IOFactory::load($filePath);
                            $worksheet = $spreadsheet->getSheet(2);

                            // 데이터 매핑 (기존 로직 동일)
                            // [A] 관리직
                            $SAMU_TOTAL = getNumValue($worksheet, 'B3'); $SAMU_FOREIGN = getNumValue($worksheet, 'E4'); $SAMU_ANNUAL = getNumValue($worksheet, 'G4'); $SAMU_OFFICIAL = getNumValue($worksheet, 'I4'); $SAMU_EDUCATION = getNumValue($worksheet, 'K4'); $SAMU_BISINESS = getNumValue($worksheet, 'M4'); $SAMU_ABSENCE = getNumValue($worksheet, 'O4');
                            // [B] 생산직
                            $FIELD_TOTAL = getNumValue($worksheet, 'B7'); $FIELD_SICK = getNumValue($worksheet, 'E8'); $FIELD_ANNUAL = getNumValue($worksheet, 'G8'); $FIELD_OFFICIAL = getNumValue($worksheet, 'I8'); $FIELD_EDUCATION = getNumValue($worksheet, 'K8'); $FIELD_BISINESS = getNumValue($worksheet, 'M8'); $FIELD_NIGHT = getNumValue($worksheet, 'O8');
                            // [C] 파견직
                            $NONFIELD_TOTAL = getNumValue($worksheet, 'B11'); $NONFIELD_DISPATCH = getNumValue($worksheet, 'E12'); $NONFIELD_ANNUAL = getNumValue($worksheet, 'G12'); $NONFIELD_OFFICIAL = getNumValue($worksheet, 'I12'); $NONFIELD_EDUCATION = getNumValue($worksheet, 'K12'); $NONFIELD_BISINESS = getNumValue($worksheet, 'M12'); $NONFIELD_SICK = getNumValue($worksheet, 'O12');

                            // INSERT
                            $sql = "INSERT INTO CONNECT.dbo.ATTEND (
                                SAMU_TOTAL, SAMU_FOREIGN, SAMU_ANNUAL, SAMU_OFFICIAL, SAMU_EDUCATION, SAMU_BISINESS, SAMU_ABSENCE,
                                FIRSTIN_FIELD_TOTAL, FIRSTIN_FIELD_SICK, FIRSTIN_FIELD_ANNUAL, FIRSTIN_FIELD_OFFICIAL, FIRSTIN_FIELD_EDUCATION, FIRSTIN_FIELD_BISINESS, FIRSTIN_FIELD_NIGHT,
                                FIRSTIN_NONFIELD_TOTAL, FIRSTIN_NONFIELD_DISPATCH, FIRSTIN_NONFIELD_ANNUAL, FIRSTIN_NONFIELD_OFFICIAL, FIRSTIN_NONFIELD_EDUCATION, FIRSTIN_NONFIELD_BISINESS, FIRSTIN_NONFIELD_SICK,
                                SORTING_DATE
                            ) VALUES (?,?,?,?,?,?,?, ?,?,?,?,?,?,?, ?,?,?,?,?,?,?, ?)";

                            $params = [
                                $SAMU_TOTAL, $SAMU_FOREIGN, $SAMU_ANNUAL, $SAMU_OFFICIAL, $SAMU_EDUCATION, $SAMU_BISINESS, $SAMU_ABSENCE,
                                $FIELD_TOTAL, $FIELD_SICK, $FIELD_ANNUAL, $FIELD_OFFICIAL, $FIELD_EDUCATION, $FIELD_BISINESS, $FIELD_NIGHT,
                                $NONFIELD_TOTAL, $NONFIELD_DISPATCH, $NONFIELD_ANNUAL, $NONFIELD_OFFICIAL, $NONFIELD_EDUCATION, $NONFIELD_BISINESS, $NONFIELD_SICK,
                                $sortingDate
                            ];

                            if(!sqlsrv_query($connect, $sql, $params)) throw new Exception("Query Failed");

                            echo "<span style='color:green;'>[OK]</span><br>";
                            $totalSuccess++;

                            // 메모리 정리
                            $spreadsheet->disconnectWorksheets();
                            unset($spreadsheet);

                            // 브라우저로 즉시 전송하여 멈춤 현상 방지
                            flush(); 

                        } catch (Throwable $e) {
                            echo "<span style='color:red;'>[ERR] " . $e->getMessage() . "</span><br>";
                            $totalError++;
                        }
                    }
                } 
            }
        }

        echo "</div>";
        echo "<hr>";
        echo "<b>{$targetMonth}월 결과:</b> 성공 {$totalSuccess}건 / 스킵 {$totalSkip}건 / 실패 {$totalError}건<br>";

        // --- 다음 달 자동 이동 로직 ---
        $nextMonth = $targetMonth + 1;
        
        if ($processedMonth) {
            echo "<p style='color:blue; font-weight:bold;'>잠시 후 {$nextMonth}월 처리로 이동합니다...</p>";
        } else {
            echo "<p style='color:gray;'>{$targetMonth}월 폴더가 없습니다. 다음 달로 넘어갑니다...</p>";
        }

        // 자바스크립트로 1초 뒤 다음 달 페이지 호출
        echo "
        <script>
            setTimeout(function() {
                location.href = '?month={$nextMonth}';
            }, 1000); // 1초 대기
        </script>
        ";

    } catch (Throwable $t) {
        echo "치명적 오류: " . $t->getMessage();
    } finally {
        if (isset($connect)) sqlsrv_close($connect);
    }
?>