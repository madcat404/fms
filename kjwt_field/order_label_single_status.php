<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.25><22.09.28>
	// Description:	<ERP 작업지시번호 라벨 & 공정진행표 라벨>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x		
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';  

    //★변수정의  
    $seq = $_POST['seq'] ?? '';   
    $post_key = 'order_no'.$seq;
    $order_no = $_POST[$post_key] ?? '';