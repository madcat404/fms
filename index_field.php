<?php 
// =============================================
// Author:  KWON SUNG KUN - sealclear@naver.com
// Create date: 21.09.30
// Description: fms 리뉴얼
// =============================================
require_once 'session/session_check.php';

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
    '현장' => [
        ["./index.php", "fa-arrow-left", "뒤로가기"],
        ["./kjwt_field/order_label.php", "fa-user-edit", "공정오더"],
        ["./kjwt_field/field_complete.php", "fa-user-check", "검사"],
        ["./kjwt_complete/complete_label.php", "fa-box-open", "포장"]
    ],
    '검사기' => [
        ["./index.php", "fa-arrow-left", "뒤로가기"],
        ["./kjwt_field_inspect/inspect_jig.php", "fa-cog", "지그"],
        ["./kjwt_inspect/inspect.php", "fa-barcode", "발열검사기"]
    ] ,
    '시험' => [
        ["./index.php", "fa-arrow-left", "뒤로가기"],
        ["./kjwt_calibration/calibration.php", "fa-ruler", "검교정"],
        ["./kjwt_test_room/test_room.php", "fa-check-square", "체크리스트"],
        ["./kjwt_test_room/test_room_process.php", "fa-backward", "시험이력"]
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

                    <?php foreach ($cards as $field => $cardList): ?>
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;"><?php echo $field ?></h1>
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