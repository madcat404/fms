<?php 
	// =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.01.11>
	// Description:	<검교정>
	// Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
	// =============================================

	//★DB연결 및 함수사용
	require_once __DIR__ . '/../session/session_check.php';   
	include_once __DIR__ . '/../DB/DB2.php'; 
	include_once __DIR__ . '/../FUNCTION.php';

	//★변수모음 (POST로부터 안전하게 값 받기)
	$title = (int)($_POST['title'] ?? 0);

	// 유효한 title(REGISTER_NO)인지 확인
	if ($title <= 0) {
		echo "<script>alert('유효하지 않은 항목입니다.'); history.back();</script>";
		exit;
	}

	//★파일 업로드 오류 확인
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        // 오류 코드에 따라 더 상세한 메시지 제공 가능
        echo "<script>alert('파일 업로드에 실패했습니다. (오류 코드: " . ($_FILES['file']['error'] ?? 'N/A') . ")'); history.back();</script>"; 
        exit;
    }

	$original_filename = $_FILES['file']['name'];
	$tmp_name = $_FILES['file']['tmp_name'];

	//★파일 해시 검사 (존재한다면)
	if (function_exists('checkFileHash') && checkFileHash($tmp_name)) {
		echo "<script>alert('업로드가 제한된 파일입니다!'); history.back();</script>";
		exit;
	}

    //★파일명 길이 확인
    if (strlen($original_filename) > 255) {
        echo "<script>alert('파일 이름이 너무 깁니다.'); history.back();</script>";
        exit;
    }
	
	//★업로드 파일 확장자 확인 (Whitelist 방식)
	$extension = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
	$allowed_extensions = ['pdf', 'ppt', 'pptx', 'xls', 'xlsx', 'zip'];

	if (!in_array($extension, $allowed_extensions)) {
		echo "<script>alert('허용되지 않는 파일 형식입니다. (허용: " . implode(', ', $allowed_extensions) . ")'); history.back();</script>";
        exit;
	}

	//★새 파일명 생성 (보안 강화)
	// 형식: calibration_{등록번호}_{unix타임스탬프}.{확장자}
	$new_basename = 'calibration_' . $title . '_' . time();
	$new_filename = $new_basename . '.' . $extension;

	//★파일 저장 경로 설정 (절대 경로 사용)
	$upload_dir = __DIR__ . '/../files/';
	$destination = $upload_dir . $new_filename;
	
	// 디렉터리가 없으면 생성
	if (!is_dir($upload_dir)) {
	    mkdir($upload_dir, 0755, true);
	}

	//★파일 이동
	if (!move_uploaded_file($tmp_name, $destination)) {
		echo "<script>alert('파일 저장에 실패했습니다.'); history.back();</script>";
		exit;
	}
	
	//★데이터베이스 업데이트 (매개변수화 쿼리 사용)
	$query = "UPDATE CONNECT.dbo.CALIBRATION SET FILE_NAME = ?, FILE_EXTENSION = ? WHERE REGISTER_NO = ?";
	$params = [$new_basename, $extension, $title];
	
	$result = sqlsrv_query($connect, $query, $params);

	if ($result === false) {
		// 데이터베이스 오류 처리
		// 실제 운영 환경에서는 사용자에게 상세 오류를 노출하지 않아야 함
		// error_log(print_r(sqlsrv_errors(), true));
		echo "<script>alert('데이터베이스 업데이트에 실패했습니다.'); history.back();</script>";
		exit;
	}
	
	echo "<script>alert('업로드 완료!'); location.href='calibration.php';</script>";
?>