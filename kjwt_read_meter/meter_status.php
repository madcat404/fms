<?php   
declare(strict_types=1); // PHP 8.x 호환성: 엄격한 타입 모드를 활성화합니다.

    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com> 	
	// Create date: <23.2.13>
	// Description:	<경비실 검침 전산화>
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
    
    //★DB연결 및 함수사용
    include '../session/ip_session.php';
    include '../DB/DB2.php';

    //★ Helper functions for fetching monthly data to reduce code repetition.

    /**
     * Fetches the last meter reading (Water IWIN, Water MALLE, Gas) for a given month and year.
     * @param string $year The year (e.g., '2023').
     * @param int $month The month (1-12).
     * @param mixed $connect The database connection resource.
     * @param array|null $options SQLSRV options.
     * @return array|null The fetched data row or null on failure.
     */
    function get_monthly_meter_data(string $year, int $month, $connect, ?array $options): ?array {
        $month_str = str_pad((string)$month, 2, '0', STR_PAD_LEFT);
        $date_pattern = "$year-$month_str%";
        // 보안: SQL Injection을 방지하기 위해 매개변수화된 쿼리를 사용합니다.
        $query = "SELECT TOP 1 ISNULL(WATER_IWIN, 0) AS WATER_IWIN, ISNULL(WATER_MALLE, 0) AS WATER_MALLE, ISNULL(GAS, 0) AS GAS
                  FROM CONNECT.dbo.READ_METER
                  WHERE SORTING_DATE LIKE ? AND GAS IS NOT NULL
                  ORDER BY SORTING_DATE DESC";
        $params = [$date_pattern];
        $result = sqlsrv_query($connect, $query, $params, $options);
        
        if ($result === false) {
            // 오류 발생 시 null 반환 (오류 로깅을 추가할 수 있습니다)
            return null;
        }
        return sqlsrv_fetch_array($result) ?: null;
    }

    /**
     * Fetches the sum of electricity consumption for a given month and year.
     * @param string $year The year (e.g., '2023').
     * @param int $month The month (1-12).
     * @param mixed $connect The database connection resource.
     * @param array|null $options SQLSRV options.
     * @return array|null The fetched data row or null on failure.
     */
    function get_monthly_electricity_data(string $year, int $month, $connect, ?array $options): ?array {
        $start_date = date('Y-m-d', strtotime("$year-$month-16 -1 month"));
        $end_date = date('Y-m-d', strtotime("$year-$month-15"));

        // 보안: SQL Injection을 방지하기 위해 매개변수화된 쿼리를 사용합니다.
        $query = "SELECT SUM(ELECTRICITY) AS ELECTRICITY
                  FROM CONNECT.dbo.READ_METER
                  WHERE SORTING_DATE BETWEEN ? AND ?";
        $params = [$start_date, $end_date];
        $result = sqlsrv_query($connect, $query, $params, $options);

        if ($result === false) {
            return null;
        }
        return sqlsrv_fetch_array($result) ?: null;
    }

    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';  
   
    //★변수모음 (보안: filter_input으로 안전하게 사용자 입력 처리)
    //탭2
    $note21_a = filter_input(INPUT_POST, "note21_a", FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $note21_b = filter_input(INPUT_POST, "note21_b", FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $note21_c = filter_input(INPUT_POST, "note21_c", FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $bt21 = filter_input(INPUT_POST, "bt21");

    //탭3  
    $s_dt3 = null;
    $e_dt3 = null;
    $dt3_raw = filter_input(INPUT_POST, "dt3");
    if ($dt3_raw && preg_match('/^(\d{4}-\d{2}-\d{2}) ~ (\d{4}-\d{2}-\d{2})$/', $dt3_raw, $matches)) {
        $s_dt3 = $matches[1];
        $e_dt3 = $matches[2];
    }
    $bt31 = filter_input(INPUT_POST, "bt31");   
    
    //★버튼 클릭 시 실행      
    if($bt21 === "on") {
        $tab_sequence=2; 
        include '../TAB.php'; 

        // Get the last valid meter reading before today
        $query_last_date = "SELECT TOP 1 * FROM CONNECT.dbo.READ_METER WHERE SORTING_DATE < ? AND WATER_IWIN IS NOT NULL ORDER BY NO DESC";
        $params_last_date = [$Hyphen_today];
        $result_last_date = sqlsrv_query($connect, $query_last_date, $params_last_date);
        $data_last_date = $result_last_date ? sqlsrv_fetch_array($result_last_date) : null;

        if ($data_last_date) {
            $last_water_iwin = (float)$data_last_date['WATER_IWIN'];
            $last_water_malle = (float)$data_last_date['WATER_MALLE'];
            $last_gas = (float)$data_last_date['GAS'];

            if($note21_a < $last_water_iwin || $note21_b < $last_water_malle || $note21_c < $last_gas) {
                echo "<script>alert('마지막 데이터보다 수도, 가스 값이 작습니다. 확인해주세요!');</script>";
            } else {
                if(($note21_a - $last_water_iwin > 1000) && ($note21_b - $last_water_malle > 1000) && ($note21_c - $last_gas > 1000)) {
                    echo "<script>alert('말레수도와 가스를 바꿔서 입력하지 않으셨나요? 확인해주세요! (평균사용량과 차이가 많이 납니다!)');</script>";
                }
                if($note21_a - $last_water_iwin >= 40) {
                    $original_request_type = $_REQUEST['type'] ?? null;
                    $_REQUEST['type'] = 'water_usage_alert';
                    include '../mailer.php';
                    $_REQUEST['type'] = $original_request_type;
                    echo "<script>alert('물이 새고 있는것 같습니다! 확인해주세요! (외곽, 화장실, 식당 등)');</script>";
                }
            }
        }
        
        // Check if data for today already exists
        $query_check_today = "SELECT NO FROM CONNECT.dbo.READ_METER WHERE SORTING_DATE = ?";
        $params_check_today = [$Hyphen_today];
        $stmt_check_today = sqlsrv_query($connect, $query_check_today, $params_check_today);

        // 보안: SQL Injection 방지를 위해 매개변수화된 쿼리를 사용합니다.
        if (sqlsrv_fetch($stmt_check_today)) {
            // Data exists, so UPDATE
            $query_update_meter = "UPDATE CONNECT.dbo.READ_METER SET WATER_IWIN=?, WATER_MALLE=?, GAS=? WHERE SORTING_DATE=?";
            $params_update = [$note21_a, $note21_b, $note21_c, $Hyphen_today];
            sqlsrv_query($connect, $query_update_meter, $params_update);
        } else {
            // Data does not exist, so INSERT
            $query_insert_meter = "INSERT INTO CONNECT.dbo.READ_METER (SORTING_DATE, WATER_IWIN, WATER_MALLE, GAS, ELECTRICITY) VALUES (?, ?, ?, ?, 0)";
            $params_insert = [$Hyphen_today, $note21_a, $note21_b, $note21_c];
            sqlsrv_query($connect, $query_insert_meter, $params_insert);
        }
    }     
    //검침내역
    ELSEIF($bt31 === "on" && $s_dt3 && $e_dt3) {
        $tab_sequence=3; 
        include '../TAB.php'; 

        //검침내역 조회 (보안: 매개변수화된 쿼리)
        $query_read_meter = "SELECT * FROM CONNECT.dbo.READ_METER WHERE SORTING_DATE BETWEEN ? AND ?";
        $params_read = [$s_dt3, $e_dt3];
        $result_read_meter = sqlsrv_query($connect, $query_read_meter, $params_read, $options);
        
        // PHP 8.x 호환성: 비권장 함수 sqlsrv_num_rows() 대신 COUNT(*) 쿼리 사용
        $query_count = "SELECT COUNT(*) AS row_count FROM CONNECT.dbo.READ_METER WHERE SORTING_DATE BETWEEN ? AND ?";
        $stmt_count = sqlsrv_query($connect, $query_count, $params_read);
        $count_data = $stmt_count ? sqlsrv_fetch_array($stmt_count) : null;
        $count_read_meter = $count_data ? $count_data['row_count'] : 0;
    } 

    //금일 검침 조회 (보안: 매개변수화된 쿼리)
    $query_today_meter = "SELECT ISNULL(WATER_IWIN, 0) AS WATER_IWIN, ISNULL(WATER_MALLE, 0) AS WATER_MALLE, ISNULL(GAS, 0) AS GAS, ISNULL(ELECTRICITY, 0) AS ELECTRICITY FROM CONNECT.dbo.READ_METER WHERE SORTING_DATE=?";
    $params_today = [$Hyphen_today];
    $result_today_meter = sqlsrv_query($connect, $query_today_meter, $params_today, $options);
    $data_today_meter = $result_today_meter ? sqlsrv_fetch_array($result_today_meter) : null;

    // 참고: 아래의 동적 변수 할당(${'...'}})은 PHP 8.x에서 유효하지만, 가독성과 정적 분석의 어려움 때문에 권장되지 않습니다.
    // 가능한 경우, 뷰(View) 파일을 수정하여 배열(e.g., $data_this_year[1], $data_this_year[2])을 사용하도록 리팩토링하는 것이 좋습니다.
    
    //////////////////////////////////금년 (수도/가스)//////////////////////////////////
    for ($m = 1; $m <= 12; $m++) {
        ${"Data_ThisYear". $m . "M"} = get_monthly_meter_data($YY, $m, $connect, $options);
    }

    //////////////////////////////////작년 (수도/가스)//////////////////////////////////
    $Data_BeforeLastYear12M = get_monthly_meter_data($Minus2YY, 12, $connect, $options);
    for ($m = 1; $m <= 12; $m++) {
        ${"Data_LastYear". $m . "M"} = get_monthly_meter_data($Minus1YY, $m, $connect, $options);
    }

    //////////////////////////////////금년 (전기)//////////////////////////////////
    for ($m = 1; $m <= 12; $m++) {
        ${"Data_ThisYear". $m . "M_E"} = get_monthly_electricity_data($YY, $m, $connect, $options);
    }

    //////////////////////////////////작년 (전기)//////////////////////////////////
    for ($m = 1; $m <= 12; $m++) {
        ${"Data_LastYear". $m . "M_E"} = get_monthly_electricity_data($Minus1YY, $m, $connect, $options);
    }
?>