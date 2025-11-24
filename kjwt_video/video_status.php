<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.12>
	// Description:	<매뉴얼>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
    // =============================================

    //★DB연결 및 함수사용
    include_once __DIR__ . '/../session/ip_session.php'; 
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../FUNCTION.php';

    //★변수 초기화 (PHP 8.x 호환성)
    $tab2 = '';
    $tab2_text = '';

    //★메뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php';     
    
    //★메뉴 진입 시 실행
    $Query_Manual = "SELECT * FROM CONNECT.dbo.VIDEO_LIST";
    $stmt = sqlsrv_query($connect, $Query_Manual);

    $Data_Manual = [];
    if ($stmt) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Data_Manual[] = $row;
        }
    }
?>