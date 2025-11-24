<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.08.24>
	// Description:	<finished 입고>	
    // Last Modified: <25.09.25> - Upgraded to PhpSpreadsheet, Refactored for PHP 8.x and Security
    // =============================================

    //★DB연결 및 함수사용
    include_once '../session/ip_session.php'; 
    include_once '../DB/DB2.php';    


    //★탭활성화
    $tab = isset($_GET["tab"]) ? $_GET["tab"] : '';
    if($tab == 3) {
        $tab_sequence=3;
    }
    else {
        $tab_sequence=2; 
    }    
    include_once '../TAB.php';  
        

    //★변수모음      
    //전일
    $closingDay = Yesterday($Hyphen_today);

    //탭2 - 입력  
    $item2 = isset($_POST["item2"]) ? strtoupper($_POST["item2"]) : '';
    $use_function2 = CROP($item2);
    $cd_item2 = isset($use_function2[0]) ? trim(HyphenRemove(strtoupper($use_function2[0]))) : '';
    $lot_date2 = isset($use_function2[2]) ? $use_function2[2] : '';
    $lot_num2 = isset($use_function2[3]) ? $use_function2[3] : '';
    $qt_goods2 = isset($use_function2[4]) ? $use_function2[4] : '';
    $kind2 = isset($use_function2[5]) ? strtoupper($use_function2[5]) : '';
    $bt21 = isset($_POST["bt21"]) ? $_POST["bt21"] : '';

    //탭2 - 수기입력
    $kind22a = isset($_POST["kind22a"]) ? $_POST["kind22a"] : '';
    $kind22 = isset($_POST["kind22"]) ? $_POST["kind22"] : '';
    $cd_item22 = isset($_POST["cd_item22"]) ? trim(HyphenRemove(strtoupper($_POST["cd_item22"]))) : '';
    $qt_goods22 = isset($_POST["qt_goods22"]) ? $_POST["qt_goods22"] : '';
    $note22 = isset($_POST["note22"]) ? $_POST["note22"] : '';
    $bt22 = isset($_POST["bt22"]) ? $_POST["bt22"] : '';

    //탭2 - 삭제
    $item2b = isset($_POST["item2b"]) ? strtoupper($_POST["item2b"]) : '';
    $use_function2b = CROP($item2b);
    $cd_item2b = isset($use_function2b[0]) ? HyphenRemove(strtoupper($use_function2b[0])) : '';
    $lot_date2b = isset($use_function2b[2]) ? $use_function2b[2] : '';
    $lot_num2b = isset($use_function2b[3]) ? $use_function2b[3] : '';
    $qt_goods2b = isset($use_function2b[4]) ? $use_function2b[4] : '';
    $bt2b = isset($_POST["bt2b"]) ? $_POST["bt2b"] : '';
    $cd_item2b2 = isset($_POST["item2b2"]) ? trim(HyphenRemove(strtoupper($_POST["item2b2"]))) : '';

    //탭2 - 수정
    $modi = isset($_GET["modi"]) ? $_GET["modi"] : '';
    $bt22a = isset($_POST["bt22a"]) ? $_POST["bt22a"] : '';

    //탭2 - 조회
    $bt23 = isset($_POST["bt23"]) ? $_POST["bt23"] : '';
    
    //탭3  
    $dt3 = $_POST["dt3"] ?? $_GET["dt3"] ?? '';
    $s_dt3 = substr($dt3, 0, 10);    	
	$e_dt3 = substr($dt3, 13, 10);
    $bt31 = isset($_POST["bt31"]) ? $_POST["bt31"] : '';
    $bt32 = isset($_POST["bt32"]) ? $_POST["bt32"] : '';
    
    //★버튼 클릭 시 실행  
    //수정
    if($modi=='Y') { 
        $tab_sequence=3; 
        include '../TAB.php'; 

        //수정확인
        $Query_ModifyCheck= "SELECT LOCK from CONNECT.dbo.USE_CONDITION WHERE KIND = ?";
        $params_ModifyCheck = ['FinishedIn'];
        $Result_ModifyCheck = sqlsrv_query($connect, $Query_ModifyCheck, $params_ModifyCheck);
        $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck);  

        if($Data_ModifyCheck && $Data_ModifyCheck['LOCK']=='N') {
            session_start();
            $s_ip = $_SERVER['REMOTE_ADDR']; //사용자 IP
            $DT = date("Y-m-d H:i:s");
                
            //수정독점화
            $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO=?, LAST_DT=? WHERE KIND = ?";    
            $params_ModifyUpdate = [$s_ip, $DT, 'FinishedIn'];      
            sqlsrv_query($connect, $Query_ModifyUpdate, $params_ModifyUpdate);	
        }
        ELSE {
            echo "<script>alert(\"다른 사람이 수정중 입니다!\");location.href='finished_in.php?tab=3';</script>";
            exit();
        }
    } 
    //입력
    elseif ($bt21 == "on") { 
        $tab_sequence=2; 
        include '../TAB.php';

        if ($cd_item2 != '' && strlen($cd_item2) >= 7) {
            // 중복확인
            $Query_RepeatCHK = "SELECT 1 FROM CONNECT.dbo.FINISHED_INPUT_LOG WHERE CD_ITEM=? AND LOT_DATE=? AND LOT_NUM=?";
            $params_RepeatCHK = array($cd_item2, $lot_date2, $lot_num2);
            $Result_RepeatCHK = sqlsrv_query($connect, $Query_RepeatCHK, $params_RepeatCHK, $options);

            if ($Result_RepeatCHK && sqlsrv_has_rows($Result_RepeatCHK)) {
                echo "<script>alert('중복되었습니다!');location.href='finished_in.php';</script>";
            } else {
                // 출처 확인
                $Query_Where = "SELECT COUNTRY FROM CONNECT.dbo.PACKING_LOG WHERE CD_ITEM=? AND LOT_DATE=? AND LOT_NUM=? UNION SELECT COUNTRY FROM CONNECT.dbo.PACKING_LOG2 WHERE CD_ITEM=? AND LOT_DATE=? AND LOT_NUM=?";
                $params_Where = array($cd_item2, $lot_date2, $lot_num2, $cd_item2, $lot_date2, $lot_num2);
                $Result_Where = sqlsrv_query($connect, $Query_Where, $params_Where, $options);
                
                $out_of = "BB"; // 기본값
                if ($Result_Where) {
                    $Data_Where = sqlsrv_fetch_array($Result_Where);
                    if ($Data_Where && strtoupper($Data_Where['COUNTRY']) == 'K') {
                        $out_of = "한국";
                    }
                }

                $pieces_yn = ($kind2 == 'R') ? 'Y' : 'N';
                
                if (date("H:i:s") >= '16:30:00' && date("H:i:s") <= '23:59:59') {
                    $Query_InputFinished = "INSERT INTO CONNECT.dbo.FINISHED_INPUT_LOG(AS_YN, OUT_OF, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, SORTING_DATE, PIECES_YN, CLOSING_YN) VALUES(?, ?, ?, ?, ?, ?, ?, ?, 'Y')";
                    $params_InputFinished = array($kind2, $out_of, $cd_item2, $lot_date2, $lot_num2, $qt_goods2, $Hyphen_today, $pieces_yn);
                    sqlsrv_query($connect, $Query_InputFinished, $params_InputFinished, $options);
                } else {
                    $Query_InputFinished = "INSERT INTO CONNECT.dbo.FINISHED_INPUT_LOG(AS_YN, OUT_OF, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, PIECES_YN, CLOSING_YN) VALUES(?, ?, ?, ?, ?, ?, ?, 'N')";
                    $params_InputFinished = array($kind2, $out_of, $cd_item2, $lot_date2, $lot_num2, $qt_goods2, $pieces_yn);
                    sqlsrv_query($connect, $Query_InputFinished, $params_InputFinished, $options);
                }
            }
        }
    }
    // 수기입력
    elseif ($bt22 == "on") { 
        $tab_sequence=2; 
        include '../TAB.php';        

        // 마지막 로트번호 검색
        $Query_LastLotNum = "SELECT TOP 1 LOT_NUM FROM CONNECT.dbo.FINISHED_INPUT_LOG WHERE CD_ITEM=? AND SORTING_DATE=? AND LOT_NUM LIKE 'a%' ORDER BY LOT_NUM DESC";
        $params_LastLotNum = array($cd_item22, $NoHyphen_today);
        $Result_LastLotNum = sqlsrv_query($connect, $Query_LastLotNum, $params_LastLotNum, $options);
        
        $Data_LastLotNum = null;
        if($Result_LastLotNum) {
            $Data_LastLotNum = sqlsrv_fetch_array($Result_LastLotNum);
        }

        $Count_LastLotNum = $Data_LastLotNum ? 1 : 0;
        $lot_num_val = $Data_LastLotNum ? $Data_LastLotNum['LOT_NUM'] : null;

        // 로트번호 생성
        $lot_num22 = LotNumber2($Count_LastLotNum, $lot_num_val, 'direct');     
       
        if (date("H:i:s") >= '16:30:00' && date("H:i:s") <= '23:59:59') {
            $Query_InputFinished = "INSERT INTO CONNECT.dbo.FINISHED_INPUT_LOG(AS_YN, OUT_OF, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, PIECES_YN, CLOSING_YN) VALUES(?, ?, ?, ?, ?, ?, 'N', 'Y')";
            $params_InputFinished = array($kind22a, $kind22, $cd_item22, $NoHyphen_today, $lot_num22, $qt_goods22);
            sqlsrv_query($connect, $Query_InputFinished, $params_InputFinished, $options);
        } else {
            $Query_InputFinished = "INSERT INTO CONNECT.dbo.FINISHED_INPUT_LOG(AS_YN, OUT_OF, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, PIECES_YN) VALUES(?, ?, ?, ?, ?, ?, 'N')";
            $params_InputFinished = array($kind22a, $kind22, $cd_item22, $NoHyphen_today, $lot_num22, $qt_goods22);
            sqlsrv_query($connect, $Query_InputFinished, $params_InputFinished, $options);
        }
    }
    // 삭제
    elseif ($bt2b == "on") { 
        $tab_sequence=2; 
        include '../TAB.php'; 

        if ($cd_item2b != '') {
            $Query_DeleteRecord = "INSERT INTO CONNECT.dbo.FINISHED_INPUT_DEL(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS) VALUES(?, ?, ?, ?)";
            sqlsrv_query($connect, $Query_DeleteRecord, array($cd_item2b, $lot_date2b, $lot_num2b, $qt_goods2b), $options);

            $Query_FinishDelete = "DELETE FROM CONNECT.dbo.FINISHED_INPUT_LOG WHERE CD_ITEM=? AND LOT_DATE=? AND LOT_NUM=?";
            sqlsrv_query($connect, $Query_FinishDelete, array($cd_item2b, $lot_date2b, $lot_num2b), $options);
        }
        // 수기입력 삭제인 경우
        elseif ($cd_item2b2 != '') {
            $Query_SelectRecord = "SELECT LOT_DATE, LOT_NUM, QT_GOODS FROM CONNECT.dbo.FINISHED_INPUT_LOG WHERE CD_ITEM=? AND SORTING_DATE=?";
            $Result_SelectRecord = sqlsrv_query($connect, $Query_SelectRecord, array($cd_item2b2, $Hyphen_today), $options);
            
            if ($Result_SelectRecord) {
                $Data_SelectRecord = sqlsrv_fetch_array($Result_SelectRecord);
                if ($Data_SelectRecord) {
                    $Query_DeleteRecord = "INSERT INTO CONNECT.dbo.FINISHED_INPUT_DEL(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS) VALUES(?, ?, ?, ?)";
                    sqlsrv_query($connect, $Query_DeleteRecord, array($cd_item2b2, $Data_SelectRecord['LOT_DATE'], $Data_SelectRecord['LOT_NUM'], $Data_SelectRecord['QT_GOODS']), $options);

                    $Query_FinishDelete = "DELETE FROM CONNECT.dbo.FINISHED_INPUT_LOG WHERE CD_ITEM=? AND LOT_DATE=? AND LOT_NUM=?";
                    sqlsrv_query($connect, $Query_FinishDelete, array($cd_item2b2, $Data_SelectRecord['LOT_DATE'], $Data_SelectRecord['LOT_NUM']), $options);
                }
            }
        }
    }
    //수정 후 저장
    ELSEIF($bt22a=="on") {
        $tab_sequence=3; 
        include '../TAB.php'; 

        $limit2 = isset($_POST["until2"]) ? (int)$_POST["until2"] : 0;

        for($a=1; $a<$limit2; $a++)
        {
            $status_key = 'CLOSING_STATUS2_' . $a;
            $no_key = 'closing_no2_' . $a;
            $source_table_key = 'source_table_' . $a;

            if (isset($_POST[$status_key], $_POST[$no_key], $_POST[$source_table_key]) && $_POST[$status_key] !== '') {
                $status_val = $_POST[$status_key];
                $no_val = $_POST[$no_key];
                $source_table = $_POST[$source_table_key];

                if (in_array($status_val, ['Y', 'N']) && ctype_digit((string)$no_val)) {
                    $table_name = '';
                    if ($source_table === 'LOG') {
                        $table_name = 'FINISHED_INPUT_LOG';
                    } elseif ($source_table === 'LOG2') {
                        $table_name = 'FINISHED_INPUT_LOG2';
                    }

                    if ($table_name) {
                        $Query_StatusUpdate = "UPDATE CONNECT.dbo." . $table_name . " SET CLOSING_YN=? WHERE NO=?";
                        sqlsrv_query($connect, $Query_StatusUpdate, array($status_val, $no_val), $options);
                    }
                }
            }
        }

        //수정 독점화 해제
        $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='FinishedIn'";          
        sqlsrv_query($connect, $Query_ModifyUpdate, array(), $options);	
    } 
    //입고내역
    if($bt31=="on" or $modi=='Y' or $bt22a == 'on') { 
        $tab_sequence=3; 
        include '../TAB.php'; 

        $Query_LabelPrint = "
            WITH DateFilteredLogs AS (
                SELECT *, 'LOG' AS SOURCE_TABLE FROM CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE BETWEEN ? AND ?
                UNION ALL
                SELECT *, 'LOG2' AS SOURCE_TABLE FROM CONNECT.dbo.FINISHED_INPUT_LOG2 WHERE SORTING_DATE BETWEEN ? AND ?
            ),
            PackingDates AS (
                SELECT CD_ITEM, LOT_DATE, LOT_NUM, MAKE_DATE, ROW_NUMBER() OVER(PARTITION BY CD_ITEM, LOT_DATE, LOT_NUM ORDER BY (SELECT NULL)) as rn
                FROM (
                    SELECT MAKE_DATE, CD_ITEM, LOT_DATE, LOT_NUM FROM CONNECT.dbo.PACKING_LOG
                    UNION ALL
                    SELECT MAKE_DATE, CD_ITEM, LOT_DATE, LOT_NUM FROM CONNECT.dbo.PACKING_LOG2
                ) AS P
            )
            SELECT dfl.*, pd.MAKE_DATE
            FROM DateFilteredLogs dfl
            LEFT JOIN PackingDates pd ON dfl.CD_ITEM = pd.CD_ITEM AND dfl.LOT_DATE = pd.LOT_DATE AND dfl.LOT_NUM = pd.LOT_NUM AND pd.rn = 1
        ";
        
        $Result_LabelPrint = sqlsrv_query($connect, $Query_LabelPrint, array($s_dt3, $e_dt3, $s_dt3, $e_dt3), $options);
        
        $LabelPrint_DataArray = [];
        if ($Result_LabelPrint) {
            while ($row = sqlsrv_fetch_array($Result_LabelPrint, SQLSRV_FETCH_ASSOC)) {
                $LabelPrint_DataArray[] = $row;
            }
        }
        $Count_LabelPrint = count($LabelPrint_DataArray);
    } 
    //ERP 엑셀 다운로드
    ELSEIF($bt32=="on") { 
        // XSS 방지를 위해 urlencode 적용
        echo "<script>window.open('finished_excel.php?s_dt=" . urlencode($s_dt3) . "&e_dt=" . urlencode($e_dt3) . "');</script>";
        exit();
    }

    //★공통으로 실행되어야 하는 쿼리 (수정모드 포함)
    //금일 입고 데이터
    $Query_InputFinished = "SELECT AS_YN, OUT_OF, CD_ITEM, SUM(QT_GOODS) AS QT_GOODS, CLOSING_YN, max(NO) as sort, SORTING_DATE from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? GROUP BY AS_YN, OUT_OF, CD_ITEM, CLOSING_YN, SORTING_DATE order by sort desc";              
    $Result_InputFinished = sqlsrv_query($connect, $Query_InputFinished, array($Hyphen_today), $options);

    //전일 마감 후 이동 데이터
    $Query_InputFinished2 = "SELECT AS_YN, OUT_OF, CD_ITEM, SUM(QT_GOODS) AS QT_GOODS, CLOSING_YN, max(NO) as sort, SORTING_DATE from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? AND CLOSING_YN='Y' GROUP BY AS_YN, OUT_OF, CD_ITEM, CLOSING_YN, SORTING_DATE order by sort desc";              
    $Result_InputFinished2 = sqlsrv_query($connect, $Query_InputFinished2, array($closingDay), $options);
        
    //박스수량 및 개별수량
    $Query_InputQuantity = "SELECT COUNT(*) AS BOX, SUM(QT_GOODS) AS PCS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? AND CLOSING_YN='N'";              
    $Result_InputQuantity = sqlsrv_query($connect, $Query_InputQuantity, array($Hyphen_today), $options);	
    $Data_InputQuantity = $Result_InputQuantity ? sqlsrv_fetch_array($Result_InputQuantity) : null; 

    $Query_InputQuantity2 = "SELECT COUNT(*) AS BOX, SUM(QT_GOODS) AS PCS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? AND CLOSING_YN='Y'";              
    $Result_InputQuantity2 = sqlsrv_query($connect, $Query_InputQuantity2, array($Hyphen_today), $options);	
    $Data_InputQuantity2 = $Result_InputQuantity2 ? sqlsrv_fetch_array($Result_InputQuantity2) : null; 
    
    $Query_InputQuantity3 = "SELECT COUNT(*) AS BOX, SUM(QT_GOODS) AS PCS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? AND CLOSING_YN='Y'";              
    $Result_InputQuantity3 = sqlsrv_query($connect, $Query_InputQuantity3, array($closingDay), $options);	
    $Data_InputQuantity3 = $Result_InputQuantity3 ? sqlsrv_fetch_array($Result_InputQuantity3) : null;     

    //금일 마감 전 이동수량
    $Query_InputQuantity41 = "SELECT SUM(QT_GOODS) AS PCS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? AND CLOSING_YN='N'";              
    $Result_InputQuantity41 = sqlsrv_query($connect, $Query_InputQuantity41, array($Hyphen_today), $options);	
    $Data_InputQuantity41 = $Result_InputQuantity41 ? sqlsrv_fetch_array($Result_InputQuantity41) : null; 

    //전일 마감 후 이동수량
    $Query_InputQuantity42 = "SELECT SUM(QT_GOODS) AS PCS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? AND CLOSING_YN='Y'";              
    $Result_InputQuantity42 = sqlsrv_query($connect, $Query_InputQuantity42, array($closingDay), $options);	
    $Data_InputQuantity42 = $Result_InputQuantity42 ? sqlsrv_fetch_array($Result_InputQuantity42) : null;

    //금일 스캔 박스수량
    $Query_InputQuantity43 = "SELECT COUNT(*) AS BOX from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=?";              
    $Result_InputQuantity43 = sqlsrv_query($connect, $Query_InputQuantity43, array($Hyphen_today), $options);	
    $Data_InputQuantity43 = $Result_InputQuantity43 ? sqlsrv_fetch_array($Result_InputQuantity43) : null; 
?>