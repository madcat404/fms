<?php
// =============================================
// Author: KWON SUNG KUN - sealclear@naver.com
// Create date: 20.10.22
// Description: 로그인 프로세스
// =============================================

// 네임스페이스 선언과 라이브러리 로드 순서 정렬
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer-master/src/PHPMailer.php";
require "PHPMailer-master/src/SMTP.php";
require "PHPMailer-master/src/Exception.php"; 

// 세션 시작 전에 출력 버퍼링 시작
ob_start();

include_once './DB/DB1.php';

// 데이터베이스 연결 확인
if (empty($connect)) {
    ob_end_clean();
    echo "<script>alert('시스템에 연결할 수 없습니다. 잠시 후 다시 시도해주세요.'); window.location.href='login.php';</script>";
    exit;
}

// 1. 세션 보안 설정 (session_start 전 필수)
// 세션 쿠키 설정 강화
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // HTTPS 사용 시
ini_set('session.cookie_samesite', 'Strict');
session_set_cookie_params(0, '/'); // 브라우저 종료 시 삭제, 전역 경로

// 세션 시작
session_start();
session_regenerate_id(true); 

// 2. 입력값 검증
$id = isset($_POST['loginId']) ? trim($_POST['loginId']) : '';
$pw = isset($_POST['password']) ? trim($_POST['password']) : '';

if (!$id || !$pw || strlen($id) > 50 || strlen($pw) > 100) {
    alert_move('아이디와 비밀번호를 올바르게 입력해주세요', 'login.php');
} else {
    // 이메일 형식 검증 (도메인 추가하여 검증)
    if (!filter_var($id.'@iwin.kr', FILTER_VALIDATE_EMAIL)) {
        alert_move('유효하지 않은 이메일 형식입니다', 'login.php');
    }
}

// 3. IP 및 국가 정보 획득
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$country = 'Unknown';

// 사설 IP 체크 및 국가 정보 획득
if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
    $country = 'Local';
} else {
    $context = stream_context_create(['http' => ['timeout' => 2]]);
    $json = @file_get_contents("http://ip-api.com/json/{$ip}", false, $context);
    if ($json) {
        $data = json_decode($json, true);
        $country = $data['country'] ?? 'Unknown';
    }
}

// 4. [보안] 해외 접속 차단
if ($country !== 'South Korea' && $country !== 'Vietnam' && $country !== 'Local') {
    record_login_attempt($connect, session_id(), $id, 'none', 'Y', $ip, $user_agent, $country);
    alert_move('해외에서의 접속은 차단됩니다.', 'login.php');
}


// =============================================================
// 5. 통합 인증 로직 (SMTP + DB 예외처리)
// =============================================================
// 5-1. 사용자 정보 조회 (공통)
$stmt = $connect->prepare('SELECT * FROM user_info WHERE ENG_NM = ?');
$stmt->bind_param('s', $id);
$stmt->execute();
$user_row = $stmt->get_result()->fetch_object();

if (!$user_row) {
    record_login_attempt($connect, session_id(), $id, 'none', 'Y', $ip, $user_agent, $country);
    alert_move('아이디 또는 비밀번호가 잘못되었습니다.', 'login.php');
}

// 5-2. 로그인 시도 횟수 확인 (Brute Force)
$stmt_attempts = $connect->prepare('SELECT login_attempts, last_activity FROM sessions WHERE user_id = ? ORDER BY s_dt DESC LIMIT 1');
$stmt_attempts->bind_param('s', $id);
$stmt_attempts->execute();
$attempt_row = $stmt_attempts->get_result()->fetch_object();

if ($attempt_row && $attempt_row->login_attempts >= 5) {
    if (time() - strtotime($attempt_row->last_activity) < 3600) {
        alert_move('로그인 시도 횟수 초과. 1시간 뒤 다시 시도해주세요.', 'login.php');
    }
}

// 5-3. 인증 방식 결정 및 검증
$auth_success = false;
$exclude_smtp_users = ['bao', 'sang']; // SMTP 예외 계정

