<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.26>
	// Description:	<직원차량>	
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php';
    include_once __DIR__ . '/../DB/DB4.php'; // $connect4 변수 포함


    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include '../TAB.php';     
    

    //★매뉴 진입 시 실행
    $Query_Car = "select * from user_info where USE_YN='Y' AND CAR_NM!='-'";
    $Result_Car = $connect4->query($Query_Car);	
    $Count_Car = $Result_Car->num_rows; 