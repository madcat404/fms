<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.07.18>
	// Description:	<이달의 생일자>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include_once __DIR__ . '/birthday_status.php';
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">생년월일</h1>
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
                                            <a class="nav-link <?php echo htmlspecialchars($tab2 ?? '', ENT_QUOTES, 'UTF-8'); ?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭: 공지 --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<br>
                                            - 직원 생일 알림<br><br>

                                            [기능]<br>
                                            - 매월 1일 당월 생일자 알림 메일 발송 (hr@iwin.kr)<br><br>

                                            [참조]<br>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 경영팀<br><br>

                                            [제작일]<br>
                                            - 24.07.18<br><br>
                                        </div>
                                        <!-- 2번째 탭: 목록 -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text ?? '', ENT_QUOTES, 'UTF-8'); ?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h6 class="m-0 font-weight-bold text-primary">명단</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample21">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-striped" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>이름</th>
                                                                        <th>생년월일</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($Result_birthday) && $Result_birthday) {
                                                                            while ($Data_birthday = sqlsrv_fetch_array($Result_birthday, SQLSRV_FETCH_ASSOC)) {
                                                                                if (!empty($Data_birthday['NM_KOR'])) {
                                                                    ?>
                                                                    <tr> 
                                                                        <td><?php echo htmlspecialchars($Data_birthday['NM_KOR'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                        <td><?php echo htmlspecialchars(substr($Data_birthday['NO_RES'] ?? '', 2, 4), ENT_QUOTES, 'UTF-8'); ?></td>
                                                                    </tr>
                                                                    <?php
                                                                                }
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
</body>
</html>