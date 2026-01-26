<?php
// =============================================
// Author: <KWON SUNG KUN - sealclear@naver.com>
// Create date: <23.07.21>
// Description: <경비실 당숙일지>
// Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
// =============================================

// ★ DB연결 및 공통 함수 포함
require_once __DIR__ . '/../session/session_check.php';
include_once __DIR__ . '/../DB/DB2.php';
include_once __DIR__ . '/../DB/DB4.php';
include_once __DIR__ . '/../FUNCTION.php';

// ★ 변수 안전하게 받기
// GET 파라미터
$tab_get = $_GET["tab"] ?? null;
$modi = $_GET["modi"] ?? null;
$nfc = $_GET["nfc"] ?? null;
$nfc_area = $_GET["area"] ?? null;
$nfc_key = $_GET["key"] ?? null;

// POST 파라미터
$bt21 = $_POST["bt21"] ?? null; // 당숙일지 입력
$bt31 = $_POST["bt31"] ?? null; // 순찰 조치사항 입력
$bt41 = $_POST["bt41"] ?? null; // 방문자 입력
$bt42 = $_POST["bt42"] ?? null; // 방문자 수정
$bt51 = $_POST["bt51"] ?? null; // 방문자 조회

// 날짜 변수
$Hyphen_today = date("Y-m-d");
$Minus1Day = date("Y-m-d", strtotime("-1 day"));
$check_date = (date("H:i:s") >= '00:00:00' && date("H:i:s") <= '08:00:00') ? $Minus1Day : $Hyphen_today;

// ★ 탭 활성화 로직
$tab_sequence = 2; // 기본 탭
if ($tab_get) $tab_sequence = (int)$tab_get;
if ($bt31) $tab_sequence = 3;
if ($nfc) $tab_sequence = 3;
if ($bt41 || $bt42 || $modi) $tab_sequence = 4;
if ($bt51) $tab_sequence = 5;
include_once '../TAB.php';

// --- 로직 처리 ---

// [탭2] 당숙일지 입력/수정
if ($bt21 === "on") {
    $fields = [
        'guard' => $_POST["guard"] ?? '', 'vip11' => $_POST["vip11"] ?? '', 'vip12' => $_POST["vip12"] ?? '',
        'vip21' => $_POST["vip21"] ?? '', 'vip22' => $_POST["vip22"] ?? '', 'vip31' => $_POST["vip31"] ?? '',
        'vip32' => $_POST["vip32"] ?? '', 'week11' => $_POST["week11"] ?? '', 'week12' => $_POST["week12"] ?? '',
        'week21' => $_POST["week21"] ?? '', 'week22' => $_POST["week22"] ?? '', 'week31' => $_POST["week31"] ?? '',
        'week32' => $_POST["week32"] ?? '', 'week41' => $_POST["week41"] ?? '', 'week42' => $_POST["week42"] ?? '',
        'car1' => $_POST["car1"] ?? '', 'note' => $_POST["note"] ?? ''
    ];

    $chk_query = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.GUARD WHERE SORTING_DATE = ?";
    $stmt = sqlsrv_query($connect, $chk_query, [$Hyphen_today]);
    $row = sqlsrv_fetch_array($stmt);

    if ($row['cnt'] > 0) {
        $sql = "UPDATE CONNECT.dbo.GUARD SET GUARD=?, VIP1=?, VIP1_TIME=?, VIP2=?, VIP2_TIME=?, VIP3=?, VIP3_TIME=?,
                HOLIDAY1=?, HOLIDAY1_TIME=?, HOLIDAY2=?, HOLIDAY2_TIME=?, HOLIDAY3=?, HOLIDAY3_TIME=?, HOLIDAY4=?, HOLIDAY4_TIME=?,
                COMPANY_CAR=?, NOTE=? WHERE SORTING_DATE=?";
        $params = array_values($fields);
        $params[] = $Hyphen_today;
    } else {
        $sql = "INSERT INTO CONNECT.dbo.GUARD (GUARD, VIP1, VIP1_TIME, VIP2, VIP2_TIME, VIP3, VIP3_TIME,
                HOLIDAY1, HOLIDAY1_TIME, HOLIDAY2, HOLIDAY2_TIME, HOLIDAY3, HOLIDAY3_TIME, HOLIDAY4, HOLIDAY4_TIME, COMPANY_CAR, NOTE, SORTING_DATE)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = array_values($fields);
        $params[] = $Hyphen_today;
    }
    if(sqlsrv_query($connect, $sql, $params)) {
        echo "<script>alert('저장되었습니다.'); location.href='guard.php?tab=2';</script>";
    }
}

