<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.23>
	// Description:	<베트남 지그 리뉴얼 - 모바일 최적화 적용>	
    // Last Modified: <25.10.13>
	// =============================================
    
    // 로직 파일 포함
    include 'inspect_jig_v_status.php';

    // XSS 방지 및 데이터 전처리
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 파라미터 받기 (검색어, 필터상태)
    $search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : '';
    $filter_status  = isset($_GET['filter_status']) ? $_GET['filter_status'] : ''; // red, orange

    // [Tab 2] JIG 현황 데이터 배열 저장 및 필터링
    $jig_list = [];
    if (isset($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $limit = $row['LIMIT_QTY'] ?? 0;
            $current = $row['CURRENT_QTY'] ?? 0;
            
            // 1. 상태 필터링 (카드 클릭 시)
            $is_included = true;
            if ($filter_status === 'red') {
                // Nguy hiểm (Red): 현재값 >= 기준값
                if ($current < $limit) $is_included = false;
            } elseif ($filter_status === 'orange') {
                // Cảnh báo (Orange): 80% 이상 ~ 100% 미만 (Red 제외)
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

    // [Tab 3] 기록(Ghi lại) 데이터 배열 저장 및 검색 필터링
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">JIG</h1>
                    </div>               

                    <div class="row"> 

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">LƯU Ý</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">JIG</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3);?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">ghi lại</a>
                                        </li>   
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            
                                        </div>
                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                    <h6 class="m-0 font-weight-bold text-primary">Trạng thái</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample32">
                                                    <div class="card-body p-2">
                                                        <div class="row">
                                                            <div class="col-xl-4 col-md-6 mb-2">
                                                                <div class="card border-left-danger shadow h-100 py-2 clickable-card" onclick="location.href='inspect_jig_v.php?tab=tab2&filter_status=red'">
                                                                    <div class="card-body">
                                                                        <div class="row no-gutters align-items-center">
                                                                            <div class="col mr-2">
                                                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">sự nguy hiểm</div>
                                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($c_JigInspectNeed); ?></div>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-4 col-md-6 mb-2">
                                                                <div class="card border-left-warning shadow h-100 py-2 clickable-card" onclick="location.href='inspect_jig_v.php?tab=tab2&filter_status=orange'">
                                                                    <div class="card-body">
                                                                        <div class="row no-gutters align-items-center">
                                                                            <div class="col mr-2">
                                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">cảnh báo</div>
                                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($c_JigInspectSoon); ?></div>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 d-block d-md-none mb-3 mt-2">
                                                                <form method="GET" action="inspect_jig_v.php">
                                                                    <?php if($filter_status): ?>
                                                                        <input type="hidden" name="filter_status" value="<?php echo h($filter_status); ?>">
                                                                    <?php endif; ?>
                                                                    <div class="input-group shadow-sm">
                                                                        <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="Tìm kiếm (ID, SEQ)" value="<?= h($search_keyword) ?>">
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
                                                                        <th>JIG_ID</th>
                                                                        <th>JIG_SEQ</th>
                                                                        <th>LIMIT_QTY</th>
                                                                        <th>CURRENT_QTY</th>
                                                                        <th>TOTAL_QTY</th>
                                                                        <th>REGISTRANT</th>
                                                                        <th>REG_DATE</th>
                                                                        <th>USER</th>
                                                                        <th>USE_DATE</th>
                                                                        <th>MODIFIER</th>
                                                                        <th>MOD_DATE</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($jig_list as $row): 
                                                                        $limit = $row['LIMIT_QTY'] ?? 0;
                                                                        $current = $row['CURRENT_QTY'] ?? 0;
                                                                        $qtyStyle = ''; 

                                                                        if ($limit > 0) {
                                                                            if($current >= $limit) {
                                                                                $qtyStyle = 'background-color: red; color: white; font-weight: bold;';
                                                                            }
                                                                            elseif($current >= ($limit * 0.8)) {
                                                                                $qtyStyle = 'background-color: orange; color: black; font-weight: bold;';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <tr data-toggle="modal" data-target="#editJigModalV"
                                                                        data-jig-id="<?php echo h($row['JIG_ID']); ?>"
                                                                        data-jig-seq="<?php echo h($row['JIG_SEQ']); ?>"
                                                                        data-limit-qty="<?php echo h($row['LIMIT_QTY']); ?>"
                                                                        data-current-qty="<?php echo h($row['CURRENT_QTY']); ?>"
                                                                        data-total-qty="<?php echo h($row['TOTAL_QTY']); ?>"
                                                                        style="cursor: pointer;" onMouseOver="this.style.backgroundColor='#ffedbf';" onMouseOut="this.style.backgroundColor='';">
                                                                        
                                                                        <td data-label="JIG_ID"><?php echo h($row['JIG_ID']); ?></td>
                                                                        <td data-label="JIG_SEQ"><?php echo h($row['JIG_SEQ']); ?></td>
                                                                        <td data-label="LIMIT_QTY"><?php echo h($row['LIMIT_QTY']); ?></td>
                                                                        <td data-label="CURRENT_QTY" style="<?php echo $qtyStyle; ?>"><?php echo h($row['CURRENT_QTY']); ?></td>
                                                                        <td data-label="TOTAL_QTY"><?php echo h($row['TOTAL_QTY']); ?></td>
                                                                        <td data-label="REGISTRANT"><?php echo h($row['INSRT_USER_ID']); ?></td>
                                                                        <td data-label="REG_DATE"><?php echo h(is_object($row['INSRT_DT']) ? $row['INSRT_DT']->format('Y-m-d') : $row['INSRT_DT']); ?></td>
                                                                        <td data-label="USER"><?php echo h($row['UPDT_USER_ID']); ?></td>
                                                                        <td data-label="USE_DATE"><?php echo h(is_object($row['UPDT_DT']) ? $row['UPDT_DT']->format('Y-m-d') : $row['UPDT_DT']); ?></td>
                                                                        <td data-label="MODIFIER"><?php echo h($row['LAST_UPDATE_USER']); ?></td> 
                                                                        <td data-label="MOD_DATE"><?php echo h(is_object($row['LAST_UPDATE_DATE']) ? $row['LAST_UPDATE_DATE']->format('Y-m-d') : $row['LAST_UPDATE_DATE']); ?></td>                                   
                                                                    </tr> 
                                                                    <?php endforeach; ?>
                                                                    <?php if(empty($jig_list)): ?>
                                                                        <tr>
                                                                            <td colspan="11" class="text-center no-data">Không có dữ liệu (No Data)</td>
                                                                        </tr>
                                                                    <?php endif; ?>  
                                                                </tbody>
                                                            </table>
                                                        </div>                                     
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>  

                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h6 class="m-0 font-weight-bold text-primary">Tìm kiếm</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="inspect_jig_v.php"> 
                                                    <div class="collapse show" id="collapseCardExample31">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>phạm vi</label>
                                                                <div class="input-group">                                                
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt3">
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt31">Tìm kiếm</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>  

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                    <h6 class="m-0 font-weight-bold text-primary">ghi lại</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample32">
                                                    <div class="card-body table-responsive p-2">
                                                        
                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="GET" action="inspect_jig_v.php">
                                                                <input type="hidden" name="tab" value="history"> 
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="Tìm kiếm..." value="<?= h($search_keyword) ?>">
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
                                                                    <th>JIG_ID</th>
                                                                    <th>JIG_SEQ</th>
                                                                    <th>USAGE_COUNT</th>
                                                                    <th>JUDGMENT</th>
                                                                    <th>NOTE</th>
                                                                    <th>ADMINISTRATOR</th>
                                                                    <th>CHANGE_DATE</th>
                                                                    <th>RECORD_DATE</th>   
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($history_list as $row_out): ?>
                                                                <tr>
                                                                    <td data-label="JIG_ID"><?php echo h($row_out['JIG_ID']); ?></td>
                                                                    <td data-label="JIG_SEQ"><?php echo h($row_out['JIG_SEQ']); ?></td>                               
                                                                    <td data-label="USAGE_COUNT"><?php echo h($row_out['USAGE_COUNT']); ?></td>
                                                                    <td data-label="JUDGMENT"><?php echo h($row_out['JUDGMENT']); ?></td>
                                                                    <td data-label="NOTE"><?php echo h($row_out['NOTE']); ?></td>
                                                                    <td data-label="ADMINISTRATOR"><?php echo h($row_out['UPDT_USER_ID']); ?></td>
                                                                    <td data-label="CHANGE_DATE"><?php echo h(is_object($row_out['UPDT_DT']) ? $row_out['UPDT_DT']->format('Y-m-d') : $row_out['UPDT_DT']); ?></td>
                                                                    <td data-label="RECORD_DATE"><?php echo h(is_object($row_out['INSERT_DT']) ? $row_out['INSERT_DT']->format('Y-m-d') : $row_out['INSERT_DT']); ?></td>
                                                                </tr> 
                                                                <?php endforeach; ?>
                                                                <?php if(empty($history_list)): ?>
                                                                    <tr>
                                                                        <td colspan="8" class="text-center no-data">Không có dữ liệu (No Data)</td>
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

    <div class="modal fade" id="editJigModalV" tabindex="-1" role="dialog" aria-labelledby="editJigModalLabelV" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJigModalLabelV">CHECK JIG</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" autocomplete="off" action="inspect_jig_v.php">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-6 col-md-4">
                                <label>JIG_ID</label>
                                <input name="NM1" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-6 col-md-4">
                                <label>JIG_SEQ</label>
                                <input name="NM2" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label>LIMIT_QTY</label>
                                <input name="QTY1" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>CURRENT_QTY</label>
                                <input name="QTY2" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label>TOTAL_QTY</label>
                                <input name="QTY3" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-12 col-md-4">
                                <label>JUDGMENT</label>
                                <select name="JUDGMENT" class="form-control">
                                    <option value="CHECK" selected="selected">KIỂM TRA</option>
                                    <option value="CHANGE">THAY ĐỔI</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label>MODIFICATION_DATE</label>
                                <input type="date" name="DT" id="modal_dt_v" class="form-control" required>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label>NOTE</label>
                                <input name="NOTE" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" name="bt_modify" value="on" class="btn btn-primary">ĐẦU VÀO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../plugin_lv1.php'; ?>

    <script>
    $(document).ready(function() {
        
        // 검색/필터 실행 시 탭 유지
        var searchParam = new URLSearchParams(window.location.search).get('search_keyword');
        var tabParam = new URLSearchParams(window.location.search).get('tab');
        var filterParam = new URLSearchParams(window.location.search).get('filter_status');
        
        if (searchParam || filterParam || tabParam) {
            if (tabParam === 'history') {
                $('#custom-tabs-one-1th-tab').tab('show');
            } else {
                $('#tab-two').tab('show');
            }
        }

        // 모달 데이터 바인딩
        $('#editJigModalV').on('show.bs.modal', function (event) {
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
            document.getElementById('modal_dt_v').valueAsDate = new Date();
        });
    });
    </script>

</body>
</html>

<?php 
    //메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>