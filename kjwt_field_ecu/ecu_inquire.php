<?php 
    // =============================================
	// Author:	<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.10.21>
	// Description:	<ecu 조회 통합>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Data Integrity
	// =============================================
    include 'ecu_inquire_status.php';
    // Helper function to prevent XSS
    function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>

    <!-- 내수/수출 체크박스 -->
    <script language="javascript">
        //체크박스 체크 여부에 따른 input 비활성화
        function checkDisable(form)
        {
            if( form.cb.checked == true )
            {
                form.item52.value = '한국';
                form.item52.disabled = true;
            }
            else 
            {
                form.item52.value = '';
                form.item52.disabled = false;
            }
        }
    </script>
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">ECU 조회</h1>
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
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">수불부</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3);?>" id="tab-three" data-toggle="pill" href="#tab3">입고내역</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab4);?>" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings">출고내역</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab5);?>" id="custom-tabs-one-5th-tab" data-toggle="pill" href="#custom-tabs-one-5th">등록</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab6);?>" id="custom-tabs-one-6th-tab" data-toggle="pill" href="#custom-tabs-one-6th">삭제내역</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - ECU 관련 각종 내역 조회 전산화<BR><BR>

                                            [기능]<br>
                                            0. 페이지<br>
                                            - [공통] 검색범위가 180일을 초과하여 검색할 수 없습니다.<br>
                                            - [공통] 검색범위에서 종료일이 시작일보다 큰경우 팝업창이 생성됩니다.<br>
                                            1. 수불부탭<br>
                                            - [결과] 샘플은 수출로 표현됩니다.<br>                                            
                                            - [결과] 등록된 품번만 출력됩니다. (입고/출고내역에서는 등록되지 않은 품번 이동내역이 출력될 수 있습니다.)<br>
                                            - [결과] ※특수품번: 88196-S0100 : 한국과 슬로바키아에 납품하지만 구분이 내수로 되어 있음<br>
                                            - <del>[결과] 자투리와 AS는 표현되지 않습니다.</del><br>
                                            - <del>[결과] 품명은 ERP 데이터를 참조하므로 ERP 데이터가 불완전한 경우 표현되지 않을 수 있습니다.</del><br>
                                            - <del>[결과] 안전재고공식: (전월 출고평균+금월일별 출고수량 합)/출고일수*2</del><br>
                                            - <del>[결과] 최대수용재고공식: 전월 출고평균과 금월일별 출고수량 중 가장 큰 수량*2</del><br>
                                            - <del>[결과] 현재고가 안전재고보다 낮으면 빨간색 음영으로 표시됩니다.</del><br>    
                                            2. 등록탭
                                            - [입력] 내수,수출 입력칸이 한국인 경우 종류가 내수로 설정되고, 체크해제하여 다른국가를 입력 시 종류는 수출로 등록됩니다.<br>
                                            - <del>[입력] ERP와 다른 ECU 전용 품목 테이블을 사용하므로 입출고가 되기 위해 ECU 품번을 등록해야 함</del><br>
                                            - <del>[입력] FMS는 ERP의 데이터를 참.조하는것이지 연.동되어 있는 것이 아닙니다.</del><br>
                                            - <del>[입력] ERP에 등록되어 있지 않으면 차종, 품명, CY코드가 나타나지 않습니다.</del><br><br>      

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: ecu 창고 관리자<br>                  
                                            - 과거에 1개의 페이지에 ECU입고,출고,조회가 모두 있었고 속도이슈가 있어 페이지를 분할하였음<br><br>   

                                            [제작일]<BR>
                                            - 21.10.21                                            
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="ecu_inquire.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
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
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt2 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt2">
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">검색</button>
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
                                                    <!-- 상단정보 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                    <div class="col-lg-12"> 
                                                        <div class="row">
                                                            <!-- 보드 시작 -->
                                                            <?php 
                                                                if (function_exists('BOARD')) {
                                                                    BOARD(3, "primary", "기초재고 합계", ($row_storage2['START_QT'] ?? 0) + ($row_basicT['PCS'] ?? 0) - ($row_basic2T['PCS'] ?? 0), "fas fa-boxes");
                                                                    BOARD(3, "primary", "입고 합계", $row_inT['PCS'] ?? 0, "fas fa-boxes");
                                                                    BOARD(3, "primary", "출고 합계", $row_outT['PCS'] ?? 0, "fas fa-boxes");
                                                                    BOARD(3, "primary", "기말재고 합계", ($row_storage2['START_QT'] ?? 0) + ($row_basicT['PCS'] ?? 0) - ($row_basic2T['PCS'] ?? 0) + ($row_inT['PCS'] ?? 0) - ($row_outT['PCS'] ?? 0), "fas fa-boxes");
                                                                }
                                                            ?>
                                                        </div>

                                                    </div>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-striped" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>구분</th>
                                                                        <th>품목</th>
                                                                        <th>자동차품번</th>
                                                                        <th>내부품번</th>
                                                                        <th>품명</th>
                                                                        <th>기초재고</th>
                                                                        <th>입고</th>
                                                                        <th>출고</th>
                                                                        <th>기말재고</th> 
                                                                        <th>판매지역</th>   
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($storage_data_array)) {
                                                                            foreach($storage_data_array as $row_storage)
                                                                            {
                                                                                $cd_item = $row_storage['CD_ITEM'];

                                                                                $query_basic = "SELECT SUM(QT_GOODS) AS PCS FROM CONNECT.dbo.ECU_INPUT_LOG WHERE CD_ITEM=? AND (SORTING_DATE BETWEEN ? AND ?)";
                                                                                $result_basic = sqlsrv_query($connect21, $query_basic, [$cd_item, $init, $y_dt2]);
                                                                                $row_basic = sqlsrv_fetch_array($result_basic, SQLSRV_FETCH_ASSOC);

                                                                                $query_basic2 = "SELECT SUM(QT_GOODS) AS PCS FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE CD_ITEM=? AND (SORTING_DATE BETWEEN ? AND ?)";
                                                                                $result_basic2 = sqlsrv_query($connect21, $query_basic2, [$cd_item, $init, $y_dt2]);
                                                                                $row_basic2 = sqlsrv_fetch_array($result_basic2, SQLSRV_FETCH_ASSOC);

                                                                                $query_in = "SELECT SUM(QT_GOODS) AS PCS FROM CONNECT.dbo.ECU_INPUT_LOG WHERE CD_ITEM=? AND (SORTING_DATE BETWEEN ? AND ?)";
                                                                                $result_in = sqlsrv_query($connect21, $query_in, [$cd_item, $s_dt2, $e_dt2]);
                                                                                $row_in = sqlsrv_fetch_array($result_in, SQLSRV_FETCH_ASSOC);

                                                                                $query_out = "SELECT SUM(QT_GOODS) AS PCS FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE CD_ITEM=? AND (SORTING_DATE BETWEEN ? AND ?)";
                                                                                $result_out = sqlsrv_query($connect21, $query_out, [$cd_item, $s_dt2, $e_dt2]);
                                                                                $row_out = sqlsrv_fetch_array($result_out, SQLSRV_FETCH_ASSOC);
                                                                                
                                                                                $row_nm = null;
                                                                                $row_nm2 = null;
                                                                                $num_chk2 = 0;

                                                                                $query_chk = "SELECT * FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND STND_ITEM=? AND CD_ITEM LIKE 'CY020%'";
                                                                                $result_chk = sqlsrv_query($connect21, $query_chk, [$cd_item]);
                                                                                $row_nm = sqlsrv_fetch_array($result_chk, SQLSRV_FETCH_ASSOC);

                                                                                if(!$row_nm) {
                                                                                    $like_param = '%' . $cd_item . '%';
                                                                                    $query_chk2 = "SELECT * FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND (((STND_ITEM LIKE ? OR STND_ITEM = ?) AND CD_ITEM LIKE 'CY%') OR (STND_DETAIL_ITEM LIKE ? AND CD_ITEM LIKE 'CY%'))";
                                                                                    $result_chk2 = sqlsrv_query($connect21, $query_chk2, [$like_param, $cd_item, $like_param]);
                                                                                    $row_nm = sqlsrv_fetch_array($result_chk2, SQLSRV_FETCH_ASSOC);
                                                                                    $num_chk2 = $row_nm ? 1 : 0;

                                                                                    if ($row_nm) {
                                                                                        $query_nm2 = "SELECT IGRP.NM_ITEMGRP FROM NEOE.NEOE.MA_PITEM P LEFT JOIN NEOE.NEOE.MA_ITEMGRP IGRP ON P.GRP_ITEM = IGRP.CD_ITEMGRP WHERE (P.STND_ITEM LIKE ? OR P.STND_ITEM = ?) AND P.CD_ITEM LIKE 'CY%' AND IGRP.NM_ITEMGRP IS NOT NULL";
                                                                                        $result_nm2 = sqlsrv_query($connect21, $query_nm2, [$like_param, $cd_item]);
                                                                                        $row_nm2 = sqlsrv_fetch_array($result_nm2, SQLSRV_FETCH_ASSOC);
                                                                                    }
                                                                                }
                                                                                if(!$row_nm) {
                                                                                    $query_nm = "SELECT * FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND CD_ITEM=?";
                                                                                    $result_nm = sqlsrv_query($connect21, $query_nm, [$cd_item]);
                                                                                    $row_nm = sqlsrv_fetch_array($result_nm, SQLSRV_FETCH_ASSOC);
                                                                                    if ($row_nm) {
                                                                                        $query_nm2 = "SELECT IGRP.NM_ITEMGRP FROM NEOE.NEOE.MA_PITEM P LEFT JOIN NEOE.NEOE.MA_ITEMGRP IGRP ON P.GRP_ITEM = IGRP.CD_ITEMGRP WHERE P.CD_ITEM=? AND IGRP.NM_ITEMGRP IS NOT NULL";
                                                                                        $result_nm2 = sqlsrv_query($connect21, $query_nm2, [$cd_item]);
                                                                                        $row_nm2 = sqlsrv_fetch_array($result_nm2, SQLSRV_FETCH_ASSOC);
                                                                                    }
                                                                                }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo h($row_storage['KIND']); ?></td>
                                                                        <td><?php echo h($row_nm2['NM_ITEMGRP'] ?? ''); ?></td>
                                                                        <td><?php echo h($row_storage['CD_ITEM']); ?></td>   
                                                                        <td><?php echo ($num_chk2 > 0) ? h($row_nm['CD_ITEM']) : '-'; ?></td> 
                                                                        <td><?php echo h($row_nm['NM_ITEM'] ?? ''); ?></td> 
                                                                        <td><?php echo h(($row_storage['START_QT'] ?? 0) + ($row_basic['PCS'] ?? 0) - ($row_basic2['PCS'] ?? 0)); ?></td> 
                                                                        <td><?php echo h($row_in['PCS'] ?? 0); ?></td>                              
                                                                        <td><?php echo h($row_out['PCS'] ?? 0); ?></td>                                                                        
                                                                        <td><?php echo h(($row_storage['START_QT'] ?? 0) + ($row_basic['PCS'] ?? 0) - ($row_basic2['PCS'] ?? 0) + ($row_in['PCS'] ?? 0) - ($row_out['PCS'] ?? 0)); ?></td>
                                                                        <td><?php echo h($row_storage['SALE_LOCAL']); ?></td>
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

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="ecu_inquire.php"> 
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
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt3">
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
                                                                        <th>자동차품번</th>
                                                                        <th>내부품번</th>
                                                                        <th>품명</th>
                                                                        <th>로트날짜</th>
                                                                        <th>박스수량</th>
                                                                        <th>개별수량</th> 
                                                                        <th>위치</th>
                                                                        <th>비고</th>
                                                                        <th>수기입력</th>
                                                                        <th>입고일</th>   
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($input_log_data_array)) {
                                                                            foreach($input_log_data_array as $r_input_log)
                                                                            { 
                                                                                $cd_item = $r_input_log['CD_ITEM'];
                                                                                $q_item_nm = "SELECT CD_ITEM, NM_ITEM FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND (((STND_ITEM LIKE ? OR STND_ITEM = ?) AND CD_ITEM LIKE 'CY%') OR (STND_DETAIL_ITEM LIKE ? AND CD_ITEM LIKE 'CY%'))";
                                                                                $like_param = '%' . $cd_item . '%';
                                                                                $rs_item_nm = sqlsrv_query($connect21, $q_item_nm, [$like_param, $cd_item, $like_param]);
                                                                                $r_item_nm = sqlsrv_fetch_array($rs_item_nm, SQLSRV_FETCH_ASSOC);

                                                                                if(!$r_item_nm) {
                                                                                    $q_item_nm = "SELECT CD_ITEM, NM_ITEM FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND CD_ITEM=?";
                                                                                    $rs_item_nm = sqlsrv_query($connect21, $q_item_nm, [$cd_item]);
                                                                                    $r_item_nm = sqlsrv_fetch_array($rs_item_nm, SQLSRV_FETCH_ASSOC);
                                                                                }

                                                                                $Query_handwrite = "SELECT COUNT(*) as count FROM CONNECT.dbo.ECU_INPUT_LOG WHERE BARCODE LIKE 'handwrite%' AND CD_ITEM = ? AND SORTING_DATE = ?";
                                                                                $Result_handwrite = sqlsrv_query($connect21, $Query_handwrite, [$cd_item, $r_input_log['SORTING_DATE']]);
                                                                                $Data_handwrite = sqlsrv_fetch_array($Result_handwrite, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo h($r_input_log['CD_ITEM']); ?></td>
                                                                        <td><?php echo h($r_item_nm['CD_ITEM'] ?? '-'); ?></td>    
                                                                        <td><?php echo h($r_item_nm['NM_ITEM'] ?? ''); ?></td>  
                                                                        <td><?php echo h($r_input_log['LOT_DATE']); ?></td>                               
                                                                        <td><?php echo h($r_input_log['BOX']); ?></td>
                                                                        <td><?php echo h($r_input_log['PCS']); ?></td>
                                                                        <td><?php echo h($r_input_log['LOCATION']); ?></td>
                                                                        <td><?php echo h($r_input_log['NOTE']); ?></td>
                                                                        <td><?php echo (($Data_handwrite['count'] ?? 0) >= 1) ? 'Y' : 'N'; ?></td>
                                                                        <td><?php echo h($r_input_log['SORTING_DATE']); ?></td>
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
                                        
                                        <!-- 4번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo h($tab4_text);?>" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="ecu_inquire.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample41">                                    
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
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt4">
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt41">검색</button>
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
                                                    <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample42">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table5">
                                                                <thead>
                                                                    <tr>
                                                                        <th>자동차품번</th>
                                                                        <th>내부품번</th>
                                                                        <th>품명</th>
                                                                        <th>로트날짜</th>
                                                                        <th>박스수량</th>
                                                                        <th>개별수량</th> 
                                                                        <th>위치</th>
                                                                        <th>비고</th>
                                                                        <th>수기입력</th>
                                                                        <th>출고일</th>   
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($output_log_data_array)) {
                                                                            foreach($output_log_data_array as $r_output_log)
                                                                            { 
                                                                                $cd_item = $r_output_log['CD_ITEM'];
                                                                                $q_item_nm2 = "SELECT CD_ITEM, NM_ITEM FROM NEOE.NEOE.MA_PITEM WHERE STND_ITEM=? AND CD_ITEM LIKE 'CY%'";
                                                                                $rs_item_nm2 = sqlsrv_query($connect21, $q_item_nm2, [$cd_item]);
                                                                                $r_item_nm2 = sqlsrv_fetch_array($rs_item_nm2, SQLSRV_FETCH_ASSOC);

                                                                                if(!$r_item_nm2) {
                                                                                    $q_item_nm2 = "SELECT CD_ITEM, NM_ITEM FROM NEOE.NEOE.MA_PITEM WHERE STND_ITEM=? AND CD_ITEM=?";
                                                                                    $rs_item_nm2 = sqlsrv_query($connect21, $q_item_nm2, [$cd_item, $cd_item]);
                                                                                    $r_item_nm2 = sqlsrv_fetch_array($rs_item_nm2, SQLSRV_FETCH_ASSOC);
                                                                                }

                                                                                $Query_handwrite2 = "SELECT COUNT(*) as count FROM CONNECT.dbo.ECU_OUTPUT_LOG WHERE BARCODE LIKE 'handwrite%' AND CD_ITEM = ? AND SORTING_DATE = ?";
                                                                                $Result_handwrite2 = sqlsrv_query($connect21, $Query_handwrite2, [$cd_item, $r_output_log['SORTING_DATE']]);
                                                                                $Data_handwrite2 = sqlsrv_fetch_array($Result_handwrite2, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo h($r_output_log['CD_ITEM']); ?></td>                                     
                                                                        <td><?php echo h($r_item_nm2['CD_ITEM'] ?? '-'); ?></td>   
                                                                        <td><?php echo h($r_item_nm2['NM_ITEM'] ?? ''); ?></td>  
                                                                        <td><?php echo h($r_output_log['LOT_DATE']); ?></td>                               
                                                                        <td><?php echo h($r_output_log['BOX']); ?></td>
                                                                        <td><?php echo h($r_output_log['PCS']); ?></td>
                                                                        <td><?php echo h($r_output_log['LOCATION']); ?></td>
                                                                        <td><?php echo h($r_output_log['NOTE']); ?></td>
                                                                        <td><?php echo (($Data_handwrite2['count'] ?? 0) >= 1) ? 'Y' : 'N'; ?></td>
                                                                        <td><?php echo h($r_output_log['SORTING_DATE']); ?></td>
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

                                        <!-- 5번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo h($tab5_text);?>" id="custom-tabs-one-5th" role="tabpanel" aria-labelledby="custom-tabs-one-5th-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="ecu_inquire.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample51">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                    
                                                                    <!-- Begin 품번 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>자동차품번</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-signature"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" required name="item51" pattern="[a-zA-Z0-9^_()_-]+">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 품번 --> 
                                                                    <!-- Begin 내수/수출 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>내수, 수출</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <input type="checkbox" checked="checked" id="ex_chk3" name="cb" onClick="checkDisable(this.form)">
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" disabled value="한국" class="form-control" required name="item52">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 내수/수출 -->                                      
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt51">등록</button>
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
                                                    <a href="#collapseCardExample52" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample52">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">ECU창고 관리항목</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="ecu_inquire.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample52">
                                                            <div class="card-body table-responsive p-2">
                                                                <table class="table table-bordered table-hover text-nowrap" id="table6">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>종류</th>
                                                                            <th>차종</th>
                                                                            <th>자동차품번</th>
                                                                            <th>내부품번</th>
                                                                            <th>품명</th>
                                                                            <th>판매지역</th>                                                                         
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            if (isset($register_data_array)) {
                                                                                foreach($register_data_array as $r_register)
                                                                                { 
                                                                                    $cd_item = $r_register['CD_ITEM'];
                                                                                    $row_nm51 = null;
                                                                                    $row_nm52 = null;
                                                                                    $num_nm51_chk = 0;

                                                                                    $query_chk2 = "SELECT * FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND STND_ITEM=? AND CD_ITEM LIKE 'CY020%'";
                                                                                    $result_chk2 = sqlsrv_query($connect21, $query_chk2, [$cd_item]);
                                                                                    $row_nm51 = sqlsrv_fetch_array($result_chk2, SQLSRV_FETCH_ASSOC);

                                                                                    if(!$row_nm51) {
                                                                                        $like_param = '%' . $cd_item . '%';
                                                                                        $query_nm51_chk = "SELECT * FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND (((STND_ITEM LIKE ? OR STND_ITEM = ?) AND CD_ITEM LIKE 'CY%') OR (STND_DETAIL_ITEM LIKE ? AND CD_ITEM LIKE 'CY%'))";
                                                                                        $result_nm51_chk = sqlsrv_query($connect21, $query_nm51_chk, [$like_param, $cd_item, $like_param]);
                                                                                        $row_nm51 = sqlsrv_fetch_array($result_nm51_chk, SQLSRV_FETCH_ASSOC);
                                                                                        $num_nm51_chk = $row_nm51 ? 1 : 0;

                                                                                        if ($row_nm51) {
                                                                                            $query_nm52 = "SELECT IGRP.NM_ITEMGRP FROM NEOE.NEOE.MA_PITEM P LEFT JOIN NEOE.NEOE.MA_ITEMGRP IGRP ON P.GRP_ITEM = IGRP.CD_ITEMGRP WHERE (P.STND_ITEM LIKE ? OR P.STND_ITEM = ?) AND P.CD_ITEM LIKE 'CY%' AND IGRP.NM_ITEMGRP IS NOT NULL";
                                                                                            $result_nm52 = sqlsrv_query($connect21, $query_nm52, [$like_param, $cd_item]);
                                                                                            $row_nm52 = sqlsrv_fetch_array($result_nm52, SQLSRV_FETCH_ASSOC);
                                                                                        }
                                                                                    }
                                                                                    if(!$row_nm51) {
                                                                                        $query_nm51 = "SELECT * FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND CD_ITEM=?";
                                                                                        $result_nm51 = sqlsrv_query($connect21, $query_nm51, [$cd_item]);
                                                                                        $row_nm51 = sqlsrv_fetch_array($result_nm51, SQLSRV_FETCH_ASSOC);

                                                                                        if ($row_nm51) {
                                                                                            $query_nm52 = "SELECT IGRP.NM_ITEMGRP FROM NEOE.NEOE.MA_PITEM P LEFT JOIN NEOE.NEOE.MA_ITEMGRP IGRP ON P.GRP_ITEM = IGRP.CD_ITEMGRP WHERE P.CD_ITEM=? AND IGRP.NM_ITEMGRP IS NOT NULL";
                                                                                            $result_nm52 = sqlsrv_query($connect21, $query_nm52, [$cd_item]);
                                                                                            $row_nm52 = sqlsrv_fetch_array($result_nm52, SQLSRV_FETCH_ASSOC);
                                                                                        }
                                                                                    }
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo h($r_register['KIND']); ?></td>                                     
                                                                            <td><?php echo h($row_nm52['NM_ITEMGRP'] ?? ''); ?></td>   
                                                                            <td><?php echo h($r_register['CD_ITEM']); ?></td>  
                                                                            <td><?php echo ($num_nm51_chk > 0) ? h($row_nm51['CD_ITEM']) : '-'; ?></td>                               
                                                                            <td><?php echo h($row_nm51['NM_ITEM'] ?? ''); ?></td>
                                                                            <td><?php echo h($r_register['SALE_LOCAL']); ?></td>
                                                                        </tr> 
                                                                        <?php 
                                                                                }
                                                                            }
                                                                        ?>       
                                                                    </tbody>
                                                                </table>                                     
                                                            </div>
                                                            <!-- /.card-body -->

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt52">조회</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>
                                                </div>
                                                <!-- /.card -->
                                            </div>  
                                        </div>

                                        <!-- 6번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo h($tab6_text);?>" id="custom-tabs-one-6th" role="tabpanel" aria-labelledby="custom-tabs-one-6th-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample61" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample61">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="ecu_inquire.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample61">                                    
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
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt6 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt6">
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt61">검색</button>
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
                                                    <a href="#collapseCardExample62" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample62">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample62">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table7">
                                                                <thead>
                                                                    <tr>
                                                                        <th>입출고</th>
                                                                        <th>품번</th>
                                                                        <th>로트날짜</th>
                                                                        <th>로트번호</th>
                                                                        <th>수량</th>  
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($delete_input_data_array)) {
                                                                            foreach($delete_input_data_array as $Data_DeleteInput)
                                                                            { 
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo "입고"; ?></td> 
                                                                        <td><?php echo h($Data_DeleteInput['CD_ITEM']); ?></td> 
                                                                        <td><?php echo h($Data_DeleteInput['LOT_DATE']); ?></td>     
                                                                        <td><?php echo h($Data_DeleteInput['LOT_NUM']); ?></td>   
                                                                        <td><?php echo h($Data_DeleteInput['QT_GOODS']); ?></td>  
                                                                    </tr> 
                                                                    <?php 
                                                                            }
                                                                        }
                                                                    ?> 
                                                                    <?php 
                                                                        if (isset($delete_output_data_array)) {
                                                                            foreach($delete_output_data_array as $Data_DeleteOutput)
                                                                            { 
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo "출고"; ?></td> 
                                                                        <td><?php echo h($Data_DeleteOutput['CD_ITEM']); ?></td> 
                                                                        <td><?php echo h($Data_DeleteOutput['LOT_DATE']); ?></td>     
                                                                        <td><?php echo h($Data_DeleteOutput['LOT_NUM']); ?></td>   
                                                                        <td><?php echo h($Data_DeleteOutput['QT_GOODS']); ?></td>  
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    //메모리 회수
    if(isset($connect21)) { sqlsrv_close($connect21); }
?>