<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.03.18>
	// Description:	<마지막 사진 뷰어)>
    // Last Modified: <25.10.20> - Refactored for PHP 8.x	
    // Last Modified: <Current Date> - Security Update (Direct file access blocked)
	// =============================================
    include 'rental_lastpic_status.php';   
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">법인차 파손 흔적</h1>
                    </div>               

                    <div class="row">                 

                        <div class="col-lg-12"> 
                            <div class="card shadow mb-4">
                                <a href="#collapseCardExample3" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample3">
                                    <h6 class="m-0 font-weight-bold text-primary">Staria 9285</h6>
                                </a>
                                <div class="collapse show" id="collapseCardExample3">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php 
                                                if ($Result_LastPicData3) {
                                                    while($Data_LastPicData3 = $Result_LastPicData3->fetch_object()) {
                                                        // [보안 수정] 파일명을 URL 인코딩하여 보안 스크립트로 전달
                                                        $rawFileName = $Data_LastPicData3->FILE_NM;
                                                        $encodedFile = urlencode($rawFileName);
                                                        // view_file.php 경로 설정 (session 폴더 기준)
                                                        $viewUrl = "/session/view_file.php?file=" . $encodedFile;
                                            ?>
                                                <div class="col-sm-2 mb-3">
                                                    <a href="<?php echo $viewUrl; ?>" target="_blank">
                                                        <img src="<?php echo $viewUrl; ?>" alt="LastPic" style="width:100%;">
                                                    </a>  
                                                </div>   
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="button" class="btn btn-info"><a href="rental.php" style="text-decoration:none; color: white;">대여화면으로 돌아가기</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-4">
                                <a href="#collapseCardExample4" class="d-block card-header py-4" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample4">
                                    <h6 class="m-0 font-weight-bold text-primary">avante 7206</h6>
                                </a>                                 
                                <div class="collapse show" id="collapseCardExample4">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php 
                                                if ($Result_LastPicData4) {
                                                    while($Data_LastPicData4 = $Result_LastPicData4->fetch_object()) {
                                                        // [보안 수정]
                                                        $rawFileName = $Data_LastPicData4->FILE_NM;
                                                        $encodedFile = urlencode($rawFileName);
                                                        $viewUrl = "/session/view_file.php?file=" . $encodedFile;
                                            ?>
                                                <div class="col-sm-2 mb-3">
                                                    <a href="<?php echo $viewUrl; ?>" target="_blank">
                                                        <img src="<?php echo $viewUrl; ?>" alt="LastPic" style="width:100%;">
                                                    </a>  
                                                </div>   
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="button" class="btn btn-info"><a href="rental.php" style="text-decoration:none; color: white;">대여화면으로 돌아가기</a></button>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="col-lg-12"> 
                            <div class="card shadow mb-4">
                                <a href="#collapseCardExample5" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample5">
                                    <h6 class="m-0 font-weight-bold text-primary">avante 7207</h6>
                                </a>
                                <div class="collapse show" id="collapseCardExample5">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php 
                                                if ($Result_LastPicData5) {
                                                    while($Data_LastPicData5 = $Result_LastPicData5->fetch_object()) {
                                                        // [보안 수정]
                                                        $rawFileName = $Data_LastPicData5->FILE_NM;
                                                        $encodedFile = urlencode($rawFileName);
                                                        $viewUrl = "/session/view_file.php?file=" . $encodedFile;
                                            ?>
                                                <div class="col-sm-2 mb-3">
                                                    <a href="<?php echo $viewUrl; ?>" target="_blank">
                                                        <img src="<?php echo $viewUrl; ?>" alt="LastPic" style="width:100%;">
                                                    </a>  
                                                </div>   
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="button" class="btn btn-info"><a href="rental.php" style="text-decoration:none; color: white;">대여화면으로 돌아가기</a></button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    //메모리 회수
    if (isset($connect)) {
        mysqli_close($connect);
    }
?>