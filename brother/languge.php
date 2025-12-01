<?php
    // 모든 출처에서의 요청을 허용 (개발 및 테스트용)
    header("Access-Control-Allow-Origin: *"); 

    // API 서버이므로 클라이언트(앱)에 JSON 형식으로 응답함을 알림
    header('Content-Type: application/json; charset=utf-8');

    // 1. DB 접속
    require_once '../DB/DB1.php';

    // 2. 접속 실패 시 에러 처리
    if (!$connect) {
        // 실패 시 JSON으로 에러 메시지 반환
        echo json_encode([
            "success" => false,
            "message" => "DB 연결 실패: " . mysqli_connect_error()
        ]);
        exit; // 스크립트 종료
    }

    // 3. Flutter에서 보낸 building 파라미터를 받음
    $buildingId = isset($_GET['building']) ? $_GET['building'] : 'all';

    $sql = "";

    // 4. building 값에 따라 다른 SQL 쿼리 실행
    if ($buildingId == '골든파크빌') {
        // '골든파크빌'에 해당하는 월세 합계 쿼리
        $sql = "SELECT SUM(payment) AS totalRent FROM brother_payment WHERE USER='권성근' AND ASSET = '골든파크빌' AND YEAR(SORTING_DATE) = YEAR(CURDATE()) AND MONTH(SORTING_DATE) = MONTH(CURDATE())";
    } else if ($buildingId == '강남 럭키빌딩') {
        // '강남 럭키빌딩'에 해당하는 월세 합계 쿼리
        $sql = "SELECT SUM(payment) AS totalRent FROM brother_payment WHERE USER='권성근' AND ASSET = '강남 럭키빌딩' AND YEAR(SORTING_DATE) = YEAR(CURDATE()) AND MONTH(SORTING_DATE) = MONTH(CURDATE())";
    } else { // 'all' 또는 다른 값이 오면 전체 합계를 구함
        // 현재 월의 데이터만 가져오도록 쿼리 수정
    $sql = "SELECT sum(payment) as totalRent FROM brother_payment WHERE USER='권성근' AND YEAR(SORTING_DATE) = YEAR(CURDATE()) AND MONTH(SORTING_DATE) = MONTH(CURDATE())";
    }

    $result = $connect->query($sql);

    $data = [];
    if ($result && $result->num_rows > 0) {
        // 결과를 배열로 변환
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // 4. 최종 결과 JSON으로 반환
    echo json_encode([
        "success" => true,
        "data"    => $data
    ]);

    // 5. DB 연결 종료
    $connect->close();
?>