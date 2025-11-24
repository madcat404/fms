<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <21.08.18>
    // Description: <네이버 뉴스 API 모듈>
    // Last Modified: <25.09.17> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    header('Content-Type: text/html; charset=utf-8');

    include '../session/ip_session.php';
    include '../DB/DB2.php';

    // --- Configuration ---
    // 보안 참고: API 키를 코드에 직접 저장하는 것은 보안상 위험합니다.
    // 서버 환경 변수나 별도의 보안 설정 파일을 사용하는 것을 권장합니다.
    $clientId = "hORbwhzCBGcYczJLJslP";
    $clientSecret = "FeDX6htde6";

    $queryParams = [
        'query' => "아이윈", // http_build_query가 자동으로 URL 인코딩을 처리합니다.
        'display' => 20, // 필터링을 위해 충분히 많은 수를 요청
        'start' => 1,
        'sort' => 'sim' // 관련도순
    ];

    // --- API Call ---
    $url = "https://openapi.naver.com/v1/search/news.json?" . http_build_query($queryParams);
    $headers = [
        "X-Naver-Client-Id: " . $clientId,
        "X-Naver-Client-Secret: " . $clientSecret
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // 보안을 위해 반드시 true로 설정
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpCode !== 200 || !empty($curlError)) {
        die("API 호출 실패: HTTP 코드 {$httpCode}, 오류: {$curlError}");
    }

    // --- Response Processing ---
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE || !isset($data['items'])) {
        die("API 응답 처리 실패: " . json_last_error_msg());
    }

    // --- Filtering ---
    $filteredItems = [];

    echo "<h3>뉴스 필터링 과정 디버그:</h3>";
    echo "<table border='1' style='width:100%; border-collapse: collapse; font-size: 12px;'>";
    echo "<tr style='background-color: #f2f2f2;'><th style='padding: 5px;'>원본 제목</th><th style='padding: 5px;'>정제된 제목</th><th style='padding: 5px;'>'아이윈' 포함?</th><th style='padding: 5px;'>'앤아이윈' 포함?</th><th style='padding: 5px;'>필터 통과 여부</th></tr>";

    foreach ($data['items'] as $item) {
        if (empty($item['title'])) {
            continue;
        }
        
        $originalTitle = $item['title'];
        $cleanTitle = strip_tags(html_entity_decode($originalTitle));

        $hasIwin = preg_match('/아이윈/u', $cleanTitle) === 1;
        $hasAndIwin = preg_match('/앤아이윈/u', $cleanTitle) === 1;
        $pass = $hasIwin && !$hasAndIwin;

        echo "<tr>";
        echo "<td style='padding: 5px;'>" . htmlspecialchars($originalTitle, ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td style='padding: 5px;'>" . htmlspecialchars($cleanTitle, ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td style='padding: 5px; text-align: center;'>" . ($hasIwin ? '<b>O</b>' : 'X') . "</td>";
        echo "<td style='padding: 5px; text-align: center;'>" . ($hasAndIwin ? '<b>O</b>' : 'X') . "</td>";
        echo "<td style='padding: 5px; text-align: center; font-weight: bold; color: " . ($pass ? "green" : "red") . ";'>" . ($pass ? '통과' : '실패') . "</td>";
        echo "</tr>";

        if ($pass) {
            $item['title'] = $cleanTitle;
            $filteredItems[] = $item;
        }
    }
    echo "</table><hr>";

    // --- Database Insertion ---
    if (count($filteredItems) > 0 && isset($connect)) {
        // 필터링된 결과에서 처음 5개만 선택
        $itemsToInsert = array_slice($filteredItems, 0, 5);
        $insertCount = 0;

        // 참고: 기존 뉴스를 모두 지우고 새로 넣으려면 아래 쿼리의 주석을 해제하세요.
        sqlsrv_query($connect, "TRUNCATE TABLE CONNECT.dbo.DASHBOARD_NEWS");

        $sql = "INSERT INTO CONNECT.dbo.DASHBOARD_NEWS(title, url, dt) VALUES(?, ?, ?)";
        
        foreach ($itemsToInsert as $item) {
            // pubDate를 데이터베이스 정렬에 용이한 'Y-m-d H:i:s' 형식으로 변환합니다.
            $pubDate = new DateTime($item['pubDate']);
            $formattedDate = $pubDate->format('Y-m-d H:i:s');

            $params = [$item['title'], $item['link'], $formattedDate];
            
            // $options 변수는 원본 코드에 정의되지 않았으므로 제거합니다.
            $stmt = sqlsrv_query($connect, $sql, $params);
            if ($stmt === false) {
                // 한 건 실패해도 전체 스크립트가 멈추지 않도록 오류만 기록
                error_log("DB INSERT 실패: " . print_r(sqlsrv_errors(), true));
            } else {
                $insertCount++;
                sqlsrv_free_stmt($stmt);
            }
        }
        echo "{$insertCount}개의 뉴스를 데이터베이스에 추가했습니다.<br>";
    } else {
        echo "데이터베이스에 추가할 뉴스가 없거나 DB 연결에 실패했습니다.<br>";
    }

    // --- Cleanup ---
    if (isset($connect4)) { mysqli_close($connect4); }
    if (isset($connect)) { sqlsrv_close($connect); }

    echo "작업 완료.";
?>