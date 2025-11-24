<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.26>
	// Description:	<직원차량>	
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
    // =============================================

    //★DB연결 및 함수사용
    include_once __DIR__ . '/../session/ip_session.php';
    include_once __DIR__ . '/../DB/DB3.php'; 


    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php';     
    

    //★매뉴 진입 시 실행
    $query_schedule = "SELECT * FROM t_sc_sch WHERE mcal_seq = ? AND use_yn = 'Y'";
    $mcal_seq = '119';
    $stmt = $connect3->prepare($query_schedule);
    $stmt->bind_param('s', $mcal_seq);
    $stmt->execute();
    $Result_schedule = $stmt->get_result();

?>