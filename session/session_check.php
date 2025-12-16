<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.06.26>
	// Description:	<세션 확인 로직, 로그인을 하지 않고 웹페이지 접근 방지>	
    // =============================================

    // DB 연결 (절대 경로 사용 권장)
    if (file_exists(__DIR__ . '/../DB/DB1.php')) {
        include __DIR__ . '/../DB/DB1.php';
    }

    // 세션 설정
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1);
    ini_set('session.use_only_cookies', 1);
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $timeout_duration = 32400; // 9시간

    // ======================================================================
    // [설정 구역] 이곳의 정보를 환경에 맞게 수정하세요.
    // ======================================================================
    
    // 1. 현장 키오스크 IP 리스트 (PC)
    $allowed_kiosk_ips = [
        '192.168.0.100', 
        '192.168.0.101', 
        '127.0.0.1'
    ];

    // 2. 경비원 핸드폰 접속용 비밀키 (URL 파라미터)
    // 사용법: http://주소/index.php?mobile_pass=GUARD_MASTER_KEY_2025
    $guard_secret_key = "GUARD_MASTER_KEY_2025"; 

    // ======================================================================

    $client_ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $is_auto_login_target = false; // 자동 로그인 대상 여부
    $auto_login_role = '';         // 역할 구분 (KIOSK or GUARD)

    // [검사 1] 현장 키오스크 IP 확인
    if (in_array($client_ip, $allowed_kiosk_ips)) {
        $is_auto_login_target = true;
        $auto_login_role = 'KIOSK';
    }

    // [검사 2] 경비원 핸드폰 비밀키 확인 (MAC 주소 대체 수단)
    // URL에 ?mobile_pass=키값 이 포함되어 있고, 모바일 기기(Android/iPhone)인 경우
    if (isset($_GET['mobile_pass']) && $_GET['mobile_pass'] === $guard_secret_key) {
        // 추가 보안: PC에서 주소만 훔쳐서 접속하는 것을 방지하기 위해 User-Agent가 모바일인지 체크
        if (stripos($user_agent, 'Mobile') !== false || stripos($user_agent, 'Android') !== false || stripos($user_agent, 'iPhone') !== false) {
            $is_auto_login_target = true;
            $auto_login_role = 'GUARD';
        }
    }

    // -----------------------------------------------------------
    // [로직] 자동 로그인 처리
    // -----------------------------------------------------------
    if ($is_auto_login_target && !isset($_SESSION['user_id'])) {
        if ($auto_login_role == 'KIOSK') {
            $_SESSION['user_id'] = 'KIOSK_AUTO';
            $_SESSION['EMP_NAME'] = '현장키오스크';
            $_SESSION['DEPT_CODE'] = 'FIELD';
        } else if ($auto_login_role == 'GUARD') {
            $_SESSION['user_id'] = 'GUARD_MOBILE';
            $_SESSION['EMP_NAME'] = '경비실모바일';
            $_SESSION['DEPT_CODE'] = 'SECURITY';
        }
        
        // 공통 세션 설정
        $_SESSION['created'] = time();
        $_SESSION['ip_address'] = $client_ip;
        $_SESSION['user_agent'] = $user_agent;
    }


    // -----------------------------------------------------------
    // [기존 로직] 세션 유효성 검사 (변경 없음, 정리만 함)
    // -----------------------------------------------------------
    $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

    function check_session_validity() {
        global $timeout_duration;
        if (!isset($_SESSION['user_id'])) return false;
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) return false;
        if (!isset($_SESSION['user_agent']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) return false;
        return true;
    }

    function update_session() {
        global $timeout_duration, $connect;
        $_SESSION['LAST_ACTIVITY'] = time(); 
        // (세션 재생성 및 DB 업데이트 로직은 필요 시 여기에 유지...)
    }

    function end_session($message) {
        session_unset();
        session_destroy();
        
        if ($GLOBALS['is_ajax']) {
            header('Content-Type: application/json');
            echo json_encode(['valid' => false, 'message' => $message]);
        } else {
            header("Location: /login.php?message=" . urlencode($message));
            echo "<script>window.location.href='/login.php?message=" . urlencode($message) . "';</script>";
        }
        exit; // 보안 종료
    }

    // 로그인 페이지가 아닌 경우에만 검사
    $current_file = basename($_SERVER['PHP_SELF']);
    if ($current_file != 'login.php' && $current_file != 'loginproc.php') {
        if ($is_ajax) {
            if (check_session_validity()) {
                update_session();
            } else {
                header('Content-Type: application/json');
                echo json_encode(['valid' => false, 'message' => '세션 만료']);
                exit;
            }
        } else {
            if (!check_session_validity()) {
                end_session('로그인이 필요합니다.');
            }
            update_session();
        }
    }
?>