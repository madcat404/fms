<?php
// brother/ocr_contract_worker.php
// 계약서 OCR 분석 및 파싱 워커 (주소 API 제거하여 원본 주소 유지)

set_time_limit(0);
ini_set('memory_limit', '-1');

// 경로 확인 필요
require_once '/var/www/html/DB/DB1.php'; 
require 'vendor/autoload.php'; 

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

function writeLog($msg) {
    file_put_contents(__DIR__ . '/contract_worker_log.txt', "[" . date('H:i:s') . "] $msg\n", FILE_APPEND);
}

if (!isset($argv[1]) || !isset($argv[2])) {
    writeLog("인자 부족: Usage: php ocr_contract_worker.php [filepath] [db_id]");
    exit;
}

$targetFilePath = $argv[1];
$dbId = $argv[2]; 

try {
    putenv('GOOGLE_APPLICATION_CREDENTIALS=/var/www/html/key.json');
    
    // 1. PDF -> 이미지 변환
    $outputPrefix = __DIR__ . "/uploads/contract_temp_" . $dbId . "_%03d.jpg";
    $cmd = "gs -dNOPAUSE -sDEVICE=jpeg -r400 -dJPEGQ=100 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -sOutputFile='$outputPrefix' '$targetFilePath' -c quit 2>&1";
    exec($cmd, $output, $returnVar);

    $images = glob(__DIR__ . "/uploads/contract_temp_" . $dbId . "_*.jpg");
    sort($images);

    if (count($images) == 0) {
        throw new Exception("PDF 변환 실패");
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
    // 3. 데이터 파싱
    // ============================================================

    $new_lessor_name = null;
    $new_lessor_phone = null;
    $new_lessor_birth = null;
    
    $new_lessee_name = null;
    $new_lessee_phone = null;
    $new_lessee_birth = null;
    $new_lessee_sex = null;
    
    $new_building_address = null;
    $new_exclusive_area = null;
    
    $new_realtor_name = null;
    $new_realtor_address = null;
    $new_realtor_phone = null;

    // [1] 성명(법인명) 추출
    if (preg_match_all('/성명\s*\(법인명\)(?:\s*주소)?\s*[:\s\.]*([가-힣]{2,20})/u', $accumulatedText, $matches)) {
        if (isset($matches[1][0])) $new_lessor_name = trim($matches[1][0]);
        if (isset($matches[1][1])) $new_lessee_name = trim($matches[1][1]);
    }

    // [2] 전화번호 추출
    // 임대인
    if (preg_match('/임대사업자\s*주민등록번호\s*전화번호\s*[:\s\.]*([^\n]+)/u', $accumulatedText, $m)) {
        $tempStr = $m[1];
        if (preg_match('/01[016789][\s\-]?[0-9]{3,4}[\s\-]?[0-9]{4}/', $tempStr, $ph)) {
             $new_lessor_phone = str_replace(' ', '', $ph[0]); 
        } else {
             $new_lessor_phone = preg_replace('/[^0-9\-]/', '', $tempStr);
        }
    }
    // 임차인
    if (preg_match('/임차인\s*주민등록번호\s*전화번호\s*[:\s\.]*([^\n]+)/u', $accumulatedText, $m)) {
        $tempStr = $m[1];
        if (preg_match('/01[016789][\s\-]?[0-9]{3,4}[\s\-]?[0-9]{4}/', $tempStr, $ph)) {
             $new_lessee_phone = str_replace(' ', '', $ph[0]); 
        } else {
             $new_lessee_phone = preg_replace('/[^0-9\-]/', '', $tempStr);
        }
    }

    // [3] 주민등록번호 추출
    // 임대인
    if (preg_match('/\(사업자등록번호\)\s*[:\s\.]*(\d{6})/u', $accumulatedText, $m)) {
        $new_lessor_birth = $m[1];
    }

    // 임차인 (주민번호 패턴 전체 검색 후 순서 기반 할당)
    preg_match_all('/(\d{6})-([1-4])\d{6}/', $accumulatedText, $birthMatches);

    if (isset($birthMatches[1][0]) && empty($new_lessor_birth)) {
        $new_lessor_birth = $birthMatches[1][0];
    }
    
    if (isset($birthMatches[1][1])) {
        if ($birthMatches[1][1] !== $new_lessor_birth) {
            $new_lessee_birth = $birthMatches[1][1];
            $genderDigit = $birthMatches[2][1];
            if ($genderDigit == '1' || $genderDigit == '3') $new_lessee_sex = '남';
            elseif ($genderDigit == '2' || $genderDigit == '4') $new_lessee_sex = '여';
        }
    }
    else if (isset($birthMatches[1][0])) {
        $matchPos = strpos($accumulatedText, $birthMatches[0][0]);
        $lesseeKeywordPos = mb_strpos($accumulatedText, '임차인');
        if ($lesseeKeywordPos !== false && $matchPos > $lesseeKeywordPos) {
             $new_lessee_birth = $birthMatches[1][0];
             $genderDigit = $birthMatches[2][0];
             if ($genderDigit == '1' || $genderDigit == '3') $new_lessee_sex = '남';
             elseif ($genderDigit == '2' || $genderDigit == '4') $new_lessee_sex = '여';
             
             if ($new_lessor_birth == $new_lessee_birth) $new_lessor_birth = null;
        }
    }

    // [4] 공인중개사 정보 추출
    $realtorPos = mb_strpos($accumulatedText, '2. 공인중개사');
    if ($realtorPos === false) {
        $realtorPos = mb_strpos($accumulatedText, '개업공인중개사');
    }
    if ($realtorPos === false) {
        $realtorPos = mb_strrpos($accumulatedText, '공인중개사');
    }

    if ($realtorPos !== false) {
        $realtorText = mb_substr($accumulatedText, $realtorPos);

        if (preg_match('/사무소\s*명칭\s*[:\s]*([^\n]+)/u', $realtorText, $m)) {
            $new_realtor_name = trim($m[1]);
        }

        if (preg_match('/(부산|서울|경기|인천|대구|광주|대전|울산|세종|강원|충북|충남|전북|전남|경북|경남|제주)[가-힣]*\s+[^\n]+(구|군|시)[^\n]+(로|길|동|읍|면)/u', $realtorText, $m)) {
             $new_realtor_address = trim($m[0]);
        }
        else if (preg_match('/(?<!대표)사무소\s*소재지\s*[:\s]*([^\n]+)/u', $realtorText, $m)) {
             $new_realtor_address = trim($m[1]);
        }

        $sosokPos = mb_strpos($realtorText, '소속공인중개사');
        $phoneSearchText = ($sosokPos !== false) ? mb_substr($realtorText, 0, $sosokPos) : $realtorText;
        
        if (preg_match_all('/01[016789][\-\s\.]?\d{3,4}[\-\s\.]?\d{4}/', $phoneSearchText, $matches)) {
            $lastPhone = end($matches[0]); 
            $new_realtor_phone = str_replace(' ', '', $lastPhone);
        }
    }

    // [5] 주소 및 전용면적 파싱 (주소 파싱 로직)
    // 1순위: "대상물건의 표시" 섹션 내의 소재지
    $targetPos = mb_strpos($accumulatedText, '대상물건의 표시');
    if ($targetPos !== false) {
        $subText = mb_substr($accumulatedText, $targetPos); 
        $tojiPosInSub = mb_strpos($subText, '토지');
        if ($tojiPosInSub !== false) {
            $subText = mb_substr($subText, 0, $tojiPosInSub);
        }
        
        if (preg_match('/(부산|서울|경기|인천|대구|광주|대전|울산|세종|강원|충북|충남|전북|전남|경북|경남|제주)[^\n]+/u', $subText, $m)) {
            $new_building_address = trim($m[0]);
        }
    }

    // 2순위: "토지" 키워드 바로 이전 주소
    if (empty($new_building_address)) {
        $tojiPos = mb_strpos($accumulatedText, '토지');
        if ($tojiPos !== false) {
            $prefix = mb_substr($accumulatedText, max(0, $tojiPos - 200), min(200, $tojiPos));
            $lines = explode("\n", $prefix);
            $lines = array_map('trim', $lines);
            $lines = array_filter($lines);
            
            if (!empty($lines)) {
                $lastLine = end($lines);
                if (preg_match('/(부산|서울|경기|인천|대구|광주|대전|울산|세종|강원|충북|충남|전북|전남|경북|경남|제주)/', $lastLine)) {
                    $new_building_address = $lastLine;
                }
            }
        }
    }

    // 3순위: 기존 로직
    if (empty($new_building_address)) {
        $bodyText = ($realtorPos !== false) ? mb_substr($accumulatedText, 0, $realtorPos) : $accumulatedText;
        if (preg_match('/(?:주택\s*)?소재지[^\n]*\s+([^\n]+)/u', $bodyText, $m)) {
            $addrCandidate = trim($m[1]);
            if (strpos($addrCandidate, '대표사무소') === false) {
                $new_building_address = $addrCandidate;
            }
        }
    }

    // [전용면적]
    if (preg_match('/전용면적[^\d]*([\d\.]+)/u', $accumulatedText, $m)) {
        $new_exclusive_area = $m[1];
    }

    // ============================================================
    // [중요] 4. 주소 정제 (Juso API) 부분 삭제됨
    // (사용자가 OCR 원본 주소 유지를 원하므로 API 연동 로직 제거)
    // ============================================================

    // ============================================================
    // 5. DB 업데이트
    // ============================================================
    
    $selectSql = "SELECT * FROM brother_contract WHERE no = ?";
    $stmt = mysqli_prepare($connect, $selectSql);
    mysqli_stmt_bind_param($stmt, "i", $dbId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($row) {
        $final_lessor_name = !empty($row['lessor_name']) ? $row['lessor_name'] : $new_lessor_name;
        $final_lessor_phone = !empty($row['lessor_phone']) ? $row['lessor_phone'] : $new_lessor_phone;
        $final_lessor_birth = !empty($row['lessor_birth_date']) ? $row['lessor_birth_date'] : $new_lessor_birth;
        
        $final_lessee_name = !empty($row['lessee_name']) ? $row['lessee_name'] : $new_lessee_name;
        $final_lessee_phone = !empty($row['lessee_phone']) ? $row['lessee_phone'] : $new_lessee_phone;
        $final_lessee_birth = !empty($row['lessee_birth_date']) ? $row['lessee_birth_date'] : $new_lessee_birth;
        $final_lessee_sex = !empty($row['lessee_sex']) ? $row['lessee_sex'] : $new_lessee_sex;

        $final_building_address = !empty($row['building_address']) ? $row['building_address'] : $new_building_address;
        $final_exclusive_area = !empty($row['exclusive_area']) ? $row['exclusive_area'] : $new_exclusive_area;
        
        $final_realtor_name = !empty($row['realtor_office_name']) ? $row['realtor_office_name'] : $new_realtor_name;
        $final_realtor_address = !empty($row['realtor_office_address']) ? $row['realtor_office_address'] : $new_realtor_address;
        $final_realtor_phone = !empty($row['realtor_phone']) ? $row['realtor_phone'] : $new_realtor_phone;

    } else {
        $final_lessor_name = $new_lessor_name;
        $final_lessor_phone = $new_lessor_phone;
        $final_lessor_birth = $new_lessor_birth;
        $final_lessee_name = $new_lessee_name;
        $final_lessee_phone = $new_lessee_phone;
        $final_lessee_birth = $new_lessee_birth;
        $final_lessee_sex = $new_lessee_sex;
        $final_building_address = $new_building_address;
        $final_exclusive_area = $new_exclusive_area;
        $final_realtor_name = $new_realtor_name;
        $final_realtor_address = $new_realtor_address;
        $final_realtor_phone = $new_realtor_phone;
    }
    
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
                realtor_office_name = ?,
                realtor_office_address = ?,
                realtor_phone = ?,
                lessee_sex = ?
            WHERE no = ?";
            
    $stmt = mysqli_prepare($connect, $sql);
    
    $cnt = 1; 

    mysqli_stmt_bind_param($stmt, "sissssssssssssi", 
        $accumulatedText, 
        $cnt, 
        $final_lessor_name, 
        $final_lessor_birth, 
        $final_lessor_phone, 
        $final_lessee_name, 
        $final_lessee_birth, 
        $final_lessee_phone, 
        $final_building_address, 
        $final_exclusive_area, 
        $final_realtor_name, 
        $final_realtor_address, 
        $final_realtor_phone,
        $final_lessee_sex,
        $dbId
    );
    
    mysqli_stmt_execute($stmt);
    
    writeLog("성공: Contract ID $dbId 처리 완료. 주소:$final_building_address");

} catch (Exception $e) {
    writeLog("에러: " . $e->getMessage());
    $msg = "에러: " . $e->getMessage();
    
    $sql = "UPDATE brother_contract SET ocr_raw_data = ? WHERE no = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "si", $msg, $dbId);
    mysqli_stmt_execute($stmt);
}
?>