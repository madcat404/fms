<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.04.28>
	// Description:	<포장라벨>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'complete_label_status.php';
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">포장라벨</h1>
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
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4;?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">삭제 및 내역</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="custom-tabs-one-5th-tab" data-toggle="pill" href="#custom-tabs-one-5th">커스텀라벨</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 포장라벨 발행<BR><BR>

                                            [기능]<BR>
                                            0. 페이지<BR>
                                            - [공통] 60초마다 리프레쉬<BR>
                                            1. 라벨발행탭<BR>
                                            - [발행가능] 발행옵션에서 여러장 선택 시 검사완료/로트사이즈 개수만큼 연속적으로 라벨이 발행됨<BR>
                                            - [발행가능] 리워크대기 수량이 있는 경우 검사메뉴에서 리워크완료로 변경 시 검사완료수량으로 변경되고 폐기로 변경 시 데이터가 사라짐<BR>
                                            2. 라벨발행내역탭<BR>
                                            - [결과] 조회 시 재발행 가능한 버튼 생성됨<BR>         
                                            3. 삭제및내역탭<BR> 
                                            - [입력] 입력값 강제 대문자화<BR>
                                            - [입력] 한국포장라벨 삭제할 경우 '한국 포장라벨 삭제는 관리자에게 문의 바랍니다!' 팝업창 생성<BR>
                                            4. 커스텀라벨탭<BR>
                                            - [라벨발행] 품번이 없는 경우 발행 불가<BR>                                            
                                            - [라벨발행] 박스 내 수량이 0인 경우 발행 불가<BR>
                                            - [라벨발행] 출력 라벨 수량이 0인 경우 발행 불가<BR>
                                            - [라벨발행] 비고에 커스텀라벨이라고 자동 기록됨<BR><BR>

                                            [히스토리]<BR>
                                            25.02.21)<BR>
                                             - 커스텀 라벨도 매핑이 가능하도록 하였음 (대문자 변환과 하이폰 미제거 되는 문제를 디버깅함)<BR>
                                             - 커스텀 라벨 발행 시 중간에 있는 공백을 제거하기 위한 매커니즘을 추가 하였음 (88888- 88888와 같은 품번이 존재하였음)<BR><BR>
                                            
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 검수반<br>
                                            - 현경바코드 업체에 의뢰한 부품식별표 하단에 바코드 생성에 대해 중복 및 기타 문제가 발생하고 변경이 필요할 시 많은 시간이 소요되어 자체 개발함<br>
                                            - A=AS / M=양산 / AR=AS자투리 / MR=양산자투리<br>
                                            - 커스텀라벨 예시: M^20240108^89190D4000^05^200<br><br>

                                            [제작일]<BR>
                                            - 22.04.28
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">    
                                            <!-- bb발행!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">발행가능</h6>
                                                    </a>
                                                    <form method="POST" action="complete_label_bundle.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2">
                                                                <!-- Begin card-footer --> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table_nosort">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>국가</th>
                                                                                <th>품번</th>
                                                                                <th>품명</th>
                                                                                <th>검사완료(발행가능)</th>                                                                                
                                                                                <th>로트사이즈</th>
                                                                                <th>리워크 대기(발행불가)</th>
                                                                                <th>발행옵션</th>
                                                                                <th>발행</th>                                                                                  
                                                                            </tr>
                                                                        </thead>                                                                        
                                                                        <tbody>                                                                            
                                                                            <?php 
                                                                                for($iv=1; $iv<=$Count_vCompleteInfo; $iv++)
                                                                                {		
                                                                                    $Data_vCompleteInfo = sqlsrv_fetch_array($Result_vCompleteInfo);                                                                                    
                                                                            ?>                                                                            
                                                                                <tr>
                                                                                    <td style="width: 1vw;"><img src="../img/flag_v.png" style="width: 3vw;"></td>
                                                                                    <input name="vITEM<?php ECHO $iv; ?>" value="<?php echo $Data_vCompleteInfo['CD_ITEM']; ?>" type="hidden">
                                                                                    <input name="vAS_YN<?php ECHO $iv; ?>" value="<?php echo $Data_vCompleteInfo['AS_YN']; ?>" type="hidden">
                                                                                    <td><?php echo $Data_vCompleteInfo['CD_ITEM']; ?></td>  
                                                                                    <td><?php echo NM_ITEM($Data_vCompleteInfo['CD_ITEM']); ?></td> 
                                                                                    <td><?php echo $Data_vCompleteInfo['VQT_GOODS']-$Data_vCompleteInfo['VREJECT_GOODS']+$Data_vCompleteInfo['VREJECT_REWORK']-$Data_vCompleteInfo['VPRINT_QT']; ?></td>  
                                                                                    <td>
                                                                                        <?php 
                                                                                            if(ItemInfo(Hyphen($Data_vCompleteInfo['CD_ITEM']), "LOTSIZE")!='0') {
                                                                                        ?>
                                                                                                <input type="number" name="vsize<?php echo $iv?>" value="<?php echo ItemInfo(Hyphen($Data_vCompleteInfo['CD_ITEM']), "LOTSIZE")?>" min="1">
                                                                                        <?php 
                                                                                            }
                                                                                            else {
                                                                                        ?>
                                                                                                <input type="number" name="vsize<?php echo $iv?>" value="<?php echo 1?>">
                                                                                        <?php 
                                                                                            }
                                                                                        ?>
                                                                                    </td>  
                                                                                    <td><?php echo $Data_vCompleteInfo['VREJECT_WAIT']; ?></td>  
                                                                                    <td>
                                                                                        <select name="voption<?php echo $iv?>" class="form-control select2" style="width: 100%;">
                                                                                            <option value="one" selected="selected">한장만</option>
                                                                                            <option value="dozen">여러장</option>
                                                                                        </select>
                                                                                    </td> 
                                                                                    <td>
                                                                                    <button type="submit" class="btn btn-info" name="seq" value="v<?php echo $iv?>">발행</button>
                                                                                    </td>
                                                                                </tr> 
                                                                            
                                                                            <?php 
                                                                                    if($Data_vCompleteInfo == false) {
                                                                                        exit;
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <?php 
                                                                                for($ic=1; $ic<=$Count_cCompleteInfo; $ic++)
                                                                                {		
                                                                                    $Data_cCompleteInfo = sqlsrv_fetch_array($Result_cCompleteInfo);
                                                                            ?>                                                                            
                                                                                <tr>
                                                                                    <td style="width: 1vw;"><img src="../img/flag_c.png" style="width: 3vw;"></td>
                                                                                    <input name="cITEM<?php ECHO $ic; ?>" value="<?php echo $Data_cCompleteInfo['CD_ITEM']; ?>" type="hidden">
                                                                                    <input name="cAS_YN<?php ECHO $ic; ?>" value="<?php echo $Data_cCompleteInfo['AS_YN']; ?>" type="hidden">
                                                                                    <td><?php echo $Data_cCompleteInfo['CD_ITEM']; ?></td>  
                                                                                    <td><?php echo NM_ITEM($Data_cCompleteInfo['CD_ITEM']); ?></td> 
                                                                                    <td><?php echo $Data_cCompleteInfo['CQT_GOODS']-$Data_cCompleteInfo['CREJECT_GOODS']+$Data_cCompleteInfo['CREJECT_REWORK']-$Data_cCompleteInfo['CPRINT_QT']; ?></td>
                                                                                    <td>
                                                                                        <?php 
                                                                                            if(ItemInfo(Hyphen($Data_cCompleteInfo['CD_ITEM']), "LOTSIZE")!='0') {
                                                                                        ?>
                                                                                                <input type="number" name="csize<?php echo $ic?>" value="<?php echo ItemInfo(Hyphen($Data_cCompleteInfo['CD_ITEM']), "LOTSIZE")?>" min="1">
                                                                                        <?php 
                                                                                            }
                                                                                            else {
                                                                                        ?>
                                                                                                <input type="number" name="csize<?php echo $ic?>" value="<?php echo 1?>">
                                                                                        <?php 
                                                                                            }
                                                                                        ?>
                                                                                    </td> 
                                                                                    <td><?php echo $Data_cCompleteInfo['CREJECT_WAIT']; ?></td>  
                                                                                    <td>
                                                                                        <select name="coption<?php echo $ic?>" class="form-control select2" style="width: 100%;">
                                                                                            <option value="one" selected="selected">한장만</option>
                                                                                            <option value="dozen">여러장</option>
                                                                                        </select>
                                                                                    </td> 
                                                                                    <td>
                                                                                    <button type="submit" class="btn btn-info" name="seq" value="c<?php echo $ic?>">발행</button>
                                                                                    </td>
                                                                                </tr> 
                                                                            
                                                                            <?php 
                                                                                    if($Data_cCompleteInfo == false) {
                                                                                        exit;
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

                                            <!-- 한국발행!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">발행가능</h6>
                                                    </a>
                                                    <form method="POST" action="complete_label_bundle.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body table-responsive p-2">
                                                                <!-- Begin card-footer --> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table_nosort">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>국가</th>
                                                                                <th>품번</th>
                                                                                <th>품명</th>
                                                                                <th>검사완료(발행가능)</th>                                                                                
                                                                                <th>로트사이즈</th>
                                                                                <th>리워크 대기(발행불가)</th>
                                                                                <th>발행옵션</th>
                                                                                <th>발행</th>                                                                                  
                                                                            </tr>
                                                                        </thead>                                                                        
                                                                        <tbody>
                                                                            <?php 
                                                                                for($i=1; $i<=$Count_CompleteInfo; $i++)
                                                                                {		
                                                                                    $Data_CompleteInfo = sqlsrv_fetch_array($Result_CompleteInfo);
                                                                            ?>                                                                            
                                                                                <tr>
                                                                                    <td style="width: 1vw;"><img src="../img/flag_k.png" style="width: 3vw;"></td>
                                                                                    <input name="kITEM<?php ECHO $i; ?>" value="<?php echo $Data_CompleteInfo['CD_ITEM']; ?>" type="hidden">
                                                                                    <input name="kAS_YN<?php ECHO $i; ?>" value="<?php echo $Data_CompleteInfo['AS_YN']; ?>" type="hidden">
                                                                                    <td><?php echo $Data_CompleteInfo['CD_ITEM']; ?></td>  
                                                                                    <td><?php echo NM_ITEM($Data_CompleteInfo['CD_ITEM']); ?></td> 
                                                                                    <td><?php echo $Data_CompleteInfo['KQT_GOODS']-$Data_CompleteInfo['KREJECT_GOODS']+$Data_CompleteInfo['KREJECT_REWORK']+$Data_CompleteInfo['ERROR_GOODS']-$Data_CompleteInfo['KPRINT_QT']; ?></td>  
                                                                                    <td>
                                                                                        <?php 
                                                                                            if(ItemInfo(Hyphen($Data_CompleteInfo['CD_ITEM']), "LOTSIZE")!='0') {
                                                                                        ?>
                                                                                                <input type="number" name="ksize<?php echo $i?>" value="<?php echo ItemInfo(Hyphen($Data_CompleteInfo['CD_ITEM']), "LOTSIZE")?>" min="1">  
                                                                                        <?php 
                                                                                            }
                                                                                            else {
                                                                                        ?>
                                                                                                <input type="number" name="ksize<?php echo $i?>" value="<?php echo 1?>">
                                                                                        <?php 
                                                                                            }
                                                                                        ?>                                                                                                                                                                          
                                                                                    </td> 
                                                                                    <td><?php echo $Data_CompleteInfo['KREJECT_WAIT']; ?></td>  
                                                                                    <td>
                                                                                        <select name="koption<?php echo $i?>" class="form-control select2" style="width: 100%;">
                                                                                            <option value="one" selected="selected">한장만</option>
                                                                                            <option value="dozen">여러장</option>
                                                                                        </select>
                                                                                    </td> 
                                                                                    <td>
                                                                                        <button type="submit" class="btn btn-info" name="seq" value="k<?php echo $i?>">발행</button>
                                                                                    </td>
                                                                                </tr> 
                                                                            
                                                                            <?php 
                                                                                    if($Data_CompleteInfo == false) {
                                                                                        exit;
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
                                                    <form method="POST" autocomplete="off" action="complete_label.php"> 
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
                                                    <form method="POST" action="complete_label_single.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32">
                                                            <div class="card-body table-responsive p-2">
                                                                <div class="row">
                                                                    <!-- 보드 시작 -->
                                                                    <?php 
                                                                        if($Count_ItemCount>0) {} else {$Count_ItemCount=0;}
                                                                        if($Data_PcsCount['QT_GOODS']>0) {} else {$Data_PcsCount['QT_GOODS']=0;}

                                                                        BOARD(6, "primary", "작업 품목수량", $Count_ItemCount, "fas fa-boxes");
                                                                        BOARD(6, "primary", "작업 개별수량", $Data_PcsCount['QT_GOODS'], "fas fa-box");
                                                                    ?>
                                                                    <!-- 보드 끝 -->
                                                                </div>

                                                                <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>국가</th>
                                                                            <th>품번</th>
                                                                            <th>품명</th>
                                                                            <th>생산일</th>
                                                                            <th>로트날짜</th>
                                                                            <th>로트번호</th>
                                                                            <th>로트사이즈</th>
                                                                            <th>비고</th>
                                                                            <th>재발행</th> 
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            for($i=1; $i<=$Count_LabelPrint; $i++)
                                                                            {		
                                                                                $Data_LabelPrint = sqlsrv_fetch_array($Result_LabelPrint);
                                                                        ?>
                                                                        <tr>
                                                                            <input name="re_no<?php ECHO $i; ?>" value="<?php echo $Data_LabelPrint['NO']; ?>" type="hidden">
                                                                            <td><?php if($Data_LabelPrint['COUNTRY']=='K') {ECHO "한국";} ELSEIF($Data_LabelPrint['COUNTRY']=='V') {ECHO "베트남";} ELSEIF($Data_LabelPrint['COUNTRY']=='C') {ECHO "중국";} ELSE {ECHO "";} ?></td>  
                                                                            <td><?php echo $Data_LabelPrint['CD_ITEM']; ?></td>  
                                                                            <td><?php echo NM_ITEM($Data_LabelPrint['CD_ITEM']); ?></td> 
                                                                            <td><?php echo $Data_LabelPrint['MAKE_DATE']; ?></td> 
                                                                            <td><?php echo $Data_LabelPrint['LOT_DATE']; ?></td>   
                                                                            <td><?php echo $Data_LabelPrint['LOT_NUM']; ?></td>  
                                                                            <td><?php echo $Data_LabelPrint['QT_GOODS']; ?></td> 
                                                                            <td><?php echo $Data_LabelPrint['NOTE']; ?></td> 
                                                                            <td>
                                                                                <button type="submit" class="btn btn-info" name="re_seq" value="<?php echo $i?>">재발행</button>
                                                                            </td> 
                                                                        </tr> 
                                                                        <?php 
                                                                                if($Data_LabelPrint == false) {
                                                                                    exit;
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

                                        <!-- 삭제 및 내역 4번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample40" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample40">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="complete_label.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample40">                                    
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
                                                                                <input type="text" class="form-control" name="item40" autofocus pattern="[a-zA-Z0-9^_()_-]+">
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt40">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="complete_label.php"> 
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
                                                                                <?php 
                                                                                    if($dt4!='') {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt4">
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" name="dt4">
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
                                                            <table class="table table-bordered table-hover text-nowrap" id="table4">
                                                                <thead>
                                                                    <tr>
                                                                        <th>국가</th>
                                                                        <th>품번</th>
                                                                        <th>품명</th>
                                                                        <th>로트날짜</th>
                                                                        <th>로트번호</th>
                                                                        <th>로트사이즈</th>
                                                                        <th>비고</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        for($i=1; $i<=$Count_DeleteSelect; $i++)
                                                                        {		
                                                                            $Data_DeleteSelect = sqlsrv_fetch_array($Result_DeleteSelect);
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php if($Data_DeleteSelect['COUNTRY']=='K') {ECHO "한국";} ELSEIF($Data_DeleteSelect['COUNTRY']=='V') {ECHO "베트남";} ELSEIF($Data_DeleteSelect['COUNTRY']=='C') {ECHO "중국";} ELSE {ECHO "";} ?></td>  
                                                                        <td><?php echo $Data_DeleteSelect['CD_ITEM']; ?></td>  
                                                                        <td><?php echo NM_ITEM($Data_DeleteSelect['CD_ITEM']); ?></td>  
                                                                        <td><?php echo $Data_DeleteSelect['LOT_DATE']; ?></td>   
                                                                        <td><?php echo $Data_DeleteSelect['LOT_NUM']; ?></td>  
                                                                        <td><?php echo $Data_DeleteSelect['QT_GOODS']; ?></td>  
                                                                        <td><?php echo $Data_DeleteSelect['NOTE']; ?></td> 
                                                                    </tr> 
                                                                    <?php 
                                                                            if($Data_DeleteSelect == false) {
                                                                                exit;
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

                                        <!-- 커스텀라벨 5번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="custom-tabs-one-5th" role="tabpanel" aria-labelledby="custom-tabs-one-5th-tab">
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">라벨발행</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" name="pop_form" action="complete_label_force.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample51">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">   
                                                                    <!-- Begin 선택1 -->     
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>선택1</label>
                                                                            <select name="kind51" class="form-control select2" style="width: 100%;">
                                                                                <option value="M" selected="selected">양산</option>
                                                                                <option value="MR">양산 자투리</option>
                                                                                <option value="A">AS</option>
                                                                                <option value="AR">AS 자투리</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 선택1 -->  
                                                                    <!-- Begin 선택2 -->     
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>선택2</label>
                                                                            <select name="country51" class="form-control select2" style="width: 100%;">
                                                                                <option value="K" selected="selected">한국</option>
                                                                                <option value="V">베트남</option>
                                                                                <option value="C">중국</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 선택2 -->                                                                     
                                                                    <!-- Begin 품번 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>품번</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-signature"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="item51" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 품번 -->
                                                                    <!-- Begin 박스내 수량 -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>박스 내 수량</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-box-open"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="number" class="form-control" name="size51" min="1" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 박스내 수량 --> 
                                                                    <!-- Begin 출력 라벨 수량 -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>출력 라벨 수량</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-barcode"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="number" class="form-control" name="label51" min="1" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 출력 라벨 수량 --> 
                                                                    <!-- Begin 비고 -->
                                                                    <div class="col-md-8">
                                                                        <div class="form-group">
                                                                            <label>비고</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-sticky-note"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="note51" value="커스텀라벨">
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt51">발행</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
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
    if(isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>