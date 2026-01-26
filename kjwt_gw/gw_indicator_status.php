<?php
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <21.02.01>
    // Description: <그룹웨어 일일지표 뷰어 - 상태 로직>
    // Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
    // =============================================
    // ★★★ [보안 강화] 외부/내부 접속 구분 및 도메인 검증 시작 ★★★
    
    // 1. 설정: 허용할 외부 홈페이지 도메인 (반드시 실제 운영 중인 홈페이지 주소로 변경하세요)
    // 예: 홈페이지가 www.kjwt.co.kr 이라면 아래 배열에 넣습니다.
    $allowed_referers = [
        'gw.iwin.kr'
    ];

    // 2. 설정: 외부 iframe 호출 시 사용할 보안 키
    $public_access_key = "iwin_public_secure"; 

    // 3. 검증 로직
    $is_public_view = false;
    $input_token = $_GET['token'] ?? '';
    $http_referer = $_SERVER['HTTP_REFERER'] ?? ''; // 요청이 어디서 왔는지 확인

    // 토큰이 일치하는지 확인
    if ($input_token === $public_access_key) {
        
        // 리퍼러(접속 경로) 검증: 주소창에 직접 입력(null)하거나 다른 곳에서 링크 건 경우 차단
        $is_valid_origin = false;
        foreach ($allowed_referers as $domain) {
            if (strpos($http_referer, $domain) !== false) {
                $is_valid_origin = true;
                break;
            }
        }

        // 토큰도 맞고, 우리 홈페이지에서 온 요청이 맞다면 공개 모드 활성화
        if ($is_valid_origin) {
            $is_public_view = true;
        }
    }

    // 4. 내부 접속(공개 모드가 아님)일 경우에만 세션 체크 실행
    // 리퍼러가 없거나(직접 입력), 토큰이 틀리면 무조건 로그인 페이지로 튕김
    if (!$is_public_view) {
        try {
            require_once __DIR__ .'/../session/session_check.php';
        } catch (Exception $e) {
            die("Session check failed.");
        }
    }
    // ★★★ [보안 강화] 로직 끝 ★★★

    // DB 연결 및 함수 사용
    include_once __DIR__ . '/../FUNCTION.php';
    include_once __DIR__ . '/../DB/DB4.php'; // $connect4 (mysqli)
    include_once __DIR__ . '/../DB/DB2.php'; // $connect (sqlsrv)

    // --- Helper Functions ---

    function getWeatherInfo(mysqli $db_conn, string $date, string $time): string
    {
        $status = '';
        $stmt = $db_conn->prepare("SELECT fcstValue FROM weather2 WHERE FcstDate = ? AND fcstTime = ? AND category = 'PTY' ORDER BY NO DESC LIMIT 1");
        $stmt->bind_param('ss', $date, $time);
        $stmt->execute();
        $pty_row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $pty_value = $pty_row['fcstValue'] ?? '0';

        $pty_map = ['1' => '비', '2' => '비/눈', '3' => '눈', '4' => '소나기'];
        if (isset($pty_map[$pty_value])) {
            return $pty_map[$pty_value];
        }

        $stmt = $db_conn->prepare("SELECT fcstValue FROM weather2 WHERE FcstDate = ? AND fcstTime = ? AND category = 'SKY' ORDER BY NO DESC LIMIT 1");
        $stmt->bind_param('ss', $date, $time);
        $stmt->execute();
        $sky_row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $sky_value = $sky_row['fcstValue'] ?? '1';
        $sky_map = ['1' => '맑음', '3' => '구름 많음', '4' => '흐림'];
        
        return $sky_map[$sky_value] ?? '맑음';
    }

    function calculateEnergyStatus(float $currentUsage, float $previousUsage): int
    {
        if ($previousUsage == 0) {
            return ($currentUsage > 0) ? 1 : 4;
        }
        if ($currentUsage <= $previousUsage) return 4;
        if ($currentUsage <= $previousUsage * 1.025) return 3;
        if ($currentUsage <= $previousUsage * 1.05) return 2;
        return 1;
    }

    function getStockInfo(mysqli $db_conn, string $code, string $today, string $yesterday): array
    {
        $info = ['current' => 0, 'compare' => 0, 'compare_rate' => 0.0, 'dt' => '-', 'ti' => '-'];

        $stmt = $db_conn->prepare("SELECT `CURRENT`, `DT`, `TI` FROM stock WHERE DT = ? AND CODE = ? ORDER BY NO DESC LIMIT 1");
        
        $stmt->bind_param('ss', $today, $code);
        $stmt->execute();
        $today_row = $stmt->get_result()->fetch_assoc();
        if ($today_row) {
            $info['current'] = $today_row['CURRENT'] ?? 0;
            $info['dt'] = $today_row['DT'] ?? $today;
            $info['ti'] = $today_row['TI'] ?? '00:00';
        }

        $stmt->bind_param('ss', $yesterday, $code);
        $stmt->execute();
        $yesterday_row = $stmt->get_result()->fetch_assoc();
        $yesterday_price = $yesterday_row['CURRENT'] ?? 0;
        
        $stmt->close();

        if ($yesterday_price > 0) {
            $info['compare'] = $info['current'] - $yesterday_price;
            $info['compare_rate'] = ($info['compare'] / $yesterday_price) * 100;
        } elseif ($info['current'] > 0) {
            $info['compare'] = $info['current'];
            $info['compare_rate'] = 100.0;
        }

        return $info;
    }

    function getMeterReading($db_conn, string $yearMonth): array
    {
        $query = "SELECT TOP 1 ISNULL(WATER_IWIN, 0) AS WATER_IWIN, ISNULL(GAS, 0) AS GAS FROM CONNECT.dbo.READ_METER WHERE SORTING_DATE LIKE ? AND GAS IS NOT NULL ORDER BY SORTING_DATE DESC";
        $params = [$yearMonth . '%'];
        $stmt = sqlsrv_query($db_conn, $query, $params);
        if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            return $row;
        }
        return ['WATER_IWIN' => 0, 'GAS' => 0];
    }

    function getElectricityUsage($db_conn, string $start, string $end): float
    {
        $query = "SELECT SUM(ELECTRICITY) AS ELECTRICITY FROM CONNECT.dbo.READ_METER WHERE SORTING_DATE BETWEEN ? AND ?";
        $params = [$start, $end];
        $stmt = sqlsrv_query($db_conn, $query, $params);
        if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            return (float)($row['ELECTRICITY'] ?? 0);
        }
        return 0.0;
    }

    // --- Main Logic ---

    $indicator_data = [];

    // ★ 날씨 (Weather) ★
    $indicator_data['weather'] = [
        'today_am' => getWeatherInfo($connect4, $NoHyphen_today, '0600'),
        'today_pm' => getWeatherInfo($connect4, $NoHyphen_today, '1500'),
        'tomorrow_am' => getWeatherInfo($connect4, $Plus1Day2, '0600'),
        'tomorrow_pm' => getWeatherInfo($connect4, $Plus1Day2, '1500')
    ];

    $tmx_stmt = $connect4->prepare("SELECT fcstValue FROM weather2 WHERE FcstDate = ? AND category = 'TMX' LIMIT 1");
    $tmx_stmt->bind_param('s', $NoHyphen_today);
    $tmx_stmt->execute();
    $indicator_data['weather']['today_max_temp'] = $tmx_stmt->get_result()->fetch_assoc()['fcstValue'] ?? 0;
    $tmx_stmt->close();

    $tmn_stmt = $connect4->prepare("SELECT fcstValue FROM weather2 WHERE FcstDate = ? AND category = 'TMN' LIMIT 1");
    $tmn_stmt->bind_param('s', $NoHyphen_today);
    $tmn_stmt->execute();
    $indicator_data['weather']['today_min_temp'] = $tmn_stmt->get_result()->fetch_assoc()['fcstValue'] ?? 0;
    $tmn_stmt->close();

    $tmx2_stmt = $connect4->prepare("SELECT fcstValue FROM weather2 WHERE FcstDate = ? AND category = 'TMX' LIMIT 1");
    $tmx2_stmt->bind_param('s', $Plus1Day2);
    $tmx2_stmt->execute();
    $indicator_data['weather']['tomorrow_max_temp'] = $tmx2_stmt->get_result()->fetch_assoc()['fcstValue'] ?? 0;
    $tmx2_stmt->close();

    $tmn2_stmt = $connect4->prepare("SELECT fcstValue FROM weather2 WHERE FcstDate = ? AND category = 'TMN' LIMIT 1");
    $tmn2_stmt->bind_param('s', $Plus1Day2);
    $tmn2_stmt->execute();
    $indicator_data['weather']['tomorrow_min_temp'] = $tmn2_stmt->get_result()->fetch_assoc()['fcstValue'] ?? 0;
    $tmn2_stmt->close();

    // ★ 주식 (Stocks) ★
    $indicator_data['stock']['iwin'] = getStockInfo($connect4, '아이윈', $NoHyphen_today, $Minus1Day2);

    // ★ 뉴스 (News) ★
    $query_news = "SELECT TOP 3 * FROM CONNECT.dbo.DASHBOARD_NEWS WHERE collect_dt = ? ORDER BY dt DESC";
    $params_news = [$NoHyphen_today];
    $stmt_news = sqlsrv_query($connect, $query_news, $params_news);
    $indicator_data['news'] = [];
    if ($stmt_news) {
        while ($row = sqlsrv_fetch_array($stmt_news, SQLSRV_FETCH_ASSOC)) {
            $indicator_data['news'][] = $row;
        }
    }

    // ★ 수도, 가스, 전기 에너지 (Energy) ★
    $this_month_usage = getMeterReading($connect, $YM);
    $last_month_usage = getMeterReading($connect, $Minus1YM);
    $two_months_ago_usage = getMeterReading($connect, $Minus2YM);
    $last_year_this_month_usage = getMeterReading($connect, $Minus1year_YM);
    $last_year_last_month_usage = getMeterReading($connect, $Minus1yearMonth_YM);

    $indicator_data['energy'] = [];
    $indicator_data['energy']['water_this_month'] = max(0, $this_month_usage['WATER_IWIN'] - $last_month_usage['WATER_IWIN']);
    $indicator_data['energy']['water_last_month'] = max(0, $last_month_usage['WATER_IWIN'] - $two_months_ago_usage['WATER_IWIN']);
    $indicator_data['energy']['water_last_year_month'] = max(0, $last_year_this_month_usage['WATER_IWIN'] - $last_year_last_month_usage['WATER_IWIN']);

    $indicator_data['energy']['gas_this_month'] = max(0, $this_month_usage['GAS'] - $last_month_usage['GAS']);
    $indicator_data['energy']['gas_last_month'] = max(0, $last_month_usage['GAS'] - $two_months_ago_usage['GAS']);
    $indicator_data['energy']['gas_last_year_month'] = max(0, $last_year_this_month_usage['GAS'] - $last_year_last_month_usage['GAS']);

    $indicator_data['energy']['water_vs_last_month'] = calculateEnergyStatus($indicator_data['energy']['water_this_month'], $indicator_data['energy']['water_last_month']);
    $indicator_data['energy']['water_vs_last_year'] = calculateEnergyStatus($indicator_data['energy']['water_this_month'], $indicator_data['energy']['water_last_year_month']);
    $indicator_data['energy']['gas_vs_last_month'] = calculateEnergyStatus($indicator_data['energy']['gas_this_month'], $indicator_data['energy']['gas_last_month']);
    $indicator_data['energy']['gas_vs_last_year'] = calculateEnergyStatus($indicator_data['energy']['gas_this_month'], $indicator_data['energy']['gas_last_year_month']);

    // 전기
    $e_period_current_start = ($D >= '16') ? $YM . '-16' : $Minus1YM . '-16';
    $e_period_current_end = ($D >= '16') ? $Plus1YM . '-15' : $YM . '-15';
    $e_period_last_month_start = ($D >= '16') ? $Minus1YM . '-16' : $Minus2YM . '-16';
    $e_period_last_month_end = ($D >= '16') ? $YM . '-15' : $Minus1YM . '-15';
    $e_period_last_year_start = ($D >= '16') ? $Minus1year_YM . '-16' : $Minus1yearMonth_YM . '-16';
    $e_period_last_year_end = ($D >= '16') ? $Plus1yearMonth_YM . '-15' : $Minus1year_YM . '-15';

    $indicator_data['energy']['electricity_this_month'] = getElectricityUsage($connect, $e_period_current_start, $e_period_current_end);
    $indicator_data['energy']['electricity_last_month'] = getElectricityUsage($connect, $e_period_last_month_start, $e_period_last_month_end);
    $indicator_data['energy']['electricity_last_year'] = getElectricityUsage($connect, $e_period_last_year_start, $e_period_last_year_end);

    $indicator_data['energy']['electricity_vs_last_month'] = calculateEnergyStatus($indicator_data['energy']['electricity_this_month'], $indicator_data['energy']['electricity_last_month']);
    $indicator_data['energy']['electricity_vs_last_year'] = calculateEnergyStatus($indicator_data['energy']['electricity_this_month'], $indicator_data['energy']['electricity_last_year']);
?>