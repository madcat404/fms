<?php
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <22.04.28>
    // Description: <완성품 이동>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';    
    include_once __DIR__ . '/../DB/DB2.php';   
    include_once __DIR__ . '/../FUNCTION.php'; 

    //★변수정의
    $cost = $_GET['cost'] ?? null;
    $val = $_POST['seq'] ?? null;
    $len = strlen($val);
    $seq = substr($val, 1, $len - 1);

    //★페이지 진입 시 실행
    //1번째 라벨 출력 시
    if ($cost === null) {
        $country = substr($val, 0, 1);

        $cd_item = $_POST[$country . 'ITEM' . $seq] ?? null;
        $lot_size = $_POST[$country . 'size' . $seq] ?? null;
        $option = $_POST[$country . 'option' . $seq] ?? null;
        $as_flag = $_POST[$country . 'AS_YN' . $seq] ?? null;

        $table_suffix = '';
        if ($country === 'v') {
            $table_suffix = '_V';
        } elseif ($country === 'c') {
            $table_suffix = '_C';
        }

        $error_goods_select = ($country === 'k') ? 'ISNULL(SUM(ERROR_GOODS),0) AS ERROR_GOODS,' : '';

        $query_wait = "SELECT
                        ISNULL(SUM(QT_GOODS),0) AS QT_GOODS,
                        ISNULL(SUM(REJECT_GOODS),0) AS REJECT_GOODS,
                        {$error_goods_select}
                        ISNULL(SUM(REJECT_DISUSE),0) AS REJECT_DISUSE,
                        ISNULL(SUM(REJECT_WAIT),0) AS REJECT_WAIT,
                        ISNULL(SUM(REJECT_REWORK),0) AS REJECT_REWORK,
                        ISNULL(SUM(PRINT_QT),0) AS PRINT_QT
                       FROM CONNECT.dbo.FIELD_PROCESS_FINISH{$table_suffix}
                       WHERE PRINT_YN!='Y' AND CD_ITEM=? AND SORTING_DATE>='2023-04-01'";

        $params_wait = array($cd_item);
        $result_wait = sqlsrv_query($connect, $query_wait, $params_wait);
        $data_wait = sqlsrv_fetch_array($result_wait, SQLSRV_FETCH_ASSOC);

        $MQT = $data_wait['QT_GOODS'] - $data_wait['REJECT_GOODS'] + $data_wait['REJECT_REWORK'] + ($data_wait['ERROR_GOODS'] ?? 0) - $data_wait['PRINT_QT'];

        if ($MQT == 0) {
            $exit = 1;
            echo "<script>alert(\"완료수량이 0입니다!\");location.href='complete_label.php';</script>";
            exit;
        }

        $remainder = $MQT % $lot_size;

        if ($remainder == 0) {
            $cost = intval($MQT / $lot_size) - 1;
        } else {
            $cost = intval($MQT / $lot_size);
            $ends_flag = 1;
        }

        if ($cost <= 0) { // 1장 또는 1장 미만일 경우
            $cost = 0;
            if ($MQT == $lot_size) {
                $lot_size = $MQT;
            } else {
                $lot_size = $remainder;
                if ($ends_flag == 1) {
                    $ends = 1;
                }
            }
        }
    }
    //2번째 이상 라벨 출력 시
    else {
        $country = $_GET["country"] ?? null;
        $MQT = $_GET["MQT"] ?? null;
        $cd_item = $_GET["item"] ?? null;
        $lot_size = $_GET['lot_size'] ?? null;
        $remainder = $_GET["remainder"] ?? null;
        $ends_flag = $_GET["ends_flag"] ?? null;
        $as_flag = $_GET["as_flag"] ?? null;

        if ($cost == 0 && $remainder != 0) {
            $lot_size = $remainder;
            if ($ends_flag == 1) {
                $ends = 1;
            }
        }
    }

    //마지막 로트번호 검색
    $Query_LastLotNum = "SELECT TOP 1 LOT_NUM FROM CONNECT.dbo.PACKING_LOG WHERE SORTING_DATE=? AND CD_ITEM=? AND LOT_NUM NOT LIKE '%A%' ORDER BY LOT_NUM DESC";
    $params_lastlot = array($Hyphen_today, $cd_item);
    $Result_LastLotNum = sqlsrv_query($connect, $Query_LastLotNum, $params_lastlot);
    
    $Data_LastLotNum = null;
    $Count_LastLotNum = 0;
    if($Result_LastLotNum && ($Data_LastLotNum = sqlsrv_fetch_array($Result_LastLotNum, SQLSRV_FETCH_ASSOC))) {
        $Count_LastLotNum = 1;
    }

    //로트번호 생성
    $lot_num = LotNumber($Count_LastLotNum, $Data_LastLotNum['LOT_NUM'] ?? null);
?>