<?php   
    // =============================================
	// Author: <KWON SUNG KUN - cardclear@naver.com>	
	// Create date: <24.09.12>
	// Description:	<법인카드>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    // Using include_once and __DIR__ for robustness
    //require_once __DIR__ . '/../session/session_check.php';     
    //include '../FUNCTION.php';
    require_once __DIR__ .'/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';
    include_once __DIR__ . '/../DB/DB3.php'; // For $connect3
    include_once __DIR__ . '/../FUNCTION.php';

    // This script might be run as a cron job, ensure $Hyphen_today is defined.
    if (!isset($Hyphen_today)) {
        $Hyphen_today = date("Y-m-d");
    }

    //★메뉴 진입 시 탭활성화
    $tab_sequence = 2; // Default to tab 2
    include_once __DIR__ . '/../TAB.php'; 

    //★변수모음 (Null 병합 연산자로 안전하게 초기화)
    $flag = $_GET['flag'] ?? null;  
    $cardpop = $_GET['cardpop'] ?? null; 
    $cardpopname = $_GET['cardpopname'] ?? null;  
    $card = $_GET['card'] ?? null; 
    $cardpopuser = $_GET['cardpopuser'] ?? null;
    $name = $_GET['name'] ?? null;  

    //탭2 (PC)
    $bt22 = $_POST['bt22'] ?? null;
    $dt22 = $_POST['dt22'] ?? null;
    $s_dt22 = $dt22 ? substr($dt22, 0, 10) : null;		
	$e_dt22 = $dt22 ? substr($dt22, 13, 10) : null;

    //사용 (bt11)
    $card11 = $_POST['card11'] ?? null;
    $user11 = $_POST['user11'] ?? null;    
    $contents11 = $_POST['contents11'] ?? null;
    $dt = $_POST["dt"] ?? null;	
    $s_dt = $dt ? substr($dt, 0, 10) : null;		
	$e_dt = $dt ? substr($dt, 13, 10) : null;
    $bt11 = $_POST['bt11'] ?? null;

    //반납 (bt12)
    $card12 = $_POST['card12'] ?? null;
    $user12 = $_POST['user12'] ?? null;  
    $bt12 = $_POST['bt12'] ?? null;

    //로그 (bt13, mobile)
    $bt13 = $_POST['bt13'] ?? null;
    $dt13 = $_POST['dt13'] ?? null;
    $s_dt13 = $dt13 ? substr($dt13, 0, 10) : null;
	$e_dt13 = $dt13 ? substr($dt13, 13, 10) : null;

    // 동명이인 처리를 위한 변수 초기화
    $duplicate_names = [];
    $action_target = ''; // 'bt11' or 'bt12'
    $selected_user_name = $_POST['selected_user_name'] ?? null;

    
    //★버튼 클릭 시 실행 (모든 쿼리를 매개변수화)
    //지급 (bt11)
    if ($bt11 === "on") { 
        // 1. 이미 사용자를 선택해서 넘어온 경우 (팝업에서 선택)
        if ($selected_user_name) {
            $userName = $selected_user_name;
            
            // 바로 지급 로직 실행
            $Query_CardUserCount = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.CARD WHERE NAME = ?";
            $Result_CardUserCount = sqlsrv_query($connect, $Query_CardUserCount, [$userName]);
            $Data_CardUserCount = sqlsrv_fetch_array($Result_CardUserCount);
            $Seq = ($Data_CardUserCount['cnt'] ?? 0) + 1;

            $Query_InsertCard = "INSERT INTO CONNECT.dbo.CARD(CARD, NAME, CONTENTS, START_DT, END_DT, GW) VALUES(?, ?, ?, ?, ?, ?)";
            sqlsrv_query($connect, $Query_InsertCard, [$card11, $userName, $contents11, $s_dt, $e_dt, $Seq]);

            echo "<script>alert('입력 되었습니다!');location.href='card.php?flag=log';</script>";
            exit;
        } 
        // 2. 처음 입력하는 경우 (사용자 조회 필요)
        else {
            $user11_like = $user11 . '%';
            // TOP 1 제거하고 전체 조회
            $Query_ID = "SELECT NM_KOR FROM NEOE.NEOE.MA_EMP WHERE NO_RES LIKE ?";
            $Result_ID = sqlsrv_query($connect, $Query_ID, [$user11_like]);
            
            $candidates = [];
            while ($row = sqlsrv_fetch_array($Result_ID, SQLSRV_FETCH_ASSOC)) {
                $candidates[] = $row['NM_KOR'];
            }
            $cnt = count($candidates);

            if ($cnt === 0) {
                echo "<script>alert('아이윈 직원이 아닙니다!');location.href='card.php';</script>";
                exit;
            } elseif ($cnt === 1) {
                // 한 명인 경우 정상 진행
                $userName = $candidates[0];

                $Query_CardUserCount = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.CARD WHERE NAME = ?";
                $Result_CardUserCount = sqlsrv_query($connect, $Query_CardUserCount, [$userName]);
                $Data_CardUserCount = sqlsrv_fetch_array($Result_CardUserCount);
                $Seq = ($Data_CardUserCount['cnt'] ?? 0) + 1;

                $Query_InsertCard = "INSERT INTO CONNECT.dbo.CARD(CARD, NAME, CONTENTS, START_DT, END_DT, GW) VALUES(?, ?, ?, ?, ?, ?)";
                sqlsrv_query($connect, $Query_InsertCard, [$card11, $userName, $contents11, $s_dt, $e_dt, $Seq]);

                echo "<script>alert('입력 되었습니다!');location.href='card.php?flag=log';</script>";
                exit;
            } else {
                // 중복 발생: view(card.php)로 넘어가서 팝업 띄움
                $duplicate_names = $candidates;
                $action_target = 'bt11'; // 지급 버튼에서 발생함
            }
        }
    }
    //반납 (bt12)
    elseif ($bt12 === "on") { 
        // 1. 이미 사용자를 선택해서 넘어온 경우
        if ($selected_user_name) {
            $userName = $selected_user_name;
            
            // 반납 로직 실행
            $Query_CardUserCount2 = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.CARD WHERE IN_YN='N' AND CARD = ?";
            $Result_CardUserCount2 = sqlsrv_query($connect, $Query_CardUserCount2, [$card12]);
            $Data_CardUserCount2 = sqlsrv_fetch_array($Result_CardUserCount2);
            $count = $Data_CardUserCount2['cnt'] ?? 0;

            if ($count >= 1) {
                $Query_UpdateCard = "UPDATE CONNECT.dbo.CARD SET RETURN_USER=?, RETURN_DATE=?, IN_YN='Y' WHERE CARD=? AND IN_YN='N'";
                $update_result = sqlsrv_query($connect, $Query_UpdateCard, [$userName, $Hyphen_today, $card12, $card12]);
                if ($update_result) {
                    echo "<script>alert('반납 되었습니다!');location.href='card.php?flag=log';</script>";
                }
            } elseif ($count === 0) {
                echo "<script>alert('이 카드는 현재 대여 중이 아닙니다.');location.href='card.php?flag=in';</script>";
            }
            exit;
        }
        // 2. 처음 입력하는 경우
        else {
            $user12_like = $user12 . '%';
            $Query_ID2 = "SELECT NM_KOR FROM NEOE.NEOE.MA_EMP WHERE NO_RES LIKE ?";
            $Result_ID2 = sqlsrv_query($connect, $Query_ID2, [$user12_like]);
            
            $candidates = [];
            while ($row = sqlsrv_fetch_array($Result_ID2, SQLSRV_FETCH_ASSOC)) {
                $candidates[] = $row['NM_KOR'];
            }
            $cnt = count($candidates);

            if ($cnt === 0) {
                echo "<script>alert('아이윈 직원이 아닙니다!');location.href='card.php';</script>";
                exit;
            } elseif ($cnt === 1) {
                // 한 명인 경우 정상 진행
                $userName = $candidates[0];
                
                $Query_CardUserCount2 = "SELECT COUNT(*) as cnt FROM CONNECT.dbo.CARD WHERE IN_YN='N' AND CARD = ?";
                $Result_CardUserCount2 = sqlsrv_query($connect, $Query_CardUserCount2, [$card12]);
                $Data_CardUserCount2 = sqlsrv_fetch_array($Result_CardUserCount2);
                $count = $Data_CardUserCount2['cnt'] ?? 0;

                if ($count >= 1) {
                    $Query_UpdateCard = "UPDATE CONNECT.dbo.CARD SET RETURN_USER=?, RETURN_DATE=?, IN_YN='Y' WHERE CARD=? AND IN_YN='N'";
                    $update_result = sqlsrv_query($connect, $Query_UpdateCard, [$userName, $Hyphen_today, $card12, $card12]);
                    if ($update_result) {
                        echo "<script>alert('반납 되었습니다!');location.href='card.php?flag=log';</script>";
                    }
                } elseif ($count === 0) {
                    echo "<script>alert('이 카드는 현재 대여 중이 아닙니다.');location.href='card.php?flag=in';</script>";
                }
                exit;
            } else {
                 // 중복 발생
                 $duplicate_names = $candidates;
                 $action_target = 'bt12'; // 반납 버튼에서 발생함
            }
        }
    }
    //모바일 로그
    elseif ($bt13 === "on") {
        $Query_Card = "SELECT * FROM CONNECT.dbo.CARD WHERE SORTING_DATE BETWEEN ? AND ? ORDER BY NO DESC";
        $Result_Card = sqlsrv_query($connect, $Query_Card, [$s_dt13, $e_dt13]);
    }  
    //PC 대여목록
    elseif ($bt22 === "on") {
        $tab_sequence = 2;
        include __DIR__ . '/../TAB.php';
        $Query_Card22 = "SELECT * FROM CONNECT.dbo.CARD WHERE SORTING_DATE BETWEEN ? AND ? ORDER BY NO DESC";
        $Result_Card22 = sqlsrv_query($connect, $Query_Card22, [$s_dt22, $e_dt22]);
    } 
    //팝업창 반납 처리
    elseif ($card !== null && $cardpopuser !== null && $name !== null) {             
        $Query_UpdateCard2 = "UPDATE CONNECT.dbo.CARD SET RETURN_USER=?, RETURN_DATE=?, IN_YN='Y' WHERE CARD=? AND NO = (SELECT MAX(NO) FROM CONNECT.dbo.CARD WHERE CARD = ? AND NAME=?)";
        sqlsrv_query($connect, $Query_UpdateCard2, [$name, $Hyphen_today, $card, $card, $cardpopuser]);
        echo "<script>alert('반납 되었습니다!');location.href='card.php?flag=log';</script>";           
    }
    

    //★메뉴 진입 시 실행 (대여현황용)
    $card_numbers_for_status = ['6532', '3963', '7938'];
    foreach ($card_numbers_for_status as $num) {
        $query = "SELECT TOP 1 * FROM CONNECT.dbo.CARD WHERE CARD = ? ORDER BY no DESC";
        $result = sqlsrv_query($connect, $query, [$num]);
        ${'Data_Card'.$num} = sqlsrv_fetch_array($result);
    }
?>