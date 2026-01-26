<?php
    // =============================================
    // Author: System
    // Description: QR 코드 데이터 처리 (생성/수정/보안 리다이렉트)
    // =============================================

    session_start(); // [중요] 세션 시작
    
    // DB 연결
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 

    // XSS 방지 함수
    if (!function_exists('h')) {
        function h($string) {
            if (!isset($string)) return '';
            return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }
    }

    // =================================================================
    // 1. [접속/리다이렉트 로직] (QR 스캔 시 동작)
    //    'no' 대신 'key' 파라미터를 사용하여 직접 접근(Sequential Attack) 방지
    // =================================================================
    if (isset($_GET['key']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        $token_key = $_GET['key'];

        // 난수 토큰(ACCESS_TOKEN)으로 원본 정보 조회
        $sql = "SELECT NO, TARGET_URL FROM CONNECT.dbo.QR WHERE ACCESS_TOKEN = ?";
        $params = array($token_key);
        $stmt = sqlsrv_query($connect, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_has_rows($stmt)) {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            $target_url = $row['TARGET_URL'];
            $no = $row['NO'];

            // A. 방문 횟수 증가
            $sql_update = "UPDATE CONNECT.dbo.QR SET VISIT_COUNT = VISIT_COUNT + 1 WHERE NO = ?";
            sqlsrv_query($connect, $sql_update, array($no));

            // B. [보안 핵심] 세션에 인증 정보 저장
            // 타겟 페이지에서 이 세션값이 있는지 검사하여 직접 접속을 차단할 수 있음
            $_SESSION['QR_AUTH_TOKEN'] = $token_key; 
            $_SESSION['QR_AUTH_NO'] = $no;
            $_SESSION['QR_AUTH_TIME'] = time();

            // C. 이동
            // URL에 토큰을 노출하지 않고 세션만으로 검증하거나, 필요 시 파라미터 추가 가능
            header("Location: " . $target_url);
            exit;

        } else {
            // 토큰 불일치 (해킹 시도 등)
            header("HTTP/1.1 403 Forbidden");
            echo "<script>alert('유효하지 않은 QR 코드입니다.'); history.back();</script>";
            exit;
        }
    }
    
    // (레거시 지원) 기존 번호 방식 접근 차단 또는 예외 처리
    // 보안을 위해 key가 없는 no 접근은 차단하는 것이 좋음
    if (isset($_GET['no']) && !isset($_GET['key']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo "<script>alert('보안 정책이 변경되었습니다. QR 코드를 다시 발급받아주세요.'); history.back();</script>";
        exit;
    }

    // =================================================================
    // 2. [저장 및 수정 로직] (관리자 페이지 폼 전송)
    // =================================================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_save'])) {
        $input_title = $_POST['title'] ?? '';
        $input_url = $_POST['target_url'] ?? '';
        $input_no = $_POST['qr_no'] ?? ''; // 수정 시 PK

        if ($input_title && $input_url) {
            // URL 프로토콜 보정
            if (!preg_match("~^(?:f|ht)tps?://~i", $input_url)) {
                $input_url = "http://" . $input_url;
            }

            if (!empty($input_no) && is_numeric($input_no)) {
                // --- 수정 (UPDATE) ---
                // 토큰은 유지, 제목/URL만 변경
                $sql = "UPDATE CONNECT.dbo.QR SET TITLE = ?, TARGET_URL = ?, UPDATED_DT = GETDATE() WHERE NO = ?";
                $params = array($input_title, $input_url, $input_no);
                $msg = "QR 코드가 수정되었습니다.";
                
                $stmt = sqlsrv_query($connect, $sql, $params);

            } else {
                // --- 신규 생성 (INSERT) ---
                // [보안 토큰 생성] 64자리 랜덤 16진수 문자열
                $new_token = bin2hex(random_bytes(32)); 

                $sql = "INSERT INTO CONNECT.dbo.QR (TITLE, TARGET_URL, ACCESS_TOKEN, CREATED_DT, UPDATED_DT) VALUES (?, ?, ?, GETDATE(), GETDATE())";
                $params = array($input_title, $input_url, $new_token);
                $msg = "QR 코드가 생성되었습니다.";
                
                $stmt = sqlsrv_query($connect, $sql, $params);
            }

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            } else {
                echo "<script>alert('{$msg}'); location.href='qr.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('제목과 URL을 모두 입력해주세요.'); history.back();</script>";
            exit;
        }
    }

    // =================================================================
    // 3. [목록 조회 로직]
    // =================================================================
    $qr_list = [];
    // ACCESS_TOKEN 컬럼 포함해서 조회
    $sql = "SELECT TOP 1000 NO, TITLE, TARGET_URL, ACCESS_TOKEN, VISIT_COUNT, CREATED_DT, UPDATED_DT FROM CONNECT.dbo.QR ORDER BY NO DESC";
    $result = sqlsrv_query($connect, $sql);

    if ($result) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $qr_list[] = $row;
        }
    }
?>