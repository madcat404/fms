<?php
// =============================================
// Author:  AI Assistant
// Create date: 24.12.05
// Description: 프로필(ERP 연동), 활동배지, 메뉴설정 (DB 충돌 방지 수정판)
// =============================================

ini_set('display_errors', 1);
error_reporting(E_ALL);

// [1] MariaDB 연결 및 세션 체크 (DB1.php)
$current_dir = getcwd();
chdir(__DIR__ . '/session');
require_once 'session_check.php';
chdir($current_dir);

// MariaDB 연결 확인
if (!isset($connect) || $connect->connect_error) {
    if (file_exists('DB/DB1.php')) include 'DB/DB1.php';
}
$conn_maria = $connect; // MariaDB 연결 객체 별도 저장
$user_id = $_SESSION['user_id']; // ID

// ====================================================
// [메뉴 마스터 데이터] nav.php와 동일하게 정의
// ====================================================
$menu_structure = [
    '차량 관리' => [
        'car_rental' => '법인차', 
        'car_individual' => '개인차', 
        'car_hipass' => '하이패스'
    ],
    '현장 관리' => [
        'field_order' => '공정오더', 
        'field_check' => '검사', 
        'field_packing' => '포장',
        'field_jig' => '지그', 
        'field_inspect' => '발열검사기', 
        'field_calib' => '검교정',
        'field_testroom' => '시험실 체크', 
        'field_testproc' => '시험이력'
    ],
    '창고 관리' => [
        'wh_fin_in' => '완성품 입고', 
        'wh_fin_out' => '본사 출하',
        'wh_ecu_in' => 'ECU 입고', 
        'wh_ecu_out' => 'ECU 출고', 
        'wh_ecu_view' => 'ECU 조회',
        'wh_bb_in' => 'BB 입고', 
        'wh_bb_out' => 'BB 출고'
    ],
    '경영 지원' => [
        'mgt_attend' => '근태', 
        'mgt_duty' => '당직', 
        'mgt_food' => '식단표',
        'mgt_mycar' => '직원차량', 
        'mgt_network' => '비상연락', 
        'mgt_visitor' => '방문자',
        'mgt_uniform' => '유니폼', 
        'mgt_birth' => '생년월일', 
        'mgt_sign' => '교육회람',
        'mgt_clean' => '청소', 
        'mgt_hr' => 'HR'
    ],
    '전산/시설/보안' => [
        'it_report' => '레포트', 
        'it_asset' => '자산', 
        'it_manual' => '메뉴얼',
        'it_laptop' => '노트북', 
        'it_check' => '일일점검', 
        'sec_meter' => '검침', 
        'sec_gate' => '입출문', 
        'sec_key' => '키 관리', 
        'sec_guard' => '당숙일지'
    ],
    'ESG/재무' => [
        'esg_main' => 'ESG', 
        'esg_report' => '제보', 
        'fin_audit' => 'ERP권한', 
        'fin_todo' => '기술지원', 
        'fin_seal' => '사용인감', 
        'fin_card' => '법인카드'
    ],
    '자동화/기타' => [
        'auto_ht' => '온습도 측정', 
        'auto_ht_view' => '온습도 조회', 
        'auto_server' => '서버', 
        'auto_dpmo' => 'DPMO', 
        'auto_watt' => '가동률', 
        'global_jig' => 'JIG(VN)', 
        'global_label' => 'Tem(VN)'
    ],
    '커스텀(PDA)' => [
        'cust_guard' => '경비원전용', 
        'cust_view' => '검사현황', 
        'cust_in_view' => '완성품 입고대기', 
        'cust_out_view' => '완성품 출고현황',
        'pda_mapping' => 'PDA 매핑', 
        'pda_out' => 'PDA 출하', 
        'pda_bb' => 'PDA BB'
    ]
];

// ====================================================
// [로직 1] MariaDB에서 한국 이름(user_nm) 및 설정 가져오기
// ====================================================
$user_nm_kor = "";
$menu_config_json = null;

