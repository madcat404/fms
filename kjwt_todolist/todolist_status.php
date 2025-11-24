<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.04>
	// Description:	<to do list>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
	// =============================================

    //★DB연결 및 함수사용
    include_once __DIR__ . '/../DB/DB4.php'; 
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../FUNCTION.php'; 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception; 

    require_once __DIR__ . "/../PHPMailer-master/src/PHPMailer.php";
    require_once __DIR__ . "/../PHPMailer-master/src/SMTP.php";
    require_once __DIR__ . "/../PHPMailer-master/src/Exception.php"; 

    //★변수 초기화 (PHP 8.x 호환성)
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

    //★함수
    /**
     * Sends a support-related email using PHPMailer.
     * @param array $mailInfo Contains all necessary information for the email (to, subject, body, etc.).
     * @param bool $isCompleteMail Determines if it's a completion notification to adjust recipients.
     */
    function sendSupportMail($mailInfo, $isCompleteMail = false) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USERNAME');
            $mail->Password = getenv('SMTP_PASSWORD');
            $mail->SMTPSecure = "tls";
            $mail->Port = (int)getenv('SMTP_PORT');
            $mail->CharSet = "utf-8";

            // Recipients
            $mail->setFrom("sealclear@naver.com", "FMS");
            $mail->addAddress($mailInfo['to'], "요청자");
            if (!$isCompleteMail) {
                $mail->addAddress("skkwon@iwin.kr", "담당자");
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $mailInfo['subject'];
            $mail->Body = $mailInfo['body'];
            
            $mail->send();
        } catch (Exception $e) {
            // In a real app, you should log this error instead of echoing.
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }

    //★버튼 클릭 시 실행
    if($bt21 === "on") {
        $requestor21 = $_POST['requestor21'] ?? '';  
        $kind21 = $_POST['kind21'] ?? '';
        $IMPORTANCE21 = $_POST['IMPORTANCE21'] ?? '';
        $problem21 = nl2br($_POST['problem21'] ?? '');
        $solution21 = nl2br($_POST['solution21'] ?? '');

        // 데이터 기록
        $query_Record = "INSERT INTO CONNECT.dbo.TO_DO_LIST (REQUESTOR, KIND, IMPORTANCE, PROBLEM, SOLUTUIN) OUTPUT INSERTED.NO VALUES (?, ?, ?, ?, ?)";
        $stmt = executeQuery($connect, $query_Record, [$requestor21, $kind21, $IMPORTANCE21, $problem21, $solution21]);
        $inserted_row = sqlsrv_fetch_array($stmt);
        $inserted_no = $inserted_row['NO'] ?? null;

        if ($inserted_no) {
            $newFileName = '';
            // 파일 업로드 처리
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['file'];
                $uploadDir = __DIR__ . '/../files/';
                $allowedExtensions = ['gif', 'png', 'jpeg', 'jpg', 'heic', 'pdf', 'xlsx', 'docx'];
                $maxFileSize = 5 * 1024 * 1024; // 5MB

                $fileName = basename($file['name']);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                if ($file['size'] > $maxFileSize) {
                    echo "<script>alert('파일 크기는 5MB를 초과할 수 없습니다.'); history.back();</script>";
                    exit;
                }
                if (!in_array($fileExt, $allowedExtensions)) {
                    echo "<script>alert('허용되지 않는 파일 형식입니다.'); history.back();</script>";
                    exit;
                }

                $newFileName = 'REQUEST_' . $inserted_no . '_' . uniqid('', true) . '.' . $fileExt;
                $destination = $uploadDir . $newFileName;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $query_UpdateFile = "UPDATE CONNECT.dbo.TO_DO_LIST SET FILE_NM = ? WHERE NO = ?";
                    executeQuery($connect, $query_UpdateFile, [$newFileName, $inserted_no]);
                } else {
                    echo "<script>alert('파일 업로드에 실패했습니다.'); history.back();</script>";
                    exit;
                }
            }

            // 메일 발송 로직
            $query_CheckUser = "SELECT EMAIL, `CALL` FROM user_info WHERE USER_NM = ?";
            $stmt_user = $connect4->prepare($query_CheckUser);
            $stmt_user->bind_param("s", $requestor21);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            $Data_CheckUser = $result_user->fetch_object();

            if ($Data_CheckUser) {
                $h = 'htmlspecialchars';
                $body = "<!DOCTYPE html><html><body><table style='width: 50%;'>
                            <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>NO</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($inserted_no)}</td><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Date</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h(date("Y-m-d"))}</td></tr>
                            <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Requestor</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($requestor21)}</td><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Number</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($Data_CheckUser->CALL)}</td></tr>
                            <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Category</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($kind21)}</td><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Priority</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($IMPORTANCE21)}</td></tr>
                            <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Contents</td><td colspan='3' style='border: 1px solid #000; width: 40%;'>{$problem21}</td></tr>";
                if ($newFileName) {
                    $body .= "<tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>File</td><td colspan='3' style='border: 1px solid #000; width: 40%;'><img src='https://fms.iwin.kr/files/{$h($newFileName)}' style='width: 100%; height: 100%'></td></tr>";
                }
                $body .= "<tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>URL</td><td colspan='3' style='border: 1px solid #000; width: 40%; text-align: center;'><a href='https://fms.iwin.kr/kjwt_todolist/todolist.php'>기술지원 및 문의현황 바로가기</a></td></tr></table></body></html>";

                sendSupportMail(
                    [
                        'to' => $Data_CheckUser->EMAIL,
                        'subject' => "[FMS] 기술지원 & 문의 등록 - NO. " . $inserted_no,
                        'body' => $body
                    ]
                );
            }
        }
        echo "<script>alert('요청이 등록되었습니다.'); location.href='todolist.php';</script>";
        exit;
    }  
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
                    $query_Check = "SELECT * FROM CONNECT.dbo.TO_DO_LIST WHERE NO = ?";
                    $Data_Check = sqlsrv_fetch_array(executeQuery($connect, $query_Check, [$solve_no]));

                    if ($Data_Check) {
                        $query_User = "SELECT EMAIL, `CALL` FROM user_info WHERE USER_NM = ?";
                        $stmt_user = $connect4->prepare($query_User);
                        $stmt_user->bind_param("s", $Data_Check['REQUESTOR']);
                        $stmt_user->execute();
                        $result_user = $stmt_user->get_result();
                        $Data_User = $result_user->fetch_object();

                        if ($Data_User) {
                            $h = 'htmlspecialchars';
                            $sorting_date_formatted = ($Data_Check['SORTING_DATE'] instanceof DateTime) ? $Data_Check['SORTING_DATE']->format('Y-m-d') : ($Data_Check['SORTING_DATE'] ?? '');
                            $body = "<!DOCTYPE html><html><body><table style='width: 50%;'>
                                        <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>NO</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($Data_Check['NO'])}</td><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Date</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($sorting_date_formatted)}</td></tr>
                                        <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Requestor</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($Data_Check['REQUESTOR'])}</td><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Number</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($Data_User->CALL)}</td></tr>
                                        <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Category</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($Data_Check['KIND'])}</td><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Priority</td><td style='border: 1px solid #000; width: 15%; text-align: center;'>{$h($Data_Check['IMPORTANCE'])}</td></tr>
                                        <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Contents</td><td colspan='3' style='border: 1px solid #000; width: 40%;'>{$Data_Check['PROBLEM']}</td></tr>
                                        <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>Answer</td><td colspan='3' style='border: 1px solid #000; width: 40%;'>{$Data_Check['SOLUTUIN']}</td></tr>
                                        <tr><td style='border: 1px solid #000; width: 10%; text-align: center; background-color: #D3D3D3;'>URL</td><td colspan='3' style='border: 1px solid #000; width: 40%; text-align: center;'><a href='https://fms.iwin.kr/kjwt_todolist/todolist.php'>기술지원 및 문의현황 바로가기</a></td></tr></table></body></html>";

                            sendSupportMail(
                                [
                                    'to' => $Data_User->EMAIL,
                                    'subject' => "[FMS] 기술지원 & 문의 처리완료 - NO. " . $Data_Check['NO'],
                                    'body' => $body
                                ], true
                            );
                        }
                    }
                }
            }
        } 

        $query_ModifyUpdate2 = "UPDATE CONNECT.dbo.USE_CONDITION SET LOCK='N' WHERE KIND=?";
        executeQuery($connect, $query_ModifyUpdate2, ['Todolist']);
        header("Location: todolist.php");
        exit;
    }
    
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

    //★메뉴 진입 시 실행
    // 처리되지 않은 항목 조회 (SOLVE가 'N'이거나 NULL인 경우)
    $Query_NotWork = "SELECT * FROM CONNECT.dbo.TO_DO_LIST WHERE SOLVE = 'N' OR SOLVE IS NULL ORDER BY NO DESC";
    $Result_NotWork = executeQuery($connect, $Query_NotWork);

    // 처리되지 않은 항목 개수 조회
    $Query_Count = "SELECT COUNT(*) as count FROM CONNECT.dbo.TO_DO_LIST WHERE SOLVE = 'N' OR SOLVE IS NULL";
    $Result_Count = executeQuery($connect, $Query_Count);
    $Data_Count = sqlsrv_fetch_array($Result_Count);
    $Count_NotWork = $Data_Count['count'] ?? 0;
?>