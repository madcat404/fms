<?php
  // =============================================
  // Author: <KWON SUNG KUN - sealclear@naver.com>	
  // Create date: <22.05.12>
  // Description:	<매뉴얼>
  // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
  // =============================================
  include_once 'video_status.php';
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include_once '../head_lv1.php'; ?>    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">      
        
        <!-- 매뉴 -->
        <?php include_once '../nav.php'; ?>

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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">매뉴얼</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 -->
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab2, ENT_QUOTES, 'UTF-8');?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 메뉴얼 영상화<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 사무직<br><br>

                                            [업데이트]<BR>
                                            - 25.01.21 시큐어코딩 및 코드리팩토링<br><br>

                                            [제작일]<BR>
                                            - 22.05.12<br><br>                                            
                                        </div>
                                        <!-- 2번째 탭 -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text, ENT_QUOTES, 'UTF-8');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h6 class="h6 m-0 font-weight-bold text-primary">매뉴얼 목록</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample21">
                                                        <div class="card-body table-responsive p-2"> 
                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped" id="table1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>종류</th>
                                                                            <th>매뉴얼명</th>
                                                                            <th>태그</th>   
                                                                            <th>영상시청</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php   
                                                                            if (!empty($Data_Manual)) {
                                                                                foreach ($Data_Manual as $Manual) {     
                                                                                    echo "<tr>
                                                                                            <td>" . htmlspecialchars($Manual['KIND'] ?? '', ENT_QUOTES, 'UTF-8') . "</td>
                                                                                            <td>" . htmlspecialchars($Manual['NOTE'] ?? '', ENT_QUOTES, 'UTF-8') . "</td>
                                                                                            <td>" . htmlspecialchars($Manual['TAG'] ?? '', ENT_QUOTES, 'UTF-8') . "</td>
                                                                                            <td><button type='button' class='btn btn-info' onclick='window.open(\"" . htmlspecialchars($Manual['LINK'], ENT_QUOTES, 'UTF-8') . "\")'>시청</button></td>                                                                                            
                                                                                        </tr>";
                                                                                }
                                                                            }
                                                                        ?>                     
                                                                    </tbody>
                                                                </table>
                                                            </div> 
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                                <!-- /.card -->
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

    <!-- Bootstrap core JavaScript-->
    <?php include_once '../plugin_lv1.php'; ?>
</body>
</html>

<?php
    // DB 연결 메모리 회수
    if(isset($connect4) && $connect4) { mysqli_close($connect4); }
    if(isset($connect) && $connect) { sqlsrv_close($connect); }
?>