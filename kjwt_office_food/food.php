<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>    
    // Create date: <21.11.15>
    // Description: <식수 리뉴얼>   
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
    // Last Modified: <Current Date> - Security Update (Direct file access blocked)
    // =============================================
    include 'food_status.php';   

    // XSS 방지를 위한 헬퍼 함수
    function h($string) {
        if (!isset($string)) return '';
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    // [Tab 2] 식단표 이미지 데이터 배열 저장
    $menu_list = [];
    if (isset($Result_Menu)) {
        while ($row = sqlsrv_fetch_array($Result_Menu, SQLSRV_FETCH_ASSOC)) {
            $menu_list[] = $row;
        }
    }

    // [Tab 3] 식수내역 데이터 배열 저장
    $food_history_data = [];
    if (isset($result) && $result !== false) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            // 날짜 객체 처리 (DateTime 객체일 경우 포맷팅)
            if (isset($row['date']) && $row['date'] instanceof DateTime) {
                $row['date_str'] = $row['date']->format('Y-m-d');
            } else {
                $row['date_str'] = $row['date'] ?? '-';
            }
            $food_history_data[] = $row;
        }
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>
    <script>
        // [보안 수정] 이미지 확대 스크립트 (보안 스크립트 경로 사용)
        function bigimg(encodedFilename){
            if (encodedFilename) {
                // 직접 경로(../files/) 대신 보안 뷰어(view_file.php)를 호출
                window.open("/session/view_file.php?file=" + encodedFilename, "bigimg", "width=800,height=800,scrollbars=yes"); 
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">식당</h1>
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
                                            <a class="nav-link <?php echo h($tab2 ?? '');?>" id="tab-two" data-toggle="pill" href="#tab2">식단표</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3 ?? '');?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">식수내역</a>
                                        </li>   
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 식단표 공유<BR><BR>   
                                            
                                            [기능]<BR>
                                            - 같은날 파일을 2번 업로드하면 제일 마지막것만 업로드됨<BR>
                                            - 금일에 근접한 다른날 올린 2개의 파일을 표시함<BR>
                                            - 세콤에 지문 또는 사원증을 태그한것을 카운팅하여 식수내역에 표시함<BR>
                                            - 세션보안 즉 로그인을 요구받지 않는 페이지이므로 서버로 파일을 업로드할 때 바이러스, 웜 등과 같은 파일 업로드를 방지하기 위해 패스워드 입력을 요구함 <BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 전직원<br>
                                            - 외부인의 경우 tv 옆 종이에 수기로 적음<br>
                                            - 영양사는 식수내역 데이터를 참조할 뿐이며 실제로 식판 개수와 외부인 기록을 카운팅하여 비용을 계산함<br><br>
                                                                                   
                                            [제작일]<BR>
                                            - 21.11.15<br><br>        
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab2_text ?? '');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">업로드</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="food.php" enctype="multipart/form-data"> 
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
                                                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
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
                                                    </div>
                                                </form>             
                                            </div>

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">식단표</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample22">                                    
                                                    <div class="card-body p-2">
                                                        <div class="row">    
                                                            <div class="col-md-12">
                                                                <div class="form-group text-center mb-0">
                                                                    <?php foreach ($menu_list as $menu): 
                                                                        // [보안 및 오류 수정]
                                                                        // 1. 날짜가 DateTime 객체인지 확인 후 문자열로 변환
                                                                        $sortDate = $menu['SORTING_DATE'];
                                                                        if ($sortDate instanceof DateTime) {
                                                                            $sortDate = $sortDate->format('Y-m-d');
                                                                        }
                                                                        
                                                                        // 2. 파일명 생성 (예: food 2025-01-14)
                                                                        $rawFilename = 'food ' . $sortDate; 
                                                                        
                                                                        // 3. [중요] 파일명에 공백이 있으므로 URL 인코딩 필수
                                                                        $encodedFilename = urlencode($rawFilename);
                                                                        
                                                                        // 4. 보안 뷰어 스크립트 경로 생성
                                                                        $viewUrl = "/session/view_file.php?file=" . $encodedFilename;
                                                                    ?>
                                                                        <img src='<?= $viewUrl ?>' 
                                                                             style='width: 100%; height: auto; margin-bottom: 10px; border-radius: 5px; cursor: pointer;'
                                                                             onclick="bigimg('<?= $encodedFilename ?>')">
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        <div class="tab-pane fade <?php echo h($tab3_text ?? '');?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="food.php"> 
                                                    <div class="collapse show" id="collapseCardExample31">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>검색범위</label>
                                                                <div class="input-group">                                                
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt3">
                                                                </div>
                                                            </div>      
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample32">
                                                    <div class="card-body p-2">
                                                        <div class="d-md-none">
                                                            <?php foreach ($food_history_data as $row): ?>
                                                            <div class="card mb-2">
                                                                <div class="card-body p-3">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                                                        <span class="h6 font-weight-bold text-secondary mb-0"><?= h($row['date_str']) ?></span>
                                                                        <span class="small text-gray-600">출근: <strong class="text-dark"><?= h($row['work_people']) ?></strong>명</span>
                                                                    </div>
                                                                    <div class="row text-center">
                                                                        <div class="col-4 border-right">
                                                                            <div class="small text-gray-600 mb-1">아침</div>
                                                                            <div class="font-weight-bold text-dark"><?= h($row['morning']) ?></div>
                                                                        </div>
                                                                        <div class="col-4 border-right">
                                                                            <div class="small text-gray-600 mb-1">점심</div>
                                                                            <div class="font-weight-bold text-dark"><?= h($row['lunch']) ?></div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="small text-gray-600 mb-1">저녁</div>
                                                                            <div class="font-weight-bold text-dark"><?= h($row['dinner']) ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                            <?php if(empty($food_history_data) && isset($bt31)): ?>
                                                                <div class="text-center p-3 small text-gray-500">검색 결과가 없습니다.</div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>날짜</th>
                                                                        <th>출근인원</th>
                                                                        <th>아침</th>
                                                                        <th>점심</th>
                                                                        <th>저녁</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($food_history_data as $row): ?>
                                                                    <tr>
                                                                        <td><?= h($row['date_str']) ?></td>
                                                                        <td><?= h($row['work_people']) ?></td>
                                                                        <td><?= h($row['morning']) ?></td>
                                                                        <td><?= h($row['lunch']) ?></td>
                                                                        <td><?= h($row['dinner']) ?></td>
                                                                    </tr> 
                                                                    <?php endforeach; ?>  
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
    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    // 메모리 회수
    if (isset($connect4)) { mysqli_close($connect4); }  
    if (isset($connect)) { sqlsrv_close($connect); }
?>