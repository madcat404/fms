<?php
// 파일명: layout_view_status.php

require_once __DIR__ . '/../session/session_check.php';
if (file_exists('../DB/DB2.php')) {
    include_once __DIR__ . '/../DB/DB2.php';
} else {
    echo "<script>alert('DB 연결 파일 없음'); history.back();</script>";
    exit;
}

header('Content-Type: application/json; charset=utf-8');

if ($connect === false) {
    echo json_encode(['status' => 'error', 'message' => 'DB 접속 실패', 'details' => sqlsrv_errors()]);
    exit;
}

$mode = $_POST['mode'] ?? '';
$transactionStarted = false;

try {
    if ($mode === 'SAVE') {
        // ... (기존 저장 로직 유지) ...
        $items = json_decode($_POST['items'], true);

        if (sqlsrv_begin_transaction($connect) === false) {
            throw new Exception("트랜잭션 시작 실패: " . print_r(sqlsrv_errors(), true));
        }
        $transactionStarted = true;

        $sqlDelete = "DELETE FROM LAYOUT_EQUIPMENT";
        $stmtDelete = sqlsrv_query($connect, $sqlDelete);
        
        if ($stmtDelete === false) {
            throw new Exception("기존 데이터 삭제 실패: " . print_r(sqlsrv_errors(), true));
        }

        if (!empty($items)) {
            $sqlInsert = "INSERT INTO LAYOUT_EQUIPMENT (EQUIP_ID, EQUIP_NAME, POS_X, POS_Y, WIDTH, HEIGHT, Z_INDEX, ROTATION, DESCRIPTION, STATUS, REG_DATE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE())";

            foreach ($items as $item) {
                $params = [
                    $item['id'],
                    !empty($item['name']) ? $item['name'] : $item['id'],
                    (int)$item['x'],
                    (int)$item['y'],
                    (int)$item['w'],
                    (int)$item['h'],
                    (int)$item['z'],
                    (int)$item['r'],
                    isset($item['desc']) ? $item['desc'] : '',
                    isset($item['status']) ? $item['status'] : 'NORMAL'
                ];
                $stmtInsert = sqlsrv_query($connect, $sqlInsert, $params);
                if ($stmtInsert === false) throw new Exception("데이터 삽입 실패");
            }
        }

        sqlsrv_commit($connect);
        echo json_encode(['status' => 'success', 'message' => '저장되었습니다.']);

    } elseif ($mode === 'LOAD') {
        // ... (기존 불러오기 로직 유지) ...
        $sqlSelect = "SELECT EQUIP_ID, EQUIP_NAME, POS_X, POS_Y, WIDTH, HEIGHT, Z_INDEX, ROTATION, DESCRIPTION, STATUS FROM LAYOUT_EQUIPMENT";
        $stmtSelect = sqlsrv_query($connect, $sqlSelect);
        if ($stmtSelect === false) throw new Exception("데이터 조회 실패");

        $data = [];
        while ($row = sqlsrv_fetch_array($stmtSelect, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $data]);

    } elseif ($mode === 'LOAD_PALETTE') {
        // --- [NEW] 설비 목록 불러오기 (TEST_ROOM_CHECKLIST) ---
        // 요청하신 쿼리 적용
        $sqlPalette = "SELECT [EQUIPMENT_NAME] FROM [CONNECT].[dbo].[TEST_ROOM_CHECKLIST] GROUP BY EQUIPMENT_NAME ORDER BY EQUIPMENT_NAME ASC";
        
        $stmtPalette = sqlsrv_query($connect, $sqlPalette);
        if ($stmtPalette === false) {
            throw new Exception("설비 목록 조회 실패: " . print_r(sqlsrv_errors(), true));
        }

        $paletteData = [];
        while ($row = sqlsrv_fetch_array($stmtPalette, SQLSRV_FETCH_ASSOC)) {
            // 값이 비어있지 않은 경우만 추가
            if (!empty($row['EQUIPMENT_NAME'])) {
                $paletteData[] = $row['EQUIPMENT_NAME'];
            }
        }
        
        echo json_encode(['status' => 'success', 'data' => $paletteData]);

    } else {
        throw new Exception("잘못된 요청 모드입니다.");
    }

} catch (Exception $e) {
    if ($transactionStarted) sqlsrv_rollback($connect);
    echo json_encode(['status' => 'error', 'message' => '오류 발생', 'details' => $e->getMessage()]);
} finally {
    if (isset($connect)) sqlsrv_close($connect);
}
?>