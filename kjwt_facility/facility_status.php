<?php
// kjwt_facility/facility_status.php
// 시설 관리 DB 처리 컨트롤러 (날짜 지정 저장 기능 포함)

session_start();

require_once __DIR__ .'/../session/session_check.php';

// 1. DB 연결
if (file_exists('../DB/DB2.php')) {
    include_once __DIR__ . '/../DB/DB2.php';  
} else {
    echo "<script>alert('DB 연결 파일 없음'); history.back();</script>";
    exit;
}

// 2. CSRF 체크 (필요 시 활성화)
// if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) { ... }

// 3. 요청 모드 확인
$mode = $_POST['mode'] ?? '';

// 공통 입력값 받아오기
$location   = $_POST['location'] ?? '';
$issue      = $_POST['issue'] ?? '';
$resolution = $_POST['resolution'] ?? '';
$cost       = isset($_POST['cost']) ? (int)$_POST['cost'] : 0;

// [중요] facility.php에서 보낸 날짜 값 받기
$created_at = $_POST['created_at'] ?? ''; 

// 파일 업로드 처리 함수
function handleFileUpload($file, $uploadDir = '../uploads/facility/') {
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) return null; // No file uploaded, not an error

    if ($file['error'] !== UPLOAD_ERR_OK) {
        // Log PHP file upload errors
        error_log("File upload error: " . $file['error'] . " for file " . ($file['name'] ?? 'unknown'));
        return null;
    }
    
    // 디렉토리 생성
    if (!is_dir($uploadDir)) {
        // 권한 문제 등으로 디렉토리 생성 실패 시
        if (!mkdir($uploadDir, 0777, true)) {
            error_log("Failed to create upload directory: " . $uploadDir);
            return null;
        }
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = date('Ymd_His') . '_' . uniqid() . '.' . $ext;
    $targetPath = $uploadDir . $newFileName;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'uploads/facility/' . $newFileName; 
    } else {
        error_log("Failed to move uploaded file from " . $file['tmp_name'] . " to " . $targetPath);
        return null;
    }
}

// ====================================================
// [INSERT] 신규 등록
// ====================================================
if ($mode === 'insert') {
    $photoPath = handleFileUpload($_FILES['photo'] ?? null);

    // [핵심] 사용자가 입력한 날짜가 있으면 그 날짜를 사용, 없으면 현재 시간(GETDATE())
    if (!empty($created_at)) {
        // 날짜만 입력된 경우(YYYY-MM-DD) 시간은 00:00:00으로 들어갑니다.
        $sql = "INSERT INTO Facility (Location, IssueDescription, Resolution, RepairCost, PhotoPath, CreatedAt) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $params = array($location, $issue, $resolution, $cost, $photoPath, $created_at);
    } else {
        $sql = "INSERT INTO Facility (Location, IssueDescription, Resolution, RepairCost, PhotoPath, CreatedAt) 
                VALUES (?, ?, ?, ?, ?, GETDATE())";
        $params = array($location, $issue, $resolution, $cost, $photoPath);
    }
    
    $stmt = sqlsrv_query($connect, $sql, $params);

    if ($stmt === false) {
        $errors = print_r(sqlsrv_errors(), true);
        echo "<script>alert('등록 실패: {$errors}'); history.back();</script>";
    } else {
        sqlsrv_free_stmt($stmt);
        echo "<script>location.href='facility.php?status=success';</script>";
    }
}

// ====================================================
// [UPDATE] 수정
// ====================================================
elseif ($mode === 'update') {
    $logID = $_POST['LogID'] ?? 0;
    if (!$logID) {
        echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
        exit;
    }

    $file_upload_attempted = (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE);
    $newPhotoPath = handleFileUpload($_FILES['photo'] ?? null);

    // 파일 업로드를 시도했지만 실패한 경우
    if ($file_upload_attempted && $newPhotoPath === null) {
        echo "<script>alert('파일 업로드에 실패했습니다. 관리자에게 문의하세요.'); history.back();</script>";
        exit;
    }

    $sql_parts = [];
    $params = [];

    // 항상 업데이트되는 필드
    $sql_parts[] = "Location = ?";
    $params[] = $location;
    $sql_parts[] = "IssueDescription = ?";
    $params[] = $issue;
    $sql_parts[] = "Resolution = ?";
    $params[] = $resolution;
    $sql_parts[] = "RepairCost = ?";
    $params[] = $cost;

    // 사진 파일이 새로 업로드된 경우
    if ($newPhotoPath) {
        $sql_parts[] = "PhotoPath = ?";
        $params[] = $newPhotoPath;
    }

    // 작업 일자가 입력된 경우
    if (!empty($created_at)) {
        $sql_parts[] = "CreatedAt = ?";
        $params[] = $created_at;
    }

    // WHERE 절을 위한 LogID 추가
    $params[] = $logID;

    // 최종 SQL 쿼리 생성
    $sql = "UPDATE Facility SET " . implode(', ', $sql_parts) . " WHERE LogID = ?";
    
    $stmt = sqlsrv_query($connect, $sql, $params);

    if ($stmt === false) {
        $errors = print_r(sqlsrv_errors(), true);
        echo "<script>alert('수정 실패: " . addslashes($errors) . "'); history.back();</script>";
    } else {
        sqlsrv_free_stmt($stmt);
        echo "<script>location.href='facility.php?status=updated';</script>";
    }
}

// ====================================================
// [DELETE] 삭제
// ====================================================
elseif ($mode === 'delete') {
    $logID = $_POST['LogID'] ?? 0;
    
    $sql = "DELETE FROM Facility WHERE LogID = ?";
    $params = array($logID);
    
    $stmt = sqlsrv_query($connect, $sql, $params);

    if ($stmt === false) {
        echo "<script>alert('삭제 실패'); history.back();</script>";
    } else {
        sqlsrv_free_stmt($stmt);
        echo "<script>alert('삭제되었습니다.'); location.href='facility.php';</script>";
    }
}

else {
    echo "<script>alert('알 수 없는 요청입니다.'); location.href='facility.php';</script>";
}

if(isset($connect)) sqlsrv_close($connect);
?>