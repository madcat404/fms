<?php
// kjwt_facility/facility.php
// 시설 관리 페이지 (모바일 최적화: 카드 뷰 적용 + 공유 기능 포함)

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

// 3. 데이터 조회
$historyList = [];
$dbError = null;

if (isset($connect) && $connect) {
    $sql = "SELECT TOP 50 LogID, Location, IssueDescription, Resolution, RepairCost, PhotoPath, CreatedAt 
            FROM Facility 
            ORDER BY CreatedAt DESC";
    $stmt = sqlsrv_query($connect, $sql);

    if ($stmt === false) {
        $errors = sqlsrv_errors();
        $dbError = "데이터 조회 실패: " . ($errors[0]['message'] ?? '알 수 없는 오류');
    } else {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $historyList[] = $row;
        }
        sqlsrv_free_stmt($stmt);
    }
} else {
    $dbError = "DB 연결 객체(\$connect)가 생성되지 않았습니다.";
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>
    <style>
        .photo-thumb {
            width: 80px; height: 80px;
            object-fit: cover;
            border-radius: 5px; border: 1px solid #ddd;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .photo-thumb:hover { transform: scale(1.1); }
        .table td { vertical-align: middle; }
        
        /* [공유 버튼 스타일] */
        .btn-action { margin-left: 4px; }

        /* [모바일 카드 스타일] */
        .mobile-card {
            border-left: 5px solid #4e73df; /* Primary Color Accent */
            transition: all 0.2s;
        }
        .mobile-card:active {
            transform: scale(0.98);
            background-color: #f8f9fc;
        }
        .mobile-label {
            font-size: 0.8rem;
            color: #858796;
            margin-bottom: 2px;
        }
        .mobile-value {
            font-weight: bold;
            color: #3a3b45;
        }
    </style>

    <script>
        function shareFacilityLink(logID, location, issue) {
            // 상세 페이지 URL 생성
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
                alert("페이지 주소가 복사되었습니다.\n원하는 곳(카카오톡, 그룹웨어)에 붙여넣기(Ctrl+V) 하세요.");
            }
        }
    </script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include '../nav.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em;">
                            <i class="fas fa-tools text-primary"></i> 시설물 수리 기록
                        </h1>
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
                        <?php elseif ($_GET['status'] === 'error'): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>오류!</strong> <?= htmlspecialchars($_GET['msg'] ?? '') ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="card shadow mb-4">
                        <a href="#collapseRegister" class="d-block card-header py-3 bg-gradient-primary" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseRegister">
                            <h6 class="m-0 font-weight-bold text-white">신규 등록 (클릭하여 열기/접기)</h6>
                        </a>
                        <div class="collapse show" id="collapseRegister">
                            <div class="card-body">
                                <form action="facility_status.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="mode" value="insert"> <div class="row">
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
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary btn-icon-split btn-lg">
                                            <span class="text">등록하기</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-secondary">최근 내역 (50건)</h6>
                        </div>
                        <div class="card-body p-2 p-md-4"> <?php if (empty($historyList)): ?>
                                <div class="text-center text-muted py-5">데이터가 없습니다.</div>
                            <?php else: ?>
                                
                                <div class="d-md-none">
                                    <?php foreach ($historyList as $row): 
                                        $logID   = $row['LogID'];
                                        $js_loc  = htmlspecialchars(str_replace(["\r", "\n"], " ", $row['Location'] ?? ''), ENT_QUOTES);
                                        $js_iss  = htmlspecialchars(str_replace(["\r", "\n"], " ", $row['IssueDescription'] ?? ''), ENT_QUOTES);
                                        
                                        $dateStr = isset($row['CreatedAt']) && $row['CreatedAt'] instanceof DateTime 
                                            ? $row['CreatedAt']->format('Y-m-d') 
                                            : substr($row['CreatedAt'] ?? '', 0, 10);
                                    ?>
                                    <div class="card mobile-card mb-3 shadow-sm">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="font-weight-bold text-primary mb-0 text-truncate" style="max-width: 70%;">
                                                    <a href="facility_view.php?LogID=<?= $logID ?>"><?= htmlspecialchars($row['Location']) ?></a>
                                                </h5>
                                                <small class="text-muted"><?= $dateStr ?></small>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <span class="badge badge-danger">고장</span>
                                                <span class="text-dark ml-1"><?= htmlspecialchars($row['IssueDescription']) ?></span>
                                            </div>
                                            
                                            <?php if($row['Resolution']): ?>
                                            <div class="mb-2">
                                                <span class="badge badge-success">조치</span>
                                                <span class="text-dark ml-1"><?= htmlspecialchars($row['Resolution']) ?></span>
                                            </div>
                                            <?php endif; ?>

                                            <div class="d-flex justify-content-between align-items-end mt-3">
                                                <div style="width: 60px; height: 60px;">
                                                    <?php if (!empty($row['PhotoPath'])): ?>
                                                        <a href="../<?= htmlspecialchars($row['PhotoPath']) ?>" target="_blank">
                                                            <img src="../<?= htmlspecialchars($row['PhotoPath']) ?>" class="w-100 h-100 rounded border" style="object-fit: cover;" alt="사진">
                                                        </a>
                                                    <?php else: ?>
                                                        <div class="w-100 h-100 bg-light rounded border d-flex align-items-center justify-content-center text-gray-400 small">No Img</div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <div class="font-weight-bold text-dark mb-2"><?= number_format($row['RepairCost']) ?>원</div>
                                                    <div>
                                                        <a href="facility_edit.php?LogID=<?= $logID ?>" class="btn btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-success btn-sm btn-action" 
                                                                onclick="shareFacilityLink(<?= $logID ?>, '<?= $js_loc ?>', '<?= $js_iss ?>')">
                                                            <i class="fas fa-share-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="table-responsive d-none d-md-block">
                                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
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
                                            <?php foreach ($historyList as $row): 
                                                $logID   = $row['LogID'];
                                                $js_loc  = htmlspecialchars(str_replace(["\r", "\n"], " ", $row['Location'] ?? ''), ENT_QUOTES);
                                                $js_iss  = htmlspecialchars(str_replace(["\r", "\n"], " ", $row['IssueDescription'] ?? ''), ENT_QUOTES);
                                            ?>
                                            <tr>
                                                <td class="text-center small">
                                                    <?php 
                                                    if (isset($row['CreatedAt']) && $row['CreatedAt'] instanceof DateTime) {
                                                        echo $row['CreatedAt']->format('Y-m-d') . "<br>" . $row['CreatedAt']->format('H:i');
                                                    } elseif (isset($row['CreatedAt'])) {
                                                        echo substr($row['CreatedAt'], 0, 16);
                                                    }
                                                    ?>
                                                </td>
                                                
                                                <td class="font-weight-bold text-center">
                                                    <a href="facility_view.php?LogID=<?= $row['LogID'] ?>" class="text-primary text-decoration-none">
                                                        <?= htmlspecialchars($row['Location']) ?>
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="facility_view.php?LogID=<?= $row['LogID'] ?>" class="text-dark text-decoration-none" style="display:block;">
                                                        <div class="mb-2"><span class="badge badge-danger">고장</span> <?= htmlspecialchars($row['IssueDescription']) ?></div>
                                                        <?php if($row['Resolution']): ?>
                                                        <div><span class="badge badge-success">조치</span> <?= htmlspecialchars($row['Resolution']) ?></div>
                                                        <?php endif; ?>
                                                    </a>
                                                </td>

                                                <td class="text-right"><?= number_format($row['RepairCost']) ?></td>
                                                <td class="text-center">
                                                    <?php if (!empty($row['PhotoPath'])): ?>
                                                        <a href="../<?= htmlspecialchars($row['PhotoPath']) ?>" target="_blank">
                                                            <img src="../<?= htmlspecialchars($row['PhotoPath']) ?>" class="photo-thumb" alt="사진">
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="small text-gray-500">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="facility_edit.php?LogID=<?= $row['LogID'] ?>" class="btn btn-info btn-sm btn-circle" title="수정">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-success btn-sm btn-circle btn-action" title="공유" 
                                                            onclick="shareFacilityLink(<?= $logID ?>, '<?= $js_loc ?>', '<?= $js_iss ?>')">
                                                        <i class="fas fa-share-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php include '../plugin_lv1.php'; ?>
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>
</html>
<?php if(isset($connect)) { sqlsrv_close($connect); } ?>