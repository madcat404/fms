<?php
session_start();
include 'db_connect.php'; // DB 연결 파일

$user_id = $_SESSION['user_id'];
$selected_menus = $_POST['menus'] ?? []; // 체크된 메뉴 코드 배열

if (!$user_id) { die("로그인이 필요합니다."); }

// 트랜잭션 시작 (권장)
sqlsrv_begin_transaction($conn);

try {
    // 1. 기존 설정 삭제 (초기화)
    $sql_del = "DELETE FROM TB_USER_MENU_SETTING WHERE user_id = ?";
    $stmt_del = sqlsrv_prepare($conn, $sql_del, array(&$user_id));
    if (!sqlsrv_execute($stmt_del)) throw new Exception("삭제 실패");

    // 2. 선택된 메뉴 새로 입력
    if (!empty($selected_menus)) {
        foreach ($selected_menus as $code) {
            $sql_ins = "INSERT INTO TB_USER_MENU_SETTING (user_id, menu_code, is_visible) VALUES (?, ?, 'Y')";
            $stmt_ins = sqlsrv_prepare($conn, $sql_ins, array(&$user_id, &$code));
            if (!sqlsrv_execute($stmt_ins)) throw new Exception("저장 실패: " . $code);
        }
    }

    sqlsrv_commit($conn);
    
    // 처리가 끝나면 다시 설정 페이지로 이동
    echo "<script>alert('메뉴 설정이 저장되었습니다.'); location.href='my_page.php';</script>";

} catch (Exception $e) {
    sqlsrv_rollback($conn);
    echo "오류 발생: " . $e->getMessage();
}
?>