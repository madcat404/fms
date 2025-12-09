<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.01.11>
	// Description:	<검교정 - 모바일 최적화 및 대시보드 필터링 적용>
    // Last Modified: <25.09.23>
	// =============================================
    include 'calibration_status.php';

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

    // 파라미터 받기 (검색어, 필터상태)
    $search_keyword = $_REQUEST['search_keyword'] ?? '';
    $filter_status = $_REQUEST['filter_status'] ?? ''; // scheduled, completed

    // 탭 강제 활성화 로직
    if (empty($tab2_text) && empty($tab3_text) && empty($tab4_text)) {
        if ((isset($bt41) && $bt41 == 'on') || (isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'history')) {
            $tab4 = 'active';
            $tab4_text = 'show active';
        } elseif (isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'label') {
            $tab3 = 'active';
            $tab3_text = 'show active';
        } else {
            $tab2 = 'active';
            $tab2_text = 'show active';
        }
    }

    // [Tab 2] 목록 데이터 처리 (배열 저장 및 필터링)
    $calibration_list = [];
    if (isset($Result_calibration)) {
        while ($row = sqlsrv_fetch_array($Result_calibration, SQLSRV_FETCH_ASSOC)) {
            // 날짜 포맷팅 미리 처리
            $row['LastCalibrationDateStr'] = ($row['LastCalibrationDate']) ? date_format($row['LastCalibrationDate'], "Y-m-d") : '';
            $row['NewDateStr'] = ($row['NewDate']) ? date_format($row['NewDate'], "Y-m-d") : '';
            
            $inspect_yn = $row['INSPECT'] ?? 'N';

            // 1. 상태 필터링 (카드 클릭 시)
            $is_included = true;
            if ($filter_status === 'scheduled') {
                // 예정: 검사완료(Y)가 아닌 것
                if ($inspect_yn === 'Y') $is_included = false;
            } elseif ($filter_status === 'completed') {
                // 완료: 검사완료(Y)인 것
                if ($inspect_yn !== 'Y') $is_included = false;
            }

            // 2. 검색어 필터링 (AND 조건)
            if ($is_included && $search_keyword && strpos($tab2_text, 'active') !== false) {
                if (strpos($row['REGISTER_NO'], $search_keyword) === false && 
                    strpos($row['NAME'], $search_keyword) === false &&
                    strpos($row['NUMBER'], $search_keyword) === false &&
                    strpos($row['MANAGER'], $search_keyword) === false) {
                    $is_included = false;
                }
            }

            // 조건 만족 시 리스트에 추가
            if ($is_included) {
                $calibration_list[] = $row;
            }
        }
    }

    // [Tab 4] 이력 데이터 처리
    $history_list = [];
    if (isset($Result_Select) && $Result_Select) {
        while ($row = sqlsrv_fetch_array($Result_Select, SQLSRV_FETCH_ASSOC)) {
            $row['HistoryDateStr'] = ($row['HISTORY_DT']) ? date_format($row['HISTORY_DT'], "Y-m-d") : '';

            if ($search_keyword && strpos($tab4_text, 'active') !== false) {
                if (strpos($row['REGISTER_NO'], $search_keyword) !== false || 
                    strpos($row['NAME'], $search_keyword) !== false ||
                    strpos($row['NUMBER'], $search_keyword) !== false) {
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

    <script language="javascript">
        //이미지 확대 스크립트 (모달 사용)
        function bigimg(imageUrl){ 
            document.getElementById('bigModalImage').src = imageUrl;
            $('#imageModal').modal('show');
        }
    </script>

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
    <script>
        // Preload instrument data for the action modal
        const instrumentData = <?php echo json_encode($title); ?>;
    </script>

    <div id="wrapper">      
        
        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">검교정</h1>
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
                                            <a class="nav-link <?php echo h($tab3);?>" id="tab-three" data-toggle="pill" href="#tab3">라벨발행</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab4);?>" id="tab-four" data-toggle="pill" href="#tab4">이력</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-3" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 시험실 검교정 관리 전산화<BR><BR>   
                                            [제작일]<BR>
                                            - 25.01.11<br><br>  
                                        </div>
                                        
                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="tab3" role="tabpanel" aria-labelledby="tab-three"> 
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h6 class="m-0 font-weight-bold text-primary">라벨발행</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="calibration_label_force.php"> 
                                                    <div class="collapse show" id="collapseCardExample31">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>선택</label>
                                                                <select name="title31" class="form-control select2" style="width: 100%;">
                                                                    <option value="" selected="selected">선택</option>
                                                                    <?php foreach ( $title as $option ) : ?>
                                                                        <option value="<?php echo h($option['REGISTER_NO']); ?>"><?php echo h($option['REGISTER_NO'].'.'.$option['NAME'].'_'.$option['NUMBER']); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt31">발행</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div>
                                        </div> 

                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">  
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample20" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample20">
                                                    <h6 class="m-0 font-weight-bold text-primary">등록</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="calibration.php"> 
                                                    <div class="collapse" id="collapseCardExample20">                                    
                                                        <div class="card-body p-3">
                                                            <div class="row">  
                                                                <?php 
                                                                    $fields = [
                                                                        ['name'=>'kind20', 'label'=>'대분류', 'icon'=>'fa-th-list'],
                                                                        ['name'=>'name20', 'label'=>'계측기명', 'icon'=>'fa-dice-d6'],
                                                                        ['name'=>'number20', 'label'=>'기기번호', 'icon'=>'fa-list-ol'],
                                                                        ['name'=>'buy20', 'label'=>'구입처', 'icon'=>'fa-shopping-cart'],
                                                                        ['name'=>'model20', 'label'=>'규격', 'icon'=>'fa-ruler'],
                                                                        ['name'=>'department20', 'label'=>'관리부서', 'icon'=>'fa-users'],
                                                                        ['name'=>'team20', 'label'=>'해당공정(담당팀)', 'icon'=>'fa-cog'],
                                                                        ['name'=>'location20', 'label'=>'해당공정(장소)', 'icon'=>'fa-map-marker-alt'],
                                                                        ['name'=>'share20', 'label'=>'Share 여부', 'icon'=>'fa-share', 'required'=>false],
                                                                        ['name'=>'note20', 'label'=>'비고', 'icon'=>'fa-sticky-note', 'required'=>false],
                                                                    ];
                                                                    foreach($fields as $f):
                                                                ?>
                                                                <div class="col-md-4 col-12 mb-2">
                                                                    <div class="form-group mb-0">
                                                                        <label><?php echo $f['label']; ?></label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas <?php echo $f['icon']; ?>"></i></span></div>
                                                                            <input type="text" class="form-control" name="<?php echo $f['name']; ?>" <?php echo isset($f['required']) && !$f['required'] ? '' : 'required'; ?>>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endforeach; ?>
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">                                                                
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt20">입력</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div>
 
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h6 class="m-0 font-weight-bold text-primary">업로드</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="calibration_upload.php" enctype="multipart/form-data"> 
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body p-3">
                                                            <div class="row">                                                                        
                                                                <div class="col-md-6 mb-2">
                                                                    <div class="form-group mb-0">
                                                                        <label>선택</label>
                                                                        <select name="title" class="form-control select2" style="width: 100%;">
                                                                            <option value="" selected="selected">선택</option>
                                                                            <?php foreach ( $title as $option ) : ?>
                                                                                <option value="<?php echo h($option['REGISTER_NO']); ?>"><?php echo h($option['REGISTER_NO'].'.'.$option['NAME'].'_'.$option['NUMBER']); ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-0">
                                                                        <label>파일선택</label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="file" name="file"> 
                                                                            <label class="custom-file-label" for="file">파일선택</label>
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

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                    <h6 class="m-0 font-weight-bold text-primary">검사</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" onsubmit="return handleSubmit(event)"> 
                                                    <div class="collapse show" id="collapseCardExample23">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>QR코드 스캔</label>
                                                                <div class="input-group">                                                
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="QR23" id="QR23" autofocus required>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <div class="custom-control custom-switch d-inline-block mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="Switch1" <?php echo (isset($_GET['switch']) && $_GET['switch'] == '1') ? 'checked' : ''; ?>>
                                                                <label class="custom-control-label" for="customSwitch1">연속검사</label>
                                                            </div>
                                                            <div class="custom-control custom-switch d-inline-block mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" name="Switch2" <?php echo (isset($_GET['switch']) && $_GET['switch'] == '2') ? 'checked' : ''; ?>>
                                                                <label class="custom-control-label" for="customSwitch2">연속반입</label>
                                                            </div>
                                                            <div class="custom-control custom-switch d-inline-block mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch3" name="Switch3" <?php echo (isset($_GET['switch']) && $_GET['switch'] == '3') ? 'checked' : ''; ?>>
                                                                <label class="custom-control-label" for="customSwitch3">연속반출</label>
                                                            </div>
                                                            <div class="custom-control custom-switch d-inline-block mr-3">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch4" name="Switch4" <?php echo (isset($_GET['switch']) && $_GET['switch'] == '4') ? 'checked' : ''; ?>>
                                                                <label class="custom-control-label" for="customSwitch4">연속판정</label>
                                                            </div>
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt23">입력</button>
                                                        </div>
                                                    </form>     
                                                </div>
                                            </div> 

                                            <script>
                                                const switchElements = [
                                                    document.getElementById('customSwitch1'), document.getElementById('customSwitch2'),
                                                    document.getElementById('customSwitch3'), document.getElementById('customSwitch4')
                                                ];
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    switchElements.forEach((switchEl, index) => {
                                                        if (switchEl.checked) {
                                                            switchElements.forEach((otherSwitch, otherIndex) => { if (index !== otherIndex) otherSwitch.disabled = true; });
                                                        }
                                                    });
                                                });
                                                switchElements.forEach((switchEl, index) => {
                                                    switchEl.addEventListener('click', function(e) {
                                                        if (this.checked) {
                                                            switchElements.forEach((otherSwitch, otherIndex) => { if (index !== otherIndex) otherSwitch.disabled = true; });
                                                        } else {
                                                            switchElements.forEach(otherSwitch => { otherSwitch.disabled = false; });
                                                        }
                                                    });
                                                });

                                                function handleSubmit(event) {
                                                    event.preventDefault(); 
                                                    const qrValue = document.getElementById('QR23').value;
                                                    const switch1 = document.getElementById('customSwitch1').checked;
                                                    const switch2 = document.getElementById('customSwitch2').checked;
                                                    const switch3 = document.getElementById('customSwitch3').checked;
                                                    const switch4 = document.getElementById('customSwitch4').checked;

                                                    const urlParams = new URL(qrValue).searchParams;
                                                    const no = urlParams.get('no');

                                                    if (!no) { alert('QR코드에서 등록번호를 찾을 수 없습니다.'); return false; }

                                                    if (switch1 || switch2 || switch3 || switch4) {
                                                        const switchParams = `switch1=${switch1 ? '1' : '0'}&switch2=${switch2 ? '1' : '0'}&switch3=${switch3 ? '1' : '0'}&switch4=${switch4 ? '1' : '0'}`;
                                                        const finalUrl = `${qrValue}${qrValue.includes('?') ? '&' : '?'}${switchParams}`;
                                                        window.location.href = finalUrl;
                                                        return false;
                                                    }

                                                    const instrument = instrumentData.find(item => item.REGISTER_NO == no);
                                                    if (instrument) {
                                                        document.getElementById('actionModalTitle').innerText = `[검교정] ${instrument.REGISTER_NO}. ${instrument.NAME}_${instrument.NUMBER}`;
                                                        document.getElementById('actionBtnInspect').onclick = function() { window.location.href = `calibration.php?registerno=${no}&flag=inspect`; };
                                                        document.getElementById('actionBtnIn').onclick = function() { window.location.href = `calibration.php?registerno=${no}&flag=in`; };
                                                        document.getElementById('actionBtnOut').onclick = function() { window.location.href = `calibration.php?registerno=${no}&flag=out`; };
                                                        document.getElementById('actionBtnJudge').onclick = function() { window.location.href = `calibration.php?registerno=${no}&flag=check`; };
                                                        $('#actionModal').modal('show');
                                                    } else {
                                                        alert('해당 등록번호의 계측기를 찾을 수 없습니다.');
                                                    }
                                                    return false;
                                                }
                                            </script>

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h6 class="m-0 font-weight-bold text-primary">리스트</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample22">
                                                    <div class="card-body table-responsive p-2"> 
                                                        <div class="row">
                                                            <div class="col-xl-4 col-md-4 col-12 mb-2">
                                                                <div class="card border-left-primary shadow h-100 py-2 clickable-card" onclick="location.href='calibration.php?tab=list'">
                                                                    <div class="card-body">
                                                                        <div class="row no-gutters align-items-center">
                                                                            <div class="col mr-2">
                                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">전체수량</div>
                                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($Count_calibration); ?></div>
                                                                            </div>
                                                                            <div class="col-auto"><i class="fas fa-list fa-2x text-gray-300"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-md-4 col-12 mb-2">
                                                                <div class="card border-left-info shadow h-100 py-2 clickable-card" onclick="location.href='calibration.php?tab=list&filter_status=scheduled'">
                                                                    <div class="card-body">
                                                                        <div class="row no-gutters align-items-center">
                                                                            <div class="col mr-2">
                                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">금년 검교정 예정</div>
                                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($Count_calibration-$Count_calibrationJudege); ?></div>
                                                                            </div>
                                                                            <div class="col-auto"><i class="fas fa-wrench fa-2x text-gray-300"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-md-4 col-12 mb-2">
                                                                <div class="card border-left-success shadow h-100 py-2 clickable-card" onclick="location.href='calibration.php?tab=list&filter_status=completed'">
                                                                    <div class="card-body">
                                                                        <div class="row no-gutters align-items-center">
                                                                            <div class="col mr-2">
                                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">금년 검교정 완료</div>
                                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($Count_calibrationJudege); ?></div>
                                                                            </div>
                                                                            <div class="col-auto"><i class="fas fa-user-check fa-2x text-gray-300"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 

                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="GET" action="calibration.php">
                                                                <?php if($filter_status): ?>
                                                                    <input type="hidden" name="filter_status" value="<?php echo h($filter_status); ?>">
                                                                <?php endif; ?>
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="등록번호/명칭/번호 검색" value="<?= h($search_keyword) ?>">
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
                                                                        <th>등록번호</th>
                                                                        <th>대분류</th>   
                                                                        <th>계측기명</th>
                                                                        <th>기기번호</th>
                                                                        <th>구입처</th>
                                                                        <th>규격</th>
                                                                        <th>관리부서</th>
                                                                        <th>교정주기</th>
                                                                        <th>교정일자(검사일)</th>
                                                                        <th>차기교정일</th>
                                                                        <th>검사</th>
                                                                        <th>판정</th>
                                                                        <th>반출</th>
                                                                        <th>해당공정(담당팀)</th>
                                                                        <th>해당공정(장소)</th>
                                                                        <th>Share여부</th>
                                                                        <th>비고</th>
                                                                        <th>성적서</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($calibration_list as $Data_calibration): ?>
                                                                        <tr> 
                                                                            <td data-label="등록번호"><?php echo h($Data_calibration['REGISTER_NO']); ?></td>   
                                                                            <td data-label="대분류"><?php echo h($Data_calibration['KIND']); ?></td> 
                                                                            <td data-label="계측기명"> 
                                                                                <?php
                                                                                    $registerNo = $Data_calibration['REGISTER_NO'] ?? '';
                                                                                    $imageWebPath = ''; 
                                                                                    if (!empty($registerNo)) {
                                                                                        $baseServerPath = __DIR__ . '/../img/calibration/' . $registerNo;
                                                                                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                                                                        foreach ($allowedExtensions as $ext) {
                                                                                            if (file_exists($baseServerPath . '.' . $ext)) {
                                                                                                $imageWebPath = '../img/calibration/' . $registerNo . '.' . $ext;
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    if ($imageWebPath) {
                                                                                ?>
                                                                                    <a href="#" onclick="bigimg('<?php echo h($imageWebPath); ?>'); return false;" style="cursor: pointer;">
                                                                                        <?php echo h($Data_calibration['NAME']); ?>
                                                                                    </a>
                                                                                <?php } else { echo h($Data_calibration['NAME']); } ?>
                                                                            </td>  
                                                                            <td data-label="기기번호"><?php echo h($Data_calibration['NUMBER']); ?></td>  
                                                                            <td data-label="구입처"><?php echo h($Data_calibration['BUY']); ?></td>  
                                                                            <td data-label="규격"><?php echo h($Data_calibration['STANDARD']); ?></td>  
                                                                            <td data-label="관리부서"><?php echo h($Data_calibration['MANAGER']); ?></td>  
                                                                            <td data-label="교정주기"><?php echo h($Data_calibration['CYCLE']); ?></td>  
                                                                            <td data-label="교정일자"><?php echo h($Data_calibration['LastCalibrationDateStr']); ?></td>
                                                                            <td data-label="차기교정일"><?php echo h($Data_calibration['NewDateStr']); ?></td> 
                                                                            <td data-label="검사"><?php echo h($Data_calibration['INSPECT']); ?></td>    
                                                                            <td data-label="판정"><?php echo h($Data_calibration['JUDGMENT']); ?></td>  
                                                                            <td data-label="반출"><?php echo h($Data_calibration['OUT_YN']); ?></td>  
                                                                            <td data-label="담당팀"><?php echo h($Data_calibration['APPLY_TEAM']); ?></td>  
                                                                            <td data-label="장소"><?php echo h($Data_calibration['APPLY_LOCATION']); ?></td>  
                                                                            <td data-label="Share"><?php echo h($Data_calibration['SHARE']); ?></td>                                                                                      
                                                                            <td data-label="비고"><?php echo h($Data_calibration['NOTE']); ?></td>  
                                                                            <td data-label="성적서">
                                                                            <?php if(!empty($Data_calibration['FILE_NAME'])) { ?>   
                                                                                    <a href="https://fms.iwin.kr/files/<?php echo h($Data_calibration['FILE_NAME']);?>.<?php echo h($Data_calibration['FILE_EXTENSION']);?>" target="_blank">
                                                                                        <span class="fa-stack fa-1x">                                    
                                                                                        <i class="fas fa-square fa-stack-2x"></i>
                                                                                        <i class="fas fa-file fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>    
                                                                                    </a>
                                                                            <?php } ?>
                                                                            </td>
                                                                        </tr>                                                                           
                                                                    <?php endforeach; ?>
                                                                    <?php if(empty($calibration_list)): ?>
                                                                        <tr><td colspan="18" class="text-center no-data">데이터가 없습니다.</td></tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>                                                                    
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>                                          
                                        </div>  

                                        <div class="tab-pane fade <?php echo h($tab4_text);?>" id="tab4" role="tabpanel" aria-labelledby="tab-four"> 
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                    <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="calibration.php"> 
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
                                                        
                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="POST" action="calibration.php">
                                                                <input type="hidden" name="bt41" value="on">
                                                                <input type="hidden" name="tab" value="history">
                                                                <input type="hidden" name="dt4" value="<?php echo h($dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="등록번호/명칭 검색" value="<?= h($search_keyword) ?>">
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
                                                                    <th>등록번호</th>
                                                                    <th>대분류</th>   
                                                                    <th>계측기명</th>
                                                                    <th>기기번호</th>
                                                                    <th>구입처</th>
                                                                    <th>규격</th>
                                                                    <th>관리부서</th>
                                                                    <th>교정주기</th>
                                                                    <th>교정일자(검사일)</th>
                                                                    <th>검사</th>
                                                                    <th>판정</th>
                                                                    <th>반출</th>
                                                                    <th>해당공정(담당팀)</th>
                                                                    <th>해당공정(장소)</th>
                                                                    <th>Share여부</th>
                                                                    <th>비고</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($history_list as $Data_Select): ?>
                                                                <tr>
                                                                    <td data-label="등록번호"><?php echo h($Data_Select['REGISTER_NO']); ?></td> 
                                                                    <td data-label="대분류"><?php echo h($Data_Select['KIND']); ?></td>   
                                                                    <td data-label="계측기명"><?php echo h($Data_Select['NAME']); ?></td> 
                                                                    <td data-label="기기번호"><?php echo h($Data_Select['NUMBER']); ?></td> 
                                                                    <td data-label="구입처"><?php echo h($Data_Select['BUY']); ?></td> 
                                                                    <td data-label="규격"><?php echo h($Data_Select['STANDARD']); ?></td> 
                                                                    <td data-label="관리부서"><?php echo h($Data_Select['MANAGER']); ?></td> 
                                                                    <td data-label="교정주기"><?php echo h($Data_Select['CYCLE']); ?></td> 
                                                                    <td data-label="교정일자"><?php echo h($Data_Select['HistoryDateStr']); ?></td> 
                                                                    <td data-label="검사"><?php echo h($Data_Select['INSPECT']); ?></td> 
                                                                    <td data-label="판정"><?php echo h($Data_Select['JUDGMENT']); ?></td> 
                                                                    <td data-label="반출"><?php echo h($Data_Select['OUT_YN']); ?></td> 
                                                                    <td data-label="담당팀"><?php echo h($Data_Select['APPLY_TEAM']); ?></td> 
                                                                    <td data-label="장소"><?php echo h($Data_Select['APPLY_LOCATION']); ?></td> 
                                                                    <td data-label="Share"><?php echo h($Data_Select['SHARE']); ?></td> 
                                                                    <td data-label="비고"><?php echo h($Data_Select['NOTE']); ?></td> 
                                                                </tr>
                                                                <?php endforeach; ?>
                                                                <?php if(empty($history_list)): ?>
                                                                    <tr><td colspan="16" class="text-center no-data">데이터가 없습니다.</td></tr>
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
                    
                    </div> </div> </div> </div> </div> <div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="actionModalLabel">작업 선택</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <p id="actionModalTitle" class="font-weight-bold mb-3"></p>
            <div class="popup-buttons">            
                <button id="actionBtnInspect" class="btn btn-primary m-1">검사</button>
                <button id="actionBtnIn" class="btn btn-info m-1">반입</button>
                <button id="actionBtnOut" class="btn btn-warning m-1">반출</button>
                <button id="actionBtnJudge" class="btn btn-success m-1">판정</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="imageModalLabel">계측기 이미지</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <img src="" id="bigModalImage" class="img-fluid" alt="Instrument Image">
          </div>
        </div>
      </div>
    </div>

    <?php include '../plugin_lv1.php'; ?>  
</body>
</html>

<?php 
    // DB 자원 해제
    if(isset($connect4)) { mysqli_close($connect4); }
    mysqli_close($connect);
?>