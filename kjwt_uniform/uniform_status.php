<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.05.08>
	// Description:	<근무복>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
	// =============================================

    //★DB연결 및 함수사용
    include_once __DIR__ . '/../session/ip_session.php';    
    include_once __DIR__ . '/../DB/DB2.php';
    include_once __DIR__ . '/../FUNCTION.php';

    //★변수 초기화 (PHP 8.x 호환성)
    $flag = $_GET['flag'] ?? '';  

    // 지급
    $user11 = $_POST['user11'] ?? '';
    $kind11 = $_POST['kind11'] ?? '';
    $size11 = $_POST['size11'] ?? '';
    $bt11 = $_POST['bt11'] ?? '';

    // 반납
    $user21 = $_POST['user21'] ?? '';
    $kind21 = $_POST['kind21'] ?? '';
    $size21 = $_POST['size21'] ?? '';
    $note21 = $_POST['note21'] ?? '';
    $bt21 = $_POST['bt21'] ?? '';
 
    // 검색
    $dt3 = $_POST['dt3'] ?? '';
    $s_dt3 = $dt3 ? substr($dt3, 0, 10) : '';		
	$e_dt3 = $dt3 ? substr($dt3, 13, 10) : '';
    $bt31 = $_POST['bt31'] ?? '';

    //★메뉴 진입 시 탭활성화
    $tab2 = '';
    $tab3 = '';
    $tab2_text = '';
    $tab3_text = '';
    $tab_sequence = 2;
    if ($bt31 === 'on') {
        $tab_sequence = 3;
    }
    include_once __DIR__ . '/../TAB.php'; 

    //★함수
    /**
     * securely updates the stock in the UNIFORM table.
     * It uses a CASE statement to avoid SQL injection vulnerabilities.
     * @param resource $connect The database connection resource.
     * @param string $kind The type of uniform (e.g., '춘추복').
     * @param string $size The size of the uniform (e.g., 'S', 'M').
     * @param int $delta The change in stock (e.g., 1 for return, -1 for issue).
     */
    function updateStock($connect, $kind, $size, $delta) {
        $sizeColumnMap = [
            'S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL',
            'XXL' => 'XXL', 'XXXL' => 'XXXL', 'XXXXL' => 'XXXXL'
        ];

        if (!isset($sizeColumnMap[$size])) {
            return; // Invalid size
        }

        $column = $sizeColumnMap[$size];

        // Dynamically and safely create the column name
        $updateQuery = "UPDATE CONNECT.dbo.UNIFORM SET [$column] = [$column] + ? WHERE KIND = ?";
        
        $params = [$delta, $kind];

        executeQuery($connect, $updateQuery, $params);
    }

    //★버튼 클릭 시 실행
    if($bt11 === "on") {
        if(empty($kind11) || empty($size11) || empty($user11)) {
            echo "<script>alert('사용자, 종류, 사이즈를 모두 선택해주세요!');history.back();</script>";
            exit;
        }

        // 데이터 삽입 (지급)
        $query = "INSERT INTO CONNECT.dbo.UNIFORM_INOUT (INOUT, NAME, KIND, SIZE) VALUES ('OUT', ?, ?, ?)";
        executeQuery($connect, $query, [$user11, $kind11, $size11]);

        // 재고 업데이트
        updateStock($connect, $kind11, $size11, -1);

        echo "<script>alert('지급 되었습니다!');location.href='uniform.php?flag=log';</script>";
        exit;
    }
    elseif($bt21 === "on") {
        if(empty($kind21) || empty($size21) || empty($user21)) {
            echo "<script>alert('사용자, 종류, 사이즈를 모두 선택해주세요!');history.back();</script>";
            exit;
        }
        
        // 데이터 삽입 (반납)
        $query = "INSERT INTO CONNECT.dbo.UNIFORM_INOUT (INOUT, NAME, KIND, SIZE, NOTE) VALUES ('IN', ?, ?, ?, ?)";
        executeQuery($connect, $query, [$user21, $kind21, $size21, $note21]);

        // 재고 업데이트
        updateStock($connect, $kind21, $size21, 1);

        echo "<script>alert('반납 되었습니다!');location.href='uniform.php?flag=log';</script>";
        exit;
    } 
    
    $data = [];
    if($bt31 === "on") {
        $query = "SELECT * FROM CONNECT.dbo.UNIFORM_INOUT WHERE SORTING_DATE BETWEEN ? AND ? ORDER BY NO DESC";
        $stmt = executeQuery($connect, $query, [$s_dt3, $e_dt3]);
        if ($stmt) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $data[] = $row;
            }
        }          
    } 
    elseif($flag === "log") {
        $query = "SELECT * FROM CONNECT.dbo.UNIFORM_INOUT WHERE SORTING_DATE = ? ORDER BY NO DESC";
        $stmt = executeQuery($connect, $query, [$Hyphen_today]);
        if ($stmt) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $data[] = $row;
            }
        }
    }
   
    //★메뉴 진입 시 실행
    // 재고 조회
    $Query_Uniform= "SELECT * FROM CONNECT.dbo.UNIFORM";              
    $Result_Uniform= executeQuery($connect, $Query_Uniform);
    $Data_Uniform = [];
    if ($Result_Uniform) {
        while ($row = sqlsrv_fetch_array($Result_Uniform, SQLSRV_FETCH_ASSOC)) {
            $Data_Uniform[] = $row;
        }
    }
?>