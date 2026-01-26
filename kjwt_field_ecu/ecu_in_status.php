<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.09>
	// Description:	<ecu 입고 리뉴얼 백엔드>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
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
    //탭2 - 입력
    $item2 = isset($_POST["item2"]) ? strtoupper($_POST["item2"]) : '';	 
    $bt21 = $_POST["bt21"] ?? null;  
    $popitem = $_GET["popitem"] ?? null; 

    //탭2 - 삭제
    $item2b = isset($_POST["item2b"]) ? strtoupper($_POST["item2b"]) : '';	 
    $use_function2b = CROP($item2b);
    $cd_item2b = $use_function2b[0];    
    $lot_date2b = $use_function2b[2];
    $lot_num2b = $use_function2b[3];
    $qt_goods2b = $use_function2b[4];
    $cd_item2c = isset($_POST["item2c"]) ? Hyphen(trim(strtoupper($_POST["item2c"]))) : '';	
    $bt2b = $_POST["bt2b"] ?? null;
    
    //탭2 - 비고변경  
    $modi = $_GET["modi"] ?? null;	   
    $bt22 = $_POST["bt22"] ?? null;          

    //탭2 - 수기입력    
    $bt23 = $_POST["bt23"] ?? null;    

    //★탭활성화
    IF($modi=='Y' OR $modi=='P') {
        $tab_sequence=2; 
        include '../TAB.php';   
        
        //수정확인
        $sql_ModifyCheck = "SELECT [LOCK] FROM CONNECT.dbo.USE_CONDITION WHERE KIND='EcuInput'";
        $Result_ModifyCheck = sqlsrv_query($connect, $sql_ModifyCheck);
        $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck, SQLSRV_FETCH_ASSOC);

        if($modi=='Y') {
            IF($Data_ModifyCheck['LOCK']=='N') {
                $s_ip = $_SERVER['REMOTE_ADDR']; //사용자 IP
                    
                //수정독점화
                $sql_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO=?, LAST_DT=? WHERE KIND='EcuInput'";
                sqlsrv_query($connect, $sql_ModifyUpdate, [$s_ip, $DT]);
            }
            ELSE {
                echo "<script>alert(\"다른 사람이 수정중 입니다!\");location.href='ecu_in.php';</script>";
            }
        }
        elseif($modi=='P') {
            $sql_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='EcuInput'";
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
            //중복검사
            $sql_ItemRepeatChk = "SELECT COUNT(*) as count FROM CONNECT.dbo.ECU_INPUT_LOG WHERE LOT_DATE=? AND CD_ITEM=? AND LOT_NUM=?";
            $params_ItemRepeatChk = [$lot_date, $cd_item, $lot_num];
            $Result_ItemRepeatChk = sqlsrv_query($connect, $sql_ItemRepeatChk, $params_ItemRepeatChk);
            $Data_ItemRepeatChk = sqlsrv_fetch_array($Result_ItemRepeatChk, SQLSRV_FETCH_ASSOC);

            if($Data_ItemRepeatChk['count'] == 0) {
                $location = '아이윈'; // Default
                $user_ip = $_SERVER['REMOTE_ADDR'];
                if(in_array($user_ip, ['192.168.3.61', '192.168.3.38'])) {
                    $location = 'ECU창고';
                } elseif(in_array($user_ip, ['192.168.3.62', '192.168.4.185'])) {
                    $location = '자재창고';
                }

                $sql_InputECU = "INSERT INTO CONNECT.dbo.ECU_INPUT_LOG(KIND, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, BARCODE, LOCATION) VALUES(?, ?, ?, ?, ?, ?, ?)";
                $params_InputECU = [$kind, $cd_item, $lot_date, $lot_num, $qt_goods, $item2, $location];
                sqlsrv_query($connect, $sql_InputECU, $params_InputECU);
            }
            else {
                echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = '0'; while(true) { var getpass = prompt('중복되었습니다!\n0를 입력하세요!'); if(pass == getpass) { location.href='ecu_in.php'; break; } } };audio.play();</script>"; 
            }
        } else {
            echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = '0'; while(true) { var getpass = prompt('값이 없습니다!\n0를 입력하세요!'); if(pass == getpass) { location.href='ecu_in.php'; break; } } };audio.play();</script>"; 
        }
    } 
    //비고 수정/저장
    ELSEIF($bt22=="on") {
        $tab_sequence=2; 
        include '../TAB.php';    

        $limit = $_POST["until"] ?? 0;
        $sql_NoteUpdate = "UPDATE CONNECT.dbo.ECU_INPUT_LOG SET NOTE=? WHERE CD_ITEM=? AND LOCATION=? AND DIRECT_YN=? AND SORTING_DATE=?";

        for($a=1; $a<$limit; $a++) {
            $N_CD_ITEM = $_POST['N_CD_ITEM'.$a] ?? null;
            $LOCATION = $_POST['LOCATION'.$a] ?? null;
            $DIRECT_YN = $_POST['DIRECT_YN'.$a] ?? null;
            $NOTE = $_POST['NOTE'.$a] ?? null;

            if($N_CD_ITEM) { // Ensure there is an item to update
                $params_NoteUpdate = [$NOTE, $N_CD_ITEM, $LOCATION, $DIRECT_YN, $Hyphen_today];
                sqlsrv_query($connect, $sql_NoteUpdate, $params_NoteUpdate);
            }
        }   

        //수정 독점화 상태 변경
        $sql_ModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='EcuInput'";
        sqlsrv_query($connect, $sql_ModifyUpdate2);
    } 
    //수기입력
    ELSEIF($bt23=="on") {
        $tab_sequence=2; 
        include '../TAB.php';  
        
        $kind23 = $_POST["kind23"] ?? '';	
        $cd_item23 = Hyphen(strtoupper(trim($_POST["item23"] ?? '')));
        $dt23 = $_POST["dt23"] ?? '';	
        $lot_date23 = str_replace("-","",substr($dt23, 0, 10));  
        $qt_goods23 = $_POST["size23"] ?? 0;
        $note23 = $_POST["note23"] ?? '';
        $b_count = $_POST["pop_out"] ?? 0;  
        
        for($i=1; $i<=$b_count; $i++) {
            //마지막 로트번호 검색
            $sql_LastLotNum = "SELECT TOP 1 LOT_NUM FROM CONNECT.dbo.ECU_INPUT_LOG WHERE LOT_DATE=? AND CD_ITEM=? ORDER BY LOT_NUM DESC";
            $params_LastLotNum = [$lot_date23, $cd_item23];
            $Result_LastLotNum = sqlsrv_query($connect, $sql_LastLotNum, $params_LastLotNum);
            $Data_LastLotNum = sqlsrv_fetch_array($Result_LastLotNum, SQLSRV_FETCH_ASSOC);
            $Count_LastLotNum = $Data_LastLotNum ? 1 : 0;

            //로트번호 생성
            $lot_num23 = LotNumber2($Count_LastLotNum, $Data_LastLotNum['LOT_NUM'] ?? null, 'direct'); 
            $handwrite = "handwrite". $NoHyphen_today . $lot_num23;
        
            //중복검사 - 입고 
            $sql_ItemRepeatChk3 = "SELECT COUNT(*) as count FROM CONNECT.dbo.ECU_INPUT_LOG WHERE LOT_DATE=? AND CD_ITEM=? AND LOT_NUM=?";
            $params_ItemRepeatChk3 = [$lot_date23, $cd_item23, $lot_num23];
            $Result_ItemRepeatChk3 = sqlsrv_query($connect, $sql_ItemRepeatChk3, $params_ItemRepeatChk3);
            $Data_ItemRepeatChk3 = sqlsrv_fetch_array($Result_ItemRepeatChk3, SQLSRV_FETCH_ASSOC);

            if($Data_ItemRepeatChk3['count'] == 0) {    
                $location = '아이윈'; // Default
                $user_ip = $_SERVER['REMOTE_ADDR'];
                if(in_array($user_ip, ['192.168.3.61', '192.168.3.38'])) {
                    $location = 'ECU창고';
                } elseif(in_array($user_ip, ['192.168.3.62', '192.168.4.185'])) {
                    $location = '자재창고';
                }

                if($kind23=='직납') {
                    //중복검사 - 출고
                    $sql_ItemRepeatChk4 = "SELECT COUNT(*) as count FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE LOT_DATE=? AND CD_ITEM=? AND LOT_NUM=?";
                    $params_ItemRepeatChk4 = [$lot_date23, $cd_item23, $lot_num23];
                    $Result_ItemRepeatChk4 = sqlsrv_query($connect, $sql_ItemRepeatChk4, $params_ItemRepeatChk4);
                    $Data_ItemRepeatChk4 = sqlsrv_fetch_array($Result_ItemRepeatChk4, SQLSRV_FETCH_ASSOC);

                    if ($Data_ItemRepeatChk4['count'] == 0) {
                        $sql_InputECU = "INSERT INTO CONNECT.dbo.ECU_INPUT_LOG(KIND, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, BARCODE, NOTE, LOCATION, DIRECT_YN) VALUES('S', ?, ?, ?, ?, ?, ?, ?, 'Y')";
                        sqlsrv_query($connect, $sql_InputECU, [$cd_item23, $lot_date23, $lot_num23, $qt_goods23, $handwrite, $note23, $location]);
    
                        $sql_OutputECU = "INSERT INTO CONNECT.dbo.ECU_OUTPUT_LOG(KIND, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, BARCODE, NOTE, LOCATION, DIRECT_YN) VALUES('S', ?, ?, ?, ?, ?, ?, ?, 'Y')";
                        sqlsrv_query($connect, $sql_OutputECU, [$cd_item23, $lot_date23, $lot_num23, $qt_goods23, $handwrite, $note23, $location]);
                    }
                } else {
                    $sql_InputECU = "INSERT INTO CONNECT.dbo.ECU_INPUT_LOG(KIND, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, BARCODE, NOTE, LOCATION, DIRECT_YN) VALUES('S', ?, ?, ?, ?, ?, ?, ?, 'N')";
                    sqlsrv_query($connect, $sql_InputECU, [$cd_item23, $lot_date23, $lot_num23, $qt_goods23, $handwrite, $note23, $location]);
                }
            } 
        }
    }
    // 삭제  
    ELSEIF($bt2b=="on") {
        $tab_sequence=2; 
        include '../TAB.php'; 

        if($cd_item2b != '') {
            $sql_DeleteRecord = "INSERT INTO CONNECT.dbo.ECU_INPUT_DEL(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS) VALUES(?, ?, ?, ?)";
            sqlsrv_query($connect, $sql_DeleteRecord, [$cd_item2b, $lot_date2b, $lot_num2b, $qt_goods2b]);

            $sql_FinishDelete = "DELETE FROM CONNECT.dbo.ECU_INPUT_LOG WHERE CD_ITEM=? AND LOT_DATE=? AND LOT_NUM=?";
            sqlsrv_query($connect, $sql_FinishDelete, [$cd_item2b, $lot_date2b, $lot_num2b]);
        }
        //수기입력 삭제인 경우
        elseif($cd_item2c != '') {
            $sql_SelectRecord = "SELECT BARCODE FROM CONNECT.dbo.ECU_INPUT_LOG WHERE CD_ITEM=? AND SORTING_DATE=? AND BARCODE LIKE 'handwrite%'";
            $Result_SelectRecord = sqlsrv_query($connect, $sql_SelectRecord, [$cd_item2c, $Hyphen_today]);
            $Data_SelectRecord = sqlsrv_fetch_array($Result_SelectRecord, SQLSRV_FETCH_ASSOC);

            if ($Data_SelectRecord) {
                $sql_DeleteRecord = "INSERT INTO CONNECT.dbo.ECU_INPUT_DEL(CD_ITEM, LOT_DATE, LOT_NUM, NOTE) VALUES(?, ?, '-', ?)";
                sqlsrv_query($connect, $sql_DeleteRecord, [$cd_item2c, $NoHyphen_today, $Data_SelectRecord['BARCODE']]);

                $sql_FinishDelete = "DELETE FROM CONNECT.dbo.ECU_INPUT_LOG WHERE CD_ITEM=? AND SORTING_DATE=? AND BARCODE LIKE 'handwrite%'";
                sqlsrv_query($connect, $sql_FinishDelete, [$cd_item2c, $Hyphen_today]);
            }
        }
    }
    
    //★메뉴 진입 시 실행
    //금일 입고 데이터
    $sql_InputECU = "SELECT CD_ITEM, COUNT(CD_ITEM) AS BOX, SUM(QT_GOODS) AS PCS, LOCATION, DIRECT_YN, NOTE FROM CONNECT.dbo.ECU_INPUT_LOG WHERE SORTING_DATE=? GROUP BY CD_ITEM, LOCATION, DIRECT_YN, NOTE";
    $result = sqlsrv_query($connect21, $sql_InputECU, [$Hyphen_today]);

    // Fetch all results into a PHP array to prevent cursor conflicts in the view file.
    $InputECU_DataArray = [];
    if ($result) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $InputECU_DataArray[] = $row;
        }
    }
        
    //박스수량 및 개별수량
    $sql_InputQuantity = "SELECT COUNT(*) AS BOX, SUM(QT_GOODS) AS PCS FROM CONNECT.dbo.ECU_INPUT_LOG WHERE SORTING_DATE=?";
    $Result_InputQuantity = sqlsrv_query($connect21, $sql_InputQuantity, [$Hyphen_today]);
    $Data_InputQuantity = sqlsrv_fetch_array($Result_InputQuantity, SQLSRV_FETCH_ASSOC);
?>