<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.11.14>
	// Description:	<발열검사기 뷰어>
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php';
    include_once __DIR__ . '/../DB/DB2.php'; // $connect 변수 포함


    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include '../TAB.php';     
    

    //★매뉴 진입 시 실행
    $Query_inspect = "select * from QIS.dbo.M_TEMP_LOG_RESISTANCE_DETAIL";
    $Result_inspect = sqlsrv_query($connect, $Query_inspect); 