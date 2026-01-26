<?php
// card_download_status.php
// 파일 위치: /card/card_download_status.php (가정)

// 1. DB 연결 (상위 폴더의 DB2.php 참조)
require_once __DIR__ . '/../session/session_check.php';  
include_once __DIR__ . '/../DB/DB2.php'; 

// DB 연결 객체 확인 ($connect 변수 사용)
if (!isset($connect) || $connect === false) {
    die("데이터베이스 연결에 실패했습니다. 관리자에게 문의하세요.");
}

// GET 파라미터로 명함 ID 받기
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id == 0) {
    die("잘못된 접근입니다. ID가 없습니다.");
}

try {
    // 2. DB에서 사용자 정보 조회 (Prepared Statement 사용)
    $sql = "SELECT TOP 1 * FROM BIZ_CARD WHERE ID = ?";
    $queryParams = array($id); // DB2.php의 $params와 겹치지 않게 이름 변경
    
    // sqlsrv_query 실행 ($connect 사용)
    $stmt = sqlsrv_query($connect, $sql, $queryParams);

    if ($stmt === false) {
        throw new Exception(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if (!$row) {
        die("사용자 정보를 찾을 수 없습니다.");
    }

    // 3. 데이터 매핑 (DB 컬럼 -> 변수)
    // DB 컬럼명이 대문자라고 가정 (BIZ_CARD 테이블)
    $name = $row['NAME'];
    $mobile = $row['MOBILE'];
    $email = $row['EMAIL'];
    $company = $row['COMPANY'];
    $department = isset($row['DEPARTMENT']) ? $row['DEPARTMENT'] : '';
    $position = $row['POSITION'];
    $address = $row['ADDRESS'];
    $website = isset($row['WEBSITE']) ? $row['WEBSITE'] : '';
    $photoPath = isset($row['PHOTO_PATH']) ? $row['PHOTO_PATH'] : ''; 

    // 4. vCard 포맷 생성 (UTF-8 호환)
    $vcard = "BEGIN:VCARD\r\n";
    $vcard .= "VERSION:3.0\r\n";
    $vcard .= "FN;CHARSET=UTF-8:" . $name . "\r\n"; // 전체 이름
    $vcard .= "N;CHARSET=UTF-8:" . $name . ";;;;\r\n";
    $vcard .= "ORG;CHARSET=UTF-8:" . $company . ";" . $department . "\r\n";
    $vcard .= "TITLE;CHARSET=UTF-8:" . $position . "\r\n";
    $vcard .= "TEL;TYPE=WORK,VOICE:" . $mobile . "\r\n";
    $vcard .= "TEL;TYPE=CELL,VOICE:" . $mobile . "\r\n";
    $vcard .= "EMAIL;TYPE=WORK:" . $email . "\r\n";
    $vcard .= "ADR;TYPE=WORK;CHARSET=UTF-8:;;" . $address . ";;;;\r\n";
    if(!empty($website)) {
        $vcard .= "URL:" . $website . "\r\n";
    }

    // 5. 사진 이미지 처리 (Base64 인코딩)
    // 주의: photoPath가 웹 경로가 아닌 서버 내부 파일 경로여야 file_get_contents가 작동합니다.
    // 예: "uploads/my_photo.jpg" (상대 경로) 또는 "C:/inetpub/wwwroot/uploads/..." (절대 경로)
    if (!empty($photoPath) && file_exists($photoPath)) {
        $imgData = file_get_contents($photoPath);
        if ($imgData !== false) {
            $base64Img = base64_encode($imgData);
            
            // 확장자 확인
            $ext = strtoupper(pathinfo($photoPath, PATHINFO_EXTENSION));
            if($ext == 'JPG') $ext = 'JPEG';
            
            // vCard에 이미지 삽입
            $vcard .= "PHOTO;ENCODING=b;TYPE=" . $ext . ":" . $base64Img . "\r\n";
        }
    }

    $vcard .= "END:VCARD\r\n";

    // 6. 헤더 설정 및 파일 다운로드 출력
    $filename = "contact_" . $id . ".vcf";
    
    // DB2.php에서 이미 헤더를 보냈을 수 있으므로 버퍼를 비우거나 덮어씀
    // 다운로드 헤더 강제 설정
    header('Content-Type: text/x-vcard; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($vcard));
    header('Connection: close');

    echo $vcard;
    exit;

} catch (Exception $e) {
    // 예외 처리
    echo "오류가 발생했습니다: " . $e->getMessage();
} finally {
    // 리소스 정리
    if (isset($stmt)) sqlsrv_free_stmt($stmt);
    if (isset($connect)) sqlsrv_close($connect); // DB2.php의 변수명 $connect
}
?>