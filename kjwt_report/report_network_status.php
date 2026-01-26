<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.2.13>
	// Description:	<전산 보고서>
    // Last Modified: <25.10.15> - Refactored for PHP 8.x	
	// =============================================
    
    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../FUNCTION.php';

    //★탭활성화
    //메뉴 진입 시 탭활성화 start
    $tab = $_GET["tab"] ?? '';
    
    if($tab=='report') {
        //전자결재 url 삽입을 위함
        $tab_sequence=5; 
    }
    elseif($tab=='service') {
        $tab_sequence=6; 
    }  
    elseif($tab=='dev') {
        $tab_sequence=3; 
    }   
    else {
        $tab_sequence=2; 
    }    
    include '../TAB.php';  


    //★메뉴 진입 시 실행
    //근무자
    $Query_Guard = "select * from CONNECT.dbo.GUARD WHERE SORTING_DATE='$Minus1Day'";              
    $Result_Guard = sqlsrv_query($connect, $Query_Guard, $params, $options);		
    $Count_Guard = sqlsrv_num_rows($Result_Guard);  
    $Data_Guard = sqlsrv_fetch_array($Result_Guard);  

    // 자산 현황을 한 번의 쿼리로 가져오도록 리팩토링 (성능 개선)
    $asset_counts = [
        'N' => 0, 'D' => 0, 'W' => 0, 'M' => 0, 'mo' => 0, 'ap' => 0,
        'l' => 0, 'c' => 0, 'k' => 0, 'PDA' => 0,
        'W7H' => 0, 'W7P' => 0, 'W10H' => 0, 'W10P' => 0, 'W11P' => 0,
        'O2007' => 0, 'O2010' => 0, 'O2013' => 0, 'O2021' => 0
    ];

    $query_assets = "
        SELECT 
            CASE 
                WHEN KIND = '노트북' THEN 'N'
                WHEN KIND LIKE '데스크%' THEN 'D'
                WHEN KIND = '워크스테이션' THEN 'W'
                WHEN KIND LIKE '미니%' THEN 'M'
                WHEN KIND = '모니터' THEN 'mo'
                WHEN KIND = 'AP' THEN 'ap'
                WHEN KIND = '라벨프린터' THEN 'l'
                WHEN KIND = '의자' THEN 'c'
                WHEN KIND = '키오스크' THEN 'k'
                WHEN KIND = 'PDA' THEN 'PDA'
                WHEN WINDOW = 'WIN7 HOME' THEN 'W7H'
                WHEN WINDOW = 'WIN7 PRO' THEN 'W7P'
                WHEN WINDOW = 'WIN10 HOME' THEN 'W10H'
                WHEN WINDOW = 'WIN10 PRO' THEN 'W10P'
                WHEN WINDOW = 'WIN11 PRO' THEN 'W11P'
                WHEN OFFICE = '2007' THEN 'O2007'
                WHEN OFFICE = '2010' THEN 'O2010'
                WHEN OFFICE = '2013' THEN 'O2013'
                WHEN OFFICE = '2021' THEN 'O2021'
            END AS ASSET_TYPE,
            COUNT(*) AS CNT
        FROM CONNECT.dbo.ASSET
        WHERE USE_YN = 'Y'
        GROUP BY 
            CASE 
                WHEN KIND = '노트북' THEN 'N'
                WHEN KIND LIKE '데스크%' THEN 'D'
                WHEN KIND = '워크스테이션' THEN 'W'
                WHEN KIND LIKE '미니%' THEN 'M'
                WHEN KIND = '모니터' THEN 'mo'
                WHEN KIND = 'AP' THEN 'ap'
                WHEN KIND = '라벨프린터' THEN 'l'
                WHEN KIND = '의자' THEN 'c'
                WHEN KIND = '키오스크' THEN 'k'
                WHEN KIND = 'PDA' THEN 'PDA'
                WHEN WINDOW = 'WIN7 HOME' THEN 'W7H'
                WHEN WINDOW = 'WIN7 PRO' THEN 'W7P'
                WHEN WINDOW = 'WIN10 HOME' THEN 'W10H'
                WHEN WINDOW = 'WIN10 PRO' THEN 'W10P'
                WHEN WINDOW = 'WIN11 PRO' THEN 'W11P'
                WHEN OFFICE = '2007' THEN 'O2007'
                WHEN OFFICE = '2010' THEN 'O2010'
                WHEN OFFICE = '2013' THEN 'O2013'
                WHEN OFFICE = '2021' THEN 'O2021'
            END
    ";

    $result_assets = sqlsrv_query($connect, $query_assets);
    if ($result_assets) {
        while ($row = sqlsrv_fetch_array($result_assets, SQLSRV_FETCH_ASSOC)) {
            if (!empty($row['ASSET_TYPE'])) {
                // 결과를 기존 변수명과 매칭되도록 배열에 할당
                $var_name = 'row_' . strtolower($row['ASSET_TYPE']);
                $$var_name[$row['ASSET_TYPE']] = $row['CNT'];
            }
        }
    }