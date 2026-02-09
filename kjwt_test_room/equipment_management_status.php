<?php
// =============================================
// Author: Gemini AI
// Description: 장비 관리 시스템 백엔드 (대시보드 및 리스트)
// =============================================
include '../FUNCTION.php';
include '../DB/DB2.php';

// 1. 대시보드 카운트 조회
$counts = ['total' => 0, 'need_inspect' => 0, 'out' => 0, 'in' => 0];
$sql_count = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN DATEDIFF(day, RECORD_DATE, GETDATE()) > 365 THEN 1 ELSE 0 END) as need_inspect,
    SUM(CASE WHEN OUT_DATE > IN_DATE THEN 1 ELSE 0 END) as out_count,
    SUM(CASE WHEN IN_DATE > OUT_DATE THEN 1 ELSE 0 END) as in_count
FROM CONNECT.dbo.TEST_ROOM_EQUIPMENT2";

$stmt_count = sqlsrv_query($connect, $sql_count);
if ($stmt_count && $row_c = sqlsrv_fetch_array($stmt_count, SQLSRV_FETCH_ASSOC)) {
    $counts['total'] = $row_c['total'] ?? 0;
    $counts['need_inspect'] = $row_c['need_inspect'] ?? 0;
    $counts['out'] = $row_c['out_count'] ?? 0;
    $counts['in'] = $row_c['in_count'] ?? 0;
}

// 2. 대시보드 최근 이력 TOP 7 조회 (수정됨: TOP 5 -> TOP 7)
$dashboard_history = [];
$sql_hist_top = "
    SELECT TOP 8 
        H.RECORD_DATE, 
        E.EQUIPMENT_NAME, 
        H.REASON, 
        H.RECORDER
    FROM CONNECT.dbo.TEST_ROOM_EQUIPMENT2_HISTORY H
    LEFT JOIN CONNECT.dbo.TEST_ROOM_EQUIPMENT2 E ON H.EQUIPMENT_NUM = E.EQUIPMENT_NUM
    ORDER BY H.RECORD_DATE DESC";
$stmt_hist = sqlsrv_query($connect, $sql_hist_top);
if ($stmt_hist) {
    while ($row = sqlsrv_fetch_array($stmt_hist, SQLSRV_FETCH_ASSOC)) {
        $dashboard_history[] = $row;
    }
}

// 3. 장비 대장 리스트 필터링 로직
$filter = $_GET['filter'] ?? 'all';
$where = "";
if ($filter == 'inspect') $where = " WHERE DATEDIFF(day, RECORD_DATE, GETDATE()) > 365 ";
else if ($filter == 'out') $where = " WHERE OUT_DATE > IN_DATE ";
else if ($filter == 'in') $where = " WHERE IN_DATE > OUT_DATE ";

$search_results_tab7 = [];
$sql_main = "SELECT * FROM CONNECT.dbo.TEST_ROOM_EQUIPMENT2" . $where . " ORDER BY CAST(EQUIPMENT_NUM AS INT) ASC";
$stmt_main = sqlsrv_query($connect, $sql_main);
if ($stmt_main) {
    while ($row = sqlsrv_fetch_array($stmt_main, SQLSRV_FETCH_ASSOC)) {
        $search_results_tab7[] = $row;
    }
}

// 4. [AJAX] 상세 이력 모달 데이터
if (isset($_POST['ajax_history']) && $_POST['ajax_history'] == 'yes') {
    $eq_num = $_POST['eq_num'];
    $sql_modal = "SELECT * FROM CONNECT.dbo.TEST_ROOM_EQUIPMENT2_HISTORY WHERE EQUIPMENT_NUM = ? ORDER BY RECORD_DATE DESC";
    $stmt_modal = sqlsrv_query($connect, $sql_modal, array($eq_num));
    $response = "";
    if ($stmt_modal) {
        while ($row = sqlsrv_fetch_array($stmt_modal, SQLSRV_FETCH_ASSOC)) {
            $in_d = ($row['IN_DATE'] instanceof DateTime) ? date_format($row['IN_DATE'], "Y-m-d") : "-";
            $rec_d = ($row['RECORD_DATE'] instanceof DateTime) ? date_format($row['RECORD_DATE'], "Y-m-d") : "-";
            $response .= "<tr><td class='text-center'>{$in_d}</td><td>".htmlspecialchars($row['REASON'])."</td><td class='text-center'>-</td><td class='text-center'>{$row['RECORDER']}</td><td class='text-center'>{$rec_d}</td></tr>";
        }
    }
    echo $response ?: "<tr><td colspan='5' class='text-center'>데이터가 없습니다.</td></tr>";
    exit;
}
?>