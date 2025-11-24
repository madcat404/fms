<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.03.05>
	// Description:	<선입선출>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';    
    include '../DB/DB21.php'; 

    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';         

    //★변수모음    
    //PDA - 입력	 
    $mode = 0;   
    $pda_cd_item21 = $_POST["pda_cd_item21"] ?? '';     
    $pda_cd_item21_a = $_POST["pda_cd_item21_a"] ?? '';     
    $pda_bt21 = $_POST["pda_bt21"] ?? '';   

    //PDA - 삭제	 
    $pda_cd_item23 = $_POST["pda_cd_item23"] ?? '';        
    $pda_bt23 = $_POST["pda_bt23"] ?? '';  

    //덮어쓰기
    $CTRLV = $_GET["CTRLV"] ?? '';  

    //박스라벨 부터 찍도록 검증
    //FIXME: 이동후 오토포커스 안됨
    $chk_head = substr($pda_cd_item21, 0, 1);
    if($chk_head=='[') {
        echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = ''; while(true) { var getpass = prompt('부품식별표를 먼저 스캔해야 합니다!\\n확인을 누르세요!',''); if(pass == getpass) { location.href='packing_pda.php'; break; } } };audio.play();</script>";
    }

    //elseif로 묶어 버리면 묶여 있는 것중에 1개를 택1해야 하므로 if를 별도로 둔다.
    if($pda_cd_item21!='') {
        $mode=1;

        $use_function2 = CROP($pda_cd_item21);
        $cd_item21 = HyphenRemove($use_function2[0] ?? '');
        $lot_date21 = $use_function2[2] ?? '';
        $lot_num21 = $use_function2[3] ?? '';
        $qt_goods21 = $use_function2[4] ?? ''; 
    }    

    if($pda_cd_item21_a!='') {
        if($pda_cd_item21=='') {
            echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = ''; while(true) { var getpass = prompt('박스 입력칸에 먼저 스캔해야 합니다!\\n확인을 누르세요!',''); if(pass == getpass) { location.href='packing_pda.php'; break; } } };audio.play();</script>";
        }
        else {
            $mode=2;

            $use_function3 = CROP($pda_cd_item21_a);
            $cd_item21_a = HyphenRemove($use_function3[0] ?? '');
            $TRACE_CODE_A = $use_function3[1] ?? '';
            $lot_date21_a = $use_function3[2] ?? '';
        }        
    }

    if($pda_cd_item23!='') {
        $use_function23 = CROP($pda_cd_item23);
        $cd_item23 = HyphenRemove($use_function23[0] ?? '');
        $lot_date23 = $use_function23[2] ?? '';
        $lot_num23 = $use_function23[3] ?? '';
    } 

    //★버튼 클릭 시 실행  
    //pda 입력
    IF($pda_bt21=="on") {   
        IF($mode==2) {
            //BB에서 DN8 F/C라벨을 보고 검수반에서 재포장을 하면서 DN8 F/C라벨을 붙였는데 내용물이 DN8 F/B인 경우가 있음 (품질 이슈)
            //이러한 문제를 검증하기 위한 매커니즘  
            //Q201 F/C VENT S111A0-00110 품번은 문제가 없음에도 "부품식별표 품번과 제품 품번이 다릅니다! 확인을 누르세요!" 발생하여 예외처리   
            //위의 품번뿐만 아니라 k로 시작하거나 s로 시작하는 11자리 품번이 모두 문제이므로 공통점인 첫글자가 k이거나 s인경우 패스하는 알고리즘으로 변경
            $first = substr($cd_item21, 0, 1);     
            IF($first=='K' or $first=='S' or $cd_item21==$cd_item21_a or substr($cd_item21,0, 10)==$cd_item21_a) {
                //make_date에 로트데이터 8자리가 입력되는 경우를 방지하기 위함
                //다른고객사의 제품은 바코드 체계가 다르므로 발생한다.
                //따라서 현기차에 맞쳐 지도록 6자리로 바꾸는 작업을 한다.
                if(strlen($lot_date21_a)>6) {
                    $lot_date21_a = substr($lot_date21_a,2,6);
                }

                //확인
                $Query_SelectBox = "SELECT * from CONNECT.dbo.PACKING_LOG where CD_ITEM=? and LOT_DATE=? and LOT_NUM=?";
                $params_select = [$cd_item21, $lot_date21, $lot_num21];
                $Result_SelectBox = sqlsrv_query($connect, $Query_SelectBox, $params_select, ["Scrollable" => SQLSRV_CURSOR_KEYSET]);
                $Data_SelectBox = sqlsrv_fetch_array($Result_SelectBox);
                $Count_SelectBox = sqlsrv_num_rows($Result_SelectBox); 

                //작업자 한명이 출근하여 처음 스캔전에 무조건 데이터 1개가 기록되어 있다고 한다
                //아마도 웹페이지를 켜면서 전일 스캔 데이터값이 등록되는것으로 보여지는데 이를 막고자 함
                if($Count_SelectBox!=0) {
                    IF(date("H:i:s") >= '00:00:00' and date("H:i:s") <= '08:45:00') {
                        if(date_format($Data_SelectBox['SORTING_DATE'], "Y-m-d")==date("Y-m-d")) {
                            //update 해야함 where 절 넣어서
                            $Query_UpdateProduct = "UPDATE CONNECT.dbo.PACKING_LOG SET IP=?, MAKE_DATE=?, UPDATE_DATE=GETDATE(), RECORD_UPDATE=GETDATE(), PRODUCT_BARCODE=? WHERE CD_ITEM=? and LOT_DATE=? and LOT_NUM=?";
                            $params_update = [$sip, $lot_date21_a, $pda_cd_item21_a, $cd_item21, $lot_date21, $lot_num21];
                            sqlsrv_query($connect, $Query_UpdateProduct, $params_update);
                        } 
                        else {                        
                            echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = ''; while(true) { var getpass = prompt('전일 데이터가 입력된것으로 보입니다!\\n인터넷을 껏다가 다시 켜보세요!\\전일 제품은 8:45 이후에 스캔가능합니다!\\n확인을 누르세요!',''); if(pass == getpass) { location.href='http://fms.iwin.kr/kjwt_field/packing_pda.php'; break; } } };audio.play();</script>";
                        }
                    }
                    else {
                        if($Data_SelectBox['MAKE_DATE']!=null) {
                            echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = ''; while(true) { var getpass = prompt('덮어쓰기 하시겠습니까?\\n덮어쓰기를 하시려면 확인을 누르세요!',''); if(pass == getpass) { location.href='packing_pda.php?CTRLV=on&sip=$sip&lot_date21_a=$lot_date21_a&cd_item21=$cd_item21&lot_date21=$lot_date21&lot_num21=$lot_num21'; break; } else{break;} } };audio.play();</script>";
                        }
                        else {
                            $Query_UpdateProduct = "UPDATE CONNECT.dbo.PACKING_LOG SET IP=?, MAKE_DATE=?, UPDATE_DATE=GETDATE(), RECORD_UPDATE=GETDATE(), PRODUCT_BARCODE=? WHERE CD_ITEM=? and LOT_DATE=? and LOT_NUM=?";
                            $params_update = [$sip, $lot_date21_a, $pda_cd_item21_a, $cd_item21, $lot_date21, $lot_num21];
                            sqlsrv_query($connect, $Query_UpdateProduct, $params_update);
                        }
                    }
                } 
                else {                        
                    echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = ''; while(true) { var getpass = prompt('출력된 포장라벨이 없습니다!\\n확인을 누르세요!',''); if(pass == getpass) { location.href='packing_pda.php'; break; } } };audio.play();</script>";
                }  
            }  
            ELSE {                
                echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = ''; while(true) { var getpass = prompt('부품식별표 품번과 제품 품번이 다릅니다!\\n확인을 누르세요!',''); if(pass == getpass) { location.href='packing_pda.php'; break; } } };audio.play();</script>";
            }
        }       
    }   
    //덮어쓰기
    ELSEIF($CTRLV=="on") {  
        $sip = $_GET["sip"] ?? '';     
        $lot_date21_a = $_GET["lot_date21_a"] ?? '';   
        $cd_item21 = $_GET["cd_item21"] ?? ''; 
        $lot_date21 = $_GET["lot_date21"] ?? ''; 
        $lot_num21 = $_GET["lot_num21"] ?? ''; 

        $Query_UpdateProduct = "UPDATE CONNECT.dbo.PACKING_LOG SET IP=?, MAKE_DATE=?, UPDATE_DATE=GETDATE(), RECORD_UPDATE=GETDATE() WHERE CD_ITEM=? and LOT_DATE=? and LOT_NUM=?";
        $params_update = [$sip, $lot_date21_a, $cd_item21, $lot_date21, $lot_num21];
        sqlsrv_query($connect, $Query_UpdateProduct, $params_update);
    }
    //삭제
    //금일 매핑을 했는데 1개가 불량이라 내일 나가야하는 경우 매핑을 초기화해야함
    ELSEIF($pda_bt23=="on") {  
        $Query_UpdateProduct2 = "UPDATE CONNECT.dbo.PACKING_LOG SET IP=null, MAKE_DATE=null, UPDATE_DATE=null, RECORD_UPDATE=null WHERE CD_ITEM=? and LOT_DATE=? and LOT_NUM=?";
        $params_delete = [$cd_item23, $lot_date23, $lot_num23];
        sqlsrv_query($connect, $Query_UpdateProduct2, $params_delete);
    }
   
    //★메뉴 진입 시 실행
    //PDA 카운트
    $Query_PDA = "SELECT * from CONNECT.dbo.PACKING_LOG WHERE UPDATE_DATE='$Hyphen_today'";              
    $Result_PDA = sqlsrv_query($connect21, $Query_PDA, $params21, $options21);	
    $Count_PDA = sqlsrv_num_rows($Result_PDA);

    $Query_PDA3117 = "SELECT COUNT(*) AS CNT from CONNECT.dbo.PACKING_LOG WHERE UPDATE_DATE='$Hyphen_today' AND (IP='192.168.3.117' or IP='192.168.4.102')";
    $Result_PDA3117 = sqlsrv_query($connect21, $Query_PDA3117, $params21, $options21);	
    $Count_PDA3117 = sqlsrv_fetch_array($Result_PDA3117)['CNT'] ?? 0;

    $Query_PDA4100 = "SELECT COUNT(*) AS CNT from CONNECT.dbo.PACKING_LOG WHERE UPDATE_DATE='$Hyphen_today' AND IP='192.168.4.100'";
    $Result_PDA4100 = sqlsrv_query($connect21, $Query_PDA4100, $params21, $options21);	
    $Count_PDA4100 = sqlsrv_fetch_array($Result_PDA4100)['CNT'] ?? 0;

    $Query_PDA4177 = "SELECT COUNT(*) AS CNT from CONNECT.dbo.PACKING_LOG WHERE UPDATE_DATE='$Hyphen_today' AND IP='192.168.4.177'";
    $Result_PDA4177 = sqlsrv_query($connect21, $Query_PDA4177, $params21, $options21);	
    $Count_PDA4177 = sqlsrv_fetch_array($Result_PDA4177)['CNT'] ?? 0;

    $Query_PDA4107 = "SELECT COUNT(*) AS CNT from CONNECT.dbo.PACKING_LOG WHERE UPDATE_DATE='$Hyphen_today' AND IP='192.168.4.107'";
    $Result_PDA4107 = sqlsrv_query($connect21, $Query_PDA4107, $params21, $options21);	
    $Count_PDA4107 = sqlsrv_fetch_array($Result_PDA4107)['CNT'] ?? 0;

    $Query_PDA4105 = "SELECT COUNT(*) AS CNT from CONNECT.dbo.PACKING_LOG WHERE UPDATE_DATE='$Hyphen_today' AND IP='192.168.4.105'";
    $Result_PDA4105 = sqlsrv_query($connect21, $Query_PDA4105, $params21, $options21);	
    $Count_PDA4105 = sqlsrv_fetch_array($Result_PDA4105)['CNT'] ?? 0;