<?php   
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.11.6>23
	// Description:	<esg 이산화탄소 배출량>		
	// =============================================
    
    //★DB연결 및 함수사용    
    include '../DB/DB2.php';
    include '../DB/DB4.php'; 
    include '../FUNCTION.php';

    //★탭활성화
    $tab_sequence=4; 
    include '../TAB.php';  


    //★ 변수 및 데이터 구조 초기화   
    $currentYear = date('Y');
    $currentMonth = date('m');
    $currentMonthInt = date('n');
    $previousYear = $currentYear - 1;
    $twoYearsAgo = $currentYear - 2;
    $threeYearsAgo = $currentYear - 3;    
    $Minus1YY = $previousYear;
    $Minus2YY = $twoYearsAgo;
    $Post_dt3 = $_POST["dt3"] ?? null;
    $s_dt3 = HyphenRemove(substr($Post_dt3 ?? '', 0, 10));
	$e_dt3 = HyphenRemove(substr($Post_dt3 ?? '', 13, 10));
    $bt31 = $_POST["bt31"] ?? null; 


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //이동연소
    $oilTypes = ['휘발유', '경유', 'LPG'];
    $year_map = [
        'thisYear' => $currentYear,
        'oneYearAgo' => $previousYear,
        'twoYearsAgo' => $twoYearsAgo,
        'threeYearsAgo' => $threeYearsAgo
    ];

    foreach ($year_map as $key => $year) {
        
        $monthlySumVarName = "{$key}monthlyOilSum";
        $totalSumVarName = "{$key}monthlyOilSumTotal";

        $$monthlySumVarName = [];
        $$totalSumVarName = [];
        foreach ($oilTypes as $oil) {
            $$monthlySumVarName[$oil] = array_fill(1, 12, 0);
            $$totalSumVarName[$oil] = 0;
        }

        for ($month = 1; $month <= 12; $month++) {
            $firstDay = date('Y-m-01', strtotime("$year-$month-01"));
            $lastDay = date('Y-m-t', strtotime("$year-$month-01"));
            $firstDayYYMM = date("Y-m", strtotime($firstDay));

            foreach ($oilTypes as $oilType) {
                
                // --- 법인차량 주행거리 계산 ---
                $query_corp = "SELECT SUM(운행거리) AS km FROM ( SELECT ( (SELECT end_km FROM car_current WHERE car_nm = cc.car_nm AND DATE_FORMAT(search_date, '%Y-%m') = '$firstDayYYMM' AND end_km != 'NULL' ORDER BY search_date DESC LIMIT 1) - (SELECT start_km FROM car_current WHERE car_nm = cc.car_nm AND DATE_FORMAT(search_date, '%Y-%m') = '$firstDayYYMM' ORDER BY search_date ASC LIMIT 1) ) AS 운행거리, ci.fuel FROM car_current cc JOIN car_info ci ON cc.car_nm = ci.car_nm WHERE DATE_FORMAT(cc.search_date, '%Y-%m') = '$firstDayYYMM' UNION SELECT ( (SELECT end_km FROM car_current2 WHERE car_nm = cc2.car_nm AND DATE_FORMAT(search_date, '%Y-%m') = '$firstDayYYMM' ORDER BY search_date DESC LIMIT 1) - (SELECT start_km FROM car_current2 WHERE car_nm = cc2.car_nm AND DATE_FORMAT(search_date, '%Y-%m') = '$firstDayYYMM' ORDER BY search_date ASC LIMIT 1) ) AS 운행거리, ci.fuel FROM car_current2 cc2 JOIN car_info ci ON cc2.car_nm = ci.car_nm WHERE DATE_FORMAT(cc2.search_date, '%Y-%m') = '$firstDayYYMM' ) AS 운행거리_서브쿼리 where fuel = '$oilType' GROUP BY fuel;";
                $result_corp = $connect4->query($query_corp);
                $data_corp = mysqli_fetch_object($result_corp);
                $corp_km = isset($data_corp->km) ? $data_corp->km : 0;

                // --- 개인차량 사용량 계산 ---
                $query_personal = "SELECT SUM(GIVE_OIL) AS GIVE_OIL FROM user_car WHERE CAR_OIL = '$oilType' AND SEARCH_DATE BETWEEN '$firstDay' AND '$lastDay'";
                $result_personal = $connect4->query($query_personal);
                $data_personal = mysqli_fetch_object($result_personal);
                $personal_usage = isset($data_personal->GIVE_OIL) ? $data_personal->GIVE_OIL : 0;

                // --- 사용량 합산 및 저장 ---
                $total_usage = $personal_usage + ($corp_km / 10);

                // 고정값을 더해도 되는지 확인
                $addFixedValue = true; // 기본값은 '더함'

                // 1. 현재 연도('thisYear') 루프를 돌고 있고
                // 2. 루프의 월($month)이 실제 현재 월($currentMonthInt)보다 큰 경우 (즉, 미래의 월)
                if ($key === 'thisYear' && $month > $currentMonthInt) {
                    $addFixedValue = false; // 고정값을 더하지 않음
                }
                
                // 사용자 요청: 고정값 추가 (조건부 실행)
                if ($addFixedValue) {
                    if ($oilType === '휘발유') {
                        $total_usage += 555.83;
                    }
                    if ($oilType === '경유') {
                        $total_usage += 1200;
                    }
                }

                ${$monthlySumVarName}[$oilType][$month] = $total_usage;
                ${$totalSumVarName}[$oilType] += $total_usage;
            }
        }
    }

    // ★★★★★ CO2 환산 로직 ★★★★★
    $oilCo2Factors = [
        '휘발유' => (30.4 * 69300) / 1000000000,
        '경유' => (35.2 * 74100) / 1000000000,
        'LPG' => (45.7 * 63100) / 1000000000,
    ];

    foreach ($year_map as $key => $year) {
        $monthlySumVarName = "{$key}monthlyOilSum"; // e.g., thisYearmonthlyOilSum
        
        // Frontend에서 사용하는 변수명에 맞게 수정 (e.g., thisYearmonthlyOilCO2)
        $co2MonthlyVarName = "{$key}monthlyOilCO2";
        $co2TotalVarName = "{$key}monthlyOilCO2Total";

        // 변수 초기화 (e.g., $thisYearmonthlyOilCO2 = ['휘발유' => [0,0...], '경유' => [0,0...]])
        $$co2MonthlyVarName = [];
        $$co2TotalVarName = [];
        foreach ($oilTypes as $oil) {
            $$co2MonthlyVarName[$oil] = array_fill(1, 12, 0);
            $$co2TotalVarName[$oil] = 0;
        }

        // 월별, 유종별 CO2 계산
        for ($month = 1; $month <= 12; $month++) {
            foreach ($oilTypes as $oil) {
                $usage = ${$monthlySumVarName}[$oil][$month];
                $co2 = $usage * $oilCo2Factors[$oil];
                
                // 월별 CO2 배출량 저장
                ${$co2MonthlyVarName}[$oil][$month] = $co2;
                
                // 유종별 연간 총합에 더하기
                ${$co2TotalVarName}[$oil] += $co2;
            }
        }
    }

    // 기존 OilCO2Data 변수들 (다른 곳에서 사용할 경우 대비하여 유지)
    foreach ($year_map as $key => $year) {
        $co2MonthlyVarName = "{$key}monthlyOilCO2"; // e.g., thisYearmonthlyOilCO2
        $co2VarName = "{$key}OilCO2"; // e.g., thisYearOilCO2
        $co2SumVarName = "{$key}OilCO2Sum"; // e.g., thisYearOilCO2Sum

        $$co2VarName = array_fill(1, 12, 0);
        $$co2SumVarName = 0;
        
        for ($month = 1; $month <= 12; $month++) {
            foreach ($oilTypes as $oil) {
                ${$co2VarName}[$month] += ${$co2MonthlyVarName}[$oil][$month];
            }
        }
        $$co2SumVarName = array_sum($$co2VarName);
    }
    
    $thisYearOilCO2Data = [$thisYearOilCO2Sum ?? 0];
    for ($i = 1; $i <= 12; $i++) $thisYearOilCO2Data[] = $thisYearOilCO2[$i] ?? 0;

    $oneYearAgoOilCO2Data = [$oneYearAgoOilCO2Sum ?? 0];
    for ($i = 1; $i <= 12; $i++) $oneYearAgoOilCO2Data[] = $oneYearAgoOilCO2[$i] ?? 0;

    $twoYearsAgoOilCO2Data = [$twoYearsAgoOilCO2Sum ?? 0];
    for ($i = 1; $i <= 12; $i++) $twoYearsAgoOilCO2Data[] = $twoYearsAgoOilCO2[$i] ?? 0;

    $threeYearsAgoOilCO2Data = [$threeYearsAgoOilCO2Sum ?? 0];
    for ($i = 1; $i <= 12; $i++) $threeYearsAgoOilCO2Data[] = $threeYearsAgoOilCO2[$i] ?? 0;

    $targetOilCO2Data = [($oneYearAgoOilCO2Sum ?? 0) * 0.97];
    for ($i = 1; $i <= 12; $i++) $targetOilCO2Data[] = ($oneYearAgoOilCO2[$i] ?? 0) * 0.97;


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //수도,가스,전기 사용량
    $usageDataTypes = ['WaterIwin', 'WaterMalle', 'Gas', 'Electricity'];
    $years = [$currentYear, $previousYear, $twoYearsAgo, $threeYearsAgo];
    $prefixes = ['thisYear', 'lastYear', 'twoYearsAgo', 'threeYearsAgo'];

    foreach ($prefixes as $prefix) {
        foreach ($usageDataTypes as $type) {
            $varName = $prefix . $type . 'UsageData';
            $$varName = array_fill(0, 12, 0); // 12개월치 데이터를 0으로 채운 배열 생성
        }
    }

    // 2단계: [가스/수도] - 누적 검침량 데이터 한 번에 가져오기
    $cumulativeReadings = [];
    $startYearForQuery = $threeYearsAgo - 1; // 2021년
    $queryMeter = "
        WITH RankedData AS (
            SELECT 
                SORTING_DATE, WATER_IWIN, WATER_MALLE, GAS,
                ROW_NUMBER() OVER(PARTITION BY FORMAT(SORTING_DATE, 'yyyy-MM') ORDER BY SORTING_DATE DESC) as rn
            FROM CONNECT.dbo.READ_METER
            WHERE FORMAT(SORTING_DATE, 'yyyy') >= ? AND GAS IS NOT NULL
        )
        SELECT SORTING_DATE, ISNULL(WATER_IWIN, 0) AS WATER_IWIN, ISNULL(WATER_MALLE, 0) AS WATER_MALLE, ISNULL(GAS, 0) AS GAS 
        FROM RankedData WHERE rn = 1
    ";
    $paramsMeter = [$startYearForQuery];
    $stmtMeter = sqlsrv_query($connect, $queryMeter, $paramsMeter);

    if ($stmtMeter) {
        while ($row = sqlsrv_fetch_array($stmtMeter, SQLSRV_FETCH_ASSOC)) {
            $dateKey = $row['SORTING_DATE']->format('Y-m');
            $cumulativeReadings[$dateKey] = $row;
        }
    }

    // 3단계: [가스/수도] - 월별 "사용량" 계산하기
    foreach ($years as $idx => $year) {
        $varPrefix = $prefixes[$idx];
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

                // 계산된 사용량을 'UsageData' 배열에 저장
                ${$varPrefix . 'GasUsageData'}[$monthIndex] = max(0, $gasUsage);
                ${$varPrefix . 'WaterIwinUsageData'}[$monthIndex] = max(0, $waterIwinUsage);
                ${$varPrefix . 'WaterMalleUsageData'}[$monthIndex] = max(0, $waterMalleUsage);
            }
        }
    }

    // 4단계: [전기] - 월별 "사용량" 합계 한 번에 가져오기
    $queryElec = "
        SELECT
            FORMAT(DATEADD(month, CASE WHEN DAY(SORTING_DATE) <= 15 THEN 0 ELSE 1 END, SORTING_DATE), 'yyyy-MM') as UsageMonth,
            -- ★★★★★ (수정!) BIGINT를 DECIMAL로 변경하여 소수점까지 합산 ★★★★★
            SUM(CONVERT(DECIMAL(18, 2), ELECTRICITY)) as ELECTRICITY_SUM
        FROM CONNECT.dbo.READ_METER
        WHERE SORTING_DATE >= ? AND SORTING_DATE < ?
        GROUP BY FORMAT(DATEADD(month, CASE WHEN DAY(SORTING_DATE) <= 15 THEN 0 ELSE 1 END, SORTING_DATE), 'yyyy-MM')
    ";
    $startDate = ($threeYearsAgo - 1) . "-12-16";
    $endDate = $currentYear . "-12-16";
    $stmtElec = sqlsrv_query($connect, $queryElec, [$startDate, $endDate]);

    if ($stmtElec) {
        while ($row = sqlsrv_fetch_array($stmtElec, SQLSRV_FETCH_ASSOC)) {
            list($year, $monthStr) = explode('-', $row['UsageMonth']);
            $monthIndex = (int)$monthStr - 1;

            foreach($years as $idx => $y) {
                if ($year == $y) {
                    $prefix = $prefixes[$idx];
                    ${$prefix . 'ElectricityUsageData'}[$monthIndex] = $row['ELECTRICITY_SUM'];
                    break;
                }
            }
        }
    }

    // ★★★★★ (추가!) 합계 및 누적 합계 계산 로직 ★★★★★
    // '합계'와 '월 누적 합계'를 계산할 데이터 타입 목록
    $typesToCalculate = ['Gas', 'WaterIwin', 'WaterMalle', 'Electricity'];
    $currentMonthIndex = (int)date('m') - 1; // 현재 월의 인덱스 (예: 10월 -> 9)

    foreach ($prefixes as $prefix) {
        foreach ($typesToCalculate as $type) {
            $varName = $prefix . $type . 'UsageData';
            
            // 1. 년 합계 계산
            $totalSum = array_sum($$varName);

            // 2. 기존 배열의 맨 앞에 합계와 누적 합계를 추가
            array_unshift($$varName, $totalSum);
        }
    }

    // ★★★★★ (추가!) CO2 환산 로직 ★★★★★
    $gasToCO2Factor = (42.73 / 43.1 * 38.9 * 15.236 / 1000000) * (44 / 12);

    foreach ($prefixes as $prefix) {
        $usageVarName = $prefix . 'GasUsageData';
        $co2VarName = $prefix . 'GasCO2';
        $co2SumVarName = $prefix . 'GasCO2Sum';

        // $$usageVarName has sum at index 0, then 12 months of data
        $usageDataWithSum = $$usageVarName;
        $monthlyUsage = array_slice($usageDataWithSum, 1); // Get only monthly data

        $monthlyCO2 = array_map(function($usage) use ($gasToCO2Factor) {
            return $usage * $gasToCO2Factor;
        }, $monthlyUsage);

        $totalCO2Sum = array_sum($monthlyCO2);

        // Create 1-indexed array for the chart, starting with index 1 for Jan
        $co2ArrayForChart = [];
        for ($i = 0; $i < 12; $i++) {
            $co2ArrayForChart[$i + 1] = $monthlyCO2[$i];
        }

        $$co2VarName = $co2ArrayForChart;
        $$co2SumVarName = $totalCO2Sum;
    }

    // ★★★★★ (추가!) 목표치 계산 로직 ★★★★★
    $lastYearGasCO2Goal = [];
    $lastYearGasCO2Goal[] = $lastYearGasCO2Sum * 0.97;
    for ($i = 1; $i <= 12; $i++) {
        $lastYearGasCO2Goal[] = $lastYearGasCO2[$i] * 0.97;
    }

    // ★★★★★ (추가!) 전기 CO2 환산 및 목표치 계산 로직 ★★★★★
    $electricityToCO2Factor = 0.000459; // tCO2/MWh -> 0.000459 tCO2/kWh. Assuming usage is in kWh.

    foreach ($prefixes as $prefix) {
        $usageVarName = $prefix . 'ElectricityUsageData';
        $co2VarName = $prefix . 'ElectricityCO2';
        $co2SumVarName = $prefix . 'ElectricityCO2Sum';

        $usageDataWithSum = $$usageVarName;
        $monthlyUsage = array_slice($usageDataWithSum, 1);

        $monthlyCO2 = array_map(function($usage) use ($electricityToCO2Factor) {
            return $usage * $electricityToCO2Factor;
        }, $monthlyUsage);

        $totalCO2Sum = array_sum($monthlyCO2);

        $co2ArrayForChart = [];
        for ($i = 0; $i < 12; $i++) {
            $co2ArrayForChart[$i + 1] = $monthlyCO2[$i];
        }

        $$co2VarName = $co2ArrayForChart;
        $$co2SumVarName = $totalCO2Sum;
    }

    // 목표치 계산
    $lastYearElectricityCO2Goal = [];
    $lastYearElectricityCO2Goal[] = $lastYearElectricityCO2Sum * 0.97;
    for ($i = 1; $i <= 12; $i++) {
        $lastYearElectricityCO2Goal[] = $lastYearElectricityCO2[$i] * 0.97;
    }


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //폐기물
    // 1. 데이터 저장을 위한 배열 초기화
    $trashData = [];
    $yearsToFetch = [$currentYear, $previousYear, $twoYearsAgo, $threeYearsAgo];
    foreach ($yearsToFetch as $year) {
        $trashData[$year] = array_fill(0, 13, 0); 
    }

    // 2. 단일 쿼리로 모든 데이터 가져오기
    $startYear = $threeYearsAgo;
    $endYear = $currentYear;
    $queryTrash = "
        SELECT 
            YEAR(WORK_DATE) as work_year,
            MONTH(WORK_DATE) as work_month,
            SUM(GIVE_QUNT) AS total_qunt
        FROM 
            CONNECT.dbo.ALLBARO 
        WHERE 
            YEAR(WORK_DATE) BETWEEN ? AND ?
        GROUP BY 
            YEAR(WORK_DATE), MONTH(WORK_DATE)
        ORDER BY 
            work_year, work_month;
    ";
    $paramsTrash = [$startYear, $endYear];
    $stmtTrash = sqlsrv_query($connect, $queryTrash, $paramsTrash);

    // 3. 가져온 데이터를 배열에 채우기
    if ($stmtTrash) {
        while ($row = sqlsrv_fetch_array($stmtTrash, SQLSRV_FETCH_ASSOC)) {
            $year = $row['work_year'];
            $month = $row['work_month'];
            $quantity = $row['total_qunt'];
            
            if (isset($trashData[$year])) {
                $trashData[$year][$month] = $quantity;
            }
        }
    }

    // 4. 연도별 합계 계산 및 최종 변수 생성
    $thisYearTrash = $trashData[$currentYear];
    $lastYearTrash = $trashData[$previousYear];
    $twoYearsAgoTrash = $trashData[$twoYearsAgo];
    $threeYearsAgoTrash = $trashData[$threeYearsAgo];

    $thisYearTrash[0] = array_sum(array_slice($thisYearTrash, 1));
    $lastYearTrash[0] = array_sum(array_slice($lastYearTrash, 1));
    $twoYearsAgoTrash[0] = array_sum(array_slice($twoYearsAgoTrash, 1));
    $threeYearsAgoTrash[0] = array_sum(array_slice($threeYearsAgoTrash, 1));

    // ★★★★★ (추가!) 폐기물 CO2 환산 로직 ★★★★★
    $trashToCO2Factor = 0.0445; // tCO2/kg 

    foreach ($prefixes as $prefix) {
        $usageVarName = $prefix . 'Trash'; // e.g., thisYearTrash
        $co2VarName = $prefix . 'TrashCO2';
        $co2SumVarName = $prefix . 'TrashCO2Sum';

        // $$usageVarName has sum at index 0, then 12 months of data at indices 1-12
        $monthlyUsage = array_slice($$usageVarName, 1); 

        $monthlyCO2 = array_map(function($usage) use ($trashToCO2Factor) {
            return $usage * $trashToCO2Factor;
        }, $monthlyUsage);

        $totalCO2Sum = array_sum($monthlyCO2);

        // Create 1-indexed array for the table
        $co2ArrayForTable = [];
        for ($i = 0; $i < 12; $i++) {
            $co2ArrayForTable[$i + 1] = $monthlyCO2[$i];
        }

        $$co2VarName = $co2ArrayForTable;
        $$co2SumVarName = $totalCO2Sum;
    }

    // Create separate Sum variables for the usage table
    $thisYearTrashSum = $thisYearTrash[0];
    $lastYearTrashSum = $lastYearTrash[0];
    $twoYearsAgoTrashSum = $twoYearsAgoTrash[0];
    $threeYearsAgoTrashSum = $threeYearsAgoTrash[0];

    // ★★★★★ (추가!) 폐기물 목표치 계산 로직 ★★★★★
    $lastYearTrashCO2Goal = [];
    $lastYearTrashCO2Goal[] = $lastYearTrashCO2Sum * 0.97;
    for ($i = 1; $i <= 12; $i++) {
        $lastYearTrashCO2Goal[] = $lastYearTrashCO2[$i] * 0.97;
    }    


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    //이산화탄소 합계
    // 1. 'thisYear'
    $totalCO2_thisYear_Sum = ($thisYearOilCO2Sum ?? 0) + ($thisYearGasCO2Sum ?? 0) + ($thisYearElectricityCO2Sum ?? 0) + ($thisYearTrashCO2Sum ?? 0);
    $totalCO2Data_ThisYear = [$totalCO2_thisYear_Sum];
    for ($i = 1; $i <= 12; $i++) {
        $totalCO2Data_ThisYear[] = ($thisYearOilCO2[$i] ?? 0) + ($thisYearGasCO2[$i] ?? 0) + ($thisYearElectricityCO2[$i] ?? 0) + ($thisYearTrashCO2[$i] ?? 0);
    }

    // 2. 'lastYear'
    // ※ 주의: 기존 코드에서 이동연소는 'oneYearAgo', 나머지는 'lastYear' 변수명을 사용하므로 교차 합산합니다.
    $totalCO2_lastYear_Sum = ($oneYearAgoOilCO2Sum ?? 0) + ($lastYearGasCO2Sum ?? 0) + ($lastYearElectricityCO2Sum ?? 0) + ($lastYearTrashCO2Sum ?? 0);
    $totalCO2Data_LastYear = [$totalCO2_lastYear_Sum];
    for ($i = 1; $i <= 12; $i++) {
        $totalCO2Data_LastYear[] = ($oneYearAgoOilCO2[$i] ?? 0) + ($lastYearGasCO2[$i] ?? 0) + ($lastYearElectricityCO2[$i] ?? 0) + ($lastYearTrashCO2[$i] ?? 0);
    }

    // 3. 'twoYearsAgo' 
    $totalCO2_twoYearsAgo_Sum = ($twoYearsAgoOilCO2Sum ?? 0) + ($twoYearsAgoGasCO2Sum ?? 0) + ($twoYearsAgoElectricityCO2Sum ?? 0) + ($twoYearsAgoTrashCO2Sum ?? 0);
    $totalCO2Data_TwoYearsAgo = [$totalCO2_twoYearsAgo_Sum];
    for ($i = 1; $i <= 12; $i++) {
        $totalCO2Data_TwoYearsAgo[] = ($twoYearsAgoOilCO2[$i] ?? 0) + ($twoYearsAgoGasCO2[$i] ?? 0) + ($twoYearsAgoElectricityCO2[$i] ?? 0) + ($twoYearsAgoTrashCO2[$i] ?? 0);
    }

    // 4. 'threeYearsAgo' 
    $totalCO2_threeYearsAgo_Sum = ($threeYearsAgoOilCO2Sum ?? 0) + ($threeYearsAgoGasCO2Sum ?? 0) + ($threeYearsAgoElectricityCO2Sum ?? 0) + ($threeYearsAgoTrashCO2Sum ?? 0);
    $totalCO2Data_ThreeYearsAgo = [$totalCO2_threeYearsAgo_Sum];
    for ($i = 1; $i <= 12; $i++) {
        $totalCO2Data_ThreeYearsAgo[] = ($threeYearsAgoOilCO2[$i] ?? 0) + ($threeYearsAgoGasCO2[$i] ?? 0) + ($threeYearsAgoElectricityCO2[$i] ?? 0) + ($threeYearsAgoTrashCO2[$i] ?? 0);
    }

    // 5. 'Target' (전년 대비 3% 절감 목표) 데이터 생성
    // 위에서 계산한 $totalCO2Data_LastYear (합계 + 12개월치)를 사용합니다.
    $totalCO2Data_Target = [];
    foreach ($totalCO2Data_LastYear as $value) {
        $totalCO2Data_Target[] = $value * 0.97;
    }


    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    // 임직원 현황
    // ★ 상수 정의
    if (!defined('OFFICE_DEPARTMENTS')) {
        define('OFFICE_DEPARTMENTS', ['021', '023']);
    }
    if (!defined('CONTRACT_DEPARTMENTS')) {
        define('CONTRACT_DEPARTMENTS', ['015', '017', '018', '019']);
    }

    // ★ 데이터베이스에서 월별 인원수를 가져오는 함수
    function getHeadcountsByDate($connect, array $dates): array
    {
        if (empty($dates)) {
            return [];
        }
        
        $sql = "
            SELECT
                WORKDATE,
                COUNT(DISTINCT CASE WHEN Department IN (" . implode(',', array_fill(0, count(OFFICE_DEPARTMENTS), '?')) . ") THEN Name + Sabun END) AS office_count,
                COUNT(DISTINCT CASE WHEN Department IN (" . implode(',', array_fill(0, count(OFFICE_DEPARTMENTS), '?')) . ") AND grade = '010' THEN Name + Sabun END) AS office_women_count,
                COUNT(DISTINCT CASE WHEN Department IN (" . implode(',', array_fill(0, count(CONTRACT_DEPARTMENTS), '?')) . ") THEN Name + Sabun END) AS contract_count,
                COUNT(DISTINCT CASE WHEN Department IN (" . implode(',', array_fill(0, count(CONTRACT_DEPARTMENTS), '?')) . ") AND grade = '010' THEN Name + Sabun END) AS field_women_count
            FROM SECOM.dbo.T_SECOM_WORKHISTORY
            WHERE WORKDATE IN (" . implode(',', array_fill(0, count($dates), '?')) . ")
            GROUP BY WORKDATE
        ";
        
        $params = array_merge(OFFICE_DEPARTMENTS, OFFICE_DEPARTMENTS, CONTRACT_DEPARTMENTS, CONTRACT_DEPARTMENTS, $dates);
        $stmt = sqlsrv_query($connect, $sql, $params);
        if ($stmt === false) { 
            // For debugging:
            // echo "SQL Query Failed:<br>";
            // die(print_r(sqlsrv_errors(), true));
            return [];
        }

        $results = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $dateString = $row['WORKDATE'];
            if (!empty($dateString)) {
                try {
                    $dateObject = new DateTime($dateString);
                    $workdateStr = $dateObject->format('Ymd');
                    $results[$workdateStr] = [
                        'office_count' => $row['office_count'],
                        'office_women_count' => $row['office_women_count'],
                        'contract_count' => $row['contract_count'],
                        'field_women_count' => $row['field_women_count']
                    ];
                } catch (Exception $e) {
                    // Ignore invalid date formats
                }
            }
        }
        
        $finalResults = [];
        foreach ($dates as $date) {
            $finalResults[$date] = [
                'office_count'   => $results[$date]['office_count'] ?? 0,
                'office_women_count'   => $results[$date]['office_women_count'] ?? 0,
                'contract_count' => $results[$date]['contract_count'] ?? 0,
                'field_women_count'   => $results[$date]['field_women_count'] ?? 0
            ];
        }

        sqlsrv_free_stmt($stmt);
        return $finalResults;
    }

    // ★ 프론트엔드 변수 생성
    foreach ($prefixes as $idx => $prefix) {
        $year = $years[$idx];
        $monthly_dates = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthly_dates[] = sprintf('%d%02d01', $year, $month);
        }

        $headcounts = getHeadcountsByDate($connect, $monthly_dates);

        // 월별 데이터 및 연간 합계/평균 계산을 위한 변수 초기화
        $monthly_totals = [];
        $monthly_office = [];
        $monthly_office_women = [];
        $monthly_contract = [];
        $monthly_field_women = [];
        
        $year_total = 0;
        $year_office_total = 0;
        $year_office_women_total = 0;
        $year_contract_total = 0;
        $year_field_women_total = 0;
        
        $month_count = 0;

        for ($month = 1; $month <= 12; $month++) {
            $date_key = sprintf('%d%02d01', $year, $month);
            $data = $headcounts[$date_key] ?? ['office_count' => 0, 'office_women_count' => 0, 'contract_count' => 0, 'field_women_count' => 0];
            
            $office_for_month = $data['office_count'];
            $office_women_for_month = $data['office_women_count'];
            $contract_for_month = $data['contract_count'];
            $field_women_for_month = $data['field_women_count'];
            $total_for_month = $office_for_month + $contract_for_month;

            $monthly_totals[$month] = $total_for_month;
            $monthly_office[$month] = $office_for_month;
            $monthly_office_women[$month] = $office_women_for_month;
            $monthly_contract[$month] = $contract_for_month;
            $monthly_field_women[$month] = $field_women_for_month;

            if ($total_for_month > 0) {
                $year_total += $total_for_month;
                $year_office_total += $office_for_month;
                $year_office_women_total += $office_women_for_month;
                $year_contract_total += $contract_for_month;
                $year_field_women_total += $field_women_for_month;
                $month_count++;
            }
        }

        // 변수 할당
        ${$prefix . 'Headcount'} = $monthly_totals;
        ${$prefix . 'HeadcountAvg'} = ($month_count > 0) ? round($year_total / $month_count) : 0;
        
        ${$prefix . 'OfficeHeadcount'} = $monthly_office;
        ${$prefix . 'OfficeHeadcountAvg'} = ($month_count > 0) ? round($year_office_total / $month_count) : 0;

        ${$prefix . 'OfficeWomenHeadcount'} = $monthly_office_women;
        ${$prefix . 'OfficeWomenHeadcountAvg'} = ($month_count > 0) ? round($year_office_women_total / $month_count) : 0;

        ${$prefix . 'ContractHeadcount'} = $monthly_contract;
        ${$prefix . 'ContractHeadcountAvg'} = ($month_count > 0) ? round($year_contract_total / $month_count) : 0;

        ${$prefix . 'FieldWomenHeadcount'} = $monthly_field_women;
        ${$prefix . 'FieldWomenHeadcountAvg'} = ($month_count > 0) ? round($year_field_women_total / $month_count) : 0;
    }




    //★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    // 수동 업데이트 항목
    // 1. 요청된 모든 컬럼 리스트
    $columnsToProcess = [
        'top_official', 'top_official_woman', 'middle_official', 'middle_official_woman',
        'term_worker', 'grievance_count', 'mandatory_edu', 'childcare_Target_man',
        'childcare_Target_woman', 'childcare_user_man', 'childcare_user_woman',
        'childcare_return_man', 'childcare_return_woman', 'childcare_return_man_year',
        'childcare_return_woman_year', 'accident_rate', 'lost_time_accident_rate',
        'personal_data_count', 'donation_amount', 'environmental_violation',
        'social_violation', 'governance_violation', 'statutory_penalty', 'ethics_rate'
    ];

    // 2. 월별 데이터, 연간 합계, 연간 평균을 저장할 배열 초기화
    $monthlyData = [];
    $yearlyTotals = [];
    $yearlyAverages = [];

    foreach ($columnsToProcess as $column) {
        // $monthlyData['term_worker'][1] = 0, $monthlyData['term_worker'][2] = 0 ...
        $monthlyData[$column] = array_fill(1, 12, 0); 
        // $yearlyTotals['term_worker'] = 0
        $yearlyTotals[$column] = 0;
    }

    // 3. 쿼리에 사용할 날짜 관련 배열 준비
    $firstDayVariables = [];
    for ($month = 1; $month <= 12; $month++) {
        $firstDayVariables[$month] = date('Y-m-d', strtotime("$currentYear-$month-01"));
    }

    $datesToQuery = [];
    $dateToMonthMap = [];
    for ($month = 1; $month <= 12; $month++) {
        $date = $firstDayVariables[$month];
        $datesToQuery[] = $date; 
        $dateToMonthMap[$date] = $month; 
    }

    // 4. 12개월 치 데이터를 한 번에 가져오는 단일 쿼리
    $placeholders = implode(',', array_fill(0, count($datesToQuery), '?'));
    // SELECT 목록에 모든 컬럼 추가
    $queryColumns = implode(', ', $columnsToProcess); 

    $query = "SELECT SORTING_DATE, $queryColumns
            FROM CONNECT.dbo.ESG
            WHERE SORTING_DATE IN ($placeholders)";

    // 5. 쿼리 실행
    $result = sqlsrv_query($connect, $query, $datesToQuery, $options);

    // 6. 쿼리 결과 처리
    if ($result) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            // 날짜를 월로 변환
            $sortingDateStr = '';
            if ($row['SORTING_DATE'] instanceof DateTime) {
                // 1. DateTime 객체인 경우: 'Y-m-d'로 포맷
                $sortingDateStr = $row['SORTING_DATE']->format('Y-m-d'); 
            } else {
                // 2. 문자열이거나 다른 타입인 경우: 
                //    앞 10자리(Y-m-d)만 자름
                $sortingDateStr = substr((string) $row['SORTING_DATE'], 0, 10);
            }

            if (isset($dateToMonthMap[$sortingDateStr])) {
                $month = $dateToMonthMap[$sortingDateStr];
                
                // 모든 컬럼에 대해 월별 데이터 저장 및 합계 계산
                foreach ($columnsToProcess as $column) {
                    $value = $row[$column] ?? 0; // null일 경우 0으로 처리
                    $monthlyData[$column][$month] = $value;
                    $yearlyTotals[$column] += (float)$value; // 합계 누적
                }
            }
        }
    } else {
        // 쿼리 실패 시 에러 처리
        // error_log("ESG 데이터 쿼리 실패: " . print_r(sqlsrv_errors(), true));
    }

    // 7. 연간 평균 계산
    foreach ($columnsToProcess as $column) {
        // 12개월 데이터의 평균
        $yearlyAverages[$column] = $yearlyTotals[$column] / 12;
    }

    // LAST YEAR
    $lastYearMonthlyData = [];
    $lastYearYearlyTotals = [];
    $lastYearYearlyAverages = [];

    foreach ($columnsToProcess as $column) {
        $lastYearMonthlyData[$column] = array_fill(1, 12, 0); 
        $lastYearYearlyTotals[$column] = 0;
    }

    $lastYearFirstDayVariables = [];
    for ($month = 1; $month <= 12; $month++) {
        $lastYearFirstDayVariables[$month] = date('Y-m-d', strtotime("$previousYear-$month-01"));
    }

    $lastYearDatesToQuery = [];
    $lastYearDateToMonthMap = [];
    for ($month = 1; $month <= 12; $month++) {
        $date = $lastYearFirstDayVariables[$month];
        $lastYearDatesToQuery[] = $date; 
        $lastYearDateToMonthMap[$date] = $month; 
    }

    $lastYearPlaceholders = implode(',', array_fill(0, count($lastYearDatesToQuery), '?'));
    $queryLastYear = "SELECT SORTING_DATE, $queryColumns
            FROM CONNECT.dbo.ESG
            WHERE SORTING_DATE IN ($lastYearPlaceholders)";

    $resultLastYear = sqlsrv_query($connect, $queryLastYear, $lastYearDatesToQuery, $options);

    if ($resultLastYear) {
        while ($row = sqlsrv_fetch_array($resultLastYear, SQLSRV_FETCH_ASSOC)) {
            $sortingDateStr = '';
            if ($row['SORTING_DATE'] instanceof DateTime) {
                $sortingDateStr = $row['SORTING_DATE']->format('Y-m-d'); 
            } else {
                $sortingDateStr = substr((string) $row['SORTING_DATE'], 0, 10);
            }

            if (isset($lastYearDateToMonthMap[$sortingDateStr])) {
                $month = $lastYearDateToMonthMap[$sortingDateStr];
                foreach ($columnsToProcess as $column) {
                    $value = $row[$column] ?? 0;
                    $lastYearMonthlyData[$column][$month] = $value;
                    $lastYearYearlyTotals[$column] += (float)$value;
                }
            }
        }
    }

    foreach ($columnsToProcess as $column) {
        $lastYearYearlyAverages[$column] = $lastYearYearlyTotals[$column] / 12;
    }

    // TWO YEARS AGO
    $twoYearsAgoMonthlyData = [];
    $twoYearsAgoYearlyTotals = [];
    $twoYearsAgoYearlyAverages = [];

    foreach ($columnsToProcess as $column) {
        $twoYearsAgoMonthlyData[$column] = array_fill(1, 12, 0);
        $twoYearsAgoYearlyTotals[$column] = 0;
    }

    $twoYearsAgoFirstDayVariables = [];
    for ($month = 1; $month <= 12; $month++) {
        $twoYearsAgoFirstDayVariables[$month] = date('Y-m-d', strtotime("$twoYearsAgo-$month-01"));
    }

    $twoYearsAgoDatesToQuery = [];
    $twoYearsAgoDateToMonthMap = [];
    for ($month = 1; $month <= 12; $month++) {
        $date = $twoYearsAgoFirstDayVariables[$month];
        $twoYearsAgoDatesToQuery[] = $date;
        $twoYearsAgoDateToMonthMap[$date] = $month;
    }

    $twoYearsAgoPlaceholders = implode(',', array_fill(0, count($twoYearsAgoDatesToQuery), '?'));
    $queryTwoYearsAgo = "SELECT SORTING_DATE, $queryColumns
            FROM CONNECT.dbo.ESG
            WHERE SORTING_DATE IN ($twoYearsAgoPlaceholders)";

    $resultTwoYearsAgo = sqlsrv_query($connect, $queryTwoYearsAgo, $twoYearsAgoDatesToQuery, $options);

    if ($resultTwoYearsAgo) {
        while ($row = sqlsrv_fetch_array($resultTwoYearsAgo, SQLSRV_FETCH_ASSOC)) {
            $sortingDateStr = '';
            if ($row['SORTING_DATE'] instanceof DateTime) {
                $sortingDateStr = $row['SORTING_DATE']->format('Y-m-d');
            } else {
                $sortingDateStr = substr((string) $row['SORTING_DATE'], 0, 10);
            }

            if (isset($twoYearsAgoDateToMonthMap[$sortingDateStr])) {
                $month = $twoYearsAgoDateToMonthMap[$sortingDateStr];
                foreach ($columnsToProcess as $column) {
                    $value = $row[$column] ?? 0;
                    $twoYearsAgoMonthlyData[$column][$month] = $value;
                    $twoYearsAgoYearlyTotals[$column] += (float)$value;
                }
            }
        }
    }

    foreach ($columnsToProcess as $column) {
        $twoYearsAgoYearlyAverages[$column] = $twoYearsAgoYearlyTotals[$column] / 12;
    }


    // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    // 신규 채용 및 퇴사 관련 데이터
    $thisYearHiringData = [];
    $params = []; // These queries don't use prepared statement parameters from this array
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

    for ($month = 1; $month <= 12; $month++) {
        $year = $currentYear;
        $firstDay = date('Y-m-d', strtotime("$year-$month-01"));
        $lastDay = date('Y-m-t', strtotime("$year-$month-01"));

        // 입사자
        $queryJoin = "SELECT COUNT(*) AS Join1
                        FROM NEOE.NEOE.MA_EMP
                        WHERE DT_ENTER BETWEEN '$firstDay' AND '$lastDay'";

        // 퇴사자
        $queryResign = "SELECT COUNT(*) AS Resign
                        FROM NEOE.NEOE.MA_EMP
                        WHERE DT_RETIRE BETWEEN '$firstDay' AND '$lastDay'";

        // 중고졸 퇴사자
        $querySchool = "SELECT COUNT(*) AS School
                        FROM (
                            SELECT A.NO_EMP, A.NM_KOR
                            FROM NEOE.NEOE.MA_EMP A
                            LEFT JOIN NEOE.NEOE.HR_SCHOCARE B
                            ON A.NO_EMP = B.NO_EMP
                            where A.CD_INCOM='099' and DT_RETIRE BETWEEN '$firstDay' AND '$lastDay' and (A.TP_EMP='100' OR A.TP_EMP='150')
                            GROUP BY A.NO_EMP, A.NM_KOR
                            HAVING SUM(CASE WHEN B.CD_CAREER IN ('400', '500', '600') THEN 1 ELSE 0 END) = 0
                            AND SUM(CASE WHEN B.CD_CAREER IN ('200', '300') THEN 1 ELSE 0 END) > 0
                        ) sub";

        // 중고졸 합계
        $querySchoolTotal = "SELECT COUNT(*) AS SchoolTotal
                        FROM (
                            SELECT A.NO_EMP, A.NM_KOR
                            FROM NEOE.NEOE.MA_EMP A
                            LEFT JOIN NEOE.NEOE.HR_SCHOCARE B
                            ON A.NO_EMP = B.NO_EMP
                            where A.CD_INCOM='001' and (A.TP_EMP='100' OR A.TP_EMP='150')
                            GROUP BY A.NO_EMP, A.NM_KOR
                            HAVING SUM(CASE WHEN B.CD_CAREER IN ('400', '500', '600') THEN 1 ELSE 0 END) = 0
                            AND SUM(CASE WHEN B.CD_CAREER IN ('200', '300') THEN 1 ELSE 0 END) > 0
                        ) sub";

        // 보훈
        $queryBohun = "SELECT COUNT(*) AS Bohun
                        FROM NEOE.NEOE.MA_EMP
                        where DT_RETIRE BETWEEN '$firstDay' AND '$lastDay' AND CD_BOHUN='100'";

        // 장애
        $queryHandi = "SELECT COUNT(*) AS Handi
                        FROM NEOE.NEOE.MA_EMP
                        WHERE DT_RETIRE BETWEEN '$firstDay' AND '$lastDay' AND YN_HANDI='Y'";
        
        $resultJoin = sqlsrv_query($connect, $queryJoin, $params, $options);
        $resultJoinData = sqlsrv_fetch_array($resultJoin); 

        $resultResign = sqlsrv_query($connect, $queryResign, $params, $options);
        $resultResignData = sqlsrv_fetch_array($resultResign);

        $resultSchoolTotal = sqlsrv_query($connect, $querySchoolTotal, $params, $options);
        $resultSchoolTotalData = sqlsrv_fetch_array($resultSchoolTotal);
        
        $resultSchool = sqlsrv_query($connect, $querySchool, $params, $options);
        $resultSchoolData = sqlsrv_fetch_array($resultSchool);

        $resultSchoolCalData = ($resultSchoolTotalData['SchoolTotal'] ?? 0) - ($resultSchoolData['School'] ?? 0);

        $resultBohun = sqlsrv_query($connect, $queryBohun, $params, $options);
        $resultBohunData = sqlsrv_fetch_array($resultBohun);

        $resultHandi = sqlsrv_query($connect, $queryHandi, $params, $options);
        $resultHandiData = sqlsrv_fetch_array($resultHandi);

        $thisYearHiringData[$month] = [
            'Join1' => $resultJoinData['Join1'] ?? 0,
            'Resign' => $resultResignData['Resign'] ?? 0,
            'School' => $resultSchoolCalData,
            'Bohun' => $resultBohunData['Bohun'] ?? 0,
            'Handi' => $resultHandiData['Handi'] ?? 0
        ];
    }

    // 연간 평균 계산
    $hiringDataFields = ['Join1', 'Resign', 'School', 'Bohun', 'Handi'];
    foreach ($hiringDataFields as $field) {
        $fieldTotal = 0;
        for ($i = 1; $i <= 12; $i++) {
            $fieldTotal += $thisYearHiringData[$i][$field] ?? 0;
        }
        $yearlyAverages[$field] = $fieldTotal / 12;
    }

    // LAST YEAR HIRING DATA
    $lastYearHiringData = [];
    for ($month = 1; $month <= 12; $month++) {
        $year = $previousYear;
        $firstDay = date('Y-m-d', strtotime("$year-$month-01"));
        $lastDay = date('Y-m-t', strtotime("$year-$month-01"));

        $queryJoin = "SELECT COUNT(*) AS Join1 FROM NEOE.NEOE.MA_EMP WHERE DT_ENTER BETWEEN '$firstDay' AND '$lastDay'";
        $queryResign = "SELECT COUNT(*) AS Resign FROM NEOE.NEOE.MA_EMP WHERE DT_RETIRE BETWEEN '$firstDay' AND '$lastDay'";
        $querySchool = "SELECT COUNT(*) AS School FROM (SELECT A.NO_EMP, A.NM_KOR FROM NEOE.NEOE.MA_EMP A LEFT JOIN NEOE.NEOE.HR_SCHOCARE B ON A.NO_EMP = B.NO_EMP where A.CD_INCOM='099' and DT_RETIRE BETWEEN '$firstDay' AND '$lastDay' and (A.TP_EMP='100' OR A.TP_EMP='150') GROUP BY A.NO_EMP, A.NM_KOR HAVING SUM(CASE WHEN B.CD_CAREER IN ('400', '500', '600') THEN 1 ELSE 0 END) = 0 AND SUM(CASE WHEN B.CD_CAREER IN ('200', '300') THEN 1 ELSE 0 END) > 0) sub";
        $querySchoolTotal = "SELECT COUNT(*) AS SchoolTotal FROM (SELECT A.NO_EMP, A.NM_KOR FROM NEOE.NEOE.MA_EMP A LEFT JOIN NEOE.NEOE.HR_SCHOCARE B ON A.NO_EMP = B.NO_EMP where A.CD_INCOM='001' and (A.TP_EMP='100' OR A.TP_EMP='150') GROUP BY A.NO_EMP, A.NM_KOR HAVING SUM(CASE WHEN B.CD_CAREER IN ('400', '500', '600') THEN 1 ELSE 0 END) = 0 AND SUM(CASE WHEN B.CD_CAREER IN ('200', '300') THEN 1 ELSE 0 END) > 0) sub";
        $queryBohun = "SELECT COUNT(*) AS Bohun FROM NEOE.NEOE.MA_EMP where DT_RETIRE BETWEEN '$firstDay' AND '$lastDay' AND CD_BOHUN='100'";
        $queryHandi = "SELECT COUNT(*) AS Handi FROM NEOE.NEOE.MA_EMP WHERE DT_RETIRE BETWEEN '$firstDay' AND '$lastDay' AND YN_HANDI='Y'";
        
        $resultJoin = sqlsrv_query($connect, $queryJoin, $params, $options);
        $resultJoinData = sqlsrv_fetch_array($resultJoin); 

        $resultResign = sqlsrv_query($connect, $queryResign, $params, $options);
        $resultResignData = sqlsrv_fetch_array($resultResign);

        $resultSchoolTotal = sqlsrv_query($connect, $querySchoolTotal, $params, $options);
        $resultSchoolTotalData = sqlsrv_fetch_array($resultSchoolTotal);
        
        $resultSchool = sqlsrv_query($connect, $querySchool, $params, $options);
        $resultSchoolData = sqlsrv_fetch_array($resultSchool);

        $resultSchoolCalData = ($resultSchoolTotalData['SchoolTotal'] ?? 0) - ($resultSchoolData['School'] ?? 0);

        $resultBohun = sqlsrv_query($connect, $queryBohun, $params, $options);
        $resultBohunData = sqlsrv_fetch_array($resultBohun);

        $resultHandi = sqlsrv_query($connect, $queryHandi, $params, $options);
        $resultHandiData = sqlsrv_fetch_array($resultHandi);

        $lastYearHiringData[$month] = [
            'Join1' => $resultJoinData['Join1'] ?? 0,
            'Resign' => $resultResignData['Resign'] ?? 0,
            'School' => $resultSchoolCalData,
            'Bohun' => $resultBohunData['Bohun'] ?? 0,
            'Handi' => $resultHandiData['Handi'] ?? 0
        ];
    }
    foreach ($hiringDataFields as $field) {
        $fieldTotal = 0;
        for ($i = 1; $i <= 12; $i++) {
            $fieldTotal += $lastYearHiringData[$i][$field] ?? 0;
        }
        $lastYearYearlyAverages[$field] = $fieldTotal / 12;
    }

    // TWO YEARS AGO HIRING DATA
    $twoYearsAgoHiringData = [];
    for ($month = 1; $month <= 12; $month++) {
        $year = $twoYearsAgo;
        $firstDay = date('Y-m-d', strtotime("$year-$month-01"));
        $lastDay = date('Y-m-t', strtotime("$year-$month-01"));

        $queryJoin = "SELECT COUNT(*) AS Join1 FROM NEOE.NEOE.MA_EMP WHERE DT_ENTER BETWEEN '$firstDay' AND '$lastDay'";
        $queryResign = "SELECT COUNT(*) AS Resign FROM NEOE.NEOE.MA_EMP WHERE DT_RETIRE BETWEEN '$firstDay' AND '$lastDay'";
        $querySchool = "SELECT COUNT(*) AS School FROM (SELECT A.NO_EMP, A.NM_KOR FROM NEOE.NEOE.MA_EMP A LEFT JOIN NEOE.NEOE.HR_SCHOCARE B ON A.NO_EMP = B.NO_EMP where A.CD_INCOM='099' and DT_RETIRE BETWEEN '$firstDay' AND '$lastDay' and (A.TP_EMP='100' OR A.TP_EMP='150') GROUP BY A.NO_EMP, A.NM_KOR HAVING SUM(CASE WHEN B.CD_CAREER IN ('400', '500', '600') THEN 1 ELSE 0 END) = 0 AND SUM(CASE WHEN B.CD_CAREER IN ('200', '300') THEN 1 ELSE 0 END) > 0) sub";
        $querySchoolTotal = "SELECT COUNT(*) AS SchoolTotal FROM (SELECT A.NO_EMP, A.NM_KOR FROM NEOE.NEOE.MA_EMP A LEFT JOIN NEOE.NEOE.HR_SCHOCARE B ON A.NO_EMP = B.NO_EMP where A.CD_INCOM='001' and (A.TP_EMP='100' OR A.TP_EMP='150') GROUP BY A.NO_EMP, A.NM_KOR HAVING SUM(CASE WHEN B.CD_CAREER IN ('400', '500', '600') THEN 1 ELSE 0 END) = 0 AND SUM(CASE WHEN B.CD_CAREER IN ('200', '300') THEN 1 ELSE 0 END) > 0) sub";
        $queryBohun = "SELECT COUNT(*) AS Bohun FROM NEOE.NEOE.MA_EMP where DT_RETIRE BETWEEN '$firstDay' AND '$lastDay' AND CD_BOHUN='100'";
        $queryHandi = "SELECT COUNT(*) AS Handi FROM NEOE.NEOE.MA_EMP WHERE DT_RETIRE BETWEEN '$firstDay' AND '$lastDay' AND YN_HANDI='Y'";
        
        $resultJoin = sqlsrv_query($connect, $queryJoin, $params, $options);
        $resultJoinData = sqlsrv_fetch_array($resultJoin); 

        $resultResign = sqlsrv_query($connect, $queryResign, $params, $options);
        $resultResignData = sqlsrv_fetch_array($resultResign);

        $resultSchoolTotal = sqlsrv_query($connect, $querySchoolTotal, $params, $options);
        $resultSchoolTotalData = sqlsrv_fetch_array($resultSchoolTotal);
        
        $resultSchool = sqlsrv_query($connect, $querySchool, $params, $options);
        $resultSchoolData = sqlsrv_fetch_array($resultSchool);

        $resultSchoolCalData = ($resultSchoolTotalData['SchoolTotal'] ?? 0) - ($resultSchoolData['School'] ?? 0);

        $resultBohun = sqlsrv_query($connect, $queryBohun, $params, $options);
        $resultBohunData = sqlsrv_fetch_array($resultBohun);

        $resultHandi = sqlsrv_query($connect, $queryHandi, $params, $options);
        $resultHandiData = sqlsrv_fetch_array($resultHandi);

        $twoYearsAgoHiringData[$month] = [
            'Join1' => $resultJoinData['Join1'] ?? 0,
            'Resign' => $resultResignData['Resign'] ?? 0,
            'School' => $resultSchoolCalData,
            'Bohun' => $resultBohunData['Bohun'] ?? 0,
            'Handi' => $resultHandiData['Handi'] ?? 0
        ];
    }
    foreach ($hiringDataFields as $field) {
        $fieldTotal = 0;
        for ($i = 1; $i <= 12; $i++) {
            $fieldTotal += $twoYearsAgoHiringData[$i][$field] ?? 0;
        }
        $twoYearsAgoYearlyAverages[$field] = $fieldTotal / 12;
    }


    // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    // 근속 연수 데이터
    $year = $currentYear;
    $month = $currentMonthInt; // Use current month for YTD calculation

    $lastDayOfYear = "GETDATE()"; // For current year, always calculate to today

    // 남자 근속년수
    $queryWorkLengthMan = "SELECT count(*) AS WorkLengthManQT,
                        SUM(DATEDIFF(day, 
                        CAST(SUBSTRING(dt_enter, 1, 4) + '-' + SUBSTRING(dt_enter, 5, 2) + '-' + SUBSTRING(dt_enter, 7, 2) AS DATE), 
                        CAST($lastDayOfYear AS DATE)) / 365.25) AS WorkLengthMan
                        FROM NEOE.NEOE.MA_EMP 
                        WHERE CD_INCOM = '001' -- 근속중 
                        AND CD_SEX = '001' -- 남자 
                        AND TP_EMP IN ('100', '150', '200', '250', '300') 
                        AND CAST(SUBSTRING(dt_enter, 1, 6) AS INT) <= $year * 100 + $month
                        ";

    // 여자 근속년수
    $queryWorkLengthWoman = "SELECT count(*) AS WorkLengthWomanQT,
                        SUM(DATEDIFF(day, 
                        CAST(SUBSTRING(dt_enter, 1, 4) + '-' + SUBSTRING(dt_enter, 5, 2) + '-' + SUBSTRING(dt_enter, 7, 2) AS DATE), 
                        CAST($lastDayOfYear AS DATE)) / 365.25) AS WorkLengthWoman
                        FROM NEOE.NEOE.MA_EMP 
                        WHERE CD_INCOM = '001' -- 근속중 
                        AND CD_SEX = '002' -- 여자 
                        AND TP_EMP IN ('100', '150', '200', '250', '300') 
                        AND CAST(SUBSTRING(dt_enter, 1, 6) AS INT) <= $year * 100 + $month
                        ";

    $resultWorkLengthMan = sqlsrv_query($connect, $queryWorkLengthMan, [], []);
    $resultWorkLengthManData = sqlsrv_fetch_array($resultWorkLengthMan); 

    $resultWorkLengthWoman = sqlsrv_query($connect, $queryWorkLengthWoman, [], []);
    $resultWorkLengthWomanData = sqlsrv_fetch_array($resultWorkLengthWoman); 

    $thisYearWorkLengthM = 0;
    if (($resultWorkLengthManData['WorkLengthManQT'] ?? 0) > 0) {
        $thisYearWorkLengthM = $resultWorkLengthManData['WorkLengthMan'] / $resultWorkLengthManData['WorkLengthManQT'];
    }

    $thisYearWorkLengthW = 0;
    if (($resultWorkLengthWomanData['WorkLengthWomanQT'] ?? 0) > 0) {
        $thisYearWorkLengthW = $resultWorkLengthWomanData['WorkLengthWoman'] / $resultWorkLengthWomanData['WorkLengthWomanQT'];
    }

    // LAST YEAR WORK LENGTH
    $year = $previousYear;
    $month = 12;
    $lastDayOfYear = "'$previousYear-12-31'";

    $queryWorkLengthManLast = "SELECT count(*) AS WorkLengthManQT, SUM(DATEDIFF(day, CAST(SUBSTRING(dt_enter, 1, 4) + '-' + SUBSTRING(dt_enter, 5, 2) + '-' + SUBSTRING(dt_enter, 7, 2) AS DATE), CAST($lastDayOfYear AS DATE)) / 365.25) AS WorkLengthMan FROM NEOE.NEOE.MA_EMP WHERE CD_INCOM = '001' AND CD_SEX = '001' AND TP_EMP IN ('100', '150', '200', '250', '300') AND CAST(SUBSTRING(dt_enter, 1, 6) AS INT) <= $year * 100 + $month";
    $queryWorkLengthWomanLast = "SELECT count(*) AS WorkLengthWomanQT, SUM(DATEDIFF(day, CAST(SUBSTRING(dt_enter, 1, 4) + '-' + SUBSTRING(dt_enter, 5, 2) + '-' + SUBSTRING(dt_enter, 7, 2) AS DATE), CAST($lastDayOfYear AS DATE)) / 365.25) AS WorkLengthWoman FROM NEOE.NEOE.MA_EMP WHERE CD_INCOM = '001' AND CD_SEX = '002' AND TP_EMP IN ('100', '150', '200', '250', '300') AND CAST(SUBSTRING(dt_enter, 1, 6) AS INT) <= $year * 100 + $month";

    $resultWorkLengthManLast = sqlsrv_query($connect, $queryWorkLengthManLast, [], []);
    $resultWorkLengthManDataLast = sqlsrv_fetch_array($resultWorkLengthManLast); 

    $resultWorkLengthWomanLast = sqlsrv_query($connect, $queryWorkLengthWomanLast, [], []);
    $resultWorkLengthWomanDataLast = sqlsrv_fetch_array($resultWorkLengthWomanLast); 

    $lastYearWorkLengthM = 0;
    if (($resultWorkLengthManDataLast['WorkLengthManQT'] ?? 0) > 0) {
        $lastYearWorkLengthM = $resultWorkLengthManDataLast['WorkLengthMan'] / $resultWorkLengthManDataLast['WorkLengthManQT'];
    }

    $lastYearWorkLengthW = 0;
    if (($resultWorkLengthWomanDataLast['WorkLengthWomanQT'] ?? 0) > 0) {
        $lastYearWorkLengthW = $resultWorkLengthWomanDataLast['WorkLengthWoman'] / $resultWorkLengthWomanDataLast['WorkLengthWomanQT'];
    }

    // TWO YEARS AGO WORK LENGTH
    $year = $twoYearsAgo;
    $month = 12;
    $lastDayOfYear = "'$twoYearsAgo-12-31'";

    $queryWorkLengthManTwoYearsAgo = "SELECT count(*) AS WorkLengthManQT, SUM(DATEDIFF(day, CAST(SUBSTRING(dt_enter, 1, 4) + '-' + SUBSTRING(dt_enter, 5, 2) + '-' + SUBSTRING(dt_enter, 7, 2) AS DATE), CAST($lastDayOfYear AS DATE)) / 365.25) AS WorkLengthMan FROM NEOE.NEOE.MA_EMP WHERE CD_INCOM = '001' AND CD_SEX = '001' AND TP_EMP IN ('100', '150', '200', '250', '300') AND CAST(SUBSTRING(dt_enter, 1, 6) AS INT) <= $year * 100 + $month";
    $queryWorkLengthWomanTwoYearsAgo = "SELECT count(*) AS WorkLengthWomanQT, SUM(DATEDIFF(day, CAST(SUBSTRING(dt_enter, 1, 4) + '-' + SUBSTRING(dt_enter, 5, 2) + '-' + SUBSTRING(dt_enter, 7, 2) AS DATE), CAST($lastDayOfYear AS DATE)) / 365.25) AS WorkLengthWoman FROM NEOE.NEOE.MA_EMP WHERE CD_INCOM = '001' AND CD_SEX = '002' AND TP_EMP IN ('100', '150', '200', '250', '300') AND CAST(SUBSTRING(dt_enter, 1, 6) AS INT) <= $year * 100 + $month";

    $resultWorkLengthManTwoYearsAgo = sqlsrv_query($connect, $queryWorkLengthManTwoYearsAgo, [], []);
    $resultWorkLengthManDataTwoYearsAgo = sqlsrv_fetch_array($resultWorkLengthManTwoYearsAgo);

    $resultWorkLengthWomanTwoYearsAgo = sqlsrv_query($connect, $queryWorkLengthWomanTwoYearsAgo, [], []);
    $resultWorkLengthWomanDataTwoYearsAgo = sqlsrv_fetch_array($resultWorkLengthWomanTwoYearsAgo);

    $twoYearsAgoWorkLengthM = 0;
    if (($resultWorkLengthManDataTwoYearsAgo['WorkLengthManQT'] ?? 0) > 0) {
        $twoYearsAgoWorkLengthM = $resultWorkLengthManDataTwoYearsAgo['WorkLengthMan'] / $resultWorkLengthManDataTwoYearsAgo['WorkLengthManQT'];
    }

    $twoYearsAgoWorkLengthW = 0;
    if (($resultWorkLengthWomanDataTwoYearsAgo['WorkLengthWomanQT'] ?? 0) > 0) {
        $twoYearsAgoWorkLengthW = $resultWorkLengthWomanDataTwoYearsAgo['WorkLengthWoman'] / $resultWorkLengthWomanDataTwoYearsAgo['WorkLengthWomanQT'];
    }



    function fetchData($connect, $query, $params = []) {
        $result = sqlsrv_query($connect, $query, $params);
        if ($result === false) {
            error_log(print_r(sqlsrv_errors(), true));
            return null;
        }
        return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    }

    function fetchAllData($connect, $query, $params = []) {
        $result = sqlsrv_query($connect, $query, $params);
        if ($result === false) {
            error_log(print_r(sqlsrv_errors(), true));
            return [];
        }
        $all_data = [];
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $all_data[] = $row;
        }
        return $all_data;
    }

    //★매뉴 진입 시 실행
    IF($bt31=="on") {
        $tab_sequence=3; 
        include '../TAB.php'; 

        $Query_Trash = "select * from CONNECT.dbo.ALLBARO where WORK_DATE between '$s_dt3' and '$e_dt3'";              
        $Result_Trash = fetchAllData($connect, $Query_Trash, [$s_dt3, $e_dt3]);			
    }

    $Data_Trash1 = fetchData($connect, "select sum(GIVE_QUNT) AS GIVE_QUNT from CONNECT.dbo.ALLBARO where WORK_DATE like ?", [$currentYear.'%']) ?? ['GIVE_QUNT' => 0];
    $Data_Trash2 = fetchData($connect, "select sum(GIVE_QUNT) AS GIVE_QUNT from CONNECT.dbo.ALLBARO where WORK_DATE like ?", [$Minus1YY.'%']) ?? ['GIVE_QUNT' => 0];
    $Data_Trash3 = fetchData($connect, "select sum(GIVE_QUNT) AS GIVE_QUNT from CONNECT.dbo.ALLBARO where WORK_DATE like ?", [$Minus2YY.'%']) ?? ['GIVE_QUNT' => 0];

    //////////////////////////////////윤리교육//////////////////////////////////
    $Data_Edu = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$currentYear}년 윤리교육'");
    $Data_Edu2 = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus1YY}년 윤리교육'");
    $Data_Edu3 = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus2YY}년 윤리교육'");

    //////////////////////////////////봉사활동//////////////////////////////////
    $Data_Clean1 = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$currentYear}년 1분기 ESG 실천활동'");
    $Data_Clean2 = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$currentYear}년 2분기 ESG 실천활동'");
    $Data_Clean3 = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$currentYear}년 3분기 ESG 실천활동'");
    $Data_Clean4 = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$currentYear}년 4분기 ESG 실천활동'");

    //작년
    $Data_Clean1Minus1YY = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus1YY}년 1분기 ESG 실천활동'");
    $Data_Clean2Minus1YY = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus1YY}년 2분기 ESG 실천활동'");
    $Data_Clean3Minus1YY = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus1YY}년 3분기 ESG 실천활동'");
    $Data_Clean4Minus1YY = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus1YY}년 4분기 ESG 실천활동'");

    //재작년
    $Data_Clean1Minus2YY = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus2YY}년 1분기 ESG 실천활동'");
    $Data_Clean2Minus2YY = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus2YY}년 2분기 ESG 실천활동'");
    $Data_Clean3Minus2YY = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus2YY}년 3분기 ESG 실천활동'");
    $Data_Clean4Minus2YY = fetchData($connect, "SELECT COUNT(*) AS COU FROM CONNECT.dbo.SIGN_LOG WHERE TITLE='{$Minus2YY}년 4분기 ESG 실천활동'");
    
    //////////////////////////////////복리후생비//////////////////////////////////
    //현재까지
    $Data_Welfare = fetchData($connect, "SELECT TOP 1 * FROM NEOE.NEOE.V_FI_DAYSUM WHERE CD_ACCT = '54900' AND CD_COMPANY = '1000' AND AM_CR > 0 AND DT_ACCT LIKE '$currentYear%' ORDER BY DT_ACCT DESC");
    $lastYearData_Welfare = fetchData($connect, "SELECT TOP 1 * FROM NEOE.NEOE.V_FI_DAYSUM WHERE CD_ACCT = '54900' AND CD_COMPANY = '1000' AND AM_CR > 0 AND DT_ACCT LIKE '$previousYear%' ORDER BY DT_ACCT DESC");
    $twoYearsAgoData_Welfare = fetchData($connect, "SELECT TOP 1 * FROM NEOE.NEOE.V_FI_DAYSUM WHERE CD_ACCT = '54900' AND CD_COMPANY = '1000' AND AM_CR > 0 AND DT_ACCT LIKE '$twoYearsAgo%' ORDER BY DT_ACCT DESC");
?>