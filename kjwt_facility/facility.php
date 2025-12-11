<?php
// kjwt_facility/facility.php
// 시설 관리 페이지 (시간 표시 제거 + 날짜 입력 + 등록 탭 최근 5건)

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 1. DB 연결
if (file_exists('../DB/DB2.php')) {
    include_once '../DB/DB2.php';
} else {
    die("오류: DB 연결 파일을 찾을 수 없습니다. (../DB/DB2.php 경로 확인 필요)");
}

if (file_exists('../FUNCTION.php')) {
    include_once '../FUNCTION.php';
}

// 2. CSRF 토큰
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// 3. 탭 활성화 로직
$active_tab = isset($_POST['btSearch']) ? 'tab4' : (isset($_GET['tab']) ? $_GET['tab'] : 'tab3');

// 4. [기본 데이터 조회] 최근 내역 (등록 탭용)
$historyList = [];
$total_cost = 0;
$total_count = 0;

if (isset($connect) && $connect) {
    // 등록 탭용 최근 50건 (통계 및 리스트용)
    $sql = "SELECT TOP 50 LogID, Location, IssueDescription, Resolution, RepairCost, PhotoPath, CreatedAt 
            FROM Facility 
            ORDER BY CreatedAt DESC";
    $stmt = sqlsrv_query($connect, $sql);

    if ($stmt !== false) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $historyList[] = $row;
        }
        sqlsrv_free_stmt($stmt);
    }
}

// 5. [검색 데이터 조회] 내역 조회 탭용
$searchList = [];
$searchDateRange = isset($_POST['dtSearch']) ? $_POST['dtSearch'] : ''; 

if (isset($_POST['btSearch']) && !empty($searchDateRange) && $connect) {
    $dates = explode(' ~ ', $searchDateRange);
    
    if (count($dates) == 2) {
        $startDate = trim($dates[0]);
        $endDate = trim($dates[1]);
        
        $sql_search = "SELECT LogID, Location, IssueDescription, Resolution, RepairCost, PhotoPath, CreatedAt 
                       FROM Facility 
                       WHERE CreatedAt >= ? AND CreatedAt < DATEADD(day, 1, CAST(? AS DATE))
                       ORDER BY CreatedAt DESC";
                       
        $params_search = array($startDate, $endDate);
        $stmt_search = sqlsrv_query($connect, $sql_search, $params_search);
        
        if ($stmt_search !== false) {
            while ($row = sqlsrv_fetch_array($stmt_search, SQLSRV_FETCH_ASSOC)) {
                $searchList[] = $row;
            }
            sqlsrv_free_stmt($stmt_search);
        }
    }
}

