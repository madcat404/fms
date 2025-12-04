<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.21>
	// Description:	<노트북 대여>	
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include 'computer_status.php'; 

    // USE_YN 값에 따라 상태 정보(텍스트, CSS 클래스)를 반환
    function getComputerStatusInfo($use_yn) {
        if (!empty($use_yn) && $use_yn == 'LI') {
            return ['text' => '사용가능', 'class' => 'text-success font-weight-bold'];
        } else {
            return ['text' => '대여중', 'class' => 'text-danger font-weight-bold'];
        }
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
    <style>
        /* 모바일 최적화: 작은 화면에서 테이블 및 카드 글자 크기 조정 */
        @media (max-width: 768px) {
            .table th, .table td {
                font-size: 0.8rem;
                padding: 0.4rem;
            }
            .d-md-none .card-body p {
                font-size: 0.9rem;
                margin-bottom: 0.5rem !important;
            }
            .d-md-none .card-header h6 {
                font-size: 1rem;
            }
        }
        .mobile-search-input {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 0;
            background-color: #ffffff !important;
            color: #495057;
            border: 1px solid #d1d3e2;
        }
        .mobile-search-input::placeholder {
            color: #858796;
        }
        .mobile-search-btn {
            width: 60px;
            border-radius: 0;
        }
    </style>
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">노트북 대여</h1>
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
                                            <a class="nav-link <?php echo $tab2 ?? '';?>" id="tab-two" data-toggle="pill" href="#tab2">대여/반납</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one"> 
                                            [목표]<BR>
                                            - 노트북 대여 전산화<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 사무직<br>
                                            - 점유하여 사용이 필요한 경우 업무협조전 작성 바람<br><br>

                                            [제작일]<BR>
                                            - 23.03.21<br><br>                                              
                                        </div>

                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab2_text ?? '';?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="row"> 
                                                <!-- 대여 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-4">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">대여</h6>
                                                        </a>
                                                        <form method="POST" autocomplete="off" action="computer.php"> 
                                                            <!-- Card Content - Collapse -->
                                                            <div class="collapse show" id="collapseCardExample21">                                    
                                                                <div class="card-body">
                                                                    <!-- Begin row -->
                                                                    <div class="row">    
                                                                        <!-- Begin 선택 -->     
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>선택</label>
                                                                                <select name="computer21" class="form-control select2" style="width: 100%;">
                                                                                    <option value="" selected="selected">선택</option>
                                                                                    <?php foreach ( $In_computer as $option ) : ?>
                                                                                        <option value="<?php echo htmlspecialchars($option->ASSET_NUM); ?>"><?php echo htmlspecialchars($option->ASSET_NUM); ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end 노트북선택 -->
                                                                        <!-- Begin 사용자 -->
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>사용자</label>
                                                                                <div class="input-group">                                                
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text">
                                                                                        <i class="fas fa-user"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="text" class="form-control" name="user21" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end 사용자 -->
                                                                        <!-- Begin 사유 -->
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>사유</label>
                                                                                <div class="input-group">                                                
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text">
                                                                                        <i class="fas fa-edit"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="text" class="form-control" name="note21" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end 사유 -->
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

                                                <!-- 반납 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->                    
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-4">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">반납</h6>
                                                        </a>
                                                        <form method="POST" autocomplete="off" action="computer.php"> 
                                                            <!-- Card Content - Collapse -->
                                                            <div class="collapse show" id="collapseCardExample22">                                    
                                                                <div class="card-body">
                                                                    <!-- Begin row -->
                                                                    <div class="row">    
                                                                        <!-- Begin 노트북선택 -->     
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label>선택</label>
                                                                                <select name="computer22" class="form-control select2" style="width: 100%;">
                                                                                    <option value="" selected="selected">선택</option>
                                                                                    <?php foreach ( $Out_computer as $option ) : ?>
                                                                                        <option value="<?php echo htmlspecialchars($option->ASSET_NUM); ?>"><?php echo htmlspecialchars($option->ASSET_NUM); ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end 노트북선택 -->   
                                                                        <!-- Begin 특이사항 -->
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label>특이사항</label>
                                                                                <div class="input-group">                                                
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text">
                                                                                        <i class="fas fa-sticky-note"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="text" class="form-control" name="note22">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- end 특이사항 -->
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
                                                            <div class="card-body p-2">
                                                                <?php
                                                                    // DB 데이터를 미리 배열로 준비
                                                                    $computer_statuses = [];
                                                                    if (isset($Computer_data) && is_array($Computer_data)) {
                                                                        foreach($Computer_data as $Data_Computer) {
                                                                            $asset_num = $Data_Computer['ASSET_NUM'] ?? null;
                                                                            if ($asset_num) {
                                                                                $Query_Computer2 = "SELECT TOP 1 * from CONNECT.dbo.ASSET_NOTEBOOK WHERE ASSET_NUM=? ORDER BY NO DESC";
                                                                                $Result_Computer2 = sqlsrv_query($connect, $Query_Computer2, [$asset_num]);
                                                                                $Data_Computer2 = sqlsrv_fetch_array($Result_Computer2, SQLSRV_FETCH_ASSOC) ?: [];
                                                                                $computer_statuses[] = array_merge($Data_Computer, $Data_Computer2);
                                                                            }
                                                                        }
                                                                    }
                                                                ?>

                                                                <!-- Mobile Search -->
                                                                <div class="d-md-none mb-3">
                                                                    <div class="input-group">
                                                                        <input type="text" id="mobile-search-input" class="form-control mobile-search-input" placeholder="결과 내 검색...">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-primary mobile-search-btn" type="button">
                                                                                <i class="fas fa-search"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Desktop Table -->
                                                                <div class="d-none d-md-block">
                                                                    <table class="table table-bordered table-striped" id="table2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>자산번호</th>
                                                                                <th>상태</th>
                                                                                <th>브랜드</th>
                                                                                <th>윈도우</th>
                                                                                <th>오피스</th>
                                                                                <th>사용자</th>
                                                                                <th>대여일</th>
                                                                                <th>반납일</th>
                                                                                <th>대여사유</th>
                                                                                <th>특이사항</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach($computer_statuses as $status_data): ?>
                                                                                <?php $status_info = getComputerStatusInfo($status_data['USE_YN'] ?? null); ?>
                                                                                <tr>
                                                                                    <td><?php echo htmlspecialchars($status_data['ASSET_NUM'] ?? ''); ?></td>
                                                                                    <td class="<?php echo $status_info['class']; ?>"><?php echo $status_info['text']; ?></td>
                                                                                    <td><?php echo htmlspecialchars($status_data['BRAND'] ?? ''); ?></td>
                                                                                    <td><?php echo htmlspecialchars($status_data['WINDOW'] ?? ''); ?></td>
                                                                                    <td><?php echo htmlspecialchars($status_data['OFFICE'] ?? ''); ?></td>
                                                                                    <td><?php echo htmlspecialchars($status_data['IWIN_USER'] ?? ''); ?></td>
                                                                                    <td><?php echo !empty($status_data['RENT_DATE']) ? $status_data['RENT_DATE']->format('Y-m-d') : ''; ?></td>
                                                                                    <td><?php echo !empty($status_data['RETURN_DATE']) ? $status_data['RETURN_DATE']->format('Y-m-d') : ''; ?></td>
                                                                                    <td><?php echo htmlspecialchars($status_data['RENT_REASON'] ?? ''); ?></td>
                                                                                    <td><?php echo htmlspecialchars($status_data['NOTE'] ?? ''); ?></td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <!-- Mobile Card View -->
                                                                <div class="d-md-none" id="mobile-card-container">
                                                                    <?php foreach($computer_statuses as $status_data): ?>
                                                                        <?php $status_info = getComputerStatusInfo($status_data['USE_YN'] ?? null); ?>
                                                                        <div class="card shadow-sm mb-3 mobile-card">
                                                                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                                                <h6 class="m-0 font-weight-bold text-primary"><?php echo htmlspecialchars($status_data['ASSET_NUM'] ?? ''); ?></h6>
                                                                                <span class="<?php echo $status_info['class']; ?>"><?php echo $status_info['text']; ?></span>
                                                                            </div>
                                                                            <div class="card-body p-3">
                                                                                <p class="card-text mb-1 d-flex justify-content-between"><strong>브랜드:</strong> <span><?php echo htmlspecialchars($status_data['BRAND'] ?? 'N/A'); ?></span></p>
                                                                                <p class="card-text mb-1 d-flex justify-content-between"><strong>사용자:</strong> <span><?php echo htmlspecialchars($status_data['IWIN_USER'] ?? 'N/A'); ?></span></p>
                                                                                <p class="card-text mb-1 d-flex justify-content-between"><strong>대여일:</strong> <span><?php echo !empty($status_data['RENT_DATE']) ? $status_data['RENT_DATE']->format('Y-m-d') : 'N/A'; ?></span></p>
                                                                                <?php if(!empty($status_data['RETURN_DATE'])): ?>
                                                                                    <p class="card-text mb-1 d-flex justify-content-between"><strong>반납일:</strong> <span><?php echo $status_data['RETURN_DATE']->format('Y-m-d'); ?></span></p>
                                                                                <?php endif; ?>
                                                                                <hr class="my-2">
                                                                                <p class="card-text text-muted text-xs mb-1"><strong>대여사유:</strong> <?php echo htmlspecialchars($status_data['RENT_REASON'] ?? '없음'); ?></p>
                                                                                <p class="card-text text-muted text-xs mb-0"><strong>특이사항:</strong> <?php echo htmlspecialchars($status_data['NOTE'] ?? '없음'); ?></p>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('mobile-search-input');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const filter = searchInput.value.toUpperCase();
                    const cards = document.querySelectorAll('#mobile-card-container .mobile-card');
                    
                    cards.forEach(function(card) {
                        const text = card.textContent || card.innerText;
                        if (text.toUpperCase().indexOf(filter) > -1) {
                            card.style.display = "";
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>