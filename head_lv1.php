<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.10.25>
	// Description:	<폴대 내 php 파일 헤드>	
	// =============================================
?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, shrink-to-fit=no">
<meta name="author" content="madcat">
<meta name="description" content="IWIN Facilities Management System">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<title>FMS</title>

<!--====== 카카오톡 미리보기 세팅 ======-->
<meta property="og:title" content="FMS">
<meta property="og:image" content="https://fms.iwin.kr/img/logo2.png">
<meta property="og:description" content="Facility Management System">
<meta property="og:type" content="website">

<!-- font-awesome 아이콘 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- sb-admin 템플릿 -->
<!-- <link href="../css/sb-admin-2.min.css" rel="stylesheet"> -->
<!-- cdn이 빠를것이라 기대되어 변경했지만 별 차이 없음 / 만약 베트남과 같이 인터넷이 자주 끈어지는 문제가 발생하는 경우 로컬에 css를 넣어 페이지 동작하도록 해야함 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" integrity="sha512-Mk4n0eeNdGiUHlWvZRybiowkcu+Fo2t4XwsJyyDghASMeFGH6yUXcdDI3CKq12an5J8fq4EFzRVRdbjerO3RmQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- daterange picker 내역 탭 캘린더 -->
<link rel="stylesheet" href="../vendor/daterangepicker/daterangepicker.css">

<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<!-- DataTables -->
<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css"> <!-- 데이터 열이 여러개이고 페이지를 축소했을때 +버튼을 통해 생략된 열을 출력  -->
<link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> <!-- column visibility 기능 활성화 -->

<!-- 파비콘 -->
<link rel="shortcut icon" href="../icon/kjwt_favicon.ico">
<link rel="apple-touch-icon-precomposed" href="../icon/kjwt_ci_152.png">
<link rel="icon" href="../icon/kjwt_favicon.png">
<link rel="icon" href="../icon/kjwt_ci_16.png" sizes="16x16"> 
<link rel="icon" href="../icon/kjwt_ci_32.png" sizes="32x32"> 
<link rel="icon" href="../icon/kjwt_ci_48.png" sizes="48x48"> 
<link rel="icon" href="../icon/kjwt_ci_64.png" sizes="64x64"> 
<link rel="icon" href="../icon/kjwt_ci_128.png" sizes="128x128">

<!-- 수량증가버튼 컨트롤 -->
<script>
    function cal(type, ths) {
        var $inputs = $(ths).parent("div").find("input[name^='pop_out']");
        $inputs.each(function(index, input) {
            var increment;
            switch (index) {
                case 0: increment = 1; break;
                case 4: increment = 10; break;
                default: increment = 50; break;
            }
            var value = Number($(input).val());
            if (type == "p") {
                $(input).val(value + increment);
            } else {
                $(input).val(value - increment);
            }
        });
    }        
</script>

<!-- 세션 자동 로그아웃 -->
<!-- <script src="/js/auto_logout.js"></script> -->