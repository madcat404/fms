<?php
// kjwt_ghp/ghp_repair.php
// GHP 및 AHU 수리 관리 페이지 (통합 관리)

session_start();

// 1. 세션 체크 및 DB 연결
require_once __DIR__ . '/../session/session_check.php';
include_once __DIR__ . '/../DB/DB2.php'; 
include_once __DIR__ . '/../FUNCTION.php';

// [중요] 보안 공유 URL용 키
$secret_key = 'ghp_repair_secure_key_2026';

// 2. 장비 ID 확인 (QR코드 접속 시 ?ghp_id=AHU-01 형태)
$Ghp_Id = $_GET['ghp_id'] ?? '';
$is_single_mode = !empty($Ghp_Id);

// 3. QR 접속 여부 확인 (nav 숨김 처리용)
$is_qr_access = (isset($_SESSION['level']) && $_SESSION['level'] === 'qr_access');

// 4. 탭 활성화 로직
$active_tab = isset($_POST['btSearch']) ? 'tab4' : (isset($_GET['tab']) ? $_GET['tab'] : 'tab3');

// 5. [기본 데이터 조회] 최근 내역
$historyList = [];
if (isset($connect) && $connect) {
    // GHP_ID 컬럼에 GHP-xx 또는 AHU-xx가 모두 저장됩니다.
    $sql = "SELECT TOP 50 REPAIR_SEQ, GHP_ID, WORKER_NAME, REPAIR_SYMPTOM, REPAIR_CONTENT, REPAIR_COST, CREATE_DT, ADMIN_CODE 
            FROM GHP_REPAIR_LOG ";
    $params = [];
    if ($is_single_mode) {
        $sql .= " WHERE GHP_ID = ? ";
        $params[] = $Ghp_Id;
    }
    $sql .= " ORDER BY CREATE_DT DESC";

    $stmt = sqlsrv_query($connect, $sql, $params);
    if ($stmt !== false) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $historyList[] = $row;
        }
    }
}

// 6. [검색 데이터 조회]
$searchList = [];
$searchDateRange = $_POST['dtSearch'] ?? ''; 
if (isset($_POST['btSearch']) && !empty($searchDateRange) && $connect) {
    $dates = explode(' ~ ', $searchDateRange);
    if (count($dates) == 2) {
        $sql_search = "SELECT REPAIR_SEQ, GHP_ID, WORKER_NAME, REPAIR_SYMPTOM, REPAIR_CONTENT, REPAIR_COST, CREATE_DT, ADMIN_CODE 
                       FROM GHP_REPAIR_LOG 
                       WHERE CREATE_DT >= ? AND CREATE_DT < DATEADD(day, 1, CAST(? AS DATE))";
        $params_search = [trim($dates[0]), trim($dates[1])];
        
        if ($is_single_mode) {
            $sql_search .= " AND GHP_ID = ? ";
            $params_search[] = $Ghp_Id;
        }
        $sql_search .= " ORDER BY CREATE_DT DESC";
        
        $stmt_search = sqlsrv_query($connect, $sql_search, $params_search);
        if ($stmt_search !== false) {
            while ($row = sqlsrv_fetch_array($stmt_search, SQLSRV_FETCH_ASSOC)) {
                $searchList[] = $row;
            }
        }
    }
}

