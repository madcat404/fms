<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.08.18>
	// Description:	<포장라벨 재발행>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x	
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ .'/../session/session_check.php';    
    include_once __DIR__ . '/../DB/DB2.php';   
    include_once __DIR__ . '/../FUNCTION.php'; 

    //★변수정의 (PHP 8.x 호환성 및 보안 강화)
    $re_seq = $_POST['re_seq'] ?? null;
    $re_no_key = 're_no' . $re_seq;
    $re_no = $_POST[$re_no_key] ?? null;

    //★페이지 진입 시 실행
    $Data_ItemSelect = null;
    if ($re_no !== null) {
        // SQL Injection 방지를 위해 파라미터화된 쿼리 사용
        $Query_ItemSelect = "SELECT * FROM CONNECT.dbo.PACKING_LOG WHERE NO=?";
        $params_select = array($re_no);
        $Result_ItemSelect = sqlsrv_query($connect, $Query_ItemSelect, $params_select, $options);
        
        if ($Result_ItemSelect) {
            $Data_ItemSelect = sqlsrv_fetch_array($Result_ItemSelect, SQLSRV_FETCH_ASSOC);
        }
    }
    
    // 데이터가 없는 경우 또는 fetch 실패 시 처리
    if (!$Data_ItemSelect) { 
        // 에러를 알리거나, 기본 페이지로 리디렉션 할 수 있습니다.
        echo "<script>alert('데이터를 찾을 수 없습니다.'); location.href='complete_label.php';</script>";
        exit;
    }
?>