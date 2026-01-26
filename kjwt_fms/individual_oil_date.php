<?php 	
	// =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <17.03.30>
	// Description:	<개인차량 운행일지 실시간 기름가격 및 전기차 요금 수집 모듈>	
	// Last Modified: <25.12.26> - 중복 실행 방지 로직 및 전기차 크롤링 통합
	// =============================================
	
	require_once __DIR__ .'/../session/session_check.php';
	include_once __DIR__ . '/../DB/DB1.php';
				
	$s_date = date("Y-m-d");

    // --- [추가] 중복 실행 방지 체크 ---
    // 오늘 이미 API 호출이나 크롤링을 수행했는지 확인합니다.
    $check_stmt = $connect->prepare("SELECT COUNT(*) FROM oil_call_check WHERE DT = ?");
    $check_stmt->bind_param("s", $s_date);
    $check_stmt->execute();
    $check_stmt->bind_result($call_count);
    $check_stmt->fetch();
    $check_stmt->close();

    // 오늘 이미 수집 기록이 있다면 실행하지 않고 종료합니다.
    if ($call_count > 0) {
        echo "<script>location.href='individual.php';</script>";
        exit;
    }
	
	// --- 1. 유류 가격 수집 (기존 API 로직) ---
	
	// 장안주유소 API 호출
	$url = 'http://www.opinet.co.kr/api/detailById.do?code=F144170330&id=A0031983&out=xml';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($ch);
	curl_close($ch); 
	$object = simplexml_load_string($response);

	$gasoline_price = null;
	$diesel_price = null;

	if ($object && isset($object->OIL[0]->OIL_PRICE)) {
	    foreach ($object->OIL[0]->OIL_PRICE as $price_info) {
	        if ($price_info->PRODCD == 'B027') {
	            $gasoline_price = (string)$price_info->PRICE;
	        } elseif ($price_info->PRODCD == 'D047') {
	            $diesel_price = (string)$price_info->PRICE;
	        }
	    }
	}
			
	if ($gasoline_price !== null) {
	    $stmt = $connect->prepare("INSERT INTO oil_price(CAR_OIL, OIL_PRICE, S_DATE) VALUES('휘발유', ?, ?)");
	    $stmt->bind_param("ss", $gasoline_price, $s_date);
	    $stmt->execute();
	}
	
	if ($diesel_price !== null) {
	    $stmt = $connect->prepare("INSERT INTO oil_price(CAR_OIL, OIL_PRICE, S_DATE) VALUES('경유', ?, ?)");
	    $stmt->bind_param("ss", $diesel_price, $s_date);
	    $stmt->execute();
	}

	// 선암주유소 API 호출
	$url2 = 'http://www.opinet.co.kr/api/detailById.do?code=F144170330&id=A0031412&out=xml';
	$ch2 = curl_init();
	curl_setopt($ch2, CURLOPT_URL, $url2);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	$response2 = curl_exec($ch2);
	curl_close($ch2); 
	$object2 = simplexml_load_string($response2);
	
	if ($object2 && isset($object2->OIL[0]->OIL_PRICE[0]->PRICE)) {
	    $lpg_price = (string)$object2->OIL[0]->OIL_PRICE[0]->PRICE;
	    $stmt = $connect->prepare("INSERT INTO oil_price(CAR_OIL, OIL_PRICE, S_DATE) VALUES('LPG', ?, ?)");
	    $stmt->bind_param("ss", $lpg_price, $s_date);
	    $stmt->execute();
	}

    // --- 2. 전기차 충전 요금 크롤링 (성공했던 로직 반영) ---

    try {
        $ev_url = "https://www.ev.or.kr/nportal/evcarInfo/initEvcarChargePrice.do";
        $ch_ev = curl_init();
        curl_setopt($ch_ev, CURLOPT_URL, $ev_url);
        curl_setopt($ch_ev, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_ev, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36');
        curl_setopt($ch_ev, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_ev, CURLOPT_TIMEOUT, 20);

        $ev_html = curl_exec($ch_ev);
        curl_close($ch_ev);

        if ($ev_html) {
            $dom = new DOMDocument();
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $ev_html);
            $xpath = new DOMXPath($dom);

            // 안내 문구가 포함된 p 또는 div 탐색
            $nodes = $xpath->query("//div[contains(@class, 'p_info')] | //p");
            $ev_price = null;

            foreach ($nodes as $node) {
                $text = trim($node->nodeValue);
                // "평균요금" 문구에서 급속 비회원 가격 추출
                if (str_contains($text, '평균요금') && str_contains($text, '급속')) {
                    if (preg_match('/급속\(회원\/비회원\)\s*:\s*[0-9.]+\s*원\s*\/\s*([0-9.]+)\s*원/', $text, $matches)) {
                        $ev_price = (float)$matches[1];
                        break;
                    }
                }
            }

            if ($ev_price !== null && $ev_price > 0) {
                $stmt_ev = $connect->prepare("INSERT INTO oil_price(CAR_OIL, OIL_PRICE, S_DATE) VALUES('전기', ?, ?)");
                $stmt_ev->bind_param("ds", $ev_price, $s_date);
                $stmt_ev->execute();
                $stmt_ev->close();
            }
        }
    } catch (Exception $e) {
        // 오류 발생 시 중단하지 않고 기록만 진행
    }

	// --- 3. 최종 호출 기록 저장 ---
    // 모든 수집 작업이 끝난 후 기록하여 다음 실행을 방지합니다.
	$stmt_log = $connect->prepare("INSERT INTO oil_call_check(DT) VALUES(?)");
	$stmt_log->bind_param("s", $s_date);
	$stmt_log->execute();
    $stmt_log->close();

	echo "<script>location.href='individual.php';</script>";
?>