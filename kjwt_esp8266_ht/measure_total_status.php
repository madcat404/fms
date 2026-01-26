<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.11.17>
	// Description:	<그룹웨어 온습도 관제 쿼리>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance		
    // =============================================
       
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB4.php'; // For $connect4

    //★변수모음 (Null 병합 연산자로 안전하게 초기화)
    $location_id = $_POST["location"] ?? null;		    
    $dt2 = $_POST["dt2"] ?? null;	
    $s_dt2 = $dt2 ? substr($dt2, 0, 10) : null;		
	$e_dt2 = $dt2 ? substr($dt2, 13, 10) : null;   
    $bt21 = $_POST["bt21"] ?? null;         //버튼 클릭 시

    /**
     * Fetches the latest N readings from a given sensor table.
     * @param mysqli $connection The database connection object.
     * @param string $tableName The name of the table to query.
     * @param int $limit The number of records to fetch.
     * @return array An array of readings.
     */
    function get_latest_readings($connection, $tableName, $limit = 7) {
        $readings = [];
        // Whitelist table names to prevent injection, although it's internally controlled.
        $safe_table_name = " `" . str_replace('`', '', $tableName) . '`';

        $stmt = $connection->prepare("SELECT HUMIDITY, TEMPERATURE, DT FROM {$safe_table_name} ORDER BY DT DESC LIMIT ?");
        if ($stmt) {
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $readings[] = $row;
            }
            $stmt->close();
        }
        return $readings;
    }

    // Whitelist of all sensor tables
    $sensor_tables = [
        'f' => 'filed',
        'm' => 'materials_storage',
        'b' => 'bb_storage',
        'fs' => 'finished_storage',
        'e' => 'ecu_storage',
        'ms' => 'mask_storage',
        'mf' => 'mask_filed',
        'srv' => 'svr_room',
        'testA' => 'experiment_room',
        'testB' => 'experiment_room2',
        'qc' => 'qc_room'
    ];

    // Fetch latest 7 readings for all sensors efficiently
    $latest_readings = [];
    foreach ($sensor_tables as $prefix => $tableName) {
        $latest_readings[$prefix] = get_latest_readings($connect4, $tableName, 7);
    }

    // 외부 온습도
    $tweather_query = "SELECT * FROM weather2 WHERE category= 'TMX' ORDER BY NO DESC LIMIT 1";
    $tweather_result = $connect4->query($tweather_query);
    $tweather_row = $tweather_result->fetch_assoc();

    $hweather_query = "SELECT * FROM weather2 WHERE category= 'REH' ORDER BY NO DESC LIMIT 1";
    $hweather_result = $connect4->query($hweather_query);
    $hweather_row = $hweather_result->fetch_assoc();

    //★ 검색 버튼 클릭 시 실행
    if ($bt21 === "on") {
        $location_map = [
            '1' => ['name' => '생산현장', 'table' => 'filed'],
            '2' => ['name' => '자재창고', 'table' => 'materials_storage'],
            '3' => ['name' => 'B/B창고', 'table' => 'bb_storage'],
            '4' => ['name' => '완성품창고', 'table' => 'finished_storage'],
            '5' => ['name' => 'ECU창고', 'table' => 'ecu_storage'],
            '6' => ['name' => '마스크창고', 'table' => 'mask_storage'],
            '7' => ['name' => '마스크공정', 'table' => 'mask_filed'],
            '8' => ['name' => '전산실', 'table' => 'svr_room'],
            '9' => ['name' => '시험실A구역', 'table' => 'experiment_room'],
            '10' => ['name' => '시험실B구역', 'table' => 'experiment_room2'],
            '11' => ['name' => '수입검사실', 'table' => 'qc_room'],
        ];

        if (isset($location_map[$location_id])) {
            $table_name = $location_map[$location_id]['table'];
            $location = $location_map[$location_id]['name']; // For display
            $safe_table_name = '`' . str_replace('`', '', $table_name) . '`';

            // Parameterized query to prevent SQL Injection
            $stmt1 = $connect4->prepare("SELECT * FROM {$safe_table_name} WHERE DT BETWEEN ? AND ?");
            $stmt1->bind_param("ss", $s_dt2, $e_dt2);
            $stmt1->execute();
            $result1 = $stmt1->get_result(); // This result object is now available for the view file
            $num_result = $result1->num_rows;

            $stmt2 = $connect4->prepare("SELECT * FROM {$safe_table_name} ORDER BY DT DESC LIMIT 1");
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $row2 = $result2->fetch_assoc();
            $stmt2->close();

        } else {
            echo "<script>alert('위치를 선택하세요!');</script>";
        }  
    }
?>