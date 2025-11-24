<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.10.25>
	// Description:	<login, index 헤드>	
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

<!-- Custom fonts for this template-->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="css/sb-admin-2.min.css" rel="stylesheet">

<!-- 파비콘 -->
<link rel="shortcut icon" href="icon/kjwt_favicon.ico">
<link rel="apple-touch-icon-precomposed" href="../icon/kjwt_ci_152.png">
<link rel="icon" href="../icon/kjwt_favicon.png">
<link rel="icon" href="../icon/kjwt_ci_16.png" sizes="16x16"> 
<link rel="icon" href="../icon/kjwt_ci_32.png" sizes="32x32"> 
<link rel="icon" href="../icon/kjwt_ci_48.png" sizes="48x48"> 
<link rel="icon" href="../icon/kjwt_ci_64.png" sizes="64x64"> 
<link rel="icon" href="../icon/kjwt_ci_128.png" sizes="128x128">

<!-- 웹 폰트 -->
<link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">

<!-- 익스플로어 접속 시 엣지로 리다이렉트 -->
<script type="text/javascript">
    if (window.navigator.userAgent.match(/MSIE|Internet Explorer|Trident/i)) {
		alert("인터넷익스플로어는 서비스가 종료되었습니다. 마이크로소프트 엣지로 이동합니다!");
        window.location="microsoft-edge:http://fms.iwin.kr"
    }        
</script>

<!-- 세션 자동 로그아웃 -->
<script>
    // PHP의 timeout_duration을 JavaScript에 전달
    const PHP_TIMEOUT_DURATION = <?php echo $timeout_duration; ?> * 1000;
</script>
<script src="/js/auto_logout.js"></script>