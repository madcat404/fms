<?php 	
	// =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <17.03.30>
	// Description:	<개인차량 운행일지 실시간 기름가격 API 모듈>	
	// Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
	
	include '../DB/DB1.php';
				
	$s_date = date("Y-m-d");
	$Minus1Day = date("Y-m-d", strtotime("-1 day"));
	
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

	// API 호출 기록
	$stmt = $connect->prepare("INSERT INTO oil_call_check(DT) VALUES(?)");
	$stmt->bind_param("s", $s_date);
	$stmt->execute();

	echo "<script>location.href='individual.php';</script>";