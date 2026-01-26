<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.07.20>
	// Description:	<자산 쿼리>		
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php';   


    //★매뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php';


    //★변수정의
    //탭3    
    $bt31 = $_POST["bt31"] ?? null; 
 

    //★버튼 클릭 시 실행
    IF($bt31=="on") {
        $tab_sequence=3; 
        include '../TAB.php';

        //변수
        $user31 = strtoupper($_POST["user31"]);

        // "all"을 입력하면 전체 조회
        if ($user31 == 'ALL') {
            $Query_SearchAsset = "SELECT * from CONNECT.dbo.ASSET WHERE USE_YN='Y' ORDER BY ASSET_NUM ASC";
            $params_SearchAsset = [];
            $options_SearchAsset = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
            $Result_SearchAsset = sqlsrv_query($connect, $Query_SearchAsset, $params_SearchAsset, $options_SearchAsset);
        } else {
            $first_word = substr($user31, 0, 1);

            //자산코드를 검색한 경우
            if($first_word=='K') {
                $Query_SearchAsset = "SELECT * from CONNECT.dbo.ASSET where ASSET_NUM = ? AND USE_YN='Y'";
                $params_SearchAsset = [$user31];
                $options_SearchAsset = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                $Result_SearchAsset = sqlsrv_query($connect, $Query_SearchAsset, $params_SearchAsset, $options_SearchAsset);

                $Count_Query_SearchAsset = "SELECT COUNT(*) as row_count from CONNECT.dbo.ASSET where ASSET_NUM = ? AND USE_YN='Y'";
                $Result_Count_SearchAsset = sqlsrv_query($connect, $Count_Query_SearchAsset, $params_SearchAsset);
                $row_count = sqlsrv_fetch_array($Result_Count_SearchAsset);
                $Count_SearchAsset = $row_count['row_count'];

                if($Count_SearchAsset==0) {
                    echo "<script>alert(\"검색하신 자산번호는 폐기되었거나 등록되지 않았습니다!\");</script>";
                }
            }
            //사용자 이름을 검색한 경우
            else {        
                $Query_SearchAsset = "SELECT * from CONNECT.dbo.ASSET where KJWT_USER = ? AND USE_YN='Y'";
                $params_SearchAsset = [$user31];
                $options_SearchAsset = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                $Result_SearchAsset = sqlsrv_query($connect, $Query_SearchAsset, $params_SearchAsset, $options_SearchAsset);

                $Count_Query_SearchAsset = "SELECT COUNT(*) as row_count from CONNECT.dbo.ASSET where KJWT_USER = ? AND USE_YN='Y'";
                $Result_Count_SearchAsset = sqlsrv_query($connect, $Count_Query_SearchAsset, $params_SearchAsset);
                $row_count = sqlsrv_fetch_array($Result_Count_SearchAsset);
                $Count_SearchAsset = $row_count['row_count'];

                if($Count_SearchAsset==0) {
                    echo "<script>alert(\"검색하신 사용자가 없습니다!\");</script>";
                }
            }
        }
    }


    //★매뉴 진입 시 실행
    $query_n = "select COUNT(*) AS N from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND='노트북'";              
    $result_n = sqlsrv_query($connect, $query_n); 	
    $row_n = sqlsrv_fetch_array($result_n);

    $query_d = "select COUNT(*) AS D from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND like '데스크%'";              
    $result_d = sqlsrv_query($connect, $query_d); 	
    $row_d = sqlsrv_fetch_array($result_d);

    $query_w = "select COUNT(*) AS W from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND='워크스테이션'";              
    $result_w = sqlsrv_query($connect, $query_w); 	
    $row_w = sqlsrv_fetch_array($result_w);

    $query_m = "select COUNT(*) AS M from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND like '미니%'";              
    $result_m = sqlsrv_query($connect, $query_m); 	
    $row_m = sqlsrv_fetch_array($result_m);

    $query_mo = "select COUNT(*) AS mo from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND='모니터'";               
    $result_mo = sqlsrv_query($connect, $query_mo); 	
    $row_mo = sqlsrv_fetch_array($result_mo);

    $query_ap = "select COUNT(*) AS ap from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND='AP'";               
    $result_ap = sqlsrv_query($connect, $query_ap); 	
    $row_ap = sqlsrv_fetch_array($result_ap);

    $query_l = "select COUNT(*) AS l from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND='라벨프린터'";               
    $result_l = sqlsrv_query($connect, $query_l); 	
    $row_l = sqlsrv_fetch_array($result_l);

    $query_c = "select COUNT(*) AS c from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND='의자'";               
    $result_c = sqlsrv_query($connect, $query_c); 	
    $row_c = sqlsrv_fetch_array($result_c);

    $query_k = "select COUNT(*) AS k from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND='키오스크'";               
    $result_k = sqlsrv_query($connect, $query_k); 	
    $row_k = sqlsrv_fetch_array($result_k);

    $query_w7h = "select COUNT(*) AS W7H from CONNECT.dbo.ASSET WHERE USE_YN='Y' and WINDOW='WIN7 HOME'";              
    $result_w7h = sqlsrv_query($connect, $query_w7h); 	
    $row_w7h = sqlsrv_fetch_array($result_w7h);

    $query_w7p = "select COUNT(*) AS W7P from CONNECT.dbo.ASSET WHERE USE_YN='Y' and WINDOW='WIN7 PRO'";              
    $result_w7p = sqlsrv_query($connect, $query_w7p); 	
    $row_w7p = sqlsrv_fetch_array($result_w7p);

    $query_w10h = "select COUNT(*) AS W10H from CONNECT.dbo.ASSET WHERE USE_YN='Y' and WINDOW='WIN10 HOME'";              
    $result_w10h = sqlsrv_query($connect, $query_w10h); 	
    $row_w10h = sqlsrv_fetch_array($result_w10h);

    $query_w10p = "select COUNT(*) AS W10P from CONNECT.dbo.ASSET WHERE USE_YN='Y' and WINDOW='WIN10 PRO'";              
    $result_w10p = sqlsrv_query($connect, $query_w10p); 	
    $row_w10p = sqlsrv_fetch_array($result_w10p);

    $query_w11p = "select COUNT(*) AS W11P from CONNECT.dbo.ASSET WHERE USE_YN='Y' and WINDOW='WIN11 PRO'";              
    $result_w11p = sqlsrv_query($connect, $query_w11p); 	
    $row_w11p = sqlsrv_fetch_array($result_w11p);

    $query_o2007 = "select COUNT(*) AS O2007 from CONNECT.dbo.ASSET WHERE USE_YN='Y' and OFFICE='2007'";              
    $result_o2007 = sqlsrv_query($connect, $query_o2007); 	
    $row_o2007 = sqlsrv_fetch_array($result_o2007);

    $query_o2010 = "select COUNT(*) AS O2010 from CONNECT.dbo.ASSET WHERE USE_YN='Y' and OFFICE='2010'";              
    $result_o2010 = sqlsrv_query($connect, $query_o2010); 	
    $row_o2010 = sqlsrv_fetch_array($result_o2010);

    $query_o2013 = "select COUNT(*) AS O2013 from CONNECT.dbo.ASSET WHERE USE_YN='Y' and OFFICE='2013'";              
    $result_o2013 = sqlsrv_query($connect, $query_o2013); 	
    $row_o2013 = sqlsrv_fetch_array($result_o2013);

    $query_o2021 = "select COUNT(*) AS O2021 from CONNECT.dbo.ASSET WHERE USE_YN='Y' and OFFICE='2021'";              
    $result_o2021 = sqlsrv_query($connect, $query_o2021); 	
    $row_o2021 = sqlsrv_fetch_array($result_o2021);

    $query_pda = "select COUNT(*) AS PDA from CONNECT.dbo.ASSET WHERE USE_YN='Y' and KIND='PDA'";              
    $result_pda = sqlsrv_query($connect, $query_pda); 	
    $row_pda = sqlsrv_fetch_array($result_pda);