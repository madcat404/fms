<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.04.13>
	// Description:	<법인차 웹페이지 세션보안 (비정상접근 배제)>	
	// =============================================

    include '../DB/DB1.php'; 

    //세션시작
    session_start();  
    
    //세션id
    $session_id = session_id();
    $sip = $_SERVER['REMOTE_ADDR']; //사용자 IP
    $user_id = $_SESSION['user_id'];

    //제일 최근에 로그인한 레코드값을 기준으로 한다.
    $session = "SELECT * FROM sessions where user_id='$user_id' AND fail_yn='N'";
    $session_result = $connect->query($session);			
    $session_row = mysqli_fetch_object($session_result);

    //경비실 예외
    if($sip!="192.168.3.22") {
        if($session_row->level!='kjwt' and $session_row->level!='master') {
            echo "<script>alert('권한이 없습니다!');history.back();</script>";
        }
    }
?>