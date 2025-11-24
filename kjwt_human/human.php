<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <25.10.22>
    // Description: <hr 관리>
    // =============================================
    include_once realpath('human_status.php');
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include_once realpath('../head_lv1.php'); ?> 
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">      
        <!-- 매뉴 -->
        <?php include_once realpath('../nav.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">HR관리</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2; ?>" id="tab-two" data-toggle="pill" href="#tab2">HR</a>
                                        </li>    
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 -->
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [국가기술 자격증 등급체계]<br>
                                             - 기능사 < 산업기사 < 기사 < 기술사 (≒기능장)<br><br>        
                                        </div>

                                        <!-- 2번째 탭 -->
                                        <div class="tab-pane fade <?php echo $tab2_text; ?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">리스트</h1>
                                                    </a>

                                                    <form method="POST" autocomplete="off" action="human.php">
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="text-align: center;">이름</th>
                                                                                <th style="text-align: center;">소속</th>
                                                                                <th style="text-align: center;">자격</th>
                                                                                <th style="text-align: center;">사진</th>                                                                                
                                                                            </tr>
                                                                        </thead>                                                                        
                                                                        <tbody> 
                                                                        <?php 
                                                                            // 파일 시스템 경로 (확인용)
                                                                            $fs_base = realpath(__DIR__ . '/../img/erp_pic/');
                                                                            if ($fs_base === false) { $fs_base = __DIR__ . '/../img/erp_pic'; }
                                                                            $fs_base = rtrim($fs_base, '/') . '/';

                                                                            // 웹 경로를 DOCUMENT_ROOT 기준으로 동적으로 계산
                                                                            $docroot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
                                                                            $photo_base = '/' . ltrim(str_replace($docroot, '', rtrim($fs_base, '/')), '/');

                                                                            foreach ($statuses as $status) {
                                                                                $name = htmlspecialchars($status['NM_KOR'] ?? '', ENT_QUOTES, 'UTF-8');
                                                                                $dept = htmlspecialchars($status['NM_DEPT'] ?? '', ENT_QUOTES, 'UTF-8');
                                                                                $photo = $status['DC_PHOTO'] ?? '';
                                                                                $list_raw = $status['LIST'] ?? '';
                                                                                if ($list_raw !== '') {
                                                                                    $parts = array_map('trim', explode(',', $list_raw));
                                                                                    $parts = array_map(function($p){
                                                                                        return htmlspecialchars($p, ENT_QUOTES, 'UTF-8');
                                                                                    }, $parts);
                                                                                    $list_html = implode('<br>', $parts);
                                                                                } else {
                                                                                    $list_html = '-';
                                                                                }

                                                                                echo "<tr>";
                                                                                echo "<td style='text-align: center; vertical-align: middle;'>$name</td>";
                                                                                echo "<td style='text-align: center; vertical-align: middle;'>$dept</td>";
                                                                                echo "<td style='text-align: center; vertical-align: middle;'>$list_html</td>";

                                                                                if (!empty($photo)) {
                                                                                    $fs_path = $fs_base . $photo;
                                                                                    $img_src = $photo_base . '/' . rawurlencode($photo);

                                                                                    if (file_exists($fs_path) && is_file($fs_path)) {
                                                                                        echo "<td style='text-align: center; vertical-align: middle;'><img src='" . htmlspecialchars($img_src, ENT_QUOTES, 'UTF-8') . "' alt='사진' style='max-width:120px; max-height:120px;'></td>";
                                                                                    } else {
                                                                                        // 디버그: 파일 없음(웹에서 접근 가능한 전체 URL 확인용)
                                                                                        $full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $img_src;
                                                                                        echo "<td style='text-align: center; vertical-align: middle; color:#a00;'>파일 없음<br><small>" . htmlspecialchars($img_src) . "</small><br><small>" . htmlspecialchars($full_url) . "</small></td>";
                                                                                    }
                                                                                } else {
                                                                                    echo "<td style='text-align: center; vertical-align: middle;'>-</td>";
                                                                                }
                                                                                
                                                                                echo "</tr>";
                                                                            }
                                                                        ?>     
                                                                        </tbody>
                                                                    </table>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </form> 
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

    <!-- Bootstrap core JavaScript-->
    <?php include_once realpath('../plugin_lv1.php'); ?>
</body>
</html>

<?php 
    // 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }
    if(isset($connect)) { sqlsrv_close($connect); }
?>