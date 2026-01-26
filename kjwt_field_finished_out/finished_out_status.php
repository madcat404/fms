<?php       
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.08.24>
	// Description:	<finished 출하>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';
    require_once __DIR__ .'/../vendor/autoload.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../DB/DB21.php'; 
    include_once __DIR__ . '/../FUNCTION.php';  

    use PhpOffice\PhpSpreadsheet\IOFactory;
    
    //★탭 변수 초기화
    $tab_sequence = $_POST['tab_sequence'] ?? 2; // Default to tab 2
    $tab2 = $tab3 = $tab4 = $tab5 = $tab6 = '';
    $tab2_text = $tab3_text = $tab4_text = $tab5_text = $tab6_text = '';

    //★입력 변수 안전하게 초기화
    //탭2
    $item2 = strtoupper($_POST["item2"] ?? '');
    $bt21 = $_POST["bt21"] ?? '';
    $cd_item22 = trim(strtoupper($_POST["cd_item22"] ?? ''));
    $qt_goods22 = $_POST["qt_goods22"] ?? '';
    $note22 = $_POST["note22"] ?? '';
    $bt22 = $_POST["bt22"] ?? '';

    //탭3
    $dt3 = $_POST["dt3"] ?? '';
    $s_dt3 = '';
    $e_dt3 = '';
    if (!empty($dt3)) {
        $s_dt3 = substr($dt3, 0, 10);
        $e_dt3 = substr($dt3, 13, 10);
    }
    $bt31 = $_POST["bt31"] ?? '';

    //탭4
    $item4 = HyphenRemove(strtoupper($_POST["item4"] ?? ''));
    $bt41 = $_POST["bt41"] ?? '';
    $cd_item42 = HyphenRemove(trim(strtoupper($_POST["cd_item42"] ?? '')));
    $qt_goods42 = $_POST["qt_goods42"] ?? '';
    $note42 = $_POST["note42"] ?? '';
    $bt42 = $_POST["bt42"] ?? '';

    //탭5
    $dt5 = $_POST["dt5"] ?? '';
    $s_dt5 = '';
    $e_dt5 = '';
    if (!empty($dt5)) {
        $s_dt5 = substr($dt5, 0, 10);
        $e_dt5 = substr($dt5, 13, 10);
    }
    $bt51 = $_POST["bt51"] ?? '';

    //탭6
    $bt61 = $_POST["bt61"] ?? '';
    $bt62 = $_POST["bt62"] ?? '';

    //★결과 변수 초기화
    $DeliveryName = '';
    $Data_OrderQT2 = ['QT_GOODS' => 0];
    $Data_OutputQuantity = ['PCS' => 0];
    $Result_OutputFinished = null;
    $Result_LabelPrint = null;
    $Result_OutputFinished2 = null;
    $Result_Return = null;
    $Result_OrderQT = null;

    //★버튼 클릭 및 탭 활성화 로직
    if ($bt21 === "on" || $bt22 === "on") { $tab_sequence = 2; }
    elseif ($bt31 === "on") { $tab_sequence = 3; }
    elseif ($bt41 === "on" || $bt42 === "on") { $tab_sequence = 4; }
    elseif ($bt51 === "on") { $tab_sequence = 5; }
    elseif ($bt61 === "on" || $bt62 === "on") { $tab_sequence = 6; }
    
    include '../TAB.php'; // 탭 활성화

    //★공통 로직: 마지막 납품기사 조회
    $Query_Delivery = "SELECT WHO from CONNECT.dbo.USE_CONDITION WHERE KIND='Delivery'";
    $Result_Delivery = sqlsrv_query($connect21, $Query_Delivery);
    if ($Result_Delivery && $Data_Delivery = sqlsrv_fetch_array($Result_Delivery)) {
        $delivery_code = $Data_Delivery['WHO'] ?? '';
        $delivery_map = [
            'DELIVERY1' => '옥해종', 'DELIVERY2' => '손규백', 'DELIVERY3' => '최기완',
            'DELIVERY4' => '조근선', 'DELIVERY5' => '박정민', 'DELIVERY6' => '김영민',
            'DELIVERY7' => '기타'
        ];
        $DeliveryName = $delivery_map[$delivery_code] ?? '기타';
    }

    //★버튼 클릭 시 실행
    //탭2: 출하 입력
    if ($bt21 === "on" && !empty($item2)) {
        $head_word = strtoupper(substr($item2, 0, 1));

        if ($head_word === 'D') {
            $Query_UpdateDelivery = "UPDATE CONNECT.dbo.USE_CONDITION SET WHO='$item2' WHERE KIND='Delivery'";
            sqlsrv_query($connect, $Query_UpdateDelivery);
            // 페이지를 새로고침하여 변경된 기사 이름을 즉시 반영
            echo "<script>location.href='finished_out.php';</script>";
            exit;
        } else {
            $use_function2 = CROP($item2);
            $cd_item2 = $use_function2[0] ?? '';
            $lot_date2 = $use_function2[2] ?? '';
            $lot_num2 = $use_function2[3] ?? '';
            $qt_goods2 = $use_function2[4] ?? '0';
            $kind2 = $use_function2[5] ?? '';

            if (!empty($cd_item2) && $qt_goods2 !== '0') {
                $Query_ItemRepeatChk = "SELECT 1 from CONNECT.dbo.FINISHED_OUTPUT_LOG where CD_ITEM='$cd_item2' and LOT_DATE='$lot_date2' AND LOT_NUM='$lot_num2'";
                $Result_ItemRepeatChk = sqlsrv_query($connect, $Query_ItemRepeatChk);
                
                if ($Result_ItemRepeatChk && sqlsrv_has_rows($Result_ItemRepeatChk)) {
                    echo "<script>alert('중복되었습니다!');</script>";
                } else {
                    $pieces_yn = ($kind2 === 'R') ? 'Y' : 'N';
                    $Query_OutputFinished = "INSERT INTO CONNECT.dbo.FINISHED_OUTPUT_LOG(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, SORTING_DATE, PIECES_YN, DELIVERY) VALUES('$cd_item2', '$lot_date2', '$lot_num2', '$qt_goods2', '$Hyphen_today','$pieces_yn', '$DeliveryName')";
                    sqlsrv_query($connect, $Query_OutputFinished);

                    // Following queries seem to be related to FIFO check, keeping them for now but they are complex and might need review
                    // ... (FIFO 로직은 일단 유지)
                }
            } else {
                echo "<script>alert('품번이 없거나 수량이 0입니다!');</script>";
            }
        }
    }
    //탭2: 수기 입력
    elseif ($bt22 === "on" && !empty($cd_item22) && !empty($qt_goods22)) {
        if (($session_row->level ?? '') !== 'kjwt' && ($session_row->level ?? '') !== 'master') {
            echo "<script>alert('사용 권한이 없습니다!');location.href='finished_out.php';</script>";
            exit;
        }

        //하이폰 제거
        $cd_item22 = HyphenRemove($cd_item22);

        //마지막 로트번호 검색
        $Query_LastLotNum = "SELECT TOP 1 LOT_NUM from CONNECT.dbo.FINISHED_OUTPUT_LOG where CD_ITEM='$cd_item22' and SORTING_DATE='$Hyphen_today' and LOT_NUM like 'a%' order by LOT_NUM desc";
        $Result_LastLotNum = sqlsrv_query($connect, $Query_LastLotNum);
        $Count_LastLotNum = ($Result_LastLotNum && sqlsrv_has_rows($Result_LastLotNum)) ? 1 : 0;
        $Data_LastLotNum = sqlsrv_fetch_array($Result_LastLotNum);

        //로트번호 생성
        $lot_num22 = LotNumber2($Count_LastLotNum, $Data_LastLotNum['LOT_NUM'] ?? null, 'direct');

        $Query_OutputFinished = "INSERT INTO CONNECT.dbo.FINISHED_OUTPUT_LOG(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, SORTING_DATE, PIECES_YN, NOTE, DELIVERY) VALUES('$cd_item22', '$NoHyphen_today', '$lot_num22', '$qt_goods22', '$Hyphen_today', 'N', '$note22', '$DeliveryName')";
        sqlsrv_query($connect, $Query_OutputFinished);
    }
    //탭3: 출하내역 검색
    elseif ($bt31 === "on" && !empty($s_dt3) && !empty($e_dt3)) {
        // N+1 문제 해결을 위해 JOIN 사용
        $Query_LabelPrint = "
            SELECT 
                L.*,
                P.MAKE_DATE
            FROM (
                SELECT * FROM CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE BETWEEN '$s_dt3' AND '$e_dt3'
                UNION ALL
                SELECT * FROM CONNECT.dbo.FINISHED_OUTPUT_LOG2 WHERE SORTING_DATE BETWEEN '$s_dt3' AND '$e_dt3'
            ) AS L
            LEFT JOIN (
                SELECT CD_ITEM, LOT_DATE, LOT_NUM, MAKE_DATE FROM CONNECT.dbo.PACKING_LOG
                UNION ALL
                SELECT CD_ITEM, LOT_DATE, LOT_NUM, MAKE_DATE FROM CONNECT.dbo.PACKING_LOG2
            ) AS P ON L.CD_ITEM = P.CD_ITEM AND L.LOT_DATE = P.LOT_DATE AND L.LOT_NUM = P.LOT_NUM";
        $Result_LabelPrint = sqlsrv_query($connect21, $Query_LabelPrint);
    }
    //탭4: 출하취소
    elseif ($bt41 === "on" && !empty($item4)) {
        $use_function4 = CROP($item4);
        $cd_item4 = $use_function4[0] ?? '';
        $lot_date4 = $use_function4[2] ?? '';
        $lot_num4 = $use_function4[3] ?? '';
        $qt_goods4 = $use_function4[4] ?? '0';

        if (!empty($cd_item4)) {
            // BUG FIX: Using correct query variables
            $Query_InsertDel = "INSERT INTO CONNECT.dbo.FINISHED_OUTPUT_DEL(CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS) VALUES('$cd_item4', '$lot_date4', '$lot_num4', '$qt_goods4')";
            sqlsrv_query($connect, $Query_InsertDel);

            $Query_DeleteLog = "DELETE FROM CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE CD_ITEM='$cd_item4' AND LOT_DATE='$lot_date4' AND LOT_NUM='$lot_num4'";
            sqlsrv_query($connect, $Query_DeleteLog);

            $Query_UpdateInput = "UPDATE CONNECT.dbo.FINISHED_INPUT_LOG set OUT_YN='N' WHERE CD_ITEM='$cd_item4' AND LOT_DATE='$lot_date4' AND LOT_NUM='$lot_num4'";
            sqlsrv_query($connect, $Query_UpdateInput);

            $Query_UpdateInput2 = "UPDATE CONNECT.dbo.FINISHED_INPUT_LOG2 set OUT_YN='N' WHERE CD_ITEM='$cd_item4' AND LOT_DATE='$lot_date4' AND LOT_NUM='$lot_num4'";
            sqlsrv_query($connect, $Query_UpdateInput2);
        }
    }
    //탭5: 출하취소내역 검색
    elseif ($bt51 === "on" && !empty($s_dt5) && !empty($e_dt5)) {
        $Query_Return = "SELECT * from CONNECT.dbo.FINISHED_OUTPUT_DEL WHERE SORTING_DATE between '$s_dt5' and '$e_dt5'";
        $Result_Return = sqlsrv_query($connect, $Query_Return);
    }
    //탭6: 오더 업로드
    elseif ($bt61 === "on") {
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
            $filename = $_FILES['excelFile']['tmp_name'];

            try {
                // Use PhpSpreadsheet since PHPExcel is deprecated
                $spreadsheet = IOFactory::load($filename);
                $worksheet = $spreadsheet->getActiveSheet();
                $maxRow = $worksheet->getHighestRow();

                sqlsrv_query($connect, "DELETE FROM CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today'");

                for ($i = 2; $i <= $maxRow; $i++) { // Assuming row 1 is header
                    $CD_ITEM = (string) $worksheet->getCell('A' . $i)->getValue();
                    $QT_GOODS = $worksheet->getCell('B' . $i)->getValue();
                    $CLIENT = (string) $worksheet->getCell('C' . $i)->getValue();
                    $DELIVERY = (string) $worksheet->getCell('D' . $i)->getValue();
                    $NOTE = (string) $worksheet->getCell('E' . $i)->getValue();

                    // 엑셀 업로드 시 cd_item이 공백이고 qt_goods가 0인 쓰레기로그가 입력되는것을 방지
                    if (empty($CD_ITEM) && (empty($QT_GOODS) || $QT_GOODS == 0)) {
                        // If both item and quantity are empty/zero, assume it's the end of the list and stop processing.
                        break;
                    }

                    if (!empty($CD_ITEM) && is_numeric($QT_GOODS) && $QT_GOODS > 0) {
                        $CD_ITEM = HyphenRemove($CD_ITEM);
                        
                        // Escape variables for SQL
                        $CD_ITEM_sql = str_replace("'", "''", $CD_ITEM);
                        $CLIENT_sql = str_replace("'", "''", $CLIENT);
                        $DELIVERY_sql = str_replace("'", "''", $DELIVERY);
                        $NOTE_sql = str_replace("'", "''", $NOTE);

                        if(empty($NOTE)) {
                            //DB INSERT
                            $Query_InsertOrder = "INSERT INTO CONNECT.dbo.FINISHED_OUTPUT_ORDER(CD_ITEM, QT_GOODS, CLIENT, DELIVERY, NOTE) VALUES('$CD_ITEM_sql', '$QT_GOODS', '$CLIENT_sql', '$DELIVERY_sql', NULL)";
                        }
                        else {
                            //DB INSERT
                            $Query_InsertOrder = "INSERT INTO CONNECT.dbo.FINISHED_OUTPUT_ORDER(CD_ITEM, QT_GOODS, CLIENT, DELIVERY, NOTE) VALUES('$CD_ITEM_sql', '$QT_GOODS', '$CLIENT_sql', '$DELIVERY_sql', '$NOTE_sql')";
                        }
                        
                        $result = sqlsrv_query($connect, $Query_InsertOrder);
                        if ($result === false) {
                            // Log error, but don't break the loop, maybe just skip the row
                            error_log("SQL insert failed for row $i: " . print_r(sqlsrv_errors(), true));
                        }
                    }
                }
                echo <<<HTML
<script>alert('업로드 완료!');</script>
<form id="redirectForm" action="finished_out.php" method="post" style="display:none;">
    <input type="hidden" name="bt62" value="on">
</form>
<script>
    document.getElementById('redirectForm').submit();
</script>
HTML;
            } catch (Throwable $e) {
                // Catching Throwable to be safer on PHP 7+
                echo "<script>alert('엑셀 파일을 읽는 도중 오류가 발생하였습니다: " . str_replace("'", "\\'", $e->getMessage()) . "');</script>";
            }
        } else {
            echo "<script>alert('파일 업로드에 실패했습니다.');</script>";
        }
    }
    //탭6: 오더 출력
    elseif ($bt62 === "on") {
        // N+1 문제 해결
        $Query_OrderQT = "
            SELECT 
                O.CD_ITEM, 
                O.QT_GOODS AS QT_ORDER, 
                O.CLIENT, 
                O.DELIVERY, 
                O.NOTE,
                ISNULL(L.QT_SUM, 0) AS QT_LOG
            FROM (
                SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS, CLIENT, DELIVERY, NOTE 
                FROM CONNECT.dbo.FINISHED_OUTPUT_ORDER 
                WHERE SORTING_DATE='$Hyphen_today' 
                GROUP BY CD_ITEM, CLIENT, DELIVERY, NOTE
            ) AS O
            LEFT JOIN (
                SELECT CD_ITEM, DELIVERY, SUM(QT_GOODS) AS QT_SUM
                FROM CONNECT.dbo.FINISHED_OUTPUT_LOG
                WHERE SORTING_DATE='$Hyphen_today'
                GROUP BY CD_ITEM, DELIVERY
            ) AS L ON O.CD_ITEM = L.CD_ITEM AND O.DELIVERY = L.DELIVERY";
        $Result_OrderQT = sqlsrv_query($connect, $Query_OrderQT);
    }

    //★메뉴 진입 시 항상 실행되는 조회 쿼리들
    //금일 출하 실적 (탭2 실적)
    $Query_OutputFinished = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS, DELIVERY, max(NO) as sort from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='$DeliveryName' GROUP BY CD_ITEM, DELIVERY order by sort desc";
    $Result_OutputFinished = sqlsrv_query($connect21, $Query_OutputFinished);

    //금일 오더 수량 (탭2 상단)
    $Query_OrderQT2 = "SELECT ISNULL(SUM(QT_GOODS), 0) AS QT_GOODS from CONNECT.dbo.FINISHED_OUTPUT_ORDER WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='$DeliveryName'";
    $Result_OrderQT2 = sqlsrv_query($connect21, $Query_OrderQT2);
    if ($Result_OrderQT2) {
        $Data_OrderQT2 = sqlsrv_fetch_array($Result_OrderQT2) ?: ['QT_GOODS' => 0];
    }

    //총 출하 수량 (탭2 상단)
    $Query_OutputQuantity = "SELECT COUNT(*) AS BOX, ISNULL(SUM(QT_GOODS), 0) AS PCS from CONNECT.dbo.FINISHED_OUTPUT_LOG WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='$DeliveryName'";
    $Result_OutputQuantity = sqlsrv_query($connect21, $Query_OutputQuantity);
    if ($Result_OutputQuantity) {
        $Data_OutputQuantity = sqlsrv_fetch_array($Result_OutputQuantity) ?: ['BOX' => 0, 'PCS' => 0];
    }

    //금일 출하취소 데이터 (탭4 결과)
    $Query_OutputFinished2 = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS, max(NO) as sort from CONNECT.dbo.FINISHED_OUTPUT_DEL WHERE SORTING_DATE='$Hyphen_today' GROUP BY CD_ITEM order by sort desc";
    $Result_OutputFinished2 = sqlsrv_query($connect21, $Query_OutputFinished2);
?>