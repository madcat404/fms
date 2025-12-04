<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <25.10.22>
    // Description: <hr 관리>
    // Last Modified: <Current Date> - Mobile UI Optimization & Search
    // =============================================
    include_once realpath('human_status.php');

    // XSS 방지 헬퍼
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 이미지 경로 설정 (공통)
    $fs_base = realpath(__DIR__ . '/../img/erp_pic/');
    if ($fs_base === false) { $fs_base = __DIR__ . '/../img/erp_pic'; }
    $fs_base = rtrim($fs_base, '/') . '/';
    
    $docroot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
    $photo_base = '/' . ltrim(str_replace($docroot, '', rtrim($fs_base, '/')), '/');
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include_once realpath('../head_lv1.php'); ?> 
    <style>
        /* [수정] 모바일 검색창 스타일 (사각형, 흰색 배경) */
        .mobile-search-input {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 0; /* 사각형 */
            background-color: #ffffff !important; /* 배경 흰색 */
            color: #495057; /* 텍스트 어두운 회색 */
            border: 1px solid #d1d3e2; /* 테두리 */
        }
        .mobile-search-input::placeholder {
            color: #858796;
        }
        .mobile-search-btn {
            width: 60px;
            border-radius: 0; /* 사각형 */
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">      
        <?php include_once realpath('../nav.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
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
                                            <a class="nav-link <?php echo h($tab2 ?? ''); ?>" id="tab-two" data-toggle="pill" href="#tab2">HR</a>
                                        </li>    
                                    </ul>
                                </div>

                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [국가기술 자격증 등급체계]<br>
                                             - 기능사 < 산업기사 < 기사 < 기술사 (≒기능장)<br><br>        
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab2_text ?? ''); ?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            
                                            <div class="card shadow mb-3 d-block d-md-none border-0 bg-transparent">
                                                <form method="GET" action="human.php">
                                                    <input type="hidden" name="tab" value="2">
                                                    <div class="input-group shadow-sm">
                                                        <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="이름 검색" value="<?= h($search_keyword) ?>">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary mobile-search-btn" type="submit">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">리스트</h1>
                                                </a>

                                                <div class="collapse show" id="collapseCardExample21">
                                                    <div class="card-body p-2"> 
                                                        
                                                        <div class="d-md-none">
                                                            <?php foreach ($statuses as $status): 
                                                                $name = h($status['NM_KOR']);
                                                                $dept = h($status['NM_DEPT']);
                                                                $photo = $status['DC_PHOTO'];
                                                                
                                                                // 자격증 리스트 처리
                                                                $list_raw = $status['LIST'] ?? '';
                                                                $list_html = ($list_raw !== '') ? str_replace(',', ', ', h($list_raw)) : '-';

                                                                // 이미지 경로 처리
                                                                $img_tag = '<div class="bg-gray-200 d-flex align-items-center justify-content-center rounded-circle" style="width:80px; height:80px;"><i class="fas fa-user fa-2x text-gray-400"></i></div>';
                                                                if (!empty($photo)) {
                                                                    $fs_path = $fs_base . $photo;
                                                                    $img_src = $photo_base . '/' . rawurlencode($photo);
                                                                    if (file_exists($fs_path) && is_file($fs_path)) {
                                                                        $img_tag = "<img src='" . h($img_src) . "' alt='사진' class='rounded-circle' style='width:80px; height:80px; object-fit:cover; border: 2px solid #eaecf4;'>";
                                                                    }
                                                                }
                                                            ?>
                                                            <div class="card mb-2 shadow-sm border-0">
                                                                <div class="card-body p-3">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-auto pr-0">
                                                                            <?= $img_tag ?>
                                                                        </div>
                                                                        <div class="col pl-3">
                                                                            <div class="h5 font-weight-bold text-primary mb-1">
                                                                                <?= $name ?> <span class="text-xs text-gray-500 font-weight-normal ml-1"><?= $dept ?></span>
                                                                            </div>
                                                                            <div class="text-xs font-weight-bold text-uppercase text-gray-600 mb-1">보유 자격</div>
                                                                            <div class="small text-gray-800">
                                                                                <?= $list_html ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                            <?php if(empty($statuses)): ?>
                                                                <div class="text-center p-5 text-gray-500">
                                                                    <?php if($search_keyword): ?>
                                                                        검색 결과가 없습니다.
                                                                    <?php else: ?>
                                                                        데이터가 없습니다.
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-hover" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="text-align: center; width: 15%;">이름</th>
                                                                        <th style="text-align: center; width: 15%;">소속</th>
                                                                        <th style="text-align: center;">자격</th>
                                                                        <th style="text-align: center; width: 150px;">사진</th>                                                                                
                                                                    </tr>
                                                                </thead>                                                                        
                                                                <tbody> 
                                                                <?php 
                                                                    foreach ($statuses as $status) {
                                                                        $name = h($status['NM_KOR']);
                                                                        $dept = h($status['NM_DEPT']);
                                                                        $photo = $status['DC_PHOTO'] ?? '';
                                                                        
                                                                        $list_raw = $status['LIST'] ?? '';
                                                                        if ($list_raw !== '') {
                                                                            $parts = array_map('trim', explode(',', $list_raw));
                                                                            $parts = array_map('h', $parts);
                                                                            $list_html = implode('<br>', $parts);
                                                                        } else {
                                                                            $list_html = '-';
                                                                        }

                                                                        echo "<tr>";
                                                                        echo "<td style='text-align: center; vertical-align: middle; font-weight:bold;'>$name</td>";
                                                                        echo "<td style='text-align: center; vertical-align: middle;'>$dept</td>";
                                                                        echo "<td style='vertical-align: middle;'>$list_html</td>";

                                                                        if (!empty($photo)) {
                                                                            $fs_path = $fs_base . $photo;
                                                                            $img_src = $photo_base . '/' . rawurlencode($photo);

                                                                            if (file_exists($fs_path) && is_file($fs_path)) {
                                                                                echo "<td style='text-align: center; vertical-align: middle;'><img src='" . h($img_src) . "' alt='사진' style='max-width:100px; max-height:120px; border-radius:5px;'></td>";
                                                                            } else {
                                                                                echo "<td style='text-align: center; vertical-align: middle; color:#a00; font-size:0.8rem;'>파일 없음</td>";
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

    <?php include_once realpath('../plugin_lv1.php'); ?>
    
    <?php if($search_keyword): ?>
    <script>
        // 검색 후 탭 유지
        $(document).ready(function() {
            $('#tab-two').tab('show');
        });
    </script>
    <?php endif; ?>
</body>
</html>

<?php 
    // 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>