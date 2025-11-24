<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.02.22>
	// Description:	<회사 입출문>
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================

    // Using include_once to prevent multiple inclusions
    include_once '../FUNCTION.php';  
    include_once '../DB/DB4.php';  
    include_once '../DB/DB2.php';  
    include_once '../DB/DB3.php';   

    // Safely initialize variables from POST/GET using the null coalescing operator
    $inout21 = $_POST["inout21"] ?? null;
    $name21 = isset($_POST["name21"]) ? strtoupper($_POST["name21"]) : null;
    $bt21 = $_POST["bt21"] ?? null;  
    
    $dt3 = $_POST["dt3"] ?? null;    
    $bt31 = $_POST["bt31"] ?? null; 

    $NfcOutName = $_GET["outnfc"] ?? null;
    $NfcInName = $_GET["innfc"] ?? null;
    $NfcKind = $_GET["kind"] ?? null;

    // Default active tab
    $tab_sequence = 2; 

    // Handle NFC parameter validation and exit to prevent further execution
    if ($NfcKind === "OUT" && empty($NfcOutName)) {
        echo "<script>alert('이름을 입력하세요!');location.href='gate_out_nfc.php';</script>";
        exit;
    }

    if ($NfcKind === "IN" && empty($NfcInName)) {
        echo "<script>alert('이름을 입력하세요!');location.href='gate_in_nfc.php';</script>";
        exit;
    }
    
    // Main logic based on button clicks or NFC parameters
    if ($bt21 === "on") {
        $tab_sequence = 2; 

        $delivery_map = [
            'DELIVERY1' => '옥해종',
            'DELIVERY2' => '손규백',
            'DELIVERY3' => '최기완',
            'DELIVERY4' => '조근선',
            'DELIVERY5' => '박정민',
            'DELIVERY6' => '김영민',
            'DELIVERY7' => '기타',
        ];
        $final_name = $delivery_map[$name21] ?? $name21;

        if (!empty($final_name) && !empty($inout21)) {
            $Query_InOut = "INSERT INTO CONNECT.dbo.GATE(INOUT, NAME) VALUES(?, ?)";
            $params_insert = [$inout21, $final_name];
            sqlsrv_query($connect, $Query_InOut, $params_insert);
        }
    }     
    else if ($bt31 === "on") {
        $tab_sequence = 3; 

        $s_dt3 = substr($dt3, 0, 10);
		$e_dt3 = substr($dt3, 13, 10);

        // Use prepared statements to prevent SQL Injection
        // Also validate date format before using in query
        if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $s_dt3) && preg_match("/^\d{4}-\d{2}-\d{2}$/", $e_dt3)) {
            $Query_InOutPrint = "SELECT * FROM CONNECT.dbo.GATE WHERE SORTING_DATE BETWEEN ? AND ?";
            $params_select = [$s_dt3, $e_dt3];
            $Result_InOutPrint = sqlsrv_query($connect, $Query_InOutPrint, $params_select);
            // $Count_InOutPrint is removed as it's deprecated and no longer needed for the refactored gate.php view
        }
    } 
    else if (!empty($NfcOutName) && $NfcKind === 'OUT') {
        $tab_sequence = 2; 
        $Query_InOut = "INSERT INTO CONNECT.dbo.GATE(INOUT, NAME) VALUES(?, ?)";
        $params_nfc_out = [$NfcKind, $NfcOutName];
        sqlsrv_query($connect, $Query_InOut, $params_nfc_out);
    }
    else if (!empty($NfcInName) && $NfcKind === 'IN') {
        $tab_sequence = 2; 
        $Query_InOut = "INSERT INTO CONNECT.dbo.GATE(INOUT, NAME) VALUES(?, ?)";
        $params_nfc_in = [$NfcKind, $NfcInName];
        sqlsrv_query($connect, $Query_InOut, $params_nfc_in);
    }
   
    // Set active tab
    include '../TAB.php';  

    // Always fetch today's records for the main view
    // Assuming $Hyphen_today is a safe, server-generated value like date('Y-m-d')
    $Query_InOutToday = "SELECT * FROM CONNECT.dbo.GATE WHERE SORTING_DATE = ?";
    $params_today = [$Hyphen_today]; // Assuming $Hyphen_today is defined in FUNCTION.php
    $Result_InOutToday = sqlsrv_query($connect, $Query_InOutToday, $params_today);
    // $Count_InOutToday is removed as it's deprecated and no longer needed for the refactored gate.php view
?>
