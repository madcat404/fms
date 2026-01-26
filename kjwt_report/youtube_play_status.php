<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.10.15>
	// Description:	<유튜브 재생>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x	
	// =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB1.php';   
        

    $no = $_GET["play"];	

    //★메뉴 진입 시 실행
    $Query_Play = "select * from PLAYITEM WHERE NO=$no";              
    $Result_Play = $connect->query($Query_Play);		
    $Data_Play = mysqli_fetch_array($Result_Play);   
?>