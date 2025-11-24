<?php 
  // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.12.06>
	// Description:	<공정진행 완료>	
	// =============================================
    include 'field_complete_status.php';
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">검사완료</h1>
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
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2" >한국</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab6;?>" id="custom-tabs-one-4th-tab" data-toggle="pill" href="#custom-tabs-one-4th">베트남</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">완료내역</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4;?>" id="custom-tabs-one-2th-tab" data-toggle="pill" href="#custom-tabs-one-2th">불량내역</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">삭제내역</a>
                                        </li>                                        
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            <?php include 'tabs/notice.php'; ?>
                                        </div>
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <?php include 'field_complete_tabs/korea.php'; ?>
                                        </div>  
                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="custom-tabs-one-4th" role="tabpanel" aria-labelledby="custom-tabs-one-4th-tab">
                                            <?php include 'field_complete_tabs/vietnam.php'; ?>
                                        </div>
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <?php include 'field_complete_tabs/completed.php'; ?>
                                        </div>
                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="custom-tabs-one-2th" role="tabpanel" aria-labelledby="custom-tabs-one-2th-tab">
                                            <?php include 'field_complete_tabs/defects.php'; ?>
                                        </div> 
                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">
                                            <?php include 'field_complete_tabs/deleted.php'; ?>
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

    <!-- Item Selection Modal -->
    <div class="modal fade" id="itemSelectionModal" tabindex="-1" role="dialog" aria-labelledby="itemSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemSelectionModalLabel">품번 선택</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="field_complete.php">
                    <div class="modal-body">
                        <p>여러 개의 품번이 발견되었습니다. 하나를 선택해주세요.</p>
                        <?php
                        if (isset($_SESSION['item_options'])) {
                            foreach ($_SESSION['item_options'] as $option) {
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" name="selected_item" id="item_'.htmlspecialchars($option).'" value="'.htmlspecialchars($option).'" required>';
                                echo '<label class="form-check-label" for="item_'.htmlspecialchars($option).'">'.htmlspecialchars($option).'</label>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="original_work_order" value="<?php echo htmlspecialchars($_SESSION['original_work_order'] ?? ''); ?>">
                        <button type="submit" class="btn btn-primary" name="bt21_item_selected" value="on">선택</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>

    <?php 
        if(isset($_GET['popup']) && $_GET['popup'] == 'select_item') {
    ?>
        <script>
            $('#itemSelectionModal').modal('show');
        </script>
    <?php
        }
        elseif($kmodal=='on') {
    ?>      
        <script>
            $('#exampleModal').modal('show');
        </script>
    <?php 
        }
        elseif($kmodal2=='on') {
    ?>      
            <script>
                $('#exampleModal2').modal('show');      
            </script>
    <?php 
        }
        elseif($vmodal=='on') {
    ?>      
        <script>
            $('#exampleModalV').modal('show');      
        </script>
    <?php 
        }
        elseif($vmodal2=='on') {
    ?>      
            <script>
                $('#exampleModalV2').modal('show');      
            </script>
    <?php        
        }            
    ?>      
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) {mysqli_close($connect4);}	

    //MSSQL 메모리 회수
    if(isset($connect)) {sqlsrv_close($connect);}	
?>