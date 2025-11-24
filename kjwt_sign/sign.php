<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.17>
	// Description:	<회람 전산화>
    // Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
	// =============================================
    include 'sign_status.php';

    // Check if we need to show the signature date and time
    $show_dt = isset($_GET['show_dt']) && $_GET['show_dt'] == '1';
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>   

    <style>
        .table-bordered th,
        .table-bordered td {
            <?php if ($show_dt) { ?>
            width: 12.5%; /* 8 columns */
            <?php } else { ?>
            width: 16.66%; /* 6 columns */
            <?php } ?>
            text-align: center;
            vertical-align: middle;
        }
        .table-bordered {
            width: 100%;
            table-layout: fixed;
        }
    </style> 
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">      
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">           

                    <!-- Begin row -->
                    <div class="row"> 
                        <div class="col-lg-12 pt-5" style="text-align: center; font-weight: bold; font-size: 50px;"> 
                        <?php echo isset($Data_SignSelect['TITLE']) ? htmlspecialchars($Data_SignSelect['TITLE'], ENT_QUOTES, 'UTF-8') : ''; ?>
                        </div>
                        <div class="col-lg-12 py-3" style="text-align: right; font-weight: bold; font-size: 20px;"> 
                        <?php echo isset($SIGNYY) ? htmlspecialchars($SIGNYY, ENT_QUOTES, 'UTF-8') : '';?>.  <?php echo isset($SIGNMM) ? htmlspecialchars($SIGNMM, ENT_QUOTES, 'UTF-8') : '';?>.  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="col-lg-12"> 
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>이름</th>
                                        <th>서명</th>
                                        <?php if ($show_dt) echo '<th>서명일시</th>'; ?>
                                        <th>NO</th>
                                        <th>이름</th>
                                        <th>서명</th>
                                        <?php if ($show_dt) echo '<th>서명일시</th>'; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($Result_Sign)) {
                                        $allSignData = [];
                                        while ($rowData = sqlsrv_fetch_array($Result_Sign, SQLSRV_FETCH_ASSOC)) {
                                            $allSignData[] = $rowData;
                                        }
                                        $totalItems = count($allSignData);
                                        $setsPerRow = 2;
                                        $itemsPerVerticalSetColumn = ceil($totalItems / $setsPerRow);

                                        for ($row = 0; $row < $itemsPerVerticalSetColumn; $row++) {
                                            echo '<tr>';
                                            for ($set = 0; $set < $setsPerRow; $set++) {
                                                $itemIndex = ($set * $itemsPerVerticalSetColumn) + $row;

                                                if ($itemIndex < $totalItems) {
                                                    $Data_SignF = $allSignData[$itemIndex];
                                        ?>
                                                    <td><?php echo ($itemIndex + 1); ?></td>
                                                    <td><?php echo htmlspecialchars($Data_SignF['NAME'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td>
                                                        <?php
                                                            if (!empty($Data_SignF['TITLE'])) {
                                                                if ($Data_SignF['NAME'] == '김창복') {
                                                        ?>
                                                                    <img src="https://fms.iwin.kr/img/gongmu.png" style="width: 40px; height: 30px;">
                                                        <?php
                                                                }
                                                                elseif ($Data_SignF['CONDITION'] == '퇴사') {                                                            
                                                                        // Security: Use basename to prevent path traversal attacks.
                                                                        $image_name = basename($Data_SignF['NAME']);
                                                                        $local_image_path = "../img/" . $image_name . ".jpg";

                                                                        if (file_exists($local_image_path)) {
                                                        ?>
                                                                        <img src="<?php echo htmlspecialchars($local_image_path, ENT_QUOTES, 'UTF-8'); ?>" style="width: 40px; height: 30px;">
                                                        <?php
                                                                    } else {
                                                        ?>
                                                                            <span>서명 이미지 없음</span>
                                                        <?php
                                                                    }
                                                                }
                                                                elseif (!empty($Data_SignF['CONDITION'])) {
                                                                    echo htmlspecialchars($Data_SignF['CONDITION'], ENT_QUOTES, 'UTF-8');
                                                                }
                                                                else {
                                                                    if (!empty($sign_id)) {
                                                        ?>
                                                                        <img src="https://gw.iwin.kr/gw/cmm/file/fileDownloadProc.do?fileId=<?php echo htmlspecialchars($Data_SignID['sign_file_id'], ENT_QUOTES, 'UTF-8'); ?>&fileSn=0" style="width: 40px; height: 30px;">  
                                                        <?php
                                                                    } else {
                                                                        // Security: Use basename to prevent path traversal attacks.
                                                                        $image_name = basename($Data_SignF['NAME']);
                                                                        $local_image_path = "../img/" . $image_name . ".jpg";
                                                                        
                                                                        if (file_exists($local_image_path)) {
                                                        ?>
                                                                            <img src="<?php echo htmlspecialchars($local_image_path, ENT_QUOTES, 'UTF-8'); ?>" style="width: 40px; height: 30px;">
                                                        <?php
                                                                        } else {
                                                        ?>
                                                                            <span>서명 이미지 없음</span>
                                                        <?php
                                                                        } 
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <?php if ($show_dt) { ?>
                                                    <td><?php echo !empty($Data_SignF['SIGN_DT']) ? htmlspecialchars($Data_SignF['SIGN_DT']->format('Y-m-d H:i'), ENT_QUOTES, 'UTF-8') : ''; ?></td>
                                                    <?php } ?>
                                        <?php
                                                } else {
                                                    if ($show_dt) {
                                                        echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
                                                    } else {
                                                        echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
                                                    }
                                                }
                                            }
                                            echo '</tr>';
                                        }
                                    } //end if
                                    ?>
                                </tbody>
                            </table>            
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
    if(isset($connect3)) { mysqli_close($connect3); }

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>