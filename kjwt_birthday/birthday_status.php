<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.07.18>
	// Description:	<이달의 생일자>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    //★DB연결 및 함수사용
    include_once __DIR__ . '/../session/ip_session.php';
    include_once __DIR__ . '/../DB/DB2.php';

    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php';     
    
    // 변수 초기화
    $Result_birthday = null;
    $Count_birthday = 0;

    //★매뉴 진입 시 실행
    $Query_birthday = "SELECT NM_KOR, NO_RES FROM NEOE.NEOE.MA_EMP WHERE CD_COMPANY='1000' AND (CD_PLANT='PL01' or CD_PLANT='PL04' or CD_PLANT='PL03' or CD_PLANT='PL06') AND CD_INCOM='001' and (no_emp like 'F%' or NO_EMP='C20130102') and NM_KOR!='이재익";
    // 정의되지 않은 $params, $options 변수 제거
    $Result_birthday = sqlsrv_query($connect, $Query_birthday);

    if ($Result_birthday) {
        // sqlsrv_num_rows는 일부 커서에서는 정확하지 않을 수 있으므로, 실제 데이터 카운트는 뷰에서 수행하는 것이 더 안정적일 수 있습니다.
        $count = sqlsrv_num_rows($Result_birthday);
        $Count_birthday = ($count === false) ? 0 : $count;
    } else {
        // 쿼리 실패 시 뷰에서 참조할 수 있도록 변수 초기화
        $Result_birthday = null;
        $Count_birthday = 0;
    }
?>