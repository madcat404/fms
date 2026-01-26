<?php   
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>    
    // Create date: <22.05.04>
    // Description: <to do list backend>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
    // Modified: <2026.01.14> - Refactored to use centralized mailer.php
    // =============================================

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php'; 
    include_once __DIR__ . '/../DB/DB4.php'; 
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../FUNCTION.php'; 
    
    // [변경] mailer_service.php 포함 제거 (mailer.php가 처리함)
    // include_once __DIR__ . '/../mailer_service.php'; 

    //★변수 초기화
    $modi = $_GET["modi"] ?? '';
    $bt21 = $_POST['bt21'] ?? '';
    $bt22 = $_POST['bt22'] ?? '';   
    $dt3 = $_POST['dt3'] ?? '';
    $s_dt3 = $dt3 ? substr($dt3, 0, 10) : '';       
    $e_dt3 = $dt3 ? substr($dt3, 13, 10) : '';
    $bt31 = $_POST['bt31'] ?? '';

    //★메뉴 진입 시 탭활성화
    $tab2 = '';
    $tab3 = '';
    $tab2_text = '';
    $tab3_text = '';
    $tab_sequence = 2;
    if ($bt31 === 'on') {
        $tab_sequence = 3;
    }
    include_once __DIR__ . '/../TAB.php'; 

    // [추가] mailer.php로 발송 요청을 보내는 함수 (cURL 사용)
    function send_request_to_mailer($params) {
        // mailer.php의 실제 URL (서버 환경에 맞게 수정 필요, 보통 도메인 사용 권장)
        $url = 'https://fms.iwin.kr/mailer.php'; 

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 결과를 문자열로 받음 (화면 출력 방지)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 내부 통신용 (필요시 true)
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5초 타임아웃 (메일 발송 대기)
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            error_log("[Todolist Status] cURL Error: " . curl_error($ch));
        }
        curl_close($ch);
        
        return $response;
    }

    //★버튼 클릭 시 실행
    // 1. 입력 처리 (bt21)
    if($bt21 === "on") {
        $requestor21 = $_POST['requestor21'] ?? '';   
        $kind21 = $_POST['kind21'] ?? '';
        $IMPORTANCE21 = $_POST['IMPORTANCE21'] ?? '';
        $problem21 = $_POST['problem21'] ?? '';
        $solution21 = $_POST['solution21'] ?? '';

        sqlsrv_begin_transaction($connect);

        try {
            // 1) 메인 데이터 기록
            $query_Record = "INSERT INTO CONNECT.dbo.TO_DO_LIST (REQUESTOR, KIND, IMPORTANCE, PROBLEM, SOLUTUIN, SORTING_DATE) OUTPUT INSERTED.NO VALUES (?, ?, ?, ?, ?, GETDATE())";
            $stmt = sqlsrv_query($connect, $query_Record, [$requestor21, $kind21, $IMPORTANCE21, $problem21, $solution21]);
            
            if ($stmt === false) throw new Exception("DB Insert Failed: " . print_r(sqlsrv_errors(), true));
            
            $inserted_row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            $inserted_no = $inserted_row['NO'] ?? null;
            if (!$inserted_no) throw new Exception("Failed to retrieve Inserted ID.");

            // 2) 다중 파일 업로드 처리
            if (isset($_FILES['files'])) {
                $fileCount = count($_FILES['files']['name']);
                $uploadDir = __DIR__ . '/../files/';
                $allowedExtensions = ['gif', 'png', 'jpeg', 'jpg', 'heic', 'pdf', 'xlsx', 'docx', 'zip', 'txt'];
                $maxFileSize = 10 * 1024 * 1024;

                for ($i = 0; $i < $fileCount; $i++) {
                    if ($_FILES['files']['error'][$i] === UPLOAD_ERR_OK) {
                        $tmpName = $_FILES['files']['tmp_name'][$i];
                        $originName = $_FILES['files']['name'][$i];
                        $fileSize = $_FILES['files']['size'][$i];
                        $fileExt = strtolower(pathinfo($originName, PATHINFO_EXTENSION));

                        if ($fileSize > $maxFileSize || !in_array($fileExt, $allowedExtensions)) continue;

                        $uniqueName = 'REQUEST_' . $inserted_no . '_' . uniqid() . '.' . $fileExt;
                        $destination = $uploadDir . $uniqueName;

                        if (move_uploaded_file($tmpName, $destination)) {
                            $sql_file = "INSERT INTO CONNECT.dbo.TO_DO_LIST_FILES (PARENT_NO, ORIG_FILENAME, SAVED_FILENAME, FILE_SIZE) VALUES (?, ?, ?, ?)";
                            $stmt_file = sqlsrv_query($connect, $sql_file, [$inserted_no, $originName, $uniqueName, $fileSize]);
                            if ($stmt_file === false) throw new Exception("File DB Insert Failed");
                        }
                    }
                }
            }
            sqlsrv_commit($connect);

            // 3) [변경] mailer.php 호출 (cURL)
            // 직접 메일을 보내지 않고 mailer.php에 type과 게시글 번호(no)만 전달합니다.
            send_request_to_mailer([
                'type' => 'todolist_regist',
                'no'   => $inserted_no
            ]);

            echo "<script>alert('요청이 등록되었습니다.'); location.href='todolist.php';</script>";

        } catch (Exception $e) {
            sqlsrv_rollback($connect);
            echo "<script>alert('오류: " . addslashes($e->getMessage()) . "'); history.back();</script>";
        }
        exit;
    }   

    // 2. 수정 모드 체크
    elseif($modi === 'Y') { 
        $Query_ModifyCheck = "SELECT [LOCK], WHO FROM CONNECT.dbo.USE_CONDITION WHERE KIND = ?";
        $Data_ModifyCheck = sqlsrv_fetch_array(executeQuery($connect, $Query_ModifyCheck, ['Todolist']));

        if($Data_ModifyCheck && $Data_ModifyCheck['LOCK'] === 'N') {
            $s_ip = $_SERVER['REMOTE_ADDR'];
            $Query_ModifyUpdate = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='Y', WHO=?, LAST_DT=? WHERE KIND=?";
            executeQuery($connect, $Query_ModifyUpdate, [$s_ip, date("Y-m-d H:i:s"), 'Todolist']);
        } else {
            echo "<script>alert('다른 사람이 수정중 입니다!'); location.href='todolist.php';</script>";
            exit;
        }
    }

    // 3. 답변 저장 및 완료 처리 (bt22)
    elseif($bt22 === "on") {
        $limit = (int)($_POST["until"] ?? 0);

        for($a = 1; $a < $limit; $a++) {
            $solution = $_POST['SOLUTUIN' . $a] ?? null;
            $solve_status = $_POST['SOLVE_STATUS' . $a] ?? null;
            $solve_no = $_POST['solve_no' . $a] ?? null;

            if ($solve_no && $solve_status !== null) {
                $query_StatusUpdate = "UPDATE CONNECT.dbo.TO_DO_LIST SET SOLUTUIN = ?, SOLVE = ? WHERE NO = ?";
                executeQuery($connect, $query_StatusUpdate, [&$solution, &$solve_status, &$solve_no]);

                if($solve_status === 'Y') {
                    // 4) [변경] mailer.php 호출 (완료 알림)
                    send_request_to_mailer([
                        'type' => 'todolist_finish',
                        'no'   => $solve_no
                    ]);
                }
            }
        } 
        $query_ModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND=?";
        executeQuery($connect, $query_ModifyUpdate2, ['Todolist']);
        header("Location: todolist.php");
        exit;
    }
    
    // 4. 검색 데이터 조회 (bt31)
    $Data_WorkHistory = [];
    if($bt31 === "on") {
        $query_WorkHistory = "SELECT * FROM CONNECT.dbo.TO_DO_LIST WHERE SORTING_DATE BETWEEN ? AND ? ORDER BY NO DESC";
        $stmt = executeQuery($connect, $query_WorkHistory, [$s_dt3, $e_dt3]);
        if ($stmt) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $Data_WorkHistory[] = $row;
            }
        }
    }

    //★메뉴 진입 시 실행: 미처리 항목 조회
    $Query_NotWork = "SELECT * FROM CONNECT.dbo.TO_DO_LIST WHERE SOLVE = 'N' OR SOLVE IS NULL ORDER BY NO DESC";
    $Result_NotWork = executeQuery($connect, $Query_NotWork);
    $Query_Count = "SELECT COUNT(*) as count FROM CONNECT.dbo.TO_DO_LIST WHERE SOLVE = 'N' OR SOLVE IS NULL";
    $Result_Count = executeQuery($connect, $Query_Count);
    $Data_Count = sqlsrv_fetch_array($Result_Count);
    $Count_NotWork = $Data_Count['count'] ?? 0;
?>