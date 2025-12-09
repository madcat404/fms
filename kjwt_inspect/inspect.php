<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.11.14>
	// Description:	<발열검사기 뷰어 - 모바일 최적화 및 여백 수정>
	// =============================================
    include 'inspect_status.php';

    // XSS 방지 및 데이터 전처리
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 탭 활성화 안전장치
    $tab2 = $tab2 ?? '';
    $tab2_text = $tab2_text ?? '';

    // 기본적으로 탭2(목록) 활성화
    if (empty($tab2_text)) {
        $tab2 = 'active';
        $tab2_text = 'show active';
    }

    // 검색어 파라미터
    $search_keyword = $_REQUEST['search_keyword'] ?? '';

    // [Tab 2] 목록 데이터 처리 (배열 저장 및 필터링)
    $inspect_list = [];
    if (isset($Result_inspect)) {
        while ($row = sqlsrv_fetch_array($Result_inspect, SQLSRV_FETCH_ASSOC)) {
            // 날짜 객체 처리
            $row['LOT_DATE_STR'] = ($row['LOT_DATE'] instanceof DateTime) ? $row['LOT_DATE']->format('Y-m-d') : $row['LOT_DATE'];
            $row['INSERT_DT_STR'] = ($row['INSERT_DT'] instanceof DateTime) ? $row['INSERT_DT']->format('Y-m-d H:i:s') : $row['INSERT_DT'];

            // 검색 필터링
            if ($search_keyword) {
                if (strpos($row['CD_ITEM'], $search_keyword) !== false || 
                    strpos($row['CD_MATL'], $search_keyword) !== false ||
                    strpos($row['LOT_DATE_STR'], $search_keyword) !== false) {
                    $inspect_list[] = $row;
                }
            } else {
                $inspect_list[] = $row;
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">발열검사기</h1>
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
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            </div>

                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h6 class="m-0 font-weight-bold text-primary">로그</h6>
                                                </a>
                                                
                                                <div class="collapse show" id="collapseCardExample21">
                                                    <div class="card-body table-responsive p-2"> 
                                                        
                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="POST" action="inspect.php">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="품번/자재/로트 검색" value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <div id="table" class="table-editable">
                                                            <table class="table table-bordered table-striped mobile-responsive-table" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>품번</th>
                                                                        <th>로트날짜</th>
                                                                        <th>자재품번</th>
                                                                        <th>자재로트날짜</th>
                                                                        <th>온도1</th>
                                                                        <th>온도2</th>
                                                                        <th>온도3</th>
                                                                        <th>온도4</th>
                                                                        <th>온도편차</th>
                                                                        <th>합부판정</th>
                                                                        <th>검사일시</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($inspect_list as $Data_inspect): ?>
                                                                        <tr>
                                                                            <td data-label="품번"><?php echo h($Data_inspect['CD_ITEM']); ?></td>
                                                                            <td data-label="로트날짜"><?php echo h($Data_inspect['LOT_DATE_STR']); ?></td>                                                                                  
                                                                            <td data-label="자재품번"><?php echo h($Data_inspect['CD_MATL']); ?></td>
                                                                            <td data-label="자재로트날짜"><?php echo h($Data_inspect['CD_MATL_LOT']); ?></td>
                                                                            <td data-label="온도1"><?php echo h($Data_inspect['TEMP_MAX1']); ?></td>
                                                                            <td data-label="온도2"><?php echo h($Data_inspect['TEMP_MAX2']); ?></td>
                                                                            <td data-label="온도3"><?php echo h($Data_inspect['TEMP_MAX3']); ?></td>
                                                                            <td data-label="온도4"><?php echo h($Data_inspect['TEMP_MAX4']); ?></td>
                                                                            <td data-label="온도편차"><?php echo h($Data_inspect['DEVIATION']).' ('.h($Data_inspect['DEVIATION_MIN']).'~'.h($Data_inspect['DEVIATION_MAX']).')'; ?></td>
                                                                            <td data-label="합부판정"><?php echo h($Data_inspect['DEVIATION_DECIDE']); ?></td>
                                                                            <td data-label="검사일시"><?php echo h($Data_inspect['INSERT_DT_STR']); ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                    
                                                                    <?php if(empty($inspect_list)): ?>
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
                                    </div>
                                </div>
                            </div>
                        </div>   
                    
                    </div> </div> </div> </div> </div> <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    // MSSQL, MARIA DB 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
    if(isset($connect4)) { mysqli_close($connect4); }	
?>