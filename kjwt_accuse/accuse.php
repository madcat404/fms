<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.05.24>
	// Description:	<내부고발>	
    // Last Modified: <25.09.11> - Refactored for PHP 8.x, Security, and Stability
	// =============================================
    // CSRF 방어를 위해 세션 시작 및 토큰 생성
    session_start();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrf_token = $_SESSION['csrf_token'];

    include 'accuse_status.php';   

    function renderCard($icon, $title, $boardColor = 'primary') {
        echo "
        <div class='col-xl-3 col-md-6 mb-2'>
            <div class='card border-left-{$boardColor} shadow h-100 py-2'>
                <div class='card-body'>
                    <div class='row no-gutters align-items-center'>
                        <div class='col-auto'>
                            <i class='fas {$icon} fa-2x text-gray-300'></i>
                        </div>
                        <div class='col ml-4'>
                            <div class='h5 mb-0 font-weight-bold text-gray-800'>{$title}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
    
    function renderSection($cards) {
        $cardHtml = implode("", array_map(function ($card) {
            return renderCard($card['icon'], $card['title'], $card['boardColor'] ?? 'primary');
        }, $cards));
    
        //여기에 <div class="card-body">가 들어가니 상단 패딩이 적용되지 않음
        echo "       
            {$cardHtml}
        ";
    }
    
    $reportTypes = [
        ['icon' => 'fa-sack-dollar', 'title' => '금품 등 수수 및 차용', 'boardColor' => 'primary'],
        ['icon' => 'fa-hand-holding-usd', 'title' => '업체특혜, 지분참여', 'boardColor' => 'success'],
        ['icon' => 'fa-comments-dollar', 'title' => '청탁 및 부당한 요구', 'boardColor' => 'info'],
        ['icon' => 'fa-user-ninja', 'title' => '절도, 공금 횡령 및 유용', 'boardColor' => 'warning'],
        ['icon' => 'fa-file-import', 'title' => '사내정보유출', 'boardColor' => 'primary'],
        ['icon' => 'fa-folder-open', 'title' => '문서 조작 및 부정 보고', 'boardColor' => 'success'],
        ['icon' => 'fa-thumbs-down', 'title' => '직권 남용(갑질)', 'boardColor' => 'info'],
        ['icon' => 'fa-swatchbook', 'title' => '기타사례 (윤리규정 위반)', 'boardColor' => 'warning'],
    ];
    
    $procedureSteps = [
        ['icon' => 'fa-phone-volume', 'title' => '1. 제보하기'],
        ['icon' => 'fa-clipboard', 'title' => '2. 접수완료', 'boardColor' => 'success'],
        ['icon' => 'fa-paste', 'title' => '3. 관련부서확인', 'boardColor' => 'info'],
        ['icon' => 'fa-clipboard-check', 'title' => '4. 처리완료', 'boardColor' => 'warning'],
    ];
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
    <style>
        /* 모바일 최적화: 작은 화면에서 글자 크기 조정 */
        @media (max-width: 768px) {
            .h3 {
                font-size: 1.25rem;
            }
            .h5 {
                font-size: 1rem;
            }
            .card-body, .form-control, .input-group-text, .btn {
                font-size: 0.9rem;
            }
            textarea.form-control {
                font-size: 0.85rem;
            }
            .text-sm {
                font-size: 0.8rem;
            }
            .table {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- 메뉴 -->
        <?php include '../nav.php'; ?>

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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;"><img src="../img/logo2.png" style="width: 7vw;">부정비리 제보</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">안내</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">제보하기</a>
                                        </li>                                         
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample11" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample11">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">제보유형</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="accuse.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample11">  
                                                            <div class="card-body"> 
                                                                <div class="row">
                                                                    <?php echo renderSection($reportTypes) ?> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample11" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample11">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">제보절차</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="accuse.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample11">                                    
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <?php echo renderSection($procedureSteps) ?> 
                                                                </div>       
                                                            </div> 
                                                            <!-- /.card-body -->      
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample11" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample11">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">제보자 보호</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="accuse.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample11">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">  
                                                                    <!-- 보드1 -->
                                                                    <div class="col-12 mb-2">
                                                                        <div class="card border-shadow h-100 py-2">
                                                                            <div class="card-body">
                                                                                <div class="row no-gutters align-items-center">
                                                                                    <div class="col ml-4">
                                                                                        <div class="text-sm mb-0 font-weight-bold text-gray-800">*비밀보장: 제보자 동의 없이 제보자의 신분을 공개하거나 암시하는 행위를 금지합니다.</div>
                                                                                        <div class="text-sm mb-0 font-weight-bold text-gray-800">*신분보장: 제보, 진술 및 자료제출 등의 이유로 거래관계 또는 소속부서로부터 불이익이나 차별에 대해 보호합니다.</div>
                                                                                        <div class="text-sm mb-0 font-weight-bold text-gray-800">*책임감면: 제보와 관련하여 제보자의 과실 또는 오류가 발견된 경우 해당 제보자에 대해 징계를 감면할 수 있습니다.</div>
                                                                                    </div>                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                                                                                      
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->      
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample11" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample11">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">담당</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="accuse.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample11">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">  
                                                                    <!-- 보드1 -->
                                                                    <div class="col-12 mb-2">
                                                                        <div class="card border-shadow h-100 py-2">
                                                                            <div class="card-body">
                                                                                <div class="row no-gutters align-items-center">
                                                                                    <div class="col ml-4">
                                                                                        <div class="text-sm mb-0 font-weight-bold text-gray-800">*담당부서: 경영팀</div>
                                                                                        <div class="text-sm mb-0 font-weight-bold text-gray-800">*연락처: 051-790-2013</div>
                                                                                        <div class="text-sm mb-0 font-weight-bold text-gray-800">*이메일: hr@iwin.kr</div>
                                                                                        <div class="text-sm mb-0 font-weight-bold text-gray-800">*주소: 부산광역시 기장군 장안읍 장안산단9로 110 아이윈</div>
                                                                                    </div>                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                                                                                      
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->      
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 
                                        </div>

                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">  
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">제보</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="accuse.php">                                                         
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">    
                                                                <p align='right'><font color='red'>* </font>필수입력사항&nbsp;&nbsp;&nbsp;</p>     
                                                                <hr style='border-width:2px; border-color:black;'>                                                               
                                                                <!-- Begin row -->
                                                                <div class="row">                                               
                                                                    <!-- Begin 사용자 -->
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>이름 (익명가능)<font color='red'> *</font></label>
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
                                                                    <!-- Begin 이메일 -->
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>이메일<font color='red'> *</font></label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-envelope"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="email" class="form-control" name="email21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 이메일 -->
                                                                    <!-- Begin 핸드폰번호 -->
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>핸드폰번호</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-mobile"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="tel" class="form-control" name="phone21">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 핸드폰번호 -->
                                                                    <!-- Begin 내용 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>내용<font color='red'> *</font></label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-sticky-note"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <textarea rows="10" class="form-control" name="note21">1. 제보하려는 내용&#10;ex) 내가 했거나 당한 일임, 내가 직접 보거나 들음, 직장 동료/업체 등에게 들음, 소문으로 알게 된 내용임 등&#10;2. 제보 대상&#10;ex) OO 업체 대표 철수, 영업 과장 영희 등&#10;3. 내용(시기, 장소, 규모)&#10;ex) 24년 2월 경 영희에게 OO 업체 대표 철수가 현금 100만원을 흰 봉투에 넣어 해운대 고급 주점에서 접대 후 건넴&#10;4. 목적&#10;ex) OO 프로젝트 원자재 수주 독점 요청&#10;5. 기타&#10;ex) 이것을 같이 목격한 사람은 OOO 입니다.</textarea>                                                                           
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 내용 --> 
                                                                    <!-- Begin Q&A1 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>제보와 관련된 문제를 잘 아는 사람과 알 것으로 예상되는 사람을 알려주십시오.</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-user-check"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="qna211">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end Q&A1 -->
                                                                    <!-- Begin Q&A2 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>조사하기 위해 좋은 방법으로 생각되는 사항을 알려주십시오.</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-lightbulb"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="qna212">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end Q&A2 -->
                                                                    <!-- Begin table -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>개인정보 수집 동의</label>
                                                                            <div class="table-responsive">
                                                                                <table class="table table-bordered">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th style="text-align: center; background-color: #EAECF4;">수집 및 이용 목적</th>
                                                                                            <th style="text-align: center; background-color: #EAECF4;">수집 및 이용 항목</th>
                                                                                            <th style="text-align: center; background-color: #EAECF4;">보유기간</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody> 
                                                                                        <tr>
                                                                                            <td style="text-align: center;">제보/민원 처리 (실명제보)</td> 
                                                                                            <td style="text-align: center;">[필수] 성명, 이메일 주소, 핸드폰번호 [선택] 생년월일, 전화번호</td> 
                                                                                            <td rowspan="2" style="text-align: center; vertical-align: middle;">제보 접수 후 조사 및 후속조치 종결 시점까지</td>              
                                                                                        </tr>   
                                                                                        <tr>
                                                                                            <td style="text-align: center;">제보/민원 처리 (익명제보)</td> 
                                                                                            <td style="text-align: center;">[필수] 이메일 주소 [선택] 핸드폰번호, 전화번호</td>             
                                                                                        </tr>                                                                                                         
                                                                                    </tbody>
                                                                                </table> 
                                                                            </div>
                                                                            <div class="form-check mt-2">
                                                                                <input class="form-check-input" type="radio" name="radio21" value="1" id="agree_privacy" required>
                                                                                <label class="form-check-label" for="agree_privacy">동의함</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end table -->
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
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
    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>