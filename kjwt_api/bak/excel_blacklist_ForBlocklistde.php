<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>    
    // Create date: <25.10.27>
    // Description: <블랙리스트 업로드>    
    // Last Modified: <25.10.27> - blocklist.de용 로직으로 변경 (A열 IP, 중복 제외 INSERT)
    // =============================================
    
    //nas 또는 fms서버 재시작으로 인하여 마운트가 끈어진 경우 재마운트 필요
    //nas 경로가 달라진 경우 filename 재작성 필요 
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';      
    require '../vendor/autoload.php';
    
    use PhpOffice\PhpSpreadsheet\IOFactory;

    $filename = '../../../../mnt3/blocklist_251027.xlsx'; // 읽어들일 엑셀 파일의 경로와 파일명을 지정한다.
 
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
        // --- 오늘 날짜 (dt 컬럼용) ---
        $todayDate = date('Y-m-d');

        // --- 파일 로드 ---
        $spreadsheet = IOFactory::load($filename);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        // --- 헤더 확인 및 시작 행 동적 결정 (A1 셀 기준) ---
        $cellA1Value = $worksheet->getCell('A1')->getValue();
        // A1 셀의 값이 유효한 IP 주소인지 확인
        if (filter_var(trim($cellA1Value), FILTER_VALIDATE_IP)) {
            $startRow = 1; // A1이 IP 주소이면 1행부터 시작
            echo "1행 A열이 IP 주소이므로 1행부터 처리를 시작합니다.<br>";
        } else {
            $startRow = 2; // A1이 IP 주소가 아니면 2행부터 시작 (헤더로 간주)
            echo "1행 A열이 IP 주소가 아니므로 헤더로 간주하고 2행부터 처리를 시작합니다.<br>";
        }

        echo "총 " . ($highestRow - ($startRow - 1)) . "개의 행을 읽습니다.<br>";

        $processedCount = 0; // 유효 IP 기준 처리 시도
        $insertCount = 0;
        $skippedCount = 0; // 중복되어 건너뛴 수

        // --- 행 반복 및 처리 ---
        for ($row = $startRow; $row <= $highestRow; ++$row) {
            try {
                // --- 데이터 추출 (A열 IP) ---
                $ipAddress = trim($worksheet->getCell('A' . $row)->getValue() ?? '');

                // IP가 비어있으면 건너뛰기
                if (empty($ipAddress)) {
                    continue;
                }
                
                // IP 유효성 검사
                if (!filter_var($ipAddress, FILTER_VALIDATE_IP)) {
                    error_log("유효하지 않은 IP (행: {$row}): " . htmlspecialchars($ipAddress));
                    continue; // 유효하지 않은 IP는 건너뛰기
                }

                // (선택 사항) 원본 로직의 내부 IP 건너뛰기
                if (strpos($ipAddress, '192.168') === 0) {
                    continue;
                }

                $processedCount++; // 유효한 IP로 확인되어 처리 시도

                // --- DB 중복 확인 ---
                $checkSql = "SELECT 1 FROM CONNECT.dbo.BLACKLIST WHERE ip = ?";
                $checkStmt = sqlsrv_query($connect, $checkSql, [$ipAddress]);
                if ($checkStmt === false) {
                    throw new Exception("IP 확인 쿼리 실패");
                }
                
                $existingRecord = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);

                if ($existingRecord) {
                    // IP가 이미 존재함 -> 건너뛰기
                    $skippedCount++;
                } else {
                    // IP가 없음 -> 신규 삽입
                    $anlab = $ipAddress . ';';
                    
                    // (참고) INSERT하는 컬럼은 실제 BLACKLIST 테이블 스키마에 맞게 조정해야 합니다.
                    // (예: COUNTRY, attack_id 등이 NOT NULL인데 기본값이 없다면 에러 발생 가능)
                    $insertSql = "INSERT INTO CONNECT.dbo.BLACKLIST(ip, anlab, note, dt) 
                                  VALUES (?, ?, 'blocklist.de 제공', ?)";
                    
                    $insertParams = [$ipAddress, $anlab, $todayDate];
                    $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
                    
                    if ($insertStmt === false) {
                        throw new Exception("INSERT 쿼리 실패");
                    }
                    $insertCount++;
                }

            } catch (Throwable $t) {
                // 행 처리 중 오류 발생 시 로그만 남기고 계속 진행
                error_log("오류 발생 (행: {$row}): " . $t->getMessage());
                continue;
            }
        }

        echo "----------------------------------------<br>";
        echo "블랙리스트 처리 완료.<br>";
        echo "총 처리 시도된 행 (유효 IP): {$processedCount}<br>";
        echo "신규 추가: {$insertCount} 건<br>";
        echo "중복 건너뛰기: {$skippedCount} 건<br>";

    } catch (Throwable $t) {
        // 파일 로드 등 스크립트의 주요 오류 처리
        echo "스크립트 실행 중 심각한 오류가 발생했습니다: " . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8');
    } finally {
        // DB 연결 종료
        if (isset($connect)) {
            sqlsrv_close($connect);
        }
    }
?>