<?php   
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.02.12>
	// Description:	<시험실 체크시트>	
    // Last Modified: <Current Date> - Added validation for empty content in record
	// =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../DB/DB3.php'; 
    include_once __DIR__ . '/../FUNCTION.php';  

    // [이력 모달] 설비 이력 조회 AJAX 요청 처리
    if (isset($_POST['ajax_history']) && $_POST['ajax_history'] == 'yes') {
        $eq_num = $_POST['eq_num'] ?? 0;
        
        // 유효성 검사
        if (!is_numeric($eq_num)) { echo "<tr><td colspan='5'>유효하지 않은 설비 번호입니다.</td></tr>"; exit; }

        $Query_History = "SELECT * FROM CONNECT.dbo.TEST_ROOM_EQUIPMENT WHERE EQUIPMENT_NUM = ? ORDER BY RECORD_DATE DESC";
        $params_history = array($eq_num);
        $Result_History = sqlsrv_query($connect, $Query_History, $params_history, $options);

        if ($Result_History === false) {
            echo "<tr><td colspan='5'>데이터 조회 중 오류가 발생했습니다.</td></tr>";
        } else {
            if (sqlsrv_has_rows($Result_History)) {
                while ($row = sqlsrv_fetch_array($Result_History, SQLSRV_FETCH_ASSOC)) {
                     // 시간 제거 (Y-m-d 형식만 출력)
                     $date = ($row['RECORD_DATE'] instanceof DateTime) ? $row['RECORD_DATE']->format('Y-m-d') : substr($row['RECORD_DATE'], 0, 10);
                     // 수리비용 콤마 추가
                     $cost = is_numeric($row['COST']) ? number_format($row['COST']) : $row['COST'];
                     
                     echo "<tr>";
                     echo "<td class='text-center'>" . $row['EQUIPMENT_NUM'] . "</td>";
                     echo "<td>" . $row['NOTE'] . "</td>";
                     echo "<td class='text-right'>" . $cost . "</td>";
                     echo "<td class='text-center'>" . $row['RECORDER'] . "</td>";
                     echo "<td class='text-center'>" . $date . "</td>";
                     echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>기록된 이력이 없습니다.</td></tr>";
            }
        }
        exit; // AJAX 요청 처리 후 종료
    }

    //★탭활성화
    $checker = $_GET['checker'] ?? '';
    $recorder = $_GET['recorder'] ?? '';
    $supervisor2 = $_GET["supervisor"] ?? '';
    $tab = $_GET['tab'] ?? '';

    if ((!empty($checker) || !empty($supervisor2)) && empty($recorder)) {
        $tab_sequence = 3;
    } elseif (!empty($tab)) {
        $tab_sequence = $tab;
    } elseif (!empty($recorder)) {
        $tab_sequence = 5;
    } else {
        $tab_sequence = 2;
    }   
    include '../TAB.php';  

    //★변수모음  
    //탭2 
    $GAS_INSPECT1 = $_POST["GAS_INSPECT1"] ?? null;	  
    $GAS_INSPECT2 = $_POST["GAS_INSPECT2"] ?? null;  
    $note21 = $_POST["note21"] ?? null;  
    $who21 = $_POST["who21"] ?? null;  
    $bt21 = $_POST["bt21"] ?? null;  

    //POPUP
    $equipment = $_GET[ 'equipment'] ?? null;
    $checker_pop = $_GET[ 'checker_pop'] ?? null;   

    //탭3
    $checker31 = $_POST['checker'] ?? null;    
    $bt31 = $_POST["bt31"] ?? null; 
    $supervisor = $_POST["supervisor"] ?? null; 

    //탭4
    $dt4 = $_POST['dt4'] ?? null;
    $s_dt4 = substr($dt4, 0, 10);		
	$e_dt4 = substr($dt4, 13, 10);
    $equipment_name = $_POST["equipment_name"] ?? null; 
    $bt41 = $_POST["bt41"] ?? null; 

    //탭5
    $content51 = $_POST["content51"] ?? null; 
    $cost51 = $_POST["cost51"] ?? null; 
    $recorder51 = $_POST["recorder51"] ?? null;
    $bt51 = $_POST["bt51"] ?? null; 

    //탭6
    $dt6 = $_POST['dt6'] ?? null;
    $s_dt6 = substr($dt6, 0, 10);		
	$e_dt6 = substr($dt6, 13, 10);
    $bt61 = $_POST["bt61"] ?? null; 


    //★버튼 클릭 시 실행  
    //입력 
    IF($bt21=="on") {
        $tab_sequence=2; 
        include '../TAB.php';

        $Query_TodayData = "SELECT * from CONNECT.dbo.TEST_ROOM WHERE SORTING_DATE='$Hyphen_today'";              
        $Result_TodayData = sqlsrv_query($connect, $Query_TodayData, $params, $options);		
        $Count_TodayData = ($Result_TodayData) ? sqlsrv_num_rows($Result_TodayData) : 0;  

        if($Count_TodayData > 0) {
            $Query_UpdateData = "UPDATE CONNECT.dbo.TEST_ROOM set GAS_INSPECT1='$GAS_INSPECT1', GAS_INSPECT2='$GAS_INSPECT2', WHO='$who21', NOTE='$note21' where SORTING_DATE='$Hyphen_today'";              
            sqlsrv_query($connect, $Query_UpdateData, $params, $options);            
        }
        else {                     
            $Query_InsertData = "INSERT INTO CONNECT.dbo.TEST_ROOM(GAS_INSPECT1, GAS_INSPECT2, INSPECT_DT, WHO, NOTE) VALUES('$GAS_INSPECT1', '$GAS_INSPECT2', getdate(), '$who21', '$note21')";              
            sqlsrv_query($connect, $Query_InsertData, $params, $options);   
        }   

        echo "<script>alert('입력되었습니다!');location.href='test_room.php';</script>";
    } 
    //조회
    elseif($bt41=="on") {
        $tab_sequence=4; 
        include '../TAB.php';

        $Query_Select = "SELECT * from CONNECT.dbo.TEST_ROOM WHERE SORTING_DATE BETWEEN '$s_dt4' AND '$e_dt4'";              
        $Result_Select = sqlsrv_query($connect, $Query_Select, $params, $options);	
        $Count_Select = ($Result_Select) ? sqlsrv_num_rows($Result_Select) : 0;  
    }   
    //설비기록
    elseif($bt51=="on") {
        $tab_sequence=5; 
        include '../TAB.php';

        // [추가] 내용 입력 확인 (백엔드 검증)
        if(empty($content51)) {
            echo "<script>alert('내용을 입력해 주세요.');history.back();</script>";
            exit;
        }

        if($equipment!=0) {
            // [수정] 수리비용 콤마 제거 및 변수명 수정 ($cost -> $cost51)
            $cost_val = str_replace(',', '', $cost51);
            if($cost_val == '') $cost_val = 0;

            // [수정] 쿼리에 올바른 변수($cost_val) 사용 및 RECORD_DATE 명시
            $Query_Record = "INSERT INTO CONNECT.dbo.TEST_ROOM_EQUIPMENT(EQUIPMENT_NUM, COST, RECORDER, NOTE, RECORD_DATE) VALUES('$equipment', '$cost_val', '$recorder51', '$content51', getdate())";              
            $Result_Record = sqlsrv_query($connect, $Query_Record, $params, $options);	
            
            echo "<script>alert('입력되었습니다!');location.href='test_room.php?tab=6';</script>";
        }
    } 
    //설비이력
    elseif($bt61=="on") {
        $tab_sequence=6; 
        include '../TAB.php';

        $Query_RecordSelect = "SELECT a.*, b.EQUIPMENT_NAME 
                        FROM CONNECT.dbo.TEST_ROOM_EQUIPMENT a
                        LEFT JOIN (
                            SELECT DISTINCT EQUIPMENT_NUM, EQUIPMENT_NAME 
                            FROM CONNECT.dbo.TEST_ROOM_CHECKLIST
                        ) b ON a.EQUIPMENT_NUM = b.EQUIPMENT_NUM 
                        WHERE a.SORTING_DATE BETWEEN '$s_dt6' AND '$e_dt6'";              
        $Result_RecordSelect = sqlsrv_query($connect, $Query_RecordSelect, $params, $options);	
        $Count_RecordSelect = ($Result_RecordSelect) ? sqlsrv_num_rows($Result_RecordSelect) : 0;  
    } 
    //확인자 입력버튼
    elseif($supervisor=='on') {
        echo "<script>location.href='test_room_pop_supervisor.php?equipment=$equipment&checker=$checker31';</script>";
    }
    //팝업창에 확인자 주민번호 입력
    elseif($supervisor2!='') {
        $tab_sequence=4; 
        include '../TAB.php';
        
        $Query_ID = "SELECT TOP 1 * from NEOE.NEOE.MA_EMP WHERE NO_RES LIKE '$supervisor2%'";              
        $Result_ID = sqlsrv_query($connect, $Query_ID, $params, $options);	
        $Count_ID = ($Result_ID) ? sqlsrv_num_rows($Result_ID) : 0; 
        $Data_ID = ($Result_ID) ? sqlsrv_fetch_array($Result_ID) : null;

        IF($Count_ID>0) {
            $Query_UpdateSupervisor= "UPDATE CONNECT.dbo.TEST_ROOM set equipment_supervisor='$Data_ID[NM_KOR]' where SORTING_DATE='$Hyphen_today'";                
            sqlsrv_query($connect, $Query_UpdateSupervisor, $params, $options);
        }
        else {
            echo '<script>alert("아이윈 직원이 아닙니다!");history.back();</script>';
        }

    }  
    elseif(!empty($checker_pop) && empty($recorder)) {
        $tab_sequence=3; 
        include '../TAB.php';

        $valid_equipments = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,24,25,26,27,28,29,30];
        if (!in_array($equipment, $valid_equipments)) {
            echo "<script>alert('유효하지 않은 장비번호입니다.');history.back();</script>";
            exit;
        }

        $Query_TodayData_pop = "SELECT * from CONNECT.dbo.TEST_ROOM WHERE SORTING_DATE='$Hyphen_today'";              
        $Result_TodayData_pop = sqlsrv_query($connect, $Query_TodayData_pop, $params, $options);		
        $Count_TodayData_pop = ($Result_TodayData_pop) ? sqlsrv_num_rows($Result_TodayData_pop) : 0;  

        $field_name = "equipment_who" . $equipment;

        if($Count_TodayData_pop > 0) {
            $Query_UpdateData_pop = "UPDATE CONNECT.dbo.TEST_ROOM set $field_name='$checker_pop' where SORTING_DATE='$Hyphen_today'";              
            sqlsrv_query($connect, $Query_UpdateData_pop, $params, $options);     
        }
        else {    
            $Query_InsertData_pop = "INSERT INTO CONNECT.dbo.TEST_ROOM($field_name, INSPECT_DT) VALUES('$checker_pop', getdate())";              
            sqlsrv_query($connect, $Query_InsertData_pop, $params, $options);   
        } 
    }  
    elseif($bt31=="on") {
        $tab_sequence=3; 
        include '../TAB.php';

        if(empty($equipment) || empty($checker31)) {
            echo "<script>alert('장비번호와 점검자 정보를 모두 입력해주세요.');history.back();</script>";
            exit;
        }
        
        $equipment_fields_map = [
            1 => 6, 3 => 3, 4 => 3, 5 => 3, 6 => 4, 7 => 4, 8 => 4, 9 => 4, 10 => 4,
            11 => 4, 12 => 5, 13 => 4, 14 => 4, 15 => 4, 16 => 4, 17 => 3, 18 => 3,
            19 => 3, 20 => 3, 21 => 4, 22 => 4, 24 => 3, 25 => 3, 26 => 4, 27 => 4,
            28 => 4, 29 => 3, 30 => 5
        ];
    
        if(!array_key_exists($equipment, $equipment_fields_map)) {
            echo "<script>alert('유효하지 않은 장비번호입니다.');history.back();</script>";
            exit;
        }

        $field_count = $equipment_fields_map[$equipment];
        $fields = [];
        $values = [];
        $update_pairs = [];

        for ($i = 1; $i <= $field_count; $i++) {
            $field_name = "equipment" . $equipment . $i;
            $post_value = $_POST[$field_name] ?? '';
            $fields[] = $field_name;
            $values[] = "'$post_value'";
            $update_pairs[] = "$field_name='$post_value'";
        }

        $Query_TodayData31 = "SELECT * from CONNECT.dbo.TEST_ROOM WHERE SORTING_DATE='$Hyphen_today'";              
        $Result_TodayData31 = sqlsrv_query($connect, $Query_TodayData31, $params, $options);		
        $Count_TodayData31 = ($Result_TodayData31) ? sqlsrv_num_rows($Result_TodayData31) : 0;  
        
        if($Count_TodayData31 > 0) {
            $update_query = "UPDATE CONNECT.dbo.TEST_ROOM SET " . implode(', ', $update_pairs) . " WHERE SORTING_DATE='$Hyphen_today'";
            sqlsrv_query($connect, $update_query, $params, $options);
        }
        else {
            $fields[] = 'INSPECT_DT';
            $values[] = 'getdate()';
            $insert_query = "INSERT INTO CONNECT.dbo.TEST_ROOM(" . implode(', ', $fields) . ") VALUES(" . implode(', ', $values) . ")";
            sqlsrv_query($connect, $insert_query, $params, $options);
        }  
        
        echo "<script>alert('입력되었습니다!');location.href='test_room.php?equipment=$equipment&checker=$checker31';</script>";
    } 

    //★메뉴 진입 시 실행
    //가스검출기1
    $Data_GAS_INSPECT1 = [];
    $Query_GAS_INSPECT1 = "SELECT top 2 * from CONNECT.dbo.TEST_ROOM where GAS_INSPECT1='on' order by NO desc";              
    $Result_GAS_INSPECT1 = sqlsrv_query($connect, $Query_GAS_INSPECT1, $params, $options);		
    if ($Result_GAS_INSPECT1) {
        while ($row = sqlsrv_fetch_array($Result_GAS_INSPECT1, SQLSRV_FETCH_ASSOC)) {
            $Data_GAS_INSPECT1[] = $row;
        }
    }
    
    //가스검출기2
    $Data_GAS_INSPECT2 = [];
    $Query_GAS_INSPECT2 = "SELECT top 2 * from CONNECT.dbo.TEST_ROOM where GAS_INSPECT2='on' order by NO desc";              
    $Result_GAS_INSPECT2 = sqlsrv_query($connect, $Query_GAS_INSPECT2, $params, $options);		
    if ($Result_GAS_INSPECT2) {
        while ($row = sqlsrv_fetch_array($Result_GAS_INSPECT2, SQLSRV_FETCH_ASSOC)) {
            $Data_GAS_INSPECT2[] = $row;
        }
    }

    //오늘 날짜의 데이터 확인
    $Query_TodayCheckList = "SELECT * from CONNECT.dbo.TEST_ROOM WHERE SORTING_DATE='$Hyphen_today'";              
    $Result_TodayCheckList = sqlsrv_query($connect, $Query_TodayCheckList, $params, $options);		
    $Data_TodayCheckList = ($Result_TodayCheckList) ? sqlsrv_fetch_array($Result_TodayCheckList) : null; 
    
    $Data_TodayCheckList2 = [];
    $Query_TodayCheckList2 = "SELECT * from CONNECT.dbo.TEST_ROOM_CHECKLIST WHERE EQUIPMENT_NUM='$equipment'";              
    $Result_TodayCheckList2 = sqlsrv_query($connect, $Query_TodayCheckList2, $params, $options);		
    if ($Result_TodayCheckList2) {
        while ($row = sqlsrv_fetch_array($Result_TodayCheckList2, SQLSRV_FETCH_ASSOC)) {
            $Data_TodayCheckList2[] = $row;
        }
    }

    if(!empty($Data_TodayCheckList) && !empty($Data_TodayCheckList['equipment_supervisor'])) {
        //GW사번 추출
        $Query_EMP = "SELECT * FROM t_co_emp_multi where lang_code='kr' and emp_name='$Data_TodayCheckList[equipment_supervisor]'";
        $Result_EMP = $connect3->query($Query_EMP);
        $Data_EMP = mysqli_fetch_array($Result_EMP); 

        if (!empty($Data_EMP)) {
            //GW sign id 추출
            $Query_SignID = "SELECT * FROM t_co_emp where emp_seq='$Data_EMP[emp_seq]'";
            $Result_SignID = $connect3->query($Query_SignID);
            $Data_SignID = mysqli_fetch_array($Result_SignID); 
            if (!empty($Data_SignID)) {
                $sign_id=$Data_SignID['sign_file_id'];
            }
        }
    }

    // [Tab 7] 설비이력2 (모든 설비의 마지막 이력)
    // ROW_NUMBER()를 사용하여 각 EQUIPMENT_NUM별로 RECORD_DATE 기준 내림차순 정렬 후 가장 최신인(RN=1) 행만 가져옴
    $Query_Tab7 = "
        SELECT A.*, B.EQUIPMENT_NAME 
        FROM (
            SELECT *, ROW_NUMBER() OVER (PARTITION BY EQUIPMENT_NUM ORDER BY RECORD_DATE DESC) as RN
            FROM CONNECT.dbo.TEST_ROOM_EQUIPMENT
        ) A
        LEFT JOIN (
            SELECT DISTINCT EQUIPMENT_NUM, EQUIPMENT_NAME 
            FROM CONNECT.dbo.TEST_ROOM_CHECKLIST
        ) B ON A.EQUIPMENT_NUM = B.EQUIPMENT_NUM 
        WHERE A.RN = 1
        ORDER BY CAST(A.EQUIPMENT_NUM AS INT) ASC
    "; 
    $Result_Tab7 = sqlsrv_query($connect, $Query_Tab7, $params, $options);
?>