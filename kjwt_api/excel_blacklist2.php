<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <2025.06.02>
    // Description: <블랙리스트 해시 업로드(kisa c-tas hash)>
    // Last Modified: <25.09.15> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    // --- Setup and Includes ---
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';   

    // --- Input Validation ---
    $send = $_GET['Hyphenday'] ?? date('Y-m-d');

    // 보안 강화: 경로 탐색(Path Traversal) 방지를 위해 날짜 형식 엄격히 검증
    $date_obj = DateTime::createFromFormat('Y-m-d', $send);
    if (!$date_obj || $date_obj->format('Y-m-d') !== $send) {
        header("HTTP/1.1 400 Bad Request");
        die('오류: Hyphenday는 Y-m-d 형식의 유효한 날짜여야 합니다.');
    }

    // --- Configuration ---
    $endDate = '2026-01-01';
    $filename = '../../../../mnt3/blacklist/' . $send . '.csv'; // 리눅스 환경에 맞는 절대 경로 사용

    // --- Main Execution ---
    if ($send >= $endDate) {
        // DB 연결 확인
        if ($connect === false) {
            die("데이터베이스 연결에 실패했습니다. 스크립트를 중단합니다.");
        }

        try {
            // 파일이 존재하지 않거나 읽을 수 없는 경우
            if (!is_readable($filename)) {
                $nextDay = new DateTime($send);
                $nextDay->modify('-1 day');
                $nextDate = $nextDay->format('Y-m-d');
                
                echo "파일이 없거나 읽을 수 없습니다: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";
                echo "<script>
                        window.location.href='excel_blacklist2.php?Hyphenday={$nextDate}';
                    </script>";
                exit;
            }
            
            if (($handle = fopen($filename, "r")) !== FALSE) {
                fgetcsv($handle); // 헤더 건너뛰기

                $insertCount = 0;
                $updateCount = 0;
                
                // --- Transaction and Loop Start ---
                if (sqlsrv_begin_transaction($connect) === false) {
                    die("데이터베이스 트랜잭션을 시작할 수 없습니다.");
                }

                while (($data = fgetcsv($handle)) !== FALSE) {
                    try {
                        // CSV 데이터 파싱
                        $dataA = date('Y-m-d', strtotime($data[0])); // 날짜
                        $dataE = trim($data[4] ?? '');               // IP
                        $dataF = trim($data[5] ?? '');               // 국가
                        
                        if (empty($dataE)) {
                            continue; // IP가 없으면 건너뛰기
                        }
                        
                        $anlab = $dataE . ';';

                        // 중복 데이터 확인
                        $check_query = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.BLACKLIST WHERE IP = ?";
                        $check_params = [$dataE];
                        $check_result = sqlsrv_query($connect, $check_query, $check_params);
                        if ($check_result === false) {
                            throw new Exception("중복 확인 쿼리 실패");
                        }

                        $row = sqlsrv_fetch_array($check_result, SQLSRV_FETCH_ASSOC);
                        
                        if ($row['cnt'] > 0) {
                            // IP가 존재하면 국가 정보 업데이트
                            $update_query = "UPDATE CONNECT.dbo.BLACKLIST SET COUNTRY = ?, NOTE='C-TAS 정보공유시스템(kisa)' WHERE IP = ?";
                            $update_params = [$dataF, $dataE];
                            $update_result = sqlsrv_query($connect, $update_query, $update_params);
                            if ($update_result === false) {
                                throw new Exception("UPDATE 쿼리 실패");
                            }
                            $updateCount++;
                        } else {
                            // 신규 데이터 입력
                            $insert_query = "INSERT INTO CONNECT.dbo.BLACKLIST(IP, anlab, COUNTRY, NOTE, dt) VALUES (?, ?, ?, 'C-TAS 정보공유시스템(kisa)', ?)";
                            $insert_params = [$dataE, $anlab, $dataF, $dataA];
                            $insert_result = sqlsrv_query($connect, $insert_query, $insert_params);
                            if ($insert_result === false) {
                                throw new Exception("INSERT 쿼리 실패: " . print_r(sqlsrv_errors(), true));
                            }
                            $insertCount++;
                        }
                    } catch (Throwable $t) {
                        error_log("행 처리 중 오류 발생 (IP: {$dataE}): " . $t->getMessage());
                        continue; // 오류 발생 시 해당 행만 건너뛰기
                    }
                }
                
                fclose($handle);
                
                // --- Transaction End ---
                if ($insertCount > 0 || $updateCount > 0) {
                    sqlsrv_commit($connect);
                    echo "총 {$insertCount}개의 레코드가 추가되었고, {$updateCount}개의 레코드가 업데이트되었습니다.<br>";
                } else {
                    sqlsrv_rollback($connect); // 변경 사항이 없으면 롤백
                    echo "처리된 레코드가 없습니다.<br>";
                }

                // --- Redirect to next day ---
                $nextDay = new DateTime($send);
                $nextDay->modify('-1 day');
                $nextDate = $nextDay->format('Y-m-d');            

                echo "<script>
                        setTimeout(function() {
                            window.location.href='excel_blacklist2.php?Hyphenday=$nextDate';
                        }, 1000); // 1초 후 이동
                    </script>";
            }
        } catch (Throwable $t) {
            // Critical error (file level, DB connection, etc.)
            if (isset($connect) && sqlsrv_in_transaction($connect)) {
                sqlsrv_rollback($connect);
            }
            echo "스크립트 실행 중 심각한 오류가 발생했습니다: " . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8');
        } finally {
            if (isset($connect)) {
                sqlsrv_close($connect);
            }
        }
    } else {
        echo "모든 날짜의 확인이 완료되었습니다.";
    }
?>