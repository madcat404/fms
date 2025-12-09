<?php
    // brother_add_asset.php

    // CORS 및 인코딩 설정
    header("Access-Control-Allow-Origin: *"); 
    header('Content-Type: application/json; charset=utf-8');

    // DB 접속
    require_once '../DB/DB1.php';

    // DB 연결 확인
    if (!$connect) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "DB 연결 실패: " . mysqli_connect_error(),
            "data" => []
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 파라미터 받기
    $ownerName = isset($_GET['owner_name']) ? $_GET['owner_name'] : '';
    $ownerBirth = isset($_GET['owner_birth']) ? $_GET['owner_birth'] : '';

    // SQL 쿼리 작성 (Prepared Statement용 ? 사용)
    $sql = "SELECT id, road_address, building_name, owner_name, owner_dob, created_at, total_pages 
            FROM brother_ocr_data 
            WHERE 1=1 "; // 동적 쿼리를 위해 항상 참인 조건 추가

    $params = [];
    $types = "";

    // 이름 검색 조건 추가
    if (!empty($ownerName)) {
        $sql .= " AND owner_name = ? ";
        $params[] = $ownerName;
        $types .= "s"; // string
    }

    // 생년월일 검색 조건 추가
    if (!empty($ownerBirth)) {
        $sql .= " AND owner_dob = ? "; // DB 컬럼명이 owner_dob라고 가정
        $params[] = $ownerBirth;
        $types .= "s";
    }

    $sql .= " ORDER BY id DESC";

    // Prepared Statement 실행
    $stmt = $connect->prepare($sql);

    if ($stmt) {
        // 파라미터 바인딩 (검색 조건이 있을 때만)
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // 결과 반환 (항상 성공 구조 유지)
        echo json_encode([
            "success" => true,
            "count" => count($data),
            "data" => $data // Dart에서는 이 'data' 키를 참조해야 합니다.
        ], JSON_UNESCAPED_UNICODE);

        $stmt->close();
    } else {
        // 쿼리 준비 실패
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "쿼리 준비 실패: " . $connect->error,
            "data" => []
        ], JSON_UNESCAPED_UNICODE);
    }

    $connect->close();
?>