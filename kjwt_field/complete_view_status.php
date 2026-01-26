<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.30>
	// Description:	<완성품 뷰어>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';    
    include_once __DIR__ . '/../FUNCTION.php';   

    $DT = date("Y-m-d H:i:s");


    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';               
    

    //★메뉴 진입 시 실행
    //bb 출고 오더 - ★bb에서 공정창고로 빠지는 오더는 제외해야 한다.
    $Query_Order11 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.BB_OUTPUT_LOG WHERE REQUEST_DT='$NoHyphen_today' and INPUT_LOCATION='검사대기창고'";              
    $Result_Order11 = sqlsrv_query($connect, $Query_Order11, $params, $options);		
    $Data_Order11  = sqlsrv_fetch_array($Result_Order11);    

    //bb 출고 (검사대기) - ★bb에서 공정창고로 빠지는 오더는 제외해야 한다.
    $Query_Order12 = "SELECT ISNULL(SUM(COMPLETE), 0) AS COMPLETE from CONNECT.dbo.BB_OUTPUT_LOG WHERE REQUEST_DT='$NoHyphen_today' and INPUT_LOCATION='검사대기창고'";              
    $Result_Order12 = sqlsrv_query($connect, $Query_Order12, $params, $options);		
    $Data_Order12  = sqlsrv_fetch_array($Result_Order12);  

    //검사완료 - 베트남
    $Query_Order13 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE='$Hyphen_today'";              
    $Result_Order13 = sqlsrv_query($connect, $Query_Order13, $params, $options);		
    $Data_Order13  = sqlsrv_fetch_array($Result_Order13);  

    //검사완료 - 중국
    $Query_Order14 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE SORTING_DATE='$Hyphen_today'";              
    $Result_Order14 = sqlsrv_query($connect, $Query_Order14, $params, $options);		
    $Data_Order14  = sqlsrv_fetch_array($Result_Order14);