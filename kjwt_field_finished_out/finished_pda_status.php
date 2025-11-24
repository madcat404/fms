<?php   
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.07.02>
	// Description:	<출하 pda>	
	// =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';    
    include '../DB/DB21.php'; 

    //★변수모음    
    //PDA - 입력	
    $item2 = strtoupper($_POST["item2"] ?? '');	
    $bt21 = $_POST["bt21"] ?? '';  

    //출하취소
    $item22 = strtoupper($_POST["item22"] ?? '');	
    $bt22 = $_POST["bt22"] ?? ''; 

    //★버튼 클릭 시 실행  
    //pda 입력
    if($bt21 === "on" && !empty($item2)) {
        $head_word = strtoupper(substr($item2, 0, 1));

        //납품기사 바코드를 스캔하면
        if($head_word === 'D') {
            $Query_UpdateDelivery = "UPDATE CONNECT.dbo.USE_CONDITION SET WHO='$item2' WHERE KIND='Delivery'";              
            sqlsrv_query($connect, $Query_UpdateDelivery);
        }
        else { 
            $use_function2 = CROP($item2);
            $cd_item2 = $use_function2[0] ?? '';
            $lot_date2 = $use_function2[2] ?? '';
            $lot_num2 = $use_function2[3] ?? '';
            $qt_goods2 = $use_function2[4] ?? '0'; 
            $kind2 = $use_function2[5] ?? ''; 

            //중복검사
            $Query_ItemRepeatChk = "SELECT * from CONNECT.dbo.FINISHED_OUTPUT_LOG where CD_ITEM='$cd_item2' and LOT_DATE='$lot_date2' AND LOT_NUM='$lot_num2'";              
            $Result_ItemRepeatChk = sqlsrv_query($connect, $Query_ItemRepeatChk);
            
            $is_duplicate = false;
            if ($Result_ItemRepeatChk && sqlsrv_has_rows($Result_ItemRepeatChk)) {
                $is_duplicate = true;
            }

            if(!$is_duplicate) {
                //마지막 납품기사
                $Query_Delivery2 = "SELECT WHO from CONNECT.dbo.USE_CONDITION WHERE KIND='Delivery'";              
                $Result_Delivery2 = sqlsrv_query($connect, $Query_Delivery2);
                $Data_Delivery2 = ($Result_Delivery2) ? sqlsrv_fetch_array($Result_Delivery2) : null; 
                
                $DeliveryName2 = '';
                if (isset($Data_Delivery2['WHO'])) {
                    if($Data_Delivery2['WHO']=='DELIVERY1') $DeliveryName2 = "옥해종";
                    elseif($Data_Delivery2['WHO']=='DELIVERY2') $DeliveryName2 = "손규백";
                    elseif($Data_Delivery2['WHO']=='DELIVERY3') $DeliveryName2 = "최기완";
                    elseif($Data_Delivery2['WHO']=='DELIVERY4') $DeliveryName2 = "조근선";
                    elseif($Data_Delivery2['WHO']=='DELIVERY5') $DeliveryName2 = "박정민";
                    elseif($Data_Delivery2['WHO']=='DELIVERY6') $DeliveryName2 = "김영민";
                    elseif($Data_Delivery2['WHO']=='DELIVERY7') $DeliveryName2 = "기타";
                }

                //하이폰 제거
                $cd_item2 = HyphenRemove($cd_item2);

                if($cd_item2 !== '') {
                    if($qt_goods2 !== '0') {
                        $pieces_yn = ($kind2 === 'R') ? 'Y' : 'N';
                        
                        $Query_OutputFinished = "INSERT INTO CONNECT.dbo.FINISHED_OUTPUT_LOG(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, SORTING_DATE, PIECES_YN, DELIVERY) VALUES('$cd_item2', '$lot_date2', '$lot_num2', '$qt_goods2', '$Hyphen_today','$pieces_yn', '$DeliveryName2')";              
                        sqlsrv_query($connect, $Query_OutputFinished);

                        $Query_InputFinished = "UPDATE CONNECT.dbo.FINISHED_INPUT_LOG set OUT_YN='Y' WHERE CD_ITEM='$cd_item2' AND LOT_DATE='$lot_date2' AND LOT_NUM='$lot_num2'";              
                        sqlsrv_query($connect, $Query_InputFinished);

                        $Query_InputFinished2 = "UPDATE CONNECT.dbo.FINISHED_INPUT_LOG2 set OUT_YN='Y' WHERE CD_ITEM='$cd_item2' AND LOT_DATE='$lot_date2' AND LOT_NUM='$lot_num2'";              
                        sqlsrv_query($connect, $Query_InputFinished2);
                        
                        //박스수량
                        $Query_Sound = "SELECT COUNT(*) AS BOX from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='$DeliveryName2'";              
                        $Result_Sound = sqlsrv_query($connect, $Query_Sound);	
                        $Data_Sound = ($Result_Sound) ? sqlsrv_fetch_array($Result_Sound) : null; 

                        if(isset($Data_Sound['BOX']) && $Data_Sound['BOX'] % 5 == 0) {
                            echo "<script>var audio = new Audio('five.mp3'); audio.play();</script>"; 
                        }
                    }
                    else {
                        echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { alert('수량 0을 출하할 수 없습니다!'); location.href='finished_pda.php'; }; audio.play();</script>"; 
                    }
                }
                else {
                    echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { alert('품번이 없습니다!'); location.href='finished_pda.php'; }; audio.play();</script>"; 
                }
            }  
            else {
                echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { alert('중복되었습니다!'); location.href='finished_pda.php'; }; audio.play();</script>"; 
            }      
        }   
    } 
    //출하취소
    IF($bt22 === "on" && !empty($item22)) {
        $use_function22 = CROP(HyphenRemove($item22));
        $cd_item22 = $use_function22[0] ?? '';
        $lot_date22 = $use_function22[2] ?? '';
        $lot_num22 = $use_function22[3] ?? '';
        $qt_goods22 = $use_function22[4] ?? '0'; 

        $Query_OutputFinished = "INSERT INTO CONNECT.dbo.FINISHED_OUTPUT_DEL(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS) VALUES('$cd_item22', '$lot_date22', '$lot_num22', '$qt_goods22')";              
        sqlsrv_query($connect, $Query_OutputFinished);

        $Query_OutputFinished2 = "DELETE FROM CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE CD_ITEM='$cd_item22' AND LOT_DATE='$lot_date22' AND LOT_NUM='$lot_num22'";              
        sqlsrv_query($connect, $Query_OutputFinished2); 

        $Query_InputFinished = "UPDATE CONNECT.dbo.FINISHED_INPUT_LOG set OUT_YN='N' WHERE CD_ITEM='$cd_item22' AND LOT_DATE='$lot_date22' AND LOT_NUM='$lot_num22'";              
        sqlsrv_query($connect, $Query_InputFinished);

        $Query_InputFinished2 = "UPDATE CONNECT.dbo.FINISHED_INPUT_LOG2 set OUT_YN='N' WHERE CD_ITEM='cd_item22' AND LOT_DATE='$lot_date22' AND LOT_NUM='$lot_num22'";              
        sqlsrv_query($connect, $Query_InputFinished2);

        //삭제 후 숫자가 바로 반영안됨
        echo "<script>location.href='finished_pda.php';</script>";	 
    }
   
    //★메뉴 진입 시 실행
    //마지막 납품기사
    $DeliveryName = '';
    $Query_Delivery = "SELECT WHO from CONNECT.dbo.USE_CONDITION WHERE KIND='Delivery'";              
    $Result_Delivery = sqlsrv_query($connect21, $Query_Delivery);
    $Data_Delivery = ($Result_Delivery) ? sqlsrv_fetch_array($Result_Delivery) : null;

    if(isset($Data_Delivery['WHO'])) {
        if($Data_Delivery['WHO']=='DELIVERY1') $DeliveryName = "옥해종";
        elseif($Data_Delivery['WHO']=='DELIVERY2') $DeliveryName = "손규백";
        elseif($Data_Delivery['WHO']=='DELIVERY3') $DeliveryName = "최기완";
        elseif($Data_Delivery['WHO']=='DELIVERY4') $DeliveryName = "조근선";
        elseif($Data_Delivery['WHO']=='DELIVERY5') $DeliveryName = "박정민";
        elseif($Data_Delivery['WHO']=='DELIVERY6') $DeliveryName = "김영민";
        elseif($Data_Delivery['WHO']=='DELIVERY7') $DeliveryName = "기타";
    }

    //박스수량 및 개별수량
    $Data_OutputQuantity = ['BOX' => 0, 'PCS' => 0];
    if (!empty($DeliveryName)) {
        $Query_OutputQuantity = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='$DeliveryName'";              
        $Result_OutputQuantity = sqlsrv_query($connect21, $Query_OutputQuantity);
        $fetched_data = ($Result_OutputQuantity) ? sqlsrv_fetch_array($Result_OutputQuantity) : null;
        if ($fetched_data) {
            $Data_OutputQuantity = $fetched_data;
        }
    }
?>