<?php
// brother/ocr_contract_worker.php
// 임대차 계약서 정밀 분석 (Gemini 3 Flash Preview + 건물명 추출 추가)

set_time_limit(0);
ini_set('memory_limit', '-1');

// DB 연결
require_once '/var/www/html/DB/DB1.php'; 

// 로그 기록
function writeLog($msg) {
    $logFile = __DIR__ . '/contract_worker_log.txt';
    $logMsg = "[" . date('Y-m-d H:i:s') . "] $msg\n";
    file_put_contents($logFile, $logMsg, FILE_APPEND);
}

// Gemini API 호출 (재시도 로직 포함)
function callGeminiForContract($imagePaths) {
    // ★ API 키 입력 필수 (기존 키를 유지하세요)
    $apiKey = "AIzaSyAigTPKIoJXX9xGR-TuqiXRiBcGwcXzYso"; 
    
    // [사용 중인 모델 유지] gemini-3-flash-preview
    $model = "gemini-3-flash-preview"; 
    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=" . $apiKey;

    // [프롬프트 수정] 12번 항목에 building_name 추가
    $promptText = "
    이 이미지는 부동산 임대차 계약서야. 내용을 있는 그대로 정확하게 읽어줘.
    특히 사람 이름(임대인, 임차인)을 읽을 때 주의해줘. 
    비슷한 글자로 추측하지 말고, 문서에 적힌 글자 그대로만 추출해.
    ('하'를 '박'으로 읽거나 없는 이름을 지어내면 절대 안 됨)
    
    [추출 항목]
    1. lessor_name: 임대인 성명 (주민등록번호 앞의 이름)
    2. lessor_birth_date: 임대인 주민번호 앞 6자리
    3. lessor_phone: 임대인 전화번호
    4. lessee_name: 임차인 성명
    5. lessee_birth_date: 임차인 주민번호 앞 6자리
    6. lessee_phone: 임차인 전화번호
    7. lessee_sex: 임차인 성별 (남/여)
    8. realtor_office_name: 공인중개사 사무소 명칭
    9. realtor_office_address: 공인중개사 소재지
    10. realtor_phone: 공인중개사 전화번호
    11. building_address: 임대 대상 건물 소재지 (전체 주소)
    12. building_name: 건물 명칭 (주소 외에 건물의 고유 이름이 있다면 추출. 예: '세경더파크', '래미안', '타워팰리스'. 없으면 null)
    13. exclusive_area: 전용 면적
    14. contract_start_date: 계약 시작일 (YYYY-MM-DD)
    15. contract_end_date: 계약 종료일 (YYYY-MM-DD)
    16. deposit: 보증금 (숫자만, 예: 50000000)
    17. monthly_rent: 월세 (숫자만, 없으면 0)

    응답은 오직 JSON 포맷으로만 해줘. (마크다운 태그 제외)
    ";

    $parts = [];
    $parts[] = ["text" => $promptText];

    foreach ($imagePaths as $path) {
        if (file_exists($path)) {
            $imageData = base64_encode(file_get_contents($path));
            $parts[] = [
                "inline_data" => [
                    "mime_type" => "image/jpeg",
                    "data" => $imageData
                ]
            ];
        }
    }

    $payload = json_encode([
        "contents" => [["parts" => $parts]],
        "generationConfig" => [
            "temperature" => 0.0, // [중요] 창의성 0% -> 있는 그대로만 읽기
            "responseMimeType" => "application/json"
        ]
    ]);

    // 재시도 로직 (최대 3회)
    $maxRetries = 3;
    
    for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            $jsonResponse = json_decode($response, true);
            if (isset($jsonResponse['candidates'][0]['content']['parts'][0]['text'])) {
                $responseText = $jsonResponse['candidates'][0]['content']['parts'][0]['text'];
                $responseText = str_replace(['```json', '```'], '', $responseText);
                return json_decode($responseText, true);
            }
        } elseif ($httpCode == 429) {
            writeLog("모델 과부하(429). 5초 대기 후 재시도 ($attempt/$maxRetries)...");
            sleep(5); // 대기 시간 5초로 증가
            continue;
        } else {
            writeLog("API 에러 (HTTP $httpCode): " . substr($response, 0, 300));
            if ($httpCode >= 500) {
                sleep(2);
                continue;
            }
            break;
        }
    }
    
    return null;
}

// 메인 로직
if (!isset($argv[1]) || !isset($argv[2])) {
    writeLog("인자 부족");
    exit;
}

$targetFilePath = $argv[1];
$dbId = $argv[2];

