<?php
// DB 연결 체크
if (!file_exists('../DB/DB2.php')) {
    die("<div class='alert alert-danger'>데이터베이스 설정 파일(../DB/db2.php)을 찾을 수 없습니다. 경로를 확인해주세요.</div>");
}
include '../DB/DB2.php';

// DB 연결 객체 확인 ($connect 변수가 db2.php에서 생성되어야 함)
if (!isset($connect) || $connect === false) {
    die("<div class='alert alert-danger'>데이터베이스 연결 실패. 관리자에게 문의하세요.<br>" . print_r(sqlsrv_errors(), true) . "</div>");
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$current_month = date('Y-m');
$location_param = isset($_GET['loc']) ? $_GET['loc'] : '';
$check_data = [];
$saved_note = '';
$saved_writer = '';

// 조회 로직
if ($location_param) {
    $search_month = isset($_GET['search_month']) ? $_GET['search_month'] : $current_month;

    $sql = "SELECT CHECK_DATA, NOTE, WRITER FROM SAFETY WHERE CHECK_MONTH = ? AND LOCATION = ?";
    $params = array($search_month, $location_param);
    
    $stmt = sqlsrv_query($connect, $sql, $params);

    if ($stmt === false) {
        // 쿼리 에러 발생 시 상세 내용 출력
        die("<div class='alert alert-danger'>데이터 조회 오류 발생.<br>" . print_r(sqlsrv_errors(), true) . "</div>");
    }

    if (sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $check_data = json_decode($row['CHECK_DATA'], true) ?? [];
        $saved_note = $row['NOTE'];
        $saved_writer = $row['WRITER'];
    }
}

// 저장 로직
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode']) && $_POST['mode'] === 'save') {
    $p_month = $_POST['check_month'];
    $p_location = $_POST['location'];
    $p_note = $_POST['note'] ?? '';
    $p_check_items = isset($_POST['check_item']) ? $_POST['check_item'] : [];
    
    $json_data = json_encode($p_check_items, JSON_UNESCAPED_UNICODE);
    $p_writer = $_SESSION['user_id'] ?? 'Guest';

    // 저장 후 돌아올 URL 자동 설정
    $return_url = $_SERVER['PHP_SELF'] . "?loc=" . urlencode($p_location) . "&search_month=" . urlencode($p_month) . "&tab=tab2";

    $sql_save = "
        MERGE INTO SAFETY AS target
        USING (SELECT ? AS CHECK_MONTH, ? AS LOCATION) AS source
        ON (target.CHECK_MONTH = source.CHECK_MONTH AND target.LOCATION = source.LOCATION)
        WHEN MATCHED THEN
            UPDATE SET CHECK_DATA = ?, NOTE = ?, WRITER = ?, REG_DATE = GETDATE()
        WHEN NOT MATCHED THEN
            INSERT (CHECK_MONTH, LOCATION, CHECK_DATA, NOTE, WRITER, REG_DATE)
            VALUES (?, ?, ?, ?, ?, GETDATE());
    ";

    $params_save = array(
        $p_month, $p_location,
        $json_data, $p_note, $p_writer,
        $p_month, $p_location, $json_data, $p_note, $p_writer
    );

    $stmt_save = sqlsrv_query($connect, $sql_save, $params_save);

    if ($stmt_save === false) {
        die("<div class='alert alert-danger'>저장 중 오류가 발생했습니다.<br>" . print_r(sqlsrv_errors(), true) . "</div>");
    } else {
        echo "<script>alert('저장되었습니다.'); location.href = '$return_url';</script>";
        exit;
    }
}
?>