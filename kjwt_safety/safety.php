<?php
    // kjwt_safety/safety.php
    // 프론트엔드: 화면 UI, 탭 처리, 데이터 표시
    // 수정사항: 날짜 조회 버그 수정 (PC/모바일 입력창 구분)
    
    // 1. 백엔드 로직 호출
    include 'safety_status.php'; 
    include_once '../FUNCTION.php';

    // XSS 방지 함수
    function e($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    $is_mobile = isMobile();

    // 탭 활성화 처리
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab1';
    $tab1_class = ($active_tab === 'tab1') ? 'active show' : '';
    $tab2_class = ($active_tab === 'tab2') ? 'active show' : '';
    $tab3_class = ($active_tab === 'tab3') ? 'active show' : '';
    $tab4_class = ($active_tab === 'tab4') ? 'active show' : '';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>
    <style>
        /* 모바일 최적화 스타일 */
        .mobile-search-input {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 0;
            background-color: #ffffff !important;
            color: #495057;
            border: 1px solid #d1d3e2;
        }
        .mobile-search-btn {
            width: 60px;
            border-radius: 0;
        }
        .mobile-card {
            border: 0 !important;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
            margin-bottom: 0.8rem;
            border-radius: 0.5rem;
        }
        
        .big-checkbox { transform: scale(1.5); cursor: pointer; }
        .check-question { font-weight: bold; margin-bottom: 0.8rem; font-size: 1.05em; color: #4e73df; }
        .btn-group-toggle .btn { font-weight: bold; }
        .btn-loc { min-width: 100px; margin: 5px; } 
        
        @media (max-width: 768px) {
            .nav-tabs .nav-link {
                padding: 0.75rem 0.5rem;
                font-size: 0.9rem;
            }
            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }
        }
    </style>
    <script>
        // [수정] 날짜 조회 함수: 어떤 입력창(inputId)을 사용할지 명시적으로 받음
        function changeDate(inputId) {
            var dateInput = document.getElementById(inputId);
            if (!dateInput) {
                alert("날짜 입력창을 찾을 수 없습니다.");
                return;
            }
            var dateVal = dateInput.value;
            
            var loc = "<?php echo urlencode($location_param); ?>";
            if(!loc) {
                alert("장소를 먼저 선택해주세요.");
                return;
            }
            location.href = "<?php echo $SELF; ?>?tab=tab2&loc=" + loc + "&search_date=" + dateVal;
        }

        function openLocationModal() {
            $('#locationModal').modal('show');
        }

        // 신문고 상태 변경 요청 함수
        function promptStatusUpdate(id) {
            var password = prompt("관리자 비밀번호를 입력하세요:", "");
            if (password === null) return; // 사용자가 취소한 경우

            var comment = prompt("조치 내용을 입력하세요:", "");
            if (comment === null) return; // 사용자가 취소한 경우

            if (password !== "" && comment.trim() !== "") {
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "<?php echo $SELF; ?>?tab=tab4";
                
                var inputMode = document.createElement("input");
                inputMode.type = "hidden";
                inputMode.name = "mode";
                inputMode.value = "status_update";
                form.appendChild(inputMode);
                
                var inputId = document.createElement("input");
                inputId.type = "hidden";
                inputId.name = "id";
                inputId.value = id;
                form.appendChild(inputId);
                
                var inputPw = document.createElement("input");
                inputPw.type = "hidden";
                inputPw.name = "password";
                inputPw.value = password;
                form.appendChild(inputPw);

                var inputComment = document.createElement("input");
                inputComment.type = "hidden";
                inputComment.name = "comment";
                inputComment.value = comment;
                form.appendChild(inputComment);
                
                document.body.appendChild(form);
                form.submit();
            } else {
                alert("비밀번호와 조치 내용을 모두 입력해야 합니다.");
            }
        }

        $(document).ready(function() {
            var activeTab = "<?php echo $active_tab; ?>";
            var loc = "<?php echo $location_param; ?>";
            if (activeTab === 'tab2' && !loc) {
                $('#locationModal').modal('show');
            }
        });
    </script>
</head>

<body id="page-top">
    <div id="wrapper">      
        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                <i class="fa fa-bars"></i>
                            </button>   
                            <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">
                                <?php echo $is_mobile ? '안전관리' : '안전 점검 시스템'; ?>
                            </h1>
                        </div>
                    </div>              

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab1_class; ?>" href="<?php echo $SELF; ?>?tab=tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2_class; ?>" href="#" onclick="openLocationModal(); return false;">체크리스트</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3_class; ?>" href="<?php echo $SELF; ?>?tab=tab3">법적기준</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4_class; ?>" href="<?php echo $SELF; ?>?tab=tab4">신문고</a>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="card-body p-2 p-md-4">
                                    <div class="tab-content">
                                        
                                        <div class="tab-pane fade <?php echo $tab1_class; ?>" id="tab1" role="tabpanel">
                                            <div class="alert alert-info mobile-card">
                                                <h5><i class="icon fas fa-info-circle"></i> 사용 가이드</h5>
                                                <ul class="mb-0 pl-3">
                                                    <li><strong>체크리스트:</strong> 장소를 선택하여 매월 안전 상태를 점검합니다.</li>
                                                    <li><strong>법적기준:</strong> 산업안전보건법 위반 시 과태료 및 처벌 기준을 확인합니다.</li>
                                                    <li><strong>신문고:</strong> 현장의 위험요소를 발견 즉시 신고합니다.</li>
                                                </ul>
                                            </div>
                                            <div class="text-center mt-4 mb-4">
                                                <div class="card shadow-sm d-inline-block p-4 mobile-card">
                                                    <h6 class="text-dark font-weight-bold mb-3">안전 신문고 바로가기</h6>
                                                    <img src="https://quickchart.io/qr?text=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $SELF . '?tab=tab4'); ?>&size=150" alt="QR코드" class="img-fluid" style="max-width: 120px;">
                                                    <p class="mt-2 text-muted small mb-0">스캔 시 신고 화면으로 이동</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab2_class; ?>" id="tab2" role="tabpanel">
                                            <?php if (empty($location_param)): ?>
                                                <div class="text-center py-5">
                                                    <i class="fas fa-map-marked-alt fa-3x text-gray-300 mb-3"></i>
                                                    <h4 class="text-gray-600 mb-4">점검할 장소를 선택해주세요.</h4>
                                                    <button type="button" class="btn btn-primary btn-lg shadow-sm" data-toggle="modal" data-target="#locationModal">
                                                        장소 선택하기
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                
                                                <div class="card shadow mb-3 d-block d-md-none border-0 bg-transparent">
                                                    <div class="input-group shadow-sm">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-secondary mobile-search-btn" type="button" onclick="openLocationModal()">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                            </button>
                                                        </div>
                                                        <input type="date" id="search_date_input_m" class="form-control mobile-search-input" value="<?php echo $search_date; ?>">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary mobile-search-btn" type="button" onclick="changeDate('search_date_input_m')">
                                                                이동
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-2">
                                                        <span class="badge badge-primary px-3 py-1"><?php echo e($location_param); ?></span> 점검표
                                                    </div>
                                                </div>

                                                <div class="d-none d-md-flex row mb-3 align-items-center">
                                                    <div class="col-md-6">
                                                        <h4 class="m-0 font-weight-bold text-primary">
                                                            <span class="badge badge-primary"><?php echo e($location_param); ?></span> 점검표
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <div class="form-inline justify-content-end">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary mr-3" data-toggle="modal" data-target="#locationModal">장소 변경</button>
                                                            <label class="mr-2">점검 일자:</label>
                                                            <div class="input-group">
                                                                <input type="date" id="search_date_input" class="form-control" value="<?php echo $search_date; ?>">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-primary" type="button" onclick="changeDate('search_date_input')">조회</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <form method="POST" action="<?php echo $SELF; ?>" onsubmit="return confirm('저장하시겠습니까?');">
                                                    <input type="hidden" name="mode" value="save">
                                                    <input type="hidden" name="location" value="<?php echo e($location_param); ?>">
                                                    <input type="hidden" name="check_date" value="<?php echo $search_date; ?>">

                                                    <?php if ($is_mobile): ?>
                                                        <div class="mobile-checklist-area">
                                                            <?php 
                                                            $idx = 1;
                                                            if (count($current_items) > 0) {
                                                                foreach ($current_items as $item) {
                                                                    $idx_key = (string)$idx; 
                                                                    $val = isset($check_data[$idx_key]) ? trim($check_data[$idx_key]) : '';
                                                            ?>
                                                                <div class="card mobile-card">
                                                                    <div class="card-body p-3">
                                                                        <div class="check-question">
                                                                            <span class="badge badge-light border mr-1"><?php echo $idx; ?>.</span>
                                                                            <?php echo $item; ?>
                                                                        </div>
                                                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                                                            <label class="btn btn-outline-success <?php if($val === 'O') echo 'active'; ?>">
                                                                                <input type="radio" name="check_item[<?php echo $idx; ?>]" value="O" <?php if($val === 'O') echo 'checked'; ?>> 양호
                                                                            </label>
                                                                            <label class="btn btn-outline-danger <?php if($val === 'X') echo 'active'; ?>">
                                                                                <input type="radio" name="check_item[<?php echo $idx; ?>]" value="X" <?php if($val === 'X') echo 'checked'; ?>> 불량
                                                                            </label>
                                                                            <label class="btn btn-outline-secondary <?php if($val === 'N/A') echo 'active'; ?>">
                                                                                <input type="radio" name="check_item[<?php echo $idx; ?>]" value="N/A" <?php if($val === 'N/A') echo 'checked'; ?>> N/A
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php $idx++; }
                                                            } else { echo "<div class='alert alert-warning mobile-card'>등록된 항목이 없습니다.</div>"; }
                                                            ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead class="thead-light text-center">
                                                                    <tr><th style="width: 50px;">NO</th><th>점검 항목</th><th style="width: 100px;">양호</th><th style="width: 100px;">불량</th><th style="width: 100px;">N/A</th></tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    $idx = 1;
                                                                    if (count($current_items) > 0) {
                                                                        foreach ($current_items as $item) { 
                                                                            $idx_key = (string)$idx;
                                                                            $val = isset($check_data[$idx_key]) ? trim($check_data[$idx_key]) : '';
                                                                    ?>
                                                                            <tr>
                                                                                <td class="text-center align-middle"><?php echo $idx; ?></td>
                                                                                <td class="align-middle"><?php echo $item; ?></td>
                                                                                <td class="text-center align-middle"><input type="radio" name="check_item[<?php echo $idx; ?>]" value="O" class="big-checkbox" <?php if($val === 'O') echo 'checked="checked"'; ?>></td>
                                                                                <td class="text-center align-middle"><input type="radio" name="check_item[<?php echo $idx; ?>]" value="X" class="big-checkbox" <?php if($val === 'X') echo 'checked="checked"'; ?>></td>
                                                                                <td class="text-center align-middle"><input type="radio" name="check_item[<?php echo $idx; ?>]" value="N/A" class="big-checkbox" <?php if($val === 'N/A') echo 'checked="checked"'; ?>></td>
                                                                            </tr>
                                                                    <?php $idx++; } } else { echo "<tr><td colspan='5' class='text-center'>등록된 점검 항목이 없습니다.</td></tr>"; } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="form-group mt-3">
                                                        <label class="font-weight-bold ml-1">특이사항</label>
                                                        <textarea class="form-control mobile-search-input" style="height:auto;" name="note" rows="3" placeholder="점검 중 특이사항이 있다면 입력해주세요."><?php echo e($saved_note); ?></textarea>
                                                    </div>
                                                    
                                                    <div class="row mt-4 mb-5">
                                                        <div class="col-6 d-flex align-items-center text-muted pl-4">
                                                            <small>작성자: <?php echo e($saved_writer ? $saved_writer : '-'); ?></small>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5 mobile-search-btn" style="width:auto;">저장</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php endif; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab3_class; ?>" id="tab3" role="tabpanel">
                                            <div class="d-none d-md-block mb-3">
                                                <h6 class="m-0 font-weight-bold text-primary">산업안전보건법 위반 시 과태료 및 처벌 기준</h6>
                                            </div>
                                            <?php if (empty($safety_law_data)): ?>
                                                <div class="text-center py-5">등록된 데이터가 없습니다.</div>
                                            <?php else: ?>
                                                <?php if($is_mobile): ?>
                                                    <?php foreach ($safety_law_data as $row): 
                                                        $isPenalty = (strpos($row['LAW_TYPE'], '처벌') !== false);
                                                        $typeColor = $isPenalty ? 'text-danger' : 'text-warning';
                                                        $appText = $row['IS_APPLICABLE'];
                                                    ?>
                                                    <div class="card mobile-card">
                                                        <div class="card-body p-3">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto pr-0">
                                                                    <div class="bg-gray-100 d-flex align-items-center justify-content-center rounded-circle" style="width:50px; height:50px;">
                                                                        <i class="fas fa-gavel <?php echo $typeColor; ?> fa-lg"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="col pl-3">
                                                                    <div class="h6 font-weight-bold text-dark mb-1"><?php echo e($row['CATEGORY']); ?></div>
                                                                    <div class="small text-danger font-weight-bold"><?php echo e($row['PENALTY_CONTENT']); ?></div>
                                                                    <div class="text-xs text-gray-500 mt-1"><?php echo e($row['LEGAL_BASIS']); ?></div>
                                                                </div>
                                                            </div>
                                                            <?php if($appText === 'Y'): ?>
                                                                <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                                                                    <span class="badge badge-danger">당사 해당</span>
                                                                    <span class="text-xs text-primary"><?php echo e($row['ACTION_PLAN']); ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover" width="100%" cellspacing="0" id="table1">
                                                            <thead class="thead-light text-center">
                                                                <tr><th style="width: 80px;">구분</th><th>위반 내용</th><th style="width: 15%;">금액/처벌</th><th style="width: 20%;">법적 근거</th><th style="width: 60px;">해당</th><th>조치 계획</th><th>조치 현황</th></tr>
                                                            </thead>
                                                            <tbody class="text-dark">
                                                                <?php foreach ($safety_law_data as $row) {
                                                                    $badgeClass = (strpos($row['LAW_TYPE'], '처벌') !== false) ? 'badge-danger' : 'badge-warning';
                                                                    $appText = $row['IS_APPLICABLE'];
                                                                    $appStyle = ($appText === 'Y') ? 'color:red; font-weight:bold;' : (($appText === 'N') ? 'color:#ccc;' : '');
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center align-middle"><span class="badge <?php echo $badgeClass; ?>"><?php echo e($row['LAW_TYPE']); ?></span></td>
                                                                    <td class="align-middle" style="word-break: keep-all;"><?php echo e($row['CATEGORY']); ?></td>
                                                                    <td class="align-middle text-right font-weight-bold"><?php echo e($row['PENALTY_CONTENT']); ?></td>
                                                                    <td class="align-middle small text-muted"><?php echo e($row['LEGAL_BASIS']); ?></td>
                                                                    <td class="text-center align-middle" style="<?php echo $appStyle; ?>"><?php echo e($appText); ?></td>
                                                                    <td class="align-middle"><?php echo e($row['ACTION_PLAN']); ?></td>
                                                                    <td class="align-middle small"><?php echo e($row['EVIDENCE']); ?></td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab4_class; ?>" id="tab4" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-5 mb-4 order-lg-1 order-1">
                                                    <div class="card mobile-card">
                                                        <div class="card-header bg-danger text-white border-0" style="border-radius: 0.5rem 0.5rem 0 0;">
                                                            <h6 class="m-0 font-weight-bold"><i class="fas fa-exclamation-triangle"></i> 위험요소 신고</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="POST" action="<?php echo $SELF; ?>" onsubmit="return confirm('신고하시겠습니까?');">
                                                                <input type="hidden" name="mode" value="report_save">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold small">발견 장소 <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control mobile-search-input" name="risk_location" placeholder="예: A동 2층 계단" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold small">제목 (위험 요소) <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control mobile-search-input" name="risk_title" placeholder="위험 내용을 요약해주세요" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold small">상세 내용</label>
                                                                    <textarea class="form-control mobile-search-input" style="height:auto;" name="risk_content" rows="4" placeholder="상황을 구체적으로 설명해주세요"></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold small">신고자</label>
                                                                    <input type="text" class="form-control mobile-search-input" name="reporter" placeholder="이름 (선택: 미입력 시 익명)" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>">
                                                                </div>
                                                                <button type="submit" class="btn btn-danger btn-block btn-lg shadow-sm mt-4 mobile-search-btn" style="width:100%; border-radius:0.5rem;">신고 접수</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-7 order-lg-2 order-2">
                                                    <div class="mb-3 pl-2">
                                                        <h6 class="font-weight-bold text-gray-800">최근 신고 현황</h6>
                                                    </div>
                                                    <?php if (empty($safety_board_data)): ?>
                                                        <div class="text-center py-5 text-gray-500 mobile-card p-4">신고된 내역이 없습니다.</div>
                                                    <?php else: ?>
                                                        <div class="list-group">
                                                            <?php foreach ($safety_board_data as $rpt): ?>
                                                                <div class="card mobile-card">
                                                                    <div class="card-body p-3">
                                                                        <div class="d-flex w-100 justify-content-between mb-2">
                                                                            <h6 class="mb-1 font-weight-bold text-dark">
                                                                                <span class="badge badge-secondary font-weight-normal mr-1"><?php echo e($rpt['RISK_LOCATION']); ?></span>
                                                                                <?php echo e($rpt['RISK_TITLE']); ?>
                                                                            </h6>
                                                                        </div>
                                                                        <p class="mb-2 text-secondary small bg-light p-2 rounded border-0">
                                                                            <?php echo nl2br(e($rpt['RISK_CONTENT'])); ?>
                                                                        </p>

                                                                        <?php if ($rpt['STATUS'] === '완료' && !empty($rpt['COMMENT'])): ?>
                                                                            <div class="mt-2 p-2 rounded border-left-success bg-light">
                                                                                <strong class="text-success small"><i class="fas fa-check-circle"></i> 조치 내용</strong>
                                                                                <p class="mb-0 text-gray-800 small" style="margin-top: 5px;"><?php echo nl2br(e($rpt['COMMENT'])); ?></p>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                        <div class="d-flex w-100 justify-content-between align-items-center mt-3">
                                                                            <small class="text-muted">
                                                                                <i class="far fa-clock"></i> 
                                                                                <?php 
                                                                                    $date = $rpt['REG_DATE'];
                                                                                    if ($date instanceof DateTime) echo $date->format('m-d H:i');
                                                                                    else echo substr($rpt['REG_DATE'], 5, 11);
                                                                                ?>
                                                                                <span class="ml-2 text-gray-400">|</span> 
                                                                                <span class="ml-2"><?php echo e($rpt['REPORTER']); ?></span>
                                                                            </small>
                                                                            <div>
                                                                                <?php 
                                                                                    $status = $rpt['STATUS'];
                                                                                    $statusBadge = 'secondary';
                                                                                    if($status == '조치중') $statusBadge = 'primary';
                                                                                    if($status == '완료') $statusBadge = 'success';
                                                                                ?>
                                                                                <span class="badge badge-<?php echo $statusBadge; ?> px-2 py-1"><?php echo e($status); ?></span>
                                                                                
                                                                                <?php if($status !== '완료'): ?>
                                                                                    <button type="button" class="btn btn-sm btn-outline-success ml-2" onclick="promptStatusUpdate(<?php echo $rpt['ID']; ?>)">
                                                                                        <i class="fas fa-check"></i> 완료처리
                                                                                    </button>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
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
    
    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">점검 장소 선택</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-4">점검하려는 장소를 선택해주세요.</p>
                    <div class="d-flex justify-content-center flex-wrap">
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('시험실'); ?>&tab=tab2&search_date=<?php echo $search_date; ?>" class="btn btn-outline-primary btn-lg btn-loc"><i class="fas fa-flask fa-2x d-block mb-2"></i>시험실</a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('연구소'); ?>&tab=tab2&search_date=<?php echo $search_date; ?>" class="btn btn-outline-success btn-lg btn-loc"><i class="fas fa-microscope fa-2x d-block mb-2"></i>연구소</a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('현장'); ?>&tab=tab2&search_date=<?php echo $search_date; ?>" class="btn btn-outline-warning btn-lg btn-loc"><i class="fas fa-hard-hat fa-2x d-block mb-2"></i>현장</a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('공무실'); ?>&tab=tab2&search_date=<?php echo $search_date; ?>" class="btn btn-outline-danger btn-lg btn-loc"><i class="fas fa-tools fa-2x d-block mb-2"></i>공무실</a>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center flex-wrap">
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('자재창고'); ?>&tab=tab2&search_date=<?php echo $search_date; ?>" class="btn btn-outline-primary btn-lg btn-loc"><i class="fas fa-boxes fa-2x d-block mb-2"></i>자재창고</a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('bb창고'); ?>&tab=tab2&search_date=<?php echo $search_date; ?>" class="btn btn-outline-success btn-lg btn-loc"><i class="fas fa-warehouse fa-2x d-block mb-2"></i>BB</a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('완성품창고'); ?>&tab=tab2&search_date=<?php echo $search_date; ?>" class="btn btn-outline-warning btn-lg btn-loc"><i class="fas fa-box-open fa-2x d-block mb-2"></i>완성품</a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('ecu창고'); ?>&tab=tab2&search_date=<?php echo $search_date; ?>" class="btn btn-outline-danger btn-lg btn-loc"><i class="fas fa-microchip fa-2x d-block mb-2"></i>ECU</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>