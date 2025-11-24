<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.02.24>
	// Description:	<경비실 키 불출 대장>	
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
    include 'key_status.php';
?><!DOCTYPE html>
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">키</h1>
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
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">키불출</a>
                                        </li>                                        
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">키불출 내역</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 키불출 전산화<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 경비원<br><br>

                                            [제작일]<BR>
                                            - 23.02.24<br><br>
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
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="key.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                        
                                                                    <!-- Begin 키명 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>키명</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-key"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="key21" autofocus required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 키명 -->                                        
                                                                    <!-- Begin 소속 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>소속</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-building"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="company21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 소속 --> 
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
                                                                    <!-- Begin 불출자 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>불출자</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-user-edit"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="guard21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 불출자 -->
                                                                    <!-- Begin 사용목적 -->
                                                                    <div class="col-md-8">
                                                                        <div class="form-group">
                                                                            <label>사용목적</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-question"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="purpose21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 사용목적 -->
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div>  

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">미반납</h6>
                                                    </a>  
                                                    <form method="POST" autocomplete="off" action="key.php">                                                  
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body table-responsive p-2">
                                                                <!-- Begin card-footer --> 
                                                                <?php 
                                                                    if (function_exists('ModifyData2')) {
                                                                        ModifyData2("key.php?modi=Y", "bt22", "Key");
                                                                    }
                                                                ?>

                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>순번</th>
                                                                                <th>키명</th>
                                                                                <th>소속</th>
                                                                                <th>사용자</th>
                                                                                <th>불출자</th> 
                                                                                <th>사용목적</th>
                                                                                <th>불출일시</th>   
                                                                                <th>반납 시 체크</th> 
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                $rowIndex = 1;
                                                                                if (isset($Result_NotIn)) {
                                                                                    while($Data_NotIn = sqlsrv_fetch_array($Result_NotIn, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <?php echo htmlspecialchars($Data_NotIn['NO'], ENT_QUOTES, 'UTF-8'); ?>
                                                                                    <?php if($modi === 'Y') { ?>
                                                                                        <input name="NO<?php echo $rowIndex; ?>" value="<?php echo htmlspecialchars($Data_NotIn['NO'], ENT_QUOTES, 'UTF-8'); ?>" type="hidden">
                                                                                    <?php } ?>
                                                                                </td>
                                                                                <td><?php echo htmlspecialchars($Data_NotIn['KEY_NM'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                                <td><?php echo htmlspecialchars($Data_NotIn['COMPANY'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                                <td><?php echo htmlspecialchars($Data_NotIn['NAME'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                                <td><?php echo htmlspecialchars($Data_NotIn['GUARD'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                                <td><?php echo htmlspecialchars($Data_NotIn['PURPOSE'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                <td><?php echo ($Data_NotIn['OUT_TIME'] instanceof DateTime) ? $Data_NotIn['OUT_TIME']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                                <td><input type='checkbox' name='CB<?php echo $rowIndex; ?>' style='zoom: 2;' <?php if($modi !== 'Y') echo 'disabled'; ?>></td>
                                                                            </tr>
                                                                            <?php
                                                                                    $rowIndex++;
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>  
                                                                
                                                                <!-- /.수정을 위해 필요 -->  
                                                                <input type="hidden" name="until" value="<?php echo $rowIndex; ?>">

                                                            </div>
                                                            <!-- /.card-body -->                                                             
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>
                                                </div>
                                                <!-- /.card -->
                                            </div> 
                                        </div>  

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="key.php"> 
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
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo htmlspecialchars($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d'), ENT_QUOTES, 'UTF-8'); ?>" name="dt3">
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
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32">
                                                            <div class="card-body table-responsive p-2">
                                                                <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>순번</th>
                                                                            <th>키명</th>
                                                                            <th>소속</th>
                                                                            <th>사용자</th>
                                                                            <th>불출자</th> 
                                                                            <th>사용목적</th>  
                                                                            <th>불출일시</th> 
                                                                            <th>반납일시</th> 
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            if (isset($Result_InOutPrint)) {
                                                                                while($Data_InOutPrint = sqlsrv_fetch_array($Result_InOutPrint, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo htmlspecialchars($Data_InOutPrint['NO'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($Data_InOutPrint['KEY_NM'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($Data_InOutPrint['COMPANY'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($Data_InOutPrint['NAME'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($Data_InOutPrint['GUARD'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($Data_InOutPrint['PURPOSE'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                            <td><?php echo ($Data_InOutPrint['OUT_TIME'] instanceof DateTime) ? $Data_InOutPrint['OUT_TIME']->format("Y-m-d H:i:s") : ''; ?></td>  
                                                                            <td><?php echo ($Data_InOutPrint['IN_TIME'] instanceof DateTime) ? $Data_InOutPrint['IN_TIME']->format("Y-m-d H:i:s") : ''; ?></td>
                                                                        </tr>
                                                                        <?php 
                                                                                }
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

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>