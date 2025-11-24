<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <23.06.13>
    // Description: <매출 엑셀 데이터 db 자동 업로드>
    // Last Modified: <25.09.15> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    // --- Setup and Includes ---
    include '../session/ip_session.php';
    include '../DB/DB2.php';
    require_once '../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;

    // --- Main Execution ---
    echo "일일 매출 보고서 처리를 시작합니다.<br>";

    try {
        // --- 1. 날짜 변수 설정 ---
        // 스크립트 내에서 날짜를 직접 생성하여 외부 변수 의존성 제거
        $today = new DateTime();
        $tomorrow = (new DateTime())->modify('+1 day');

        $YY = $today->format('Y');
        $MM = $today->format('n');  // 월 (앞에 0 없음)
        $MM2 = $today->format('m'); // 월 (앞에 0 있음)
        $D = $today->format('j');   // 일 (앞에 0 없음)
        $Plus1Day_formatted = $tomorrow->format('Y-m-d');

        // 절대 경로를 사용하여 안정성 확보
        $filename = "../../../../mnt4/{$YY}년/{$MM}월/일일현황보고({$MM2}월 {$D}일).xlsx";
        echo "대상 파일: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";

        // --- 2. DB 및 파일 확인 ---
        if ($connect === false) {
            throw new Exception("데이터베이스 연결에 실패했습니다.");
        }
        if (!is_readable($filename)) {
            throw new Exception("엑셀 파일을 찾을 수 없거나 읽을 수 없습니다.");
        }

        // --- 3. 기존 데이터 삭제 (하루에 여러번 실행해도 괜찮도록) ---
        echo "기존 데이터 삭제 중 (날짜: {$Plus1Day_formatted})... ";
        $deleteSql = "DELETE FROM CONNECT.dbo.SALES WHERE SORTING_DATE = ?";
        $deleteStmt = sqlsrv_query($connect, $deleteSql, [$Plus1Day_formatted]);
        if ($deleteStmt === false) {
            throw new Exception("기존 데이터 삭제 실패: " . print_r(sqlsrv_errors(), true));
        }
        echo "완료.<br>";

        // --- 4. 엑셀 파일 처리 ---
        $spreadsheet = IOFactory::load($filename);
        $worksheet = $spreadsheet->getSheet(2); // 3번째 시트
        
        $insertCount = 0;
        $processedKinds = [];

        // 기존의 경직된 if/elseif 구조를 배열 기반으로 개선하여 유지보수 용이성 향상
        $rowsToProcess = [
            20 => '히터', 22 => '발열핸들(열선)', 24 => '통풍(이원컴포텍)',
            26 => '통풍', 28 => '통합ECU', 30 => '일반ECU',
            32 => '기타', 33 => '합계'
        ];

        foreach ($rowsToProcess as $rowNum => $expectedKind) {
            try {
                // F, K, P 열에서 계산된 값 읽기
                $dataF = $worksheet->getCell('F' . $rowNum)->getCalculatedValue(); // 년
                $dataK = $worksheet->getCell('K' . $rowNum)->getCalculatedValue(); // 월
                $dataP = $worksheet->getCell('P' . $rowNum)->getCalculatedValue(); // 일

                // 숫자형 데이터 유효성 검사 (값이 숫자가 아니면 0으로 처리)
                $y_money = is_numeric($dataF) ? $dataF : 0;
                $m_money = is_numeric($dataK) ? $dataK : 0;
                $d_money = is_numeric($dataP) ? $dataP : 0;

                // --- DB INSERT (Parameterized) ---
                $insertSql = "INSERT INTO CONNECT.dbo.SALES(KIND, Y_MONEY, M_MONEY, D_MONEY, SORTING_DATE) VALUES (?, ?, ?, ?, ?)";
                $insertParams = [$expectedKind, $y_money, $m_money, $d_money, $Plus1Day_formatted];
                
                $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
                if ($insertStmt === false) {
                    throw new Exception("INSERT 쿼리 실패 (행: {$rowNum}): " . print_r(sqlsrv_errors(), true));
                }
                $insertCount++;
                $processedKinds[] = $expectedKind;

            } catch (Throwable $t) {
                error_log("오류 발생 (행: {$rowNum}): " . $t->getMessage());
                continue; // 오류 발생 행은 건너뛰기
            }
        }

        echo "<hr><h2>처리 완료</h2>";
        echo "총 {$insertCount}개의 레코드가 성공적으로 추가되었습니다.<br>";
        echo "처리된 항목: " . htmlspecialchars(implode(', ', $processedKinds), ENT_QUOTES, 'UTF-8');

    } catch (Throwable $t) {
        echo "스크립트 실행 중 심각한 오류가 발생했습니다: " . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8');
    } finally {
        // MARIA DB, MSSQL 연결 종료
        if (isset($connect4)) { mysqli_close($connect4); }
        if (isset($connect)) { sqlsrv_close($connect); }
    }
?>