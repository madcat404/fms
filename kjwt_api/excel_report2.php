<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <23.06.13>
    // Description: <품질 엑셀 데이터 db 자동 업로드>
    // Last Modified: <25.09.15> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    // --- Setup and Includes ---
    set_time_limit(0);
    include '../session/ip_session.php';
    include '../DB/DB2.php';
    require_once '../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;

    // --- Main Execution ---
    echo "일일 품질 보고서 처리를 시작합니다.<br>";

    try {
        // --- 1. 날짜 변수 설정 ---
        $today = new DateTime();
        $tomorrow = (new DateTime())->modify('+1 day');

        $YY = $today->format('Y');
        $MM = (int)$today->format('n');
        $MM2 = $today->format('m');
        $D = $today->format('j');
        $Plus1Day_formatted = $tomorrow->format('Y-m-d');

        $filename = "../../../../mnt4/{$YY}년/{$MM}월/일일현황보고({$MM2}월 {$D}일).xlsx";
        echo "대상 파일: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";

        // --- 2. DB 및 파일 확인 ---
        if ($connect === false) {
            throw new Exception("데이터베이스 연결에 실패했습니다.");
        }
        if (!is_readable($filename)) {
            throw new Exception("엑셀 파일을 찾을 수 없거나 읽을 수 없습니다.");
        }

        // --- 3. 올해의 기존 QC 데이터 삭제 ---
        echo "기존 QC 데이터 삭제 중 (연도: {$YY})... ";
        $deleteSql = "DELETE FROM CONNECT.dbo.QC WHERE YY = ? AND KIND IN ('시트히터', '핸들', '통풍')";
        $deleteStmt = sqlsrv_query($connect, $deleteSql, [$YY]);
        if ($deleteStmt === false) {
            throw new Exception("기존 데이터 삭제 실패: " . print_r(sqlsrv_errors(), true));
        }
        echo "완료.<br>";

        // --- 4. 엑셀 파일 처리 ---
        $spreadsheet = IOFactory::load($filename);
        $worksheet = $spreadsheet->getSheet(0);
        
        $totalInsertCount = 0;
        echo "<hr>데이터 입력을 시작합니다...<br>";

        // --- 데이터 블록 정의 ---
        $dataBlocks = [
            '시트히터' => [
                'startRow' => 41,
                'definitions' => [
                    'J' => '한국폐기 본사 스티칭', 'K' => '한국폐기 본사 최종검사', 'L' => '한국폐기 협력사귀책',
                    'M' => '한국리워크 본사', 'N' => '한국리워크 BB베트남', 'O' => '베트남 폐기', 'P' => '베트남 리워크',
                    'Q' => '중국 폐기', 'R' => '미국 폐기', 'S' => '슬로박 폐기'
                ]
            ],
            '핸들' => [
                'startRow' => 41,
                'definitions' => [
                    'AC' => '한국폐기 본사', 'AD' => '한국폐기 협력사귀책', 'AE' => '한국폐기 BB베트남',
                    'AF' => '한국리워크 본사', 'AG' => '한국리워크 BB베트남', 'AH' => '베트남 폐기'
                ]
            ],
            '통풍' => [
                'startRow' => 60,
                'definitions' => [
                    'M' => '한국폐기 본사', 'N' => '한국폐기 협력사귀책'
                ]
            ]
        ];

        // --- 데이터 처리 루프 ---
        foreach ($dataBlocks as $kind => $block) {
            echo "<b>- {$kind} 데이터 처리 중...</b><br>";
            $sheetInsertCount = 0;
            // 1월부터 현재 월까지만 반복
            for ($month = 1; $month <= $MM; $month++) {
                $rowNum = $block['startRow'] + $month - 1;
                foreach ($block['definitions'] as $col => $kind2) {
                    try {
                        $cellValue = $worksheet->getCell($col . $rowNum)->getCalculatedValue();
                        $money = is_numeric($cellValue) ? $cellValue : 0;

                        $insertSql = "INSERT INTO CONNECT.dbo.QC(KIND, KIND2, YY, MM, M_MONEY, SORTING_DATE) VALUES (?, ?, ?, ?, ?, ?)";
                        $insertParams = [$kind, $kind2, $YY, $month, $money, $Plus1Day_formatted];
                        
                        $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
                        if ($insertStmt === false) {
                            throw new Exception("INSERT 실패 (KIND: {$kind}, KIND2: {$kind2}, 월: {$month})");
                        }
                        $sheetInsertCount++;
                    } catch (Throwable $t) {
                        error_log("오류 (KIND: {$kind}, 월: {$month}, 컬럼: {$col}): " . $t->getMessage());
                        continue; // 오류 발생 행은 건너뛰기
                    }
                }
            }
            $totalInsertCount += $sheetInsertCount;
            echo "  ({$sheetInsertCount} 건 처리 완료)<br>";
        }

        echo "<hr><h2>최종 처리 완료</h2>";
        echo "총 {$totalInsertCount}개의 레코드가 성공적으로 추가되었습니다.<br>";

    } catch (Throwable $t) {
        echo "<h2 style='color:red;'>스크립트 실행 중 심각한 오류가 발생했습니다</h2>";
        echo "<pre>" . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
    } finally {
        if (isset($connect4)) { mysqli_close($connect4); }
        if (isset($connect)) { sqlsrv_close($connect); }
    }
?>