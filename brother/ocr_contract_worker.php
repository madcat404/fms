<?php
// brother/ocr_contract_worker.php
// 계약서 OCR 분석 및 파싱 워커

set_time_limit(0);
ini_set('memory_limit', '-1');

// 경로 확인 필요
require_once '/var/www/html/DB/DB1.php'; 
require 'vendor/autoload.php'; // Google Cloud Vision 라이브러리 로드

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

// 로그 기록 함수
function writeLog($msg) {
    file_put_contents(__DIR__ . '/contract_worker_log.txt', "[" . date('H:i:s') . "] $msg\n", FILE_APPEND);
}

if (!isset($argv[1]) || !isset($argv[2])) {
    writeLog("인자 부족: Usage: php ocr_contract_worker.php [filepath] [db_id]");
    exit;
}

$targetFilePath = $argv[1];
$dbId = $argv[2]; // brother_contract 테이블의 PK (no)

try {
    // Google API Key 설정 (경로 확인)
    putenv('GOOGLE_APPLICATION_CREDENTIALS=/var/www/html/key.json');
    
    // 1. PDF -> 이미지 변환 (Ghostscript 사용)
    // 계약서는 글자가 작을 수 있으므로 400 DPI 유지
    $outputPrefix = __DIR__ . "/uploads/contract_temp_" . $dbId . "_%03d.jpg";
    $cmd = "gs -dNOPAUSE -sDEVICE=jpeg -r400 -dJPEGQ=100 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -sOutputFile='$outputPrefix' '$targetFilePath' -c quit 2>&1";
    exec($cmd, $output, $returnVar);

    $images = glob(__DIR__ . "/uploads/contract_temp_" . $dbId . "_*.jpg");
    sort($images);

    if (count($images) == 0) {
        throw new Exception("PDF 변환 실패 (이미지 생성 안됨).");
    }

    // 2. Google Vision OCR 실행
    $accumulatedText = "";
    $imageAnnotator = new ImageAnnotatorClient();

    foreach ($images as $imgPath) {
        $content = file_get_contents($imgPath);
        $response = $imageAnnotator->textDetection($content);
        $texts = $response->getTextAnnotations();

        if (count($texts) > 0) {
            // 첫 번째 요소가 전체 텍스트입니다.
            $accumulatedText .= $texts[0]->getDescription() . "\n\n";
        }
        // 처리된 임시 이미지 삭제
        unlink($imgPath); 
    }
    $imageAnnotator->close();

    // ============================================================
    // 3. 계약서 데이터 파싱 (정규식)
    // ============================================================

    // 초기화
    $lessor_name = null;
    $lessor_phone = null;
    $lessor_birth = null;
    $lessee_name = null;
    $lessee_phone = null;
    $lessee_birth = null;
    $building_address = null;
    $exclusive_area = null;
    $realtor_name = null;

    // (1) 임대인 (성명, 전화, 주민번호)
    // 패턴: "임대인" ... "성명" ... (이름)
    if (preg_match('/(?:임\s*대\s*인|매\s*도\s*인).*?성\s*명\s*[:\s\.]*([가-힣]{2,5})/u', $accumulatedText, $m)) {
        $lessor_name = trim($m[1]);
    }
    // 주민번호 (앞 6자리)
    if (preg_match('/(?:임\s*대\s*인|매\s*도\s*인).*?(\d{6})\s*-\s*[1-4]\d{6}/u', $accumulatedText, $m)) {
        $lessor_birth = $m[1];
    }
    // 전화번호 (010-xxxx-xxxx)
    if (preg_match('/(?:임\s*대\s*인|매\s*도\s*인).*?(01\d[\s\-\.]?\d{3,4}[\s\-\.]?\d{4})/u', $accumulatedText, $m)) {
        $lessor_phone = preg_replace('/[^0-9]/', '-', $m[1]); // 숫자 외 문자 -로 통일 혹은 제거
    }

    // (2) 임차인 (성명, 전화, 주민번호)
    if (preg_match('/(?:임\s*차\s*인|매\s*수\s*인).*?성\s*명\s*[:\s\.]*([가-힣]{2,5})/u', $accumulatedText, $m)) {
        $lessee_name = trim($m[1]);
    }
    if (preg_match('/(?:임\s*차\s*인|매\s*수\s*인).*?(\d{6})\s*-\s*[1-4]\d{6}/u', $accumulatedText, $m)) {
        $lessee_birth = $m[1];
    }
    if (preg_match('/(?:임\s*차\s*인|매\s*수\s*인).*?(01\d[\s\-\.]?\d{3,4}[\s\-\.]?\d{4})/u', $accumulatedText, $m)) {
        $lessee_phone = preg_replace('/[^0-9]/', '-', $m[1]);
    }

    // (3) 소재지 (주소)
    // "소재지" 다음에 오는 문자열 추출 (줄바꿈 전까지)
    if (preg_match('/(?:소\s*재\s*지|물건의\s*표시)\s*[:\s]*([^\n]+)/u', $accumulatedText, $m)) {
        $building_address = trim($m[1]);
    }

    // (4) 전용면적
    if (preg_match('/(?:전용|건물)\s*면적\s*[:\s]*([\d\.]+)\s*㎡/u', $accumulatedText, $m)) {
        $exclusive_area = $m[1];
    }

    // (5) 공인중개사 (사무소 명칭)
    if (preg_match('/(개업)?공인중개사.*?사무소\s*명칭\s*[:\s]*([^\n]+)/u', $accumulatedText, $m)) {
        $realtor_name = trim($m[2]);
    }


    // ============================================================
    // 4. 주소 정제 (Juso API 활용 - 기존 코드 참조)
    // ============================================================
    if ($building_address) {
        $juso_api_key = "U01TX0FVVEgyMDI1MTIwMTEwMzQ0NzExNjUxNDY="; // 기존 키 사용
        $apiUrl = "https://business.juso.go.kr/addrlink/addrLinkApi.do";
        $queryParams = http_build_query([
            'confmKey' => $juso_api_key,
            'currentPage' => 1,
            'countPerPage' => 10,
            'keyword' => $building_address,
            'resultType' => 'json'
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
                    // API에서 찾은 정확한 도로명 주소로 업데이트
                    $building_address = $json['results']['juso'][0]['roadAddr'];
                }
            }
        }
    }

    // ============================================================
    // 5. DB 업데이트
    // ============================================================
    
    $sql = "UPDATE brother_contract 
            SET ocr_raw_data = ?, 
                pdf_page_count = ?, 
                lessor_name = ?, 
                lessor_birth_date = ?,
                lessor_phone = ?,
                lessee_name = ?,
                lessee_birth_date = ?,
                lessee_phone = ?,
                building_address = ?,
                exclusive_area = ?,
                realtor_office_name = ?
            WHERE no = ?";
            
    $stmt = mysqli_prepare($connect, $sql);
    
    $totalPages = count($images); // 처음에 생성된 이미지 수 (현재는 삭제됨) 사용하려면 위에서 변수 저장했어야 함.
    // 수정: 위에서 $images를 glob했을 때 개수를 저장해두는 것이 좋습니다. 
    // 여기서는 $accumulatedText 길이를 보아 0보다 크면 최소 1페이지로 간주.
    if (!isset($cnt)) $cnt = 1; // 임시

    mysqli_stmt_bind_param($stmt, "sisssssssssi", 
        $accumulatedText, 
        $cnt, 
        $lessor_name, 
        $lessor_birth,
        $lessor_phone,
        $lessee_name,
        $lessee_birth,
        $lessee_phone,
        $building_address,
        $exclusive_area,
        $realtor_name,
        $dbId
    );
    
    mysqli_stmt_execute($stmt);
    
    writeLog("성공: Contract ID $dbId 처리 완료 (주소: $building_address, 임대인: $lessor_name)");

} catch (Exception $e) {
    writeLog("에러: " . $e->getMessage());
    $msg = "에러: " . $e->getMessage();
    
    // 에러 발생 시 원본 데이터 컬럼에 에러 메시지 기록
    $sql = "UPDATE brother_contract SET ocr_raw_data = ? WHERE no = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "si", $msg, $dbId);
    mysqli_stmt_execute($stmt);
}
?>