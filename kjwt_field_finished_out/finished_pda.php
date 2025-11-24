<?php 
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.07.02>
	// Description:	<출하 pda>	
	// =============================================
    include 'finished_pda_status.php';
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
                        <a href="finished_inquire_pda.php" class="btn btn-link mr-3" title="move_inquire">
                            <i class="fa fa-clipboard-list fa-2x"></i>
                        </a>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">완성품 출하</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 
                        <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-12 mb-2" id="pda_in"> 
                            <form method="POST" autocomplete="off" action="finished_pda.php">   
                                <!-- Begin row -->
                                <div class="row">                                                                        
                                    <!-- Begin 라벨스캔 -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control mr-2" name="item2" aria-labelledby="pda_in" pattern="[a-zA-Z0-9^_()\- 7]+" placeholder="부품식별표 바코드 스캔" inputmode="none" required autofocus>
                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
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
                                    //다이렉트로 넣고 0인경우 정상적으로 출력이 안됨
                                    if($Data_OutputQuantity['PCS']==0) {
                                        $box="0";
                                    }
                                    else {
                                        $box=$Data_OutputQuantity['BOX'];
                                    }
                                    BOARD2(4, "success", "지입기사", $DeliveryName, "fas fa-boxes", "pda_finished", $box);                                    
                                ?>
                                <!-- 보드 끝 -->
                            </div>
                        </div>

                        <!-- 삭제 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-12" id="pda_in"> 
                            <form method="POST" autocomplete="off" action="finished_pda.php">   
                                <!-- Begin row -->
                                <div class="row">                                                                        
                                    <!-- Begin 라벨스캔 -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control mr-2" name="item22" aria-labelledby="pda_in" pattern="[a-zA-Z0-9^_()\- 7]+" placeholder="부품식별표 바코드 스캔" inputmode="none">
                                                <button type="submit" value="on" class="btn btn-primary" name="bt22">출하취소</button>
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