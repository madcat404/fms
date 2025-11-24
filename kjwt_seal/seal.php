<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.09.12>
	// Description:	<사용인감>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
	// =============================================
    include 'seal_status.php';
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
<?php    
    
    if(isMobile()) {  
            if($flag=='log') {
?>
                        <a href="seal.php" class="btn btn-link mr-3" title="move_inquire">
                            <i class="fa fa-stamp fa-2x"></i>
                        </a> 

        <?php 
            }
            else {
        ?>
                        <a href="seal.php?flag=log" class="btn btn-link mr-3" title="move_inquire">
                            <i class="fa fa-clipboard-list fa-2x"></i>
                        </a> 
        <?php 
            }
        ?>
        
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">사용인감</h1>
                    </div> 

                    <!-- Begin row -->
                    <div class="row"> 
                        <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-12 mb-2">                                     
                            <?php 
                                if($flag=='') {
                            ?>
                                    <form method="POST" autocomplete="off" action="seal.php">   
                                        <!-- Begin row -->
                                        <div class="row">
                                            <!-- Begin 사용인 -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>주민번호 앞자리</label>
                                                    <div class="input-group">                                                
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                            <i class="fas fa-user"></i>
                                                            </span>
                                                        </div>
                                                        <input type="number" class="form-control" name="user11" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end 사용자 --> 
                                            <!-- Begin 내용 -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>내용</label>
                                                    <div class="input-group">                                                
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                            <i class="fas fa-pen-to-square"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control" name="contents11" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end 내용 -->  
                                            <!-- Begin 사용처 -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>사용처</label>
                                                    <div class="input-group">                                                
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                            <i class="fas fa-share-from-square"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control" name="submit11" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end 사용처 -->                                         
                                        </div> 
                                        <!-- /.row --> 

                                        <div class="text-right mt-3">
                                            <button type="submit" value="on" class="btn btn-primary" name="bt11">입력</button>
                                        </div> 
                            <?php 
                                }                               
                                elseif($flag=='log') {
                            ?>
                                <form method="POST" autocomplete="off" action="seal.php?flag=log"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>검색범위</label>
                                            <div class="input-group">                                                
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo htmlspecialchars($dt13 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt13">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <button type="submit" value="on" class="btn btn-primary" name="bt13">검색</button>
                                    </div>
                                </form>  
                                
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table1">
                                        <thead>
                                            <tr>
                                                <th>날짜</th>
                                                <th>소속</th>
                                                <th>이름</th>   
                                                <th>내용</th>
                                                <th>사용처</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                                
                                            <?php 
                                                while($Data_Seal = sqlsrv_fetch_array($Result_Seal, SQLSRV_FETCH_ASSOC))
                                                {		
                                                    $Query_Dept = "SELECT B.NM_DEPT AS NM_DEPT FROM NEOE.NEOE.MA_EMP A JOIN NEOE.NEOE.MA_DEPT B ON A.CD_DEPT=B.CD_DEPT where A.CD_COMPANY='1000' AND A.NM_KOR=?";              
                                                    $params_dept = [$Data_Seal['NAME']];
                                                    $Result_Dept = sqlsrv_query($connect, $Query_Dept, $params_dept);	
                                                    $Data_Dept = sqlsrv_fetch_array($Result_Dept, SQLSRV_FETCH_ASSOC);  
                                            ?>                                                                            
                                                <tr> 
                                                    <td><?php echo htmlspecialchars(date_format($Data_Seal['SORTING_DATE'], "Y-m-d")); ?></td>                                                                          
                                                    <td><?php echo htmlspecialchars($Data_Dept['NM_DEPT'] ?? ''); ?></td>  
                                                    <td><?php echo htmlspecialchars($Data_Seal['NAME']); ?></td> 
                                                    <td><?php echo htmlspecialchars($Data_Seal['CONTENTS']); ?></td> 
                                                    <td><?php echo htmlspecialchars($Data_Seal['WHERE_USE']); ?></td>    
                                                </tr>                                                                           
                                            <?php 
                                                }
                                            ?>                                                                                            
                                        </tbody>
                                    </table>
                                </div>
                            <?php 
                                    }
                            ?>
                            </form>     
                        </div>   

                        <!-- end !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                    
                    </div>
                    <!-- /.row -->
<?php    
    }
    else {  
?>
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">사용인감</h1>
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
                                            <a class="nav-link <?php echo htmlspecialchars($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">

                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">     
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="seal.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">                                    
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
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo htmlspecialchars($dt22 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt22">
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt22">검색</button>
                                                            </div>
                                                            <!-- /.card-footer -->  
                                                        </div>
                                                    </form> 
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                                        
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">목록</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="seal.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>날짜</th>
                                                                                <th>소속</th>
                                                                                <th>이름</th>   
                                                                                <th>내용</th>
                                                                                <th>사용처</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                while($Data_Seal = sqlsrv_fetch_array($Result_Seal22, SQLSRV_FETCH_ASSOC))
                                                                                {		
                                                                                    $Query_Dept = "SELECT B.NM_DEPT AS NM_DEPT FROM NEOE.NEOE.MA_EMP A JOIN NEOE.NEOE.MA_DEPT B ON A.CD_DEPT=B.CD_DEPT where A.CD_COMPANY='1000' AND A.NM_KOR=?";
                                                                                    $params_dept = [$Data_Seal['NAME']];
                                                                                    $Result_Dept = sqlsrv_query($connect, $Query_Dept, $params_dept);	
                                                                                    $Data_Dept = sqlsrv_fetch_array($Result_Dept, SQLSRV_FETCH_ASSOC);  
                                                                            ?>                                                                            
                                                                                <tr> 
                                                                                    <td><?php echo htmlspecialchars(date_format($Data_Seal['SORTING_DATE'], "Y-m-d")); ?></td>                                                                          
                                                                                    <td><?php echo htmlspecialchars($Data_Dept['NM_DEPT'] ?? ''); ?></td>  
                                                                                    <td><?php echo htmlspecialchars($Data_Seal['NAME']); ?></td> 
                                                                                    <td><?php echo htmlspecialchars($Data_Seal['CONTENTS']); ?></td> 
                                                                                    <td><?php echo htmlspecialchars($Data_Seal['WHERE_USE']); ?></td>    
                                                </tr>                                                                           
                                                                            <?php 
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
<?php    
    } 
?>              
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
?>