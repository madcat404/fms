<?php 
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>	
    // Create date: <23.11.6>
    // Description:	<esg 이산화탄소 배출량 메인 페이지>	
    // Updated:     <모듈화 리팩토링>
    // =============================================
    
    // 데이터 처리 로직 포함 (기존 파일 유지)
    require_once __DIR__ .'/../session/session_check.php';
    include 'esg_status.php';   
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>    
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">ESG</h1>
                    </div>               

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4;?>" id="tab-four" data-toggle="pill" href="#tab4">ESG</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="tab-five" data-toggle="pill" href="#tab5">ESG진단</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab6;?>" id="tab-six" data-toggle="pill" href="#tab6">ESG DATA 관리</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">온실가스 배출량</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-there" data-toggle="pill" href="#tab3">폐기물</a>
                                        </li>                                          
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            <?php include 'esg_module/tab_notice.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="tab4" role="tabpanel" aria-labelledby="tab-four">
                                            <?php include 'esg_module/tab_intro.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="tab5" role="tabpanel" aria-labelledby="tab-five">
                                            <?php include 'esg_module/tab_diagnosis.php'; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="tab6" role="tabpanel" aria-labelledby="tab-six">
                                            <?php include 'esg_module/tab_data.php'; ?>
                                        </div>     

                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">  
                                            <?php include 'esg_module/tab_ghg.php'; ?>
                                        </div> 

                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <?php include 'esg_module/tab_waste.php'; ?> 
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
    <?php include '../plugin_lv1.php'; ?>

    <?php include 'esg_module/esg_charts.php'; ?>

</body>
</html>

<?php 
    // DB 연결 종료 처리
    if (isset($connect4)) { mysqli_close($connect4);} 	
    if (isset($connect)) { sqlsrv_close($connect); }
?>