<?php
    // brother/asset_add.php (floor_info 확장 버전)

    error_reporting(0);
    ini_set('display_errors', 0);

    header("Access-Control-Allow-Origin: *"); 
    header('Content-Type: application/json; charset=utf-8');

    require_once '../DB/DB1.php';

    if (!$connect) {
        echo json_encode(["success" => false, "message" => "DB 연결 실패"]);
        exit;
    }

    $ownerName = mysqli_real_escape_string($connect, isset($_GET['owner_name']) ? $_GET['owner_name'] : '');
    $ownerBirth = mysqli_real_escape_string($connect, isset($_GET['owner_birth']) ? $_GET['owner_birth'] : '');

    // 1. 건물 목록 조회
    $sql = "SELECT id, road_address, building_name, owner_name, owner_dob 
            FROM brother_ocr_data 
            WHERE 1=1 ";

    if (!empty($ownerName)) $sql .= " AND owner_name = '$ownerName' ";
    if (!empty($ownerBirth)) $sql .= " AND owner_dob = '$ownerBirth' ";

    $sql .= " ORDER BY id DESC";

    $result = $connect->query($sql);
    $buildings = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row['units'] = []; 
            $buildings[] = $row;
        }
    } else {
        echo json_encode(["success" => false, "message" => "건물 조회 실패"]);
        exit;
    }

    // 2. 호실 정보 조회 및 [핵심] JSON 확장(Flatten) 처리
    if (count($buildings) > 0) {
        foreach ($buildings as &$building) {
            $address = $building['road_address'];
            
            if (empty($address)) continue;

            $safeAddress = mysqli_real_escape_string($connect, $address);

            // DB에서 해당 건물의 전유부 파일 데이터 조회
            $unitSql = "SELECT id, area, floor_info 
                        FROM brother_ocr_data_unit 
                        WHERE road_address = '$safeAddress' 
                        ORDER BY id ASC";
            
            $unitResult = $connect->query($unitSql);
            
            if ($unitResult) {
                $expandedUnits = []; // 확장된 호실들을 담을 배열
                $unitCounter = 1;    // 호수 카운터

                while ($uRow = $unitResult->fetch_assoc()) {
                    // floor_info JSON 파싱
                    $floors = json_decode($uRow['floor_info'], true);

                    // ★ 핵심 수정: floor_info 안에 데이터가 있으면 펼쳐서 저장
                    if (is_array($floors) && count($floors) > 0) {
                        foreach ($floors as $floorData) {
                            $newUnit = [];
                            
                            // 층 정보가 있으면 그것을 호실명으로 사용 (예: "1층"), 없으면 임의 번호
                            // 앱에서 room_number를 굵은 글씨로 보여주므로 "1층"이라고 뜨는 게 더 직관적일 것입니다.
                            // 만약 무조건 "1호, 2호"를 원하시면 아래 주석을 바꾸세요.
                            
                            $newUnit['room_number'] = isset($floorData['floor']) ? $floorData['floor'] : ($unitCounter . '호');
                            // $newUnit['room_number'] = $unitCounter . '호'; // 무조건 1호, 2호...로 하고 싶으면 이거 사용

                            $newUnit['area'] = isset($floorData['area']) ? $floorData['area'] : ($uRow['area'] ?? '-');
                            
                            // 앱의 Dart 코드 호환성을 위해 floor_info 구조를 유지해서 다시 넣어줌
                            // (앱은 floor_info[0]['usage'] 등을 참조하므로)
                            $newUnit['floor_info'] = json_encode([$floorData], JSON_UNESCAPED_UNICODE);
                            
                            $expandedUnits[] = $newUnit;
                            $unitCounter++;
                        }
                    } else {
                        // floor_info가 없거나 비어있으면 DB 행 그대로 1개만 추가 (기존 방식)
                        $uRow['room_number'] = $unitCounter . '호';
                        $uRow['floor_info'] = $uRow['floor_info'] ?? '[]';
                        $uRow['area'] = $uRow['area'] ?? '-';
                        
                        $expandedUnits[] = $uRow;
                        $unitCounter++;
                    }
                }
                
                // 확장된 호실 리스트를 건물 데이터에 할당
                $building['units'] = $expandedUnits;
            }
        }
    }

    // 3. 결과 반환
    $jsonOutput = json_encode([
        "success" => true,
        "count" => count($buildings),
        "data" => $buildings
    ], JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);

    if ($jsonOutput === false) {
        echo json_encode(["success" => false, "message" => "JSON 변환 오류"]);
    } else {
        echo $jsonOutput;
    }

    $connect->close();
?>