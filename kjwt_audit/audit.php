<?php
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.06.10>
	// Description:	<감사 - 모바일 최적화 적용>
    // Last Modified: <25.09.18>
	// =============================================
    include 'audit_status.php';

    // XSS 방지 함수
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 검색어 파라미터
    $search_keyword = $_REQUEST['search_keyword'] ?? '';

    // ---------------------------------------------------------
    // [Tab 2] ERP 권한부여(입사) 데이터 처리
    // ---------------------------------------------------------
    $grant_list = [];
    if (isset($Result_Grant)) {
        while ($row = sqlsrv_fetch_array($Result_Grant, SQLSRV_FETCH_ASSOC)) {
            if ($search_keyword && strpos($tab2_text, 'active') !== false) {
                if (strpos($row['ID_USER'], $search_keyword) !== false) {
                    $grant_list[] = $row;
                }
            } else {
                $grant_list[] = $row;
            }
        }
    }

    // ---------------------------------------------------------
    // [Tab 3] ERP 회계계정 데이터 처리
    // ---------------------------------------------------------
    $account_list = [];
    if (isset($Result_Grant2)) {
        while ($row = sqlsrv_fetch_array($Result_Grant2, SQLSRV_FETCH_ASSOC)) {
            if ($search_keyword && strpos($tab3_text, 'active') !== false) {
                if (strpos($row['NM_ACGRP'], $search_keyword) !== false || 
                    strpos($row['NM_ACCT'], $search_keyword) !== false ||
                    strpos($row['ID_INSERT'], $search_keyword) !== false) {
                    $account_list[] = $row;
                }
            } else {
                $account_list[] = $row;
            }
        }
    }

    // ---------------------------------------------------------
    // [Tab 4] ERP 메뉴별 권한보유자 데이터 처리
    // ---------------------------------------------------------
    $menu_user_list = [];
    if (isset($Result_Grant3)) {
        while ($row = sqlsrv_fetch_array($Result_Grant3, SQLSRV_FETCH_ASSOC)) {
            if ($search_keyword && strpos($tab4_text, 'active') !== false) {
                if (strpos($row['ID_USER'], $search_keyword) !== false || 
                    strpos($row['NM_DEPT'], $search_keyword) !== false ||
                    strpos($row['NM_MENU'], $search_keyword) !== false) {
                    $menu_user_list[] = $row;
                }
            } else {
                $menu_user_list[] = $row;
            }
        }
    }

    // ---------------------------------------------------------
    // [Tab 5] ERP 권한회수(퇴사) 데이터 처리
    // ---------------------------------------------------------
    $retire_list = [];
    if (isset($Result_Grant4)) {
        while ($row = sqlsrv_fetch_array($Result_Grant4, SQLSRV_FETCH_ASSOC)) {
            if ($search_keyword && strpos($tab5_text, 'active') !== false) {
                if (strpos($row['NM_KOR'], $search_keyword) !== false || 
                    strpos($row['NOTE'], $search_keyword) !== false) {
                    $retire_list[] = $row;
                }
            } else {
                $retire_list[] = $row;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta http-equiv="Cache-Control" content="max-age=31536000"/>
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

            /* 데이터 없음 행 스타일 */
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">내부회계관리제도</h1>
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
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">ERP 권한부여(입사)</a>
                                        </li>                
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab5);?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">ERP 권한회수(퇴사)</a>
                                        </li>                                                                   
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3);?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">ERP 회계계정상태</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab4);?>" id="custom-tabs-one-2th-tab" data-toggle="pill" href="#custom-tabs-one-2th">ERP 메뉴별 권한보유자</a>
                                        </li>   
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-3" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - ERP 권한정보 공유<BR><BR>
                                            [제작일]<BR>
                                            - 22.06.10<br><br> 
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two"> 
                                            <P class="p-2">
                                                ※ERP 사용자 정보등록 메뉴에서 계정을 생성한 상태
                                            </P>
                                            
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="audit.php"> 
                                                    <div class="collapse show" id="collapseCardExample22">                                    
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
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt21">조회</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div> 

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h6 class="m-0 font-weight-bold text-primary">ERP 권한부여(입사)</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="audit.php"> 
                                                    <div class="collapse show" id="collapseCardExample21">
                                                        <div class="card-body table-responsive p-2"> 
                                                            
                                                            <div class="d-block d-md-none mb-3 mt-2">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="hidden" name="bt21" value="on">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="이름 검색" value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit"><i class="fas fa-search"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped mobile-responsive-table" id="table1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>이름</th>
                                                                            <th>권한부여 일시</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($grant_list as $Data_Grant): ?>                                                                            
                                                                            <tr> 
                                                                                <td data-label="이름"><?= h(trim($Data_Grant['ID_USER'] ?? '')) ?></td>        
                                                                                <td data-label="권한부여 일시"><?= h($Data_Grant['DTS_INSERT'] ? date('Y-m-d H:m:s', strtotime($Data_Grant['DTS_INSERT'])) : '') ?></td> 
                                                                            </tr>                                                                           
                                                                        <?php endforeach; ?>
                                                                        <?php if(empty($grant_list)): ?>
                                                                            <tr><td colspan="2" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                        <?php endif; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </form> 
                                            </div>
                                        </div>  

                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">           
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h6 class="m-0 font-weight-bold text-primary">ERP 회계 계정등록/변경 상태</h6>                                                        
                                                </a>
                                                <form method="POST" autocomplete="off" action="audit.php"> 
                                                    <div class="collapse show" id="collapseCardExample31">
                                                        <div class="card-body table-responsive p-2">  
                                                            <div class="d-block d-md-none mb-3 mt-2">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="hidden" name="bt31" value="on">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="계정명/그룹명 검색" value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit"><i class="fas fa-search"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="table-editable">
                                                                <table class="table table-bordered table-striped mobile-responsive-table" id="table3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>상위계정명</th> 
                                                                            <th>계정명</th>  
                                                                            <th>생성자</th>
                                                                            <th>생성일시</th>
                                                                            <th>변경자</th>
                                                                            <th>변경일시</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($account_list as $Data_Grant2): ?>                                                                            
                                                                            <tr> 
                                                                                <td data-label="상위계정명"><?= h($Data_Grant2['NM_ACGRP']) ?></td>  
                                                                                <td data-label="계정명"><?= h($Data_Grant2['NM_ACCT']) ?></td>     
                                                                                <td data-label="생성자"><?= h($Data_Grant2['ID_INSERT']) ?></td> 
                                                                                <td data-label="생성일시"><?= h($Data_Grant2['DTS_INSERT']) ?></td>  
                                                                                <td data-label="변경자"><?= h($Data_Grant2['ID_UPDATE']) ?></td> 
                                                                                <td data-label="변경일시"><?= h($Data_Grant2['DTS_UPDATE']) ?></td>   
                                                                            </tr>                                                                           
                                                                        <?php endforeach; ?>
                                                                        <?php if(empty($account_list)): ?>
                                                                            <tr><td colspan="6" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                        <?php endif; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div> 
                                                        </div>
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt31">조회</button>
                                                        </div>
                                                    </div>
                                                </form> 
                                            </div>
                                        </div> 

                                        <div class="tab-pane fade <?php echo h($tab4_text);?>" id="custom-tabs-one-2th" role="tabpanel" aria-labelledby="custom-tabs-one-2th-tab">    
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                    <h6 class="m-0 font-weight-bold text-primary">입력</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="audit.php"> 
                                                    <div class="collapse show" id="collapseCardExample41">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>메뉴명</label>
                                                                <div class="input-group">  
                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-qrcode"></i></span></div>
                                                                    <input type="text" class="form-control" name="menu41" value="<?php echo h($menu41); ?>" autofocus>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt41">입력</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div> 
                                        
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                    <h6 class="m-0 font-weight-bold text-primary">ERP 메뉴별 권한보유자</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample42">
                                                    <div class="card-body table-responsive p-2"> 
                                                        
                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="POST" action="audit.php">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="hidden" name="bt41" value="on">
                                                                    <input type="hidden" name="menu41" value="<?php echo h($menu41); ?>">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="사용자/부서 검색" value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit"><i class="fas fa-search"></i></button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <div class="table-editable">
                                                            <table class="table table-bordered table-striped mobile-responsive-table" id="table4">
                                                                <thead>
                                                                    <tr>
                                                                        <th>그룹</th>
                                                                        <th>사용자</th>
                                                                        <th>소속</th> 
                                                                        <th>모듈명</th>
                                                                        <th>메뉴명</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($menu_user_list as $Data_Grant3): ?>                                                                            
                                                                        <tr>                                                                                 
                                                                            <td data-label="그룹"><?= h($Data_Grant3['ID_GROUP']) ?></td> 
                                                                            <td data-label="사용자"><?= h($Data_Grant3['ID_USER']) ?></td> 
                                                                            <td data-label="소속"><?= h($Data_Grant3['NM_DEPT']) ?></td> 
                                                                            <td data-label="모듈명"><?= h($Data_Grant3['NM_MODULE']) ?></td> 
                                                                            <td data-label="메뉴명"><?= h($Data_Grant3['NM_MENU']) ?></td>    
                                                                        </tr>                                                                           
                                                                    <?php endforeach; ?>
                                                                    <?php if(empty($menu_user_list)): ?>
                                                                        <tr><td colspan="5" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>   
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab5_text);?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">    
                                            <div class="col-lg-12 p-0"> 
                                                <P class="p-2">
                                                    ※ERP 사원등록 메뉴에서 경영팀이 재직구분을 퇴직으로 변경한 상태<br>
                                                    ※사원등록 메뉴에서 재직구분을 퇴직으로 변경하면 그 즉시 ERP 접근이 불가능함<br>
                                                </P>

                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample52" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample52">
                                                        <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="audit.php"> 
                                                        <div class="collapse show" id="collapseCardExample52">                                    
                                                            <div class="card-body p-3">
                                                                <div class="form-group mb-0">
                                                                    <label>검색범위</label>
                                                                    <div class="input-group">                                                
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt5 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt5">
                                                                    </div>                                                               
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt51">조회</button>
                                                            </div>
                                                        </div>
                                                    </form>     
                                                </div>

                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                        <h6 class="m-0 font-weight-bold text-primary">ERP 권한회수(퇴사)</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="audit.php"> 
                                                        <div class="collapse show" id="collapseCardExample51">
                                                            <div class="card-body table-responsive p-2"> 
                                                                
                                                                <div class="d-block d-md-none mb-3 mt-2">
                                                                    <div class="input-group shadow-sm">
                                                                        <input type="hidden" name="bt51" value="on">
                                                                        <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="사용자/비고 검색" value="<?= h($search_keyword) ?>">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-primary mobile-search-btn" type="submit"><i class="fas fa-search"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="table-editable">
                                                                    <table class="table table-bordered table-striped mobile-responsive-table" id="table5">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>그룹코드</th>
                                                                                <th>사용자</th>
                                                                                <th>퇴사일</th>   
                                                                                <th>퇴사처리일시</th>
                                                                                <th>비고</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($retire_list as $Data_Grant4): ?>                                                                            
                                                                                <tr>  
                                                                                    <td data-label="그룹코드"><?= h($Data_Grant4['CD_GROUP']) ?></td>                                                                                             
                                                                                    <td data-label="사용자"><?= h($Data_Grant4['NM_KOR']) ?></td>  
                                                                                    <td data-label="퇴사일"><?= h($Data_Grant4['DT_RETIRE'] ? date('Y-m-d', strtotime($Data_Grant4['DT_RETIRE'])) : '') ?></td>
                                                                                    <td data-label="퇴사처리일시"><?= h($Data_Grant4['DTS_UPDATE'] ? date('Y-m-d H:m:s', strtotime($Data_Grant4['DTS_UPDATE'])) : '') ?></td>
                                                                                    <td data-label="비고"><?= h($Data_Grant4['NOTE']) ?></td> 
                                                                                </tr>                                                                           
                                                                            <?php endforeach; ?>
                                                                            <?php if(empty($retire_list)): ?>
                                                                                <tr><td colspan="4" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                            <?php endif; ?>
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
                    
                    </div> </div> </div> </div> </div> <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php
    //MARIA DB 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>