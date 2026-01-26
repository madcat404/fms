<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.04.11>
	// Description:	<bb 조회 (pda용)>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php'; 
    include_once __DIR__ . '/../DB/DB2.php';
    include_once __DIR__ . '/../FUNCTION.php';
   
    //★메뉴 진입 시 실행
    
    // 변수 초기화 (오류 방지)
    $Result_InputBB = null;
    $Count_InputBB = 0;

    //금일 입고 데이터 조회 (매개변수화된 쿼리 사용)
    $Query_InputBB = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.BB_INPUT_LOG WHERE SORTING_DATE = ? GROUP BY CD_ITEM";
    $params = [$Hyphen_today];
    
    // 정의되지 않은 $options 변수 제거
    $Result_InputBB = sqlsrv_query($connect, $Query_InputBB, $params);

    // 쿼리 실행 실패 시에도 뷰 파일에서 오류가 나지 않도록 처리
    if ($Result_InputBB) {
        // sqlsrv_num_rows는 일부 커서 유형에서만 정확하므로, 뷰에서 while 루프로 처리하는 것이 더 안정적입니다.
        // 이 변수는 기존 for 루프 호환성을 위해 남겨두지만, while 루프 사용을 권장합니다.
        $count = sqlsrv_num_rows($Result_InputBB);
        // 만약 sqlsrv_num_rows가 false를 반환하는 경우를 대비
        $Count_InputBB = ($count === false) ? 0 : $count;
    } else {
        // 쿼리 실패 시 뷰에서 참조할 수 있도록 변수 초기화
        $Result_InputBB = null;
        $Count_InputBB = 0;
    }
?>