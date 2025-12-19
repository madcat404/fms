<?php
    // brother/ocr_contract_pdf_upload.php
    // 계약서 PDF 업로드 및 중복 체크, 재분석 실행 로직 (개선버전)

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json; charset=utf-8');

    // preflight
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        exit;
    }

    require_once '/var/www/html/DB/DB1.php'; 

    // JSON 응답 헬퍼 함수
    function json_response($data) {
        echo json_encode($data, JSON_UNESCAPED_UNICODE); // 한글 깨짐 방지
        exit;
    }

    if (!isset($_FILES['uploaded_file'])) {
        http_response_code(400);
        json_response(["status" => "error", "message" => "파일이 전송되지 않았습니다."]);
    }

    $fileName = $_FILES['uploaded_file']['name'];
    $tmpName = $_FILES['uploaded_file']['tmp_name'];
    $fileHash = hash_file('sha256', $tmpName); // 파일 내용 해시 생성

    // 업로드 디렉토리 설정 (중복 여부와 상관없이 미리 준비)
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        // SELinux 환경 대비 (필요시 주석 해제)
        // exec("chcon -t httpd_sys_rw_content_t $uploadDir");
    }
    
    // 저장될 파일 경로 (파일명 충돌 방지를 위해 해시값이나 타임스탬프 활용 권장하나, 여기선 원본 유지)
    // 한글 파일명 이슈 방지를 위해 서버 저장명은 안전하게 변경하는 것이 좋지만, 
    // 기존 로직 유지를 위해 basename 사용
    $uploadPath = $uploadDir . basename($fileName);

    // ============================================================
    // 1. 중복 조회
    // ============================================================
    $checkSql = "SELECT no, ocr_raw_data, lessor_name, lessee_name, building_address 
                 FROM brother_contract 
                 WHERE file_hash = ?";
    
    $checkStmt = mysqli_prepare($connect, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "s", $fileHash);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);
    $existingData = mysqli_fetch_assoc($checkResult);
    mysqli_stmt_close($checkStmt);

    // ============================================================
    // 2. 중복 처리 로직
    // ============================================================
    if ($existingData) {
        $dbId = $existingData['no'];
        
        // 데이터가 비어있는지 확인 (재분석 조건)
        $isEmptyLessor = empty($existingData['lessor_name']);
        $isEmptyLessee = empty($existingData['lessee_name']);
        // DB 컬럼명 확인 필요 (realtor_office_name)
        $isEmptyRealtor = !isset($existingData['realtor_office_name']) || empty($existingData['realtor_office_name']);
        $isEmptyBuilding = empty($existingData['building_address']);

        // 하나라도 비어있으면 재분석 실행
        if ($isEmptyLessor || $isEmptyLessee || $isEmptyRealtor || $isEmptyBuilding) {
            
            // 파일 덮어쓰기
            if (move_uploaded_file($tmpName, $uploadPath)) {
                
                // ★ 워커 실행 (Contract 전용 워커)
                $workerPath = __DIR__ . '/ocr_contract_worker.php';
                $cmd = "php $workerPath '$uploadPath' '$dbId' > /dev/null 2>&1 &";
                exec($cmd);

                json_response([
                    "status" => "success", 
                    "message" => "기존 데이터가 불완전하여 재분석을 시작했습니다.",
                    "db_id" => $dbId,
                    "is_duplicate" => true,
                    "restarted" => true
                ]);
            } else {
                http_response_code(500);
                json_response(["status" => "error", "message" => "파일 이동 실패 (권한 확인 필요)"]);
            }
        }

        // 데이터가 이미 있으면 재분석 없이 리턴
        json_response([
            "status" => "success", 
            "message" => "이미 등록된 계약서입니다.",
            "db_id" => $dbId,
            "is_duplicate" => true
        ]);
    }

    // ============================================================
    // 3. 신규 등록 로직
    // ============================================================
    
    // 먼저 파일 이동 시도
    if (move_uploaded_file($tmpName, $uploadPath)) {
        
        // DB Insert
        $sql = "INSERT INTO brother_contract (file_name, file_hash, ocr_raw_data, pdf_page_count) VALUES (?, ?, '분석 중입니다...', 0)";
        $stmt = mysqli_prepare($connect, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $fileName, $fileHash);
            mysqli_stmt_execute($stmt);
            $last_id = mysqli_insert_id($connect);
            mysqli_stmt_close($stmt);

            // ★ 워커 실행
            $workerPath = __DIR__ . '/ocr_contract_worker.php';
            $cmd = "php $workerPath '$uploadPath' '$last_id' > /dev/null 2>&1 &";
            exec($cmd);

            json_response([
                "status" => "success", 
                "message" => "계약서가 업로드되었습니다. OCR 분석을 시작합니다.",
                "db_id" => $last_id,
                "is_duplicate" => false
            ]);
        } else {
            // DB 에러 시 업로드 된 파일 삭제 (선택사항)
            // unlink($uploadPath);
            http_response_code(500);
            json_response(["status" => "error", "message" => "DB 저장 실패: " . mysqli_error($connect)]);
        }

    } else {
        http_response_code(500);
        json_response(["status" => "error", "message" => "파일 이동 실패"]);
    }
?>