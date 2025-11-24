<?php 
    // Prevent caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.05.09>
	// Description:	<finished 뷰어>
    // Last Modified: <25.09.25> - Upgraded to PhpSpreadsheet, Refactored for PHP 8.x and Security
	// =============================================
    include 'finished_in_view_status.php';
    function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
    <meta http-equiv="refresh" content="300;"> 
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

                    <!-- Begin row -->
                    <div class="row">                        
                        <div class="col-lg-12 mt-2"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                    <h6 class="m-0 font-weight-bold text-primary">입고대기 (<?php echo h($DT); ?> 기준)</h6>
                                </a>

                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample21">
                                    <div class="card-body">
                                        <div id="table">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>품번</th>
                                                        <th>품명</th>
                                                        <th>대기수량</th>
                                                        <th>양산/AS</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    //한국
                                                        foreach($KoreaScan_DataArray as $Data_KoreaScan)
                                                        {
                                                            $sql_kChkFinishedIn = "SELECT SUM(QT_GOODS) AS QT_GOODS FROM CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? AND OUT_OF='한국' AND CD_ITEM=? GROUP BY CD_ITEM";
                                                            $result_kChkFinishedIn = sqlsrv_query($connect, $sql_kChkFinishedIn, [$Hyphen_today, $Data_KoreaScan['CD_ITEM']]);
                                                            $Data_kChkFinishedIn = sqlsrv_fetch_array($result_kChkFinishedIn, SQLSRV_FETCH_ASSOC);

                                                            $itemName = NM_ITEM($Data_KoreaScan['CD_ITEM']);
                                                            $fan1=strpos(strtoupper($itemName), "모듈");
                                                            $fan2=strpos(strtoupper($itemName), "BLOW");
                                                            $fan3=strpos(strtoupper($itemName), "BLOWER");
                                                            $bed1=strpos(strtoupper($itemName), "BED");
                                                            $wheel1=strpos(strtoupper($itemName), "S/WHEEL");
                                                            $wheel2=strpos(strtoupper($itemName), "S/W");
                                                            $unit1=strpos(strtoupper($itemName), "UNIT");
                                                            $warmer1=strpos(strtoupper($itemName), "WARMER");

                                                            if($fan1 === false && $fan2 === false && $fan3 === false && $bed1 === false && $wheel1 === false && $wheel2 === false && $unit1 === false && $warmer1 === false) {
                                                                $k_inspected_qty = ($Data_KoreaScan['QT_GOODS'] ?? 0) - ($Data_KoreaScan['REJECT_GOODS'] ?? 0);
                                                                $k_received_qty = $Data_kChkFinishedIn['QT_GOODS'] ?? 0;

                                                                if($k_inspected_qty > $k_received_qty) {
                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo h($Data_KoreaScan['CD_ITEM']); ?></td>
                                                                        <td><?php echo h($itemName); ?></td>
                                                                        <td><?php echo h($k_inspected_qty - $k_received_qty); ?></td>
                                                                        <td><?php echo ($Data_KoreaScan['AS_YN'] == 'Y') ? "A/S" : "양산"; ?></td>
                                                                    </tr>
                                                    <?php 
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <?php 
                                                    //베트남
                                                        foreach($VietnamScan_DataArray as $Data_VietnamScan)
                                                        {
                                                            $sql_vChkFinishedIn = "SELECT SUM(QT_GOODS) AS QT_GOODS FROM CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? AND OUT_OF='BB' AND CD_ITEM=? GROUP BY CD_ITEM";
                                                            $result_vChkFinishedIn = sqlsrv_query($connect, $sql_vChkFinishedIn, [$Hyphen_today, $Data_VietnamScan['CD_ITEM']]);
                                                            $Data_vChkFinishedIn = sqlsrv_fetch_array($result_vChkFinishedIn, SQLSRV_FETCH_ASSOC);

                                                            $v_inspected_qty = ($Data_VietnamScan['QT_GOODS'] ?? 0) - ($Data_VietnamScan['REJECT_GOODS'] ?? 0);
                                                            $v_received_qty = $Data_vChkFinishedIn['QT_GOODS'] ?? 0;

                                                            if($v_inspected_qty > $v_received_qty) {
                                                    ?>
                                                                <tr>
                                                                    <td><?php echo h($Data_VietnamScan['CD_ITEM']); ?></td>
                                                                    <td><?php echo h(NM_ITEM($Data_VietnamScan['CD_ITEM'])); ?></td>
                                                                    <td><?php echo h($v_inspected_qty - $v_received_qty); ?></td>
                                                                    <td><?php echo ($Data_VietnamScan['AS_YN'] == 'Y') ? "A/S" : "양산"; ?></td>
                                                                </tr>
                                                    <?php 
                                                            }
                                                        }
                                                    ?>   
                                                    <?php 
                                                    //중국
                                                        foreach($ChinaScan_DataArray as $Data_ChinaScan)
                                                        {
                                                            $sql_cChkFinishedIn = "SELECT SUM(QT_GOODS) AS QT_GOODS FROM CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE=? AND OUT_OF='BB' AND CD_ITEM=? GROUP BY CD_ITEM";
                                                            $result_cChkFinishedIn = sqlsrv_query($connect, $sql_cChkFinishedIn, [$Hyphen_today, $Data_ChinaScan['CD_ITEM']]);
                                                            $Data_cChkFinishedIn = sqlsrv_fetch_array($result_cChkFinishedIn, SQLSRV_FETCH_ASSOC);

                                                            $c_inspected_qty = ($Data_ChinaScan['QT_GOODS'] ?? 0) - ($Data_ChinaScan['REJECT_GOODS'] ?? 0);
                                                            $c_received_qty = $Data_cChkFinishedIn['QT_GOODS'] ?? 0;

                                                            if($c_inspected_qty > $c_received_qty) {
                                                    ?>
                                                                <tr>
                                                                    <td><?php echo h($Data_ChinaScan['CD_ITEM']); ?></td>
                                                                    <td><?php echo h(NM_ITEM($Data_ChinaScan['CD_ITEM'])); ?></td>
                                                                    <td><?php echo h($c_inspected_qty - $c_received_qty); ?></td>
                                                                    <td><?php echo ($Data_ChinaScan['AS_YN'] == 'Y') ? "A/S" : "양산"; ?></td>
                                                                </tr>
                                                    <?php 
                                                            }
                                                        }
                                                    ?>                  
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.Card Content - Collapse -->                                                                                   
                            </div>
                            <!-- /.card -->
                        </div>                          

                        <!-- end !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                    
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
    //메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>