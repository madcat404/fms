<?php
// kjwt_facility/facility_edit.php
// 시설 관리 수정 페이지

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 1. DB 연결
if (file_exists('../DB/DB2.php')) {
    include_once '../DB/DB2.php';
} else {
    die("오류: DB 연결 파일(../DB/DB2.php)을 찾을 수 없습니다.");
}

// 2. CSRF 토큰
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// 3. 수정할 데이터 조회
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
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include '../nav.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                         <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em;">시설물 수리 기록 수정</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-info">
                            <h6 class="m-0 font-weight-bold text-white">내용 수정 (ID: <?= $logID ?>)</h6>
                        </div>
                        <div class="card-body">
                            <form action="facility_status.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">
                                <input type="hidden" name="mode" value="update"> <input type="hidden" name="LogID" value="<?= $logID ?>">
                                <input type="hidden" name="old_photo_path" value="<?= htmlspecialchars($data['PhotoPath'] ?? '') ?>">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>위치 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="location" value="<?= htmlspecialchars($data['Location']) ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>비용 (원)</label>
                                        <input type="number" class="form-control" name="cost" value="<?= (int)$data['RepairCost'] ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>고장 내용 <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="issue" rows="3" required><?= htmlspecialchars($data['IssueDescription']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label>조치 내용</label>
                                    <textarea class="form-control" name="resolution" rows="3"><?= htmlspecialchars($data['Resolution']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label>현장 사진 (변경하려면 파일 선택)</label>
                                    <?php if (!empty($data['PhotoPath'])): ?>
                                        <div class="mb-2">
                                            <img src="../<?= htmlspecialchars($data['PhotoPath']) ?>" alt="현재 사진" style="max-height: 150px; border:1px solid #ddd;">
                                            <span class="text-muted small ml-2">현재 등록된 사진</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*">
                                        <label class="custom-file-label" for="photo">새 사진 선택 (선택 시 기존 사진 대체)...</label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="facility.php" class="btn btn-secondary">취소</a>
                                    <button type="submit" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                                        <span class="text">수정 내용 저장</span>
                                    </button>
                                </div>
                            </form>
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