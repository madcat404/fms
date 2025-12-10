<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.09.01>
	// Description:	<레포트 리뉴얼>	
    // Last Modified: <25.10.20> - Refactored for Modularization
	// =============================================
    include 'report_body_status.php';   
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>         
</head>

<body id="page-top">  

    <div id="wrapper">

        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                    </div>       

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab1;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">information</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">경영</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4;?>" id="custom-tabs-one-4th-tab" data-toggle="pill" href="#custom-tabs-one-4th">회계</a>
                                        </li>   
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="custom-tabs-one-5th-tab" data-toggle="pill" href="#custom-tabs-one-5th">물류</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab6;?>" id="custom-tabs-one-6th-tab" data-toggle="pill" href="#custom-tabs-one-6th">매출</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab7;?>" id="custom-tabs-one-7th-tab" data-toggle="pill" href="#custom-tabs-one-7th">품질</a>
                                        </li>   
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab8;?>" id="custom-tabs-one-8th-tab" data-toggle="pill" href="#custom-tabs-one-8th">수주</a>
                                        </li>     
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab9;?>" id="custom-tabs-one-9th-tab" data-toggle="pill" href="#custom-tabs-one-9th">YouTube</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab10;?>" id="custom-tabs-one-10th-tab" data-toggle="pill" href="#custom-tabs-one-10th"><img src="../img/flag_v.webp" style="width: 2vw;"> 베트남</a>
                                        </li>            
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade <?php echo $tab1_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <?php include 'report_body_tabs/tab_information.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">
                                            <?php include 'report_body_tabs/tab_management.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="custom-tabs-one-4th" role="tabpanel" aria-labelledby="custom-tabs-one-4th-tab">
                                            <?php include 'report_body_tabs/tab_accounting.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="custom-tabs-one-5th" role="tabpanel" aria-labelledby="custom-tabs-one-5th-tab">
                                            <?php include 'report_body_tabs/tab_logistics.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab7_text;?>" id="custom-tabs-one-6th" role="tabpanel" aria-labelledby="custom-tabs-one-6th-tab">
                                            <?php include 'report_body_tabs/tab_sales.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab8_text;?>" id="custom-tabs-one-7th" role="tabpanel" aria-labelledby="custom-tabs-one-7th-tab">
                                            <?php include 'report_body_tabs/tab_quality.php'; ?>
                                        </div> 
                                        
                                        <div class="tab-pane fade <?php echo $tab9_text;?>" id="custom-tabs-one-8th" role="tabpanel" aria-labelledby="custom-tabs-one-8th-tab">
                                            <?php include 'report_body_tabs/tab_orders.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab10_text;?>" id="custom-tabs-one-9th" role="tabpanel" aria-labelledby="custom-tabs-one-9th-tab">
                                            <?php include 'report_body_tabs/tab_youtube.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab10_text;?>" id="custom-tabs-one-10th" role="tabpanel" aria-labelledby="custom-tabs-one-10th-tab">
                                            <?php include 'report_body_tabs/tab_vietnam.php'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                    </div>
                </div>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include '../plugin_lv1.php'; ?>

    <?php include 'report_body_tabs/report_charts.php'; ?>

</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) {mysqli_close($connect4);}	

    //MSSQL 메모리 회수
    if(isset($connect)) {sqlsrv_close($connect);}
?>