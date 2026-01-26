<?php    
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>    
    // Description: <올바로 모듈 - 1월 전년도 체크 및 0.00 데이터 제외 로직>   
    // Last Modified: <26.01.26>
    // =============================================

    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';     
    include_once __DIR__ . '/../FUNCTION.php';   

    // 1. 조회할 연도 리스트 설정 ($YY, $Minus1YY는 FUNCTION.php 정의값 사용)
    $years_to_check = array($YY);

    // 현재가 1월인 경우 전년도 데이터도 다시 확인 (데이터 누락 방지)
    if (date("n") == 1) {
        $years_to_check[] = $Minus1YY;
    }

    // API 설정
    $url = "https://api.allbaro.or.kr:27000/restApi/selectT200_4001_09";
    $header = [
        'Authorization: Basic MDgwMDAzNDEyOmFsbGJhcm9zeXM=',
        'Content-Type: application/json;charset=utf-8'
    ];

    foreach ($years_to_check as $target_year) {
        try {
            // API 요청 본문
            $body_data = array(
                "api_cert_key" => "yeIX9fXTTNOi90mpN+mDzQ==",
                "entn_lkcd" => "080003412",
                "manf_nums" => "",
                "page_no" => "N",
                "period_from_date" => $target_year . "0101",
                "period_to_date" => $target_year . "1231",
                "req_type" => "A",
                "subcd_include_yn" => "N"
            );

            $body = json_encode($body_data);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $result = curl_exec($ch);
            $curl_error = curl_error($ch);
            curl_close($ch);

            if ($curl_error) {
                error_log($target_year . "년 올바로 API cURL 에러: " . $curl_error);
                continue;
            }

            $object = json_decode($result, true);

            if (isset($object['dataList']) && is_array($object['dataList'])) {
                foreach ($object['dataList'] as $item) {
                    $give_qunt = $item['give_qunt'];
                    $give_date = $item['give_date'];
                    $work_date = $item['work_date'];

                    // [추가 로직] GIVE_QUNT가 0이거나 0.00인 경우 저장하지 않고 건너뜀
                    if (empty($give_qunt) || (float)$give_qunt <= 0) {
                        continue; 
                    }

                    // 중복 확인 쿼리 (MSSQL T-SQL 문법)
                    $Query_Chk = "SELECT COUNT(*) FROM ALLBARO WHERE WORK_DATE = ? AND GIVE_QUNT = ?";
                    $params_chk = array($work_date, $give_qunt);
                    $stmt_chk = sqlsrv_query($connect, $Query_Chk, $params_chk);

                    if ($stmt_chk === false) {
                        error_log("SQLSRV 중복 체크 에러: " . print_r(sqlsrv_errors(), true));
                        continue;
                    }

                    sqlsrv_fetch($stmt_chk);
                    $count = sqlsrv_get_field($stmt_chk, 0);
                    sqlsrv_free_stmt($stmt_chk);

                    // 신규 데이터인 경우에만 저장
                    if ($count == 0) {
                        $Query_Insert = "INSERT INTO ALLBARO (GIVE_QUNT, GIVE_DATE, WORK_DATE) VALUES (?, ?, ?)";
                        $params_ins = array($give_qunt, $give_date, $work_date);
                        $res_ins = sqlsrv_query($connect, $Query_Insert, $params_ins);

                        if ($res_ins === false) {
                            error_log("SQLSRV 데이터 삽입 실패: " . print_r(sqlsrv_errors(), true));
                        }
                    }
                }
            }
        } catch (Exception $e) {
            error_log($target_year . "년 처리 중 예외 발생: " . $e->getMessage());
        }
    }

    // 자원 해제
    if (isset($connect) && $connect) {
        sqlsrv_close($connect);
    }
?>