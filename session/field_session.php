<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.04.13>
	// Description:	<세션보안 (내부 ip 예외)>	
	// =============================================

    include '../DB/DB1.php'; 
    include '../FUNCTION.php';

    //세션시작
    session_start(); 
    
    //세션id
    $session_id = session_id();
    $sip = $_SERVER['REMOTE_ADDR']; //사용자 IP
   // $cut_ip = substr($sip, 0, 9);

    //제일 최근에 로그인한 레코드값을 기준으로 한다.
    $session = "SELECT * FROM sessions WHERE session_id='$session_id'";
    $session_result = $connect->query($session);			
    $session_row = mysqli_fetch_object($session_result);

    //내부 ip를 획득한 단말기는 예외 처리
    if($cut_ip!="192.168.0" and $cut_ip!="192.168.2" and $cut_ip!="192.168.3" and $cut_ip!="192.168.10") {
        if($session_row->level!='kjwt' and $session_row->level!='master') {
            Confirm();
            //include같은 경우 문제가 발생하더라도 코드를 계속 읽는 특성을 가지고 있다.
            //메일에 세션제약을 거는 경우 confirm()함수 리턴값이 생성되었음에도 메일이 발송이 되는 문제점이 있다,
            //이를 해결하기 위하여 confirm()가 실행이 되는 if문안으로 들어왔을때 exit 특성으로 인하여 include를 포함한 하위 코드를 실행하지 않는다. (즉 메일 발송안됨)
            //이는 공격자가 해당 url을 매크로로 돌려 대량의 메일발송이 되지 않도록 막는 효과가 있다.
            exit; 
        }
    }
