<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.05.28>
	// Description:	<esg sheet 마지막 데이터 복사>	
    // Last Modified: <25.09.12> - Refactored for PHP 8.x, Security, and Stability
	// =============================================
    //nas 또는 fms서버 재시작으로 인하여 마운트가 끈어진 경우 재마운트 필요
    //nas 경로가 달라진 경우 filename 재작성 필요 
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';   

    $Query_Esg = "INSERT INTO [CONNECT].[dbo].[ESG] ([top_official]
                        ,[top_official_woman]
                        ,[middle_official]
                        ,[middle_official_woman]
                        ,[term_worker]
                        ,[grievance_count]
                        ,[mandatory_edu]
                        ,[childcare_Target_man]
                        ,[childcare_Target_woman]
                        ,[childcare_user_man]
                        ,[childcare_user_woman]
                        ,[childcare_return_man]
                        ,[childcare_return_woman]
                        ,[childcare_return_man_year]
                        ,[childcare_return_woman_year]
                        ,[accident_rate]
                        ,[lost_time_accident_rate]
                        ,[personal_data_count]
                        ,[donation_amount]
                        ,[environmental_violation]
                        ,[social_violation]
                        ,[governance_violation]
                        ,[statutory_penalty]
                        ,[ethics_rate]) 
                    SELECT [top_official]
                        ,[top_official_woman]
                        ,[middle_official]
                        ,[middle_official_woman]
                        ,[term_worker]
                        ,[grievance_count]
                        ,[mandatory_edu]
                        ,[childcare_Target_man]
                        ,[childcare_Target_woman]
                        ,[childcare_user_man]
                        ,[childcare_user_woman]
                        ,[childcare_return_man]
                        ,[childcare_return_woman]
                        ,[childcare_return_man_year]
                        ,[childcare_return_woman_year]
                        ,[accident_rate]
                        ,[lost_time_accident_rate]
                        ,[personal_data_count]
                        ,[donation_amount]
                        ,[environmental_violation]
                        ,[social_violation]
                        ,[governance_violation]
                        ,[statutory_penalty]
                        ,[ethics_rate]
                    FROM [CONNECT].[dbo].[ESG]
                    WHERE sorting_date = (SELECT MAX(sorting_date) FROM [CONNECT].[dbo].[ESG])";
    $result = sqlsrv_query($connect, $Query_Esg, $params, $options);   

    // 쿼리 실행 결과 확인
    if ($result === false) {
        // 실패 시 에러 로그 기록
        error_log("ESG data copy query failed: " . print_r(sqlsrv_errors(), true));
    }   

    //메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }