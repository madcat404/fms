<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// =============================================
// Author: KWON SUNG KUN - sealclear@naver.com
// Create date: 20.10.22
// Description: 로그인 프로세스
// =============================================use PHPMailer\PHPMailer\PHPMailer;


require "PHPMailer-master/src/PHPMailer.php";
require "PHPMailer-master/src/SMTP.php";
require "PHPMailer-master/src/Exception.php"; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 세션 시작 전에 출력 버퍼링 시작
ob_start();

include './DB/DB1.php';

// 데이터베이스 연결 확인
if (empty($connect)) {
    ob_end_clean();
    echo "<script>alert('시스템에 연결할 수 없습니다. 잠시 후 다시 시도해주세요.'); window.location.href='login.php';</script>";
    exit;
}

// 세션 쿠키 설정 강화
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // HTTPS 사용 시
ini_set('session.cookie_samesite', 'Strict');


// 세션 시작
session_start();
session_regenerate_id(true); 

// CSRF 토큰 검증
/*if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    ob_end_clean();
    echo "<script>alert('유효하지 않은 요청입니다.'); window.location.href='login.php';</script>";
    exit;
}*/

// 사용자 입력 검증
$id = isset($_POST['loginId']) ? htmlspecialchars($_POST['loginId'], ENT_QUOTES, 'UTF-8') : '';
$pw = isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : '';

if (!$id || !$pw || strlen($id) > 50 || strlen($pw) > 100) {
    ob_end_clean();
    echo "<script>alert('아이디와 비밀번호를 올바르게 입력해주세요'); window.location.href='login.php';</script>";
    exit;
} else {
    $user_mail = filter_var($id.'@iwin.kr', FILTER_VALIDATE_EMAIL);
    if (!$user_mail) {
        ob_end_clean();
        echo "<script>alert('유효하지 않은 이메일 형식입니다'); window.location.href='login.php';</script>";
        exit;
    }
}

// IP 정보 가져오기 보안 강화
$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
if (!$ip) {
    ob_end_clean();
    echo "<script>alert('유효하지 않은 IP 주소입니다'); window.location.href='login.php';</script>";
    exit;
}

// IP가 '192.168.'로 시작하는지 확인
if (strpos($ip, '192.168.') === 0) {
    // IP가 '192.168.'로 시작하면, IP 정보를 사용하지 않고 country를 기본값으로 설정
    $country = 'Local'; // 예를 들어 'Local'로 설정
} else {
    // '192.168.'이 아닌 경우 실제 IP를 사용하여 country 정보를 가져옴
    $context = stream_context_create(['http' => ['timeout' => 3]]); // 3초 타임아웃 설정
    $json = @file_get_contents("http://ip-api.com/json/{$ip}", false, $context);
    if ($json) {
        $data = json_decode($json, true);
        $country = $data['country'] ?? 'Unknown'; // IP로부터 얻은 국가 정보
    } else {
        $country = 'Unknown'; // API 호출에 실패한 경우
    }
}

$session_id = session_id(); //세션ID

$_SESSION["user_id"] = $id;
$_SESSION["session_level"] = 'none';

