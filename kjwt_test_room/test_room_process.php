<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.04.08>
	// Description:	<시험실 qr코드 이력관리 - 모바일 최적화 적용>
    // Last Modified: <25.10.13>
	// =============================================
    include 'test_room_process_status.php';

    // XSS 방지 및 데이터 전처리
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 탭 활성화 안전장치
    $tab2 = $tab2 ?? '';
    $tab3 = $tab3 ?? '';
    $tab4 = $tab4 ?? '';
    $tab2_text = $tab2_text ?? '';
    $tab3_text = $tab3_text ?? '';
    $tab4_text = $tab4_text ?? '';

    // 검색어 파라미터
    $search_keyword = $_REQUEST['search_keyword'] ?? '';

    // 탭 강제 활성화 로직
    if (empty($tab2_text) && empty($tab3_text) && empty($tab4_text)) {
        if ((isset($bt31) && $bt31 == 'on') || (isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'history')) {
            $tab3 = 'active';
            $tab3_text = 'show active';
        } elseif ((isset($bt41) && $bt41 == 'on') || (isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'label')) {
            $tab4 = 'active';
            $tab4_text = 'show active';
        } else {
            $tab2 = 'active';
            $tab2_text = 'show active';
        }
    }

    // [Tab 3] 이력 데이터 처리 (배열 저장 및 필터링)
    $history_list = [];
    if (isset($Result_Select)) {
        while ($row = sqlsrv_fetch_array($Result_Select, SQLSRV_FETCH_ASSOC)) {
            // 검색 필터링
            if ($search_keyword && strpos($tab3_text, 'active') !== false) {
                if (strpos($row['CD_ITEM'], $search_keyword) !== false || 
                    strpos($row['TEST_USER'], $search_keyword) !== false ||
                    strpos($row['LOT_NUM'], $search_keyword) !== false ||
                    strpos($row['NOTE'], $search_keyword) !== false) {
                    $history_list[] = $row;
                }
            } else {
                $history_list[] = $row;
            }
        }
    }

    // [Helper] LEG Form 렌더링 함수 (모바일 최적화 적용)
    function renderLegForm($legNumber, $legData, $existData, $showClass, $cdItem, $id) {
        $cdItemEscaped = htmlspecialchars($cdItem ?? '', ENT_QUOTES, 'UTF-8');
        $idEscaped = htmlspecialchars($id ?? '', ENT_QUOTES, 'UTF-8');
        $actionUrl = "test_room_process.php?CD_ITEM={$cdItemEscaped}&ID={$idEscaped}";
?>
        <div class="card shadow mb-4">
            <a href="#collapseCardExample2<?php echo $legNumber; ?>" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2<?php echo $legNumber; ?>">
                <h6 class="m-0 font-weight-bold text-primary">LEG<?php echo $legNumber; ?></h6>
            </a>
            <form method="POST" autocomplete="off" action="<?php echo $actionUrl; ?>">
                <div class="collapse <?php echo htmlspecialchars($showClass ?? ''); ?>" id="collapseCardExample2<?php echo $legNumber; ?>">
                    <div class="card-body table-responsive p-2">
                        <div id="table" class="table-editable">
                            <table class="table table-bordered mobile-responsive-table" id="table_test_room_process_<?php echo $legNumber; ?>">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">순서</th>
                                        <th style="text-align: center;">시험명</th>
                                        <th style="text-align: center;">판정</th>
                                        <th style="text-align: center;">특이사항</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $flag = 0;
                                    if (!empty($legData)) {
                                        foreach ($legData as $item) {
                                            $leg = $item['LEG'] ?? '';
                                            $step = $item['STEP'] ?? '';
                                            $process = $item['PROCESS'] ?? '';
                                            $stepId = $leg . $step;

                                            $currentValue = $existData["P{$stepId}"] ?? null;
                                            $currentValueNOTE = $existData["NOTE{$stepId}"] ?? null;
                                            $nextStepJs = (int)$step + 1;

                                            $isDisabled = ($flag === 1 && empty($currentValue));
                                            $disabledAttr = $isDisabled ? "disabled" : "";

                                            if (empty($currentValue)) {
                                                $flag = 1;
                                            }
                                    ?>
                                        <tr>
                                            <td data-label="순서" style='text-align: center;'><?php echo htmlspecialchars($step); ?></td>
                                            <td data-label="시험명" style='text-align: center;'><?php echo htmlspecialchars($process); ?></td>
                                            <td data-label="판정" style='text-align: center;'>
                                                <select id='P<?php echo $stepId; ?>' name='P<?php echo $stepId; ?>' class="form-control form-control-sm" style='width: 100%;' <?php echo $disabledAttr; ?> onchange='updateSelectState("P<?php echo $stepId; ?>", "P<?php echo $leg . $nextStepJs; ?>")'>
                                                    <option value='' <?php echo ($currentValue == '') ? "selected" : ""; ?>></option>
                                                    <option value='NA' <?php echo ($currentValue == 'NA') ? "selected" : ""; ?>>N/A(생략)</option>
                                                    <option value='불합격' <?php echo ($currentValue == '불합격') ? "selected" : ""; ?>>불합격</option>
                                                    <option value='합격' <?php echo ($currentValue == '합격') ? "selected" : ""; ?>>합격</option>
                                                </select>
                                            </td>
                                            <td data-label="특이사항" style='text-align: center;'>
                                                <input type='text' class="form-control form-control-sm" name='NOTE<?php echo $stepId; ?>' style='width: 100%;' <?php echo $disabledAttr; ?> value='<?php echo htmlspecialchars($currentValueNOTE ?? '', ENT_QUOTES); ?>'>
                                            </td>
                                        </tr>
                                    <?php } }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" value="on" class="btn btn-primary" name="bt2<?php echo $legNumber; ?>">입력</button>
                    </div>
                </div>
            </form>
        </div>
<?php
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
                
                /* 텍스트 줄바꿈 처리 */
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">시험 이력 관리</h1>
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
                                            <a class="nav-link <?php echo h($tab4);?>" id="tab-four" data-toggle="pill" href="#tab4">라벨발행</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">이력관리</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3);?>" id="tab-three" data-toggle="pill" href="#tab3">이력조회</a>
                                        </li>  
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-3" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [안내]<br>
                                            - 시험 이력 관리를 위한 페이지입니다.
                                        </div>
                                        
                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <?php 
                                            for ($i = 1; $i <= 8; $i++) {
                                                $legDataVar = "Data_LEG{$i}";
                                                $showVar = "show{$i}";
                                                // 전역 변수에서 데이터 가져오기
                                                global $$legDataVar, $Data_ExistData, $$showVar, $CD_ITEM, $ID;
                                                renderLegForm($i, $$legDataVar ?? [], $Data_ExistData ?? [], $$showVar ?? '', $CD_ITEM ?? '', $ID ?? '');
                                            }
                                            ?>
                                        </div>  

                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="test_room_process.php"> 
                                                    <div class="collapse show" id="collapseCardExample31">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>검색범위</label>
                                                                <div class="input-group">                                                
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt3 ?? ''); ?>" name="dt3">
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
                                                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                    <h6 class="m-0 font-weight-bold text-primary">결과</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample32">
                                                    <div class="card-body table-responsive p-2">    
                                                        
                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="POST" action="test_room_process.php">
                                                                <input type="hidden" name="bt31" value="on">
                                                                <input type="hidden" name="tab" value="history">
                                                                <input type="hidden" name="dt3" value="<?php echo h($dt3 ?? ''); ?>">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="품명/시험자/비고 검색" value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <table class="table table-bordered table-hover text-nowrap mobile-responsive-table" id="table6">
                                                            <thead>
                                                                <tr>
                                                                    <th>품명</th><th>라벨발행일</th><th>라벨번호</th><th>시험품사양</th><th>시험자</th><th>SW</th><th>샘플번호</th><th>시험목적</th><th>HW</th><th>비고</th>
                                                                    <?php 
                                                                        // 동적 헤더 생성
                                                                        for ($l=1; $l<=8; $l++) {
                                                                            for ($s=1; $s<=14; $s++) {
                                                                                echo "<th>LEG{$l}/{$s} 판정</th><th>LEG{$l}/{$s} 특이사항</th>";
                                                                            }
                                                                        }
                                                                    ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($history_list as $Data_Select): ?>
                                                                <tr>
                                                                    <td data-label="품명"><?php echo h($Data_Select['CD_ITEM']); ?></td> 
                                                                    <td data-label="라벨발행일"><?php echo h($Data_Select['LOT_DATE']); ?></td>   
                                                                    <td data-label="라벨번호"><?php echo h($Data_Select['LOT_NUM']); ?></td> 
                                                                    <td data-label="시험품사양"><?php echo h($Data_Select['CONTENTS']); ?></td> 
                                                                    <td data-label="시험자"><?php echo h($Data_Select['TEST_USER']); ?></td> 
                                                                    <td data-label="SW"><?php echo h($Data_Select['SW']); ?></td> 
                                                                    <td data-label="샘플번호"><?php echo h($Data_Select['SAMPLE_NUM']); ?></td> 
                                                                    <td data-label="시험목적"><?php echo h($Data_Select['PURPOSE']); ?></td> 
                                                                    <td data-label="HW"><?php echo h($Data_Select['HW']); ?></td> 
                                                                    <td data-label="비고"><?php echo h($Data_Select['NOTE']); ?></td> 
                                                                    <?php 
                                                                        // 동적 셀 생성 (모바일 라벨 포함)
                                                                        for ($l=1; $l<=8; $l++) {
                                                                            for ($s=1; $s<=14; $s++) {
                                                                                echo "<td data-label='LEG{$l}/{$s} 판정'>" . h($Data_Select["P{$l}{$s}"] ?? '') . "</td>";
                                                                                echo "<td data-label='LEG{$l}/{$s} 특이사항'>" . h($Data_Select["NOTE{$l}{$s}"] ?? '') . "</td>";
                                                                            }
                                                                        }
                                                                    ?>
                                                                </tr> 
                                                                <?php endforeach; ?>
                                                                <?php if(empty($history_list)): ?>
                                                                    <tr><td colspan="234" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>                                     
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab4_text);?>" id="tab4" role="tabpanel" aria-labelledby="tab-four"> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                        <h6 class="m-0 font-weight-bold text-primary">라벨발행</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" name="pop_form" action="test_room_label_force.php" target="_blank"> 
                                                        <div class="collapse show" id="collapseCardExample41">                                    
                                                            <div class="card-body p-3">
                                                                <div class="row">
                                                                    <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>품명</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-signature"></i></span></div><input type="text" class="form-control" name="item41" required></div></div></div>
                                                                    <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>출력 라벨 수량</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-barcode"></i></span></div><input type="number" class="form-control" name="label41" min="1" value="1" required></div></div></div>
                                                                    <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>비고</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-sticky-note"></i></span></div><input type="text" class="form-control" name="note41"></div></div></div>
                                                                    <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>시험품 사양</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-ruler-combined"></i></span></div><input type="text" class="form-control" name="contents41" required placeholder="EX) SHVU_FR"></div></div></div>
                                                                    <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>시험자</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="text" class="form-control" name="test_user41" required></div></div></div>
                                                                    <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>SW</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-windows"></i></span></div><input type="text" class="form-control" name="sw41" required placeholder="EX) 25410"></div></div></div>
                                                                    <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>샘플번호</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-tag"></i></span></div><input type="text" class="form-control" name="sample_num41" placeholder="EX) #5-1"></div></div></div>
                                                                    <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>시험목적</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flag-checkered"></i></span></div><select name='purpose41' class="form-control" required><option value='DV'>DV</option><option value='PV'>PV</option><option value='4M변경'>4M변경</option><option value='정기시험'>정기시험</option></select></div></div></div>
                                                                    <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>HW</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hdd"></i></span></div><input type="text" class="form-control" name="hw41" required placeholder="EX) 1.00"></div></div></div>
                                                                </div> 
                                                            </div>
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt41">발행</button>
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

    <script>
        function updateSelectState(currentId, nextId) {
            const currentElement = document.getElementById(currentId);
            const nextElement = document.getElementById(nextId);
            if (!nextElement) return;

            const nextInput = document.querySelector(`input[name="NOTE${nextId.replace('P', '')}"]`);

            if (currentElement.value !== '') {
                nextElement.disabled = false;
                if (nextInput) nextInput.disabled = false;
            } else {
                nextElement.disabled = true;
                nextElement.value = '';
                if (nextInput) {
                    nextInput.disabled = true;
                    nextInput.value = '';
                }
                let currentLeg = nextId.charAt(1);
                let currentStep = parseInt(nextId.substring(2));
                let nextEl = document.getElementById(`P${currentLeg}${currentStep}`);
                while(nextEl) {
                    nextEl.disabled = true;
                    nextEl.value = '';
                    let nextInputEl = document.querySelector(`input[name="NOTE${currentLeg}${currentStep}"]`);
                    if(nextInputEl) {
                        nextInputEl.disabled = true;
                        nextInputEl.value = '';
                    }
                    currentStep++;
                    nextEl = document.getElementById(`P${currentLeg}${currentStep}`);
                }
            }
        }
        
        $(document).ready(function() {
            // 검색 실행 시 탭 유지
            var searchParam = new URLSearchParams(window.location.search).get('search_keyword');
            var tabParam = new URLSearchParams(window.location.search).get('tab');
            
            if (searchParam || tabParam === 'history') {
                $('#tab-three').tab('show');
            } else if (tabParam === 'label') {
                $('#tab-four').tab('show');
            }
        });
    </script>

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>