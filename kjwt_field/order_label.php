<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.25>
	// Description:	<ERP 작업지시번호 라벨 & 공정진행표 라벨 - 모바일 최적화 적용>
    // Last Modified: <25.10.13>	
	// =============================================
    include 'order_label_status.php';

    // XSS 방지 및 데이터 전처리
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 탭 활성화 안전장치
    $tab2 = $tab2 ?? '';
    $tab3 = $tab3 ?? '';
    $tab2_text = $tab2_text ?? '';
    $tab3_text = $tab3_text ?? '';

    // 검색어 파라미터
    $search_keyword = $_REQUEST['search_keyword'] ?? '';

    // 탭 강제 활성화 로직 (검색 시 해당 탭 유지)
    if (empty($tab2_text) && empty($tab3_text)) {
        if ((isset($bt31) && $bt31 == 'on') || (isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'history')) {
            $tab3 = 'active';
            $tab3_text = 'show active';
        } else {
            $tab2 = 'active';
            $tab2_text = 'show active';
        }
    }

    // [Tab 2] 발행가능 목록 데이터 처리 (배열 저장 및 필터링)
    $order_list = [];
    if (isset($Result_OrderInfo)) {
        while ($row = sqlsrv_fetch_array($Result_OrderInfo, SQLSRV_FETCH_ASSOC)) {
            // 품명 조회 (검색 필터링을 위해 미리 조회)
            $row['NM_ITEM'] = NM_ITEM($row['CD_ITEM']);
            $row['STND'] = ItemInfo($row['CD_ITEM'], 'STND');

            if ($search_keyword && strpos($tab2_text, 'active') !== false) {
                // 작업지시번호, 품번, 품명 검색
                if (strpos($row['NO_WO'], $search_keyword) !== false || 
                    strpos($row['CD_ITEM'], $search_keyword) !== false ||
                    strpos($row['NM_ITEM'], $search_keyword) !== false) {
                    $order_list[] = $row;
                }
            } else {
                $order_list[] = $row;
            }
        }
    }

    // [Tab 3] 발행내역 데이터 처리 (배열 저장 및 필터링)
    $history_list = [];
    if (isset($Result_LabelPrint)) {
        while ($row = sqlsrv_fetch_array($Result_LabelPrint, SQLSRV_FETCH_ASSOC)) {
            // 추가 정보 조회
            $Query_OrderInfo2 = "SELECT * from NEOE.NEOE.PR_WO WHERE NO_WO = '{$row['ORDER_NO']}'";             
            $Result_OrderInfo2 = sqlsrv_query($connect, $Query_OrderInfo2, $params, $options);		
            $Data_OrderInfo2 = sqlsrv_fetch_array($Result_OrderInfo2, SQLSRV_FETCH_ASSOC);

            $row['CD_ITEM'] = $Data_OrderInfo2['CD_ITEM'] ?? '';
            $row['NM_ITEM'] = isset($Data_OrderInfo2['CD_ITEM']) ? NM_ITEM($Data_OrderInfo2['CD_ITEM']) : '';
            $row['STND']    = isset($Data_OrderInfo2['CD_ITEM']) ? ItemInfo($Data_OrderInfo2['CD_ITEM'], 'STND') : '';
            $row['QT_ITEM'] = isset($Data_OrderInfo2['QT_ITEM']) ? (int)$Data_OrderInfo2['QT_ITEM'] : '';

            if ($search_keyword && strpos($tab3_text, 'active') !== false) {
                // 작업지시번호, 품번 검색
                if (strpos($row['ORDER_NO'], $search_keyword) !== false || 
                    strpos($row['CD_ITEM'], $search_keyword) !== false) {
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">작업지시번호 라벨</h1>
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
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 실적 전산화를 위한 라벨 발행 전산화<BR><BR>

                                            [작업순서]<BR>
                                            1. ERP 작업지시 데이터 삽입<BR>
                                            2. ERP 작업지시 출력<BR>
                                            3. 검사 시 작업지시서에 있는 바코드를 스캔했는데 작업지시번호가 없다고 뜨는 경우<BR>
                                            4. FMS 작업지시번호 라벨에서 변경된 작업지시번호를 찾아 출력<BR>
                                             - ERP에서 작업지시 데이터를 삭제했을 가능성이 큼<BR><BR>

                                            [기능]<BR>
                                            0. 페이지<br>
                                            - [공통] 60초 마다 자동 새로고침<BR>
                                            1. 라벨발행탭<br>
                                            - [발행가능] ERP 오더상태가 발행이고 22.1.1 이후 데이터 출력<BR>
                                            - [발행가능] ERP 작업지시번호가 기록된 바코드 라벨을 발행<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 검수반<br><br>

                                            [히스토리]<BR>
                                            21.11.25)<BR>
                                            - 기존에 작업지시마다 작업지시 엑셀파일을 출력하였고 이곳에 FMS에서 발행하는 작업지시 바코드 라벨을 붙이도록 합의 하였다.<BR>
                                            22.09.28)<BR>                                            
                                            - 내부회계관리제도가 들어오면서 ERP로 작업지시를 내려야 했고 작업지시별이 아닌 금일 작업 품번당 작업지시가 내려가는 식으로 변경 되었다.<BR>
                                            25.02.21)<BR>                                            
                                            - 출력해야 하는 작업지시 데이터가 많아져 웹페이지 출력 속도가 느려지는 문제점을 개선하기 위해 최근 데이터 100개만 출력하도록 하였다.<BR><BR>

                                            [제작일]<BR>
                                            - 21.11.25<br><br> 
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">    
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h6 class="m-0 font-weight-bold text-primary">발행가능</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample21">
                                                    <div class="card-body table-responsive p-2">
                                                        
                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="POST" action="order_label.php">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="작업지시번호/품번/품명 검색" value="<?= h($search_keyword) ?>">
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
                                                                        <th>작업지시번호</th>
                                                                        <th>품번</th>
                                                                        <th>품명</th>
                                                                        <th>규격</th>                                                                                
                                                                        <th>지시수량</th>     
                                                                        <th>발행</th>                                                                         
                                                                    </tr>
                                                                </thead>                                                                        
                                                                <tbody>
                                                                    <?php 
                                                                        $i = 1;
                                                                        foreach ($order_list as $Data_OrderInfo):
                                                                    ?>                                                                            
                                                                        <tr>
                                                                            <form method="POST" action="order_label_single.php">
                                                                                <input name="order_no<?php echo $i; ?>" value="<?php echo h($Data_OrderInfo['NO_WO']); ?>" type="hidden">
                                                                                <td data-label="작업지시번호"><?php echo h($Data_OrderInfo['NO_WO']); ?></td>  
                                                                                <td data-label="품번"><?php echo h($Data_OrderInfo['CD_ITEM']); ?></td> 
                                                                                <td data-label="품명"><?php echo h($Data_OrderInfo['NM_ITEM']); ?></td> 
                                                                                <td data-label="규격"><?php echo h($Data_OrderInfo['STND']); ?></td> 
                                                                                <td data-label="지시수량"><?php echo (int)$Data_OrderInfo['QT_ITEM']; ?></td>                                                                                      
                                                                                <td data-label="발행">
                                                                                    <button type="submit" class="btn btn-info btn-sm" name="seq" value="<?php echo $i?>">발행</button>
                                                                                </td>
                                                                            </form>
                                                                        </tr> 
                                                                    <?php 
                                                                            $i++;
                                                                        endforeach;
                                                                    ?>
                                                                    <?php if(empty($order_list)): ?>
                                                                        <tr>
                                                                            <td colspan="6" class="text-center no-data">데이터가 없습니다.</td>
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
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="order_label.php"> 
                                                    <div class="collapse show" id="collapseCardExample31">                                    
                                                        <div class="card-body p-3"> <div class="form-group mb-0">
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
                                                            <form method="POST" action="order_label.php">
                                                                <input type="hidden" name="bt31" value="on">
                                                                <input type="hidden" name="tab" value="history">
                                                                <input type="hidden" name="dt3" value="<?php echo h($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>">
                                                                
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="작업지시번호/품번 검색" value="<?= h($search_keyword) ?>">
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
                                                                    <th>작업지시번호</th>
                                                                    <th>품번</th>
                                                                    <th>품명</th>
                                                                    <th>규격</th>
                                                                    <th>지시수량</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($history_list as $row): ?>
                                                                <tr>
                                                                    <td data-label="작업지시번호"><?php echo h($row['ORDER_NO']); ?></td>  
                                                                    <td data-label="품번"><?php echo h($row['CD_ITEM']); ?></td> 
                                                                    <td data-label="품명"><?php echo h($row['NM_ITEM']); ?></td> 
                                                                    <td data-label="규격"><?php echo h($row['STND']); ?></td> 
                                                                    <td data-label="지시수량"><?php echo (int)$row['QT_ITEM']; ?></td>   
                                                                </tr> 
                                                                <?php endforeach; ?>
                                                                <?php if(empty($history_list)): ?>
                                                                    <tr>
                                                                        <td colspan="5" class="text-center no-data">데이터가 없습니다.</td>
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
                    
                    </div> </div> </div> </div> </div> <?php include '../plugin_lv1.php'; ?>

    <script>
    $(document).ready(function() {
        // 검색 실행 시 탭 유지 (POST 방식이지만 JS로 보완)
        var searchParam = new URLSearchParams(window.location.search).get('search_keyword');
        var tabParam = new URLSearchParams(window.location.search).get('tab');
        
        // URL 파라미터나 hidden input(tab=history)이 있을 경우 처리
        if (tabParam === 'history' || "<?php echo $tab3; ?>" === 'active') {
            $('#custom-tabs-one-1th-tab').tab('show');
        } else {
            $('#tab-two').tab('show');
        }
    });
    </script>
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }	
?>