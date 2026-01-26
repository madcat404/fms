<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <23.06.13>
    // Description: <품질 엑셀 데이터 db 자동 업로드>
    // Last Modified: <25.09.15> - Refactored for PHP 8.x, Security, and Stability
    // Update Note: <26.01.06> - 연도 판단 알고리즘 고도화 (C1 + 데이터 기반 작년 감지)
    // =============================================

    // --- Setup and Includes ---
    set_time_limit(0); // 실행 시간 제한 없음
    
    // 경로에 맞게 include 파일 수정 필요 (사용자 환경 기준 유지)
    require_once __DIR__ . '/../session/session_check.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    include_once __DIR__ . '/../DB/DB2.php'; 

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Shared\Date; 

    // --- Main Execution ---
    echo "일일 품질 보고서 처리를 시작합니다.<br>";

    try {
        // --- 1. 기본 날짜 변수 설정 (시스템 기준) ---
        $today = new DateTime();
        $tomorrow = (new DateTime())->modify('+1 day');

        $YY  = $today->format('Y');    // 기본값: 현재 연도 (예: 2026)
        $MM  = (int)$today->format('n'); // 현재 월 (예: 1)
        $MM2 = $today->format('m');    
        $D   = $today->format('j');    
        $D2  = $today->format('d');    
        
        $Plus1Day_formatted = $tomorrow->format('Y-m-d');

        // --- 2. 다양한 파일명 형식 탐색 ---
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

        // --- 3. DB 연결 및 파일 확인 ---
        if ($connect === false) {
            throw new Exception("데이터베이스 연결에 실패했습니다.");
        }

        if ($filename === null || !is_readable($filename)) {
            $search_hint = htmlspecialchars($base_path_prefix, ENT_QUOTES, 'UTF-8') . "(...날짜...).xlsx";
            throw new Exception("엑셀 파일을 찾을 수 없습니다.<br>탐색 경로 패턴: {$search_hint}");
        }

        // --- 4. 엑셀 파일 로드 및 연도 판단 로직 ---
        $spreadsheet = IOFactory::load($filename);
        $worksheet = $spreadsheet->getSheet(0); 
        
        // [단계 1] C1 셀 기반 1차 연도 감지
        $c1Cell = $worksheet->getCell('C1');
        $c1Value = $c1Cell->getCalculatedValue();
        $detectedYear = null;

        if (Date::isDateTime($c1Cell)) {
            $detectedYear = Date::excelToDateTimeObject($c1Value)->format('Y');
        } else {
            $formattedValue = $c1Cell->getFormattedValue();
            if (preg_match('/(20\d{2})/', (string)$formattedValue, $matches)) {
                $detectedYear = $matches[1];
            } elseif (preg_match('/(\d{4})/', (string)$formattedValue, $matches)) {
                $detectedYear = $matches[1];
            }
        }
        
        if ($detectedYear) {
            if ($detectedYear != $YY) {
                echo "엑셀(C1)에서 연도 감지: <b>{$detectedYear}년</b>으로 1차 설정.<br>";
                $YY = $detectedYear; 
            }
        }

        // [단계 2] 데이터 기반 2차 연도 검증 (요청하신 로직 추가)
        // 조건: 현재가 1월인데, '시트히터 베트남 폐기(O열)'의 10월 데이터(50행)가 존재하면 작년으로 판단
        // (41행이 1월이므로, 10월은 41 + 9 = 50행)
        
        if ($MM == 1 or $MM == 2) { // 현재 시스템 월이 1~2월인 경우에만 체크
            $checkCol = 'O'; // 베트남 폐기 컬럼
            $checkRow = 50;  // 10월 데이터 행 (41 + 10 - 1)
            
            $checkValue = $worksheet->getCell($checkCol . $checkRow)->getCalculatedValue();
            $checkValue = is_numeric($checkValue) ? $checkValue : 0;

            if ($checkValue > 0) {
                $prevYear = (string)((int)$today->format('Y') - 1); // 작년 연도 계산
                echo "<span style='color:blue; font-weight:bold;'>[알고리즘 감지]</span> 현재 1월이나 엑셀에 10월 데이터(값: {$checkValue})가 확인됩니다.<br>";
                echo "-> C1 값({$YY})을 무시하고, <b>작년({$prevYear}년)</b> 데이터로 확정하여 처리합니다.<br>";
                $YY = $prevYear; // 연도를 작년으로 강제 변경
            }
        }

        // --- 5. 확정된 연도($YY)의 기존 QC 데이터 삭제 ---
        echo "기존 QC 데이터 삭제 중 (대상 연도: {$YY})... ";
        
        $deleteSql = "DELETE FROM CONNECT.dbo.QC WHERE YY = ? AND KIND IN ('시트히터', '핸들', '통풍')";
        $deleteStmt = sqlsrv_query($connect, $deleteSql, [$YY]);
        
        if ($deleteStmt === false) {
            throw new Exception("기존 데이터 삭제 실패: " . print_r(sqlsrv_errors(), true));
        }
        echo "완료.<br>";

        // --- 6. 데이터 입력 시작 ---
        $totalInsertCount = 0;
        echo "<hr>데이터 입력을 시작합니다... (적용 연도: <b>{$YY}</b>)<br>";

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

        foreach ($dataBlocks as $kind => $block) {
            echo "<b>- {$kind} 데이터 처리 중...</b><br>";
            $sheetInsertCount = 0;
            
            for ($month = 1; $month <= 13; $month++) {
                $rowNum = $block['startRow'] + $month - 1;
                
                foreach ($block['definitions'] as $col => $kind2) {
                    try {
                        $cellValue = $worksheet->getCell($col . $rowNum)->getCalculatedValue();
                        $money = is_numeric($cellValue) ? $cellValue : 0;

                        $insertSql = "INSERT INTO CONNECT.dbo.QC(KIND, KIND2, YY, MM, M_MONEY, SORTING_DATE) VALUES (?, ?, ?, ?, ?, ?)";
                        $insertParams = [$kind, $kind2, $YY, $month, $money, $Plus1Day_formatted];
                        
                        $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
                        
                        if ($insertStmt === false) {
                            $errors = print_r(sqlsrv_errors(), true);
                            throw new Exception("INSERT 실패 (KIND: {$kind}, KIND2: {$kind2}, 월: {$month}) - DB Error: {$errors}");
                        }
                        $sheetInsertCount++;
                        
                    } catch (Throwable $t) {
                        error_log("오류 발생 (KIND: {$kind}, 월: {$month}, 컬럼: {$col}): " . $t->getMessage());
                    }
                }
            }
            $totalInsertCount += $sheetInsertCount;
            echo "  ({$sheetInsertCount} 건 처리 완료)<br>";
        }

        echo "<hr><h2>최종 처리 완료</h2>";
        echo "총 {$totalInsertCount}개의 레코드가 성공적으로 추가되었습니다. (적용 연도: {$YY})<br>";

    } catch (Throwable $t) {
        echo "<h2 style='color:red;'>스크립트 실행 중 심각한 오류가 발생했습니다</h2>";
        echo "<pre>" . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
    } finally {
        if (isset($connect4) && $connect4) { @mysqli_close($connect4); }
        if (isset($connect) && $connect) { sqlsrv_close($connect); }
    }
?>