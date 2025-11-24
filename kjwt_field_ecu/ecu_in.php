<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.09>
	// Description:	<ecu 입고 리뉴얼>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Data Integrity
	// =============================================
    include 'ecu_in_status.php';
    // Helper function to prevent XSS
    function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">ECU 입고</h1>
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
                                            <a class="nav-link" id="custom-tabs-one-1th-tab" href="ecu_inquire.php?tab=in">입고내역</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-2th-tab" href="ecu_inquire.php?tab=reg">등록</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-3th-tab" href="ecu_inquire.php?tab=del">삭제내역</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - ECU 입고 전산화<BR><BR>

                                            [작업순서]<BR>
                                            1. ECU 박스라벨 바코드 스캔<BR>
                                            2. 만약 ECU 박스라벨의 바코드가 없거나 개별로 들어온 경우 수기입력<BR><BR>

                                            [기능]<BR>
                                            - [입력] 입력값 강제 대문자화<BR>
                                            - [입력] 입력값이 없는 경우 경고음 및 '값이 없습니다!' 팝업창 생성<BR>
                                            - [입력] 입력값 중 품번에 하이폰이 없는 경우 자동생성<BR>
                                            - [입력] 입력값 중 품번, 로트날짜, 로트번호 조합이 중복인 경우 경고음 및 '중복되었습니다!' 팝업창 생성<BR>
                                            - [입력] ecu창고/키오스크, 컴퓨터로 입력할 경우 ecu창고로 위치 저장<BR>
                                            - [입력] 자재창고/키오스크, 컴퓨터로 입력할 경우 자재창고로 위치 저장<BR>
                                            - [입력] 그외 컴퓨터로 입력할 경우 아이윈으로 위치 저장<BR>
                                            - [수기입력] 로트사이즈나 박스수량이 0인 경우 입력 불가<BR>
                                            - [수기입력] 직납을 선택하여 입력한 경우 ECU 입고,출고 데이터가 한꺼번에 기록<BR>
                                            - [수기입력] 하이폰 없이 품번을 입력하는 경우 자동으로 하이폰 생성<BR>
                                            - [수기입력] a로 시작하는 로트번호가 자동생성됨<BR>
                                            - [수기입력] ecu창고/키오스크, 컴퓨터로 입력할 경우 ecu창고로 위치 저장<BR>
                                            - [수기입력] 자재창고/키오스크, 컴퓨터로 입력할 경우 자재창고로 위치 저장<BR>
                                            - [수기입력] 그외 컴퓨터로 입력할 경우 아이윈으로 위치 저장<BR>
                                            - [삭제] 품번 입력칸 공백제거<BR>
                                            - [결과] 비고수정<BR>
                                            - [결과] 비고수정 독점화 (수정 중일때 다른사람이 수정불가, 수정 버튼 푸쉬 후 5분동안 저장하지 않을 시 다른사람 수정 가능)<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 동미향 사원<br>                  
                                            - 자재창고: 샘플, 수출용 /  ECU창고: 내수용<br>
                                            - 아이윈오토 박스라벨 바코드 예시: S^20231205^88B70-S9520^07^90<br>
                                            - 수기입력 시 DB저장 예시: handwrite20231214a01<br><br>   

                                            [제작일]<BR>
                                            - 21.11.09
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="ecu_in.php"> 
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
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">수기입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" name="pop_form" action="ecu_in.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse" id="collapseCardExample23">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 구분 -->     
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>내수/수출/직납 구분</label>
                                                                            <select name="kind23" class="form-control select2" style="width: 100%;">
                                                                                <option value="내수" selected="selected">내수</option>
                                                                                <option value="수출">수출</option>
                                                                                <option value="직납">직납</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 구분 --> 
                                                                    <!-- Begin 품번 -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>품번</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-signature"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="item23">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 품번 -->  
                                                                    <!-- Begin 로트날짜 -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>로트날짜</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask name="dt23">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 로트날짜 --> 
                                                                    <!-- Begin 로트사이즈 -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>로트사이즈</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-box-open"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="number" class="form-control" name="size23" value="90" min="1">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 로트사이즈 --> 
                                                                    <!-- Begin 박스수량 -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>박스수량</label>
                                                                            <div class="input-group">               
                                                                                <button type="button" class="btn btn-info" onclick="cal('p', this);">+</button>
                                                                                <input type="number" class="form-control" name="pop_out" value="1" min="1">
                                                                                <button type="button" class="btn btn-info" onclick="cal('m', this);">-</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 박스수량 -->  
                                                                    <!-- Begin 비고 -->
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>비고</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-sticky-note"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="note23">
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt23">입력</button>
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
                                                    <a href="#collapseCardExample2b" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample2b">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">삭제</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="ecu_in.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse" id="collapseCardExample2b">                                    
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
                                                                            <label>품번 (금일 수기입력 해당 품번 모두 삭제)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-signature"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="item2c" pattern="[a-zA-Z0-9^_()_-]+">
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
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="ecu_in.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32">
                                                            <div class="card-body table-responsive p-2">
                                                                <div class="row">
                                                                    <!-- 보드 시작 -->
                                                                    <?php 
                                                                        if (function_exists('BOARD')) {
                                                                            BOARD(6, "primary", "박스수량", $Data_InputQuantity['BOX'] ?? 0, "fas fa-boxes");
                                                                            BOARD(6, "primary", "개별수량", $Data_InputQuantity['PCS'] ?? 0, "fas fa-puzzle-piece");
                                                                        }
                                                                    ?>
                                                                    <!-- 보드 끝 -->
                                                                </div>

                                                                <!-- Begin card-footer --> 
                                                                <?php 
                                                                    if (function_exists('ModifyData2')) {
                                                                        ModifyData2("ecu_in.php?modi=Y", "bt22", "EcuInput");
                                                                    }
                                                                ?>

                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>자동차품번</th>
                                                                                <th>내부품번</th>
                                                                                <th>품명</th>
                                                                                <th>박스수량</th>
                                                                                <th>개별수량</th> 
                                                                                <th>위치</th> 
                                                                                <th>직납여부</th> 
                                                                                <th>비고</th>  
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                $i = 1;
                                                                                foreach ($InputECU_DataArray as $Data_InputECU)
                                                                                {		
                                                                                    // Get item name securely and efficiently
                                                                                    $cd_item_from_db = $Data_InputECU['CD_ITEM'];
                                                                                    $row_out3 = null;

                                                                                    $sql_chk = "SELECT CD_ITEM, NM_ITEM FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND STND_ITEM=? AND CD_ITEM LIKE 'CY020%'";
                                                                                    $result_chk = sqlsrv_query($connect, $sql_chk, [$cd_item_from_db]);
                                                                                    $row_out3 = sqlsrv_fetch_array($result_chk, SQLSRV_FETCH_ASSOC);

                                                                                    if (!$row_out3) {
                                                                                        $sql_chk3 = "SELECT CD_ITEM, NM_ITEM FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND ((STND_ITEM LIKE ? OR STND_ITEM = ?) AND CD_ITEM LIKE 'CY%') OR (STND_DETAIL_ITEM LIKE ? AND CD_ITEM LIKE 'CY%')";
                                                                                        $like_param = '%'.$cd_item_from_db.'%';
                                                                                        $result_chk3 = sqlsrv_query($connect21, $sql_chk3, [$like_param, $cd_item_from_db, $like_param]);
                                                                                        $row_out3 = sqlsrv_fetch_array($result_chk3, SQLSRV_FETCH_ASSOC);
                                                                                    }

                                                                                    if (!$row_out3) {
                                                                                        $sql_out3 = "SELECT CD_ITEM, NM_ITEM FROM NEOE.NEOE.MA_PITEM WHERE CD_PLANT='PL01' AND CD_ITEM=?";
                                                                                        $result_out3 = sqlsrv_query($connect21, $sql_out3, [$cd_item_from_db]);
                                                                                        $row_out3 = sqlsrv_fetch_array($result_out3, SQLSRV_FETCH_ASSOC);
                                                                                    }
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php if($modi=='Y') { echo h($Data_InputECU['CD_ITEM']); ?> <input name='N_CD_ITEM<?php echo $i; ?>' value='<?php echo h($Data_InputECU['CD_ITEM']); ?>' type='hidden'> <?php } else {echo h($Data_InputECU['CD_ITEM']);} ?></td>
                                                                                <td><?php echo h($row_out3['CD_ITEM'] ?? '-'); ?></td> 
                                                                                <td><?php echo h($row_out3['NM_ITEM'] ?? ''); ?></td>                                 
                                                                                <td><?php echo h($Data_InputECU['BOX']); ?></td>
                                                                                <td><?php echo h($Data_InputECU['PCS']); ?></td>
                                                                                <td><?php if($modi=='Y') { echo h($Data_InputECU['LOCATION']); ?> <input name='LOCATION<?php echo $i; ?>' value='<?php echo h($Data_InputECU['LOCATION']); ?>' type='hidden'> <?php } else {echo h($Data_InputECU['LOCATION']);} ?></td>
                                                                                <td><?php if($modi=='Y') { echo h($Data_InputECU['DIRECT_YN']); ?> <input name='DIRECT_YN<?php echo $i; ?>' value='<?php echo h($Data_InputECU['DIRECT_YN']); ?>' type='hidden'> <?php } else {echo h($Data_InputECU['DIRECT_YN']);} ?></td>
                                                                                <td><?php if($modi=='Y') { ?> <input value='<?php echo h($Data_InputECU['NOTE']); ?>' name='NOTE<?php echo $i; ?>' type='text'> <?php } else {echo h($Data_InputECU['NOTE']);} ?></td>
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

                                                            <!-- /.수정을 위해 필요 -->  
                                                            <input type="hidden" name="until" value="<?php echo $i; ?>">
                                                             
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>
                                                </div>
                                                <!-- /.card -->
                                            </div> 
                                        </div>  

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            
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
    //메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
    if(isset($connect21)) { sqlsrv_close($connect21); }
?>