<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.30>
	// Description:	<finished 뷰어>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'complete_view_status.php';
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
                    <div class="row mt-2">                        
                        <div class="col-lg-12 mt-2"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-2">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                    <h6 class="m-0 font-weight-bold text-primary">검사대기창고 뷰어 (<?php echo htmlspecialchars($DT, ENT_QUOTES, 'UTF-8'); ?> 기준)</h6>
                                </a>

                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample21">
                                    <div class="card-body">
                                        <div class="row"> 
                                            <!-- 보드1-1 -->
                                            <div class="col-xl-12 col-md-12 mb-2">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col-3" style="text-align: center;">
                                                                <i class="fas fa-warehouse fa-10x text-gray-300" style="font-size: 252px;"></i>
                                                            </div>
                                                            <div class="col-6" style="text-align: center;">
                                                                <div class="font-weight-bold text-info" style="font-size: 100px;">B/B 출고 오더</div>
                                                            </div>
                                                            <div class="col-3" style="text-align: rightr; padding-right: 28px;">
                                                                <div class="font-weight-bold text-info" style="font-size: 80px;"><?php echo htmlspecialchars($Data_Order11['QT_GOODS'], ENT_QUOTES, 'UTF-8'); ?> pcs</div>
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드1-2 -->
                                            <div class="col-xl-12 col-md-12 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col-3" style="text-align: center;">
                                                                <i class="fas fa-truck-loading fa-10x text-gray-300" style="font-size: 252px;"></i>
                                                            </div>
                                                            <div class="col-6" style="text-align: center;">
                                                                <div class="font-weight-bold text-success" style="font-size: 100px;">B/B 출고</div>
                                                            </div>
                                                            <div class="col-3" style="text-align: rightr; padding-right: 28px;">
                                                                <div class="font-weight-bold text-success" style="font-size: 80px;"><?php echo htmlspecialchars($Data_Order12['COMPLETE'], ENT_QUOTES, 'UTF-8'); ?> pcs</div>
                                                                <div class="font-weight-bold text-success" style="font-size: 80px; text-align: center;">
                                                                    <?php 
                                                                        $percent1 = 0;
                                                                        if (!empty($Data_Order11['QT_GOODS'])) {
                                                                            $percent1 = ROUND($Data_Order12['COMPLETE'] * 100 / $Data_Order11['QT_GOODS']);
                                                                        }
                                                                        echo $percent1;
                                                                    ?>%
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 보드1-3 -->
                                            <div class="col-xl-12 col-md-12 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col-3" style="text-align: center;">
                                                                <i class="fas fa-box-open fa-10x text-gray-300" style="font-size: 252px;"></i>
                                                            </div>
                                                            <div class="col-6" style="text-align: center;">
                                                                <div class="font-weight-bold text-primary" style="font-size: 100px;">검사 완료</div>
                                                            </div>
                                                            <div class="col-3" style="text-align: rightr; padding-right: 28px;">
                                                                <div class="font-weight-bold text-primary" style="font-size: 80px;"><?php echo htmlspecialchars($Data_Order13['QT_GOODS']+$Data_Order14['QT_GOODS'], ENT_QUOTES, 'UTF-8'); ?> pcs</div>
                                                                <div class="font-weight-bold text-primary" style="font-size: 80px; text-align: center;">
                                                                    <?php 
                                                                        $percent2 = 0;
                                                                        if (!empty($Data_Order12['COMPLETE'])) {
                                                                            $percent2 = ROUND(($Data_Order13['QT_GOODS'] + $Data_Order14['QT_GOODS']) * 100 / $Data_Order12['COMPLETE']);
                                                                        }
                                                                        echo $percent2;
                                                                    ?>%
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
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
    //MARIA DB 메모리 회수
    if (isset($connect4)) {
    mysqli_close($connect4);
}	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>