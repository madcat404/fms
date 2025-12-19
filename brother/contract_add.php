<?php
    // brother/contract_add.php
    // Flutter 앱의 장부관리(AssetService)와 연결되는 API
    // brother_contract 테이블의 데이터를 건물별/호실별로 그룹화하여 반환

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json; charset=utf-8');

    require_once '/var/www/html/DB/DB1.php'; 

    // GET 파라미터 받기 (임대인 정보)
    $ownerName = $_GET['owner_name'] ?? '';
    $ownerBirth = $_GET['owner_birth'] ?? '';

    // 응답 기본 구조
    $response = [
        'status' => 'success',
        'data' => []
    ];

    if (empty($ownerName)) {
        echo json_encode(['status' => 'error', 'message' => '임대인 성명이 필요합니다.']);
        exit;
    }

    // 1. DB 조회 (brother_contract 테이블)
    // 임대인 이름으로 조회
    $sql = "SELECT * FROM brother_contract WHERE lessor_name = ? ORDER BY building_address ASC, no DESC";
    
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ownerName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 건물별 그룹화를 위한 맵
    $buildingsMap = [];

    while ($row = mysqli_fetch_assoc($result)) {
        
        $fullAddress = $row['building_address'];
        
        // ---------------------------------------------------------
        // [주소 파싱 로직] 건물명과 호수 분리 시도
        // ---------------------------------------------------------
        
        // 1. 호수 추출
        $roomNumber = '호수미상';
        if (preg_match('/(\d+호)$/u', $fullAddress, $m)) {
            $roomNumber = $m[1];
        }

        // 2. 건물명 추출
        $addressWithoutRoom = trim(str_replace($roomNumber, '', $fullAddress));
        $buildingName = $addressWithoutRoom; 

        if (preg_match('/(?:\d+(?:-\d+)?|\d+번지)\s+([^\d]+)$/u', $addressWithoutRoom, $m)) {
            $potentialName = trim($m[1]);
            if (!preg_match('/(동|읍|면|리|가|로|길)$/u', $potentialName)) {
                $buildingName = $potentialName;
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
        }

        // 4. 호실 정보 구성
        // [수정됨] DB의 신규 컬럼들을 JSON 키에 매핑
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
            
            // [신규 추가] 계약 상세 정보 (DB 컬럼 -> JSON 키)
            'contract_date' => $row['contract_start_date'] ?? '-', // 계약 시작일
            'expiry_date'   => $row['contract_end_date'] ?? '-',   // 계약 종료일
            'deposit'       => $row['deposit'] ?? '-',             // 보증금
            'rent'          => $row['monthly_rent'] ?? '-',        // 월 임대료 (Flutter 모델이 'rent'를 사용함)
            
            // 공실 여부 (임차인 이름이 없으면 공실)
            'is_vacant' => empty($row['lessee_name']),
            
            // 기타 정보
            'floor_info' => json_encode([
                ['floor' => '', 'usage' => '주거용'] 
            ]) 
        ];

        // 해당 건물에 호실 추가
        $buildingsMap[$buildingKey]['units'][] = $unitData;
    }

    // 맵을 배열로 변환하여 data에 할당
    $response['data'] = array_values($buildingsMap);

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>