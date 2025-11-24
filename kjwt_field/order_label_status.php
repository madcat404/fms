<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.25>
	// Description:	<ERP 작업지시번호 라벨 & 공정진행표 라벨>	
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
    $dt3 = $_POST["dt3"] ?? '';	
    $s_dt3 = substr($dt3, 0, 10);		
	$e_dt3 = substr($dt3, 13, 10);
    $bt31 = $_POST["bt31"] ?? '';   


    //★버튼 클릭 시 실행
    IF($bt31=="on") {
        $tab_sequence=3; 
        include '../TAB.php'; 

        //발행내역 조회
        $Query_LabelPrint = "select * from CONNECT.dbo.FIELD_PROCESS_LABEL WHERE SORTING_DATE between '$s_dt3' and '$e_dt3'";              
        $Result_LabelPrint = sqlsrv_query($connect, $Query_LabelPrint, $params, $options);		
        $Count_LabelPrint = sqlsrv_num_rows($Result_LabelPrint);        
    }         
    
    //★메뉴 진입 시 실행
    //입고라벨 탭
    //ST_WO = 'R' 오더상태가 발행
    $Query_OrderInfo = "SELECT top 100 * from NEOE.NEOE.PR_WO WHERE ST_WO = 'R' AND DTS_INSERT > '20220101000000' order by DTS_INSERT desc";             
    $Result_OrderInfo = sqlsrv_query($connect, $Query_OrderInfo, $params, $options);		
    $Count_OrderInfo = sqlsrv_num_rows($Result_OrderInfo);