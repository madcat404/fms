<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.23>
	// Description:	<지그 리뉴얼 백엔드>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    include 'inspect_session.php';  
    include '../DB/DB2.php';   
    
    $s_date = date("Ymd");

    //메뉴 진입 시 탭활성화 start
    $tab2 = 'active';
    $tab3 = '';
    $tab2_text = 'show active';
    $tab3_text = '';
    //메뉴 진입 시 탭활성화 end      
    
    //변수모음 start 
    //탭2  
    $item1 = $_POST["jigid21"] ?? null;	
    $item2 = $_POST["jignum21"] ?? null;
    $item3 = $_POST["val21"] ?? null;
    $bt21 = $_POST["bt21"] ?? null;         //버튼 클릭 시  

    //탭3  
    $dt3 = $_POST["dt3"] ?? null;	
    
    // 날짜 처리 (Notice 방지)
    if($dt3) {
        $s_dt3 = str_replace("-","",substr($dt3, 0, 10));		
        $e_dt3 = str_replace("-","",substr($dt3, 13, 10));
    } else {
        $s_dt3 = date("Ymd");
        $e_dt3 = date("Ymd");
    }

    $bt31 = $_POST["bt31"] ?? null;         //버튼 클릭 시  
    $bt_modify = $_POST["bt_modify"] ?? null; //수정 버튼
    //변수모음 end


    //활성화 탭 변경 start   
    IF($bt21=="on") {
        $tab2 = 'active';
        $tab3 = '';
        $tab2_text = 'show active';
        $tab3_text = '';

        //중복확인
        $chk_query = "select * from QIS.dbo.M_JIG_INFO WHERE JIG_ID=? AND JIG_SEQ=?";
        $chk_params = array($item1, $item2);
        $chk_result = sqlsrv_query($connect, $chk_query, $chk_params, $options);
        
        // sqlsrv_has_rows 체크
        $chk_num_result = ($chk_result) ? sqlsrv_has_rows($chk_result) : false;
        
        if($chk_num_result === false) {
            // [수정] $session_row->id -> $session_row->user_id
            $record_query = "INSERT INTO QIS.dbo.M_JIG_INFO(JIG_ID, JIG_SEQ, LIMIT_QTY, CURRENT_QTY, TOTAL_QTY, INSRT_USER_ID, INSRT_DT) VALUES(?, ?, ?, '0', '0', ?, ?)";
            $record_params = array($item1, $item2, $item3, $session_row->user_id, $s_date);
            sqlsrv_query($connect, $record_query, $record_params, $options);

            echo "<script>alert('완료 되었습니다!');location.href='inspect_jig.php';</script>";
        }
        else {
            echo "<script>alert('중복 지그가 있습니다! 다시 등록하세요!');location.href='inspect_jig.php';</script>";
        } 
    } 
    ELSEIF($bt31=="on") {
        $tab2 = '';
        $tab3 = 'active';
        $tab2_text = '';
        $tab3_text = 'show active';

        $query_out = "select * from QIS.dbo.M_LOG_JIG WHERE UPDT_DT between ? and ? ORDER BY INSERT_DT DESC";
        $out_params = array($s_dt3, $e_dt3);
        $result_out = sqlsrv_query($connect, $query_out, $out_params, $options);
        // $num_result_out = sqlsrv_num_rows($result_out); // This will be handled in the view file by iterating
    } 
    ELSEIF($bt_modify == "on") {
        $JIG_ID_mod = $_POST["NM1"] ?? null;
        $JIG_SEQ_mod = $_POST["NM2"] ?? null;
        $CURRENT_QTY_mod = $_POST["QTY2"] ?? 0;
        $TOTAL_QTY_mod = $_POST["QTY3"] ?? 0;
        $JUDGMENT_mod = $_POST["JUDGMENT"] ?? null;
        $DT_mod = $_POST["DT"] ?? null;
        $NOTE_mod = $_POST["NOTE"] ?? null;
        
        // 숫자형 변환 (계산 안전성 확보)
        $CURRENT_QTY_mod = is_numeric($CURRENT_QTY_mod) ? $CURRENT_QTY_mod : 0;
        $TOTAL_QTY_mod = is_numeric($TOTAL_QTY_mod) ? $TOTAL_QTY_mod : 0;

        $USAGE_COUNT_mod = $CURRENT_QTY_mod + $TOTAL_QTY_mod;
        
        // 날짜 처리
        $c_date_mod = ($DT_mod) ? date("Ymd", strtotime($DT_mod)) : $s_date;

        if ($JUDGMENT_mod == 'CHECK') {
            // [수정] $session_row->id -> $session_row->user_id
            $record_query = "INSERT INTO QIS.dbo.M_LOG_JIG(JIG_ID, JIG_SEQ, USAGE_COUNT, JUDGMENT, NOTE, UPDT_USER_ID, UPDT_DT, INSERT_DT) VALUES(?, ?, ?, 'CHECK', ?, ?, ?, ?)";
            $record_params = array($JIG_ID_mod, $JIG_SEQ_mod, $USAGE_COUNT_mod, $NOTE_mod, $session_row->user_id, $c_date_mod, $s_date);
            sqlsrv_query($connect, $record_query, $record_params);

            // [수정] $session_row->id -> $session_row->user_id
            $update_query = "UPDATE QIS.dbo.M_JIG_INFO SET CURRENT_QTY='0', TOTAL_QTY=?, LAST_UPDATE_USER=?, LAST_UPDATE_DATE=? WHERE JIG_ID=? AND JIG_SEQ=?";
            $update_params = array($USAGE_COUNT_mod, $session_row->user_id, $s_date, $JIG_ID_mod, $JIG_SEQ_mod);
            sqlsrv_query($connect, $update_query, $update_params);
        } else { // Assumes 'CHANGE'
            // [수정] $session_row->id -> $session_row->user_id
            $record_query = "INSERT INTO QIS.dbo.M_LOG_JIG(JIG_ID, JIG_SEQ, USAGE_COUNT, JUDGMENT, NOTE, UPDT_USER_ID, UPDT_DT, INSERT_DT) VALUES(?, ?, ?, 'CHANGE', ?, ?, ?, ?)";
            $record_params = array($JIG_ID_mod, $JIG_SEQ_mod, $USAGE_COUNT_mod, $NOTE_mod, $session_row->user_id, $c_date_mod, $s_date);
            sqlsrv_query($connect, $record_query, $record_params);

            // [수정] $session_row->id -> $session_row->user_id
            $update_query = "UPDATE QIS.dbo.M_JIG_INFO SET CURRENT_QTY='0', TOTAL_QTY='0', LAST_UPDATE_USER=?, LAST_UPDATE_DATE=? WHERE JIG_ID=? AND JIG_SEQ=?";
            $update_params = array($session_row->user_id, $s_date, $JIG_ID_mod, $JIG_SEQ_mod);
            sqlsrv_query($connect, $update_query, $update_params);
        }

        echo "<script>alert('변경 되었습니다!');location.href='inspect_jig.php';</script>";
        exit;
    } 
    //활성화 탭 변경 end  

   
    //메뉴 입장 시 실행 start
    
    // 파라미터 초기화 (Notice 방지)
    $params = array();

    //지그현황
    $query = "select * from QIS.dbo.M_JIG_INFO";              
    $result = sqlsrv_query($connect, $query, $params, $options);		
    // $num_result = sqlsrv_num_rows($result); // SQLSRV_CURSOR_KEYSET 옵션 필요할 수 있음, 여기선 생략해도 무방

    //지그수량
    $q_JigCount = "select * from QIS.dbo.M_JIG_INFO";              
    $r_JigCount = sqlsrv_query($connect, $q_JigCount, $params, $options);		
    $c_JigCount = ($r_JigCount) ? sqlsrv_num_rows($r_JigCount) : 0; 
    
    //지그점검필요
    $q_JigInspectNeed = "select * from QIS.dbo.M_JIG_INFO where CURRENT_QTY>=LIMIT_QTY";              
    $r_JigInspectNeed = sqlsrv_query($connect, $q_JigInspectNeed, $params, $options);		
    $c_JigInspectNeed = ($r_JigInspectNeed) ? sqlsrv_num_rows($r_JigInspectNeed) : 0; 

    //지그점검도래
    $q_JigInspectSoon = "select * from QIS.dbo.M_JIG_INFO where CURRENT_QTY>=LIMIT_QTY*0.8";              
    $r_JigInspectSoon = sqlsrv_query($connect, $q_JigInspectSoon, $params, $options);		
    $c_JigInspectSoon = ($r_JigInspectSoon) ? sqlsrv_num_rows($r_JigInspectSoon) : 0; 
    //메뉴 입장 시 실행 end
?>