<?php
// card_view.php
// 파일 위치: /card/card_view.php (가정)

// 1. DB 연결
require_once __DIR__ . '/../session/session_check.php';  
include_once __DIR__ . '/../DB/DB2.php'; 

// DB 연결 확인
if (!isset($connect) || $connect === false) {
    die("DB 연결 실패. 시스템 관리자에게 문의하세요.");
}

// ID 파라미터 확인
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// 데이터 조회
$sql = "SELECT TOP 1 * FROM BIZ_CARD WHERE ID = ?";
$queryParams = array($id); // 파라미터 바인딩용 배열

$stmt = sqlsrv_query($connect, $sql, $queryParams);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if (!$row) {
    die("존재하지 않는 명함입니다.");
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['NAME']; ?> - 모바일 명함</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Malgun Gothic', 'Dotum', sans-serif; }
        .card-box {
            max-width: 400px;
            margin: 30px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
        }
        .top-bg {
            height: 130px;
            background: linear-gradient(to right, #2c3e50, #3498db);
        }
        .avatar-area {
            margin-top: -65px;
            margin-bottom: 15px;
        }
        .avatar-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 5px solid #fff;
            object-fit: cover;
            background-color: #eee;
        }
        .info-area { padding: 0 20px 30px 20px; }
        .user-name { font-size: 1.5rem; font-weight: bold; margin-bottom: 5px; color:#333; }
        .user-pos { font-size: 0.9rem; color: #777; margin-bottom: 20px; }
        
        .detail-item {
            text-align: left;
            margin-bottom: 12px;
            color: #555;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }
        .detail-item i { width: 30px; text-align: center; color: #3498db; margin-right: 5px; }

        /* 버튼 스타일 */
        .btn-custom {
            width: 100%;
            margin-bottom: 8px;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-save { background-color: #27ae60; color: white; border:none; }
        .btn-save:hover { background-color: #219150; color: white; }
        .btn-tel { background-color: #2980b9; color: white; border:none; }
        .btn-sms { background-color: #f1c40f; color: #333; border:none; }
    </style>
</head>
<body>

    <div class="container">
        <div class="card-box">
            <div class="top-bg"></div>
            
            <div class="avatar-area">
                <img src="<?php echo !empty($row['PHOTO_PATH']) ? $row['PHOTO_PATH'] : 'https://via.placeholder.com/130?text=No+Image'; ?>" class="avatar-img" alt="프로필">
            </div>

            <div class="info-area">
                <div class="user-name"><?php echo $row['NAME']; ?></div>
                <div class="user-pos">
                    <?php echo $row['COMPANY']; ?><br>
                    <?php echo isset($row['DEPARTMENT']) ? $row['DEPARTMENT'] : ''; ?> <?php echo $row['POSITION']; ?>
                </div>

                <hr style="opacity: 0.15; margin-bottom: 20px;">

                <div class="detail-list mb-4">
                    <div class="detail-item">
                        <i class="fas fa-mobile-alt"></i> <?php echo $row['MOBILE']; ?>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-envelope"></i> <?php echo $row['EMAIL']; ?>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i> <span style="font-size:0.85rem;"><?php echo $row['ADDRESS']; ?></span>
                    </div>
                    <?php if(!empty($row['WEBSITE'])) { ?>
                    <div class="detail-item">
                        <i class="fas fa-globe"></i> <a href="<?php echo $row['WEBSITE']; ?>" target="_blank" style="text-decoration:none; color:#555;">홈페이지 방문</a>
                    </div>
                    <?php } ?>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <a href="tel:<?php echo $row['MOBILE']; ?>" class="btn btn-custom btn-tel">
                            <i class="fas fa-phone-alt me-1"></i> 전화
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="sms:<?php echo $row['MOBILE']; ?>" class="btn btn-custom btn-sms">
                            <i class="fas fa-comment me-1"></i> 문자
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="card_download_status.php?id=<?php echo $id; ?>" class="btn btn-custom btn-save">
                            <i class="fas fa-save me-1"></i> 연락처 저장 (사진 포함)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php
// 리소스 해제
if(isset($stmt)) sqlsrv_free_stmt($stmt);
if(isset($connect)) sqlsrv_close($connect);
?>