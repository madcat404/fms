<?php 	
	// =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.10.12>
	// Description:	<공휴일 API 모듈>	
	// Last Modified: <25.10.13> - Refactored for PHP 8.x and security.
	// =============================================
	//php.inid의 ;extension=php_curl.dll주석을 해제
	//.../php/libssh2.dll을 .../apache2.4/bin로 복사 후 서비스 재시작
	//xml 파서도 설치해야함
	include '../session/ip_session.php'; 
	include '../DB/DB1.php';  
				
	//오늘 날짜를 변수 $s_date에 저장   
	$s_date = date("Y-m-d");
	$s_yy = substr($s_date, 0, 4);	
	$s_mm = substr($s_date, 5, 2);
	$s_dd = substr($s_date, 8, 2);

	//다음달
	$s_mm2 = $s_mm+1;
	
	//10, 11, 12월이 아닌경우
	if(strlen($s_mm2)==1) {
		$s_mm2 = "0"."$s_mm2";
	}
	//년도가 변경되는 경우
	if($s_mm2==13) {
		$s_yy = $s_yy+1;
		$s_mm2 = "01";
	}
	elseif($s_mm2==14) {
		$s_yy = $s_yy+1;
		$s_mm2 = "02";
	}

	$s_date2 = "$s_yy"."-"."$s_mm2"."-"."$s_dd";	
	
	//api call 절약
	$API_query= "select * from duty_holiday order by dt desc limit 1";
	$API_result = $connect->query($API_query);  //쿼리실행
	$row = mysqli_fetch_object($API_result);

	//다음달 데이터가 있는지 확인
	if($s_mm2==substr($row->dt,4,2)) {
		echo "<script>location.href='../index.php';</script>";
	}
	else {	
		//공공데이터포털 일일 허용 call 수 10000번
		// 보안 참고: API 키는 소스코드에 직접 하드코딩하는 것보다 별도의 설정 파일로 분리하여 관리하는 것이 안전합니다.
		$url = "http://apis.data.go.kr/B090041/openapi/service/SpcdeInfoService/getHoliDeInfo?solYear="."$s_yy"."&solMonth="."$s_mm2"."&ServiceKey=IO031b0twVJ4cXrhqlKAl4Xfdka2wMvW3cQMkOfuRqUnapo9YQNb16qvhxv7U6DF%2Bma7k25nALytcJTdKPlVYw%3D%3D";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			$error_message = curl_error($ch);
			curl_close($ch);
			// XSS 방지를 위해 오류 메시지를 이스케이프합니다.
			$safe_error_message = htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8');
			echo "<script>alert('cURL Error: " . $safe_error_message . "'); location.href='../index.php';</script>";
			exit;
		}
		
		curl_close($ch); 
		
		libxml_use_internal_errors(true);
		$object = simplexml_load_string($response);

		if ($object === false) {
			// XML 파싱 오류. 응답이 비어 있거나 형식이 잘못되었을 수 있습니다.
			echo "<script>alert('Failed to parse XML response from holiday API.'); location.href='../index.php';</script>";
			exit;
		}

		// API 자체에서 반환하는 오류 확인 (예: 서비스 키 만료)
		if (isset($object->header) && (string)$object->header->resultCode !== '00') {
			$errorMsg = isset($object->header->resultMsg) ? (string)$object->header->resultMsg : 'Unknown API Error';
			// XSS 방지를 위해 오류 메시지를 이스케이프합니다.
			$safe_error_message = htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8');
			echo "<script>alert('API Error: " . $safe_error_message . "'); location.href='../index.php';</script>";
			exit;
		}

		// 공휴일 데이터 처리
		$totalCount = isset($object->body, $object->body->totalCount) ? (int)$object->body->totalCount : 0;

		if ($totalCount > 0 && isset($object->body->items, $object->body->items->item)) {
			// SQL 인젝션 방지를 위해 Prepared Statement를 준비합니다.
			$check_stmt = $connect->prepare("SELECT dt FROM duty_holiday WHERE dt = ?");
			$insert_stmt = $connect->prepare("INSERT INTO duty_holiday(dt, holiday_yn, holiday_name) VALUES(?, 'Y', ?)");

			foreach ($object->body->items->item as $item) {
				if (isset($item->locdate, $item->dateName)) {
					$locdate = (string)$item->locdate;
					$dateName = (string)$item->dateName;
					
					// 이미 데이터가 있는지 확인
					$check_stmt->bind_param("s", $locdate);
					$check_stmt->execute();
					$check_result = $check_stmt->get_result();
					
					if ($check_result->num_rows == 0) {
						// 데이터 삽입
						$insert_stmt->bind_param("ss", $locdate, $dateName);
						$insert_stmt->execute();
					}
				}
			}
			// statement를 닫습니다.
			$check_stmt->close();
			$insert_stmt->close();
		}
				
		//다음달 마지막 일
		$s_mm_last_day = date('t', strtotime($s_date2));

		for($j=1; $j<=$s_mm_last_day; $j++) {	

			$day_padded = str_pad($j, 2, '0', STR_PAD_LEFT);

			$s_date3 = "$s_yy"."$s_mm2"."$day_padded";

			//요일검증
			$s_date4 = "$s_yy"."-"."$s_mm2"."-"."$day_padded";			
			$s_weekend = date('w', strtotime($s_date4));

			//토, 일 데이터 삽입
			if($s_weekend=='0' or $s_weekend=='6') {
				//api 데이터 확인
				$check_holiday= "select * from duty_holiday where dt = '$s_date3'";
				$check_holiday_result = $connect->query($check_holiday);  //쿼리실행
				$num_result = $check_holiday_result->num_rows;
				
				//api에서 입력한 값을 주말보다 우선함
				if($num_result<1) {
					$insert_holiday2 = "insert into duty_holiday(dt, holiday_yn, holiday_name) values('$s_date3', 'Y', '주말')";
					$connect->query($insert_holiday2);  //쿼리실행	
				}
			}		
		}

		echo "<script>location.href='duty_create.php';</script>";
	}

    //MARIA DB 메모리 회수
    mysqli_close($connect);
?>