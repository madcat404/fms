<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.04.28>
	// Description:	<포장라벨 - 모바일 최적화 적용>	
    // Last Modified: <25.10.13>
	// =============================================
    include 'complete_label_status.php';

    // XSS 방지 및 데이터 전처리
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 탭 활성화 안전장치
    $tab2 = $tab2 ?? '';
    $tab3 = $tab3 ?? '';
    $tab4 = $tab4 ?? '';
    $tab5 = $tab5 ?? '';
    
    $tab2_text = $tab2_text ?? '';
    $tab3_text = $tab3_text ?? '';
    $tab4_text = $tab4_text ?? '';
    $tab5_text = $tab5_text ?? '';

    // 검색어 파라미터
    $search_keyword = $_REQUEST['search_keyword'] ?? '';

    // 탭 강제 활성화 로직
    if (empty($tab2_text) && empty($tab3_text) && empty($tab4_text) && empty($tab5_text)) {
        if ((isset($bt31) && $bt31 == 'on') || (isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'history')) {
            $tab3 = 'active';
            $tab3_text = 'show active';
        } elseif ((isset($bt40) && $bt40 == 'on') || (isset($bt41) && $bt41 == 'on') || (isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'delete')) {
            $tab4 = 'active';
            $tab4_text = 'show active';
        } elseif ((isset($bt51) && $bt51 == 'on') || (isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'custom')) {
            $tab5 = 'active';
            $tab5_text = 'show active';
        } else {
            $tab2 = 'active';
            $tab2_text = 'show active';
        }
    }

    // ---------------------------------------------------------
    // [Tab 2] 발행가능 목록 데이터 처리 (배열 저장 및 필터링)
    // ---------------------------------------------------------
    
    // 1. 베트남 (Vietnam)
    $v_list = [];
    if (isset($Result_vCompleteInfo)) {
        while ($row = sqlsrv_fetch_array($Result_vCompleteInfo, SQLSRV_FETCH_ASSOC)) {
            // 검색 필터링 (Tab 2 활성화 시)
            if ($search_keyword && strpos($tab2_text, 'active') !== false) {
                if (strpos($row['CD_ITEM'], $search_keyword) !== false || 
                    strpos(NM_ITEM($row['CD_ITEM']), $search_keyword) !== false) {
                    $v_list[] = $row;
                }
            } else {
                $v_list[] = $row;
            }
        }
    }

    // 2. 중국 (China)
    $c_list = [];
    if (isset($Result_cCompleteInfo)) {
        while ($row = sqlsrv_fetch_array($Result_cCompleteInfo, SQLSRV_FETCH_ASSOC)) {
            if ($search_keyword && strpos($tab2_text, 'active') !== false) {
                if (strpos($row['CD_ITEM'], $search_keyword) !== false || 
                    strpos(NM_ITEM($row['CD_ITEM']), $search_keyword) !== false) {
                    $c_list[] = $row;
                }
            } else {
                $c_list[] = $row;
            }
        }
    }

    // 3. 한국 (Korea)
    $k_list = [];
    if (isset($Result_CompleteInfo)) {
        while ($row = sqlsrv_fetch_array($Result_CompleteInfo, SQLSRV_FETCH_ASSOC)) {
            if ($search_keyword && strpos($tab2_text, 'active') !== false) {
                if (strpos($row['CD_ITEM'], $search_keyword) !== false || 
                    strpos(NM_ITEM($row['CD_ITEM']), $search_keyword) !== false) {
                    $k_list[] = $row;
                }
            } else {
                $k_list[] = $row;
            }
        }
    }

    // ---------------------------------------------------------
    // [Tab 3] 발행내역 데이터 처리
    // ---------------------------------------------------------
    $history_list = [];
    if (isset($Result_LabelPrint)) {
        while ($row = sqlsrv_fetch_array($Result_LabelPrint, SQLSRV_FETCH_ASSOC)) {
            if ($search_keyword && strpos($tab3_text, 'active') !== false) {
                if (strpos($row['CD_ITEM'], $search_keyword) !== false || 
                    strpos(NM_ITEM($row['CD_ITEM']), $search_keyword) !== false ||
                    strpos($row['LOT_NUM'], $search_keyword) !== false) {
                    $history_list[] = $row;
                }
            } else {
                $history_list[] = $row;
            }
        }
    }

    // ---------------------------------------------------------
    // [Tab 4] 삭제내역 데이터 처리
    // ---------------------------------------------------------
    $delete_list = [];
    if (isset($Result_DeleteSelect)) {
        while ($row = sqlsrv_fetch_array($Result_DeleteSelect, SQLSRV_FETCH_ASSOC)) {
            $delete_list[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>   
    <meta http-equiv="refresh" content="60;"> 

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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">포장라벨</h1>
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
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">라벨발행</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3);?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">라벨발행내역</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab4);?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">삭제 및 내역</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab5);?>" id="custom-tabs-one-5th-tab" data-toggle="pill" href="#custom-tabs-one-5th">커스텀라벨</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-3" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 포장라벨 발행<BR><BR>
                                            [제작일]<BR>
                                            - 22.04.28
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">    
                                            
                                            <div class="d-block d-md-none mb-3 mt-2">
                                                <form method="GET" action="complete_label.php">
                                                    <div class="input-group shadow-sm">
                                                        <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="품번 검색" value="<?= h($search_keyword) ?>">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary mobile-search-btn" type="submit">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h6 class="m-0 font-weight-bold text-primary">발행가능 (해외)</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample21">
                                                    <div class="card-body table-responsive p-2">
                                                        <div id="table" class="table-editable">
                                                            <table class="table table-bordered table-striped mobile-responsive-table" id="table_nosort">
                                                                <thead>
                                                                    <tr>
                                                                        <th>국가</th>
                                                                        <th>품번</th>
                                                                        <th>품명</th>
                                                                        <th>검사완료</th>                                                                                
                                                                        <th>로트사이즈</th>
                                                                        <th>리워크 대기</th>
                                                                        <th>발행옵션</th>
                                                                        <th>발행</th>                                                                                  
                                                                    </tr>
                                                                </thead>                                                                        
                                                                <tbody>
                                                                    <?php foreach ($v_list as $index => $row): $iv = $index + 1; ?>
                                                                        <tr>
                                                                            <form method="POST" action="complete_label_bundle.php">
                                                                                <input name="vITEM<?php echo $iv; ?>" value="<?php echo h($row['CD_ITEM']); ?>" type="hidden">
                                                                                <input name="vAS_YN<?php echo $iv; ?>" value="<?php echo h($row['AS_YN']); ?>" type="hidden">
                                                                                <td data-label="국가"><img src="../img/flag_v.png" style="width: 30px;"></td>
                                                                                <td data-label="품번"><?php echo h($row['CD_ITEM']); ?></td>  
                                                                                <td data-label="품명"><?php echo h(NM_ITEM($row['CD_ITEM'])); ?></td> 
                                                                                <td data-label="검사완료"><?php echo $row['VQT_GOODS']-$row['VREJECT_GOODS']+$row['VREJECT_REWORK']-$row['VPRINT_QT']; ?></td>  
                                                                                <td data-label="로트사이즈">
                                                                                    <input type="number" class="form-control form-control-sm" name="vsize<?php echo $iv?>" value="<?php echo (ItemInfo(Hyphen($row['CD_ITEM']), "LOTSIZE")!='0') ? ItemInfo(Hyphen($row['CD_ITEM']), "LOTSIZE") : 1; ?>" min="1">
                                                                                </td>  
                                                                                <td data-label="리워크 대기"><?php echo $row['VREJECT_WAIT']; ?></td>  
                                                                                <td data-label="발행옵션">
                                                                                    <select name="voption<?php echo $iv?>" class="form-control form-control-sm">
                                                                                        <option value="one" selected="selected">한장만</option>
                                                                                        <option value="dozen">여러장</option>
                                                                                    </select>
                                                                                </td> 
                                                                                <td data-label="발행">
                                                                                    <button type="submit" class="btn btn-info btn-sm" name="seq" value="v<?php echo $iv?>">발행</button>
                                                                                </td>
                                                                            </form>
                                                                        </tr> 
                                                                    <?php endforeach; ?>

                                                                    <?php foreach ($c_list as $index => $row): $ic = $index + 1; ?>
                                                                        <tr>
                                                                            <form method="POST" action="complete_label_bundle.php">
                                                                                <input name="cITEM<?php echo $ic; ?>" value="<?php echo h($row['CD_ITEM']); ?>" type="hidden">
                                                                                <input name="cAS_YN<?php echo $ic; ?>" value="<?php echo h($row['AS_YN']); ?>" type="hidden">
                                                                                <td data-label="국가"><img src="../img/flag_c.png" style="width: 30px;"></td>
                                                                                <td data-label="품번"><?php echo h($row['CD_ITEM']); ?></td>  
                                                                                <td data-label="품명"><?php echo h(NM_ITEM($row['CD_ITEM'])); ?></td> 
                                                                                <td data-label="검사완료"><?php echo $row['CQT_GOODS']-$row['CREJECT_GOODS']+$row['CREJECT_REWORK']-$row['CPRINT_QT']; ?></td>
                                                                                <td data-label="로트사이즈">
                                                                                    <input type="number" class="form-control form-control-sm" name="csize<?php echo $ic?>" value="<?php echo (ItemInfo(Hyphen($row['CD_ITEM']), "LOTSIZE")!='0') ? ItemInfo(Hyphen($row['CD_ITEM']), "LOTSIZE") : 1; ?>" min="1">
                                                                                </td> 
                                                                                <td data-label="리워크 대기"><?php echo $row['CREJECT_WAIT']; ?></td>  
                                                                                <td data-label="발행옵션">
                                                                                    <select name="coption<?php echo $ic?>" class="form-control form-control-sm">
                                                                                        <option value="one" selected="selected">한장만</option>
                                                                                        <option value="dozen">여러장</option>
                                                                                    </select>
                                                                                </td> 
                                                                                <td data-label="발행">
                                                                                    <button type="submit" class="btn btn-info btn-sm" name="seq" value="c<?php echo $ic?>">발행</button>
                                                                                </td>
                                                                            </form>
                                                                        </tr> 
                                                                    <?php endforeach; ?>
                                                                    
                                                                    <?php if(empty($v_list) && empty($c_list)): ?>
                                                                        <tr><td colspan="8" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                    <?php endif; ?>
                                                                </tbody>                                                                        
                                                            </table>
                                                        </div>                                     
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h6 class="m-0 font-weight-bold text-primary">발행가능 (국내)</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample22">
                                                    <div class="card-body table-responsive p-2">
                                                        <div id="table" class="table-editable">
                                                            <table class="table table-bordered table-striped mobile-responsive-table" id="table_nosort2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>국가</th>
                                                                        <th>품번</th>
                                                                        <th>품명</th>
                                                                        <th>검사완료</th>                                                                                
                                                                        <th>로트사이즈</th>
                                                                        <th>리워크 대기</th>
                                                                        <th>발행옵션</th>
                                                                        <th>발행</th>                                                                                  
                                                                    </tr>
                                                                </thead>                                                                        
                                                                <tbody>
                                                                    <?php foreach ($k_list as $index => $row): $i = $index + 1; ?>
                                                                        <tr>
                                                                            <form method="POST" action="complete_label_bundle.php">
                                                                                <input name="kITEM<?php echo $i; ?>" value="<?php echo h($row['CD_ITEM']); ?>" type="hidden">
                                                                                <input name="kAS_YN<?php echo $i; ?>" value="<?php echo h($row['AS_YN']); ?>" type="hidden">
                                                                                <td data-label="국가"><img src="../img/flag_k.png" style="width: 30px;"></td>
                                                                                <td data-label="품번"><?php echo h($row['CD_ITEM']); ?></td>  
                                                                                <td data-label="품명"><?php echo h(NM_ITEM($row['CD_ITEM'])); ?></td> 
                                                                                <td data-label="검사완료"><?php echo $row['KQT_GOODS']-$row['KREJECT_GOODS']+$row['KREJECT_REWORK']+$row['KERROR_GOODS']-$row['KPRINT_QT']; ?></td>  
                                                                                <td data-label="로트사이즈">
                                                                                    <input type="number" class="form-control form-control-sm" name="ksize<?php echo $i?>" value="<?php echo (ItemInfo(Hyphen($row['CD_ITEM']), "LOTSIZE")!='0') ? ItemInfo(Hyphen($row['CD_ITEM']), "LOTSIZE") : 1; ?>" min="1">
                                                                                </td> 
                                                                                <td data-label="리워크 대기"><?php echo $row['KREJECT_WAIT']; ?></td>  
                                                                                <td data-label="발행옵션">
                                                                                    <select name="koption<?php echo $i?>" class="form-control form-control-sm">
                                                                                        <option value="one" selected="selected">한장만</option>
                                                                                        <option value="dozen">여러장</option>
                                                                                    </select>
                                                                                </td> 
                                                                                <td data-label="발행">
                                                                                    <button type="submit" class="btn btn-info btn-sm" name="seq" value="k<?php echo $i?>">발행</button>
                                                                                </td>
                                                                            </form>
                                                                        </tr> 
                                                                    <?php endforeach; ?>
                                                                    <?php if(empty($k_list)): ?>
                                                                        <tr><td colspan="8" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                    <?php endif; ?>
                                                                </tbody>                                                                        
                                                            </table>
                                                        </div>                                     
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>  

                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="complete_label.php"> 
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
                                                        <div class="row">
                                                            <?php 
                                                                $ci_count = ($Count_ItemCount > 0) ? $Count_ItemCount : 0;
                                                                $cp_count = ($Data_PcsCount['QT_GOODS'] > 0) ? $Data_PcsCount['QT_GOODS'] : 0;
                                                                BOARD(6, "primary", "작업 품목수량", $ci_count, "fas fa-boxes");
                                                                BOARD(6, "primary", "작업 개별수량", $cp_count, "fas fa-box");
                                                            ?>
                                                        </div>

                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="POST" action="complete_label.php">
                                                                <input type="hidden" name="bt31" value="on">
                                                                <input type="hidden" name="tab" value="history">
                                                                <input type="hidden" name="dt3" value="<?php echo h($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="품번/로트 검색" value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <table class="table table-bordered table-hover text-nowrap mobile-responsive-table" id="table3">
                                                            <thead>
                                                                <tr>
                                                                    <th>국가</th>
                                                                    <th>품번</th>
                                                                    <th>품명</th>
                                                                    <th>생산일</th>
                                                                    <th>로트날짜</th>
                                                                    <th>로트번호</th>
                                                                    <th>로트사이즈</th>
                                                                    <th>비고</th>
                                                                    <th>재발행</th> 
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($history_list as $index => $row): $i = $index + 1; ?>
                                                                <tr>
                                                                    <form method="POST" action="complete_label_single.php">
                                                                        <input name="re_no<?php ECHO $i; ?>" value="<?php echo h($row['NO']); ?>" type="hidden">
                                                                        <td data-label="국가">
                                                                            <?php 
                                                                                $country_code = isset($row['COUNTRY']) ? trim(strtoupper($row['COUNTRY'])) : '';

                                                                                if($country_code=='K') echo "한국";
                                                                                elseif($country_code=='V') echo "베트남";
                                                                                elseif($country_code=='C') echo "중국";
                                                                            ?>
                                                                        </td>  
                                                                        <td data-label="품번"><?php echo h($row['CD_ITEM']); ?></td>  
                                                                        <td data-label="품명"><?php echo h(NM_ITEM($row['CD_ITEM'])); ?></td> 
                                                                        <td data-label="생산일"><?php echo h($row['MAKE_DATE']); ?></td> 
                                                                        <td data-label="로트날짜"><?php echo h($row['LOT_DATE']); ?></td>   
                                                                        <td data-label="로트번호"><?php echo h($row['LOT_NUM']); ?></td>  
                                                                        <td data-label="로트사이즈"><?php echo h($row['QT_GOODS']); ?></td> 
                                                                        <td data-label="비고"><?php echo h($row['NOTE']); ?></td> 
                                                                        <td data-label="재발행">
                                                                            <button type="submit" class="btn btn-info btn-sm" name="re_seq" value="<?php echo $i?>">재발행</button>
                                                                        </td> 
                                                                    </form>
                                                                </tr> 
                                                                <?php endforeach; ?>
                                                                <?php if(empty($history_list)): ?>
                                                                    <tr><td colspan="9" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>                                     
                                                    </div>
                                                </div>
                                            </div>                                             
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab4_text);?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample40" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample40">
                                                    <h6 class="m-0 font-weight-bold text-primary">입력</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="complete_label.php"> 
                                                    <div class="collapse show" id="collapseCardExample40">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>라벨스캔</label>
                                                                <div class="input-group">                                                
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="item40" autofocus pattern="[a-zA-Z0-9^_()_-]+">
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt40">입력</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div> 

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                    <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="complete_label.php"> 
                                                    <div class="collapse show" id="collapseCardExample41">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>검색범위</label>
                                                                <div class="input-group">                                                
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt4">
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt41">검색</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>  

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                    <h6 class="m-0 font-weight-bold text-primary">결과</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample42">
                                                    <div class="card-body table-responsive p-2">
                                                        <table class="table table-bordered table-hover text-nowrap mobile-responsive-table" id="table4">
                                                            <thead>
                                                                <tr>
                                                                    <th>국가</th>
                                                                    <th>품번</th>
                                                                    <th>품명</th>
                                                                    <th>로트날짜</th>
                                                                    <th>로트번호</th>
                                                                    <th>로트사이즈</th>
                                                                    <th>비고</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($delete_list as $row): ?>
                                                                <tr>
                                                                    <td data-label="국가">
                                                                        <?php 
                                                                            if($row['COUNTRY']=='K') echo "한국";
                                                                            elseif($row['COUNTRY']=='V') echo "베트남";
                                                                            elseif($row['COUNTRY']=='C') echo "중국";
                                                                        ?>
                                                                    </td>  
                                                                    <td data-label="품번"><?php echo h($row['CD_ITEM']); ?></td>  
                                                                    <td data-label="품명"><?php echo h(NM_ITEM($row['CD_ITEM'])); ?></td>  
                                                                    <td data-label="로트날짜"><?php echo h($row['LOT_DATE']); ?></td>   
                                                                    <td data-label="로트번호"><?php echo h($row['LOT_NUM']); ?></td>  
                                                                    <td data-label="로트사이즈"><?php echo h($row['QT_GOODS']); ?></td>  
                                                                    <td data-label="비고"><?php echo h($row['NOTE']); ?></td> 
                                                                </tr> 
                                                                <?php endforeach; ?>
                                                                <?php if(empty($delete_list)): ?>
                                                                    <tr><td colspan="7" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>                                     
                                                    </div>
                                                </div>
                                            </div>                                             
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab5_text);?>" id="custom-tabs-one-5th" role="tabpanel" aria-labelledby="custom-tabs-one-5th-tab">
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                        <h6 class="m-0 font-weight-bold text-primary">라벨발행</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" name="pop_form" action="complete_label_force.php"> 
                                                        <div class="collapse show" id="collapseCardExample51">                                    
                                                            <div class="card-body p-3">
                                                                <div class="row">   
                                                                    <div class="col-md-3 col-6 mb-2">
                                                                        <div class="form-group mb-0">
                                                                            <label>선택1</label>
                                                                            <select name="kind51" class="form-control select2" style="width: 100%;">
                                                                                <option value="M" selected="selected">양산</option>
                                                                                <option value="MR">양산 자투리</option>
                                                                                <option value="A">AS</option>
                                                                                <option value="AR">AS 자투리</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-6 mb-2">
                                                                        <div class="form-group mb-0">
                                                                            <label>선택2</label>
                                                                            <select name="country51" class="form-control select2" style="width: 100%;">
                                                                                <option value="K" selected="selected">한국</option>
                                                                                <option value="V">베트남</option>
                                                                                <option value="C">중국</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12 mb-2">
                                                                        <div class="form-group mb-0">
                                                                            <label>품번</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-signature"></i></span></div>
                                                                                <input type="text" class="form-control" name="item51" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-6 mb-2">
                                                                        <div class="form-group mb-0">
                                                                            <label>박스 내 수량</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box-open"></i></span></div>
                                                                                <input type="number" class="form-control" name="size51" min="1" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-6 mb-2">
                                                                        <div class="form-group mb-0">
                                                                            <label>출력 라벨 수량</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-barcode"></i></span></div>
                                                                                <input type="number" class="form-control" name="label51" min="1" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-8 col-12 mb-2">
                                                                        <div class="form-group mb-0">
                                                                            <label>비고</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-sticky-note"></i></span></div>
                                                                                <input type="text" class="form-control" name="note51" value="커스텀라벨">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt51">발행</button>
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
                    
                    </div> </div> </div> </div> </div> <?php include '../plugin_lv1.php'; ?>

    <script>
    $(document).ready(function() {
        // 모바일 기기 감지 및 Select2 해제
        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth <= 768;
        if (isMobile) {
            $('.select2').each(function() {
                if ($.fn.select2 && $(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2('destroy');
                }
                $(this).removeClass('select2');
            });
        }

        // 검색 실행 시 탭 유지
        var searchParam = new URLSearchParams(window.location.search).get('search_keyword');
        var tabParam = new URLSearchParams(window.location.search).get('tab');
        
        // PHP에서 이미 처리하지만, URL 파라미터가 명시적으로 있을 경우를 대비
        if (tabParam === 'history') {
            $('#custom-tabs-one-1th-tab').tab('show');
        } else if (tabParam === 'delete') {
            $('#custom-tabs-one-3th-tab').tab('show');
        } else if (tabParam === 'custom') {
            $('#custom-tabs-one-5th-tab').tab('show');
        }
    });
    </script>
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>