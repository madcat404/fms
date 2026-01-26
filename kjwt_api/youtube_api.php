<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>	
    // Create date: <22.12.22>
    // Description:	<유튜브 재생목록 끍어오기>
    // Last Modified: <25.09.18> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

     include_once '../DB/DB1.php';

    // !!! 보안 경고 !!!
    // API 키를 코드에 직접 작성하는 것은 매우 위험합니다.
    // 실제 운영 환경에서는 환경 변수(getenv('YOUTUBE_API_KEY'))나 별도의 보안 설정 파일을 사용하세요.
    $apiKey = "AIzaSyB7rcH7fQpSGT-R69FgGchgO_lb-g6Mjgw"; // 여기에 실제 API 키를 임시로 유지합니다. 하지만 반드시 안전한 곳으로 옮겨야 합니다.

    // --- 채널 목록 조회 ---
    $query_channel = "SELECT channelId FROM fms.YOUTUBE_CHANNEL";
    $result_channel = $connect->query($query_channel);

    if ($result_channel === false) {
        die("채널 목록 조회 실패: " . $connect->error);
    }

    $channels = $result_channel->fetch_all(MYSQLI_ASSOC);
    $result_channel->free();

    // --- 각 채널별 재생목록 수집 ---
    $all_playlists_to_insert = [];

    foreach ($channels as $channel) {
        $channelId = $channel['channelId'];
        if (empty($channelId)) {
            continue;
        }

        $params = [
            "key" => $apiKey,
            "part" => "snippet",
            "channelId" => $channelId,
            "maxResults" => 50
        ];

        $apiUrl = 'https://www.googleapis.com/youtube/v3/playlists?' . http_build_query($params);

        // API 호출
        $response_json = file_get_contents($apiUrl);
        if ($response_json === false) {
            error_log("YouTube API 호출 실패: " . $channelId);
            continue;
        }

        // JSON 파싱
        try {
            $response_data = json_decode($response_json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            error_log("YouTube API JSON 파싱 실패: " . $channelId . " - " . $e->getMessage());
            continue;
        }

        if (empty($response_data['items'])) {
            continue;
        }

        // 삽입할 데이터 배열에 추가
        foreach ($response_data['items'] as $item) {
            $all_playlists_to_insert[] = [
                'channelTitle' => $item['snippet']['channelTitle'] ?? '',
                'title' => $item['snippet']['title'] ?? '',
                'publishedAt' => $item['snippet']['publishedAt'] ?? '',
                'playlistId' => $item['id'] ?? ''
            ];
        }
    }

    // --- 데이터베이스에 일괄 삽입 ---
    if (!empty($all_playlists_to_insert)) {
        // INSERT IGNORE: 기본 키(PK)가 중복될 경우, 오류를 무시하고 다음 데이터를 삽입합니다.
        $query_insert = "INSERT IGNORE INTO fms.PLAYLIST(channelTitle, title, publishedAt, playlistId) VALUES ";
        
        $value_placeholders = [];
        $bind_params = [];
        $types = '';

        foreach ($all_playlists_to_insert as $playlist) {
            $value_placeholders[] = '(?, ?, ?, ?)';
            $bind_params[] = $playlist['channelTitle'];
            $bind_params[] = $playlist['title'];
            $bind_params[] = $playlist['publishedAt'];
            $bind_params[] = $playlist['playlistId'];
            $types .= 'ssss';
        }

        $query_insert .= implode(', ', $value_placeholders);
        
        $stmt = $connect->prepare($query_insert);
        if ($stmt === false) {
            die("Prepare 실패: " . $connect->error);
        }

        $stmt->bind_param($types, ...$bind_params);

        if ($stmt->execute()) {
            echo "성공적으로 " . $stmt->affected_rows . "개의 신규 재생목록을 추가했습니다.";
        } else {
            error_log("재생목록 일괄 삽입 실패: " . $stmt->error);
            echo "오류: 데이터베이스에 재생목록을 추가하는 데 실패했습니다.";
        }

        $stmt->close();
    } else {
        echo "추가할 신규 재생목록이 없습니다.";
    }

    $connect->close();
?>