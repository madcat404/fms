<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.10.27>
	// Description:	<포장라벨 커스텀>		
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';    
    include_once __DIR__ . '/../DB/DB2.php';   
    include_once __DIR__ . '/../FUNCTION.php';  
        
    //★변수정의 (Null coalescing operator for PHP 8.x compatibility)
    $popitem = $_GET["popitem"] ?? null;
    $cost = $_GET['cost'] ?? null;

    if ($popitem === null) {
        // From POST
        $kind = $_POST['kind51'] ?? null;
        $country = $_POST['country51'] ?? null;
        $cd_item = strtoupper(HyphenRemove(trim($_POST['item51'] ?? '')));
        $lot_size = $_POST['size51'] ?? null;
        $note = $_POST['note51'] ?? null;
        $b_count = $_POST["label51"] ?? null;
    } else {
        // From GET (after popitem redirect)
        $kind = $_GET['kind'] ?? null;
        $country = $_GET['country'] ?? null;
        $cd_item = strtoupper(HyphenRemove(trim($popitem)));
        $lot_size = $_GET['lot_size'] ?? null;
        $note = $_GET['note'] ?? null;
        $b_count = $_GET["b_count"] ?? null;
    }
    $cd_item = str_replace(' ', '', $cd_item); //중간 공백제거

    // From GET (recursive call)
    if ($cd_item == '') {
        $kind = $_GET['kind51'] ?? $kind;
        $country = $_GET['country51'] ?? $country;
        $cd_item = $_GET['item51'] ?? $cd_item;
        $lot_size = $_GET['size51'] ?? $lot_size;
        $note = $_GET['note51'] ?? $note;
    }

    // GO-Series redirect logic
    if ($popitem === null && in_array($cd_item, ['88170GO200', '88370GO100', '89170GO050', '89370GO050', '8888888888'])) {
        $redirect_url = sprintf(
            "complete_label_pop.php?cd_item=%s&kind=%s&country=%s&lot_size=%s&note=%s&b_count=%s",
            urlencode($cd_item),
            urlencode($kind),
            urlencode($country),
            urlencode($lot_size),
            urlencode($note),
            urlencode($b_count)
        );
        echo "<script>location.href='$redirect_url';</script>";
        exit;
    }

    //출력라벨 개수가 0인 경우
    if (($b_count === '0' || $b_count === 0) && $cost === null) {
        echo "<script>alert('출력할 라벨 개수를 선택하세요!');history.back();</script>";
        exit;
    }

    if ($b_count !== null && $cost === null) {
        $cost = $b_count - 1;
    }

    //마지막 로트번호 검색 (Parameterized Query)
    $Query_LastLotNum = "SELECT TOP 1 LOT_NUM FROM CONNECT.dbo.PACKING_LOG WHERE SORTING_DATE=? AND CD_ITEM=? AND LOT_NUM LIKE 'A%' ORDER BY LOT_NUM DESC";
    $params_lastlot = array($Hyphen_today, $cd_item);
    $Result_LastLotNum = sqlsrv_query($connect, $Query_LastLotNum, $params_lastlot);

    $Data_LastLotNum = null;
    $Count_LastLotNum = 0;
    if ($Result_LastLotNum) {
        $Data_LastLotNum = sqlsrv_fetch_array($Result_LastLotNum);
        if ($Data_LastLotNum) {
            $Count_LastLotNum = 1;
        }
    }

    //로트번호 생성
    $lot_num = strtoupper(LotNumber2($Count_LastLotNum, $Data_LastLotNum['LOT_NUM'] ?? null, 'direct'));
?>