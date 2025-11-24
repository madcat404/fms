<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.03.09>
	// Description:	<개인차량 운행일지 통합 컨트롤러 및 데이터 조회>
    // Last Modified: <25.11.07> - Refactored to use centralized mailer.php.
    // =============================================

    include_once 'fms_session.php';   
    include_once __DIR__ . '/../DB/DB1.php';
    include_once __DIR__ . '/../FUNCTION.php';

    //================================================================================
    // --- POST 요청 처리 컨트롤러 ---
    //================================================================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // '출발' 폼 처리 (bt1)
        if (isset($_POST['bt1'])) {
            $car_num = filter_input(INPUT_POST, 'my_car_num1', FILTER_DEFAULT);
            $departure = filter_input(INPUT_POST, 'my_departure', FILTER_DEFAULT);
            $destination = filter_input(INPUT_POST, 'my_destination', FILTER_DEFAULT);
            $hipasscard = filter_input(INPUT_POST, 'my_hipasscard', FILTER_DEFAULT);

            $user_stmt = $connect->prepare("SELECT USER_NM, CAR_OIL FROM user_info WHERE CAR_NUM = ?");
            $user_stmt->bind_param("s", $car_num);
            $user_stmt->execute();
            $user_info = $user_stmt->get_result()->fetch_object();

            if (!$user_info) { echo "<script>alert('등록되지 않은 번호입니다!'); history.back();</script>"; exit; }

            $last_run_stmt = $connect->prepare("SELECT KM, UPLOAD_YN FROM user_car WHERE CAR_NUM = ? ORDER BY NO DESC LIMIT 1");
            $last_run_stmt->bind_param("s", $car_num);
            $last_run_stmt->execute();
            $last_run = $last_run_stmt->get_result()->fetch_object();

            if ($last_run) {
                if ($last_run->KM == 0) { echo "<script>alert('먼저 입력한 데이터의 도착정보를 입력하세요!'); history.back();</script>"; exit; }
                if ($last_run->UPLOAD_YN == 'N') { echo "<script>alert('먼저 입력한 데이터의 증빙사진을 업로드 하세요!'); history.back();</script>"; exit; }
            }

            $hipass_yn = (!empty($hipasscard) && is_numeric($hipasscard)) ? 'Y' : 'N';
            $insert_car_stmt = $connect->prepare("INSERT INTO user_car(CAR_NUM, CAR_OIL, DEPARTURE, DESTINATION, HIPASS_YN) VALUES (?, ?, ?, ?, ?)");
            $insert_car_stmt->bind_param("sssss", $car_num, $user_info->CAR_OIL, $departure, $destination, $hipass_yn);
            $insert_car_stmt->execute();

            $alert_msg = "기록되었습니다!";
            if ($hipass_yn === 'Y') {
                $hipass_rent_stmt = $connect->prepare("INSERT INTO hipass_card(USER, KIND, CARD_CONDITION) VALUES (?, ?, 'OUT')");
                $hipass_rent_stmt->bind_param("ss", $user_info->USER_NM, $hipasscard);
                $hipass_rent_stmt->execute();
                $hipass_update_stmt = $connect->prepare("UPDATE hipass_now SET USER=?, CARD_CONDITION='OUT' WHERE NO=?");
                $hipass_update_stmt->bind_param("ss", $user_info->USER_NM, $hipasscard);
                $hipass_update_stmt->execute();
                $alert_msg = "기록되었습니다. 경영팀에서 하이패스 카드를 수령하세요!";
            }
            echo "<script>alert('{$alert_msg}'); location.href='individual.php';</script>";
            exit;
        }

        // '도착' 폼 처리 (bt2)
        if (isset($_POST['bt2'])) {
            $car_num = filter_input(INPUT_POST, 'my_car_num2', FILTER_DEFAULT);
            $km = filter_input(INPUT_POST, 'my_km', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $tollgate = filter_input(INPUT_POST, 'tollgate', FILTER_SANITIZE_NUMBER_INT);
            $tollgate2 = filter_input(INPUT_POST, 'tollgate2', FILTER_SANITIZE_NUMBER_INT);
            $update_date = date("Y-m-d H:i:s");

            if (empty($car_num) || !is_numeric($km)) { echo "<script>alert('차량 번호와 주행 거리를 올바르게 입력해주세요.'); history.back();</script>"; exit; }

            $stmt = $connect->prepare("SELECT * FROM user_car WHERE CAR_NUM = ? ORDER BY NO DESC LIMIT 1");
            $stmt->bind_param("s", $car_num);
            $stmt->execute();
            $check_row1 = $stmt->get_result()->fetch_object();
            
            if ($check_row1) {
                $latest_record_no = $check_row1->NO;
                if($check_row1->HIPASS_YN == 'N') {
                    $tollgate2_val = isset($_POST['cb3']) ? 0 : ($tollgate2 ?? 0);
                    $update_stmt = $connect->prepare("UPDATE user_car SET KM = ?, TOLL_GATE = ? WHERE NO = ?");
                    $update_stmt->bind_param("dii", $km, $tollgate2_val, $latest_record_no);
                    $update_stmt->execute();
                    echo "<script>alert('기록되었습니다. 증빙사진을 업로드 하세요!');</script>";                    
                } 
                elseif($check_row1->HIPASS_YN == 'Y') {
                    if (!is_numeric($tollgate)) {
                        echo "<script>alert('회사 하이패스 잔액을 입력해주세요.'); history.back();</script>";
                        exit;
                    }
                    $user_stmt = $connect->prepare("SELECT USER_NM FROM user_info WHERE CAR_NUM = ?");
                    $user_stmt->bind_param("s", $car_num);
                    $user_stmt->execute();
                    $user_row = $user_stmt->get_result()->fetch_object();
                    if ($user_row) {
                        $hipass_stmt = $connect->prepare("SELECT NO, KIND FROM hipass_card WHERE USER = ? AND CARD_CONDITION='OUT' ORDER BY NO DESC LIMIT 1");
                        $hipass_stmt->bind_param("s", $user_row->USER_NM);
                        $hipass_stmt->execute();
                        $hipass_row = $hipass_stmt->get_result()->fetch_object();
                        if ($hipass_row) {
                            $update_hipass_card_stmt = $connect->prepare("UPDATE hipass_card SET CARD_CONDITION='IN', SUM=?, RETURN_DATE=? WHERE NO=?");
                            $update_hipass_card_stmt->bind_param("isi", $tollgate, $update_date, $hipass_row->NO);
                            $update_hipass_card_stmt->execute();
                            $update_hipass_now_stmt = $connect->prepare("UPDATE hipass_now SET CARD_CONDITION='IN', SUM=? WHERE NO=?");
                            $update_hipass_now_stmt->bind_param("ii", $tollgate, $hipass_row->KIND);
                            $update_hipass_now_stmt->execute();
                            $update_user_car_stmt = $connect->prepare("UPDATE user_car SET KM = ? WHERE NO = ?");
                            $update_user_car_stmt->bind_param("di", $km, $latest_record_no);
                            $update_user_car_stmt->execute();
                            echo "<script>alert('기록되었습니다. 하이패스카드를 경영팀에 반납하고 증빙사진을 업로드 하세요!');</script>";
                            if($tollgate < 30000) {
                                $card_id_to_charge = $hipass_row->KIND;
                                $balance_to_report = $tollgate;

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
                        }
                    }
                }
            } else { echo "<script>alert('등록되지 않은 번호입니다!');</script>"; }
            echo "<script>location.href='individual.php';</script>";
            exit;
        }

        // '증빙' 폼 처리 (bt3)
        if (isset($_POST['bt3'])) {
            if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) { echo "<script>alert('파일 업로드에 실패했습니다.'); history.back();</script>"; exit; }
            $tmpname = $_FILES['file']['tmp_name']; $original_filename = $_FILES['file']['name'];
            if(checkFileHash($tmpname)) { echo "<script>alert('업로드가 제한된 파일입니다!'); history.back();</script>"; exit; }
            if(strlen($original_filename) > 255) { echo "<script>alert('파일 이름이 너무 깁니다.'); history.back();</script>"; exit; }
            $validMimeTypes = ['image/gif', 'image/png', 'image/jpeg', 'image/jpg', 'image/heic']; $validExtensions = ['gif', 'png', 'jpeg', 'jpg', 'heic'];
            $finfo = new finfo(FILEINFO_MIME_TYPE); $mimeType = $finfo->file($tmpname);
            $fileExt = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
            if (!in_array($mimeType, $validMimeTypes) || !in_array($fileExt, $validExtensions)) { echo "<script>alert('유효하지 않은 파일 형식입니다.'); history.back();</script>"; exit; }
            if (@getimagesize($tmpname) === false) { echo "<script>alert('이미지 파일이 아닙니다.'); history.back();</script>"; exit; }
            $img_type = filter_input(INPUT_POST, 'img_type', FILTER_DEFAULT); $car = filter_input(INPUT_POST, 'my_car_num3', FILTER_DEFAULT);
            if (empty($img_type) || empty($car)) { echo "<script>alert('업로드 파일 종류와 차종을 선택하세요!'); history.back();</script>"; exit; }
            $check_stmt = $connect->prepare("SELECT * FROM user_car WHERE CAR_NUM = ? AND UPLOAD_YN = 'N' ORDER BY NO DESC LIMIT 1");
            $check_stmt->bind_param("s", $car); $check_stmt->execute(); $check_result = $check_stmt->get_result(); $check_row = $check_result->fetch_object();
            if (!$check_row) { echo "<script>alert('출발/도착 먼저 입력하세요!!'); location.href='individual.php';</script>"; exit; }

            if ($img_type === 'TollGate' && (int)$check_row->TOLL_GATE === 0) {
                echo "<script>alert('톨게이트비를 입력하지 않은 건에 대해서는 톨게이트비 증빙을 업로드할 수 없습니다.'); history.back();</script>";
                exit;
            }

            $binding_num = $check_row->NO; $name_date = date("Y-m-d_H-i-s");
            $new_filename = "{$name_date}_{$car}_{$img_type}_{$binding_num}.{$fileExt}"; $dir = "../files/{$new_filename}";
            if (move_uploaded_file($tmpname, $dir)) {
                $DT = date("Y-m-d H:i:s"); $Hyphen_today = date("Y-m-d");
                $insert_stmt = $connect->prepare("INSERT INTO files (CAR_NUM, IMG_TYPE, FILE_NM, U_DATE, N_DATE, S_DATE, CHECK_YN, BINDING_NUM, VIEW_YN) VALUES (?, ?, ?, ?, ?, ?, 'N', ?, 'Y')");
                $insert_stmt->bind_param("ssssssi", $car, $img_type, $new_filename, $DT, $name_date, $Hyphen_today, $binding_num);
                $insert_stmt->execute();
                $upload_complete = false;
                if ($check_row->HIPASS_YN == 'Y') { if ($img_type !== 'TollGate') { $upload_complete = true; } }
                else { if ($check_row->TOLL_GATE == 0) { if ($img_type !== 'TollGate') { $upload_complete = true; } }
                    else { $km_check_stmt = $connect->prepare("SELECT 1 FROM files WHERE CHECK_YN = 'N' AND CAR_NUM = ? AND IMG_TYPE = 'Km' AND BINDING_NUM = ?");
                        $km_check_stmt->bind_param("si", $car, $binding_num); $km_check_stmt->execute(); $km_uploaded = $km_check_stmt->get_result()->num_rows > 0;
                        $toll_check_stmt = $connect->prepare("SELECT 1 FROM files WHERE CHECK_YN = 'N' AND CAR_NUM = ? AND IMG_TYPE = 'Tollgate' AND BINDING_NUM = ?");
                        $toll_check_stmt->bind_param("si", $car, $binding_num); $toll_check_stmt->execute(); $toll_uploaded = $toll_check_stmt->get_result()->num_rows > 0;
                        if ($km_uploaded && $toll_uploaded) { $upload_complete = true; } } }
                if ($upload_complete) { $update_stmt = $connect->prepare("UPDATE user_car SET UPLOAD_YN = 'Y' WHERE NO = ?"); $update_stmt->bind_param("i", $binding_num); $update_stmt->execute(); }
                echo "<script>alert('업로드 완료!');</script>";
                $count_res = $connect->query("SELECT COUNT(*) as count FROM user_car WHERE GIVE_YN='N'");
                $num_result = 0;
                if ($count_res) {
                    $data = $count_res->fetch_assoc();
                    if ($data) {
                        $num_result = (int)$data['count'];
                    }
                }
                if ($num_result > 0 && $num_result % 5 == 0) {                               
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://fms.iwin.kr/mailer.php?type=individual_settlement_request");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_exec($ch);
                    curl_close($ch);
                }
            } else { echo "<script>alert('파일 저장에 실패했습니다.');</script>"; }
            echo "<script>location.href='individual.php';</script>";
            exit;
        }

        // '관리자' 폼 처리 (bt4)
        if (isset($_POST['bt4'])) {
            $car_num = filter_input(INPUT_POST, 'my_car_num5', FILTER_DEFAULT);
            $admin_code = filter_input(INPUT_POST, 'my_admin_code', FILTER_DEFAULT);
            $s_date = date("Y-m-d");
            $search_date = date("Y-m-d H:i:s");

            if ($admin_code == '2580') {
                // 유가 비교 로직 (항상 실행)
                $gasoline_price_stmt = $connect->prepare("SELECT OIL_PRICE FROM oil_price WHERE car_oil='휘발유' AND s_date=?");
                $gasoline_price_stmt->bind_param("s", $s_date);
                $gasoline_price_stmt->execute();
                $gasoline_price_row = $gasoline_price_stmt->get_result()->fetch_object();
                $gasoline_price = $gasoline_price_row->OIL_PRICE ?? 0;

                $diesel_price_stmt = $connect->prepare("SELECT OIL_PRICE FROM oil_price WHERE car_oil='경유' AND s_date=?");
                $diesel_price_stmt->bind_param("s", $s_date);
                $diesel_price_stmt->execute();
                $diesel_price_row = $diesel_price_stmt->get_result()->fetch_object();
                $diesel_price = $diesel_price_row->OIL_PRICE ?? 0;

                if ($gasoline_price > 0 && $diesel_price > 0 && $gasoline_price < $diesel_price) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://fms.iwin.kr/mailer.php?type=individual_api_error");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_exec($ch);
                    curl_close($ch);
                    
                    echo "<script>alert('한국석유공사 API에서 가져온 유가 정보에 오류가 의심됩니다.'); location.href='individual.php';</script>";
                    exit;
                }

                // 정산 로직
                if (strcasecmp($car_num, 'all') !== 0) { // 단일 처리
                    $user_info_stmt = $connect->prepare("SELECT CAR_NUM FROM user_info WHERE CAR_NUM = ?");
                    $user_info_stmt->bind_param("s", $car_num);
                    $user_info_stmt->execute();
                    if ($user_info_stmt->get_result()->num_rows > 0) {
                        $calc_stmt = $connect->prepare("SELECT * FROM user_car WHERE CAR_NUM = ? AND GIVE_OIL = 0 AND GIVE_CHECK = 'N' AND UPLOAD_YN = 'Y'");
                        $calc_stmt->bind_param("s", $car_num);
                        $calc_stmt->execute();
                        $calc_res = $calc_stmt->get_result();
                        while ($row = $calc_res->fetch_object()) {
                            $oil_price_stmt = $connect->prepare("SELECT OIL_PRICE FROM oil_price WHERE CAR_OIL = ? AND S_DATE = ?");
                            $oil_price_stmt->bind_param("ss", $row->CAR_OIL, $s_date);
                            $oil_price_stmt->execute();
                            $price_row = $oil_price_stmt->get_result()->fetch_object();
                            $current_oil_price = $price_row->OIL_PRICE ?? 1;
                            $calc = ($row->HIPASS_YN == 'N') ? ceil(($row->KM / 10) + ($row->TOLL_GATE / $current_oil_price)) : ceil($row->KM / 10);
                            if ($calc > 0) {
                                $update_stmt = $connect->prepare("UPDATE user_car SET GIVE_OIL = ?, GIVE_CHECK = 'Y', UPDATE_DATE = ? WHERE NO = ?");
                                $update_stmt->bind_param("isi", $calc, $search_date, $row->NO);
                                $update_stmt->execute();
                                $files_update_stmt = $connect->prepare("UPDATE files SET CHECK_YN = 'Y' WHERE CAR_NUM = ? AND CHECK_YN = 'N' AND BINDING_NUM = ?");
                                $files_update_stmt->bind_param("si", $car_num, $row->NO);
                                $files_update_stmt->execute();
                            }
                        }
                        echo "<script>alert('정산되었습니다!');</script>";
                    } else {
                        echo "<script>alert('등록되지 않은 번호입니다!');</script>";
                    }
                } else { // 일괄 처리
                    $all_calc_stmt = $connect->prepare("SELECT * FROM user_car WHERE GIVE_OIL = 0 AND GIVE_CHECK = 'N' AND UPLOAD_YN = 'Y'");
                    $all_calc_stmt->execute();
                    $all_calc_res = $all_calc_stmt->get_result();
                    while ($row = $all_calc_res->fetch_object()) {
                        $oil_price_stmt = $connect->prepare("SELECT OIL_PRICE FROM oil_price WHERE CAR_OIL = ? AND S_DATE = ?");
                        $oil_price_stmt->bind_param("ss", $row->CAR_OIL, $s_date);
                        $oil_price_stmt->execute();
                        $price_row = $oil_price_stmt->get_result()->fetch_object();
                        $current_oil_price = $price_row->OIL_PRICE ?? 1;
                        $calc2 = ($row->HIPASS_YN == 'N') ? ceil(($row->KM / 10) + ($row->TOLL_GATE / $current_oil_price)) : ceil($row->KM / 10);
                        if ($calc2 > 0) {
                            $update_stmt = $connect->prepare("UPDATE user_car SET GIVE_OIL = ?, GIVE_CHECK = 'Y', UPDATE_DATE = ? WHERE NO = ?");
                            $update_stmt->bind_param("isi", $calc2, $search_date, $row->NO);
                            $update_stmt->execute();
                            $files_update_stmt = $connect->prepare("UPDATE files SET CHECK_YN = 'Y' WHERE CHECK_YN = 'N' AND BINDING_NUM = ?");
                            $files_update_stmt->bind_param("i", $row->NO);
                            $files_update_stmt->execute();
                        }
                    }
                    echo "<script>alert('도착정보를 입력한 데이터만 결재하였습니다!');</script>";
                }
                // 메일 발송은 공통
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://fms.iwin.kr/mailer.php?type=individual_voucher_request");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_exec($ch);
                curl_close($ch);

            } elseif ($admin_code == '323650') {
                if (strcasecmp($car_num, 'all') !== 0) { // 단일 처리
                    $user_info_stmt = $connect->prepare("SELECT CAR_NUM FROM user_info WHERE CAR_NUM = ?");
                    $user_info_stmt->bind_param("s", $car_num);
                    $user_info_stmt->execute();
                    if ($user_info_stmt->get_result()->num_rows > 0) {
                        $give_stmt = $connect->prepare("UPDATE user_car SET GIVE_YN = 'Y', UPDATE_DATE = ? WHERE CAR_NUM = ? AND GIVE_CHECK = 'Y' AND GIVE_YN = 'N'");
                        $give_stmt->bind_param("ss", $search_date, $car_num);
                        $give_stmt->execute();
                        echo "<script>alert('지급완료되었습니다!');</script>";
                    } else {
                        echo "<script>alert('등록되지 않은 번호입니다!');</script>";
                    }
                } else { // 일괄 처리
                    $all_give_stmt = $connect->prepare("UPDATE user_car SET GIVE_YN = 'Y', UPDATE_DATE = ? WHERE GIVE_CHECK = 'Y' AND GIVE_YN = 'N'");
                    $all_give_stmt->bind_param("s", $search_date);
                    $all_give_stmt->execute();
                    echo "<script>alert('정산된 데이터만 지급완료되었습니다!');</script>";
                }
                // 메일 발송은 공통
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://fms.iwin.kr/mailer.php?type=individual_gas_ticket_notice");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_exec($ch);
                curl_close($ch);

            } else {
                echo "<script>alert('패스워드가 일치하지 않습니다!');</script>";
            }

            echo "<script>location.href='individual.php';</script>";
            exit;
        }
    }

    //================================================================================
    // --- 페이지 표시 데이터 조회 ---
    //================================================================================

    $select_date = date("Y-m-d");
    $dt = date("Y-m-d H:i:s");

    $hipass_cards = [];
    $query = $connect->query("SELECT * FROM hipass_now WHERE CARD_CONDITION='IN'");
    if ($query) { while ($row = $query->fetch_object()) { $hipass_cards[] = $row; } }
    
    $result1 = $connect->query("SELECT * FROM user_car WHERE GIVE_YN='N' ORDER BY CAR_NUM");
    $num_result = $result1 ? $result1->num_rows : 0;

    function get_oil_price($connect, $oil_type, $date) {
        $stmt = $connect->prepare("SELECT OIL_PRICE FROM oil_price WHERE car_oil=? AND s_date=?");
        $stmt->bind_param("ss", $oil_type, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }

    $row11 = get_oil_price($connect, '휘발유', $select_date);
    $row22 = get_oil_price($connect, '경유', $select_date);
    $row33 = get_oil_price($connect, 'LPG', $select_date);

    // 7일 이상 증빙 미업로드 건 조회 및 알림 메일 발송
    $seven_days_ago = date("Y-m-d H:i:s", strtotime("-7 days"));
    $check_stmt = $connect->prepare("SELECT NO, CAR_NUM FROM user_car WHERE UPLOAD_YN='N' AND OVER_MAIL_YN='N' AND RECORD_DATE < ?");
    $check_stmt->bind_param("s", $seven_days_ago);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    while ($overdue_row = $check_result->fetch_object()) {
        $user_info_stmt = $connect->prepare("SELECT EMAIL FROM user_info WHERE CAR_NUM=?");
        $user_info_stmt->bind_param("s", $overdue_row->CAR_NUM);
        $user_info_stmt->execute();
        $user_info = $user_info_stmt->get_result()->fetch_object();

        if ($user_info && !empty($user_info->EMAIL)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://fms.iwin.kr/mailer.php?type=individual_check_request&to=" . urlencode($user_info->EMAIL));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_exec($ch);
            curl_close($ch);

            $update_stmt = $connect->prepare("UPDATE user_car SET OVER_MAIL_YN='Y' WHERE NO=?");
            $update_stmt->bind_param("i", $overdue_row->NO);
            $update_stmt->execute();
        }
    }
?>