try {
    if ($conn_maria) {
        $stmt = $conn_maria->prepare("SELECT user_nm, menu_config FROM user_info WHERE ENG_NM = ?");
        if ($stmt) {
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $user_nm_kor = $row['user_nm'];
                $menu_config_json = $row['menu_config'];
            }
            $stmt->close();
        }
    }
} catch (Exception $e) { }

// ====================================================
// [로직 2] POST 요청 처리 (비밀번호, 메뉴 설정)
// ====================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 2-1. 사이드바 메뉴 설정 저장
    if (isset($_POST['save_menu_setting'])) {
        $selected_menus = $_POST['menus'] ?? [];
        $json_config = json_encode($selected_menus); 
        
        try {
            if ($conn_maria) {
                $stmt_up = $conn_maria->prepare("UPDATE user_info SET menu_config = ? WHERE ENG_NM = ?");
                if ($stmt_up) {
                    $stmt_up->bind_param("ss", $json_config, $user_id);
                    if ($stmt_up->execute()) {
                        echo "<script>alert('메뉴 설정이 저장되었습니다.'); location.href='my_page.php';</script>";
                        exit;
                    } else {
                        throw new Exception($stmt_up->error);
                    }
                    $stmt_up->close();
                }
            }
        } catch (Exception $e) {
            echo "<script>alert('저장 실패: " . addslashes($e->getMessage()) . "');</script>";
        }
    }

    // 2-2. 비밀번호 변경
    if (!empty($_POST['new_password'])) {
        $current_pw = $_POST['current_password'];
        $new_pw = $_POST['new_password'];
        $confirm_pw = $_POST['confirm_password'];

        if ($new_pw !== $confirm_pw) {
            echo "<script>alert('새 비밀번호가 일치하지 않습니다.');</script>";
        } else {
            $stmt_pw = $conn_maria->prepare("SELECT PASSWORD FROM user_info WHERE ENG_NM = ?");
            $stmt_pw->bind_param("s", $user_id);
            $stmt_pw->execute();
            $row_pw = $stmt_pw->get_result()->fetch_assoc();

            if ($row_pw && password_verify($current_pw, $row_pw['PASSWORD'])) {
                $new_pw_hash = password_hash($new_pw, PASSWORD_DEFAULT);
                $stmt_up_pw = $conn_maria->prepare("UPDATE user_info SET PASSWORD = ? WHERE ENG_NM = ?");
                $stmt_up_pw->bind_param("ss", $new_pw_hash, $user_id);
                $stmt_up_pw->execute();
                echo "<script>alert('비밀번호가 변경되었습니다. 재로그인해주세요.'); location.href='logout.php';</script>";
                exit;
            } else {
                echo "<script>alert('현재 비밀번호가 일치하지 않습니다.');</script>";
            }
        }
    }
}

// ====================================================
// [로직 3] MSSQL (ERP) 연결 및 사진 정보 가져오기
// ====================================================
$profile_img_src = "";
$dept_name = "-";

// ERP DB 연결 시 $connect 변수가 변경될 수 있음
if (!empty($user_nm_kor)) {
    if (file_exists('DB/DB2.php')) include 'DB/DB2.php'; 
    
    // DB2.php 로드 후에는 $connect가 MSSQL 리소스를 가리킴
    if (isset($connect) && $connect && function_exists('sqlsrv_query')) {
        $sql_erp = "SELECT TOP 1 T1.NM_DEPT, T3.DC_PHOTO 
                    FROM neoe.neoe.ma_emp AS T1
                    LEFT JOIN neoe.neoe.ma_dept AS T2 ON T1.CD_DEPT = T2.CD_DEPT
                    LEFT JOIN neoe.neoe.HR_PHOTO AS T3 ON T1.NO_EMP = T3.NO_EMP
                    WHERE T1.NM_KOR = ? AND T1.CD_INCOM = '001'";
        
        $params_erp = array($user_nm_kor);
        $stmt_erp = @sqlsrv_query($connect, $sql_erp, $params_erp);
        
        if ($stmt_erp && $row_erp = sqlsrv_fetch_array($stmt_erp, SQLSRV_FETCH_ASSOC)) {
            $dept_name = $row_erp['NM_DEPT'];
            $photo_file = $row_erp['DC_PHOTO'];
            
            if (!empty($photo_file)) {
                $fs_base = realpath(__DIR__ . '/img/erp_pic/');
                if ($fs_base === false) $fs_base = __DIR__ . '/img/erp_pic';
                $fs_base = rtrim($fs_base, '/') . '/';
                $docroot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
                $photo_base = '/' . ltrim(str_replace($docroot, '', $fs_base), '/');
                if (file_exists($fs_base . $photo_file)) {
                    $profile_img_src = $photo_base . rawurlencode($photo_file);
                }
            }
        }
    }
}

