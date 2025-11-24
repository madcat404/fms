<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.2.13>
	// Description:	<경비원 보고서>	
    // Last Modified: <25.10.15> - Refactored for PHP 8.x	
	// =============================================
    include 'report_guard_status.php';   
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">경비 보고서 (<?php echo $Minus1Day; ?>)</h1>
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
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">당숙일지</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">순찰</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            - 주야 2교대 (24시간) <br>
                                            - 순찰시간 (20:00~22:00 / 05:30~06:30)    
                                        </div>
                                        
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">  
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">근무자</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body">
                                                            <!-- Begin row -->
                                                            <div class="row">                                                        
                                                                <!-- Begin 근무자 -->
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>선택</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fas fa-user"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="guard" value="<?php echo htmlspecialchars($Data_Guard['GUARD'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end 근무자 -->             
                                                            </div> 
                                                            <!-- /.row -->         
                                                        </div> 
                                                        <!-- /.card-body -->    
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->                                                      
                                                </div>
                                                <!-- /.card -->
                                            </div>    
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">방문자</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample22">                                    
                                                        <div class="card-body table-responsive p-2">
                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped" id="table2">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>업체명</th>
                                                                            <th>방문목적</th>
                                                                            <th>방문시간</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php while ($Data_GuestToday = sqlsrv_fetch_array($Result_GuestToday, SQLSRV_FETCH_ASSOC)): ?>
                                                                        <tr>
                                                                            <td><?php echo htmlspecialchars($Data_GuestToday['NAME'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($Data_GuestToday['PURPOSE'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($Data_GuestToday['DT'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                                        </tr> 
                                                                        <?php endwhile; ?>
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
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">전산관리 외 법인차</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample24">                                    
                                                        <div class="card-body">
                                                            <!-- Begin row -->
                                                            <div class="row">                                                        
                                                                <!-- Begin 차량번호 -->
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>차량번호</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                <i class="fas fa-car"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="car1" value="<?php echo htmlspecialchars($Data_Guard['COMPANY_CAR'] ?? '3101(G90), 1156(벤츠), 5210(쏘나타), 0300(씨에나)', ENT_QUOTES, 'UTF-8'); ?>" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end 차량번호 -->              
                                                            </div> 
                                                            <!-- /.row -->         
                                                        </div> 
                                                        <!-- /.card-body -->    
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->                                                      
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample26" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample26">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">순찰</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample26">                                    
                                                        <div class="card-body">
                                                            <!-- Begin row -->
                                                            <div class="row">                                                        
                                                                <!-- Begin 특이사항 -->
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>특이사항</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fas fa-sticky-note"></i>
                                                                                </span>
                                                                            </div>
                                                                            <textarea rows="5" class="form-control" name="note" disabled><?php echo htmlspecialchars($Data_Guard['NOTE'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end 특이사항 -->              
                                                            </div> 
                                                            <!-- /.row -->         
                                                        </div> 
                                                        <!-- /.card-body -->    
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->                                                      
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                        </div> 
                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <!-- 순찰!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">순찰</h6>
                                                    </a>                                                    
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample31">
                                                        <div class="card-body table-responsive p-2">  
                                                            <div id="table" class="table-editable"> 
                                                                <table class="table table-bordered" id="table6">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center;">구분</th>
                                                                            <th style="text-align: center;">NFC 위치</th>
                                                                            <th style="text-align: center;">착안점</th>
                                                                            <th style="text-align: center;">점검</th>
                                                                            <th style="text-align: center;">점검시간1</th>
                                                                            <th style="text-align: center;">점검시간2</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                        <tr>
                                                                            <td rowspan="10" style="vertical-align: middle; text-align: center;">NFC</td>  
                                                                            <td>와인딩실</td>   
                                                                            <td>시건, 화재, 소등, 냉/난방기, 환풍기</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php
                                                                                if(isset($Data_TodayCheckList['NFC1']) && $Data_TodayCheckList['NFC1'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC1' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC1' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>    
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC1_TIME1']) ? $Data_TodayCheckList['NFC1_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC1_TIME2']) ? $Data_TodayCheckList['NFC1_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr>   
                                                                        <tr>
                                                                            <td>ECU 창고</td> 
                                                                            <td>시건, 화재, 소등, 냉/난방기, 환풍기</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php 
                                                                                if(isset($Data_TodayCheckList['NFC2']) && $Data_TodayCheckList['NFC2'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC2' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC2' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>  
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC2_TIME1']) ? $Data_TodayCheckList['NFC2_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC2_TIME2']) ? $Data_TodayCheckList['NFC2_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>완성품 창고</td> 
                                                                            <td>시건, 화재, 소등, 냉/난방기, 환풍기</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php 
                                                                                if(isset($Data_TodayCheckList['NFC3']) && $Data_TodayCheckList['NFC3'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC3' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC3' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC3_TIME1']) ? $Data_TodayCheckList['NFC3_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC3_TIME2']) ? $Data_TodayCheckList['NFC3_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr> 
                                                                        <tr>
                                                                            <td>B/B 창고</td> 
                                                                            <td>시건, 화재, 소등, 냉/난방기, 환풍기</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php 
                                                                                if(isset($Data_TodayCheckList['NFC4']) && $Data_TodayCheckList['NFC4'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC4' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC4' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>  
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC4_TIME1']) ? $Data_TodayCheckList['NFC4_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC4_TIME2']) ? $Data_TodayCheckList['NFC4_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr> 
                                                                        <tr>
                                                                            <td>자재창고</td> 
                                                                            <td>시건, 화재, 소등, 냉/난방기, 환풍기</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php 
                                                                                if(isset($Data_TodayCheckList['NFC5']) && $Data_TodayCheckList['NFC5'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC5' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC5' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>    
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC5_TIME1']) ? $Data_TodayCheckList['NFC5_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC5_TIME2']) ? $Data_TodayCheckList['NFC5_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr>  
                                                                        <tr>
                                                                            <td>공무실</td> 
                                                                            <td>시건, 화재, 소등, 냉/난방기, 환풍기</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php 
                                                                                if(isset($Data_TodayCheckList['NFC6']) && $Data_TodayCheckList['NFC6'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC6' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC6' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>    
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC6_TIME1']) ? $Data_TodayCheckList['NFC6_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC6_TIME2']) ? $Data_TodayCheckList['NFC6_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr>  
                                                                        <tr>
                                                                            <td>시험실</td> 
                                                                            <td>시건, 화재, 소등</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php 
                                                                                if(isset($Data_TodayCheckList['NFC7']) && $Data_TodayCheckList['NFC7'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC7' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC7' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>    
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC7_TIME1']) ? $Data_TodayCheckList['NFC7_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC7_TIME2']) ? $Data_TodayCheckList['NFC7_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>서버실</td> 
                                                                            <td>화재, 소등</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php 
                                                                                if(isset($Data_TodayCheckList['NFC8']) && $Data_TodayCheckList['NFC8'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC8' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC8' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>    
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC8_TIME1']) ? $Data_TodayCheckList['NFC8_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC8_TIME2']) ? $Data_TodayCheckList['NFC8_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>기숙사</td> 
                                                                            <td>시건, 화재, 소등</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php 
                                                                                if(isset($Data_TodayCheckList['NFC9']) && $Data_TodayCheckList['NFC9'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC9' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC9' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>    
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC9_TIME1']) ? $Data_TodayCheckList['NFC9_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC9_TIME2']) ? $Data_TodayCheckList['NFC9_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>식당</td> 
                                                                            <td>시건, 화재, 소등, 물샘</td> 
                                                                            <td style="text-align: center;">
                                                                            <?php 
                                                                                if(isset($Data_TodayCheckList['NFC10']) && $Data_TodayCheckList['NFC10'] == 'on') {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC10' style='zoom: 2;' checked disabled></td>  
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type='checkbox' name='NFC10' style='zoom: 2;' disabled></td>  
                                                                            <?php 
                                                                                }
                                                                            ?>    
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC10_TIME1']) ? $Data_TodayCheckList['NFC10_TIME1']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                            <td><?php echo isset($Data_TodayCheckList['NFC10_TIME2']) ? $Data_TodayCheckList['NFC10_TIME2']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr>                                                                                                                                             
                                                                    </tbody>
                                                                </table> 
                                                                <br>
                                                                <!-- Begin 조치사항 -->
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>조치사항</label>
                                                                        <div class="input-group">    
                                                                            <textarea rows="8" class="form-control" name="note31" disabled><?php echo htmlspecialchars($Data_TodayCheckList['NOTE'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end 조치사항 --> 
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
