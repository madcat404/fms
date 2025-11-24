<?php
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <21.12.20>
    // Description:	<라벨중복검사기>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php';
    include '../DB/DB2.php';
    include '../DB/DB21.php';

    //★변수정의 (PHP 8.x 호환성을 위해 null 병합 연산자 ?? 사용)
    $modi = $_GET["modi"] ?? null;
    $error = $_GET["error"] ?? null;

    // 탭2 입력값
    $item2 = trim(strtoupper($_POST["item2"] ?? ''));
    $use_function2 = CROP($item2);
    $CD_ITEM = $use_function2[0];
    $TRACE_CODE = $use_function2[1];
    $bt21 = $_POST["bt21"] ?? null;
    $bt23 = $_POST["bt23"] ?? null;

    // 탭3 입력값
    if (isset($_GET['bt31']) && $_GET['bt31'] == 'on') {
        $dt3 = $_GET["dt3"] ?? '';
        $bt31 = $_GET["bt31"] ?? null;
    } else {
        $dt3 = $_POST["dt3"] ?? '';
        $bt31 = $_POST["bt31"] ?? null;
    }
    $s_dt3 = substr($dt3, 0, 10);
    $e_dt3 = substr($dt3, 13, 10);

    //★메뉴 진입 시 탭활성화
    $tab_sequence = 2;
    if ($bt31 == "on") {
        $tab_sequence = 3;
    }
    include '../TAB.php';

    //★버튼 클릭 시 실행
    if ($bt21 == "on" && $CD_ITEM != '') {
        // SQL Injection 방지를 위해 파라미터화된 쿼리 사용
        // 중복검사
        $Query_RepeatCheck = "SELECT COUNT(*) as count FROM CONNECT.dbo.LABEL_INSPECT WHERE CD_ITEM=? AND TRACE_CODE=?";
        $params_repeat = array($CD_ITEM, $TRACE_CODE);
        $Result_RepeatCheck = sqlsrv_query($connect, $Query_RepeatCheck, $params_repeat);
        $Data_RepeatCheck = sqlsrv_fetch_array($Result_RepeatCheck);
        $Count_RepeatCheck = $Data_RepeatCheck['count'];

        // 혼합검사
        $Query_MixCheck = "SELECT TOP 1 CD_ITEM FROM CONNECT.dbo.LABEL_INSPECT WHERE SORTING_DATE=? AND PRINT_YN='N' ORDER BY NO DESC";
        $params_mix = array($Hyphen_today);
        $Result_MixCheck = sqlsrv_query($connect, $Query_MixCheck, $params_mix);
        $Data_MixCheck = sqlsrv_fetch_array($Result_MixCheck);
        $Count_MixCheck = ($Data_MixCheck) ? 1 : 0;

        if ($Count_RepeatCheck > 0) {
            echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = '0'; while(true) { var getpass = prompt('chồng lên nhau (중복되었습니다!)\n Hãy nhập số 0 đi ạ (0를 입력하세요!)'); if(pass == getpass) { location.href='label_inspect.php'; break; } } };audio.play();</script>";
        } elseif ($Count_MixCheck > 0 && $Data_MixCheck['CD_ITEM'] != $CD_ITEM) {
            echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = '0'; while(true) { var getpass = prompt('trộn lẫn (혼합되었습니다!)\n Hãy nhập số 0 đi ạ (0를 입력하세요!)'); if(pass == getpass) { location.href='label_inspect.php'; break; } } };audio.play();</script>";
        } else {
            $Query_DataSave = "INSERT INTO CONNECT.dbo.LABEL_INSPECT(CD_ITEM, TRACE_CODE, BARCODE) VALUES(?, ?, ?)";
            $params_save = array($CD_ITEM, $TRACE_CODE, $item2);
            sqlsrv_query($connect, $Query_DataSave, $params_save);
        }
    } elseif ($bt31 == "on") {
        // 검사내역 조회 (결과를 배열로 저장)
        $Query_InspectInquire = "SELECT * FROM CONNECT.dbo.LABEL_INSPECT WHERE SORTING_DATE BETWEEN ? AND ? AND PRINT_YN='Y'";
        $params_inquire = array($s_dt3, $e_dt3);
        $Result_InspectInquire = sqlsrv_query($connect21, $Query_InspectInquire, $params_inquire);
        $InspectInquire_Rows = [];
        if ($Result_InspectInquire) {
            while ($row = sqlsrv_fetch_array($Result_InspectInquire, SQLSRV_FETCH_ASSOC)) {
                $InspectInquire_Rows[] = $row;
            }
        }
        $Count_InspectInquire = count($InspectInquire_Rows);

        // 작업품목수량
        $Query_ItemCount = "SELECT COUNT(DISTINCT CD_ITEM) as count FROM CONNECT.dbo.LABEL_INSPECT WHERE SORTING_DATE BETWEEN ? AND ? AND PRINT_YN='Y'";
        $Result_ItemCount = sqlsrv_query($connect21, $Query_ItemCount, $params_inquire);
        $Data_ItemCount = sqlsrv_fetch_array($Result_ItemCount);
        $Count_ItemCount = $Data_ItemCount['count'];

        // 개별작업수량
        $Query_PcsCount = "SELECT COUNT(*) as count FROM CONNECT.dbo.LABEL_INSPECT WHERE SORTING_DATE BETWEEN ? AND ? AND PRINT_YN='Y'";
        $Result_PcsCount = sqlsrv_query($connect21, $Query_PcsCount, $params_inquire);
        $Data_PcsCount = sqlsrv_fetch_array($Result_PcsCount);
        $Count_PcsCount = $Data_PcsCount['count'];

    } elseif ($error == "on") {
        // 제일 마지막 행 삭제
        $Query_LastNoDel = "DELETE FROM CONNECT.dbo.LABEL_INSPECT WHERE NO = (SELECT MAX(NO) FROM CONNECT.dbo.LABEL_INSPECT)";
        sqlsrv_query($connect, $Query_LastNoDel);
    }

    //★메뉴 진입 시 실행
    // 라벨발행수량
    // 원본 로직(CD_ITEM, BOX_LOT_NUM 그룹의 수)을 정확히 반영하도록 수정
    $Query_PrintLabel = "SELECT COUNT(*) as count FROM (SELECT DISTINCT CD_ITEM, BOX_LOT_NUM FROM CONNECT.dbo.LABEL_INSPECT WHERE SORTING_DATE=? AND PRINT_YN='Y') as sub";
    $params_today = array($Hyphen_today);
    $Result_PrintLabel = sqlsrv_query($connect, $Query_PrintLabel, $params_today);
    $Data_PrintLabel = sqlsrv_fetch_array($Result_PrintLabel);
    $Count_PrintLabel = $Data_PrintLabel['count'];

    // 스캔수량 (효율적인 방식으로 변경)
    $Query_ScanLabel = "SELECT * FROM CONNECT.dbo.LABEL_INSPECT WHERE SORTING_DATE=? AND PRINT_YN='N' ORDER BY NO DESC";
    $Result_ScanLabel = sqlsrv_query($connect, $Query_ScanLabel, $params_today);
    $ScanLabel_Rows = [];
    if ($Result_ScanLabel) {
        while ($row = sqlsrv_fetch_array($Result_ScanLabel, SQLSRV_FETCH_ASSOC)) {
            $ScanLabel_Rows[] = $row;
        }
    }
    $Count_ScanLabel = count($ScanLabel_Rows);
    $Data_ScanLabel2 = $Count_ScanLabel > 0 ? $ScanLabel_Rows[0] : null;

    $LOT = 0;
    if ($Data_ScanLabel2) {
        $Change_Cditem = Hyphen($Data_ScanLabel2['CD_ITEM']);
        $Query_LotSize = "SELECT LOTSIZE FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND CD_ITEM=?";
        $params_lot = array($Change_Cditem);
        $Result_LotSize = sqlsrv_query($connect, $Query_LotSize, $params_lot);
        $Data_LotSize = sqlsrv_fetch_array($Result_LotSize);
        if ($Data_LotSize) {
            $LOT = $Data_LotSize['LOTSIZE'];
        }
    }

    //★라벨인쇄
    if ($LOT > 0 && $Count_ScanLabel == $LOT) {
        echo "<script>location.href='label_bundle.php?cd_item=" . urlencode($CD_ITEM) . "&qt_goods=" . urlencode($Count_ScanLabel) . "';</script>";
    } elseif ($bt23 == "on") {
        if ($Count_ScanLabel > 0) {
            echo "<script>location.href='label_bundle.php?cd_item=" . urlencode($Data_ScanLabel2['CD_ITEM']) . "&qt_goods=" . urlencode($Count_ScanLabel) . "';</script>";
        } else {
            echo "<script>alert('스캔한 파일이 없어 박스 라벨을 출력할 수 없습니다!');location.href='label_inspect.php';</script>";
        }
    }
?>