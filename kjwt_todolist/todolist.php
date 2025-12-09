<?php 
    // Prevent caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.04>
	// Description:	<to do list - 모바일 최적화 적용>
    // Last Modified: <25.09.25>
	// =============================================
    include_once 'todolist_status.php';

    // Helper function for safe HTML output
    function h($s) {
        return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 탭 활성화 안전장치
    $tab2 = $tab2 ?? '';
    $tab3 = $tab3 ?? '';
    $tab2_text = $tab2_text ?? '';
    $tab3_text = $tab3_text ?? '';

    // 기본 탭 설정
    if (empty($tab2_text) && empty($tab3_text)) {
        if ((isset($bt31) && $bt31 == 'on') || (isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'history')) {
            $tab3 = 'active';
            $tab3_text = 'show active';
        } else {
            $tab2 = 'active';
            $tab2_text = 'show active';
        }
    }

    // 검색어 파라미터
    $search_keyword = $_REQUEST['search_keyword'] ?? '';

    // [Tab 2] 미처리 목록 데이터 처리 (배열 저장 및 필터링)
    $not_work_list = [];
    if (isset($Result_NotWork)) {
        // $Result_NotWork는 리소스일 수 있으므로 루프를 통해 배열로 변환
        // todolist_status.php에서 이미 쿼리가 실행된 상태라고 가정
        // sqlsrv_query 결과는 한 번만 순회 가능하므로 여기서 순회하며 저장
        while ($row = sqlsrv_fetch_array($Result_NotWork, SQLSRV_FETCH_ASSOC)) {
            // 날짜 객체 처리
            $row['SORTING_DATE_STR'] = ($row['SORTING_DATE'] instanceof DateTime) ? $row['SORTING_DATE']->format('Y-m-d') : $row['SORTING_DATE'];

            // 검색 필터링 (Tab 2 활성화 시)
            if ($search_keyword && strpos($tab2_text, 'active') !== false) {
                if (strpos($row['REQUESTOR'], $search_keyword) !== false || 
                    strpos($row['PROBLEM'], $search_keyword) !== false ||
                    strpos($row['SOLUTUIN'], $search_keyword) !== false ||
                    strpos($row['KIND'], $search_keyword) !== false) {
                    $not_work_list[] = $row;
                }
            } else {
                $not_work_list[] = $row;
            }
        }
    }

    // [Tab 3] 처리내역 데이터 처리 (배열 필터링)
    $history_list = [];
    // todolist_status.php에서 $Data_WorkHistory 배열을 생성해 둠
    if (isset($Data_WorkHistory) && is_array($Data_WorkHistory)) {
        foreach ($Data_WorkHistory as $row) {
            $row['SORTING_DATE_STR'] = ($row['SORTING_DATE'] instanceof DateTime) ? $row['SORTING_DATE']->format('Y-m-d') : $row['SORTING_DATE'];

            if ($search_keyword && strpos($tab3_text, 'active') !== false) {
                if (strpos($row['REQUESTOR'], $search_keyword) !== false || 
                    strpos($row['PROBLEM'], $search_keyword) !== false ||
                    strpos($row['SOLUTUIN'], $search_keyword) !== false ||
                    strpos($row['KIND'], $search_keyword) !== false) {
                    $history_list[] = $row;
                }
            } else {
                $history_list[] = $row;
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>      

    <style>
        /* 모바일 검색창 스타일 */
        .mobile-search-input {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 0;
            background-color: #ffffff !important;
            color: #495057;
            border: 1px solid #d1d3e2;
        }
        .mobile-search-input::placeholder {
            color: #858796;
        }
        .mobile-search-btn {
            width: 60px;
            border-radius: 0;
        }

        /* 모바일 화면 전용 스타일 */
        @media screen and (max-width: 768px) {
            
            /* DataTables 컨트롤 숨김 */
            .dt-buttons, 
            .dataTables_filter, 
            .dataTables_length,
            .dataTables_paginate .page-item {
                display: none !important;
            }
            /* 페이징 버튼 일부만 표시 */
            .dataTables_paginate .page-item.previous,
            .dataTables_paginate .page-item.next,
            .dataTables_paginate .page-item.active {
                display: block !important;
            }
            .dataTables_paginate ul.pagination {
                justify-content: center !important;
                margin-top: 10px;
            }

            /* 테이블 카드 뷰 변환 */
            .mobile-responsive-table thead {
                display: none;
            }
            .mobile-responsive-table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #fff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .mobile-responsive-table td {
                display: block;
                text-align: right;
                font-size: 0.9rem;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                padding-top: 10px;
                padding-bottom: 10px;
                
                /* 텍스트 줄바꿈 */
                white-space: normal !important; 
                word-break: break-word;
            }
            .mobile-responsive-table td:last-child {
                border-bottom: 0;
            }
            .mobile-responsive-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                font-weight: 700;
                text-align: left;
                color: #4e73df;
            }

            /* 데이터 없음 행 스타일 (중앙 정렬) */
            .mobile-responsive-table td.no-data {
                text-align: center !important;
                padding-left: 0.75rem !important;
                color: #858796;
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
            .mobile-responsive-table td.no-data::before {
                content: none !important;
            }
        }
    </style>
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">기술지원요청(장애처리현황)</h1>
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
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">기록</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3);?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th" role="tab" aria-controls="custom-tabs-one-1th" aria-selected="false">내역</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-3" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 기술지원요청 게시판 제작<BR><BR>
                                            [제작일]<BR>
                                            - 22.05.04<br><br> 
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h6 class="m-0 font-weight-bold text-primary">입력</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="todolist.php" enctype="multipart/form-data"> 
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body p-3">
                                                            <div class="row">   
                                                                <div class="col-md-4 col-12 mb-2">
                                                                    <div class="form-group mb-0"><label>요청자</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="text" class="form-control" name="requestor21" required></div></div>
                                                                </div>
                                                                <div class="col-md-4 col-6 mb-2">
                                                                    <div class="form-group mb-0"><label>종류</label><select name="kind21" class="form-control select2" style="width: 100%;"><option value="ERP" selected>ERP</option><option value="GW">GW</option><option value="NAS">NAS</option><option value="FMS">FMS</option><option value="TMS">TMS</option><option value="PDM">PDM</option><option value="WEB">WEB</option><option value="서버">서버</option><option value="개발">개발</option><option value="N/W">N/W</option><option value="H/W">H/W</option><option value="S/W">S/W</option><option value="ETC">ETC</option></select></div>
                                                                </div>
                                                                <div class="col-md-4 col-6 mb-2">
                                                                    <div class="form-group mb-0"><label>중요도</label><select name="IMPORTANCE21" class="form-control select2" style="width: 100%;"><option value="하" selected>하</option><option value="중">중</option><option value="상">상</option></select></div>
                                                                </div>
                                                                <div class="col-md-6 col-12 mb-2">
                                                                    <div class="form-group mb-0"><label>내용</label><div class="input-group"><textarea rows="8" class="form-control" name="problem21" required></textarea></div></div>
                                                                </div>
                                                                <div class="col-md-6 col-12 mb-2">
                                                                    <div class="form-group mb-0"><label>해결책</label><div class="input-group"><textarea rows="8" class="form-control" name="solution21"></textarea></div></div>
                                                                </div>
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group mb-0"><label>첨부파일</label><div class="custom-file"><input type="file" class="custom-file-input" id="file" name="file"><label class="custom-file-label" for="file">파일선택</label></div></div>
                                                                </div>                                 
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div>

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h6 class="m-0 font-weight-bold text-primary">처리현황</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="todolist.php"> 
                                                    <div class="collapse show" id="collapseCardExample22">
                                                        <div class="card-body table-responsive p-2">   
                                                            <?php ModifyData2("todolist.php?modi=Y", "bt22", "Todolist"); ?>

                                                            <div class="d-block d-md-none mb-3 mt-2">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="요청자/내용 검색" value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit"><i class="fas fa-search"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped mobile-responsive-table" id="table_nosort">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>NO</th>
                                                                            <th>요청자</th>
                                                                            <th>종류</th>
                                                                            <th>중요도</th>   
                                                                            <th>내용</th>  
                                                                            <th>답변</th>  
                                                                            <th>요청일</th> 
                                                                            <th>처리현황</th> 
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $i = 1;
                                                                            foreach ($not_work_list as $Data_NotWork):
                                                                        ?>
                                                                        <tr>
                                                                            <input name='solve_no<?php echo $i; ?>' value='<?php echo h($Data_NotWork['NO']); ?>' type='hidden'>   
                                                                            <td data-label="NO"><?php echo h($Data_NotWork['NO']); ?></td>
                                                                            <td data-label="요청자"><?php echo h($Data_NotWork['REQUESTOR']); ?></td>
                                                                            <td data-label="종류"><?php echo h($Data_NotWork['KIND']); ?></td>
                                                                            <td data-label="중요도"><?php echo h($Data_NotWork['IMPORTANCE']); ?></td>
                                                                            <td data-label="내용"><?php echo $Data_NotWork['PROBLEM']; // HTML 허용 ?></td>
                                                                            <td data-label="답변">
                                                                                <?php if($modi=='Y') { ?> 
                                                                                    <textarea rows='3' class='form-control' name='SOLUTUIN<?php echo $i; ?>'><?php echo h($Data_NotWork['SOLUTUIN']); ?></textarea> 
                                                                                <?php } else { echo $Data_NotWork['SOLUTUIN']; } ?>
                                                                            </td>
                                                                            <td data-label="요청일"><?php echo h($Data_NotWork['SORTING_DATE_STR']); ?></td>
                                                                            <td data-label="처리현황">
                                                                            <?php 
                                                                                if($modi=='Y') { 
                                                                                    $selectedN = ($Data_NotWork['SOLVE']=='N') ? 'selected' : '';
                                                                                    $selectedY = ($Data_NotWork['SOLVE']=='Y') ? 'selected' : '';
                                                                            ?> 
                                                                                    <select name="SOLVE_STATUS<?php echo $i; ?>" class="form-control select2" style="width: 100%;">
                                                                                        <option value="N" <?php echo $selectedN; ?>>N</option>
                                                                                        <option value="Y" <?php echo $selectedY; ?>>Y</option>                                                                                                
                                                                                    </select> 
                                                                            <?php 
                                                                                } else {
                                                                                    echo h($Data_NotWork['SOLVE']);
                                                                                } 
                                                                            ?>
                                                                            </td> 
                                                                        </tr> 
                                                                        <?php 
                                                                                $i++;
                                                                            endforeach;
                                                                        ?>    
                                                                        <?php if(empty($not_work_list)): ?>
                                                                            <tr><td colspan="8" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                        <?php endif; ?>            
                                                                    </tbody>
                                                                </table>
                                                            </div>  
                                                            <input type="hidden" name="until" value="<?php echo $i; ?>">
                                                        </div>
                                                    </div>
                                                </form> 
                                            </div>                                            
                                        </div>  

                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="todolist.php"> 
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
                                                    <h6 class="m-0 font-weight-bold text-primary">결과</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample32">
                                                    <div class="card-body table-responsive p-2">
                                                        
                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="POST" action="todolist.php">
                                                                <input type="hidden" name="bt31" value="on">
                                                                <input type="hidden" name="dt3" value="<?php echo h($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="요청자/내용 검색" value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit"><i class="fas fa-search"></i></button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <table class="table table-bordered table-hover text-nowrap mobile-responsive-table" id="table3">
                                                            <thead>
                                                                <tr>
                                                                    <th>NO</th>
                                                                    <th>요청자</th>
                                                                    <th>종류</th>
                                                                    <th>중요도</th>   
                                                                    <th>내용</th>  
                                                                    <th>답변</th>  
                                                                    <th>요청일</th> 
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($history_list as $WorkHistory): ?>
                                                                    <tr>
                                                                        <td data-label="NO"><?php echo h($WorkHistory['NO']); ?></td>
                                                                        <td data-label="요청자"><?php echo h($WorkHistory['REQUESTOR']); ?></td>
                                                                        <td data-label="종류"><?php echo h($WorkHistory['KIND']); ?></td>
                                                                        <td data-label="중요도"><?php echo h($WorkHistory['IMPORTANCE']); ?></td>
                                                                        <td data-label="내용"><?php echo $WorkHistory['PROBLEM']; ?></td>
                                                                        <td data-label="답변"><?php echo $WorkHistory['SOLUTUIN']; ?></td>
                                                                        <td data-label="요청일"><?php echo h($WorkHistory['SORTING_DATE_STR']); ?></td>
                                                                    </tr>                                                       
                                                                <?php endforeach; ?>     
                                                                <?php if(empty($history_list)): ?>
                                                                    <tr><td colspan="7" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                <?php endif; ?>
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
                    
                    </div> </div> </div> </div> </div> <?php include '../plugin_lv1.php'; ?> 

    <script>
    $(document).ready(function() {
        // 모바일 기기 감지 및 Select2 해제 (스크롤 튐 방지)
        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth <= 768;
        if (isMobile) {
            $('.select2').each(function() {
                if ($.fn.select2 && $(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2('destroy');
                }
                $(this).removeClass('select2');
            });
        }
    });
    </script>
</body>
</html>

<?php 
    //메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }	
    if(isset($connect)) { sqlsrv_close($connect); }	
?>