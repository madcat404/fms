<?php   
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.12.06>
	// Description:	<공정진행 완료>		
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php'; 
    include '../DB/DB21.php'; 

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    //★변수정의
    //수정
    $modi = $_GET["modi"];
    $Vmodi = $_GET["Vmodi"];
    $Cmodi = $_GET["Cmodi"];
    $BadWorkModi = $_GET["BadWorkModi"];      
    //팝업창
    $kmodal = $_GET["MODAL"];
    $kmodal2 = $_GET["MODAL2"];
    $vmodal = $_GET["VMODAL"];
    $vmodal2 = $_GET["VMODAL2"];     

    
    //★탭활성화
    //P모드 : 팝업창 닫기 시 부모창의 마지막 선택 탭을 보여주기 위함   
    //한국 탭 
    IF($modi=='Y' OR $modi=='P') {
        $tab_sequence=2; 
        include '../TAB.php';   
        
        //수정확인
        $Query_ModifyCheck= "SELECT * from CONNECT.dbo.USE_CONDITION WHERE KIND='FieldCompleteKorea'";              
        $Result_ModifyCheck = sqlsrv_query($connect, $Query_ModifyCheck, $params, $options);		
        $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck);  

        if($modi=='Y') {  
            IF($Data_ModifyCheck['LOCK']=='N') {
                if (session_status() === PHP_SESSION_NONE) { session_start(); }
                $s_ip = $_SERVER['REMOTE_ADDR']; //사용자 IP
                    
                //수정독점화
                $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO='$s_ip', LAST_DT='$DT' WHERE KIND='FieldCompleteKorea'";          
                sqlsrv_query($connect, $Query_ModifyUpdate, $params, $options);	
            }
            ELSE {
                echo "<script>alert(\"다른 사람이 수정중 입니다!\");location.href='field_complete.php';</script>";
            }
        }
        elseif($modi=='P') {
            $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='FieldCompleteKorea'";          
            sqlsrv_query($connect, $Query_ModifyUpdate, $params, $options);	
        }
    }
    //베트남 탭
    ELSEIF($Vmodi=='Y' OR $Vmodi=='P') {
        $tab_sequence=6; 
        include '../TAB.php';   
        
        //수정확인
        $Query_ModifyCheck= "SELECT * from CONNECT.dbo.USE_CONDITION WHERE KIND='FieldCompleteVietnam'";              
        $Result_ModifyCheck = sqlsrv_query($connect, $Query_ModifyCheck, $params, $options);		
        $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck);  

        if($Vmodi=='Y') {  
            IF($Data_ModifyCheck['LOCK']=='N') {
                if (session_status() === PHP_SESSION_NONE) { session_start(); }
                $s_ip = $_SERVER['REMOTE_ADDR']; //사용자 IP
                    
                //수정독점화
                $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO='$s_ip', LAST_DT='$DT' WHERE KIND='FieldCompleteVietnam'";          
                sqlsrv_query($connect, $Query_ModifyUpdate, $params, $options);	
            }
            ELSE {
                echo "<script>alert(\"다른 사람이 수정중 입니다!\");location.href='field_complete.php';</script>";
            }
        }
        elseif($Vmodi=='P') {
            $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='FieldCompleteVietnam'";          
            sqlsrv_query($connect, $Query_ModifyUpdate, $params, $options);	
        }
    }    
    //불량내역 탭
    elseif($BadWorkModi=='Y' OR $BadWorkModi=='P' OR $BadWorkModi=='T') {
        $tab_sequence=4; 
        include '../TAB.php'; 

        //조회를 하지 않은 상태에서 수정버튼을 누렀을때의 탭이동에 대한 불편함을 개선하기 위해 T 추가
        if($BadWorkModi=='T') {}
        else {
            //불량내역 수정 시 가져오는 날짜 데이터 
            $hidden_dt4 = $_GET["hdt4"]; 
            //날짜검색, 수정, 저장 후 다시 수정을 누르는 경우 get에 dt가 빠짐  
            if($hidden_dt4=='') {            
                echo "<script>alert(\"날짜불러오기 실패! 검색범위를 다시 선택하세요!\");location.href='field_complete.php?BadWorkModi=T';</script>";
            }  
            else {
                //수정확인
                $Query_ModifyCheck= "SELECT * from CONNECT.dbo.USE_CONDITION WHERE KIND='FieldCompleteBad'";              
                $Result_ModifyCheck = sqlsrv_query($connect, $Query_ModifyCheck, $params, $options);		
                $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck);  

                if($BadWorkModi=='Y') {  
                    IF($Data_ModifyCheck['LOCK']=='N') {
                        if (session_status() === PHP_SESSION_NONE) { session_start(); }
                        $s_ip = $_SERVER['REMOTE_ADDR']; //사용자 IP
                            
                        //수정독점화
                        $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO='$s_ip', LAST_DT='$DT' WHERE KIND='FieldCompleteBad'";          
                        sqlsrv_query($connect, $Query_ModifyUpdate, $params, $options);	
                    }
                    ELSE {
                        echo "<script>alert(\"다른 사람이 수정중 입니다!\");location.href='field_complete.php';</script>";
                    }
                }
                elseif($BadWorkModi=='P') {
                    $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='FieldCompleteBad'";          
                    sqlsrv_query($connect, $Query_ModifyUpdate, $params, $options);	
                }

                
                $hs_dt4 = substr($hidden_dt4, 0, 10);		
                $he_dt4 = substr($hidden_dt4, 13, 10);

                //불량내역(한국)
                $Query_Reject = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE SORTING_DATE between '$hs_dt4' and '$he_dt4'";              
                $Result_Reject = sqlsrv_query($connect, $Query_Reject, $params, $options);		
                $Count_Reject = sqlsrv_num_rows($Result_Reject);

                //불량내역(베트남)
                $Query_vReject = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE SORTING_DATE between '$hs_dt4' and '$he_dt4'";              
                $Result_vReject = sqlsrv_query($connect, $Query_vReject, $params, $options);		
                $Count_vReject = sqlsrv_num_rows($Result_vReject);

                //불량내역(중국)
                $Query_cReject = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_C WHERE SORTING_DATE between '$hs_dt4' and '$he_dt4'";              
                $Result_cReject = sqlsrv_query($connect, $Query_cReject, $params, $options);		
                $Count_cReject = sqlsrv_num_rows($Result_cReject);

                //작업개별수량(한국)
                $Query_RejectPcsCount= "SELECT SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE SORTING_DATE between '$hs_dt4' and '$he_dt4'";              
                $Result_RejectPcsCount = sqlsrv_query($connect, $Query_RejectPcsCount, $params, $options);		
                $Data_RejectPcsCount = sqlsrv_fetch_array($Result_RejectPcsCount);  

                //작업개별수량(베트남)
                $Query_vRejectPcsCount= "SELECT SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE SORTING_DATE between '$hs_dt4' and '$he_dt4'";              
                $Result_vRejectPcsCount = sqlsrv_query($connect, $Query_vRejectPcsCount, $params, $options);		
                $Data_vRejectPcsCount = sqlsrv_fetch_array($Result_vRejectPcsCount);  

                //작업개별수량(중국)
                $Query_cRejectPcsCount= "SELECT SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_REJECT_C WHERE SORTING_DATE between '$hs_dt4' and '$he_dt4'";              
                $Result_cRejectPcsCount = sqlsrv_query($connect, $Query_cRejectPcsCount, $params, $options);		
                $Data_cRejectPcsCount = sqlsrv_fetch_array($Result_cRejectPcsCount);  
            }
        }
    }
    //한국 탭
    else {
        $tab_sequence=2; 
        include '../TAB.php'; 
    }    


    //★팝업창 활성화 시 실행
    //한국불량
    if($kmodal=='on') {
        $kmodal_Delivery_ItemCode = $_GET["kmodal_Delivery_ItemCode"];
        $kmodal_Delivery_LotDate = $_GET["kmodal_Delivery_LotDate"];
        $kmodal_Delivery_LotNum = $_GET["kmodal_Delivery_LotNum"];
        $kmodal_Delivery_ERP = $_GET["kmodal_Delivery_ERP"];

        //입력된 불량내용과 개수 불러오기
        $Query_KoreaReject1= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$kmodal_Delivery_ItemCode' AND LOT_DATE='$kmodal_Delivery_LotDate' AND LOT_NUM='$kmodal_Delivery_LotNum' and REJECT_CODE='1'";              
        $Result_KoreaReject1 = sqlsrv_query($connect, $Query_KoreaReject1, $params, $options);		
        $Data_KoreaReject1 = sqlsrv_fetch_array($Result_KoreaReject1);  

        $Query_KoreaReject2= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$kmodal_Delivery_ItemCode' AND LOT_DATE='$kmodal_Delivery_LotDate' AND LOT_NUM='$kmodal_Delivery_LotNum' and REJECT_CODE='2'";              
        $Result_KoreaReject2 = sqlsrv_query($connect, $Query_KoreaReject2, $params, $options);		
        $Data_KoreaReject2 = sqlsrv_fetch_array($Result_KoreaReject2);  

        $Query_KoreaReject3= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$kmodal_Delivery_ItemCode' AND LOT_DATE='$kmodal_Delivery_LotDate' AND LOT_NUM='$kmodal_Delivery_LotNum' and REJECT_CODE='3'";              
        $Result_KoreaReject3 = sqlsrv_query($connect, $Query_KoreaReject3, $params, $options);		
        $Data_KoreaReject3 = sqlsrv_fetch_array($Result_KoreaReject3);  

        $Query_KoreaReject4= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$kmodal_Delivery_ItemCode' AND LOT_DATE='$kmodal_Delivery_LotDate' AND LOT_NUM='$kmodal_Delivery_LotNum' and REJECT_CODE='4'";              
        $Result_KoreaReject4 = sqlsrv_query($connect, $Query_KoreaReject4, $params, $options);		
        $Data_KoreaReject4 = sqlsrv_fetch_array($Result_KoreaReject4);  

        $Query_KoreaReject5= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$kmodal_Delivery_ItemCode' AND LOT_DATE='$kmodal_Delivery_LotDate' AND LOT_NUM='$kmodal_Delivery_LotNum' and REJECT_CODE='5'";              
        $Result_KoreaReject5 = sqlsrv_query($connect, $Query_KoreaReject5, $params, $options);		
        $Data_KoreaReject5 = sqlsrv_fetch_array($Result_KoreaReject5);  

        $Query_KoreaReject6= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$kmodal_Delivery_ItemCode' AND LOT_DATE='$kmodal_Delivery_LotDate' AND LOT_NUM='$kmodal_Delivery_LotNum' and REJECT_CODE='6'";              
        $Result_KoreaReject6 = sqlsrv_query($connect, $Query_KoreaReject6, $params, $options);		
        $Data_KoreaReject6 = sqlsrv_fetch_array($Result_KoreaReject6); 

        $Query_KoreaReject7= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$kmodal_Delivery_ItemCode' AND LOT_DATE='$kmodal_Delivery_LotDate' AND LOT_NUM='$kmodal_Delivery_LotNum' and REJECT_CODE='7'";              
        $Result_KoreaReject7 = sqlsrv_query($connect, $Query_KoreaReject7, $params, $options);		
        $Data_KoreaReject7 = sqlsrv_fetch_array($Result_KoreaReject7); 

        $Query_KoreaReject8= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$kmodal_Delivery_ItemCode' AND LOT_DATE='$kmodal_Delivery_LotDate' AND LOT_NUM='$kmodal_Delivery_LotNum' and REJECT_CODE='8'";              
        $Result_KoreaReject8 = sqlsrv_query($connect, $Query_KoreaReject8, $params, $options);		
        $Data_KoreaReject8 = sqlsrv_fetch_array($Result_KoreaReject8); 
    }
    //한국 품번 중복 시 수량 변경
    elseif($kmodal2=='on') {
        $tab_sequence=2; 
        include '../TAB.php'; 

        $modal_Delivery_ItemCode2 = $_GET["modal_Delivery_ItemCode2"];
        $size = $_GET["size"]; 

        //입력된 수량 불러오기
        $Query_KoreaPrevious= "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH where SORTING_DATE='$Hyphen_today' and CD_ITEM='$modal_Delivery_ItemCode2' and BARCODE like 'handwrite%'";              
        $Result_KoreaPrevious = sqlsrv_query($connect, $Query_KoreaPrevious, $params, $options);		
        $Data_KoreaPrevious = sqlsrv_fetch_array($Result_KoreaPrevious);    
    }
    //베트남불량
    elseif($vmodal=='on') {
        $tab_sequence=6; 
        include '../TAB.php'; 
        $vmodal_Delivery_ItemCode = $_GET["vmodal_Delivery_ItemCode"];
        $vmodal_Delivery_LotDate = $_GET["vmodal_Delivery_LotDate"];

        //입력된 불량내용과 개수 불러오기
        $Query_VietnamReject1= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM='$vmodal_Delivery_ItemCode' AND LOT_DATE='$vmodal_Delivery_LotDate' and REJECT_CODE='1'";              
        $Result_VietnamReject1 = sqlsrv_query($connect, $Query_VietnamReject1, $params, $options);		
        $Data_VietnamReject1 = sqlsrv_fetch_array($Result_VietnamReject1);  

        $Query_VietnamReject2= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM='$vmodal_Delivery_ItemCode' AND LOT_DATE='$vmodal_Delivery_LotDate' and REJECT_CODE='2'";              
        $Result_VietnamReject2 = sqlsrv_query($connect, $Query_VietnamReject2, $params, $options);		
        $Data_VietnamReject2 = sqlsrv_fetch_array($Result_VietnamReject2);  

        $Query_VietnamReject3= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM='$vmodal_Delivery_ItemCode' AND LOT_DATE='$vmodal_Delivery_LotDate' and REJECT_CODE='3'";              
        $Result_VietnamReject3 = sqlsrv_query($connect, $Query_VietnamReject3, $params, $options);		
        $Data_VietnamReject3 = sqlsrv_fetch_array($Result_VietnamReject3);  

        $Query_VietnamReject4= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM='$vmodal_Delivery_ItemCode' AND LOT_DATE='$vmodal_Delivery_LotDate' and REJECT_CODE='4'";              
        $Result_VietnamReject4 = sqlsrv_query($connect, $Query_VietnamReject4, $params, $options);		
        $Data_VietnamReject4 = sqlsrv_fetch_array($Result_VietnamReject4);  

        $Query_VietnamReject5= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM='$vmodal_Delivery_ItemCode' AND LOT_DATE='$vmodal_Delivery_LotDate' and REJECT_CODE='5'";              
        $Result_VietnamReject5 = sqlsrv_query($connect, $Query_VietnamReject5, $params, $options);		
        $Data_VietnamReject5 = sqlsrv_fetch_array($Result_VietnamReject5);  

        $Query_VietnamReject6= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM='$vmodal_Delivery_ItemCode' AND LOT_DATE='$vmodal_Delivery_LotDate' and REJECT_CODE='6'";              
        $Result_VietnamReject6 = sqlsrv_query($connect, $Query_VietnamReject6, $params, $options);		
        $Data_VietnamReject6 = sqlsrv_fetch_array($Result_VietnamReject6);  

        $Query_VietnamReject7= "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM='$vmodal_Delivery_ItemCode' AND LOT_DATE='$vmodal_Delivery_LotDate' and REJECT_CODE='7'";              
        $Result_VietnamReject7 = sqlsrv_query($connect, $Query_VietnamReject7, $params, $options);		
        $Data_VietnamReject7 = sqlsrv_fetch_array($Result_VietnamReject7);  
    }
    //베트남 품번 중복 시 수량 변경
    elseif($vmodal2=='on') {
        $tab_sequence=6; 
        include '../TAB.php'; 
        $vmodal_Delivery_ItemCode2 = $_GET["vmodal_Delivery_ItemCode2"];
        $vsize = $_GET["vsize"]; 

        //입력된 수량 불러오기
        $Query_VietnamPrevious= "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH_V where SORTING_DATE='$Hyphen_today' and CD_ITEM='$vmodal_Delivery_ItemCode2'";              
        $Result_VietnamPrevious = sqlsrv_query($connect, $Query_VietnamPrevious, $params, $options);		
        $Data_VietnamPrevious = sqlsrv_fetch_array($Result_VietnamPrevious);    
    }
    else {  
        $kmodal= '';
        $kmodal2= '';
        $vmodal= '';
        $vmodal2= '';
    }  


    //★변수모음   
    //탭2 - 입력 
    $item2 = strtoupper($_POST["item2"]);
    $use_function2 = CROP($item2);
    $cd_item2 = $use_function2[0];  //여기서 하이폰 제거하면 안됨
    $lot_date2 = $use_function2[2];
    $lot_num2 = $use_function2[3];
    $qt_goods2 = $use_function2[4];
    $bt21 = $_POST["bt21"];  
    $bt22 = $_POST["bt22"];
    $bt21b1 = $_POST["bt21b1"];         

    //탭2 - 삭제
    $item2b = strtoupper($_POST["item2b"]);
    $use_function2b = CROP($item2b);
    $cd_item2b = $use_function2b[0]; //여기서 하이폰 제거하면 안됨
    $lot_date2b = $use_function2b[2];
    $lot_num2b = $use_function2b[3];
    $qt_goods2b = $use_function2b[4];
    $bt21b = $_POST["bt21b"];  
    $cd_item2b2 = trim(HyphenRemove(strtoupper($_POST["item2b2"])));
    
    //탭2 - 불량
    $mbt1 = $_POST["mbt1"];
    $mi1 = $_POST["mi1"]; 
    $mn1 = $_POST["mn1"]; 
    $mi2 = $_POST["mi2"]; 
    $mn2 = $_POST["mn2"]; 
    $mi3 = $_POST["mi3"]; 
    $mn3 = $_POST["mn3"]; 
    $mi4 = $_POST["mi4"]; 
    $mn4 = $_POST["mn4"]; 
    $mi5 = $_POST["mi5"]; 
    $mn5 = $_POST["mn5"]; 
    $mi6 = $_POST["mi6"]; 
    $mn6 = $_POST["mn6"]; 
    $mi7 = $_POST["mi7"]; 
    $mn7 = $_POST["mn7"]; 
    $mi8 = $_POST["mi8"]; 
    $mn8 = $_POST["mn8"]; 
    $kmodal_ItemCode = $_POST["kmodal_ItemCode"]; 
    $kmodal_LotDate = $_POST["kmodal_LotDate"]; 
    $kmodal_LotNum = $_POST["kmodal_LotNum"]; 
    $kmodal_ERP = $_POST["kmodal_ERP"]; 

    //탭2 - 중복 시 수량조정
    $mbt2 = $_POST["mbt2"];
    $add_qt_goods2 = $_POST["pop_out5"];
    $modal_ItemCode2 = $_POST["modal_ItemCode2"];   
    $modal_quantiy2 = $_POST["modal_quantiy2"];   
    $qt_goods5 = $add_qt_goods2 + $modal_quantiy2;  

    //탭3  
    $dt3 = $_POST["dt3"];	
    $s_dt3 = substr($dt3, 0, 10);		
	$e_dt3 = substr($dt3, 13, 10);
    $bt31 = $_POST["bt31"];     
    $bt32 = $_POST["bt32"];        
    
    //탭4 
    $dt4 = $_POST["dt4"];	
    $s_dt4 = substr($dt4, 0, 10);		
	$e_dt4 = substr($dt4, 13, 10);
    $bt41 = $_POST["bt41"];   
    $bt42 = $_POST["bt42"];       
    
    //탭5
    $dt5 = $_POST["dt5"];	
    $s_dt5 = substr($dt5, 0, 10);		
	$e_dt5 = substr($dt5, 13, 10);
    $bt51 = $_POST["bt51"];          

    //탭6 
    $item6 = strtoupper($_POST["item6"]);
    $use_function6 = CROP($item6);
    $CD_ITEM6 = HyphenRemove($use_function6[0]);
    //MEa 제품은 뒤에 (na)가 붙어 선택창이 나오도록 함 (25.01.16)
    $popitem = $_GET["popitem"]; 
    if($CD_ITEM6=='88170GO200' or $CD_ITEM6=='88370GO100' or $CD_ITEM6=='89170GO050' or $CD_ITEM6=='89370GO050') {
		echo "<script>location.href='field_complete_pop.php?cd_item=$CD_ITEM6';</script>";	
		exit;
	}	    
    $bt61 = $_POST["bt61"];           
    $bt62 = $_POST["bt62"];  
    $bt61b1 = $_POST["bt61b1"];   
    
    //탭6 - 삭제
    $item6b = $_POST["item6b"];
    $use_function6b = CROP($item6b);
    $cd_item6b = HyphenRemove($use_function6b[0]);
    //MEa 제품은 뒤에 (na)가 붙어 선택창이 나오도록 함 (25.01.16)
    $popitem2 = $_GET["popitem2"]; 
    if($cd_item6b=='88170GO200' or $cd_item6b=='88370GO100' or $cd_item6b=='89170GO050' or $cd_item6b=='89370GO050') {
		echo "<script>location.href='field_complete_pop2.php?cd_item=$cd_item6b';</script>";	
		exit;
	}	
    $bt61b = $_POST["bt61b"];  
    $cd_item6b2 = trim(HyphenRemove($_POST["item6b2"]));

    //탭6 - 불량
    $vmbt1 = $_POST["vmbt1"];
    $vmi1 = $_POST["vmi1"]; 
    $vmn1 = $_POST["vmn1"]; 
    $vmi2 = $_POST["vmi2"]; 
    $vmn2 = $_POST["vmn2"]; 
    $vmi3 = $_POST["vmi3"]; 
    $vmn3 = $_POST["vmn3"]; 
    $vmi4 = $_POST["vmi4"]; 
    $vmn4 = $_POST["vmn4"]; 
    $vmi5 = $_POST["vmi5"]; 
    $vmn5 = $_POST["vmn5"]; 
    $vmi6 = $_POST["vmi6"]; 
    $vmn6 = $_POST["vmn6"]; 
    $vmi7 = $_POST["vmi7"]; 
    $vmn7 = $_POST["vmn7"]; 
    $vmodal_ItemCode = $_POST["vmodal_ItemCode"]; 
    $vmodal_LotDate = $_POST["vmodal_LotDate"]; 

    //탭6 - 중복 시 수량조정
    $vmbt2 = $_POST["vmbt2"];
    $add_qt_goods6 = $_POST["pop_out4"];
    $vmodal_ItemCode2 = $_POST["vmodal_ItemCode2"];   
    $vmodal_quantiy2 = $_POST["vmodal_quantiy2"];   
    $qt_goods6 = $add_qt_goods6 + $vmodal_quantiy2;   
    

    //★버튼 클릭 시 실행
    //한국 스캔 입력
    if(isset($_POST['bt21']) && $_POST['bt21'] == 'on') {
        $tab_sequence=2; 
        include '../TAB.php'; 

        $order_check = strtoupper(substr($item2, 0, 1));	

        if($order_check=="W") {
            //만약 내부품번이면 자동차 품번으로 변경
            if(substr($cd_item2, 0, 1)=='A') {
                $stnd_item = ItemInfo($cd_item2, 'STND');

                if (strpos($stnd_item, '/') !== false) {
                    $item_options = array_map('trim', explode('/', $stnd_item));
                    $_SESSION['item_options'] = $item_options;
                    $_SESSION['original_work_order'] = $item2;
                    echo "<script>location.href='field_complete.php?popup=select_item';</script>";
                    exit;
                }
                $cd_item2 = $stnd_item;
            }

            $cd_item2=HyphenRemove($cd_item2);

            if($cd_item2!='') {
                $Query_CheckOrder = "SELECT * from NEOE.NEOE.PR_WO WHERE NO_WO='$item2'";              
                $Result_CheckOrder = sqlsrv_query($connect, $Query_CheckOrder, $params, $options);
                $Count_CheckOrder = sqlsrv_num_rows($Result_CheckOrder);
                $Data_CheckOrder = sqlsrv_fetch_array($Result_CheckOrder);

                IF($Count_CheckOrder=='0') {
                    echo "<script>alert(\"ERP 작업지시번호가 없습니다! 생산관리팀 담당자에게 연락하여 어떤 작업지시번호로 변경되었는지 물어보고 FMS 작업지시번호 라벨 메뉴에서 라벨을 발행하세요!\");location.href='field_complete.php';</script>";
                }
                else {
                    $Query_CheckOrder2 = "SELECT * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$Data_CheckOrder[CD_ITEM]' AND YN_USE='Y' and CD_PLANT='PL01'";              
                    $Result_CheckOrder2 = sqlsrv_query($connect, $Query_CheckOrder2, $params, $options);
                    $Count_CheckOrder2 = sqlsrv_num_rows($Result_CheckOrder2);

                    IF($Count_CheckOrder2=='0') {
                        echo "<script>alert(\"미사용 품번으로 작업지시를 내렸습니다. 신승화 과장에게 연락하세요!\");location.href='field_complete.php';</script>";
                    }
                    else {
                        $Query_CheckRepeat = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE BARCODE='$item2'";              
                        $Result_CheckRepeat = sqlsrv_query($connect, $Query_CheckRepeat, $params, $options);
                        $Count_CheckRepeat = sqlsrv_num_rows($Result_CheckRepeat);

                        $Query_CheckRepeat2 = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH2 WHERE BARCODE='$item2'";              
                        $Result_CheckRepeat2 = sqlsrv_query($connect, $Query_CheckRepeat2, $params, $options);
                        $Count_CheckRepeat2 = sqlsrv_num_rows($Result_CheckRepeat2);

                        IF($Count_CheckRepeat=='0' and $Count_CheckRepeat2=='0') {
                            $Query_finish = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, REJECT_GOODS, BARCODE, AS_YN) VALUES('$cd_item2', '$lot_date2', '$lot_num2', '$qt_goods2', '0', '$item2', 'N')";              
                            sqlsrv_query($connect, $Query_finish, $params, $options);                    
                        }
                        else {                    
                            echo "<script>alert(\"중복스캔하였습니다!\");location.href='field_complete.php';</script>";
                        }
                    }
                }            
            }

            $Query_FinishUpdateChk = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH where CD_ITEM='$cd_item2' and LOT_DATE='$lot_date2' and LOT_NUM='$lot_num2'";              
            $Result_FinishUpdateChk = sqlsrv_query($connect, $Query_FinishUpdateChk, $params, $options);
            $Data_FinishUpdateChk = sqlsrv_num_rows($Result_FinishUpdateChk);

            IF($Data_FinishUpdateChk > 0) {
                $Query_FinishUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_INPUT SET END_YN = 'Y', END_QT_GOODS='$qt_goods2' where CD_ITEM='$cd_item2' and LOT_DATE='$lot_date2' and LOT_NUM='$lot_num2'";
                sqlsrv_query($connect, $Query_FinishUpdate, $params, $options);
            }
        }
        else {
            echo "<script>alert(\"erp작업지시번호 바코드를 스캔해주세요!!\");location.href='field_complete.php';</script>";
        }
    }
    //한국 스캔 입력 (팝업창에서 품번 선택 후)
    ELSEIF(isset($_POST['bt21_item_selected']) && $_POST['bt21_item_selected'] == 'on') {
        $tab_sequence=2; 
        include '../TAB.php';

        $selected_item = $_POST['selected_item'];
        $original_work_order = $_POST['original_work_order'];

        $use_function2 = CROP($original_work_order);
        $lot_date2 = $use_function2[2];
        $lot_num2 = $use_function2[3];
        $qt_goods2 = $use_function2[4];

        $cd_item2 = HyphenRemove($selected_item);

        if($cd_item2!='') {
            $Query_CheckOrder = "SELECT * from NEOE.NEOE.PR_WO WHERE NO_WO='$original_work_order'";              
            $Result_CheckOrder = sqlsrv_query($connect, $Query_CheckOrder, $params, $options);
            $Count_CheckOrder = sqlsrv_num_rows($Result_CheckOrder);
            $Data_CheckOrder = sqlsrv_fetch_array($Result_CheckOrder);

            IF($Count_CheckOrder=='0') {
                echo "<script>alert(\"ERP 작업지시번호가 없습니다! 생산관리팀 담당자에게 연락하여 어떤 작업지시번호로 변경되었는지 물어보고 FMS 작업지시번호 라벨 메뉴에서 라벨을 발행하세요!\");location.href='field_complete.php';</script>";
            }
            else {
                $Query_CheckOrder2 = "SELECT * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$Data_CheckOrder[CD_ITEM]' AND YN_USE='Y' and CD_PLANT='PL01'";              
                $Result_CheckOrder2 = sqlsrv_query($connect, $Query_CheckOrder2, $params, $options);
                $Count_CheckOrder2 = sqlsrv_num_rows($Result_CheckOrder2);

                IF($Count_CheckOrder2=='0') {
                    echo "<script>alert(\"미사용 품번으로 작업지시를 내렸습니다. 신승화 과장에게 연락하세요!\");location.href='field_complete.php';</script>";
                }
                else {
                    $Query_CheckRepeat = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE BARCODE='$original_work_order'";              
                    $Result_CheckRepeat = sqlsrv_query($connect, $Query_CheckRepeat, $params, $options);
                    $Count_CheckRepeat = sqlsrv_num_rows($Result_CheckRepeat);

                    $Query_CheckRepeat2 = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH2 WHERE BARCODE='$original_work_order'";              
                    $Result_CheckRepeat2 = sqlsrv_query($connect, $Query_CheckRepeat2, $params, $options);
                    $Count_CheckRepeat2 = sqlsrv_num_rows($Result_CheckRepeat2);

                    IF($Count_CheckRepeat=='0' and $Count_CheckRepeat2=='0') {
                        $Query_finish = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, REJECT_GOODS, BARCODE, AS_YN) VALUES('$cd_item2', '$lot_date2', '$lot_num2', '$qt_goods2', '0', '$original_work_order', 'N')";              
                        sqlsrv_query($connect, $Query_finish, $params, $options);                    
                    }
                    else {                    
                        echo "<script>alert(\"중복스캔하였습니다!\");location.href='field_complete.php';</script>";
                    }
                }
            }            
        }

        $Query_FinishUpdateChk = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH where CD_ITEM='$cd_item2' and LOT_DATE='$lot_date2' and LOT_NUM='$lot_num2'";              
        $Result_FinishUpdateChk = sqlsrv_query($connect, $Query_FinishUpdateChk, $params, $options);
        $Data_FinishUpdateChk = sqlsrv_num_rows($Result_FinishUpdateChk);

        if($Data_FinishUpdateChk > 0) {
            $Query_FinishUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_INPUT SET END_YN = 'Y', END_QT_GOODS='$qt_goods2' where CD_ITEM='$cd_item2' and LOT_DATE='$lot_date2' and LOT_NUM='$lot_num2'";
            sqlsrv_query($connect, $Query_FinishUpdate, $params, $options);
        }

        unset($_SESSION['item_options']);
        unset($_SESSION['original_work_order']);
    }
    //한국 수기입력
    ELSEIF($bt21b1=="on") {
        $tab_sequence=2; 
        include '../TAB.php'; 

        $order_check2 = strtoupper(substr($item2, 0, 3));	

        //수기입력칸에 작업지시를 스캔하는 경우가 종종 있음
        if($order_check2=="WMO") {            
            echo "<script>alert(\"erp작업지시번호가 아닌 품번을 직접 입력해주세요!!\");location.href='field_complete.php';</script>";            
        }
        else {
            $item21b1 = trim(HyphenRemove(strtoupper($_POST["item21b1"])));  
            $size21b1 = $_POST["size21b1"]; 
            $note21b1= $_POST["note21b1"]; 
            $chkitem = Hyphen($item21b1);   //미사용 품번 확인용

            //미사용 품번이면 팝업창 발생 (신승화 과장 요청 사항 23.5.8)
            //더존에서는 미사용 품목을 작업지시 내리지 못하도록 제약을 가할 수 없음 (답변 받음)
            $Query_CheckOrder3 = "SELECT * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$chkitem' AND YN_USE='Y' and CD_PLANT='PL01'";              
            $Result_CheckOrder3 = sqlsrv_query($connect, $Query_CheckOrder3, $params, $options);
            $Count_CheckOrder3 = sqlsrv_num_rows($Result_CheckOrder3);

            IF($Count_CheckOrder3=='0') {
                echo "<script>alert(\"미사용 품번으로 작업지시를 내렸습니다. 신승화 과장에게 연락하세요!\");location.href='field_complete.php';</script>";
            }
            else {
                //품번 중복검사
                //수기입력에서만 중복된 품번이 있는 경우 수량변경 팝업창 생성
                $Query_ItemRepeatChk2 = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH where SORTING_DATE='$Hyphen_today' and CD_ITEM='$item21b1' and BARCODE like 'handwrite%'";              
                $Result_ItemRepeatChk2 = sqlsrv_query($connect, $Query_ItemRepeatChk2, $params, $options);
                $Count_ItemRepeatChk2 = sqlsrv_num_rows($Result_ItemRepeatChk2);

                //중복 시 수량변경 팝업창 생성
                IF($Count_ItemRepeatChk2 > 0) {   
                    echo "<script>location.href='field_complete.php?modi=Y&MODAL2=on&modal_Delivery_ItemCode2=$item21b1&size=$size21b1';</script>";
                }
                else {
                    //로트넘버 생성
                    $Query_LastLotNum = "SELECT TOP 1 * from CONNECT.dbo.FIELD_PROCESS_FINISH where CD_ITEM='$item21b1' and sorting_date='$Hyphen_today' order by LOT_NUM desc";              
                    $Result_LastLotNum = sqlsrv_query($connect, $Query_LastLotNum, $params, $options);	
                    $Count_LastLotNum = sqlsrv_num_rows($Result_LastLotNum);
                    $Data_LastLotNum = sqlsrv_fetch_array($Result_LastLotNum);         

                    $num21b1 = LotNumber2($Count_LastLotNum, $Data_LastLotNum['LOT_NUM'], 'direct');  
                    $handwrite = "handwrite".$NoHyphen_today.$num21b1;
                    
                    $Query_Directfinish = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, REJECT_GOODS, NOTE, BARCODE, AS_YN) VALUES('$item21b1', '$NoHyphen_today', '$num21b1', '$size21b1', '0', '$note21b1', '$handwrite', 'N')";              
                    sqlsrv_query($connect, $Query_Directfinish, $params, $options);   
                }    
            } 
        }
    }  
    //한국 삭제  
    ELSEIF($bt21b=="on") {
        $tab_sequence=2; 
        include '../TAB.php'; 

        //만약 내부품번이면 자동차 품번으로 변경
        //그래야 강정순jj이 엑셀 다운로드하여 erp업로드 할때 문제가 없음
        //내부품번은 A로 시작
        if(substr($cd_item2b, 0, 1)=='A') {
            $cd_item2b = ItemInfo($cd_item2b, 'STND');
        }

        //여기에서 하이폰을 제거해야 정상동작함
        $cd_item2b=HyphenRemove($cd_item2b);

        //최초에 엑셀을 출력하고 라벨을 발행하여 부착하는 형식이었음
        if($cd_item2b !='') {
            
            //DB 프라이머리키 설정으로 중복확인 절차 불필요
            $Query_DeleteRecord = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH_DEL(KIND, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, REJECT_GOODS, BARCODE) VALUES('K', '$cd_item2b', '$lot_date2b', '$lot_num2b', '$qt_goods2b', '0', '$item2b')";              
            sqlsrv_query($connect, $Query_DeleteRecord, $params, $options);

            $Query_FinishDelete = "DELETE FROM CONNECT.dbo.FIELD_PROCESS_FINISH WHERE CD_ITEM='$cd_item2b' AND LOT_DATE='$lot_date2b' AND LOT_NUM='$lot_num2b'";
            sqlsrv_query($connect, $Query_FinishDelete, $params, $options);

            $Query_RejectDelete = "DELETE CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$cd_item2b' AND LOT_DATE='$lot_date2b' AND LOT_NUM='$lot_num2b'";
            sqlsrv_query($connect, $Query_RejectDelete, $params, $options);
        }
        //23.7월 내부회계가 들어오고 ERP에서 출력하는 작업지시서에 바로 바코드가 인쇄되어 나옴 (바코드 정보는 작업지시번호 WMO~~~~)
        //이걸로 삭제하는 메커니즘이 없어 삭제가 안되는 에러가 24.1에 발생하여 추가함
        elseif(substr($item2b, 0, 1)=='W') {
            $Query_SelectRecord = "SELECT * FROM CONNECT.dbo.FIELD_PROCESS_FINISH WHERE BARCODE='$item2b'";              
            $Result_SelectRecord = sqlsrv_query($connect, $Query_SelectRecord, $params, $options);
            $Data_SelectRecord = sqlsrv_fetch_array($Result_SelectRecord);  

            $cd_item2b=$Data_SelectRecord['CD_ITEM'];
            $lot_date2b=$Data_SelectRecord['LOT_DATE'];
            $lot_num2b=$Data_SelectRecord['LOT_NUM'];
            $qt_goods2b=$Data_SelectRecord['QT_GOODS'];
            
            $Query_DeleteRecord = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH_DEL(KIND, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, REJECT_GOODS, BARCODE) VALUES('K', '$cd_item2b', '$lot_date2b', '$lot_num2b', '$qt_goods2b', '0', '$item2b')";              
            sqlsrv_query($connect, $Query_DeleteRecord, $params, $options);

            $Query_FinishDelete = "DELETE FROM CONNECT.dbo.FIELD_PROCESS_FINISH WHERE CD_ITEM='$cd_item2b' AND LOT_DATE='$lot_date2b' AND LOT_NUM='$lot_num2b'";
            sqlsrv_query($connect, $Query_FinishDelete, $params, $options);

            $Query_RejectDelete = "DELETE CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$cd_item2b' AND LOT_DATE='$lot_date2b' AND LOT_NUM='$lot_num2b'";
            sqlsrv_query($connect, $Query_RejectDelete, $params, $options);
        }
        //수기입력 삭제인 경우
        elseif($cd_item2b2 !='') {
            $Query_SelectRecord = "SELECT * FROM CONNECT.dbo.FIELD_PROCESS_FINISH WHERE CD_ITEM='$cd_item2b2' AND SORTING_DATE ='$Hyphen_today' AND BARCODE LIKE 'handwrite%'";              
            $Result_SelectRecord = sqlsrv_query($connect, $Query_SelectRecord, $params, $options);
            $Data_SelectRecord = sqlsrv_fetch_array($Result_SelectRecord);  

            //DB 프라이머리키 설정으로 중복확인 절차 불필요
            $Query_DeleteRecord = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH_DEL(KIND, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, REJECT_GOODS) VALUES('K', '$cd_item2b2', '$Data_SelectRecord[LOT_DATE]', '$Data_SelectRecord[LOT_NUM]', '$Data_SelectRecord[AT_GOODS]', '$Data_SelectRecord[REJECT_GOODS]')";              
            sqlsrv_query($connect, $Query_DeleteRecord, $params, $options);

            $Query_FinishDelete = "DELETE FROM CONNECT.dbo.FIELD_PROCESS_FINISH WHERE CD_ITEM='$cd_item2b2' AND LOT_DATE='$Data_SelectRecord[LOT_DATE]' AND LOT_NUM='$Data_SelectRecord[LOT_NUM]'";
            sqlsrv_query($connect, $Query_FinishDelete, $params, $options);

            $Query_RejectDelete = "DELETE CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM='$cd_item2b2' AND LOT_DATE='$Data_SelectRecord[LOT_DATE]' AND LOT_NUM='$Data_SelectRecord[LOT_NUM]'";
            sqlsrv_query($connect, $Query_RejectDelete, $params, $options);
        }
    }
    //한국 수정/저장
    ELSEIF($bt22=="on") {
        $tab_sequence=2; 
        include '../TAB.php'; 

        $limit2 = $_POST["until"];

        for($a=1; $a<$limit2; $a++)
        {
            $N_CD_ITEM2 = 'N_CD_ITEM'.$a;
            $N_LOT_DATE2 = 'N_LOT_DATE'.$a;
            $N_LOT_NUM2 = 'N_LOT_NUM'.$a;
            $pop_out2 = 'pop_out'.$a;
            $note_num2 = 'NOTE'.$a;
            $AS_STATUS = 'AS_STATUS'.$a;

            ${"N_CD_ITEM".$a} = $_POST[$N_CD_ITEM2];
            ${"LOT_DATE".$a} = $_POST[$N_LOT_DATE2];	
            ${"LOT_NUM".$a} = $_POST[$N_LOT_NUM2];	
            ${"pop_out".$a} = $_POST[$pop_out2];
            ${"NOTE".$a} = $_POST[$note_num2];
            ${"AS_STATUS".$a} = $_POST[$AS_STATUS];

            if(${"NOTE".$a} != '' OR ${"pop_out".$a} != '') {
                $Query_NoteUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH set NOTE='${"NOTE".$a}', ERROR_GOODS='${"pop_out".$a}' WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"N_CD_ITEM".$a}' AND LOT_DATE='${"LOT_DATE".$a}' AND LOT_NUM='${"LOT_NUM".$a}'";              
                sqlsrv_query($connect, $Query_NoteUpdate, $params, $options);
            }

            //양산 vs a/s
            IF(${"AS_STATUS".$a}=='Y') {
                $Query_InspectYN = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH set AS_YN='Y' WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"N_CD_ITEM".$a}' AND LOT_DATE='${"LOT_DATE".$a}' AND LOT_NUM='${"LOT_NUM".$a}'";              
                sqlsrv_query($connect, $Query_InspectYN, $params, $options);
            }
            else {
                $Query_InspectYN = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH set AS_YN='N' WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"N_CD_ITEM".$a}' AND LOT_DATE='${"LOT_DATE".$a}' AND LOT_NUM='${"LOT_NUM".$a}'";              
                sqlsrv_query($connect, $Query_InspectYN, $params, $options);
            }
        }
        
        //수정 독점화 상태 변경
        $Query_ModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='FieldCompleteKorea'";          
        sqlsrv_query($connect, $Query_ModifyUpdate2, $params, $options);		
    }
    //완료내역
    ELSEIF($bt31=="on") {
        $tab_sequence=3; 
        include '../TAB.php'; 

        //속도이슈로 인하여 db 튜닝함
        //따라서 금일 외 날짜를 조회하기 위해서는 금일포함하면 안됨
        //금일 처리하지 못한 데이터가 사라지는 경우를 방지하기 위해 7일 이후 데이터가 다른 테이블로 넘겨짐(sql에이전트)
        //이로 인하여 7일동안 데이터가 조회되지 않으므로 if조건문을 변경 (24.9.9)
        if($s_dt3>$Minus7Day and $e_dt3>$Minus7Day) {

            //검사완료내역(한국)
            $Query_kFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS, BARCODE, NOTE from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' group by CD_ITEM, LOT_DATE, BARCODE, NOTE";              
            $Result_kFinishHistory = sqlsrv_query($connect, $Query_kFinishHistory, $params, $options);		
            $Count_kFinishHistory = sqlsrv_num_rows($Result_kFinishHistory);

            //검사완료내역(베트남)
            $Query_vFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS, NOTE, INSPECT_YN from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' group by CD_ITEM, LOT_DATE, NOTE, INSPECT_YN";              
            $Result_vFinishHistory = sqlsrv_query($connect, $Query_vFinishHistory, $params, $options);		
            $Count_vFinishHistory = sqlsrv_num_rows($Result_vFinishHistory);

            //검사완료내역(중국)
            $Query_cFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS, NOTE from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' group by CD_ITEM, LOT_DATE, NOTE";              
            $Result_cFinishHistory = sqlsrv_query($connect, $Query_cFinishHistory, $params, $options);		
            $Count_cFinishHistory = sqlsrv_num_rows($Result_cFinishHistory);

            //검사완료세분화 내역(한국)
            $Query_kFinishHistoryDetail = "SELECT CD_ITEM, QT_GOODS, ERROR_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_kFinishHistoryDetail = sqlsrv_query($connect, $Query_kFinishHistoryDetail, $params, $options);		
            $Count_kFinishHistoryDetail = sqlsrv_num_rows($Result_kFinishHistoryDetail);

            for($j=1; $j<=$Count_kFinishHistoryDetail; $j++)
            {
                $Data_kFinishHistoryDetail = sqlsrv_fetch_array($Result_kFinishHistoryDetail); 

                $KIND = ItemInfo(strtoupper(Hyphen($Data_kFinishHistoryDetail['CD_ITEM'])), 'KIND');

                if($KIND=='SH') {
                    $SH=$SH+$Data_kFinishHistoryDetail['QT_GOODS'];
                    $ESH=$ESH+$Data_kFinishHistoryDetail['ERROR_GOODS'];
                }
                ELSEIF($KIND=='SW') {
                    $SW=$SW+$Data_kFinishHistoryDetail['QT_GOODS'];
                }
                ELSEIF($KIND=='VT') {
                    $VT=$VT+$Data_kFinishHistoryDetail['QT_GOODS'];
                }
                ELSE {
                    $ETC=$ETC+$Data_kFinishHistoryDetail['QT_GOODS'];
                }
            }        

            //검사완료세분화 내역(베트남)
            $Query_vFinishHistoryDetail = "SELECT CD_ITEM, QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE INSPECT_YN='Y' AND SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vFinishHistoryDetail = sqlsrv_query($connect, $Query_vFinishHistoryDetail, $params, $options);		
            $Count_vFinishHistoryDetail = sqlsrv_num_rows($Result_vFinishHistoryDetail);

            $Query_vFinishHistoryDetail2 = "SELECT CD_ITEM, QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE INSPECT_YN='N' AND SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vFinishHistoryDetail2 = sqlsrv_query($connect, $Query_vFinishHistoryDetail2, $params, $options);		
            $Count_vFinishHistoryDetail2 = sqlsrv_num_rows($Result_vFinishHistoryDetail2);

            $Query_vFinishHistoryDetail3 = "SELECT CD_ITEM, QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vFinishHistoryDetail3 = sqlsrv_query($connect, $Query_vFinishHistoryDetail3, $params, $options);		
            $Count_vFinishHistoryDetail3 = sqlsrv_num_rows($Result_vFinishHistoryDetail3);

            for($jv=1; $jv<=$Count_vFinishHistoryDetail; $jv++)
            {
                $Data_vFinishHistoryDetail = sqlsrv_fetch_array($Result_vFinishHistoryDetail); 

                //보통 bb제품은 하이폰 없는데 핸들은 하이폰이 있다
                if(strpos($Data_vFinishHistoryDetail['CD_ITEM'], "-") > 0) {
                    $vKIND = ItemInfo(strtoupper($Data_vFinishHistoryDetail['CD_ITEM']), 'KIND');
                }
                else {
                    $vKIND = ItemInfo(Hyphen($Data_vFinishHistoryDetail['CD_ITEM']), 'KIND');
                }

                if($vKIND=='SH') {
                    $vSH=$vSH+$Data_vFinishHistoryDetail['QT_GOODS'];
                }
                ELSEIF($vKIND=='SW') {
                    $vSW=$vSW+$Data_vFinishHistoryDetail['QT_GOODS'];
                }
            }   
            
            for($jv=1; $jv<=$Count_vFinishHistoryDetail2; $jv++)
            {
                $Data_vFinishHistoryDetail2 = sqlsrv_fetch_array($Result_vFinishHistoryDetail2); 

                //보통 bb제품은 하이폰 없는데 핸들은 하이폰이 있다
                if(strpos($Data_vFinishHistoryDetail2['CD_ITEM'], "-") > 0) {
                    $vKIND2 = ItemInfo(strtoupper($Data_vFinishHistoryDetail2['CD_ITEM']), 'KIND');
                }
                else {
                    $vKIND2 = ItemInfo(Hyphen($Data_vFinishHistoryDetail2['CD_ITEM']), 'KIND');
                }

                if($vKIND2=='SH') {
                    $vSH2=$vSH2+$Data_vFinishHistoryDetail2['QT_GOODS'];
                }
                ELSEIF($vKIND2=='SW') {
                    $vSW2=$vSW2+$Data_vFinishHistoryDetail2['QT_GOODS'];
                }
            }  

            for($jv=1; $jv<=$Count_vFinishHistoryDetail3; $jv++)
            {
                $Data_vFinishHistoryDetail3 = sqlsrv_fetch_array($Result_vFinishHistoryDetail3); 

                //보통 bb제품은 하이폰 없는데 핸들은 하이폰이 있다
                if(strpos($Data_vFinishHistoryDetail3['CD_ITEM'], "-") > 0) {
                    $vKIND3 = ItemInfo(strtoupper($Data_vFinishHistoryDetail3['CD_ITEM']), 'KIND');
                }
                else {
                    $vKIND3 = ItemInfo(Hyphen($Data_vFinishHistoryDetail3['CD_ITEM']), 'KIND');
                }

                if($vKIND3=='SH') {
                    $vSH3=$vSH3+$Data_vFinishHistoryDetail3['QT_GOODS'];
                }
                ELSEIF($vKIND3=='SW') {
                    $vSW3=$vSW3+$Data_vFinishHistoryDetail3['QT_GOODS'];
                }
                ELSE {
                    $vETC3=$vETC3+$Data_vFinishHistoryDetail3['QT_GOODS'];
                }
            }  

            //작업개별수량(한국)
            $Query_PcsCount= "SELECT SUM(QT_GOODS) AS QT_GOODS, SUM(ERROR_GOODS) AS ERROR_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_PcsCount = sqlsrv_query($connect, $Query_PcsCount, $params, $options);		
            $Data_PcsCount = sqlsrv_fetch_array($Result_PcsCount);  

            //작업개별수량(베트남)-유검
            $Query_vPcsCount= "SELECT SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE INSPECT_YN='Y' AND SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vPcsCount = sqlsrv_query($connect, $Query_vPcsCount, $params, $options);		
            $Data_vPcsCount = sqlsrv_fetch_array($Result_vPcsCount);  

            //작업개별수량(베트남)-무검
            $Query_vPcsCount2= "SELECT SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE INSPECT_YN='N' AND SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vPcsCount2 = sqlsrv_query($connect, $Query_vPcsCount2, $params, $options);		
            $Data_vPcsCount2 = sqlsrv_fetch_array($Result_vPcsCount2);

            //작업개별수량(베트남)-유검+무검
            $Query_vPcsCount3= "SELECT SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vPcsCount3 = sqlsrv_query($connect, $Query_vPcsCount3, $params, $options);		
            $Data_vPcsCount3 = sqlsrv_fetch_array($Result_vPcsCount3);

            //작업개별수량(중국)
            $Query_cPcsCount= "SELECT SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_cPcsCount = sqlsrv_query($connect, $Query_cPcsCount, $params, $options);		
            $Data_cPcsCount = sqlsrv_fetch_array($Result_cPcsCount);  
        }
        elseif($s_dt3<=$Minus7Day and $e_dt3<=$Minus7Day) {
            //검사완료내역(한국)
            $Query_kFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS, BARCODE, NOTE from CONNECT.dbo.FIELD_PROCESS_FINISH2 WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' group by CD_ITEM, LOT_DATE, BARCODE, NOTE";              
            $Result_kFinishHistory = sqlsrv_query($connect, $Query_kFinishHistory, $params, $options);		
            $Count_kFinishHistory = sqlsrv_num_rows($Result_kFinishHistory);

            //검사완료내역(베트남)
            $Query_vFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS, NOTE, INSPECT_YN from CONNECT.dbo.FIELD_PROCESS_FINISH_V2 WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' group by CD_ITEM, LOT_DATE, NOTE, INSPECT_YN";              
            $Result_vFinishHistory = sqlsrv_query($connect, $Query_vFinishHistory, $params, $options);		
            $Count_vFinishHistory = sqlsrv_num_rows($Result_vFinishHistory);

            //검사완료내역(중국)
            $Query_cFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS, NOTE from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' group by CD_ITEM, LOT_DATE, NOTE";              
            $Result_cFinishHistory = sqlsrv_query($connect, $Query_cFinishHistory, $params, $options);		
            $Count_cFinishHistory = sqlsrv_num_rows($Result_cFinishHistory);

            //검사완료세분화 내역(한국)
            $Query_kFinishHistoryDetail = "SELECT CD_ITEM, QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH2 WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_kFinishHistoryDetail = sqlsrv_query($connect, $Query_kFinishHistoryDetail, $params, $options);		
            $Count_kFinishHistoryDetail = sqlsrv_num_rows($Result_kFinishHistoryDetail);

            for($j=1; $j<=$Count_kFinishHistoryDetail; $j++)
            {
                $Data_kFinishHistoryDetail = sqlsrv_fetch_array($Result_kFinishHistoryDetail); 

                $KIND = ItemInfo(strtoupper(Hyphen($Data_kFinishHistoryDetail['CD_ITEM'])), 'KIND');

                if($KIND=='SH') {
                    $SH=$SH+$Data_kFinishHistoryDetail['QT_GOODS'];
                }
                ELSEIF($KIND=='SW') {
                    $SW=$SW+$Data_kFinishHistoryDetail['QT_GOODS'];
                }
                ELSEIF($KIND=='VT') {
                    $VT=$VT+$Data_kFinishHistoryDetail['QT_GOODS'];
                }
                ELSE {
                    $ETC=$ETC+$Data_kFinishHistoryDetail['QT_GOODS'];
                }
            }        

            //검사완료세분화 내역(베트남)
            $Query_vFinishHistoryDetail = "SELECT CD_ITEM, QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V2 WHERE INSPECT_YN='Y' AND SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vFinishHistoryDetail = sqlsrv_query($connect, $Query_vFinishHistoryDetail, $params, $options);		
            $Count_vFinishHistoryDetail = sqlsrv_num_rows($Result_vFinishHistoryDetail);

            $Query_vFinishHistoryDetail2 = "SELECT CD_ITEM, QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V2 WHERE INSPECT_YN='N' AND SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vFinishHistoryDetail2 = sqlsrv_query($connect, $Query_vFinishHistoryDetail2, $params, $options);		
            $Count_vFinishHistoryDetail2 = sqlsrv_num_rows($Result_vFinishHistoryDetail2);

            $Query_vFinishHistoryDetail3 = "SELECT CD_ITEM, QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V2 WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vFinishHistoryDetail3 = sqlsrv_query($connect, $Query_vFinishHistoryDetail3, $params, $options);		
            $Count_vFinishHistoryDetail3 = sqlsrv_num_rows($Result_vFinishHistoryDetail3);

            for($jv=1; $jv<=$Count_vFinishHistoryDetail; $jv++)
            {
                $Data_vFinishHistoryDetail = sqlsrv_fetch_array($Result_vFinishHistoryDetail); 

                //보통 bb제품은 하이폰 없는데 핸들은 하이폰이 있다
                if(strpos($Data_vFinishHistoryDetail['CD_ITEM'], "-") > 0) {
                    $vKIND = ItemInfo(strtoupper($Data_vFinishHistoryDetail['CD_ITEM']), 'KIND');
                }
                else {
                    $vKIND = ItemInfo(Hyphen($Data_vFinishHistoryDetail['CD_ITEM']), 'KIND');
                }

                if($vKIND=='SH') {
                    $vSH=$vSH+$Data_vFinishHistoryDetail['QT_GOODS'];
                }
                ELSEIF($vKIND=='SW') {
                    $vSW=$vSW+$Data_vFinishHistoryDetail['QT_GOODS'];
                }
            }   
            
            for($jv=1; $jv<=$Count_vFinishHistoryDetail2; $jv++)
            {
                $Data_vFinishHistoryDetail2 = sqlsrv_fetch_array($Result_vFinishHistoryDetail2); 

                //보통 bb제품은 하이폰 없는데 핸들은 하이폰이 있다
                if(strpos($Data_vFinishHistoryDetail2['CD_ITEM'], "-") > 0) {
                    $vKIND2 = ItemInfo(strtoupper($Data_vFinishHistoryDetail2['CD_ITEM']), 'KIND');
                }
                else {
                    $vKIND2 = ItemInfo(Hyphen($Data_vFinishHistoryDetail2['CD_ITEM']), 'KIND');
                }

                if($vKIND2=='SH') {
                    $vSH2=$vSH2+$Data_vFinishHistoryDetail2['QT_GOODS'];
                }
                ELSEIF($vKIND2=='SW') {
                    $vSW2=$vSW2+$Data_vFinishHistoryDetail2['QT_GOODS'];
                }
            }  

            for($jv=1; $jv<=$Count_vFinishHistoryDetail3; $jv++)
            {
                $Data_vFinishHistoryDetail3 = sqlsrv_fetch_array($Result_vFinishHistoryDetail3); 

                //보통 bb제품은 하이폰 없는데 핸들은 하이폰이 있다
                if(strpos($Data_vFinishHistoryDetail3['CD_ITEM'], "-") > 0) {
                    $vKIND3 = ItemInfo(strtoupper($Data_vFinishHistoryDetail3['CD_ITEM']), 'KIND');
                }
                else {
                    $vKIND3 = ItemInfo(Hyphen($Data_vFinishHistoryDetail3['CD_ITEM']), 'KIND');
                }

                if($vKIND3=='SH') {
                    $vSH3=$vSH3+$Data_vFinishHistoryDetail3['QT_GOODS'];
                }
                ELSEIF($vKIND3=='SW') {
                    $vSW3=$vSW3+$Data_vFinishHistoryDetail3['QT_GOODS'];
                }
                ELSE {
                    $vETC3=$vETC3+$Data_vFinishHistoryDetail3['QT_GOODS'];
                }
            }  

            //작업개별수량(한국)
            $Query_PcsCount= "SELECT SUM(QT_GOODS) AS QT_GOODS, SUM(ERROR_GOODS) AS ERROR_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH2 WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_PcsCount = sqlsrv_query($connect, $Query_PcsCount, $params, $options);		
            $Data_PcsCount = sqlsrv_fetch_array($Result_PcsCount);  

            //작업개별수량(베트남)-유검
            $Query_vPcsCount= "SELECT SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V2 WHERE INSPECT_YN='Y' AND SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vPcsCount = sqlsrv_query($connect, $Query_vPcsCount, $params, $options);		
            $Data_vPcsCount = sqlsrv_fetch_array($Result_vPcsCount);  

            //작업개별수량(베트남)-무검
            $Query_vPcsCount2= "SELECT SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V2 WHERE INSPECT_YN='N' AND SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vPcsCount2 = sqlsrv_query($connect, $Query_vPcsCount2, $params, $options);		
            $Data_vPcsCount2 = sqlsrv_fetch_array($Result_vPcsCount2);

            //작업개별수량(베트남)-유검+무검
            $Query_vPcsCount3= "SELECT SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V2 WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_vPcsCount3 = sqlsrv_query($connect, $Query_vPcsCount3, $params, $options);		
            $Data_vPcsCount3 = sqlsrv_fetch_array($Result_vPcsCount3);

            //작업개별수량(중국)
            $Query_cPcsCount= "SELECT SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
            $Result_cPcsCount = sqlsrv_query($connect, $Query_cPcsCount, $params, $options);		
            $Data_cPcsCount = sqlsrv_fetch_array($Result_cPcsCount); 
        }
        else {
            echo "<script>alert(\"DB튜닝으로 금일부터 7일전 보다 큰 검색범위 데이터 조회를 하고 싶은 경우 아래와 같이 나눠서 검색해야 합니다.\\n  1. 금일부터 7일전 까지의 검색범위로 검색\\n  2. 원하는 날짜 부터 금일에서 8일전 까지의 검색범위\\n ex) 금일 24.9.23, 원하는 검색범위 24.9.1~24.9.20 \\n  1. 24.9.17~24.9.20\\n  2. 24.9.1~24.9.16 \");location.href='field_complete.php';</script>";
        }
    }
    //ERP 엑셀 다운로드
    ELSEIF($bt32=="on") {
        $tab_sequence=3; 
        include '../TAB.php'; 

        echo "<script>location.href='field_complete_excel.php?s_dt=".$s_dt3."&e_dt=".$e_dt3."';</script>";        
    }
    //한국 불량입력
    ELSEIF (isset($_POST['mbt1']) && $_POST['mbt1'] == 'on') {        
        // --- 1. 입력 데이터 안전하게 가져오기 ---
        $item_code = $_POST['kmodal_ItemCode'] ?? null;
        $lot_date = $_POST['kmodal_LotDate'] ?? null;
        $lot_num = $_POST['kmodal_LotNum'] ?? null;
        $barcode = $_POST['kmodal_ERP'] ?? null;

        // 필수 식별값이 하나라도 없으면 즉시 중단
        if (empty($item_code) || empty($lot_date) || empty($lot_num) || empty($barcode)) {
            echo "<script>alert('품번, 로트날짜, 로트번호, 바코드 정보를 불러오지 못했습니다. 다시 시도해주세요.'); location.href='field_complete.php';</script>";
            exit;
        }

        // --- 2. 불량 데이터 구조화 및 합계 계산 ---
        // 불량 유형을 배열로 정의하여 코드 반복 제거 및 관리 용이성 확보
        $reject_definitions = [
            ['code' => 1, 'type' => '폐기', 'qty_name' => 'mi1', 'note_name' => 'mn1'],
            ['code' => 2, 'type' => '폐기', 'qty_name' => 'mi2', 'note_name' => 'mn2'],
            ['code' => 3, 'type' => '폐기', 'qty_name' => 'mi3', 'note_name' => 'mn3'],
            ['code' => 4, 'type' => '폐기', 'qty_name' => 'mi4', 'note_name' => 'mn4'],
            ['code' => 5, 'type' => '리워크', 'qty_name' => 'mi5', 'note_name' => 'mn5'],
            ['code' => 6, 'type' => '폐기', 'qty_name' => 'mi6', 'note_name' => 'mn6'],
            ['code' => 7, 'type' => '폐기', 'qty_name' => 'mi7', 'note_name' => 'mn7'],
            ['code' => 8, 'type' => '폐기', 'qty_name' => 'mi8', 'note_name' => 'mn8'],
        ];

        $rejects_to_insert = [];
        $total_rejects = 0;
        $total_disuse = 0;
        $total_rework = 0;

        foreach ($reject_definitions as $def) {
            $qty = (int)($_POST[$def['qty_name']] ?? 0); // 정수로 변환하여 안정성 확보
            if ($qty > 0) {
                $note = $_POST[$def['note_name']] ?? '';
                $rejects_to_insert[] = [
                    'code' => $def['code'],
                    'qty' => $qty,
                    'note' => $note,
                    'type' => $def['type']
                ];
                // 합계 계산
                $total_rejects += $qty;
                if ($def['type'] === '폐기') {
                    $total_disuse += $qty;
                } else { // '리워크'
                    $total_rework += $qty;
                }
            }
        }

        // --- 3. 데이터베이스 작업 (트랜잭션으로 안정성 보장) ---
        sqlsrv_begin_transaction($connect); // ✨ 트랜잭션 시작: 모든 작업이 한 묶음으로 처리됨

        try {
            // (쿼리 1) 기존 불량 기록 삭제
            $query_delete = "DELETE FROM CONNECT.dbo.FIELD_PROCESS_REJECT WHERE CD_ITEM = ? AND LOT_DATE = ? AND LOT_NUM = ?";
            sqlsrv_query($connect, $query_delete, [$item_code, $lot_date, $lot_num]);

            // (쿼리 2) 새로운 불량 기록들을 반복문으로 INSERT (유지보수 용이)
            $query_insert = "
                INSERT INTO CONNECT.dbo.FIELD_PROCESS_REJECT
                (CD_ITEM, LOT_DATE, LOT_NUM, REJECT_CODE, REJECT_GOODS, REJECT_NOTE, RESULT_NOTE)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            foreach ($rejects_to_insert as $reject) {
                sqlsrv_query($connect, $query_insert, [
                    $item_code, $lot_date, $lot_num, $reject['code'], $reject['qty'], $reject['note'], $reject['type']
                ]);
            }
            
            // (쿼리 3) 업데이트에 필요한 현재 완료 수량 조회
            $query_select_finish = "SELECT QT_GOODS, PRINT_YN, PRINT_QT FROM CONNECT.dbo.FIELD_PROCESS_FINISH WHERE CD_ITEM = ? AND LOT_DATE = ? AND LOT_NUM = ? AND BARCODE = ?";
            $stmt_select = sqlsrv_query($connect, $query_select_finish, [$item_code, $lot_date, $lot_num, $barcode]);
            $data_finish = sqlsrv_fetch_array($stmt_select, SQLSRV_FETCH_ASSOC);

            // (쿼리 4) 최종 합계 데이터를 FIELD_PROCESS_FINISH 테이블에 한 번에 업데이트
            $update_fields = [
                'REJECT_GOODS' => $total_rejects,
                'REJECT_DISUSE' => $total_disuse,
                'REJECT_WAIT' => $total_rework,
                'REJECT_REWORK' => 0 // 기존 로직을 따라 0으로 초기화
            ];

            // 조건부로 PRINT_YN 상태 업데이트 필드 추가
            if ($data_finish) {
                if ($data_finish['QT_GOODS'] == $total_disuse) {
                    $update_fields['PRINT_YN'] = 'Y';
                    $update_fields['PRINT_QT'] = 0;
                } elseif ($data_finish['QT_GOODS'] != $total_disuse && $data_finish['PRINT_YN'] == 'Y' && $data_finish['PRINT_QT'] == 0) {
                    $update_fields['PRINT_YN'] = 'P';
                }
            }
            
            $set_clauses = [];
            $update_params = [];
            foreach($update_fields as $field => $value) {
                $set_clauses[] = "[$field] = ?";
                $update_params[] = $value;
            }
            $update_params = array_merge($update_params, [$item_code, $lot_date, $lot_num, $barcode]);

            $query_update_finish = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH SET " . implode(', ', $set_clauses) . " WHERE CD_ITEM = ? AND LOT_DATE = ? AND LOT_NUM = ? AND BARCODE = ?";
            sqlsrv_query($connect, $query_update_finish, $update_params);

            // 모든 쿼리가 성공적으로 실행되면 최종 확정
            sqlsrv_commit($connect);
            echo "<script>alert('불량 등록이 완료되었습니다.'); location.href='field_complete.php';</script>";

        } catch (Exception $e) {
            // 중간에 하나라도 오류가 발생하면 모든 작업을 취소 (데이터 무결성 보장)
            sqlsrv_rollback($connect);
            echo "<script>alert('오류가 발생하여 모든 작업이 취소되었습니다: " . $e->getMessage() . "'); location.href='field_complete.php';</script>";
        }
    }
    //한국 완료수량 변경
    ELSEIF($mbt2=="on") {
        $tab_sequence=2; 
        include '../TAB.php';  
        
        $Query_PUpdate2 = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"N_CD_ITEM".$a}' and BARCODE like 'handwrite%'";              
        $Result_PUpdate2 = sqlsrv_query($connect, $Query_PUpdate2, $params, $options);	
        $Data_PUpdate2 = sqlsrv_fetch_array($Result_PUpdate2); 

        if($qt_goods5 != $Data_PUpdate2['PRINT_QT']) {
            $Query_QuantityUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH set QT_GOODS='$qt_goods5', PRINT_YN='P' WHERE CD_ITEM='$modal_ItemCode2' AND SORTING_DATE='$Hyphen_today' and BARCODE like 'handwrite%'";              
            sqlsrv_query($connect, $Query_QuantityUpdate, $params, $options);
        }
        ELSE {
            $Query_QuantityUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH set QT_GOODS='$qt_goods5' WHERE CD_ITEM='$modal_ItemCode2' AND SORTING_DATE='$Hyphen_today' and BARCODE like 'handwrite%'";              
            sqlsrv_query($connect, $Query_QuantityUpdate, $params, $options);
        }

        //수정 독점화 상태 변경
        $Query_ModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='FieldCompleteKorea'";          
        sqlsrv_query($connect, $Query_ModifyUpdate2, $params, $options);
    }
    //불량내역
    ELSEIF($bt41=="on") {
        $tab_sequence=4; 
        include '../TAB.php'; 

        //불량내역(한국)
        $Query_Reject = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE SORTING_DATE between '$s_dt4' and '$e_dt4'";              
        $Result_Reject = sqlsrv_query($connect, $Query_Reject, $params, $options);		
        $Count_Reject = sqlsrv_num_rows($Result_Reject);

        //불량내역(베트남)
        $Query_vReject = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE SORTING_DATE between '$s_dt4' and '$e_dt4'";              
        $Result_vReject = sqlsrv_query($connect, $Query_vReject, $params, $options);		
        $Count_vReject = sqlsrv_num_rows($Result_vReject);

        //불량내역(중국)
        $Query_cReject = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_C WHERE SORTING_DATE between '$s_dt4' and '$e_dt4'";              
        $Result_cReject = sqlsrv_query($connect, $Query_cReject, $params, $options);		
        $Count_cReject = sqlsrv_num_rows($Result_cReject);

        //작업개별수량(한국)
        $Query_RejectPcsCount= "SELECT SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE SORTING_DATE between '$s_dt4' and '$e_dt4'";              
        $Result_RejectPcsCount = sqlsrv_query($connect, $Query_RejectPcsCount, $params, $options);		
        $Data_RejectPcsCount = sqlsrv_fetch_array($Result_RejectPcsCount);  

        //작업개별수량(베트남)
        $Query_vRejectPcsCount= "SELECT SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE SORTING_DATE between '$s_dt4' and '$e_dt4'";              
        $Result_vRejectPcsCount = sqlsrv_query($connect, $Query_vRejectPcsCount, $params, $options);		
        $Data_vRejectPcsCount = sqlsrv_fetch_array($Result_vRejectPcsCount);  

        //작업개별수량(중국)
        $Query_cRejectPcsCount= "SELECT SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_REJECT_C WHERE SORTING_DATE between '$s_dt4' and '$e_dt4'";              
        $Result_cRejectPcsCount = sqlsrv_query($connect, $Query_cRejectPcsCount, $params, $options);		
        $Data_cRejectPcsCount = sqlsrv_fetch_array($Result_cRejectPcsCount);  
    }
    //불량내역 수정/저장
    ELSEIF($bt42=="on") {
        $tab_sequence=4; 
        include '../TAB.php';         

        $limit4 = $_POST["until4"];
        $vlimit4 = $_POST["vuntil4"];
        $climit4 = $_POST["cuntil4"];

        //한국
        for($a=1; $a<$limit4; $a++)
        {
            $K_STATUS = 'K_STATUS'.$a;
            $badwork_kno = 'badwork_kno'.$a;
            ${"K_STATUS".$a} = $_POST[$K_STATUS];
            ${"badwork_kno".$a} = $_POST[$badwork_kno];

            if(${"K_STATUS".$a} != '') {
                $Query_kStatusUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_REJECT set RESULT_NOTE='${"K_STATUS".$a}' WHERE NO='${"badwork_kno".$a}'";              
                sqlsrv_query($connect, $Query_kStatusUpdate, $params, $options);

                //검사완료 테이블 불량세부내역 업데이트//
                $Query_kReworkUpdate = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE NO='${"badwork_kno".$a}'";              
                $Result_kReworkUpdate = sqlsrv_query($connect, $Query_kReworkUpdate, $params, $options);		
                $Data_kReworkUpdate = sqlsrv_fetch_array($Result_kReworkUpdate);

                //불량(리워크) 등록 후 라벨 프린트하고 불량을 폐기로 변경하는 경우 쓰레기 로그가 포장에 남아 있는것을 방지하기 위함
                $Query_kPrintStatus = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE CD_ITEM='$Data_kReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_kReworkUpdate[LOT_DATE]' and LOT_NUM='$Data_kReworkUpdate[LOT_NUM]'";              
                $Result_kPrintStatus = sqlsrv_query($connect, $Query_kPrintStatus, $params, $options);		
                $Data_kPrintStatus = sqlsrv_fetch_array($Result_kPrintStatus);
                
                IF($Data_kPrintStatus['PRINT_YN']=='W' AND $Data_kReworkUpdate['REJECT_CODE']=='5' AND ${"K_STATUS".$a}=='폐기') {
                    $Query_kPrintStatusUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH SET PRINT_YN='Y' WHERE CD_ITEM='$Data_kReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_kReworkUpdate[LOT_DATE]' and LOT_NUM='$Data_kReworkUpdate[LOT_NUM]'";              
                    sqlsrv_query($connect, $Query_kPrintStatusUpdate, $params, $options);	
                }
                ELSEIF($Data_kPrintStatus['PRINT_YN']=='Y' AND $Data_kReworkUpdate['REJECT_CODE']=='5' AND ${"K_STATUS".$a}=='리워크') {
                    $Query_kPrintStatusUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH SET PRINT_YN='W' WHERE CD_ITEM='$Data_kReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_kReworkUpdate[LOT_DATE]' and LOT_NUM='$Data_kReworkUpdate[LOT_NUM]'";              
                    sqlsrv_query($connect, $Query_kPrintStatusUpdate, $params, $options);
                }

                //폐기완료 후 포장라벨을 발행하고 리워크완료로 바꾸는 경우 print_yn이 y인것을 확인하여 경고창이 뜨게끔 하려고 했으나
                //현헙에서 실제 폐기한걸 다시 리워크해서 사용하자고 하는것을 기록해야 하는데 이것에 제약을 걸어버리면 생략하는 경우가 발생할 수 있어 제약을 가하지 않는것으로 함
                //단 위와같은 행위를 했을때 포장라벨 발행쪽에서 라벨 발행을 해도 계속 데이터가 남아 있는 경우가 발생했는데 검사 베트남탭에서 이를 재현해보려 했으나 되지 않음...  (한국 데이터가 이런 오류를 일으켯음)
                //향후 동일한 문제가 발생할 시 확인 필요
                
                //폐기
                $Query_kDisuse = "SELECT ISNULL(sum(REJECT_GOODS), 0) AS KSUM FROM [CONNECT].[dbo].[FIELD_PROCESS_REJECT] where CD_ITEM='$Data_kReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_kReworkUpdate[LOT_DATE]' and LOT_NUM='$Data_kReworkUpdate[LOT_NUM]' and RESULT_NOTE='폐기'";              
                $Result_kDisuse = sqlsrv_query($connect, $Query_kDisuse, $params, $options);	
                $Data_kDisuse = sqlsrv_fetch_array($Result_kDisuse);                
                
                $Query_kDisuse2 = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH SET REJECT_DISUSE='$Data_kDisuse[KSUM]' WHERE CD_ITEM='$Data_kReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_kReworkUpdate[LOT_DATE]' and LOT_NUM='$Data_kReworkUpdate[LOT_NUM]'";              
                sqlsrv_query($connect, $Query_kDisuse2, $params, $options);	

                //리워크
                $Query_kWait = "SELECT ISNULL(sum(REJECT_GOODS), 0) AS KSUM FROM [CONNECT].[dbo].[FIELD_PROCESS_REJECT] where CD_ITEM='$Data_kReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_kReworkUpdate[LOT_DATE]' and LOT_NUM='$Data_kReworkUpdate[LOT_NUM]' and RESULT_NOTE='리워크'";              
                $Result_kWait = sqlsrv_query($connect, $Query_kWait, $params, $options);	
                $Data_kWait = sqlsrv_fetch_array($Result_kWait);                
                
                $Query_kWait2 = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH SET REJECT_WAIT='$Data_kWait[KSUM]' WHERE CD_ITEM='$Data_kReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_kReworkUpdate[LOT_DATE]' and LOT_NUM='$Data_kReworkUpdate[LOT_NUM]'";              
                sqlsrv_query($connect, $Query_kWait2, $params, $options);	

                //리워크완료
                $Query_kRework = "SELECT ISNULL(sum(REJECT_GOODS), 0) AS KSUM FROM [CONNECT].[dbo].[FIELD_PROCESS_REJECT] where CD_ITEM='$Data_kReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_kReworkUpdate[LOT_DATE]' and LOT_NUM='$Data_kReworkUpdate[LOT_NUM]' and RESULT_NOTE='리워크완료'";              
                $Result_kRework = sqlsrv_query($connect, $Query_kRework, $params, $options);	
                $Data_kRework = sqlsrv_fetch_array($Result_kRework);                
                
                $Query_kRework2 = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH SET REJECT_REWORK='$Data_kRework[KSUM]' WHERE CD_ITEM='$Data_kReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_kReworkUpdate[LOT_DATE]' and LOT_NUM='$Data_kReworkUpdate[LOT_NUM]'";              
                sqlsrv_query($connect, $Query_kRework2, $params, $options);	              	
                //////////////////////////////////////
            }
        } 

        //베트남
        for($a=1; $a<$vlimit4; $a++)
        {
            $V_STATUS = 'V_STATUS'.$a;
            $badwork_vno = 'badwork_vno'.$a;
            ${"V_STATUS".$a} = $_POST[$V_STATUS];
            ${"badwork_vno".$a} = $_POST[$badwork_vno];

            if(${"V_STATUS".$a} != '') {
                $Query_vStatusUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_REJECT_V set RESULT_NOTE='${"V_STATUS".$a}' WHERE NO='${"badwork_vno".$a}'";              
                sqlsrv_query($connect, $Query_vStatusUpdate, $params, $options);

                //검사완료 테이블 불량세부내역 업데이트//
                $Query_vReworkUpdate = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE NO='${"badwork_vno".$a}'";              
                $Result_vReworkUpdate = sqlsrv_query($connect, $Query_vReworkUpdate, $params, $options);		
                $Data_vReworkUpdate = sqlsrv_fetch_array($Result_vReworkUpdate);

                //불량(리워크) 등록 후 라벨 프린트하고 불량을 폐기로 변경하는 경우 쓰레기 로그가 포장에 남아 있는것을 방지하기 위함
                $Query_vPrintStatus = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE CD_ITEM='$Data_vReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_vReworkUpdate[LOT_DATE]'";              
                $Result_vPrintStatus = sqlsrv_query($connect, $Query_vPrintStatus, $params, $options);		
                $Data_vPrintStatus = sqlsrv_fetch_array($Result_vPrintStatus);
                
                IF($Data_vPrintStatus['PRINT_YN']=='W' AND $Data_vReworkUpdate['REJECT_CODE']=='5' AND ${"V_STATUS".$a}=='폐기') {
                    $Query_vPrintStatusUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V SET PRINT_YN='Y' WHERE CD_ITEM='$Data_vReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_vReworkUpdate[LOT_DATE]'";              
                    sqlsrv_query($connect, $Query_vPrintStatusUpdate, $params, $options);	
                }
                ELSEIF($Data_vPrintStatus['PRINT_YN']=='Y' AND $Data_vReworkUpdate['REJECT_CODE']=='5' AND ${"V_STATUS".$a}=='리워크') {
                    $Query_vPrintStatusUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V SET PRINT_YN='W' WHERE CD_ITEM='$Data_vReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_vReworkUpdate[LOT_DATE]'";              
                    sqlsrv_query($connect, $Query_vPrintStatusUpdate, $params, $options);
                }

                //폐기
                $Query_vDisuse = "SELECT ISNULL(sum(REJECT_GOODS), 0) AS VSUM FROM [CONNECT].[dbo].[FIELD_PROCESS_REJECT_V] where CD_ITEM='$Data_vReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_vReworkUpdate[LOT_DATE]' and RESULT_NOTE='폐기'";              
                $Result_vDisuse = sqlsrv_query($connect, $Query_vDisuse, $params, $options);	
                $Data_vDisuse = sqlsrv_fetch_array($Result_vDisuse);                
                
                $Query_vDisuse2 = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V SET REJECT_DISUSE='$Data_vDisuse[VSUM]' WHERE CD_ITEM='$Data_vReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_vReworkUpdate[LOT_DATE]'";              
                sqlsrv_query($connect, $Query_vDisuse2, $params, $options);	

                //리워크
                $Query_vWait = "SELECT ISNULL(sum(REJECT_GOODS), 0) AS VSUM FROM [CONNECT].[dbo].[FIELD_PROCESS_REJECT_V] where CD_ITEM='$Data_vReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_vReworkUpdate[LOT_DATE]' and RESULT_NOTE='리워크'";              
                $Result_vWait = sqlsrv_query($connect, $Query_vWait, $params, $options);	
                $Data_vWait = sqlsrv_fetch_array($Result_vWait);                
                
                $Query_vWait2 = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V SET REJECT_WAIT='$Data_vWait[VSUM]' WHERE CD_ITEM='$Data_vReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_vReworkUpdate[LOT_DATE]'";              
                sqlsrv_query($connect, $Query_vWait2, $params, $options);	

                //리워크완료
                $Query_vRework = "SELECT ISNULL(sum(REJECT_GOODS), 0) AS VSUM FROM [CONNECT].[dbo].[FIELD_PROCESS_REJECT_V] where CD_ITEM='$Data_vReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_vReworkUpdate[LOT_DATE]' and RESULT_NOTE='리워크완료'";              
                $Result_vRework = sqlsrv_query($connect, $Query_vRework, $params, $options);	
                $Data_vRework = sqlsrv_fetch_array($Result_vRework);                
                
                $Query_vRework2 = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V SET REJECT_REWORK='$Data_vRework[VSUM]' WHERE CD_ITEM='$Data_vReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_vReworkUpdate[LOT_DATE]'";              
                sqlsrv_query($connect, $Query_vRework2, $params, $options);	              	
                //////////////////////////////////////
            }
        } 

        //중국
        for($a=1; $a<$climit4; $a++)
        {
            $C_STATUS = 'C_STATUS'.$a;
            $badwork_cno = 'badwork_cno'.$a;
            ${"K_STATUS".$a} = $_POST[$C_STATUS];
            ${"badwork_cno".$a} = $_POST[$badwork_cno];

            if(${"C_STATUS".$a} != '') {
                $Query_cStatusUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_REJECT_C set RESULT_NOTE='${"C_STATUS".$a}', PRINT_YN='W' WHERE NO='${"badwork_cno".$a}'";              
                sqlsrv_query($connect, $Query_cStatusUpdate, $params, $options);

                //검사완료 테이블 불량세부내역 업데이트//
                $Query_cReworkUpdate = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_C WHERE NO='${"badwork_cno".$a}'";              
                $Result_cReworkUpdate = sqlsrv_query($connect, $Query_cReworkUpdate, $params, $options);		
                $Data_cReworkUpdate = sqlsrv_fetch_array($Result_cReworkUpdate);

                //불량(리워크) 등록 후 라벨 프린트하고 불량을 폐기로 변경하는 경우 쓰레기 로그가 포장에 남아 있는것을 방지하기 위함
                $Query_cPrintStatus = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE CD_ITEM='$Data_cReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_cReworkUpdate[LOT_DATE]'";              
                $Result_cPrintStatus = sqlsrv_query($connect, $Query_cPrintStatus, $params, $options);		
                $Data_cPrintStatus = sqlsrv_fetch_array($Result_cPrintStatus);
                
                IF($Data_cPrintStatus['PRINT_YN']=='W' AND $Data_cReworkUpdate['REJECT_CODE']=='5' AND ${"C_STATUS".$a}=='폐기') {
                    $Query_cPrintStatusUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_C SET PRINT_YN='Y' WHERE CD_ITEM='$Data_cReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_cReworkUpdate[LOT_DATE]'";              
                    sqlsrv_query($connect, $Query_cPrintStatusUpdate, $params, $options);	
                }
                ELSEIF($Data_cPrintStatus['PRINT_YN']=='Y' AND $Data_cReworkUpdate['REJECT_CODE']=='5' AND ${"C_STATUS".$a}=='리워크') {
                    $Query_cPrintStatusUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_C SET PRINT_YN='W' WHERE CD_ITEM='$Data_cReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_cReworkUpdate[LOT_DATE]'";              
                    sqlsrv_query($connect, $Query_cPrintStatusUpdate, $params, $options);
                }
                
                //폐기
                $Query_cDisuse = "SELECT ISNULL(sum(REJECT_GOODS), 0) AS CSUM FROM [CONNECT].[dbo].[FIELD_PROCESS_REJECT_C] where CD_ITEM='$Data_cReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_cReworkUpdate[LOT_DATE]' and RESULT_NOTE='폐기'";              
                $Result_cDisuse = sqlsrv_query($connect, $Query_cDisuse, $params, $options);	
                $Data_cDisuse = sqlsrv_fetch_array($Result_cDisuse);                
                
                $Query_cDisuse2 = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_C SET REJECT_DISUSE='$Data_cDisuse[CSUM]' WHERE CD_ITEM='$Data_cReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_cReworkUpdate[LOT_DATE]'";              
                sqlsrv_query($connect, $Query_cDisuse2, $params, $options);	

                //리워크
                $Query_cWait = "SELECT ISNULL(sum(REJECT_GOODS), 0) AS CSUM FROM [CONNECT].[dbo].[FIELD_PROCESS_REJECT_C] where CD_ITEM='$Data_cReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_cReworkUpdate[LOT_DATE]' and RESULT_NOTE='리워크'";              
                $Result_cWait = sqlsrv_query($connect, $Query_cWait, $params, $options);	
                $Data_cWait = sqlsrv_fetch_array($Result_cWait);                
                
                $Query_cWait2 = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_C SET REJECT_WAIT='$Data_cWait[CSUM]' WHERE CD_ITEM='$Data_cReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_cReworkUpdate[LOT_DATE]'";              
                sqlsrv_query($connect, $Query_cWait2, $params, $options);	

                //리워크완료
                $Query_cRework = "SELECT ISNULL(sum(REJECT_GOODS), 0) AS CSUM FROM [CONNECT].[dbo].[FIELD_PROCESS_REJECT_C] where CD_ITEM='$Data_cReworkUpdate[CD_ITEM]' and LOT_DATE='$Data_cReworkUpdate[LOT_DATE]' and RESULT_NOTE='리워크완료'";              
                $Result_cRework = sqlsrv_query($connect, $Query_cRework, $params, $options);	
                $Data_cRework = sqlsrv_fetch_array($Result_cRework);                
                
                $Query_cRework2 = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_C SET REJECT_REWORK='$Data_cRework[CSUM]' WHERE CD_ITEM='$Data_cReworkUpdate[CD_ITEM]' AND LOT_DATE='$Data_cReworkUpdate[LOT_DATE]'";              
                sqlsrv_query($connect, $Query_cRework2, $params, $options);	              	
                //////////////////////////////////////
            }
        } 

        //저장 후 저장결과를 확인하기 위함
        $hidden_dt42 = $_POST["hidden_dt"];     
        $hs_dt42 = substr($hidden_dt42, 0, 10);		
        $he_dt42 = substr($hidden_dt42, 13, 10);

        //불량내역(한국)
        $Query_Reject = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE SORTING_DATE between '$hs_dt42' and '$he_dt42'";              
        $Result_Reject = sqlsrv_query($connect, $Query_Reject, $params, $options);		
        $Count_Reject = sqlsrv_num_rows($Result_Reject);

        //불량내역(베트남)
        $Query_vReject = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE SORTING_DATE between '$hs_dt42' and '$he_dt42'";              
        $Result_vReject = sqlsrv_query($connect, $Query_vReject, $params, $options);		
        $Count_vReject = sqlsrv_num_rows($Result_vReject);

        //불량내역(중국)
        $Query_cReject = "SELECT * from CONNECT.dbo.FIELD_PROCESS_REJECT_C WHERE SORTING_DATE between '$hs_dt42' and '$he_dt42'";              
        $Result_cReject = sqlsrv_query($connect, $Query_cReject, $params, $options);		
        $Count_cReject = sqlsrv_num_rows($Result_cReject);

        //작업개별수량(한국)
        $Query_RejectPcsCount= "SELECT SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_REJECT WHERE SORTING_DATE between '$hs_dt42' and '$he_dt42'";              
        $Result_RejectPcsCount = sqlsrv_query($connect, $Query_RejectPcsCount, $params, $options);		
        $Data_RejectPcsCount = sqlsrv_fetch_array($Result_RejectPcsCount);  

        //작업개별수량(베트남)
        $Query_vRejectPcsCount= "SELECT SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE SORTING_DATE between '$hs_dt42' and '$he_dt42'";              
        $Result_vRejectPcsCount = sqlsrv_query($connect, $Query_vRejectPcsCount, $params, $options);		
        $Data_vRejectPcsCount = sqlsrv_fetch_array($Result_vRejectPcsCount);  

        //작업개별수량(중국)
        $Query_cRejectPcsCount= "SELECT SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_REJECT_C WHERE SORTING_DATE between '$hs_dt42' and '$he_dt42'";              
        $Result_cRejectPcsCount = sqlsrv_query($connect, $Query_cRejectPcsCount, $params, $options);		
        $Data_cRejectPcsCount = sqlsrv_fetch_array($Result_cRejectPcsCount);  

        //수정 독점화 상태 변경
        $Query_BadModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='FieldCompleteBad'";          
        sqlsrv_query($connect, $Query_BadModifyUpdate, $params, $options);
    }
    //삭제내역
    ELSEIF($bt51=="on") {
        $tab_sequence=5; 
        include '../TAB.php'; 

        $Query_Delete = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH_DEL WHERE SORTING_DATE between '$s_dt5' and '$e_dt5'";              
        $Result_Delete = sqlsrv_query($connect, $Query_Delete, $params, $options);		
        $Count_Delete = sqlsrv_num_rows($Result_Delete);        
    }
    //베트남 스캔 입력
    ELSEIF($bt61=="on" or $popitem!='') {
        $tab_sequence=6; 
        include '../TAB.php';

        if($popitem!='') {
            $CD_ITEM6=$popitem;
        }

        //품번 중복검사
        $Query_vItemRepeatChk = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH_V where SORTING_DATE='$Hyphen_today' and CD_ITEM='$CD_ITEM6'";              
        $Result_vItemRepeatChk = sqlsrv_query($connect, $Query_vItemRepeatChk, $params, $options);
        $Count_vItemRepeatChk = sqlsrv_num_rows($Result_vItemRepeatChk);

        //중복 시 수량변경 팝업창 생성
        IF($Count_vItemRepeatChk > 0) {   
            echo "<script>location.href='field_complete.php?Vmodi=Y&VMODAL2=on&vmodal_Delivery_ItemCode2=$CD_ITEM6';</script>";
        }
        else {
            if($CD_ITEM6!='') {
                $Query_vFinish = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH_V(CD_ITEM, LOT_DATE, BARCODE, AS_YN) VALUES('$CD_ITEM6', '$NoHyphen_today', '$item6', 'N')";              
                sqlsrv_query($connect, $Query_vFinish, $params, $options);
            }
        }   
    }
    //베트남 수기입력
    ELSEIF($bt61b1=="on") {
        $tab_sequence=6; 
        include '../TAB.php'; 

        $item61b1 = trim(HyphenRemove($_POST["item61b1"]));  
        $size61b1 = $_POST["size61b1"]; 
        $note61b1= $_POST["note61b1"]; 

        //품번 중복검사
        $Query_vItemRepeatChk2 = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH_V where SORTING_DATE='$Hyphen_today' and CD_ITEM='$item61b1'";              
        $Result_vItemRepeatChk2 = sqlsrv_query($connect, $Query_vItemRepeatChk2, $params, $options);
        $Count_vItemRepeatChk2 = sqlsrv_num_rows($Result_vItemRepeatChk2);

        //중복 시 수량변경 팝업창 생성
        IF($Count_vItemRepeatChk2 > 0) {   
            echo "<script>location.href='field_complete.php?Vmodi=Y&VMODAL2=on&vmodal_Delivery_ItemCode2=$item61b1&vsize=$size61b1';</script>";
        }
        else {
            //DB 프라이머리키 설정으로 중복확인 절차 불필요
            $Query_vDirectfinish = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH_V(CD_ITEM, LOT_DATE, QT_GOODS, REJECT_GOODS, NOTE, AS_YN) VALUES('$item61b1', '$NoHyphen_today', '$size61b1', '0', '$note61b1', 'Y')";              
            sqlsrv_query($connect, $Query_vDirectfinish, $params, $options);
        }
    }
    //베트남 삭제  
    ELSEIF($bt61b=="on" or $popitem2!='') {
        $tab_sequence=6; 
        include '../TAB.php'; 

        if($popitem2!='') {
            $cd_item6b=$popitem2;
        }


        if($cd_item6b !='') {
            $Query_vDeleteCheck = "SELECT * FROM CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE CD_ITEM='$cd_item6b' AND SORTING_DATE='$Hyphen_today'";              
            $Result_vDeleteCheck = sqlsrv_query($connect, $Query_vDeleteCheck, $params, $options);
            $Data_vDeleteCheck = sqlsrv_fetch_array($Result_vDeleteCheck);  
            
            $Query_vDeleteRecord = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH_DEL(KIND, CD_ITEM, LOT_DATE, QT_GOODS, REJECT_GOODS, BARCODE) VALUES('V', '$cd_item6b', '$Data_vDeleteCheck[LOT_DATE]', '$Data_vDeleteCheck[QT_GOODS]', '$Data_vDeleteCheck[REJECT_GOODS]', '$item6b')";              
            sqlsrv_query($connect, $Query_vDeleteRecord, $params, $options);

            $Query_vFinishDelete = "DELETE FROM CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE CD_ITEM='$cd_item6b' AND SORTING_DATE='$Hyphen_today'";
            sqlsrv_query($connect, $Query_vFinishDelete, $params, $options);

            $Query_vRejectDelete = "DELETE CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM='$cd_item6b' AND LOT_DATE='$NoHyphen_today'";
            sqlsrv_query($connect, $Query_vRejectDelete, $params, $options);
        }
        //수기입력 삭제인 경우
        elseif($cd_item6b2 !='') {
            $Query_vSelectCheck = "SELECT * FROM CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE CD_ITEM='$cd_item6b2' AND SORTING_DATE ='$Hyphen_today' AND BARCODE IS NULL";              
            $Result_vSelectCheck = sqlsrv_query($connect, $Query_vSelectCheck, $params, $options);
            $Data_vSelectCheck = sqlsrv_fetch_array($Result_vSelectCheck);  
            
            $Query_vDeleteRecord = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_FINISH_DEL(KIND, CD_ITEM, LOT_DATE, QT_GOODS, REJECT_GOODS) VALUES('V', '$cd_item6b2', '$Data_vSelectCheck[LOT_DATE]', '$Data_vSelectCheck[QT_GOODS]', '$Data_vSelectCheck[REJECT_GOODS]')";              
            sqlsrv_query($connect, $Query_vDeleteRecord, $params, $options);

            $Query_vFinishDelete = "DELETE FROM CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE CD_ITEM='$cd_item6b2' AND SORTING_DATE='$Hyphen_today'";
            sqlsrv_query($connect, $Query_vFinishDelete, $params, $options);

            $Query_vRejectDelete = "DELETE CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM='$cd_item6b2' AND LOT_DATE='$NoHyphen_today'";
            sqlsrv_query($connect, $Query_vRejectDelete, $params, $options);       
        }
    }
    //베트남 수정/저장
    ELSEIF($bt62=="on") {
        $tab_sequence=6; 
        include '../TAB.php'; 

        $limit6 = $_POST["until6"];

        for($a=1; $a<$limit6; $a++)
        {
            $V_CD_ITEM = 'V_CD_ITEM'.$a;          
            $pop_out2 = 'pop_out2'.$a;
            $VNOTE = 'VNOTE'.$a;
            $V_CB = 'V_CB'.$a;
            $AS_STATUS = 'AS_STATUS'.$a;

            ${"V_CD_ITEM".$a} = $_POST[$V_CD_ITEM];
            ${"pop_out2".$a} = $_POST[$pop_out2];
            ${"VNOTE".$a} = $_POST[$VNOTE];
            ${"V_CB".$a} = $_POST[$V_CB];
            ${"AS_STATUS".$a} = $_POST[$AS_STATUS];

            $Query_vPUpdate = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"V_CD_ITEM".$a}'";              
            $Result_vPUpdate = sqlsrv_query($connect, $Query_vPUpdate, $params, $options);	
            $Data_vPUpdate = sqlsrv_fetch_array($Result_vPUpdate); 

            if($Data_vPUpdate['PRINT_YN']=='Y' AND ${"pop_out2".$a}<$Data_vPUpdate['QT_GOODS']) {
                echo "<script>alert(\"포장라벨 발행이 되었는데 완료수량을 줄이려 합니다!, 검사의 완료수량을 줄이려면 삭제 진행 후 재입력하세요!\");location.href='field_complete.php';</script>";
            }
            else {
                if(${"pop_out2".$a}!=$Data_vPUpdate['PRINT_QT']) {
                    //이 조건을 넣어야 포장라벨을 뽑아서 완료된 데이터의 PRINT_YN이 P로 변경되는 일이 없다.
                    if(${"pop_out2".$a}!=$Data_vPUpdate['PRINT_QT']+$Data_vPUpdate['REJECT_GOODS']) {
                        $Query_vNoteUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V set NOTE='${"VNOTE".$a}', QT_GOODS='${"pop_out2".$a}', PRINT_YN='P' WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"V_CD_ITEM".$a}'";              
                        sqlsrv_query($connect, $Query_vNoteUpdate, $params, $options);
                    }
                }
                ELSE {
                    $Query_vNoteUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V set NOTE='${"VNOTE".$a}', QT_GOODS='${"pop_out2".$a}' WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"V_CD_ITEM".$a}'";              
                    sqlsrv_query($connect, $Query_vNoteUpdate, $params, $options);
                }   

                //검사 시 체크
                IF(${"V_CB".$a}=='on') {
                    $Query_vInspectYN = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V set INSPECT_YN='Y' WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"V_CD_ITEM".$a}'";              
                    sqlsrv_query($connect, $Query_vInspectYN, $params, $options);
                }
                else {
                    $Query_vInspectYN = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V set INSPECT_YN='N' WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"V_CD_ITEM".$a}'";              
                    sqlsrv_query($connect, $Query_vInspectYN, $params, $options);
                }
                
                //양산 vs a/s
                IF(${"AS_STATUS".$a}=='Y') {
                    $Query_vInspectYN = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V set AS_YN='Y' WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"V_CD_ITEM".$a}'";              
                    sqlsrv_query($connect, $Query_vInspectYN, $params, $options);
                }
                else {
                    $Query_vInspectYN = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V set AS_YN='N' WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"V_CD_ITEM".$a}'";              
                    sqlsrv_query($connect, $Query_vInspectYN, $params, $options);
                }
            }
        } 

        //수정 독점화 상태 변경
        $Query_vModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='FieldCompleteVietnam'";          
        sqlsrv_query($connect, $Query_vModifyUpdate2, $params, $options);
    }
    //베트남 불량입력
    ELSEIF (isset($_POST['vmbt1']) && $_POST['vmbt1'] == 'on') {
        $tab_sequence = 6;
        include '../TAB.php';

        // --- 1. 입력 데이터 안전하게 가져오기 ---
        $item_code = $_POST['vmodal_ItemCode'] ?? null;
        $lot_date = $_POST['vmodal_LotDate'] ?? null;

        // 필수 값이 없으면 즉시 중단
        if (empty($item_code) || empty($lot_date)) {
            echo "<script>alert('품번 또는 로트 날짜를 불러오지 못했습니다. 다시 시도해주세요.'); location.href='field_complete.php';</script>";
            exit;
        }

        // 불량 데이터를 배열로 구조화하여 관리 용이성 증대
        $reject_definitions = [
            ['code' => 1, 'type' => '폐기', 'qty_name' => 'vmi1', 'note_name' => 'vmn1'],
            ['code' => 2, 'type' => '폐기', 'qty_name' => 'vmi2', 'note_name' => 'vmn2'],
            ['code' => 3, 'type' => '폐기', 'qty_name' => 'vmi3', 'note_name' => 'vmn3'],
            ['code' => 4, 'type' => '폐기', 'qty_name' => 'vmi4', 'note_name' => 'vmn4'],
            ['code' => 5, 'type' => '리워크', 'qty_name' => 'vmi5', 'note_name' => 'vmn5'],
            ['code' => 6, 'type' => '폐기', 'qty_name' => 'vmi6', 'note_name' => 'vmn6'],
            ['code' => 7, 'type' => '폐기', 'qty_name' => 'vmi7', 'note_name' => 'vmn7'],
        ];

        $rejects_to_insert = [];
        $total_rejects = 0;
        $total_disuse = 0;
        $total_rework = 0;

        foreach ($reject_definitions as $def) {
            $qty = (int)($_POST[$def['qty_name']] ?? 0);
            if ($qty > 0) {
                $note = $_POST[$def['note_name']] ?? '';
                $rejects_to_insert[] = [
                    'code' => $def['code'],
                    'qty' => $qty,
                    'note' => $note,
                    'type' => $def['type']
                ];
                // 합계 계산
                $total_rejects += $qty;
                if ($def['type'] === '폐기') {
                    $total_disuse += $qty;
                } else { // '리워크'
                    $total_rework += $qty;
                }
            }
        }

        // --- 2. 데이터베이스 작업 (트랜잭션으로 안정성 확보) ---
        sqlsrv_begin_transaction($connect); // 트랜잭션 시작

        try {
            // (쿼리 1) 기존 불량 기록 삭제
            $query_delete = "DELETE FROM CONNECT.dbo.FIELD_PROCESS_REJECT_V WHERE CD_ITEM = ? AND LOT_DATE = ?";
            sqlsrv_query($connect, $query_delete, [$item_code, $lot_date]);

            // (쿼리 2) 반복문을 통해 새로운 불량 기록 추가 (성능 개선)
            $query_insert = "
                INSERT INTO CONNECT.dbo.FIELD_PROCESS_REJECT_V
                (CD_ITEM, LOT_DATE, REJECT_CODE, REJECT_GOODS, REJECT_NOTE, RESULT_NOTE)
                VALUES (?, ?, ?, ?, ?, ?)";
            
            foreach ($rejects_to_insert as $reject) {
                sqlsrv_query($connect, $query_insert, [
                    $item_code, $lot_date, $reject['code'], $reject['qty'], $reject['note'], $reject['type']
                ]);
            }

            // (쿼리 3) 업데이트에 필요한 현재 완료 수량 조회
            $query_select_finish = "SELECT QT_GOODS, PRINT_YN, PRINT_QT FROM CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE CD_ITEM = ? AND LOT_DATE = ?";
            $stmt_select = sqlsrv_query($connect, $query_select_finish, [$item_code, $lot_date]);
            $data_finish = sqlsrv_fetch_array($stmt_select, SQLSRV_FETCH_ASSOC);

            // (쿼리 4) 최종 합계 데이터를 한 번에 업데이트 (성능 개선)
            $update_fields = [
                'REJECT_GOODS' => $total_rejects,
                'REJECT_DISUSE' => $total_disuse,
                'REJECT_WAIT' => $total_rework,
                'REJECT_REWORK' => 0 // 기존 로직에 REWORK 필드가 있어 0으로 초기화
            ];

            if ($data_finish) {
                if ($data_finish['QT_GOODS'] == $total_disuse) {
                    $update_fields['PRINT_YN'] = 'Y';
                    $update_fields['PRINT_QT'] = 0;
                } elseif ($data_finish['QT_GOODS'] != $total_disuse && $data_finish['PRINT_YN'] == 'Y' && $data_finish['PRINT_QT'] == 0) {
                    $update_fields['PRINT_YN'] = 'P';
                }
            }
            
            $set_clauses = [];
            $update_params = [];
            foreach($update_fields as $field => $value) {
                $set_clauses[] = "[$field] = ?";
                $update_params[] = $value;
            }
            $update_params[] = $item_code;
            $update_params[] = $lot_date;

            $query_update_finish = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V SET " . implode(', ', $set_clauses) . " WHERE CD_ITEM = ? AND LOT_DATE = ?";
            sqlsrv_query($connect, $query_update_finish, $update_params);

            // 모든 쿼리가 성공하면 최종 확정
            sqlsrv_commit($connect);
            echo "<script>alert('불량 등록이 완료되었습니다.'); location.href='field_complete.php';</script>";

        } catch (Exception $e) {
            // 하나라도 실패하면 모든 작업을 취소 (데이터 무결성 보장)
            sqlsrv_rollback($connect);
            echo "<script>alert('오류가 발생하여 작업을 취소했습니다: " . $e->getMessage() . "'); location.href='field_complete.php';</script>";
        }
    }
    //베트남 완료수량 변경
    ELSEIF($vmbt2=="on") {
        $tab_sequence=6; 
        include '../TAB.php';  
        
        $Query_vPUpdate2 = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE='$Hyphen_today' and CD_ITEM='${"V_CD_ITEM".$a}'";              
        $Result_vPUpdate2 = sqlsrv_query($connect, $Query_vPUpdate2, $params, $options);	
        $Data_vPUpdate2 = sqlsrv_fetch_array($Result_vPUpdate2); 

        if($qt_goods6 != $Data_vPUpdate2['PRINT_QT']) {
            $Query_vQuantityUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V set QT_GOODS='$qt_goods6', PRINT_YN='P' WHERE CD_ITEM='$vmodal_ItemCode2' AND SORTING_DATE='$Hyphen_today'";              
            sqlsrv_query($connect, $Query_vQuantityUpdate, $params, $options);
        }
        ELSE {
            $Query_vQuantityUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V set QT_GOODS='$qt_goods6' WHERE CD_ITEM='$vmodal_ItemCode2' AND SORTING_DATE='$Hyphen_today'";              
            sqlsrv_query($connect, $Query_vQuantityUpdate, $params, $options);
        }

        //수정 독점화 상태 변경
        $Query_vModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='FieldCompleteVietnam'";          
        sqlsrv_query($connect, $Query_vModifyUpdate2, $params, $options);
    }

    
    //★메뉴 진입 시 실행
    //한국 탭
    $Query_KoreaScan = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE SORTING_DATE='$Hyphen_today' order by NO DESC";              
    $Result_KoreaScan = sqlsrv_query($connect21, $Query_KoreaScan, $params21, $options21);		
    $Count_KoreaScan = sqlsrv_num_rows($Result_KoreaScan); 

    //베트남 탭
    $Query_VietnamScan = "SELECT * from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE='$Hyphen_today' order by NO DESC";              
    $Result_VietnamScan = sqlsrv_query($connect21, $Query_VietnamScan, $params21, $options21);		
    $Count_VietnamScan = sqlsrv_num_rows($Result_VietnamScan); 

    //한국 pcs 합계
    $Query_KoreaTotal = "SELECT SUM(QT_GOODS) AS QT, SUM(REJECT_GOODS) AS RE from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE SORTING_DATE='$Hyphen_today'";              
    $Result_KoreaTotal = sqlsrv_query($connect21, $Query_KoreaTotal, $params21, $options21);		
    $Data_KoreaTotal = sqlsrv_fetch_array($Result_KoreaTotal); 

    //베트남 pcs 합계
    $Query_VietnamTotal = "SELECT SUM(QT_GOODS) AS QT, SUM(REJECT_GOODS) AS RE from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE='$Hyphen_today'";              
    $Result_VietnamTotal = sqlsrv_query($connect21, $Query_VietnamTotal, $params21, $options21);		
    $Data_VietnamTotal = sqlsrv_fetch_array($Result_VietnamTotal); 

    //중국 pcs 합계
    $Query_ChinaTotal = "SELECT SUM(QT_GOODS) AS QT, SUM(REJECT_GOODS) AS RE from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE SORTING_DATE='$Hyphen_today'";              
    $Result_ChinaTotal = sqlsrv_query($connect21, $Query_ChinaTotal, $params21, $options21);		
    $Data_ChinaTotal = sqlsrv_fetch_array($Result_ChinaTotal);