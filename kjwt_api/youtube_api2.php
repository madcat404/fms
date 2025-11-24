<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>	
    // Create date:	<22.12.22>
    // Description:	<유튜브 재생목록 아이템 끍어오기>
    // Last Modified: <25.09.18> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    // --- 설정 ---
    // 개발 환경에서는 오류를 확인하기 위해 아래 주석을 해제하세요.
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    include_once '../DB/DB1.php';

    // !!! 보안 경고 !!!
    // API 키를 코드에 직접 작성하는 것은 매우 위험합니다.
    // 실제 운영 환경에서는 환경 변수(getenv('YOUTUBE_API_KEY'))나 별도의 보안 설정 파일을 사용하세요.
    $apiKey = "AIzaSyB7rcH7fQpSGT-R69FgGchgO_lb-g6Mjgw"; // 여기에 실제 API 키를 임시로 유지합니다. 하지만 반드시 안전한 곳으로 옮겨야 합니다.

    // --- 활성화된 재생목록 조회 ---
    $query_playlist = "SELECT playlistId, title FROM PLAYLIST WHERE use_yn='Y'";
    $result_playlist = $connect->query($query_playlist);

    if ($result_playlist === false) {
        die("재생목록 조회 실패: " . $connect->error);
    }

    $playlists = $result_playlist->fetch_all(MYSQLI_ASSOC);
    $result_playlist->free();

    // --- 각 재생목록별 동영상 아이템 수집 ---
    $all_videos_to_insert = [];

    foreach ($playlists as $playlist) {
        $playlistId = $playlist['playlistId'];
        $playlistTitle = $playlist['title'];
        if (empty($playlistId)) {
            continue;
        }

        $params = [
            "key" => $apiKey,
            "part" => "snippet",
            "playlistId" => $playlistId,
            "maxResults" => 50
        ];

        $apiUrl = 'https://www.googleapis.com/youtube/v3/playlistItems?' . http_build_query($params);

        // API 호출
        $response_json = file_get_contents($apiUrl);
        if ($response_json === false) {
            error_log("YouTube API 호출 실패 (playlistItems): " . $playlistId);
            continue;
        }

        // JSON 파싱
        try {
            $response_data = json_decode($response_json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            error_log("YouTube API JSON 파싱 실패 (playlistItems): " . $playlistId . " - " . $e->getMessage());
            continue;
        }

        if (empty($response_data['items'])) {
            continue;
        }

        // 삽입할 데이터 배열에 추가
        foreach ($response_data['items'] as $item) {
            $title = $item['snippet']['title'] ?? '';
            // 비공개 동영상은 건너뜁니다.
            if ($title === 'Private video') {
                continue;
            }

            $all_videos_to_insert[] = [
                'channelTitle' => $item['snippet']['channelTitle'] ?? '',
                'playlistTitle' => $playlistTitle,
                'title' => $title,
                'publishedAt' => $item['snippet']['publishedAt'] ?? '',
                'videoId' => $item['snippet']['resourceId']['videoId'] ?? null
            ];
        }
    }

    // --- 데이터베이스에 일괄 삽입 ---
    if (!empty($all_videos_to_insert)) {
        // 참고: 이 쿼리가 정상 동작하려면 PLAYITEM 테이블의 videoId 컬럼에 UNIQUE 키 설정이 필요합니다.
        // ALTER TABLE PLAYITEM ADD UNIQUE (videoId);
        // INSERT IGNORE: 기본 키(PK) 또는 유니크 키(UK)가 중복될 경우, 오류를 무시하고 다음 데이터를 삽입합니다.
        $query_insert = "INSERT IGNORE INTO PLAYITEM(channelTitle, playlistTitle, title, publishedAt, videoId, use_yn) VALUES ";
        
        $value_placeholders = [];
        $bind_params = [];
        $types = '';

        foreach ($all_videos_to_insert as $video) {
            // videoId가 없는 경우 건너뜁니다.
            if (empty($video['videoId'])) {
                continue;
            }
            $value_placeholders[] = '(?, ?, ?, ?, ?, \'Y\')';
            $bind_params[] = $video['channelTitle'];
            $bind_params[] = $video['playlistTitle'];
            $bind_params[] = $video['title'];
            $bind_params[] = $video['publishedAt'];
            $bind_params[] = $video['videoId'];
            $types .= 'sssss';
        }

        if (!empty($value_placeholders)) {
            $query_insert .= implode(', ', $value_placeholders);
            
            $stmt = $connect->prepare($query_insert);
            if ($stmt === false) {
                die("Prepare 실패: " . $connect->error . "\nQuery: " . $query_insert);
            }

            $stmt->bind_param($types, ...$bind_params);

            if ($stmt->execute()) {
                echo "성공적으로 " . $stmt->affected_rows . "개의 신규 동영상을 추가했습니다.";
            } else {
                error_log("동영상 일괄 삽입 실패: " . $stmt->error);
                echo "오류: 데이터베이스에 동영상을 추가하는 데 실패했습니다.";
            }

            $stmt->close();
        } else {
            echo "추가할 신규 동영상이 없습니다.";
        }
    } else {
        echo "추가할 신규 동영상이 없습니다.";
    }

    $connect->close();
?>