try {
    if (in_array($id, $exclude_smtp_users)) {
        // [A] 예외 사용자는 DB 비밀번호 검증
        if (password_verify($pw, $user_row->PASSWORD)) {
            $auth_success = true;
        }
    } else {
        // [B] 일반 사용자는 SMTP 인증
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "mail.iwin.kr";
        $mail->SMTPAuth = true;
        $mail->Username = $id . '@iwin.kr'; // 이메일 형식 자동 완성
        $mail->Password = $pw;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Timeout = 5;
        
        if ($mail->smtpConnect()) {
            $mail->smtpClose();
            $auth_success = true;
        }
    }
} catch (Exception $e) {
    $auth_success = false;
}

// 5-4. 결과 처리
if ($auth_success) {
    // [성공]
    if ($user_row->LEVEL === 'closing') {
        alert_move('계정이 잠김(Closing) 상태입니다.', 'login.php');
    }

    session_regenerate_id(true);
    $_SESSION['name'] = $user_row->USER_NM;
    $_SESSION['user_id'] = $user_row->ENG_NM;
    $_SESSION['level'] = $user_row->LEVEL; // [수정] 호환성을 위해 session_level로 복구
    $_SESSION['ip_address'] = $ip;
    $_SESSION['user_agent'] = $user_agent;
    $_SESSION['LAST_ACTIVITY'] = time();

    // DB 기록 (성공 'N')
    record_login_attempt($connect, session_id(), $id, $user_row->LEVEL, 'N', $ip, $user_agent, $country);

    // Remember Me
    if (isset($_POST['remember-me'])) {
        setcookie('remember_me', $id, time() + (86400 * 30), "/");
    } else {
        if (isset($_COOKIE['remember_me'])) setcookie('remember_me', '', time() - 3600, "/");
    }

    // [수정됨] LEVEL에 따라 특정 페이지로 리다이렉트
    if ($user_row->LEVEL === 'seetech') {
        header("Location: kjwt_field_ecu/ecu_inquire.php");
    } elseif ($user_row->LEVEL === 'vietnam') {
        header("Location: index_global.php");
    } else {
        header("Location: index.php");
    }
    exit;

} else {
    // [실패]
    record_login_attempt($connect, session_id(), $id, 'none', 'Y', $ip, $user_agent, $country);
    alert_move('아이디 또는 비밀번호가 잘못되었습니다.', 'login.php');
}

// =============================================================
// Helper Functions
// =============================================================

function parseUserAgentInfo($user_agent) {
    // Mobile/Tablet 확인을 위한 키워드
    $mobile_keywords = array('Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone');
    $tablet_keywords = array('iPad', 'Tablet', 'Kindle');
    
    // 디바이스 타입 확인
    $device_type = 'desktop';
    foreach($mobile_keywords as $keyword) {
        if(stripos($user_agent, $keyword) !== false) {
            $device_type = 'mobile';
            break;
        }
    }
    foreach($tablet_keywords as $keyword) {
        if(stripos($user_agent, $keyword) !== false) {
            $device_type = 'tablet';
            break;
        }
    }

    // OS 정보 추출
    $os_name = 'Unknown';
    $os_version = '';
    if(stripos($user_agent, 'Windows') !== false) {
        $os_name = 'Windows';
        if(preg_match('/Windows NT ([\d\.]+)/', $user_agent, $matches)) {
            $os_version = $matches[1];
        }
    } elseif(stripos($user_agent, 'Mac OS X') !== false) {
        $os_name = 'Mac OS X';
        if(preg_match('/Mac OS X ([\d_\.]+)/', $user_agent, $matches)) {
            $os_version = str_replace('_', '.', $matches[1]);
        }
    } elseif(stripos($user_agent, 'Linux') !== false) {
        $os_name = 'Linux';
    } elseif(stripos($user_agent, 'Android') !== false) {
        $os_name = 'Android';
        if(preg_match('/Android ([\d\.]+)/', $user_agent, $matches)) {
            $os_version = $matches[1];
        }
    } elseif(stripos($user_agent, 'iOS') !== false) {
        $os_name = 'iOS';
        if(preg_match('/OS ([\d_]+)/', $user_agent, $matches)) {
            $os_version = str_replace('_', '.', $matches[1]);
        }
    }

    // 브라우저 정보 추출
    $browser_name = 'Unknown';
    $browser_version = '';
    if(preg_match('/(Chrome|Firefox|Safari|Edge|MSIE|Trident)\/?([\d\.]+)?/', $user_agent, $matches)) {
        $browser_name = $matches[1];
        $browser_version = isset($matches[2]) ? $matches[2] : '';
    }

    return array(
        'device_type' => $device_type,
        'os_name' => $os_name,
        'os_version' => $os_version,
        'browser_name' => $browser_name,
        'browser_version' => $browser_version
    );
}

