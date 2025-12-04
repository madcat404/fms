<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <25.10.22>
    // Description: <hrd 관리>
    // Last Modified: <Current Date> - Added Search & Sort by Name
    // =============================================

    // ★ DB 연결 및 세션 초기화
    include_once realpath('../session/ip_session.php');
    include_once realpath('../DB/DB2.php');

    // 초기화: 빈 배열로 선언하여 undefined 에러 방지
    $statuses = [];

    // ★ 매뉴 진입 시 탭 활성화
    $tab_sequence = 2;
    include_once realpath('../TAB.php');

    // ★ 검색 로직
    $search_keyword = $_GET['search_keyword'] ?? '';
    $params = array();

    // 기본 SQL 정의
    $sql = "
        SELECT
            T1.NM_KOR,  -- 사원명
            T2.NM_DEPT, -- 부서명
            T3.DC_PHOTO, -- 사진파일명 (없으면 NULL)
            STRING_AGG(T4.NM_QUALI, ', ') AS LIST -- 자격증 없으면 NULL
        FROM
            neoe.neoe.ma_emp AS T1
        INNER JOIN
            neoe.neoe.ma_dept AS T2 ON T1.CD_DEPT = T2.CD_DEPT
        LEFT JOIN -- 사진이 없어도 사원 정보가 나오도록 변경
            neoe.neoe.HR_PHOTO AS T3 ON T1.NO_EMP = T3.NO_EMP
        LEFT JOIN -- 자격증이 없어도 사원 정보가 나오도록 변경
            neoe.neoe.HR_LICENSE AS T4 ON T1.NO_EMP = T4.NO_EMP
        WHERE
            T1.cd_company = '1000'
            AND T1.CD_PLANT = 'PL01'
            AND (T1.no_emp LIKE 'F%' or T1.CD_PART='100')
            AND T1.CD_INCOM = '001'
    ";

    // 검색어가 있을 경우 조건 추가
    if ($search_keyword) {
        $sql .= " AND T1.NM_KOR LIKE ? ";
        $params[] = "%" . $search_keyword . "%";
    }

    // 그룹화 및 정렬 (이름순 정렬로 변경)
    $sql .= "
        GROUP BY
            T1.NM_KOR,
            T2.NM_DEPT,
            T3.DC_PHOTO
        ORDER BY
            T1.NM_KOR ASC
    ";

    if (!isset($options)) { $options = array("Scrollable" => "static"); }

    $stmt = sqlsrv_query($connect, $sql, $params, $options);
    if ($stmt === false) {
        $err = print_r(sqlsrv_errors(), true);
        error_log("human_status.php - sqlsrv_query 실패: " . $err);
        // echo "<pre>쿼리 실패:\n" . htmlspecialchars($err) . "\n\nSQL:\n" . htmlspecialchars($sql) . "</pre>"; // 디버깅용
        // exit;
    } else {
        // 전체 결과를 모두 가져와 $statuses에 저장
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $statuses[] = $row;
        }
        sqlsrv_free_stmt($stmt);
    }
?>