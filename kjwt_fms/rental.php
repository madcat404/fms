<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.10.12>
	// Description:	<법인차량일지 리뉴얼>	
    // Last Modified: <25.10.20> - Refactored for PHP 8.x	
	// =============================================
    include 'rental_status.php'; 
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
        

    <!-- 체크박스 체크 여부에 따른 input 비활성화 -->
    <script language="javascript">
       function checkDisable(form)
       {
            form.hipass.disabled = form.cb.checked;
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">법인차 일지</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지 / 사고대처요령</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">일지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">조회</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            ★공지★ 00:00~17:30 외 시간에 대여하는 경우 경영팀확인이 필요함<BR><BR>                                             
                                            ★공지★ 만26세 이상만 운전할 것! (법인차 보험적용 나이: 만26세 이상)<BR><BR>   

                                            [avante 7206 / avante 7207]<BR> 
                                            STEP1. 경영팀 통보 (변상주CJ 051-790-2013 / 권성근DR 051-790-2077)<BR> 
                                            STEP2. 1670-5330(오릭스 오토카 서비스)<BR> 
                                            ※자기부담금: 30만원<BR><BR>
                                        </div>

                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 대여 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">STEP1. 대여</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="rental.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 차량선택 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>차량선택</label>
                                                                            <select name="car" class="form-control select2" style="width: 100%;">
                                                                                <option value="" selected="selected">선택</option>
                                                                                <?php foreach ( $in_car as $option ) : ?>
                                                                                    <option value="<?php echo htmlspecialchars($option->CAR_NM); ?>"><?php echo htmlspecialchars($option->CAR_NM); ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 차량선택 -->
                                                                    <!-- Begin 운전자 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>운전자</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="driver" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 운전자 -->
                                                                    <!-- Begin 목적지 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>목적지</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="destination" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 목적지 -->
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">대여</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>  

                                            <!-- 차량사진 업로드 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                        <h6 class="m-0 font-weight-bold text-primary">STEP2. 파손</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="rental.php" enctype="multipart/form-data"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample24">                                    
                                                            <div class="card-body">
                                                                <p style="color: red; font-weight-bold">         
                                                                    ※ "업로드 완료" 창이 뜨지 않는 경우 사진을 분할하여 업로드 바랍니다.<br>
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 차량선택 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>차량선택</label>
                                                                            <select name="car24" class="form-control select2" style="width: 100%;">
                                                                                <option value="" selected="selected">선택</option>	
                                                                                <option value="avante 7206">Avante 7206</option>
                                                                                <option value="avante 7207">Avante 7207</option>
                                                                                <option value="Staria 9285">Staria 9285</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 차량선택 -->
                                                                    <!-- Begin 파손유무 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>파손유무</label>
                                                                            <select name="damage24" class="form-control select2" style="width: 100%;" id="damageSelection">
                                                                                <option value="" selected="selected">선택</option>		
                                                                                <option value="E">이전과 동일해요</option>	
                                                                                <option value="Y">네, 있었어요</option>
                                                                                <option value="N">아니오, 없었어요</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 파손유무 -->
                                                                    <!-- Begin 파일선택 -->     
                                                                    <div class="col-md-4" id="fileSelection" style="display: none;">
                                                                        <div class="form-group">
                                                                            <label>파일선택</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" name="file24[]" id="file24" multiple> 
                                                                                <label class="custom-file-label" for="file24">파일선택</label>
                                                                            </div>                                                      
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 파일선택 --> 

                                                                    <script>
                                                                        // Get the damage selection element and file selection div
                                                                        var damageSelection = document.getElementById('damageSelection');
                                                                        var fileSelection = document.getElementById('fileSelection');

                                                                        // Add event listener to handle changes in the damage selection
                                                                        damageSelection.addEventListener('change', function() {
                                                                            var selectedDamage = damageSelection.value;

                                                                            // Hide the file selection initially
                                                                            fileSelection.style.display = 'none';

                                                                            // Display the file selection if "네, 있었어요" is selected
                                                                            if (selectedDamage === 'Y') {
                                                                                fileSelection.style.display = 'block';
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->      

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="button" class="btn btn-info"><a href="https://fms.iwin.kr/kjwt_fms/rental_lastpic.php" style="text-decoration:none; color: white;">이전사진</a></button>
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt24">저장</button>
                                                            </div>
                                                            <!-- /.card-footer -->         
                                                        </div>
                                                    </form>  
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <!-- 반납 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->                    
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">STEP3. 반납</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="rental.php" enctype="multipart/form-data"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 차량선택 -->     
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>차량선택</label>
                                                                            <select name="arrive_car" class="form-control select2" style="width: 100%;" id="carSelection">
                                                                                <option value="" selected="selected">선택</option>
                                                                                <?php foreach ( $out_car as $option ) : ?>
                                                                                    <option value="<?php echo htmlspecialchars($option->CAR_NM); ?>"><?php echo htmlspecialchars($option->CAR_NM); ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 차량선택 -->
                                                                    <!-- Begin 주행후 계기판 거리 -->
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>주행후 계기판 거리</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-tachometer-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="number" class="form-control" name="end_km" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 주행후 계기판 거리 -->
                                                                    <!-- Begin 하이패스 잔액 -->
                                                                    <div class="col-md-3" >
                                                                        <div class="form-group">
                                                                            <label>하이패스 잔액</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <input type="checkbox" checked="checked" id="ex_chk3" name="cb" onClick="checkDisable(this.form)" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" disabled class="form-control" name="hipass" placeholder="하이패스 사용 시 체크해제 후 입력"  onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 하이패스 잔액 -->                                            
                                                                    <!-- Begin 특이사항 -->
                                                                    <div class="col-md-3" id="NoteSelection">
                                                                        <div class="form-group">
                                                                            <label>특이사항</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-sticky-note"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="note" placeholder="경영팀에 알릴사항 (자동메일발송)">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 특이사항 -->
                                                                    <!-- Begin 위치 -->
                                                                    <div class="col-md-3" id="LoctionSelection" style="display: none;">
                                                                        <div class="form-group">
                                                                            <label>주차위치</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="file" name="file"> 
                                                                                <label class="custom-file-label" for="file">파일선택</label>
                                                                            </div>                                                      
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 위치 --> 

                                                                    <script>
                                                                        // Get the car selection element and option/password divs
                                                                        var carSelection = document.getElementById('carSelection');
                                                                        var NoteSelection = document.getElementById('NoteSelection');
                                                                        var LoctionSelection = document.getElementById('LoctionSelection');

                                                                        // Add event listener to handle changes in the car selection
                                                                        carSelection.addEventListener('change', function() {
                                                                            var selectedCar = carSelection.value;

                                                                            // Hide both option and password sections initially
                                                                            NoteSelection.style.display = 'none';
                                                                            LoctionSelection.style.display = 'none';

                                                                            // Display the appropriate section based on the selected car
                                                                            if (selectedCar === 'avante 7207') {
                                                                                LoctionSelection.style.display = 'block';
                                                                            } else {
                                                                                NoteSelection.style.display = 'block';
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt22">반납</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>                                              

                                            <!-- 관리자 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->                    
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">관리자</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="rental.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse" id="collapseCardExample23">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 차량선택 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>차량선택</label>
                                                                            <select name="admin_car" class="form-control select2" style="width: 100%;">
                                                                                <option value="" selected="selected">선택</option>	
                                                                                <option value="avante 7206">Avante 7206</option>
                                                                                <option value="avante 7207">Avante 7207</option>
                                                                                <option value="Staria 9285">Staria 9285</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 차량선택 -->
                                                                    <!-- Begin 옵션선택 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>옵션</label>
                                                                            <select name="admin_condition" class="form-control select2" style="width: 100%;">
                                                                                <option value="" selected="selected">선택</option>
                                                                                <option value="확인">경영팀 확인</option>
                                                                                <option value="경비">경비실 확인</option>
                                                                                <option value="취소">대여취소</option>
                                                                                <option value="취소2">예약취소</option>
                                                                                <option value="예약">예약</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 옵션선택 -->
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
                                                                                <input type="password" class="form-control" name="admin_code" required>
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt23">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>   
                                                </div>
                                                <!-- /.card -->
                                            </div>   

                                            <!-- 현황 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->                    
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">현황</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample24">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-striped" id="table2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>차종</th>
                                                                        <th>유종</th>
                                                                        <th>상태</th>
                                                                        <th>대여일</th>
                                                                        <th>운전자</th>
                                                                        <th>목적지</th>
                                                                        <th>최종 km (이전 km)</th>
                                                                        <th>하이패스 잔액 (이전 잔액)</th> 
                                                                        <th>시간 외 근거</th> 
                                                                        <th>위치</th> 
                                                                        <th>특이사항</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>                                                             
                                                                    <tr>
                                                                        <td>avante 225하 7206</td>
                                                                        <td>LPG</td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo6->CAR_CONDITION ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo6->SEARCH_DATE ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo6->DRIVER ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo6->DESTINATION ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo6->END_KM ?? '-'); ?> (<?php echo htmlspecialchars($Data_CarInfo66->END_KM ?? '-'); ?>)</td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo6->HI_PASS ?? '-'); ?> (<?php echo htmlspecialchars($Data_CarInfo66->HI_PASS ?? '-'); ?>)</td>
                                                                        <td><?php echo htmlspecialchars($gw_title6 ?? '-'); ?></td>
                                                                        <td>-</td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo6->NOTE ?? '-'); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>avante 225하 7207</td>
                                                                        <td>LPG</td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo7->CAR_CONDITION ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo7->SEARCH_DATE ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo7->DRIVER ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo7->DESTINATION ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo7->END_KM ?? '-'); ?> (<?php echo htmlspecialchars($Data_CarInfo77->END_KM ?? '-'); ?>)</td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo7->HI_PASS ?? '-'); ?> (<?php echo htmlspecialchars($Data_CarInfo77->HI_PASS ?? '-'); ?>)</td>
                                                                        <td><?php echo htmlspecialchars($gw_title7 ?? '-'); ?></td>
                                                                        <td><button type="button" class="btn btn-info"><a href="https://fms.iwin.kr/files/<?php echo htmlspecialchars($Data_CarLocation->FILE_NM ?? ''); ?>" style="text-decoration:none; color: white;">보기</a></button></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo7->NOTE ?? '-'); ?></td>
                                                                    </tr>                                                                      
                                                                    <tr>
                                                                        <td>Staria 169하 9285</td>
                                                                        <td>경유</td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo2->CAR_CONDITION ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo2->SEARCH_DATE ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo2->DRIVER ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo2->DESTINATION ?? '-'); ?></td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo2->END_KM ?? '-'); ?> (<?php echo htmlspecialchars($Data_CarInfo22->END_KM ?? '-'); ?>)</td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo2->HI_PASS ?? '-'); ?> (<?php echo htmlspecialchars($Data_CarInfo22->HI_PASS ?? '-'); ?>)</td>
                                                                        <td><?php echo htmlspecialchars($gw_title2 ?? '-'); ?></td>
                                                                        <td>-</td>
                                                                        <td><?php echo htmlspecialchars($Data_CarInfo2->NOTE ?? '-'); ?></td>
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
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="rental.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 차량선택 -->     
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>차량선택</label>
                                                                            <select name="car" class="form-control select2" style="width: 100%;">
                                                                                <option value="<?php echo $car ?? 'all'; ?>" selected="selected"><?php echo $car ?? '모든차량'; ?></option>
                                                                                <option value="all">모든차량</option>
                                                                                <option value="avante 1296">『부산』 avante 1296</option>
                                                                                <option value="avante 1297">『부산』 avante 1297</option>
                                                                                <option value="avante 7206">『부산』 avante 7206</option>
                                                                                <option value="avante 7207">『부산』 avante 7207</option>
                                                                                <option value="K5 4639">『부산』 K5 4639</option>
                                                                                <option value="K5 4210">『부산』 K5 4210</option>
                                                                                <option value="LF 8266">『부산』 LF 8266</option>
                                                                                <option value="Starex 2918">『부산』 Starex 2918</option>
                                                                                <option value="K5 7305" style="color: red">『천안』 K5 7305</option>
                                                                            </select> 
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 차량선택 -->
                                                                    <!-- Begin 검색범위 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <?php 
                                                                                    if($dt!='') {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt">
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" name="dt">
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt3">검색</button>
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
                                                            <table class="table table-bordered table-striped" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                    <th>차종</th>
                                                                    <th>대여일</th>
                                                                    <th>반납일</th>
                                                                    <th>운전자</th>   
                                                                    <th>최종KM</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if(isset($Result_SearchCar) && $Result_SearchCar->num_rows > 0) {
                                                                            while($Data_SearchCar = $Result_SearchCar->fetch_assoc())
                                                                            {		
                                                                                echo "<tr>";	
                                                                                    echo "<td>" . htmlspecialchars($Data_SearchCar['CAR_NM']) . "</td>";											
                                                                                    echo "<td>" . htmlspecialchars($Data_SearchCar['START_TIME']) . "</td>";
                                                                                    if(empty($Data_SearchCar['END_TIME'])) {echo "<td> - </td>";} else {echo "<td>" . htmlspecialchars($Data_SearchCar['END_TIME']) . "</td>";} 
                                                                                    echo "<td>" . htmlspecialchars($Data_SearchCar['DRIVER']) . "</td>";
                                                                                    echo "<td>" . htmlspecialchars($Data_SearchCar['END_KM']) . "</td>";
                                                                                echo "</tr>";
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
                                        <!-- 탭3 end -->
                                    </div>
                                </div>
                            </div>                            
                        </div> 
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
    if(isset($connect)) { mysqli_close($connect); }	
    if(isset($connect3)) { mysqli_close($connect3); }
?>