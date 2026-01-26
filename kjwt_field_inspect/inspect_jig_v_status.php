<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.23>
	// Description:	<베트남 지그 리뉴얼 백엔드>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';   
    

    //메뉴 진입 시 탭활성화 start
    $tab2 = 'active';
    $tab3 = '';
    $tab2_text = 'show active';
    $tab3_text = '';
    //메뉴 진입 시 탭활성화 end   

    //변수모음 start 
    $s_date = date("Ymd");
    $bt_modify = $_POST["bt_modify"] ?? null; //수정 버튼

    //탭3  
    $dt3 = $_POST["dt3"] ?? '';	
    $s_dt3 = str_replace("-","",substr($dt3, 0, 10));		
	$e_dt3 = str_replace("-","",substr($dt3, 13, 10));
    $bt31 = $_POST["bt31"] ?? null;         //버튼 클릭 시  
    //변수모음 end

    // 수정 버튼 클릭 시 실행
    if ($bt_modify == "on") {
        $JIG_ID_mod = $_POST["NM1"] ?? null;
        $JIG_SEQ_mod = $_POST["NM2"] ?? null;
        $CURRENT_QTY_mod = $_POST["QTY2"] ?? 0;
        $TOTAL_QTY_mod = $_POST["QTY3"] ?? 0;
        $JUDGMENT_mod = $_POST["JUDGMENT"] ?? null;
        $DT_mod = $_POST["DT"] ?? null;
        $NOTE_mod = $_POST["NOTE"] ?? null;
        
        $USAGE_COUNT_mod = $CURRENT_QTY_mod + $TOTAL_QTY_mod;
        $c_date_mod = date("Ymd", strtotime($DT_mod));

        if ($JUDGMENT_mod == 'CHECK') {
            $record_query = "INSERT INTO QIS.dbo.M_LOG_JIG(JIG_ID, JIG_SEQ, USAGE_COUNT, JUDGMENT, NOTE, UPDT_USER_ID, UPDT_DT, INSERT_DT) VALUES(?, ?, ?, 'CHECK', ?, ?, ?, ?)";
            $record_params = array($JIG_ID_mod, $JIG_SEQ_mod, $USAGE_COUNT_mod, $NOTE_mod, $session_row->id, $c_date_mod, $s_date);
            sqlsrv_query($connect, $record_query, $record_params);

            $update_query = "UPDATE QIS.dbo.M_JIG_INFO SET CURRENT_QTY='0', TOTAL_QTY=?, LAST_UPDATE_USER=?, LAST_UPDATE_DATE=? WHERE JIG_ID=? AND JIG_SEQ=?";
            $update_params = array($USAGE_COUNT_mod, $session_row->id, $s_date, $JIG_ID_mod, $JIG_SEQ_mod);
            sqlsrv_query($connect, $update_query, $update_params);
        } else { // Assumes 'CHANGE'
            $record_query = "INSERT INTO QIS.dbo.M_LOG_JIG(JIG_ID, JIG_SEQ, USAGE_COUNT, JUDGMENT, NOTE, UPDT_USER_ID, UPDT_DT, INSERT_DT) VALUES(?, ?, ?, 'CHANGE', ?, ?, ?, ?)";
            $record_params = array($JIG_ID_mod, $JIG_SEQ_mod, $USAGE_COUNT_mod, $NOTE_mod, $session_row->id, $c_date_mod, $s_date);
            sqlsrv_query($connect, $record_query, $record_params);

            $update_query = "UPDATE QIS.dbo.M_JIG_INFO SET CURRENT_QTY='0', TOTAL_QTY='0', LAST_UPDATE_USER=?, LAST_UPDATE_DATE=? WHERE JIG_ID=? AND JIG_SEQ=?";
            $update_params = array($session_row->id, $s_date, $JIG_ID_mod, $JIG_SEQ_mod);
            sqlsrv_query($connect, $update_query, $update_params);
        }

        echo "<script>alert('HOÀN THÀNH!');location.href='inspect_jig_v.php';</script>";
        exit;
    }
    
    //활성화 탭 변경 start   
    IF($bt31=="on") {
        $tab2 = '';
        $tab3 = 'active';
        $tab2_text = '';
        $tab3_text = 'show active';

        $query_out = "select * from QIS.dbo.M_LOG_JIG WHERE (UPDT_DT between ? and ?) and (JIG_ID LIKE 'V%' OR JIG_SEQ LIKE 'V%') ORDER BY INSERT_DT DESC";
        $params_out = array($s_dt3, $e_dt3);
        $result_out = sqlsrv_query($connect, $query_out, $params_out, $options);
    } 
    //활성화 탭 변경 end  

   
    //메뉴 입장 시 실행 start
    //지그현황
    $query = "select * from QIS.dbo.M_JIG_INFO where JIG_ID LIKE 'V%' OR JIG_SEQ LIKE 'V%'";              
    $result = sqlsrv_query($connect, $query, $params, $options);
    
    //지그점검필요
    $q_JigInspectNeed = "select COUNT(*) as count from QIS.dbo.M_JIG_INFO where CURRENT_QTY>=LIMIT_QTY and (JIG_ID LIKE 'V%' OR JIG_SEQ LIKE 'V%')";
    $r_JigInspectNeed = sqlsrv_query($connect, $q_JigInspectNeed, $params, $options);
    $d_JigInspectNeed = sqlsrv_fetch_array($r_JigInspectNeed);
    $c_JigInspectNeed = $d_JigInspectNeed['count'];

    //지그점검도래
    $q_JigInspectSoon = "select COUNT(*) as count from QIS.dbo.M_JIG_INFO where CURRENT_QTY>=LIMIT_QTY*0.8 and (JIG_ID LIKE 'V%' OR JIG_SEQ LIKE 'V%')";
    $r_JigInspectSoon = sqlsrv_query($connect, $q_JigInspectSoon, $params, $options);
    $d_JigInspectSoon = sqlsrv_fetch_array($r_JigInspectSoon);
    $c_JigInspectSoon = $d_JigInspectSoon['count'];
    //메뉴 입장 시 실행 end
?>