if (strpos($ip, '192.168.') === 0 || $country === 'South Korea' || $country === 'Vietnam') {
    //베트남 바오사원은 gw 계정이 없음
    if($id!='bao' and $id!='sykim' and $id!='sang' and $id!='hssin') {
        
        $mail = new PHPMailer(true);

        try {
            // 서버 세팅
            $mail->SMTPDebug = 0; // 디버깅 설정 (2로 설정하여 자세한 디버깅 메시지 출력)
            $mail->isSMTP(); // SMTP 사용 설정 
            $mail->Host = "mail.iwin.kr"; // SMTP 서버
            $mail->SMTPAuth = true; // SMTP 인증 사용
            $mail->Username = $user_mail; // 메일 계정
            $mail->Password = $pw; // 메일 비밀번호
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS 암호화
            $mail->Port = 587; // email 보낼때 사용할 포트
            $mail->CharSet = "utf-8"; // 문자셋 인코딩
            $mail->Timeout = 10; // SMTP 연결 시간 초과 설정 (10초)
            $mail->smtpConnect();   // SMTP 연결
            $mail->smtpClose(); // 연결 종료

            // 사용자 정보 조회
            $stmt = $connect->prepare('SELECT * FROM user_info WHERE ENG_NM = ?');
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $connect->error);
            }

            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $check_pw_row = $result->fetch_object();   
            
            // [FIX] Check if user exists before proceeding. If not, throw exception to be caught below.
            if (!$check_pw_row) {
                throw new Exception("Authentication failed");
            }
            
            // 로그인 시도 횟수 및 마지막 로그인 시간 조회
            $stmt_attempts = $connect->prepare('SELECT login_attempts, last_activity FROM sessions WHERE user_id = ? order by s_dt desc limit 1');
            if (!$stmt_attempts) {
                ob_end_clean();
                echo "<script>alert('데이터베이스 오류가 발생했습니다.'); window.location.href='login.php';</script>";
                exit;
            }
            $stmt_attempts->bind_param('s', $id);
            $stmt_attempts->execute();
            $result_attempts = $stmt_attempts->get_result();
            $attempts_row = $result_attempts->fetch_object();
            
            // 로그인 시도 횟수 6회 이상이면 1시간 경과 여부 확인
            if ($attempts_row && $attempts_row->login_attempts >= 6) {
                $last_activity = strtotime($attempts_row->last_activity);
                $current_time = time();
                
                // 1시간(3600초) 이내에 시도한 경우 로그인 차단
                if ($current_time - $last_activity < 3600) {
                    ob_end_clean();
                    echo "<script>alert('로그인 시도 횟수가 너무 많아 계정이 잠겼습니다. 1시간 후에 다시 시도해주세요.'); window.location.href='login.php';</script>";
                    exit;
                }
            }

            $_SESSION["user_id"] = $check_pw_row->ENG_NM;
            $_SESSION["session_level"] = $check_pw_row->LEVEL;
        
            // 세션 레벨 검증 추가
            if (!check_session_level($connect, $_SESSION["user_id"])) {
                ob_end_clean();
                echo "<script>alert('접근이 제한된 계정입니다. 관리자에게 문의하세요.'); window.location.href='login.php';</script>";
                exit;
            }

            // 세션 고정 공격 방지
            if (!isset($_SESSION['user_agent'])) {
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            } else if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
                // 브라우저가 변경된 경우 세션 종료
                session_unset();
                session_destroy();
                ob_end_clean();
                echo "<script>alert('세션이 만료되었습니다. 모든 인터넷 창을 끄고 다시 로그인 해주세요.'); window.location.href='login.php';</script>";
                exit;
            }

            // 세션 하이재킹 방지
            if (!isset($_SESSION['ip_address'])) {
                $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
            } else if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
                // IP 주소가 변경된 경우 세션 종료
                session_unset();
                session_destroy();
                ob_end_clean();
                echo "<script>alert('세션이 만료되었습니다. 모든 인터넷 창을 끄고 다시 로그인 해주세요.'); window.location.href='login.php';</script>";
                exit;
            }           

            record_login_attempt($connect, $session_id, $_SESSION['user_id'], $_SESSION['session_level'], 'N', $ip, $_SERVER['HTTP_USER_AGENT'], $country);
            
            // "Remember me" 쿠키 처리
            if (isset($_POST['remember-me'])) {
                // 쿠키를 30일간 유지
                setcookie('remember_me', $id, time() + (86400 * 30), "/"); 
            } else {
                // "Remember me"가 체크되지 않은 경우 쿠키 삭제
                if (isset($_COOKIE['remember_me'])) {
                    setcookie('remember_me', '', time() - 3600, "/");
                }
            }

            header("Location: index.php");
            exit;    
        } catch (Exception $e) {            
            $errorMessage = $e->getMessage();
            // 로그인 시도 횟수 및 마지막 로그인 시간 조회
            $stmt_attempts = $connect->prepare('SELECT login_attempts, last_activity FROM sessions WHERE user_id = ? order by s_dt desc limit 1');
            if (!$stmt_attempts) {
                ob_end_clean();
                echo "<script>alert('데이터베이스 오류가 발생했습니다.'); window.location.href='login.php';</script>";
                exit;
            }
            $stmt_attempts->bind_param('s', $id);
            $stmt_attempts->execute();
            $result_attempts = $stmt_attempts->get_result();
            $attempts_row = $result_attempts->fetch_object();
            
            // 로그인 시도 횟수 6회 이상이면 1시간 경과 여부 확인
            if ($attempts_row && $attempts_row->login_attempts >= 6) {
                $last_activity = strtotime($attempts_row->last_activity);
                $current_time = time();
                
                // 1시간(3600초) 이내에 시도한 경우 로그인 차단
                if ($current_time - $last_activity < 3600) {
                    ob_end_clean();
                    echo "<script>alert('로그인 시도 횟수가 너무 많아 계정이 잠겼습니다. 1시간 후에 다시 시도해주세요'); window.location.href='login.php';</script>";
                    exit;
                }
            }

            record_login_attempt($connect, $session_id, $id, 'none', 'Y', $ip, $_SERVER['HTTP_USER_AGENT'], $country);
            ob_end_clean();
            echo "<script>alert('아이디나 패스워드가 잘못된것 같습니다!'); window.location.href='login.php';</script>";
            exit;
        }
    }
    else {
        // 사용자 정보 조회
        $stmt = $connect->prepare('SELECT * FROM user_info WHERE ENG_NM = ?');
        if (!$stmt) {
            ob_end_clean();
            echo "<script>alert('데이터베이스 오류가 발생했습니다.'); window.location.href='login.php';</script>";
            exit;
        }

        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $check_pw_row = $result->fetch_object();

        // [FIX] Check if user exists before proceeding
        if (!$check_pw_row) {
            record_login_attempt($connect, $session_id, $id, 'none', 'Y', $ip, $_SERVER['HTTP_USER_AGENT'], $country);
            ob_end_clean();
            echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.'); window.location.href='login.php';</script>";
            exit;
        }

        // 로그인 시도 횟수 및 마지막 로그인 시간 조회
        $stmt_attempts = $connect->prepare('SELECT login_attempts, last_activity FROM sessions WHERE user_id = ? order by s_dt desc limit 1');
        if (!$stmt_attempts) {
            ob_end_clean();
            echo "<script>alert('데이터베이스 오류가 발생했습니다.'); window.location.href='login.php';</script>";
            exit;
        }
        $stmt_attempts->bind_param('s', $id);
        $stmt_attempts->execute();
        $result_attempts = $stmt_attempts->get_result();
        $attempts_row = $result_attempts->fetch_object();

        // 로그인 시도 횟수 6회 이상이면 1시간 경과 여부 확인
        if ($attempts_row && $attempts_row->login_attempts >= 6) {
            $last_activity = strtotime($attempts_row->last_activity); // 'last_activity'를 Unix 타임스탬프로 변환
            $current_time = time(); // 현재 시간 (Unix 타임스탬프)
            
            // 1시간(3600초) 이내에 시도한 경우 로그인 차단
            if ($current_time - $last_activity < 3600) {
                ob_end_clean();
                echo "<script>alert('로그인 시도 횟수가 너무 많습니다. 1시간 후에 다시 시도해주세요.'); window.location.href='login.php';</script>";
                exit;
            }
        }

        $_SESSION["user_id"] = $check_pw_row->ENG_NM;
        $_SESSION["session_level"] = $check_pw_row->LEVEL;

        // 세션 레벨 검증 추가
        if (!check_session_level($connect, $_SESSION["user_id"])) {
            ob_end_clean();
            echo "<script>alert('접근이 제한된 계정입니다. 관리자에게 문의하세요.'); window.location.href='login.php';</script>";
            exit;
        }

        // 비밀번호 해시 검증
        if (password_verify($pw, $check_pw_row->PASSWORD)) {
            // 세션 고정 공격 방지
            if (!isset($_SESSION['user_agent'])) {
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            } else if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
                // 브라우저가 변경된 경우 세션 종료
                session_unset();
                session_destroy();
                ob_end_clean();
                echo "<script>alert('세션이 만료되었습니다. 모든 인터넷 창을 끄고 다시 로그인 해주세요.'); window.location.href='login.php';</script>";
                exit;
            }

            // 세션 하이재킹 방지
            if (!isset($_SESSION['ip_address'])) {
                $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
            } else if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
                // IP 주소가 변경된 경우 세션 종료
                session_unset();
                session_destroy();
                ob_end_clean();
                echo "<script>alert('세션이 만료되었습니다. 모든 인터넷 창을 끄고 다시 로그인 해주세요.'); window.location.href='login.php';</script>";
                exit;
            }          

            record_login_attempt($connect, $session_id, $_SESSION['user_id'], $_SESSION['session_level'], 'N', $ip, $_SERVER['HTTP_USER_AGENT'], $country);
            
            // "Remember me" 쿠키 처리
            if (isset($_POST['remember-me'])) {
                // 쿠키를 30일간 유지
                setcookie('remember_me', $id, time() + (86400 * 30), "/"); 
            } else {
                // "Remember me"가 체크되지 않은 경우 쿠키 삭제
                if (isset($_COOKIE['remember_me'])) {
                    setcookie('remember_me', '', time() - 3600, "/");
                }
            }

            header("Location: index.php");
            exit;
        } else {
            
            record_login_attempt($connect, $session_id, $_SESSION['user_id'], $_SESSION['session_level'], 'Y', $ip, $_SERVER['HTTP_USER_AGENT'], $country);
            ob_end_clean();
            echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.'); window.location.href='login.php';</script>";
            exit;
        }
    }
} else {
    // 로그인 제한: IP가 192.168.이 아니거나 $country가 South Korea가 아닌 경우
    record_login_attempt($connect, $session_id, $_SESSION['user_id'], $_SESSION['session_level'], 'Y', $ip, $_SERVER['HTTP_USER_AGENT'], $country);
    ob_end_clean();
    echo "<script>alert('해외에서 로그인 시도 시 관리자에게 문의 바랍니다.'); window.location.href='login.php';</script>";
    exit;
}

