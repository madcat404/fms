<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <2025.06.02>
	// Description:	<블랙리스트 해시 업로드(kisa c-tas hash)>	
    // Last Modified: <25.09.12> - Refactored for PHP 8.x, Security, and Stability
	// =============================================
    $send = $_GET['Hyphenday'] ?? date('Y-m-d');   
    
    // 보안 강화: 경로 탐색(Path Traversal) 방지를 위해 날짜 형식 엄격히 검증
    $date_obj = DateTime::createFromFormat('Y-m-d', $send);
    if (!$date_obj || $date_obj->format('Y-m-d') !== $send) {
        header("HTTP/1.1 400 Bad Request");
        die('오류: Hyphenday는 Y-m-d 형식의 유효한 날짜여야 합니다.');
    } 
    
    // 종료 날짜 설정
    $endDate = '2026-01-01';

    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';        

    if ($send >= $endDate) {
        $filename = '../../../../mnt3/blacklistHASH/'.$send.'.csv'; // 읽어들일 엑셀 파일의 경로와 파일명을 지정한다.

        try {	
            // 파일이 존재하지 않는 경우
            if (!file_exists($filename)) {
                // 다음 날짜로 이동
                $nextDay = new DateTime($send);
                $nextDay->modify('-1 day');
                $nextDate = $nextDay->format('Y-m-d');
                
                echo "파일이 없습니다: {$send}.csv<br>";
                echo "<script>
                        window.location.href='excel_blacklist_hash.php?Hyphenday={$nextDate}';
                    </script>";
                exit;
            }
            
            // CSV 파일 열기
            if (($handle = fopen($filename, "r")) !== FALSE) {
                // 첫 번째 줄은 헤더로 건너뛰기
                fgetcsv($handle);
                
                $insertCount = 0; // 처리된 레코드 수를 추적
                
                // 트랜잭션 시작
                sqlsrv_begin_transaction($connect);
                
                while (($data = fgetcsv($handle)) !== FALSE) {
                    try {
                        // CSV 데이터 파싱
                        $dataA = date('Y-m-d', strtotime($data[0])); 
                        $dataO = $data[14]; 
                        
                        // 해시값 유효성 검사
                        if (empty($dataO) || strlen($dataO) != 32 || !ctype_xdigit($dataO)) {
                            error_log("Invalid MD5 hash format skipped: " . $dataO);
                            continue;
                        }

                        // 중복 데이터 확인
                        $check_query = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.BLACKLIST_HASH WHERE HASH = ?";
                        $check_params = array($dataO);
                        $check_result = sqlsrv_query($connect, $check_query, $check_params);

                        if ($check_result) {
                            $row = sqlsrv_fetch_array($check_result, SQLSRV_FETCH_ASSOC);
                            if ($row['cnt'] > 0) {
                                continue;
                            }
                        }

                        // 신규 데이터 입력
                        $Query_blacklist = "INSERT INTO CONNECT.dbo.BLACKLIST_HASH(HASH_KIND, HASH, REGISTER_DATE) VALUES ('md5', ?, ?)";
                        $params = array($dataO, $dataA);
                        $result = sqlsrv_query($connect, $Query_blacklist, $params, $options);
                        
                        if ($result === false) {
                            throw new Exception("데이터 삽입 실패: " . print_r(sqlsrv_errors(), true));
                        }
                        
                        $insertCount++;
                    } catch (Exception $insertError) {
                        error_log("행 처리 중 오류 발생: " . $insertError->getMessage());
                        continue; // 다음 행으로 계속 진행
                    }
                }
                
                // 파일 처리 완료 후 파일 닫기
                fclose($handle);
                
                // 트랜잭션 커밋 부분 수정
                if ($insertCount > 0) {
                    sqlsrv_commit($connect);
                    echo "총 {$insertCount}개의 레코드가 처리되었습니다.<br>";
                } else {
                    sqlsrv_rollback($connect);
                    echo "처리된 레코드가 없습니다.<br>";
                }

                // 다음 날짜로 이동 (insertCount와 관계없이 항상 실행)
                $Hyphenday = new DateTime($send);
                $Hyphenday->modify('-1 day');
                $Hyphenday2 = $Hyphenday->format('Y-m-d');            

                echo "<script>
                        setTimeout(function() {
                            window.location.href='excel_blacklist_hash.php?Hyphenday=$Hyphenday2';
                        }, 3000); // 3초 후 다음 페이지로 이동
                    </script>";
            }
        } catch (Exception $e) {	
            if (isset($handle)) {
                fclose($handle);
            }
            // 트랜잭션 롤백
            if (sqlsrv_begin_transaction($connect)) {
                sqlsrv_rollback($connect);
            }
            echo '오류가 발생했습니다: ' . $e->getMessage() . '<br>';	
        }
    }