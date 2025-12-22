<?php
    // brother/contract_add.php
    // Flutter 앱의 장부관리(AssetService)와 연결되는 API
    // 호실 번호 자연 정렬(Natural Sort) 적용

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json; charset=utf-8');

    require_once '/var/www/html/DB/DB1.php'; 

    // GET 파라미터 받기
    $ownerName = $_GET['owner_name'] ?? '';

    // 응답 기본 구조
    $response = [
        'status' => 'success',
        'data' => []
    ];

    if (empty($ownerName)) {
        echo json_encode(['status' => 'error', 'message' => '임대인 성명이 필요합니다.']);
        exit;
    }

    // 1. DB 조회
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

    // 건물별 그룹화를 위한 맵
    $buildingsMap = [];

    while ($row = mysqli_fetch_assoc($result)) {
        
        $fullAddress = $row['building_address'];
        
        // 1. 호수 추출
        $roomNumber = '호수미상';
        if (preg_match('/(\d+호)$/u', $fullAddress, $m)) {
            $roomNumber = $m[1];
        }

        // 주소에서 호수 제거한 문자열 (그룹핑 키로 사용)
        $addressWithoutRoom = trim(str_replace($roomNumber, '', $fullAddress));

        // 2. 건물명 결정 로직
        $buildingName = "";
        if (!empty($row['building_name'])) {
            $buildingName = $row['building_name'];
        } else {
            // Fallback: 정규식으로 추측
            $buildingName = $addressWithoutRoom;
            if (preg_match('/(?:\d+(?:-\d+)?|\d+번지)\s+([^\d]+)$/u', $addressWithoutRoom, $m)) {
                $potentialName = trim($m[1]);
                if (!preg_match('/(동|읍|면|리|가|로|길)$/u', $potentialName)) {
                    $buildingName = $potentialName;
                }
            }
        }

        // 3. 건물이 맵에 없으면 초기화
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

        // 4. 호실 정보 구성
        $unitData = [
            'room_number' => $roomNumber,
            'area' => $row['exclusive_area'] ?? '-',
            
            // 임대인 정보
            'lessor_name' => $row['lessor_name'] ?? '-',
            'lessor_phone' => $row['lessor_phone'] ?? '-',
            'lessor_birth' => $row['lessor_birth_date'] ?? '-',

            // 임차인 정보
            'tenant_name' => $row['lessee_name'] ?? '-',
            'lessee_phone' => $row['lessee_phone'] ?? '-',
            'lessee_birth' => $row['lessee_birth_date'] ?? '-',
            'lessee_sex' => $row['lessee_sex'] ?? '-', 
            
            // 계약 정보
            'contract_date' => $row['contract_start_date'] ?? '-', 
            'expiry_date'   => $row['contract_end_date'] ?? '-',   
            'deposit'       => $row['deposit'] ?? '-',             
            'rent'          => $row['monthly_rent'] ?? '-',        
            
            // 공실 여부
            'is_vacant' => empty($row['lessee_name']),
            
            // 기타
            'floor_info' => json_encode([
                ['floor' => '', 'usage' => '주거용'] 
            ]) 
        ];

        $buildingsMap[$buildingKey]['units'][] = $unitData;
    }

    // ============================================================
    // [핵심 변경] 호실 번호 자연 정렬 (Natural Sort)
    // 101호 -> 201호 -> 1101호 순서로 정렬됨
    // ============================================================
    foreach ($buildingsMap as $key => $building) {
        usort($buildingsMap[$key]['units'], function ($a, $b) {
            // strnatcmp: 숫자가 포함된 문자열을 사람의 기준(Natural Order)으로 비교
            return strnatcmp($a['room_number'], $b['room_number']);
        });
    }

    // 맵을 배열로 변환하여 data에 할당
    $response['data'] = array_values($buildingsMap);

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>