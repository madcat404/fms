<?php   
    session_start();
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.02.24>
	// Description:	<경비실 키 불출 대장 - 보안 및 호환성 수정>
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php';
    include '../DB/DB2.php';     

    //★탭활성화
    $tab_sequence = 2; 
    include '../TAB.php';  
        
    //★변수모음 (Null 병합 연산자로 안전하게 처리)
    $key21 = $_POST["key21"] ?? null;
    $company21 = $_POST["company21"] ?? null;
    $user21 = $_POST["user21"] ?? null;
    $guard21 = $_POST["guard21"] ?? null;
    $purpose21 = $_POST["purpose21"] ?? null;
    $bt21 = $_POST["bt21"] ?? null;

    $modi = $_GET["modi"] ?? null;
    $bt22 = $_POST["bt22"] ?? null;
    
    $dt3 = $_POST["dt3"] ?? null;
    $s_dt3 = $dt3 ? substr($dt3, 0, 10) : null;
	$e_dt3 = $dt3 ? substr($dt3, 13, 10) : null;
    $bt31 = $_POST["bt31"] ?? null;

    //★버튼 클릭 시 실행
    //입력
    if ($bt21 === "on") {
        $tab_sequence = 2;
        include '../TAB.php';

        // SQL Injection 방지를 위해 파라미터화된 쿼리 사용
        $Query_KeyOut = "INSERT INTO CONNECT.dbo.KEY_INOUT(KEY_NM, COMPANY, NAME, GUARD, PURPOSE) VALUES(?, ?, ?, ?, ?)";
        $params_KeyOut = [$key21, $company21, $user21, $guard21, $purpose21];
        sqlsrv_query($connect, $Query_KeyOut, $params_KeyOut);
    }   
    //수정 (반납 처리)
    else if ($bt22 === "on") {
        $tab_sequence = 2;
        include '../TAB.php';

        $limit = $_POST["until"] ?? 0;

        for ($a = 1; $a < $limit; $a++) {
            $NO_name = 'NO' . $a;
            $CB_name = 'CB' . $a;

            $current_NO = $_POST[$NO_name] ?? null;

            if (isset($_POST[$CB_name]) && $_POST[$CB_name] === 'on' && $current_NO !== null) {
                // SQL Injection 방지를 위해 파라미터화된 쿼리 사용
                $Query_Check = "UPDATE CONNECT.dbo.KEY_INOUT SET IN_TIME = getdate(), IN_CHECK = 'on' WHERE NO = ?";
                sqlsrv_query($connect, $Query_Check, [$current_NO]);
            }
        }

        //수정 독점화 해제
        $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND='Key'";
        sqlsrv_query($connect, $Query_ModifyUpdate);
    }  
    //반납 시 체크 수정 모드 진입
    else if ($modi === 'Y') {
        $tab_sequence = 2;
        include '../TAB.php';

        $Query_ModifyCheck = "SELECT LOCK FROM CONNECT.dbo.USE_CONDITION WHERE KIND='Key'";
        $Result_ModifyCheck = sqlsrv_query($connect, $Query_ModifyCheck);
        $Data_ModifyCheck = sqlsrv_fetch_array($Result_ModifyCheck);

        if ($Data_ModifyCheck && $Data_ModifyCheck['LOCK'] === 'N') {
            $s_ip = $_SERVER['REMOTE_ADDR'];
            $now = date("Y-m-d H:i:s"); // 정의되지 않은 $DT 변수 수정
            
            // 파라미터화된 쿼리 사용
            $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO=?, LAST_DT=? WHERE KIND='Key'";
            sqlsrv_query($connect, $Query_ModifyUpdate, [$s_ip, $now]);
        } else {
            echo "<script>alert('다른 사람이 수정중 입니다!'); location.href='key.php';</script>";
        }
    } 
    //입출문내역 검색
    else if ($bt31 === "on") {
        $tab_sequence = 3;
        include '../TAB.php';

        // SQL Injection 방지를 위해 파라미터화된 쿼리 사용
        $Query_InOutPrint = "SELECT * FROM CONNECT.dbo.KEY_INOUT WHERE SORTING_DATE BETWEEN ? AND ? ORDER BY NO DESC";
        $params_InOutPrint = [$s_dt3, $e_dt3];
        $Result_InOutPrint = sqlsrv_query($connect, $Query_InOutPrint, $params_InOutPrint);
    }  
    
    //★메뉴 진입 시 또는 기본으로 실행되는 쿼리
    //미반납 내역 조회
    $Query_NotIn = "SELECT * FROM CONNECT.dbo.KEY_INOUT WHERE IN_CHECK IS NULL ORDER BY NO DESC";
    $Result_NotIn = sqlsrv_query($connect, $Query_NotIn);

    // 검색 결과 카운트 (sqlsrv_num_rows 대체)
    if ($bt31 === 'on' && isset($Result_InOutPrint)) {
        // 쿼리를 다시 실행하여 카운트 (결과셋을 재사용할 수 없으므로)
        $Query_Count_InOutPrint = "SELECT COUNT(*) as row_count FROM CONNECT.dbo.KEY_INOUT WHERE SORTING_DATE BETWEEN ? AND ?";
        $result = sqlsrv_query($connect, $Query_Count_InOutPrint, $params_InOutPrint);
        $row = sqlsrv_fetch_array($result);
        $Count_InOutPrint = $row['row_count'];
    } else {
        $Count_NotIn_Count_Query = "SELECT COUNT(*) as row_count FROM CONNECT.dbo.KEY_INOUT WHERE IN_CHECK IS NULL";
        $Count_NotIn_Result = sqlsrv_query($connect, $Count_NotIn_Count_Query);
        $Count_NotIn_Row = sqlsrv_fetch_array($Count_NotIn_Result);
        $Count_NotIn = $Count_NotIn_Row['row_count'];
        $Count_InOutPrint = 0;
    }
?>