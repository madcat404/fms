<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.2.13>
	// Description:	<경비원 보고서>	
    // Last Modified: <25.10.15> - Refactored for PHP 8.x	
	// =============================================
    
    //★DB연결 및 함수사용
    include '../session/ip_session.php';
    include '../DB/DB2.php';

    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';  

    // SQL Injection 방지를 위해 파라미터 준비
    $params_date = [$Minus1Day];

    //★메뉴 진입 시 실행
    //당숙일진
    $Query_Guard = "SELECT * FROM CONNECT.dbo.GUARD WHERE SORTING_DATE = ?";
    $Result_Guard = sqlsrv_query($connect, $Query_Guard, $params_date);
    if ($Result_Guard === false) { die(print_r(sqlsrv_errors(), true)); }
    $Data_Guard = sqlsrv_fetch_array($Result_Guard);  
    $Count_Guard = $Data_Guard ? 1 : 0;

    //순찰
    $Query_TodayCheckList = "SELECT * FROM CONNECT.dbo.DUTY2 WHERE SORTING_DATE = ?";
    $Result_TodayCheckList = sqlsrv_query($connect, $Query_TodayCheckList, $params_date);
    if ($Result_TodayCheckList === false) { die(print_r(sqlsrv_errors(), true)); }
    $Data_TodayCheckList = sqlsrv_fetch_array($Result_TodayCheckList);
    $Count_TodayCheckList = $Data_TodayCheckList ? 1 : 0;

    //방문자
    // report_guard.php에서 while 루프로 처리하므로 여기서는 결과셋만 준비합니다.
    $Query_GuestToday = "SELECT * FROM CONNECT.dbo.GUEST WHERE SORTING_DATE = ?";
    $Result_GuestToday = sqlsrv_query($connect, $Query_GuestToday, $params_date);
    if ($Result_GuestToday === false) { die(print_r(sqlsrv_errors(), true)); }