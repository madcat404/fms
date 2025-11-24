<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.08.24>
	// Description:	<finished 입고>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'finished_out_status.php';
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">완성품창고 출하</h1>
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
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">출하</a>
                                        </li>                                        
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">출하내역</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">출하취소</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="custom-tabs-one-2th-tab" data-toggle="pill" href="#custom-tabs-one-2th">출하취소 내역</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab6;?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">오더</a>
                                        </li>  
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 완성품창고 출하 전산회<BR><BR>   

                                            [작업순서]<BR>
                                            1. 부품 식별표에 부착된 박스 라벨 바코드 스캔<BR>
                                            2. 만약 박스 라벨의 바코드가 없거나 개별로 출하해야 할 경우 수기입력<BR><BR>

                                            [기능]<br>
                                            1. 입고탭<br>
                                            - [입력] 입력값 강제 대문자화, 하이폰 제거<BR>
                                            - [입력] 납품 기사 바코드 스캔 시 해당 지입 기사 표시<BR>
                                            - [입력] 입력값 중 품번, 로트날짜, 로트번호 조합이 중복인 경우 경고음 및 '중복되었습니다!','0를 입력하세요!' 팝업창 생성<BR>
                                            - [입력] 자투리인 경우 자투리 Y로 표기<BR>   
                                            - [입력] 5박스 입력마다 '다섯' 음성 발생<BR>
                                            - [수기입력] 입력값 품번 강제 대문자화, 하이폰 제거, 공백 제거<BR>
                                            - [수기입력] 로그인하지 않고 수기입력을 했을 경우 '사용 권한이 없습니다!' 팝업창 생성<BR>
                                            - [수기입력] a로 시작하는 로트번호가 자동 생성됨<BR>
                                            - [수기입력] 납품 기사 코드값 (DELIVERY1~DELIVERY7) 입력 시 해당 지입 기사 표시<BR>
                                            2. 출하취소탭<br>
                                            - [입력] 입력값 강제 대문자화, 하이폰 제거<BR>
                                            - [수기입력] 입력값 품번 강제 대문자화, 하이폰 제거, 공백 제거<BR>
                                            3. 오더탭<br>
                                            - [업로드] 납품 기사 바코드 엑셀파일 다운로드<BR>
                                            - [업로드] 오더 업로드 엑셀 파일 다운로드<BR>
                                            - [업로드] 업로드 엑셀 파일 데이터 출력<BR><br>                                           

                                            [히스토리]<BR>
                                            2023)<BR>
                                            - 엑셀 오더를 업로드할 수 있도록 해달라는 요청이 있었음<BR>
                                            - 출하탭 삭제 카드를 제거해달라는 요청이 있었음<BR>
                                            - 출하탭 수기입력에 제약을 가해 달라는 요청이 있어 로그인 시 수기입력이 가능하도록 함<BR><BR>  
                                            
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 지입 기사, 김진호bj, 물류팀<br>
                                            - 지입기사 코드값:<br>
                                             > DELIVERY1 = 옥해종<br>
                                             > DELIVERY2 = 손규백<br>
                                             > DELIVERY3 = 최기완<br>
                                             > DELIVERY4 = 조근선<br>
                                             > DELIVERY5 = 박정민<br>
                                             > DELIVERY6 = 김영민<br>
                                             > DELIVERY7 = 기타<br><br>
                                            
                                            [제작일]<BR>
                                            - 22.08.24<br><br> 

                                            [FIXME]<br> 
                                            - 오더출력 버튼은 오더 카드로 이동<br> 
                                            - 출하 뷰어 탭 생성<br>
                                            - 오더탭 제일 밑에 가도록 변경(메뉴를 열었을때 업로드 창 밑에 메뉴가 깔림)<br><br>
                                        </div>                                        
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 상단정보 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="row">
                                                    <!-- 보드 시작 -->
                                                    <?php 
                                                        BOARD(4, "success", "지입기사", $DeliveryName, "fas fa-user");
                                                        BOARD(4, "primary", "출하오더(PCS)", $Data_OrderQT2['QT_GOODS'] ?? 0, "fas fa-puzzle-piece");
                                                        BOARD(4, "info", "출하실적(PCS)", $Data_OutputQuantity['PCS'] ?? 0, "fas fa-puzzle-piece");
                                                    ?>
                                                </div>
                                            </div>

                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="finished_out.php"> 
                                                        <input type="hidden" name="tab_sequence" value="2">
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <div class="row">                                                                        
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>라벨스캔</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-qrcode"></i></span></div>
                                                                                <input type="text" class="form-control" name="item2" autofocus pattern="[a-zA-Z0-9^_()_-]+">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                            </div>
                                                        </div>
                                                    </form>     
                                                </div>
                                            </div>  

                                            <!-- 수기입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">수기입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" name="pop_form" action="finished_out.php"> 
                                                        <input type="hidden" name="tab_sequence" value="2">
                                                        <div class="collapse" id="collapseCardExample22">                                    
                                                            <div class="card-body">
                                                                <div class="row">                                                       
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>품번</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-signature"></i></span></div>
                                                                                <input type="text" class="form-control" name="cd_item22" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>수량</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box-open"></i></span></div>
                                                                                <input type="number" class="form-control" name="qt_goods22" min="1" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>비고</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-sticky-note"></i></span></div>
                                                                                <input type="text" class="form-control" name="note22">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt22">입력</button>
                                                            </div>
                                                        </div>
                                                    </form>     
                                                </div>
                                            </div>                                             

                                            <!-- 실적!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">실적</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample23">
                                                        <div class="card-body table-responsive p-2">
                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped" id="table_nosort">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>자동차품번</th>
                                                                            <th>품명</th>       
                                                                            <th>수량</th>
                                                                            <th>지입기사</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            if ($Result_OutputFinished) {
                                                                                while($row = sqlsrv_fetch_array($Result_OutputFinished, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $row['CD_ITEM']; ?></td>
                                                                            <td><?php echo NM_ITEM(Hyphen($row['CD_ITEM'])); ?></td>  
                                                                            <td><?php echo $row['QT_GOODS']; ?></td>    
                                                                            <td><?php echo $row['DELIVERY']; ?></td>                                                                        
                                                                        </tr> 
                                                                        <?php 
                                                                                }
                                                                            }
                                                                        ?>                     
                                                                    </tbody>
                                                                </table>
                                                            </div>                                     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>  

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample52" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample52">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="finished_out.php"> 
                                                        <input type="hidden" name="tab_sequence" value="3">
                                                        <div class="collapse show" id="collapseCardExample52">                                    
                                                            <div class="card-body">
                                                                <div class="row">                                                                        
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt3">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
                                                            </div>
                                                        </div>
                                                    </form>             
                                                </div>
                                            </div>  

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>자동차품번</th>
                                                                        <th>품명</th>
                                                                        <th>생산일</th>
                                                                        <th>로트날짜</th>
                                                                        <th>로트번호</th>
                                                                        <th>개별수량</th> 
                                                                        <th>지입기사</th>
                                                                        <th>출고일</th>
                                                                        <th>비고</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if ($Result_LabelPrint) {
                                                                            while($row = sqlsrv_fetch_array($Result_LabelPrint, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr> 
                                                                        <td><?php echo $row['CD_ITEM']; ?></td>  
                                                                        <td><?php echo NM_ITEM($row['CD_ITEM']); ?></td>  
                                                                        <td><?php echo ($row['MAKE_DATE'] instanceof DateTime) ? $row['MAKE_DATE']->format('Y-m-d') : ($row['MAKE_DATE'] ?? 'N/A'); ?></td>  
                                                                        <td><?php echo $row['LOT_DATE']; ?></td>   
                                                                        <td><?php echo $row['LOT_NUM']; ?></td>  
                                                                        <td><?php echo $row['QT_GOODS']; ?></td> 
                                                                        <td><?php echo $row['DELIVERY']; ?></td> 
                                                                        <td><?php echo ($row['RECORD_DATE'] instanceof DateTime) ? $row['RECORD_DATE']->format('Y-m-d') : 'N/A'; ?></td>  
                                                                        <td><?php echo $row['NOTE']; ?></td> 
                                                                    </tr> 
                                                                    <?php 
                                                                            }
                                                                        }
                                                                    ?>       
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   
                                        </div>  

                                        <!-- 4번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="finished_out.php"> 
                                                        <input type="hidden" name="tab_sequence" value="4">
                                                        <div class="collapse show" id="collapseCardExample41">                                    
                                                            <div class="card-body">
                                                                <div class="row">                                                                        
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>라벨스캔</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-qrcode"></i></span></div>
                                                                                <input type="text" class="form-control" name="item4" autofocus pattern="[a-zA-Z0-9^_()_-]+">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt41">입력</button>
                                                            </div>
                                                        </div>
                                                    </form>     
                                                </div>
                                            </div>       
                                            
                                            <!-- 수기입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">수기입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" name="pop_form" action="finished_out.php"> 
                                                        <input type="hidden" name="tab_sequence" value="4">
                                                        <div class="collapse" id="collapseCardExample42">                                    
                                                            <div class="card-body">
                                                                <div class="row">                                                       
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>품번</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-signature"></i></span></div>
                                                                                <input type="text" class="form-control" name="cd_item42" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>수량</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box-open"></i></span></div>
                                                                                <input type="number" class="form-control" name="qt_goods42" min="1" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>비고</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-sticky-note"></i></span></div>
                                                                                <input type="text" class="form-control" name="note42">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt42">입력</button>
                                                            </div>
                                                        </div>
                                                    </form>     
                                                </div>
                                            </div> 

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample43" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample43">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample43">
                                                        <div class="card-body table-responsive p-2">
                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped" id="table4">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>자동차품번</th>
                                                                            <th>품명</th>
                                                                            <th>수량</th>  
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            if ($Result_OutputFinished2) {
                                                                                while($row = sqlsrv_fetch_array($Result_OutputFinished2, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $row['CD_ITEM']; ?></td>
                                                                            <td><?php echo NM_ITEM(Hyphen($row['CD_ITEM'])); ?></td>  
                                                                            <td><?php echo $row['QT_GOODS']; ?></td>                                                                         
                                                                        </tr> 
                                                                        <?php 
                                                                                }
                                                                            }
                                                                        ?>                     
                                                                    </tbody>
                                                                </table>
                                                            </div>                                     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>

                                        <!-- 5번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="custom-tabs-one-2th" role="tabpanel" aria-labelledby="custom-tabs-one-2th-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="finished_out.php"> 
                                                        <input type="hidden" name="tab_sequence" value="5">
                                                        <div class="collapse show" id="collapseCardExample51">                                    
                                                            <div class="card-body">
                                                                <div class="row">                                                                        
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt5 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt5">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt51">검색</button>
                                                            </div>
                                                        </div>
                                                    </form>             
                                                </div>
                                            </div>  

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample53" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample53">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample53">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table5">
                                                                <thead>
                                                                    <tr>
                                                                        <th>자동차품번</th>
                                                                        <th>품명</th>
                                                                        <th>로트날짜</th>
                                                                        <th>로트번호</th>
                                                                        <th>개별수량</th> 
                                                                        <th>비고</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if ($Result_Return) {
                                                                            while($row = sqlsrv_fetch_array($Result_Return, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr> 
                                                                        <td><?php echo $row['CD_ITEM']; ?></td>  
                                                                        <td><?php echo NM_ITEM($row['CD_ITEM']); ?></td>  
                                                                        <td><?php echo $row['LOT_DATE']; ?></td>   
                                                                        <td><?php echo $row['LOT_NUM']; ?></td>  
                                                                        <td><?php echo $row['QT_GOODS']; ?></td> 
                                                                        <td><?php echo $row['NOTE']; ?></td> 
                                                                    </tr> 
                                                                    <?php 
                                                                            }
                                                                        }
                                                                    ?>       
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>

                                        <!-- 6번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">
                                            <!-- 업로드 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample61" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample61">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">업로드</h6>
                                                    </a>
                                                    <form enctype="multipart/form-data" action="finished_out.php" method="post"> 
                                                        <input type="hidden" name="tab_sequence" value="6">
                                                        <div class="collapse show" id="collapseCardExample61">                                    
                                                            <div class="card-body">
                                                                <div class="row">    
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>파일선택</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="file" name="excelFile">
                                                                                <label class="custom-file-label" for="file">파일선택</label>
                                                                            </div>                                                      
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <a href="../files/delivery_barcode.xlsx" download="delivery_barcode.xlsx" class="btn btn-info">납품기사 바코드 다운로드</a>
                                                                <a href="../files/order.xlsx" download="order.xlsx" class="btn btn-info">업로드 양식 다운로드</a>
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt61">업로드</button>
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt62">오더출력</button>
                                                            </div>
                                                        </div>
                                                    </form>             
                                                </div>
                                            </div>                                              

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample62" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample62">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">오더</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample62">
                                                        <div class="card-body table-responsive p-2">
                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped" id="table1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>자동차품번</th>
                                                                            <th>품명</th>       
                                                                            <th>오더수량</th> 
                                                                            <th>실적수량</th>
                                                                            <th>지입기사</th>
                                                                            <th>고객사</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            if ($Result_OrderQT) {
                                                                                while($row = sqlsrv_fetch_array($Result_OrderQT, SQLSRV_FETCH_ASSOC)) {
                                                                                    $is_mismatch = ($row['QT_ORDER'] != $row['QT_LOG']);
                                                                                    $style = $is_mismatch ? 'style="background-color: orange;"' : '';
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $row['CD_ITEM']; ?></td>
                                                                            <td><?php echo NM_ITEM(Hyphen($row['CD_ITEM'])); ?></td>  
                                                                            <td <?php echo $style; ?>><?php echo $row['QT_ORDER']; ?></td>  
                                                                            <td <?php echo $style; ?>><?php echo $row['QT_LOG']; ?></td>   
                                                                            <td><?php echo $row['DELIVERY']; ?></td>  
                                                                            <td><?php echo $row['CLIENT']; ?></td>                                                                      
                                                                        </tr> 
                                                                        <?php 
                                                                                }
                                                                            }
                                                                        ?>                     
                                                                    </tbody>
                                                                </table>
                                                            </div>                                     
                                                        </div>
                                                    </div>
                                                </div>
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