<?php 
// =============================================
// Author:  KWON SUNG KUN - sealclear@naver.com
// Create date: 21.09.30
// Description: fms 리뉴얼
// =============================================
require_once 'session/session_check.php';

// Function to generate card HTML
function generateCard($href, $icons, $text) {
    $iconsHtml = '';
    foreach ($icons as $icon) {
        $iconsHtml .= "<i class='fas $icon fa-2x'></i>";
    }
    return "
    <div class='col-6 col-xl-2 col-lg-2 col-md-3 col-sm-4 mb-2'>
        <a href='$href'>
            <div class='card h-100 py-2 align-items-center'>
                <div class='card-body'>
                    <div class='row no-gutters'>
                        <div class='col-auto' style='text-align: center;'>
                            $iconsHtml
                            <div class='text-md font-weight-bold text-primary text-center text-uppercase mb-1'>$text</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>";
}

$cards = [
    '커스텀' => [
        ["./index.php", ["fa-arrow-left"], "뒤로가기"],
        ["./index_guard_private.php", ["fa-user", "fa-shield-alt"], "경비원 전용"],
        ["./kjwt_field/complete_view.php", ["fa-chart-line"], "검사 현황"],
        ["./kjwt_field_finished/finished_in_view.php", ["fa-box"], "완성품 입고 대기"],
        ["./kjwt_field_finished_out/finished_view.php", ["fa-truck-loading"], "완성품 출고 현황"],
        ["./kjwt_field/packing_pda.php", ["fa-barcode"], "PDA 매핑 전용"],
        ["./kjwt_field_finished_out/finished_pda.php", ["fa-barcode"], "PDA 완성품 출하 전용"],
        ["./kjwt_bb/bb_in_pda.php", ["fa-barcode"], "PDA B/B 입고 전용"]
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

                    <?php foreach ($cards as $custom => $cardList): ?>
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;"><?php echo $custom ?></h1>
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