// ====================================================
// [로직 4] UI 데이터 준비 (DB 연결 복구 포함)
// ====================================================
$user_visible_menus = $menu_config_json ? json_decode($menu_config_json, true) : [];
if(!is_array($user_visible_menus)) $user_visible_menus = [];

$login_count = 0; $last_hour = -1; $last_wday = -1;

try {
    // [중요] MSSQL 연결 후 MariaDB 연결이 끊겼거나 변수가 오염되었을 수 있으므로 확인
    if (!$conn_maria || !($conn_maria instanceof mysqli)) {
        // MariaDB 재연결
        if (file_exists('DB/DB1.php')) {
            include 'DB/DB1.php';
            $conn_maria = $connect; // 재연결된 객체 할당
        }
    }

    if ($conn_maria && $conn_maria instanceof mysqli) {
        $stmt_stats = $conn_maria->prepare("SELECT COUNT(*) as login_count, MAX(s_dt) as last_login FROM sessions WHERE user_id = ?");
        if ($stmt_stats) {
            $stmt_stats->bind_param("s", $user_id);
            if ($stmt_stats->execute()) {
                $res = $stmt_stats->get_result()->fetch_assoc();
                $login_count = $res['login_count'] ?? 0;
                if (!empty($res['last_login'])) {
                    $ts = strtotime($res['last_login']);
                    $last_hour = (int)date('H', $ts);
                    $last_wday = (int)date('w', $ts);
                }
            }
            $stmt_stats->close();
        }
    }
} catch (Exception $e) {
    // 에러 발생 시 기본값 유지 (로그인 0회 등)
}

