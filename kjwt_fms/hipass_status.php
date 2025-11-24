<?php   
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.03.13>
	// Description:	<하이패스현황 조회 모듈>	
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
    // =============================================
  
    include 'fms_session.php';
    include_once __DIR__ . '/../DB/DB1.php';
    
    // PHP 8.x and security enhancements
    // 1. Use prepared statements to prevent SQL injection.
    // 2. Use password_hash() and password_verify() for passwords.
    // 3. Add null checks for database results to prevent errors.
    // 4. Sanitize all POST/GET inputs.

    $s_date = date("Y-m-d");  
    $dt = date("Y-m-d H:i:s");

    // Sanitize inputs
    $bt2 = filter_input(INPUT_POST, 'bt2', FILTER_SANITIZE_STRING);
    $bt31 = filter_input(INPUT_POST, 'bt31', FILTER_SANITIZE_STRING);
    $bt32 = filter_input(INPUT_POST, 'bt32', FILTER_SANITIZE_STRING);
    $tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_STRING);

    // Tab 2 variables
    $hipasscard = filter_input(INPUT_POST, 'hipasscard', FILTER_SANITIZE_NUMBER_INT);
	$card_sum = filter_input(INPUT_POST, 'card_sum', FILTER_SANITIZE_NUMBER_INT);
	$card_admin = $_POST['card_admin'] ?? null;

    // Tab 3 variables
    $hipasscard31 = filter_input(INPUT_POST, 'hipasscard31', FILTER_SANITIZE_NUMBER_INT);
	$user = filter_input(INPUT_POST, 'user3', FILTER_SANITIZE_STRING);
    $hipasscard32 = filter_input(INPUT_POST, 'hipasscard32', FILTER_SANITIZE_NUMBER_INT);
    $card_balance = filter_input(INPUT_POST, 'card_balance', FILTER_SANITIZE_NUMBER_INT);
	$password31 = $_POST['password31'] ?? null;
	$password32 = $_POST['password32'] ?? null;

    // Stored password hash for '323650'
    $password_hash = '$2y$12$zMPbMsSHfruSEvkDMREblevTsqC.El.EoIJ/w.zugB1BhlHJQndG2';

    // Tab activation logic
    $tab2 = 'active';
    $tab3 = '';
    $tab2_text = 'show active';
    $tab3_text = '';
    
    if ($bt31 === "on" || $bt32 === "on" || $tab === "3") {
        $tab2 = '';
        $tab3 = 'active';
        $tab2_text = '';
        $tab3_text = 'show active';
    }

    // Fetch available hipass cards
    $in_hipass = [];
    $qs_check_in_hipass = $connect->query("SELECT * FROM hipass_now WHERE CARD_CONDITION='IN'");
    if ($qs_check_in_hipass) {
        while ($row = $qs_check_in_hipass->fetch_object()) {
            $in_hipass[] = $row;
        }
    }

    // Fetch unavailable hipass cards
    $out_hipass = [];
    $qs_check_out_hipass = $connect->query("SELECT * FROM hipass_now WHERE CARD_CONDITION='OUT'");
    if ($qs_check_out_hipass) {
        while ($row = $qs_check_out_hipass->fetch_object()) {
            $out_hipass[] = $row;
        }
    }

    // Helper function to fetch object safely
    function fetch_object_safely($connect, $query, $params = [], $types = "") {
        $stmt = $connect->prepare($query);
        if ($stmt) {
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                return $result->fetch_object();
            }
        }
        return null;
    }

    // Fetch hipass details
    $row1 = fetch_object_safely($connect, "SELECT * FROM hipass_now WHERE NO=?", [1], "i");
    $row2 = fetch_object_safely($connect, "SELECT * FROM hipass_now WHERE NO=?", [2], "i");
    $row3 = fetch_object_safely($connect, "SELECT * FROM hipass_now WHERE NO=?", [3], "i");
    $row4 = fetch_object_safely($connect, "SELECT * FROM hipass_now WHERE NO=?", [4], "i");

    $dt_row1 = fetch_object_safely($connect, "SELECT * FROM hipass_card WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND='1')");
    $dt_row2 = fetch_object_safely($connect, "SELECT * FROM hipass_card WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND='2')");
    $dt_row3 = fetch_object_safely($connect, "SELECT * FROM hipass_card WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND='3')");
    $dt_row4 = fetch_object_safely($connect, "SELECT * FROM hipass_card WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND='4')");

    $user_row1 = fetch_object_safely($connect, "SELECT * FROM hipass_card WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND='1' AND CARD_CONDITION='IN')");
    $user_row2 = fetch_object_safely($connect, "SELECT * FROM hipass_card WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND='2' AND CARD_CONDITION='IN')");
    $user_row3 = fetch_object_safely($connect, "SELECT * FROM hipass_card WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND='3' AND CARD_CONDITION='IN')");
    $user_row4 = fetch_object_safely($connect, "SELECT * FROM hipass_card WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND='4' AND CARD_CONDITION='IN')");

    // Charge hipass card
    if ($hipasscard !== NULL && $bt2 === 'on') {
        if (password_verify($card_admin, $password_hash)) {
            $stmt = $connect->prepare("SELECT SUM FROM hipass_card WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND = ? AND CARD_CONDITION='IN')");
            $stmt->bind_param("i", $hipasscard);
            $stmt->execute();
            $result = $stmt->get_result();
            $check_row = $result->fetch_object();

            if ($check_row) {
                $card_sum2 = $card_sum + $check_row->SUM;

                $stmt1 = $connect->prepare("INSERT INTO hipass_card(USER, KIND, CARD_CONDITION, SUM) VALUES('경영팀', ?, '충전', ?)");
                $stmt1->bind_param("ii", $hipasscard, $card_sum);
                $stmt1->execute();

                $stmt2 = $connect->prepare("UPDATE hipass_card SET SUM=?, SUM_UPDATE_YN='Y' WHERE NO IN (SELECT MAX(NO) FROM hipass_card WHERE KIND = ? AND CARD_CONDITION='IN')");
                $stmt2->bind_param("ii", $card_sum2, $hipasscard);
                $stmt2->execute();

                $stmt3 = $connect->prepare("UPDATE hipass_now SET SUM=? WHERE NO=?");
                $stmt3->bind_param("ii", $card_sum2, $hipasscard);
                $stmt3->execute();
                
                echo "<script>alert('기록되었습니다!');location.href='hipass.php';</script>";
            }
        } else {
            echo "<script>alert('패스워드가 알맞지 않습니다!');</script>";
        }
    } elseif ($hipasscard === NULL && $bt2 === 'on') {
        echo "<script>alert('카드를 선택하세요!');</script>";
    }

    // Rent hipass card
    if ($hipasscard31 !== NULL && $bt31 === 'on') {
        if (password_verify($password31, $password_hash)) {
            $stmt = $connect->prepare("SELECT * FROM user_info WHERE USER_NM = ?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt1 = $connect->prepare("INSERT INTO hipass_card(USER, KIND, CARD_CONDITION) VALUES(?,?,'OUT')");
                $stmt1->bind_param("si", $user, $hipasscard31);
                if (!$stmt1->execute()) {
                    echo "<script>alert('DB 오류: " . $stmt1->error . "');location.href='hipass.php?tab=3';</script>";
                    exit;
                }

                $stmt2 = $connect->prepare("UPDATE hipass_now SET USER=?, CARD_CONDITION='OUT' WHERE NO=?");
                $stmt2->bind_param("si", $user, $hipasscard31);
                $stmt2->execute();

                echo "<script>alert('기록 되었습니다. 경영팀에서 하이패스 카드를 수령하세요!');location.href='hipass.php?tab=3';</script>";
            } else {
                echo "<script>alert('등록되지 않은 사용자입니다.');location.href='hipass.php?tab=3';</script>";
                exit;
            }
        } else {
            echo "<script>alert('패스워드가 알맞지 않습니다!');</script>";
        }
    } elseif ($hipasscard31 === NULL && $bt31 === 'on') {
        echo "<script>alert('카드를 선택하세요!');</script>";
    }

    // Return hipass card
    if ($hipasscard32 !== NULL && $bt32 === 'on') {
        if (password_verify($password32, $password_hash)) {
            $stmt1 = $connect->prepare("UPDATE hipass_card SET CARD_CONDITION='IN', SUM=?, RETURN_DATE=? WHERE KIND=? AND CARD_CONDITION='OUT'");
            $stmt1->bind_param("isi", $card_balance, $dt, $hipasscard32);
            $stmt1->execute();

            $stmt2 = $connect->prepare("UPDATE hipass_now SET CARD_CONDITION='IN', SUM=? WHERE NO=?");
            $stmt2->bind_param("ii", $card_balance, $hipasscard32);
            $stmt2->execute();

            if ($card_balance < 30000) {
                $card_id_to_charge = $hipasscard32 ?? null;
                $balance_to_report = $card_balance ?? 0;

                // cURL을 사용하여 mailer.php에 비동기적으로 요청
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://fms.iwin.kr/mailer.php");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                    'type' => 'hipass_charge_notice',
                    'card_id' => $card_id_to_charge,
                    'balance' => $balance_to_report
                ]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 타임아웃 설정
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 로컬 환경 등에서 SSL 검증 비활성화

                $response = curl_exec($ch);

                if (curl_errno($ch)) {
                    error_log('cURL Error (hipass_charge_notice): ' . curl_error($ch));
                }
                
                curl_close($ch);
            }
            
            echo "<script>alert('기록 되었습니다. 경영팀에 하이패스 카드를 반납하세요!');location.href='hipass.php?tab=3';</script>";
        } else {
            echo "<script>alert('패스워드가 알맞지 않습니다!');</script>";
        }
    } elseif ($hipasscard32 === NULL && $bt32 === 'on') {
        echo "<script>alert('카드를 선택하세요!');</script>";
    }
?>