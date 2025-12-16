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
    // 임대인 이름으로 조회 (생년월일은 포맷이 다를 수 있어 이름 우선 조회 후 PHP에서 검증 권장하지만, 여기선 이름만으로 조회하거나 LIKE 사용)
    // 보안상 Prepared Statement 사용
    $sql = "SELECT * FROM brother_contract WHERE lessor_name = ? ORDER BY building_address ASC, no DESC";
    
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ownerName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 건물별 그룹화를 위한 맵
    $buildingsMap = [];

    while ($row = mysqli_fetch_assoc($result)) {
        // 생년월일 검증 (필요한 경우 주석 해제)
        // if ($ownerBirth && strpos($row['lessor_birth_date'], $ownerBirth) === false) continue;

        $fullAddress = $row['building_address'];
        
        // ---------------------------------------------------------
        // [주소 파싱 로직] 건물명과 호수 분리 시도
        // 예: 부산광역시 서구 부용동1가 18 세경더파크 802호
        // ---------------------------------------------------------
        
        // 1. 호수 추출 (문자열 끝에 있는 '숫자+호' 패턴)
        $roomNumber = '호수미상';
        if (preg_match('/(\d+호)$/u', $fullAddress, $m)) {
            $roomNumber = $m[1];
        }

        // 2. 건물명 추출
        // 호수를 제외한 나머지 주소에서, 번지수(숫자) 뒤에 오는 단어를 건물명으로 추정
        $addressWithoutRoom = trim(str_replace($roomNumber, '', $fullAddress));
        $buildingName = $addressWithoutRoom; // 기본값은 호수 뺀 전체 주소

        // "번지" 또는 숫자로 끝나는 지점 뒤의 텍스트를 건물명으로 인식 시도
        // 예: "...부용동1가 18 세경더파크" -> "18" 뒤의 "세경더파크" 추출
        if (preg_match('/(?:\d+(?:-\d+)?|\d+번지)\s+([^\d]+)$/u', $addressWithoutRoom, $m)) {
            $potentialName = trim($m[1]);
            // 동/읍/면/리로 끝나지 않는 경우만 건물명으로 간주
            if (!preg_match('/(동|읍|면|리|가|로|길)$/u', $potentialName)) {
                $buildingName = $potentialName;
            }
        }

        // 3. 건물이 맵에 없으면 초기화
        // 그룹화 키는 '호수를 제외한 주소' 사용
        $buildingKey = $addressWithoutRoom;
        
        if (!isset($buildingsMap[$buildingKey])) {
            $buildingsMap[$buildingKey] = [
                'building_name' => $buildingName,
                'road_address' => $addressWithoutRoom,
                'units' => []
            ];
        }

        // 4. 호실 정보 구성 (Flutter Model의 Unit 구조에 맞춤)
        // AssetService.dart에서 파싱하는 키값들을 맞춰줍니다.
        $unitData = [
            'room_number' => $roomNumber,
            'area' => $row['exclusive_area'] ?? '-',
            
            // [추가됨] 임대인 정보 (DB 컬럼명 그대로 매핑)
            'lessor_name' => $row['lessor_name'] ?? '-',
            'lessor_phone' => $row['lessor_phone'] ?? '-',
            'lessor_birth' => $row['lessor_birth_date'] ?? '-',

            // 임차인 정보
            'tenant_name' => $row['lessee_name'] ?? '-',
            'lessee_phone' => $row['lessee_phone'] ?? '-',
            'lessee_birth' => $row['lessee_birth_date'] ?? '-',
            'lessee_sex' => $row['lessee_sex'] ?? '-', 
            
            // ... (하단 생략) ...
            'is_vacant' => empty($row['lessee_name']),
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