<?php   
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>	
    // Create date: <21.05.24>
    // Description:	<연차정보 제공 - Status Logic>
    // Last Modified: <25.10.01> - Refactored for PHP 8.x and security.
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/ip_session.php'; 
    require_once __DIR__ . '/../DB/DB3.php';  // $connect3 (mysqli)
    require_once __DIR__ . '/../DB/DB2.php'; // $connect (sqlsrv)

    // --- Helper Functions ---

    function getSingleValueSrv( $db_conn, $sql, $params = []) {
        $stmt = sqlsrv_query($db_conn, $sql, $params);
        if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            return $row['COU'] ?? 0;
        }
        return 0;
    }

    function getSingleValueMysqli( $db_conn, $sql) {
        $result = $db_conn->query($sql);
        return $result ? $result->num_rows : 0;
    }

    function getLeaveDetails(mysqli $db_conn, string $condition, string $date_condition): array
    {
        $details = [];
        $sql = "
            SELECT
                d.day_cnt, d.annv_use_day_cnt, d.start_dt, d.end_dt, d.remark,
                e.emp_name,
                dp.dept_name,
                r.att_req_title,
                r.elct_appv_doc_id
            FROM
                t_at_att_req_detail d
            LEFT JOIN t_co_emp_multi e ON d.emp_seq = e.emp_seq AND e.lang_code = 'kr'
            LEFT JOIN t_co_dept_multi dp ON d.dept_seq = dp.dept_seq AND dp.lang_code = 'kr'
            LEFT JOIN t_at_att_req r ON d.req_sqno = r.req_sqno AND r.comp_seq = '1'
            WHERE
                d.use_yn = 'Y' AND d.approve_yn NOT IN ('K', 'R')
                AND {$condition}
                AND {$date_condition}
        ";

        $result = $db_conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $details[] = [
                    'emp_name' => $row['emp_name'] ?? '',
                    'dept_name' => $row['dept_name'] ?? '',
                    'day_cnt' => $row['day_cnt'] ?? 0,
                    'annv_use_day_cnt' => $row['annv_use_day_cnt'] ?? 0,
                    'start_dt' => $row['start_dt'] ?? '',
                    'end_dt' => $row['end_dt'] ?? '',
                    'title' => $row['att_req_title'] ?? '',
                    'remark' => $row['remark'] ?? '',
                    'doc_id' => $row['elct_appv_doc_id'] ?? ''
                ];
            }
        }
        return $details;
    }

    // --- Data Initialization ---
    $attendance_data = [];
    $today_ymd = date("Ymd");
    $yesterday_ymd = (date('w') == 1) ? date("Ymd", strtotime("-3 days")) : date("Ymd", strtotime("-1 day"));

    // --- Data Fetching ---
    // 1. 요약 (Summary)
    $attendance_data['summary'] = [
        'managed' => [
            'total' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department IN ('021', '023')"),
            'male' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department IN ('021', '023') AND grade='009'"),
            'female' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department IN ('021', '023') AND grade='010'"),
            'dispatch' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department='023'")
        ],
        'contract' => [
            'total' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department IN ('015', '017', '018', '019') AND JoiningDate<=?", [$today_ymd]),
            'male' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department IN ('015', '017', '018', '019') AND grade='009'"),
            'female' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department IN ('015', '017', '018', '019') AND grade='010'"),
            'absent' => getSingleValueSrv($connect, "SELECT COUNT(*) AS COU FROM SECOM.dbo.T_SECOM_WORKHISTORY WHERE SABUN LIKE 'T%' AND WORKDATE=? AND Department IN ('015', '016', '018') AND WSTime=''", [$today_ymd])
        ]
    ];

    // 2. 휴가 등 (Leave etc.)
    $leave_types = [
        'managed_annual' => "d.dept_seq <> '353' AND d.comp_seq='1' AND d.att_item_code='1' AND d.att_div_code='11'",
        'managed_official' => "d.dept_seq <> '353' AND d.comp_seq='1' AND d.att_item_code='1' AND d.att_div_code='14'",
        'managed_training' => "d.dept_seq <> '353' AND d.comp_seq='1' AND (d.att_div_code='532' OR d.att_div_code='5012')",
        'managed_business_trip' => "d.dept_seq <> '353' AND d.comp_seq='1' AND d.att_item_code='2'",
        'contract_annual' => "d.dept_seq='353' AND d.comp_seq='1' AND d.att_item_code='1' AND d.att_div_code='11'",
        'contract_official' => "d.dept_seq='353' AND d.comp_seq='1' AND d.att_item_code='1' AND d.att_div_code='14'",
        'contract_training' => "d.dept_seq='353' AND d.comp_seq='1' AND (d.att_item_code='53' OR d.att_item_code='54')",
        'contract_business_trip' => "d.dept_seq='353' AND d.comp_seq='1' AND d.att_item_code='2'"
    ];
    foreach ($leave_types as $key => $condition) {
        $sql = "SELECT 1 FROM t_at_att_req_detail d WHERE d.use_yn='Y' AND d.approve_yn NOT IN ('K', 'R') AND {$condition} AND d.end_dt>='$today_ymd' AND d.start_dt<='$today_ymd'";
        $attendance_data['leave_counts'][$key] = getSingleValueMysqli($connect3, $sql);
    }

    // 3. 도급직 세부 (Contractor Details)
    $attendance_data['details'] = [
        'firstin_total' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department='015' AND JoiningDate<=?", [$today_ymd]),
        'firstinkorea_total' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department IN ('017', '018', '019') AND JoiningDate<=?", [$today_ymd]),
        'firstinkorea_cleaning' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department='018'"),
        'firstinkorea_security' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department='019'"),
        'firstinkorea_other' => getSingleValueSrv($connect, "SELECT COUNT(DISTINCT Name+Sabun) AS COU FROM SECOM.dbo.T_SECOM_PERSON WHERE Department='017' AND JoiningDate<=?", [$today_ymd])
    ];
    $attendance_data['details']['firstin_prod'] = $attendance_data['details']['firstin_total'];

    // 4. 인원 증감 (Headcount Trend)
    $b_yyyy = date("Y", strtotime("-1 year"));
    $yyyy = date("Y");
    $attendance_data['trend'] = ['this_year' => [], 'last_year' => [], 'this_year_label' => $yyyy.'년 (매월 1일)', 'last_year_label' => $b_yyyy.'년 (매월 1일)'];
    $dept_condition = "Department='' OR Department IN ('015','016','017','018','019','020')";
    for ($i = 1; $i <= 12; $i++) {
        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
        $query = "SELECT COUNT(*) AS COU FROM SECOM.dbo.T_SECOM_WORKHISTORY WHERE WORKDATE=? AND SABUN LIKE 'T%' AND ($dept_condition)";
        $this_year_count = getSingleValueSrv($connect, $query, [$yyyy . $month . '01']);
        $attendance_data['trend']['this_year'][] = ($this_year_count > 0) ? $this_year_count + 3 : 0;
        $last_year_count = getSingleValueSrv($connect, $query, [$b_yyyy . $month . '01']);
        $attendance_data['trend']['last_year'][] = ($last_year_count > 0) ? $last_year_count + 3 : 0;
    }

    // 5. 상세 휴가 정보 (Detailed Leave Info for Tables)
    $attendance_data['leave_details'] = [];
    $leave_detail_types = [
        'annual' => "d.comp_seq='1' AND d.att_item_code='1' AND d.att_div_code='11'",
        'official' => "d.comp_seq='1' AND d.att_item_code='1' AND d.att_div_code='14'",
        'training' => "d.comp_seq='1' AND (d.att_div_code='532' OR d.att_div_code='5012')",
        'early_leave' => "d.comp_seq='1' AND d.att_item_code='1' AND (d.att_div_code='5025' OR d.att_div_code='5026' OR d.att_div_code='5027')",
        'business_trip' => "d.comp_seq='1' AND d.att_item_code='2'",
        'outside_work' => "d.comp_seq='1' AND d.att_item_code='3'"
    ];
    foreach ($leave_detail_types as $key => $condition) {
        $date_condition = "d.end_dt>='$today_ymd' AND d.start_dt<='$today_ymd'";
        $attendance_data['leave_details'][$key] = getLeaveDetails($connect3, $condition, $date_condition);
    }
    $attendance_data['leave_details']['yesterday_early'] = getLeaveDetails($connect3, "d.comp_seq='1' AND d.att_item_code='1' AND (d.att_div_code='5025' OR d.att_div_code='5026' OR d.att_div_code='5027')", "d.end_dt>='$yesterday_ymd' AND d.start_dt<='$yesterday_ymd'");
    $attendance_data['leave_details']['yesterday_leave'] = getLeaveDetails($connect3, "d.comp_seq='1' AND d.att_item_code='1' AND (d.att_div_code='11' OR d.att_div_code='14')", "d.end_dt>='$yesterday_ymd' AND d.start_dt<='$yesterday_ymd'");

    // 6. 현장 결근자 명단
    $absentee_query = sqlsrv_query($connect, "SELECT Name FROM SECOM.dbo.T_SECOM_WORKHISTORY WHERE SABUN LIKE 'T%' AND WORKDATE=? AND Department IN ('015', '016', '018') AND WSTime=''", [$today_ymd]);
    $attendance_data['absentees'] = [];
    if($absentee_query) {
        while($row = sqlsrv_fetch_array($absentee_query, SQLSRV_FETCH_ASSOC)) {
            $attendance_data['absentees'][] = $row['Name'];
        }
    }
?>
