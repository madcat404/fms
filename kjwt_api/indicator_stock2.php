<?php    
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <21.02.02>
    // Description: <홈페이지 주식 API 모듈 - mssql>
    // Last Modified: <25.09.16> - Refactored for PHP 8.x, Security, and Stability
    // =============================================
    // --- Setup and Includes ---
    set_time_limit(120);
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 

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
            echo "<b>DEBUG: cURL 호출 실패. HTTP 코드: {$httpCode}</b>";
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
     * Upserts stock price into MSSQL database.
     * @param resource $dbConnection
     * @param string $stockName
     * @param int $price
     * @param string $date
     */
    /**
     * Fetches the opening stock price from Naver Finance.
     * @param string $stockCode
     * @return int|null
     */
    function upsertStockPriceMssql($dbConnection, int $price, string $date): void
    {
        // 1. 오늘 날짜로 데이터가 있는지 확인
        $checkSql = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.STOCK WHERE SORTING_DATE = ?";
        $checkParams = [$date];
        $checkStmt = sqlsrv_query($dbConnection, $checkSql, $checkParams);
        if ($checkStmt === false) {
            error_log("DB Check Failed: " . print_r(sqlsrv_errors(), true));
            echo "- DB 확인 실패.<br>";
            return;
        }
        $rowCount = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)['cnt'];
        sqlsrv_free_stmt($checkStmt);

        if ($rowCount > 0) {
            // 2. 데이터가 있으면 UPDATE
            $updateSql = "UPDATE CONNECT.dbo.STOCK SET VAL = ? WHERE SORTING_DATE = ?";
            $updateParams = [$price, $date];
            $updateStmt = sqlsrv_query($dbConnection, $updateSql, $updateParams);
            if ($updateStmt === false) {
                error_log("DB UPDATE Failed: " . print_r(sqlsrv_errors(), true));
                echo "- DB 업데이트 실패.<br>";
            } else {
                echo "- 기존 가격 업데이트 -> {$price}<br>";
            }
        } else {
            // 3. 데이터가 없으면 INSERT
            $insertSql = "INSERT INTO CONNECT.dbo.STOCK (VAL, SORTING_DATE) VALUES (?, ?)";
            $insertParams = [$price, $date];
            $insertStmt = sqlsrv_query($dbConnection, $insertSql, $insertParams);
            if ($insertStmt === false) {
                error_log("DB INSERT Failed: " . print_r(sqlsrv_errors(), true));
                echo "- DB 신규 입력 실패.<br>";
            } else {
                echo "- 신규 가격 입력 -> {$price}<br>";
            }
        }
    }

    // --- Main Execution ---
    echo "주식 현재가 업데이트를 시작합니다 (MSSQL).<br>";

    try {
        if (!isset($connect) || $connect === false) {
            throw new Exception("MSSQL 데이터베이스 연결에 실패했습니다.");
        }

        $today = date('Y-m-d');
        $stockName = '아이윈'; // For display purposes
        $stockCode = '090150';

        // Get and store CURRENT price
        $price = getStockPrice($stockCode);

        if ($price !== null) {
            echo "- {$stockName} 현재가 -> {$price}<br>";
            upsertStockPriceMssql($connect, $price, $today);
        } else {
            echo "- {$stockName}: 현재가 정보를 가져오는 데 실패했습니다.<br>";
        }

    } catch (Throwable $t) {
        echo "<h2 style='color:red;'>스크립트 실행 중 오류가 발생했습니다</h2>";
        echo "<pre>" . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
    } finally {
        if (isset($connect)) { sqlsrv_close($connect); }
    }

    echo "작업 완료.<br>";
?>