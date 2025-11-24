<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.21>
	// Description:	<노트북 대여>	
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include 'computer_status.php'; 
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
                                <div class="card-body">
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
                                                                    <div class="col-md-4">
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
                                                                    <div class="col-md-4">
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
                                                                    <div class="col-md-4">
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
                                                                    <div class="col-md-6">
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
                                                                    <div class="col-md-6">
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
                                                        <div class="card-body table-responsive p-2">
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
                                                                    <?php 
                                                                        foreach($Computer_data as $Data_Computer)
                                                                        {
                                                                            $Query_Computer2= "SELECT TOP 1 * from CONNECT.dbo.ASSET_NOTEBOOK WHERE ASSET_NUM=? ORDER BY NO DESC";
                                                                            $Result_Computer2 = sqlsrv_query($connect, $Query_Computer2, [$Data_Computer['ASSET_NUM']]);
                                                                            $Data_Computer2 = sqlsrv_fetch_array($Result_Computer2, SQLSRV_FETCH_ASSOC); 
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo !empty($Data_Computer['ASSET_NUM']) ? htmlspecialchars($Data_Computer['ASSET_NUM']) : ''; ?></td>
                                                                        <td><?php IF(!empty($Data_Computer['USE_YN']) && $Data_Computer['USE_YN']=='LI') {ECHO "사용가능";} ELSE {ECHO "대여중";} ?></td>
                                                                        <td><?php echo !empty($Data_Computer['BRAND']) ? htmlspecialchars($Data_Computer['BRAND']) : ''; ?></td>
                                                                        <td><?php echo !empty($Data_Computer['WINDOW']) ? htmlspecialchars($Data_Computer['WINDOW']) : ''; ?></td>
                                                                        <td><?php echo !empty($Data_Computer['OFFICE']) ? htmlspecialchars($Data_Computer['OFFICE']) : ''; ?></td>
                                                                        <td><?php echo !empty($Data_Computer2['IWIN_USER']) ? htmlspecialchars($Data_Computer2['IWIN_USER']) : ''; ?></td>
                                                                        <td><?php echo !empty($Data_Computer2['RENT_DATE']) ? $Data_Computer2['RENT_DATE']->format('Y-m-d') : ''; ?></td>   
                                                                        <td><?php echo !empty($Data_Computer2['RETURN_DATE']) ? $Data_Computer2['RETURN_DATE']->format('Y-m-d') : ''; ?></td>  
                                                                        <td><?php echo !empty($Data_Computer2['RENT_REASON']) ? htmlspecialchars($Data_Computer2['RENT_REASON']) : ''; ?></td>
                                                                        <td><?php echo !empty($Data_Computer2['NOTE']) ? htmlspecialchars($Data_Computer2['NOTE']) : ''; ?></td>                                                                                                       
                                                                    </tr> 
                                                                    <?php 
                                                                        }
                                                                    ?>                     
                                                                </tbody>
                                                            </table>                                     
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
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>