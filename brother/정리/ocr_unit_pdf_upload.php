<?php
    // brother/ocr_unit_pdf_upload.php (재분석 로직 추가 버전)

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json; charset=utf-8');

    require_once '../DB/DB1.php'; 

    if (isset($_FILES['uploaded_file'])) {
        $fileName = $_FILES['uploaded_file']['name'];
        $tmpName = $_FILES['uploaded_file']['tmp_name'];
        
        // 1. 파일 해시 계산
        $fileHash = hash_file('sha256', $tmpName);

        // 2. DB 조회 (extracted_text와 주요 컬럼들을 가져옴)
        $checkSql = "SELECT id, extracted_text, road_address, building_name, floor_info 
                     FROM brother_ocr_data_unit 
                     WHERE file_hash = ?";
        $checkStmt = mysqli_prepare($connect, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "s", $fileHash);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        $existingData = mysqli_fetch_assoc($checkResult);
        mysqli_stmt_close($checkStmt);

        // 3. 중복 파일이 있는 경우
        if ($existingData) {
            $dbId = $existingData['id'];
            $text = $existingData['extracted_text'];
            
            // 데이터가 비어있는지 확인 (주소, 건물명, 층정보 중 하나라도 없으면 재분석)
            $isEmptyAddress = empty($existingData['road_address']);
            $isEmptyBuilding = empty($existingData['building_name']);
            $isEmptyFloor = empty($existingData['floor_info']) || $existingData['floor_info'] === '[]' || $existingData['floor_info'] === 'null';

            if (($isEmptyAddress || $isEmptyBuilding || $isEmptyFloor) && !empty($text)) {
                
                // =========================================================
                // [재분석 시작] 워커의 파싱 로직을 여기서 재실행
                // =========================================================
                
                // (0) 전처리
                $noise_patterns = [
                    '/이\s*등\(?초\)?본은\s*건축물대장의\s*원본내용과\s*틀림없음을\s*증명합니다\.?/u',
                    '/발급일\s*:\s*[\d\.년월일]+/u',
                    '/담당자\s*:\s*[^\n]+/u',
                    '/전화\s*:\s*[\d\-]+/u',
                    '/건축물\s*현황/u',
                    '/소유자\s*현황/u',
                    '/면적\s*\(㎡\)/u',
                    '/주민\(법인\)등록번호/u',
                    '/변동일/u',
                    '/변동원인/u',
                    '/이하여백/u'
                ];
                $cleanText = preg_replace($noise_patterns, '', $text);
                $cleanText = preg_replace('/(\d+층)([가-힣])/u', '$1 $2', $cleanText);

                $new_road_address = $existingData['road_address'];
                $new_building_name = $existingData['building_name'];
                $new_floor_info_json = $existingData['floor_info'];

                // (1) 주소 재추출 (비어있을 때만)
                if ($isEmptyAddress) {
                    $road_pattern = '/([가-힣]+(?:특별시|광역시|자치시|도|시)\s+(?:[가-힣]+(?:구|군|시)\s+)?[가-힣\d]+(?:로|길)\s+\d+(?:-\d+)?)/u';
                    preg_match_all($road_pattern, $cleanText, $matches_addr);
                    if (!empty($matches_addr[1])) {
                        $last_idx = count($matches_addr[1]) - 1;
                        $new_road_address = trim($matches_addr[1][$last_idx]);
                    }
                }

                // (2) 층별 정보 재추출 (비어있을 때만)
                if ($isEmptyFloor) {
                    $floor_info = [];
                    $floor_pattern = '/((?:주|조)\d+|\d+)\s+((?:지|B)?\d+층)\s+((?:[가-힣]+\s*)*(?:구조|조))\s+(.+?)\s+([\d,]+\.?\d*)(?=\s|$)/mu';
                    preg_match_all($floor_pattern, $cleanText, $matches_floor, PREG_SET_ORDER);

                    foreach ($matches_floor as $match) {
                        $floor = trim($match[2]);
                        $structure = preg_replace('/\s+/', '', $match[3]);
                        $usage = trim($match[4]);
                        $area = str_replace(',', '', trim($match[5]));

                        $usage = preg_replace('/\b(?:지|B)?\d+층\b/u', '', $usage);
                        $usage = str_replace($structure, '', $usage);
                        $usage = trim($usage);

                        if (!is_numeric($area) || floatval($area) < 1) continue;

                        $floor_info[] = [
                            'floor' => $floor,
                            'structure' => $structure,
                            'usage' => $usage,
                            'area' => $area
                        ];
                    }
                    // 중복 제거
                    $floor_info = array_map("unserialize", array_unique(array_map("serialize", $floor_info)));
                    $floor_info = array_values($floor_info);
                    $new_floor_info_json = empty($floor_info) ? null : json_encode($floor_info, JSON_UNESCAPED_UNICODE);
                }

                // (3) 건물명 재검색 (주소가 있고 건물명이 비어있을 때)
                if ($isEmptyBuilding && !empty($new_road_address)) {
                    $juso_api_key = "U01TX0FVVEgyMDI1MTIwMTEwMzQ0NzExNjUxNDY="; 
                    $apiUrl = "https://business.juso.go.kr/addrlink/addrLinkApi.do";
                    $queryParams = http_build_query([
                        'confmKey' => $juso_api_key,
                        'currentPage' => 1,
                        'countPerPage' => 10,
                        'keyword' => $new_road_address,
                        'resultType' => 'json',
                        'hstryYn' => 'Y'
                    ]);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $apiUrl . "?" . $queryParams);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $apiResponse = curl_exec($ch);
                    curl_close($ch);

                    if ($apiResponse) {
                        $json = json_decode($apiResponse, true);
                        if (isset($json['results']['common']['errorCode']) && $json['results']['common']['errorCode'] == '0') {
                            if (!empty($json['results']['juso'])) {
                                $new_building_name = $json['results']['juso'][0]['bdNm'];
                            }
                        }
                    }
                }

                // (4) DB 업데이트
                $updateSql = "UPDATE brother_ocr_data_unit 
                              SET road_address = ?, building_name = ?, floor_info = ? 
                              WHERE id = ?";
                $updateStmt = mysqli_prepare($connect, $updateSql);
                mysqli_stmt_bind_param($updateStmt, "sssi", $new_road_address, $new_building_name, $new_floor_info_json, $dbId);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt);

                echo json_encode([
                    "status" => "success", 
                    "message" => "기존 데이터의 누락된 정보를 재분석하여 채워넣었습니다.",
                    "db_id" => $dbId,
                    "is_duplicate" => true,
                    "reparsed" => true
                ]);
                exit;
            }

            // 데이터가 이미 꽉 차있으면 그냥 기존 정보 반환
            echo json_encode([
                "status" => "success", 
                "message" => "이미 등록된 파일입니다.",
                "db_id" => $dbId,
                "is_duplicate" => true
            ]);
            exit;
        }

        // --- (아래는 신규 파일 업로드 로직, 기존과 동일) ---

        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
            exec("chcon -t httpd_sys_rw_content_t $uploadDir");
        }
        $uploadPath = $uploadDir . basename($fileName);

        if (move_uploaded_file($tmpName, $uploadPath)) {
            $sql = "INSERT INTO brother_ocr_data_unit (file_name, file_hash, extracted_text, total_pages) VALUES (?, ?, '분석 중입니다...', 0)";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $fileName, $fileHash);
            mysqli_stmt_execute($stmt);
            $last_id = mysqli_insert_id($connect);
            mysqli_stmt_close($stmt);

            $workerPath = __DIR__ . '/ocr_unit_worker.php';
            $cmd = "php $workerPath '$uploadPath' '$last_id' > /dev/null 2>&1 &";
            exec($cmd);

            echo json_encode([
                "status" => "success", 
                "message" => "신규 파일이 업로드되었습니다. 분석을 시작합니다.",
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