<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.02.17>
	// Description:	<bb창고 출고>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include_once __DIR__ . '/bb_out_status.php';

    // XSS 방지를 위해 변수 기본값 설정 및 초기화
    $tab2 = $tab2 ?? '';
    $tab3 = $tab3 ?? '';
    $tab2_text = $tab2_text ?? '';
    $tab3_text = $tab3_text ?? '';
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include_once __DIR__ . '/../head_lv1.php'; ?>   
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">      
        
        <!-- 메뉴 -->
        <?php include_once __DIR__ . '/../nav.php'; ?>

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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">B/B</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 -->
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab2, ENT_QUOTES, 'UTF-8'); ?>" id="tab-two" data-toggle="pill" href="#tab2">출고</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab3, ENT_QUOTES, 'UTF-8'); ?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">출고내역</a>
                                        </li>     
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭: 공지 --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<br>
                                            - BB출고 전산화<br><br>

                                            [작업순서]<br>
                                            1. 제품을 출고<br>
                                            2. 출고탭에서 수정버튼 선택<br>
                                            3. 출고한 제품의 출고수량을 입력 후 저장버튼 선택<br>
                                            4. 제품을 수령받은 검수반에서 수정버튼 선택하고 본인 바코드 스캔 후 저장버튼 선택<br><br>

                                            [기능]<br>
                                            1. 출고탭<br>
                                            - [입력] 입력값 강제 대문자화<br>
                                            - [입력] 입력값 중 품번에 하이폰이 없는 경우 자동생성<br>
                                            - [입력] 입력값이 금일 출고할 품번인 경우 수량변경 가능한 팝업창 생성<br>
                                            - [입력] 입력값이 금일 출고할 품번이 아닌 경우 '출고요청된 품번이 아닙니다!' 팝업창 생성<br>
                                            - [결과] ERP출고요청등록 메뉴에서 요청일이 오늘인 데이터가 출력됨<br>
                                            - [결과] 요청수량과 출고수량이 상이한 경우 출고수량에 주황색 음영으로 표시<br>
                                            - [결과] 출고수량과 비고 수정<br>
                                            - [결과] 비고수정 독점화 (수정 중일때 다른사람이 수정불가, 수정 버튼 푸쉬 후 5분동안 저장하지 않을 시 다른사람 수정 가능)<br>
                                            2. 출고내역탭<br>
                                            - [검색] 검수반 바코드 파일 다운로드<br>
                                            - [검색] ERP에 바로 업로드할 수 있는 엑셀 파일 다운로드(ERP S/L간 이동처리 메뉴 엑셀 업로드 가능)<br><br>
                                                                                    
                                            [히스토리]<br>      
                                            2022년)<br> 
                                            - 최초에 부품식별표 바코드를 스캔하여 출고했으나 중복이 발생하여 않아 반수동 형태로 변경하였음<br><br> 
                                              
                                            [참조]<br>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: BB작업자<br>
                                            - ERP 출고요청 데이터를 자동으로 가져옴<br>
                                            - MM_GIREQL 테이블에서 트리거나 데이터 받아옴<br>
                                            <br>
                                            
                                            [제작일]<br>
                                            - 22.02.17<br><br>
                                        </div>

                                        <!-- 2번째 탭: 출고 -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text, ENT_QUOTES, 'UTF-8'); ?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <!-- 입력 --> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h6 class="m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="bb_out.php"> 
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="item2_input">라벨스캔</label>
                                                                            <div class="input-group">  
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                                                </div>
                                                                                <input type="text" id="item2_input" class="form-control" name="item2" pattern="[a-zA-Z0-9^[)>. _-]+" aria-labelledby="collapseCardExample21" autofocus>
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

                                            <!-- 결과 -->
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h6 class="m-0 font-weight-bold text-primary">출고요청</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="bb_out.php"> 
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div class="row">
                                                                    <!-- 보드 시작 -->
                                                                    <?php 
                                                                        BOARD(6, "primary", "목표수량", htmlspecialchars($Data_BBToTAL['QT'] ?? 0, ENT_QUOTES, 'UTF-8'), "fas fa-flag-checkered");
                                                                        BOARD(6, "primary", "출고수량", htmlspecialchars($Data_BBToTAL['CO'] ?? 0, ENT_QUOTES, 'UTF-8'), "fas fa-sign-out-alt");
                                                                    ?>
                                                                    <!-- 보드 끝 -->
                                                                </div>    

                                                                <!-- 수정/저장 버튼 --> 
                                                                <?php ModifyData2("bb_out.php?modi=Y", "bt22", "BBOut"); ?>

                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table_spread">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>오더번호</th>
                                                                                <th>입고창고</th>
                                                                                <th>품번</th>
                                                                                <th>품명</th>   
                                                                                <th>요청수량</th> 
                                                                                <th>출고수량</th> 
                                                                                <th>비고</th> 
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                $i = 0;
                                                                                if (isset($Result_RequestOutput)) {
                                                                                    while ($Data_RequestOutput = sqlsrv_fetch_array($Result_RequestOutput, SQLSRV_FETCH_ASSOC)) {
                                                                                        $i++;
                                                                                        $is_modify_mode = ($modi === 'Y');
                                                                                        $is_different = ($Data_RequestOutput['COMPLETE'] != '0' && $Data_RequestOutput['QT_GOODS'] != $Data_RequestOutput['COMPLETE']);
                                                                            ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <?php echo htmlspecialchars($Data_RequestOutput['ORDER_NO'], ENT_QUOTES, 'UTF-8'); ?>
                                                                                    <?php if ($is_modify_mode): ?>
                                                                                        <input name="ORDER_NO<?php echo $i; ?>" value="<?php echo htmlspecialchars($Data_RequestOutput['ORDER_NO'], ENT_QUOTES, 'UTF-8'); ?>" type="hidden">
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td><?php echo htmlspecialchars($Data_RequestOutput['INPUT_LOCATION'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                <td>
                                                                                    <?php echo htmlspecialchars($Data_RequestOutput['CD_ITEM'], ENT_QUOTES, 'UTF-8'); ?>
                                                                                    <?php if ($is_modify_mode): ?>
                                                                                        <input name="CD_ITEM<?php echo $i; ?>" value="<?php echo htmlspecialchars($Data_RequestOutput['CD_ITEM'], ENT_QUOTES, 'UTF-8'); ?>" type="hidden">
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td><?php echo htmlspecialchars(NM_ITEM($Data_RequestOutput['CD_ITEM']), ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                <td><?php echo htmlspecialchars($Data_RequestOutput['QT_GOODS'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                <td <?php if ($is_different) echo 'style="background-color: orange;"'?>>
                                                                                    <?php if ($is_modify_mode): ?>
                                                                                        <div class="input-group">                                                                                          
                                                                                            <button type="button" class="btn btn-info" onclick="cal('m', this);">-</button>
                                                                                            <input type="text" class="form-control" name="pop_out2<?php echo $i; ?>" value="<?php echo htmlspecialchars($Data_RequestOutput['COMPLETE'], ENT_QUOTES, 'UTF-8'); ?>">
                                                                                            <button type="button" class="btn btn-info" onclick="cal('p', this);">+</button> 
                                                                                        </div>
                                                                                    <?php else: ?>
                                                                                        <?php echo htmlspecialchars($Data_RequestOutput['COMPLETE'], ENT_QUOTES, 'UTF-8'); ?>
                                                                                    <?php endif; ?>
                                                                                </td>   
                                                                                <td>
                                                                                    <?php if ($is_modify_mode): ?>
                                                                                        <input value="<?php echo htmlspecialchars($Data_RequestOutput['NOTE'], ENT_QUOTES, 'UTF-8'); ?>" name="NOTE<?php echo $i; ?>" type="text" class="form-control">
                                                                                    <?php else: ?>
                                                                                        <?php echo htmlspecialchars($Data_RequestOutput['NOTE'], ENT_QUOTES, 'UTF-8'); ?>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php 
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div> 
                                                                
                                                                <input type="hidden" name="until" value="<?php echo $i + 1; ?>">

                                                            </div>
                                                        </div>
                                                    </form> 

                                                    <!-- Modal --> 
                                                    <?php if ($modal === 'on' && isset($Data_Quantity)): ?>
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">수량 변경</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST" autocomplete="off" action="bb_out.php">
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">선택:</label><br>
                                                                            - 품번: <?php echo htmlspecialchars($modal_Delivery_ItemCode, ENT_QUOTES, 'UTF-8'); ?><br>
                                                                            - 품명: <?php echo htmlspecialchars(NM_ITEM($modal_Delivery_ItemCode), ENT_QUOTES, 'UTF-8'); ?><br>
                                                                            - 요청수량: <?php echo htmlspecialchars($Data_Quantity["QT_GOODS"] ?? 0, ENT_QUOTES, 'UTF-8'); ?><br>
                                                                            - 현재수량: <?php echo htmlspecialchars($Data_Quantity["COMPLETE"] ?? 0, ENT_QUOTES, 'UTF-8'); ?>
                                                                        </div> 
                                                                        <div class="form-group">
                                                                            <label for="pop_out3_input" class="col-form-label">추가할 수량:</label>
                                                                            <div class="input-group">                                                                                          
                                                                                <button type="button" class="btn btn-info" onclick="cal('m', this);">-</button>
                                                                                <input type="text" id="pop_out3_input" class="form-control" name="pop_out3" value="0">
                                                                                <button type="button" class="btn btn-info" onclick="cal('p', this);">+</button> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="modal_ItemCode" value="<?php echo htmlspecialchars($modal_Delivery_ItemCode, ENT_QUOTES, 'UTF-8'); ?>">
                                                                        <input type="hidden" name="modal_quantiy" value="<?php echo htmlspecialchars($Data_Quantity['COMPLETE'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>">
                                                                        <button type="submit" value="on" name="mbt1" class="btn btn-info">저장</button>
                                                                        <a href="bb_out.php" class="btn btn-secondary">닫기</a>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>                                            
                                        </div>  

                                        <!-- 3번째 탭: 출고내역 -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab3_text, ENT_QUOTES, 'UTF-8'); ?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <!-- 검색 --> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="bb_out.php"> 
                                                        <div class="collapse show" id="collapseCardExample31">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="dt3_input">검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                                </div>
                                                                                <input type="text" id="dt3_input" class="form-control float-right kjwt-search-date" name="dt3" value="<?php echo htmlspecialchars($dt3 ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <a href="../files/inspect_barcode.xlsx" download="inspect_barcode.xlsx" class="btn btn-info">검수반 바코드 다운로드</a>
                                                                <button type="submit" value="on" class="btn btn-info" name="bt32">ERP 엑셀 다운로드</button>
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
                                                            </div>
                                                        </div>
                                                    </form>             
                                                </div>
                                            </div>  

                                            <!-- 결과 -->
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h6 class="m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <div class="row">
                                                                <!-- 보드 시작 -->
                                                                <?php 
                                                                    BOARD(6, "primary", "출고품목개수", htmlspecialchars($Count_ItemCount ?? 0, ENT_QUOTES, 'UTF-8'), "fas fa-boxes");
                                                                    BOARD(6, "primary", "출고수량", htmlspecialchars($Data_PcsCount['CO'] ?? 0, ENT_QUOTES, 'UTF-8'), "fas fa-box");
                                                                ?>
                                                                <!-- 보드 끝 -->
                                                            </div>
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>오더번호</th>
                                                                        <th>품번</th>
                                                                        <th>품명</th>   
                                                                        <th>요청수량</th> 
                                                                        <th>출고수량</th> 
                                                                        <th>비고</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($Result_BBInquire)) {
                                                                            while ($Data_BBInquire = sqlsrv_fetch_array($Result_BBInquire, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($Data_BBInquire['ORDER_NO'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars($Data_BBInquire['CD_ITEM'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars(NM_ITEM($Data_BBInquire['CD_ITEM']), ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars($Data_BBInquire['QT_GOODS'], ENT_QUOTES, 'UTF-8'); ?></td>   
                                                                        <td><?php echo htmlspecialchars($Data_BBInquire['COMPLETE'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars($Data_BBInquire['NOTE'], ENT_QUOTES, 'UTF-8'); ?></td>  
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
                </div>
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <?php include_once __DIR__ . '/../plugin_lv1.php'; ?>
    
    <?php if ($modal === 'on'): ?>      
        <script>
            // Modal을 표시하기 위해 jQuery 사용
            $(document).ready(function() {
                $('#exampleModal').modal('show');
            });
        </script>
    <?php endif; ?>
</body>
</html>