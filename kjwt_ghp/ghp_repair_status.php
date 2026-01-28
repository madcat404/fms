<?php
// kjwt_ghp/ghp_repair_status.php
session_start();
require_once __DIR__ . '/../session/session_check.php';
include_once __DIR__ . '/../DB/DB2.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = $_POST['mode'] ?? 'insert';
    $RepairSeq = $_POST['repair_seq'] ?? '';
    $Ghp_Id = $_POST['ghp_id'] ?? '';
    $Worker = $_POST['worker_name'] ?? '';
    $Symptom = $_POST['repair_symptom'] ?? '';
    $Content = $_POST['repair_content'] ?? '';
    $Cost = isset($_POST['repair_cost']) ? (int)$_POST['repair_cost'] : 0;
    $Date = $_POST['repair_date'] ?: date('Y-m-d');
    
    // 관리자 확정 코드
    $AdminCode = $_POST['admin_code'] ?? ''; 
    
    $Ghp_Id_Url = $_POST['ghp_id_url'] ?? '';

    if (!$connect) die("DB 연결 실패");
    if (sqlsrv_begin_transaction($connect) === false) die(print_r(sqlsrv_errors(), true));

    try {
        if ($mode === 'update') {
            if (empty($RepairSeq)) throw new Exception("수정할 내역 번호가 없습니다.");
            
            // [중요] 관리자 코드 검증 로직 추가
            // 코드가 입력되었는데 '323650'이 아니면 에러 발생
            if (!empty($AdminCode) && $AdminCode !== '323650') {
                throw new Exception("관리자 확정 코드가 일치하지 않습니다.\\n올바른 코드를 입력하거나 비워두세요.");
            }

            // 코드가 '323650'이면 DB에 저장되어 잠금 처리됨 (빈 값이면 일반 수정)
            $sql = "UPDATE GHP_REPAIR_LOG 
                    SET WORKER_NAME = ?, REPAIR_SYMPTOM = ?, REPAIR_CONTENT = ?, REPAIR_COST = ?, CREATE_DT = ?, ADMIN_CODE = ? 
                    WHERE REPAIR_SEQ = ?";
            $params = array($Worker, $Symptom, $Content, $Cost, $Date, $AdminCode, $RepairSeq);
            
            if (sqlsrv_query($connect, $sql, $params) === false) throw new Exception("수정 실패: " . print_r(sqlsrv_errors(), true));

            // 사진 삭제 처리
            if (!empty($_POST['delete_photos'])) {
                foreach ($_POST['delete_photos'] as $p_seq) {
                    $f_stmt = sqlsrv_query($connect, "SELECT FILE_NAME FROM GHP_REPAIR_PHOTOS WHERE PHOTO_SEQ = ?", array($p_seq));
                    if ($f_row = sqlsrv_fetch_array($f_stmt, SQLSRV_FETCH_ASSOC)) {
                        $target = $_SERVER['DOCUMENT_ROOT'] . "/uploads/ghp/" . $f_row['FILE_NAME'];
                        if (file_exists($target)) @unlink($target);
                    }
                    sqlsrv_query($connect, "DELETE FROM GHP_REPAIR_PHOTOS WHERE PHOTO_SEQ = ?", array($p_seq));
                }
            }
            $Current_Seq = $RepairSeq;

        } else {
            // [등록] 등록 시에는 관리자 코드를 저장하지 않음 (NULL 또는 빈값)
            $sql = "INSERT INTO GHP_REPAIR_LOG (GHP_ID, WORKER_NAME, REPAIR_SYMPTOM, REPAIR_CONTENT, REPAIR_COST, CREATE_DT) 
                    VALUES (?, ?, ?, ?, ?, ?); SELECT SCOPE_IDENTITY() AS ID;";
            $params = array($Ghp_Id, $Worker, $Symptom, $Content, $Cost, $Date);
            $stmt = sqlsrv_query($connect, $sql, $params);
            if ($stmt === false) throw new Exception("등록 실패: " . print_r(sqlsrv_errors(), true));

            sqlsrv_next_result($stmt);
            sqlsrv_fetch($stmt);
            $Current_Seq = sqlsrv_get_field($stmt, 0);
        }

        // 사진 추가 업로드 처리
        if (!empty($_FILES['photos']['name'][0])) {
            $upDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/ghp/";
            if (!is_dir($upDir)) mkdir($upDir, 0777, true);
            foreach ($_FILES['photos']['name'] as $k => $name) {
                if ($_FILES['photos']['error'][$k] === UPLOAD_ERR_OK) {
                    $newName = "GHP_{$Current_Seq}_{$k}_" . time() . "." . pathinfo($name, PATHINFO_EXTENSION);
                    if (move_uploaded_file($_FILES['photos']['tmp_name'][$k], $upDir . $newName)) {
                        sqlsrv_query($connect, "INSERT INTO GHP_REPAIR_PHOTOS (REPAIR_SEQ, FILE_NAME) VALUES (?, ?)", array($Current_Seq, $newName));
                    }
                }
            }
        }

        sqlsrv_commit($connect);
        
        // 결과 메시지 설정
        $msg = ($mode === 'update') ? "수정되었습니다." : "등록되었습니다.";
        if ($mode === 'update' && $AdminCode === '323650') {
            $msg = "관리자 확정(잠금) 처리가 완료되었습니다.";
        }

        $url = "ghp_repair.php" . (!empty($Ghp_Id_Url) ? "?ghp_id=$Ghp_Id_Url" : "");
        echo "<script>alert('$msg'); location.href='$url';</script>";

    } catch (Exception $e) {
        sqlsrv_rollback($connect);
        // 에러 메시지 출력 (줄바꿈 문자 처리)
        $errMsg = str_replace(["\r", "\n"], "\\n", addslashes($e->getMessage()));
        echo "<script>alert('오류: $errMsg'); history.back();</script>";
    }
}
?>