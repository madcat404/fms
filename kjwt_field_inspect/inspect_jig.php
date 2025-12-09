<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.23>
	// Description:	<지그 리뉴얼 - 대시보드 카드 필터링 기능 추가>	
    // Last Modified: <25.10.13>
	// =============================================
    
    // 로직 파일 포함
    include 'inspect_jig_status.php';

    // XSS 방지 및 데이터 전처리
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 파라미터 받기 (검색어, 필터상태)
    $search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : '';
    $filter_status  = isset($_GET['filter_status']) ? $_GET['filter_status'] : ''; // red, orange, or empty

    // [Tab 2] 지그 현황 데이터 배열 저장 및 필터링 적용
    $jig_list = [];
    if (isset($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $limit = $row['LIMIT_QTY'] ?? 0;
            $current = $row['CURRENT_QTY'] ?? 0;
            
            // 1. 상태 필터링 (카드 클릭 시)
            $is_included = true;
            if ($filter_status === 'red') {
                // 점검필요 (Red): 현재값 >= 기준값
                if ($current < $limit) $is_included = false;
            } elseif ($filter_status === 'orange') {
                // 점검도래 (Orange): 80% 이상 ~ 100% 미만 (Red 제외)
                if ($current < ($limit * 0.8) || $current >= $limit) $is_included = false;
            }

            // 2. 검색어 필터링 (AND 조건)
            if ($is_included && $search_keyword) {
                if (strpos($row['JIG_ID'], $search_keyword) === false && 
                    strpos($row['JIG_SEQ'], $search_keyword) === false) {
                    $is_included = false;
                }
            }

            // 조건 만족 시 리스트에 추가
            if ($is_included) {
                $jig_list[] = $row;
            }
        }
    }

    // [Tab 3] 지그 변경 이력 데이터 배열 저장 및 검색 필터링
    $history_list = [];
    if (isset($result_out)) {
        while ($row_out = sqlsrv_fetch_array($result_out, SQLSRV_FETCH_ASSOC)) {
            if ($search_keyword) {
                if (strpos($row_out['JIG_ID'], $search_keyword) !== false || 
                    strpos($row_out['JIG_SEQ'], $search_keyword) !== false ||
                    strpos($row_out['NOTE'], $search_keyword) !== false ||
                    strpos($row_out['UPDT_USER_ID'], $search_keyword) !== false) {
                    $history_list[] = $row_out;
                }
            } else {
                $history_list[] = $row_out;
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

        /* 카드에 클릭 커서 표시 */
        .clickable-card {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .clickable-card:hover {
            transform: scale(1.02);
        }

        /* 모바일 화면 전용 스타일 */
        @media screen and (max-width: 768px) {
            
            /* DataTables 하단 페이지 번호 간소화 */
            .dataTables_paginate .page-item {
                display: none !important;
            }
            .dataTables_paginate .page-item.previous,
            .dataTables_paginate .page-item.next,
            .dataTables_paginate .page-item.active {
                display: block !important;
            }
            .dataTables_paginate ul.pagination {
                justify-content: center !important;
                margin-top: 10px;
            }

            /* DataTables 버튼 및 기능 숨김 */
            .dt-buttons, 
            .dataTables_filter, 
            .dataTables_length {
                display: none !important;
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">지그</h1>
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
                                            <a class="nav-link <?php echo h($tab2 ?? ''); ?>" id="tab-two" data-toggle="pill" href="#tab2">지그</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3 ?? ''); ?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">지그변경이력</a>
                                        </li>                                          
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 지그 변경 및 이력관리 전산화<BR><BR>   

                                            [기능]<br>
                                            1. 지그탭<br>
                                            - [등록] 중복 지그가 있는 경우 '중복 지그가 있습니다! 다시 등록하세요!' 팝업창 생성<BR>   
                                            - [현황] 점검 현재값이 기준값에 80% 이상인 경우 현재값 셀을 주황색으로 표현<BR>   
                                            - [현황] 점검 현재값이 기준값보다 큰 경우 현재값 셀을 빨간색으로 표현<BR><BR>                                   
                                                                                 
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 검수반, 품질팀<br>      
                                            - 누적값: 지금까지 사용한 값<br>
                                            - 등록일: 지그 최초 등록날짜<br>
                                            - 사용일: 지그 사용 최종날짜<br>
                                            - 주황색: 점검도래<br>
                                            - 빨간색: 점검필요<br><br> 
                                            
                                            [제작일]<BR>
                                            - 21.11.23<br><br>                                              
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab2_text ?? ''); ?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h6 class="m-0 font-weight-bold text-primary">등록</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="inspect_jig.php"> 
                                                    <div class="collapse" id="collapseCardExample21">                                    
                                                        <div class="card-body p-3">
                                                            <div class="row"> 
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>지그ID</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-car"></i></span></div>
                                                                            <input type="text" class="form-control" name="jigid21" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>지그번호</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div>
                                                                            <input type="text" class="form-control" name="jignum21" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>점검기준값</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div>
                                                                            <input type="text" class="form-control" name="val21" value="10000" required onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                        </div>
                                                                    </div>
                                                                </div>                                              
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                        </div>
                                                    </div>   
                                                </form>             
                                            </div>

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h6 class="m-0 font-weight-bold text-primary">현황</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample22">
                                                    <div class="card-body p-2">
                                                        
                                                        <div class="row">
                                                            <div class="col-xl-4 col-md-6 mb-2">
                                                                <div class="card border-left-info shadow h-100 py-2 clickable-card" onclick="location.href='inspect_jig.php?tab=tab2'">
                                                                    <div class="card-body">
                                                                        <div class="row no-gutters align-items-center">
                                                                            <div class="col mr-2">
                                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">지그수량 (전체)</div>
                                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($c_JigCount ?? '0'); ?></div>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-4 col-md-6 mb-2">
                                                                <div class="card border-left-danger shadow h-100 py-2 clickable-card" onclick="location.href='inspect_jig.php?tab=tab2&filter_status=red'">
                                                                    <div class="card-body">
                                                                        <div class="row no-gutters align-items-center">
                                                                            <div class="col mr-2">
                                                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">점검필요</div>
                                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($c_JigInspectNeed ?? '0'); ?></div>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-4 col-md-6 mb-2">
                                                                <div class="card border-left-warning shadow h-100 py-2 clickable-card" onclick="location.href='inspect_jig.php?tab=tab2&filter_status=orange'">
                                                                    <div class="card-body">
                                                                        <div class="row no-gutters align-items-center">
                                                                            <div class="col mr-2">
                                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">점검도래</div>
                                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($c_JigInspectSoon ?? '0'); ?></div>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 d-block d-md-none mb-3 mt-2">
                                                                <form method="GET" action="inspect_jig.php">
                                                                    <?php if($filter_status): ?>
                                                                        <input type="hidden" name="filter_status" value="<?php echo h($filter_status); ?>">
                                                                    <?php endif; ?>
                                                                    <div class="input-group shadow-sm">
                                                                        <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="지그ID/번호 검색" value="<?= h($search_keyword) ?>">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-primary mobile-search-btn" type="submit">
                                                                                <i class="fas fa-search"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div id="table" class="table-editable mt-1">
                                                            <table class="table table-bordered table-striped mobile-responsive-table" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>지그ID</th>
                                                                        <th>지그번호</th>
                                                                        <th>점검 기준값</th>
                                                                        <th>현재값</th>
                                                                        <th>누적값</th>
                                                                        <th>등록자</th>
                                                                        <th>둥록일</th>
                                                                        <th>사용자</th>
                                                                        <th>사용일</th>
                                                                        <th>변경자</th>
                                                                        <th>변경일</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($jig_list as $row): 
                                                                        $limit = $row['LIMIT_QTY'] ?? 0;
                                                                        $current = $row['CURRENT_QTY'] ?? 0;
                                                                        $qtyStyle = ''; 

                                                                        if ($limit > 0) {
                                                                            if($current >= $limit) {
                                                                                $qtyStyle = 'background-color: red; color: white;';
                                                                            }
                                                                            elseif($current >= ($limit * 0.8)) {
                                                                                $qtyStyle = 'background-color: orange; color: black;';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <tr data-toggle="modal" data-target="#editJigModal"
                                                                        data-jig-id="<?php echo h($row['JIG_ID']); ?>"
                                                                        data-jig-seq="<?php echo h($row['JIG_SEQ']); ?>"
                                                                        data-limit-qty="<?php echo h($row['LIMIT_QTY']); ?>"
                                                                        data-current-qty="<?php echo h($row['CURRENT_QTY']); ?>"
                                                                        data-total-qty="<?php echo h($row['TOTAL_QTY']); ?>"
                                                                        style="cursor: pointer;" onMouseOver="this.style.backgroundColor='#ffedbf';" onMouseOut="this.style.backgroundColor='';">
                                                                        
                                                                        <td data-label="지그ID"><?php echo h($row['JIG_ID']); ?></td>
                                                                        <td data-label="지그번호"><?php echo h($row['JIG_SEQ']); ?></td>
                                                                        <td data-label="점검 기준값"><?php echo h($row['LIMIT_QTY']); ?></td>
                                                                        <td data-label="현재값" style="<?php echo $qtyStyle; ?>"><?php echo h($row['CURRENT_QTY']); ?></td>
                                                                        <td data-label="누적값"><?php echo h($row['TOTAL_QTY']); ?></td>
                                                                        <td data-label="등록자"><?php echo h($row['INSRT_USER_ID']); ?></td>
                                                                        <td data-label="둥록일"><?php echo h(is_object($row['INSRT_DT']) ? $row['INSRT_DT']->format('Y-m-d') : $row['INSRT_DT']); ?></td>
                                                                        <td data-label="사용자"><?php echo h($row['UPDT_USER_ID']); ?></td>
                                                                        <td data-label="사용일"><?php echo h(is_object($row['UPDT_DT']) ? $row['UPDT_DT']->format('Y-m-d') : $row['UPDT_DT']); ?></td>
                                                                        <td data-label="변경자"><?php echo h($row['LAST_UPDATE_USER']); ?></td> 
                                                                        <td data-label="변경일"><?php echo h(is_object($row['LAST_UPDATE_DATE']) ? $row['LAST_UPDATE_DATE']->format('Y-m-d') : $row['LAST_UPDATE_DATE']); ?></td>                                   
                                                                    </tr> 
                                                                    <?php endforeach; ?>
                                                                    <?php if(empty($jig_list)): ?>
                                                                        <tr>
                                                                            <td colspan="11" class="text-center no-data">데이터가 없습니다.</td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>                                     
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="tab-pane fade <?php echo h($tab3_text ?? ''); ?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            
                                            <div class="card shadow mb-2"> 
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="inspect_jig.php"> 
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

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                    <h6 class="m-0 font-weight-bold text-primary">결과</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample32">
                                                    <div class="card-body table-responsive p-2">

                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="GET" action="inspect_jig.php">
                                                                <input type="hidden" name="tab" value="history"> 
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="지그ID/번호/내용 검색" value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <table class="table table-bordered table-striped mobile-responsive-table" id="table3">
                                                            <thead>
                                                                <tr>
                                                                    <th>지그ID</th>
                                                                    <th>지그번호</th>
                                                                    <th>사용횟수</th>
                                                                    <th>조치사항</th>
                                                                    <th>내용</th>
                                                                    <th>담당자</th>
                                                                    <th>변경일</th>
                                                                    <th>기록일</th>   
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($history_list as $row_out): ?>
                                                                <tr>
                                                                    <td data-label="지그ID"><?php echo h($row_out['JIG_ID']); ?></td>
                                                                    <td data-label="지그번호"><?php echo h($row_out['JIG_SEQ']); ?></td>                               
                                                                    <td data-label="사용횟수"><?php echo h($row_out['USAGE_COUNT']); ?></td>
                                                                    <td data-label="조치사항"><?php echo h($row_out['JUDGMENT']); ?></td>
                                                                    <td data-label="내용"><?php echo h($row_out['NOTE']); ?></td>
                                                                    <td data-label="담당자"><?php echo h($row_out['UPDT_USER_ID']); ?></td>
                                                                    <td data-label="변경일"><?php echo h(is_object($row_out['UPDT_DT']) ? $row_out['UPDT_DT']->format('Y-m-d') : $row_out['UPDT_DT']); ?></td>
                                                                    <td data-label="기록일"><?php echo h(is_object($row_out['INSERT_DT']) ? $row_out['INSERT_DT']->format('Y-m-d') : $row_out['INSERT_DT']); ?></td>
                                                                </tr> 
                                                                <?php endforeach; ?>
                                                                <?php if(empty($history_list)): ?>
                                                                    <tr>
                                                                        <td colspan="8" class="text-center no-data">데이터가 없습니다.</td>
                                                                    </tr>
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
                    
                    </div> </div> </div> </div> </div> <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="editJigModal" tabindex="-1" role="dialog" aria-labelledby="editJigModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJigModalLabel">지그 점검/교체</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" autocomplete="off" action="inspect_jig.php">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>지그ID</label>
                                <input name="NM1" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>지그번호</label>
                                <input name="NM2" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>기준값</label>
                                <input name="QTY1" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>현재값</label>
                                <input name="QTY2" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>누적값</label>
                                <input name="QTY3" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>조치사항</label>
                                <select name="JUDGMENT" class="form-control">
                                    <option value="CHECK" selected="selected">점검</option>
                                    <option value="CHANGE">교체</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>변경일</label>
                                <input type="date" name="DT" id="modal_dt" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>내용</label>
                                <input name="NOTE" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                        <button type="submit" name="bt_modify" value="on" class="btn btn-primary">입력</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../plugin_lv1.php'; ?>

    <script>
    $(document).ready(function() {
        
        // 검색 실행 시 탭 유지
        var searchParam = new URLSearchParams(window.location.search).get('search_keyword');
        var tabParam = new URLSearchParams(window.location.search).get('tab');
        var filterParam = new URLSearchParams(window.location.search).get('filter_status');
        
        // 검색어, 필터, 탭 파라미터가 있으면 탭 유지 로직 실행
        if (searchParam || filterParam || tabParam) {
            if (tabParam === 'history') {
                $('#custom-tabs-one-1th-tab').tab('show');
            } else {
                $('#tab-two').tab('show');
            }
        }

        // 모달 데이터 바인딩
        $('#editJigModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            
            var jigId = button.data('jig-id');
            var jigSeq = button.data('jig-seq');
            var limitQty = button.data('limit-qty');
            var currentQty = button.data('current-qty');
            var totalQty = button.data('total-qty');

            var modal = $(this);
            modal.find('.modal-body input[name="NM1"]').val(jigId);
            modal.find('.modal-body input[name="NM2"]').val(jigSeq);
            modal.find('.modal-body input[name="QTY1"]').val(limitQty);
            modal.find('.modal-body input[name="QTY2"]').val(currentQty);
            modal.find('.modal-body input[name="QTY3"]').val(totalQty);

            // 오늘 날짜 기본 설정
            document.getElementById('modal_dt').valueAsDate = new Date();
        });
    });
    </script>

</body>
</html>

<?php 
    // DB 자원 해제
    if(isset($connect4)) { mysqli_close($connect4); }	
    if(isset($connect)) { sqlsrv_close($connect); }	
?>