<?php
// kjwt_facility/facility_edit.php
// 시설 관리 수정 페이지 (삭제 버튼 제거됨)

session_start();

require_once __DIR__ .'/../session/session_check.php';

// 1. DB 연결
if (file_exists('../DB/DB2.php')) {
    include_once __DIR__ . '/../DB/DB2.php'; 
} else {
    die("오류: DB 연결 파일을 찾을 수 없습니다.");
}

// 2. CSRF 토큰
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// 3. 수정할 데이터 조회
$logID = filter_input(INPUT_GET, 'LogID', FILTER_SANITIZE_NUMBER_INT);
$data = null;

if ($logID && $connect) {
    $sql = "SELECT LogID, Location, IssueDescription, Resolution, RepairCost, PhotoPath, CreatedAt 
            FROM Facility WHERE LogID = ?";
    $params = array($logID);
    $stmt = sqlsrv_query($connect, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    sqlsrv_free_stmt($stmt);
}

if (!$data) {
    echo "<script>alert('존재하지 않거나 삭제된 기록입니다.'); location.href='facility.php';</script>";
    exit;
}

// 날짜 포맷 처리 (input type="date"용: YYYY-MM-DD)
$dateValue = '';
if ($data['CreatedAt'] instanceof DateTime) {
    $dateValue = $data['CreatedAt']->format('Y-m-d');
} else {
    // 문자열일 경우 앞 10자리만 추출
    $dateValue = substr($data['CreatedAt'] ?? '', 0, 10);
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em;">수리 기록 수정</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">기록 수정 (LogID: <?= $data['LogID'] ?>)</h6>
                        </div>
                        <div class="card-body">
                            <form action="facility_status.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                <input type="hidden" name="mode" value="update">
                                <input type="hidden" name="LogID" value="<?= $data['LogID'] ?>">

                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3">
                                        <label><strong>작업 일자</strong> <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="created_at" value="<?= $dateValue ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>위치 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="location" value="<?= htmlspecialchars($data['Location']) ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>비용 (원)</label>
                                        <input type="number" class="form-control" name="cost" value="<?= $data['RepairCost'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>고장 내용 <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="issue" rows="3" required><?= htmlspecialchars($data['IssueDescription']) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>조치 내용</label>
                                    <textarea class="form-control" name="resolution" rows="3"><?= htmlspecialchars($data['Resolution']) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>사진 수정 (선택사항)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*">
                                        <label class="custom-file-label" for="photo">파일 선택...</label>
                                    </div>
                                    <?php if(!empty($data['PhotoPath'])): ?>
                                        <div class="mt-2">
                                            <small>현재 파일: <a href="../<?= htmlspecialchars($data['PhotoPath']) ?>" target="_blank">보기</a></small>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <hr>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-icon-split btn-lg">
                                        <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                                        <span class="text">수정 저장</span>
                                    </button>
                                    <a href="facility.php" class="btn btn-secondary btn-icon-split btn-lg">
                                        <span class="text">취소</span>
                                    </a>
                                    </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <?php include '../plugin_lv1.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
    <script>
        // 파일명 표시
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        // 폼 제출 시 이미지 압축
        $('form').on('submit', async function(e) {
            e.preventDefault(); // 기본 폼 제출 중단

            const form = this;
            const imageFile = $('#photo')[0].files[0];
            
            // 압축할 이미지가 없으면 바로 폼 제출
            if (!imageFile) {
                form.submit();
                return;
            }

            const submitButton = $(form).find('button[type="submit"]');
            const originalButtonText = submitButton.find('.text').text();
            submitButton.prop('disabled', true).find('.text').text('파일 압축 중...');

            const options = {
                maxSizeMB: 2,          // 최대 2MB로 압축
                maxWidthOrHeight: 1920, // 최대 너비/높이 1920px
                useWebWorker: true
            }

            try {
                const compressedFile = await imageCompression(imageFile, options);

                const formData = new FormData(form);
                formData.set('photo', compressedFile, compressedFile.name); // 원본 파일을 압축 파일로 교체

                submitButton.find('.text').text('업로드 중...');

                // Fetch API로 폼 데이터 제출
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData
                });

                // 서버 응답(주로 리디렉션 스크립트)을 현재 문서에 쓰고 실행
                document.open();
                document.write(await response.text());
                document.close();

            } catch (error) {
                console.error('Image compression error:', error);
                alert('이미지 압축에 실패했습니다. 원본 파일로 업로드를 시도합니다.');
                submitButton.prop('disabled', false).find('.text').text(originalButtonText);
                form.submit(); // 압축 실패 시 원본 폼 제출
            }
        });
    </script>
</body>
</html>
<?php if(isset($connect)) sqlsrv_close($connect); ?>