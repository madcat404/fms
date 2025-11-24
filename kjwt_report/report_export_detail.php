<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.06.09>
	// Description:	<b/l기반 erp 정보 출력>
    // Last Modified: <25.10.15> - Refactored for PHP 8.x	
	// =============================================
    include 'report_export_detail_status.php';
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
        
        <!-- 매뉴 -->
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
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">B/L</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">B/L</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">

                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h6 class="m-0 font-weight-bold text-primary">선적목록</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>선적번호(BL)</th>
                                                                                <th>출발&nbsp;<i class="fas fa-arrow-right"></i>&nbsp;도착</th>
                                                                                <th>작업일</th>
                                                                                <th>출항</th>
                                                                                <th>통화</th>
                                                                                <th>외화금액합계</th>
                                                                                <th>기표금액합계(원)</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                for($i=1; $i<=$Count_ExportDetail2; $i++)
                                                                                {		
                                                                                    $Data_ExportDetail2 = sqlsrv_fetch_array($Result_ExportDetail2);  

                                                                                    //요약정보
                                                                                    $Query_ExportMoney = "select * from NEOE.NEOE.TR_EXBL WHERE NO_BL='$bl'";
                                                                                    $Result_ExportMoney = sqlsrv_query($connect, $Query_ExportMoney, $params, $options);		
                                                                                    $Data_ExportMoney = sqlsrv_fetch_array($Result_ExportMoney);  
                                                                            ?>                                                                            
                                                                                <tr> 
                                                                                    <td><?php echo $bl; ?></td> 
                                                                                    <td style="width: 30%;"><?php if($Data_ExportDetail2['s_country']=="V") {
                                                                                        ?>
                                                                                        <img src="../img/flag_v.png" width="60em"></img>

                                                                                        <?php } elseif($Data_ExportDetail2['s_country']=="K") {
                                                                                        ?>
                                                                                        <img src="../img/flag_k.png" width="60em"></img>
                                                                                        <?php } elseif($Data_ExportDetail2['s_country']=="S") {
                                                                                        ?>
                                                                                        <img src="../img/flag_s.png" width="60em"></img>
                                                                                        <?php } elseif($Data_ExportDetail2['s_country']=="C") {
                                                                                        ?>
                                                                                        <img src="../img/flag_c.png" width="60em"></img>
                                                                                        <?php }
                                                                                        ?>

                                                                                        &nbsp;<i class="fas fa-arrow-right"></i>&nbsp;

                                                                                        <?php if($Data_ExportDetail2['e_country']=="V") {
                                                                                        ?>
                                                                                        <img src="../img/flag_v.png" width="60em"></img>

                                                                                        <?php } elseif($Data_ExportDetail2['e_country']=="U") {
                                                                                        ?>
                                                                                        <img src="../img/flag_a.png" width="60em"></img>
                                                                                        <?php } elseif($Data_ExportDetail2['e_country']=="S") {
                                                                                        ?>
                                                                                        <img src="../img/flag_s.png" width="60em"></img>
                                                                                        <?php } elseif($Data_ExportDetail2['e_country']=="C") {
                                                                                        ?>
                                                                                        <img src="../img/flag_c.png" width="60em"></img>
                                                                                        <?php }
                                                                                        ?>
                                                                                    </td>  
                                                                                    <td><?php echo $Data_ExportDetail2['invoice_dt']; ?></td>  
                                                                                    <td><?php echo $Data_ExportDetail2['etd']; ?></td>  
                                                                                    <td><?php IF($Data_ExportMoney['CD_EXCH']=='001') {echo 'USD';} elseif($Data_ExportMoney['CD_EXCH']=='003') {echo 'EUR';} else {echo '';} ?></td>  
                                                                                    <td><?php echo number_format((int)$Data_ExportMoney['AM_EX']); ?></td>  
                                                                                    <td><?php echo number_format((int)$Data_ExportMoney['AM']); ?></td> 
                                                                                </tr>                                                                           
                                                                            <?php 
                                                                                }
                                                                                 
                                                                                if($Data_ExportDetail2 == false) {
                                                                                    exit;
                                                                                }
                                                                            ?>                     
                                                                        </tbody>
                                                                    </table>
                                                                </div> 
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->

                                                    
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>송장번호(INVOICE)</th>
                                                                                <th>통관번호</th>
                                                                                <th>품번</th>
                                                                                <th>품명</th>
                                                                                <th>수량</th>   
                                                                                <th>수주단위</th>
                                                                                <th>금액(원)</th>                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                for($i=1; $i<=$Count_ExportDetail; $i++)
                                                                                {		
                                                                                    $Data_ExportDetail = sqlsrv_fetch_array($Result_ExportDetail);  
                                                                                    
                                                                                    //단위
                                                                                    $Query_ExportSO = "select * from NEOE.NEOE.MA_PITEM WHERE CD_ITEM='$Data_ExportDetail[CD_ITEM]'";
                                                                                    $Result_ExportSO = sqlsrv_query($connect, $Query_ExportSO, $params, $options);		
                                                                                    $Data_ExportSO = sqlsrv_fetch_array($Result_ExportSO);  
                                                                            ?>                                                                            
                                                                                <tr>                                                                                     
                                                                                    <td><?php echo $Data_ExportDetail['NO_INV']; ?></td> 
                                                                                    <td><?php echo $Data_ExportDetail['NO_TO']; ?></td> 
                                                                                    <td><?php echo $Data_ExportDetail['CD_ITEM']; ?></td>       
                                                                                    <td><?php echo NM_ITEM($Data_ExportDetail['CD_ITEM']); ?></td> 
                                                                                    <td><?php echo (int)$Data_ExportDetail['QT_SO']; ?></td> 
                                                                                    <td><?php echo $Data_ExportSO['UNIT_SO']; ?></td> 
                                                                                    <td><?php echo number_format((int)$Data_ExportDetail['AM_EXSO']); ?></td>                                                                                      
                                                                                </tr>                                                                           
                                                                            <?php 
                                                                                }
                                                                                 
                                                                                if($Data_ExportDetail == false) {
                                                                                    exit;
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
                                        </div>  
                                    </div>
                                </div>
                            </div>
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