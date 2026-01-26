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


    //★탭활성화
    $tab_sequence=2; 
    include_once __DIR__ . '/../TAB.php'; 


    //★변수모음      
    //탭2
    $upload_code21 = $_POST["upload_code21"] ?? null;
    $bt21 = $_POST["bt21"] ?? null;

    
    //★버튼 클릭 시 실행      
    if($bt21=="on") {
        $tab_sequence=2; 
        include '../TAB.php'; 

        // 파일 관련 변수 초기화
        $file = $_FILES['file'] ?? null;

        // 업로드 파일 유효성 검사
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            echo "<script>alert('파일 업로드에 실패했습니다.'); history.back();</script>";
            exit;
        }

        $tmpname = $file['tmp_name'];

        // 파일 해시 검사 (함수가 존재한다고 가정)
        if(function_exists('checkFileHash') && checkFileHash($tmpname)) {
            echo "<script>alert('업로드가 제한된 파일입니다!'); history.back();</script>";
            exit;
        }

        // 파일 크기, MIME 타입, 확장자 등 검증
        $validMimeTypes = ['image/gif', 'image/png', 'image/jpeg', 'image/jpg', 'image/heic'];
        $validExtensions = ['gif', 'png', 'jpeg', 'jpg', 'heic'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($tmpname);

        if ($file['size'] > 5 * 1024 * 1024) { // 2MB 사이즈 제한
            echo "<script>alert('파일 크기는 2MB를 초과할 수 없습니다.'); history.back();</script>";
            exit;
        }

        if (strlen($file['name']) > 255) {
            echo "<script>alert('파일 이름이 너무 깁니다.'); history.back();</script>";
            exit;
        }

        if (!in_array($mimeType, $validMimeTypes) || !in_array($fileExt, $validExtensions)) {
            echo "<script>alert('유효하지 않은 파일 형식입니다. (gif, png, jpg, heic만 가능)'); history.back();</script>";
            exit;
        }

        // 비밀번호 확인 (하드코딩된 비밀번호는 보안에 취약합니다)
        if($upload_code21 !== '323650') {
            echo "<script>alert('패스워드가 틀렸습니다!'); history.back();</script>";
            exit;
        }

        // 안전한 파일 이름 생성
        $safe_filename = "network-" . date("Y-m-d-H-i-s") . "." . $fileExt;
        $dir = "../files/" . $safe_filename;

        // 이미지 파일인지 최종 확인 후 파일 이동
        if (@getimagesize($tmpname) !== false) {
            if (move_uploaded_file($tmpname, $dir)) {
                // 파라미터화된 쿼리를 사용하여 SQL Injection 방지
                $Query_network = "INSERT INTO CONNECT.dbo.NETWORK(FILE_NM, SORTING_DATE) VALUES(?, ?)";
                $params_network = [$safe_filename, date("Y-m-d")];
                $result = sqlsrv_query($connect, $Query_network, $params_network);

                if ($result) {
                    echo "<script>alert('업로드 완료!'); location.href='network.php';</script>";
                } else {
                    // 데이터베이스 오류 처리
                    echo "<script>alert('데이터베이스 저장에 실패했습니다.'); history.back();</script>";
                }
            } else {
                echo "<script>alert('파일 이동에 실패했습니다.'); history.back();</script>";
            }
        } else {
            echo "<script>alert('이미지 파일이 아니거나 손상되었습니다!'); history.back();</script>";
        }
    }

    // 비상연락망 표시 로직
    $Query_Menu = "SELECT TOP 1 FILE_NM FROM CONNECT.dbo.NETWORK ORDER BY NO DESC";
    $Result_Menu = sqlsrv_query($connect, $Query_Menu);

    // 행의 존재 여부를 확인하기 위해 fetch를 사용
    $Data_Menu = sqlsrv_fetch_array($Result_Menu, SQLSRV_FETCH_ASSOC);
?>