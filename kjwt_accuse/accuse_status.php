<?php    
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>    
    // Create date: <24.05.24>
    // Description: <내부고발 저장 및 메일 발송 (익명 보안 적용)>      
    // Last Modified: <25.09.11> - Refactored for PHP 8.x, Security, and Stability
    // =============================================
    
    // 1. 세션 시작
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1);
    session_set_cookie_params(0, '/');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // 2. DB 연결 및 공통 함수
    include_once __DIR__ . '/../DB/DB2.php';
    include_once __DIR__ . '/../FUNCTION.php';

    // 3. 탭 설정 
    $tab_sequence = 2; 
    include_once __DIR__ . '/../TAB.php'; 


    // ======================================================================
    // [로직 시작] - 버튼이 눌렸을 때만(bt21=on) 실행
    // ======================================================================
    if (isset($_POST['bt21']) && $_POST['bt21'] == "on") {

        // ------------------------------------------------------------------
        // [보안 단계 1] CSRF 토큰 검증
        // ------------------------------------------------------------------
        if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            if(isset($_SESSION['csrf_token'])) unset($_SESSION['csrf_token']);
            die("<script>alert('보안 토큰이 만료되었습니다.\\n페이지를 새로고침한 후 다시 시도해주세요.'); history.back();</script>");
        }

        // ------------------------------------------------------------------
        // [보안 단계 2] 캡차(자동입력 방지) 검증
        // ------------------------------------------------------------------
        if (!isset($_POST['captcha']) || !isset($_SESSION['captcha_answer']) || (int)$_POST['captcha'] !== (int)$_SESSION['captcha_answer']) {
            die("<script>alert('자동입력 방지(보안 문자) 정답이 틀렸습니다.\\n페이지를 새로고침 후 다시 시도해주세요.'); history.back();</script>");
        }

        // ==================================================================
        // ★ [추가 보안 1] 도배 방지 (세션 기반)
        // ==================================================================
        if (isset($_SESSION['last_accuse_time']) && (time() - $_SESSION['last_accuse_time'] < 60)) {
            die("<script>alert('도배 방지를 위해 제보 후 1분간은 다시 작성할 수 없습니다.\\n잠시 후 다시 시도해주세요.'); history.back();</script>");
        }

        // ------------------------------------------------------------------
        // [데이터 처리] 변수 수신 및 정제
        // ------------------------------------------------------------------
        // ★ [추가 보안 2] HTML 태그 제거 (strip_tags)
        $user21  = isset($_POST['user21']) ? strip_tags(trim($_POST['user21'])) : '익명';
        $email21 = isset($_POST['email21']) ? strip_tags(trim($_POST['email21'])) : '';
        $phone21 = isset($_POST['phone21']) ? strip_tags(trim($_POST['phone21'])) : '';
        $note21  = isset($_POST['note21']) ? trim($_POST['note21']) : ''; 
        $qna211  = isset($_POST['qna211']) ? strip_tags(trim($_POST['qna211'])) : '';
        $qna212  = isset($_POST['qna212']) ? strip_tags(trim($_POST['qna212'])) : '';

        // ★ [추가 보안 3] 글자 수 제한
        if (mb_strlen($note21, 'UTF-8') > 5000) {
            die("<script>alert('내용은 최대 5000자까지만 입력 가능합니다.'); history.back();</script>");
        }
        if (mb_strlen($user21, 'UTF-8') > 50) {
             die("<script>alert('이름이 너무 깁니다.'); history.back();</script>");
        }

        // 특수문자 변환
        $note21_safe = nl2br(htmlspecialchars($note21, ENT_QUOTES, 'UTF-8')); 
        
        // ------------------------------------------------------------------
        // [DB 저장] Prepared Statement 사용
        // ------------------------------------------------------------------
        try {
            if (!$connect) {
                throw new Exception("DB 연결에 실패했습니다.");
            }

            // ★ [수정됨] 테이블명 및 컬럼명 수정 (CREATED_DATE -> SORTING_DATE)
            $Query_Accuse = "INSERT INTO CONNECT.dbo.ACCUSE (NAME, EMAIL, PHONE, CONTENTS, QNA1, QNA2, SORTING_DATE) VALUES (?, ?, ?, ?, ?, ?, GETDATE())";
            
            $params = array($user21, $email21, $phone21, $note21_safe, $qna211, $qna212);
            $stmt_Accuse = sqlsrv_prepare($connect, $Query_Accuse, $params);

            if ($stmt_Accuse === false) {
                // 쿼리 준비 실패 시 상세 에러 출력
                throw new Exception(print_r(sqlsrv_errors(), true));
            }

            if (sqlsrv_execute($stmt_Accuse)) {
                
                // === 메일 발송 로직 ===
                $postData = [
                    'user21'  => $user21,
                    'email21' => $email21,
                    'phone21' => $phone21,
                    'note21'  => $note21,
                    'qna211'  => $qna211,
                    'qna212'  => $qna212,
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
                curl_close($ch);
                // === 메일 발송 끝 ===

                // ★ 성공 시 도배 방지 시간 기록
                $_SESSION['last_accuse_time'] = time();

                unset($_SESSION['csrf_token']);
                unset($_SESSION['captcha_answer']);

                echo "<script>alert('성공적으로 제보되었습니다.\\n소중한 의견 감사합니다.'); location.href='accuse.php';</script>";

            } else {
                // 실행 실패 시 상세 에러 출력
                throw new Exception(print_r(sqlsrv_errors(), true));
            }

        } catch (Exception $e) {
            // ★ [디버깅] 이번까지는 에러 내용을 보여주도록 유지 (확인 후 주석 처리 권장)
            $err_msg = addslashes($e->getMessage()); 
            echo "<script>alert('DB 저장 오류 발생:\\n$err_msg'); history.back();</script>";
            
            error_log("[Accuse DB Error] " . $e->getMessage());
        }
        
    } 

    // 리소스 정리
    if(isset($connect)) sqlsrv_close($connect);
?>