<?php
// kjwt_ghp/ghp_edit.php
// GHP 수리 내역 수정 페이지 (증상/비용 추가, 관리자 잠금, 사진 관리 포함)

session_start();

// 1. 세션 체크 및 DB 연결
// session_check.php가 실행되면 로그인 여부 및 QR 접속 여부($_SESSION['level'])가 설정됩니다.
require_once __DIR__ . '/../session/session_check.php';
include_once __DIR__ . '/../DB/DB2.php'; 
include_once __DIR__ . '/../FUNCTION.php';

// 2. 파라미터 확인
$RepairSeq = $_GET['RepairSeq'] ?? '';

// 3. QR 접속 여부 확인 (Nav 숨김용)
$is_qr_access = (isset($_SESSION['level']) && $_SESSION['level'] === 'qr_access');

$data = null;
$photos = [];

if (!empty($RepairSeq) && $connect) {
    // 3-1. 수리 내역 상세 조회 (ADMIN_CODE, REPAIR_SYMPTOM, REPAIR_COST 포함)
    $sql = "SELECT REPAIR_SEQ, GHP_ID, WORKER_NAME, REPAIR_CONTENT, REPAIR_SYMPTOM, REPAIR_COST, CREATE_DT, ADMIN_CODE
            FROM GHP_REPAIR_LOG 
            WHERE REPAIR_SEQ = ?";
    $params = array($RepairSeq);
    $stmt = sqlsrv_query($connect, $sql, $params);
    
    if ($stmt !== false) {
        $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    // 3-2. 이미 관리자 확정(잠금)된 내역인지 확인
    if ($data && !empty($data['ADMIN_CODE'])) {
        echo "<script>alert('관리자에 의해 확정된 내역입니다. 수정할 수 없습니다.'); history.back();</script>";
        exit;
    }

    // 3-3. 기존 업로드된 사진 목록 조회
    $p_sql = "SELECT PHOTO_SEQ, FILE_NAME FROM GHP_REPAIR_PHOTOS WHERE REPAIR_SEQ = ?";
    $p_stmt = sqlsrv_query($connect, $p_sql, array($RepairSeq));
    while ($p_row = sqlsrv_fetch_array($p_stmt, SQLSRV_FETCH_ASSOC)) {
        $photos[] = $p_row;
    }
}

if (!$data) {
    echo "<script>alert('데이터를 불러올 수 없습니다. 삭제되었거나 존재하지 않는 글입니다.'); history.back();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>
    <style>
        /* 기존 사진 목록 스타일 */
        .existing-photo-item { 
            position: relative; 
            display: inline-block; 
            margin: 5px; 
            border: 1px solid #ddd; 
            padding: 5px; 
            border-radius: 5px; 
            background-color: #fff;
        }
        .existing-photo-item img { 
            width: 100px; 
            height: 100px; 
            object-fit: cover; 
            border-radius: 3px;
        }
        .del-check { 
            position: absolute; 
            top: 5px; 
            right: 5px; 
            background: rgba(255, 255, 255, 0.9); 
            padding: 2px 5px; 
            border-radius: 3px; 
            font-size: 0.8rem;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        
        <?php 
        // QR 접속자가 아닐 경우에만 Nav 메뉴 표시
        if (!$is_qr_access) {
            include '../nav.php'; 
        }
        ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <?php if(!$is_qr_access): ?>
                            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                <i class="fa fa-bars"></i>
                            </button>
                        <?php endif; ?>
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em;">
                            <i class="fas fa-edit mr-2"></i>수리 내역 수정
                        </h1>
                    </div>

                    <div class="card shadow mb-4 border-left-info">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">수리 내용 변경</h6>
                        </div>
                        <div class="card-body">
                            <form action="ghp_repair_status.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="mode" value="update">
                                <input type="hidden" name="repair_seq" value="<?=$RepairSeq?>">
                                <input type="hidden" name="ghp_id_url" value="<?=htmlspecialchars($data['GHP_ID'])?>">

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label><strong>GHP 번호</strong></label>
                                        <input type="text" class="form-control bg-light" name="ghp_id" value="<?=htmlspecialchars($data['GHP_ID'])?>" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label><strong>작업자</strong> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="worker_name" value="<?=htmlspecialchars($data['WORKER_NAME'])?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label><strong>작업일자</strong></label>
                                        <input type="date" class="form-control" name="repair_date" value="<?=$data['CREATE_DT']->format('Y-m-d')?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label><strong>고장 증상</strong></label>
                                        <input type="text" class="form-control" name="repair_symptom" value="<?=htmlspecialchars($data['REPAIR_SYMPTOM'] ?? '')?>" placeholder="예: 냉방 불량, 에러코드 E04" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label><strong>수리 비용 (원)</strong></label>
                                        <input type="number" class="form-control" name="repair_cost" value="<?=$data['REPAIR_COST']?>" step="100">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label><strong>수리 및 조치 내용</strong> <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="repair_content" rows="5" required><?=htmlspecialchars($data['REPAIR_CONTENT'])?></textarea>
                                </div>

                                <div class="mb-4">
                                    <label><strong>기존 사진 관리</strong> <span class="small text-muted">(삭제할 사진만 체크하세요)</span></label>
                                    <div class="border p-3 rounded bg-light">
                                        <?php if(empty($photos)): ?>
                                            <p class="text-muted mb-0 text-center small">등록된 사진이 없습니다.</p>
                                        <?php else: ?>
                                            <div class="d-flex flex-wrap">
                                                <?php foreach ($photos as $p): ?>
                                                    <div class="existing-photo-item">
                                                        <a href="/uploads/ghp/<?=$p['FILE_NAME']?>" target="_blank">
                                                            <img src="/uploads/ghp/<?=$p['FILE_NAME']?>" alt="현장사진">
                                                        </a>
                                                        <div class="del-check">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="del_img_<?=$p['PHOTO_SEQ']?>" name="delete_photos[]" value="<?=$p['PHOTO_SEQ']?>">
                                                                <label class="custom-control-label text-danger font-weight-bold" for="del_img_<?=$p['PHOTO_SEQ']?>">삭제</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label><strong>새로운 사진 추가</strong></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photos" name="photos[]" multiple accept="image/*">
                                        <label class="custom-file-label" for="photos">사진을 추가하려면 선택하세요...</label>
                                    </div>
                                </div>

                                <div class="alert alert-warning border-left-warning" role="alert">
                                    <div class="form-group mb-0">
                                        <label class="text-danger font-weight-bold"><i class="fas fa-key"></i> 관리자 확정 (수정 잠금)</label>
                                        <input type="text" class="form-control" name="admin_code" placeholder="코드를 입력하고 저장하면 이 내역은 더 이상 수정할 수 없습니다." value="">
                                        <small class="form-text text-muted">※ 작업이 완전히 끝났을 때만 입력하세요. (비워두면 계속 수정 가능)</small>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" onclick="history.back();" class="btn btn-secondary mr-2">취소</button>
                                    <button type="submit" class="btn btn-info px-5">수정 완료</button>
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
        // 파일 선택 시 라벨 변경 스크립트
        $(document).ready(function() {
            $(".custom-file-input").on("change", function() {
                var fileCount = $(this)[0].files.length;
                var fileName = fileCount > 0 ? fileCount + "개의 파일이 선택됨" : "사진을 추가하려면 선택하세요...";
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>
</body>
</html>