<?php
// ocr_worker.php (주소 API 연동 버전)

set_time_limit(0);
ini_set('memory_limit', '-1');

require_once '/var/www/html/DB/DB1.php'; 
require 'vendor/autoload.php';

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

function writeLog($msg) {
    file_put_contents(__DIR__ . '/worker_log.txt', "[" . date('H:i:s') . "] $msg\n", FILE_APPEND);
}

// 인자 확인
if (!isset($argv[1]) || !isset($argv[2])) {
    exit;
}
$targetFilePath = $argv[1];
$dbId = $argv[2];

try {
    putenv('GOOGLE_APPLICATION_CREDENTIALS=/var/www/html/key.json');
    
    // 1. 이미지 변환
    $outputPrefix = __DIR__ . "/uploads/temp_" . $dbId . "_%03d.jpg";
    $cmd = "gs -dNOPAUSE -sDEVICE=jpeg -r300 -dJPEGQ=100 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -sOutputFile='$outputPrefix' '$targetFilePath' -c quit 2>&1";
    exec($cmd, $output, $returnVar);

    $images = glob(__DIR__ . "/uploads/temp_" . $dbId . "_*.jpg");
    sort($images);

    if (count($images) == 0) {
        throw new Exception("PDF 변환 실패.");
    }

    // 2. Google OCR 실행
    $accumulatedText = "";
    $imageAnnotator = new ImageAnnotatorClient();

    foreach ($images as $imgPath) {
        $content = file_get_contents($imgPath);
        $response = $imageAnnotator->textDetection($content);
        $texts = $response->getTextAnnotations();

        if (count($texts) > 0) {
            $accumulatedText .= $texts[0]->getDescription() . "\n\n";
        }
        unlink($imgPath); 
    }
    $imageAnnotator->close();

    // ============================================================
    // 3. 데이터 추출 (Regex)
    // ============================================================
    
    $owner_name = null;
    $owner_dob = null;
    $road_address = null;
    $building_name = null; // 초기화

    // (1) 소유주 추출
    preg_match_all('/(소유자|공유자)\s+([가-힣]+)\s+(\d{6})/u', $accumulatedText, $matches_owner);
    if (!empty($matches_owner[0])) {
        $last_idx = count($matches_owner[0]) - 1;
        $owner_name = $matches_owner[2][$last_idx]; 
        $owner_dob  = $matches_owner[3][$last_idx];
    }

    // (2) 도로명주소 추출 (엄격 모드)
    $road_pattern = '/(?:\[?도로명주소\]?)\s+([가-힣]+(?:특별시|광역시|자치시|도|시)\s+[가-힣\s\d]+(?:구|군|시)?\s+[가-힣\s\d]+(?:로|길)\s*[\d\-]+)/u';
    preg_match_all($road_pattern, $accumulatedText, $matches_addr);

    if (!empty($matches_addr[1])) {
        $last_idx_addr = count($matches_addr[1]) - 1;
        $road_address = trim($matches_addr[1][$last_idx_addr]);
    } else {
        // 백업 패턴 (시/도 생략된 경우 대비)
        $backup_pattern = '/(?:\[?도로명주소\]?)\s+([^\n]*(?:로|길)\s*[\d\-]+)/u';
        preg_match_all($backup_pattern, $accumulatedText, $matches_backup);
        if (!empty($matches_backup[1])) {
            $last_idx = count($matches_backup[1]) - 1;
            $road_address = trim($matches_backup[1][$last_idx]);
        }
    }

    // ============================================================
    // 4. [추가] 주소 API 호출하여 건물명(bdNm) 가져오기
    // ============================================================
    
    if ($road_address) {
        $juso_api_key = "U01TX0FVVEgyMDI1MTIwMTEwMzQ0NzExNjUxNDY="; 
        
        // 중요: resultType=json 파라미터 추가함
        $apiUrl = "https://business.juso.go.kr/addrlink/addrLinkApi.do";
        $queryParams = http_build_query([
            'confmKey' => $juso_api_key,
            'currentPage' => 1,
            'countPerPage' => 10,
            'keyword' => $road_address,
            'resultType' => 'json', // JSON으로 받아야 파싱이 편합니다.
            'hstryYn' => 'Y'
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . "?" . $queryParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL 인증서 문제 무시 (필요시 true)
        $apiResponse = curl_exec($ch);
        curl_close($ch);

        if ($apiResponse) {
            $json = json_decode($apiResponse, true);
            
            // 결과가 있고, 에러가 없으며, 검색 결과가 1개 이상일 때
            if (isset($json['results']['common']['errorCode']) && $json['results']['common']['errorCode'] == '0') {
                if (!empty($json['results']['juso'])) {
                    // 첫 번째 검색 결과의 건물명(bdNm) 가져오기
                    $building_name = $json['results']['juso'][0]['bdNm'];
                    writeLog("주소API 성공: $road_address -> $building_name");
                }
            } else {
                writeLog("주소API 에러: " . ($json['results']['common']['errorMessage'] ?? '알 수 없는 오류'));
            }
        }
    }


    // ============================================================
    // 5. DB 업데이트 (building_name 추가)
    // ============================================================
    
    $sql = "UPDATE brother_ocr_data 
            SET extracted_text = ?, 
                total_pages = ?, 
                owner_name = ?, 
                owner_dob = ?, 
                road_address = ?, 
                building_name = ? 
            WHERE id = ?";
            
    $stmt = mysqli_prepare($connect, $sql);
    
    $cnt = count($images);
    
    // 바인딩 타입: s(text), i(int), s, s, s, s(bldg), s(id) -> "sisssss"
    mysqli_stmt_bind_param($stmt, "sisssss", $accumulatedText, $cnt, $owner_name, $owner_dob, $road_address, $building_name, $dbId);
    
    mysqli_stmt_execute($stmt);
    
    writeLog("성공: ID $dbId 처리 완료 (건물명: $building_name)");

} catch (Exception $e) {
    writeLog("에러: " . $e->getMessage());
    $msg = "에러: " . $e->getMessage();
    
    $sql = "UPDATE brother_ocr_data SET extracted_text = ? WHERE id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "si", $msg, $dbId);
    mysqli_stmt_execute($stmt);
}
?>