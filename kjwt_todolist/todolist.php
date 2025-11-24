<?php 
    // Prevent caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.04>
	// Description:	<to do list>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
	// =============================================
    include_once 'todolist_status.php';

    // Helper function for safe HTML output
    function h($s) {
        return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
    }
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">기술지원요청(장애처리현황)</h1>
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
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">기록</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th" role="tab" aria-controls="custom-tabs-one-1th" aria-selected="false">내역</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 기술지원요청 게시판 제작<BR><BR>

                                            [기능]<BR>
                                            - 기술지원요청 입력 시 전산담당자에게 메일 발송<BR>
                                            - 기술지원 처리현황을 Y로 수정 시 요청자에게 메일 발송<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트, 회계사<br>
                                            - 사용자: 전직원<br>
                                            - 내부회계관리제도로 인하여 전산에 요청한 내용을 기록하고 분기별로 보고<br><br>

                                            [제작일]<BR>
                                            - 22.05.04<br><br> 
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
                                                    <form method="POST" autocomplete="off" action="todolist.php" enctype="multipart/form-data"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">   
                                                                    <!-- Begin 요청자 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>요청자</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="requestor21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 요청자 -->  
                                                                    <!-- Begin 종류 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>종류</label>
                                                                            <select name="kind21" class="form-control select2" style="width: 100%;">
                                                                                <option value="ERP" selected="selected">ERP</option>
                                                                                <option value="GW">GW</option>
                                                                                <option value="NAS">NAS</option>                                                                                
                                                                                <option value="FMS">FMS</option>
                                                                                <option value="TMS">TMS</option>
                                                                                <option value="PDM">PDM</option>
                                                                                <option value="WEB">WEB</option>
                                                                                <option value="서버">서버</option>
                                                                                <option value="개발">개발</option>
                                                                                <option value="N/W">N/W</option>
                                                                                <option value="H/W">H/W</option>
                                                                                <option value="S/W">S/W</option>                                                                                
                                                                                <option value="ETC">ETC</option>                                                                                
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 종류 --> 
                                                                    <!-- Begin 종류2 -->     
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>중요도</label>
                                                                            <select name="IMPORTANCE21" class="form-control select2" style="width: 100%;">
                                                                                <option value="하" selected="selected">하</option>
                                                                                <option value="중">중</option>  
                                                                                <option value="상">상</option>                                                                           
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 종류2 -->  
                                                                    <!-- Begin 내용 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>내용</label>
                                                                            <div class="input-group">   
                                                                                <textarea rows="8" class="form-control" name="problem21" required></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 내용 -->  
                                                                    <!-- Begin 해결책 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>해결책</label>
                                                                            <div class="input-group">    
                                                                                <textarea rows="8" class="form-control" name="solution21"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 해결책 -->     
                                                                    <!-- Begin 첨부파일 -->     
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>첨부파일</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="file" name="file"> 
                                                                                <label class="custom-file-label" for="file">파일선택</label>
                                                                            </div>                                                      
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 첨부파일 -->                                 
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
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">처리현황</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="todolist.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body table-responsive p-2">   
                                                                
                                                                <!-- Begin modify --> 
                                                                <?php 
                                                                    ModifyData2("todolist.php?modi=Y", "bt22", "Todolist");
                                                                ?>

                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table_nosort">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>NO</th>
                                                                                <th>요청자</th>
                                                                                <th>종류</th>
                                                                                <th>중요도</th>   
                                                                                <th>내용</th>  
                                                                                <th>답변</th>  
                                                                                <th>요청일</th> 
                                                                                <th>처리현황</th> 
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                for($i=1; $i<=$Count_NotWork; $i++)
                                                                                {		
                                                                                    $Data_NotWork = sqlsrv_fetch_array($Result_NotWork); //실행된 쿼리값을 읽음
                                                                            ?>
                                                                            <tr>
                                                                                <input name='solve_no<?php echo $i; ?>' value='<?php echo $Data_NotWork['NO']; ?>' type='hidden'>   
                                                                                <td><?php echo $Data_NotWork['NO']; ?></td>
                                                                                <td><?php echo $Data_NotWork['REQUESTOR']; ?></td>
                                                                                <td><?php echo $Data_NotWork['KIND']; ?></td>
                                                                                <td><?php echo $Data_NotWork['IMPORTANCE']; ?></td>
                                                                                <td><?php echo $Data_NotWork['PROBLEM']; ?></td>
                                                                                <td><?php if($modi=='Y') { ?> <textarea rows='8' class='form-control' name='SOLUTUIN<?php echo $i; ?>'><?php echo $Data_NotWork['SOLUTUIN']; ?></textarea> <?php } else {echo $Data_NotWork['SOLUTUIN'];} ?></td>
                                                                            
                                                                                <td><?php echo date_format($Data_NotWork['SORTING_DATE'],"Y-m-d"); ?></td>
                                                                                <td>
                                                                                <?php 
                                                                                    if($modi=='Y') { 
                                                                                        if($Data_NotWork['SOLVE']=='N') {
                                                                                ?> 
                                                                                            <select name="SOLVE_STATUS<?php echo $i; ?>" class="form-control select2" style="width: 100%;">
                                                                                                <option value="<?php echo $Data_NotWork['SOLVE']?>" selected="selected"><?php echo $Data_NotWork['SOLVE']?></option>
                                                                                                <option value="N">N</option>
                                                                                                <option value="Y">Y</option>                                                                                                
                                                                                            </select> 
                                                                                <?php 
                                                                                        }
                                                                                        else {
                                                                                ?>
                                                                                            <select name="SOLVE_STATUS<?php echo $i; ?>" class="form-control select2" style="width: 100%;">
                                                                                                <option value="<?php echo $Data_NotWork['SOLVE']?>" selected="selected"><?php echo $Data_NotWork['SOLVE']?></option>
                                                                                                <option value="Y">Y</option>
                                                                                                <option value="N">N</option>
                                                                                            </select>    
                                                                                <?php 
                                                                                        }
                                                                                    } 
                                                                                    else {
                                                                                        echo $Data_NotWork['SOLVE'];
                                                                                    } 
                                                                                ?>
                                                                                </td> 
                                                                            </tr> 
                                                                            <?php 
                                                                                    if($Data_NotWork == false) {
                                                                                        exit;
                                                                                    }
                                                                                }
                                                                            ?>                
                                                                        </tbody>
                                                                    </table>
                                                                </div>  
                                                                
                                                                <!-- /.수정을 위해 필요 -->  
                                                                <input type="hidden" name="until" value="<?php echo $i; ?>">

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
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="todolist.php"> 
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
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt3">
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
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>NO</th>
                                                                        <th>요청자</th>
                                                                        <th>종류</th>
                                                                        <th>중요도</th>   
                                                                        <th>내용</th>  
                                                                        <th>답변</th>  
                                                                        <th>요청일</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        foreach ($Data_WorkHistory as $WorkHistory) 
                                                                        {		
                                                                            echo "<tr>
                                                                                    <td>" . htmlspecialchars($WorkHistory['NO'], ENT_QUOTES, 'UTF-8') . "</td>
                                                                                    <td>" . htmlspecialchars($WorkHistory['REQUESTOR'], ENT_QUOTES, 'UTF-8') . "</td>
                                                                                    <td>" . htmlspecialchars($WorkHistory['KIND'], ENT_QUOTES, 'UTF-8') . "</td>
                                                                                    <td>" . htmlspecialchars($WorkHistory['IMPORTANCE'], ENT_QUOTES, 'UTF-8') . "</td>
                                                                                    <td>" . htmlspecialchars($WorkHistory['PROBLEM'], ENT_QUOTES, 'UTF-8') . "</td>
                                                                                    <td>" . htmlspecialchars($WorkHistory['SOLUTUIN'], ENT_QUOTES, 'UTF-8') . "</td>
                                                                                    <td>" . date_format($WorkHistory['SORTING_DATE'], "Y-m-d") . "</td>
                                                                                </tr>";                                                       
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
    //메모리 회수
    mysqli_close($connect4);	

    //메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>