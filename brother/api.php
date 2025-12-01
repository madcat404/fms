<?php

    // 1. 서비스 키 (data.go.kr에서 발급받은 '일반 인증키 (Encoded)' 사용)
    $serviceKey_encoded = 'IO031b0twVJ4cXrhqlKAl4Xfdka2wMvW3cQMkOfuRqUnapo9YQNb16qvhxv7U6DF%2Bma7k25nALytcJTdKPlVYw%3D%3D'; // 👈 여기에 발급받은 인코딩된 키를 입력하세요.

    // 2. 요청 엔드포인트 (건축물대장 기본개요 조회)
    $endpoint = 'http://apis.data.go.kr/1613000/BldRgstHubService/getBrTitleInfo';

    // 3. 요청 파라미터 (주소 정보)
    // 예시: 서울특별시 강남구(11680) 삼성동(10500) 1번지(0001-0000)
    $params = [
        'sigunguCd' => '11680', // 시군구 코드 (예: 강남구)
        'bjdongCd'  => '10300', // 법정동 코드 (예: 삼성동)
        'bun'       => '0012', // 번
        'ji'        => '0000', // 지
        'numOfRows' => '10',   // 한 페이지 결과 수
        'pageNo'    => '1',    // 페이지 번호
        '_type'     => 'json'  // 응답 형식 (json 또는 xml)
    ];

    // 4. 쿼리 스트링 생성 (http_build_query: 배열을 URL 쿼리 문자열로 변환)
    $queryString = http_build_query($params);

    // 5. 전체 요청 URL 생성 (서비스 키는 URL에 직접 추가)
    // 참고: 서비스 키를 http_build_query에 포함하면 이중 인코딩 문제가 발생할 수 있습니다.
    $fullUrl = $endpoint . '?serviceKey=' . $serviceKey_encoded . '&' . $queryString;


    // 6. cURL 초기화
    $ch = curl_init();

    // 7. cURL 옵션 설정
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 결과를 문자열로 반환
    curl_setopt($ch, CURLOPT_HEADER, false);       // 응답 헤더는 제외
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); // GET 방식 요청

    // 8. cURL 실행
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // HTTP 상태 코드 확인

    // 9. cURL 오류 처리
    if (curl_errno($ch)) {
        echo '[cURL Error] : ' . curl_error($ch);
        exit;
    }

    // 10. cURL 세션 종료
    curl_close($ch);

    // 11. 응답 처리
    echo "<h3>HTTP Status Code: $httpCode</h3>";

    if ($httpCode == 200) {
        // 11-1. JSON 응답 디코딩 (true: 연관 배열로 변환)
        $data = json_decode($response, true);

        // 11-2. JSON 파싱 오류 확인
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "[JSON Parse Error] : " . json_last_error_msg();
            echo "<hr><h3>Raw Response:</h3><pre>" . htmlspecialchars($response) . "</pre>";
        } 
        // 11-3. API 자체 응답 코드 확인 (공공데이터 API는 HTTP 200 이어도 오류 메시지를 body에 담아 보낼 수 있음)
        elseif (isset($data['response']['header']['resultCode']) && $data['response']['header']['resultCode'] == '00') {
            // 성공
            echo "<h2>API 호출 성공!</h2>";
            echo "<pre>";
            print_r($data['response']['body']); // body 데이터 출력
            echo "</pre>";
        } 
        // 11-4. API 자체 오류
        else {
            echo "<h2>API 오류</h2>";
            echo "<pre>";
            print_r($data['response']['header']); // 오류 헤더 출력
            echo "</pre>";
        }

    } else {
        echo "HTTP 오류 발생: $httpCode";
        echo "<hr><h3>Raw Response:</h3><pre>" . htmlspecialchars($response) . "</pre>";
    }

?>