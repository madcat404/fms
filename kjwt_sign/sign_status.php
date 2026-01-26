<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.17>
	// Description:	<회람 전산화>	
    // Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../DB/DB3.php'; 
    include_once __DIR__ . '/../FUNCTION.php';


    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php';    


    //★변수모음   
    $no = $_GET['no'] ?? null;   
    
    
    //★버튼 클릭 시 실행  
    IF($no!='') {
        //출력시 회람 생성일과 제목 출력을 위한 쿼리
        $Query_SignSelect = "SELECT * from CONNECT.dbo.SIGN2 where no=?";              
        $params_SignSelect = array($no);
        $Result_SignSelect = sqlsrv_query($connect, $Query_SignSelect, $params_SignSelect, $options);
        // PHP 8.x 호환성 및 보안: 쿼리 실패 시 오류를 처리합니다.
        if ($Result_SignSelect === false) {
            // 프로덕션 환경에서는 오류 로깅 시스템을 사용해야 합니다.
            error_log(print_r(sqlsrv_errors(), true));
            // 사용자에게는 일반적인 오류 메시지를 표시하는 것이 좋습니다.
            die("데이터베이스 쿼리 오류가 발생했습니다.");
        }
        $Data_SignSelect = sqlsrv_fetch_array($Result_SignSelect);  	
        if ($Data_SignSelect) {
            $SIGNYY = substr($Data_SignSelect['DT'],0,4);
            $SIGNMM = substr($Data_SignSelect['DT'],5,2);
        }
    }    

    //★매뉴 진입 시 실행
    if (isset($Data_SignSelect['TITLE'])) {
        $Query_Sign = "SELECT
                            s.name AS NAME,
                            s.use_yn,
                            sl.title AS TITLE,
                            sl.date AS SIGN_DT,
                            s.condition AS CONDITION,
                            s.sorting_date
                        FROM
                            sign s
                        LEFT JOIN
                            sign_log sl ON s.name = sl.name AND sl.title = ?
                        LEFT JOIN
                            (SELECT
                                EOMONTH(TRY_CONVERT(DATE, dt + '-01', 23)) AS dt_last_day_of_month
                            FROM sign2 WHERE title = ?) AS s2_dt ON 1 = 1
                        WHERE
                            (s.use_yn = 'y' OR sl.title IS NOT NULL)
                            AND s2_dt.dt_last_day_of_month IS NOT NULL
                            AND s.sorting_date < s2_dt.dt_last_day_of_month;";
        $params_Sign = array($Data_SignSelect['TITLE'], $Data_SignSelect['TITLE']);
        $Result_Sign = sqlsrv_query($connect, $Query_Sign, $params_Sign, $options);
        // PHP 8.x 호환성 및 보안: 쿼리 실패 시 오류를 처리합니다.
        if ($Result_Sign === false) {
            // 프로덕션 환경에서는 오류 로깅 시스템을 사용해야 합니다.
            error_log(print_r(sqlsrv_errors(), true));
            // 사용자에게는 일반적인 오류 메시지를 표시하는 것이 좋습니다.
            die("데이터베이스 쿼리 오류가 발생했습니다.");
        }
    } 
?>