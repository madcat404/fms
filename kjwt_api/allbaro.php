<?php 	
	// =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.02.20>
	// Description:	<올바로 모듈>	
    // Last Modified: <25.09.12> - Refactored for PHP 8.x, Security, and Stability
	// =============================================
	//php.inid의 ;extension=php_curl.dll주석을 해제
	//.../php/libssh2.dll을 .../apache2.4/bin로 복사 후 서비스 재시작
	//xml 파서도 설치해야함
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';  
        
    $url = "https://api.allbaro.or.kr:27000/restApi/selectT200_4001_09";
    
    $header = [
        'Authorization: Basic MDgwMDAzNDEyOmFsbGJhcm9zeXM=',
        'Content-Type: application/json;charset=utf-8'
    ];

    //금일 데이터가 있는지 확인하도록 to, from을 금일로 설정하니 문제가 발생함
    //월 1일에 전월을 확인하도록 변경
    //이때 중복데이터가 있는지 확인하는 매커니즘을 추가해야함
    //같은 일에 나눠서 폐기하는 경우도 있으니 폐기물량과 작업일 두가지 데이터로 중복이 있는지 확인할것
    $body_data = array(
        "api_cert_key" => "yeIX9fXTTNOi90mpN+mDzQ==",
        "entn_lkcd" => "080003412",
        "manf_nums" => "",
        "page_no" => "N",
        "period_from_date" => $YY."0101",
        "period_to_date" => $YY."1231",
        "req_type" => "A",
        "subcd_include_yn" => "N"
    );

    $body = json_encode($body_data);
    
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
	
		
	$result = curl_exec($ch);
	curl_close($ch);
	$object = json_decode($result, true);

    if ($curl_error) {
        // cURL 에러 처리 (예: 로그 남기기)
        error_log("cURL Error: " . $curl_error);
    } else {
        $object = json_decode($result, true);

        // JSON 디코딩 오류 및 dataList 확인
        if (json_last_error() !== JSON_ERROR_NONE || !isset($object['dataList']) || !is_array($object['dataList'])) {
            // 오류 처리 (예: 로그 남기기)
            error_log("Failed to decode JSON or dataList is invalid.");
        } else {
            foreach ($object['dataList'] as $item) {
                $give_qunt = $item['give_qunt'];
                $give_date = $item['give_date'];
                $work_date = $item['work_date'];

                // COUNT(*)를 사용하여 성능 및 명확성 개선
                $Query_ChkLastDate = "SELECT COUNT(*) FROM CONNECT.dbo.ALLBARO WHERE WORK_DATE = ? AND GIVE_QUNT = ?";
                $params_check = array($work_date, $give_qunt);                
                $stmt = sqlsrv_query($connect, $Query_ChkLastDate, $params_check);

                if ($stmt === false) {
                    // 쿼리 에러 처리
                    error_log("SQLSRV count query failed: " . print_r(sqlsrv_errors(), true));
                    continue; // 다음 반복으로 넘어감
                }
                
                sqlsrv_fetch($stmt);
                $Count_ChkLastDate = sqlsrv_get_field($stmt, 0);
                sqlsrv_free_stmt($stmt);

                if ($Count_ChkLastDate == 0) {
                    $Query_Allbaro = "INSERT INTO ALLBARO(GIVE_QUNT, GIVE_DATE, WORK_DATE) VALUES(?, ?, ?)";
                    $params_insert = array($give_qunt, $give_date, $work_date);
                    $result_insert = sqlsrv_query($connect, $Query_Allbaro, $params_insert);
                    if ($result_insert === false) {
                        error_log("SQLSRV insert failed: " . print_r(sqlsrv_errors(), true));
                    }
                }
            }
        }
    }

    // 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }
    if(isset($connect)) { sqlsrv_close($connect); }