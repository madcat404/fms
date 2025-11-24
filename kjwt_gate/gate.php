<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.02.22>
	// Description:	<회사 입출문>
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
    include 'gate_status.php';

    // XSS prevention helper function
    function e($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }
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
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">입출문</h1>
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
                                            <a class="nav-link <?php echo e($tab2 ?? '');?>" id="tab-two" data-toggle="pill" href="#tab2">입출문</a>
                                        </li>                                        
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo e($tab3 ?? '');?>" id="tab-three" data-toggle="pill" href="#tab3">입출문 내역</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 입출문 전산화<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 지입기사 및 사무직<br><br>

                                            [제작일]<BR>
                                            - 23.02.22<br><br>
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo e($tab2_text ?? '');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="gate.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 선택 -->     
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>선택</label>
                                                                            <select name="inout21" class="form-control select2" style="width: 100%;">
                                                                                <option value="OUT" selected="selected">출문</option>
                                                                                <option value="IN">입문</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 선택 -->                                                                      
                                                                    <!-- Begin 이름 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>이름</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="name21" autofocus>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 이름 -->                                        
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div>  

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">금일기록</h6>
                                                    </a>                                                   
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body table-responsive p-2">
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>종류</th>
                                                                                <th>이름</th>
                                                                                <th>시간</th>
                                                                                <th>GW정보</th> 
                                                                                <th>법인차량정보</th>  
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                // Use while loop for fetching results.
                                                                                if (isset($Result_InOutToday)) {
                                                                                    while($Data_InOutToday = sqlsrv_fetch_array($Result_InOutToday, SQLSRV_FETCH_ASSOC)) {
                                                                                        $emp_name = $Data_InOutToday['NAME'];
                                                                                        $emp_seq = null;
                                                                                        $gw_info = '';
                                                                                        $car_info = '';

                                                                                        // GW 사번 추출 (Prepared Statement)
                                                                                        if (isset($connect3) && $emp_name) {
                                                                                            $stmt_emp = $connect3->prepare("SELECT emp_seq FROM t_co_emp_multi WHERE lang_code='kr' AND emp_name=?");
                                                                                            $stmt_emp->bind_param("s", $emp_name);
                                                                                            $stmt_emp->execute();
                                                                                            $Result_EMP = $stmt_emp->get_result();
                                                                                            if ($Data_EMP = $Result_EMP->fetch_assoc()) {
                                                                                                $emp_seq = $Data_EMP['emp_seq'];
                                                                                            }
                                                                                            $stmt_emp->close();
                                                                                        }

                                                                                        // GW 정보 (Prepared Statement)
                                                                                        if (isset($connect3) && $emp_seq && isset($NoHyphen_today)) {
                                                                                            $stmt_gw = $connect3->prepare("SELECT T2.att_req_title FROM t_at_att_req_detail AS T1 JOIN t_at_att_req AS T2 ON T1.req_sqno = T2.req_sqno WHERE T1.use_yn='Y' AND T1.emp_seq=? AND T1.comp_seq='1' AND T1.att_item_code IN ('1', '2', '3') AND T1.end_dt >= ? AND T1.start_dt <= ?");
                                                                                            $stmt_gw->bind_param("iss", $emp_seq, $NoHyphen_today, $NoHyphen_today);
                                                                                            $stmt_gw->execute();
                                                                                            $Result_GWInfo = $stmt_gw->get_result();
                                                                                            if ($Data_GWInfo = $Result_GWInfo->fetch_assoc()) {
                                                                                                $gw_info = $Data_GWInfo['att_req_title'];
                                                                                            }
                                                                                            $stmt_gw->close();
                                                                                        }

                                                                                        // 법인차량정보 (Prepared Statement)
                                                                                        if (isset($connect4) && $emp_name) {
                                                                                            $stmt_car = $connect4->prepare("SELECT CAR_NM FROM car_current WHERE CAR_CONDITION='대여중' AND DRIVER=?");
                                                                                            $stmt_car->bind_param("s", $emp_name);
                                                                                            $stmt_car->execute();
                                                                                            $Result_CarInfo = $stmt_car->get_result();
                                                                                            if ($Data_CarInfo = $Result_CarInfo->fetch_assoc()) {
                                                                                                $car_info = $Data_CarInfo['CAR_NM'];
                                                                                            }
                                                                                            $stmt_car->close();
                                                                                        }
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo e($Data_InOutToday['INOUT']); ?></td>
                                                                                <td><?php echo e($emp_name); ?></td>
                                                                                <td><?php echo e($Data_InOutToday['RECORD_DATE'] ? $Data_InOutToday['RECORD_DATE']->format("H:i:s") : ''); ?></td>  
                                                                                <td><?php echo e($gw_info); ?></td>
                                                                                <td><?php echo e($car_info); ?></td>                                                                              
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
                                        </div>  

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo e($tab3_text ?? '');?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="gate.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 검색범위 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo e($dt3 ?? ''); ?>" name="dt3" placeholder="<?php echo date('Y-m-d').' ~ '.date('Y-m-d'); ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 검색범위 -->                                       
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
                                                            </div>
                                                            <!-- /.card-footer -->    
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>  

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32">
                                                            <div class="card-body table-responsive p-2">
                                                                <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>종류</th>
                                                                            <th>이름</th>
                                                                            <th>일시</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            if (isset($Result_InOutPrint)) {
                                                                                // Use while loop and fix bug using $Data_InOutPrint
                                                                                while($Data_InOutPrint = sqlsrv_fetch_array($Result_InOutPrint, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo e($Data_InOutPrint['INOUT']); ?></td>  
                                                                            <td><?php echo e($Data_InOutPrint['NAME']); ?></td>  
                                                                            <td><?php echo e($Data_InOutPrint['RECORD_DATE'] ? $Data_InOutPrint['RECORD_DATE']->format("Y-m-d H:i:s") : ''); ?></td>  
                                                                        </tr> 
                                                                        <?php 
                                                                                }
                                                                            }
                                                                        ?>       
                                                                    </tbody>
                                                                </table>                                     
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
    // Safely close DB connections
    if(isset($connect4)) { mysqli_close($connect4); } 
    if(isset($connect3)) { mysqli_close($connect3); }
    if(isset($connect)) { sqlsrv_close($connect); }
?>
