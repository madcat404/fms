<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <24.08.21>
    // Description: <관리자 화면>
    // Last Modified: <25.09.11> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    // ★ DB 연결 및 세션 초기화
    include_once realpath('../session/ip_session.php');
    include_once realpath('../DB/DB2.php');
    include_once realpath('../DB/DB4.php');

    // ★ 매뉴 진입 시 탭 활성화
    $tab_sequence = 2;
    include_once realpath('../TAB.php');
    

    // ★ 공통 데이터 개수 조회 함수
    function fetchCount($connection, $query, $params = []) {
        $stmt = executeQuery($connection, $query, $params);
        return ($stmt) ? sqlsrv_num_rows($stmt) : 0;
    }

    // ★ 현장 데이터 조회
    $Minus7DayCondition = "SORTING_DATE < ?";
    $Minus7DayParams = [$Minus7Day];

    // 테이블 이름 및 설명 매핑
    $storageTables = [
        'CONNECT.dbo.FIELD_PROCESS_FINISH_V' => 'Count_FieldVietnam',
        'CONNECT.dbo.FIELD_PROCESS_FINISH' => 'Count_FieldKorea',
        'CONNECT.dbo.FINISHED_INPUT_LOG' => 'Count_FieldInput',
        'CONNECT.dbo.FINISHED_OUTPUT_LOG' => 'Count_FieldOutput'
    ];

    // 데이터 저장 배열
    $storageCounts = [];
    foreach ($storageTables as $tableName => $description) {
        $query = "SELECT * FROM $tableName WHERE $Minus7DayCondition";
        $storageCounts[$description] = fetchCount($connect, $query, $Minus7DayParams);
    }

    // ★ 레포트 데이터 조회
    $Query_Fee = "SELECT * FROM CONNECT.dbo.FEE WHERE KIND = ?";
    $Result_Fee = executeQuery($connect, $Query_Fee, [$Minus1YM2]);
    $Data_Fee = ($Result_Fee) ? sqlsrv_fetch_array($Result_Fee) : null;

    // 선박링크 확인
    $Query_Export = "
        SELECT a.vessel as vessel, b.imo as imo 
        FROM CONNECT.dbo.DISTRIBUTION a 
        LEFT JOIN CONNECT.dbo.VESSEL b ON a.vessel = b.name 
        WHERE a.SORTING_DATE = ? AND a.complete_dt IS NULL AND b.imo IS NULL";
    $Result_Export = executeQuery($connect, $Query_Export, [$NoHyphen_today]);
    $Data_Export = ($Result_Export) ? sqlsrv_fetch_array($Result_Export) : null;

    // ★ 온습도 데이터 조회
    // 공통 데이터 조회 함수 (MySQL 전용)
    function getDataCount($connection, $tableName, $dateCondition, $limit = 1, $field = 'DT') {
        $query = "SELECT * FROM $tableName WHERE $field > ? ORDER BY $field DESC LIMIT ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("si", $dateCondition, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows;
    }

    // 온습도 테이블 정의
    $storageAreas = [
        'filed' => 'f_count',
        'materials_storage' => 'm_count',
        'bb_storage' => 'b_count',
        'finished_storage' => 'fs_count',
        'ecu_storage' => 'e_count',
        'mask_storage' => 'ms_count',
        'svr_room' => 'srv_count',
        'experiment_room' => 'testA_count',
        'experiment_room2' => 'testB_count',
        'qc_room' => 'qc_count'
    ];

    // 데이터 저장
    $humidityCounts = [];
    foreach ($storageAreas as $tableName => $areaDescription) {
        $humidityCounts[$areaDescription] = getDataCount($connect4, $tableName, $Hyphen_today_zero);
    }

    // ★ API 데이터 조회
    // 공통 함수
    function getOilData($connection, $date, $carOilType) {
        $query = "SELECT * FROM oil_price WHERE S_DATE = ? AND CAR_OIL = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ss", $date, $carOilType);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result) ? $result->fetch_assoc() : null;
    }

    // 유종별 데이터 조회
    $oilTypes = ['휘발유', '경유', 'LPG'];
    $oilData = [];
    foreach ($oilTypes as $oilType) {
        $oilData[$oilType] = getOilData($connect4, $Hyphen_today, $oilType);
    }

    // API 결과 사용
    $oilGasolineData = $oilData['휘발유'] ?? null;
    $oilDieselData = $oilData['경유'] ?? null;
    $oilLpgData = $oilData['LPG'] ?? null;
?>