try {
    // 1. PDF -> 이미지 변환 (고화질 옵션 적용)
    $outputPrefix = __DIR__ . "/uploads/contract_" . $dbId . "_%03d.jpg";
    // -dJPEGQ=100 : 이미지 압축 없이 최고 화질로 변환
    $cmd = "gs -dNOPAUSE -sDEVICE=jpeg -r300 -dJPEGQ=100 -sOutputFile='$outputPrefix' '$targetFilePath' -c quit 2>&1";
    exec($cmd);

    $images = glob(__DIR__ . "/uploads/contract_" . $dbId . "_*.jpg");
    sort($images);
    $pageCount = count($images);

    if ($pageCount == 0) {
        throw new Exception("PDF 변환 실패");
    }

    writeLog("ID $dbId: 이미지 변환 완료. 정밀 분석 시작...");

    // 2. 분석
    $parsedData = callGeminiForContract($images);

    // 이미지 삭제
    foreach ($images as $img) @unlink($img);

    // 3. 결과 처리
    $lessor_name = $lessor_birth_date = $lessor_phone = null;
    $lessee_name = $lessee_birth_date = $lessee_phone = $lessee_sex = null;
    $realtor_office_name = $realtor_office_address = $realtor_phone = null;
    $building_address = $building_name = $exclusive_area = null;
    $contract_start_date = $contract_end_date = null;
    $deposit = $monthly_rent = null;
    $ocr_raw_data = "";

    if ($parsedData) {
        $lessor_name = $parsedData['lessor_name'] ?? null;
        $lessor_birth_date = $parsedData['lessor_birth_date'] ?? null;
        $lessor_phone = $parsedData['lessor_phone'] ?? null;
        $lessee_name = $parsedData['lessee_name'] ?? null;
        $lessee_birth_date = $parsedData['lessee_birth_date'] ?? null;
        $lessee_phone = $parsedData['lessee_phone'] ?? null;
        $lessee_sex = $parsedData['lessee_sex'] ?? null;
        $realtor_office_name = $parsedData['realtor_office_name'] ?? null;
        $realtor_office_address = $parsedData['realtor_office_address'] ?? null;
        $realtor_phone = $parsedData['realtor_phone'] ?? null;
        
        $building_address = $parsedData['building_address'] ?? null;
        $building_name = $parsedData['building_name'] ?? null; // ★ 추가됨
        $exclusive_area = $parsedData['exclusive_area'] ?? null;
        
        $contract_start_date = $parsedData['contract_start_date'] ?? null;
        $contract_end_date = $parsedData['contract_end_date'] ?? null;
        $deposit = $parsedData['deposit'] ?? null;
        $monthly_rent = $parsedData['monthly_rent'] ?? null;

        $ocr_raw_data = json_encode($parsedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        writeLog("분석 완료: 임대인 [$lessor_name], 건물명 [$building_name]");
    } else {
        $ocr_raw_data = "분석 실패 (로그 확인 필요)";
        writeLog("분석 실패.");
    }

    // 4. DB 저장
    // ★ building_name 컬럼 추가
    $sql = "UPDATE brother_contract SET 
            lessor_name = ?, lessor_birth_date = ?, lessor_phone = ?, 
            lessee_name = ?, lessee_birth_date = ?, lessee_phone = ?, lessee_sex = ?, 
            realtor_office_name = ?, realtor_office_address = ?, realtor_phone = ?, 
            building_address = ?, building_name = ?, exclusive_area = ?, 
            contract_start_date = ?, contract_end_date = ?, 
            deposit = ?, monthly_rent = ?, 
            pdf_page_count = ?, ocr_raw_data = ? 
            WHERE no = ?";

    $stmt = mysqli_prepare($connect, $sql);
    
    // 바인딩 타입 수정: sssssssssssssssssisi (총 20개 파라미터)
    // building_name을 building_address 뒤에 추가
    mysqli_stmt_bind_param($stmt, "sssssssssssssssssisi", 
        $lessor_name, $lessor_birth_date, $lessor_phone, 
        $lessee_name, $lessee_birth_date, $lessee_phone, $lessee_sex, 
        $realtor_office_name, $realtor_office_address, $realtor_phone, 
        $building_address, $building_name, $exclusive_area, 
        $contract_start_date, $contract_end_date, 
        $deposit, $monthly_rent, 
        $pageCount, $ocr_raw_data, 
        $dbId
    );

    if (mysqli_stmt_execute($stmt)) {
        writeLog("DB 저장 성공");
        if (!empty($building_address)) {
            writeLog("건축물대장 정보 수집 시도: $building_address");
            
            // 백그라운드에서 실행 (사용자를 기다리게 하지 않음)
            // wget을 사용하여 비동기 호출
            $encodedAddr = urlencode($building_address);
            $triggerUrl = "https://fms.iwin.kr/brother/api_auto_register.php?address=" . $encodedAddr;
            
            // 리눅스 백그라운드 실행 명령어 (> /dev/null 2>&1 &)
            exec("wget -q -O - '$triggerUrl' > /dev/null 2>&1 &");
        }
    } else {
        writeLog("DB 에러: " . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    writeLog("시스템 에러: " . $e->getMessage());
}
mysqli_close($connect);
?>