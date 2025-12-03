<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.26>
	// Description:	<직원차량 연락망 쿼리>	
    // Last Modified: <Current Date> - Fixed Variable Consistency ($Result_Car)
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php';
    // [중요] MySQL 연결 파일 ($connect4)
    include_once __DIR__ . '/../DB/DB4.php'; 

    //★매뉴 진입 시 탭활성화
    $tab_sequence = 2; 
    include '../TAB.php';     

    //★검색 로직
    $search_keyword = $_GET['search_keyword'] ?? '';
    
    // 쿼리 결과 변수 초기화
    $Result_Car = null;

    if ($search_keyword) {
        // [검색어 있음] 차량번호 또는 이름 검색
        $search_term = "%" . $search_keyword . "%";
        if ($stmt = $connect4->prepare("SELECT * FROM user_info WHERE USE_YN='Y' AND (CAR_NUM LIKE ? OR USER_NM LIKE ?) ORDER BY CAR_NUM ASC")) {
            $stmt->bind_param("ss", $search_term, $search_term);
            $stmt->execute();
            $Result_Car = $stmt->get_result();
        }
    } else {
        // [검색어 없음] 전체 목록 조회 (차량번호 있는 사람만)
        $query = "SELECT * FROM user_info WHERE USE_YN='Y' AND CAR_NM != '-' AND CAR_NM != '' ORDER BY CAR_NUM ASC";
        $Result_Car = $connect4->query($query);
    }

    // [데이터 가공] 결과를 배열에 저장 (car.php에서 사용)
    $car_list = [];
    if ($Result_Car) {
        while ($row = $Result_Car->fetch_assoc()) {
            $car_list[] = $row;
        }
    }
?>