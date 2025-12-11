<?php
// kjwt_facility/facility_status.php
// 데이터 저장 및 수정 로직

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 1. DB 연결
if (file_exists('../DB/DB2.php')) {
    include_once '../DB/DB2.php';
} else {
    die("오류: DB 연결 파일(../DB/DB2.php)을 찾을 수 없습니다.");
}

// 2. 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CSRF 체크
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // die("잘못된 접근입니다 (CSRF 토큰 불일치).");
    }

    if (!isset($connect) || $connect === false) {
        die("데이터베이스 연결 실패.");
    }

    try {
        // 공통 파라미터 수신
        $mode = $_POST['mode'] ?? 'insert'; // insert 또는 update
        $location = trim($_POST['location'] ?? '');
        $issue = trim($_POST['issue'] ?? '');
        $resolution = trim($_POST['resolution'] ?? '');
        $cost = (float)($_POST['cost'] ?? 0);

        if (empty($location) || empty($issue)) {
            throw new Exception("필수 항목(위치, 고장내용)이 누락되었습니다.");
        }

        // --- 파일 업로드 처리 ---
        // 기존 파일 경로를 가져옴 (수정 모드일 때 사용)
        $photoPath = $_POST['old_photo_path'] ?? null;

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/'; 
            
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    throw new Exception("uploads 폴더 생성 실패.");
                }
            }

            $fileName = $_FILES['photo']['name'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($ext, $allowed)) {
                throw new Exception("이미지 파일(JPG, PNG, GIF)만 업로드 가능합니다.");
            }

            $newFileName = date('Ymd_His') . '_' . uniqid() . '.' . $ext;
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $destPath)) {
                // 새 파일이 업로드되면 경로 업데이트
                $photoPath = 'uploads/' . $newFileName;
            } else {
                throw new Exception("파일 이동 실패.");
            }
        }

        // --- DB 처리 분기 ---
        if ($mode === 'update') {
            // [수정 로직]
            $logID = (int)($_POST['LogID'] ?? 0);
            if ($logID <= 0) throw new Exception("유효하지 않은 게시물 ID입니다.");

            $sql = "UPDATE Facility 
                    SET Location = ?, IssueDescription = ?, Resolution = ?, RepairCost = ?, PhotoPath = ? 
                    WHERE LogID = ?";
            
            $params = array($location, $issue, $resolution, $cost, $photoPath, $logID);
            $redirectStatus = "updated";

        } else {
            // [등록 로직] (기본값)
            $sql = "INSERT INTO Facility (Location, IssueDescription, Resolution, RepairCost, PhotoPath, CreatedAt) 
                    VALUES (?, ?, ?, ?, ?, GETDATE())";
            
            $params = array($location, $issue, $resolution, $cost, $photoPath);
            $redirectStatus = "success";
        }
        
        // 쿼리 실행
        $stmt = sqlsrv_prepare($connect, $sql, $params);

        if (!$stmt) {
             $errors = sqlsrv_errors();
             throw new Exception("Query Preparation Failed: " . print_r($errors, true));
        }

        if (sqlsrv_execute($stmt)) {
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($connect);
            header("Location: facility.php?status=" . $redirectStatus);
            exit;
        } else {
            $errors = sqlsrv_errors();
            $msg = "";
            if ($errors != null) {
                foreach ($errors as $error) {
                    $msg .= $error['message'] . " ";
                }
            }
            throw new Exception("DB 저장 실패: " . $msg);
        }

    } catch (Exception $e) {
        $msg = urlencode($e->getMessage());
        header("Location: facility.php?status=error&msg=" . $msg);
        exit;
    }
} else {
    header("Location: facility.php");
    exit;
}
?>