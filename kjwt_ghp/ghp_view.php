<?php
// kjwt_ghp/ghp_view.php
require_once __DIR__ . '/../session/session_check.php';
include_once __DIR__ . '/../DB/DB2.php'; 
include_once __DIR__ . '/../FUNCTION.php';

$RepairSeq = $_GET['RepairSeq'] ?? '';
$token = $_GET['token'] ?? ''; // 보안 토큰 (필요 시 검증 로직 추가 가능)

// QR 모드 체크
$is_qr_access = (isset($_SESSION['level']) && $_SESSION['level'] === 'qr_access');

$data = null;
$photos = [];
if (!empty($RepairSeq) && $connect) {
    $sql = "SELECT REPAIR_SEQ, GHP_ID, WORKER_NAME, REPAIR_SYMPTOM, REPAIR_CONTENT, REPAIR_COST, CREATE_DT, ADMIN_CODE
            FROM GHP_REPAIR_LOG WHERE REPAIR_SEQ = ?";
    $stmt = sqlsrv_query($connect, $sql, array($RepairSeq));
    if ($stmt) {
        $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    $p_sql = "SELECT FILE_NAME FROM GHP_REPAIR_PHOTOS WHERE REPAIR_SEQ = ?";
    $p_stmt = sqlsrv_query($connect, $p_sql, array($RepairSeq));
    while ($p_row = sqlsrv_fetch_array($p_stmt, SQLSRV_FETCH_ASSOC)) {
        $photos[] = $p_row['FILE_NAME'];
    }
}

if (!$data) {
    echo "<script>alert('데이터가 없습니다.'); history.back();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>
    <style>
        .view-photo { width: 100%; max-width: 800px; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .label-text { font-weight: bold; color: #4e73df; }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php if (!$is_qr_access) include '../nav.php'; ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em;"><i class="fas fa-file-alt mr-2"></i>수리 상세 내역</h1>
                        <a href="ghp_repair.php?ghp_id=<?=$data['GHP_ID']?>" class="btn btn-secondary btn-sm mt-3"><i class="fas fa-list mr-1"></i>목록</a>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-gradient-primary">
                            <h6 class="m-0 font-weight-bold text-white"><?=htmlspecialchars($data['GHP_ID'])?> - 수리 보고서</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4"><span class="label-text">작업자:</span> <?=htmlspecialchars($data['WORKER_NAME'])?></div>
                                <div class="col-md-4"><span class="label-text">작업일자:</span> <?=$data['CREATE_DT']->format('Y-m-d')?></div>
                                <div class="col-md-4 text-right">
                                    <?php if(empty($data['ADMIN_CODE'])): ?>
                                        <a href="ghp_edit.php?RepairSeq=<?=$RepairSeq?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> 수정하기</a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled><i class="fas fa-lock"></i> 확정됨</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mb-4">
                                <div class="row">
                                    <div class="col-md-8"><strong>[고장 증상]</strong> <?=htmlspecialchars($data['REPAIR_SYMPTOM'])?></div>
                                    <div class="col-md-4"><strong>[수리 비용]</strong> <?=number_format($data['REPAIR_COST'])?>원</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="label-text">조치 내용 상세</h6>
                                <div class="p-3 bg-light border rounded" style="min-height: 100px; white-space: pre-wrap;"><?=htmlspecialchars($data['REPAIR_CONTENT'])?></div>
                            </div>

                            <div>
                                <h6 class="label-text">현장 사진 (<?=count($photos)?>장)</h6>
                                <div class="text-center">
                                    <?php foreach ($photos as $img): ?>
                                        <a href="/uploads/ghp/<?=$img?>" target="_blank">
                                            <img src="/uploads/ghp/<?=$img?>" class="view-photo">
                                        </a>
                                    <?php endforeach; ?>
                                    <?php if(empty($photos)) echo "<p class='text-muted'>등록된 사진이 없습니다.</p>"; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../plugin_lv1.php'; ?>
</body>
</html>