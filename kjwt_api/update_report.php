<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <24.05.20>
    // Description: <레포트 경영탭 업데이트>
    // Last Modified: <25.09.18> - Refactored for PHP 8.x, Security, and Maintainability
    // =============================================

    // --- 의존성 파일 포함 ---
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';  
    include_once __DIR__ . '/../DB/DB3.php';  
    include_once __DIR__ . '/../FUNCTION.php';  

    // --- 유틸리티 함수 정의 ---

    /**
     * 쿼리 실행 실패 시 오류를 출력하고 스크립트를 종료합니다.
     * @param mixed $stmt 실행된 statement
     * @param string $query 실행된 쿼리 문자열
     */
    function handle_sql_error($stmt, $query) {
        if ($stmt === false) {
            // sqlsrv의 경우
            if (function_exists('sqlsrv_errors')) {
                die("쿼리 실행 실패: " . print_r(sqlsrv_errors(), true) . "\nQuery: " . $query);
            }
            // mysqli의 경우
            global $connect3;
            if ($connect3 && $connect3->error) {
                die("쿼리 실행 실패: " . $connect3->error . "\nQuery: " . $query);
            }
            die("알 수 없는 데이터베이스 오류가 발생했습니다.\nQuery: " . $query);
        }
    }

    /**
     * MSSQL 업데이트 쿼리를 실행합니다.
     * @param PDO $connect DB 커넥션
     * @param string $kind 업데이트할 KIND (YYYYMM)
     * @param string $field 업데이트할 필드명
     * @param mixed $value 업데이트할 값
     */
    function update_fee_record($connect, $kind, $field, $value) {
        // MSSQL의 INT 타입 컬럼 호환성을 위해 값을 정수로 변환합니다.
        $intValue = (int)floatval($value);
        $sql = "UPDATE CONNECT.dbo.FEE SET {$field}=? WHERE KIND=?";
        $params = [$intValue, $kind];
        $stmt = sqlsrv_query($connect, $sql, $params);
        handle_sql_error($stmt, $sql);
    }


    // --- 기본 변수 및 날짜 설정 ---
    try {
        $today = new DateTime();
        $current_year = $today->format('Y');
    } catch (Exception $e) {
        die("날짜 생성 실패: " . $e->getMessage());
    }

    // --- 데이터베이스에서 마지막 기록 조회 ---
    $query_last_fee = "SELECT TOP 1 KIND, WATER, GAS, ELECTRICITY, ELECTRICITY2, PAY, PAY2, DELIVERY FROM CONNECT.dbo.FEE ORDER BY KIND DESC";
    $stmt_last_fee = sqlsrv_query($connect, $query_last_fee);
    handle_sql_error($stmt_last_fee, $query_last_fee);
    $last_fee = sqlsrv_fetch_array($stmt_last_fee, SQLSRV_FETCH_ASSOC);

    if (!$last_fee) {
        die("FEE 테이블에서 데이터를 찾을 수 없습니다.");
    }

    // --- 처리할 월(KIND) 결정 ---
    try {
        $last_kind_date = DateTime::createFromFormat('Ym', $last_fee['KIND']);
        if ($last_kind_date === false) {
            throw new Exception("마지막 KIND 날짜 형식이 잘못되었습니다: " . $last_fee['KIND']);
        }

        // 모든 항목이 채워졌는지 확인
        $all_filled = !empty($last_fee['WATER']) && !empty($last_fee['GAS']) && !empty($last_fee['ELECTRICITY']) && !empty($last_fee['PAY']) && !empty($last_fee['PAY2']) && !empty($last_fee['DELIVERY']);

        if ($all_filled) {
            $target_date = (clone $last_kind_date)->modify('+1 month');
            $target_kind = $target_date->format('Ym');

            // 새 레코드 삽입
            $query_insert = "INSERT INTO CONNECT.dbo.FEE(KIND) VALUES(?)";
            $stmt_insert = sqlsrv_query($connect, $query_insert, [$target_kind]);
            handle_sql_error($stmt_insert, $query_insert);
        } else {
            $target_date = $last_kind_date;
            $target_kind = $last_fee['KIND'];
        }
        
        $prev_month_date = (clone $target_date)->modify('-1 month');

    } catch (Exception $e) {
        die("날짜 처리 오류: " . $e->getMessage());
    }


    // --- 각 항목별 텍스트 및 업데이트 로직 처리 ---

    // 각 항목에 대해 대상 월의 데이터를 조회하고, 존재하면 업데이트합니다.

    // 1. 상하수도요금 (WATER)
    $water_text = $target_date->format('n월') . ' 상하수도요금';
    $sql_water = "SELECT amt FROM t_ex_expend_list WHERE create_date LIKE ? AND note LIKE ? ORDER BY create_date LIMIT 1";
    $stmt_water = $connect3->execute_query($sql_water, [$current_year . '%', $water_text . '%']);
    handle_sql_error($stmt_water, $sql_water);
    $water_data = $stmt_water->fetch_assoc();
    if ($water_data && $water_data['amt'] > 0) {
        update_fee_record($connect, $target_kind, 'WATER', $water_data['amt']);
    }

    // 2. 가스요금 (GAS)
    $gas_text = $target_date->format('n월') . ' 본사 가스요금';
    $sql_gas = "SELECT amt FROM t_ex_expend_list WHERE create_date LIKE ? AND note LIKE ? ORDER BY create_date LIMIT 1";
    $stmt_gas = $connect3->execute_query($sql_gas, [$current_year . '%', $gas_text]);
    handle_sql_error($stmt_gas, $sql_gas);
    $gas_data = $stmt_gas->fetch_assoc();
    if ($gas_data && $gas_data['amt'] > 0) {
        update_fee_record($connect, $target_kind, 'GAS', $gas_data['amt']);
    }

    // 3. 전기요금 (ELECTRICITY) - 아이윈오토 제외
    $sql_elec = "SELECT amt FROM t_ex_expend_list WHERE note LIKE '%본사 전기요금%' AND note NOT LIKE '%아이윈오토%' ORDER BY create_date DESC LIMIT 1";
    $stmt_elec = $connect3->execute_query($sql_elec);
    handle_sql_error($stmt_elec, $sql_elec);
    $elec_data = $stmt_elec->fetch_assoc();
    if ($elec_data && $elec_data['amt'] > 0) {
        update_fee_record($connect, $target_kind, 'ELECTRICITY', $elec_data['amt']);
    }

    // 4. 전기요금2 (ELECTRICITY2) - 아이윈오토
    $sql_elec2 = "SELECT amt FROM t_ex_expend_list WHERE note LIKE '%본사 전기요금%' AND note LIKE '%아이윈오토%' ORDER BY create_date DESC LIMIT 1";
    $stmt_elec2 = $connect3->execute_query($sql_elec2);
    handle_sql_error($stmt_elec2, $sql_elec2);
    $elec2_data = $stmt_elec2->fetch_assoc();
    if ($elec2_data && $elec2_data['amt'] > 0) {
        update_fee_record($connect, $target_kind, 'ELECTRICITY2', $elec2_data['amt']);
    }

    // 5. 사무직급여 (PAY)
    $pay_text = $target_date->format('Y년m월') . ' 급여';
    $sql_pay = "SELECT doc_xml FROM teag_appdoc_interlock WHERE created_dt LIKE ? AND doc_xml LIKE ? LIMIT 1";
    $stmt_pay = $connect3->execute_query($sql_pay, [$current_year . '%', '%' . $pay_text . '%']);
    handle_sql_error($stmt_pay, $sql_pay);
    $pay_data = $stmt_pay->fetch_assoc();
    if ($pay_data) {
        // 원본 코드의 오프셋(208)은 htmlspecialchars 처리된 문자열 기준이므로, 동일하게 처리합니다.
        $encoded_xml = htmlspecialchars($pay_data['doc_xml']);
        $pay_location = strpos($encoded_xml, '합 계');
        if ($pay_location !== false) {
            $pay_amount_str = substr($encoded_xml, $pay_location + 208, 11);
            $pay_amount = (int) filter_var($pay_amount_str, FILTER_SANITIZE_NUMBER_INT);
            if ($pay_amount > 0) {
                update_fee_record($connect, $target_kind, 'PAY', $pay_amount);
            }
        }
    }

    // 6. 도급직급여 (PAY2)
    $pay2_text = $target_date->format('n월') . ' 외주가공';
    $sql_pay2 = "SELECT sum(DISTINCT std_amt) as amt FROM t_ex_expend_list WHERE auth_date LIKE ? AND note LIKE ?";
    $stmt_pay2 = $connect3->execute_query($sql_pay2, [$current_year . '%', $pay2_text . '%']);
    handle_sql_error($stmt_pay2, $sql_pay2);
    $pay2_data = $stmt_pay2->fetch_assoc();
    if ($pay2_data && $pay2_data['amt'] > 0) {
        update_fee_record($connect, $target_kind, 'PAY2', $pay2_data['amt']);
    }

    // 7. 운반비 (DELIVERY)
    $delivery_month_str = $prev_month_date->format('Ym');
    $sql_delivery = "SELECT SUM(AM_CR) AS AM_CR FROM NEOE.NEOE.V_FI_DAYSUM WHERE CD_ACCT='56200' AND CD_COMPANY='1000' AND DT_ACCT LIKE ?";

    // 이전 달 운반비 업데이트
    $stmt_delivery_prev = sqlsrv_query($connect, $sql_delivery, [$delivery_month_str . '%']);
    handle_sql_error($stmt_delivery_prev, $sql_delivery);
    $delivery_data_prev = sqlsrv_fetch_array($stmt_delivery_prev, SQLSRV_FETCH_ASSOC);
    if ($delivery_data_prev && $delivery_data_prev['AM_CR'] > 0) {
        update_fee_record($connect, $prev_month_date->format('Ym'), 'DELIVERY', $delivery_data_prev['AM_CR']);
    }

    // 현재 대상 월 운반비 업데이트
    $delivery_current_month_str = $target_date->format('Ym');
    $stmt_delivery_current = sqlsrv_query($connect, $sql_delivery, [$delivery_current_month_str . '%']);
    handle_sql_error($stmt_delivery_current, $sql_delivery);
    $delivery_data_current = sqlsrv_fetch_array($stmt_delivery_current, SQLSRV_FETCH_ASSOC);
    if ($delivery_data_current && $delivery_data_current['AM_CR'] > 0) {
        update_fee_record($connect, $target_kind, 'DELIVERY', $delivery_data_current['AM_CR']);
    }

    echo "레포트 업데이트 작업이 완료되었습니다.";

    // --- 데이터베이스 연결 해제 ---
    if (isset($connect)) { sqlsrv_close($connect); }
    if (isset($connect3)) { $connect3->close(); }
?>