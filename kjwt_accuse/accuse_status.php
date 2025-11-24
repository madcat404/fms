<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.05.24>
	// Description:	<내부고발>		
    // Last Modified: <25.09.11> - Refactored for PHP 8.x, Security, and Stability
	// =============================================
    
    //★DB연결 및 함수사용    
    //외부사람들도 고발을 할 수 있어야 하므로 세션 제약을 가하면 안됨
    include_once '../DB/DB2.php';
    include_once '../FUNCTION.php';


    //★탭활성화
    $tab_sequence=2; 
    include_once '../TAB.php';  


    if (isset($_POST['bt21']) && $_POST['bt21'] == "on") {
        // ★ CSRF 토큰 검증
        if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            // 토큰이 없거나 일치하지 않으면 공격으로 간주하고 처리 중단
            if(isset($_SESSION['csrf_token'])) unset($_SESSION['csrf_token']);
            die('오류: 유효하지 않은 요청입니다. 페이지를 새로고침한 후 다시 시도해주세요.');
        }

        // 정상 처리 후 토큰 제거 (재사용 방지)
        unset($_SESSION['csrf_token']);
        
        //★변수모음 
        //탭2
        $user21 = htmlspecialchars($_POST['user21'], ENT_QUOTES, 'UTF-8');
        $email21 = htmlspecialchars($_POST['email21'], ENT_QUOTES, 'UTF-8');
        $phone21 = htmlspecialchars($_POST['phone21'], ENT_QUOTES, 'UTF-8');
        $note21 = nl2br(htmlspecialchars($_POST['note21'], ENT_QUOTES, 'UTF-8'));
        $qna211 = htmlspecialchars($_POST['qna211'], ENT_QUOTES, 'UTF-8');
        $qna212 = htmlspecialchars($_POST['qna212'], ENT_QUOTES, 'UTF-8');
        $radio21 = $_POST['radio21'];
        $bt21 = $_POST['bt21'];

        
        //★버튼 클릭 시 실행  
        IF($bt21=="on") {
            $tab_sequence=2; 
            include_once '../TAB.php'; 

            try {
                $Query_Accuse = "INSERT INTO CONNECT.dbo.ACCUSE(NAME, EMAIL, PHONE, CONTENTS, QNA1, QNA2) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_Accuse = sqlsrv_prepare($connect, $Query_Accuse, [$user21, $email21, $phone21, $note21, $qna211, $qna212], $options);

                if (sqlsrv_execute($stmt_Accuse)) {
                    // --- 통합 메일러 호출 ---
                    $postData = [
                        'user21' => $_POST['user21'] ?? '',
                        'email21' => $_POST['email21'] ?? '',
                        'phone21' => $_POST['phone21'] ?? '',
                        'note21' => $_POST['note21'] ?? '',
                        'qna211' => $_POST['qna211'] ?? '',
                        'qna212' => $_POST['qna212'] ?? '',
                    ];

                    $mailerUrl = sprintf(
                        "%s://%s/mailer.php?type=accuse_report",
                        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http',
                        $_SERVER['HTTP_HOST'] ?? 'localhost'
                    );

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $mailerUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $response = curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $curl_error = curl_error($ch);
                    curl_close($ch);

                    // --- START TEMPORARY DEBUGGING ---
                    echo "<pre style='background-color: #f0f0f0; padding: 15px; border: 1px solid #ccc; font-family: monospace;'>";
                    echo "<h2>Mailer Debug Information</h2>";
                    echo "--------------------------------------------------<br>";
                    echo "<strong>Mailer URL:</strong> " . htmlspecialchars($mailerUrl) . "<br>";
                    echo "<strong>HTTP Status Code:</strong> " . $http_code . "<br>";
                    echo "<strong>cURL Error:</strong> " . htmlspecialchars($curl_error) . "<br><br>";
                    echo "<strong>Mailer Raw Response:</strong><br>";
                    echo "--------------------------------------------------<br>";
                    echo htmlspecialchars($response);
                    echo "</pre>";
                    exit; // Stop execution to show debug info
                    // --- END TEMPORARY DEBUGGING ---

                    // cURL 요청 자체에 에러가 있거나, HTTP 상태 코드가 200이 아니거나, 응답이 없는 경우
                    if ($curl_error || $http_code !== 200 || !$response) {
                        error_log("Mailer cURL Error: {$curl_error}, HTTP Code: {$http_code}, Response: {$response}");
                    } else {
                        $mail_result = json_decode($response, true);
                        if (!isset($mail_result['success']) || $mail_result['success'] !== true) {
                            error_log("Mail sending failed via mailer.php: " . ($mail_result['message'] ?? 'Unknown error'));
                        }
                        // 메일 발송 성공 여부와 관계없이 DB 저장이 완료되었으므로 사용자에게는 성공으로 알림
                    }

                    echo "<script>alert(\"제보되었습니다!\");location.href='accuse.php';</script>";

                } else {
                    $errors = sqlsrv_errors();
                    error_log("Failed to execute SQL statement: " . print_r($errors, true));
                    throw new Exception('데이터베이스 저장에 실패했습니다.');
                }
            } catch (Exception $e) {
                echo "<script>alert(\"에러가 발생했습니다. 관리자에게 문의하세요.\");</script>";
                error_log($e->getMessage());
            }
        } 
    }