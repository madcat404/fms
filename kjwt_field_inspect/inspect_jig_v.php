<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.23>
	// Description:	<베트남 지그 리뉴얼>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'inspect_jig_v_status.php';
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">JIG</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">LƯU Ý</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab2, ENT_QUOTES, 'UTF-8');?>" id="tab-two" data-toggle="pill" href="#tab2">JIG</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab3, ENT_QUOTES, 'UTF-8');?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">ghi lại</a>
                                        </li>   
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text, ENT_QUOTES, 'UTF-8');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">Trạng thái</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <!-- 보드 시작 -->
                                                            <div class="row">
                                                                <!-- 보드1 -->
                                                                <div class="col-xl-6 col-md-6 mb-2">
                                                                    <div class="card border-left-danger shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">sự nguy hiểm</div>
                                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($c_JigInspectNeed, ENT_QUOTES, 'UTF-8'); ?></div>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- 보드2 -->
                                                                <div class="col-xl-6 col-md-6 mb-2">
                                                                    <div class="card border-left-warning shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">cảnh báo</div>
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
                                                                            <th>JIG_ID</th>
                                                                            <th>JIG_SEQ</th>
                                                                            <th>LIMIT_QTY</th>
                                                                            <th>CURRENT_QTY</th>
                                                                            <th>TOTAL_QTY</th>
                                                                            <th>REGISTRANT</th>
                                                                            <th>REGISTRATION_DATE</th>
                                                                            <th>USER</th>
                                                                            <th>USE_DATE</th>
                                                                            <th>MODIFIER</th>
                                                                            <th>MODIFICATION_DATE</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            if (isset($result)) {
                                                                                while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)):
                                                                        ?>
                                                                        <tr data-toggle="modal" data-target="#editJigModalV"
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
                                                                        <?php 
                                                                                endwhile;
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

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab3_text, ENT_QUOTES, 'UTF-8');?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">Tìm kiếm</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="inspect_jig_v.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 검색범위 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>phạm vi</label>
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">Tìm kiếm</button>
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
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">ghi lại</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-striped" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>JIG_ID</th>
                                                                        <th>JIG_SEQ</th>
                                                                        <th>USAGE_COUNT</th>
                                                                        <th>JUDGMENT</th>
                                                                        <th>NOTE</th>
                                                                        <th>ADMINISTRATOR</th>
                                                                        <th>CHANGE_DATE</th>
                                                                        <th>RECORD_DATE</th>   
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
    <div class="modal fade" id="editJigModalV" tabindex="-1" role="dialog" aria-labelledby="editJigModalLabelV" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJigModalLabelV">CHECK JIG</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" autocomplete="off" action="inspect_jig_v.php">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>JIG_ID</label>
                                <input name="NM1" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>JIG_SEQ</label>
                                <input name="NM2" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>LIMIT_QTY</label>
                                <input name="QTY1" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>CURRENT_QTY</label>
                                <input name="QTY2" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>TOTAL_QTY</label>
                                <input name="QTY3" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>JUDGMENT</label>
                                <select name="JUDGMENT" class="form-control">
                                    <option value="CHECK" selected="selected">KIỂM TRA</option>
                                    <option value="CHANGE">THAY ĐỔI</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>MODIFICATION_DATE</label>
                                <input type="date" name="DT" id="modal_dt_v" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>NOTE</label>
                                <input name="NOTE" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" name="bt_modify" value="on" class="btn btn-primary">ĐẦU VÀO</button>
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
        $('#editJigModalV').on('show.bs.modal', function (event) {
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
            document.getElementById('modal_dt_v').valueAsDate = new Date();
        });
    });
    </script>

</body>
</html>

<?php 
    //메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>