function record_login_attempt($connect, $session_id, $id, $level, $fail_yn, $ip_address, $user_agent, $country) {
   // user_info 테이블에서 사용자 확인
   $check_user = $connect->prepare("SELECT ENG_NM FROM user_info WHERE ENG_NM = ?");
   $check_user->bind_param('s', $id);
   $check_user->execute();
   $user_result = $check_user->get_result();
   
   $use_yn = ($user_result->num_rows > 0) ? 'Y' : 'N';
   $device_info = parseUserAgentInfo($user_agent);
   
   // 해당 user_id로 세션이 존재하는지 확인
   $check_session = $connect->prepare("SELECT session_id, level, fail_yn FROM sessions WHERE user_id = ? ORDER BY s_dt DESC LIMIT 1");
   $check_session->bind_param('s', $id);
   $check_session->execute();
   $result = $check_session->get_result();
   
   if ($result->num_rows > 0) {
       // 기존 세션이 있는 경우 업데이트
       $update_session = $connect->prepare("UPDATE sessions SET 
           session_id = ?,
           level = ?,
           fail_yn = ?,
           ip_address = ?,
           country = ?,
           use_yn = ?,
           device_type = ?,
           os_name = ?,
           os_version = ?,
           browser_name = ?,
           browser_version = ?,
           last_activity = CURRENT_TIMESTAMP,
           s_dt = CURRENT_TIMESTAMP
           WHERE user_id = ?");
       
       $update_session->bind_param('ssssssssssss', 
           $session_id, 
           $level, 
           $fail_yn, 
           $ip_address, 
           $country,
           $use_yn,
           $device_info['device_type'], 
           $device_info['os_name'], 
           $device_info['os_version'], 
           $device_info['browser_name'], 
           $device_info['browser_version'], 
           $id
       );
       $update_session->execute();
       
       if ($fail_yn == 'Y') {
           $update_attempts_stmt = $connect->prepare('UPDATE sessions SET login_attempts = login_attempts + 1 WHERE user_id = ?');
           $update_attempts_stmt->bind_param('s', $id);
           $update_attempts_stmt->execute();
       } elseif ($fail_yn == 'N') {
           $update_attempts_stmt = $connect->prepare('UPDATE sessions SET login_attempts = 0 WHERE user_id = ?');
           $update_attempts_stmt->bind_param('s', $id);
           $update_attempts_stmt->execute();
       }

   } else {
       // 기존 세션이 없는 경우 새로 삽입
       $login_record = $connect->prepare("INSERT INTO sessions(
           session_id, 
           user_id, 
           level, 
           fail_yn, 
           ip_address, 
           country,
           use_yn,
           device_type,
           os_name, 
           os_version, 
           browser_name, 
           browser_version,
           login_attempts,
           s_dt,
           last_activity
       ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
       
       $attempts = ($fail_yn == 'Y') ? 1 : 0;

       $login_record->bind_param('ssssssssssssi', 
           $session_id, 
           $id, 
           $level, 
           $fail_yn, 
           $ip_address, 
           $country,
           $use_yn, 
           $device_info['device_type'], 
           $device_info['os_name'], 
           $device_info['os_version'], 
           $device_info['browser_name'], 
           $device_info['browser_version'],
           $attempts
       );
       $login_record->execute();
   }
}

function alert_move($msg, $url) {
    ob_end_clean();
    echo "<script>alert('$msg'); window.location.href='$url';</script>";
    exit;
}
?>