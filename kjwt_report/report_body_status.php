<?php   
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.09.01>
	// Description:	<레포트 리뉴얼>		
    // Last Modified: <25.10.20> - Refactored for PHP 8.x	
    // =============================================
  
    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';
    include '../DB/DB3.php';

    //★탭활성화
    //메뉴 진입 시 탭활성화 start
    $tab = $_GET["tab"] ?? 'information';
    switch ($tab) {
        case 'management':
            $tab_sequence = 3;
            break;
        case 'accounting':
            $tab_sequence = 4;
            break;
        case 'logistics':
            $tab_sequence = 5;
            break;
        case 'sales':
            $tab_sequence = 6;
            break;
        case 'quality':
            $tab_sequence = 7;
            break;
        case 'orders':
            $tab_sequence = 8;
            break;
        case 'youtube':
            $tab_sequence = 9;
            break;
        case 'vietnam':
            $tab_sequence = 10;
            break;
        default:
            $tab_sequence = 1;
            break;
    }
    include '../TAB.php';


    //★ 변수 및 데이터 구조 초기화   
    // [수정] 외부 파일(FUNCTION.php)에 의존하지 않고 현재 서버 시간 기준으로 연도를 직접 생성합니다.
    $currentYear = date("Y"); // 예: 2025
    $currentMonth = date("m");
    
    // 정수형으로 변환하여 1년 전, 2년 전 연도를 정확히 계산
    $currentYearInt = (int)$currentYear;
    $previousYear = (string)($currentYearInt - 1);      // 예: 2024
    $yearBeforePrevious = (string)($currentYearInt - 2); // 예: 2023

    // [중요] 프론트엔드(report_body.php)의 그래프 라벨(범례)에 표시될 변수도 여기서 강제로 갱신합니다.
    // 기존 $Minus1YY 변수가 잘못되었더라도 여기서 덮어쓰므로 정상 출력됩니다.
    $YY = $currentYear;
    $Minus1YY = $previousYear;
    $Minus2YY = $yearBeforePrevious;


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //사무직/도급직 총원
    // 결과를 담을 변수 초기화
    $office_staff_count = 0;
    $contract_staff_count = 0;    
    $attend_total = 0;

    try {
        // [수정] CONNECT.dbo.ATTEND 테이블을 사용하여 총원 조회
        // 가장 최신 날짜(SORTING_DATE DESC)의 데이터를 기준으로 합니다.
        $attend_sql = "SELECT TOP 1 * FROM CONNECT.dbo.ATTEND ORDER BY SORTING_DATE DESC";
        $attend_result = sqlsrv_query($connect, $attend_sql);
        
        if ($attend_result) {
            $attend_row = sqlsrv_fetch_array($attend_result, SQLSRV_FETCH_ASSOC);
            
            if ($attend_row) {
                // 사무직 총원 = SAMU_TOTAL
                // 값이 없으면 0으로 처리
                $office_staff_count = isset($attend_row['SAMU_TOTAL']) ? (int)$attend_row['SAMU_TOTAL'] : 0;
                
                // 도급직 총원 = FIRSTIN_FIELD_TOTAL(현장) + FIRSTIN_NONFIELD_TOTAL(비현장)
                $field_total = isset($attend_row['FIRSTIN_FIELD_TOTAL']) ? (int)$attend_row['FIRSTIN_FIELD_TOTAL'] : 0;
                $nonfield_total = isset($attend_row['FIRSTIN_NONFIELD_TOTAL']) ? (int)$attend_row['FIRSTIN_NONFIELD_TOTAL'] : 0;
                
                $contract_staff_count = $field_total + $nonfield_total;
                
                // 전체 합계
                $attend_total = $office_staff_count + $contract_staff_count;
            }
        }
    } catch (Throwable $e) {
        error_log("Database query failed: " . $e->getMessage());
    }


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //사무/도급직 인원증감 (CONNECT.dbo.ATTEND 테이블 사용 - 월말 기준 / SQL 날짜함수 사용)

    // 1. 그래프 데이터 배열 초기화
    $thisYearOfficeChartData = [];
    $thisYearContractChartData = [];
    $lastYearOfficeChartData = [];
    $lastYearContractChartData = [];
    $yearBeforeOfficeChartData = [];
    $yearBeforeContractChartData = [];

    // 2. 월별 마지막 데이터 조회 함수 정의 (개선된 SQL)
    if (!function_exists('getMonthlyHeadcounts')) {
        function getMonthlyHeadcounts($connect, $year) {
            // 1~12월 기본값 0으로 초기화
            $data = array_fill(1, 12, ['office' => 0, 'contract' => 0]); 

            // [핵심 로직] 
            // 1. YEAR(SORTING_DATE) = ? : 연도 일치 조건 (날짜 형식 무관하게 동작)
            // 2. MONTH(SORTING_DATE) as MM : DB에서 직접 월을 추출하여 가져옴 (PHP 파싱 불필요)
            $sql = "
                WITH MonthlyRanked AS (
                    SELECT
                        MONTH(SORTING_DATE) as MM,
                        ISNULL(SAMU_TOTAL, 0) AS SAMU_TOTAL,
                        ISNULL(FIRSTIN_FIELD_TOTAL, 0) + ISNULL(FIRSTIN_NONFIELD_TOTAL, 0) AS CONTRACT_TOTAL,
                        ROW_NUMBER() OVER (PARTITION BY MONTH(SORTING_DATE) ORDER BY SORTING_DATE DESC) as rn
                    FROM CONNECT.dbo.ATTEND
                    WHERE YEAR(SORTING_DATE) = ?
                )
                SELECT MM, SAMU_TOTAL, CONTRACT_TOTAL
                FROM MonthlyRanked
                WHERE rn = 1
            ";

            $params = [$year];
            $stmt = sqlsrv_query($connect, $sql, $params);

            if ($stmt) {
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    // DB에서 가져온 월(MM) 사용
                    $month = (int)$row['MM'];

                    // 해당 월 데이터 저장
                    if ($month >= 1 && $month <= 12) {
                        $data[$month] = [
                            'office' => (int)$row['SAMU_TOTAL'],
                            'contract' => (int)$row['CONTRACT_TOTAL']
                        ];
                    }
                }
            } else {
                // 쿼리 에러 확인용 (필요시 주석 해제)
                // echo "Query Error ($year): "; print_r(sqlsrv_errors());
            }
            return $data;
        }
    }

    // 3. 상단에서 계산된 정확한 연도 변수를 사용하여 데이터 조회
    $dataCurrent = getMonthlyHeadcounts($connect, $currentYear);
    $dataLast = getMonthlyHeadcounts($connect, $previousYear);
    $dataBefore = getMonthlyHeadcounts($connect, $yearBeforePrevious);

    // 4. 그래프용 배열에 순서대로 할당 (1월 ~ 12월)
    for ($i = 1; $i <= 12; $i++) {
        $thisYearOfficeChartData[] = $dataCurrent[$i]['office'];
        $thisYearContractChartData[] = $dataCurrent[$i]['contract'];

        $lastYearOfficeChartData[] = $dataLast[$i]['office'];
        $lastYearContractChartData[] = $dataLast[$i]['contract'];

        $yearBeforeOfficeChartData[] = $dataBefore[$i]['office'];
        $yearBeforeContractChartData[] = $dataBefore[$i]['contract'];
    }


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //수도,가스,전기 사용량
    $usageDataTypes = ['WaterIwin', 'WaterMalle', 'Gas', 'Electricity'];
    // 금년, 작년, 재작년(2023) 루프
    foreach ([$currentYear, $previousYear, $yearBeforePrevious] as $year) {
        foreach ($usageDataTypes as $type) {
            $prefix = ($year == $currentYear) ? 'thisYear' : (($year == $previousYear) ? 'lastYear' : 'yearBefore');
            $varName = $prefix . $type . 'UsageData';
            $$varName = array_fill(0, 12, 0); // 12개월치 0으로 초기화
        }
    }

    // 2단계: [가스/수도] - 누적 검침량 데이터 가져오기 (2023년 포함)
    $cumulativeReadings = [];
    $queryMeter = "
        WITH RankedData AS (
            SELECT 
                SORTING_DATE, WATER_IWIN, WATER_MALLE, GAS,
                ROW_NUMBER() OVER(PARTITION BY FORMAT(SORTING_DATE, 'yyyy-MM') ORDER BY SORTING_DATE DESC) as rn
            FROM CONNECT.dbo.READ_METER
            WHERE (SORTING_DATE LIKE ? OR SORTING_DATE LIKE ? OR SORTING_DATE LIKE ? OR SORTING_DATE LIKE ?) AND GAS IS NOT NULL
        )
        SELECT SORTING_DATE, ISNULL(WATER_IWIN, 0) AS WATER_IWIN, ISNULL(WATER_MALLE, 0) AS WATER_MALLE, ISNULL(GAS, 0) AS GAS 
        FROM RankedData WHERE rn = 1
    ";
    // 2023년 사용량 계산을 위해 2022년 12월 데이터도 필요함
    $paramsMeter = [$currentYear . '%', $previousYear . '%', $yearBeforePrevious . '%', ($yearBeforePrevious - 1) . '-12%'];
    $stmtMeter = sqlsrv_query($connect, $queryMeter, $paramsMeter);

    if ($stmtMeter) {
        while ($row = sqlsrv_fetch_array($stmtMeter, SQLSRV_FETCH_ASSOC)) {
            $dateKey = $row['SORTING_DATE']->format('Y-m');
            $cumulativeReadings[$dateKey] = $row;
        }
    }

    // 3단계: [가스/수도] - 월별 "사용량" 계산 (2023년 추가)
    foreach ([$currentYear, $previousYear, $yearBeforePrevious] as $year) {
        for ($month = 1; $month <= 12; $month++) {
            $monthIndex = $month - 1;
            
            $currentMonthKey = sprintf('%d-%02d', $year, $month);
            $previousMonthDate = new DateTime("$currentMonthKey-01");
            $previousMonthDate->modify('-1 month');
            $previousMonthKey = $previousMonthDate->format('Y-m');

            $currentReading = $cumulativeReadings[$currentMonthKey] ?? null;
            $previousReading = $cumulativeReadings[$previousMonthKey] ?? null;

            if ($currentReading && $previousReading) {
                $gasUsage = $currentReading['GAS'] - $previousReading['GAS'];
                $waterIwinUsage = $currentReading['WATER_IWIN'] - $previousReading['WATER_IWIN'];
                $waterMalleUsage = $currentReading['WATER_MALLE'] - $previousReading['WATER_MALLE'];

                $prefix = ($year == $currentYear) ? 'thisYear' : (($year == $previousYear) ? 'lastYear' : 'yearBefore');
                
                ${$prefix . 'GasUsageData'}[$monthIndex] = max(0, $gasUsage);
                ${$prefix . 'WaterIwinUsageData'}[$monthIndex] = max(0, $waterIwinUsage);
                ${$prefix . 'WaterMalleUsageData'}[$monthIndex] = max(0, $waterMalleUsage);
            }
        }
    }

    // 4단계: [전기] - 월별 "사용량" 합계 (2023년 포함)
    $queryElec = "
        SELECT
            FORMAT(DATEADD(month, CASE WHEN DAY(SORTING_DATE) <= 15 THEN 0 ELSE 1 END, SORTING_DATE), 'yyyy-MM') as UsageMonth,
            SUM(CONVERT(DECIMAL(18, 2), ELECTRICITY)) as ELECTRICITY_SUM
        FROM CONNECT.dbo.READ_METER
        WHERE SORTING_DATE >= ? AND SORTING_DATE < ?
        GROUP BY FORMAT(DATEADD(month, CASE WHEN DAY(SORTING_DATE) <= 15 THEN 0 ELSE 1 END, SORTING_DATE), 'yyyy-MM')
    ";
    $startDate = ($yearBeforePrevious - 1) . "-12-16";
    $endDate = $currentYear . "-12-16";
    $stmtElec = sqlsrv_query($connect, $queryElec, [$startDate, $endDate]);

    if ($stmtElec) {
        while ($row = sqlsrv_fetch_array($stmtElec, SQLSRV_FETCH_ASSOC)) {
            list($year, $monthStr) = explode('-', $row['UsageMonth']);
            $monthIndex = (int)$monthStr - 1;

            if ($year == $currentYear) {
                $thisYearElectricityUsageData[$monthIndex] = $row['ELECTRICITY_SUM'];
            } elseif ($year == $previousYear) {
                $lastYearElectricityUsageData[$monthIndex] = $row['ELECTRICITY_SUM'];
            } elseif ($year == $yearBeforePrevious) {
                $yearBeforeElectricityUsageData[$monthIndex] = $row['ELECTRICITY_SUM'];
            }
        }
    }

    // 합계 및 누적 합계 계산
    $typesToCalculate = ['Gas', 'WaterIwin', 'WaterMalle', 'Electricity'];
    $currentMonthIndex = (int)date('m') - 1; 

    foreach ([$currentYear, $previousYear, $yearBeforePrevious] as $year) {
        foreach ($typesToCalculate as $type) {
            $prefix = ($year == $currentYear) ? 'thisYear' : (($year == $previousYear) ? 'lastYear' : 'yearBefore');
            $varName = $prefix . $type . 'UsageData';
            
            $totalSum = array_sum($$varName);
            $limitIndex = ($year == $currentYear) ? $currentMonthIndex : 11;
            $cumulativeSum = array_sum(array_slice($$varName, 0, $limitIndex + 1));

            array_unshift($$varName, $totalSum, $cumulativeSum);
        }
    }


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //수도,가스, 전기비, 사무/도급직급여
    // 1단계: 그래프용 배열 명시적 초기화
    $thisYearWaterChartData = []; $lastYearWaterChartData = []; $yearBeforeWaterChartData = [];
    $thisYearGasChartData   = []; $lastYearGasChartData   = []; $yearBeforeGasChartData   = [];
    $thisYearElecChartData  = []; $lastYearElecChartData  = []; $yearBeforeElecChartData  = [];
    $thisYearPayChartData   = []; $lastYearPayChartData   = []; $yearBeforePayChartData   = [];
    $thisYearPay2ChartData  = []; $lastYearPay2ChartData  = []; $yearBeforePay2ChartData  = [];
    $thisYearDeliChartData  = []; $lastYearDeliChartData  = []; $yearBeforeDeliChartData  = [];

    // 2단계: 월별 데이터 DB 조회 (금년, 작년, 재작년) - FEE 테이블 (수도, 가스, 전기, 도급비, 운반비)
    $monthlyData = [];
    // PAY(사무직급여)는 별도 쿼리로 가져오므로 여기서 PAY는 제외하거나 무시됩니다.
    $query = "SELECT KIND, WATER, GAS, (ELECTRICITY + ELECTRICITY2) AS ELECTRICITY, CONVERT(BIGINT, PAY2) AS PAY2, DELIVERY FROM CONNECT.dbo.FEE WHERE KIND LIKE ? OR KIND LIKE ? OR KIND LIKE ?";
    
    // 파라미터를 명시적 문자열로 변환
    $params = [(string)$currentYear . '%', (string)$previousYear . '%', (string)$yearBeforePrevious . '%'];
    $result = sqlsrv_query($connect, $query, $params);
    
    if ($result) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            // [중요] trim()을 사용하여 DB 컬럼(KIND) 뒤에 붙은 공백을 제거합니다.
            $kind = trim($row['KIND']);
            $monthlyData[$kind] = $row;
            // 초기 PAY 값 0으로 설정 (이후 덮어씌움)
            $monthlyData[$kind]['PAY'] = 0;
        }
    }

    // 2-1단계: [추가] 사무직 급여(PAY) - neoe.neoe.HR_PCALCPAY 테이블에서 조회
    // 쿼리: 년월(ym)별 급여총액(am_totpay) 합계
    $payQuery = "
        SELECT ym, SUM(am_totpay) AS TOTAL_PAY 
        FROM neoe.neoe.HR_PCALCPAY 
        WHERE ym LIKE ? OR ym LIKE ? OR ym LIKE ? 
        GROUP BY ym
    ";
    $payParams = [(string)$currentYear . '%', (string)$previousYear . '%', (string)$yearBeforePrevious . '%'];
    $payResult = sqlsrv_query($connect, $payQuery, $payParams);

    // 급여 집계 변수 초기화 (합계 및 누적)
    $paySums = [$currentYear => 0, $previousYear => 0, $yearBeforePrevious => 0];
    $payCums = [$currentYear => 0, $previousYear => 0, $yearBeforePrevious => 0];
    
    // 누적 계산을 위한 기준 월 (문자열 비교용)
    $currentMonthStr = sprintf('%02d', $currentMonth); 

    if ($payResult) {
        while ($row = sqlsrv_fetch_array($payResult, SQLSRV_FETCH_ASSOC)) {
            $ym = $row['ym']; // 예: 202501
            $pay = (float)$row['TOTAL_PAY'];
            $year = substr($ym, 0, 4);
            $month = substr($ym, 4, 2);

            // $monthlyData에 병합
            if (!isset($monthlyData[$ym])) {
                $monthlyData[$ym] = [
                    'WATER' => 0, 'GAS' => 0, 'ELECTRICITY' => 0, 'PAY2' => 0, 'DELIVERY' => 0
                ];
            }
            $monthlyData[$ym]['PAY'] = $pay;

            // 년도별 합계 계산
            if (isset($paySums[$year])) {
                $paySums[$year] += $pay;
            }

            // 누적 합계 계산 (해당 월이 현재 월보다 작거나 같을 때)
            // 작년, 재작년도 동일하게 현재 월(currentMonth) 기준으로 누적을 구하는 로직 유지
            if ($month <= $currentMonthStr) {
                 if (isset($payCums[$year])) {
                    $payCums[$year] += $pay;
                }
            }
        }
    }

    // 3단계: 합계 및 누적 데이터 조회 (FEE 테이블 항목들)
    // PAY 컬럼은 제외하고 조회하거나, 조회 후 위에서 계산한 값으로 덮어씁니다.
    $sumQuery = "SELECT SUM(WATER) AS WATER, SUM(GAS) AS GAS, SUM(ELECTRICITY + ELECTRICITY2) AS ELECTRICITY, SUM(CONVERT(BIGINT, PAY2)) AS PAY2, SUM(CONVERT(BIGINT, DELIVERY)) AS DELIVERY FROM CONNECT.dbo.FEE";
    
    // [전체 합계]
    $sumThis = sqlsrv_fetch_array(sqlsrv_query($connect, "$sumQuery WHERE KIND LIKE ?", [(string)$currentYear . '%']), SQLSRV_FETCH_ASSOC);
    $sumLast = sqlsrv_fetch_array(sqlsrv_query($connect, "$sumQuery WHERE KIND LIKE ?", [(string)$previousYear . '%']), SQLSRV_FETCH_ASSOC);
    $sumBefore = sqlsrv_fetch_array(sqlsrv_query($connect, "$sumQuery WHERE KIND LIKE ?", [(string)$yearBeforePrevious . '%']), SQLSRV_FETCH_ASSOC);

    // [누적 합계] (현재 월 기준)
    $cumThis = sqlsrv_fetch_array(sqlsrv_query($connect, "$sumQuery WHERE KIND LIKE ? AND KIND <= ?", [(string)$currentYear . '%', (string)$currentYear . $currentMonthStr]), SQLSRV_FETCH_ASSOC);
    $cumLast = sqlsrv_fetch_array(sqlsrv_query($connect, "$sumQuery WHERE KIND LIKE ? AND KIND <= ?", [(string)$previousYear . '%', (string)$previousYear . $currentMonthStr]), SQLSRV_FETCH_ASSOC);
    $cumBefore = sqlsrv_fetch_array(sqlsrv_query($connect, "$sumQuery WHERE KIND LIKE ? AND KIND <= ?", [(string)$yearBeforePrevious . '%', (string)$yearBeforePrevious . $currentMonthStr]), SQLSRV_FETCH_ASSOC);

    // 3-1단계: [수정] 계산된 급여(PAY) 합계/누적 값을 배열에 주입
    $sumThis['PAY'] = $paySums[$currentYear];
    $sumLast['PAY'] = $paySums[$previousYear];
    $sumBefore['PAY'] = $paySums[$yearBeforePrevious];

    $cumThis['PAY'] = $payCums[$currentYear];
    $cumLast['PAY'] = $payCums[$previousYear];
    $cumBefore['PAY'] = $payCums[$yearBeforePrevious];

    // 4단계: 데이터 채우기 함수 (합계, 누적, 1~12월)
    if (!function_exists('fillCostArray')) {
        function fillCostArray($colName, $sumRow, $cumRow, $monthlyData, $year) {
            $arr = [];
            // 0: 년 합계
            $arr[] = $sumRow[$colName] ?? 0;
            // 1: 월 누적 합계
            $arr[] = $cumRow[$colName] ?? 0;
            
            // 2~13: 1월 ~ 12월 데이터
            for ($m = 1; $m <= 12; $m++) {
                $key = $year . sprintf('%02d', $m);
                // 위에서 trim()으로 공백을 제거했으므로 이제 정확히 매칭됩니다.
                $arr[] = $monthlyData[$key][$colName] ?? 0;
            }
            return $arr;
        }
    }

    // 5단계: 각 항목별 데이터 할당 (명시적 호출)
    // 수도
    $thisYearWaterChartData   = fillCostArray('WATER', $sumThis, $cumThis, $monthlyData, $currentYear);
    $lastYearWaterChartData   = fillCostArray('WATER', $sumLast, $cumLast, $monthlyData, $previousYear);
    $yearBeforeWaterChartData = fillCostArray('WATER', $sumBefore, $cumBefore, $monthlyData, $yearBeforePrevious);

    // 가스
    $thisYearGasChartData   = fillCostArray('GAS', $sumThis, $cumThis, $monthlyData, $currentYear);
    $lastYearGasChartData   = fillCostArray('GAS', $sumLast, $cumLast, $monthlyData, $previousYear);
    $yearBeforeGasChartData = fillCostArray('GAS', $sumBefore, $cumBefore, $monthlyData, $yearBeforePrevious);

    // 전기 (변수명: Elec)
    $thisYearElecChartData   = fillCostArray('ELECTRICITY', $sumThis, $cumThis, $monthlyData, $currentYear);
    $lastYearElecChartData   = fillCostArray('ELECTRICITY', $sumLast, $cumLast, $monthlyData, $previousYear);
    $yearBeforeElecChartData = fillCostArray('ELECTRICITY', $sumBefore, $cumBefore, $monthlyData, $yearBeforePrevious);

    // 사무직 급여 (Pay) - [수정됨: HR_PCALCPAY 데이터 사용]
    $thisYearPayChartData   = fillCostArray('PAY', $sumThis, $cumThis, $monthlyData, $currentYear);
    $lastYearPayChartData   = fillCostArray('PAY', $sumLast, $cumLast, $monthlyData, $previousYear);
    $yearBeforePayChartData = fillCostArray('PAY', $sumBefore, $cumBefore, $monthlyData, $yearBeforePrevious);

    // 도급비 (Pay2)
    $thisYearPay2ChartData   = fillCostArray('PAY2', $sumThis, $cumThis, $monthlyData, $currentYear);
    $lastYearPay2ChartData   = fillCostArray('PAY2', $sumLast, $cumLast, $monthlyData, $previousYear);
    $yearBeforePay2ChartData = fillCostArray('PAY2', $sumBefore, $cumBefore, $monthlyData, $yearBeforePrevious);

    // 운반비 (Deli)
    $thisYearDeliChartData   = fillCostArray('DELIVERY', $sumThis, $cumThis, $monthlyData, $currentYear);
    $lastYearDeliChartData   = fillCostArray('DELIVERY', $sumLast, $cumLast, $monthlyData, $previousYear);
    $yearBeforeDeliChartData = fillCostArray('DELIVERY', $sumBefore, $cumBefore, $monthlyData, $yearBeforePrevious);


    // -------------------------------------------------------------------------
    // 4. 표 데이터 (2023년 추가)
    // -------------------------------------------------------------------------
    $Data_ThisYearFee0 = $sumThis;
    $Data_ThisYearFee00 = $cumThis;
    
    $Data_LastYearFee0 = $sumLast;
    $Data_LastYearFee00 = $cumLast;
    
    $Data_YearBeforeFee0 = $sumBefore; // 2023년 합계
    $Data_YearBeforeFee00 = $cumBefore; // 2023년 누적

    for ($month = 1; $month <= 12; $month++) {
        $defaultRow = ['WATER' => 0, 'GAS' => 0, 'ELECTRICITY' => 0, 'PAY' => 0, 'PAY2' => 0, 'DELIVERY' => 0];
        
        $keyThis = $currentYear . sprintf('%02d', $month);
        $keyLast = $previousYear . sprintf('%02d', $month);
        $keyBefore = $yearBeforePrevious . sprintf('%02d', $month);

        ${'Data_ThisYearFee' . $month}   = $monthlyData[$keyThis] ?? $defaultRow;
        ${'Data_LastYearFee' . $month}   = $monthlyData[$keyLast] ?? $defaultRow;
        ${'Data_YearBeforeFee' . $month} = $monthlyData[$keyBefore] ?? $defaultRow;
    }

    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //회계
    // 1단계: 필요한 변수 및 데이터 구조 초기화
    // ★★★★★ (수정!) $years 배열을 여기서 생성해야 합니다. ★★★★★
    $years = [$currentYear, $previousYear, $currentYear - 2, $currentYear - 3];

    // ★ 조회할 계정 항목 목록 정의
    $accountNames = [
        '매출액', '매출원가', '판매비와관리비', '영업외이익(손실)',
        '당기순이익(손실)', '반기순이익(손실)', '분기순이익(손실)', '분기순이익'
    ];

    // ★ 최종 데이터를 담을 구조화된 배열
    $financialData = [];

    // 2단계: 단 한 번의 쿼리로 최근 4년치 모든 데이터 가져오기
    $financialsql = "
        WITH NormalizedData AS (
            -- 1. 먼저 계정명을 통일합니다.
            SELECT 
                *,
                CASE 
                    WHEN account_nm IN (?, ?, ?, ?) THEN N'당기순이익'
                    ELSE account_nm 
                END AS normalized_account_nm
            FROM 
                CONNECT.dbo.DART
            WHERE 
                yy IN (?, ?, ?, ?) AND account_nm IN (?, ?, ?, ?, ?, ?, ?, ?)
        ),
        RankedData AS (
            -- 2. 통일된 계정명으로 순위를 매깁니다.
            SELECT *,
                ROW_NUMBER() OVER(PARTITION BY yy, normalized_account_nm ORDER BY no DESC) as rn
            FROM NormalizedData
        )
        -- 3. 순위가 1인 데이터만 최종 선택합니다.
        SELECT * FROM RankedData 
        WHERE rn = 1
    ";

    // 파라미터 순서에 맞게 재구성
    $netIncomeNames = ['당기순이익(손실)', '반기순이익(손실)', '분기순이익(손실)', '분기순이익'];
    $financialparams = array_merge($netIncomeNames, $years, $accountNames);
    $financialstmt = sqlsrv_query($connect, $financialsql, $financialparams);

    if ($financialstmt) {
        while ($row = sqlsrv_fetch_array($financialstmt, SQLSRV_FETCH_ASSOC)) {
            $year = $row['yy'];
            $accountName = $row['normalized_account_nm'];
            $financialData[$year][$accountName] = $row;
        }
    } else {
        // 쿼리 실패 시 에러 출력 (디버깅용)
        die(print_r(sqlsrv_errors(), true));
    }

    // ★★★★★ (추가!) 재무 항목 비교 바 차트용 데이터 생성 ★★★★★
    // 1. 프론트엔드 차트의 라벨 순서와 정확히 일치하는 배열을 정의합니다.
    $financeAccountOrder = ['매출액', '매출원가', '판매비와관리비', '영업외이익(손실)', '당기순이익'];

    // 2. 각 연도의 데이터를 담을 빈 배열들을 생성합니다.
    $financeDataCurrentYear = [];
    $financeDataPreviousYear = [];
    $financeDataMinus2Year = [];
    $financeDataMinus3Year = [];

    // 3. 정의된 순서대로 각 항목의 데이터를 추출하여 배열에 추가합니다.
    foreach ($financeAccountOrder as $accountName) {
        // $financialData 배열에서 해당 연도, 해당 계정의 'thstrm_amount' 값을 가져옵니다.
        // 데이터가 없으면 안전하게 0을 사용합니다.
        $financeDataCurrentYear[]  = $financialData[$currentYear][$accountName]['thstrm_amount'] ?? 0;
        $financeDataPreviousYear[] = $financialData[$previousYear][$accountName]['thstrm_amount'] ?? 0;
        $financeDataMinus2Year[]   = $financialData[$currentYear - 2][$accountName]['thstrm_amount'] ?? 0;
        $financeDataMinus3Year[]   = $financialData[$currentYear - 3][$accountName]['thstrm_amount'] ?? 0;
    }


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //물류
    // 1. 최종 데이터를 담을 배열 초기화
    $data_in_transit = []; // 운송중 데이터
    $data_completed = [];  // 운송완료 데이터

    // 2. [JOIN]을 사용하여 DISTRIBUTION과 VESSEL 테이블을 한 번에 조회하고,
    //    [CASE] 문으로 운송 상태를 구분하는 최적화된 쿼리
    $sql = "
        SELECT 
            d.*, 
            v.imo
        FROM 
            CONNECT.dbo.DISTRIBUTION d
        LEFT JOIN 
            CONNECT.dbo.VESSEL v ON d.vessel = v.name
        WHERE
            d.SORTING_DATE = ?
            AND (
                d.complete_dt IS NULL -- '운송중' 조건
                OR
                (d.complete_dt IS NOT NULL AND d.update_dt >= ?) -- '운송완료' 조건
            )
        ORDER BY 
            d.s_country, d.e_country, d.invoice_dt
    ";

    // 3. 파라미터 바인딩
    $params = [$NoHyphen_today, $Minus3Month];
    $stmt = sqlsrv_query($connect, $sql, $params);

    // 4. 결과를 '운송중'과 '운송완료'로 분리하여 각 배열에 저장
    if ($stmt) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['complete_dt'] === null) {
                $data_in_transit[] = $row; // complete_dt가 없으면 '운송중' 배열에 추가
            } else {
                $data_completed[] = $row;  // complete_dt가 있으면 '운송완료' 배열에 추가
            }
        }
    }


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //매출
    // 1단계: 최신 판매일자 조회 (DB 조회 1/3)
    $sale_dt = $Hyphen_today; // 오늘 날짜를 기본값으로 설정

    // ★ 오늘 날짜에 데이터가 있는지 확인하는 쿼리
    $sql_check = "SELECT 1 FROM CONNECT.dbo.SALES WHERE SORTING_DATE = ?";
    $stmt_check = sqlsrv_query($connect, $sql_check, [$Hyphen_today]);
    $has_today_sales = sqlsrv_has_rows($stmt_check);

    // ★ 오늘 데이터가 없으면, 가장 최근 날짜를 조회
    if (!$has_today_sales) {
        $sql_latest_date = "SELECT TOP 1 SORTING_DATE FROM CONNECT.dbo.SALES ORDER BY SORTING_DATE DESC";
        $stmt_latest_date = sqlsrv_query($connect, $sql_latest_date);
        if ($row = sqlsrv_fetch_array($stmt_latest_date)) {
            $sale_dt = $row['SORTING_DATE']->format('Y-m-d');
        }
    }

    // 2단계: 필요한 모든 데이터를 구조화된 배열에 저장
    // ★ 최종 데이터를 담을 구조화된 배열들
    $latestSalesByKind = [];   // 최신일자 항목별 매출
    $annualSalesTotals = [];   // 연도별 '합계' 매출
    $monthlySalesByKind = [];  // 올해 월별/항목별 매출

    // ★ 조회할 항목 목록
    $kinds = ['히터', '발열핸들(열선)', '통풍(이원컴포텍)', '통풍', '통합ECU', '일반ECU', '기타', '합계'];

    // A. 최신일자 & 월별 항목 매출 데이터 조회 (DB 조회 2/3)
    $query_monthly = "
        WITH RankedSales AS (
            SELECT *, ROW_NUMBER() OVER(PARTITION BY KIND, FORMAT(SORTING_DATE, 'yyyy-MM') ORDER BY SORTING_DATE DESC) as rn
            FROM CONNECT.dbo.SALES
            WHERE SORTING_DATE LIKE ? OR SORTING_DATE = ?
        )
        SELECT * FROM RankedSales WHERE rn = 1
    ";
    $params_monthly = [$currentYear . '%', $sale_dt];
    $stmt_monthly = sqlsrv_query($connect, $query_monthly, $params_monthly);

    if ($stmt_monthly) {
        while ($row = sqlsrv_fetch_array($stmt_monthly, SQLSRV_FETCH_ASSOC)) {
            $kind = $row['KIND'];
            $row_date = $row['SORTING_DATE']->format('Y-m-d');
            $year_month = $row['SORTING_DATE']->format('Y-m');

            // 1. 최신일자 데이터 저장
            if ($row_date === $sale_dt) {
                $latestSalesByKind[$kind] = $row;
            }
            // 2. 올해 월별 데이터 저장
            if (strpos($year_month, $currentYear) === 0) {
                $monthlySalesByKind[$kind][$year_month] = $row;
            }
        }
    }

    // B. 과거 4개년 '합계' 매출 데이터 조회 (DB 조회 3/3)
    $four_years_ago = ($currentYear - 3) . '-01-01';
    $query_annual = "
        WITH RankedAnnual AS (
            SELECT *, ROW_NUMBER() OVER(PARTITION BY FORMAT(SORTING_DATE, 'yyyy') ORDER BY SORTING_DATE DESC) as rn
            FROM CONNECT.dbo.SALES
            WHERE KIND = ? AND SORTING_DATE >= ?
        )
        SELECT * FROM RankedAnnual WHERE rn = 1
    ";
    $params_annual = ['합계', $four_years_ago];
    $stmt_annual = sqlsrv_query($connect, $query_annual, $params_annual);

    if ($stmt_annual) {
        while ($row = sqlsrv_fetch_array($stmt_annual, SQLSRV_FETCH_ASSOC)) {
            $year = $row['SORTING_DATE']->format('Y');
            $annualSalesTotals[$year] = $row;
        }
    }

    // 3단계: 프론트엔드 차트용 단순 배열 생성
    $chartData = [];
    $kindMap = [
        '히터' => 'heater',
        '발열핸들(열선)' => 'handle',
        '통풍(이원컴포텍)' => 'iwon',
        '통풍' => 'vent',
        '통합ECU' => 'integratedEcu',
        '일반ECU' => 'generalEcu',
        '기타' => 'etc'
    ];

    // 프론트엔드의 복잡한 IF문을 처리하기 위한 조건 변수
    $isCurrentYearSalesHigher = ($annualSalesTotals[$currentYear]['Y_MONEY'] ?? 0) >= ($annualSalesTotals[$previousYear]['Y_MONEY'] ?? 0);

    // ★ (수정!) $kindMap을 사용하여 반복문 실행
    foreach ($kindMap as $kind => $alias) {
        // 예: 'heaterChartData', 'handleChartData' ...
        $varName = $alias . 'ChartData'; 
        $tempArray = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $monthStr = sprintf('%02d', $month);
            $key = "$currentYear-$monthStr";
            
            $value = $monthlySalesByKind[$kind][$key]['Y_MONEY'] ?? 0;

            // 프론트엔드의 1월 데이터 특별 조건 처리
            if ($month === 1 && $isCurrentYearSalesHigher && $kind !== '히터') {
                $value = 0;
            }
            
            $tempArray[] = $value;
        }
        // 최종 차트 데이터 배열에 영문 키로 할당
        $chartData[$varName] = $tempArray;
    }

    // ★★★★★ (추가!) 도넛 차트용 퍼센트(%) 데이터 생성 ★★★★★
    // 1. 차트 라벨 순서와 동일하게 항목 목록을 정의합니다.
    $donutChartKinds = ['히터', '발열핸들(열선)', '통풍(이원컴포텍)', '통풍', '통합ECU', '일반ECU', '기타'];

    // 2. 최종 퍼센트 데이터를 담을 빈 배열을 생성합니다.
    $donutChartPercentages = [];

    // 3. 전체 합계 금액을 가져옵니다. (0으로 나누는 오류 방지)
    $totalSales = $latestSalesByKind['합계']['Y_MONEY'] ?? 0;

    // 4. 합계가 0보다 클 때만 퍼센트를 계산합니다.
    if ($totalSales > 0) {
        // 항목 목록을 순회하며 각 항목의 비율을 계산합니다.
        foreach ($donutChartKinds as $kind) {
            // 해당 항목의 매출액을 가져옵니다. (없으면 0)
            $itemSales = $latestSalesByKind[$kind]['Y_MONEY'] ?? 0;
            
            // (항목 매출액 * 100 / 전체 합계) 공식을 사용하여 퍼센트 계산 후 배열에 추가
            $percentage = round(($itemSales * 100) / $totalSales, 2);
            $donutChartPercentages[] = $percentage;
        }
    } else {
        // 합계가 0이면 모든 항목의 비율을 0으로 채웁니다.
        $donutChartPercentages = array_fill(0, count($donutChartKinds), 0);
    }
    
    // ★★★★★ (추가!) 연간 매출 라인 차트용 데이터 생성 ★★★★★
    // 1. 라인 차트용 라벨 및 데이터 배열을 초기화합니다.
    $lineChartLabels = [];
    $lineChartValues = [];

    // 2. 최근 4개년을 순회하며($currentYear 포함) 데이터를 추출합니다.
    for ($i = 3; $i >= 0; $i--) {
        $year = $currentYear - $i;
        
        // 라벨 배열에 '2022년', '2023년' 등을 추가합니다.
        $lineChartLabels[] = $year . '년';
        
        // $annualSalesTotals 배열에서 해당 연도의 'Y_MONEY' 값을 가져옵니다.
        // 데이터가 없으면 안전하게 0을 사용합니다.
        $lineChartValues[] = $annualSalesTotals[$year]['Y_MONEY'] ?? 0;
    }

    
    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //품질  
    // 최종 데이터를 담을 구조화된 배열들
    $qcData = [];     // 상세 항목 데이터
    $graphData = [];  // 그래프용 집계 데이터

    try {
        // 1. 조회 기준 날짜 결정 (수정 없음)
        $dates = [];
        $sql_check_today = "SELECT 1 FROM CONNECT.dbo.QC WHERE SORTING_DATE = ?";
        $stmt_check_today = sqlsrv_query($connect, $sql_check_today, [$Hyphen_today]);
        if (sqlsrv_fetch($stmt_check_today)) {
            $dates[$currentYear] = $Hyphen_today;
        } else {
            $sql_latest_current_year = "SELECT TOP 1 SORTING_DATE FROM CONNECT.dbo.QC WHERE YY = ? ORDER BY SORTING_DATE DESC";
            $stmt_latest_current_year = sqlsrv_query($connect, $sql_latest_current_year, [$currentYear]);
            $row = sqlsrv_fetch_array($stmt_latest_current_year);
            $dates[$currentYear] = $row ? $row['SORTING_DATE']->format('Y-m-d') : null;
        }
        $sql_latest_agg_year = "SELECT TOP 1 SORTING_DATE FROM CONNECT.dbo.QC WHERE YY = ? AND MM = '13' ORDER BY SORTING_DATE DESC";
        $stmt_minus1 = sqlsrv_query($connect, $sql_latest_agg_year, [$previousYear]);
        $row_minus1 = sqlsrv_fetch_array($stmt_minus1);
        $dates[$previousYear] = $row_minus1 ? $row_minus1['SORTING_DATE']->format('Y-m-d') : null;
        $stmt_minus2 = sqlsrv_query($connect, $sql_latest_agg_year, [$yearBeforePrevious]);
        $row_minus2 = sqlsrv_fetch_array($stmt_minus2);
        $dates[$yearBeforePrevious] = $row_minus2 ? $row_minus2['SORTING_DATE']->format('Y-m-d') : null;

        // 2. 모든 상세 항목 데이터 가져오기 (수정 없음)
        $qcData = [];
        if (!empty($dates[$currentYear])) {
            $sql_main = "SELECT * FROM CONNECT.dbo.QC WHERE SORTING_DATE = ? AND KIND IN ('시트히터', '핸들', '통풍') ORDER BY NO";
            $main_results = sqlsrv_query($connect, $sql_main, [$dates[$currentYear]]);
            while ($row = sqlsrv_fetch_array($main_results, SQLSRV_FETCH_ASSOC)) {
                $qcData[$row['KIND']][$row['KIND2']][] = $row;
            }
        }

        // 3. 모든 그래프 데이터 가져오기 (수정 없음)
        $graphData = [];
        $sql_graph = "SELECT YY, KIND, SUM(M_MONEY) AS TOTAL_MONEY FROM CONNECT.dbo.QC WHERE MM = '13' AND KIND IN ('시트히터', '핸들', '통풍') AND ((YY = ? AND SORTING_DATE = ?) OR (YY = ? AND SORTING_DATE = ?) OR (YY = ? AND SORTING_DATE = ?)) GROUP BY YY, KIND";
        $params_graph = [$currentYear, $dates[$currentYear], $previousYear, $dates[$previousYear], $yearBeforePrevious, $dates[$yearBeforePrevious]];
        $graph_results = sqlsrv_query($connect, $sql_graph, $params_graph);
        while ($row = sqlsrv_fetch_array($graph_results, SQLSRV_FETCH_ASSOC)) {
            $graphData[$row['YY']][$row['KIND']] = $row['TOTAL_MONEY'];
        }

        // ★★★★★ (추가 수정) 금년 데이터만 월별 합산으로 덮어쓰기 ★★★★★
        $sql_current_year_sum = "SELECT KIND, SUM(CONVERT(bigint, M_MONEY)) AS TOTAL_MONEY FROM CONNECT.dbo.QC WHERE YY = ? AND MM <> '13' AND KIND IN ('시트히터', '핸들', '통풍') GROUP BY KIND";
        $params_current_year_sum = [$currentYear];
        $result_current_year_sum = sqlsrv_query($connect, $sql_current_year_sum, $params_current_year_sum);
        if ($result_current_year_sum) {
            while($row_sum = sqlsrv_fetch_array($result_current_year_sum, SQLSRV_FETCH_ASSOC)) {
                $graphData[$currentYear][$row_sum['KIND']] = $row_sum['TOTAL_MONEY'];
            }
        }
        // ★★★★★ 수정 끝 ★★★★★

        // 4. $qcData를 월별 데이터($monthlyData)로 가공
        // 먼저 모든 카테고리에 대한 배열 구조를 0으로 생성하여 데이터 유무와 상관없이 항상 동일한 구조를 유지합니다.
        $monthlyData = [
            '시트히터' => [
                '한국폐기 본사 스티칭' => array_fill(1, 13, 0), '한국폐기 본사 최종검사' => array_fill(1, 13, 0), '한국폐기 협력사귀책' => array_fill(1, 13, 0),
                '한국리워크 본사' => array_fill(1, 13, 0), '한국리워크 BB베트남' => array_fill(1, 13, 0), '베트남 폐기' => array_fill(1, 13, 0),
                '중국 폐기' => array_fill(1, 13, 0), '미국 폐기' => array_fill(1, 13, 0), '슬로박 폐기' => array_fill(1, 13, 0)
            ],
            '핸들' => [
                '한국폐기 본사' => array_fill(1, 13, 0), '한국폐기 협력사귀책' => array_fill(1, 13, 0), '한국폐기 BB베트남' => array_fill(1, 13, 0),
                '한국리워크 본사' => array_fill(1, 13, 0), '한국리워크 BB베트남' => array_fill(1, 13, 0), '베트남 폐기' => array_fill(1, 13, 0)
            ],
            '통풍' => [
                '한국폐기 본사' => array_fill(1, 13, 0), '한국폐기 협력사귀책' => array_fill(1, 13, 0)
            ]
        ];

        // $qcData에 있는 실제 데이터를 월별로 합산합니다.
        if (!empty($qcData)) {
            foreach ($qcData as $kind => $subKindData) {
                foreach ($subKindData as $kind2 => $records) {
                    if (isset($monthlyData[$kind][$kind2])) { // 미리 정의된 구조에 해당하는 데이터만 처리
                        foreach ($records as $record) {
                            $month = (int)$record['MM'];
                            $money = (float)$record['M_MONEY'];
                            if ($month >= 1 && $month <= 12) {
                                $monthlyData[$kind][$kind2][$month] += $money;
                            }
                        }
                    }
                }
            }
        }

        // 각 항목의 합계(13번째 값)를 계산합니다.
        foreach ($monthlyData as $kind => &$subKinds) {
            foreach ($subKinds as $kind2 => &$months) {
                $total = 0;
                for ($m = 1; $m <= 12; $m++) {
                    $total += $months[$m];
                }
                $months[13] = $total; // 13번째 인덱스에 합계 저장
            }
        }
        unset($subKinds, $months); // 참조 해제

        // 5. barChart7을 위한 데이터 가공 (수정 없음)
        $currentYearHeater = $graphData[$currentYear]['시트히터'] ?? 0;
        $currentYearHandle = $graphData[$currentYear]['핸들'] ?? 0;
        $currentYearVent = $graphData[$currentYear]['통풍'] ?? 0;
        $previousYearHeater = $graphData[$previousYear]['시트히터'] ?? 0;
        $currentYearTotal = $currentYearHeater + $currentYearHandle + $currentYearVent;
        $barChart7Data = [
            'labels' => ['합계', '시트히터', '발열핸들', '통풍시트'],
            'datasets' => [
                ['label' => $currentYear . '년', 'backgroundColor' => 'rgba(40,192,141,1)', 'borderColor' => 'rgba(40,192,141,1)', 'data' => [$currentYearTotal, $currentYearHeater, $currentYearHandle, $currentYearVent]],
                ['label' => $previousYear . '년', 'backgroundColor' => 'rgba(210, 214, 222, 1)', 'borderColor' => 'rgba(210, 214, 222, 1)', 'data' => [($graphData[$previousYear]['시트히터']??0)+($graphData[$previousYear]['핸들']??0)+($graphData[$previousYear]['통풍']??0), $graphData[$previousYear]['시트히터']??0, $graphData[$previousYear]['핸들']??0, $graphData[$previousYear]['통풍']??0]],
                ['label' => $yearBeforePrevious . '년', 'backgroundColor' => 'rgba(175, 183, 197, 1)', 'borderColor' => 'rgba(175, 183, 197, 1)', 'data' => [($graphData[$yearBeforePrevious]['시트히터']??0)+($graphData[$yearBeforePrevious]['핸들']??0)+($graphData[$yearBeforePrevious]['통풍']??0), $graphData[$yearBeforePrevious]['시트히터']??0, $graphData[$yearBeforePrevious]['핸들']??0, $graphData[$yearBeforePrevious]['통풍']??0]]
            ]
        ];

        // 6. 프론트엔드 JavaScript에서 사용할 변수 추출 (수정 없음)
        $currentYearJson    = json_encode($barChart7Data['datasets'][0]['data']);
        $previousYearJson   = json_encode($barChart7Data['datasets'][1]['data']);
        $yearBeforeJson     = json_encode($barChart7Data['datasets'][2]['data']);

    } catch (Throwable $e) {
        error_log("QC Data Fetch Error: " . $e->getMessage());
        // 에러 발생 시 프론트엔드 변수가 정의되지 않는 것을 방지하기 위해 빈 값으로 초기화
        $qcData = [];
        $monthlyData = [];
        $graphData = [];
        $currentYearJson = '[]';
        $previousYearJson = '[]';
        $yearBeforeJson = '[]';
    }


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //수주
    $develop_dt = null; // 최종 사용할 날짜 변수 초기화

    try {
        // 1. 오늘 날짜의 데이터가 있는지 먼저 확인 (효율적인 쿼리 사용)
        $sql_check = "SELECT SORTING_DATE FROM CONNECT.dbo.DEVELOP WHERE SORTING_DATE = ?";
        $params_check = [$Hyphen_today];
        $result_check = sqlsrv_query($connect, $sql_check, $params_check);
        
        // 쿼리 실행 여부 확인
        if ($result_check === false) {
            throw new Exception(sqlsrv_errors()[0]['message']);
        }

        $row_check = sqlsrv_fetch_array($result_check);

        if ($row_check) {
            // 오늘 날짜 데이터가 있으면 해당 날짜 사용
            $develop_dt = $Hyphen_today;
        } else {
            // 오늘 날짜 데이터가 없으면, 가장 최신 데이터의 날짜를 조회
            $sql_latest = "SELECT TOP 1 SORTING_DATE FROM CONNECT.dbo.DEVELOP ORDER BY SORTING_DATE DESC";
            $result_latest = sqlsrv_query($connect, $sql_latest);
            
            if ($result_latest === false) {
                throw new Exception(sqlsrv_errors()[0]['message']);
            }

            $row_latest = sqlsrv_fetch_array($result_latest);

            // 최신 데이터가 존재하는지 확인 (빈 테이블 오류 방지)
            if ($row_latest && $row_latest['SORTING_DATE']) {
                // sqlsrv 드라이버는 datetime 필드를 DateTime 객체로 반환
                $develop_dt = $row_latest['SORTING_DATE']->format("Y-m-d");
            }
        }
        
        // 최종적으로 조회할 날짜가 확정되었는지 확인
        if ($develop_dt) {
            // 2. 확정된 날짜($develop_dt)를 사용하여 안전하게 데이터 조회
            $Query_DEVELOP1 = "SELECT * FROM CONNECT.dbo.DEVELOP WHERE SORTING_DATE = ? ORDER BY NO";
            $params_final = [$develop_dt];
            $Result_DEVELOP1 = sqlsrv_query($connect, $Query_DEVELOP1, $params_final);

            if ($Result_DEVELOP1 === false) {
                throw new Exception(sqlsrv_errors()[0]['message']);
            }
            
            // 이제 $Result_DEVELOP1 으로 데이터를 처리...
            // while($row = sqlsrv_fetch_array($Result_DEVELOP1, SQLSRV_FETCH_ASSOC)) {
            //     // ...
            // }

        } else {
            // 조회할 데이터가 전혀 없는 경우
            echo "조회할 개발 일정이 없습니다.";
        }

    } catch (Throwable $e) {
        error_log("개발일정 조회 오류: " . $e->getMessage());
    }
    
  
    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //베트남 인원

    // --- 1. 기본 데이터 구조 생성 ---
    // 데이터가 없을 경우 사용될 기본 빈 행(row) 구조를 정의합니다.
    $defaultRow = [
        'night_iwin' => 0, 'night_part' => 0, 'morning_iwin' => 0,
        'morning_part' => 0, 'morning_office' => 0, 'morning_etc' => 0,
        'vacation_baby' => 0,
    ];

    // 1월부터 12월까지 기본 행으로 채워진 배열을 미리 생성합니다.
    $thisYearVietnamTotals = array_fill(1, 12, $defaultRow);
    $lastYearVietnamTotals = array_fill(1, 12, $defaultRow);

    // --- 2. DB에서 실제 데이터 가져오기 ---
    // DB에서 가져온 실제 데이터를 임시로 담을 배열
    $thisYearData = [];
    $lastYearData = [];

    // 금년과 작년 데이터를 한 번에 가져오는 최적화된 쿼리
    $query = "
        WITH MonthlyData AS (
            SELECT *, ROW_NUMBER() OVER(PARTITION BY SUBSTRING(excel_title, 1, 6) ORDER BY excel_title DESC) as rn
            FROM CONNECT.dbo.VIETNAM_ATTEND
            WHERE excel_title LIKE ? OR excel_title LIKE ?
        )
        SELECT * FROM MonthlyData WHERE rn = 1
    ";

    // 파라미터 바인딩
    $params = [$currentYear . '%', $previousYear . '%'];
    $options = ["Scrollable" => SQLSRV_CURSOR_KEYSET]; // 필요에 따라 옵션 조정
    $stmt = sqlsrv_query($connect, $query, $params, $options);

    if ($stmt !== false) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $year = (int)substr($row['excel_title'], 0, 4);
            $month = (int)substr($row['excel_title'], 4, 2);
            
            if ($year == $currentYear) {
                $dbDataThisYear[$month] = $row;
            } elseif ($year == $previousYear) {
                $dbDataLastYear[$month] = $row;
            }
        }
    }

    // --- 3. 기본 데이터에 실제 데이터 덮어쓰기 (가공) ---
    // array_replace 함수는 $thisYearData의 기본값을 $dbDataThisYear의 실제 값으로 교체합니다.
    // $dbDataThisYear에 데이터가 없는 월은 $thisYearData의 기본값이 그대로 유지됩니다.
    $thisYearData = array_replace($thisYearData, $dbDataThisYear);
    $lastYearData = array_replace($lastYearData, $dbDataLastYear);

    // --- 4. (그래프용) 합계 데이터 계산 ---
    // 이제 완성된 $thisYearData를 기반으로 합계 데이터를 계산합니다.
    $thisYearVietnamTotals = array_fill(1, 12, 0);
    $lastYearVietnamTotals = array_fill(1, 12, 0);
    $sum_keys = ['night_iwin', 'night_part', 'morning_iwin', 'morning_part', 'morning_office', 'morning_etc', 'vacation_baby'];

    for ($month = 1; $month <= 12; $month++) {
        foreach ($sum_keys as $key) {
            $thisYearVietnamTotals[$month] += $thisYearData[$month][$key] ?? 0;
            $lastYearVietnamTotals[$month] += $lastYearData[$month][$key] ?? 0;
        }
    }