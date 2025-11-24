<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.11.14>
	// Description:	<발열검사기 뷰어>
	// =============================================
    include 'inspect_status.php';
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">발열검사기</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
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
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">로그</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="car.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>품번</th>
                                                                                <th>로트날짜</th>
                                                                                <th>자재품번</th>
                                                                                <th>자재로트날짜</th>
                                                                                <th>온도1</th>
                                                                                <th>온도2</th>
                                                                                <th>온도3</th>
                                                                                <th>온도4</th>
                                                                                <th>온도편차</th>
                                                                                <th>합부판정</th>
                                                                                <th>검사일시</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                while ($Data_inspect = sqlsrv_fetch_array($Result_inspect, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                                <tr>
                                                                                    <td><?php echo $Data_inspect['CD_ITEM']; ?></td>
                                                                                    <td><?php echo ($Data_inspect['LOT_DATE'] instanceof DateTime) ? $Data_inspect['LOT_DATE']->format('Y-m-d') : $Data_inspect['LOT_DATE']; ?></td>                                                                                  
                                                                                    <td><?php echo $Data_inspect['CD_MATL']; ?></td>
                                                                                    <td><?php echo $Data_inspect['CD_MATL_LOT']; ?></td>
                                                                                    <td><?php echo $Data_inspect['TEMP_MAX1']; ?></td>
                                                                                    <td><?php echo $Data_inspect['TEMP_MAX2']; ?></td>
                                                                                    <td><?php echo $Data_inspect['TEMP_MAX3']; ?></td>
                                                                                    <td><?php echo $Data_inspect['TEMP_MAX4']; ?></td>
                                                                                    <td><?php echo $Data_inspect['DEVIATION'].' ('.$Data_inspect['DEVIATION_MIN'].'~'.$Data_inspect['DEVIATION_MAX'].')'; ?></td>
                                                                                    <td><?php echo $Data_inspect['DEVIATION_DECIDE']; ?></td>
                                                                                    <td><?php echo ($Data_inspect['INSERT_DT'] instanceof DateTime) ? $Data_inspect['INSERT_DT']->format('Y-m-d H:i:s') : $Data_inspect['INSERT_DT']; ?></td>
                                                                                </tr>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div> 
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form> 
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
    // MSSQL, MARIA DB 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
    if(isset($connect4)) { mysqli_close($connect4); }	
?>