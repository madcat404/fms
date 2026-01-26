<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <23.05.30>
    // Description: <다트 API 모듈>
    // Last Modified: <25.09.16> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    // --- Setup and Includes ---
    set_time_limit(120); // API 호출을 위해 실행 시간을 2분으로 설정
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';   

    // --- Configuration ---
    // API 키는 별도의 설정 파일로 분리하는 것이 가장 좋습니다.
    const DART_API_KEY = 'bb475babba1ed252b2c3e7350c5444e75b50972a';
    const CORP_CODE = '00365624';

    /**
     * DART API에서 재무 정보를 가져와 DB에 저장하는 주 함수
     * @param resource $connect DB 커넥션
     * @param string $year 사업연도
     * @param string $reportCode 보고서 코드 (11011: 사업보고서, 11013: 1분기, 11012: 반기, 11014: 3분기)
     * @return bool 성공 여부
     */
    function fetchAndStoreDartReport($connect, $year, $reportCode)
    {
        $reportNames = [
            '11011' => '사업보고서',
            '11013' => '1분기 보고서',
            '11012' => '반기 보고서',
            '11014' => '3분기 보고서'
        ];
        $reportName = $reportNames[$reportCode] ?? '알 수 없는 보고서';
        echo "<hr><b>{$year}년 {$reportName}</b> 데이터 처리 시작...<br>";

        // 1. API 호출
        $url = sprintf(
            "https://opendart.fss.or.kr/api/fnlttSinglAcntAll.xml?crtfc_key=%s&corp_code=%s&bsns_year=%s&reprt_code=%s&fs_div=CFS",
            DART_API_KEY, CORP_CODE, $year, $reportCode
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // 302 리디렉션을 자동으로 따라가도록 설정
        // 일부 API는 User-Agent 헤더를 요구하므로 추가합니다.
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // 보안을 위해 SSL 검증 활성화
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError || $httpCode !== 200) {
            echo "<span style='color:red;'>API 호출 실패 (HTTP 코드: {$httpCode}, 오류: {$curlError})</span><br>";
            return false;
        }

        // 2. XML 파싱 및 데이터 추출
        try {
            $xml = simplexml_load_string($result);
            if ($xml === false || (string)$xml->status !== '000') {
                $errorMessage = $xml ? (string)$xml->message : 'XML 파싱 실패';
                echo "<span style='color:red;'>API 응답 오류: {$errorMessage}</span><br>";
                return false;
            }

            $data = [];
            $accounts = [
                '매출액' => 'sales', '매출원가' => 'cost_of_sales', '판매비와관리비' => 'sga_expenses',
                '금융수익' => 'financial_income', '금융비용' => 'financial_expenses', '기타수익' => 'other_income',
                '기타비용' => 'other_expenses', '관계기업투자손익' => 'investment_income', '법인세비용' => 'tax_expense'
            ];

            // XPath를 사용하여 특정 계정 항목을 효율적으로 검색
            foreach ($accounts as $accountName => $key) {
                $node = $xml->xpath("//list[account_nm='{$accountName}']");
                if (!empty($node)) {
                    $data[$key] = (string)($node[0]->thstrm_add_amount ?: $node[0]->thstrm_amount);
                }
            }
            
            // 당기순이익은 이름이 여러가지일 수 있어 별도 처리
            $netIncomeNode = $xml->xpath("//list[sj_nm='포괄손익계산서' and (starts-with(account_nm, '당기순이익') or starts-with(account_nm, '분기순이익') or starts-with(account_nm, '반기순이익'))]");
            if (!empty($netIncomeNode)) {
                $data['net_income'] = (string)($netIncomeNode[0]->thstrm_add_amount ?: $netIncomeNode[0]->thstrm_amount);
                $data['thstrm_nm'] = (string)$netIncomeNode[0]->thstrm_nm;
            }

            if (empty($data['sales'])) {
                echo "필수 항목(매출액) 데이터가 없어 건너뜁니다.<br>";
                return false;
            }

        } catch (Throwable $t) {
            echo "<span style='color:red;'>XML 데이터 처리 중 오류 발생: " . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8') . "</span><br>";
            return false;
        }

        // 3. 데이터베이스에 저장 (파라미터화된 쿼리 사용)
        $nonOperatingIncome = ($data['financial_income'] ?? 0) + ($data['other_income'] ?? 0) + ($data['investment_income'] ?? 0) - (($data['financial_expenses'] ?? 0) + ($data['other_expenses'] ?? 0) + ($data['tax_expense'] ?? 0));
        
        $recordsToInsert = [
            ['매출액', $data['thstrm_nm'], $data['sales']],
            ['매출원가', $data['thstrm_nm'], $data['cost_of_sales']],
            ['판매비와관리비', $data['thstrm_nm'], $data['sga_expenses']],
            ['당기순이익', $data['thstrm_nm'], $data['net_income']],
            ['영업외이익(손실)', $data['thstrm_nm'], $nonOperatingIncome]
        ];

        sqlsrv_begin_transaction($connect);
        try {
            $insertSql = "INSERT INTO CONNECT.dbo.DART(account_nm, thstrm_nm, thstrm_amount, yy, reprt_code) VALUES (?, ?, ?, ?, ?)";
            foreach ($recordsToInsert as $record) {
                $params = [$record[0], $record[1], $record[2], $year, $reportCode];
                $stmt = sqlsrv_query($connect, $insertSql, $params);
                if ($stmt === false) {
                    throw new Exception("{$record[0]} 데이터 삽입 실패");
                }
            }
            sqlsrv_commit($connect);
            echo "<span style='color:green;'>성공적으로 DB에 저장했습니다.</span><br>";
            return true;
        } catch (Throwable $t) {
            sqlsrv_rollback($connect);
            echo "<span style='color:red;'>DB 저장 중 오류 발생: " . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8') . "</span><br>";
            return false;
        }
    }

    // --- Main Execution Logic ---
    try {
        if ($connect === false) {
            throw new Exception("데이터베이스 연결에 실패했습니다.");
        }

        $currentYear = date('Y');
        $previousYear = $currentYear - 1;

        // 1. 작년 사업보고서 확인 및 처리
        $checkSql = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.DART WHERE yy = ? AND reprt_code = '11011'";
        $stmt = sqlsrv_query($connect, $checkSql, [$previousYear]);
        $rowCount = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)['cnt'];

        if ($rowCount == 0) {
            fetchAndStoreDartReport($connect, $previousYear, '11011');
        } else {
            // 2. 올해 분기 보고서들 순차적으로 확인 및 처리
            $reportsToCheck = ['11013', '11012', '11014'];
            foreach ($reportsToCheck as $reportCode) {
                $checkSql = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.DART WHERE yy = ? AND reprt_code = ?";
                $stmt = sqlsrv_query($connect, $checkSql, [$currentYear, $reportCode]);
                $rowCount = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)['cnt'];

                if ($rowCount == 0) {
                    fetchAndStoreDartReport($connect, $currentYear, $reportCode);
                    break; // 하나를 처리하면 다음 실행까지 대기
                }
            }
        }
        echo "<hr>모든 확인 작업 완료.";

    } catch (Throwable $t) {
        echo "<h2 style='color:red;'>스크립트 실행 중 심각한 오류가 발생했습니다</h2>";
        echo "<pre>" . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
    } finally {
        if (isset($connect4)) { mysqli_close($connect4); }
        if (isset($connect)) { sqlsrv_close($connect); }
    }
?>