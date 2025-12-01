<?php
    // CORS 헤더 설정
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json; charset=utf-8');

    // preflight 요청에 대한 응답
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        exit;
    }

    require_once '../DB/DB1.php';

    // 응답용 함수
    function json_response($success, $message) {
        echo json_encode(['success' => $success, 'message' => $message], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // DB 연결 확인
    if (!$connect) {
        http_response_code(500);
        json_response(false, "DB 연결 실패: " . mysqli_connect_error());
    }

    // POST 요청 확인
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        json_response(false, "잘못된 요청입니다. POST 요청만 허용됩니다.");
    }

    // 'kind' 데이터 확인
    if (!isset($_POST['kind']) || empty($_POST['kind'])) {
        http_response_code(400);
        json_response(false, "'kind' 데이터가 비어있거나 전송되지 않았습니다.");
    }

    $kind = $_POST['kind'];

    // Prepared Statement 사용
    $stmt = mysqli_prepare($connect, "INSERT INTO brother_ocr (kind) VALUES (?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $kind);

        if (mysqli_stmt_execute($stmt)) {
            json_response(true, "성공적으로 저장되었습니다.");
        } else {
            // 이 부분이 varchar(50) 초과 시 오류를 반환합니다.
            http_response_code(500);
            json_response(false, "저장 실패: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        json_response(false, "SQL 구문 준비 실패: " . mysqli_error($connect));
    }

    mysqli_close($connect);
?>