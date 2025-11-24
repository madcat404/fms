<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.23>
	// Description:	<지그 리뉴얼>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'inspect_jig_status.php';
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">지그</h1>
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
                                            <a class="nav-link <?php echo htmlspecialchars($tab2, ENT_QUOTES, 'UTF-8');?>" id="tab-two" data-toggle="pill" href="#tab2">지그</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab3, ENT_QUOTES, 'UTF-8');?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">지그변경이력</a>
                                        </li>                                          
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 지그 변경 및 이력관리 전산화<BR><BR>   

                                            [기능]<br>
                                            1. 지그탭<br>
                                            - [등록] 중복 지그가 있는 경우 '중복 지그가 있습니다! 다시 등록하세요!' 팝업창 생성<BR>   
                                            - [현황] 점검 현재값이 기준값에 80% 이상인 경우 현재값 셀을 주황색으로 표현<BR>   
                                            - [현황] 점검 현재값이 기준값보다 큰 경우 현재값 셀을 빨간색으로 표현<BR><BR>                                   
                                                                                 
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 검수반, 품질팀<br>      
                                            - 누적값: 지금까지 사용한 값<br>
                                            - 등록일: 지그 최초 등록날짜<br>
                                            - 사용일: 지그 사용 최종날짜<br>
                                            - 주황색: 점검도래<br>
                                            - 빨간색: 점검필요<br><br> 
                                            
                                            [제작일]<BR>
                                            - 21.11.23<br><br>                                             
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text, ENT_QUOTES, 'UTF-8');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 등록 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">등록</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="inspect_jig.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row"> 
                                                                    <!-- Begin 지그ID -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>지그ID</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-car"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="jigid21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 지그ID -->
                                                                    <!-- Begin 지그번호 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>지그번호</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="jignum21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 지그번호 -->
                                                                    <!-- Begin 점검기준값 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>점검기준값</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="val21" value="10000" required onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 점검기준값 -->                                              
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>  
                                        
                                        
                                            <!-- 현황!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">현황</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample22">
                                                        <div class="card-body table-responsive p-2">
                                                            <!-- 보드 시작 -->
                                                            <div class="row">
                                                                <!-- 보드1 -->
                                                                <div class="col-xl-4 col-md-6 mb-2">
                                                                    <div class="card border-left-info shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">지그수량</div>
                                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($c_JigCount, ENT_QUOTES, 'UTF-8'); ?></div>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- 보드2 -->
                                                                <div class="col-xl-4 col-md-6 mb-2">
                                                                    <div class="card border-left-danger shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">점검필요</div>
                                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($c_JigInspectNeed, ENT_QUOTES, 'UTF-8'); ?></div>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- 보드3 -->
                                                                <div class="col-xl-4 col-md-6 mb-2">
                                                                    <div class="card border-left-warning shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">점검도래</div>
                                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($c_JigInspectSoon, ENT_QUOTES, 'UTF-8'); ?></div>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- 보드 끝 -->

                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped" id="table1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>지그ID</th>
                                                                            <th>지그번호</th>
                                                                            <th>점검 기준값</th>
                                                                            <th>현재값</th>
                                                                            <th>누적값</th>
                                                                            <th>등록자</th>
                                                                            <th>둥록일</th>
                                                                            <th>사용자</th>
                                                                            <th>사용일</th>
                                                                            <th>변경자</th>
                                                                            <th>변경일</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)):
                                                                        ?>
                                                                        <tr data-toggle="modal" data-target="#editJigModal"
                                                                            data-jig-id="<?php echo htmlspecialchars($row['JIG_ID'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                            data-jig-seq="<?php echo htmlspecialchars($row['JIG_SEQ'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                            data-limit-qty="<?php echo htmlspecialchars($row['LIMIT_QTY'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                            data-current-qty="<?php echo htmlspecialchars($row['CURRENT_QTY'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                            data-total-qty="<?php echo htmlspecialchars($row['TOTAL_QTY'], ENT_QUOTES, 'UTF-8'); ?>"
                                                                            style="cursor: pointer;" onMouseOver="this.style.backgroundColor='#ffedbf';" onMouseOut="this.style.backgroundColor='';">
                                                                            <td><?php echo htmlspecialchars($row['JIG_ID'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($row['JIG_SEQ'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($row['LIMIT_QTY'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <?php 
                                                                                $cell_style = '';
                                                                                if($row['CURRENT_QTY'] >= $row['LIMIT_QTY']) {
                                                                                    $cell_style = 'style="background-color: red;"';
                                                                                }
                                                                                elseif($row['CURRENT_QTY'] >= ($row['LIMIT_QTY'] * 0.8)) {
                                                                                    $cell_style = 'style="background-color: orange;"';
                                                                                }
                                                                            ?>
                                                                            <td <?php echo $cell_style; ?>><?php echo htmlspecialchars($row['CURRENT_QTY'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($row['TOTAL_QTY'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($row['INSRT_USER_ID'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($row['INSRT_DT'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($row['UPDT_USER_ID'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($row['UPDT_DT'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                            <td><?php echo htmlspecialchars($row['LAST_UPDATE_USER'], ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                            <td><?php echo htmlspecialchars($row['LAST_UPDATE_DATE'], ENT_QUOTES, 'UTF-8'); ?></td>                                   
                                                                        </tr> 
                                                                        <?php endwhile; ?>
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

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab3_text, ENT_QUOTES, 'UTF-8');?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="inspect_jig.php"> 
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
                                                            <table class="table table-bordered table-striped" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>지그ID</th>
                                                                        <th>지그번호</th>
                                                                        <th>사용횟수</th>
                                                                        <th>조치사항</th>
                                                                        <th>내용</th>
                                                                        <th>담당자</th>
                                                                        <th>변경일</th>
                                                                        <th>기록일</th>   
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($result_out)) {
                                                                            while($row_out = sqlsrv_fetch_array($result_out, SQLSRV_FETCH_ASSOC)):
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($row_out['JIG_ID'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                        <td><?php echo htmlspecialchars($row_out['JIG_SEQ'], ENT_QUOTES, 'UTF-8'); ?></td>                               
                                                                        <td><?php echo htmlspecialchars($row_out['USAGE_COUNT'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                        <td><?php echo htmlspecialchars($row_out['JUDGMENT'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                        <td><?php echo htmlspecialchars($row_out['NOTE'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                        <td><?php echo htmlspecialchars($row_out['UPDT_USER_ID'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                        <td><?php echo htmlspecialchars($row_out['UPDT_DT'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                        <td><?php echo htmlspecialchars($row_out['INSERT_DT'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                    </tr> 
                                                                    <?php 
                                                                            endwhile;
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- 지그 수정 Modal -->
    <div class="modal fade" id="editJigModal" tabindex="-1" role="dialog" aria-labelledby="editJigModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJigModalLabel">지그 점검/교체</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" autocomplete="off" action="inspect_jig.php">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>지그ID</label>
                                <input name="NM1" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>지그번호</label>
                                <input name="NM2" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>기준값</label>
                                <input name="QTY1" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>현재값</label>
                                <input name="QTY2" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>누적값</label>
                                <input name="QTY3" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>조치사항</label>
                                <select name="JUDGMENT" class="form-control">
                                    <option value="CHECK" selected="selected">점검</option>
                                    <option value="CHANGE">교체</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>변경일</label>
                                <input type="date" name="DT" id="modal_dt" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>내용</label>
                                <input name="NOTE" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                        <button type="submit" name="bt_modify" value="on" class="btn btn-primary">입력</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>

    <script>
    $(document).ready(function() {
        // 모달이 열릴 때 이벤트 처리
        $('#editJigModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // 모달을 트리거한 <tr> 엘리먼트
            // data-* 속성에서 데이터 추출
            var jigId = button.data('jig-id');
            var jigSeq = button.data('jig-seq');
            var limitQty = button.data('limit-qty');
            var currentQty = button.data('current-qty');
            var totalQty = button.data('total-qty');

            // 모달의 입력 필드에 데이터 채우기
            var modal = $(this);
            modal.find('.modal-body input[name="NM1"]').val(jigId);
            modal.find('.modal-body input[name="NM2"]').val(jigSeq);
            modal.find('.modal-body input[name="QTY1"]').val(limitQty);
            modal.find('.modal-body input[name="QTY2"]').val(currentQty);
            modal.find('.modal-body input[name="QTY3"]').val(totalQty);

            // 변경일 기본값을 오늘 날짜로 설정
            document.getElementById('modal_dt').valueAsDate = new Date();
        });
    });
    </script>

</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>
