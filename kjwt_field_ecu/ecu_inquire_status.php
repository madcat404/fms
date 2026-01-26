<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.10.21>
	// Description:	<ecu 조회 백엔드>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Data Integrity
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB21.php'; 
    include_once __DIR__ . '/../FUNCTION.php';  

    //메뉴 진입 시 탭활성화 start
    $tab = $_GET["tab"] ?? '';
    
    if($tab=='out') {
        $tab_sequence=4; 
    }
    elseif($tab=='in') {
        $tab_sequence=3; 
    }
    elseif($tab=='reg') {
        $tab_sequence=5; 
    }
    elseif($tab=='del') {
        $tab_sequence=6; 
    }
    else {
        $tab_sequence=2; 
    }    
    include '../TAB.php'; 
    //메뉴 진입 시 탭활성화 end
    
    //변수모음 start   
    $init = "2021-01-01";

    // FOR WAIT SCREEN
    $dt2 = $_GET["dt2"] ?? $_POST["dt2"] ?? null;
    $bt21 = $_GET["bt21"] ?? $_POST["bt21"] ?? null;

    //탭2   
    $s_dt2 = $dt2 ? substr($dt2, 0, 10) : null;
	$e_dt2 = $dt2 ? substr($dt2, 13, 10) : null;
    $limit2_days = 0;
    if ($s_dt2 && $e_dt2) {
        $ns_dt2 = date_create($s_dt2);
        $ne_dt2 = date_create($e_dt2);
        if ($ns_dt2 && $ne_dt2) {
            $limit2 = date_diff($ns_dt2, $ne_dt2);
            $limit2_days = $limit2->days;
        }
    }
    $y_dt2 = $s_dt2 ? date("Y-m-d", strtotime($s_dt2.'- 1 days')) : null;

    //탭3   
    $dt3 = $_POST["dt3"] ?? null;
    $s_dt3 = $dt3 ? substr($dt3, 0, 10) : null;
	$e_dt3 = $dt3 ? substr($dt3, 13, 10) : null;
    $limit3_days = 0;
    if ($s_dt3 && $e_dt3) {
        $ns_dt3 = date_create($s_dt3);
        $ne_dt3 = date_create($e_dt3);
        if ($ns_dt3 && $ne_dt3) {
            $limit3 = date_diff($ns_dt3, $ne_dt3);
            $limit3_days = $limit3->days;
        }
    }
    $bt31 = $_POST["bt31"] ?? null;

    //탭4 
    $dt4 = $_POST["dt4"] ?? null;
    $s_dt4 = $dt4 ? substr($dt4, 0, 10) : null;
	$e_dt4 = $dt4 ? substr($dt4, 13, 10) : null;
    $limit4_days = 0;
    if ($s_dt4 && $e_dt4) {
        $ns_dt4 = date_create($s_dt4);
        $ne_dt4 = date_create($e_dt4);
        if ($ns_dt4 && $ne_dt4) {
            $limit4 = date_diff($ns_dt4, $ne_dt4);
            $limit4_days = $limit4->days;
        }
    }
    $bt41 = $_POST["bt41"] ?? null;

    //탭5 
    $item51 = $_POST["item51"] ?? null;
    $item52 = $_POST["item52"] ?? null;
    $kind = $_POST["cb"] ?? null;
    $bt51 = $_POST["bt51"] ?? null;
    $bt52 = $_POST["bt52"] ?? null;

    //탭6
    $dt6 = $_POST["dt6"] ?? null;
    $s_dt6 = $dt6 ? substr($dt6, 0, 10) : null;
	$e_dt6 = $dt6 ? substr($dt6, 13, 10) : null;
    $limit6_days = 0;
    if ($s_dt6 && $e_dt6) {
        $ns_dt6 = date_create($s_dt6);
        $ne_dt6 = date_create($e_dt6);
        if ($ns_dt6 && $ne_dt6) {
            $limit6 = date_diff($ns_dt6, $ne_dt6);
            $limit6_days = $limit6->days;
        }
    }
    $bt61 = $_POST["bt61"] ?? null;
    //변수모음 end

    // Function to fetch all results into an array to prevent cursor conflicts
    function fetch_all_results($conn, $sql, $params = []) {
        $stmt = sqlsrv_query($conn, $sql, $params);
        $results = [];
        if ($stmt) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $results[] = $row;
            }
        }
        return $results;
    }

    //활성화 탭 변경 start   
    //수불부
    IF($bt21=="on") {
        $tab_sequence=2; 
        include '../TAB.php'; 
        
        if($limit2_days > 180) {
            echo "<script>alert(\"180일 초과하여 검색할 수 없습니다!\");history.back();</script>";
        }
        elseif($s_dt2 > $e_dt2) {
            echo "<script>alert(\"종료일이 시작일보다 큽니다!\");history.back();</script>";  
        }
        else {
            $storage_data_array = fetch_all_results($connect21, "SELECT * FROM CONNECT.dbo.ECU_STORAGE WHERE YYYY>='2022' ORDER BY KIND, CAR_NM, CD_ITEM DESC");

            $query_storage2 = "SELECT SUM(START_QT) AS START_QT FROM CONNECT.dbo.ECU_STORAGE WHERE YYYY>='2022'";
            $result_storage2 = sqlsrv_query($connect21, $query_storage2);
            $row_storage2 = sqlsrv_fetch_array($result_storage2, SQLSRV_FETCH_ASSOC);

            $query_basicT = "SELECT SUM(b.QT_GOODS) AS PCS FROM connect.dbo.ECU_STORAGE a LEFT JOIN connect.dbo.ECU_INPUT_LOG b ON a.CD_ITEM=b.CD_ITEM WHERE a.YYYY >= '2022' AND (b.SORTING_DATE BETWEEN ? AND ?)";
            $result_basicT = sqlsrv_query($connect21, $query_basicT, [$init, $y_dt2]);
            $row_basicT = sqlsrv_fetch_array($result_basicT, SQLSRV_FETCH_ASSOC);

            $query_basic2T = "SELECT SUM(b.QT_GOODS) AS PCS FROM connect.dbo.ECU_STORAGE a LEFT JOIN connect.dbo.ECU_OUTPUT_LOG b ON a.CD_ITEM=b.CD_ITEM WHERE a.YYYY >= '2022' AND (b.SORTING_DATE BETWEEN ? AND ?)";
            $result_basic2T = sqlsrv_query($connect21, $query_basic2T, [$init, $y_dt2]);
            $row_basic2T = sqlsrv_fetch_array($result_basic2T, SQLSRV_FETCH_ASSOC);

            $query_inT = "SELECT SUM(QT_GOODS) AS PCS FROM CONNECT.dbo.ECU_INPUT_LOG WHERE (SORTING_DATE BETWEEN ? AND ?)";
            $result_inT = sqlsrv_query($connect21, $query_inT, [$s_dt2, $e_dt2]);
            $row_inT = sqlsrv_fetch_array($result_inT, SQLSRV_FETCH_ASSOC);

            $query_outT = "SELECT SUM(QT_GOODS) AS PCS FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE (SORTING_DATE BETWEEN ? AND ?)";
            $result_outT = sqlsrv_query($connect21, $query_outT, [$s_dt2, $e_dt2]);
            $row_outT = sqlsrv_fetch_array($result_outT, SQLSRV_FETCH_ASSOC);
        }
    } 
    //입고내역
    ELSEIF($bt31=="on") {
        $tab_sequence=3; 
        include '../TAB.php'; 

        if($limit3_days > 180) {
            echo "<script>alert(\"180일 초과하여 검색할 수 없습니다!\");history.back();</script>";
        }
        elseif($s_dt3 > $e_dt3) {
            echo "<script>alert(\"종료일이 시작일보다 큽니다!\");history.back();</script>";  
        }
        else {
            $qs_input_log = "SELECT CD_ITEM, LOT_DATE, NOTE, CONVERT(VARCHAR(10), SORTING_DATE, 120) AS SORTING_DATE, COUNT(CD_ITEM) AS BOX, SUM(QT_GOODS) AS PCS, LOCATION FROM CONNECT.dbo.ECU_INPUT_LOG WHERE SORTING_DATE BETWEEN ? AND ? GROUP BY CD_ITEM, LOT_DATE, NOTE, SORTING_DATE, LOCATION ORDER BY SORTING_DATE, CD_ITEM, LOT_DATE DESC";
            $input_log_data_array = fetch_all_results($connect21, $qs_input_log, [$s_dt3, $e_dt3]);
        }
    }
    //출고내역
    ELSEIF($bt41=="on") {
        $tab_sequence=4; 
        include '../TAB.php'; 

        if($limit4_days > 180) {
            echo "<script>alert(\"180일 초과하여 검색할 수 없습니다!\");history.back();</script>";
        }
        elseif($s_dt4 > $e_dt4) {
            echo "<script>alert(\"종료일이 시작일보다 큽니다!\");history.back();</script>";  
        }
        else {
            $qs_output_log = "SELECT CD_ITEM, LOT_DATE, NOTE, CONVERT(VARCHAR(10), SORTING_DATE, 120) AS SORTING_DATE, COUNT(CD_ITEM) AS BOX, SUM(QT_GOODS) AS PCS, LOCATION FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE SORTING_DATE BETWEEN ? AND ? GROUP BY CD_ITEM, LOT_DATE, NOTE, SORTING_DATE, LOCATION ORDER BY SORTING_DATE, CD_ITEM, LOT_DATE DESC";
            $output_log_data_array = fetch_all_results($connect21, $qs_output_log, [$s_dt4, $e_dt4]);
        }
    }
    //등록
    ELSEIF($bt51=="on") {
        $tab_sequence=5; 
        include '../TAB.php'; 

        $kind_val = ($kind == 'on') ? '내수' : '수출';

        $repeat_chk_query = "SELECT COUNT(*) as count FROM CONNECT.dbo.ECU_STORAGE WHERE KIND=? AND CD_ITEM=? AND YYYY>='2022'";
        $repeat_chk_result = sqlsrv_query($connect21, $repeat_chk_query, [$kind_val, $item51]);
        $repeat_chk_data = sqlsrv_fetch_array($repeat_chk_result, SQLSRV_FETCH_ASSOC);

        if($repeat_chk_data['count'] == 0) {
            $in_record_query = "INSERT INTO CONNECT.dbo.ECU_STORAGE(KIND, CAR_NM, CD_ITEM, YYYY, SALE_LOCAL) VALUES(?, '', ?, ?, ?)";
            sqlsrv_query($connect21, $in_record_query, [$kind_val, $item51, $YY, $item52]);
        }
    }
    //등록조회
    ELSEIF($bt52=="on") {
        $tab_sequence=5; 
        include '../TAB.php'; 

        $qs_register = "SELECT * FROM CONNECT.dbo.ECU_STORAGE WHERE YYYY=?";
        $register_data_array = fetch_all_results($connect21, $qs_register, [$YY]);
    }
    //삭제내역
    ELSEIF($bt61=="on") {
        $tab_sequence=6; 
        include '../TAB.php'; 

        if($limit6_days > 180) {
            echo "<script>alert(\"180일 초과하여 검색할 수 없습니다!\");history.back();</script>";
        }
        elseif($s_dt6 > $e_dt6) {
            echo "<script>alert(\"종료일이 시작일보다 큽니다!\");history.back();</script>";  
        }
        else {
            $Query_DeleteInput = "SELECT * FROM CONNECT.dbo.ECU_INPUT_DEL WHERE SORTING_DATE BETWEEN ? AND ?";
            $delete_input_data_array = fetch_all_results($connect21, $Query_DeleteInput, [$s_dt6, $e_dt6]);

            $Query_DeleteOutput = "SELECT * FROM CONNECT.dbo.ECU_OUTPUT_DEL WHERE SORTING_DATE BETWEEN ? AND ?";
            $delete_output_data_array = fetch_all_results($connect21, $Query_DeleteOutput, [$s_dt6, $e_dt6]);
        }
    }
    //활성화 탭 변경 end      
?>