<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <23.06.08>
    // Description: <수출 엑셀 데이터 db 자동 업로드>
    // Last Modified: <25.09.15> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    // --- Setup and Includes ---
    require_once __DIR__ . '/../session/session_check.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    include_once __DIR__ . '/../DB/DB2.php'; 

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Shared\Date;

    // --- Configuration ---
    $filename = '../../../../mnt3/Shipping Schedule.xlsx';

    // --- Main Execution ---
    echo "수출 데이터 처리를 시작합니다: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";

    // DB 연결 확인
    if ($connect === false) {
        die("데이터베이스 연결에 실패했습니다.");
    }

    // 파일 존재 및 읽기 권한 확인
    if (!is_readable($filename)) {
        die("엑셀 파일을 찾을 수 없거나 읽을 수 없습니다. 경로: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8'));
    }

    $totalInsertCount = 0;

    try {
        // 2. 엑셀 파일 로드
        $spreadsheet = IOFactory::load($filename);

        // 3. 시트 반복 처리 (기존 로직대로 1~8번 시트)
        $sheetCount = $spreadsheet->getSheetCount();
        $maxSheetIndex = min(8, $sheetCount - 1); // 0-based index

        for ($j = 1; $j <= $maxSheetIndex; $j++) {
            $worksheet = $spreadsheet->getSheet($j);
            $sheetTitle = $worksheet->getTitle();
            echo "<hr><b>'{$sheetTitle}'</b> 시트 처리 시작...<br>";

            // --- 국가 정보 파싱 ---
            $titleCell = $worksheet->getCell('A1')->getValue();
            $s_country = '';
            $e_country = '';

            if (strpos($titleCell, "KOREA → VIETNAM") !== false) { $s_country = 'K'; $e_country = 'V'; }
            elseif (strpos($titleCell, "KOREA → CHINA") !== false) { $s_country = 'K'; $e_country = 'C'; }
            elseif (strpos($titleCell, "KOREA → USA") !== false) { $s_country = 'K'; $e_country = 'U'; }
            elseif (strpos($titleCell, "KOREA → SLOVAKIA") !== false) { $s_country = 'K'; $e_country = 'S'; }
            elseif (strpos($titleCell, "VIETNAM → CHINA") !== false) { $s_country = 'V'; $e_country = 'C'; }
            elseif (strpos($titleCell, "VIETNAM → USA") !== false) { $s_country = 'V'; $e_country = 'U'; }
            elseif (strpos($titleCell, "VIETNAM → SLOVAKIA") !== false) { $s_country = 'V'; $e_country = 'S'; }
            
            if (empty($s_country) || empty($e_country)) {
                echo "'{$sheetTitle}' 시트 A1셀에서 국가 정보를 찾을 수 없어 건너뜁니다.<br>";
                continue;
            }
            echo "국가: {$s_country} → {$e_country}<br>";

            // --- 행 반복 처리 ---
            $highestRow = $worksheet->getHighestRow();
            $sheetInsertCount = 0;
            $status_condition = '운송중'; // 상태 초기값 설정

            // 기존 로직대로 4행부터 시작
            for ($i = 4; $i <= $highestRow; $i++) {
                try {
                    $dataA_raw = $worksheet->getCell('A' . $i)->getValue();
                    
                    // A열이 비어있으면 해당 시트 처리 중단
                    if (empty($dataA_raw)) {
                        break;
                    }

                    // A열에 '운송 완료 LIST'가 있으면 상태를 '운송완료'로 변경하고 다음 행으로
                    if (trim($dataA_raw) === '운송 완료 LIST') {
                        $status_condition = '운송완료';
                        continue; // 해당 행은 데이터가 아니므로 건너뜁니다.
                    }

                    // --- 데이터 추출 및 변환 ---
                    $dataA = Date::excelToDateTimeObject($dataA_raw)->format('Y-m-d'); // update_dt
                    $dataC = $worksheet->getCell('C' . $i)->getValue(); // bl
                    $dataD = $worksheet->getCell('D' . $i)->getValue(); // invoice
                    $dataE = $worksheet->getCell('E' . $i)->getValue(); // kind
                    
                    if (empty($dataE)) {
                        continue;
                    }

                    $dataF_raw = $worksheet->getCell('F' . $i)->getValue(); // invoice_dt
                    $dataF = !empty($dataF_raw) ? Date::excelToDateTimeObject($dataF_raw)->format('Y-m-d') : null;

                    $dataG_raw = $worksheet->getCell('G' . $i)->getValue(); // etd
                    $dataG = !empty($dataG_raw) ? Date::excelToDateTimeObject($dataG_raw)->format('Y-m-d') : null;

                    $dataH_raw = $worksheet->getCell('H' . $i)->getValue(); // eta
                    $dataH = !empty($dataH_raw) ? Date::excelToDateTimeObject($dataH_raw)->format('Y-m-d') : null;

                    $dataJ = $worksheet->getCell('J' . $i)->getCalculatedValue(); // delay
                    $dataN = trim($worksheet->getCell('N' . $i)->getValue() ?? ''); // vessel

                    // --- DB INSERT (Parameterized) ---
                    $insertSql = "INSERT INTO CONNECT.dbo.DISTRIBUTION(s_country, e_country, update_dt, bl, invoice, kind, invoice_dt, etd, eta, delay, vessel, condition) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $insertParams = [$s_country, $e_country, $dataA, $dataC, $dataD, $dataE, $dataF, $dataG, $dataH, $dataJ, $dataN, $status_condition];
                    
                    $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
                    if ($insertStmt === false) {
                        throw new Exception("INSERT 쿼리 실패: " . print_r(sqlsrv_errors(), true));
                    }
                    $sheetInsertCount++;

                } catch (Throwable $t) {
                    error_log("오류 발생 (시트: {$sheetTitle}, 행: {$i}): " . $t->getMessage());
                    continue; // 오류 발생 행은 건너뛰기
                }
            }
            echo "'{$sheetTitle}' 시트 처리 완료. ({$sheetInsertCount} 건 추가)<br>";
            $totalInsertCount += $sheetInsertCount;
        }

        echo "<hr><h2>최종 처리 완료</h2>";
        echo "총 {$totalInsertCount}개의 레코드가 성공적으로 추가되었습니다.<br>";

    } catch (Throwable $t) {
        echo "스크립트 실행 중 심각한 오류가 발생했습니다: " . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8');
    } finally {
        if (isset($connect)) {
            sqlsrv_close($connect);
        }
    }
?>