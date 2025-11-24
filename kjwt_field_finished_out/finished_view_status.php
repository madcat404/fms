<?php   
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.30>
	// Description:	<완성품 뷰어>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';    


    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';               
    
   
    //★메뉴 진입 시 실행
    //옥해종
    //출하오더
    $Query_Order11 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='옥해종'";              
    $Result_Order11 = sqlsrv_query($connect, $Query_Order11);
    $Data_Order11  = ($Result_Order11 && sqlsrv_has_rows($Result_Order11)) ? sqlsrv_fetch_array($Result_Order11) : ['QT_GOODS' => 0];

    //출하실적
    $Query_Order12 = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='옥해종'";              
    $Result_Order12 = sqlsrv_query($connect, $Query_Order12);
    $Data_Order12  = ($Result_Order12 && sqlsrv_has_rows($Result_Order12)) ? sqlsrv_fetch_array($Result_Order12) : ['PCS' => 0];

    //출문
    $Query_Order13 = "SELECT TOP 1 * from CONNECT.dbo.GATE WHERE SORTING_DATE='$Hyphen_today' and NAME='옥해종' and INOUT='OUT' order by RECORD_DATE DESC";              
    $Result_Order13 = sqlsrv_query($connect, $Query_Order13);
    $Data_Order13  = ($Result_Order13 && sqlsrv_has_rows($Result_Order13)) ? sqlsrv_fetch_array($Result_Order13) : null;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //손규백
    //출하오더
    $Query_Order21 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='손규백'";              
    $Result_Order21 = sqlsrv_query($connect, $Query_Order21);
    $Data_Order21  = ($Result_Order21 && sqlsrv_has_rows($Result_Order21)) ? sqlsrv_fetch_array($Result_Order21) : ['QT_GOODS' => 0];
    
    //출하실적
    $Query_Order22 = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='손규백'";              
    $Result_Order22 = sqlsrv_query($connect, $Query_Order22);
    $Data_Order22  = ($Result_Order22 && sqlsrv_has_rows($Result_Order22)) ? sqlsrv_fetch_array($Result_Order22) : ['PCS' => 0];

    //출문
    $Query_Order23 = "SELECT TOP 1 * from CONNECT.dbo.GATE WHERE SORTING_DATE='$Hyphen_today' and NAME='손규백' and INOUT='OUT' order by RECORD_DATE DESC";              
    $Result_Order23 = sqlsrv_query($connect, $Query_Order23);
    $Data_Order23  = ($Result_Order23 && sqlsrv_has_rows($Result_Order23)) ? sqlsrv_fetch_array($Result_Order23) : null;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //최기완
    //출하오더
    $Query_Order31 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='최기완'";              
    $Result_Order31 = sqlsrv_query($connect, $Query_Order31);
    $Data_Order31  = ($Result_Order31 && sqlsrv_has_rows($Result_Order31)) ? sqlsrv_fetch_array($Result_Order31) : ['QT_GOODS' => 0];

    //출하실적
    $Query_Order32 = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='최기완'";              
    $Result_Order32 = sqlsrv_query($connect, $Query_Order32);
    $Data_Order32  = ($Result_Order32 && sqlsrv_has_rows($Result_Order32)) ? sqlsrv_fetch_array($Result_Order32) : ['PCS' => 0];

    //출문
    $Query_Order33 = "SELECT TOP 1 * from CONNECT.dbo.GATE WHERE SORTING_DATE='$Hyphen_today' and NAME='최기완' and INOUT='OUT' order by RECORD_DATE DESC";              
    $Result_Order33 = sqlsrv_query($connect, $Query_Order33);
    $Data_Order33  = ($Result_Order33 && sqlsrv_has_rows($Result_Order33)) ? sqlsrv_fetch_array($Result_Order33) : null;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //조근선
    //출하오더
    $Query_Order41 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='조근선'";              
    $Result_Order41 = sqlsrv_query($connect, $Query_Order41);
    $Data_Order41  = ($Result_Order41 && sqlsrv_has_rows($Result_Order41)) ? sqlsrv_fetch_array($Result_Order41) : ['QT_GOODS' => 0];

    //출하실적
    $Query_Order42 = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='조근선'";              
    $Result_Order42 = sqlsrv_query($connect, $Query_Order42);
    $Data_Order42  = ($Result_Order42 && sqlsrv_has_rows($Result_Order42)) ? sqlsrv_fetch_array($Result_Order42) : ['PCS' => 0];

    //출문
    $Query_Order43 = "SELECT TOP 1 * from CONNECT.dbo.GATE WHERE SORTING_DATE='$Hyphen_today' and NAME='조근선' and INOUT='OUT' order by RECORD_DATE DESC";              
    $Result_Order43 = sqlsrv_query($connect, $Query_Order43);
    $Data_Order43  = ($Result_Order43 && sqlsrv_has_rows($Result_Order43)) ? sqlsrv_fetch_array($Result_Order43) : null;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //박정민
    //출하오더
    $Query_Order51 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='박정민'";              
    $Result_Order51 = sqlsrv_query($connect, $Query_Order51);
    $Data_Order51  = ($Result_Order51 && sqlsrv_has_rows($Result_Order51)) ? sqlsrv_fetch_array($Result_Order51) : ['QT_GOODS' => 0];
    
    //출하실적
    $Query_Order52 = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='박정민'";              
    $Result_Order52 = sqlsrv_query($connect, $Query_Order52);
    $Data_Order52  = ($Result_Order52 && sqlsrv_has_rows($Result_Order52)) ? sqlsrv_fetch_array($Result_Order52) : ['PCS' => 0];

    //출문
    $Query_Order53 = "SELECT TOP 1 * from CONNECT.dbo.GATE WHERE SORTING_DATE='$Hyphen_today' and NAME='박정민' and INOUT='OUT' order by RECORD_DATE DESC";              
    $Result_Order53 = sqlsrv_query($connect, $Query_Order53);
    $Data_Order53  = ($Result_Order53 && sqlsrv_has_rows($Result_Order53)) ? sqlsrv_fetch_array($Result_Order53) : null;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //김영민
    //출하오더
    $Query_Order61 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='김영민'";              
    $Result_Order61 = sqlsrv_query($connect, $Query_Order61);
    $Data_Order61  = ($Result_Order61 && sqlsrv_has_rows($Result_Order61)) ? sqlsrv_fetch_array($Result_Order61) : ['QT_GOODS' => 0];
    
    //출하실적
    $Query_Order62 = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='김영민'";              
    $Result_Order62 = sqlsrv_query($connect, $Query_Order62);
    $Data_Order62  = ($Result_Order62 && sqlsrv_has_rows($Result_Order62)) ? sqlsrv_fetch_array($Result_Order62) : ['PCS' => 0];

    //출문
    $Query_Order63 = "SELECT TOP 1 * from CONNECT.dbo.GATE WHERE SORTING_DATE='$Hyphen_today' and NAME='김영민' and INOUT='OUT' order by RECORD_DATE DESC";              
    $Result_Order63 = sqlsrv_query($connect, $Query_Order63);
    $Data_Order63  = ($Result_Order63 && sqlsrv_has_rows($Result_Order63)) ? sqlsrv_fetch_array($Result_Order63) : null;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //기타
    //출하오더
    $Query_Order71 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='기타'";              
    $Result_Order71 = sqlsrv_query($connect, $Query_Order71);
    $Data_Order71  = ($Result_Order71 && sqlsrv_has_rows($Result_Order71)) ? sqlsrv_fetch_array($Result_Order71) : ['QT_GOODS' => 0];
    
    //출하실적
    $Query_Order72 = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='기타'";              
    $Result_Order72 = sqlsrv_query($connect, $Query_Order72);
    $Data_Order72  = ($Result_Order72 && sqlsrv_has_rows($Result_Order72)) ? sqlsrv_fetch_array($Result_Order72) : ['PCS' => 0];

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //천안
    //출하오더
    $Query_Order81 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='천안'";              
    $Result_Order81 = sqlsrv_query($connect, $Query_Order81);
    $Data_Order81  = ($Result_Order81 && sqlsrv_has_rows($Result_Order81)) ? sqlsrv_fetch_array($Result_Order81) : ['QT_GOODS' => 0];
    
    //출하실적
    $Query_Order82 = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='천안'";              
    $Result_Order82 = sqlsrv_query($connect, $Query_Order82);
    $Data_Order82  = ($Result_Order82 && sqlsrv_has_rows($Result_Order82)) ? sqlsrv_fetch_array($Result_Order82) : ['PCS' => 0];

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //합계
    //출하실적
    $Query_Order92 = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today'";              
    $Result_Order92 = sqlsrv_query($connect, $Query_Order92);
    $Data_Order92  = ($Result_Order92 && sqlsrv_has_rows($Result_Order92)) ? sqlsrv_fetch_array($Result_Order92) : ['PCS' => 0];
?>
