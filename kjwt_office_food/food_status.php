<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.07.20>
	// Description:	<식수 쿼리>		
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
    // =============================================
    
    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../FUNCTION.php'; 


    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';  

    //★변수모음      
    //탭2
    $upload_code21 = $_POST["upload_code21"];
    $bt21 = $_POST["bt21"];

    //탭3  
    $dt3 = $_POST["dt3"];	
    $s_dt3 = substr($dt3, 0, 10);		
	$e_dt3 = substr($dt3, 13, 10);	
    $bt31 = $_POST["bt31"];
    
    //★버튼 클릭 시 실행      
    if($bt21=="on") {
        $tab_sequence=2; 
        include '../TAB.php'; 

        $tmpname = $_FILES['file']['tmp_name'];				//웹 서버에 임시로 저장된 파일의 위치			
        // 파일 해시 검사 추가
        if(checkFileHash($tmpname)) {
            echo "<script>alert('업로드가 제한된 파일입니다!');</script>";
            echo "<script>history.back();</script>";
            exit;
        }

        //php.ini정책에 의해 5MB가 최대 업로드 가능한 용량
        //php.ini정책에 의해 다중 업로드 파일 개수 10개가 최대
        $validMimeTypes = ['image/gif', 'image/png', 'image/jpeg', 'image/jpg', 'image/heic'];
        $validExtensions = ['gif', 'png', 'jpeg', 'jpg', 'heic'];

        //업로드할 파일을 찾아보기하여 열었는지 여부에 대해 확인
        if(!isset($_FILES['file']) || $_FILES['file']['error'] != UPLOAD_ERR_OK)
        {
            echo "<script>alert('파일 업로드에 실패했습니다.');";
            echo "history.back();</script>"; 
            exit;
        }

        //파일명의 길이를 확인
        if(strlen($_FILES['file']['name']) > 255)
        {
            echo "<script>alert('파일 이름이 너무 깁니다.');";
            echo "history.back();</script>";
            exit;
        }

        // MIME 타입 확인
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['file']['tmp_name']);
        if (!in_array($mimeType, $validMimeTypes)) {
            echo "<script>alert('유효하지 않은 파일 형식입니다.');";
            echo "history.back();</script>"; 
            exit;
        }

        // 파일 확장자 확인
        $fileExt = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExt, $validExtensions)) {
            echo "<script>alert('유효하지 않은 파일 확장자입니다.');";
            echo "history.back();</script>"; 
            exit;
        }
        
        //MYSQL에 파일이름이 한글인 경우 INSERT 되도록 하기위한 변수
        $filename2 = $_FILES['file']['name'];				//사용자 컴퓨터에서의 파일이름         
            
        //한글이름 파일인 경우 업로드 시 한글이 안보이거나 깨지는 현상 방지
        $arr = explode(".", $_FILES['file']['name']);
        $ext = array_pop($arr);
        $origin_name = join(".", $arr);        
        $str="food";
        //files 폴더가 아닌 폴더를 사용할 경우 리눅스 내에서 권한을 변경해줘야 한다.
        $dir = "../files/$str $Hyphen_today";			//경로 (C:\APM_Setup\htdocs\files) upload.php 파일이 있는 위치에서 files 폴더안에 $car $s_date $filename와 같은 이름으로 파일을 저장

        IF($upload_code21=='123qwe') {
            IF(in_array($_FILES["file"]["type"], $validMimeTypes) && @getimagesize($tmpname) !== false) {                
                if (move_uploaded_file($tmpname, $dir)) {	 
                    $Query_Food = "INSERT INTO CONNECT.dbo.FOOD(FILE_NM) VALUES(?)";
                    $params = [$filename2];
                    sqlsrv_query($connect, $Query_Food, $params);
                    echo "<script>alert('업로드 완료!');location.href='food.php';</script>";
                }                
            }
            else {
                echo "<script>alert('이미지 파일이 아니거나 파일 사이즈가 큽니다!');</script>";		
            } 
        }  
        else {
            echo "<script>alert('패스워드가 틀렸습니다!');</script>";	
        }      	
    } 
    elseif($bt31=="on") {
        $tab_sequence=3; 
        include '../TAB.php'; 

        $select_capco = "SELECT * FROM SECOM.dbo.COUNT_FOOD WHERE date BETWEEN ? AND ?";
        $params_capco = [$s_dt3, $e_dt3];
        $result = sqlsrv_query($connect, $select_capco, $params_capco);

        $count_query = "SELECT COUNT(*) as row_count FROM SECOM.dbo.COUNT_FOOD WHERE date BETWEEN ? AND ?";
        $params_count = [$s_dt3, $e_dt3];
        $result_count = sqlsrv_query($connect, $count_query, $params_count);
        $row = sqlsrv_fetch_array($result_count);
        $num_result = $row['row_count'];
    } 

    //식단표
    $Query_Menu = "SELECT top 2 * from CONNECT.dbo.FOOD order by NO desc";              
    $Result_Menu = sqlsrv_query($connect, $Query_Menu);

    // Count the number of rows safely
    $Count_Menu_Query = "SELECT COUNT(*) as row_count FROM (SELECT top 2 * from CONNECT.dbo.FOOD) as subquery";
    $Result_Count_Menu = sqlsrv_query($connect, $Count_Menu_Query);
    $row_count_menu = sqlsrv_fetch_array($Result_Count_Menu);
    $Count_Menu = $row_count_menu['row_count'];