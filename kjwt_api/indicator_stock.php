<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <21.02.02>
    // Description: <네이버 금융 주식 현재가 스크레이핑>
    // Last Modified: <25.09.17> - Refactored for PHP 8.x, Security, and Stability
    // =============================================
    // --- Setup and Includes ---
    set_time_limit(120);
    include '../session/ip_session.php';

    /**
     * Fetches the current stock price from Naver Finance.
     * @param string $stockCode
     * @return int|null
     */
    function getStockPrice(string $stockCode): ?int
    {
        $url = 'https://finance.naver.com/item/main.nhn?code=' . $stockCode;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        $htmlContent = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || empty($htmlContent)) {
            error_log("Failed to fetch stock page for code: {$stockCode}, HTTP Code: {$httpCode}");
            return null;
        }

        // Naver Finance can send different encodings. Detect and convert only if not UTF-8.
        $detected_encoding = mb_detect_encoding($htmlContent, ['UTF-8', 'EUC-KR', 'CP949'], true);
        $utf8Content = $htmlContent;
        if ($detected_encoding && $detected_encoding !== 'UTF-8') {
            $utf8Content = mb_convert_encoding($htmlContent, 'UTF-8', $detected_encoding);
        }

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $utf8Content);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        // Find the screen-reader-only <dl> which contains clean data.
        $nodes = $xpath->query("//dl[@class='blind']/dd[starts-with(text(), '현재가')]");

        if ($nodes->length > 0) {
            $priceStr = $nodes->item(0)->textContent; // "현재가 787 전일대비..."
            preg_match('/현재가\s*([0-9,]+)/', $priceStr, $matches);
            if (isset($matches[1])) {
                return (int)str_replace(',', '', $matches[1]);
            }
        }

        error_log("Could not find price element for stock code: {$stockCode}");
        return null;
    }

    /**
     * 주식 가격을 DB에 Upsert (Update or Insert)하는 함수
     * @param mysqli $dbConnection
     * @param string $stockName
     * @param int $price
     * @param string $date
     */
    function upsertStockPrice(mysqli $dbConnection, string $stockName, int $price, string $date): void
    {
        // 1. 오늘 날짜로 데이터가 있는지 확인
        $stmt = $dbConnection->prepare("SELECT CURRENT FROM stock WHERE CODE = ? AND DT = ?");
        $stmt->bind_param('ss', $stockName, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            // 2. 데이터가 있으면 UPDATE
            $stmt = $dbConnection->prepare("UPDATE stock SET CURRENT = ? WHERE CODE = ? AND DT = ?");
            $stmt->bind_param('iss', $price, $stockName, $date);
            echo "- {$stockName}: 기존 가격 업데이트 -> {$price}<br>";
        } else {
            // 3. 데이터가 없으면 INSERT
            $stmt = $dbConnection->prepare("INSERT INTO stock (CODE, CURRENT, DT) VALUES (?, ?, ?)");
            $stmt->bind_param('sis', $stockName, $price, $date);
            echo "- {$stockName}: 신규 가격 입력 -> {$price}<br>";
        }

        if (!$stmt->execute()) {
            error_log("DB 작업 실패 (Stock: {$stockName}): " . $stmt->error);
            echo "- {$stockName}: DB 작업 실패.<br>";
        }
        $stmt->close();
    }

    // --- Main Execution ---
    echo "주식 현재가 업데이트를 시작합니다.<br>";

    // connect4 변수가 ip_session.php에서 생성된 mysqli 커넥션이라고 가정합니다.
    if (!isset($connect4) || $connect4->connect_error) {
        die("MariaDB 데이터베이스 연결에 실패했습니다.");
    }

    $today = date('Y-m-d');

    // 오늘 날짜의 데이터를 먼저 모두 삭제
    try {
        $deleteStmt = $connect4->prepare("DELETE FROM stock WHERE DT = ?");
        $deleteStmt->bind_param('s', $today);
        $deleteStmt->execute();
        $deletedRows = $deleteStmt->affected_rows;
        $deleteStmt->close();
        echo "- 오늘 날짜({$today})의 기존 데이터 ({$deletedRows}건)을 삭제했습니다.<br>";
    } catch (Exception $e) {
        error_log("DB DELETE 실패: " . $e->getMessage());
        echo "- 기존 데이터 삭제 중 오류가 발생했습니다.<br>";
    }

    $stocksToUpdate = [
        '아이윈' => '090150',
        '아이윈플러스' => '123010'
    ];

    foreach ($stocksToUpdate as $name => $code) {
        $price = getStockPrice($code);
        if ($price !== null) {
            upsertStockPrice($connect4, $name, $price, $today);
        } else {
            echo "- {$name}: 가격 정보를 가져오는 데 실패했습니다.<br>";
        }
    }

    // DB 연결 종료
    if (isset($connect4)) {
        mysqli_close($connect4);
    }

    echo "작업 완료.<br>";
?>