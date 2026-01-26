<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.01.11>
	// Description:	<검교정>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';   
    include_once __DIR__ . '/../FUNCTION.php';
    include_once __DIR__ . '/../DB/DB2.php'; 

    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php';     

    //★변수모음 (Null 병합 연산자로 안전하게 초기화)
    //pop
    $no = $_GET['no'] ?? null;
    $flag = $_GET['flag'] ?? null;
    $registerno = $_GET['registerno'] ?? null;
    $switch = $_GET['switch'] ?? null;
    $switch1 = $_GET['switch1'] ?? null;
    $switch2 = $_GET['switch2'] ?? null;
    $switch3 = $_GET['switch3'] ?? null;
    $switch4 = $_GET['switch4'] ?? null;

    //탭2
    $kind20 = $_POST['kind20'] ?? null;
    $name20 = $_POST['name20'] ?? null;
    $number20 = $_POST['number20'] ?? null;
    $buy20 = $_POST['buy20'] ?? null;
    $model20 = $_POST['model20'] ?? null;
    $department20 = $_POST['department20'] ?? null;
    $team20 = $_POST['team20'] ?? null;
    $location20 = $_POST['location20'] ?? null;
    $share20 = $_POST['share20'] ?? null;
    $note20 = $_POST['note20'] ?? null;
    $bt20 = $_POST['bt20'] ?? null;
    $QR23 = $_POST['QR23'] ?? null;
    $bt23 = $_POST['bt23'] ?? null;

    //탭4
    $dt4 = $_POST['dt4'] ?? null;
    $s_dt4 = $dt4 ? substr($dt4, 0, 10) : null;
	$e_dt4 = $dt4 ? substr($dt4, 13, 10) : null;
    $bt41 = $_POST["bt41"] ?? null;

    // 연속검사 스위치 리디렉션
    if ($no) {
        $redirect_url = null;
        if ($switch1 === '1') {
            $redirect_url = "calibration.php?switch=1&registerno=" . urlencode($no) . "&flag=inspect";
        } elseif ($switch2 === '1') {
            $redirect_url = "calibration.php?switch=2&registerno=" . urlencode($no) . "&flag=in";
        } elseif ($switch3 === '1') {
            $redirect_url = "calibration.php?switch=3&registerno=" . urlencode($no) . "&flag=out";
        } elseif ($switch4 === '1') {
            $redirect_url = "calibration.php?switch=4&registerno=" . urlencode($no) . "&flag=check";
        }
        if ($redirect_url) {
            // develop.iwin.kr은 하드코딩되어 있어, 현재 서버 경로 기준으로 변경
            echo "<script>location.href='" . $redirect_url . "';</script>";
            exit;
        }
    }

    //★ 플래그 기반 동작 처리 (매개변수화된 쿼리 적용)
    if ($flag && $registerno) {
        if ($flag === 'check') {
            $Query_checkInspect = "SELECT INSPECT, OUT_YN FROM CALIBRATION WHERE REGISTER_NO = ?";
            $Result_checkInspect = sqlsrv_query($connect, $Query_checkInspect, [$registerno]);
            $row = $Result_checkInspect ? sqlsrv_fetch_array($Result_checkInspect) : null;
            
            if (!$row) {
                echo "<script>alert('유효하지 않은 등록번호입니다.'); history.back();</script>";
                exit;
            }
            if ($row['INSPECT'] !== 'Y') {
                echo "<script>alert('검사가 완료되지 않았습니다. 먼저 검사를 진행해주세요.'); history.back();</script>";
                exit;
            }
            if ($row['OUT_YN'] !== 'IN') {
                echo "<script>alert('반입이 되지 않았습니다. 먼저 반입을 진행해주세요.'); history.back();</script>";
                exit;
            }
            $Query_calibrationUpdate = "UPDATE CALIBRATION SET JUDGMENT='Y' WHERE REGISTER_NO = ?";
            sqlsrv_query($connect, $Query_calibrationUpdate, [$registerno]);

        } elseif ($flag === 'in') {
            $Query_calibrationUpdate = "UPDATE CALIBRATION SET OUT_YN='IN' WHERE REGISTER_NO = ?";
            sqlsrv_query($connect, $Query_calibrationUpdate, [$registerno]);

        } elseif ($flag === 'out') {
            $Query_calibrationUpdate = "UPDATE CALIBRATION SET OUT_YN='OUT' WHERE REGISTER_NO = ?";
            sqlsrv_query($connect, $Query_calibrationUpdate, [$registerno]);

        } elseif ($flag === 'inspect') {
            $Query_calibrationUpdate = "UPDATE CALIBRATION SET INSPECT='Y', DT = ? WHERE REGISTER_NO = ?";
            sqlsrv_query($connect, $Query_calibrationUpdate, [$Hyphen_today, $registerno]);
            
            $Query_historyInsert = "INSERT INTO CALIBRATION_HISTORY (REGISTER_NO, DT) VALUES (?, ?)";
            sqlsrv_query($connect, $Query_historyInsert, [$registerno, $Hyphen_today]);
        }
        // 연속검사 스위치가 켜져있으면 원래 페이지로 리디렉션
        if ($switch) {
            header("Location: calibration.php?switch=" . urlencode($switch));
            exit;
        }
    }

    //★ 버튼 기반 동작 처리
    if ($bt20 === 'on') {
        $Query_lastRegisterNo = "SELECT MAX(REGISTER_NO) as last_no FROM CALIBRATION";
        $Result_lastRegisterNo = sqlsrv_query($connect, $Query_lastRegisterNo);
        $row = $Result_lastRegisterNo ? sqlsrv_fetch_array($Result_lastRegisterNo) : ['last_no' => 0];
        $next_register_no = ($row['last_no'] ?? 0) + 1;

        $Query_calibrationInsert = "INSERT INTO CALIBRATION (REGISTER_NO, KIND, NAME, NUMBER, BUY, STANDARD, MANAGER, APPLY_TEAM, APPLY_LOCATION, SHARE, NOTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$next_register_no, $kind20, $name20, $number20, $buy20, $model20, $department20, $team20, $location20, $share20, $note20];
        sqlsrv_query($connect, $Query_calibrationInsert, $params);

    } elseif ($bt41 === 'on') {
        $tab_sequence = 4;
        include __DIR__ . '/../TAB.php';

        $Query_Select = "SELECT CH.DT as HISTORY_DT, C.* FROM CONNECT.dbo.CALIBRATION_HISTORY CH INNER JOIN CONNECT.dbo.CALIBRATION C ON CH.REGISTER_NO = C.REGISTER_NO WHERE CH.DT BETWEEN ? AND ?";
        $Result_Select = sqlsrv_query($connect, $Query_Select, [$s_dt4, $e_dt4]);
        $Count_Select = $Result_Select ? sqlsrv_num_rows($Result_Select) : 0;
    }

    //★ 기본 데이터 조회
    // 전체 수량 계산 (sqlsrv_num_rows는 기본 forward 커서에서 동작하지 않으므로 COUNT(*) 쿼리 사용)
    $Query_count = "SELECT COUNT(*) FROM CALIBRATION";
    $Result_count = sqlsrv_query($connect, $Query_count);
    $Count_calibration = 0;
    if ($Result_count && sqlsrv_fetch($Result_count)) {
        $Count_calibration = sqlsrv_get_field($Result_count, 0);
    }

    // 목록 데이터 조회
    $Query_calibration = "SELECT c.*, DATEADD(year, 1, ch.DT) as NewDate, ch.DT as LastCalibrationDate FROM CALIBRATION c LEFT JOIN (SELECT REGISTER_NO, MAX(DT) as DT FROM CALIBRATION_HISTORY GROUP BY REGISTER_NO) ch ON c.REGISTER_NO = ch.REGISTER_NO";
    $Result_calibration = sqlsrv_query($connect, $Query_calibration);

    $Query_calibrationJudege = "SELECT COUNT(*) FROM CALIBRATION WHERE INSPECT='Y'";
    $Result_calibrationJudege = sqlsrv_query($connect, $Query_calibrationJudege);
    $Count_calibrationJudege = 0;
    if ($Result_calibrationJudege && sqlsrv_fetch($Result_calibrationJudege)) {
        $Count_calibrationJudege = sqlsrv_get_field($Result_calibrationJudege, 0);
    }

    $Query_CheckTitle = "SELECT REGISTER_NO, NAME, NUMBER FROM CONNECT.dbo.CALIBRATION ORDER BY REGISTER_NO";
    $Result_CheckTitle = sqlsrv_query($connect, $Query_CheckTitle);
    $title = [];
    if ($Result_CheckTitle) {
        while ($row = sqlsrv_fetch_array($Result_CheckTitle, SQLSRV_FETCH_ASSOC)) {
            $title[] = $row;
        }
    }
?>