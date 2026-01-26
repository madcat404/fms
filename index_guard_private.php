<?php 
    // =============================================
    // Author:  KWON SUNG KUN - sealclear@naver.com
    // Create date: 24.04.23
    // Description: 경비실 전용 메뉴
    // Last Modified: <Current Date> - Security Update (files path redirect)
    // =============================================
    /*session_start();

    $user_ip = $_SERVER['REMOTE_ADDR'];   //사용자 IP
    $cut_ip = substr($user_ip, 0, 9);

    if($cut_ip!="192.168.0" and $cut_ip!="192.168.3") {
        require_once './session/session_check.php';
    }*/

    require_once './session/session_check.php';

    // [수정함수] 카드 HTML 생성 및 보안 링크 변환
    function generateCard($href, $icon, $text) {
        $target = ""; // 기본: 현재 창에서 열기

        // 링크가 './files/'로 시작하는 경우 (파일 직접 링크)
        if (strpos($href, './files/') === 0) {
            // 1. 앞의 './files/' 경로 제거하고 파일명만 추출
            $fileName = substr($href, 8); 
            
            // 2. 한글 파일명 깨짐 방지를 위해 URL 인코딩
            $encodedName = urlencode($fileName);
            
            // 3. 보안 뷰어 스크립트 경로로 교체
            $href = "/session/view_file.php?file=" . $encodedName;
            
            // 4. 파일은 새 창에서 열리도록 설정
            $target = "target='_blank'";
        }

        return "
        <div class='col-6 col-xl-2 col-lg-2 col-md-3 col-sm-4 mb-2'>
            <a href='$href' $target>
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
        '기록' => [
            ["./kjwt_guard/guard.php", "fa-file-signature", "당숙일지"],
            ["./kjwt_read_meter/meter.php", "fa-clipboard-check", "검침"],
            ["./kjwt_gate/gate.php", "fa-door-open", "입출문"],
            ["./kjwt_key/key.php", "fa-key", "키"]
        ],
        '차량' => [        
            ["./kjwt_car/car.php", "fa-car-side", "직원차량"],
            ["./kjwt_fms/rental.php", "fa-car-side", "법인차"]
        ],
        '내부정보' => [
            ["./kjwt_gw/gw_attend.php", "fa-id-card", "근태"],
            ["./kjwt_office_duty/duty.php", "fa-user-check", "당직"],
            ["./kjwt_schedule/schedule.php", "fa-user-tie", "방문자"],
            ["./kjwt_network/network.php", "fa-phone-volume", "비상연락"],
            ["./kjwt_office_food/food.php", "fa-utensils", "식단표"],              
            ["./session/view_file.php?file=에스원 세콤.txt", "fa-user-shield", "세콤"],  
            ["./session/view_file.php?file=현대.txt", "fa-car", "현대차 계정"]     
        ],
        '위치정보' => [
            ["./files/nfc 부착위치.zip", "fa-barcode", "NFC위치"],
            ["./session/view_file.php?file=공장동 GATE명판 부착 설명.pptx", "fa-dungeon", "GATE위치"]
        ],
        '메뉴얼' => [
            ["./session/view_file.php?file=대여취소.mp4", "fa-user-clock", "대여취소"]
        ] 
    ];
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include 'head_root.php' ?>
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include 'nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <div class="container-fluid">

                    <?php foreach ($cards as $guard2 => $cardList): ?>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;"><?php echo  $guard2 ?></h1>
                        </div>
                        
                        <div class="row">
                            <?php foreach ($cardList as $card): ?>
                                <?php echo  generateCard($card[0], $card[1], $card[2]) ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?> 

                </div>
                </div>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

    <script src="js/modernizr-custom.js"></script>
</body>
</html>