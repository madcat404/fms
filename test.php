<?php 
   include_once __DIR__ . '/DB/DB1.php'; // DB 연결 (mysqli)

   $user_info_query = $connect->prepare("SELECT EMAIL, CAR_OIL FROM user_info WHERE CAR_NUM = '5215'");                 
                    $user_info_query->execute();
                    $user_info_result = $user_info_query->get_result();
                    $user_info = $user_info_result->fetch_assoc();

    // [전기차] 휘발유 환산 리터(L) 계산 로직
                            $liter_text = "";
                            
                            // 1. 정산일 기준 날짜 설정 (없으면 오늘)
                            $calc_date = !empty($user_car['UPDATE_DATE']) ? date("Y-m-d", strtotime($user_car['UPDATE_DATE'])) : date("Y-m-d");
                            
                            // 2. 휘발유 가격 조회 (DB1.php 사용)
                            $price_stmt = $connect->prepare("SELECT OIL_PRICE FROM oil_price WHERE CAR_OIL='휘발유' AND S_DATE = ?");
                            $price_stmt->bind_param("s", $calc_date);
                            $price_stmt->execute();
                            $price_res = $price_stmt->get_result();
                            $price_row = $price_res->fetch_assoc();
                            
                            // DB 가격 포맷(쉼표 제거) 처리
                            $gas_price = isset($price_row['OIL_PRICE']) ? (float)str_replace(',', '', $price_row['OIL_PRICE']) : 0;

                            echo  $gas_price;



                            if ($gas_price > 0) {
                                $liter_calc = $user_car['KM'] / 10;


                                echo  $user_car['KM'];
                                
                                if ($user_car['HIPASS_YN'] === 'N' && $user_car['TOLL_GATE'] > 0) {
                                    $liter_calc += ($user_car['TOLL_GATE'] / $gas_price);
                                }
                                
                                $gas_liter = ceil($liter_calc); // 올림 처리
                                
                                // [결과] 괄호 안에 리터 표시 텍스트 생성 (예: (20L))
                                $liter_text = " ({$gas_liter}L)";
                            }





                         