// [탭3] NFC 순찰 기록
if ($nfc === "on") {
    if ($nfc_key === '6218132365') {
        $allowed_nfc = range(1, 13);
        $nfc_num = filter_var($nfc_area, FILTER_SANITIZE_NUMBER_INT);

        if (in_array($nfc_num, $allowed_nfc)) {
            $is_morning_patrol = (date("H:i:s") >= '00:00:00' && date("H:i:s") <= '08:00:00');
            $target_date = $is_morning_patrol ? $Minus1Day : $Hyphen_today;
            $time_column = $is_morning_patrol ? "NFC{$nfc_num}_TIME2" : "NFC{$nfc_num}_TIME1";
            $flag_column = $is_morning_patrol ? null : "NFC{$nfc_num}";

            $chk_query = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.DUTY2 WHERE SORTING_DATE = ?";
            $stmt = sqlsrv_query($connect, $chk_query, [$target_date]);
            $row = sqlsrv_fetch_array($stmt);

            if ($row['cnt'] > 0) {
                $sql = "UPDATE CONNECT.dbo.DUTY2 SET {$time_column} = GETDATE()" . ($flag_column ? ", {$flag_column} = 'on'" : "") . " WHERE SORTING_DATE = ?";
                sqlsrv_query($connect, $sql, [$target_date]);
            } else {
                $sql = "INSERT INTO CONNECT.dbo.DUTY2 (SORTING_DATE, {$time_column}" . ($flag_column ? ", {$flag_column}" : "") . ") VALUES (?, GETDATE()" . ($flag_column ? ", 'on'" : "") . ")";
                sqlsrv_query($connect, $sql, [$target_date]);
            }
            echo "<script>alert('NFC 태그가 기록되었습니다.'); location.href='guard.php?tab=3';</script>";
        } else {
            echo "<script>alert('유효하지 않은 NFC 영역입니다.'); location.href='guard.php?tab=3';</script>";
        }
    } else {
        echo "<script>alert('키값이 틀렸습니다!'); location.href='guard.php?tab=3';</script>";
    }
}

// [탭3] 순찰 조치사항 입력
if ($bt31 === "on") {
    $note31 = $_POST["note31"] ?? '';
    $chk_query = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.DUTY2 WHERE SORTING_DATE = ?";
    $stmt = sqlsrv_query($connect, $chk_query, [$check_date]);
    $row = sqlsrv_fetch_array($stmt);

    if ($row['cnt'] > 0) {
        $sql = "UPDATE CONNECT.dbo.DUTY2 SET NOTE = ? WHERE SORTING_DATE = ?";
    } else {
        $sql = "INSERT INTO CONNECT.dbo.DUTY2 (NOTE, SORTING_DATE) VALUES (?, ?)";
    }
    if(sqlsrv_query($connect, $sql, [$note31, $check_date])) {
        echo "<script>alert('저장되었습니다.'); location.href='guard.php?tab=3';</script>";
    }
}

