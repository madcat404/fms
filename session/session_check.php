<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.06.26>
	// Description:	<세션 확인 로직, 로그인을 하지 않고 웹페이지 접근 방지>	
	// =============================================

    include '../DB/DB1.php';  // 데이터베이스 연결 추가

    ini_set('session.cookie_httponly', 1); // XSS 공격 방지
    ini_set('session.cookie_secure', 1);   // HTTPS 통신 강제
    ini_set('session.use_only_cookies', 1); // URL을 통한 세션 ID 전달 방지
    session_start();

    $timeout_duration = 32400; //9시간
    
    // AJAX 요청 확인
    $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

    // 세션 유효성 검사 함수
    function check_session_validity() {
        global $timeout_duration;
        
        // 기본 세션 체크
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        // 타임아웃 체크
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
            return false;
        }

        // User-Agent 체크
        if (!isset($_SESSION['user_agent']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
            return false;
        }

        // IP 주소 체크
        if (!isset($_SESSION['ip_address'])) {
            $validated_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
            if ($validated_ip === false) {
                return false;
            }
            $_SESSION['ip_address'] = $validated_ip;
        } else if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
            return false;
        }
        return true;
    }

    // 세션 업데이트 함수
    function update_session() {
        global $timeout_duration;
        
        $_SESSION['LAST_ACTIVITY'] = time(); // 현재 시간으로 업데이트

        // 세션 재생성 조건 수정
        // 1. 세션이 처음 생성되었거나
        // 2. 마지막 세션 재생성 후 일정 시간(timeout_duration)이 지났을 때만 재생성
        if (!isset($_SESSION['created'])) {
            $_SESSION['created'] = time();
        } else if (time() - $_SESSION['created'] > $timeout_duration) {
            $old_session_id = session_id();
            session_regenerate_id(true);
            $new_session_id = session_id();
            
            // sessions 테이블 업데이트 (필요한 경우)
            if(isset($connect)) {
                $update_session = $connect->prepare("UPDATE sessions SET session_id = ? WHERE session_id = ? AND use_yn = 'Y'");
                $update_session->bind_param('ss', $new_session_id, $old_session_id);
                $update_session->execute();
            }
            
            $_SESSION['created'] = time();
        }
    }

    // 세션 종료 함수
    function end_session($message) {
        session_unset();
        session_destroy();
        
        if ($GLOBALS['is_ajax']) {
            header('Content-Type: application/json');
            echo json_encode([
                'valid' => false,
                'message' => $message
            ]);
        } else {
            // 단순 리다이렉트로 변경
            header("Location: login.php?message=" . urlencode($message));
        }
        exit;
    }

    // 메인 로직
    if ($is_ajax) {
        // AJAX 요청에 대한 처리
        header('Content-Type: application/json');
        
        if (check_session_validity()) {
            update_session();
            echo json_encode(['valid' => true]);
        } else {
            echo json_encode([
                'valid' => false,
                'message' => '세션이 만료되었습니다. 다시 로그인해주세요.'
            ]);
        }
        exit;
    } else {
        // 일반 페이지 요청에 대한 처리
        if (!check_session_validity()) {
            $message = '세션이 만료되었습니다. 다시 로그인해주세요.';
            if (!isset($_SESSION['user_id'])) {
                $message = '권한이 없습니다. 로그인 해주세요.';
            } else if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
                $message = '다른 환경에서 접속이 감지되어 로그아웃되었습니다. 다시 로그인해주세요.';
            }
            end_session($message);
        }
        
        update_session(); // 페이지 이동시 세션 시간 갱신
    }
?>