$badges = [
    'diligent' => ($login_count >= 50),
    'early'    => ($last_hour >= 0 && $last_hour < 8 && $last_hour != -1),
    'night'    => ($last_hour >= 20),
    'weekend'  => ($last_wday == 0 || $last_wday == 6),
    'master'   => ($login_count >= 500),
    'security' => true
];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include 'head_root.php'; ?>
    <title>FMS - 설정</title>
    <style>
        .profile-img-container {
            width: 150px; height: 150px; margin: 0 auto;
            border-radius: 50%; overflow: hidden;
            border: 3px solid #eaecf4; background-color: #f8f9fc;
            display: flex; align-items: center; justify-content: center;
        }
        .profile-img-container img { width: 100%; height: 100%; object-fit: cover; }
        .badge-item { text-align: center; padding: 15px 5px; border-radius: 10px; transition: 0.3s; }
        .badge-locked { filter: grayscale(100%); opacity: 0.4; }
        .badge-unlocked:hover { background-color: #f8f9fc; transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .badge-icon { font-size: 2.5rem; margin-bottom: 10px; }
        .badge-title { font-weight: 700; color: #4e73df; font-size: 0.85rem; }
        .badge-desc { font-size: 0.7rem; color: #858796; }
        .card-stretch { height: 100%; }
        .custom-control-label { cursor: pointer; user-select: none; font-size: 0.9rem; }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'nav.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <br>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">마이페이지 공사중</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow card-stretch">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-circle"></i> 프로필 정보</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-4">
                                        <div class="profile-img-container">
                                            <?php if($profile_img_src): ?>
                                                <img src="<?php echo $profile_img_src; ?>">
                                            <?php else: ?>
                                                <i class="fas fa-user fa-5x text-gray-300"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-3">
                                            <h4 class="font-weight-bold text-gray-800"><?php echo htmlspecialchars($user_nm_kor ? $user_nm_kor : $user_id); ?></h4>
                                            <div class="text-secondary mb-1"><?php echo htmlspecialchars($dept_name); ?></div>
                                            <span class="badge badge-success">총 접속 <?php echo number_format($login_count); ?>회</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <form method="post" onsubmit="return validateForm()">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-3">비밀번호 변경</div>
                                        <div class="form-group"><input type="password" class="form-control form-control-user" name="current_password" placeholder="현재 비밀번호"></div>
                                        <div class="form-group"><input type="password" class="form-control form-control-user" id="new_password" name="new_password" placeholder="새 비밀번호"></div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="confirm_password" name="confirm_password" placeholder="새 비밀번호 확인">
                                            <small id="pwCheckMsg" class="text-danger mt-2" style="display:none; text-align:center;">비밀번호 불일치</small>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block"><i class="fas fa-key"></i> 비밀번호 변경</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-list-ul"></i> 사이드바 메뉴 설정</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <input type="hidden" name="save_menu_setting" value="1">
                                        
                                        <?php foreach ($menu_structure as $group => $items): ?>
                                            <h6 class="font-weight-bold text-gray-800 mt-4 border-bottom pb-2"><?= $group ?></h6>
                                            <div class="row">
                                                <?php foreach ($items as $code => $label): ?>
                                                    <div class="col-6 col-md-3 mb-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" 
                                                                   id="menu_<?= $code ?>" name="menus[]" value="<?= $code ?>"
                                                                   <?= in_array($code, $user_visible_menus) ? 'checked' : '' ?>>
                                                            <label class="custom-control-label" for="menu_<?= $code ?>">
                                                                <?= $label ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach; ?>
                                        
                                        <hr class="mt-4 mb-3">
                                        <button type="submit" class="btn btn-info btn-block"><i class="fas fa-save"></i> 메뉴 설정 저장</button>
                                    </form>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-success"><i class="fas fa-medal"></i> 활동배지</h6></div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php 
                                        $badge_list = [
                                            ['key'=>'diligent', 'icon'=>'fa-fire', 'color'=>'text-danger', 'title'=>'성실의 아이콘', 'desc'=>'로그인 50회'],
                                            ['key'=>'early', 'icon'=>'fa-sun', 'color'=>'text-warning', 'title'=>'아침형 인간', 'desc'=>'08시 이전 접속'],
                                            ['key'=>'night', 'icon'=>'fa-moon', 'color'=>'text-dark', 'title'=>'열정의 화신', 'desc'=>'20시 이후 접속'],
                                            ['key'=>'weekend', 'icon'=>'fa-calendar-check', 'color'=>'text-info', 'title'=>'주말의 전사', 'desc'=>'주말 근무'],
                                            ['key'=>'master', 'icon'=>'fa-crown', 'color'=>'text-primary', 'title'=>'FMS 마스터', 'desc'=>'로그인 500회'],
                                            ['key'=>'security', 'icon'=>'fa-shield-alt', 'color'=>'text-success', 'title'=>'보안관', 'desc'=>'정회원 인증'],
                                        ];
                                        foreach($badge_list as $b) {
                                            $cls = $badges[$b['key']] ? 'badge-unlocked' : 'badge-locked';
                                            echo "<div class='col-4 col-md-2 mb-2'><div class='badge-item $cls'>
                                                    <div class='badge-icon {$b['color']}'><i class='fas {$b['icon']}'></i></div>
                                                    <div class='badge-title'>{$b['title']}</div>
                                                  </div></div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#confirm_password').on('keyup', function() {
                if ($('#new_password').val() != $(this).val()) {
                    $('#pwCheckMsg').show(); $(this).addClass('is-invalid');
                } else {
                    $('#pwCheckMsg').hide(); $(this).removeClass('is-invalid').addClass('is-valid');
                }
            });
        });
        function validateForm() {
            var p1 = document.getElementById("new_password").value;
            var p2 = document.getElementById("confirm_password").value;
            if ((p1 || p2) && p1 !== p2) { alert("비밀번호 불일치"); return false; }
            return true;
        }
    </script>
</body>
</html>