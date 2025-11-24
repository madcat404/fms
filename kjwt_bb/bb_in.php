<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.08>
	// Description:	<bb 입고>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include_once __DIR__ . '/bb_in_status.php';

    // XSS 방지를 위해 변수 기본값 설정 및 초기화
    $tab2 = $tab2 ?? '';
    $tab3 = $tab3 ?? '';
    $tab2_text = $tab2_text ?? '';
    $tab3_text = $tab3_text ?? '';
    $MODAL_ITEM = $MODAL_ITEM ?? '';
    $dt3 = $dt3 ?? '';
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">B/B창고 입고</h1>
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
                                            <a class="nav-link <?php echo htmlspecialchars($tab2, ENT_QUOTES, 'UTF-8'); ?>" id="tab-two" data-toggle="pill" href="#tab2">입고</a>
                                        </li>                                        
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab3, ENT_QUOTES, 'UTF-8'); ?>" id="tab-three" data-toggle="pill" href="#tab3">입고내역</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭: 공지 --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<br>
                                            - BB입고 전산화<br><br>

                                            [작업순서]<br>
                                            1. 부품식별표 라벨을 스캔<br><br>

                                            [기능]<br>
                                            1. 입고탭<br>
                                            - [입력] 입력값 강제 대문자화<br>
                                            - [입력] 입력값에 V가 포함되지 않은 경우 경고음 및 '부품식별표 바코드가 아닙니다! 확인을 누르세요!' 팝업창 생성<br>
                                            - [입력] 입력값 중 품번, 로트날짜, 로트번호 조합이 중복인 경우 경고음 및 '중복되었습니다! 확인을 누르세요!' 팝업창 생성<br><br>
                                            
                                            [참조]<br>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: BB작업자<br>
                                            - PDA 전용 페이지가 있으며 이 페이지는 키오스크로 입고 또는 내역을 확인하기 위한 페이지임<br>
                                            - 라벨이 미부착되어 들어오는 박스가 있음 (수기입력 개발이 필요함)<br>
                                            - 현경바코드에서 발행되는 라벨이 중복되어 들어오는데 컴퓨터 번호를 지정하도록 개발을 요청함, 그리고 이 프로그램을 베트남에 적용 요청했는데 적용했는지 확인하지 않음<br><br>

                                            [제작일]<br>
                                            - 23.03.08<br><br>
                                        </div>

                                        <!-- 2번째 탭: 입고 --> 
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text, ENT_QUOTES, 'UTF-8'); ?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 라벨 스캔 입력 --> 
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h6 class="m-0 font-weight-bold text-primary">라벨스캔</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="bb_in.php">
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="item21_input" class="sr-only">라벨스캔</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                                        </div>
                                                                        <input type="text" id="item21_input" class="form-control" name="item21" autofocus pattern="[a-zA-Z0-9^_()_-]+" required>
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

                                            <!-- 수기입력 --> 
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-3">
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h6 class="m-0 font-weight-bold text-primary">수기입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" name="pop_form" action="bb_in.php">
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="cd_item22_input">품번</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <a href="bb_in.php?MODAL=on" class="btn btn-info" role="button">검색</a>
                                                                                </div>
                                                                                <input type="text" id="cd_item22_input" class="form-control" value="<?php echo htmlspecialchars($MODAL_ITEM, ENT_QUOTES, 'UTF-8'); ?>" name="cd_item22">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="qt_goods22_input">수량(PCS)</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                                                                                </div>
                                                                                <input type="number" id="qt_goods22_input" class="form-control" name="qt_goods22" min="1" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="note22_input">비고</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="far fa-sticky-note"></i></span>
                                                                                </div>
                                                                                <input type="text" id="note22_input" class="form-control" name="note22">
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

                                            <!-- 삭제 --> 
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample23">
                                                        <h6 class="m-0 font-weight-bold text-primary">삭제</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="bb_in.php">
                                                        <div class="collapse" id="collapseCardExample23">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="item23_input">품번(수기입력 삭제)</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                                                        </div>
                                                                        <input type="text" id="item23_input" class="form-control" name="item23">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt23">입력</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                            <!-- 결과 -->
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                        <h6 class="m-0 font-weight-bold text-primary">금일 입고 현황</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample24">
                                                        <div class="card-body table-responsive p-2">
                                                            <div class="row">
                                                                <?php 
                                                                    BOARD(6, "primary", "합계(BOX)", $Data_InputBB2['COU'] ?? 0, "fas fa-boxes");
                                                                    BOARD(6, "primary", "합계(PCS)", $Data_InputBB2['QT_GOODS'] ?? 0, "fas fa-puzzle-piece");
                                                                ?>
                                                            </div>
                                                            <table class="table table-bordered table-striped" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>품번</th>
                                                                        <th>품명</th>
                                                                        <th>수량</th>   
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($Result_InputBB)) {
                                                                            while($Data_InputBB = sqlsrv_fetch_array($Result_InputBB, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($Data_InputBB['CD_ITEM'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                        <td><?php echo htmlspecialchars(NM_ITEM(Hyphen($Data_InputBB['CD_ITEM'])), ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars($Data_InputBB['QT_GOODS'], ENT_QUOTES, 'UTF-8'); ?></td>
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

                                        <!-- 3번째 탭: 입고내역 -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab3_text, ENT_QUOTES, 'UTF-8'); ?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <!-- 검색 --> 
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="bb_in.php">
                                                        <div class="collapse show" id="collapseCardExample31">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="dt3_input">검색범위</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                        </div>
                                                                        <input type="text" id="dt3_input" class="form-control float-right kjwt-search-date" value="<?php echo htmlspecialchars($dt3, ENT_QUOTES, 'UTF-8'); ?>" name="dt3">
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

                                            <!-- 결과 -->
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h6 class="m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>품번</th>
                                                                        <th>품명</th>
                                                                        <th>로트날짜</th>
                                                                        <th>로트번호</th>
                                                                        <th>개별수량</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($Result_BBIn)) {
                                                                            while ($Data_BBIn = sqlsrv_fetch_array($Result_BBIn, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr> 
                                                                        <td><?php echo htmlspecialchars($Data_BBIn['CD_ITEM'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars(NM_ITEM($Data_BBIn['CD_ITEM']), ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars($Data_BBIn['LOT_DATE'], ENT_QUOTES, 'UTF-8'); ?></td>   
                                                                        <td><?php echo htmlspecialchars($Data_BBIn['LOT_NUM'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars($Data_BBIn['QT_GOODS'], ENT_QUOTES, 'UTF-8'); ?></td>
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

    <!-- Modal for item search -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">품번검색</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" autocomplete="off" action="bb_in.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="modal_item_input" class="col-form-label">품명입력:</label>
                            <input type="text" id="modal_item_input" class="form-control" name="modal_item">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">결과:</label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table_modal">
                                    <thead>
                                        <tr>
                                            <th>품번</th>
                                            <th>품명</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if (isset($r_modal) && $r_modal) {
                                                while($d_modal = sqlsrv_fetch_array($r_modal, SQLSRV_FETCH_ASSOC)) {
                                                    $modal_item_url = urlencode($d_modal['CD_ITEM']);
                                        ?>
                                        <tr style="cursor: pointer;" onclick="location.href='bb_in.php?MODAL_ITEM=<?php echo $modal_item_url; ?>'" onMouseOver="style.backgroundColor='#ffedbf';" onMouseOut="style.backgroundColor='#ffffff';">
                                            <td><?php echo htmlspecialchars($d_modal['CD_ITEM'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($d_modal['NM_ITEM'], ENT_QUOTES, 'UTF-8'); ?></td>
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
                    <div class="modal-footer">
                        <button type="submit" value="on" name="mbt1" class="btn btn-info">검색</button>
                        <a href="bb_in.php" class="btn btn-secondary">닫기</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include_once __DIR__ . '/../plugin_lv1.php'; ?>

    <?php if($modal === 'on'): ?>
    <script>
        $(document).ready(function() {
            $('#exampleModal').modal('show');
        });
    </script>
    <?php endif; ?>
</body>
</html>