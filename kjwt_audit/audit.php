<?php
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.06.10>
	// Description:	<감사>
    // Last Modified: <25.09.18> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include 'audit_status.php';
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <meta http-equiv="Cache-Control" content="max-age=31536000"/>
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">내부회계관리제도</h1>
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
                                            <a class="nav-link <?=$tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">ERP 권한부여(입사)</a>
                                        </li>                
                                        <li class="nav-item">
                                            <a class="nav-link <?=$tab5;?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">ERP 권한회수(퇴사)</a>
                                        </li>                                                                   
                                        <li class="nav-item">
                                            <a class="nav-link <?=$tab3;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">ERP 회계계정상태</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?=$tab4;?>" id="custom-tabs-one-2th-tab" data-toggle="pill" href="#custom-tabs-one-2th">ERP 메뉴별 권한보유자</a>
                                        </li>   
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - ERP 권한정보 공유<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 회계사(내부회계관리제도 컨설팅)<br>
                                            - 사용자: 회계사<br>
                                            - ERP 프로그램에서 볼 수 없는 권한정보를 가시화함<br>
                                            - ERP 모든 사용자에 대한 권한 출력은 과부하가 걸려 어려움(경영팀에 개별 요청할 것)<br><br>

                                            [제작일]<BR>
                                            - 22.06.10<br><br> 
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?=$tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two"> 
                                            <P>※ERP 사원등록 메뉴에서 경영팀이 데이터 입력을 한 상태</P>
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="gate.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 선택 -->     
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>선택</label>
                                                                            <select name="inout22" class="form-control select2" style="width: 100%;">
                                                                                <option value="OUT" selected="selected">출문</option>
                                                                                <option value="IN">입문</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 선택 -->                                                                      
                                                                    <!-- Begin 이름 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>이름</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="name22" autofocus>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 이름 -->                                        
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt22">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
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
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">ERP 권한부여(입사)</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="audit.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>이름</th>
                                                                                <th>권한부여 일시</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                if (isset($Result_Grant)) {
                                                                                    while($Data_Grant = sqlsrv_fetch_array($Result_Grant, SQLSRV_FETCH_ASSOC))
                                                                                    {                                                              
                                                                            ?>                                                                            
                                                                                <tr> 
                                                                                    <td><?= htmlspecialchars(trim($Data_Grant['NM_KOR'] ?? '')) ?></td>        
                                                                                    <td><?= htmlspecialchars($Data_Grant['DTS_INSERT'] ? date('Y-m-d H:m:s', strtotime($Data_Grant['DTS_INSERT'])) : '') ?></td> 
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
                                                            
                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">조회</button>
                                                            </div>
                                                            <!-- /.card-footer -->  
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form> 
                                                </div>
                                                <!-- /.card -->
                                            </div>                                          
                                        </div>  

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?=$tab3_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">           
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h6 class="m-0 font-weight-bold text-primary">ERP 회계 계정등록/변경 상태</h6>                                                        
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="audit.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">
                                                            <div class="card-body table-responsive p-2">                                                                 
                                                                <div class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table3">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>상위계정명</th> 
                                                                                <th>계정명</th>  
                                                                                <th>생성자</th>
                                                                                <th>생성일시</th>
                                                                                <th>변경자</th>
                                                                                <th>변경일시</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                if (isset($Result_Grant2)) {
                                                                                    while($Data_Grant2 = sqlsrv_fetch_array($Result_Grant2, SQLSRV_FETCH_ASSOC))
                                                                                    {                                                                                    
                                                                            ?>                                                                            
                                                                                <tr> 
                                                                                    <td><?= htmlspecialchars($Data_Grant2['NM_ACGRP'] ?? '') ?></td>  
                                                                                    <td><?= htmlspecialchars($Data_Grant2['NM_ACCT'] ?? '') ?></td>     
                                                                                    <td><?= htmlspecialchars($Data_Grant2['ID_INSERT'] ?? '') ?></td> 
                                                                                    <td><?= htmlspecialchars($Data_Grant2['DTS_INSERT'] ?? '') ?></td>  
                                                                                    <td><?= htmlspecialchars($Data_Grant2['ID_UPDATE'] ?? '') ?></td> 
                                                                                    <td><?= htmlspecialchars($Data_Grant2['DTS_UPDATE'] ?? '') ?></td>   
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

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">조회</button>
                                                            </div>
                                                            <!-- /.card-footer -->  
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form> 
                                                </div>
                                                <!-- /.card -->
                                            </div>                                          
                                        </div> 

                                        <!-- 4번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?=$tab4_text;?>" id="custom-tabs-one-2th" role="tabpanel" aria-labelledby="custom-tabs-one-2th-tab">    
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                        <h6 class="m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="audit.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample41">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 메뉴명 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>메뉴명</label>
                                                                            <div class="input-group">  
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-qrcode"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="menu41" autofocus>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 사용자 -->                                        
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt41">입력</button>
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
                                                    <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                        <h6 class="m-0 font-weight-bold text-primary">ERP 메뉴별 권한보유자</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample42">
                                                        <div class="card-body table-responsive p-2"> 
                                                            <div class="table-editable">
                                                                <table class="table table-bordered table-striped" id="table4">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>그룹</th>
                                                                            <th>사용자</th>
                                                                            <th>소속</th> 
                                                                            <th>모듈명</th>
                                                                            <th>메뉴명</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            if (isset($Result_Grant3)) {
                                                                                while($Data_Grant3 = sqlsrv_fetch_array($Result_Grant3, SQLSRV_FETCH_ASSOC))
                                                                                {                                                                                    
                                                                        ?>                                                                            
                                                                            <tr>                                                                                 
                                                                                <td><?= htmlspecialchars($Data_Grant3['ID_GROUP'] ?? '') ?></td> 
                                                                                <td><?= htmlspecialchars($Data_Grant3['ID_USER'] ?? '') ?></td> 
                                                                                <td><?= htmlspecialchars($Data_Grant3['NM_DEPT'] ?? '') ?></td> 
                                                                                <td><?= htmlspecialchars($Data_Grant3['NM_MODULE'] ?? '') ?></td> 
                                                                                <td><?= htmlspecialchars($Data_Grant3['NM_MENU'] ?? '') ?></td>    
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
                                                </div>
                                                <!-- /.card -->
                                            </div>   
                                        </div>

                                        <!-- 5번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?=$tab5_text;?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">    
                                            <div class="col-lg-12"> 
                                                <P>※ERP 사원등록 메뉴에서 경영팀이 재직구분을 퇴직으로 변경한 상태</P>
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">ERP 권한회수(퇴사)</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="audit.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample51">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table5">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>사용자</th>
                                                                                <th>퇴사일</th>   
                                                                                <th>퇴사처리일시</th>
                                                                                <th>비고</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                                if (isset($Result_Grant4)) {
                                                                                    while($Data_Grant4 = sqlsrv_fetch_array($Result_Grant4, SQLSRV_FETCH_ASSOC))
                                                                                    {                                                                                    
                                                                            ?>                                                                            
                                                                                <tr>                                                                                             
                                                                                    <td><?= htmlspecialchars($Data_Grant4['NM_KOR'] ?? '') ?></td>  
                                                                                    <td><?= htmlspecialchars($Data_Grant4['DT_RETIRE'] ? date('Y-m-d', strtotime($Data_Grant4['DT_RETIRE'])) : '') ?></td>
                                                                                    <td><?= htmlspecialchars($Data_Grant4['DTS_UPDATE'] ? date('Y-m-d H:m:s', strtotime($Data_Grant4['DTS_UPDATE'])) : '') ?></td>
                                                                                    <td><?= htmlspecialchars($Data_Grant4['NOTE'] ?? '') ?></td> 
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
                                                            
                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt51">조회</button>
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
    //MARIA DB 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>