<?php 
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.10.07>
	// Description:	<하이패스 리뉴얼>	
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
    include 'hipass_status.php'; 
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">하이패스</h1>
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
                                            <a class="nav-link <?php echo htmlspecialchars($tab2 ?? '', ENT_QUOTES, 'UTF-8');?>" id="tab-two" data-toggle="pill" href="#tab2">충전</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab3 ?? '', ENT_QUOTES, 'UTF-8');?>" id="tab-three" data-toggle="pill" href="#tab3">대여 / 반납</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 하이패스카드 출납 및 내역 전산화<BR><BR>   

                                            [참조]<BR>
                                            - 현황 IN/OUT 상관없이 충전 가능<BR>
                                            - 해당 기능을 별도로 만든 이유는 카드만 빌려야 하는 예외사항이 몇번 있었기 때문 ex) 법인차 하이패스카드가 고장나서 개인출장하이패스카드를 빌려야 하는 경우 <br>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 전직원<br><br>

                                            [히스토리]<br>
                                            25.05.14<br>
                                            - 개인차량운행일지에 하이패스카드를 빌릴 수 있도록 하였는데 미숙한 사용자가 따로 입력하는 문제가 지속적으로 발생하여 해당 메뉴에서 하이패스카드를 대여, 반납 시 패스워드를 입력하도록 함 (패스워드 힌트: bc카드 패스워드 동일)<br><br>

                                            [제작일]<BR>
                                            - 21.10.07<br><br> 
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text ?? '', ENT_QUOTES, 'UTF-8');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 충전 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">충전</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="hipass.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 카드선택 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>카드선택</label>
                                                                            <select name="hipasscard" class="form-control select2" style="width: 100%;">
                                                                                <option value="" selected="selected">선택</option>
                                                                                <option value="1">개인출장1</option>
                                                                                <option value="2">개인출장2</option>
                                                                                <option value="3">개인출장3</option>
                                                                                <option value="4">개인출장4</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 카드선택 -->
                                                                    <!-- Begin 충전금액 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>충전금액</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-dollar-sign"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="card_sum" required onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 충전금액 -->
                                                                    <!-- Begin 패스워드 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>패스워드</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-key"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="password" class="form-control" name="card_admin" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 패스워드 -->                                             
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt2">충전</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <!-- 현황!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->                    
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">현황</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample22">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="dataTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>카드종류</th>
                                                                        <th>마지막 사용자</th>
                                                                        <th>대여자</th>
                                                                        <th>현황</th>
                                                                        <th>잔액</th>
                                                                        <th>대여/반납일</th>    
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($row1->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($user_row1->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($row1) && $row1->CARD_CONDITION=='OUT') {echo htmlspecialchars($row1->USER, ENT_QUOTES, 'UTF-8');} else {echo "없음";} ?></td>
                                                                        <td><?= htmlspecialchars($row1->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($row1->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($dt_row1) && $dt_row1->RETURN_DATE==NULL) {echo htmlspecialchars($dt_row1->RECORD_DATE, ENT_QUOTES, 'UTF-8');} else {echo htmlspecialchars($dt_row1->RETURN_DATE ?? '', ENT_QUOTES, 'UTF-8');} ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($row2->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($user_row2->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($row2) && $row2->CARD_CONDITION=='OUT') {echo htmlspecialchars($row2->USER, ENT_QUOTES, 'UTF-8');} else {echo "없음";} ?></td>
                                                                        <td><?= htmlspecialchars($row2->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($row2->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($dt_row2) && $dt_row2->RETURN_DATE==NULL) {echo htmlspecialchars($dt_row2->RECORD_DATE, ENT_QUOTES, 'UTF-8');} else {echo htmlspecialchars($dt_row2->RETURN_DATE ?? '', ENT_QUOTES, 'UTF-8');} ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($row3->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($user_row3->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($row3) && $row3->CARD_CONDITION=='OUT') {echo htmlspecialchars($row3->USER, ENT_QUOTES, 'UTF-8');} else {echo "없음";} ?></td>
                                                                        <td><?= htmlspecialchars($row3->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($row3->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($dt_row3) && $dt_row3->RETURN_DATE==NULL) {echo htmlspecialchars($dt_row3->RECORD_DATE, ENT_QUOTES, 'UTF-8');} else {echo htmlspecialchars($dt_row3->RETURN_DATE ?? '', ENT_QUOTES, 'UTF-8');} ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($row4->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($user_row4->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($row4) && $row4->CARD_CONDITION=='OUT') {echo htmlspecialchars($row4->USER, ENT_QUOTES, 'UTF-8');} else {echo "없음";} ?></td>
                                                                        <td><?= htmlspecialchars($row4->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($row4->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($dt_row4) && $dt_row4->RETURN_DATE==NULL) {echo htmlspecialchars($dt_row4->RECORD_DATE, ENT_QUOTES, 'UTF-8');} else {echo htmlspecialchars($dt_row4->RETURN_DATE ?? '', ENT_QUOTES, 'UTF-8');} ?></td>
                                                                    </tr>      
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
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab3_text ?? '', ENT_QUOTES, 'UTF-8');?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <!-- 대여 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">대여</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="hipass.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 카드선택 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>카드선택</label>
                                                                            <select name="hipasscard31" class="form-control select2" style="width: 100%;">
                                                                                <option value="" selected="selected">선택</option>
                                                                                <?php foreach ( $in_hipass as $option ) : ?>
                                                                                    <option value="<?= htmlspecialchars($option->NO ?? '', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($option->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 카드선택 -->
                                                                    <!-- Begin 사용자 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>사용자</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="user3" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 사용자 -->
                                                                    <!-- Begin 패스워드 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>패스워드</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-key"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="password" class="form-control" name="password31" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 패스워드 -->                                            
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">대여</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <!-- 반납 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">반납</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="hipass.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 카드선택 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>카드선택</label>
                                                                            <select name="hipasscard32" class="form-control select2" style="width: 100%;">
                                                                                <option value="" selected="selected">선택</option>
                                                                                <?php foreach ( $out_hipass as $option ) : ?>
                                                                                    <option value="<?= htmlspecialchars($option->NO ?? '', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($option->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 카드선택 -->
                                                                    <!-- Begin 카드잔액 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>카드잔액</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-dollar-sign"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="card_balance" required onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 카드잔액 -->                                          
                                                                    <!-- Begin 패스워드 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>패스워드</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-key"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="password" class="form-control" name="password32" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 패스워드 --> 
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt32">반납</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <!-- 현황!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->                    
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample33" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample33">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">현황</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample33">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="dataTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>카드종류</th>
                                                                        <th>마지막 사용자</th>
                                                                        <th>대여자</th>
                                                                        <th>현황</th>
                                                                        <th>잔액</th>
                                                                        <th>대여/반납일</th>    
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($row1->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($user_row1->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($row1) && $row1->CARD_CONDITION=='OUT') {echo htmlspecialchars($row1->USER, ENT_QUOTES, 'UTF-8');} else {echo "없음";} ?></td>
                                                                        <td><?= htmlspecialchars($row1->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($row1->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($dt_row1) && $dt_row1->RETURN_DATE==NULL) {echo htmlspecialchars($dt_row1->RECORD_DATE, ENT_QUOTES, 'UTF-8');} else {echo htmlspecialchars($dt_row1->RETURN_DATE ?? '', ENT_QUOTES, 'UTF-8');} ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($row2->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($user_row2->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($row2) && $row2->CARD_CONDITION=='OUT') {echo htmlspecialchars($row2->USER, ENT_QUOTES, 'UTF-8');} else {echo "없음";} ?></td>
                                                                        <td><?= htmlspecialchars($row2->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($row2->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($dt_row2) && $dt_row2->RETURN_DATE==NULL) {echo htmlspecialchars($dt_row2->RECORD_DATE, ENT_QUOTES, 'UTF-8');} else {echo htmlspecialchars($dt_row2->RETURN_DATE ?? '', ENT_QUOTES, 'UTF-8');} ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($row3->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($user_row3->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($row3) && $row3->CARD_CONDITION=='OUT') {echo htmlspecialchars($row3->USER, ENT_QUOTES, 'UTF-8');} else {echo "없음";} ?></td>
                                                                        <td><?= htmlspecialchars($row3->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($row3->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($dt_row3) && $dt_row3->RETURN_DATE==NULL) {echo htmlspecialchars($dt_row3->RECORD_DATE, ENT_QUOTES, 'UTF-8');} else {echo htmlspecialchars($dt_row3->RETURN_DATE ?? '', ENT_QUOTES, 'UTF-8');} ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($row4->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($user_row4->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($row4) && $row4->CARD_CONDITION=='OUT') {echo htmlspecialchars($row4->USER, ENT_QUOTES, 'UTF-8');} else {echo "없음";} ?></td>
                                                                        <td><?= htmlspecialchars($row4->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($row4->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?php if(isset($dt_row4) && $dt_row4->RETURN_DATE==NULL) {echo htmlspecialchars($dt_row4->RECORD_DATE, ENT_QUOTES, 'UTF-8');} else {echo htmlspecialchars($dt_row4->RETURN_DATE ?? '', ENT_QUOTES, 'UTF-8');} ?></td>
                                                                    </tr>      
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

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    //메모리 회수
    if (isset($connect)) {
        if ($connect instanceof mysqli) {
            mysqli_close($connect);
        } elseif (is_resource($connect) && get_resource_type($connect) === 'SQL Server Connection') {
            sqlsrv_close($connect);
        }
    }
?>