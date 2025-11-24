<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.08>
	// Description:	<bb 입고>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include_once __DIR__ . '/bb_in_status.php';
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include_once __DIR__ . '/../head_lv1.php'; ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">      
        
        <!-- 메뉴 -->
        <?php include_once __DIR__ . '/../nav.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <a href="bb_inquire_pda.php" class="btn btn-link mr-3" title="move_inquire">
                            <i class="fa fa-clipboard-list fa-2x"></i>
                        </a>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">B/B창고 입고</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 
                        <!-- 입력 --> 
                        <div class="col-lg-12 mb-4" id="pda_in"> 
                            <form method="POST" autocomplete="off" action="bb_in_pda.php">   
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="pda_cd_item_input" class="sr-only">라벨스캔</label>
                                            <div class="input-group">                                                
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                </div>
                                                <input type="text" id="pda_cd_item_input" class="form-control mr-2" name="pda_cd_item21" aria-labelledby="pda_in" pattern="[a-zA-Z0-9^_()\- 7]+" inputmode="none" autofocus>
                                                <button type="submit" value="on" class="btn btn-primary" name="pda_bt21">입력</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </form>     
                        </div>   
                        
                        <!-- 결과 카드 --> 
                        <div class="col-lg-12"> 
                            <div class="row">
                                <!-- 보드 시작 -->
                                <?php 
                                    // XSS 방지를 위해 htmlspecialchars 적용
                                    $total_count = $Data_InputBB2['COU'] ?? 0;
                                    BOARD(4, "success", "입고수량(BOX)", htmlspecialchars($total_count, ENT_QUOTES, 'UTF-8'), "fas fa-boxes");   
                                ?>
                                <!-- 보드 끝 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <?php include_once __DIR__ . '/../plugin_lv1.php'; ?>
</body>
</html>