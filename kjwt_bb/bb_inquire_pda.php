<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.04.11>
	// Description:	<bb 조회 (pda용)>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include_once __DIR__ . '/bb_inquire_pda_status.php';
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
                    <a href="bb_in_pda.php" class="btn btn-link mr-3" title="move_input">
                            <i class="fa fa-barcode fa-2x"></i>
                        </a>     
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">B/B창고 조회</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>품번</th>
                                        <th>수량</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        // while 루프와 htmlspecialchars를 사용하여 안전하고 안정적으로 데이터를 출력합니다.
                                        if (isset($Result_InputBB)) {
                                            while ($Data_InputBB = sqlsrv_fetch_array($Result_InputBB, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($Data_InputBB['CD_ITEM'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($Data_InputBB['QT_GOODS'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>                                                                            
                                    </tr> 
                                    <?php 
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
    <?php include_once __DIR__ . '/../plugin_lv1.php'; ?>
</body>
</html>