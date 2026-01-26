<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.04.03>
	// Description:	<테스트제품라벨>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../FUNCTION.php'; 

    //★변수정의  
    $cd_item = strtoupper(trim($_POST['item41']));   
    $cd_item = str_replace(' ', '_', $cd_item); //중간 공백제거 (데이터 중간에 공백이 있는 경우가 있었고 이를 위한 추가 코딩 25.02.41)
    $note = $_POST['note41']; 
    $b_count = $_POST["label41"];  //출력할 라벨 개수
    $cost= $_GET['cost'];

    $contents41 = $_POST['contents41']; 
    $test_user41 = $_POST['test_user41']; 
    $sw41 = $_POST['sw41']; 
    $sample_num41 = $_POST['sample_num41']; 
    $purpose41 = $_POST['purpose41']; 
    $hw41 = $_POST['hw41']; 

    //출력라벨 개수가 0인 경우
    if($b_count==0 and $cost=='') {
        echo "<script>alert('출력할 라벨 개수를 선택하세요!');history.back();</script>";
    } 

    if($b_count!='' and $cost=='') {
        $cost=$b_count-1;
    }

    //두번째부터 get으로 받을때 
    if($cd_item=='') {
        $cd_item = $_GET['item41'];   
        $note = $_GET['note41']; 
    }

    //마지막 로트번호 검색
    $Query_LastLotNum = "select TOP 1 * from CONNECT.dbo.TEST_ROOM_LABEL where SORTING_DATE='$Hyphen_today' and CD_ITEM='$cd_item' order by LOT_NUM desc";              
    $Result_LastLotNum = sqlsrv_query($connect, $Query_LastLotNum, $params, $options);	
    $Count_LastLotNum = sqlsrv_num_rows($Result_LastLotNum);
    $Data_LastLotNum = sqlsrv_fetch_array($Result_LastLotNum); //실행된 쿼리값을 읽음

    //로트번호 생성
    $lot_num = strtoupper(LotNumber2($Count_LastLotNum, $Data_LastLotNum['LOT_NUM'], 'direct'));   
?>