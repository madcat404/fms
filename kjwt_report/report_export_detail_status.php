<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.06.09>
	// Description:	<b/l기반 erp 정보 출력>
    // Last Modified: <25.10.15> - Refactored for PHP 8.x	
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';     


    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';   
    
    
    //★변수모음      
    //탭2
    $bl = $_GET["bl"];	
    

    //★매뉴 진입 시 실행
    $Query_ExportDetail = "select * from NEOE.NEOE.TR_INVL WHERE NO_BL='$bl'";
    $Result_ExportDetail = sqlsrv_query($connect, $Query_ExportDetail, $params, $options);		
    $Count_ExportDetail = sqlsrv_num_rows($Result_ExportDetail);

    $Query_ExportDetail2 = "select * from CONNECT.dbo.DISTRIBUTION WHERE SORTING_DATE='$Hyphen_today' AND bl='$bl'";
    $Result_ExportDetail2 = sqlsrv_query($connect, $Query_ExportDetail2, $params, $options);		
    $Count_ExportDetail2 = sqlsrv_num_rows($Result_ExportDetail2);
?>