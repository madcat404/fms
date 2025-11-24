<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date:	<20.10.13>
	// Description:	<당직명령 쿼리>
    // Security Update: <2025.10.13> - Applied prepared statements to prevent SQL injection.
    // =============================================
    
    //★DB연결 및 함수사용
    include '../FUNCTION.php'; 
    include '../DB/DB1.php'; 
    include '../DB/DB6.php'; 

    // TODO: 이 키는 보안을 위해 외부 설정 파일로 이동해야 합니다.
    define('NFC_AUTH_KEY', '6218132365');

    $tab = $_GET["tab"] ?? null;
    
    //★메뉴 진입 시 탭활성화
    if($tab=='5') {
        $tab_sequence=5; 
        include '../TAB.php';     
    }
    else {
        $tab_sequence=2; 
        include '../TAB.php'; 
    }  
    

    //★변수모음 
    $modi = $_GET["modi"] ?? null;	
    $bt22 = $_POST["bt22"] ?? null;    
    
    //탭4  
    $dt4 = $_POST["dt4"] ?? null;	
    if ($dt4) {
        $s_dt4 = HyphenRemove(substr($dt4, 0, 10));		
        $e_dt4 = HyphenRemove(substr($dt4, 13, 10));
    }
    $bt41 = $_POST["bt41"] ?? null;   

    //탭5  
    $OUTSIDE1 = $_POST["OUTSIDE1"] ?? null;
    $OUTSIDE2 = $_POST["OUTSIDE2"] ?? null;	
    $OUTSIDE3 = $_POST["OUTSIDE3"] ?? null;	
    $OUTSIDE4 = $_POST["OUTSIDE4"] ?? null;	
    $OUTSIDE5 = $_POST["OUTSIDE5"] ?? null;	
    $FLOOR1_1 = $_POST["FLOOR1_1"] ?? null;	
    $FLOOR1_2 = $_POST["FLOOR1_2"] ?? null;	
    $FLOOR1_3 = $_POST["FLOOR1_3"] ?? null;	
    $FLOOR2_1 = $_POST["FLOOR2_1"] ?? null;	
    $FLOOR2_2 = $_POST["FLOOR2_2"] ?? null;	
    $FLOOR2_3 = $_POST["FLOOR2_3"] ?? null;	
    $FLOOR2_4 = $_POST["FLOOR2_4"] ?? null;	
    $FLOOR3_1 = $_POST["FLOOR3_1"] ?? null;
    $FLOOR3_2 = $_POST["FLOOR3_2"] ?? null;
    $FLOOR3_3 = $_POST["FLOOR3_3"] ?? null;
    $FLOOR3_4 = $_POST["FLOOR3_4"] ?? null;
    $FLOOR3_5 = $_POST["FLOOR3_5"] ?? null;
    $FLOOR4_1 = $_POST["FLOOR4_1"] ?? null;
    $FLOOR4_2 = $_POST["FLOOR4_2"] ?? null;
    $FILED1 = $_POST["FILED1"] ?? null;
    $FILED2 = $_POST["FILED2"] ?? null;
    $FILED3 = $_POST["FILED3"] ?? null;
    $FILED4 = $_POST["FILED4"] ?? null;
    $NFC1 = $_POST["NFC1"] ?? null;
    $NFC2 = $_POST["NFC2"] ?? null;
    $NFC3 = $_POST["NFC3"] ?? null;  
    $note51 = $_POST["note51"] ?? null; 
    $bt51 = $_POST["bt51"] ?? null;   
    $mobile = $_POST["mobile"] ?? null;

    //nfc  
    $nfc = $_GET["nfc"] ?? null;


    //★버튼 클릭 시 실행
    IF($bt22=="on") {
        $tab_sequence=2; 
        include '../TAB.php'; 

        $limit = $_POST["until"];

        for($a=1; $a<$limit; $a++)
        {
            $DT_var_name = 'DT'.$a;
            $NOTE_var_name = 'NOTE'.$a;

            $dt_val = $_POST[$DT_var_name] ?? '';
            $note_val = $_POST[$NOTE_var_name] ?? '';

            if($note_val != '') {
                $stmt = $connect->prepare("UPDATE duty SET duty_change = ? WHERE dt = ?");
                $stmt->bind_param("ss", $note_val, $dt_val);
                $stmt->execute();
            }
            else {
                $stmt = $connect->prepare("UPDATE duty SET duty_change = NULL WHERE dt = ?");
                $stmt->bind_param("s", $dt_val);
                $stmt->execute();
            }
        } 

        //수정 독점화
        $Query_ModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='Duty'";          
        sqlsrv_query($connect6, $Query_ModifyUpdate2);	
    } 
    //당직수정
    elseif($modi=='Y') { 
        $tab_sequence=2; 
        include '../TAB.php'; 

        //수정확인
        $Query_ModifyCheck= "SELECT * from CONNECT.dbo.USE_CONDITION WHERE KIND='Duty'";              
        $Result_ModifyCheck = sqlsrv_query($connect6, $Query_ModifyCheck);		
        $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck);  

        IF($Data_ModifyCheck['LOCK']=='N') {
            session_start();
            // TODO: IP 주소 대신 세션 ID나 사용자 ID를 사용하여 잠금 대상을 식별하는 것이 더 안전하고 신뢰할 수 있습니다.
            // 예: $user_identifier = $_SESSION['user_id'] ?? $_SERVER['REMOTE_ADDR'];
            $s_ip = $_SERVER['REMOTE_ADDR']; //사용자 IP
            $DT = date("Y-m-d H:i:s");
                
            //수정독점화
            $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO=?, LAST_DT=? WHERE KIND='Duty'";          
            $params = [$s_ip, $DT];
            sqlsrv_query($connect6, $Query_ModifyUpdate, $params);	
        }
        ELSE {
            echo "<script>alert('다른 사람이 수정중 입니다!');location.href='duty.php';</script>";
        }
    } 
    ELSEIF($bt41=="on") {
        $tab_sequence=4; 
        include '../TAB.php'; 

        $stmt = $connect->prepare("SELECT * FROM duty where dt between ? and ?");
        $stmt->bind_param("ss", $s_dt4, $e_dt4);
        $stmt->execute();
        $Result_DutyInquire = $stmt->get_result();
        if ($Result_DutyInquire) {
            $Count_DutyInquire = $Result_DutyInquire->num_rows;		
        }
    } 
    ELSEIF($nfc=="on") {
        $area = $_GET["area"];	
        $key = $_GET["key"];    //copy 방지	

        if($key === NFC_AUTH_KEY) {
            //오늘 날짜의 데이터가 있는지 확인
            $Query_TodayData = "SELECT * from CONNECT.dbo.DUTY WHERE SORTING_DATE=?";             
            $Result_TodayData = sqlsrv_query($connect6, $Query_TodayData, [$Hyphen_today]);		
            $has_today_data = sqlsrv_has_rows($Result_TodayData);  

            //오늘 날짜의 데이터가 있으면 UPDATE
            if($has_today_data) {
                $area_column = 'NFC' . filter_var($area, FILTER_SANITIZE_NUMBER_INT);
                if (in_array($area, ['NFC1', 'NFC2', 'NFC3', 'NFC4', 'NFC5', 'NFC6', 'NFC7'])) {
                    $Query_UpdateData = "UPDATE CONNECT.dbo.DUTY set $area='on', ${area}_TIME=getdate() where SORTING_DATE=?";
                    sqlsrv_query($connect6, $Query_UpdateData, [$Hyphen_today]);
                }
            }
            //오늘 날짜의 데이터가 없으면 INSERT
            else {
                if (in_array($area, ['NFC1', 'NFC2', 'NFC3', 'NFC4', 'NFC5', 'NFC6', 'NFC7'])) {
                    $Query_InsertData = "INSERT INTO CONNECT.dbo.DUTY($area, ${area}_TIME) VALUES('on', getdate())";             
                    sqlsrv_query($connect6, $Query_InsertData);
                }
            }	
        }    
        else {
            echo "<script>alert('키값이 틀렸습니다!');location.href='duty.php?tab=5';</script>";
        }

        echo "<script>alert('nfc 태그 기록 완료!');location.href='duty.php?tab=5';</script>";
    } 
    ELSEIF($bt51=="on") {
        $tab_sequence=5; 
        include '../TAB.php'; 

        if($mobile=='on' and $FLOOR1_1=='on') {
            $FLOOR1_2 = 'on';
            $FLOOR1_3 = 'on';
        }
        if($mobile=='on' and $FLOOR2_1=='on') {
            $FLOOR2_2 = 'on';
            $FLOOR2_3 = 'on';
            $FLOOR2_4 = 'on';
        }
        if($mobile=='on' and $FLOOR3_1=='on') {
            $FLOOR3_2 = 'on';
            $FLOOR3_3 = 'on';
            $FLOOR3_4 = 'on';
            $FLOOR3_5 = 'on';
        }
        if($mobile=='on' and $FLOOR4_1=='on') {
            $FLOOR4_2 = 'on';
        }
        if($mobile=='on' and $FILED1=='on') {
            $FILED2 = 'on';
            $FILED3 = 'on';
            $FILED4 = 'on';
        }
        if($mobile=='on' and $OUTSIDE1=='on') {
            $OUTSIDE2 = 'on';
            $OUTSIDE3 = 'on';
            $OUTSIDE4 = 'on';
            $OUTSIDE5 = 'on';
        }      

        //오늘 날짜의 데이터가 있는지 확인
        $Query_TodayData = "SELECT * from CONNECT.dbo.DUTY WHERE SORTING_DATE=?";             
        $Result_TodayData = sqlsrv_query($connect6, $Query_TodayData, [$Hyphen_today]);		
        $has_today_data = sqlsrv_has_rows($Result_TodayData);  

        $params = [
            $OUTSIDE1, $OUTSIDE2, $OUTSIDE3, $OUTSIDE4, $OUTSIDE5,
            $FLOOR1_1, $FLOOR1_2, $FLOOR1_3, $FLOOR2_1, $FLOOR2_2,
            $FLOOR2_3, $FLOOR2_4, $FLOOR3_1, $FLOOR3_2, $FLOOR3_3,
            $FLOOR3_4, $FLOOR3_5, $FLOOR4_1, $FLOOR4_2, $FILED1,
            $FILED2, $FILED3, $FILED4, $note51
        ];

        //오늘 날짜의 데이터가 있으면 UPDATE
        if($has_today_data) { 
            $sql = "UPDATE CONNECT.dbo.DUTY 
                    SET OUTSIDE1=?, OUTSIDE2=?, OUTSIDE3=?, OUTSIDE4=?, OUTSIDE5=?,
                        FLOOR1_1=?, FLOOR1_2=?, FLOOR1_3=?, FLOOR2_1=?, FLOOR2_2=?,
                        FLOOR2_3=?, FLOOR2_4=?, FLOOR3_1=?, FLOOR3_2=?, FLOOR3_3=?,
                        FLOOR3_4=?, FLOOR3_5=?, FLOOR4_1=?, FLOOR4_2=?, FILED1=?,
                        FILED2=?, FILED3=?, FILED4=?, NOTE=?
                    WHERE SORTING_DATE=?";
            $params[] = $Hyphen_today;
            sqlsrv_query($connect6, $sql, $params);
        }
        //오늘 날짜의 데이터가 없으면 INSERT
        else {            
            $sql = "INSERT INTO CONNECT.dbo.DUTY(
                        OUTSIDE1, OUTSIDE2, OUTSIDE3, OUTSIDE4, OUTSIDE5, 
                        FLOOR1_1, FLOOR1_2, FLOOR1_3, FLOOR2_1, FLOOR2_2, 
                        FLOOR2_3, FLOOR2_4, FLOOR3_1, FLOOR3_2, FLOOR3_3, 
                        FLOOR3_4, FLOOR3_5, FLOOR4_1, FLOOR4_2, FILED1, 
                        FILED2, FILED3, FILED4, NOTE
                    ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            sqlsrv_query($connect6, $sql, $params);
        }        
    } 

    //★메뉴 진입 시 실행
    $stmt = $connect->prepare("SELECT * from duty where dt >= ?");
    $stmt->bind_param("s", $NoHyphen_today);
    $stmt->execute();
    $select_duty_result = $stmt->get_result();
    $num_result = $select_duty_result->num_rows; 

    //당직 대상자 조회
    $Query_DutyTarget= "SELECT * FROM user_info WHERE DUTY_YN = 'Y'";
    $Result_DutyTarget = $connect->query($Query_DutyTarget);  
    $Count_DutyTarget = $Result_DutyTarget->num_rows;

    //오늘 당직
    $stmt = $connect->prepare("SELECT * FROM duty WHERE dt = ?");
    $stmt->bind_param("s", $NoHyphen_today);
    $stmt->execute();
    $Result_DutyToday = $stmt->get_result();
    $Data_DutyToday =  $Result_DutyToday->fetch_array(); 

    //오늘 당직일지
    $Query_TodayCheckList = "SELECT * from CONNECT.dbo.DUTY WHERE SORTING_DATE = ?";             
    $Result_TodayCheckList = sqlsrv_query($connect6, $Query_TodayCheckList, [$Hyphen_today]);		
    $Data_TodayCheckList = sqlsrv_fetch_array($Result_TodayCheckList); 
?>