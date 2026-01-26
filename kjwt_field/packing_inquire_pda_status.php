<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.03.19>
	// Description:	<포장생산일 매핑 조회 (pda용)>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';     
    include_once __DIR__ . '/../FUNCTION.php';    
   
    //변수 생성을 여기서 직접 해야 합니다.
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // ★★★ 이 부분이 빠져서 IP가 기록되지 않았던 것입니다. ★★★
    $sip = $_SERVER['REMOTE_ADDR'];
    //★메뉴 진입 시 실행 (Refactored for performance and security)   

    // 1. 모든 IP에 대한 오늘의 패킹 데이터를 한 번에 가져옵니다.
    $all_packing_data = [];
    $query_all_packing = "
        SELECT 
            IP, 
            CD_ITEM, 
            SUM(QT_GOODS) AS QT_GOODS
        FROM CONNECT.dbo.PACKING_LOG 
        WHERE UPDATE_DATE = ?
        GROUP BY IP, CD_ITEM";
    
    $params_all_packing = [$Hyphen_today];
    $result_all_packing = sqlsrv_query($connect, $query_all_packing, $params_all_packing);

    if ($result_all_packing) {
        while ($row = sqlsrv_fetch_array($result_all_packing, SQLSRV_FETCH_ASSOC)) {
            $ip_address = $row['IP'] ?? 'UNKNOWN';
            $all_packing_data[$ip_address][] = $row;
        }
    }

    // 2. IP 주소에 따라 데이터를 필터링합니다.
    $ip_map = [
        '192.168.3.117' => '3117', '192.168.4.102' => '3117',
        '192.168.4.100' => '4100', '192.168.4.177' => '4177',
        '192.168.4.105' => '4105'
    ];
    
    $is_specific_ip = isset($ip_map[$sip]);

    if ($is_specific_ip) {
        $packing_data_for_user = $all_packing_data[$sip] ?? [];
    } else {
        // 지정되지 않은 IP의 경우, 모든 데이터를 CD_ITEM 기준으로 합산합니다.
        $total_packing_data = [];
        foreach ($all_packing_data as $ip_data) {
            foreach ($ip_data as $row) {
                $cd_item = $row['CD_ITEM'];
                if (!isset($total_packing_data[$cd_item])) {
                    $total_packing_data[$cd_item] = ['CD_ITEM' => $cd_item, 'QT_GOODS' => 0];
                }
                $total_packing_data[$cd_item]['QT_GOODS'] += $row['QT_GOODS'];
            }
        }
        $packing_data_for_user = array_values($total_packing_data);
    }