// [탭4] 방문자 입력
if ($bt41 === "on") {
    $name41 = isset($_POST['name41']) ? trim($_POST['name41']) : '';
    $purpose41 = isset($_POST['purpose41']) ? trim($_POST['purpose41']) : '';
    $time41 = isset($_POST['time41']) ? trim($_POST['time41']) : '';

    if (empty($name41) || empty($purpose41) || empty($time41)) {
        echo "<script>alert('업체명, 방문목적, 방문시간을 모두 입력해주세요.'); location.href='guard.php?tab=4';</script>";
    } else {
        $sql = "INSERT INTO CONNECT.dbo.GUEST(NAME, PURPOSE, DT, SORTING_DATE) VALUES(?, ?, ?, ?)";
        $params = [$name41, $purpose41, $time41, $Hyphen_today];
        if(sqlsrv_query($connect, $sql, $params)) {
            echo "<script>alert('저장되었습니다.'); location.href='guard.php?tab=4';</script>";
        }
    }
}

// [탭4] 방문자 수정
if ($bt42 === "on") {
    $limit = $_POST["until"] ?? 0;
    for ($i = 1; $i <= $limit; $i++) {
        $no = $_POST["NO{$i}"] ?? null;
        $name = $_POST["NAME{$i}"] ?? null;
        $purpose = $_POST["PURPOSE{$i}"] ?? null;
        $dt = $_POST["DT{$i}"] ?? null;

        if ($no && $name) { // 이름이 비어있지 않고, NO가 있는 경우만 업데이트
            $sql = "UPDATE CONNECT.dbo.GUEST SET NAME = ?, PURPOSE = ?, DT = ? WHERE NO = ?";
            sqlsrv_query($connect, $sql, [$name, $purpose, $dt, $no]);
        }
    }
    // 수정 모드 해제
    sqlsrv_query($connect, "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='Guard'");
    echo "<script>alert('저장되었습니다.'); location.href='guard.php?tab=4';</script>";
}

// [탭4] 수정 모드 진입
if ($modi === 'Y') {
    $stmt = sqlsrv_query($connect, "SELECT LOCK FROM CONNECT.dbo.USE_CONDITION WHERE KIND='Guard'");
    $row = sqlsrv_fetch_array($stmt);
    if ($row && $row['LOCK'] === 'N') {
        $sql = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO=?, LAST_DT=? WHERE KIND='Guard'";
        sqlsrv_query($connect, $sql, [$_SERVER['REMOTE_ADDR'], date("Y-m-d H:i:s")]);
    } else {
        echo "<script>alert('다른 사람이 수정중 입니다!'); location.href='guard.php?tab=4';</script>";
    }
}

// --- 데이터 조회 ---

// [탭2] 당숙일지 데이터 조회
$Result_Guard = sqlsrv_query($connect, "SELECT * FROM CONNECT.dbo.GUARD WHERE SORTING_DATE = ?", [$Hyphen_today]);
$Data_Guard = sqlsrv_fetch_array($Result_Guard, SQLSRV_FETCH_ASSOC);

// [탭3] 순찰 데이터 조회
$Result_TodayCheckList = sqlsrv_query($connect, "SELECT * FROM CONNECT.dbo.DUTY2 WHERE SORTING_DATE = ?", [$check_date]);
$Data_TodayCheckList = sqlsrv_fetch_array($Result_TodayCheckList, SQLSRV_FETCH_ASSOC);

// [탭4] 금일 방문자 조회
$Result_GuestToday = sqlsrv_query($connect, "SELECT * FROM CONNECT.dbo.GUEST WHERE SORTING_DATE = ? ORDER BY NO DESC", [$Hyphen_today]);

// [탭5] 방문자 내역 조회
$Result_GuestChk = null;
if ($bt51 === "on") {
    $s_dt5 = $_POST["dt5"] ? substr($_POST["dt5"], 0, 10) : date("Y-m-d");
    $e_dt5 = $_POST["dt5"] ? substr($_POST["dt5"], 13, 10) : date("Y-m-d");
    $sql = "SELECT * FROM CONNECT.dbo.GUEST WHERE SORTING_DATE BETWEEN ? AND ? ORDER BY NO DESC";
    $Result_GuestChk = sqlsrv_query($connect, $sql, [$s_dt5, $e_dt5]);
}
?>