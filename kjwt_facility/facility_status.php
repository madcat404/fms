<?php
// kjwt_facility/facility_status.php
// 시설 관리 DB 처리 컨트롤러 (날짜 지정 저장 기능 포함)

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 1. DB 연결
if (file_exists('../DB/DB2.php')) {
    include_once '../DB/DB2.php';
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
    if (!isset($file) || $file['error'] != UPLOAD_ERR_OK) return null;
    
    // 디렉토리 생성
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = date('Ymd_His') . '_' . uniqid() . '.' . $ext;
    $targetPath = $uploadDir . $newFileName;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'uploads/facility/' . $newFileName; 
    }
    return null;
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

    $newPhotoPath = handleFileUpload($_FILES['photo'] ?? null);

    // 수정 시에도 날짜($created_at)를 업데이트할지 여부 결정
    // created_at 값이 넘어오면 업데이트 쿼리에 포함
    if ($newPhotoPath) {
        if (!empty($created_at)) {
            $sql = "UPDATE Facility 
                    SET Location = ?, IssueDescription = ?, Resolution = ?, RepairCost = ?, PhotoPath = ?, CreatedAt = ? 
                    WHERE LogID = ?";
            $params = array($location, $issue, $resolution, $cost, $newPhotoPath, $created_at, $logID);
        } else {
            $sql = "UPDATE Facility 
                    SET Location = ?, IssueDescription = ?, Resolution = ?, RepairCost = ?, PhotoPath = ? 
                    WHERE LogID = ?";
            $params = array($location, $issue, $resolution, $cost, $newPhotoPath, $logID);
        }
    } else {
        if (!empty($created_at)) {
            $sql = "UPDATE Facility 
                    SET Location = ?, IssueDescription = ?, Resolution = ?, RepairCost = ?, CreatedAt = ? 
                    WHERE LogID = ?";
            $params = array($location, $issue, $resolution, $cost, $created_at, $logID);
        } else {
            $sql = "UPDATE Facility 
                    SET Location = ?, IssueDescription = ?, Resolution = ?, RepairCost = ? 
                    WHERE LogID = ?";
            $params = array($location, $issue, $resolution, $cost, $logID);
        }
    }

    $stmt = sqlsrv_query($connect, $sql, $params);

    if ($stmt === false) {
        $errors = print_r(sqlsrv_errors(), true);
        echo "<script>alert('수정 실패: {$errors}'); history.back();</script>";
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