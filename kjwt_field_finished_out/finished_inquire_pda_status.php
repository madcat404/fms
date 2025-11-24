<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.03.19>
	// Description:	<포장생산일 매핑 조회 (pda용)>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================

    //★DB연결 및 함수사용
    include '../session/ip_session.php'; 
    include '../DB/DB2.php'; 
    include '../DB/DB21.php';       
   
    //★메뉴 진입 시 실행
    $DeliveryName = '';
    $Result_OutputQuantity = null;

    //마지막 납품기사
    $Query_Delivery = "SELECT WHO from CONNECT.dbo.USE_CONDITION WHERE KIND='Delivery'";              
    $Result_Delivery = sqlsrv_query($connect21, $Query_Delivery);
    if ($Result_Delivery) {
        $Data_Delivery = sqlsrv_fetch_array($Result_Delivery);
        if (isset($Data_Delivery['WHO'])) {
            if($Data_Delivery['WHO']=='DELIVERY1') $DeliveryName = "옥해종";
            elseif($Data_Delivery['WHO']=='DELIVERY2') $DeliveryName = "손규백";
            elseif($Data_Delivery['WHO']=='DELIVERY3') $DeliveryName = "최기완";
            elseif($Data_Delivery['WHO']=='DELIVERY4') $DeliveryName = "조근선";
            elseif($Data_Delivery['WHO']=='DELIVERY5') $DeliveryName = "박정민";
            elseif($Data_Delivery['WHO']=='DELIVERY6') $DeliveryName = "김영민";
            elseif($Data_Delivery['WHO']=='DELIVERY7') $DeliveryName = "기타";
        }
    }

    // 데이터 조회 (N+1 문제 해결을 위해 JOIN 사용)
    if (!empty($DeliveryName)) {
        $Query_OutputQuantity = "
            SELECT 
                T.CD_ITEM, 
                T.BOX, 
                T.PCS, 
                B.NM_ITEMGRP as item_name
            FROM (
                SELECT 
                    CD_ITEM, 
                    ISNULL(COUNT(*),0) AS BOX, 
                    ISNULL(SUM(QT_GOODS), 0) AS PCS 
                FROM CONNECT.dbo.FINISHED_OUTPUT_LOG 
                WHERE SORTING_DATE='$Hyphen_today' and DELIVERY='$DeliveryName' 
                GROUP BY CD_ITEM
            ) T
            LEFT JOIN NEOE.NEOE.MA_PITEM A ON A.CD_ITEM = T.CD_ITEM AND A.CD_PLANT='PL01'
            LEFT JOIN NEOE.NEOE.DZSN_MA_ITEMGRP B ON A.GRP_ITEM=B.CD_ITEMGRP";

        $Result_OutputQuantity = sqlsrv_query($connect21, $Query_OutputQuantity);
    }
?>