// 새로운 함수 추가: 디바이스 정보 파싱
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

function record_login_attempt(&$connect, &$session_id, &$id, $level, $fail_yn, &$ip_address, &$user_agent, $country) {
   // user_info 테이블에서 사용자 확인
    $check_user = $connect->prepare("SELECT ENG_NM FROM user_info WHERE ENG_NM = ?");
    $check_user->bind_param('s', $id);
    $check_user->execute();
    $user_result = $check_user->get_result();
    
    // use_yn 값 설정 (사용자가 존재하면 'Y', 아니면 'N')
    $use_yn = ($user_result->num_rows > 0) ? 'Y' : 'N';
    
    // 디바이스 정보 파싱
    $device_info = parseUserAgentInfo($user_agent);
    
    // 해당 user_id로 세션이 존재하는지 확인
    $check_session = $connect->prepare("SELECT session_id, level, fail_yn FROM sessions WHERE user_id = ? ORDER BY s_dt DESC LIMIT 1");
    $check_session->bind_param('s', $id);
    $check_session->execute();
    $result = $check_session->get_result();
    $existing_session = $result->fetch_object();
    
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
            browser_version
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $login_record->bind_param('ssssssssssss', 
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
            $device_info['browser_version']
        );
        $login_record->execute();
    }

    // 로그인 실패/성공에 따른 attempts 처리
    if ($fail_yn == 'Y') {
        $update_attempts_stmt = $connect->prepare('UPDATE sessions SET login_attempts = login_attempts + 1 WHERE user_id = ?');
        $update_attempts_stmt->bind_param('s', $id);
        $update_attempts_stmt->execute();
    } elseif ($fail_yn == 'N') {
        $update_attempts_stmt = $connect->prepare('UPDATE sessions SET login_attempts = 0 WHERE user_id = ?');
        $update_attempts_stmt->bind_param('s', $id);
        $update_attempts_stmt->execute();
    }
}

function check_session_level($connect, $user_id) {
    // sessions 테이블에서 해당 사용자의 최근 세션 레벨 확인
    $stmt = $connect->prepare('SELECT level FROM sessions WHERE user_id = ? ORDER BY s_dt DESC LIMIT 1');
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $session_row = $result->fetch_object();

    // 세션이 'closing' 상태이거나 없는 경우 false 반환
    if ($session_row && $session_row->level === 'closing') {
        return false;
    }
    
    // $_SESSION의 level이 'none'인 경우 false 반환
    if ($_SESSION["session_level"] === 'none') {
        return false;
    }

    return true;
}