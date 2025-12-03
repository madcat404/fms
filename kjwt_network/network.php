<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.07.13>
	// Description:	<비상연락망>	
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
    // Last Modified: <Current Date> - Mobile UI Optimization & Image Zoom
	// =============================================
    include 'network_status.php';   
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>
    <script>
        // [추가] 이미지 확대 스크립트
        function bigimg(filename){
            if (filename) {
                // 새 창으로 이미지 열기
                window.open("../files/" + filename, "bigimg", "width=800,height=800,scrollbars=yes"); 
            }
        }
    </script>     
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">비상연락망</h1>
                    </div>               

                    <div class="row"> 

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">비상연락망</a>
                                        </li>   
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 비상연락망 공유<BR><BR>   
                                            
                                            [기능]<BR>
                                            - 같은날 파일을 2번 업로드하면 제일 마지막것만 업로드됨<BR><br>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 전직원<br>
                                            - 해킹방지를 위해 2MB 초과 파일을 업로드할 수 없음<br>
                                            - 사진용량 줄이는 방법: <a href="https://fms.iwin.kr/kjwt_video/photo_size_down.mp4">https://fms.iwin.kr/kjwt_video/photo_size_down.mp4</a><br>
                                            - 패스워드 힌트: 32~<br><br>     
                                            [제작일]<BR>
                                            - 21.11.15<br><br>        
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">업로드</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="network.php" enctype="multipart/form-data"> 
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body p-3">
                                                            <div class="row">    
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>파일선택</label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="file" name="file">
                                                                            <label class="custom-file-label" for="file">파일선택</label>
                                                                        </div>                                                      
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>패스워드</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                <i class="fas fa-key"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="password" class="form-control" name="upload_code21" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div> 
                                                            </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt21">업로드</button>
                                                        </div>
                                                        </form>             
                                                </div>
                                                </div>
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">비상연락망</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample22">                                    
                                                    <div class="card-body p-2">
                                                        <div class="row">    
                                                            <div class="col-md-12">
                                                                <div class="form-group text-center mb-0">
                                                                    <?php 
                                                                        if ($Data_Menu && !empty($Data_Menu['FILE_NM'])) {
                                                                            $filename = htmlspecialchars(basename($Data_Menu['FILE_NM']), ENT_QUOTES, 'UTF-8');
                                                                            $image_path = '../files/' . $filename;
                                                                            
                                                                            // [수정] 이미지 클릭 시 확대 기능 적용, 스타일 최적화
                                                                            echo "<img src='{$image_path}' 
                                                                                style='width: 100%; height: auto; cursor: pointer; border-radius: 5px;' 
                                                                                onclick=\"bigimg('{$filename}')\" 
                                                                                alt='비상연락망'>";
                                                                        } else {
                                                                            echo "<div class='p-3'>등록된 비상연락망이 없습니다.</div>";
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            </div> 
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>   
                                    </div>
                                </div>
                            </div>
                        </div>   

                        </div>
                    </div>
                </div>
            </div>
        </div>
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