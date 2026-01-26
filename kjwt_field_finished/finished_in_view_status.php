<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.05.09>
	// Description:	<finished 뷰어>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';  
    include_once __DIR__ . '/../FUNCTION.php'; 

    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';               
    
    /**
     * Helper function to execute a parameterized query and fetch all results into an array.
     * This prevents cursor conflicts and is more reliable than sqlsrv_num_rows.
     * @param resource $conn The database connection resource.
     * @param string $sql The SQL query with placeholders.
     * @param array $params The parameters to bind to the query.
     * @return array An array containing all result rows.
     */
    function fetch_all_results($conn, $sql, $params = []) {
        $stmt = sqlsrv_query($conn, $sql, $params);
        $results = [];
        if ($stmt) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $results[] = $row;
            }
        }
        return $results;
    }

    //★메뉴 진입 시 실행
    //한국 탭
    $sql_KoreaScan = "SELECT * FROM CONNECT.dbo.FIELD_PROCESS_FINISH WHERE SORTING_DATE=? ORDER BY NO DESC";
    $KoreaScan_DataArray = fetch_all_results($connect, $sql_KoreaScan, [$Hyphen_today]);
    
    //베트남 탭
    $sql_VietnamScan = "SELECT * FROM CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE=? ORDER BY NO DESC";
    $VietnamScan_DataArray = fetch_all_results($connect, $sql_VietnamScan, [$Hyphen_today]);
?>