<?php
    // brother/ocr_contract_pdf_upload.php
    // 계약서 PDF 업로드 및 중복 체크, 재분석 로직

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json; charset=utf-8');

    // DB 연결 (사용자 환경 경로)
    require_once '/var/www/html/DB/DB1.php'; 

    if (isset($_FILES['uploaded_file'])) {
        $fileName = $_FILES['uploaded_file']['name'];
        $tmpName = $_FILES['uploaded_file']['tmp_name'];
        
        // 1. 파일 해시 계산 (SHA256)
        $fileHash = hash_file('sha256', $tmpName);

        // 2. DB 중복 조회
        // brother_contract 테이블의 주요 정보 확인
        $checkSql = "SELECT no, ocr_raw_data, lessor_name, lessee_name, building_address 
                     FROM brother_contract 
                     WHERE file_hash = ?";
        $checkStmt = mysqli_prepare($connect, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "s", $fileHash);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        $existingData = mysqli_fetch_assoc($checkResult);
        mysqli_stmt_close($checkStmt);

        // 3. 중복 파일이 있는 경우 처리
        if ($existingData) {
            $dbId = $existingData['no'];
            $text = $existingData['ocr_raw_data'];
            
            // 데이터가 비어있는지 확인 (임대인, 임차인, 주소 중 하나라도 없으면 재분석 시도)
            $isEmptyLessor = empty($existingData['lessor_name']);
            $isEmptyLessee = empty($existingData['lessee_name']);
            $isEmptyAddress = empty($existingData['building_address']);

            // 텍스트는 있는데 주요 정보가 비어있다면 PHP 내부에서 재파싱 시도
            if (($isEmptyLessor || $isEmptyLessee || $isEmptyAddress) && !empty($text)) {
                
                // [재분석 로직] ---------------------------------------------
                $newLessor = $existingData['lessor_name'];
                $newLessee = $existingData['lessee_name'];
                $newAddress = $existingData['building_address'];

                // 노이즈 제거
                $cleanText = preg_replace('/[^\w\s가-힣\(\)\-\.\,]/u', ' ', $text);

                // (1) 임대인 성명 추출
                if ($isEmptyLessor) {
                    // 예: "임대인 : 홍길동" 또는 "매도인 (인) 홍길동" 등
                    if (preg_match('/(?:임\s*대\s*인|매\s*도\s*인).*?성\s*명\s*[:\s\.]*([가-힣]{2,5})/u', $text, $m)) {
                        $newLessor = trim($m[1]);
                    }
                }

                // (2) 임차인 성명 추출
                if ($isEmptyLessee) {
                    if (preg_match('/(?:임\s*차\s*인|매\s*수\s*인).*?성\s*명\s*[:\s\.]*([가-힣]{2,5})/u', $text, $m)) {
                        $newLessee = trim($m[1]);
                    }
                }

                // (3) 소재지(주소) 추출
                if ($isEmptyAddress) {
                    if (preg_match('/(?:소\s*재\s*지|물건의\s*표시)\s*[:\s]*([^\n]+)/u', $text, $m)) {
                        $newAddress = trim($m[1]);
                    }
                }

                // DB 업데이트
                $updateSql = "UPDATE brother_contract 
                              SET lessor_name = ?, lessee_name = ?, building_address = ? 
                              WHERE no = ?";
                $updateStmt = mysqli_prepare($connect, $updateSql);
                mysqli_stmt_bind_param($updateStmt, "sssi", $newLessor, $newLessee, $newAddress, $dbId);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt);

                echo json_encode([
                    "status" => "success", 
                    "message" => "기존 데이터의 누락된 계약 정보를 재분석했습니다.",
                    "db_id" => $dbId,
                    "is_duplicate" => true,
                    "reparsed" => true,
                    "lessor" => $newLessor
                ]);
                exit;
            }

            // 이미 데이터가 있으면 그대로 반환
            echo json_encode([
                "status" => "success", 
                "message" => "이미 등록된 계약서입니다.",
                "db_id" => $dbId,
                "is_duplicate" => true
            ]);
            exit;
        }

        // 4. 신규 파일 업로드 및 워커 실행
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
            // SELinux 권한 설정 (리눅스 환경)
            exec("chcon -t httpd_sys_rw_content_t $uploadDir");
        }
        $uploadPath = $uploadDir . basename($fileName);

        if (move_uploaded_file($tmpName, $uploadPath)) {
            // 초기 데이터 INSERT
            $sql = "INSERT INTO brother_contract (file_name, file_hash, ocr_raw_data, pdf_page_count) VALUES (?, ?, '분석 중입니다...', 0)";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $fileName, $fileHash);
            mysqli_stmt_execute($stmt);
            $last_id = mysqli_insert_id($connect);
            mysqli_stmt_close($stmt);

            // 비동기 워커 실행 (ocr_contract_worker.php 호출)
            $workerPath = __DIR__ . '/ocr_contract_worker.php';
            // 로그 출력을 위해 /dev/null 대신 로그 파일로 리다이렉트 가능 (디버깅 시)
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