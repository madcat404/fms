<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com> 	
	// Create date: <24.09.12>
	// Description:	<사용인감>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
	// =============================================

    //★DB연결 및 함수사용
    //require_once __DIR__ . '/../session/session_check.php';    
    //include '../FUNCTION.php';
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../FUNCTION.php';


    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php'; 


    //★변수모음 
    $flag = $_GET['flag'] ?? '';  

    //탭2 
    $bt22 =  $_POST['bt22'] ?? '';
    $dt22 = $_POST['dt22'] ?? '';
    $s_dt22 = substr($dt22, 0, 10); 		
	$e_dt22 = substr($dt22, 13, 10);

    //모바일 입력
    $user11 =  $_POST['user11'] ?? '';
    $contents11 =  $_POST['contents11'] ?? '';
    $submit11 =  $_POST['submit11'] ?? '';
    $bt11 =  $_POST['bt11'] ?? '';

    //로그
    $bt13 =  $_POST['bt13'] ?? '';
    $dt13 = $_POST['dt13'] ?? '';
    $s_dt13 = substr($dt13, 0, 10);
	$e_dt13 = substr($dt13, 13, 10);


    //★버튼 클릭 시 실행
    //지급
    IF($bt11=="on") {
        $Query_ID = "SELECT TOP 1 NM_KOR from NEOE.NEOE.MA_EMP WHERE NO_RES LIKE ?";
        $params = [$user11.'%'];
        $Result_ID = sqlsrv_query($connect, $Query_ID, $params);
        $Data_ID = sqlsrv_fetch_array($Result_ID);   

        IF($Data_ID) {
            $Query_InsertSeal= "INSERT INTO CONNECT.dbo.SEAL(NAME, CONTENTS, WHERE_USE) VALUES(?, ?, ?)";
            $params_insert = [$Data_ID['NM_KOR'], $contents11, $submit11];
            sqlsrv_query($connect, $Query_InsertSeal, $params_insert);

            echo "<script>alert(\"입력 되었습니다!\");location.href='seal.php?flag=log';</script>";
        }
        else {
            echo "<script>alert(\"아이윈 직원이 아닙니다!\");location.href='seal.php';</script>";
        }
    }
    //로그
    ELSEIF($bt13=="on") {
        $Query_Seal= "SELECT * from CONNECT.dbo.SEAL where SORTING_DATE BETWEEN ? AND ? order by NO desc";
        $params_seal = [$s_dt13, $e_dt13];
        $Result_Seal= sqlsrv_query($connect, $Query_Seal, $params_seal);
    }  
    //로그 pc
    ELSEIF($bt22=="on") {
        $Query_Seal22= "SELECT * from CONNECT.dbo.SEAL where SORTING_DATE BETWEEN ? AND ? order by NO desc";
        $params_seal22 = [$s_dt22, $e_dt22];
        $Result_Seal22= sqlsrv_query($connect, $Query_Seal22, $params_seal22);
    }
    else {
        //기본적으로 목록을 표시하기 위한 초기화
        $s_dt22 = date('Y-m-d');
        $e_dt22 = date('Y-m-d');
        $dt22 = $s_dt22 . ' ~ ' . $e_dt22;
        $Query_Seal22= "SELECT * from CONNECT.dbo.SEAL where SORTING_DATE BETWEEN ? AND ? order by NO desc";
        $params_seal22 = [$s_dt22, $e_dt22];
        $Result_Seal22= sqlsrv_query($connect, $Query_Seal22, $params_seal22);

        $s_dt13 = date('Y-m-d');
        $e_dt13 = date('Y-m-d');
        $dt13 = $s_dt13 . ' ~ ' . $e_dt13;
        $Query_Seal= "SELECT * from CONNECT.dbo.SEAL where SORTING_DATE BETWEEN ? AND ? order by NO desc";
        $params_seal = [$s_dt13, $e_dt13];
        $Result_Seal= sqlsrv_query($connect, $Query_Seal, $params_seal);
    }
?>