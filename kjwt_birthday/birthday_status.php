<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.07.18>
	// Description:	<이달의 생일자>
    // Last Modified: <Current Date> - Added Sorting by Birth Date (MMDD)
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';   
    include_once __DIR__ . '/../DB/DB2.php';

    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php';     
    
    // 변수 초기화
    $Result_birthday = null;
    $Count_birthday = 0;

    //★검색 로직
    $search_keyword = $_GET['search_keyword'] ?? '';
    $params = array();

    //★매뉴 진입 시 실행
    // 기본 쿼리
    $Query_birthday = "SELECT NM_KOR, NO_RES FROM NEOE.NEOE.MA_EMP WHERE CD_COMPANY='1000' AND (CD_PLANT='PL01' or CD_PLANT='PL04' or CD_PLANT='PL03' or CD_PLANT='PL06') AND CD_INCOM='001' and (no_emp like 'F%' or NO_EMP='C20130102') and NM_KOR!='이재익'";

    // 검색어가 있을 경우 조건 추가
    if ($search_keyword) {
        $Query_birthday .= " AND NM_KOR LIKE ?";
        $params[] = "%" . $search_keyword . "%";
    }

    // [수정] 생일(월일) 기준 정렬 추가
    // 주민등록번호(NO_RES)의 3번째 자리부터 4글자(MMDD)를 추출하여 오름차순 정렬
    $Query_birthday .= " ORDER BY SUBSTRING(NO_RES, 3, 4) ASC";

    // 쿼리 실행
    $Result_birthday = sqlsrv_query($connect, $Query_birthday, $params);

    if ($Result_birthday) {
        $count = sqlsrv_num_rows($Result_birthday);
        $Count_birthday = ($count === false) ? 0 : $count;
    } else {
        $Result_birthday = null;
        $Count_birthday = 0;
    }
?>