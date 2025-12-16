<?php
// brother/ocr_unit_worker.php (지1층 누락 해결 및 층별 파싱 최적화)

set_time_limit(0);
ini_set('memory_limit', '-1');

require_once '/var/www/html/DB/DB1.php'; 
require 'vendor/autoload.php';

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

function writeLog($msg) {
    file_put_contents(__DIR__ . '/unit_worker_log.txt', "[" . date('H:i:s') . "] $msg\n", FILE_APPEND);
}

if (!isset($argv[1]) || !isset($argv[2])) {
    exit;
}
$targetFilePath = $argv[1];
$dbId = $argv[2];

try {
    putenv('GOOGLE_APPLICATION_CREDENTIALS=/var/www/html/key.json');
    
    // 1. 이미지 변환 (400 DPI 권장)
    $outputPrefix = __DIR__ . "/uploads/unit_temp_" . $dbId . "_%03d.jpg";
    $cmd = "gs -dNOPAUSE -sDEVICE=jpeg -r400 -dJPEGQ=100 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -sOutputFile='$outputPrefix' '$targetFilePath' -c quit 2>&1";
    exec($cmd, $output, $returnVar);

    $images = glob(__DIR__ . "/uploads/unit_temp_" . $dbId . "_*.jpg");
    sort($images);

    if (count($images) == 0) {
        throw new Exception("PDF 변환 실패.");
    }

    // 2. OCR 실행
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
    // 3. 데이터 추출
    // ============================================================
    
    $road_address = null;
    $building_name = null;
    $floor_info = []; 

    // (0) 전처리: 노이즈 제거
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
    $cleanText = preg_replace($noise_patterns, '', $accumulatedText);
    
    // 층과 구조가 붙은 경우 띄어쓰기 (예: "2층철근" -> "2층 철근")
    $cleanText = preg_replace('/(\d+층)([가-힣])/u', '$1 $2', $cleanText);

    // (1) 도로명주소 추출
    $road_pattern = '/([가-힣]+(?:특별시|광역시|자치시|도|시)\s+(?:[가-힣]+(?:구|군|시)\s+)?[가-힣\d]+(?:로|길)\s+\d+(?:-\d+)?)/u';
    preg_match_all($road_pattern, $cleanText, $matches_addr);

    if (!empty($matches_addr[1])) {
        $last_idx_addr = count($matches_addr[1]) - 1;
        $road_address = trim($matches_addr[1][$last_idx_addr]);
    }

    // (2) ★ 층별 정보 추출 (최종 개선) ★
    // 개선 사항:
    // 1. /msu 옵션 사용: m(다중행), s(점.이 줄바꿈 포함), u(유니코드) -> 용도가 여러 줄이어도 인식함
    // 2. 층 패턴 확장: (지하|지|B)?\d+층 -> 지1층, 지하1층, B1층 모두 인식
    // 3. 구조 패턴 유연화: [^\s]+ 대신 [가-힣A-Za-z\(\)·]+ 허용 (괄호나 점 포함 구조 대비)
    
    $floor_pattern = '/(?:(?:주|조)?\d+\s+)?((?:지하|지|B)?\s*\d+층)\s+((?:[가-힣A-Za-z\(\)·]+\s*)*(?:구조|조))\s+(.+?)\s+([\d,]+\.?\d*)(?=\s|$)/msu';
    
    preg_match_all($floor_pattern, $cleanText, $matches_floor, PREG_SET_ORDER);

    foreach ($matches_floor as $match) {
        $floor = trim($match[1]);
        $structure = preg_replace('/\s+/', '', $match[2]); 
        $usage = trim($match[3]);
        $area = str_replace(',', '', trim($match[4]));

        // 용도 필드 정제
        $usage = preg_replace('/\s+/', ' ', $usage); // 줄바꿈을 공백으로 변환
        $usage = preg_replace('/\b(?:지|B)?\d+층\b/u', '', $usage); // 용도 내 층 정보 제거
        $usage = str_replace($structure, '', $usage); // 용도 내 구조 정보 제거
        $usage = trim($usage);

        // 유효성 검사: 면적이 1 미만이면 제외 (페이지 번호 등 오탐 방지)
        if (!is_numeric($area) || floatval($area) < 1) continue;

        $floor_info[] = [
            'floor'     => $floor,
            'structure' => $structure,
            'usage'     => $usage,
            'area'      => $area
        ];
    }
    
    // 중복 제거
    $floor_info = array_map("unserialize", array_unique(array_map("serialize", $floor_info)));
    $floor_info = array_values($floor_info);

    $floor_info_json = empty($floor_info) ? null : json_encode($floor_info, JSON_UNESCAPED_UNICODE);


    // ============================================================
    // 4. 주소 API 호출
    // ============================================================
    
    if ($road_address) {
        $juso_api_key = "U01TX0FVVEgyMDI1MTIwMTEwMzQ0NzExNjUxNDY="; 
        $apiUrl = "https://business.juso.go.kr/addrlink/addrLinkApi.do";
        $queryParams = http_build_query([
            'confmKey' => $juso_api_key,
            'currentPage' => 1,
            'countPerPage' => 10,
            'keyword' => $road_address,
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
                    $building_name = $json['results']['juso'][0]['bdNm'];
                }
            }
        }
    }

    // ============================================================
    // 5. DB 업데이트
    // ============================================================
    
    $sql = "UPDATE brother_ocr_data_unit 
            SET extracted_text = ?, 
                total_pages = ?, 
                road_address = ?, 
                building_name = ?,
                floor_info = ? 
            WHERE id = ?";
            
    $stmt = mysqli_prepare($connect, $sql);
    
    $cnt = count($images);
    
    mysqli_stmt_bind_param($stmt, "sisssi", 
        $accumulatedText, 
        $cnt, 
        $road_address, 
        $building_name, 
        $floor_info_json,
        $dbId
    );
    
    mysqli_stmt_execute($stmt);
    
    writeLog("성공: Unit ID $dbId 처리 완료 ($building_name, 층 정보 " . count($floor_info) . "건)");

} catch (Exception $e) {
    writeLog("에러: " . $e->getMessage());
    $msg = "에러: " . $e->getMessage();
    
    $sql = "UPDATE brother_ocr_data_unit SET extracted_text = ? WHERE id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "si", $msg, $dbId);
    mysqli_stmt_execute($stmt);
}
?>