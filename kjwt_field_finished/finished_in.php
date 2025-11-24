<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.08.24>
	// Description:	<finished 입고>
    // Last Modified: <25.09.25> - Upgraded to PhpSpreadsheet, Refactored for PHP 8.x and Security	
	// =============================================
    include 'finished_in_status.php';

    // Helper function for escaping HTML output
    function h($s) {
        return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">완성품창고 입고</h1>
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
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">입고</a>
                                        </li>                                     
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3);?>" id="tab-three" data-toggle="pill" href="#tab3">입고내역</a>
                                        </li>                                        
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 완성품창고 입고 전산화<BR><BR>   

                                            [작업순서]<BR>
                                            1. 부품식별표에 부착된 박스라벨 바코드 스캔<BR>
                                            2. 만약 박스라벨의 바코드가 없거나 개별로 들어온 경우 수기입력<BR><BR>

                                            [기능]<br>
                                            1. 입고탭<br>
                                            - [입력] 입력값 강제 대문자화, 하이폰 제거<BR>
                                            - [입력] 입력값 중 품번, 로트날짜, 로트번호 조합이 중복인 경우 경고음 및 '중복되었습니다!' 팝업창 생성<BR>
                                            - [입력] 포장메뉴 로그를 활용하여 출처가 한국생산인지 BB인지 구분<BR>
                                            - [입력] 16:30 즉 마감시간이 지나 입고된 경우 마감 후 이동 Y로 표기<BR>
                                            - [입력] 자투리인 경우 자투리 Y로 표기<BR>                                            
                                            - [수기입력] 로트 사이즈나 박스 수량이 0인 경우 입력 불가<BR>
                                            - [수기입력] 입력값 강제 대문자화, 하이폰 제거, 공백 제거<BR>
                                            - [수기입력] a로 시작하는 로트번호가 자동 생성됨<BR>
                                            - [수기입력] 16:30 즉 마감시간이 지나 입고된 경우 마감 후 이동 Y로 표기<BR>
                                            - [삭제] 입력값 강제 대문자화, 하이폰 제거, 공백 제거<BR>
                                            - [결과] 마감 후 이동 수정 가능<BR>
                                            - [결과] 비고 수정 독점화 (수정 중일 때 다른 사람이 수정 불가, 수정 버튼 푸쉬 후 5분 동안 저장하지 않을 시 다른 사람 수정 가능)<BR>
                                            - [결과] 품번으로 그룹핑하여 수량을 합산함<br>
                                            2. 입고내역탭<br>
                                            - [검색] ERP S/L간 이동 처리를 바로 할 수 있도록 ERP 업로드 양식에 검색 범위와 전일 마감 후 이동 데이터가 입력되어 다운로드됨<br><br>
                                          
                                            [히스토리]<BR>
                                            23.04.29)<BR>                                            
                                            - NX4 검사 완료 라벨과 포장 라벨이 동일한 형식이고 완성품 입고 시 검사 완료 라벨을 스캔하는 경우가 발생하여 검사 완료 라벨을 부품 식별표 뒤에 부착하도록 품질팀과 협의함(우무용DR, 배병정CJ)<BR>
                                            23.12.1)<BR> 
                                            - 오후 정도 되면 스캔 후 화면이 리프레쉬가 느려짐<BR>
                                            - http/2 프로토콜 적용 및 DB 튜닝을 해보았지만 여전히 동일함<BR>
                                            - MSSQL의 많은 양의 데이터를 출력하게 되면 (스크롤이 생성될 정도로) 속도 이슈가 있다고 함<BR> 
                                            - 따라서 금일 데이터를 자동 출력이 아닌 조회 버튼을 눌러야 출력되도록 변경하였고 속도가 개선됨<BR>
                                            - 스크롤 옵션에 대해 STATIC에서 BUFFERD로 변경하면 속도가 개선되는것을 확인했지만 일단 이 메뉴에서는 그것을 적용하지 않음<BR>                                            
                                            25.02.21)<BR> 
                                            - 250219 as_yn이 wm이 기록됨, 이 데이터가 기록될 수 있는 로직이 없는데 어떻게 됬는지 모르겠음..... 일단 m으로 기록되려고 하는데 잘못된것으로 판단되어 wm도 양산으로 표현하도록 함<BR><BR>
                                            
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 지입기사, 김진호bj, 물류팀<br>
                                            - 의견<br>
                                            &nbsp; > 23.12.19 시점에서 완성품 창고 입고 웹페이지는 작업자의 스캔 속도에 잘 맞혀 입력되고 검수반과의 분쟁 해결도 톡톡히 해 내고 있다. <br>
                                            &nbsp; > 이 웹페이지 초창기에는 버그가 많아 완성품 창고 입고 시 종이에 이동 품명과 수량을 적는 것이 이해는 갔지만 현재는 웹페이지를 보고 다시 종이에 적는 불필요한 행위를 하고 있다. <br>
                                            &nbsp; > 작업자와 대화를 통해 마감 후 이동 수량에 대한 것, 한국생산인지 bb인지 제품 출처에 대한 것 등 원하는 모든 정보가 보이도록 변경을 했기 때문에 웹페이지는 종이를 대처할 수 있다.<br>
                                            &nbsp; > 그럼에도 불구하고 작업자가 기존의 방식을 벗어나지 못하기 때문에 종이 작성을 계속하는 것으로 보인다.                                <br>
                                            &nbsp; > 이것을 해결하려면 작업자가 소속된 팀의 팀장이 종이 작성을 못하도록 강제하거나 또는 사무직이 지속적으로 2~4주 정도 옆에서 같이 변경된 프로세스를 교육해야 할 것으로 보인다.<br><br>                                         

                                            [제작일]<BR>
                                            - 22.08.24<br><br> 

                                            [FIXME]<br> 
                                            - 입고탭 상단 전일마감 후 이동 카드에 수량이 없는 경우 0 표시<br> 
                                            - 삭제 내역 탭 생성<br> 
                                            - 입고대기 뷰어 탭 생성<br><br> 
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 상단정보 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="row">
                                                    <!-- 보드 시작 -->
                                                    <?php 
                                                        BOARD(4, "success", "스캔(BOX)", h($Data_InputQuantity43['BOX'] ?? 0), "fas fa-boxes");
                                                        BOARD(4, "primary", "금일 마감 전 이동(PCS)", h($Data_InputQuantity41['PCS'] ?? 0), "fas fa-boxes");
                                                        BOARD(4, "primary", "전일 마감 후 이동(PCS)", h($Data_InputQuantity42['PCS'] ?? 0), "fas fa-boxes");
                                                    ?>
                                                </div>
                                            </div>
                                            
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="finished_in.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 라벨스캔 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>라벨스캔</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-qrcode"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="item2" autofocus pattern="[a-zA-Z0-9^_()_-]+">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 라벨스캔 -->                                        
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
                                            
                                            <!-- 수기입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">수기입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" name="pop_form" action="finished_in.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse" id="collapseCardExample22">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">   
                                                                    <!-- Begin 선택1 -->     
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>선택1</label>
                                                                            <select name="kind22a" class="form-control select2" style="width: 100%;">
                                                                                <option value="M" selected="selected">양산</option>
                                                                                <option value="A">AS</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 선택1 -->  
                                                                    <!-- Begin 선택2 -->     
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>선택2</label>
                                                                            <select name="kind22" class="form-control select2" style="width: 100%;">
                                                                                <option value="한국" selected="selected">한국</option>
                                                                                <option value="BB">BB</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 선택2 -->                                                                     
                                                                    <!-- Begin 품번 -->
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>품번</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-signature"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="cd_item22" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 품번 -->
                                                                    <!-- Begin 로트사이즈 -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>수량(PCS)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-box-open"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="number" class="form-control" name="qt_goods22" min="1" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 로트사이즈 --> 
                                                                    <!-- Begin 비고 -->
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>비고</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-sticky-note"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="note22">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 비고 -->  
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt22">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div>  

                                            <!-- 삭제 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">삭제</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="finished_in.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse" id="collapseCardExample23">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 라벨스캔 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>라벨스캔</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-qrcode"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="item2b" pattern="[a-zA-Z0-9^_()_-]+">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 라벨스캔 -->  
                                                                    <!-- Begin 수기입력 삭제 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>품번(수기입력 삭제)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-signature"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="item2b2">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 수기입력 삭제 -->                     
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt2b">입력</button>
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
                                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="finished_in.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample24">
                                                            <div class="card-body table-responsive p-2">
                                                       
                                                                <div class="row" >
                                                                    <!-- 보드 시작 -->
                                                                    <?php 
                                                                        BOARD(4, "primary", "전일 마감 후 이동수량(PCS)", h($Data_InputQuantity3['PCS'] ?? 0), "fas fa-boxes");
                                                                        BOARD(4, "primary", "금일 마감 전 이동수량(PCS)", h($Data_InputQuantity['PCS'] ?? 0), "fas fa-boxes");
                                                                        BOARD(4, "primary", "금일 마감 후 이동수량(PCS)", h($Data_InputQuantity2['PCS'] ?? 0), "fas fa-boxes");
                                                                    ?>
                                                                    <!-- 보드 끝 -->
                                                                </div>

                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table_nosort">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>양산/AS</th>
                                                                                <th>출처</th>
                                                                                <th>자동차품번</th>
                                                                                <th>품명</th>
                                                                                <th>수량</th> 
                                                                                <th>마감 후 이동</th>  
                                                                                <th>스캔일</th> 
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                $i = 1; // Initialize counter
                                                                                if (isset($Result_InputFinished)) {
                                                                                    while($Data_InputFinished = sqlsrv_fetch_array($Result_InputFinished))
                                                                                    { 
                                                                            ?>
                                                                            <tr>
                                                                                 <!-- 아무리 찾아봐도 WM이 나올수가 없는데 25.2.19에 완성품 입고에서 AS_YN에 WM이 입력됬음 아마도 M이 입력되야하는데 컴퓨터의 실수? 로 W가 같이 입력된것으로 보임, 가능성이 있다면 커스텀라벨에서 발생할 수 있음 --> 
                                                                                <td><?php $as_yn = $Data_InputFinished['AS_YN']; if($as_yn=='M' || $as_yn=='MR' || $as_yn=='WM') {echo "양산";} elseif($as_yn=='A' || $as_yn=='AR') {echo "AS";} else {echo h($as_yn);} ?></td>
                                                                                <td><?php echo h($Data_InputFinished['OUT_OF']); ?></td>
                                                                                <td><?php echo h($Data_InputFinished['CD_ITEM']); ?></td>
                                                                                <td><?php echo h(NM_ITEM(Hyphen($Data_InputFinished['CD_ITEM']))); ?></td>  
                                                                                <td><?php echo h($Data_InputFinished['QT_GOODS']); ?></td>
                                                                                <td>
                                                                                <?php 
                                                                                    if($modi=='Y') { 
                                                                                        $closing_yn_val = h($Data_InputFinished['CLOSING_YN']);
                                                                                ?> 
                                                                                        <select name="CLOSING_STATUS<?php echo $i; ?>" class="form-control select2" style="width: 100%;">
                                                                                            <option value="<?php echo $closing_yn_val; ?>" selected="selected"><?php echo $closing_yn_val; ?></option>
                                                                                            <option value="N">N</option>
                                                                                            <option value="Y">Y</option>
                                                                                        </select> 
                                                                                <?php 
                                                                                    } 
                                                                                    else {
                                                                                        echo h($Data_InputFinished['CLOSING_YN']);
                                                                                    } 
                                                                                ?>
                                                                                </td>  
                                                                                <td><?php echo $Data_InputFinished['SORTING_DATE'] ? h($Data_InputFinished['SORTING_DATE']->format("Y-m-d")) : ''; ?></td>                                                                          
                                                                            </tr> 
                                                                            <?php 
                                                                                    $i++;
                                                                                    }
                                                                                }
                                                                            ?>  
                                                                            <?php 
                                                                            ////////////////////////////////////////////////////////////////전일////////////////////////////////////////////////////////////////
                                                                                $j = 1; // Initialize counter
                                                                                if (isset($Result_InputFinished2)) {
                                                                                    while($Data_InputFinished2 = sqlsrv_fetch_array($Result_InputFinished2))
                                                                                    { 
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php $as_yn2 = $Data_InputFinished2['AS_YN']; if($as_yn2=='M' || $as_yn2=='MR') {echo "양산";} elseif($as_yn2=='A' || $as_yn2=='AR') {echo "AS";} else {echo h($as_yn2);} ?></td>
                                                                                <td><?php echo h($Data_InputFinished2['OUT_OF']); ?></td>
                                                                                <td><?php echo h($Data_InputFinished2['CD_ITEM']); ?></td>
                                                                                <td><?php echo h(NM_ITEM(Hyphen($Data_InputFinished2['CD_ITEM']))); ?></td>  
                                                                                <td><?php echo h($Data_InputFinished2['QT_GOODS']); ?></td>
                                                                                <td><?php echo h($Data_InputFinished2['CLOSING_YN']); ?></td>  
                                                                                <td><?php echo $Data_InputFinished2['SORTING_DATE'] ? h($Data_InputFinished2['SORTING_DATE']->format("Y-m-d")) : ''; ?></td>                                                                          
                                                                            </tr> 
                                                                            <?php 
                                                                                    $j++;
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
                                                    </form>
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
                                                    <form method="POST" autocomplete="off" action="finished_in.php"> 
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
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt3" id="date-range-input-3">
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
                                                                <button type="submit" value="on" class="btn btn-info" name="bt32">ERP 엑셀 다운로드</button>
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
                                                    <form method="POST" action="finished_in.php"> 
                                                        <input type="hidden" name="dt3" value="<?php echo h($dt3); ?>"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32">
                                                            <div class="card-body table-responsive p-2">
                                                                <?php
                                                                    $modify_url = "finished_in.php?modi=Y";
                                                                    if (!empty($dt3)) {
                                                                        $modify_url .= "&dt3=" . urlencode($dt3);
                                                                    }
                                                                    ModifyData2($modify_url, "bt22a", "FinishedIn");
                                                                ?>
                                                                <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>양산/AS</th>
                                                                            <th>출처</th>
                                                                            <th>자동차품번</th>
                                                                            <th>품명</th>
                                                                            <th>로트날짜</th>
                                                                            <th>로트번호</th>
                                                                            <th>생산일</th>
                                                                            <th>개별수량</th> 
                                                                            <th>자투리여부</th> 
                                                                            <th>마감 후 이동</th> 
                                                                            <th>비고</th> 
                                                                            <th>스캔일</th> 
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $k = 1;
                                                                            if (isset($LabelPrint_DataArray)) {
                                                                                foreach($LabelPrint_DataArray as $Data_LabelPrint)
                                                                                {
                                                                        ?>
                                                                        <tr>
                                                                            <input type="hidden" name="closing_no2_<?php echo $k; ?>" value="<?php echo h($Data_LabelPrint['NO']); ?>">
                                                                            <input type="hidden" name="source_table_<?php echo $k; ?>" value="<?php echo h($Data_LabelPrint['SOURCE_TABLE']); ?>">
                                                                            <td><?php $as_yn_lp = $Data_LabelPrint['AS_YN']; if($as_yn_lp=='M' || $as_yn_lp=='MR') {echo "양산";} elseif($as_yn_lp=='A' || $as_yn_lp=='AR') {echo "AS";} else {echo h($as_yn_lp);} ?></td>
                                                                            <td><?php echo h($Data_LabelPrint['OUT_OF']); ?></td>  
                                                                            <td><?php echo h($Data_LabelPrint['CD_ITEM']); ?></td>  
                                                                            <td><?php echo h(NM_ITEM($Data_LabelPrint['CD_ITEM'])); ?></td>  
                                                                            <td><?php echo h($Data_LabelPrint['LOT_DATE']); ?></td>   
                                                                            <td><?php echo h($Data_LabelPrint['LOT_NUM']); ?></td>  
                                                                            <td><?php echo h($Data_LabelPrint['MAKE_DATE'] ?? ''); ?></td> 
                                                                            <td><?php echo h($Data_LabelPrint['QT_GOODS']); ?></td> 
                                                                            <td><?php echo h($Data_LabelPrint['PIECES_YN']); ?></td> 
                                                                            <td>
                                                                            <?php 
                                                                                if($modi=='Y') { 
                                                                                    $closing_yn_val2 = h($Data_LabelPrint['CLOSING_YN']);
                                                                            ?> 
                                                                                    <select name="CLOSING_STATUS2_<?php echo $k; ?>" class="form-control select2" style="width: 100%;">
                                                                                        <option value="<?php echo $closing_yn_val2; ?>" selected="selected"><?php echo $closing_yn_val2; ?></option>
                                                                                        <option value="Y">Y</option>
                                                                                        <option value="N">N</option>
                                                                                    </select>    
                                                                            <?php 
                                                                                } 
                                                                                else {
                                                                                    echo h($Data_LabelPrint['CLOSING_YN']);
                                                                                }
                                                                            ?>    
                                                                            </td> 
                                                                            <td><?php echo h($Data_LabelPrint['NOTE']); ?></td> 
                                                                            <td><?php $sortingDate3 = $Data_LabelPrint['SORTING_DATE']; echo $sortingDate3 instanceof DateTimeInterface ? h($sortingDate3->format('Y-m-d')) : h($sortingDate3); ?></td> 
                                                                        </tr> 
                                                                        <?php 
                                                                                $k++;
                                                                                }
                                                                            }
                                                                        ?>       
                                                                    </tbody>
                                                                </table>   
                                                                
                                                                <!-- /.수정을 위해 필요 -->  
                                                                <input type="hidden" name="until" value="<?php echo $i; ?>">
                                                                <input type="hidden" name="until2" value="<?php echo $k; ?>">
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date-range-input-3');
        const downloadBtn = document.getElementById('download-excel-btn');

        function updateDownloadLink() {
            if (!dateInput || !downloadBtn) return;

            const dateRange = dateInput.value;
            if (dateRange) {
                const dates = dateRange.split(' ~ ');
                if (dates.length === 2) {
                    const startDate = dates[0];
                    const endDate = dates[1];
                    downloadBtn.href = `finished_excel.php?s_dt=${encodeURIComponent(startDate)}&e_dt=${encodeURIComponent(endDate)}`;
                }
            }
        }

        // Initial setup
        updateDownloadLink();

        // For daterangepicker, it's better to listen to its specific event
        if (dateInput) {
            $(dateInput).on('apply.daterangepicker', function(ev, picker) {
                // The input value is already updated by the plugin, so we just call our function
                updateDownloadLink();
            });
        }
    });
    </script>
</body>
</html>

<?php 
    //메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>