// [공통 함수] 문자열 말줄임 처리
function truncateText($text, $width = 30) {
    if (empty($text)) return '';
    return htmlspecialchars(mb_strimwidth($text, 0, $width, '...', 'UTF-8'));
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>
    <style>
        /* 모바일 최적화 스타일 */
        @media (max-width: 576px) {
            .table td, .table th {
                font-size: 0.85rem;
                padding: 0.5rem;
            }
        }
        .mobile-search-input {
            height: 50px; font-size: 1.1rem; border-radius: 0;
            background-color: #ffffff !important; color: #495057; border: 1px solid #d1d3e2;
        }
        .mobile-search-input::placeholder { color: #858796; }
        .mobile-search-btn { width: 60px; border-radius: 0; }
        
        .photo-thumb {
            width: 60px; height: 60px;
            object-fit: cover; border-radius: 4px; border: 1px solid #ddd;
            cursor: pointer; transition: transform 0.2s;
        }
        .photo-thumb:hover { transform: scale(1.1); }
        .table td { vertical-align: middle; }
        
        /* 행 클릭 효과 */
        .clickable-row { cursor: pointer; }
        .clickable-row:hover { background-color: #f8f9fc !important; }

        /* 모바일 카드 스타일 */
        .mobile-card { border-left: 5px solid #4e73df; transition: all 0.2s; }
        .mobile-card:active { transform: scale(0.98); background-color: #f8f9fc; }
    </style>

    <script>
        function shareFacilityLink(logID, location, issue) {
            let baseUrl = window.location.href.split('?')[0]; 
            if (baseUrl.indexOf('facility.php') !== -1) {
                baseUrl = baseUrl.replace('facility.php', 'facility_view.php');
            } else {
                baseUrl = baseUrl.replace(/\/$/, "") + '/facility_view.php';
            }
            const targetUrl = baseUrl + "?LogID=" + logID;
            
            const shareData = {
                title: '시설물 수리 기록 공유',
                text: `[FMS] ${location} - ${issue}`,
                url: targetUrl
            };

            if (navigator.share) {
                navigator.share(shareData)
                    .then(() => console.log('공유 성공'))
                    .catch((error) => console.log('공유 실패', error));
            } else {
                const tempInput = document.createElement("input");
                document.body.appendChild(tempInput);
                tempInput.value = targetUrl;
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                alert("페이지 주소가 복사되었습니다.\n원하는 곳에 붙여넣기(Ctrl+V) 하세요.");
            }
        }
        
        function goToView(id) {
            location.href = 'facility_view.php?LogID=' + id;
        }
    </script>
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">시설 관리</h1>
                    </div> 

                    <?php if (isset($_GET['status'])): ?>
                        <?php if ($_GET['status'] === 'success'): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <strong>성공!</strong> 등록되었습니다.
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php elseif ($_GET['status'] === 'updated'): ?>
                            <div class="alert alert-info alert-dismissible fade show">
                                <strong>수정 완료!</strong> 내용이 성공적으로 수정되었습니다.
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($active_tab == 'tab1') ? 'active' : '' ?>" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($active_tab == 'tab3') ? 'active' : '' ?>" id="tab-three" data-toggle="pill" href="#tab3">등록</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($active_tab == 'tab4') ? 'active' : '' ?>" id="tab-four" data-toggle="pill" href="#tab4">내역 조회</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        
                                        <div class="tab-pane fade <?= ($active_tab == 'tab1') ? 'show active' : '' ?>" id="tab1" role="tabpanel">
                                            [목표]<BR>
                                            - 시설물 고장 및 수리 현황 공유<BR><BR>
                                            [참조]<BR>
                                            - 사진 첨부 시 현장 상황을 더 빠르게 파악할 수 있습니다.<br>
                                            - '등록' 탭에서 최근 5건을 확인할 수 있습니다.<br>
                                            - '내역 조회' 탭에서 전체 내역 검색 및 엑셀 다운로드가 가능합니다.<br><br>                                           
                                        </div>
                                        
                                        <div class="tab-pane fade <?= ($active_tab == 'tab3') ? 'show active' : '' ?>" id="tab3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-12"> 
                                                    <div class="card shadow mb-4">
                                                        <a href="#collapseRegister" class="d-block card-header py-3 bg-gradient-primary" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseRegister">
                                                            <h6 class="m-0 font-weight-bold text-white">신규 등록</h6>
                                                        </a>
                                                        <div class="collapse show" id="collapseRegister">
                                                            <div class="card-body">
                                                                <form action="facility_status.php" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                                    <input type="hidden" name="mode" value="insert"> 
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <label><strong>작업 일자</strong></label>
                                                                            <input type="date" class="form-control" name="created_at" value="<?php echo date('Y-m-d'); ?>" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label>위치 <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" name="location" placeholder="예: 1층 로비" required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label>비용 (원)</label>
                                                                            <input type="number" class="form-control" name="cost" value="0">
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>고장 내용 <span class="text-danger">*</span></label>
                                                                        <textarea class="form-control" name="issue" rows="3" required></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>조치 내용</label>
                                                                        <textarea class="form-control" name="resolution" rows="3"></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>현장 사진</label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*">
                                                                            <label class="custom-file-label" for="photo">파일 선택...</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right"><button type="submit" class="btn btn-primary">등록하기</button></div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="col-lg-12"> 
                                                    <div class="card shadow mb-4">
                                                        <div class="card-header py-3">
                                                            <h6 class="m-0 font-weight-bold text-primary">최근 등록 내역 (5건)</h6>
                                                        </div>
                                                        <div class="card-body table-responsive p-2">
                                                            <?php 
                                                                $displayList = array_slice($historyList, 0, 5); 
                                                                $tableId = "table_recent_5";
                                                            ?>
                                                            <div class="d-none d-md-block">
                                                                <table class="table table-bordered table-hover" id="<?= $tableId ?>" width="100%" cellspacing="0">
                                                                    <thead class="thead-light text-center">
                                                                        <tr>
                                                                            <th style="width: 15%">날짜</th>
                                                                            <th style="width: 15%">위치</th>
                                                                            <th>내용 / 조치</th>
                                                                            <th style="width: 10%">비용</th>
                                                                            <th style="width: 10%">사진</th>
                                                                            <th style="width: 12%">관리</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($displayList as $row): 
                                                                            $logID = $row['LogID'];
                                                                            $js_loc = htmlspecialchars(str_replace(["\r", "\n"], " ", $row['Location'] ?? ''), ENT_QUOTES);
                                                                            $js_iss = htmlspecialchars(str_replace(["\r", "\n"], " ", $row['IssueDescription'] ?? ''), ENT_QUOTES);
                                                                        ?>
                                                                        <tr class="clickable-row" onclick="goToView(<?= $logID ?>)">
                                                                            <td class="text-center small">
                                                                                <?php 
                                                                                if (isset($row['CreatedAt']) && $row['CreatedAt'] instanceof DateTime) {
                                                                                    echo $row['CreatedAt']->format('Y-m-d');
                                                                                } else { echo substr($row['CreatedAt'] ?? '', 0, 10); }
                                                                                ?>
                                                                            </td>
                                                                            <td class="font-weight-bold text-center"><?= htmlspecialchars($row['Location']) ?></td>
                                                                            <td>
                                                                                <div class="mb-1">
                                                                                    <span class="badge badge-danger">고장</span> 
                                                                                    <span title="<?= htmlspecialchars($row['IssueDescription']) ?>">
                                                                                        <?= truncateText($row['IssueDescription'], 30) ?>
                                                                                    </span>
                                                                                </div>
                                                                                <?php if($row['Resolution']): ?>
                                                                                    <div>
                                                                                        <span class="badge badge-success">조치</span> 
                                                                                        <span title="<?= htmlspecialchars($row['Resolution']) ?>">
                                                                                            <?= truncateText($row['Resolution'], 30) ?>
                                                                                        </span>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td class="text-right"><?= number_format($row['RepairCost']) ?></td>
                                                                            <td class="text-center" onclick="event.stopPropagation()">
                                                                                <?php if (!empty($row['PhotoPath'])): ?><a href="../<?= htmlspecialchars($row['PhotoPath']) ?>" target="_blank"><img src="../<?= htmlspecialchars($row['PhotoPath']) ?>" class="photo-thumb"></a><?php else: echo "-"; endif; ?>
                                                                            </td>
                                                                            <td class="text-center" onclick="event.stopPropagation()">
                                                                                <a href="facility_edit.php?LogID=<?= $row['LogID'] ?>" class="btn btn-info btn-sm btn-circle"><i class="fas fa-edit"></i></a>
                                                                                <button class="btn btn-success btn-sm btn-circle" onclick="shareFacilityLink(<?= $logID ?>, '<?= $js_loc ?>', '<?= $js_iss ?>')"><i class="fas fa-share-alt"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            
                                                            <div class="d-md-none">
                                                                <?php foreach ($displayList as $row): 
                                                                    $logID = $row['LogID'];
                                                                    $dateStr = isset($row['CreatedAt']) && $row['CreatedAt'] instanceof DateTime ? $row['CreatedAt']->format('Y-m-d') : substr($row['CreatedAt'] ?? '', 0, 10);
                                                                ?>
                                                                <div class="card mobile-card mb-3 shadow-sm clickable-row" onclick="goToView(<?= $logID ?>)">
                                                                    <div class="card-body p-3">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <h5 class="font-weight-bold text-primary mb-0"><?= htmlspecialchars($row['Location']) ?></h5>
                                                                            <small class="text-muted"><?= $dateStr ?></small>
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <strong class="text-gray-600">고장:</strong> 
                                                                            <?= truncateText($row['IssueDescription'], 30) ?>
                                                                        </div>
                                                                        <?php if($row['Resolution']): ?>
                                                                            <div class="mb-2">
                                                                                <strong class="text-gray-600">조치:</strong> 
                                                                                <?= truncateText($row['Resolution'], 30) ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <div class="d-flex justify-content-between align-items-end mt-2">
                                                                            <div onclick="event.stopPropagation()">
                                                                                <?php if (!empty($row['PhotoPath'])): ?><img src="../<?= htmlspecialchars($row['PhotoPath']) ?>" style="width:50px; height:50px; object-fit:cover; border-radius:4px;"><?php endif; ?>
                                                                            </div>
                                                                            <div class="text-right">
                                                                                <div class="font-weight-bold mb-1"><?= number_format($row['RepairCost']) ?>원</div>
                                                                                <div onclick="event.stopPropagation()">
                                                                                    <a href="facility_edit.php?LogID=<?= $logID ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="tab-pane fade <?= ($active_tab == 'tab4') ? 'show active' : '' ?>" id="tab4" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-12"> 
                                                    <div class="card shadow mb-4">
                                                        <a href="#collapseSearch" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSearch">
                                                            <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                                        </a>
                                                        <form method="POST" autocomplete="off" action="facility.php"> 
                                                            <div class="collapse show" id="collapseSearch">                                    
                                                                <div class="card-body">
                                                                    <div class="row">                                                                        
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label>검색범위 (날짜)</label>
                                                                                <div class="input-group">                                                
                                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                                                                    <input type="text" class="form-control float-right kjwt-search-date" name="dtSearch" 
                                                                                           value="<?= htmlspecialchars($searchDateRange) ?>" 
                                                                                           placeholder="<?= date('Y-m-d').' ~ '.date('Y-m-d') ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </div>                                                                     
                                                                <div class="card-footer text-right">
                                                                    <button type="submit" class="btn btn-primary" name="btSearch">검색</button>
                                                                </div>
                                                            </div>
                                                        </form>             
                                                    </div>
                                                </div>

                                                <div class="col-lg-12"> 
                                                    <div class="card shadow mb-4">
                                                        <a href="#collapseResult" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseResult">
                                                            <h6 class="m-0 font-weight-bold text-primary">검색 결과</h6>
                                                        </a>
                                                        <div class="collapse show" id="collapseResult">
                                                            <div class="card-body table-responsive p-2">
                                                                
                                                                <?php if(empty($searchList) && isset($_POST['btSearch'])): ?>
                                                                    <div class="text-center p-5 text-gray-500">검색된 데이터가 없습니다.</div>
                                                                <?php elseif(!empty($searchList)): ?>
                                                                    
                                                                    <div class="d-md-none mb-3">
                                                                        <div class="input-group">
                                                                            <input type="text" id="mobile-search-history" class="form-control mobile-search-input" placeholder="결과 내 검색...">
                                                                            <div class="input-group-append"><button class="btn btn-primary mobile-search-btn" type="button"><i class="fas fa-search"></i></button></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="d-none d-md-block">
                                                                        <table class="table table-bordered table-hover text-nowrap" id="dataTableResult" width="100%" cellspacing="0">
                                                                            <thead class="thead-light text-center">
                                                                                <tr>
                                                                                    <th style="width: 15%">날짜</th>
                                                                                    <th style="width: 15%">위치</th>
                                                                                    <th>내용 / 조치</th>
                                                                                    <th style="width: 10%">비용</th>
                                                                                    <th style="width: 10%">사진</th>
                                                                                    <th style="width: 12%">관리</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($searchList as $row): 
                                                                                    $logID = $row['LogID'];
                                                                                    $js_loc = htmlspecialchars(str_replace(["\r", "\n"], " ", $row['Location'] ?? ''), ENT_QUOTES);
                                                                                    $js_iss = htmlspecialchars(str_replace(["\r", "\n"], " ", $row['IssueDescription'] ?? ''), ENT_QUOTES);
                                                                                ?>
                                                                                <tr class="clickable-row" onclick="goToView(<?= $logID ?>)">
                                                                                    <td class="text-center small">
                                                                                        <?php 
                                                                                        if (isset($row['CreatedAt']) && $row['CreatedAt'] instanceof DateTime) {
                                                                                            echo $row['CreatedAt']->format('Y-m-d');
                                                                                        } else { echo substr($row['CreatedAt'] ?? '', 0, 10); }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td class="font-weight-bold text-center"><?= htmlspecialchars($row['Location']) ?></td>
                                                                                    <td>
                                                                                        <div class="mb-1">
                                                                                            <span class="badge badge-danger">고장</span> 
                                                                                            <span title="<?= htmlspecialchars($row['IssueDescription']) ?>">
                                                                                                <?= truncateText($row['IssueDescription'], 40) ?>
                                                                                            </span>
                                                                                        </div>
                                                                                        <?php if($row['Resolution']): ?>
                                                                                            <div>
                                                                                                <span class="badge badge-success">조치</span> 
                                                                                                <span title="<?= htmlspecialchars($row['Resolution']) ?>">
                                                                                                    <?= truncateText($row['Resolution'], 40) ?>
                                                                                                </span>
                                                                                            </div>
                                                                                        <?php endif; ?>
                                                                                    </td>
                                                                                    <td class="text-right"><?= number_format($row['RepairCost']) ?></td>
                                                                                    <td class="text-center" onclick="event.stopPropagation()">
                                                                                        <?php if (!empty($row['PhotoPath'])): ?><a href="../<?= htmlspecialchars($row['PhotoPath']) ?>" target="_blank"><img src="../<?= htmlspecialchars($row['PhotoPath']) ?>" class="photo-thumb"></a><?php else: echo "-"; endif; ?>
                                                                                    </td>
                                                                                    <td class="text-center" onclick="event.stopPropagation()">
                                                                                        <a href="facility_edit.php?LogID=<?= $row['LogID'] ?>" class="btn btn-info btn-sm btn-circle"><i class="fas fa-edit"></i></a>
                                                                                        <button class="btn btn-success btn-sm btn-circle" onclick="shareFacilityLink(<?= $logID ?>, '<?= $js_loc ?>', '<?= $js_iss ?>')"><i class="fas fa-share-alt"></i></button>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <div class="d-md-none" id="mobile-card-container-history">
                                                                        <?php foreach ($searchList as $row): 
                                                                            $logID = $row['LogID'];
                                                                            $dateStr = isset($row['CreatedAt']) && $row['CreatedAt'] instanceof DateTime ? $row['CreatedAt']->format('Y-m-d') : substr($row['CreatedAt'] ?? '', 0, 10);
                                                                        ?>
                                                                        <div class="card mobile-card mb-3 shadow-sm clickable-row" onclick="goToView(<?= $logID ?>)">
                                                                            <div class="card-body p-3">
                                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                                    <h5 class="font-weight-bold text-primary mb-0"><?= htmlspecialchars($row['Location']) ?></h5>
                                                                                    <small class="text-muted"><?= $dateStr ?></small>
                                                                                </div>
                                                                                <div class="mb-2">
                                                                                    <strong class="text-gray-600">고장:</strong> 
                                                                                    <?= truncateText($row['IssueDescription'], 30) ?>
                                                                                </div>
                                                                                <?php if($row['Resolution']): ?>
                                                                                    <div class="mb-2">
                                                                                        <strong class="text-gray-600">조치:</strong> 
                                                                                        <?= truncateText($row['Resolution'], 30) ?>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                                <div class="d-flex justify-content-between align-items-end mt-2">
                                                                                    <div onclick="event.stopPropagation()">
                                                                                        <?php if (!empty($row['PhotoPath'])): ?><img src="../<?= htmlspecialchars($row['PhotoPath']) ?>" style="width:50px; height:50px; object-fit:cover; border-radius:4px;"><?php endif; ?>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-weight-bold mb-1"><?= number_format($row['RepairCost']) ?>원</div>
                                                                                        <div onclick="event.stopPropagation()">
                                                                                            <a href="facility_edit.php?LogID=<?= $logID ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php endforeach; ?>
                                                                    </div>

                                                                <?php else: ?>
                                                                    <div class="text-center p-3 small text-muted">검색할 날짜 범위를 선택하고 검색 버튼을 눌러주세요.</div>
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
            </div>
        </div>
    </div>
    
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <?php include '../plugin_lv1.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DataTables 설정
            if ($.fn.DataTable.isDataTable('#dataTableResult')) {
                $('#dataTableResult').DataTable().destroy();
            }
            
            var table = $('#dataTableResult').DataTable({
                "responsive": true,
                "lengthChange": false, 
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"], 
                "order": [[ 0, "desc" ]], 
                "language": {
                    "search": "검색:",
                    "paginate": { "next": "다음", "previous": "이전" },
                    "info": "_START_ - _END_ (총 _TOTAL_ 건)",
                    "emptyTable": "데이터가 없습니다."
                }
            });

            table.buttons().container().appendTo('#dataTableResult_wrapper .col-md-6:eq(0)');

            // 모바일 검색
            const searchInput = document.getElementById('mobile-search-history');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const filter = searchInput.value.toUpperCase();
                    const cards = document.querySelectorAll('#mobile-card-container-history .mobile-card');
                    
                    cards.forEach(function(card) {
                        const text = card.textContent || card.innerText;
                        if (text.toUpperCase().indexOf(filter) > -1) {
                            card.style.display = "";
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            }
            
            // 파일 업로드 라벨
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>

</body>
</html>

<?php 
    if(isset($connect)) { sqlsrv_close($connect); }
?>