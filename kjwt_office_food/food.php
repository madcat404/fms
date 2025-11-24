<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.15>
	// Description:	<식수 리뉴얼>	
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
    include 'food_status.php';   
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">식당</h1>
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
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">식단표</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">식수내역</a>
                                        </li>   
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 식단표 공유<BR><BR>   
                                            
                                            [기능]<BR>
                                            - 같은날 파일을 2번 업로드하면 제일 마지막것만 업로드됨<BR>
                                            - 금일에 근접한 다른날 올린 2개의 파일을 표시함<BR>
                                            - 세콤에 지문 또는 사원증을 태그한것을 카운팅하여 식수내역에 표시함<BR>
                                            - 세션보안 즉 로그인을 요구받지 않는 페이지이므로 서버로 파일을 업로드할 때 바이러스, 웜 등과 같은 파일 업로드를 방지하기 위해 패스워드 입력을 요구함 <BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 전직원<br>
                                            - 외부인의 경우 tv 옆 종이에 수기로 적음<br>
                                            - 영양사는 식수내역 데이터를 참조할 뿐이며 실제로 식판 개수와 외부인 기록을 카운팅하여 비용을 계산함<br><br>
                                                                                   
                                            [제작일]<BR>
                                            - 21.11.15<br><br>        
                                        </div>

                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <!-- 업로드 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">업로드</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="food.php" enctype="multipart/form-data"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 파일선택 -->     
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>파일선택</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="file" name="file"> 
                                                                                <label class="custom-file-label" for="file">파일선택</label>
                                                                            </div>                                                      
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 파일선택 -->  
                                                                    <!-- Begin 패스워드 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>패스워드</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-key"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="password" class="form-control" name="upload_code21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 패스워드 -->
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">업로드</button>
                                                            </div>
                                                            <!-- /.card-footer -->    
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>   

                                            <!-- 식단표 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">식단표</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample22">                                    
                                                        <div class="card-body">
                                                            <!-- Begin row -->
                                                            <div class="row">    
                                                                <!-- Begin 식단표 -->     
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <?php 
                                                                            for($i=1; $i<=$Count_Menu; $i++)
                                                                            {		
                                                                                $Data_Menu  = sqlsrv_fetch_array($Result_Menu);                                                                           

                                                                                echo ("<img src='../files/food $Data_Menu[SORTING_DATE]' style='width: 100%; height: 100%'>");

                                                                                if($Data_Menu == false) {
                                                                                    exit;
                                                                                }
                                                                            }	
                                                                        ?>
                                                                                                                             
                                                                    </div>
                                                                </div>
                                                                <!-- end 식단표 -->  
                                                            </div> 
                                                            <!-- /.row -->         
                                                        </div> 
                                                        <!-- /.card-body -->                      
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div> 
                                        </div> 
                                        
                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="food.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 검색범위 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <?php 
                                                                                    if($dt3!='') {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo htmlspecialchars($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt3">
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" name="dt3">
                                                                                <?php 
                                                                                    }
                                                                                ?> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 검색범위 -->                                       
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
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
                                                    <form method="POST" action="complete_label_single.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32">
                                                            <div class="card-body table-responsive p-2">
                                                                <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>날짜</th>
                                                                            <th>출근인원</th>
                                                                            <th>아침</th>
                                                                            <th>점심</th>
                                                                            <th>저녁</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            for($i=1; $i<=$num_result; $i++)
                                                                            {		
                                                                                $row1 = sqlsrv_fetch_array($result); //실행된 쿼리값을 읽음
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $row1['date']; ?></td>
                                                                            <td><?php echo $row1['work_people']; ?></td>
                                                                            <td><?php echo $row1['morning']; ?></td>
                                                                            <td><?php echo $row1['lunch']; ?></td>
                                                                            <td><?php echo $row1['dinner']; ?></td>
                                                                        </tr> 
                                                                        <?php 
                                                                                if($row1 == false) {
                                                                                    exit;
                                                                                }
                                                                            }
                                                                        ?>  
                                                                    </tbody>
                                                                </table>                                     
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
    if (isset($connect4)) {
    mysqli_close($connect4);
}	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>
