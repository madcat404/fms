<?php 
    // =============================================
    // Description: <통합 세션 관리자 (QR/NFC/키오스크/강제업데이트 등 접근 제어)> 
    // =============================================

    // 1. DB 연결 (절대 경로)
    $db_path = dirname(__DIR__) . '/DB/DB1.php';
    try {
        if (file_exists($db_path)) {
            include_once $db_path;
        } else {
            throw new Exception("DB 연결 파일을 찾을 수 없습니다: " . $db_path);
        }
    } catch (Exception $e) {
        die("오류 발생: " . $e->getMessage());
    }

    // ======================================================================
    // [함수 정의]
    // ======================================================================
    if (!function_exists('end_session_alert')) {
        function end_session_alert($msg) {
            session_unset();
            session_destroy();
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['valid' => false, 'message' => $msg]);
                exit;
            }
            echo "<script>alert('$msg'); location.href='/login.php';</script>";
            exit;
        }
    }

    if (!function_exists('isInternalIp')) {
        function isInternalIp($ip) {
            return ($ip === '127.0.0.1' || strpos($ip, '192.168.') === 0);
        }
    }

    // ======================================================================
    // 2. 세션 설정 및 시작
    // ======================================================================
    ini_set('session.cookie_httponly', 1); 
    ini_set('session.cookie_secure', 1); 
    ini_set('session.use_only_cookies', 1);
    session_set_cookie_params(0, '/');

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $client_ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $current_file = basename($_SERVER['PHP_SELF']);
    $timeout_duration = 32400; // 9시간

    // ======================================================================
    // [1] 자동 로그인 처리 (QR / NFC / 키오스크 / 특정 IP)
    // ======================================================================

    if (!isset($_SESSION['user_id'])) {

        // ------------------------------------------------------------------
        // [A] QR 코드 접근 자동 로그인
        // ------------------------------------------------------------------
        if (isset($_GET['key']) && !empty($_GET['key']) || (isset($_GET['equipment']) && !empty($_GET['equipment']))) {
            $_SESSION['user_id'] = 'QR_GUEST';       
            $_SESSION['EMP_NAME'] = 'QR접속자';
            $_SESSION['level'] = 'qr_access';        
            $_SESSION['ip_address'] = $client_ip;
            $_SESSION['user_agent'] = $user_agent;
            $_SESSION['created'] = time();
            $_SESSION['LAST_ACTIVITY'] = time();
        }
        
        // ------------------------------------------------------------------
        // [B] NFC 태그 접근 자동 로그인
        // ------------------------------------------------------------------
        else if (isset($_GET['nfc']) && $_GET['nfc'] === 'on' && isset($_GET['key']) && !empty($_GET['key'])) {
            $_SESSION['user_id'] = 'NFC_' . preg_replace('/[^0-9]/', '', $_GET['key']);
            $_SESSION['EMP_NAME'] = 'NFC접속자';
            $_SESSION['level'] = 'nfc_access';       
            $_SESSION['ip_address'] = $client_ip;
            $_SESSION['user_agent'] = $user_agent;
            $_SESSION['created'] = time();
            $_SESSION['LAST_ACTIVITY'] = time();
        }

        // ------------------------------------------------------------------
        // [D] 메일 링크 접근 자동 로그인
        // ------------------------------------------------------------------
        else if (isset($_GET['mail_key']) && $_GET['mail_key'] === 'secret_pass_1234') {             
            $_SESSION['user_id'] = 'EMAIL_USER';
            $_SESSION['EMP_NAME'] = '메일접속자';
            $_SESSION['level'] = 'email_access';  // 메일 접속 전용 레벨 부여
            $_SESSION['ip_address'] = $client_ip;
            $_SESSION['user_agent'] = $user_agent;
            $_SESSION['created'] = time();
            $_SESSION['LAST_ACTIVITY'] = time();
        }

        // ------------------------------------------------------------------
        // [C] IP 기반 자동 로그인 (경비실 / 키오스크 / 현장PC / 스캐너 / 업데이트PC)
        // ------------------------------------------------------------------
        else {
            $guard_ips = ['192.168.3.23', '192.168.3.138']; 
            $kiosk_ips = ['192.168.3.63', '192.168.3.66', '192.168.3.65', '192.168.3.233', '192.168.3.61', '192.168.3.62'];
            $field_ips = ['192.168.3.117', '192.168.3.129', '192.168.2.130', '192.168.4.12'];
            $zebra_ips = ['192.168.3.177', '192.168.4.102', '192.168.4.100', '192.168.4.177', '192.168.4.200', '192.168.4.106'];
            $scheduler_ips = ['192.168.0.79', '192.168.3.177', '192.168.100.10'];
            $food_ips = ['192.168.0.199'];


            // C-1. 경비실 IP
            if (in_array($client_ip, $guard_ips)) {
                $auto_login_files = ['index_guard_private.php', 'view_file.php'];
                if (in_array($current_file, $auto_login_files)) {
                    $_SESSION['user_id'] = 'GUARD_AUTO';
                    $_SESSION['EMP_NAME'] = '경비실';
                    $_SESSION['level'] = 'guard';
                    $_SESSION['ip_address'] = $client_ip;
                    $_SESSION['user_agent'] = $user_agent;
                    $_SESSION['created'] = time();
                    $_SESSION['LAST_ACTIVITY'] = time();
                }
            }
            // C-2. 키오스크 IP
            else if (in_array($client_ip, $kiosk_ips)) {
                $auto_login_files = ['complete_label.php', 'order_label.php', 'bb_in.php', 'bb_out.php', 'finished_in.php', 'finished_out.php', 'ecu_in.php', 'ecu_out.php', 'ecu_inquire.php', 'gate.php'];
                if (in_array($current_file, $auto_login_files)) {
                    $_SESSION['user_id'] = 'KIOSK_AUTO';
                    $_SESSION['EMP_NAME'] = '현장키오스크';
                    $_SESSION['level'] = 'kiosk';
                    $_SESSION['ip_address'] = $client_ip;
                    $_SESSION['user_agent'] = $user_agent;
                    $_SESSION['created'] = time();
                    $_SESSION['LAST_ACTIVITY'] = time();
                }
            }
            // C-3. 현장pc IP
            else if (in_array($client_ip, $field_ips)) {
                $auto_login_files = ['finished_in_view.php.php', 'complete_label.php', 'field_complete.php', 'bb_out.php', 'finished_in.php', 'finished_out.php', 'complete_view.php', 'food.php'];
                if (in_array($current_file, $auto_login_files)) {
                    $_SESSION['user_id'] = 'FIELDPC_AUTO';
                    $_SESSION['EMP_NAME'] = '현장PC';
                    $_SESSION['level'] = 'filedpc';
                    $_SESSION['ip_address'] = $client_ip;
                    $_SESSION['user_agent'] = $user_agent;
                    $_SESSION['created'] = time();
                    $_SESSION['LAST_ACTIVITY'] = time();
                }
            }
            // C-4. 지브라스캐너 IP
            else if (in_array($client_ip, $zebra_ips)) {
                $auto_login_files = ['bb_in.php.php', 'finished_pda.php', 'bb_in_pda.php', 'packing_pda.php'];
                if (in_array($current_file, $auto_login_files)) {
                    $_SESSION['user_id'] = 'ZEBRA_AUTO';
                    $_SESSION['EMP_NAME'] = '지브라스캐너';
                    $_SESSION['level'] = 'zebra';
                    $_SESSION['ip_address'] = $client_ip;
                    $_SESSION['user_agent'] = $user_agent;
                    $_SESSION['created'] = time();
                    $_SESSION['LAST_ACTIVITY'] = time();
                }
            }
            // C-5 스케쥴러 IP (DB서버)
            else if (in_array($client_ip, $scheduler_ips)) {
                $auto_login_files = ['packing_force_update.php', 'duty_holiday_date.php', 'allbaro.php', 'esg_query.php', 'excel_blacklist.php', 'excel_blacklist2.php', 'excel_blacklist_hash.php', 'excel_export.php', 'excel_report1.php', 'excel_report2.php', 'excel_report3.php', 'excel_report4.php', 'excel_report5.php', 'indicator_stock.php','indicator_stock2.php', 'naver_news.php', 'indicator_weather.php', 'indicator_dart.php', 'indicator_electricity.php', 'update_report.php'];
                if (in_array($current_file, $auto_login_files)) {
                    $_SESSION['user_id'] = 'SCHEDULER_AUTO';
                    $_SESSION['EMP_NAME'] = '스케쥴러';
                    $_SESSION['level'] = 'scheduler_access'; // 전용 권한 레벨
                    $_SESSION['ip_address'] = $client_ip;
                    $_SESSION['user_agent'] = $user_agent;
                    $_SESSION['created'] = time();
                    $_SESSION['LAST_ACTIVITY'] = time();
                }
            } 
            // C-6 영양사 IP
            else if (in_array($client_ip, $food_ips)) {
                // 이 IP는 오직 packing_force_update.php 파일에서만 자동 로그인됨
                if ($current_file === 'food.php') {
                    $_SESSION['user_id'] = 'FOOD_AUTO';
                    $_SESSION['EMP_NAME'] = '영양사';
                    $_SESSION['level'] = 'food_access'; // 전용 권한 레벨
                    $_SESSION['ip_address'] = $client_ip;
                    $_SESSION['user_agent'] = $user_agent;
                    $_SESSION['created'] = time();
                    $_SESSION['LAST_ACTIVITY'] = time();
                }
            }            
        }
    }

    // ======================================================================
    // [2] 세션 유효성 검사 (공통)
    // ======================================================================
    
    // 검사 제외 파일 목록
    $exclude_files = ['login.php', 'loginproc.php', 'logout.php']; 

    if (!in_array($current_file, $exclude_files)) {

        // 2-1. 로그인 여부 확인
        if (!isset($_SESSION['user_id'])) {
            end_session_alert('로그인이 필요하거나 잘못된 접근입니다.');
        }

        // 2-2. 세션 하이재킹 방지
        if (isset($_SESSION['ip_address']) && $_SESSION['ip_address'] !== $client_ip) {
            end_session_alert('접속 IP가 변경되어 보안상 로그아웃 되었습니다.');
        }
        if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== $user_agent) {
             end_session_alert('브라우저 정보가 변경되어 보안상 로그아웃 되었습니다.');
        }

        // 2-3. 타임아웃 검사
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
            end_session_alert('세션이 만료되었습니다. 다시 로그인해주세요.');
        }
        
        $_SESSION['LAST_ACTIVITY'] = time();


        // ======================================================================
        // [3] 외부망 접근 통제
        // ======================================================================
        $allowed_external_levels = ['kjwt', 'master', 'vietnam', 'seetech', 'qr_access', 'nfc_access', 'email_access']; 
        $user_level = isset($_SESSION['level']) ? $_SESSION['level'] : '';

        if (!isInternalIp($client_ip)) {
            if (!in_array($user_level, $allowed_external_levels)) {
                end_session_alert('외부에서는 접근할 수 없는 계정입니다.');
            }
        }


        // ======================================================================
        // [4] 권한별 페이지 접근 통제 (Whitelist 방식)
        // ======================================================================
        
        // [4-1] 경비원(guard) 접근 통제
        if ($user_level === 'guard') {
            $guard_allowed_files = [
                'index_guard_private.php', 'key.php',
                'guard.php', 'meter.php', 'gate.php',
                'car.php', 'rental.php', 'duty.php', 
                'gw_attend.php', 'network.php',
                'schedule.php', 'food.php', 'view_file.php'
            ];
            if (!in_array($current_file, $guard_allowed_files)) {
                end_session_alert('경비원 권한으로 접근할 수 없는 페이지입니다.');
            }
        }

        // [4-2] QR 접속자(qr_access) 접근 통제
        if ($user_level === 'qr_access') {
            $qr_allowed_files = [
                'seal.php',         
                'card.php',
                'uniform.php',
                'safety.php',
                'measure_review.php',
                'food.php',
                'view_file.php',
                'card_view.php',
                'qr.php',
                'card_view.php',
                'card_download_status.php',
                'guard.php',
                'test_room_pop.php',
                'test_room.php',
                'test_room_process.php'
            ];

            if (!in_array($current_file, $qr_allowed_files)) {
                end_session_alert('QR 코드로 접근할 수 없는 페이지입니다. (권한 없음)');
            }
        }

        // [4-3] 키오스크(kiosk) 접근 통제
        if ($user_level === 'kiosk') {
            $guard_allowed_files = [
                'complete_label.php', 'order_label.php', 
                'bb_in.php', 'bb_out.php', 'finished_in.php', 
                'finished_out.php', 'ecu_in.php', 'ecu_out.php', 
                'ecu_inquire.php', 'gate.php', 'food.php', 'view_file.php'
            ];
            if (!in_array($current_file, $guard_allowed_files)) {
                end_session_alert('키오스크 권한으로 접근할 수 없는 페이지입니다.');
            }
        }

        // [4-4] 현장pc(fieldpc) 접근 통제
        if ($user_level === 'fieldpc') {
            $guard_allowed_files = [
                'finished_in_view.php.php', 'complete_label.php',
                'field_complete.php', 'bb_out.php', 'finished_in.php',
                'finished_out.php', 'complete_view.php', 'food.php', 'view_file.php',
                //'complete_label_bundle.php', 'complete_label_force.php', 'complete_label_single.php'
            ];
            if (!in_array($current_file, $guard_allowed_files)) {
                end_session_alert('현장 권한으로 접근할 수 없는 페이지입니다.');
            }
        }

        // [4-5] 지브라스캐너(zebra) 접근 통제
        if ($user_level === 'zebra') {
            $guard_allowed_files = [
                'finished_pda.php', 'finished_inquire_pda.php',
                'bb_in_pda.php', 'bb_inquire_pda.php',
                'packing_pda.php', 'packing_inquire_pda.php'
            ];
            if (!in_array($current_file, $guard_allowed_files)) {
                end_session_alert('스캐너 권한으로 접근할 수 없는 페이지입니다.');
            }
        }

        // [4-6] NFC 접속자(nfc_access) 접근 통제
        if ($user_level === 'nfc_access') {
            $nfc_allowed_files = [
                'guard.php', 
                'clean.php',
                'duty.php',
                'gate.php',
                'gate_in_nfc.php',
                'gate_out_nfc.php'
            ];
            if (!in_array($current_file, $nfc_allowed_files)) {
                end_session_alert('NFC 권한으로 접근할 수 없는 페이지입니다.');
            }
        }

        // [4-7] ★ 스케쥴러(scheduler_access) 접근 통제
        if ($user_level === 'scheduler_access') {
            $force_allowed_files = [
                'packing_force_update.php',
                'duty_holiday_date.php',
                'allbaro.php',
                'esg_query.php',
                'excel_blacklist.php',
                'excel_blacklist2.php',
                'excel_blacklist_hash.php',
                'excel_export.php',
                'excel_report1.php',
                'excel_report2.php',
                'excel_report3.php',
                'excel_report4.php',
                'excel_report5.php',
                'indicator_stock.php',
                'indicator_stock2.php',
                'naver_news.php',
                'indicator_weather.php',
                'indicator_dart.php',
                'indicator_electricity.php',
                'update_report.php'
            ];
            if (!in_array($current_file, $force_allowed_files)) {
                end_session_alert('스케쥴러 권한으로 접근할 수 없는 페이지입니다.');
            }
        }

        // [4-8] 영양사(food_access) 접근 통제
        if ($user_level === 'food_access') {
            $force_allowed_files = [
                'food.php'
            ];
            if (!in_array($current_file, $force_allowed_files)) {
                end_session_alert('영양사 권한으로 접근할 수 없는 페이지입니다.');
            }
        }

        // [4-9] 이메일 접속자(email_access) 접근 통제
        if ($user_level === 'email_access') {
            $email_allowed_files = [
                'individual.php',
                'report_body.php',
                'report_network.php',
                'calibration.php',
                'card.php',
                'measure_review.php',
                'test_room.php',
                'inspect_jig.php',
                'inspect_jig_v.php',
                'report_guard.php',
                'guard.php',
                'duty.php',
                'hipass.php',
                'rental.php',                
                'safety.php',
                'todolist.php',
                'esg.php',
                'gw_attend.php',
                'view_file.php'
            ];

            if (!in_array($current_file, $email_allowed_files)) {
                end_session_alert('메일 링크 권한으로 접근할 수 없는 페이지입니다.');
            }
        }

        // [4-10] 아이윈오토(seetech) 접근 통제
        if ($user_level === 'seetech') {
            $force_allowed_files = [
                'ecu_inquire.php'
            ];
            if (!in_array($current_file, $force_allowed_files)) {
                end_session_alert('아이윈오토 권한으로 접근할 수 없는 페이지입니다.');
            }
        }

        // [4-11] 베트남(vietnam) 접근 통제
        if ($user_level === 'vietnam') {
            $force_allowed_files = [
                'inspect_jig_v.php',
                'label_inspect.php',
                'index_global.php'
            ];
            if (!in_array($current_file, $force_allowed_files)) {
                end_session_alert('Không thể tiếp cận được.');
            }
        }
    }
?>