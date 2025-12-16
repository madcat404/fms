<?php
    // brother/ocr_contract_pdf_upload.php
    // 계약서 PDF 업로드 및 중복 체크, 재분석 실행 로직

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json; charset=utf-8');

    require_once '/var/www/html/DB/DB1.php'; 

    if (isset($_FILES['uploaded_file'])) {
        $fileName = $_FILES['uploaded_file']['name'];
        $tmpName = $_FILES['uploaded_file']['tmp_name'];
        
        $fileHash = hash_file('sha256', $tmpName);

        // 중복 조회
        $checkSql = "SELECT no, ocr_raw_data, lessor_name, lessee_name, building_address 
                     FROM brother_contract 
                     WHERE file_hash = ?";
        $checkStmt = mysqli_prepare($connect, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "s", $fileHash);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        $existingData = mysqli_fetch_assoc($checkResult);
        mysqli_stmt_close($checkStmt);

        if ($existingData) {
            $dbId = $existingData['no'];
            
            // 데이터가 비어있는지 확인 (임대인 이름이 없으면 재분석 대상)
            $isEmptyLessor = empty($existingData['lessor_name']);
            $isEmptyLessee = empty($existingData['lessee_name']);
            $isEmptyRealtore = empty($existingData['realtor_office_name']);
            $isEmptyBuilding = empty($existingData['building_address']);
            // 필요 시 다른 컬럼도 체크 가능

            if ($isEmptyLessor || $isEmptyLessee || $isEmptyRealtore || $isEmptyBuilding) {
                // [재분석 트리거]
                // 이미 업로드된 파일이 있는지 확인해야 하지만, 업로드된 파일명을 DB에 저장하지 않았다면 난감함.
                // 여기서는 방금 올린 파일($tmpName)을 다시 uploads 폴더로 덮어쓰고 워커를 돌립니다.
                
                $uploadDir = __DIR__ . '/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                    exec("chcon -t httpd_sys_rw_content_t $uploadDir");
                }
                $uploadPath = $uploadDir . basename($fileName);
                
                // 기존 파일이 있다면 덮어씌움
                move_uploaded_file($tmpName, $uploadPath);

                // 워커 실행
                $workerPath = __DIR__ . '/ocr_contract_worker.php';
                $cmd = "php $workerPath '$uploadPath' '$dbId' > /dev/null 2>&1 &";
                exec($cmd);

                echo json_encode([
                    "status" => "success", 
                    "message" => "기존 데이터가 불완전하여 재분석을 시작했습니다.",
                    "db_id" => $dbId,
                    "is_duplicate" => true,
                    "restarted" => true
                ]);
                exit;
            }

            // 데이터가 이미 꽉 차있으면 그대로 반환
            echo json_encode([
                "status" => "success", 
                "message" => "이미 등록된 계약서입니다.",
                "db_id" => $dbId,
                "is_duplicate" => true
            ]);
            exit;
        }

        // --- 신규 파일 업로드 로직 ---
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
            exec("chcon -t httpd_sys_rw_content_t $uploadDir");
        }
        $uploadPath = $uploadDir . basename($fileName);

        if (move_uploaded_file($tmpName, $uploadPath)) {
            $sql = "INSERT INTO brother_contract (file_name, file_hash, ocr_raw_data, pdf_page_count) VALUES (?, ?, '분석 중입니다...', 0)";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $fileName, $fileHash);
            mysqli_stmt_execute($stmt);
            $last_id = mysqli_insert_id($connect);
            mysqli_stmt_close($stmt);

            $workerPath = __DIR__ . '/ocr_contract_worker.php';
            $cmd = "php $workerPath '$uploadPath' '$last_id' > /dev/null 2>&1 &";
            exec($cmd);

            echo json_encode([
                "status" => "success", 
                "message" => "계약서가 업로드되었습니다. OCR 분석을 시작합니다.",
                "db_id" => $last_id,
                "is_duplicate" => false
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "파일 이동 실패"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "파일이 전송되지 않았습니다."]);
    }
?>