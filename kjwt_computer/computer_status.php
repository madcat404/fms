<?php

    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.21>
	// Description:	<노트북 대여>	
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
	// =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
     

    //★메뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php'; 


    //★변수모음 
    $computer21 = $_POST["computer21"] ?? null;
    $user21 = $_POST["user21"] ?? null;
    $note21 = $_POST["note21"] ?? null;
    $bt21 = $_POST["bt21"] ?? null;  

    $computer22 = $_POST["computer22"] ?? null;
    $note22 = $_POST["note22"] ?? null;
    $bt22 = $_POST["bt22"] ?? null;  
    
    $dt3 = $_POST["dt3"] ?? null;
    $s_dt3 = substr($dt3 ?? '', 0, 10);
	$e_dt3 = substr($dt3 ?? '', 13, 10);
    $bt31 = $_POST["bt31"] ?? null; 

    
    //★버튼 클릭 시 실행
    //대여
    IF($bt21=="on" && $computer21 && $user21) {
        $tab_sequence=2; 
        include '../TAB.php';  

        $Query_UpdateComputer= "UPDATE CONNECT.dbo.ASSET SET USE_YN='LO' WHERE ASSET_NUM=?";
        sqlsrv_query($connect, $Query_UpdateComputer, [&$computer21]);

        $Query_InsertComputer= "INSERT INTO CONNECT.dbo.ASSET_NOTEBOOK(ASSET_NUM, IWIN_USER, RENT_DATE, RENT_REASON) VALUES(?, ?, ?, ?)";
        sqlsrv_query($connect, $Query_InsertComputer, [&$computer21, &$user21, &$Hyphen_today, &$note21]);
    }
    //반납
    ELSEIF($bt22=="on" && $computer22) {
        $tab_sequence=2; 
        include '../TAB.php';      

        $Query_UpdateComputer= "UPDATE CONNECT.dbo.ASSET SET USE_YN='LI' WHERE ASSET_NUM=?";
        sqlsrv_query($connect, $Query_UpdateComputer, [&$computer22]);
        
        $Query_InsertComputer= "UPDATE CONNECT.dbo.ASSET_NOTEBOOK SET RETURN_DATE=?, NOTE=? WHERE ASSET_NUM=? AND RETURN_DATE IS NULL";
        sqlsrv_query($connect, $Query_InsertComputer, [&$Hyphen_today, &$note22, &$computer22]);
    }

    function fetch_objects($result) {
        $array = [];
        if ($result === false) return $array;
        while ($object = sqlsrv_fetch_object($result)) {
            $array[] = $object;
        }
        return $array;
    }

    //★메뉴 진입 시 실행
    //대여 가능
    $Query_InComputer= "SELECT * from CONNECT.dbo.ASSET WHERE USE_YN='LI'";              
    $Result_InComputer= sqlsrv_query($connect, $Query_InComputer);
    $In_computer = fetch_objects($Result_InComputer);

    //대여
    $Query_OutComputer= "SELECT * from CONNECT.dbo.ASSET WHERE USE_YN='LO'";              
    $Result_OutComputer= sqlsrv_query($connect, $Query_OutComputer);
    $Out_computer = fetch_objects($Result_OutComputer);

    $Query_Computer= "SELECT * from CONNECT.dbo.ASSET WHERE USE_YN='LI' OR USE_YN='LO' ORDER BY ASSET_NUM DESC";              
    $Result_Computer_res = sqlsrv_query($connect, $Query_Computer);
    $Computer_data = [];
    if ($Result_Computer_res) {
        while($row = sqlsrv_fetch_array($Result_Computer_res, SQLSRV_FETCH_ASSOC)) {
            $Computer_data[] = $row;
        }
    }
?>