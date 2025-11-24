<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.26>
	// Description:	<직원차량>
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
    include 'schedule_status.php';
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
        
        <!-- 매뉴 -->
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">방문정보</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 방문자정보 공유<BR><BR>   

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 경비원<br>
                                            - 그룹웨어 방문자 일정 공유<br><br>
                                                                                   
                                            [제작일]<BR>
                                            - 22.05.26<br><br>
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">방문일정</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="schedule.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>방문일</th>
                                                                                <th>종료일</th>   
                                                                                <th>내용</th>
                                                                                <th>담당자</th>
                                                                                <th>내선</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                if ($Result_schedule) {
                                                                                    while($Data_schedule = $Result_schedule->fetch_assoc()) {
                                                                                        $emp_seq = $Data_schedule['create_seq'];
                                                                                        $Data_CheckEMP = null;
                                                                                        $Data_CheckUser = null;

                                                                                        //사원번호로 id 검색
                                                                                        $Query_CheckEMP = "SELECT login_id FROM t_co_emp WHERE emp_seq = ?";
                                                                                        $stmt_emp = $connect3->prepare($Query_CheckEMP);
                                                                                        $stmt_emp->bind_param('s', $emp_seq);
                                                                                        if ($stmt_emp->execute()) {
                                                                                            $Result_CheckEMP = $stmt_emp->get_result();
                                                                                            $Data_CheckEMP = $Result_CheckEMP->fetch_assoc();
                                                                                        }
                                                                                        $stmt_emp->close();

                                                                                        if ($Data_CheckEMP && isset($Data_CheckEMP['login_id'])) {
                                                                                            //사용자 이름
                                                                                            $login_id = $Data_CheckEMP['login_id'];
                                                                                            $Query_CheckUser = "SELECT USER_NM, `CALL` FROM user_info WHERE ENG_NM = ?";
                                                                                            $stmt_user = $connect4->prepare($Query_CheckUser);
                                                                                            $stmt_user->bind_param('s', $login_id);
                                                                                            if ($stmt_user->execute()) {
                                                                                                $Result_CheckUser = $stmt_user->get_result();
                                                                                                $Data_CheckUser = $Result_CheckUser->fetch_assoc();
                                                                                            }
                                                                                            $stmt_user->close();
                                                                                        }
                                                                            ?>                                                                            
                                                                                <tr> 
                                                                                    <td><?php echo htmlspecialchars($Data_schedule['start_date']); ?></td>                                                                                              
                                                                                    <td><?php echo htmlspecialchars($Data_schedule['end_date']); ?></td>  
                                                     <td><?php echo htmlspecialchars($Data_schedule['sch_title']); ?></td> 
                                                                                    <td><?php echo htmlspecialchars($Data_CheckUser['USER_NM'] ?? ''); ?></td> 
                                                                                    <td><?php echo htmlspecialchars($Data_CheckUser['CALL'] ?? ''); ?></td> 
                                                                                </tr>                                                                           
                                                                            <?php 
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
    if(isset($connect3)) { mysqli_close($connect3); }
?>