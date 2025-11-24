<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.04.28>
	// Description:	<완성품 이동>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x		
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php'; 
    

    //★메뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include '../TAB.php'; 


    //★변수모음 
    //탭3  
    $dt3 = $_POST["dt3"];	
    $s_dt3 = substr($dt3, 0, 10);		
	$e_dt3 = substr($dt3, 13, 10);
    $bt31 = $_POST["bt31"];   

    //탭4
    $item40 = trim(strtoupper($_POST["item40"]));	 
    $use_function40 = CROP($item40);
    $cd_item40 = $use_function40[0];
    $lot_date40 = $use_function40[2];
    $lot_num40 = $use_function40[3];
    $qt_goods40 = $use_function40[4];
    $bt40 = $_POST["bt40"]; 

    $dt4 = $_POST["dt4"];	
    $s_dt4 = substr($dt4, 0, 10);		
	$e_dt4 = substr($dt4, 13, 10);
    $bt41 = $_POST["bt41"];  

    //★버튼 클릭 시 실행
    IF($bt31=="on") {
        $tab_sequence=3; 
        include '../TAB.php'; 

        //검사내역 조회
        $Query_LabelPrint = "select * from CONNECT.dbo.PACKING_LOG WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
        $Result_LabelPrint = sqlsrv_query($connect, $Query_LabelPrint, $params, $options);		
        $Count_LabelPrint = sqlsrv_num_rows($Result_LabelPrint);
        
        //작업품목수량
        $Query_ItemCount= "select CD_ITEM from CONNECT.dbo.PACKING_LOG WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' group by CD_ITEM";              
        $Result_ItemCount = sqlsrv_query($connect, $Query_ItemCount, $params, $options);		
        $Count_ItemCount = sqlsrv_num_rows($Result_ItemCount);

        //개별작업수량
        $Query_PcsCount= "select SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.PACKING_LOG WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
        $Result_PcsCount = sqlsrv_query($connect, $Query_PcsCount, $params, $options);		
        $Count_PcsCount = sqlsrv_num_rows($Result_PcsCount);
    }  
    //삭제
    ELSEIF($bt40=="on") {
        $tab_sequence=4; 
        include '../TAB.php'; 

        // Use parameterized query for the initial SELECT
        $Query_DeleteSelect = "SELECT * FROM CONNECT.dbo.PACKING_LOG WHERE CD_ITEM=? AND LOT_DATE=? AND LOT_NUM=?";
        $params_select = array($cd_item40, $lot_date40, $lot_num40);
        $Result_DeleteSelect = sqlsrv_query($connect, $Query_DeleteSelect, $params_select);

        // Check if a row was found
        if ($Result_DeleteSelect && ($Data_DeleteSelect = sqlsrv_fetch_array($Result_DeleteSelect, SQLSRV_FETCH_ASSOC))) {

            // Use parameterized query for the INSERT into the delete log
            $Query_DeleteRecord = "INSERT INTO CONNECT.dbo.PACKING_DEL(COUNTRY, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS) VALUES(?, ?, ?, ?, ?)";
            $lot_date_to_insert = ($Data_DeleteSelect['LOT_DATE'] instanceof DateTime) ? $Data_DeleteSelect['LOT_DATE']->format('Ymd') : $Data_DeleteSelect['LOT_DATE'];
            $params_insert = array(
                $Data_DeleteSelect['COUNTRY'],
                $Data_DeleteSelect['CD_ITEM'],
                $lot_date_to_insert,
                $Data_DeleteSelect['LOT_NUM'],
                $Data_DeleteSelect['QT_GOODS']
            );
            sqlsrv_query($connect, $Query_DeleteRecord, $params_insert);
            
            // The logic for updating FIELD_PROCESS_FINISH tables
            if(strtoupper($Data_DeleteSelect['COUNTRY'])=='K') {
                echo "<script>alert(\"한국 포장라벨 삭제는 관리자에게 문의 바랍니다!\");location.href='complete_label.php';</script>";
            }
            ELSEIF(strtoupper($Data_DeleteSelect['COUNTRY'])=='V') {
                $Query_vFinishSelect = "SELECT TOP 1 * FROM CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE CD_ITEM=? ORDER BY NO DESC";
                $Result_vFinishSelect = sqlsrv_query($connect, $Query_vFinishSelect, array($Data_DeleteSelect['CD_ITEM']));
                if ($Result_vFinishSelect && ($Data_vFinishSelect = sqlsrv_fetch_array($Result_vFinishSelect, SQLSRV_FETCH_ASSOC))) {
                    $vCAL_QT = $Data_vFinishSelect['PRINT_QT'] - $qt_goods40;
                    $Query_vFinishUpdate = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH_V SET PRINT_YN='P', PRINT_QT=? WHERE NO=?";
                    sqlsrv_query($connect, $Query_vFinishUpdate, array($vCAL_QT, $Data_vFinishSelect['NO']));
                }
            }

            // Use parameterized query for the final DELETE
            $Query_FinishDelete = "DELETE FROM CONNECT.dbo.PACKING_LOG WHERE CD_ITEM=? AND LOT_DATE=? AND LOT_NUM=?";
            $params_delete = array($cd_item40, $lot_date40, $lot_num40);
            $delete_stmt = sqlsrv_query($connect, $Query_FinishDelete, $params_delete);

            if($delete_stmt === false) {
                 echo "삭제 중 오류가 발생했습니다.";
                 // For debugging: die(print_r(sqlsrv_errors(), true));
            }

        } else {
            // Handle case where no record was found to delete
            echo "<script>alert(\"삭제할 데이터를 찾지 못했습니다.\");location.href='complete_label.php';</script>";
        }
    } 
    //삭제내역
    ELSEIF($bt41=="on") {
        $tab_sequence=4; 
        include '../TAB.php'; 

        //삭제내역 조회
        $Query_DeleteSelect = "select * from CONNECT.dbo.PACKING_DEL WHERE SORTING_DATE between '$s_dt4' and '$e_dt4'";              
        $Result_DeleteSelect = sqlsrv_query($connect, $Query_DeleteSelect, $params, $options);		
        $Count_DeleteSelect = sqlsrv_num_rows($Result_DeleteSelect);
    }   
     
    
    
    //★메뉴 진입 시 실행
    //입고라벨 탭
    //속도를 빠르게 한다고 db튜닝을 했는데... 그러다 보니 어제 검수완료한거가 다음날 오면 포장에 안떠 있음
    //MSSQL 작업에이전트에서 7일 이후에 데이터를 이동시키는 것으로 해결함
    $Query_CompleteInfo = "SELECT CD_ITEM, ISNULL(SUM(QT_GOODS),0) AS KQT_GOODS, ISNULL(SUM(REJECT_GOODS),0) AS KREJECT_GOODS, ISNULL(SUM(ERROR_GOODS),0) AS KERROR_GOODS, ISNULL(SUM(REJECT_DISUSE),0) AS KREJECT_DISUSE, ISNULL(SUM(REJECT_WAIT),0) AS KREJECT_WAIT, ISNULL(SUM(REJECT_REWORK),0) AS KREJECT_REWORK, ISNULL(SUM(PRINT_QT),0) AS KPRINT_QT, AS_YN from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE PRINT_YN!='Y' AND SORTING_DATE>='2024-04-01' group by CD_ITEM, AS_YN";             
    $Result_CompleteInfo = sqlsrv_query($connect, $Query_CompleteInfo, $params, $options);		
    $Count_CompleteInfo = sqlsrv_num_rows($Result_CompleteInfo); 

    $Query_vCompleteInfo = "SELECT CD_ITEM, ISNULL(SUM(QT_GOODS),0) AS VQT_GOODS, ISNULL(SUM(REJECT_GOODS),0) AS VREJECT_GOODS, ISNULL(SUM(REJECT_DISUSE),0) AS VREJECT_DISUSE, ISNULL(SUM(REJECT_WAIT),0) AS VREJECT_WAIT, ISNULL(SUM(REJECT_REWORK),0) AS VREJECT_REWORK, ISNULL(SUM(PRINT_QT),0) AS VPRINT_QT, AS_YN from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE PRINT_YN!='Y' AND SORTING_DATE>='2024-04-01' group by CD_ITEM, AS_YN";             
    $Result_vCompleteInfo = sqlsrv_query($connect, $Query_vCompleteInfo, $params, $options);		
    $Count_vCompleteInfo = sqlsrv_num_rows($Result_vCompleteInfo); 

    $Query_cCompleteInfo = "SELECT CD_ITEM, ISNULL(SUM(QT_GOODS),0) AS CQT_GOODS, ISNULL(SUM(REJECT_GOODS),0) AS CREJECT_GOODS, ISNULL(SUM(REJECT_DISUSE),0) AS CREJECT_DISUSE, ISNULL(SUM(REJECT_WAIT),0) AS CREJECT_WAIT, ISNULL(SUM(REJECT_REWORK),0) AS CREJECT_REWORK, ISNULL(SUM(PRINT_QT),0) AS CPRINT_QT, AS_YN from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE PRINT_YN!='Y' AND SORTING_DATE>='2024-04-01' group by CD_ITEM, AS_YN";             
    $Result_cCompleteInfo = sqlsrv_query($connect, $Query_cCompleteInfo, $params, $options);		
    $Count_cCompleteInfo = sqlsrv_num_rows($Result_cCompleteInfo);    