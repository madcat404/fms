<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.03.19>
	// Description:	<포장생산일 매핑 조회 (pda용)>		
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'finished_inquire_pda_status.php';
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
                    <a href="finished_pda.php" class="btn btn-link mr-3" title="move_input">
                            <i class="fa fa-barcode fa-2x"></i>
                        </a>     
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">출하 실적</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 
                        <div id="table" class="table-responsive">
                            <table class="table table-bordered table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>품번 (제품군)</th>
                                        <th>BOX (PCS)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                        
                                        if ($Result_OutputQuantity) {
                                            while($row = sqlsrv_fetch_array($Result_OutputQuantity, SQLSRV_FETCH_ASSOC))
                                            {
                                                //쓰레기값이 나오는것을 차단하기 위함
                                                if(!empty($row['CD_ITEM'])) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['CD_ITEM']." (".($row['item_name'] ?? 'N/A').")"; ?></td>
                                                <td><?php echo $row['BOX']." (".$row['PCS'].")"; ?></td>                                                                            
                                            </tr>
                                    <?php 
                                                }
                                            }
                                        }
                                    ?>                     
                                </tbody>
                            </table>
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