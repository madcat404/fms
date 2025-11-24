<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.07.17>
	// Description:	<미화원 실적>	
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance	
	// =============================================

    //★DB연결 및 함수사용
    include_once __DIR__ . '/../FUNCTION.php';
    include_once __DIR__ . '/../DB/DB2.php';     

    $tab_sequence=3; 
    include_once __DIR__ . '/../TAB.php'; 

    //★변수모음 
    $nfc = $_GET["nfc"] ?? null;
    
    //★NFC 태그 처리
    if ($nfc === "on") {
        $area = $_GET["area"] ?? null;	
        $key = $_GET["key"] ?? null;

        // 간단한 키 인증
        if ($key !== '6218132365') {
            echo "<script>alert('키값이 틀렸습니다!');location.href='clean.php';</script>";
            exit;
        }

        // 허용된 영역 값만 처리하여 SQL 인젝션 방지
        $allowed_areas = ['NFC1', 'NFC2', 'NFC3', 'NFC4', 'NFC5', 'NFC6', 'NFC7'];
        if (!in_array($area, $allowed_areas)) {
            echo "<script>alert('유효하지 않은 영역입니다!');location.href='clean.php';</script>";
            exit;
        }
        
        $time_column = $area . '_TIME';

        // 오늘 날짜의 데이터가 있는지 확인 (매개변수화된 쿼리)
        $q_check = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.CLEAN WHERE SORTING_DATE = ?";
        $stmt_check = sqlsrv_query($connect, $q_check, [$Hyphen_today]);
        $row = sqlsrv_fetch_array($stmt_check);
        $has_today_data = ($row && $row['cnt'] > 0);

        if ($has_today_data) {
            // 데이터가 있으면 UPDATE
            // 동적으로 컬럼을 지정하지만, $area가 whitelist에 의해 검증되었으므로 안전함
            $q_update = "UPDATE CONNECT.dbo.CLEAN SET {$area} = 'on', {$time_column} = GETDATE() WHERE SORTING_DATE = ?";
            sqlsrv_query($connect, $q_update, [$Hyphen_today]);
        } else {
            // 데이터가 없으면 INSERT
            // SORTING_DATE는 DB 기본값(getdate())으로 자동 생성된다고 가정
            $q_insert = "INSERT INTO CONNECT.dbo.CLEAN({$area}, {$time_column}, SORTING_DATE) VALUES ('on', GETDATE(), ?)";
            sqlsrv_query($connect, $q_insert, [$Hyphen_today]);
        }
        
        echo "<script>alert('NFC 태그 기록 완료!');location.href='clean.php';</script>";
        exit;
    } 

    //★메뉴 진입 시 표시할 데이터 조회
    $Query_Clean = "SELECT * FROM CONNECT.DBO.CLEAN WHERE SORTING_DATE = ?";
    $Result_Clean = sqlsrv_query($connect, $Query_Clean, [$Hyphen_today]);		
    $Data_Clean = sqlsrv_fetch_array($Result_Clean);
    
    // 오늘 데이터가 없는 경우, 뷰(view)에서 오류가 나지 않도록 빈 배열로 초기화
    if ($Data_Clean === null) {
        $Data_Clean = [];
    }
?>