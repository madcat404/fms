<?php
// kjwt_facility/facility_view.php
// 상세 보기 및 공유 페이지 (공유 토큰 기능 추가)

// --------------------------------------------------------------------------------
// [보안 설정] 공유 URL 생성을 위한 비밀키 (변경하여 사용하세요)
// 이 키가 유출되지 않도록 주의하세요.
// --------------------------------------------------------------------------------
$secret_key = 'iwin_fms_secure_share_key_2026'; 

// 1. 요청 파라미터 확인
$logID = isset($_GET['LogID']) ? (int)$_GET['LogID'] : 0;
$input_token = isset($_GET['token']) ? $_GET['token'] : '';

// 2. 공유 토큰 생성 및 검증 로직
// LogID와 비밀키를 조합하여 고유한 해시값을 만듭니다.
$generated_token = hash_hmac('sha256', $logID, $secret_key);
$is_public_mode = false;

// 입력된 토큰이 생성된 토큰과 일치하면 '공유 모드'로 간주 (로그인 패스)
if ($logID > 0 && !empty($input_token) && hash_equals($generated_token, $input_token)) {
    $is_public_mode = true;
}

// 3. 세션 체크 (공유 모드가 아닐 경우에만 수행)
if (!$is_public_mode) {
    session_start();
    require_once __DIR__ .'/../session/session_check.php';
}

// 4. DB 연결
if (file_exists('../DB/DB2.php')) {
    include_once __DIR__ . '/../DB/DB2.php'; 
} else {
    // DB 파일이 없을 경우 예외 처리
    die("오류: DB 연결 파일을 찾을 수 없습니다.");
}

// 5. 게시물 조회 (Prepared Statement 사용)
$data = null;

if ($logID > 0 && isset($connect)) {
    try {
        $sql = "SELECT * FROM Facility WHERE LogID = ?";
        $params = array($logID);
        $stmt = sqlsrv_query($connect, $sql, $params);

        if ($stmt === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_has_rows($stmt)) {
            $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        } else {
            // 데이터가 없는 경우
            if ($is_public_mode) {
                 die("<h3>존재하지 않거나 삭제된 게시물입니다.</h3>");
            } else {
                 die("<script>alert('존재하지 않거나 삭제된 게시물입니다.'); location.href='facility.php';</script>");
            }
        }
    } catch (Exception $e) {
        // 에러 로그는 서버에 남기고 사용자에게는 간단히 표시
        error_log($e->getMessage());
        die("데이터 조회 중 오류가 발생했습니다.");
    }
} else {
    die("<script>alert('잘못된 접근입니다.'); location.href='facility.php';</script>");
}

// 공유용 전체 URL 생성 (Javascript에서 사용)
// 현재 프로토콜(http/https)과 호스트를 감지하여 전체 주소 조합
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$share_link = "$protocol://{$_SERVER['HTTP_HOST']}{$_SERVER['SCRIPT_NAME']}?LogID={$logID}&token={$generated_token}";
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
        
        /* 공유 모드일 때 네비게이션 공간 제거 등 스타일 조정 */
        <?php if ($is_public_mode): ?>
        body { background-color: #f8f9fc; padding-top: 20px; }
        #wrapper { padding: 0; }
        #content-wrapper { background-color: transparent; }
        .card { max-width: 800px; margin: 0 auto; }
        <?php endif; ?>
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        
        <?php 
        // 공유 모드가 아닐 때만 네비게이션 바 표시
        if (!$is_public_mode) {
            include '../nav.php'; 
        }
        ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em;">
                            <?= $is_public_mode ? 'FMS 시설물 수리 내역' : '시설물 수리 상세' ?>
                        </h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                No. <?= $logID ?> (<?= isset($data['CreatedAt']) ? $data['CreatedAt']->format('Y-m-d') : '' ?>)
                            </h6>
                            
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
                                    <div class="view-content"><?= number_format((float)$data['RepairCost']) ?> 원</div>
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
                                <?php if (!$is_public_mode): ?>
                                    <a href="facility.php" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
                                        <span class="text">목록으로</span>
                                    </a>
                                    <a href="facility_edit.php?LogID=<?= $logID ?>" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
                                        <span class="text">수정하기</span>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-icon-split" disabled>
                                        <span class="icon text-white-50"><i class="fas fa-lock"></i></span>
                                        <span class="text">읽기 전용 모드</span>
                                    </button>
                                <?php endif; ?>
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
            // PHP에서 생성한 보안 토큰이 포함된 URL
            const shareUrl = "<?= $share_link ?>";
            
            const shareData = {
                title: '시설물 수리 기록 공유',
                text: '[FMS] <?= htmlspecialchars($data['Location']) ?> - 수리 내역',
                url: shareUrl
            };

            // 1. 모바일 (Web Share API 지원 시)
            if (navigator.share) {
                navigator.share(shareData)
                    .then(() => console.log('공유 성공'))
                    .catch((error) => console.log('공유 실패', error));
            } 
            // 2. PC 또는 미지원 브라우저
            else {
                const tempInput = document.createElement("input");
                document.body.appendChild(tempInput);
                tempInput.value = shareUrl;
                tempInput.select();
                try {
                    document.execCommand("copy");
                    alert("공유 링크가 복사되었습니다.\n원하는 곳(카카오톡, 문자 등)에 붙여넣기 하세요.\n\n" + shareUrl);
                } catch (err) {
                    alert("복사에 실패했습니다. URL을 직접 복사해주세요.\n" + shareUrl);
                }
                document