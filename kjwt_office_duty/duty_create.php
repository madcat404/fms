<?php
	// =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>
	// Create date: <20.10.12>
	// Description: <당직명령 생성 모듈>
	// Last Modified: <25.10.13> - Refactored for PHP 8.x and security.
	// =============================================
	include '../session/ip_session.php';
	include '../DB/DB1.php';

	// --- 1. 날짜 설정 (DateTime 객체 사용) ---
	try {
		$date = new DateTime();
		$date->modify('+2 months'); // 두 달 뒤 날짜로 설정
		$targetYear = $date->format('Y');
		$targetMonth = $date->format('m');
		$lastDayOfMonth = (int)$date->format('t');
	} catch (Exception $e) {
		die('날짜 처리 중 오류 발생: ' . $e->getMessage());
	}

	// --- 2. 이미 해당 월의 데이터가 있는지 확인 ---
	$check_query = "SELECT dt FROM duty WHERE dt LIKE ? LIMIT 1";
	$stmt_check = $connect->prepare($check_query);
	$month_prefix = $targetYear . $targetMonth . '%';
	$stmt_check->bind_param("s", $month_prefix);
	$stmt_check->execute();
	$stmt_check->store_result();

	if ($stmt_check->num_rows > 0) {
		echo "<script>alert('이미 " . $targetMonth . "월 당직명령이 생성되었습니다.'); location.href='../index.php';</script>";
		exit;
	}
	$stmt_check->close();

	// --- 3. 필요한 데이터 미리 조회 ---
	// 휴일 정보 미리 조회
	$holiday_query = "SELECT dt, holiday_name FROM duty_holiday WHERE dt LIKE ?";
	$stmt_holiday = $connect->prepare($holiday_query);
	$stmt_holiday->bind_param("s", $month_prefix);
	$stmt_holiday->execute();
	$holiday_result = $stmt_holiday->get_result();
	$holidays = [];
	while ($row = $holiday_result->fetch_assoc()) {
		$holidays[$row['dt']] = $row['holiday_name'];
	}
	$stmt_holiday->close();

	// 당직 근무자 정보 미리 조회
	$user_query = "SELECT USER_NM, DUTY_NUM FROM user_info WHERE DUTY_YN='Y' ORDER BY DUTY_NUM ASC";
	$user_result = $connect->query($user_query);
	$duty_users = [];
	while ($row = $user_result->fetch_assoc()) {
		// DUTY_NUM을 키로 사용하여 이름 저장
		$duty_users[$row['DUTY_NUM']] = $row['USER_NM'];
	}
	$duty_user_count = count($duty_users);

	if ($duty_user_count == 0) {
		die('당직 설정된 사용자가 없습니다.');
	}

	// 마지막 근무자 번호 조회
	$last_duty_num_query = "SELECT duty_num FROM duty WHERE holiday_yn='N' ORDER BY dt DESC LIMIT 1";
	$last_duty_result = $connect->query($last_duty_num_query);
	$last_duty_row = $last_duty_result->fetch_assoc();
	$current_duty_num = $last_duty_row ? (int)$last_duty_row['duty_num'] : 0;

	// --- 4. 당직 데이터 생성 및 삽입 루프 ---
	$insert_sql = "INSERT INTO duty (dt, holiday_yn, duty_person, duty_num) VALUES (?, ?, ?, ?)";
	$stmt_insert = $connect->prepare($insert_sql);

	for ($day = 1; $day <= $lastDayOfMonth; $day++) {
		$current_day_str = str_pad($day, 2, '0', STR_PAD_LEFT);
		$full_date = $targetYear . $targetMonth . $current_day_str;

		if (isset($holidays[$full_date])) { // 휴일인 경우
			$holiday_yn = 'Y';
			$person = $holidays[$full_date];
			$duty_num_val = 99; // 휴일 코드
		} else { // 평일인 경우
			$current_duty_num++;
			if ($current_duty_num > $duty_user_count) {
				$current_duty_num = 1; // 순서 리셋
			}
			
			$holiday_yn = 'N';
			$person = $duty_users[$current_duty_num] ?? '배정오류'; // 해당 번호의 사용자가 없을 경우 대비
			$duty_num_val = $current_duty_num;
		}

		$stmt_insert->bind_param("sssi", $full_date, $holiday_yn, $person, $duty_num_val);
		$stmt_insert->execute();
	}

	$stmt_insert->close();
	mysqli_close($connect);

	echo "<script>location.href='duty.php';</script>";
?>