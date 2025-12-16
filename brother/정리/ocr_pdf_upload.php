<?php
    // ocr_pdf_upload.php

    // 1. 기본 설정
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json; charset=utf-8');

    require_once '../DB/DB1.php'; 

    if (isset($_FILES['uploaded_file'])) {
        $fileName = $_FILES['uploaded_file']['name'];
        $tmpName = $_FILES['uploaded_file']['tmp_name'];
        
        $uploadDir = __DIR__ . '/uploads/'; // 절대 경로 사용 권장
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
            exec("chcon -t httpd_sys_rw_content_t $uploadDir");
        }
        $uploadPath = $uploadDir . basename($fileName);

        if (move_uploaded_file($tmpName, $uploadPath)) {
            
            // [중요] DB에 먼저 "빈 껍데기"를 만듭니다. (ID 확보용)
            // 나중에 Worker가 이 ID를 찾아서 내용을 채울 것입니다.
            $sql = "INSERT INTO brother_ocr_data (file_name, extracted_text, total_pages) VALUES (?, '분석 중입니다...', 0)";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "s", $fileName);
            mysqli_stmt_execute($stmt);
            
            // 방금 들어간 데이터의 ID (번호)를 알아냅니다.
            $last_id = mysqli_insert_id($connect);
            mysqli_stmt_close($stmt);

            // ------------------------------------------------------------------
            // ★ [핵심] 백그라운드 프로세스 실행 (Fire and Forget)
            // ------------------------------------------------------------------
            // php 명령어로 ocr_worker.php를 실행하되, 
            // > /dev/null 2>&1 & 를 붙여서 기다리지 않고 바로 넘어갑니다.
            // 인자값(Argument)으로 파일경로와 DB ID를 넘깁니다.
            
            $workerPath = __DIR__ . '/ocr_worker.php';
            $cmd = "php $workerPath '$uploadPath' '$last_id' > /dev/null 2>&1 &";
            exec($cmd);

            // 앱에는 즉시 성공 메시지를 보냅니다. (기다리지 않음!)
            echo json_encode([
                "status" => "success", 
                "message" => "파일이 업로드되었습니다. 서버에서 분석을 시작합니다.",
                "db_id" => $last_id // 앱에서 나중에 조회할 때 사용
            ]);

        } else {
            echo json_encode(["status" => "error", "message" => "파일 이동 실패"]);
        }
    }
?>