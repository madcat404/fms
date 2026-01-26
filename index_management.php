<?php 
// =============================================
// Author:  KWON SUNG KUN - sealclear@naver.com
// Create date: 21.09.30
// Description: fms 리뉴얼
// =============================================
require_once './session/session_check.php';

// Function to generate card HTML
function generateCard($href, $icon, $text) {
    return "
    <div class='col-6 col-xl-2 col-lg-2 col-md-3 col-sm-4 mb-2'>
        <a href='$href'>
            <div class='card h-100 py-2 align-items-center'>
                <div class='card-body'>
                    <div class='row no-gutters'>
                        <div class='col-auto' style='text-align: center;'>
                            <i class='fas $icon fa-2x'></i>
                            <div class='text-md font-weight-bold text-primary text-center text-uppercase mb-1'>$text</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>";
}

$cards = [
    '경영' => [
        ["./index.php", "fa-arrow-left", "뒤로가기"],
        ["./kjwt_gw/gw_attend.php", "fa-id-card", "근태"],
        ["./kjwt_office_duty/duty.php", "fa-user-check", "당직"],
        ["./kjwt_office_food/food.php", "fa-utensils", "식단표"],        
        ["./kjwt_network/network.php", "fa-phone-volume", "비상연락"],
        ["./kjwt_schedule/schedule.php", "fa-user-tie", "방문자"],       
        ["./kjwt_uniform/uniform.php", "fa-tshirt", "유니폼"],
        ["./kjwt_birthday/birthday.php", "fa-birthday-cake", "생년월일"],
        ["./kjwt_sign/sign_select.php", "fa-file-signature", "교육회람"],    
        ["./kjwt_human/human.php", "fa-users", "HR"],
        ["./kjwt_facility/facility.php", "fa-tools", "시설"],
        ["./kjwt_safety/safety.php", "fa-hard-hat", "안전"],
        ["./kjwt_qr/qr.php", "fa-qrcode", "QR코드"]
    ],
    '전산' => [
        ["./index.php", "fa-arrow-left", "뒤로가기"],
        ["./kjwt_report/report_body.php", "fa-file-alt", "레포트"],
        ["./kjwt_office_asset/asset.php", "fa-list", "자산"],
        ["./kjwt_video/video.php", "fa-photo-video", "메뉴얼"],
        ["./kjwt_computer/computer.php", "fa-keyboard", "노트북"],
        ["./kjwt_admin/admin.php", "fa-clipboard-check", "일일체크리스트"]
    ],
    'ESG' => [
        ["./index.php", "fa-arrow-left", "뒤로가기"],
        ["./kjwt_esg/esg.php", "fa-solar-panel", "ESG"],    
        ["./kjwt_accuse/accuse.php", "fa-phone-volume", "제보"],
        ["./kjwt_clean/clean.php", "fa-trash-alt", "청소"]
    ],
    '경비' => [
        ["./index.php", "fa-arrow-left", "뒤로가기"],
        ["./kjwt_read_meter/meter.php", "fa-clipboard-check", "검침"],
        ["./kjwt_gate/gate.php", "fa-door-open", "입출문"],
        ["./kjwt_key/key.php", "fa-key", "키"],
        ["./kjwt_guard/guard.php", "fa-file-signature", "당숙일지"]
    ] 
];
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include 'head_root.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- 메뉴 -->
        <?php include 'nav.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php foreach ($cards as $management => $cardList): ?>
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;"><?php echo $management ?></h1>
                        </div>
                        
                        <!-- Cards -->
                        <div class="row">
                            <?php foreach ($cardList as $card): ?>
                                <?php echo generateCard($card[0], $card[1], $card[2]) ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?> 

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- 호환성(브라우저 기능검사) -->
    <script src="js/modernizr-custom.js"></script>
</body>
</html>
