<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.25>
	// Description:	<ERP 작업지시번호 라벨 & 공정진행표 라벨>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x	
	// =============================================
    include 'order_label_status.php';
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>   
    <meta http-equiv="refresh" content="60;"> 
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">작업지시번호 라벨</h1>
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
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">라벨발행</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">라벨발행내역</a>
                                        </li> 
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 실적 전산화를 위한 라벨 발행 전산화<BR><BR>

                                            [작업순서]<BR>
                                            1. ERP 작업지시 데이터 삽입<BR>
                                            2. ERP 작업지시 출력<BR>
                                            3. 검사 시 작업지시서에 있는 바코드를 스캔했는데 작업지시번호가 없다고 뜨는 경우<BR>
                                            4. FMS 작업지시번호 라벨에서 변경된 작업지시번호를 찾아 출력<BR>
                                             - ERP에서 작업지시 데이터를 삭제했을 가능성이 큼<BR><BR>

                                            [기능]<BR>
                                            0. 페이지<br>
                                            - [공통] 60초 마다 자동 새로고침<BR>
                                            1. 라벨발행탭<br>
                                            - [발행가능] ERP 오더상태가 발행이고 22.1.1 이후 데이터 출력<BR>
                                            - [발행가능] ERP 작업지시번호가 기록된 바코드 라벨을 발행<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 검수반<br><br>

                                            [히스토리]<BR>
                                            21.11.25)<BR>
                                            - 기존에 작업지시마다 작업지시 엑셀파일을 출력하였고 이곳에 FMS에서 발행하는 작업지시 바코드 라벨을 붙이도록 합의 하였다.<BR>
                                            22.09.28)<BR>                                            
                                            - 내부회계관리제도가 들어오면서 ERP로 작업지시를 내려야 했고 작업지시별이 아닌 금일 작업 품번당 작업지시가 내려가는 식으로 변경 되었다.<BR>
                                            25.02.21)<BR>                                            
                                            - 출력해야 하는 작업지시 데이터가 많아져 웹페이지 출력 속도가 느려지는 문제점을 개선하기 위해 최근 데이터 100개만 출력하도록 하였다.<BR><BR>

                                            [제작일]<BR>
                                            - 21.11.25<br><br> 
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">    
                                            <!-- 발행!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">발행가능</h6>
                                                    </a>
                                                    <form method="POST" action="order_label_single.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2">
                                                                <!-- Begin card-footer --> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>작업지시번호</th>
                                                                                <th>품번</th>
                                                                                <th>품명</th>
                                                                                <th>규격</th>                                                                                
                                                                                <th>지시수량</th>     
                                                                                <th>발행</th>                                                                         
                                                                            </tr>
                                                                        </thead>                                                                        
                                                                        <tbody>
                                                                            <?php 
                                                                                $i=1;
                                                                                while($Data_OrderInfo = sqlsrv_fetch_array($Result_OrderInfo))
                                                                                {
                                                                            ?>                                                                            
                                                                                <tr>
                                                                                    <input name="order_no<?php echo $i; ?>" value="<?php echo $Data_OrderInfo['NO_WO']; ?>" type="hidden">
                                                                                    <td><?php echo $Data_OrderInfo['NO_WO']; ?></td>  
                                                                                    <td><?php echo $Data_OrderInfo['CD_ITEM']; ?></td> 
                                                                                    <td><?php echo NM_ITEM($Data_OrderInfo['CD_ITEM']); ?></td> 
                                                                                    <td><?php echo ItemInfo($Data_OrderInfo['CD_ITEM'], 'STND'); ?></td> 
                                                                                    <td><?php echo (int)$Data_OrderInfo['QT_ITEM']; ?></td>                                                                                      
                                                                                    <td>
                                                                                        <button type="submit" class="btn btn-info" name="seq" value="<?php echo $i?>">발행</button>
                                                                                    </td>
                                                                                </tr> 
                                                                            
                                                                            <?php 
                                                                                    $i++;
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

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="order_label.php"> 
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
                                                                                <?php 
                                                                                    if($dt3!='') {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt3">
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" name="dt3">
                                                                                <?php 
                                                                                    }
                                                                                ?> 
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
                                                    <form method="POST" action="order_label.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32">
                                                            <div class="card-body table-responsive p-2">
                                                                <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>작업지시번호</th>
                                                                            <th>품번</th>
                                                                            <th>품명</th>
                                                                            <th>규격</th>
                                                                            <th>지시수량</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            if (isset($Result_LabelPrint)) {
                                                                                while($Data_LabelPrint = sqlsrv_fetch_array($Result_LabelPrint))
                                                                                {		
                                                                                    $Query_OrderInfo2 = "SELECT * from NEOE.NEOE.PR_WO WHERE NO_WO = '{$Data_LabelPrint['ORDER_NO']}'";             
                                                                                    $Result_OrderInfo2 = sqlsrv_query($connect, $Query_OrderInfo2, $params, $options);		
                                                                                    $Data_OrderInfo2 = sqlsrv_fetch_array($Result_OrderInfo2);  
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $Data_LabelPrint['ORDER_NO']; ?></td>  
                                                                                <td><?php echo $Data_OrderInfo2['CD_ITEM'] ?? ''; ?></td> 
                                                                                <td><?php echo isset($Data_OrderInfo2['CD_ITEM']) ? NM_ITEM($Data_OrderInfo2['CD_ITEM']) : ''; ?></td> 
                                                                                <td><?php echo isset($Data_OrderInfo2['CD_ITEM']) ? ItemInfo($Data_OrderInfo2['CD_ITEM'], 'STND') : ''; ?></td> 
                                                                                <td><?php echo isset($Data_OrderInfo2['QT_ITEM']) ? (int)$Data_OrderInfo2['QT_ITEM'] : ''; ?></td>   
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
    //MARIA DB 메모리 회수
    if (isset($connect4)) {
    mysqli_close($connect4);
}	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>