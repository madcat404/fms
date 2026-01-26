<?php
// =============================================
// Author: <KWON SUNG KUN - sealclear@naver.com>
// Create date: <20.11.25>
// Description:	<그룹웨어 설비가동시간 관제 쿼리>
// Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance	
// =============================================

require_once __DIR__ .'/../session/session_check.php';
include_once __DIR__ . '/../DB/DB4.php';
include_once __DIR__ . '/../FUNCTION.php';
// function의 dt로 설정하지 않음
// 23.6 기준으로 해당 웹페이지 운영하고 있지 않으므로 보류
// 시험실 전기공사 중
// 25.01.23 이후 복구 시도
// WATT8-항온항습기 #1
// WATT9-항온항습기 #2
// WATT7-항온항습기 #3

/**
 * Executes a prepared statement and returns the result.
 * @param mysqli $connection The database connection object.
 * @param string $query The SQL query with placeholders.
 * @param array $params The parameters to bind to the query.
 * @param string $types A string containing the types of the parameters (e.g., 'sii').
 * @return array|null The fetched associative array or null on failure.
 */
function getQueryResult(mysqli $connection, string $query, array $params, string $types): ?array
{
    $stmt = $connection->prepare($query);
    if ($stmt === false) {
        // In a production environment, it's better to log this error.
        // error_log('Prepare failed: ' . $connection->error);
        return null;
    }
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc(); // Fetch a single row
    $stmt->close();
    return $data;
}

// Fetch latest status for WATT 7, 8, 9
$wattStatus = [];
foreach ([7, 8, 9] as $num) {
    $query = "SELECT WATT FROM experiment_equipment{$num} ORDER BY dt DESC LIMIT 1";
    $result = $connect4->query($query);
    $wattStatus[$num] = $result->fetch_assoc();
}

// --- Monthly Data ---
$monthlyData = [];
$firstDays = [
    $Hyphen_ThisYear1M_FirstDay, $Hyphen_ThisYear2M_FirstDay, $Hyphen_ThisYear3M_FirstDay,
    $Hyphen_ThisYear4M_FirstDay, $Hyphen_ThisYear5M_FirstDay, $Hyphen_ThisYear6M_FirstDay,
    $Hyphen_ThisYear7M_FirstDay, $Hyphen_ThisYear8M_FirstDay, $Hyphen_ThisYear9M_FirstDay,
    $Hyphen_ThisYear10M_FirstDay, $Hyphen_ThisYear11M_FirstDay, $Hyphen_ThisYear12M_FirstDay
];

$query_monthly = "SELECT SUM(work_time) as work_time FROM equipment_worktime WHERE kind = ? AND dt BETWEEN ? AND ?";

foreach ([7, 8, 9] as $num) {
    $kind = "experiment{$num}";
    for ($month = 1; $month <= 12; $month++) {
        $firstDay = $firstDays[$month - 1];
        // Assuming DateConversion function exists and works as intended
        $lastDay = DateConversion($firstDay, 'Hyphen');
        $monthlyData[$num][$month] = getQueryResult($connect4, $query_monthly, [$kind, $firstDay, $lastDay], 'sss');
    }
}

// --- Weekly Data ---
$weeklyData = [];
// Assuming $week, $week1, ... $week6
$weeks = [$week, $week1, $week2, $week3, $week4, $week5, $week6];
$query_weekly = "SELECT SUM(work_time) as work_time FROM equipment_worktime WHERE kind = ? AND YEAR(dt) = ? AND WEEKOFYEAR(dt) = ?";

foreach ([7, 8, 9] as $num) {
    $kind = "experiment{$num}";
    foreach ($weeks as $i => $weekNum) {
        // Assuming $YY is defined in the included session file and is an integer year
        if (isset($YY) && isset($weekNum)) {
            $weeklyData[$num][$i + 1] = getQueryResult($connect4, $query_weekly, [$kind, $YY, $weekNum], 'sii');
        }
    }
}

// on/off status determination
$WATT7 = ($wattStatus[7]['WATT'] ?? 0) > 250 ? "ON" : "OFF";
$WATT8 = ($wattStatus[8]['WATT'] ?? 0) > 250 ? "ON" : "OFF";
$WATT9 = ($wattStatus[9]['WATT'] ?? 0) > 250 ? "ON" : "OFF";

/*
    Data Access Example:
    The original variables like `$Data_WATT7_ThisYear1M` are now stored in arrays.
    You can access them like this:

    - WATT7 1월 데이터: $monthlyData[7][1]['work_time']
    - WATT8 2월 데이터: $monthlyData[8][2]['work_time']
    - WATT9 첫번째 주 데이터: $weeklyData[9][1]['work_time']
*/
?>
