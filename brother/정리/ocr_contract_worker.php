<?php
// brother/ocr_contract_worker.php
// 계약서 OCR 분석 및 파싱 워커 (사용자 지정 순차 검색 로직 적용)

set_time_limit(0);
ini_set('memory_limit', '-1');

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

    $new_contract_start = null;
    $new_contract_end = null;
    $new_deposit = null;
    $new_monthly_rent = null;


    // [1] 성명(법인명)
    if (preg_match_all('/성명\s*\(법인명\)(?:\s*주소)?\s*[:\s\.]*([가-힣]{2,20})/u', $accumulatedText, $matches)) {
        if (isset($matches[1][0])) $new_lessor_name = trim($matches[1][0]);
        if (isset($matches[1][1])) $new_lessee_name = trim($matches[1][1]);
    }

    // [2] 전화번호
    if (preg_match('/임대사업자\s*주민등록번호\s*전화번호\s*[:\s\.]*([^\n]+)/u', $accumulatedText, $m)) {
        $tempStr = $m[1];
        if (preg_match('/01[016789][\s\-]?[0-9]{3,4}[\s\-]?[0-9]{4}/', $tempStr, $ph)) {
             $new_lessor_phone = str_replace(' ', '', $ph[0]); 
        } else {
             $new_lessor_phone = preg_replace('/[^0-9\-]/', '', $tempStr);
        }
    }
    if (preg_match('/임차인\s*주민등록번호\s*전화번호\s*[:\s\.]*([^\n]+)/u', $accumulatedText, $m)) {
        $tempStr = $m[1];
        if (preg_match('/01[016789][\s\-]?[0-9]{3,4}[\s\-]?[0-9]{4}/', $tempStr, $ph)) {
             $new_lessee_phone = str_replace(' ', '', $ph[0]); 
        } else {
             $new_lessee_phone = preg_replace('/[^0-9\-]/', '', $tempStr);
        }
    }

    // [3] 주민등록번호
    if (preg_match('/\(사업자등록번호\)\s*[:\s\.]*(\d{6})/u', $accumulatedText, $m)) {
        $new_lessor_birth = $m[1];
    }

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

    // [4] 공인중개사 정보
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

    // [5] 주소 및 전용면적
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

    if (empty($new_building_address)) {
        $bodyText = ($realtorPos !== false) ? mb_substr($accumulatedText, 0, $realtorPos) : $accumulatedText;
        if (preg_match('/(?:주택\s*)?소재지[^\n]*\s+([^\n]+)/u', $bodyText, $m)) {
            $addrCandidate = trim($m[1]);
            if (strpos($addrCandidate, '대표사무소') === false) {
                $new_building_address = $addrCandidate;
            }
        }
    }

    if (preg_match('/전용면적[^\d]*([\d\.]+)/u', $accumulatedText, $m)) {
        $new_exclusive_area = $m[1];
    }
    
    // ============================================================
    // [6] 계약 기간 및 금액 파싱 (사용자 지정 순차 검색 로직)
    // ============================================================

    // A. 계약 기간 (YYYY년 MM월 DD일)
    if (preg_match('/(\d{4})\s*년\s*(\d{1,2})\s*월\s*(\d{1,2})\s*일[^\n]*?(\d{4})\s*년\s*(\d{1,2})\s*월\s*(\d{1,2})\s*일/u', $accumulatedText, $m)) {
        $new_contract_start = sprintf('%04d-%02d-%02d', $m[1], $m[2], $m[3]);
        $new_contract_end = sprintf('%04d-%02d-%02d', $m[4], $m[5], $m[6]);
    }

    // B. 보증금 (임대보증금) - 기존 로직 유지
    // "임대보증금" 뒤의 ₩ 뒤의 숫자
    if (preg_match('/(?:임대|전세)?\s*보증금.{0,200}?[₩￦Ww]\s*([\d,]+)/su', $accumulatedText, $m)) {
        $new_deposit = str_replace(',', '', $m[1]);
    } 
    elseif (preg_match('/(?:임대|전세)?\s*보증금.{0,200}?([1-9][\d,]{5,})\s*원/su', $accumulatedText, $m)) {
         $new_deposit = str_replace(',', '', $m[1]);
    }

    // C. 월 임대료 (월차임) - [요청하신 순차 검색 로직]
    // 1단계: "계약조건" (또는 계약내용, 제1조 등 헤더) 찾기
    $posStart = 0;
    $startKeywords = ['계약조건', '계약내용', '제1조', '부동산의 표시'];
    
    foreach($startKeywords as $kw) {
        $p = mb_strpos($accumulatedText, $kw);
        if ($p !== false) {
            $posStart = $p;
            break;
        }
    }

    // 2단계: 그 다음으로 "₩" (첫 번째 ₩: 보통 보증금) 찾기
    // $posFirstWon 위치를 찾음
    $posFirstWon = false;
    $wonSymbols = ['₩', '￦', 'W', 'w'];
    $minDist = 999999;

    foreach ($wonSymbols as $sym) {
        $p = mb_strpos($accumulatedText, $sym, $posStart);
        if ($p !== false && $p < $minDist) {
            $minDist = $p;
            $posFirstWon = $p;
        }
    }

    // 3단계: 첫 번째 ₩ 이후에 "월임대료" (또는 월세, 차임) 찾기
    $posRentKeyword = false;
    
    // 만약 첫 번째 ₩를 못 찾았으면, 시작점부터 그냥 찾음 (안전장치)
    $searchBase = ($posFirstWon !== false) ? $posFirstWon : $posStart;
    
    $rentKeywords = ['월임대료', '월차임', '차임', '월세'];
    $minDist = 999999;

    foreach ($rentKeywords as $kw) {
        $p = mb_strpos($accumulatedText, $kw, $searchBase);
        if ($p !== false && $p < $minDist) {
            $minDist = $p;
            $posRentKeyword = $p;
        }
    }

    // 4단계: 월임대료 이후에 나오는 "₩"를 찾아서 금액 추출
    if ($posRentKeyword !== false) {
        // 월임대료 키워드 뒤 200자 잘라내기
        $rentChunk = mb_substr($accumulatedText, $posRentKeyword, 200);
        
        // ₩, ￦, W 뒤의 숫자 추출 (여기가 최종 타겟)
        if (preg_match('/[₩￦Ww]\s*([\d,]+)/u', $rentChunk, $m)) {
            $val = str_replace(',', '', $m[1]);
            if (is_numeric($val)) {
                $new_monthly_rent = $val;
            }
        }
    }


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

        $final_contract_start = !empty($row['contract_start_date']) ? $row['contract_start_date'] : $new_contract_start;
        $final_contract_end = !empty($row['contract_end_date']) ? $row['contract_end_date'] : $new_contract_end;
        $final_deposit = !empty($row['deposit']) ? $row['deposit'] : $new_deposit;
        $final_monthly_rent = !empty($row['monthly_rent']) ? $row['monthly_rent'] : $new_monthly_rent;

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
        
        $final_contract_start = $new_contract_start;
        $final_contract_end = $new_contract_end;
        $final_deposit = $new_deposit;
        $final_monthly_rent = $new_monthly_rent;
    }
    
    // DB 업데이트
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
                lessee_sex = ?,
                contract_start_date = ?,
                contract_end_date = ?,
                deposit = ?,
                monthly_rent = ?
            WHERE no = ?";
            
    $stmt = mysqli_prepare($connect, $sql);
    
    $cnt = 1; 

    mysqli_stmt_bind_param($stmt, "sissssssssssssssssi", 
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
        $final_contract_start,
        $final_contract_end,
        $final_deposit,
        $final_monthly_rent,
        $dbId
    );
    
    mysqli_stmt_execute($stmt);
    
    writeLog("성공: Contract ID $dbId 처리 완료. 보증금:$final_deposit, 월세:$final_monthly_rent");

} catch (Exception $e) {
    writeLog("에러: " . $e->getMessage());
    $msg = "에러: " . $e->getMessage();
    
    $sql = "UPDATE brother_contract SET ocr_raw_data = ? WHERE no = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "si", $msg, $dbId);
    mysqli_stmt_execute($stmt);
}
?>