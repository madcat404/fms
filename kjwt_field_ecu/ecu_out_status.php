<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com> 	
	// Create date: <21.11.09>
	// Description:	<ecu 출고 리뉴얼 백엔드>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Data Integrity
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../DB/DB21.php'; 
    include_once __DIR__ . '/../FUNCTION.php'; 
    
    session_start();

    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';  
    
    //★변수모음    
    $item2 = isset($_POST["item2"]) ? strtoupper($_POST["item2"]) : '';		
    $bt21 = $_POST["bt21"] ?? null;  
    $popitem = $_GET["popitem"] ?? null; 
    
    $item2b = isset($_POST["item2b"]) ? strtoupper($_POST["item2b"]) : '';	 
    $use_function2b = CROP($item2b);
    $cd_item2b = $use_function2b[0];
    $lot_date2b = $use_function2b[2];
    $lot_num2b = $use_function2b[3];
    $qt_goods2b = $use_function2b[4];
    $cd_item2c = isset($_POST["item2c"]) ? Hyphen(trim(strtoupper($_POST["item2c"]))) : '';	
    $bt2b = $_POST["bt2b"] ?? null;

    $modi = $_GET["modi"] ?? null;	
    $bt22 = $_POST["bt22"] ?? null;        

    $bt23 = $_POST["bt23"] ?? null;    
        
    //★탭활성화
    IF($modi=='Y' OR $modi=='P') {
        $tab_sequence=2; 
        include '../TAB.php';   
        
        $sql_ModifyCheck = "SELECT [LOCK] FROM CONNECT.dbo.USE_CONDITION WHERE KIND='EcuOutput'";
        $Result_ModifyCheck = sqlsrv_query($connect, $sql_ModifyCheck);
        $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck, SQLSRV_FETCH_ASSOC);

        if($modi=='Y') {
            IF($Data_ModifyCheck['LOCK']=='N') {
                $s_ip = $_SERVER['REMOTE_ADDR'];
                $sql_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO=?, LAST_DT=? WHERE KIND='EcuOutput'";
                sqlsrv_query($connect, $sql_ModifyUpdate, [$s_ip, $DT]);
            }
            ELSE {
                echo "<script>alert(\"다른 사람이 수정중 입니다!\");location.href='ecu_out.php';</script>";
            }
        }
        elseif($modi=='P') {
            $sql_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='EcuOutput'";
            sqlsrv_query($connect, $sql_ModifyUpdate);
        }
    }
    
    //★버튼 클릭 시 실행    
    //입력
    IF($bt21=="on" or $popitem!='') {
        $tab_sequence=2; 
        include '../TAB.php';

        if($popitem!='') {
            $cd_item = $popitem;
            $kind = 'S';
            $lot_date = $_GET["lot_date"] ?? ''; 
            $lot_num = $_GET["lot_num"] ?? ''; 
            $qt_goods = $_GET["qt_goods"] ?? ''; 
        }
        else {
            $use_function2 = CROP($item2);
            $kind = $use_function2[5];
            $cd_item = Hyphen($use_function2[0]);
            $lot_date = $use_function2[2];
            $lot_num = $use_function2[3];
            $qt_goods = $use_function2[4];            
        }    
    
        if($kind != '' && $cd_item != '') {
            $sql_ItemRepeatChk = "SELECT COUNT(*) as count FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE LOT_DATE=? AND CD_ITEM=? AND LOT_NUM=?";
            $params_ItemRepeatChk = [$lot_date, $cd_item, $lot_num];
            $result_ItemRepeatChk = sqlsrv_query($connect, $sql_ItemRepeatChk, $params_ItemRepeatChk);
            $data_ItemRepeatChk = sqlsrv_fetch_array($result_ItemRepeatChk, SQLSRV_FETCH_ASSOC);

            if($data_ItemRepeatChk['count'] == 0) {
                $location = 'ETC'; // Default
                $direct_yn = 'N';
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $user_id = $_SESSION['s_id'] ?? '';

                if(in_array($user_ip, ['192.168.3.61', '192.168.3.38'])) {
                    $location = 'ECU창고';
                } elseif(in_array($user_ip, ['192.168.3.62', '192.168.4.185'])) {
                    $location = '자재창고';
                } elseif($user_id == 'seetech') {
                    $location = '아이윈오토';
                    $direct_yn = 'Y';
                }

                $sql_OutputECU = "INSERT INTO CONNECT.dbo.ECU_OUTPUT_LOG(KIND, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, BARCODE, LOCATION, DIRECT_YN) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
                sqlsrv_query($connect, $sql_OutputECU, [$kind, $cd_item, $lot_date, $lot_num, $qt_goods, $item2, $location, $direct_yn]);
            } 
            else {
                echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = '0'; while(true) { var getpass = prompt('중복되었습니다!\n0를 입력하세요!'); if(pass == getpass) { location.href='ecu_out.php'; break; } } };audio.play();</script>"; 
            } 
        } 
        else {
            echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = '0'; while(true) { var getpass = prompt('값이 없습니다!\n0를 입력하세요!'); if(pass == getpass) { location.href='ecu_out.php'; break; } } };audio.play();</script>"; 
        }            
    } 
    //비고 수정/저장
    ELSEIF($bt22=="on") {
        $tab_sequence=2; 
        include '../TAB.php';

        $limit = $_POST["until"] ?? 0;
        $sql_NoteUpdate = "UPDATE CONNECT.dbo.ECU_OUTPUT_LOG SET NOTE=? WHERE CD_ITEM=? AND LOCATION=? AND DIRECT_YN=? AND PALLET_YN=? AND SORTING_DATE=?";

        for($a=1; $a<$limit; $a++) {
            $N_CD_ITEM = $_POST['N_CD_ITEM'.$a] ?? null;
            $LOCATION = $_POST['LOCATION'.$a] ?? null;
            $DIRECT_YN = $_POST['DIRECT_YN'.$a] ?? null;
            $PALLET_YN = $_POST['PALLET_YN'.$a] ?? null;
            $NOTE = $_POST['NOTE'.$a] ?? null;

            if ($N_CD_ITEM) {
                $params_NoteUpdate = [$NOTE, $N_CD_ITEM, $LOCATION, $DIRECT_YN, $PALLET_YN, $Hyphen_today];
                sqlsrv_query($connect, $sql_NoteUpdate, $params_NoteUpdate);
            }
        } 
        
        $sql_ModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='EcuOutput'";
        sqlsrv_query($connect, $sql_ModifyUpdate2);
    } 
    //수기입력
    ELSEIF($bt23=="on") {
        $tab_sequence=2; 
        include '../TAB.php';

        $cd_item23 = Hyphen(strtoupper(trim($_POST["item23"] ?? '')));
        $dt23 = $_POST["dt23"] ?? '';	
        $lot_date23 = str_replace("-","",substr($dt23, 0, 10));  
        $qt_goods23 = $_POST["size23"] ?? 0;
        $note23 = $_POST["note23"] ?? '';
        $b_count = $_POST["pop_out"] ?? 0;  
        
        for($i=1; $i<=$b_count; $i++) {
            $sql_LastLotNum = "SELECT TOP 1 LOT_NUM FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE LOT_DATE=? AND CD_ITEM=? ORDER BY LOT_NUM DESC";
            $result_LastLotNum = sqlsrv_query($connect, $sql_LastLotNum, [$lot_date23, $cd_item23]);
            $data_LastLotNum = sqlsrv_fetch_array($result_LastLotNum, SQLSRV_FETCH_ASSOC);
            $count_LastLotNum = $data_LastLotNum ? 1 : 0;
            
            $lot_num23 = LotNumber2($count_LastLotNum, $data_LastLotNum['LOT_NUM'] ?? null, 'direct'); 
            $handwrite = "handwrite". $NoHyphen_today . $lot_num23;
        
            $sql_ItemRepeatChk = "SELECT COUNT(*) as count FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE LOT_DATE=? AND CD_ITEM=? AND LOT_NUM=?";
            $result_ItemRepeatChk = sqlsrv_query($connect, $sql_ItemRepeatChk, [$lot_date23, $cd_item23, $lot_num23]);
            $data_ItemRepeatChk = sqlsrv_fetch_array($result_ItemRepeatChk, SQLSRV_FETCH_ASSOC);

            if($data_ItemRepeatChk['count'] == 0) {
                $location = 'ETC'; // Default
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $user_id = $_SESSION['s_id'] ?? '';

                if(in_array($user_ip, ['192.168.3.61', '192.168.3.38'])) {
                    $location = 'ECU창고';
                } elseif(in_array($user_ip, ['192.168.3.62', '192.168.4.185'])) {
                    $location = '자재창고';
                } elseif($user_id == 'seetech') {
                    $location = '아이윈오토';
                }

                $sql_OutputECU = "INSERT INTO CONNECT.dbo.ECU_OUTPUT_LOG(KIND, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, BARCODE, NOTE, LOCATION) VALUES('S', ?, ?, ?, ?, ?, ?, ?)";
                sqlsrv_query($connect, $sql_OutputECU, [$cd_item23, $lot_date23, $lot_num23, $qt_goods23, $handwrite, $note23, $location]);
            } 
        }  
    }
    // 삭제  
    ELSEIF($bt2b=="on") {
        $tab_sequence=2; 
        include '../TAB.php'; 

        if($cd_item2b != '') {
            $sql_DeleteRecord = "INSERT INTO CONNECT.dbo.ECU_OUTPUT_DEL(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS) VALUES(?, ?, ?, ?)";
            sqlsrv_query($connect, $sql_DeleteRecord, [$cd_item2b, $lot_date2b, $lot_num2b, $qt_goods2b]);

            $sql_FinishDelete = "DELETE FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE CD_ITEM=? AND LOT_DATE=? AND LOT_NUM=?";
            sqlsrv_query($connect, $sql_FinishDelete, [$cd_item2b, $lot_date2b, $lot_num2b]);
        }
        elseif($cd_item2c != '') {
            $sql_SelectRecord = "SELECT BARCODE FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE CD_ITEM=? AND SORTING_DATE=? AND BARCODE LIKE 'handwrite%' ";
            $result_SelectRecord = sqlsrv_query($connect, $sql_SelectRecord, [$cd_item2c, $Hyphen_today]);
            $data_SelectRecord = sqlsrv_fetch_array($result_SelectRecord, SQLSRV_FETCH_ASSOC);

            if ($data_SelectRecord) {
                $sql_DeleteRecord = "INSERT INTO CONNECT.dbo.ECU_OUTPUT_DEL(CD_ITEM, LOT_DATE, LOT_NUM, NOTE) VALUES(?, ?, '-', ?)";
                sqlsrv_query($connect, $sql_DeleteRecord, [$cd_item2c, $NoHyphen_today, $data_SelectRecord['BARCODE']]);

                $sql_FinishDelete = "DELETE FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE CD_ITEM=? AND SORTING_DATE=? AND BARCODE LIKE 'handwrite%' ";
                sqlsrv_query($connect, $sql_FinishDelete, [$cd_item2c, $Hyphen_today]);
            }
        }
    }
    
    //★메뉴 진입 시 실행
    //금일 출고 데이터
    $sql_OutputECU = "SELECT CD_ITEM, COUNT(CD_ITEM) AS BOX, SUM(QT_GOODS) AS PCS, LOCATION, DIRECT_YN, PALLET_YN, NOTE FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE SORTING_DATE=? AND (KIND='S' OR KIND='J' OR KIND='TA' OR KIND='P') GROUP BY CD_ITEM, LOCATION, DIRECT_YN, PALLET_YN, NOTE";
    $result = sqlsrv_query($connect21, $sql_OutputECU, [$Hyphen_today]);
    $OutputECU_DataArray = [];
    if ($result) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $OutputECU_DataArray[] = $row;
        }
    }
        
    //박스수량 및 개별수량
    $sql_OutputQuantity = "SELECT COUNT(*) AS BOX, SUM(QT_GOODS) AS PCS FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE SORTING_DATE=? AND (KIND='S' OR KIND='J' OR KIND='TA' OR KIND='P')";
    $Result_OutputQuantity = sqlsrv_query($connect21, $sql_OutputQuantity, [$Hyphen_today]);
    $Data_OutputQuantity = sqlsrv_fetch_array($Result_OutputQuantity, SQLSRV_FETCH_ASSOC);  

    //파레트수량
    $sql_OutputPallet = "SELECT PALLET_LOT_NUM FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE SORTING_DATE=? AND PALLET_YN='Y' GROUP BY PALLET_LOT_NUM";
    $result_pallet = sqlsrv_query($connect21, $sql_OutputPallet, [$Hyphen_today]);
    $OutputPallet_DataArray = [];
    if ($result_pallet) {
        while ($row = sqlsrv_fetch_array($result_pallet, SQLSRV_FETCH_ASSOC)) {
            $OutputPallet_DataArray[] = $row;
        }
    }
    $Count_OutputPallet = count($OutputPallet_DataArray);
?>