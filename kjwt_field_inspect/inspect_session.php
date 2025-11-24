<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.04.13>
	// Description:	<세션(비정상접근 및 씨텍 배제)>	
	// =============================================
    
    include '../DB/DB1.php'; 

    //세션시작
    session_start();  
    
    //세션id
    $session_id = session_id();
    $user_id = $_SESSION['user_id'];

    //제일 최근에 로그인한 레코드값을 기준으로 한다.
    $session = "SELECT * FROM sessions where user_id='$user_id' AND fail_yn='N'";
    $session_result = $connect->query($session);			
    $session_row = mysqli_fetch_object($session_result);

    if($session_row->level!='kjwt' and $session_row->level!='master' and $session_row->level!='vietnam') {
        echo "<script>alert('권한이 없습니다!');history.back();</script>";
    }
?>