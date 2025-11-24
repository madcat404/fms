<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.12.20>
	// Description:	<라벨중복검사기 라벨>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';  

    //★변수정의
    $cd_item = $_GET["cd_item"] ?? null;
    $qt_goods = $_GET["qt_goods"] ?? null;

    //★페이지 진입 시 실행
    //마지막 로트번호 검색
    // SQL Injection 방지를 위해 파라미터화된 쿼리 사용
    $Query_LastLotNum = "SELECT TOP 1 BOX_LOT_NUM from CONNECT.dbo.LABEL_INSPECT where SORTING_DATE=? and CD_ITEM=? AND PRINT_YN='Y' order by BOX_LOT_NUM desc";
    $params_lastlot = array($Hyphen_today, $cd_item);
    $Result_LastLotNum = sqlsrv_query($connect, $Query_LastLotNum, $params_lastlot, $options);
    
    if ($Result_LastLotNum === false) {
        // 쿼리 실패 시 오류 처리
        // 실제 운영 환경에서는 오류를 로그 파일에 기록하는 것이 좋습니다.
        die("데이터베이스 쿼리 실행에 실패했습니다.");
    }
    
    $last_lot_num = null;
    $Data_LastLotNum = sqlsrv_fetch_array($Result_LastLotNum);

    $count_last_lot_num = ($Data_LastLotNum !== null) ? 1 : 0;
    
    if ($count_last_lot_num > 0) {
        $last_lot_num = $Data_LastLotNum['BOX_LOT_NUM'];
    }

    //로트번호 생성
    // LotNumber 함수가 첫번째 인자로 count를 받을 경우를 대비하여 0 또는 1을 전달
    $lot_num = LotNumber($count_last_lot_num, $last_lot_num);
?>