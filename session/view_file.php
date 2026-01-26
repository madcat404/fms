<?php
    // =============================================
    // Description: 보안 파일 다운로드/보기 (하위 폴더 지원 버전)
    // =============================================

    include 'session_check.php';

    // 1. 세션 체크
    if (!isset($_SESSION['user_id'])) {
        die("권한이 없습니다.");
    }

    // 2. 파일명 가져오기
    $file_path = $_GET['file'] ?? '';

    if (empty($file_path)) {
        die("잘못된 요청입니다.");
    }

    // [중요] 실제 파일 폴더 위치 설정 (files 폴더)
    $upload_dir = realpath(__DIR__ . '/../files/');

    // 3. 실제 파일 경로 구성 (하위 폴더 포함)
    // realpath를 사용하여 ../ 같은 상대 경로를 절대 경로로 변환
    $real_path = realpath($upload_dir . '/' . $file_path);

    // 4. 보안 검사 (가장 중요)
    // (1) 파일이 존재해야 함
    // (2) 변환된 실제 경로($real_path)가 업로드 폴더($upload_dir)로 시작해야 함 (상위 폴더 접근 방지)
    if ($real_path === false || strpos($real_path, $upload_dir) !== 0 || !file_exists($real_path)) {
        header("HTTP/1.0 404 Not Found");
        die("파일을 찾을 수 없습니다.");
    }

    // 5. 파일 출력
    $mime_type = mime_content_type($real_path);
    
    // 다운로드 시 파일명 설정 (경로 제외한 순수 파일명만)
    $filename_only = basename($real_path);

    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: inline; filename="' . $filename_only . '"');
    header('Content-Length: ' . filesize($real_path));
    
    // 버퍼 비우기
    if (ob_get_level()) ob_end_clean();
    
    readfile($real_path);
    exit;
?>