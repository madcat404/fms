<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.02.18>
	// Description:	<강제 매핑>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php';    

    // 1. 성능 및 안정성을 위해 while 루프로 변경하고, 필요한 컬럼만 선택합니다.
    $Query_SelectBarcode = "SELECT NO, PRODUCT_BARCODE FROM CONNECT.dbo.PACKING_LOG WHERE make_date IS NULL AND PRODUCT_BARCODE IS NOT NULL AND lot_date >= '20250101'";
    $Result_SelectBarcode = sqlsrv_query($connect, $Query_SelectBarcode);

    if ($Result_SelectBarcode === false) {
        die(print_r(sqlsrv_errors(), true)); // 쿼리 실패 시 에러 출력 후 중지
    }

    while ($Data_SelectBarcode = sqlsrv_fetch_array($Result_SelectBarcode, SQLSRV_FETCH_ASSOC)) {
        // 2. PHP 8.x 호환성을 위해 Null 병합 연산자(??)를 사용하여 Undefined index 오류를 방지합니다.
        $productBarcode = $Data_SelectBarcode['PRODUCT_BARCODE'] ?? null;
        if (!$productBarcode) {
            continue; // PRODUCT_BARCODE가 없으면 다음 레코드로 넘어갑니다.
        }

        $use_function2 = CROP($productBarcode);
        $lot_date21 = $use_function2[2] ?? null; // CROP 결과가 예상과 다를 경우를 대비

        if ($lot_date21 && strlen($lot_date21) > 6) {
            $lot_date21 = substr($lot_date21, 2, 6);
        }

        // 3. SQL Injection 방지를 위해 매개변수화된 쿼리를 사용합니다.
        $Query_UpdateProduct = "UPDATE CONNECT.dbo.PACKING_LOG SET IP='MASTER', MAKE_DATE=?, UPDATE_DATE=GETDATE(), RECORD_UPDATE=GETDATE() WHERE NO=?";
        $params_update = [$lot_date21, $Data_SelectBarcode['NO']];
        sqlsrv_query($connect, $Query_UpdateProduct, $params_update);
    }