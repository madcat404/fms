<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.03.19>
	// Description:	<포장생산일 매핑 조회 (pda용)>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x		
	// =============================================
    include 'packing_inquire_pda_status.php';
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">      
        
        <!-- 메뉴 -->
        <?php include '../nav.php' ?>

        <!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <a href="packing_pda.php" class="btn btn-link mr-3" title="move_input">
                            <i class="fa fa-barcode fa-2x"></i>
                        </a>     
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">매핑 실적</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 
                        <div id="table" class="table-responsive">
                            <table class="table table-bordered table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>품번 (제품군)</th>
                                        <th>수량 (박스)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        // N+1 쿼리 문제를 해결하기 위해 데이터를 미리 가져옵니다.
                                        $item_codes = array_column($packing_data_for_user, 'CD_ITEM');
                                        $item_group_names = [];
                                        $box_counts = [];

                                        if (!empty($item_codes)) {
                                            // 1. 품목 그룹명 가져오기
                                            $placeholders = implode(',', array_fill(0, count($item_codes), '?'));
                                            $query_goods_group = "
                                                SELECT A.CD_ITEM, B.NM_ITEMGRP as item_name 
                                                FROM NEOE.NEOE.MA_PITEM A
                                                LEFT JOIN NEOE.NEOE.DZSN_MA_ITEMGRP B ON A.GRP_ITEM = B.CD_ITEMGRP	
                                                WHERE A.CD_ITEM IN ($placeholders) AND A.CD_PLANT = 'PL01'";
                                            
                                            $params_goods_group = array_map(function($code) { return Hyphen($code); }, $item_codes);
                                            $result_goods_group = sqlsrv_query($connect, $query_goods_group, $params_goods_group);
                                            if ($result_goods_group) {
                                                while ($row = sqlsrv_fetch_array($result_goods_group, SQLSRV_FETCH_ASSOC)) {
                                                    $item_group_names[$row['CD_ITEM']] = $row['item_name'];
                                                }
                                            }

                                            // 2. 박스 개수 가져오기
                                            $query_box_count = "
                                                SELECT 
                                                    CD_ITEM, 
                                                    COUNT(CASE WHEN ? = 'ALL' OR IP = ? THEN 1 END) as box_count
                                                FROM CONNECT.dbo.PACKING_LOG
                                                WHERE UPDATE_DATE = ? AND CD_ITEM IN ($placeholders)
                                                GROUP BY CD_ITEM";

                                            $ip_filter = $is_specific_ip ? $sip : 'ALL';
                                            // 파라미터 순서: IP 필터, IP 필터, 오늘 날짜, 품목 코드들
                                            $params_box_count = array_merge([$ip_filter, $ip_filter, $Hyphen_today], $item_codes);

                                            $result_box_count = sqlsrv_query($connect, $query_box_count, $params_box_count);
                                            if ($result_box_count) {
                                                while ($row = sqlsrv_fetch_array($result_box_count, SQLSRV_FETCH_ASSOC)) {
                                                    $box_counts[$row['CD_ITEM']] = $row['box_count'];
                                                }
                                            }
                                        }

                                        foreach ($packing_data_for_user as $data) {
                                            $cd_item = $data['CD_ITEM'];
                                            $hyphen_item = Hyphen($cd_item);
                                            $item_name = $item_group_names[$hyphen_item] ?? 'N/A';
                                            $box_count = $box_counts[$cd_item] ?? 0;
                                            $qt_goods = $data['QT_GOODS'] ?? 0;
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($cd_item, ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($item_name, ENT_QUOTES, 'UTF-8') . ")"; ?></td>
                                        <td><?php echo htmlspecialchars($qt_goods, ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($box_count, ENT_QUOTES, 'UTF-8') . ")"; ?></td>
                                    </tr>
                                    <?php 
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>   
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) {
    mysqli_close($connect4);
}	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>