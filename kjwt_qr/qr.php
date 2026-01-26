<?php 
    // 로직 파일 포함
    include 'qr_status.php';   
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>
    <style>
        /* QR 이미지 스타일 (PC) */
        .qr-code-img {
            border: 1px solid #ddd;
            padding: 5px;
            background: #fff;
            border-radius: 5px;
            width: 100px;
            height: 100px;
        }
        /* QR 이미지 스타일 (모바일) */
        .qr-code-img-mobile {
            border: 1px solid #ddd;
            padding: 3px;
            background: #fff;
            border-radius: 5px;
            width: 100%;
            max-width: 120px;
            height: auto;
        }
        .url-text {
            word-break: break-all;
            font-size: 0.85rem;
        }
        /* 모바일 카드 스타일 보정 */
        .mobile-label {
            font-size: 0.75rem;
            color: #858796;
            margin-bottom: 0;
            font-weight: bold;
        }
        .mobile-value {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            word-break: break-all;
        }
        .token-badge {
            font-family: monospace;
            background: #f8f9fc;
            padding: 2px 5px;
            border-radius: 3px;
            border: 1px solid #eaecf4;
            color: #4e73df;
            font-size: 0.8em;
        }
    </style>
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">QR 코드 관리 (보안 적용)</h1>
                    </div>               

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            
                            <div class="card shadow mb-4">
                                <a href="#collapseQRInput" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true">
                                    <h6 class="m-0 font-weight-bold text-primary" id="formCardTitle">새 QR 코드 생성</h6>
                                </a>
                                <div class="collapse show" id="collapseQRInput">
                                    <div class="card-body">
                                        <form method="POST" action="qr.php" autocomplete="off" id="qrForm">
                                            <input type="hidden" name="qr_no" id="qr_no" value="">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>제목 (용도)</label>
                                                        <input type="text" class="form-control" name="title" id="input_title" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>이동할 URL (최종 목적지)</label>
                                                        <input type="text" class="form-control" name="target_url" id="input_url" placeholder="https://..." required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-end">
                                                    <div class="form-group w-100 d-flex">
                                                        <button type="button" id="btn_cancel" class="btn btn-secondary mr-2" style="display:none;" onclick="resetForm()">
                                                            취소
                                                        </button>
                                                        <button type="submit" name="btn_save" value="y" class="btn btn-primary flex-fill" id="btn_submit">
                                                            <i class="fas fa-qrcode fa-sm"></i> <span id="btn_text">생성</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">생성된 QR 목록</h6>
                                </div>
                                <div class="card-body p-2 p-md-4"> 
                                    
                                    <div class="d-md-none">
                                        <?php if (count($qr_list) > 0): ?>
                                            <?php foreach ($qr_list as $row): ?>
                                                <?php 
                                                    // ==========================================================
                                                    // [중요] QR 생성 URL 로직 (KEY 방식 사용)
                                                    // ==========================================================
                                                    $current_domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                                                    $token_key = $row['ACCESS_TOKEN'] ?? '';
                                                    
                                                    // 토큰이 있으면 key 파라미터 사용, 없으면(구버전 데이터) no 사용
                                                    if ($token_key) {
                                                        $system_url = $current_domain . "/kjwt_qr/qr.php?key=" . $token_key;
                                                    } else {
                                                        $system_url = $current_domain . "/kjwt_qr/qr.php?no=" . $row['NO'];
                                                    }
                                                    
                                                    $qr_api_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($system_url);
                                                    $date_str = ($row['CREATED_DT'] instanceof DateTime) ? $row['CREATED_DT']->format('Y-m-d') : substr($row['CREATED_DT'], 0, 10);
                                                ?>
                                                <div class="card mb-3 border-left-primary shadow-sm">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <span class="badge badge-primary mr-1">NO.<?= h($row['NO']) ?></span>
                                                                <h6 class="font-weight-bold text-dark d-inline-block" style="vertical-align: middle;"><?= h($row['TITLE']) ?></h6>
                                                            </div>
                                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                                onclick="editQR(
                                                                    '<?= h($row['NO']) ?>', 
                                                                    '<?= h(addslashes($row['TITLE'])) ?>', 
                                                                    '<?= h(addslashes($row['TARGET_URL'])) ?>'
                                                                )">
                                                                <i class="fas fa-pen"></i>
                                                            </button>
                                                        </div>

                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col-4 pr-2 text-center">
                                                                <a href="<?= $qr_api_url ?>" target="_blank">
                                                                    <img src="<?= $qr_api_url ?>" class="qr-code-img-mobile" alt="QR">
                                                                </a>
                                                                <div class="mt-2 small text-gray-600">
                                                                    <i class="fas fa-eye"></i> <?= number_format($row['VISIT_COUNT']) ?>회
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-8">
                                                                <div class="mb-2">
                                                                    <p class="mobile-label">시스템 URL (QR내용)</p>
                                                                    <a href="<?= $system_url ?>" target="_blank" class="mobile-value text-primary font-weight-bold d-block"><?= $system_url ?></a>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <p class="mobile-label">이동할 URL</p>
                                                                    <div class="mobile-value text-success"><?= h($row['TARGET_URL']) ?></div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <small class="text-muted"><i class="far fa-calendar-alt"></i> <?= $date_str ?></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-center py-4 text-gray-500">생성된 QR 코드가 없습니다.</div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="table-responsive d-none d-md-block">
                                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">NO</th>
                                                    <th style="width: 120px;">QR 이미지</th>
                                                    <th>정보</th>
                                                    <th style="width: 100px;">보안 토큰</th>
                                                    <th style="width: 80px;">스캔수</th>
                                                    <th style="width: 100px;">생성일</th>
                                                    <th style="width: 70px;">관리</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (count($qr_list) > 0): ?>
                                                    <?php foreach ($qr_list as $row): ?>
                                                        <?php 
                                                            $current_domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                                                            $token_key = $row['ACCESS_TOKEN'] ?? '';
                                                            
                                                            // Key 방식 적용
                                                            if ($token_key) {
                                                                $system_url = $current_domain . "/kjwt_qr/qr.php?key=" . $token_key;
                                                            } else {
                                                                $system_url = $current_domain . "/kjwt_qr/qr.php?no=" . $row['NO'];
                                                            }

                                                            $qr_api_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($system_url);
                                                        ?>
                                                        <tr>
                                                            <td class="align-middle text-center"><?= h($row['NO']) ?></td>
                                                            <td class="align-middle text-center">
                                                                <a href="<?= $qr_api_url ?>" target="_blank" title="이미지 크게 보기">
                                                                    <img src="<?= $qr_api_url ?>" class="qr-code-img" alt="QR Code">
                                                                </a>
                                                            </td>
                                                            <td class="align-middle">
                                                                <strong><?= h($row['TITLE']) ?></strong>
                                                                <hr class="my-1">
                                                                <small class="text-secondary">QR 접속 주소: </small>
                                                                <a href="<?= $system_url ?>" target="_blank" class="url-text text-primary"><?= $system_url ?></a><br>
                                                                <small class="text-secondary">최종 목적지: </small>
                                                                <span class="url-text text-success font-weight-bold"><?= h($row['TARGET_URL']) ?></span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <?php if($token_key): ?>
                                                                    <span class="token-badge" title="<?= h($token_key) ?>">
                                                                        <?= substr($token_key, 0, 8) ?>...
                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-warning">미적용</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="align-middle text-center font-weight-bold">
                                                                <?= number_format($row['VISIT_COUNT']) ?>
                                                            </td>
                                                            <td class="align-middle text-center small">
                                                                <?php 
                                                                    if($row['CREATED_DT'] instanceof DateTime) {
                                                                        echo h($row['CREATED_DT']->format('Y-m-d'));
                                                                    } else {
                                                                        echo h(substr($row['CREATED_DT'], 0, 10));
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <button type="button" class="btn btn-sm btn-info" 
                                                                    onclick="editQR(
                                                                        '<?= h($row['NO']) ?>', 
                                                                        '<?= h(addslashes($row['TITLE'])) ?>', 
                                                                        '<?= h(addslashes($row['TARGET_URL'])) ?>'
                                                                    )">
                                                                    수정
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4">생성된 QR 코드가 없습니다.</td>
                                                    </tr>
                                                <?php endif; ?>
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

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include '../plugin_lv1.php'; ?>
    
    <script>
        $(document).ready(function() {
            if($.fn.DataTable) {
                $('#dataTable').DataTable({
                    "order": [[ 0, "desc" ]], // NO 내림차순
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Korean.json"
                    }
                });
            }
        });

        // 수정 버튼 클릭 시
        function editQR(no, title, url) {
            $('#qr_no').val(no);
            $('#input_title').val(title);
            $('#input_url').val(url);

            $('#formCardTitle').text('QR 코드 수정 (NO: ' + no + ')');
            $('#btn_text').text('수정');
            $('#btn_submit').removeClass('btn-primary').addClass('btn-success');
            $('#btn_cancel').show();

            $('html, body').animate({ scrollTop: $('#collapseQRInput').offset().top - 100 }, 500);
            $('#collapseQRInput').collapse('show');
        }

        // 취소 버튼 클릭 시
        function resetForm() {
            $('#qr_no').val('');
            $('#input_title').val('');
            $('#input_url').val('');

            $('#formCardTitle').text('새 QR 코드 생성');
            $('#btn_text').text('생성');
            $('#btn_submit').removeClass('btn-success').addClass('btn-primary');
            $('#btn_cancel').hide();
        }
    </script>
</body>
</html>

<?php 
    if(isset($connect)) { sqlsrv_close($connect); }
?>