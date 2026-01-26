<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.05.25>
	// Description:	<그룹웨어 ppm 뷰어>
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
    // =============================================
       
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';

    // --- 데이터 처리를 위한 함수 정의 ---
    function process_ppm_data($row) {
        if ($row && $row['QT_WORK'] > 0) {
            $ppm_v = round((int)$row['QT_REJECT'] * 1000000 / (int)$row['QT_WORK']);
            $ppm_w = (int)$row['QT_WORK'] / 1000;
        } else {
            $ppm_v = 0;
            $ppm_w = 0;
        }
        return [$ppm_v, $ppm_w];
    }

    // --- 1. 일별 데이터 조회 (효율적인 GROUP BY 쿼리) ---
    $dailyData = [];
    $date_to_check_day = date("Ymd", strtotime("-6 days"));
    $query_daily = "
        SELECT 
            DT_WORK,
            SUM(A.QT_WORK) as QT_WORK, 
            SUM(A.QT_REJECT) as QT_REJECT 
        FROM NEOE.NEOE.PR_WORK A 
        INNER JOIN NEOE.NEOE.PR_WO B ON A.NO_WO = B.NO_WO 
        WHERE A.DT_WORK >= ? AND B.TP_ROUT = 'K20'
        GROUP BY A.DT_WORK
        ORDER BY A.DT_WORK ASC";
    
    $params_daily = [$date_to_check_day];
    $result_daily = sqlsrv_query($connect, $query_daily, $params_daily);

    $daily_results = [];
    if ($result_daily) {
        while ($row = sqlsrv_fetch_array($result_daily, SQLSRV_FETCH_ASSOC)) {
            $daily_results[$row['DT_WORK']] = $row;
        }
    }

    for ($i = 6; $i >= 0; $i--) {
        $day = date("Ymd", strtotime("-$i days"));
        $row = $daily_results[$day] ?? null;
        list($ppm_v, $ppm_w) = process_ppm_data($row);
        $dailyData[] = [$day, $ppm_v, 180, round($ppm_w)];
    }

    // --- 2. 주차별 데이터 조회 (효율적인 GROUP BY 쿼리) ---
    $weeklyData = [];
    $date_to_check_week = date("Ymd", strtotime("-48 days")); // Approx 7 weeks back

    // SQL Server의 DATEPART를 사용하여 주차(week) 계산
    $query_weekly = "
        SELECT 
            DATEPART(week, A.DT_WORK) as WORK_WEEK,
            MIN(A.DT_WORK) as WEEK_START_DATE,
            SUM(A.QT_WORK) as QT_WORK, 
            SUM(A.QT_REJECT) as QT_REJECT 
        FROM NEOE.NEOE.PR_WORK A 
        INNER JOIN NEOE.NEOE.PR_WO B ON A.NO_WO = B.NO_WO 
        WHERE A.DT_WORK >= ? AND B.TP_ROUT = 'K20'
        GROUP BY DATEPART(week, A.DT_WORK)
        ORDER BY WORK_WEEK ASC";

    $params_weekly = [$date_to_check_week];
    $result_weekly = sqlsrv_query($connect, $query_weekly, $params_weekly);

    $weekly_results = [];
    if ($result_weekly) {
        while ($row = sqlsrv_fetch_array($result_weekly, SQLSRV_FETCH_ASSOC)) {
            $weekly_results[$row['WORK_WEEK']] = $row;
        }
    }

    $current_week_number = date('W');
    for ($i = 6; $i >= 0; $i--) {
        $week_number = date('W', strtotime("-$i weeks"));
        $row = $weekly_results[$week_number] ?? null;
        list($ppm_v, $ppm_w) = process_ppm_data($row);
        $weeklyData[] = [$week_number . "주차", $ppm_v, 180, round($ppm_w)];
    }
?>