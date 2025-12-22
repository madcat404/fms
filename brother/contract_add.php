<?php
    // brother/contract_add.php
    // [수정] realtor_office_name (공인중개사 명칭) 추가 전송

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json; charset=utf-8');

    require_once '/var/www/html/DB/DB1.php'; 

    $ownerName = $_GET['owner_name'] ?? '';

    $response = ['status' => 'success', 'data' => []];

    if (empty($ownerName)) {
        echo json_encode(['status' => 'error', 'message' => '임대인 성명이 필요합니다.']);
        exit;
    }

    if ($ownerName === 'all') {
        $sql = "SELECT * FROM brother_contract ORDER BY building_address ASC, no DESC";
        $stmt = mysqli_prepare($connect, $sql);
    } else {
        $sql = "SELECT * FROM brother_contract WHERE lessor_name = ? ORDER BY building_address ASC, no DESC";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "s", $ownerName);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $buildingsMap = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $fullAddress = $row['building_address'];
        $roomNumber = '호수미상';
        if (preg_match('/(\d+호)$/u', $fullAddress, $m)) {
            $roomNumber = $m[1];
        }
        $addressWithoutRoom = trim(str_replace($roomNumber, '', $fullAddress));

        $buildingName = "";
        if (!empty($row['building_name'])) {
            $buildingName = $row['building_name'];
        } else {
            $buildingName = $addressWithoutRoom;
            if (preg_match('/(?:\d+(?:-\d+)?|\d+번지)\s+([^\d]+)$/u', $addressWithoutRoom, $m)) {
                $potentialName = trim($m[1]);
                if (!preg_match('/(동|읍|면|리|가|로|길)$/u', $potentialName)) {
                    $buildingName = $potentialName;
                }
            }
        }

        $buildingKey = $addressWithoutRoom;
        
        if (!isset($buildingsMap[$buildingKey])) {
            $buildingsMap[$buildingKey] = [
                'building_name' => $buildingName,
                'road_address' => $addressWithoutRoom,
                'units' => []
            ];
        } else {
            if (!empty($row['building_name']) && empty($buildingsMap[$buildingKey]['building_name'])) {
                $buildingsMap[$buildingKey]['building_name'] = $row['building_name'];
            }
        }

        $unitData = [
            'no' => $row['no'], 
            'room_number' => $roomNumber,
            'area' => $row['exclusive_area'] ?? '-',
            'lessor_name' => $row['lessor_name'] ?? '-',
            'lessor_phone' => $row['lessor_phone'] ?? '-',
            'lessor_birth' => $row['lessor_birth_date'] ?? '-',
            'tenant_name' => $row['lessee_name'] ?? '-',
            'lessee_phone' => $row['lessee_phone'] ?? '-',
            'lessee_birth' => $row['lessee_birth_date'] ?? '-',
            'lessee_sex' => $row['lessee_sex'] ?? '-', 
            'contract_date' => $row['contract_start_date'] ?? '-', 
            'expiry_date'   => $row['contract_end_date'] ?? '-',   
            'deposit'       => $row['deposit'] ?? '-',             
            'rent'          => $row['monthly_rent'] ?? '-',        
            'is_vacant' => empty($row['lessee_name']),
            'entrance_pw' => $row['entrance_pw'] ?? '-',
            'room_pw' => $row['room_pw'] ?? '-',
            'memo' => $row['memo'] ?? '-',
            
            // [수정] 부동산 전화번호 및 사무소 이름
            'realtor_phone' => $row['realtor_phone'] ?? '',
            'realtor_office_name' => $row['realtor_office_name'] ?? '', // 공인중개사 사무소 이름
            
            'options' => $row['options'] ?? '[]'
        ];

        $buildingsMap[$buildingKey]['units'][] = $unitData;
    }

    foreach ($buildingsMap as $key => $building) {
        usort($buildingsMap[$key]['units'], function ($a, $b) {
            return strnatcmp($a['room_number'], $b['room_number']);
        });
    }

    $response['data'] = array_values($buildingsMap);
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>