<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.08>
	// Description:	<bb 입고>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    //★DB연결 및 함수사용
    include_once __DIR__ . '/../session/ip_session.php'; 
    include_once __DIR__ . '/../DB/DB2.php';    
    include_once __DIR__ . '/../DB/DB21.php'; 
    include_once __DIR__ . '/../FUNCTION.php'; // CROP, LotNumber2, 날짜 변수 등을 위해 명시적으로 포함

    //★ PHP 8.x 호환성: GET/POST 변수 null 병합 연산자로 초기화
    $MODAL_ITEM = $_GET["MODAL_ITEM"] ?? '';
    $popup = $_GET["MODAL"] ?? '';

    //★탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php';  

    $modal = ($popup == 'on') ? 'on' : '';
        
    //★변수모음    
    $pda_cd_item21 = strtoupper($_POST["pda_cd_item21"] ?? '');
    $pda_bt21 = $_POST["pda_bt21"] ?? '';
    $item21 = strtoupper($_POST["item21"] ?? '');
    $bt21 = $_POST["bt21"] ?? '';
    $modal_item = $_POST["modal_item"] ?? '';
    $mbt1 = $_POST["mbt1"] ?? '';
    $cd_item22 = trim(HyphenRemove(strtoupper($_POST["cd_item22"] ?? '')));
    $qt_goods22 = $_POST["qt_goods22"] ?? 0;
    $note22 = $_POST["note22"] ?? '';
    $bt22 = $_POST["bt22"] ?? '';
    $item23 = trim(HyphenRemove(strtoupper($_POST["item23"] ?? '')));
    $bt23 = $_POST["bt23"] ?? '';
    $dt3 = $_POST["dt3"] ?? '';
    $s_dt3 = substr($dt3, 0, 10);
	$e_dt3 = substr($dt3, 13, 10);
    $bt31 = $_POST["bt31"] ?? '';    

    //★버튼 클릭 시 실행  
    //pda 입고
    if ($pda_bt21 === "on") {
        $use_function2 = CROP($pda_cd_item21);
        $cd_item21 = HyphenRemove($use_function2[0] ?? '');
        $lot_date21 = $use_function2[2] ?? '';
        $lot_num21 = $use_function2[3] ?? '';
        $qt_goods21 = $use_function2[4] ?? 0;
        $kind21 = $use_function2[5] ?? '';

        if ($kind21 !== 'V') {
            echo "<script>alert('부품식별표 바코드가 아닙니다!'); location.href='bb_in_pda.php';</script>"; 
        } else {
            //중복확인
            $Query_Repeat = "SELECT CD_ITEM FROM CONNECT.dbo.BB_INPUT_LOG WHERE CD_ITEM = ? AND LOT_DATE = ? AND LOT_NUM = ?";
            $params_Repeat = [$cd_item21, $lot_date21, $lot_num21];
            $Result_Repeat = sqlsrv_query($connect, $Query_Repeat, $params_Repeat);
            if ($Result_Repeat && sqlsrv_has_rows($Result_Repeat)) {
                echo "<script>alert('이미 입고 처리된 바코드입니다.'); location.href='bb_in_pda.php';</script>"; 
            } else {
                //데이터 삽입
                $Query_InsertBB = "INSERT INTO CONNECT.dbo.BB_INPUT_LOG(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, BARCODE) VALUES(?, ?, ?, ?, ?)";
                $params_InsertBB = [$cd_item21, $lot_date21, $lot_num21, $qt_goods21, $pda_cd_item21];
                $stmt_InsertBB = sqlsrv_query($connect, $Query_InsertBB, $params_InsertBB);
                if ($stmt_InsertBB) {
                    header('Location: bb_in_pda.php'); // 성공 시 새로고침
                } else {
                    echo "<script>alert('데이터베이스 저장에 실패했습니다.');</script>";
                }
            }
        }
        exit();
    }  
    //입고   
    elseif ($bt21 === "on") {
        $tab_sequence = 2; 
        include __DIR__ . '/../TAB.php'; 

        $use_function2 = CROP($item21);
        $cd_item21 = HyphenRemove($use_function2[0] ?? '');
        $lot_date21 = $use_function2[2] ?? '';
        $lot_num21 = $use_function2[3] ?? '';
        $qt_goods21 = $use_function2[4] ?? 0;
        $kind21 = $use_function2[5] ?? '';

        if ($kind21 !== 'V') {
            echo "<script>alert('부품식별표 바코드가 아닙니다!'); location.href='bb_in.php';</script>"; 
        } else {
            //중복확인
            $Query_Repeat = "SELECT CD_ITEM FROM CONNECT.dbo.BB_INPUT_LOG WHERE CD_ITEM = ? AND LOT_DATE = ? AND LOT_NUM = ?";
            $params_Repeat = [$cd_item21, $lot_date21, $lot_num21];
            $Result_Repeat = sqlsrv_query($connect, $Query_Repeat, $params_Repeat);
            if ($Result_Repeat && sqlsrv_has_rows($Result_Repeat)) {
                echo "<script>alert('이미 입고 처리된 바코드입니다.'); location.href='bb_in.php';</script>"; 
            } else {
                //데이터 삽입
                $Query_InsertBB = "INSERT INTO CONNECT.dbo.BB_INPUT_LOG(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, BARCODE) VALUES(?, ?, ?, ?, ?)";
                $params_InsertBB = [$cd_item21, $lot_date21, $lot_num21, $qt_goods21, $item21];
                $stmt_InsertBB = sqlsrv_query($connect, $Query_InsertBB, $params_InsertBB);
                if ($stmt_InsertBB) {
                    header('Location: bb_in.php'); // 성공 시 새로고침
                } else {
                    echo "<script>alert('데이터베이스 저장에 실패했습니다.');</script>";
                }
            }
        }
        exit();
    } 
    //수기입력
    elseif ($bt22 === "on") {
        $tab_sequence = 2; 
        include __DIR__ . '/../TAB.php'; 

        $check = strtoupper(substr($cd_item22, 0, 1));

        if ($check === "A") {
            echo "<script>alert('내부품번을 사용하셨군요! 자동차품번을 선택해주세요!');location.href='bb_in.php';</script>";
        } else {
            //로트넘버 생성
            $Query_LastLotNum = "SELECT TOP 1 LOT_NUM from CONNECT.dbo.BB_INPUT_LOG where CD_ITEM = ? and sorting_date = ? order by LOT_NUM desc";
            $params_LastLotNum = [$cd_item22, $Hyphen_today];
            $Result_LastLotNum = sqlsrv_query($connect, $Query_LastLotNum, $params_LastLotNum);
            $Data_LastLotNum = $Result_LastLotNum ? sqlsrv_fetch_array($Result_LastLotNum) : null;
            $Count_LastLotNum = $Data_LastLotNum ? 1 : 0;
            
            $lot_num22 = LotNumber2($Count_LastLotNum, $Data_LastLotNum['LOT_NUM'] ?? null, 'direct');
            $handwrite = "handwrite" . $NoHyphen_today . ($num21b1 ?? '');

            //데이터 삽입
            $note22_safe = htmlspecialchars($note22, ENT_QUOTES, 'UTF-8');
            $Query_InsertBB = "INSERT INTO CONNECT.dbo.BB_INPUT_LOG(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, NOTE, BARCODE) VALUES(?, ?, ?, ?, ?, ?)";
            $params_InsertBB = [$cd_item22, $NoHyphen_today, $lot_num22, $qt_goods22, $note22_safe, $handwrite];
            $stmt_InsertBB = sqlsrv_query($connect, $Query_InsertBB, $params_InsertBB);
            if ($stmt_InsertBB) {
                header('Location: bb_in.php');
            } else {
                echo "<script>alert('데이터베이스 저장에 실패했습니다.');</script>";
            }
        }
        exit();
    }  
    // 삭제  
    elseif ($bt23 === "on") {
        $tab_sequence = 2; 
        include __DIR__ . '/../TAB.php';         

        // 데이터 삭제
        $Query_BBDelete = "DELETE FROM CONNECT.dbo.BB_INPUT_LOG WHERE CD_ITEM = ? AND SORTING_DATE = ?";
        $params_BBDelete = [$item23, $Hyphen_today];
        $stmt_BBDelete = sqlsrv_query($connect, $Query_BBDelete, $params_BBDelete);
        if ($stmt_BBDelete) {
            header('Location: bb_in.php');
        } else {
            echo "<script>alert('데이터 삭제에 실패했습니다.');</script>";
        }
        exit();
    }
    //입고내역
    elseif ($bt31 === "on") {
        $tab_sequence = 3; 
        include __DIR__ . '/../TAB.php'; 

        //입고내역 조회
        $Query_BBIn = "select * from CONNECT.dbo.BB_INPUT_LOG WHERE SORTING_DATE between ? and ?";
        $params_BBIn = [$s_dt3, $e_dt3];
        $Result_BBIn = sqlsrv_query($connect21, $Query_BBIn, $params_BBIn);
    } 
    elseif ($mbt1 === "on") {
        $modal = "on";

        // 모달 조회
        $q_modal = "select * from NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND NM_ITEM like ?";
        $params_modal = ['%' . $modal_item . '%'];
        $r_modal = sqlsrv_query($connect, $q_modal, $params_modal);
    }
   
    //★메뉴 진입 시 실행 (위에서 버튼 클릭 분기 처리에 걸리지 않은 경우)
    //금일 입고 데이터
    $Query_InputBB = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.BB_INPUT_LOG WHERE SORTING_DATE = ? GROUP BY CD_ITEM";
    $params_InputBB = [$Hyphen_today];
    $Result_InputBB = sqlsrv_query($connect21, $Query_InputBB, $params_InputBB);

    //금일 입고 데이터 집계
    $Query_InputBB2 = "SELECT COUNT(*) AS COU, SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.BB_INPUT_LOG WHERE SORTING_DATE = ?";
    $params_InputBB2 = [$Hyphen_today];
    $Result_InputBB2 = sqlsrv_query($connect21, $Query_InputBB2, $params_InputBB2);
    $Data_InputBB2 = $Result_InputBB2 ? sqlsrv_fetch_array($Result_InputBB2) : null;

    //PDA 카운트
    $Query_PDA = "SELECT * from CONNECT.dbo.BB_INPUT_LOG WHERE SORTING_DATE = ?";
    $params_PDA = [$Hyphen_today];
    $Result_PDA = sqlsrv_query($connect21, $Query_PDA, $params_PDA);
    
?>