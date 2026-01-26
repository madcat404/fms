<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.02.17>
	// Description:	<bb창고 출고>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php'; 
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../FUNCTION.php'; // CROP, ItemChange 및 날짜 변수($Hyphen_today 등)를 위해 명시적으로 포함

    //★메뉴 진입 시 탭활성화
    $tab_sequence = 2; 
    include_once __DIR__ . '/../TAB.php'; 

    //★ 안전한 변수 정의 (PHP 8.x 호환성)
    // GET 파라미터
    $modi = $_GET["modi"] ?? null;
    $modal = $_GET["MODAL"] ?? null;
    $modal_Delivery_ItemCode = $_GET["modal_Delivery_ItemCode"] ?? null;

    // POST 파라미터
    $item2 = $_POST["item2"] ?? null;
    $bt21 = $_POST["bt21"] ?? null;
    $bt22 = $_POST["bt22"] ?? null;
    $bt22a = $_POST["bt22a"] ?? null;
    $mbt1 = $_POST["mbt1"] ?? null;
    $add_qt_goods = $_POST["pop_out3"] ?? 0;
    $modal_ItemCode = $_POST["modal_ItemCode"] ?? null;
    $modal_quantiy = $_POST["modal_quantiy"] ?? 0;
    $dt3 = $_POST["dt3"] ?? null;
    $bt31 = $_POST["bt31"] ?? null;
    $bt32 = $_POST["bt32"] ?? null;
    $limit2 = $_POST["until"] ?? 0;

    // 파생 변수
    $use_function2 = $item2 ? CROP($item2) : [null];
    $CD_ITEM2 = $item2 ? ItemChange(Hyphen($use_function2[0]), 'AF') : null;
    $qt_goods = (int)$add_qt_goods + (int)$modal_quantiy;
    $s_dt3 = $dt3 ? substr($dt3, 0, 10) : null;
	$e_dt3 = $dt3 ? substr($dt3, 13, 10) : null;

    // 수정 모드 진입 처리
    if ($modi === 'Y') { 
        $tab_sequence = 2; 
        include __DIR__ . '/../TAB.php';   
        
        $Query_ModifyCheck = "SELECT [LOCK] FROM CONNECT.dbo.USE_CONDITION WHERE KIND = ?";
        $params_ModifyCheck = ['BBOut'];
        $Result_ModifyCheck = sqlsrv_query($connect, $Query_ModifyCheck, $params_ModifyCheck);
        $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck);  

        if ($Data_ModifyCheck && $Data_ModifyCheck['LOCK'] === 'N') {
            session_start();
            $s_ip = $_SERVER['REMOTE_ADDR']; //사용자 IP
            $DT = date("Y-m-d H:i:s");
            
            $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK = 'Y', WHO = ?, LAST_DT = ? WHERE KIND = ?";
            $params_ModifyUpdate = [$s_ip, $DT, 'BBOut'];
            sqlsrv_query($connect, $Query_ModifyUpdate, $params_ModifyUpdate);
        } else {
            echo "<script>alert('다른 사람이 수정중 입니다!');location.href='bb_out.php';</script>";
            exit();
        }
    }   

    //★팝업창 활성화 시 실행    
    if ($modal === 'on') {
        //입력된 수량 불러오기
        $Query_Quantity = "SELECT * FROM CONNECT.dbo.BB_OUTPUT_LOG WHERE SORTING_DATE = ? AND CD_ITEM = ?";
        $params_Quantity = [$Hyphen_today, $modal_Delivery_ItemCode];
        $Result_Quantity = sqlsrv_query($connect, $Query_Quantity, $params_Quantity);
        $Data_Quantity = sqlsrv_fetch_array($Result_Quantity); 
    } else {  
        $modal = '';
    }  
   
    //★버튼 클릭 시 실행
    if ($bt21 === "on") {
        $tab_sequence = 2; 
        include __DIR__ . '/../TAB.php';

        //품번 중복검사
        $Query_ItemRepeatChk = "SELECT CD_ITEM FROM CONNECT.dbo.BB_OUTPUT_LOG WHERE SORTING_DATE = ? AND CD_ITEM = ?";
        $params_ItemRepeatChk = [$Hyphen_today, $CD_ITEM2];
        $Result_ItemRepeatChk = sqlsrv_query($connect, $Query_ItemRepeatChk, $params_ItemRepeatChk);
        
        if ($Result_ItemRepeatChk && sqlsrv_has_rows($Result_ItemRepeatChk)) {   
            // XSS 방지를 위해 urlencode 적용
            echo "<script>location.href='bb_out.php?MODAL=on&modal_Delivery_ItemCode=" . urlencode($CD_ITEM2) . "';</script>";
        } else {
            echo "<script>alert('출고요청된 품번이 아닙니다!');location.href='bb_out.php';</script>";
        }
        exit();
    }
    elseif ($bt22 === "on") {
        $tab_sequence = 2; 
        include __DIR__ . '/../TAB.php'; 

        for ($a = 1; $a < $limit2; $a++) {
            $order_no = $_POST['ORDER_NO' . $a] ?? null;
            $cd_item = $_POST['CD_ITEM' . $a] ?? null;
            $pop_out2 = $_POST['pop_out2' . $a] ?? null;
            $note = $_POST['NOTE' . $a] ?? null;

            if (($note !== null && $note !== '') || ($pop_out2 !== null && $pop_out2 !== '')) {
                $Query_NoteUpdate = "UPDATE CONNECT.dbo.BB_OUTPUT_LOG SET NOTE = ?, COMPLETE = ? WHERE ORDER_NO = ? AND CD_ITEM = ?";
                $params_NoteUpdate = [$note, $pop_out2, $order_no, $cd_item];
                sqlsrv_query($connect, $Query_NoteUpdate, $params_NoteUpdate);
            }
        } 

        //수정 독점화 해제
        $Query_ModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND = ?";
        sqlsrv_query($connect, $Query_ModifyUpdate2, ['BBOut']);

        header("Location: bb_out.php");
        exit();
    }
    elseif ($bt22a === "on") {
        $tab_sequence = 2; 
        include __DIR__ . '/../TAB.php'; 

        for ($a = 1; $a < $limit2; $a++) {
            $order_no = $_POST['ORDER_NO' . $a] ?? null;
            $cd_item = $_POST['CD_ITEM' . $a] ?? null;
            $pop_out2 = $_POST['pop_out2' . $a] ?? null;

            if ($pop_out2 !== null && $pop_out2 !== '') {
                $Query_NoteUpdate = "UPDATE CONNECT.dbo.BB_OUTPUT_LOG SET COMPLETE = ? WHERE ORDER_NO = ? AND CD_ITEM = ?";
                $params_NoteUpdate = [$pop_out2, $order_no, $cd_item];
                sqlsrv_query($connect, $Query_NoteUpdate, $params_NoteUpdate);
            }
        }
        header("Location: bb_out.php");
        exit();
    }
    //수량 변경
    elseif ($mbt1 === "on") {
        $tab_sequence = 2; 
        include __DIR__ . '/../TAB.php';   
        
        $Query_QuantityUpdate = "UPDATE CONNECT.dbo.BB_OUTPUT_LOG SET COMPLETE = ? WHERE CD_ITEM = ? AND SORTING_DATE = ?";
        $params_QuantityUpdate = [$qt_goods, $modal_ItemCode, $Hyphen_today];
        sqlsrv_query($connect, $Query_QuantityUpdate, $params_QuantityUpdate);

        header("Location: bb_out.php");
        exit();
    }
    elseif ($bt31 === "on") {
        $tab_sequence = 3; 
        include __DIR__ . '/../TAB.php'; 

        // 날짜 형식 검증 (Ymd)
        $cs_dt3 = date("Ymd", strtotime($s_dt3));
        $ce_dt3 = date("Ymd", strtotime($e_dt3));

        //출고내역 조회
        $Query_BBInquire = "SELECT * FROM CONNECT.dbo.BB_OUTPUT_LOG WHERE REQUEST_DT BETWEEN ? AND ?";
        $params_BBInquire = [$cs_dt3, $ce_dt3];
        $Result_BBInquire = sqlsrv_query($connect, $Query_BBInquire, $params_BBInquire);
        $Count_BBInquire = $Result_BBInquire ? sqlsrv_num_rows($Result_BBInquire) : 0;
        
        //출고품목개수 (쿼리 효율성 개선)
        $Query_ItemCount = "SELECT COUNT(DISTINCT CD_ITEM) AS ITEM_COUNT FROM CONNECT.dbo.BB_OUTPUT_LOG WHERE SORTING_DATE BETWEEN ? AND ? AND COMPLETE > 0";
        $params_ItemCount = [$s_dt3, $e_dt3];
        $Result_ItemCount = sqlsrv_query($connect, $Query_ItemCount, $params_ItemCount);
        $Data_ItemCount = sqlsrv_fetch_array($Result_ItemCount);
        $Count_ItemCount = $Data_ItemCount['ITEM_COUNT'] ?? 0;

        //출고수량
        $Query_PcsCount = "SELECT SUM(COMPLETE) AS CO FROM CONNECT.dbo.BB_OUTPUT_LOG WHERE SORTING_DATE BETWEEN ? AND ? AND COMPLETE > 0";
        $params_PcsCount = [$s_dt3, $e_dt3];
        $Result_PcsCount = sqlsrv_query($connect, $Query_PcsCount, $params_PcsCount);
        $Data_PcsCount = sqlsrv_fetch_array($Result_PcsCount);
    }     
    //ERP 엑셀 다운로드
    elseif ($bt32 === "on") {
        $tab_sequence = 3; 
        include __DIR__ . '/../TAB.php'; 

        // XSS 방지를 위해 urlencode 적용
        echo "<script>window.open('bb_excel.php?s_dt=" . urlencode($s_dt3) . "&e_dt=" . urlencode($e_dt3) . "');</script>";
        exit();
    }       
    
    //★메뉴 진입 시 실행 (위에서 버튼 클릭 분기 처리에 걸리지 않은 경우)    
    //테이블
    $Query_RequestOutput = "SELECT * FROM CONNECT.dbo.BB_OUTPUT_LOG WHERE REQUEST_DT = ?";
    $params_RequestOutput = [$NoHyphen_today];
    $Result_RequestOutput = sqlsrv_query($connect, $Query_RequestOutput, $params_RequestOutput);
    $Count_RequestOutput = $Result_RequestOutput ? sqlsrv_num_rows($Result_RequestOutput) : 0;   

    //보드
    $Query_BBToTAL = "SELECT SUM(QT_GOODS) AS QT, SUM(COMPLETE) AS CO FROM CONNECT.dbo.BB_OUTPUT_LOG WHERE REQUEST_DT = ?";
    $params_BBToTAL = [$NoHyphen_today];
    $Result_BBToTAL = sqlsrv_query($connect, $Query_BBToTAL, $params_BBToTAL);
    $Data_BBToTAL = sqlsrv_fetch_array($Result_BBToTAL);      
?>