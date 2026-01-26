<?php   
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.03.03>
	// Description:	<법인차 운행일지 status>
	// Last Modified: <25.10.20> - Refactored for PHP 8.x	
    // Last Modified: <Current Date> - Combined Damage & Return Logic for Mobile
	// =============================================	

    //★DB연결 및 함수사용
    require_once __DIR__ . '/../session/session_check.php';
    include_once __DIR__ . '/../DB/DB1.php';
	include_once __DIR__ . '/../DB/DB3.php';
	include_once __DIR__ . '/../DB/DB6.php';
	include_once __DIR__ . '/../FUNCTION.php';
    

    //★메뉴 진입 시 탭활성화
    $tab_sequence=2; 
    include '../TAB.php'; 


    //★변수모음 
	$word = "Location";
	$word2 = "Damage";
    //탭2
    $bt21 = $_POST["bt21"] ?? null; 
    $bt22 = $_POST["bt22"] ?? null; 
    $bt23 = $_POST["bt23"] ?? null; 
	$bt24 = $_POST["bt24"] ?? null; 

    //탭3 
    $bt3 = $_POST["bt3"] ?? null; 

	$car = $_POST["car"] ?? null; 	
	$driver = $_POST["driver"] ?? null; 
	$destination = $_POST["destination"] ?? null; 


	//팝업창2
	if(!empty($_GET["bt21"])) {
		$bt21 = $_GET["bt21"]; 
	}
    
    //★버튼 클릭 시 실행
    //법인차 일지 조회
    IF($bt3=="on") {
        $tab_sequence=3; 
        include '../TAB.php';  

        //변수
        $car = $_POST["car"] ?? null;
        $dt = $_POST["dt"] ?? null;	
        $use_function = CropDate($dt);
        $StartDate = $use_function[0];		
		$EndDate = $use_function[1];

		//차량선택 옵션
		IF($car!="all") {     
			$Query_SearchCar = $connect->prepare("
				SELECT * FROM (
					SELECT * FROM car_current 
					UNION ALL 
					SELECT * FROM car_current2
				) AUTH 
				WHERE CAR_NM = ? AND SEARCH_DATE BETWEEN ? AND ?
				ORDER BY NO DESC
			");

			$Query_SearchCar->bind_param("sss", $car, $StartDate, $EndDate);
			$Query_SearchCar->execute();
			$Result_SearchCar = $Query_SearchCar->get_result();			
			$Count_SearchCar = $Result_SearchCar->num_rows; 
		}
		else {	
			$Query_SearchCar = $connect->prepare("
				SELECT * FROM (
					SELECT * FROM car_current 
					UNION ALL 
					SELECT * FROM car_current2
				) AUTH 
				WHERE SEARCH_DATE BETWEEN ? AND ?
				ORDER BY NO DESC
			");

			$Query_SearchCar->bind_param("ss", $StartDate, $EndDate);
			$Query_SearchCar->execute();
			$Result_SearchCar = $Query_SearchCar->get_result();		
			$Count_SearchCar = $Result_SearchCar->num_rows;                 
		}
    }
    elseif($bt21=="on") {
		//★★★★★★★★★★★부산★★★★★★★★★★★//
		IF($car == 'Staria 9285' OR $car == 'avante 7206' OR $car == 'avante 7207') {
			//법인차를 렌트할 수 있는 권한이 있는지 확인
			$stmt = $connect->prepare("SELECT * FROM user_info WHERE USER_NM = ?");
			$stmt->bind_param("s", $driver);
			$stmt->execute();
			$check_driver_result = $stmt->get_result();
			$check_driver_row = $check_driver_result->fetch_object();	

			//선택한 차량의 최종 레코드의 CAR_CONDITIN 컬럼을 확인하기 위해 조회 (NO 컬럼을 정렬하여 제일 최신 레코드를 확인)
			$stmt = $connect->prepare("SELECT * FROM car_current WHERE NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM)");
			$stmt->bind_param("s", $car);
			$stmt->execute();
			$check_result_busan1 = $stmt->get_result();
			$check_row_busan1 = $check_result_busan1->fetch_object();	
		
			//대여중인 차량을 다른사람이 대여할 수 없도록 하는 조건문
			If($check_row_busan1 && $check_row_busan1->CAR_CONDITION=='사용가능') { 
				//권한이 없는 경우 법인차 렌트불가	
				IF($check_driver_row && $check_driver_row->USE_YN=='Y') {
					//업무시간에 차량을 대여 (저녁에 개인사용목적으로 렌트하는 사용자를 막기위함)
					IF(date("H:i:s") >= '00:00:00' and date("H:i:s") <= '17:30:00') {
                            $full_driver = (isset($team) && $team != '') ? $driver . "(" . $team . ")" : $driver;
                            $stmt = $connect->prepare("INSERT INTO car_current(CAR_NM, CAR_CONDITION, START_TIME, SEARCH_DATE, DRIVER, DESTINATION, START_KM, END_KM, HI_PASS) VALUES (?, '대여중', ?, ?, ?, ?, ?, NULL, NULL)");
                            $stmt->bind_param("ssssss", $car, $DT, $Hyphen_today, $full_driver, $destination, $check_row_busan1->END_KM);
                            $stmt->execute();
					
						//경영팀 확인
						$stmt = $connect->prepare("UPDATE car_current SET CHECK_C='ok' WHERE NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM) AS B)");
						$stmt->bind_param("s", $car);
						$stmt->execute();  					

						$stmt = $connect->prepare("UPDATE car_now SET CAR_CONDITION='대여중' WHERE CAR_NM=?");
						$stmt->bind_param("s", $car);
						$stmt->execute();

						//3만원 미만이면 충전요청 메일을 발송
						IF($check_row_busan1->HI_PASS < 30000) {
                            $ch = curl_init();
                            $url = 'https://fms.iwin.kr/mailer.php';
                            $data = ['type' => 'hipass_charge_notice_corporate', 'car' => $car, 'balance' => $check_row_busan1->HI_PASS];
                            $url .= '?' . http_build_query($data);
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                            $response = curl_exec($ch);
                            if (curl_errno($ch)) {
                                error_log('cURL error in rental_status.php (1): ' . curl_error($ch));
                            }
                            curl_close($ch);
							echo "<script>alert('★하이패스카드가 3만원 미만 입니다. 경영팀에 방문하여 하이패스 카드를 충전하세요!★ 대여완료! 경비실에서 차키를 수령하세요!');location.href='rental.php';</script>";	
						}
						ELSE {
							echo "<script>alert('대여완료! 경비실에서 차키를 수령하세요!');location.href='rental.php';</script>";	
						}								
					}
					ELSE {
						if ($car == 'avante 7207') {
                            $full_driver = (isset($team) && $team != '') ? $driver . "(" . $team . ")" : $driver;
							$stmt = $connect->prepare("INSERT INTO car_current(CAR_NM,CAR_CONDITION,START_TIME,SEARCH_DATE,DRIVER,DESTINATION,START_KM,END_KM,HI_PASS) VALUES(?, '대여중', ?, ?, ?, ?, ?, NULL, NULL)");
							$stmt->bind_param("ssssss", $car, $DT, $Hyphen_today, $full_driver, $destination, $check_row_busan1->END_KM);
							$stmt->execute();
						
							//경영팀 확인
							$stmt = $connect->prepare("UPDATE car_current SET CHECK_C='ok' WHERE NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ?) AS B)");
							$stmt->bind_param("s", $car);
							$stmt->execute();
	
							$stmt = $connect->prepare("UPDATE car_now SET CAR_CONDITION='대여중' WHERE CAR_NM=?");
							$stmt->bind_param("s", $car);
							$stmt->execute();
	
							//3만원 미만이면 충전요청 메일을 발송
							IF($check_row_busan1->HI_PASS < 30000) {
                                $ch = curl_init();
                                $url = 'https://fms.iwin.kr/mailer.php';
                                $data = ['type' => 'hipass_charge_notice_corporate', 'car' => $car, 'balance' => $check_row_busan1->HI_PASS];
                                $url .= '?' . http_build_query($data);
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                $response = curl_exec($ch);
                                if (curl_errno($ch)) {
                                    error_log('cURL error in rental_status.php (2): ' . curl_error($ch));
                                }
                                curl_close($ch);
								echo "<script>alert('★하이패스카드가 3만원 미만 입니다. 경영팀에 방문하여 하이패스 카드를 충전하세요!★ 대여완료! 경비실에서 차키를 수령하세요!');location.href='rental.php';</script>";	
							}
							ELSE {
								echo "<script>alert('대여완료! 경비실에서 차키를 수령하세요!');location.href='rental.php';</script>";	
							}	
						} 
						else {
                            $full_driver = (isset($team) && $team != '') ? $driver . "(" . $team . ")" : $driver;
							$stmt = $connect->prepare("INSERT INTO car_current(CAR_NM,CAR_CONDITION,START_TIME,SEARCH_DATE,DRIVER,DESTINATION,START_KM,END_KM,HI_PASS) VALUES(?, '경영팀확인', ?, ?, ?, ?, ?, NULL, NULL)");
							$stmt->bind_param("ssssss", $car, $DT, $Hyphen_today, $full_driver, $destination, $check_row_busan1->END_KM);
							$stmt->execute();

							$stmt = $connect->prepare("UPDATE car_now SET CAR_CONDITION='경영팀확인' WHERE CAR_NM=?");
							$stmt->bind_param("s", $car);
							$stmt->execute();

							echo "<script>alert('업무시간 외 법인차 대여가 불가능합니다!');</script>";
						}
					}
				}
				ELSE {
					echo "<script>alert('법인차 대여 권한이 없습니다!');</script>";
				}	
			}
			//반납완료가 아닌 상태에서 대여를 하려고 할때
			ELSE {
				echo "<script>alert('반납완료 되지 않았습니다!');</script>";
			}				
		}	
		//차량을 입력하지 않았을 때
		ELSE {
			echo "<script>alert('차량을 선택하세요!');</script>";	
		}
			
		//작업이 끝난 후 index.php로 리턴
		echo "<script>location.href='rental.php';</script>";	
	}
    elseIF($bt22=="on") {
		//변수
		$car = $_POST["arrive_car"];										
		$end_km = $_POST["end_km"];
		$hipass = $_POST["hipass"];
		$note = $_POST["note"];
		$car4 = substr($car, 7, 4);

        // [추가 로직] 반납 요청 시 파손 정보(damage24)가 함께 넘어왔다면(모바일) 먼저 업데이트 처리
        $mobile_damage = $_POST["damage24"] ?? null;
        if($mobile_damage) {
            $uploadDir = "../files/";
            // 1. 파손 여부 업데이트
            $update_damage_query = $connect->prepare("UPDATE car_current SET DAMAGE_YN = ? WHERE CAR_NM = ? AND NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM)");
            $update_damage_query->bind_param("sss", $mobile_damage, $car, $car);
            $update_damage_query->execute();

            // 2. 파일 업로드 (Y인 경우)
            if($mobile_damage == 'Y' && isset($_FILES['file24'])) {
                $upload_success = false;
                foreach ($_FILES['file24']['name'] as $key => $name) {
                    if ($_FILES['file24']['error'][$key] == UPLOAD_ERR_OK) {
                        $tmpName = $_FILES['file24']['tmp_name'][$key];
                        $fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                        $name_date = date("Y-m-d_H-i-s");
                        $uniqueName = $word2 . "_" . $name_date . "_" . $car . "_" . $key . "." . $fileExt;
                        $filePath = $uploadDir . $uniqueName;

                        if (move_uploaded_file($tmpName, $filePath)) {
                            $query = $connect->prepare("INSERT INTO files (CAR_NUM, IMG_TYPE, FILE_NM, U_DATE, N_DATE, S_DATE, CHECK_YN, VIEW_YN, FILE_EXTENSION) VALUES (?, 'Damage', ?, ?, ?, ?, '-', '-', ?)");
                            $query->bind_param("ssssss", $car, $uniqueName, $name_date, $name_date, $name_date, $fileExt);
                            $query->execute();
                            $upload_success = true;
                        }
                    }
                }
                if($upload_success) {
                    $update_upload_yn = $connect->prepare("UPDATE car_current SET UPLOAD_YN = 'Y' WHERE CAR_NM = ? AND NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM)");
                    $update_upload_yn->bind_param("ss", $car, $car);
                    $update_upload_yn->execute();
                }
            } else {
                 // N or E
                 $update_upload_yn = $connect->prepare("UPDATE car_current SET UPLOAD_YN = 'N' WHERE CAR_NM = ? AND NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM)");
                 $update_upload_yn->bind_param("ss", $car, $car);
                 $update_upload_yn->execute();
            }
        }

        // 파손 유무를 먼저 입력했는지 확인
        $check_damage_stmt = $connect->prepare("SELECT DAMAGE_YN FROM car_current WHERE NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = ?)");
        $check_damage_stmt->bind_param("s", $car);
        $check_damage_stmt->execute();
        $damage_result = $check_damage_stmt->get_result();
        $damage_row = $damage_result->fetch_object();
        $check_damage_stmt->close();

        if (!$damage_row || !in_array($damage_row->DAMAGE_YN, ['E', 'Y', 'N'])) {
            echo "<script>alert('파손 유무를 먼저 입력해주세요!'); location.href='rental.php';</script>";
            exit();
        }

		//위치사진 업로드
		IF($car == 'avante 7207') { 
			$tmpname = $_FILES['file']['tmp_name'];				//웹 서버에 임시로 저장된 파일의 위치			
			// 파일 해시 검사 추가
			if(function_exists('checkFileHash') && checkFileHash($tmpname)) {
				echo "<script>alert('업로드가 제한된 파일입니다!');location.href='rental.php';</script>";
				exit;
			}

			//php.ini정책에 의해 5MB가 최대 업로드 가능한 용량
			//php.ini정책에 의해 다중 업로드 파일 개수 10개가 최대
			$validMimeTypes = ['image/gif', 'image/png', 'image/jpeg', 'image/jpg', 'image/heic'];
			$validExtensions = ['gif', 'png', 'jpeg', 'jpg', 'heic'];
			
			//업로드할 파일을 찾아보기하여 열었는지 여부에 대해 확인
			if(!isset($_FILES['file']) || $_FILES['file']['error'] != UPLOAD_ERR_OK)
			{
				echo "<script>alert('위치 사진을 업로드 하지 않았습니다!');location.href='rental.php';</script>"; 
				exit;
			}

			//파일명의 길이를 확인
			if(strlen($_FILES['file']['name']) > 255)
			{
				echo "<script>alert('파일 이름이 너무 깁니다.');";
				echo "location.href='rental.php';</script>";
				exit;
			}

			// MIME 타입 확인
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$mimeType = $finfo->file($_FILES['file']['tmp_name']);
			if (!in_array($mimeType, $validMimeTypes)) {
				echo "<script>alert('유효하지 않은 파일 형식입니다.');location.href='rental.php';</script>";
				exit;
			}

			// 파일 확장자 확인
			$fileExt = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
			if (!in_array($fileExt, $validExtensions)) {
				echo "<script>alert('유효하지 않은 파일 확장자입니다.');location.href='rental.php';</script>";
				exit;
			}
					
			//MYSQL에 파일이름이 한글인 경우 INSERT 되도록 하기위한 변수			
			$name_date = date("Y-m-d_H-i-s");			
			$uniqueName = $word . "_" . $name_date . "_" . $car . "." . $fileExt;	
			$uploadDir = "../files/";	
			$dir = $uploadDir . $uniqueName;

			if (@getimagesize($tmpname) !== false) {
				//★★★★★★★파일 업로드하고 업로드한 파일 정보를 files테이블에 저장한다. (테이블에 파일을 저장하지 않는다.)					
				if (move_uploaded_file($tmpname, $dir)) { 
					$query = $connect->prepare("INSERT INTO files (CAR_NUM, IMG_TYPE, FILE_NM, U_DATE, N_DATE, S_DATE, CHECK_YN, VIEW_YN, FILE_EXTENSION) VALUES (?, 'Location', ?, ?, ?, ?, '-', '-', ?)");
					$query->bind_param("ssssss", $car4, $uniqueName, $DT, $name_date, $Hyphen_today, $fileExt);
					$query->execute();

					// echo "<script>alert('업로드 완료!');</script>"; // 모바일 플로우 끊김 방지
				}								
			}
			else {
				echo "<script>alert('이미지 파일이 아니거나 파일 사이즈가 큽니다!');</script>";	
			}	
		}

		//★★★★★★★★★★★부산★★★★★★★★★★★//
		IF($car == 'Staria 9285' OR $car == 'avante 7206' OR $car == 'avante 7207') { 
			//맨마지막 전 레코드값을 확인한다	
			$stmt = $connect->prepare("SELECT * FROM car_current WHERE CAR_NM = ? ORDER BY NO DESC LIMIT 1,1");
            $stmt->bind_param("s", $car);
            $stmt->execute();
            $check_result3 = $stmt->get_result();
			$check_row3 = $check_result3->fetch_object();	

			//개인사용방지
			if($check_row3 && $check_row3->CAR_CONDITION == '경영팀확인') {
				echo "<script>alert('경영팀에 연락하여 일과시간 이후에 법인차를 사용하는 이유를 알려주세요!');</script>";
			}
			else {			
				//반납시 최종KM를 가라로 입력하는 경우 방지
				IF($check_row3 && $check_row3->END_KM < $end_km) {			
					//하이패스 사용, 미사용 확인	
					$final_hipass = ($hipass == '' || $hipass === null) ? $check_row3->HI_PASS : $hipass;
                    $stmt = $connect->prepare("UPDATE car_current SET CAR_CONDITION='경비실확인', END_TIME=?, END_KM=?, HI_PASS=?, SEARCH_DATE=?, NOTE=? WHERE NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ?) AS B)");
                    $stmt->bind_param("ssssss", $DT, $end_km, $final_hipass, $Hyphen_today, $note, $car);
                    $stmt->execute();

                    $stmt = $connect->prepare("UPDATE car_now SET CAR_CONDITION='경비실확인' WHERE CAR_NM=?");
                    $stmt->bind_param("s", $car);
                    $stmt->execute();
					//특이사항 경영팀 메일 발송
					IF($note != '') { 
                        $ch = curl_init();
                        $url = 'https://fms.iwin.kr/mailer.php?type=corporate_car_issue_report';
                        
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

                        $response = curl_exec($ch);

                        if (curl_errno($ch)) {
                            error_log('cURL Error in rental_status.php (corporate_car_issue_report): ' . curl_error($ch));
                        }
                        curl_close($ch);
					}					

					echo "<script>alert('차량 외관을 확인하고 경비실에 차키를 반납하세요!');</script>";
				}
				ELSE {
					echo "<script>alert('출발 KM보다 작은 수를를 입력하였습니다. 정확한 KM를 입력하세요!');location.href='rental.php';</script>";	
				}
			}			
		}	
		//차량을 입력하지 않았을 때
		ELSE {
			echo "<script>alert('차량을 선택하세요!');</script>";	
		}
		
		//작업이 끝난 후 index.php로 리턴
		echo "<script>location.href='rental.php';</script>";
	}
    elseif($bt23=="on") {
		//변수
		$car = $_POST["admin_car"];	
		$car_condition = $_POST["admin_condition"];
		$admin_code = $_POST["admin_code"];		
		
		IF($car == 'Staria 9285' OR $car == 'avante 7206' OR $car == 'avante 7207') {
			//경영팀 확인 컬럼의 OK를 보고 경비실에서 키불출
			//20.03.05 기준으로 경영팀 확인을 사용하지 않음
			IF($car_condition=='확인') {
				IF ($admin_code=='323650') {
					$stmt = $connect->prepare("UPDATE car_current SET CHECK_C='ok', CAR_CONDITION='대여중' WHERE CAR_CONDITION='경영팀확인' AND NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM) AS B)");
                    $stmt->bind_param("s", $car);
                    $stmt->execute();

					$stmt = $connect->prepare("UPDATE car_now SET CAR_CONDITION='대여중' WHERE CAR_NM=?");
                    $stmt->bind_param("s", $car);
                    $stmt->execute();
					
					echo "<script>alert('경영팀 확인완료!');</script>";	
				}
				ELSE {
					echo "<script>alert('패스워드가 틀렸습니다!');</script>";		
				}			
			}				
			//경비실에서 최종확인 후 키반납
			elseif ($car_condition=='경비') {
				IF ($admin_code=='1111') {	
					//선택한 차량의 최종 레코드의 RESERVE_CONDITION 컬럼을 확인하기 위해 조회 (NO 컬럼을 정렬하여 제일 최신 레코드를 확인)		
					$stmt = $connect->prepare("SELECT * FROM car_current WHERE NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM) AS B)");
                    $stmt->bind_param("s", $car);
                    $stmt->execute();
					$check_result1 = $stmt->get_result();  
					$check_row1 = $check_result1->fetch_object();	

					if(!$check_row1 || $check_row1->UPLOAD_YN==NULL OR $check_row1->UPLOAD_YN=='') {
						echo "<script>alert('파손정보를 입력하지 않았습니다!');</script>";
					}
					else {

						$stmt = $connect->prepare("UPDATE car_current SET CAR_CONDITION='사용가능' WHERE CAR_CONDITION='경비실확인' AND NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM) AS B)");
						$stmt->bind_param("s", $car);
                        $stmt->execute();

						$stmt = $connect->prepare("UPDATE car_now SET CAR_CONDITION='사용가능' WHERE CAR_NM=?");
						$stmt->bind_param("s", $car);
                        $stmt->execute();
						
						IF($check_row1->RESERVE_CONDITION=='1') {
							$stmt = $connect->prepare("INSERT INTO car_current(CAR_NM,CAR_CONDITION,START_TIME,SEARCH_DATE,DRIVER,DESTINATION,START_KM,END_KM,HI_PASS,CHECK_C) values(?, '예약', ?, ?, '경영팀', 'NULL', 'NULL', 'NULL', 'NULL', 'ok')");
							$stmt->bind_param("sss", $car, $DT, $Hyphen_today);
                            $stmt->execute();

							$stmt = $connect->prepare("UPDATE car_now SET CAR_CONDITION='예약' WHERE CAR_NM=?");
							$stmt->bind_param("s", $car);
                            $stmt->execute();					
						}
						echo "<script>alert('경비실 확인완료!');location.href='rental.php';</script>";
					}	
				}
				ELSE {
					echo "<script>alert('패스워드가 틀렸습니다!');</script>";		
				}
			}	
			elseif ($car_condition=='취소') {
				IF ($admin_code=='1111') {
					$stmt = $connect->prepare("DELETE FROM car_current WHERE NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ? AND CAR_CONDITION='대여중' GROUP BY CAR_NM) AS B)");
					$stmt->bind_param("s", $car);
                    $stmt->execute();

					$stmt = $connect->prepare("UPDATE car_now SET CAR_CONDITION='사용가능' WHERE CAR_NM=?");
					$stmt->bind_param("s", $car);
                    $stmt->execute();

					echo "<script>alert('취소 되었습니다!');</script>";
				}
				ELSE {
					echo "<script>alert('패스워드가 틀렸습니다!');</script>";		
				}		
			}
			elseif ($car_condition=='예약') {
				IF ($admin_code=='323650') {
					$stmt = $connect->prepare("UPDATE car_current SET RESERVE_CONDITION='1' WHERE NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ? AND CAR_CONDITION='대여중' GROUP BY CAR_NM) AS B)");
					$stmt->bind_param("s", $car);
                    $stmt->execute();
					echo "<script>alert('예약 되었습니다! (상태가 대여중이 아닌경우 예약불가)');</script>";
				}
				ELSE {
					echo "<script>alert('패스워드가 틀렸습니다!');</script>";		
				}
			}
			elseif ($car_condition=='취소2') {
				IF ($admin_code=='323650') {
					$stmt = $connect->prepare("DELETE FROM car_current WHERE NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ? AND CAR_CONDITION='예약' GROUP BY CAR_NM) AS B)");
					$stmt->bind_param("s", $car);
                    $stmt->execute();

					$stmt = $connect->prepare("UPDATE car_now SET CAR_CONDITION='사용가능' WHERE CAR_NM=?");
					$stmt->bind_param("s", $car);
                    $stmt->execute();

					echo "<script>alert('취소 되었습니다!');</script>";
				}
				ELSE {
					echo "<script>alert('패스워드가 틀렸습니다!');</script>";		
				}	
			}
		}
		//차량을 입력하지 않았을 때
		ELSE {
			echo "<script>alert('차량과 상태를 선택하세요!');</script>";	
		}

		//작업이 끝난 후 리턴
		echo "<script>location.href='rental.php';</script>";
	}	
	//파손
	elseIF($bt24=="on") {
        //변수
        $car = $_POST["car24"] ?? null;                                        
		$damage = $_POST["damage24"] ?? null; 
        $uploadDir = "../files/";

		$stmt = $connect->prepare("SELECT * FROM car_current WHERE NO IN (SELECT max_no FROM (SELECT MAX(NO) as max_no FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM) AS B)");
        $stmt->bind_param("s", $car);
        $stmt->execute();
		$check_result1 = $stmt->get_result();  
		$check_row1 = $check_result1->fetch_object();	

		//대여도 하지 않은 사용자가 마구잡이로 파일을 업로드하는 것을 방지
		if($check_row1 && $check_row1->CAR_CONDITION == '대여중') {
			IF($car == 'Staria 9285' OR $car == 'avante 7206' OR $car == 'avante 7207') {
				if($damage=='Y') {
					// 다중 파일 업로드 처리
					foreach ($_FILES['file24']['name'] as $key => $name) {
						if ($_FILES['file24']['error'][$key] == UPLOAD_ERR_OK) {
							$tmpName = $_FILES['file24']['tmp_name'][$key];
							$fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));

							// 파일명 유니크하게 만들기
							$name_date = date("Y-m-d_H-i-s");
							$uniqueName = $word2 . "_" . $name_date . "_" . $car . "_" . $key . "." . $fileExt;

							// 파일 경로 설정
							$filePath = $uploadDir . $uniqueName;

							// 파일 업로드
							if (move_uploaded_file($tmpName, $filePath)) {
								// 파일 정보 DB에 저장
								$query = $connect->prepare("INSERT INTO files (CAR_NUM, IMG_TYPE, FILE_NM, U_DATE, N_DATE, S_DATE, CHECK_YN, VIEW_YN, FILE_EXTENSION) VALUES (?, 'Damage', ?, ?, ?, ?, '-', '-', ?)");
								$query->bind_param("ssssss", $car, $uniqueName, $name_date, $name_date, $name_date, $fileExt);
								$query->execute();

								$update_query = $connect->prepare("UPDATE car_current SET UPLOAD_YN = 'Y', DAMAGE_YN = ? WHERE CAR_NM = ? AND NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM)");
								$update_query->bind_param("sss", $damage, $car, $car);
								$update_query->execute();						
							} else {
								echo "<script>alert('파일 업로드에 실패했습니다.');</script>";
							}
						} else {
							echo "<script>alert('파일 업로드에 실패했습니다.');</script>";
						}
					}

					echo "<script>alert('업로드 완료!');</script>";	
				}
				elseif($damage=='N' or $damage=='E') {
					$update_query = $connect->prepare("UPDATE car_current SET UPLOAD_YN = 'N', DAMAGE_YN = ? WHERE CAR_NM = ? AND NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = ? GROUP BY CAR_NM)");
					$update_query->bind_param("sss", $damage, $car, $car);
					$update_query->execute();	
					
					echo "<script>alert('저장 완료!');</script>";	
				}
				else {
					echo "<script>alert('파손여부를 선택하세요!');</script>";	
				}
			}
			else {
				echo "<script>alert('차량을 선택하세요!');</script>";	
			}
		}
		else {
			echo "<script>alert('대여중인 차량에 대해서만 파손상태를 입력할 수 있습니다!');</script>";	
		}
    }	

    //★메뉴 진입 시 실행
    //대여 가능한 차량
    $Query_CheckInCar = $connect ->query("select * from car_now where CAR_CONDITION='사용가능'");
    $in_car = [];
    while($row = $Query_CheckInCar->fetch_object()) {
        $in_car[] = $row;
    }

    //반납 가능한 차량
    $Query_CheckOutCar = $connect ->query("select * from car_now where CAR_CONDITION='대여중'");
    $out_car = [];
    while($row = $Query_CheckOutCar->fetch_object()) {
        $out_car[] = $row;
    }


    //법인차 정보	
    $Query_CarInfo2 = "select * from car_current where NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = 'Staria 9285' GROUP BY CAR_NM )";
    $Result_CarInfo2 = $connect->query($Query_CarInfo2);			
    $Data_CarInfo2 = mysqli_fetch_object($Result_CarInfo2);

	$Query_CarInfo22 = "select * from car_current where CAR_NM = 'Staria 9285' order by NO desc limit 1 offset 1";
    $Result_CarInfo22 = $connect->query($Query_CarInfo22);			
    $Data_CarInfo22 = mysqli_fetch_object($Result_CarInfo22);

	$Query_CarInfo6 = "select * from car_current where NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = 'avante 7206' GROUP BY CAR_NM )";
    $Result_CarInfo6 = $connect->query($Query_CarInfo6);						
    $Data_CarInfo6 = mysqli_fetch_object($Result_CarInfo6);

	$Query_CarInfo66 = "select * from car_current where CAR_NM = 'avante 7206' order by NO desc limit 1 offset 1";
    $Result_CarInfo66 = $connect->query($Query_CarInfo66);						
    $Data_CarInfo66 = mysqli_fetch_object($Result_CarInfo66);

	$Query_CarInfo7 = "select * from car_current where NO IN (SELECT MAX(NO) FROM car_current WHERE CAR_NM = 'avante 7207' GROUP BY CAR_NM )";
    $Result_CarInfo7 = $connect->query($Query_CarInfo7);						
    $Data_CarInfo7 = mysqli_fetch_object($Result_CarInfo7);

	$Query_CarInfo77 = "select * from car_current where CAR_NM = 'avante 7207' order by NO desc limit 1 offset 1";
    $Result_CarInfo77 = $connect->query($Query_CarInfo77);						
    $Data_CarInfo77 = mysqli_fetch_object($Result_CarInfo77);

	//위치 사진 정보
	$Query_CarLocation = "SELECT * FROM files WHERE IMG_TYPE='Location' ORDER BY NO DESC LIMIT 1";
	$Result_CarLocation = $connect->query($Query_CarLocation);
	$Data_CarLocation = mysqli_fetch_object($Result_CarLocation);

    function get_gw_title($connect3, $driver_name) {
        if (empty($driver_name)) {
            return '';
        }
    
        $gw_title = '';
        $stmt_emp = $connect3->prepare("SELECT emp_seq FROM t_co_emp_multi where lang_code='kr' and emp_name=?");
        if (!$stmt_emp) return '';
        $stmt_emp->bind_param("s", $driver_name);
        $stmt_emp->execute();
        $Result_EMP = $stmt_emp->get_result();
        $Data_EMP = $Result_EMP->fetch_assoc();
        $stmt_emp->close();
    
        if ($Data_EMP) {
            $stmt_gw = $connect3->prepare("SELECT req_sqno FROM t_at_att_req_detail where use_yn='Y' and emp_seq=? and comp_seq='1' and (att_div_code='31' or att_div_code='32' or att_div_code='33' or att_div_code='21') ORDER BY end_dt DESC LIMIT 1");
            if (!$stmt_gw) return '';
            $stmt_gw->bind_param("s", $Data_EMP['emp_seq']);
            $stmt_gw->execute();
            $Result_GWInfo = $stmt_gw->get_result();
            $Data_GWInfo = $Result_GWInfo->fetch_assoc();
            $stmt_gw->close();
    
            if ($Data_GWInfo) {
                $stmt_gw2 = $connect3->prepare("SELECT att_req_title FROM t_at_att_req where req_sqno=?");
                if (!$stmt_gw2) return '';
                $stmt_gw2->bind_param("s", $Data_GWInfo['req_sqno']);
                $stmt_gw2->execute();
                $Result_GWInfo2 = $stmt_gw2->get_result();
                $Data_GWInfo2 = $Result_GWInfo2->fetch_assoc();
                $stmt_gw2->close();
    
                if ($Data_GWInfo2) {
                    $gw_title = $Data_GWInfo2['att_req_title'];
                }
            }
        }
        return $gw_title;
    }

    $gw_title2 = get_gw_title($connect3, $Data_CarInfo2->DRIVER ?? null);
    $gw_title6 = get_gw_title($connect3, $Data_CarInfo6->DRIVER ?? null);
    $gw_title7 = get_gw_title($connect3, $Data_CarInfo7->DRIVER ?? null);
?>