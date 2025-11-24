<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.03.05>
	// Description:	<선입선출>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'packing_pda_status.php';
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
                        <a href="packing_inquire_pda.php" class="btn btn-link mr-3" title="move_inquire">
                            <i class="fa fa-clipboard-list fa-2x"></i>
                        </a>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">생산/포장일 매핑</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 
                        <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-12 mb-2" id="pda_in"> 
                            <form method="POST" autocomplete="off" action="packing_pda.php">   
                                <!-- Begin row -->
                                <div class="row">                                                                        
                                    <!-- Begin 라벨스캔 -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <?php 
                                                    if(isset($mode) && ($mode == 0 || $mode == 2)) {
                                                ?>
                                                        <input type="text" class="form-control mr-2" name="pda_cd_item21" id="pda_cd_item21" aria-labelledby="pda_in" pattern="[a-zA-Z0-9^_()\- 7]+" placeholder="박스" inputmode="none" required autofocus>
                                                        <input type="text" class="form-control mr-2" name="pda_cd_item21_a" aria-labelledby="pda_in" pattern="[a-zA-Z0-9^_()\- 7]+" placeholder="제품" inputmode="none" disabled autofocus>
                                                <?php 
                                                    }
                                                    elseif($mode==1) {
                                                ?>
                                                        <input type="hidden" name="pda_cd_item21" value="<?php echo htmlspecialchars($pda_cd_item21 ?? '', ENT_QUOTES, 'UTF-8'); ?>">  
                                                        <input type="text" class="form-control mr-2" name="pda_cd_item21_v" value="<?php echo htmlspecialchars($cd_item21 ?? '', ENT_QUOTES, 'UTF-8'); ?>" disabled aria-labelledby="pda_in" pattern="[a-zA-Z0-9^_()\- 7]+" placeholder="박스" inputmode="none" autofocus>
                                                        <input type="text" class="form-control mr-2" name="pda_cd_item21_a" aria-labelledby="pda_in" pattern="[a-zA-Z0-9^_()\- 7]+" placeholder="제품" inputmode="none" required autofocus>
                                                <?php 
                                                    }
                                                ?>
                                                <button type="submit" value="on" class="btn btn-primary" name="pda_bt21">입력</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end 라벨스캔 -->                                        
                                </div> 
                                <!-- /.row -->   
                            </form>     
                        </div>   
                        
                        <!-- 결과 카드 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-12 mb-2"> 
                            <div class="row">
                                <!-- 보드 시작 -->
                                <?php 
                                    $user_ip = $_SERVER['REMOTE_ADDR'] ?? '';
                                    $ip_counts = [
                                        '192.168.3.117' => $Count_PDA3117 ?? 0,
                                        '192.168.4.102' => $Count_PDA3117 ?? 0,
                                        '192.168.4.100' => $Count_PDA4100 ?? 0,
                                        '192.168.4.177' => $Count_PDA4177 ?? 0,
                                        '192.168.4.107' => $Count_PDA4107 ?? 0,
                                        '192.168.4.105' => $Count_PDA4105 ?? 0,
                                    ];

                                    if (array_key_exists($user_ip, $ip_counts)) {
                                        BOARD2(4, "success", "나의실적(BOX)", $ip_counts[$user_ip], "fas fa-user-check", "pda_screen", $Count_PDA);
                                    }
                                    else {
                                        BOARD2(4, "success", "전체실적(BOX)", $Count_PDA ?? 0, "fas fa-boxes", "pda_screen", $Count_PDA);
                                    }
                                ?>
                                <!-- 보드 끝 -->
                            </div>
                        </div>

                        <!-- 삭제 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-12" id="pda_in"> 
                            <form method="POST" autocomplete="off" action="packing_pda.php">   
                                <!-- Begin row -->
                                <div class="row">                                                                        
                                    <!-- Begin 라벨스캔 -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control mr-2" name="pda_cd_item23" aria-labelledby="pda_in" pattern="[a-zA-Z0-9^_()\- 7]+" placeholder="박스" inputmode="none">
                                                <button type="submit" value="on" class="btn btn-primary" name="pda_bt23">삭제</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end 라벨스캔 -->                                        
                                </div> 
                                <!-- /.row -->   
                            </form>     
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