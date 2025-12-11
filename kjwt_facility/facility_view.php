<?php
// kjwt_facility/facility_view.php
// 상세 보기 및 공유 페이지

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 1. DB 연결
if (file_exists('../DB/DB2.php')) {
    include_once '../DB/DB2.php';
} else {
    die("오류: DB 연결 파일(../DB/DB2.php)을 찾을 수 없습니다.");
}

// 2. 게시물 조회
$logID = isset($_GET['LogID']) ? (int)$_GET['LogID'] : 0;
$data = null;

if ($logID > 0 && isset($connect)) {
    $sql = "SELECT * FROM Facility WHERE LogID = ?";
    $stmt = sqlsrv_query($connect, $sql, array($logID));

    if ($stmt && sqlsrv_has_rows($stmt)) {
        $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    } else {
        die("<script>alert('존재하지 않거나 삭제된 게시물입니다.'); location.href='facility.php';</script>");
    }
} else {
    die("<script>alert('잘못된 접근입니다.'); location.href='facility.php';</script>");
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>
    <style>
        /* 보기 전용 스타일 */
        .view-label { font-weight: bold; color: #4e73df; }
        .view-content { background-color: #f8f9fc; padding: 15px; border-radius: 5px; border: 1px solid #eaecf4; min-height: 50px; }
        .view-photo { max-width: 100%; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include '../nav.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                         <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em;">시설물 수리 상세</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">No. <?= $logID ?> (<?= isset($data['CreatedAt']) ? $data['CreatedAt']->format('Y-m-d') : '' ?>)</h6>
                            
                            <button onclick="sharePage()" class="btn btn-success btn-sm btn-icon-split shadow-sm">
                                <span class="icon text-white-50"><i class="fas fa-share-alt"></i></span>
                                <span class="text">공유하기</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="view-label mb-1">위치</div>
                                    <div class="view-content"><?= htmlspecialchars($data['Location']) ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="view-label mb-1">비용</div>
                                    <div class="view-content"><?= number_format($data['RepairCost']) ?> 원</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="view-label mb-1">고장 내용</div>
                                <div class="view-content"><?= nl2br(htmlspecialchars($data['IssueDescription'])) ?></div>
                            </div>

                            <div class="mb-4">
                                <div class="view-label mb-1">조치 내용</div>
                                <div class="view-content"><?= nl2br(htmlspecialchars($data['Resolution'] ?? '-')) ?></div>
                            </div>

                            <?php if (!empty($data['PhotoPath'])): ?>
                            <div class="mb-4 text-center">
                                <div class="view-label mb-2 text-left">현장 사진</div>
                                <img src="../<?= htmlspecialchars($data['PhotoPath']) ?>" class="view-photo" alt="현장 사진">
                            </div>
                            <?php endif; ?>

                            <hr>
                            
                            <div class="d-flex justify-content-between">
                                <a href="facility.php" class="btn btn-secondary btn-icon-split">
                                    <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
                                    <span class="text">목록으로</span>
                                </a>
                                <a href="facility_edit.php?LogID=<?= $logID ?>" class="btn btn-info btn-icon-split">
                                    <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
                                    <span class="text">수정하기</span>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php include '../plugin_lv1.php'; ?>

    <script>
        function sharePage() {
            // 현재 페이지 정보
            const shareData = {
                title: '시설물 수리 기록 공유',
                text: '[FMS] <?= htmlspecialchars($data['Location']) ?> - <?= htmlspecialchars($data['IssueDescription']) ?>',
                url: window.location.href
            };

            // 1. 모바일 (Web Share API 지원 시): 카카오톡, 메시지 등 앱 선택창 뜸
            if (navigator.share) {
                navigator.share(shareData)
                    .then(() => console.log('공유 성공'))
                    .catch((error) => console.log('공유 실패', error));
            } 
            // 2. PC 또는 미지원 브라우저: 클립보드에 URL 복사
            else {
                const tempInput = document.createElement("input");
                document.body.appendChild(tempInput);
                tempInput.value = window.location.href;
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                alert("페이지 주소가 복사되었습니다.\n원하는 곳(카카오톡, 그룹웨어)에 붙여넣기(Ctrl+V) 하세요.");
            }
        }
    </script>
</body>
</html>
<?php if(isset($connect)) { sqlsrv_close($connect); } ?>