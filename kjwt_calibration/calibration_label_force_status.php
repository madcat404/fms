<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.04.28>
	// Description:	<검교정 라벨발행>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';   
    include_once __DIR__ . '/../DB/DB2.php';  

    //★변수정의 (Null 병합 연산자로 안전하게 초기화)
    $title31 = $_POST['title31'] ?? $_GET['title31'] ?? null;
    $cost = $_GET['cost'] ?? null;

    // Note: These variables seem related to a different, commented-out feature.
    // Initialize them to avoid errors.
    $contents41 = $_POST['contents41'] ?? null; 
    $test_user41 = $_POST['test_user41'] ?? null; 
    $sw41 = $_POST['sw41'] ?? null; 
    $sample_num41 = $_POST['sample_num41'] ?? null; 
    $purpose41 = $_POST['purpose41'] ?? null; 
    $hw41 = $_POST['hw41'] ?? null; 
    
    // These are passed recursively for multi-label printing
    $cd_item = $_GET['item41'] ?? null;   
    $note = $_GET['note41'] ?? null; 

    // 최초 진입 시 라벨 개수 설정
    if ($cost === null) {
        $b_count = 1; // 기본 출력할 라벨 개수
        if ($b_count <= 0) {
            echo "<script>alert('출력할 라벨 개수를 선택하세요!');history.back();</script>";
            exit;
        }
        $cost = $b_count - 1;
    }
?>