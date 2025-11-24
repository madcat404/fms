<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.03.18>
	// Description:	<마지막 사진 뷰어)>
    // Last Modified: <25.10.20> - Refactored for PHP 8.x	
	// =============================================
    include 'rental_lastpic_status.php';   
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
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">법인차 파손 흔적</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row">                 

                        <!-- 카드3 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample3" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample3">
                                    <h6 class="m-0 font-weight-bold text-primary">Staria 9285</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample3">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php 
                                                if ($Result_LastPicData3) {
                                                    while($Data_LastPicData3 = $Result_LastPicData3->fetch_object()) {
                                                        $fileName = htmlspecialchars($Data_LastPicData3->FILE_NM, ENT_QUOTES, 'UTF-8');
                                            ?>
                                                <div class="col-sm-2 mb-3">
                                                    <a href="https://fms.iwin.kr/files/<?php echo $fileName; ?>" target="_blank">
                                                        <img src="https://fms.iwin.kr/files/<?php echo $fileName; ?>" alt="LastPic" style="width:100%;">
                                                    </a>  
                                                </div>   
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer text-right">
                                        <button type="button" class="btn btn-info"><a href="https://fms.iwin.kr/kjwt_fms/rental.php" style="text-decoration:none; color: white;">대여화면으로 돌아가기</a></button>
                                    </div>
                                </div>
                                <!-- /.Card Content - Collapse -->
                            </div>
                             <!-- /.card -->
                        </div>  
                        
                        <!-- 카드4 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample4" class="d-block card-header py-4" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample4">
                                    <h6 class="m-0 font-weight-bold text-primary">avante 7206</h6>
                                </a>                                 
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample4">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php 
                                                if ($Result_LastPicData4) {
                                                    while($Data_LastPicData4 = $Result_LastPicData4->fetch_object()) {
                                                        $fileName = htmlspecialchars($Data_LastPicData4->FILE_NM, ENT_QUOTES, 'UTF-8');
                                            ?>
                                                <div class="col-sm-2 mb-3">
                                                    <a href="https://fms.iwin.kr/files/<?php echo $fileName; ?>" target="_blank">
                                                        <img src="https://fms.iwin.kr/files/<?php echo $fileName; ?>" alt="LastPic" style="width:100%;">
                                                    </a>  
                                                </div>   
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer text-right">
                                        <button type="button" class="btn btn-info"><a href="https://fms.iwin.kr/kjwt_fms/rental.php" style="text-decoration:none; color: white;">대여화면으로 돌아가기</a></button>
                                    </div>
                                </div>
                                <!-- /.Card Content - Collapse -->                                
                            </div>
                             <!-- /.card -->
                        </div> 

                        
                        <!-- 카드5 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample5" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample5">
                                    <h6 class="m-0 font-weight-bold text-primary">avante 7207</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample5">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php 
                                                if ($Result_LastPicData5) {
                                                    while($Data_LastPicData5 = $Result_LastPicData5->fetch_object()) {
                                                        $fileName = htmlspecialchars($Data_LastPicData5->FILE_NM, ENT_QUOTES, 'UTF-8');
                                            ?>
                                                <div class="col-sm-2 mb-3">
                                                    <a href="https://fms.iwin.kr/files/<?php echo $fileName; ?>" target="_blank">
                                                        <img src="https://fms.iwin.kr/files/<?php echo $fileName; ?>" alt="LastPic" style="width:100%;">
                                                    </a>  
                                                </div>   
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer text-right">
                                        <button type="button" class="btn btn-info"><a href="https://fms.iwin.kr/kjwt_fms/rental.php" style="text-decoration:none; color: white;">대여화면으로 돌아가기</a></button>
                                    </div>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    //메모리 회수
    if (isset($connect)) {
        mysqli_close($connect);
    }
?>