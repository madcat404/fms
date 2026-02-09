<?php 
  include 'equipment_management_status.php';  
  $active_tab = isset($_GET['filter']) ? 'tab_list' : 'tab_board';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>
    <style>
        #table_spread { border: 1px solid #dee2e6 !important; border-collapse: collapse !important; }
        #table_spread th, #table_spread td { border: 1px solid #dee2e6 !important; vertical-align: middle !important; }
        .table-info-th { background-color: #f8f9fc; text-align: center; font-weight: bold; }
        .equipment-img-pc { width: 100px; height: 75px; object-fit: contain; border: 1px solid #e3e6f0; border-radius: 4px; }
        .modal-body { max-height: 60vh; overflow-y: auto; }
        .clickable-card { cursor: pointer; transition: 0.3s; }
        .clickable-card:hover { transform: translateY(-5px); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; }
        
        /* [추가] 배치도 iframe용 스타일: 클릭/드래그 방지 */
        .readonly-iframe {
            pointer-events: none; /* 마우스 이벤트 차단 (클릭, 스크롤, 드래그 방지) */
            user-select: none;    /* 텍스트 선택 방지 */
            border: 0;
        }
    </style>
    <script>
        function openHistoryModal(eqNum, eqName) {
            $('#historyModalLabel').text(eqName + " (No." + eqNum + ") 상세 이력");
            $('#historyTableBody').html("<tr><td colspan='5' class='text-center'>데이터 로딩 중...</td></tr>");
            $('#historyModal').modal('show');
            $.ajax({
                url: 'equipment_management_status.php',
                type: 'POST',
                data: { ajax_history: 'yes', eq_num: eqNum },
                success: function(response) { $('#historyTableBody').html(response); },
                error: function() { $('#historyTableBody').html("<tr><td colspan='5' class='text-center'>오류 발생</td></tr>"); }
            });
        }
        function goFilter(type) { location.href = 'equipment_management.php?filter=' + type; }
    </script>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include '../nav.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">장비 관리 시스템</h1>
                    </div>                       

                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a></li>
                                <li class="nav-item"><a class="nav-link <?= $active_tab == 'tab_board' ? 'active' : '' ?>" id="tab-three" data-toggle="pill" href="#tab_board">대시보드</a></li>
                                <li class="nav-item"><a class="nav-link <?= $active_tab == 'tab_list' ? 'active' : '' ?>" id="tab-two" data-toggle="pill" href="#tab_list">장비 대장</a></li>
                                <li class="nav-item"><a class="nav-link" href="layout_view.php">장비 배치도</a></li>
                            </ul>
                        </div>
                        <div class="card-body p-2">
                            <div class="tab-content">
                                <div class="tab-pane fade p-3" id="tab1" role="tabpanel">
                                    <h6 class="font-weight-bold text-primary">[목표]</h6>
                                    <p class="small">- 시험실 장비관리 전산화</p>
                                    <h6 class="font-weight-bold text-primary">[참조]</h6>
                                    <p class="small">- 요청자: 전우준<br>- 사용자: 시험팀</p>
                                    <h6 class="font-weight-bold text-primary">[제작일]</h6>
                                    <p class="small">- 26.02.02</p>
                                </div>

                                <div class="tab-pane fade <?= $active_tab == 'tab_board' ? 'show active' : '' ?>" id="tab_board" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-3 col-md-6 mb-2">
                                            <div class="card border-left-primary shadow py-2 clickable-card" onclick="goFilter('all')">
                                                <div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">전체수량</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts['total'] ?>대</div></div><div class="col-auto"><i class="fas fa-list fa-2x text-gray-300"></i></div></div></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6 mb-2">
                                            <div class="card border-left-danger shadow py-2 clickable-card" onclick="goFilter('inspect')">
                                                <div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-danger text-uppercase mb-1">점검 필요(1년초과)</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts['need_inspect'] ?>대</div></div><div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div></div></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6 mb-2">
                                            <div class="card border-left-warning shadow py-2 clickable-card" onclick="goFilter('out')">
                                                <div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-warning text-uppercase mb-1">반출</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts['out'] ?>대</div></div><div class="col-auto"><i class="fas fa-sign-out-alt fa-2x text-gray-300"></i></div></div></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6 mb-2">
                                            <div class="card border-left-success shadow py-2 clickable-card" onclick="goFilter('in')">
                                                <div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-success text-uppercase mb-1">반입</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts['in'] ?>대</div></div><div class="col-auto"><i class="fas fa-sign-in-alt fa-2x text-gray-300"></i></div></div></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-3">
                                        <div class="col-lg-6">
                                            <div class="card shadow mb-4">
                                                <div class="card-header py-3 bg-danger"><h6 class="m-0 font-weight-bold text-white"><i class="fas fa-map-marked-alt mr-2"></i>시험실 장비 배치도</h6></div>
                                                <div class="card-body p-0" style="height:400px; overflow:hidden; background-color: #f8f9fa;">
                                                    <iframe src="layout_view.php?view_only=1" width="100%" height="100%" frameborder="0" scrolling="no" class="readonly-iframe"></iframe>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="card shadow mb-4">
                                                <div class="card-header py-3 bg-primary"><h6 class="m-0 font-weight-bold text-white"><i class="fas fa-history mr-2"></i>최근 장비 이력 (TOP 7)</h6></div>
                                                <div class="card-body p-0">
                                                    <table class="table table-bordered mb-0" style="font-size:0.85rem;">
                                                        <thead class="bg-light text-center"><tr><th>기록일</th><th>장비명</th><th>반출/점검 사유</th><th>기록자</th></tr></thead>
                                                        <tbody>
                                                            <?php foreach($dashboard_history as $h): ?>
                                                            <tr>
                                                                <td class="text-center"><?= ($h['RECORD_DATE'] instanceof DateTime) ? date_format($h['RECORD_DATE'], "Y-m-d") : "-" ?></td>
                                                                <td class="text-center font-weight-bold"><?= $h['EQUIPMENT_NAME'] ?></td>
                                                                <td><?= htmlspecialchars($h['REASON']) ?></td>
                                                                <td class="text-center"><?= $h['RECORDER'] ?></td>
                                                            </tr>
                                                            <?php endforeach; if(empty($dashboard_history)) echo "<tr><td colspan='4' class='text-center p-3'>기록 없음</td></tr>"; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade <?= $active_tab == 'tab_list' ? 'show active' : '' ?>" id="tab_list" role="tabpanel">
                                    <div class="card shadow mb-2">
                                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                            <h6 class="m-0 font-weight-bold text-primary">장비 목록 <?= $filter != 'all' ? '(필터 적용됨)' : '' ?></h6>
                                            <?php if($filter != 'all'): ?>
                                                <button class="btn btn-sm btn-secondary" onclick="goFilter('all')">필터 해제</button>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover text-nowrap" id="table_spread">
                                                    <thead><tr class="table-info-th"><th>장비번호</th><th>사진</th><th>장비명</th><th>반입</th><th>반출</th><th>반출/점검 사유</th><th>기록일</th><th>기록자</th><th>상세이력</th></tr></thead>
                                                    <tbody>
                                                        <?php if (!empty($search_results_tab7)): foreach($search_results_tab7 as $res): 
                                                            $in_date = ($res['IN_DATE'] instanceof DateTime) ? date_format($res['IN_DATE'], "Y-m-d") : "-";
                                                            $out_date = ($res['OUT_DATE'] instanceof DateTime) ? date_format($res['OUT_DATE'], "Y-m-d") : "-";
                                                            $record_date = ($res['RECORD_DATE'] instanceof DateTime) ? date_format($res['RECORD_DATE'], "Y-m-d") : "-";
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?= $res['EQUIPMENT_NUM'] ?></td>
                                                            <td class="text-center"></td>
                                                            <td class="font-weight-bold"><?= $res['EQUIPMENT_NAME'] ?></td>
                                                            <td class="text-center"><?= $in_date ?></td>
                                                            <td class="text-center"><?= $out_date ?></td>
                                                            <td style="white-space:normal; min-width:200px;"><?= htmlspecialchars($res['REASON']) ?></td>
                                                            <td class="text-center"><?= $record_date ?></td>
                                                            <td class="text-center"><?= $res['RECORDER'] ?></td>
                                                            <td class="text-center"><button class="btn btn-sm btn-info" onclick="openHistoryModal('<?= $res['EQUIPMENT_NUM'] ?>', '<?= addslashes($res['EQUIPMENT_NAME']) ?>')">기록</button></td>
                                                        </tr>
                                                        <?php endforeach; else: echo "<tr><td colspan='9' class='text-center p-4'>데이터가 없습니다.</td></tr>"; endif; ?>
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
        </div>
    </div>
    
    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-primary" id="historyModalLabel">설비 상세 이력</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-info-th">
                            <tr><th>번호</th><th>내용</th><th>비용</th><th>기록자</th><th>날짜</th></tr>
                        </thead>
                        <tbody id="historyTableBody"></tbody>
                    </table>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button></div>
            </div>
        </div>
    </div>

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>