// 공통 함수
function truncateText($text, $width = 30) {
    if (empty($text)) return '';
    return htmlspecialchars(mb_strimwidth($text, 0, $width, '...', 'UTF-8'));
}
function generateShareLink($repairSeq, $secret_key) {
    $token = hash_hmac('sha256', $repairSeq, $secret_key);
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
    $dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') . '/';
    return "{$protocol}://{$_SERVER['HTTP_HOST']}{$dir}ghp_view.php?RepairSeq={$repairSeq}&token={$token}";
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>
    <style>
        @media (max-width: 576px) { .table td, .table th { font-size: 0.85rem; padding: 0.5rem; } }
        .photo-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; margin-right: 2px; }
        .clickable-row { cursor: pointer; }
        .clickable-row:hover { background-color: #f8f9fc !important; }
        .mobile-card { border-left: 5px solid #4e73df; transition: all 0.2s; }
        .mobile-search-input { height: 50px; font-size: 1.1rem; border-radius: 0; background-color: #ffffff !important; color: #495057; border: 1px solid #d1d3e2; }
    </style>
    <script>
        function shareGhpLink(fullUrl, id, content) {
            const shareData = { title: '수리 내역 공유', text: `[FMS] ${id} - ${content}`, url: fullUrl };
            if (navigator.share) {
                navigator.share(shareData).catch((error) => console.log('공유 실패', error));
            } else {
                const tempInput = document.createElement("input");
                document.body.appendChild(tempInput);
                tempInput.value = fullUrl; tempInput.select();
                try {
                    document.execCommand("copy");
                    alert("공유 링크가 복사되었습니다.");
                } catch (e) {
                    prompt("이 주소를 복사하세요:", fullUrl);
                }
                document.body.removeChild(tempInput);
            }
        }
        
        function sendGhpMail(repairSeq) {
            if (!confirm("해당 수리 내역을 hr@iwin.kr로 발송하시겠습니까?")) return;
            $.ajax({
                url: '../mailer.php', 
                type: 'POST',
                data: { type: 'ghp_repair_notice', repair_seq: repairSeq },
                success: function(response) { alert(response); },
                error: function(xhr, status, error) { alert("통신 오류 발생"); console.error(error); }
            });
        }

        function goToView(id) { location.href = 'ghp_view.php?RepairSeq=' + id; }
    </script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php if (!$is_qr_access) include '../nav.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">
                            <i class="fas fa-wrench mr-2"></i>GHP/AHU 수리 관리 
                            <?= $is_single_mode ? "[".htmlspecialchars($Ghp_Id)."]" : "" ?>
                        </h1>
                    </div> 

                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link <?= ($active_tab == 'tab1') ? 'active' : '' ?>" data-toggle="pill" href="#tab1">공지</a></li>
                                <li class="nav-item"><a class="nav-link <?= ($active_tab == 'tab3') ? 'active' : '' ?>" data-toggle="pill" href="#tab3">등록</a></li>
                                <li class="nav-item"><a class="nav-link <?= ($active_tab == 'tab4') ? 'active' : '' ?>" data-toggle="pill" href="#tab4">내역 조회</a></li>
                            </ul>
                        </div>

                        <div class="card-body p-2">
                            <div class="tab-content">
                                <div class="tab-pane fade <?= ($active_tab == 'tab1') ? 'show active' : '' ?>" id="tab1">
                                    <div class="p-3">
                                        <h6 class="font-weight-bold text-primary">[작업 지침]</h6>
                                        <p>- GHP 및 AHU 장비의 수리/점검 내역을 통합 관리합니다.<br>
                                        - 현장 사진, 고장 증상, 비용을 정확히 입력해주세요.<br>
                                        - QR 코드로 접속 시 해당 장비가 자동으로 선택됩니다.</p>
                                    </div>
                                </div>

                                <div class="tab-pane fade <?= ($active_tab == 'tab3') ? 'show active' : '' ?>" id="tab3">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3 bg-gradient-primary text-white">
                                            <h6 class="m-0 font-weight-bold">신규 수리 내역 등록</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="ghp_repair_status.php" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="ghp_id_url" value="<?=htmlspecialchars($Ghp_Id)?>">
                                                <input type="hidden" name="mode" value="insert"> 
                                                
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label><strong>장비 번호</strong> <span class="text-danger">*</span></label>
                                                        <?php if($is_single_mode): ?>
                                                            <input type="text" class="form-control" name="ghp_id" value="<?=htmlspecialchars($Ghp_Id)?>" readonly>
                                                        <?php else: ?>
                                                            <select class="form-control" name="ghp_id" required>
                                                                <option value="">장비 선택</option>
                                                                <optgroup label="GHP (가스히트펌프)">
                                                                    <?php for($i=1; $i<=19; $i++) { 
                                                                        $val = "GHP-".str_pad($i, 2, "0", STR_PAD_LEFT);
                                                                        echo "<option value='$val'>$val</option>";
                                                                    } ?>
                                                                </optgroup>
                                                                <optgroup label="AHU (공조기)">
                                                                    <?php for($i=1; $i<=5; $i++) { 
                                                                        $val = "AHU-".str_pad($i, 2, "0", STR_PAD_LEFT);
                                                                        echo "<option value='$val'>$val</option>";
                                                                    } ?>
                                                                </optgroup>
                                                            </select>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-4 mb-3"><label><strong>작업자</strong></label><input type="text" class="form-control" name="worker_name" required></div>
                                                    <div class="col-md-4 mb-3"><label><strong>작업일자</strong></label><input type="date" class="form-control" name="repair_date" value="<?=date('Y-m-d')?>"></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8 mb-3"><label><strong>고장 증상</strong></label><input type="text" class="form-control" name="repair_symptom" placeholder="예: 에러코드 E04, 냉방 불량" required></div>
                                                    <div class="col-md-4 mb-3"><label><strong>비용 (원)</strong></label><input type="number" class="form-control" name="repair_cost" value="0" step="100"></div>
                                                </div>

                                                <div class="mb-3"><label><strong>조치 내용</strong></label><textarea class="form-control" name="repair_content" rows="3" required></textarea></div>
                                                <div class="mb-3">
                                                    <label><strong>현장 사진 (다중 선택)</strong></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="photos[]" multiple accept="image/*">
                                                        <label class="custom-file-label">파일 선택...</label>
                                                    </div>
                                                </div>
                                                <div class="text-right"><button type="submit" class="btn btn-primary">등록하기</button></div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <?php 
                                        $displayList = array_slice($historyList, 0, 5); 
                                        include 'ghp_repair_list_inc.php'; 
                                    ?>
                                </div>

                                <div class="tab-pane fade <?= ($active_tab == 'tab4') ? 'show active' : '' ?>" id="tab4">
                                    <div class="card shadow mb-4">
                                        <form method="POST" action="ghp_repair.php<?= $is_single_mode ? "?ghp_id=$Ghp_Id" : "" ?>">
                                            <div class="card-body">
                                                <label>검색 기간</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                                    <input type="text" class="form-control kjwt-search-date" name="dtSearch" value="<?=htmlspecialchars($searchDateRange)?>" placeholder="날짜 선택">
                                                    <div class="input-group-append"><button type="submit" name="btSearch" class="btn btn-primary">검색</button></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php 
                                        $displayList = $searchList; 
                                        include 'ghp_repair_list_inc.php'; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../plugin_lv1.php'; ?>
    <script>
        $(document).ready(function() {
            if ($('#dataTableResult').length > 0) {
                $('#dataTableResult').DataTable({ "order": [[ 0, "desc" ]], "language": { "search": "결과 내 검색:", "info": "총 _TOTAL_ 건" } });
            }
            $(".custom-file-input").on("change", function() {
                var c = $(this)[0].files.length; $(this).siblings(".custom-file-label").addClass("selected").html(c + "개의 파일 선택됨");
            });
        });
    </script>
</body>
</html>