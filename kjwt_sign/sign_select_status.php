<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.17>
	// Description:	<회람 전산화>	
    // Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
    // =============================================
    
    //★DB연결 및 함수사용
    //esg활동 같이 바깥에서 싸인해야 하는 경우도 있으므로 세션 확인안함
    include '../FUNCTION.php';
    include '../DB/DB2.php'; 


    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include '../TAB.php';    
      

    //★변수모음   
    //탭2
    $request21 = $_POST["request21"] ?? null; 
    $calendar21 = $_POST["calendar21"] ?? null; 
    $link21 = $_POST["link21"] ?? null; 
    $bt21 = $_POST["bt21"] ?? null;  

    $no = $_GET['no'] ?? null;   
    $listno = $_GET['listno'] ?? null;  
    $input = $_GET['input'] ?? null;     
    $input2 = $_GET['input2'] ?? null;     


    //★버튼 클릭 시 실행  
    IF($bt21=="on") { 
        $tab_sequence=2; 
        include '../TAB.php'; 

        // 보안: 링크 URL 유효성 검사
        if ($link21 && !filter_var($link21, FILTER_VALIDATE_URL)) {
            echo "<script>alert(\"유효하지 않은 자료 링크(URL)입니다.\");history.back();</script>";
            exit;
        }

        $Query_SignCreate = "INSERT INTO CONNECT.dbo.SIGN2(TITLE, DT, LINK) VALUES (?, ?, ?)";
        $params_SignCreate = [$request21, $calendar21, $link21];
        $Result_SignCreate = sqlsrv_query($connect, $Query_SignCreate, $params_SignCreate);

        if ($Result_SignCreate) {
            echo "<script>alert(\"입력 되었습니다!\");location.href='sign_select.php';</script>";
        } else {
            error_log("Sign creation failed: " . print_r(sqlsrv_errors(), true));
            echo "<script>alert(\"에러가 발생했습니다. 관리자에게 문의하세요.\");history.back();</script>";
        }
        exit;
    } 
    elseif($input!='') { 
        $input_like = $input . '%';
        $Query_ID = "SELECT NM_KOR FROM NEOE.NEOE.MA_EMP WHERE NO_RES LIKE ? and CD_INCOM='001'";
        $params_ID = [$input_like];
        $Result_ID = sqlsrv_query($connect, $Query_ID, $params_ID);
        if ($Result_ID === false) { die("Database query failed: " . print_r(sqlsrv_errors(), true)); }
        
        $employees = [];
        while ($row = sqlsrv_fetch_array($Result_ID, SQLSRV_FETCH_ASSOC)) {
            $employees[] = $row;
        }
        $count = count($employees);

        if ($count === 0) {
            echo "<script>alert(\"일치하는 직원이 없습니다!\");window.location.href='sign_select.php';</script>";
            exit;
        }

        $Query_SIGN2 = "SELECT * from CONNECT.dbo.SIGN2 WHERE NO = ?";
        $params_SIGN2 = [$listno];
        $Result_SIGN2 = sqlsrv_query($connect, $Query_SIGN2, $params_SIGN2);
        if ($Result_SIGN2 === false) { die("Database query failed: " . print_r(sqlsrv_errors(), true)); }
        $Data_SIGN2 = sqlsrv_fetch_array($Result_SIGN2);  

        if ($count === 1) {
            // Only one employee found, sign directly
            $employee_name = $employees[0]['NM_KOR'];

            // 중복 서명 확인
            $Query_CheckSign = "SELECT COUNT(*) as count FROM CONNECT.dbo.SIGN_LOG WHERE TITLE = ? AND NAME = ?";
            $params_CheckSign = [$Data_SIGN2['TITLE'], $employee_name];
            $Result_CheckSign = sqlsrv_query($connect, $Query_CheckSign, $params_CheckSign);
            if ($Result_CheckSign === false) { die("Database query failed: " . print_r(sqlsrv_errors(), true)); }
            $Data_CheckSign = sqlsrv_fetch_array($Result_CheckSign);

            if ($Data_CheckSign['count'] > 0) {
                echo "<script>alert('이미 서명을 했습니다.');window.location.href='sign_select.php';</script>";
                exit;
            }

            $Query_InsertSign = "INSERT INTO CONNECT.dbo.SIGN_LOG(TITLE, NAME) VALUES(?, ?)";
            $params_InsertSign = [$Data_SIGN2['TITLE'], $employee_name];
            $Result_InsertSign = sqlsrv_query($connect, $Query_InsertSign, $params_InsertSign);
            if ($Result_InsertSign === false) { die("Database query failed: " . print_r(sqlsrv_errors(), true)); }

            if($employee_name == '권성근' and strpos($Data_SIGN2['TITLE'], "정기안전보건교육") !== false) { 
                // Auto-sign logic
                $names_to_sign = ['김창복', '조병호', '신규진', '배세현'];
                $Query_AutoInsert = "INSERT INTO CONNECT.dbo.SIGN_LOG(TITLE, NAME) VALUES(?, ?)";
                foreach ($names_to_sign as $name) {
                    $params_AutoInsert = [$Data_SIGN2['TITLE'], $name];
                    sqlsrv_query($connect, $Query_AutoInsert, $params_AutoInsert); // 에러 처리 추가 필요
                }
            }

            $link = $Data_SIGN2['LINK'] ?? '';
            if (filter_var($link, FILTER_VALIDATE_URL) && (strpos($link, 'http://') === 0 || strpos($link, 'https://') === 0)) {
                echo "<script>alert(\"서명 되었습니다!\\n확인을 누르면 자료를 열람할 수 있습니다.\");location.href=". json_encode($link) .";</script>";
            } else {
                echo "<script>alert(\"서명 되었습니다!\");location.href='sign_select.php';</script>";
            }
            exit;
        } else { 
            // Multiple employees found, prepare data for the popup
            $duplicate_names = array_column($employees, 'NM_KOR');
        }
    }
    elseif($input2!='') { 

        $Query_SIGN2 = "SELECT * from CONNECT.dbo.SIGN2 WHERE NO = ?";
        $params_SIGN2 = [$listno];
        $Result_SIGN2 = sqlsrv_query($connect, $Query_SIGN2, $params_SIGN2);
        if ($Result_SIGN2 === false) { die("Database query failed: " . print_r(sqlsrv_errors(), true)); }
        $Data_SIGN2 = sqlsrv_fetch_array($Result_SIGN2);  

        // 중복 서명 확인
        $Query_CheckSign = "SELECT COUNT(*) as count FROM CONNECT.dbo.SIGN_LOG WHERE TITLE = ? AND NAME = ?";
        $params_CheckSign = [$Data_SIGN2['TITLE'], $input2];
        $Result_CheckSign = sqlsrv_query($connect, $Query_CheckSign, $params_CheckSign);
        if ($Result_CheckSign === false) { die("Database query failed: " . print_r(sqlsrv_errors(), true)); }
        $Data_CheckSign = sqlsrv_fetch_array($Result_CheckSign);

        if ($Data_CheckSign['count'] > 0) {
            echo "<script>alert('이미 서명을 했습니다.');window.location.href='sign_select.php';</script>";
            exit;
        }
       
        $Query_InsertSign= "INSERT INTO CONNECT.dbo.SIGN_LOG(TITLE, NAME) VALUES(?, ?)";
        $params_InsertSign = [$Data_SIGN2['TITLE'], $input2];
        $Result_InsertSign = sqlsrv_query($connect, $Query_InsertSign, $params_InsertSign);
        if ($Result_InsertSign === false) { die("Database query failed: " . print_r(sqlsrv_errors(), true)); }

        $link = $Data_SIGN2['LINK'] ?? '';
        if (filter_var($link, FILTER_VALIDATE_URL) && (strpos($link, 'http://') === 0 || strpos($link, 'https://') === 0)) {
            echo "<script>alert(\"서명 되었습니다!\\n확인을 누르면 자료를 열람할 수 있습니다.\");location.href=". json_encode($link) .";</script>";
        } else {
            echo "<script>alert(\"서명 되었습니다!\");location.href='sign_select.php';</script>";
        }
        exit;
    }
    elseif($no!='') {    
        $Query_SignTitle = "SELECT * from CONNECT.dbo.SIGN2 WHERE NO = ?";
        $params_SignTitle = [$no];
        $Result_SignTitle = sqlsrv_query($connect, $Query_SignTitle, $params_SignTitle);
        if ($Result_SignTitle === false) { die("Database query failed: " . print_r(sqlsrv_errors(), true)); }
        $Data_SignTitle = sqlsrv_fetch_array($Result_SignTitle);  
    }


    //★매뉴 진입 시 실행
    $Query_Sign = "SELECT * from CONNECT.dbo.SIGN2 ORDER BY NO DESC";              
    $Result_Sign = sqlsrv_query($connect, $Query_Sign);
    if ($Result_Sign === false) { die("Database query failed: " . print_r(sqlsrv_errors(), true)); }
?>