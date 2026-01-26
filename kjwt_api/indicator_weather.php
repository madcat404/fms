<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <21.02.02>
    // Description: <날씨 API 모듈>
    // Last Modified: <25.09.17> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    header('Content-Type: text/html; charset=utf-8');

    // --- Setup and Includes ---
    set_time_limit(120);
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB4.php'; 

    if (!isset($connect4) || $connect4->connect_error) {
        die("MariaDB 데이터베이스 연결에 실패했습니다: " . ($connect4->connect_error ?? 'Unknown error'));
    }

    // --- Configuration ---
    $baseUrl = "https://apihub.kma.go.kr/api/typ02/openApi/VilageFcstInfoService_2.0/getVilageFcst";
    $authKey = "Q6zA848mQIaswPOPJiCG2w"; // Note: Storing API keys in a more secure way is recommended.
    $queryParams = [
        'pageNo' => 1,
        'numOfRows' => 1000,
        'dataType' => 'XML',
        'base_date' => date('Ymd'), // Use current date
        'base_time' => '0500',
        'nx' => 55,
        'ny' => 127,
        'authKey' => $authKey
    ];

    // --- API Call ---
    $url = $baseUrl . '?' . http_build_query($queryParams);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Explicitly set for security
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpCode !== 200 || !empty($curlError)) {
        die("API 호출 실패: HTTP 코드 {$httpCode}, 오류: {$curlError}");
    }

    // --- XML Parsing ---
    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        // In a real application, log these errors instead of printing them.
        $xml_errors = libxml_get_errors();
        error_log("XML 파싱 실패: " . print_r($xml_errors, true));
        die("XML 파싱 실패.");
    }

    $resultCode = (string)$xml->header->resultCode;
    if ($resultCode !== '00') {
        $errorMsg = (string)$xml->header->resultMsg;
        die("API 오류: {$errorMsg} (코드: {$resultCode})");
    }

    // --- Database Operations ---
    $today = date('Ymd');
    $tomorrow = (new DateTime())->modify('+1 days')->format('Ymd');
    $validCategories = ['TMX', 'TMN', 'SKY', 'PTY', 'REH'];
    $validTimes = ['0600', '1500'];

    try {
        // 1. Delete today's and tomorrow's data to ensure a clean slate
        $deleteStmt = $connect4->prepare("DELETE FROM weather2 WHERE fcstDate = ? OR fcstDate = ?");
        $deleteStmt->bind_param('ss', $today, $tomorrow);
        $deleteStmt->execute();
        $deletedRows = $deleteStmt->affected_rows;
        $deleteStmt->close();
        echo "- 오늘({$today})과 내일({$tomorrow})의 기존 날씨 데이터 ({$deletedRows}건)을 삭제했습니다.<br>";

        // 2. Prepare statement for insertion
        $insertStmt = $connect4->prepare("INSERT INTO weather2(category, fcstDate, fcstTime, fcstValue) VALUES (?, ?, ?, ?)");
        $insertCount = 0;

        if (isset($xml->body->items->item)) {
            // 3. Iterate and insert new data
            foreach ($xml->body->items->item as $item) {
                $fcstDate = (string)$item->fcstDate;
                $fcstTime = (string)$item->fcstTime;
                $category = (string)$item->category;
                $fcstValue = (string)$item->fcstValue;

                // Filter for relevant data points
                if (in_array($fcstTime, $validTimes) && in_array($category, $validCategories)) {
                    $insertStmt->bind_param('ssss', $category, $fcstDate, $fcstTime, $fcstValue);
                    if ($insertStmt->execute()) {
                        $insertCount++;
                    } else {
                        // Log error, but don't stop the entire script
                        error_log("DB INSERT 실패 (Category: {$category}): " . $insertStmt->error);
                    }
                }
            }
        }
        
        echo "- 날씨 정보 {$insertCount}건을 새로 입력했습니다.<br>";
        $insertStmt->close();

    } catch (Exception $e) {
        die("데이터베이스 작업 중 오류가 발생했습니다: " . $e->getMessage());
    } finally {
        // Close DB connection
        if (isset($connect4)) {
            mysqli_close($connect4);
        }
    }

    echo "작업 완료.<br>";
?>
