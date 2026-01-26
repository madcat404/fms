<?php
    declare(strict_types=1);

    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <25.09.29>
    // Description: <통합 메일 발송 서비스>
    // Last Modified: <25.11.07> - 개인차량(FMS) 관련 메일 기능 통합
    // =============================================

    require_once __DIR__ . '/mailer_service.php';

    // [추가] 자동 로그인을 위한 매직 키 정의 (session_check.php와 일치해야 함)
    define('MAIL_MAGIC_KEY', 'secret_pass_1234');

    /**
     * Builds a styled HTML email body.
     * @param string $systemName The name of the system sending the alert (e.g., "FMS", "내부고발").
     * @param string $title The title for the card header.
     * @param string $contentHtml The main HTML content of the email.
     * @param string|null $link An optional URL for a call-to-action button.
     * @param string $buttonText Text for the call-to-action button.
     * @param string|null $logoCid The Content-ID of the logo image to embed.
     * @return string The full HTML email body.
     */
    function build_email_template(string $systemName, string $title, string $contentHtml, ?string $link, string $buttonText = '페이지로 이동', ?string $logoCid = null): string
    {
        // [추가] 링크가 존재할 경우 mail_key 파라미터 자동 추가
        if ($link) {
            // 이미 파라미터(?)가 있으면 &로 연결, 없으면 ?로 연결
            $separator = (strpos($link, '?') !== false) ? '&' : '?';
            $link .= $separator . 'mail_key=' . MAIL_MAGIC_KEY;
        }

        $buttonHtml = $link ? '<p style="margin-top: 20px; text-align: center;"><a href="' . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . '" target="_blank" style="display: inline-block; padding: 10px 20px; background-color: #055AAF; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">' . htmlspecialchars($buttonText, ENT_QUOTES, 'UTF-8') . '</a></p>' : '';
        $fullContent = $contentHtml . $buttonHtml;
        $escapedSystemName = htmlspecialchars($systemName, ENT_QUOTES, 'UTF-8');
        $escapedTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        
        $headerContentHtml = '';
        if ($logoCid) {
            // If logo exists, create a 2-column table for logo and title, centered as a block.
            $headerContentHtml = <<<HTML
            <img src="cid:{$logoCid}" alt="Logo" style="display: block; margin: 0 auto 15px auto; padding: 10px; border-radius: 8px; max-width: 70px; vertical-align: middle;">
            <h1 style="margin: 0; font-size: 22px; color: #ffffff; display: inline-block; vertical-align: middle;">{$escapedSystemName}</h1>
HTML;
        } else {
            // If no logo, just the centered title. Use double quotes to interpolate variables.
            $headerContentHtml = "<h1 style=\"margin: 0; font-size: 24px; color: #ffffff;\">{$escapedSystemName}</h1>";
        }

        return <<<HTML
        <!DOCTYPE html>
        <html lang="ko">
        <head>
            <meta charset="utf-8">
            <title>{$escapedSystemName}</title>
        </head>
        <body style="margin: 0; padding: 0; background-color: #f4f7f6; font-family: 'Malgun Gothic', '맑은 고딕', sans-serif;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 680px;">
                <!-- 헤더 -->
                <tr>
                    <td style="background-color: #055AAF; color: #ffffff; padding: 30px; text-align: center;">
                        {$headerContentHtml}
                    </td>
                </tr>
                <!-- 본문 -->
                <tr>
                    <td style="background-color: #ffffff; padding: 20px;">
                        <!-- 컨텐츠 카드 -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e3e6f0; border-radius: 5px; margin-bottom: 20px;">
                            <tr>
                                <td style="padding: 12px 20px; background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; font-weight: bold; color: #055AAF;">{$escapedTitle}</td>
                            </tr>
                            <tr>
                                <td style="padding: 20px; line-height: 1.6; font-size: 14px;">
                                    {$fullContent}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- 푸터 -->
                <tr>
                    <td style="padding: 20px; text-align: center; font-size: 12px; color: #858796;">
                        <p style="margin: 0;">본 메일은 발신전용입니다.</p>
                    </td>
                </tr>
            </table>
        </body>
        </html>
HTML;
    }

    // 요청 타입 파라미터 가져오기 (GET, POST 모두 지원)
    $mail_type = $_REQUEST['type'] ?? '';

    // mailer_service.php에 send_system_email($to, $subject, $body, $fromName)이 정의되어 있다고 가정

    $logoPath = __DIR__ . '/img/logo_white.png';
    $logoCid = 'iwin_logo';
    $embeddedImages = [[ 'path' => $logoPath, 'cid' => $logoCid ]];
    
    switch ($mail_type) {
        // ===================================
        // 개인차량 FMS 관련 메일
        // ===================================
        case 'individual_settlement_request':
            $to = ['skkwon@iwin.kr', 'khgmah1102@iwin.kr'];
            $subject = '[FMS] 개인차량운행 결재요청';
            $systemName = '개인차량 FMS';
            $title = '개인차량운행 결재요청';
            $contentHtml = '<p>개인차량운행 정산 결재가 필요합니다.</p>';
            $link = 'https://fms.iwin.kr/kjwt_fms/individual.php';
            $body = build_email_template($systemName, $title, $contentHtml, $link, 'FMS 페이지로 이동', $logoCid);
            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Individual settlement request sent.";
            } else {
                echo "Failed to send individual settlement request.";
            }
            break;

        case 'individual_voucher_request':
            $to = ['skkwon@iwin.kr', 'jypark@iwin.kr'];
            $subject = '[FMS] 개인차량운행 주유권 발급요청';
            $systemName = '개인차량 FMS';
            $title = '주유권 발급요청';
            $contentHtml = '<p>개인차량운행일지에 대한 주유권 발급이 필요합니다.</p>';
            $link = 'https://fms.iwin.kr/kjwt_fms/individual.php';
            $body = build_email_template($systemName, $title, $contentHtml, $link, 'FMS 페이지로 이동', $logoCid);
            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Individual voucher request sent.";
            } else {
                echo "Failed to send individual voucher request.";
            }
            break;

        case 'individual_gas_ticket_notice':
            include_once __DIR__ . '/DB/DB1.php'; // DB 연결 (mysqli)
            
            // [중요] 전기차 환산 계산을 위해 KM, TOLL_GATE, HIPASS_YN, UPDATE_DATE 컬럼을 조회합니다.
            $query = "SELECT NO, CAR_NUM, GIVE_OIL, KM, TOLL_GATE, HIPASS_YN, UPDATE_DATE FROM user_car WHERE GIVE_YN='Y' AND MAIL_YN='N'";
            $result = $connect->query($query);

            if ($result && $result->num_rows > 0) {
                $systemName = '개인차량 FMS';
                $link = 'https://fms.iwin.kr/kjwt_fms/individual.php';

                while ($user_car = $result->fetch_assoc()) {
                    // 사용자 정보 조회
                    $user_info_query = $connect->prepare("SELECT EMAIL, CAR_OIL FROM user_info WHERE CAR_NUM = ?");
                    $user_info_query->bind_param("s", $user_car['CAR_NUM']);
                    $user_info_query->execute();
                    $user_info_result = $user_info_query->get_result();
                    $user_info = $user_info_result->fetch_assoc();
                    $user_info_query->close(); // [중요] 리소스 해제

                    if ($user_info && !empty($user_info['EMAIL'])) {
                        $to = $user_info['EMAIL'];
                        
                        // [안전장치 1] 정산금액이 NULL이면 0으로 처리
                        $amount_val = (float)($user_car['GIVE_OIL'] ?? 0);
                        $amount = number_format($amount_val);

                        // --- 유종별 메일 내용 및 제목 분기 ---
                        if (($user_info['CAR_OIL'] ?? '') === '전기') {
                            // [전기차] 휘발유 환산 리터(L) 계산 로직
                            $liter_text = "";
                            
                            // [안전장치 2] DB 데이터 NULL 체크 및 기본값 설정
                            $km_val = (float)($user_car['KM'] ?? 0);
                            $toll_val = (int)($user_car['TOLL_GATE'] ?? 0);
                            $hipass_yn = $user_car['HIPASS_YN'] ?? 'N';
                            
                            // [안전장치 3] 날짜 데이터 검증 (PHP 8 오류 방지)
                            $db_date = $user_car['UPDATE_DATE'] ?? null;
                            if ($db_date) {
                                $calc_date = date("Y-m-d", strtotime($db_date));
                            } else {
                                $calc_date = date("Y-m-d"); // 날짜 없으면 오늘 기준
                            }
                            
                            // 휘발유 가격 조회
                            $price_stmt = $connect->prepare("SELECT OIL_PRICE FROM oil_price WHERE CAR_OIL='휘발유' AND S_DATE = ?");
                            $price_stmt->bind_param("s", $calc_date);
                            $price_stmt->execute();
                            $price_res = $price_stmt->get_result();
                            $price_row = $price_res->fetch_assoc();
                            $price_stmt->close(); // [중요] 리소스 해제
                            
                            // [안전장치 4] 가격 정보 문자열 처리 (NULL 방지)
                            $oil_price_str = $price_row['OIL_PRICE'] ?? '0';
                            // 쉼표 제거 후 float 변환
                            $gas_price = (float)str_replace(',', '', (string)$oil_price_str);

                            // 계산 수행 (휘발유 가격이 유효할 때만)
                            if ($gas_price > 0) {
                                // 기본식: 주행거리 / 10
                                $liter_calc = $km_val / 10;
                                
                                // 하이패스 미사용('N')이고 톨비가 있는 경우: + (톨비 / 휘발유가)
                                if ($hipass_yn === 'N' && $toll_val > 0) {
                                    $liter_calc += ($toll_val / $gas_price);
                                }
                                
                                $gas_liter = ceil($liter_calc); // 올림 처리
                                
                                // 결과 텍스트 생성: (20 L)
                                $liter_text = " ({$gas_liter} L)";
                            }

                            // 전기차 전용 메일 본문
                            $subject = '[FMS] 전기차 충전비 정산 안내';
                            $title = '전기차 충전비 정산 완료';
                            $contentHtml = "
                                <p>개인차량(전기차) 운행에 따른 충전비 정산이 완료되었습니다.</p>
                                <p style='font-size: 16px; color: #055AAF;'><strong>정산 금액: {$amount}원{$liter_text}</strong></p><br>
                                <p>당분간 휘발유 기준 주유권으로 지급합니다.</p><br>    
                                <p>경영팀 방문하여  주유권 수령하시기 바랍니다.</p><br> 
                                <p>수령하신 주유권은 <strong>장안가스충전주유소(<a href='https://kko.kakao.com/quibtWrWz7'>부산광역시 기장군 장안읍 기장대로 1673</a>)</strong>에서만 사용가능합니다.</p>                  
                                ";
                        } else {
                            // [일반 유종] (휘발유, 경유, LPG) 메일 본문
                            $subject = '[FMS] 주유권 지급 안내';
                            $title = '주유권 지급 안내';
                            
                            if (($user_info['CAR_OIL'] ?? '') == 'LPG') {
                                $contentHtml = "<p>경영팀을 방문하여 주유권(<strong>{$amount} L</strong>)을 받아 가시기 바랍니다.</p><p>수령하신 주유권은 <strong>선암주유소(<a href='https://kko.to/sucBgowg1k'>부산광역시 기장군 장안읍 기장대로 1453</a>)</strong>에서만 사용가능합니다.</p>";
                            } else {
                                $contentHtml = "<p>경영팀을 방문하여 주유권(<strong>{$amount} L</strong>)을 받아 가시기 바랍니다.</p><p>수령하신 주유권은 <strong>장안가스충전주유소(<a href='https://kko.kakao.com/quibtWrWz7'>부산광역시 기장군 장안읍 기장대로 1673</a>)</strong>에서만 사용가능합니다.</p>";
                            }
                        }

                        $body = build_email_template($systemName, $title, $contentHtml, $link, 'FMS 페이지로 이동', $logoCid);

                        // 메일 발송 성공 시에만 MAIL_YN 업데이트
                        if (send_system_email($to, $subject, $body, $embeddedImages)) {
                            $update_stmt = $connect->prepare("UPDATE user_car SET MAIL_YN='Y' WHERE NO = ?");
                            $update_stmt->bind_param("i", $user_car['NO']);
                            $update_stmt->execute();
                            $update_stmt->close(); // [중요] 리소스 해제
                            echo "Notice sent to {$to} (" . ($user_info['CAR_OIL'] ?? 'N/A') . "). ";
                        } else {
                            echo "Failed to send to {$to}. ";
                        }
                    }
                }
            } else {
                echo "No new tickets to notify.";
            }
            if(isset($connect)) { $connect->close(); }
            break;

        case 'individual_check_request':
            $to = filter_var($_REQUEST['to'] ?? '', FILTER_SANITIZE_EMAIL);
            if (!empty($to)) {
                $subject = '[FMS] 개인차량운행일지 작성요청';
                $systemName = '개인차량 FMS';
                $title = '운행일지 작성 요청';
                $contentHtml = '<p>7일 이상 운행일지 도착 정보 입력 또는 증빙 업로드가 지연되고 있습니다. 조속한 처리를 부탁드립니다.</p>';
                $link = 'https://fms.iwin.kr/kjwt_fms/individual.php';
                $body = build_email_template($systemName, $title, $contentHtml, $link, 'FMS 페이지로 이동', $logoCid);
                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Check request sent to {$to}.";
                } else {
                    echo "Failed to send check request to {$to}.";
                }
            } else {
                echo "No recipient specified for check request.";
            }
            break;

        // ===================================
        // 내부고발 관련 메일
        // ===================================
        case 'accuse_report':
            $user21 = htmlspecialchars($_POST["user21"] ?? '익명', ENT_QUOTES, 'UTF-8');
            $email21 = filter_var($_POST["email21"] ?? '', FILTER_SANITIZE_EMAIL);
            $phone21 = htmlspecialchars($_POST["phone21"] ?? '', ENT_QUOTES, 'UTF-8');
            $note21 = nl2br(htmlspecialchars($_POST["note21"] ?? '', ENT_QUOTES, 'UTF-8'));
            $qna211 = htmlspecialchars($_POST["qna211"] ?? '', ENT_QUOTES, 'UTF-8');
            $qna212 = htmlspecialchars($_POST["qna212"] ?? '', ENT_QUOTES, 'UTF-8');

            $to = 'hr@iwin.kr';
            $subject = '[FMS] 부정비리 제보가 접수되었습니다.';
            $systemName = '부정비리 제보 접수';
            $title = '내용';

            $contentHtml = <<<HTML
            <p>새로운 제보가 접수되어 아래와 같이 전달드립니다.</p>
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; font-size: 14px;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold; width: 30%;">제보자 이름</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{$user21}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold;">이메일</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{$email21}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold;">연락처</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{$phone21}</td>
                </tr>
                <tr style="background-color: #f8f9fc;">
                    <td colspan="2" style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold;">제보 내용</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold; vertical-align: top;">상세 내용</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{$note21}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold; vertical-align: top;">관련 문제 인지자</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{$qna211}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold; vertical-align: top;">조사 방법 제안</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{$qna212}</td>
                </tr>
            </table>
HTML;

            $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

            header('Content-Type: application/json');
            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo json_encode(['success' => true, 'message' => '메일 발송에 성공했습니다.']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => '메일 발송에 실패했습니다.']);
            }
            break;

        // ===================================
        // 전력 데이터 관련 메일
        // ===================================
        case 'electricity_data_error':
            $to = 'hr@iwin.kr';
            $subject = '[FMS] 전기 데이터 확인 요청';
            $systemName = '전기 데이터 미수신';
            $title = '내용';

            $contentHtml = <<<HTML
            <p>전기 데이터를 가져오지 못했습니다.</p>
            <p>파워플래너 웹사이트(<a href="https://pp.kepco.co.kr/intro.do" target="_blank">https://pp.kepco.co.kr/intro.do</a>)에서 전기사용량을 조회하여 <code_inline>CONNECT.dbo.READ_METER</code_inline> 테이블에 데이터를 삽입해주세요.</p>
            <ul style="padding-left: 20px; line-height: 1.8; list-style-type: none;">
                <li><strong>ID:</strong> <code_inline>0433209253</code_inline></li>
                <li><strong>PW:</strong> <code_inline>0021921</code_inline></li>
            </ul>
            <p><code_inline>SORTING_DATE</code_inline>가 오늘 날짜인 경우, 파워플래너 웹사이트에서 전일 전기사용량을 입력하시면 됩니다.</p>
            <p>해당 테이블은 FMS - 레포트 메뉴 - 경영탭 - #2-1. 전기 카드 - 사용량(KWH) 탭에 영향을 미칩니다.</p>
            <p>만약 지속적으로 전기데이터를 가져오지 못할 경우, 에너지 마켓 플레이스(<a href="https://edsm.kepco.co.kr" target="_blank">https://edsm.kepco.co.kr</a>) EDS에서 FMS를 검색하여 정보제공동의를 연장해주세요.</p>
            <ul style="padding-left: 20px; line-height: 1.8; list-style-type: none;">
                <li><strong>ID:</strong> <code_inline>iwinadmin</code_inline></li>
                <li><strong>PW:</strong> <code_inline>kjwt8132365!</code_inline></li>
            </ul>
HTML;
            
            $link = 'https://fms.iwin.kr/kjwt_report/report_body.php';
            $body = build_email_template($systemName, $title, $contentHtml, $link, 'FMS 레포트로 이동', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Electricity data error alert sent successfully.";
            } else {
                echo "Failed to send electricity data error alert.";
            }
            break;

        // ===================================
        // 홈페이지 관련 메일
        // ===================================
        case 'homepage_down_alert':
            include_once __DIR__ . '/FUNCTION.php'; // homepage() 함수를 사용하기 위해 포함

            // 1. 홈페이지 상태를 확인합니다.
            $homepage_url = 'https://www.iwin.kr/index';
            $condition = homepage($homepage_url);

            // 2. 상태 코드가 200이 아닐 경우에만 알림 메일을 발송합니다.
            if ($condition != '200') {
                $to = 'hr@iwin.kr';
                $subject = '[FMS] 홈페이지가 다운되었습니다!';
                $systemName = '홈페이지 접속 오류';
                $title = '내용';

                $contentHtml = <<<HTML
                <p><strong>아이윈 홈페이지(www.iwin.kr) 접속에 실패했습니다.</strong></p>
                <p>아래 절차에 따라 서버를 재시작해주세요.</p>
                <ol style="padding-left: 20px; line-height: 1.8;">
                    <li><strong>원격 데스크톱 연결</strong>: <code_inline>mstsc</code_inline> 실행 후 <code_inline>59.20.180.151</code_inline>에 연결</li>
                    <li><strong>로그인</strong>: ID: <code_inline>user</code_inline> / PW: <code_inline>kjwt8132365!</code_inline></li>
                    <li><strong>PowerShell 실행</strong>: Windows PowerShell을 관리자 권한으로 실행</li>
                    <li><strong>경로 이동</strong>: <code_inline>cd c:\webapp</code_inline> 입력</li>
                    <li><strong>서버 재시작</strong>: <code_inline>java -jar iwin.war</code_inline> 입력</li>
                </ol>
                <p>위 절차는 <code_inline>C:\webapp\구동명령어.txt</code_inline> 파일에서도 확인하실 수 있습니다.</p>
HTML;
                
                $link = 'https://www.iwin.kr/index';
                $body = build_email_template($systemName, $title, $contentHtml, $link, '홈페이지 확인하기', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Homepage down alert sent successfully.";
                } else {
                    echo "Failed to send homepage down alert.";
                }
            } else {
                echo "Homepage is up. No alert sent.";
            }
            break;

        // ===================================
        // 생일자 관련 메일
        // ===================================
        case 'birthday_notice':
            include_once __DIR__ . '/DB/DB2.php';
            include_once __DIR__ . '/FUNCTION.php';

            $MM = date('m');

            // --- 1. 이메일 내용에 필요한 데이터 조회 ---
            $Query_birthday2 = "SELECT NM_KOR, NO_RES FROM NEOE.NEOE.MA_EMP WHERE CD_COMPANY='1000' AND CD_INCOM='001' and (NO_EMP LIKE 'F%' or NO_EMP='C20130102') and NM_KOR!='신채은' and NM_KOR!='이완수' ORDER BY NM_KOR";
            $Result_birthday2 = sqlsrv_query($connect, $Query_birthday2);

            $birthday_list = [];
            if ($Result_birthday2) {
                while ($row = sqlsrv_fetch_array($Result_birthday2, SQLSRV_FETCH_ASSOC)) {
                    if (isset($row['NO_RES']) && substr($row['NO_RES'], 2, 2) === $MM) {
                        $birthday_list[] = [
                            'name' => $row['NM_KOR'],
                            'birthdate' => substr($row['NO_RES'], 2, 4)
                        ];
                    }
                }
            }

            $special_cases = [
                '07' => ['name' => '조병호', 'birthdate' => '0727'],
                '12' => ['name' => '김창복', 'birthdate' => '1220']
            ];

            if (isset($special_cases[$MM])) {
                $found = false;
                foreach ($birthday_list as $person) {
                    if ($person['name'] === $special_cases[$MM]['name']) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $birthday_list[] = $special_cases[$MM];
                }
            }

            usort($birthday_list, function($a, $b) {
                return strcmp($a['name'], $b['name']);
            });

            $Query_total_count = "SELECT count(NM_KOR) as total FROM NEOE.NEOE.MA_EMP WHERE CD_COMPANY='1000' AND (CD_PLANT='PL01' or CD_PLANT='PL04' or CD_PLANT='PL03' or CD_PLANT='PL06') AND CD_INCOM='001' and (no_emp like 'F%' or NO_EMP='C20130102') and NM_KOR!='이재익'";
            $Result_total_count = sqlsrv_query($connect, $Query_total_count);
            $Data_total_count = $Result_total_count ? sqlsrv_fetch_array($Result_total_count) : ['total' => 0];
            $Count_birthday2 = $Data_total_count['total'];

            // --- 2. 이메일 본문(HTML) 생성 ---
            $today = date('Y-m-d');
            $contentHtml = <<<HTML
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e3e6f0; border-radius: 5px; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 12px 20px; background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; font-weight: bold; color: #055AAF;">안내</td>
                </tr>
                <tr>
                    <td style="padding: 20px; line-height: 1.6; font-size: 12px;">
                        <div style="margin-bottom: 20px;">
                            <strong>[신세계 상품권]</strong><br>
                            - TIP1: 500만원 미만은 키오스크로 구매가능<br>
                            - HISTORY: 신세계프리미엄 아울렛에서 더이상 상품권 구매가 불가능함 (2023년 기준)<br>
                            <a href="https://kko.kakao.com/EWVdGMpd1G" target="_blank">지도 보기 (이마트 트레이더스 양산점)</a>
                        </div>
                        <div>
                            <strong>[롯데 상품권]</strong><br>
                            - TIP1: 구매마다 사업자등록증, 재직증명서, 신분증 필요<br>
                            - TIP2: 롯데마트 데스크에서 구매 가능<br>
                            <a href="https://kko.kakao.com/LNJfrRMIWR" target="_blank">지도 보기 (롯데마트 동부산점)</a>
                        </div>
                        <hr style="border: 0; border-top: 1px solid #e3e6f0; margin: 20px 0;">
                        <p style="margin: 0 0 10px 0; font-size: 12px;">
                            <strong>[참조사항]</strong><br>
                            - 매월 1일에 메일이 발송됩니다.<br>
                            - 해당 메일은 경영팀만 열람할 수 있습니다.<br>
                            - 사무직 외 다음 사람이 포함되었습니다. (대상총원:{$Count_birthday2}명 / 기준일:{$today})<br>
                            &nbsp; > 한국: 김창복, 김홍수, 김용찬, 신유진<br>
                            &nbsp; > 베트남, 슬로박, 중국 파견 한국 관리자<br>
                            &nbsp; > 미국: 신광진<br>
                            &nbsp; > 미포함: 신채은, 이완수, 이재익, 미국법인, 김진호(퇴사예정 25.10)<br>
                            - 신입사원 입사 시 ERP에서 사원등록 후 사원관리 메뉴에서 공장을 설정해줘야 카운팅 됩니다.<br>
                        </p>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e3e6f0; border-radius: 5px;">
                <tr>
                    <td style="padding: 12px 20px; background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; font-weight: bold; color: #055AAF;">명단</td>
                </tr>
                <tr>
                    <td style="padding: 20px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #e3e6f0; padding: 12px; background-color: #f8f9fc; text-align: center;">NO</th>
                                    <th style="border: 1px solid #e3e6f0; padding: 12px; background-color: #f8f9fc; text-align: center;">이름</th>
                                    <th style="border: 1px solid #e3e6f0; padding: 12px; background-color: #f8f9fc; text-align: center;">생년월일</th>
                                </tr>
                            </thead>
                            <tbody>
HTML;
            if (empty($birthday_list)) {
                $contentHtml .= '<tr><td colspan="3" style="border: 1px solid #e3e6f0; padding: 12px; text-align: center;">이달의 생일자가 없습니다.</td></tr>';
            } else {
                foreach ($birthday_list as $index => $person) {
                    $contentHtml .= '<tr>';
                    $contentHtml .= '<td style="border: 1px solid #e3e6f0; padding: 12px; text-align: center;">' . ($index + 1) . '</td>';
                    $contentHtml .= '<td style="border: 1px solid #e3e6f0; padding: 12px; text-align: center;">' . htmlspecialchars($person['name'], ENT_QUOTES, 'UTF-8') . '</td>';
                    $contentHtml .= '<td style="border: 1px solid #e3e6f0; padding: 12px; text-align: center;">' . htmlspecialchars($person['birthdate'], ENT_QUOTES, 'UTF-8') . '</td>';
                    $contentHtml .= '</tr>';
                }
            }
            $contentHtml .= <<<HTML
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
HTML;

            if(isset($connect)) { sqlsrv_close($connect); }

            $to = 'hr@iwin.kr';
            $subject = '[FMS] ' . date('n') . '월 생일자 안내';
            $systemName = date('n') . '월 생일자 안내';
            $title = '생일자 안내 및 명단';

            $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Birthday notice sent successfully.";
            } else {
                echo "Failed to send birthday notice.";
            }
            break;

        // ===================================
        // 검교정 알림 메일
        // ===================================
        case 'calibration_due_notice':
            include_once __DIR__ . '/DB/DB2.php';

            $Query_LastCalibration = "SELECT TOP 1 DT from CALIBRATION WHERE DT IS NOT NULL ORDER BY DT DESC";
            $Result_LastCalibration = sqlsrv_query($connect, $Query_LastCalibration);
            $Data_LastCalibration = sqlsrv_fetch_array($Result_LastCalibration);

            if ($Data_LastCalibration) {
                $LastCalibrationDate = date_format($Data_LastCalibration["DT"], "Y-m-d");
                $today = date("Y-m-d");

                $lastDate = new DateTime($LastCalibrationDate);
                $currentDate = new DateTime($today);
                $interval = $currentDate->diff($lastDate);
                $monthsDiff = ($interval->y * 12) + $interval->m;

                // 11개월이 지났고 오늘이 월요일인 경우 (매주 1회) 메일 발송
                if ($monthsDiff >= 11 && date('N') == 1) {
                    $to = ['skkwon@iwin.kr', 'test@iwin.kr'];
                    $subject = '[FMS] 검교정 기한 알림';
                    $systemName = '검교정 기한 알림';
                    $title = '안내';

                    $contentHtml = <<<HTML
                    <p>검교정 일자가 1개월 앞으로 다가왔음을 알려드립니다.</p>
                    <p><strong>마지막 검교정 일자:</strong> {$LastCalibrationDate}</p>
HTML;
                    
                    $link = 'https://fms.iwin.kr/kjwt_calibration/calibration.php';
                    $body = build_email_template($systemName, $title, $contentHtml, $link, '검교정 페이지로 이동', $logoCid);

                    if (send_system_email($to, $subject, $body, $embeddedImages)) {
                        echo "Calibration due notice sent successfully.";
                    } else {
                        echo "Failed to send calibration due notice.";
                    }
                } else {
                    echo "Calibration due notice conditions not met. No alert sent.";
                }
            } else {
                echo "No calibration data found. No alert sent.";
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 법인카드 반납 알림 메일
        // ===================================
        case 'card_overdue_notice':
            include_once __DIR__ . '/DB/DB2.php';

            $Hyphen_today = date("Y-m-d");

            // 1. Check for any overdue cards first
            $query_check = "SELECT COUNT(*) as overdue_count FROM CONNECT.dbo.CARD WHERE IN_YN='N' AND END_DT < ?";
            $stmt_check = sqlsrv_query($connect, $query_check, [$Hyphen_today]);
            
            $overdue_count = 0;
            if ($stmt_check) {
                $row = sqlsrv_fetch_array($stmt_check);
                if ($row) {
                    $overdue_count = $row['overdue_count'];
                }
            }

            // 2. If overdue cards exist, prepare and send the email
            if ($overdue_count > 0) {
                
                // Helper function to get card holder info
                if (!function_exists('getCardHolderInfo')) {
                    function getCardHolderInfo($connection, $cardNumber) {
                        $info = ['status' => '반납', 'name' => '', 'phone' => ''];
                        $q1 = "SELECT TOP 1 IN_YN, NAME FROM CONNECT.dbo.CARD WHERE CARD = ? ORDER BY no DESC";
                        $stmt1 = sqlsrv_query($connection, $q1, [$cardNumber]);

                        if ($stmt1 && ($data1 = sqlsrv_fetch_array($stmt1))) {
                            $info['status'] = ($data1['IN_YN'] == 'N') ? '대여' : '반납';
                            $info['name'] = $data1['NAME'];

                            if (!empty($info['name'])) {
                                // 1. NO_TEL 과 NO_TEL_EMER 컬럼을 모두 조회하도록 쿼리 수정
                                $q2 = "SELECT NO_TEL, NO_TEL_EMER FROM NEOE.NEOE.MA_EMP WHERE NM_KOR = ? AND CD_COMPANY='1000' AND CD_PLANT='PL01'";
                                $stmt2 = sqlsrv_query($connection, $q2, [$info['name']]);

                                if ($stmt2 && ($data2 = sqlsrv_fetch_array($stmt2))) {
                                    $no_tel = $data2['NO_TEL'];
                                    $no_tel_emer = $data2['NO_TEL_EMER'];

                                    // 2. 010으로 시작하는 번호 우선순위 적용
                                    if (strpos($no_tel, '010') === 0) {
                                        $info['phone'] = $no_tel;
                                    } elseif (strpos($no_tel_emer, '010') === 0) {
                                        $info['phone'] = $no_tel_emer;
                                    } else {
                                        $info['phone'] = $no_tel;
                                    }
                                }
                            }
                        }
                        return $info;
                    }
                }

                $card_numbers_map = [
                    '6532' => ['name' => '신한카드', 'full_number' => '4518-4445-0568-6532'],
                    '3963' => ['name' => '우리비씨카드', 'full_number' => '4101-2020-0993-3963'],
                    '7938' => ['name' => '기업비씨카드', 'full_number' => '9430-0307-5713-7938']
                ];
                
                $card_data = [];
                foreach ($card_numbers_map as $num => $details) {
                    $card_data[$num] = getCardHolderInfo($connect, $num);
                    $card_data[$num]['details'] = $details;
                }

                // Build email body
                $tableHtml = '<table style="width: 100%; border-collapse: collapse; font-family: sans-serif; font-size: 14px;">
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">카드사</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">카드번호</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">반납여부</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">대여자</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">대여자 연락처</th>
                    </tr>';

                foreach($card_data as $data) {
                    $style = ($data['status'] == '대여') ? ' style="background-color: #FFDDC1;"' : '';
                    $tableHtml .= '
                    <tr'.$style.'>
                        <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($data['details']['name'] ?? '', ENT_QUOTES, 'UTF-8').'</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($data['details']['full_number'] ?? '', ENT_QUOTES, 'UTF-8').'</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($data['status'] ?? '', ENT_QUOTES, 'UTF-8').'</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($data['name'] ?? '', ENT_QUOTES, 'UTF-8').'</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($data['phone'] ?? '', ENT_QUOTES, 'UTF-8').'</td>
                    </tr>';
                }
                $tableHtml .= '</table>';

                $to = ['skkwon@iwin.kr', 'ir@iwin.kr'];
                $subject = '[FMS] 반납예정일을 초과한 법인카드가 있습니다!';
                $systemName = '법인카드 반납 알림';
                $title = '반납 초과 카드 목록';
                
                $link = 'https://fms.iwin.kr/kjwt_card/card.php';
                $body = build_email_template($systemName, $title, $tableHtml, $link, '법인카드 관리 페이지로 이동', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Card overdue notice sent successfully.";
                } else {
                    echo "Failed to send card overdue notice.";
                }

            } else {
                echo "No overdue cards found. No alert sent.";
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 협력사 인증 만료 알림 메일
        // ===================================
        case 'certification_expiry_notice':
            include_once __DIR__ . '/DB/DB2.php';

            // Find certifications expiring within the next 30 days
            $Query_Certification = "SELECT * FROM CONNECT.dbo.CERTIFICATION WHERE
                                    (IATF16949 BETWEEN GETDATE() AND DATEADD(day, 30, GETDATE())) OR
                                    (ISO9001 BETWEEN GETDATE() AND DATEADD(day, 30, GETDATE())) OR
                                    (ISO14001 BETWEEN GETDATE() AND DATEADD(day, 30, GETDATE())) OR
                                    (SQ BETWEEN GETDATE() AND DATEADD(day, 30, GETDATE()))";
            $Result_Certification = sqlsrv_query($connect, $Query_Certification);

            if ($Result_Certification === false) {
                error_log("Certification query failed: " . print_r(sqlsrv_errors(), true));
                echo "Database query failed.";
                if(isset($connect)) { sqlsrv_close($connect); }
                break;
            }

            $expiring_certs_html = '<table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">업체명</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">IATF16949</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">ISO9001</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">ISO14001</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">SQ</th>
                    </tr>
                </thead>
                <tbody>';
            
            $hasExpiringCerts = false;
            $thirty_days_from_now = (new DateTime())->modify('+30 days');

            while ($row = sqlsrv_fetch_array($Result_Certification, SQLSRV_FETCH_ASSOC)) {
                $hasExpiringCerts = true;
                
                $iatf_date = $row["IATF16949"] ? $row["IATF16949"]->format('Y-m-d') : '';
                $iso9001_date = $row["ISO9001"] ? $row["ISO9001"]->format('Y-m-d') : '';
                $iso14001_date = $row["ISO14001"] ? $row["ISO14001"]->format('Y-m-d') : '';
                $sq_date = $row["SQ"] ? $row["SQ"]->format('Y-m-d') : '';

                $iatf_style = ($row["IATF16949"] && $row["IATF16949"] <= $thirty_days_from_now) ? 'background-color: #FFDDC1;' : '';
                $iso9001_style = ($row["ISO9001"] && $row["ISO9001"] <= $thirty_days_from_now) ? 'background-color: #FFDDC1;' : '';
                $iso14001_style = ($row["ISO14001"] && $row["ISO14001"] <= $thirty_days_from_now) ? 'background-color: #FFDDC1;' : '';
                $sq_style = ($row["SQ"] && $row["SQ"] <= $thirty_days_from_now) ? 'background-color: #FFDDC1;' : '';

                $expiring_certs_html .= '<tr>
                    <td style="border: 1px solid #dddddd; padding: 8px;">' . htmlspecialchars($row['COMPANY']) . '</td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;' . $iatf_style . '">' . $iatf_date . '</td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;' . $iso9001_style . '">' . $iso9001_date . '</td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;' . $iso14001_style . '">' . $iso14001_date . '</td>
                    <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;' . $sq_style . '">' . $sq_date . '</td>
                </tr>';
            }
            $expiring_certs_html .= '</tbody></table>';

            if ($hasExpiringCerts) {
                $intro_text = '<p>※ 협력사 인증서 유효기간 만료 30일 전 알림입니다.<br>※ 유효기간 갱신 시 데이터 수정은 경영팀에 요청 바랍니다. (직접 핸들링을 원할 시 경영팀 문의바람)</p>';
                $contentHtml = $intro_text . $expiring_certs_html;

                $to = ['skkwon@iwin.kr', 'sales@iwin.kr'];
                $subject = '[FMS] 협력사 인증 유효기간 만료 안내';
                $systemName = '협력사 인증 만료 알림';
                $title = '만료 예정 인증서 목록';
                
                $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Certification expiry notice sent successfully.";
                } else {
                    echo "Failed to send certification expiry notice.";
                }
            } else {
                echo "No expiring certifications found. No alert sent.";
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 시험실 온습도 알림 메일
        // ===================================
        case 'test_room_temp_alert':
            include_once __DIR__ . '/DB/DB4.php'; // For $connect4 (mysqli)

            // Helper function to check temperature
            if (!function_exists('checkTestRoomTemperature')) {
                function checkTestRoomTemperature($connection, $today, $startTime, $endTime) {
                    $start_dt = $today . ' ' . $startTime . ':00';
                    $end_dt = $today . ' ' . $endTime . ':00';
                    $result = ['A_out' => false, 'B_out' => false];
                    $query_template = "SELECT 1 FROM %s WHERE search_dt = ? AND DT BETWEEN ? AND ? AND (temperature < 20 OR temperature > 30) LIMIT 1";
                    
                    // Check Room A
                    $stmtA = $connection->prepare(sprintf($query_template, '`experiment_room`'));
                    if ($stmtA) {
                        $stmtA->bind_param("sss", $today, $start_dt, $end_dt);
                        $stmtA->execute();
                        if ($stmtA->get_result()->num_rows > 0) {
                            $result['A_out'] = true;
                        }
                        $stmtA->close();
                    }

                    // Check Room B
                    $stmtB = $connection->prepare(sprintf($query_template, '`experiment_room2`'));
                    if ($stmtB) {
                        $stmtB->bind_param("sss", $today, $start_dt, $end_dt);
                        $stmtB->execute();
                        if ($stmtB->get_result()->num_rows > 0) {
                            $result['B_out'] = true;
                        }
                        $stmtB->close();
                    }
                    return $result;
                }
            }

            $Hyphen_today = date("Y-m-d");
            $current_time = date("H:i");
            $time_slot_info = null;

            // Determine which time slot to check based on cron schedule
            if ($current_time >= "08:30" && $current_time < "08:35") {
                $time_slot_info = ['start' => '00:00', 'end' => '08:30', 'label' => '00:00~08:30'];
            } elseif ($current_time >= "10:30" && $current_time < "10:35") {
                $time_slot_info = ['start' => '08:30', 'end' => '10:30', 'label' => '08:30~10:30'];
            } elseif ($current_time >= "13:30" && $current_time < "13:35") {
                $time_slot_info = ['start' => '10:30', 'end' => '13:30', 'label' => '10:30~13:30'];
            } elseif ($current_time >= "15:30" && $current_time < "15:35") {
                $time_slot_info = ['start' => '13:30', 'end' => '15:30', 'label' => '13:30~15:30'];
            }

            if ($time_slot_info === null) {
                echo "Not a designated notification time. No action taken.";
                break;
            }

            $check_result = checkTestRoomTemperature($connect4, $Hyphen_today, $time_slot_info['start'], $time_slot_info['end']);
            $is_A_out = $check_result['A_out'];
            $is_B_out = $check_result['B_out'];

            if (!$is_A_out && !$is_B_out) {
                echo "Temperatures are within range. No alert sent.";
                if(isset($connect4)) { $connect4->close(); }
                break;
            }

            // Determine location string for the email
            $LOCATION = '';
            if ($is_A_out && $is_B_out) {
                $LOCATION = 'A구역(출입구)과 B구역(챔버)';
            } elseif ($is_A_out) {
                $LOCATION = 'A구역(출입구)';
            } else { // Only B is out
                $LOCATION = 'B구역(챔버)';
            }
            
            $between = $time_slot_info['label'];

            $to = ['skkwon@iwin.kr', 'test@iwin.kr'];
            $subject = '[FMS] 온도 관리 기준 범위 이탈 안내';
            $systemName = '시험실 온도 알림';
            $title = '온도 이탈 발생';

            $contentHtml = <<<HTML
            <p>{$between} 시험실 {$LOCATION} 온도가 관리 기준을 이탈 하였습니다.</p>
            <ul style="padding-left: 20px; line-height: 1.8; list-style-type: none;">
                <li><strong>온도 관리 기준:</strong> 25±5℃ (20℃ ~ 30℃)</li>
                <li><strong>알림주기:</strong> 4회/일 (8:30 / 10:30 / 13:30 / 15:30)</li>
                <li><strong>알림기준:</strong> 각 측정 구간별 이탈 1회 이상 발생 시 알림</li>
                <li><strong>알림 대상자:</strong> 시험평가팀 전원</li>
            </ul>
HTML;
            
            $link = 'https://fms.iwin.kr/kjwt_esp8266_ht/measure_review.php';
            $body = build_email_template($systemName, $title, $contentHtml, $link, '온습도 기록 확인', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Test room temperature alert sent successfully.";
            } else {
                echo "Failed to send test room temperature alert.";
            }

            if(isset($connect4)) { $connect4->close(); }
            break;

        // ===================================
        // 시험실 가스경보기 점검 알림
        // ===================================
        case 'test_room_gas_detector_check':
            include_once __DIR__ . '/DB/DB2.php'; // For $connect (sqlsrv)
            
            $YY = date('Y');
            $Hyphen_today = date('Y-m-d');

            $Query_LastData = "SELECT top 1 INSPECT_DT from CONNECT.dbo.TEST_ROOM where INSPECT_DT IS NOT NULL order by NO desc";
            $Result_LastData = sqlsrv_query($connect, $Query_LastData);
            
            if ($Result_LastData) {
                $Data_LastData = sqlsrv_fetch_array($Result_LastData);
            } else {
                $Data_LastData = null;
            }

            if ($Data_LastData && isset($Data_LastData["INSPECT_DT"])) {
                $INSPECT_DT = $Data_LastData["INSPECT_DT"]->format("Y-m-d");
                $FLAG = $YY.'-02-15';
                $FLAG2 = $YY.'-08-15';

                if (($Hyphen_today > $FLAG && $INSPECT_DT < $FLAG) || ($Hyphen_today > $FLAG2 && $INSPECT_DT < $FLAG2)) {
                    $to = ['skkwon@iwin.kr', 'test@iwin.kr'];
                    $subject = '[FMS] 가스경보기 성능점검 안내';
                    $systemName = '시험실 가스경보기 점검';
                    $title = '성능점검 안내';
                    $contentHtml = '
                        <p>연소성시험기에 있는 가스경보기 성능점검일이 도래하였습니다! (6개월 마다 1회 점검!)</p>
                        <p>※가스경보기 가까이 라이터를 ★점화하지 않고★ 가스만 방출하여 경보기가 동작하는지 확인하시기 바랍니다!</p>
                        <p>성능점검 완료 후 아래의 바로가기나 연소성시험기 근처에 있는 점검했어요」포맥스의 QR코드를 스캔하여 체크리스트 입력 바랍니다.</p>
                    ';
                    $link = 'https://fms.iwin.kr/kjwt_test_room/test_room.php';
                    $body = build_email_template($systemName, $title, $contentHtml, $link, '바로가기', $logoCid);

                    if (send_system_email($to, $subject, $body, $embeddedImages)) {
                        echo "Test room gas detector check notice sent successfully.";
                    } else {
                        echo "Failed to send test room gas detector check notice.";
                    }
                } else {
                    echo "Test room gas detector check not due. No alert sent.";
                }
            } else {
                echo "Could not retrieve last inspection date for test room gas detector.";
                if ($Result_LastData === false) {
                    error_log("test_room_gas_detector_check: DB query failed: " . print_r(sqlsrv_errors(), true));
                }
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 지그 점검 알림 메일
        // ===================================
        case 'jig_inspection_notice':
            include_once __DIR__ . '/DB/DB2.php';

            $query = "SELECT CURRENT_QTY, LIMIT_QTY FROM QIS.dbo.M_JIG_INFO WHERE JIG_ID NOT LIKE 'V%' AND JIG_SEQ NOT LIKE 'V%'";
            $result = sqlsrv_query($connect, $query);

            $inspection_needed = false;
            if ($result) {
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    if (isset($row['CURRENT_QTY'], $row['LIMIT_QTY']) && $row['CURRENT_QTY'] >= $row['LIMIT_QTY']) {
                        $inspection_needed = true;
                        break;
                    }
                }
            } else {
                error_log("jig_inspection_notice: DB query failed: " . print_r(sqlsrv_errors(), true));
                echo "Jig inspection check failed due to a database error.";
                if(isset($connect)) { sqlsrv_close($connect); }
                break;
            }

            if ($inspection_needed) {
                $to = ['skkwon@iwin.kr', 'qc@iwin.kr'];
                $subject = '[FMS] JIG 점검 요청';
                $systemName = 'JIG 점검 알림';
                $title = '점검 요청';

                $contentHtml = '<p>점검이 필요한 지그가 있습니다. FMS에서 확인해주세요.</p>';
                
                $link = 'https://fms.iwin.kr/kjwt_field_inspect/inspect_jig.php';
                $body = build_email_template($systemName, $title, $contentHtml, $link, 'JIG 현황 확인', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Jig inspection notice sent successfully.";
                } else {
                    echo "Failed to send jig inspection notice.";
                }
            } else {
                echo "No jigs require inspection. Email not sent.";
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 베트남 지그 점검 알림 메일
        // ===================================
        case 'jig_inspection_notice_vietnam':
            include_once __DIR__ . '/DB/DB2.php';

            $query = "SELECT CURRENT_QTY, LIMIT_QTY FROM QIS.dbo.M_JIG_INFO WHERE JIG_ID LIKE 'V%' OR JIG_SEQ LIKE 'V%'";
            $result = sqlsrv_query($connect, $query);

            $inspection_needed = false;
            if ($result) {
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    if (isset($row['CURRENT_QTY'], $row['LIMIT_QTY']) && $row['CURRENT_QTY'] >= $row['LIMIT_QTY']) {
                        $inspection_needed = true;
                        break;
                    }
                }
            } else {
                error_log("jig_inspection_notice_vietnam: DB query failed: " . print_r(sqlsrv_errors(), true));
                echo "Vietnam jig inspection check failed due to a database error.";
                if(isset($connect)) { sqlsrv_close($connect); }
                break;
            }

            if ($inspection_needed) {
                $to = ['jyjung@iwin.kr', 'bjbae@iwin.kr'];
                $subject = '[FMS] JIG 점검 요청 (베트남)';
                $systemName = 'JIG 점검 알림 (베트남)';
                $title = '점검 요청';

                $contentHtml = '<p>점검이 필요한 베트남 지그가 있습니다. FMS에서 확인해주세요.</p>';
                
                $link = 'https://fms.iwin.kr/kjwt_field_inspect/inspect_jig_v.php';
                $body = build_email_template($systemName, $title, $contentHtml, $link, 'JIG 현황 확인', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Vietnam jig inspection notice sent successfully.";
                } else {
                    echo "Failed to send Vietnam jig inspection notice.";
                }
            } else {
                echo "No Vietnam jigs require inspection. Email not sent.";
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 선입선출 오류 보고서
        // ===================================
        case 'fifo_error_report':
            include_once __DIR__ . '/DB/DB2.php';
            include_once __DIR__ . '/FUNCTION.php';

            $Minus1Day = date('Ymd', strtotime('-1 day'));

            $Query_FifoFail = "
                WITH RankedLogs AS (
                    SELECT 
                        *,
                        ROW_NUMBER() OVER (PARTITION BY cd_item, lot_date ORDER BY SORTING_DATE) AS rn,
                        COUNT(*) OVER (PARTITION BY cd_item, lot_date) AS cd_item_count
                    FROM CONNECT.dbo.FINISHED_OUTPUT_LOG
                    WHERE FIFO_YN='N' AND SORTING_DATE = ?
                )
                SELECT *
                FROM RankedLogs
                WHERE rn = 1;
            ";

            $params = [$Minus1Day];
            $options = ["Scrollable" => SQLSRV_CURSOR_KEYSET];
            $Result_FifoFail = sqlsrv_query($connect, $Query_FifoFail, $params, $options);

            if ($Result_FifoFail === false) {
                error_log("fifo_error_report: DB query failed: " . print_r(sqlsrv_errors(), true));
                echo "FIFO error report failed due to a database error.";
                if(isset($connect)) { sqlsrv_close($connect); }
                break;
            }

            $Count_FifoFail = sqlsrv_num_rows($Result_FifoFail);

            if ($Count_FifoFail > 0) {
                $tableRows = '';
                while ($row = sqlsrv_fetch_array($Result_FifoFail, SQLSRV_FETCH_ASSOC)) {
                    $cd_item = $row['CD_ITEM'] ?? '';
                    $lot_date = $row['LOT_DATE'] ?? '';
                    $cd_item_count = $row['cd_item_count'] ?? '';
                    $sorting_date_obj = $row['SORTING_DATE'];
                    $sorting_date = $sorting_date_obj ? $sorting_date_obj->format('Y-m-d') : '';
                    $fifo_n_reason = $row['FIFO_N_REASON'] ?? '';

                    $nm_item = NM_ITEM($cd_item);
                    $cd_item_hyphen = Hyphen($cd_item);

                    $tableRows .= '
                        <tr>
                            <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($cd_item_hyphen).'</td>
                            <td style="border: 1px solid #dddddd; padding: 8px;">'.htmlspecialchars($nm_item).'</td>
                            <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($lot_date).'</td>
                            <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($cd_item_count).'</td>
                            <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($sorting_date).'</td>
                            <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">'.htmlspecialchars($fifo_n_reason).'</td>
                        </tr>
                    ';
                }

                $explanation = '
                    <p style="font-size: 12px; color: #555;">
                        - 전일 선입선출 오류 리스트입니다.<br>
                        - 출하 시점에서 선입선출 오류인 제품에 대해 알려 드립니다.<br>
                        - 로트날짜는 제품 생산 날짜입니다.<br>
                        - 만약 <span style="color: red;">20240101</span>, <span style="color: blue;">20250101</span>, <span style="color: green;">20250202</span> 제품이 있고 오늘 <span style="color: blue;">20250101</span>이 출하되면 선입선출 오류로 기록되며 내일 <span style="color: red;">20240101</span>이 출하되고 모레 <span style="color: green;">20250202</span>가 출하되면 <span style="color: green;">20250202</span>는 선입선출 오류로 기록되지 않습니다.<br>
                        - 로트날짜는 검수완료 후 매핑 시 수집이 되므로 BB에서 발생하는 선입선출 오류를 검출할 수 없습니다.<br>
                        - 완성품 출하 시 박스라벨이 있음에도 불구하고 수기입력 시, 해당 라벨에 있는 로트날짜가 계속 입고되어 있는것으로 나오므로 선입선출 카운트에 영향을 줍니다.
                    </p>';

                $tableHtml = '
                    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center; background-color: #f2f2f2;">품번</th>
                                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center; background-color: #f2f2f2;">품명</th>
                                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center; background-color: #f2f2f2;">포장일</th>
                                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center; background-color: #f2f2f2;">오류건수</th>
                                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center; background-color: #f2f2f2;">출하일</th>
                                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center; background-color: #f2f2f2;">근거<br>(대기중인 생산일)</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.$tableRows.'
                        </tbody>
                    </table>';
                
                $contentHtml = $explanation . $tableHtml;

                $to = ['skkwon@iwin.kr', 'qc@iwin.kr'];
                $subject = '[FMS] 완성품창고 선입선출 오류 보고서';
                $systemName = '선입선출 오류 보고서';
                $title = '전일 선입선출 오류 목록';
                
                $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "FIFO error report sent successfully.";
                } else {
                    echo "Failed to send FIFO error report.";
                }

            } else {
                echo "No FIFO errors found for yesterday. No report sent.";
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 당숙일지 순찰 특이사항 알림
        // ===================================
        case 'guard_patrol_report':
            include_once __DIR__ . '/DB/DB2.php';

            $Minus1Day = date('Ymd', strtotime('-1 day'));

            $Query_GuardChk = "SELECT GUARD, NOTE FROM CONNECT.dbo.GUARD WHERE SORTING_DATE = ?";
            $params = [$Minus1Day];
            $Result_GuardChk = sqlsrv_query($connect, $Query_GuardChk, $params);

            if ($Result_GuardChk === false) {
                error_log('Guard Mail Error: SQL query failed: ' . print_r(sqlsrv_errors(), true));
                echo "Guard patrol report failed due to a database error.";
                if(isset($connect)) { sqlsrv_close($connect); }
                break;
            }

            $Data_GuardChk = sqlsrv_fetch_array($Result_GuardChk);

            if ($Data_GuardChk) {
                $NOTE = trim($Data_GuardChk["NOTE"] ?? '');

                if (!empty($NOTE) && strpos($NOTE, '없음') === false) {
                    $guard = htmlspecialchars($Data_GuardChk["GUARD"] ?? 'N/A', ENT_QUOTES, 'UTF-8');
                    $SORTING_DATE = htmlspecialchars($Minus1Day, ENT_QUOTES, 'UTF-8');
                    $NOTE_html = nl2br(htmlspecialchars($NOTE, ENT_QUOTES, 'UTF-8'));

                    $contentHtml = <<<HTML
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <tr>
                            <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; width: 20%;">보고자</td>
                            <td style="border: 1px solid #dddddd; padding: 8px;">{$guard}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold;">날짜</td>
                            <td style="border: 1px solid #dddddd; padding: 8px;">{$SORTING_DATE}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold;">특이사항</td>
                            <td style="border: 1px solid #dddddd; padding: 8px;">{$NOTE_html}</td>
                        </tr>
                    </table>
HTML;

                    $to = 'hr@iwin.kr';
                    $subject = '[FMS] 당숙일지 특이사항 발생';
                    $systemName = '당숙일지 특이사항';
                    $title = '전일 순찰 특이사항';
                    $link = 'https://fms.iwin.kr/kjwt_guard/guard.php';

                    $body = build_email_template($systemName, $title, $contentHtml, $link, '당숙일지 확인하기', $logoCid);

                    if (send_system_email($to, $subject, $body, $embeddedImages)) {
                        echo "Guard patrol report sent successfully.";
                    } else {
                        echo "Failed to send guard patrol report.";
                    }
                } else {
                    echo "No special notes found for yesterday. No report sent.";
                }
            } else {
                echo "No guard log found for yesterday. No report sent.";
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 마스터 샘플 점검 알림
        // ===================================
        case 'master_sample_expiry_notice':
            include_once __DIR__ . '/DB/DB2.php';

            $Query_MasterSample = "SELECT dt FROM CONNECT.dbo.MASTER_SAMPLE";
            $Result_MasterSample = sqlsrv_query($connect, $Query_MasterSample);

            $isMailRequired = false;
            $mailBodyContent = '';
            $updates = [];
            $today = new DateTime();

            if ($Result_MasterSample) {
                while ($row = sqlsrv_fetch_array($Result_MasterSample, SQLSRV_FETCH_ASSOC)) {
                    $dt = $row["dt"] ?? null;

                    if (!$dt) {
                        continue; // Skip if date is missing
                    }

                    $expiryDate = (clone $dt);
                    $diff_days = ($today->diff($expiryDate))->days;
                    $is_past = $today > $expiryDate;

                    if (!$is_past && $diff_days < 30 && date('N') == 1) {
                        $isMailRequired = true;
                        
                        $old_dt_str = $expiryDate->format('Y-m-d');
                        $new_dt = (clone $expiryDate)->modify('+6 months');
                        $new_dt_str = $new_dt->format('Y-m-d');

                        // Store for update and email body
                        $updates[] = ['old_dt' => $old_dt_str, 'new_dt' => $new_dt_str];
                        
                        $mailBodyContent .= '
                            <tr>
                                <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">' . htmlspecialchars($old_dt_str) . '</td>
                                <td style="border: 1px solid #dddddd; padding: 8px; text-align: center;">' . htmlspecialchars($new_dt_str) . '</td>
                            </tr>
                        ';
                    }
                }
            } else {
                 error_log("Master sample mail: DB query failed: " . print_r(sqlsrv_errors(), true));
                 echo "Master sample check failed due to a database error.";
                 if(isset($connect)) { sqlsrv_close($connect); }
                 break;
            }

            if ($isMailRequired) {
                // 1. Update the database for each expiring sample
                // This assumes that the 'dt' column can uniquely identify the rows to be updated.
                // If multiple samples share the same expiry date, they will all be updated together.
                $updateQuery = "UPDATE CONNECT.dbo.MASTER_SAMPLE SET dt = ? WHERE dt = ?";
                foreach ($updates as $update) {
                    $update_params = [$update['new_dt'], $update['old_dt']];
                    sqlsrv_query($connect, $updateQuery, $update_params);
                }

                // 2. Send notification email
                $tableHtml = '
                    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center; background-color: #f2f2f2;">기존 만료일</th>
                                <th style="border: 1px solid #dddddd; padding: 8px; text-align: center; background-color: #f2f2f2;">갱신된 만료일</th>
                            </tr>
                        </thead>
                        <tbody>'
                        . $mailBodyContent .
                        '</tbody>
                    </table>';
                
                $intro_text = '<p>등록된 마스터 샘플의 유효기간 30일 전 알림입니다.<br>아래 샘플들의 유효기간이 6개월 자동 갱신되었습니다.</p>';
                $contentHtml = $intro_text . $tableHtml;

                $to = ['skkwon@iwin.kr', 'qc@iwin.kr'];
                $subject = '[FMS] 마스터 샘플 만료일자 안내 (자동 갱신 완료)';
                $systemName = '마스터 샘플 점검';
                $title = '만료 예정 샘플 (자동 갱신됨)';
                
                $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Master sample expiry notice sent and dates updated successfully.";
                } else {
                    echo "Failed to send master sample expiry notice.";
                }

            } else {
                echo "No master samples require renewal. No action taken.";
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 당직자 알림 메일
        // ===================================
        case 'duty_person_notice':
            include_once __DIR__ . '/DB/DB1.php'; // For $connect (mysqli)

            $today = date("Ymd");
            $duty_person_email = null;
            $duty_person_name = '';

            $sql_duty = "SELECT duty_person, duty_change FROM duty WHERE dt = ? AND holiday_yn = 'N'";
            $stmt_duty = $connect->prepare($sql_duty);
            $stmt_duty->bind_param("s", $today);
            $stmt_duty->execute();
            $result_duty = $stmt_duty->get_result();
            $duty_record = $result_duty->fetch_assoc();

            if ($duty_record) {
                $duty_person_name = !empty($duty_record['duty_change']) ? $duty_record['duty_change'] : $duty_record['duty_person'];

                $sql_user = "SELECT EMAIL FROM user_info WHERE DUTY_YN = 'Y' AND USER_NM = ?";
                $stmt_user = $connect->prepare($sql_user);
                $stmt_user->bind_param("s", $duty_person_name);
                $stmt_user->execute();
                $result_user = $stmt_user->get_result();
                $user_record = $result_user->fetch_assoc();

                if ($user_record && filter_var($user_record['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                    $duty_person_email = $user_record['EMAIL'];
                } else {
                    error_log("Duty person not found or email is invalid: " . $duty_person_name);
                }
                $stmt_user->close();
            }
            $stmt_duty->close();

            if ($duty_person_email) {
                $to = $duty_person_email;
                $subject = '[FMS] 금일의 당직자는 ' . $duty_person_name . '님 입니다.';
                $systemName = '당직 알림';
                $title = '당직 절차 안내';

                $contentHtml = <<<HTML
                <p><strong>※ 중요공지: 12:10~12:30 경비실 교대근무 (차량통제)</strong></p>
                <ol style="padding-left: 20px; line-height: 1.8;">
                    <li>현장종료 후 17:30(정상) or 19:30(연장) 당직시작</li>
                    <li>핸드폰으로 <a href="https://fms.iwin.kr/kjwt_office_duty/duty.php" target="_blank">당직 페이지</a> 접속 후, 당직일지 탭 선택</li>
                    <li>당직일지의 체크포인트를 확인</li>
                    <li>당직일지의 NFC 체크포인트에서 NFC 태깅
                        <ul style="font-size: 0.9em; color: #555;">
                            <li>태깅이 잘 안되면 핸드폰 커버를 벗겨 보세요!</li>
                            <li>Android: NFC를 켜세요!</li>
                            <li>iOS: NFC가 항상 켜져 있어요!</li>
                        </ul>
                    </li>
                </ol>
                <p>※ 긴급사항(화재, 누수 등) 발생 시 경비원, 경영팀에 연락 바랍니다.</p>
HTML;
                
                $link = 'https://fms.iwin.kr/kjwt_office_duty/duty.php';
                $body = build_email_template($systemName, $title, $contentHtml, $link, '당직 페이지로 이동', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Duty person notice sent successfully to {$duty_person_name}.";
                } else {
                    echo "Failed to send duty person notice.";
                }
            } else {
                echo "No duty person found for today. No email sent.";
            }

            if(isset($connect)) { $connect->close(); }
            break;

        // ===================================
        // 물 사용량 이상 알림
        // ===================================
        case 'water_usage_alert':
            $to = 'hr@iwin.kr';
            $subject = '[FMS] 물 사용량이 이상합니다!';
            $systemName = '수도 사용량 경고';
            $title = '물 사용량 급증';

            $contentHtml = <<<HTML
            <p>★물 사용량이 갑자기 증가하였습니다★</p>
            <ul style="padding-left: 20px; line-height: 1.8;">
                <li><strong>일 평균:</strong> 12</li>
                <li><strong>일 사용 과다:</strong> 20~30</li>
                <li><strong>사용 이상:</strong> 30 이상</li>
            </ul>
HTML;
            
            $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Water usage alert sent successfully.";
            } else {
                echo "Failed to send water usage alert.";
            }
            break;

        // ===================================
        // BB 유검 수량 월간 보고서
        // ===================================
        case 'field_inspection_report':
            include_once __DIR__ . '/DB/DB2.php';

            $first_day = date('Y-m-01', strtotime('-1 month'));
            $last_day = date('Y-m-t', strtotime('-1 month'));
            $report_month = date('Y년 m월', strtotime('-1 month'));

            $query = "SELECT 
                        (SELECT ISNULL(SUM(QT_GOODS), 0)
                         FROM [CONNECT].[dbo].[FIELD_PROCESS_FINISH_V]
                         WHERE INSPECT_YN = 'Y'
                         AND SORTING_DATE BETWEEN ? AND ?) 
                        + 
                        (SELECT ISNULL(SUM(QT_GOODS), 0)
                         FROM [CONNECT].[dbo].[FIELD_PROCESS_FINISH_V2]
                         WHERE INSPECT_YN = 'Y'
                         AND SORTING_DATE BETWEEN ? AND ?) AS TOTAL_GOODS";
            
            $params = [$first_day, $last_day, $first_day, $last_day];
            $result = sqlsrv_query($connect, $query, $params);

            if ($result === false) {
                error_log("Field inspection report query failed: " . print_r(sqlsrv_errors(), true));
                echo "Database query for inspection report failed.";
                if(isset($connect)) { sqlsrv_close($connect); }
                break;
            }

            $data = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $total_goods = $data['TOTAL_GOODS'] ?? 0;

            $to = ['skkwon@iwin.kr', 'qc@iwin.kr'];
            $subject = "[FMS] {$report_month} BB 유검 수량 보고";
            $systemName = '월간 유검 수량 보고';
            $title = "{$report_month} BB 유검 수량";

            $contentHtml = <<<HTML
            <p>전월({$report_month}) 한국 BB 제품 유검 수량을 안내드립니다.</p>
            <p style="font-size: 24px; font-weight: bold; color: #055AAF; text-align: center; margin: 20px 0;">
                {$total_goods} 개
            </p>
            <hr style="border: 0; border-top: 1px solid #e3e6f0; margin: 20px 0;">
            <p style="font-size: 12px; color: #858796;">
                - 본 메일은 매월 1일, 전월의 데이터를 기준으로 자동 발송됩니다.<br>
                - 기준: 한국 검사일<br>
                - 요청자: 품질팀 황형섭
            </p>
HTML;
            
            $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Field inspection report sent successfully.";
            } else {
                echo "Failed to send field inspection report.";
            }

            if(isset($connect)) { sqlsrv_close($connect); }
            break;

        // ===================================
        // 골프장 예약 알림
        // ===================================
        case 'golf_reservation_notice':
            $to = 'hr@iwin.kr';
            $subject = '[FMS] 골프장 예약 알림';
            $systemName = '골프장 예약 알림';
            $title = '예약 안내';

            $contentHtml = <<<HTML
            ■ 골프장 예약 ■<br><br>

            ※요약<br>
            - 격주로 수요일에 3주 후 토요일 날짜를 예약한다.<br>
            - 매주 금요일에 4주 후 목요일 날짜를 예약한다.<br>
            - 9~15시 사이에만 예약할 수 있다.<br>
            - 예약 그리고 예약확정 시 담당자와 회장님에게 문자가 간다.<br>
            - 모두 신안그룹에 소속된 골프장인데 특이하게 에버리스만 전화로 예약해야 한다.<br><br>

            1. 매월 예약<br>
            ㅁ 예약일정 : 회장님 지시하시는 날짜, 별말씀 없으시면 매주 목요일 (4회) / 첫째, 셋째 토요일<br>
            ㅁ 평일은 4주전 다음날 예약 가능하다 . (목요일 예약의 경우 4주전 금요일 예약신청)<br>
            ㅁ 주말(공휴일포함)은 3주전(24일전) 수요일에 예약 가능하다. <br>
            ㅁ 회장님 별 말씀 없으시면<br>
            - 1순위 : 리베라 / 2순위 : 신안 / 3순위 : 그린힐<br>
            - 시간대 : 8시~9시<br>
            ㅁ 예약방법은 온라인신청, 팩스신청 가능함.<br>
            - 온라인 신청 : 공휴일에도 신청 가능<br>
            &nbsp; > www.shinangolf.com (iwin0007/kjwt8132365!)<br>
            - 팩스신청 : 공휴일인 경우 그 다음 영업일에 팩스 송신.<br><br>

            2. 제주 에버리스 예약 : 회장님 지시할때 예약<br>
            ㅁ 전화로 예약해야함<br>
            - 지정된 담당자 전화로만 예약가능. (담당자 변경신청 필요) <br>
            - 에버리스 : 064-795-5000<br>
            ㅁ 법인회원이고, 신규진이라고 하면 됨.<br> <br>

            3. 예약취소 : 회장님 지시할때 취소<br>
            ㅁ 전화로 취소해야함<br>
            - 지정된 담당자 전화로만 취소가능. (담당자 변경신청 필요)            
HTML;
            
            $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Golf reservation notice sent successfully.";
            } else {
                echo "Failed to send golf reservation notice.";
            }
            break;

        // ===================================
        // 하이패스카드 충전 요청
        // ===================================
        case 'hipass_charge_notice':
            include_once __DIR__ . '/DB/DB1.php'; // For $connect (mysqli)

            $card_id = filter_var($_POST["card_id"] ?? null, FILTER_VALIDATE_INT);
            $balance = filter_var($_POST["balance"] ?? 0, FILTER_VALIDATE_INT);

            $card_kind = '정보 없음';
            if ($card_id !== null) {
                $stmt = $connect->prepare("SELECT KIND FROM hipass_now WHERE NO = ?");
                if ($stmt) {
                    $stmt->bind_param("i", $card_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_object()) {
                        $card_kind = $row->KIND;
                    }
                    $stmt->close();
                }
            }

            $to = 'hr@iwin.kr';
            $subject = '[FMS] 개인차량 하이패스카드 충전 요청';
            $systemName = '하이패스카드 충전 요청';
            $title = '충전 및 정산 요청';

            $formatted_balance = number_format($balance);

            $contentHtml = <<<HTML
            <p>아래 하이패스카드의 잔액이 부족하여 충전 및 정산이 필요합니다.</p>
            <br>
            <p><strong>- 카드 종류:</strong> {$card_kind}</p>
            <p><strong>- 현재 잔액:</strong> {$formatted_balance} 원</p>
HTML;
            
            $link = 'https://fms.iwin.kr/kjwt_fms/hipass.php';
            $body = build_email_template($systemName, $title, $contentHtml, $link, '하이패스 관리 페이지로 이동', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Hi-pass charge notice sent successfully.";
            } else {
                echo "Failed to send hi-pass charge notice.";
            }

            if(isset($connect)) { $connect->close(); }
            break;

        // ===================================
        // 법인차 하이패스카드 충전 요청
        // ===================================
        case 'hipass_charge_notice_corporate':
            $car = htmlspecialchars($_REQUEST["car"] ?? '정보 없음', ENT_QUOTES, 'UTF-8');
            $balance = filter_var($_REQUEST["balance"] ?? 0, FILTER_VALIDATE_INT);
            $formatted_balance = number_format($balance);

            $to = 'hr@iwin.kr';
            $subject = "[FMS] 법인차({$car}) 하이패스카드 충전 및 정산요청";
            $systemName = '법인차 하이패스카드';
            $title = '충전 및 정산 요청';

            $contentHtml = <<<HTML
            <p>법인차량({$car})의 하이패스카드 잔액이 부족하여 충전이 필요합니다.</p>
            <br>
            <p><strong>- 차량번호:</strong> {$car}</p>
            <p><strong>- 현재 잔액:</strong> {$formatted_balance} 원</p>
HTML;
            
            $link = 'https://fms.iwin.kr/kjwt_fms/hipass.php';
            $body = build_email_template($systemName, $title, $contentHtml, $link, '법인차량 관리 페이지로 이동', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Corporate hi-pass charge notice sent successfully.";
            } else {
                echo "Failed to send corporate hi-pass charge notice.";
            }
            break;

        // ===================================
        // 회장님실 달력 교체 알림
        // ===================================
        case 'chairman_calendar_notice':
            $today = date('Y-m-d');
            $end_of_month = date('Y-m-t');

            // 오늘이 이달의 마지막 날인 경우에만 메일 발송
            if ($today === $end_of_month) {
                $to = 'hr@iwin.kr';
                $subject = '[FMS] 달력 넘김 알림';
                $systemName = 'FMS 알림';
                $title = '회장님실 달력 교체';

                $contentHtml = '<p>회장님실 탁상달력을 다음달로 넘기세요!</p>';
                
                $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Chairman calendar notice sent successfully.";
                } else {
                    echo "Failed to send chairman calendar notice.";
                }
            } else {
                echo "Not the end of the month. No calendar notice sent.";
            }
            break;

        // ===================================
        // 법인차 특이사항 알림
        // ===================================
        case 'corporate_car_issue_report':
            include_once __DIR__ . '/DB/DB1.php'; // For $connect (mysqli)

            // 특이사항 발생 차량 조회
            $query = "SELECT CAR_NM, NOTE FROM car_current ORDER BY NO DESC LIMIT 1";
            $result = $connect->query($query);
            $data = $result->fetch_object();

            if ($data) {
                $carName = htmlspecialchars($data->CAR_NM, ENT_QUOTES, 'UTF-8');
                $note = htmlspecialchars($data->NOTE, ENT_QUOTES, 'UTF-8');

                $to = 'hr@iwin.kr';
                $subject = '[FMS] 법인차 특이사항 발생';
                $systemName = '법인차량 관리';
                $title = '차량 특이사항 알림';

                $contentHtml = <<<HTML
                <p>아래와 같이 법인차량 특이사항이 발생하여 알려드립니다.</p>
                <br>
                <p><strong>차량정보:</strong> {$carName}</p>
                <p><strong>특이사항:</strong><br>{$note}</p>
HTML;
                
                $link = 'https://fms.iwin.kr/kjwt_fms/rental.php'; // Link to the car management page
                $body = build_email_template($systemName, $title, $contentHtml, $link, '차량 관리 페이지로 이동', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Corporate car issue report sent successfully.";
                } else {
                    echo "Failed to send corporate car issue report.";
                }
            } else {
                echo "No car issue data found. No alert sent.";
            }

            if(isset($connect)) { $connect->close(); }
            break;

        // ===================================
        // 통합 보고서
        // ===================================
        case 'merge_report':
            include_once __DIR__ . '/DB/DB3.php'; // For $connect3 (mysqli)
            include_once __DIR__ . '/FUNCTION.php';

            $Query_ReportSafe = "SELECT doc_id FROM teag_appdoc WHERE doc_title LIKE '%안전관리 상태보고 건' ORDER BY doc_id DESC LIMIT 1";
            $Result_ReportSafe = $connect3->query($Query_ReportSafe);
            $Data_ReportSafe = $Result_ReportSafe ? $Result_ReportSafe->fetch_assoc() : null;

            $Query_ReportIT = "SELECT doc_id FROM teag_appdoc WHERE doc_title LIKE '%IT 보고 건' ORDER BY doc_id DESC LIMIT 1";
            $Result_ReportIT = $connect3->query($Query_ReportIT);
            $Data_ReportIT = $Result_ReportIT ? $Result_ReportIT->fetch_assoc() : null;

            if(isset($connect3)) { $connect3->close(); }

            $safe_doc_id = $Data_ReportSafe['doc_id'] ?? '';
            $it_doc_id = $Data_ReportIT['doc_id'] ?? '';

            // [추가] 파라미터 문자열 미리 생성 (이미 코드에 존재했으나 사용되지 않음)
            $mk_param = '?mail_key=' . MAIL_MAGIC_KEY;

            // 아래 HEREDOC 내부의 fms.iwin.kr 링크들 뒤에 {$mk_param}을 추가했습니다.
            $contentHtml = <<<HTML
            <p style="font-size: 12px; color: #858796;">
                - 보안을 위해 외부환경(LTE, 부산본사 외 WIFI)에서 열람이 제한됩니다.<br>
                - 임원 및 팀장에게는 월요일마다 메일이 발송됩니다.<br>
                - 수신거부를 원할 시 경영팀에 연락주시기 바랍니다.
            </p>
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;" border="1" cellpadding="8">
                <thead style="background-color: #f8f9fc;">
                    <tr>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">제목</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">설명</th>
                        <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">바로가기</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center;">
                        <td style="border: 1px solid #dddddd; padding: 8px;">일일업무 보고서</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">비용과 관련된 포괄적인 내용</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><a href="https://fms.iwin.kr/kjwt_report/report_body.php{$mk_param}" target="_blank" style="text-decoration: none; font-size: 24px;">🧾</a></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="border: 1px solid #dddddd; padding: 8px;">근태 보고서</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">인원 및 근태현황</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><a href="https://fms.iwin.kr/kjwt_gw/gw_attend.php{$mk_param}" target="_blank" style="text-decoration: none; font-size: 24px;">👤</a></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="border: 1px solid #dddddd; padding: 8px;">안전 보고서</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">안전 문제점 및 조치현황</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><a href="https://gw.iwin.kr/eap/ea/docpop/EAAppDocViewPop.do?doc_id={$safe_doc_id}&form_id=16" target="_blank" style="text-decoration: none; font-size: 24px;">👷</a></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="border: 1px solid #dddddd; padding: 8px;">전산 보고서</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">서버, 자산, 서비스 목록 / 운영비용 / 개발현황</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><a href="https://fms.iwin.kr/kjwt_report/report_network.php{$mk_param}" target="_blank" style="text-decoration: none; font-size: 24px;">🖥️</a></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="border: 1px solid #dddddd; padding: 8px;">전산 보고서2</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">내부회계 조건을 충족하는 IT 보고서</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><a href="https://gw.iwin.kr/eap/ea/docpop/EAAppDocViewPop.do?doc_id={$it_doc_id}&form_id=16" target="_blank" style="text-decoration: none; font-size: 24px;">📋</a></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="border: 1px solid #dddddd; padding: 8px;">경비 보고서</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">당숙일지 및 순찰현황</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><a href="https://fms.iwin.kr/kjwt_report/report_guard.php{$mk_param}" target="_blank" style="text-decoration: none; font-size: 24px;">🛡️</a></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="border: 1px solid #dddddd; padding: 8px;">ESG 보고서</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">ESG활동 및 온실가스 배출 현황</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><a href="https://fms.iwin.kr/kjwt_esg/esg.php{$mk_param}" target="_blank" style="text-decoration: none; font-size: 24px;">🌱</a></td>
                    </tr>
                </tbody>
            </table>
HTML;
           $to = [
                "hr@iwin.kr", "skjin@iwin.kr", "hjjin@iwin.kr", "bhcho@iwin.kr", "tsyou@iwin.kr", "yscho@iwin.kr",
                "slpark@iwin.kr", "ydjeong@iwin.kr", "jsyoon@iwin.kr", "yksung@iwin.kr", "shjoo@iwin.kr",
                "jwjung@iwin.kr", "hjshim@iwin.kr", "gmkim@iwin.kr", "dkkim@iwin.kr", "shpark@iwin.kr",
                "ithan@iwin.kr", "sklee@iwin.kr", "shsin@iwin.kr", "bhkim@iwin.kr", "dykim@iwin.kr", "mbko@iwin.kr",
                "jkjang@iwin.kr", "mywoo@iwin.kr"
            ];
            $subject = '[FMS] 통합 보고서';
            $systemName = 'FMS 통합 보고서';
            $title = '주간 보고서 목록';
            $body = build_email_template($systemName, $title, $contentHtml, null, '', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Merge report mail sent successfully.";
            } else {
                echo "Failed to send merge report mail.";
            }
            break;

        // ===================================
        // 프로젝트 업무관리 알림
        // ===================================
        case 'project_task_notice':
            include_once __DIR__ . '/DB/DB1.php'; // For $connect (mysqli, user_info)
            include_once __DIR__ . '/DB/DB3.php'; // For $connect3 (mysqli, project db)
            include_once __DIR__ . '/FUNCTION.php'; // For date variables like $Hyphen_today, $Plus6Day

            // 1. 마감일이 임박하고, 완료되지 않은 태스크가 있는 사용자 목록 조회
            $query_users_to_notify = "
                SELECT DISTINCT c.emp_name
                FROM t_pr_job_user c
                LEFT JOIN t_pr_job_detail a ON c.job_seq = a.job_seq
                LEFT JOIN t_pr_job b ON a.job_seq = b.job_seq
                WHERE a.use_yn = 'Y' 
                  AND a.process_rate != '100' 
                  AND b.end_date >= '{$Hyphen_today}' 
                  AND b.end_date <= '{$Plus6Day}'
            ";
            $result_users_to_notify = $connect3->query($query_users_to_notify);

            if (!$result_users_to_notify) {
                error_log("Project task mailer: Failed to query users to notify: " . $connect3->error);
                echo "Failed to query users to notify.";
                if(isset($connect)) { $connect->close(); }
                if(isset($connect3)) { $connect3->close(); }
                break;
            }

            if ($result_users_to_notify->num_rows === 0) {
                echo "No users with impending tasks to notify.";
                if(isset($connect)) { $connect->close(); }
                if(isset($connect3)) { $connect3->close(); }
                break;
            }

            $users_emailed = 0;

            // 2. 각 사용자별로 루프를 돌며 메일 발송
            while ($user_row = $result_users_to_notify->fetch_assoc()) {
                $emp_name = $user_row['emp_name'];

                // 2-1. 사용자 이메일 조회
                $user_info_query = $connect->prepare("SELECT EMAIL FROM user_info WHERE USER_NM = ?");
                $user_info_query->bind_param("s", $emp_name);
                $user_info_query->execute();
                $user_info_result = $user_info_query->get_result();
                $user_info = $user_info_result->fetch_assoc();
                $user_info_query->close();

                $EMAIL = $user_info['EMAIL'] ?? null;

                // 동명이인 처리
                if ($emp_name == '김대현') {
                    $EMAIL = 'kdh@iwin.kr';
                }

                if (!$EMAIL) {
                    error_log("Project task mailer: Email not found for user {$emp_name}.");
                    continue; // 다음 사용자로 넘어감
                }

                // 2-2. 이메일 컨텐츠 생성을 위한 데이터 조회
                $queries = [
                    'UserTodolist' => "SELECT e.nm_project, d.work_name, b.job_name, a.detail_contents, a.process_rate, b.end_date FROM t_pr_job_user c LEFT JOIN t_pr_job_detail a ON c.job_seq=a.job_seq LEFT JOIN t_pr_job b ON a.job_seq=b.job_seq LEFT JOIN t_pr_work d ON b.work_seq=d.work_seq LEFT JOIN t_pr_project_main e ON d.prj_seq=e.no_project WHERE c.emp_name='{$emp_name}' AND a.use_yn='Y' AND a.process_rate!='100' AND b.end_date>='{$Hyphen_today}' AND b.end_date<='{$Plus6Day}' AND e.ed_project>='{$Hyphen_today}'",
                    'UserTodolist2' => "SELECT 1 FROM t_pr_job_user c LEFT JOIN t_pr_job_detail a ON c.job_seq=a.job_seq LEFT JOIN t_pr_job b ON a.job_seq=b.job_seq LEFT JOIN t_pr_work d ON b.work_seq=d.work_seq LEFT JOIN t_pr_project_main e ON d.prj_seq=e.no_project WHERE c.emp_name='{$emp_name}' AND a.use_yn='Y' AND e.ed_project>='{$Hyphen_today}'",
                    'UserTodolist3' => "SELECT 1 FROM t_pr_job_user c LEFT JOIN t_pr_job_detail a ON c.job_seq=a.job_seq LEFT JOIN t_pr_job b ON a.job_seq=b.job_seq LEFT JOIN t_pr_work d ON b.work_seq=d.work_seq LEFT JOIN t_pr_project_main e ON d.prj_seq=e.no_project WHERE c.emp_name='{$emp_name}' AND a.use_yn='Y' AND a.process_rate!='100' AND a.process_rate!='0' AND e.ed_project>='{$Hyphen_today}'",
                    'UserTodolist4' => "SELECT e.nm_project, d.work_name, b.job_name, a.detail_contents, a.process_rate, b.end_date FROM t_pr_job_user c LEFT JOIN t_pr_job_detail a ON c.job_seq=a.job_seq LEFT JOIN t_pr_job b ON a.job_seq=b.job_seq LEFT JOIN t_pr_work d ON b.work_seq=d.work_seq LEFT JOIN t_pr_project_main e ON d.prj_seq=e.no_project WHERE c.emp_name='{$emp_name}' AND a.use_yn='Y' AND a.process_rate!='100' AND b.end_date<'{$Hyphen_today}' AND e.ed_project>='{$Hyphen_today}'",
                    'UserTodolist5' => "SELECT 1 FROM t_pr_job_user c LEFT JOIN t_pr_job_detail a ON c.job_seq=a.job_seq LEFT JOIN t_pr_job b ON a.job_seq=b.job_seq LEFT JOIN t_pr_work d ON b.work_seq=d.work_seq LEFT JOIN t_pr_project_main e ON d.prj_seq=e.no_project WHERE c.emp_name='{$emp_name}' AND a.use_yn='Y' AND a.process_rate='0' AND e.ed_project>='{$Hyphen_today}'",
                    'UserTodolist6' => "SELECT 1 FROM t_pr_job_user c LEFT JOIN t_pr_job_detail a ON c.job_seq=a.job_seq LEFT JOIN t_pr_job b ON a.job_seq=b.job_seq LEFT JOIN t_pr_work d ON b.work_seq=d.work_seq LEFT JOIN t_pr_project_main e ON d.prj_seq=e.no_project WHERE c.emp_name='{$emp_name}' AND a.use_yn='Y' AND a.process_rate='100' AND e.ed_project>='{$Hyphen_today}'"
                ];

                $results = [];
                $counts = [];
                foreach ($queries as $key => $query) {
                    $result = $connect3->query($query);
                    if (!$result) {
                        error_log("Project task mailer SQL Error for user {$emp_name}: " . $connect3->error . " (Query: {$query})");
                        continue 2; // Skip to the next user
                    }
                    $results[$key] = $result;
                    $counts[$key] = $result->num_rows;
                }
                
                $Count_UserTodolist = $counts['UserTodolist'];
                $Count_UserTodolist2 = $counts['UserTodolist2'];
                $Count_UserTodolist3 = $counts['UserTodolist3'];
                $Count_UserTodolist4 = $counts['UserTodolist4'];
                $Count_UserTodolist5 = $counts['UserTodolist5'];
                $Count_UserTodolist6 = $counts['UserTodolist6'];

                $progress_rate = ($Count_UserTodolist2 > 0) ? round($Count_UserTodolist6 * 100 / $Count_UserTodolist2) : 0;

                // 임박 태스크 목록 HTML 생성
                $imminent_tasks_html = '';
                if ($Count_UserTodolist > 0) {
                    while ($task = $results['UserTodolist']->fetch_assoc()) {
                        $imminent_tasks_html .= '<tr style="text-align: center; vertical-align: middle;">
                            <td>' . htmlspecialchars($task['nm_project'] ?? '') . '</td>
                            <td>' . htmlspecialchars($task['work_name'] ?? '') . '</td>
                            <td>' . htmlspecialchars($task['job_name'] ?? '') . '</td>
                            <td>' . htmlspecialchars($task['detail_contents'] ?? '') . '</td>
                            <td>' . htmlspecialchars($task['process_rate'] ?? '') . '%</td>
                            <td>' . htmlspecialchars(substr($task['end_date'] ?? '', 0, 10)) . '</td>
                        </tr>';
                    }
                } else {
                    $imminent_tasks_html = '<tr><td colspan="6" style="text-align: center;">마감일이 임박한 태스크가 없습니다.</td></tr>';
                }

                // 초과 태스크 목록 HTML 생성
                $overdue_tasks_html = '';
                if ($Count_UserTodolist4 > 0) {
                    while ($task = $results['UserTodolist4']->fetch_assoc()) {
                        $overdue_tasks_html .= '<tr style="text-align: center; vertical-align: middle; background-color: #ffebee;">
                            <td>' . htmlspecialchars($task['nm_project'] ?? '') . '</td>
                            <td>' . htmlspecialchars($task['work_name'] ?? '') . '</td>
                            <td>' . htmlspecialchars($task['job_name'] ?? '') . '</td>
                            <td>' . htmlspecialchars($task['detail_contents'] ?? '') . '</td>
                            <td>' . htmlspecialchars($task['process_rate'] ?? '') . '%</td>
                            <td>' . htmlspecialchars(substr($task['end_date'] ?? '', 0, 10)) . '</td>
                        </tr>';
                    }
                } else {
                    $overdue_tasks_html = '<tr><td colspan="6" style="text-align: center;">마감일이 초과된 태스크가 없습니다.</td></tr>';
                }

                // 최종 이메일 본문 HTML 조합
                $contentHtml = <<<HTML
                <p><strong>{$emp_name}님, 안녕하세요.</strong><br>마감일이 다가오거나 초과된 업무 목록을 알려드립니다.</p>
                
                <table style="width: 100%; border-collapse: collapse; font-size: 14px; margin-bottom: 20px;">
                    <tr style="text-align: center;">
                        <td style="border: 1px solid #dddddd; padding: 8px;"><strong>총 진행률</strong><br>{$progress_rate}%</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><strong>대기중</strong><br>{$Count_UserTodolist5}건</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;"><strong>진행중</strong><br>{$Count_UserTodolist3}건</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; color: #d9534f;"><strong>마감 임박</strong><br>{$Count_UserTodolist}건</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; color: #d9534f; font-weight: bold;"><strong>마감 초과</strong><br>{$Count_UserTodolist4}건</td>
                    </tr>
                </table>

                <h4 style="margin-top: 25px; margin-bottom: 10px; border-bottom: 2px solid #055AAF; padding-bottom: 5px;">마감 임박 태스크 ({$Count_UserTodolist}건)</h4>
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <thead style="background-color: #f8f9fc;">
                        <tr>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">프로젝트</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">업무</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">할일</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">내용</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">진척도</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">마감일</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$imminent_tasks_html}
                    </tbody>
                </table>

                <h4 style="margin-top: 25px; margin-bottom: 10px; border-bottom: 2px solid #d9534f; padding-bottom: 5px;">마감 초과 태스크 ({$Count_UserTodolist4}건)</h4>
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <thead style="background-color: #f8f9fc;">
                        <tr>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">프로젝트</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">업무</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">할일</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">내용</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">진척도</th>
                            <th style="border: 1px solid #dddddd; padding: 8px; text-align: center;">마감일</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$overdue_tasks_html}
                    </tbody>
                </table>
HTML;

                // 2-3. 메일 발송
                $to = $EMAIL;
                $subject = '[FMS] 업무관리 알림: ' . $emp_name . '님';
                $systemName = '업무관리 시스템';
                $title = '주간 태스크 현황';
                $link = 'https://gw.iwin.kr';
                
                $body = build_email_template($systemName, $title, $contentHtml, $link, '업무관리 페이지로 이동', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    echo "Project task notice sent to {$emp_name} ({$to}).<br>";
                    $users_emailed++;
                } else {
                    echo "Failed to send project task notice to {$emp_name} ({$to}).<br>";
                }
            }

            echo "Finished sending notices. Total emails sent: {$users_emailed}.";

            if(isset($connect)) { $connect->close(); }
            if(isset($connect3)) { $connect3->close(); }
            break;

        // ===================================
        // 윤리 캠페인 안내 메일
        // ===================================
        case 'ethics_campaign_notice':
            $to = ['hr@iwin.kr', 'test@iwin.kr', 'design@iwin.kr', 'qc@iwin.kr', 'ir@iwin.kr', 'sales@iwin.kr', 'order@iwin.kr'];
            $subject = '[FMS] 내부회계관리 - 윤리 캠페인';
            $systemName = '윤리 캠페인';
            $title = '안내';
            $contentHtml = <<<HTML
            <p style="margin-top: 8px;">우리 회사는 윤리경영 실천을 위해, 윤리강령규정 및 윤리행동지침이 그룹웨어 및 홈페이지에 게시되어 있습니다.</p>
            <p style="margin-top: 8px;">또한, 윤리적 문제나 위반 사항에 대해 제보할 수 있는 사내 익명게시판(내부고발)을 운영 중이오니 많은 관심과 활용 바랍니다.</p>
            <p style="margin-top: 20px;"><strong>참고사항)</strong></p>
            <ol style="padding-left: 20px; line-height: 1.6;">
                <li><strong>윤리강령 및 행동지침 열람</strong><br>
                    그룹웨어 &gt; 게시판 &gt; 사내게시판 &gt; 공지함 &gt; 4. 규정</li>
                <li><strong>익명게시판(내부고발) 이용</strong><br>
                    그룹웨어 &gt; 게시판 &gt; 사내게시판 &gt; 공지함 &gt; 6. 익명게시판(내부고발)</li>
                <li><strong>보안 및 익명성 보장 안내</strong><br>
                    익명게시판은 경영팀만 열람 가능하며, 임원 및 타 부서에서는 열람할 수 없습니다.<br>
                    작성자의 익명성은 철저히 보장됩니다.
                </li>
            </ol>
HTML;
            $link = 'https://gw.iwin.kr'; // Link to Groupware
            $body = build_email_template($systemName, $title, $contentHtml, $link, '그룹웨어 바로가기', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Ethics campaign notice sent successfully.";
            } else {
                echo "Failed to send ethics campaign notice.";
            }
            break;

        // ===================================
        // 안전 신문고 접수 알림
        // ===================================
        case 'safety_report':
            $r_location = htmlspecialchars($_POST["risk_location"] ?? '', ENT_QUOTES, 'UTF-8');
            $r_title = htmlspecialchars($_POST["risk_title"] ?? '', ENT_QUOTES, 'UTF-8');
            $r_content = nl2br(htmlspecialchars($_POST["risk_content"] ?? '', ENT_QUOTES, 'UTF-8'));
            $r_reporter = htmlspecialchars($_POST["reporter"] ?? '익명', ENT_QUOTES, 'UTF-8');

            $to = ['hr@iwin.kr', 'hjjin@iwin.kr', 'gmkim@iwin.kr', 'dykim@iwin.kr', 'jsyoon@iwin.kr'];
            $subject = '[FMS] 안전 신문고 제보가 접수되었습니다.';
            $systemName = '안전 신문고';
            $title = '접수내용';

            $contentHtml = <<<HTML
            <p>새로운 위험요소 신고가 접수되었습니다.</p>
            <table style="width: 100%; border-collapse: collapse; font-size: 14px; margin-top: 10px;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold; width: 30%; background-color: #f8f9fc;">발견 장소</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{$r_location}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold; background-color: #f8f9fc;">제목</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{$r_title}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold; background-color: #f8f9fc;">신고자</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{$r_reporter}</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold; background-color: #f8f9fc;">상세 내용</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 15px; border: 1px solid #dee2e6;">{$r_content}</td>
                </tr>
            </table>
HTML;
            $link = 'https://fms.iwin.kr/kjwt_safety/safety.php?tab=tab4';
            $body = build_email_template($systemName, $title, $contentHtml, $link, '신문고 확인하기', $logoCid);

            if (send_system_email($to, $subject, $body, $embeddedImages)) {
                echo "Safety report email sent.";
            } else {
                echo "Failed to send safety report email.";
            }
            break;

        // ===================================
        // [수정] 기술지원 요청 등록 (Todolist)
        // ===================================
        case 'todolist_regist':
            // 로그: 요청 도착 확인
            error_log("[Mailer] todolist_regist requested. param no=" . ($_POST['no'] ?? 'null'));

            include_once __DIR__ . '/DB/DB2.php'; // MSSQL ($connect)
            include_once __DIR__ . '/DB/DB4.php'; // MySQL ($connect4)

            $no = $_POST['no'] ?? null;
            if (!$no) { 
                error_log("[Mailer] No ID provided.");
                break; 
            }

            // 1. 게시글 정보 조회 (MSSQL)
            if (!isset($connect)) { error_log("[Mailer] MSSQL connection failed."); break; }
            
            $query_list = "SELECT * FROM CONNECT.dbo.TO_DO_LIST WHERE NO = ?";
            $stmt = sqlsrv_query($connect, $query_list, [$no]);
            
            if ($stmt === false) {
                error_log("[Mailer] MSSQL Query Error: " . print_r(sqlsrv_errors(), true));
                break;
            }
            
            $data_list = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if (!$data_list) { 
                error_log("[Mailer] Post not found in MSSQL (NO: {$no})"); 
                break; 
            }

            // 2. 요청자 정보 조회 (MySQL - DB4.php 사용)
            if (!isset($connect4)) { error_log("[Mailer] MySQL connection failed."); break; }

            $query_user = "SELECT EMAIL, `CALL` FROM user_info WHERE USER_NM = ?";
            $stmt_user = $connect4->prepare($query_user);
            
            if (!$stmt_user) {
                error_log("[Mailer] MySQL Prepare Error: " . $connect4->error);
                break;
            }

            $stmt_user->bind_param("s", $data_list['REQUESTOR']);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            $data_user = $result_user->fetch_object();

            if ($data_user && !empty($data_user->EMAIL)) {
                $h = 'htmlspecialchars';
                $fileHtml = '';
                
                // [첨부파일 링크 처리]
                if (!empty($data_list['FILE_NM'])) {
                    // 다운로드 링크에도 자동 로그인 키 추가
                    $fileUrl = 'https://fms.iwin.kr/files/' . $h($data_list['FILE_NM']) . '?mail_key=' . MAIL_MAGIC_KEY;
                    $fileHtml = "<tr><td style='border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold;'>첨부파일</td><td colspan='3' style='border: 1px solid #dddddd; padding: 8px;'><a href='{$fileUrl}' target='_blank'>파일 보기</a></td></tr>";
                }
                
                $requestor = $h($data_list['REQUESTOR']);
                $reqDate = $data_list['SORTING_DATE'] ? $h($data_list['SORTING_DATE']->format('Y-m-d')) : '';

                // [수정] 줄바꿈 처리를 위해 변수에 nl2br 적용
                $problem_html = nl2br($h($data_list['PROBLEM']));

                $contentHtml = <<<HTML
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; width: 15%; text-align: center;">NO</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; width: 35%;">{$h((string)$data_list['NO'])}</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; width: 15%; text-align: center;">요청일</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; width: 35%;">{$reqDate}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; text-align: center;">요청자</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">{$requestor}</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; text-align: center;">연락처</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">{$h($data_user->CALL)}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; text-align: center;">분류</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">{$h($data_list['KIND'])}</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; text-align: center;">중요도</td>
                        <td style="border: 1px solid #dddddd; padding: 8px;">{$h($data_list['IMPORTANCE'])}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; text-align: center;">내용</td>
                        <td colspan="3" style="border: 1px solid #dddddd; padding: 8px;">{$problem_html}</td>
                    </tr>
                    {$fileHtml}
                </table>
HTML;
                // 수신자 설정
                $recipients = [$data_user->EMAIL, 'skkwon@iwin.kr'];
                
                $subject = "[FMS] 기술지원 & 문의 등록 - NO. " . $no;
                $systemName = '기술지원 요청';
                $title = '신규 요청 접수';
                
                // [수정] 메인 링크 생성 (자동 로그인 키는 build_email_template 함수가 처리함)
                $link = 'https://fms.iwin.kr/kjwt_todolist/todolist.php';

                $body = build_email_template($systemName, $title, $contentHtml, $link, '바로가기', $logoCid);

                if (send_system_email($recipients, $subject, $body, $embeddedImages)) {
                    error_log("[Mailer] Success: Mail sent to " . implode(', ', $recipients));
                    echo "Todolist regist mail sent.";
                } else {
                    error_log("[Mailer] Fail: send_system_email returned false.");
                    echo "Failed to send todolist regist mail.";
                }
            } else {
                error_log("[Mailer] User info not found for requestor: " . $data_list['REQUESTOR']);
            }
            
            if(isset($connect)) sqlsrv_close($connect);
            if(isset($connect4)) $connect4->close();
            break;

        // ===================================
        // [수정] 기술지원 처리 완료 (Todolist)
        // ===================================
        case 'todolist_finish':
            error_log("[Mailer] todolist_finish requested. param no=" . ($_POST['no'] ?? 'null'));

            include_once __DIR__ . '/DB/DB2.php'; // MSSQL ($connect)
            include_once __DIR__ . '/DB/DB4.php'; // MySQL ($connect4)

            $no = $_POST['no'] ?? null;
            if (!$no) { error_log("[Mailer] No ID."); break; }

            // 1. 게시글 조회
            $query_list = "SELECT * FROM CONNECT.dbo.TO_DO_LIST WHERE NO = ?";
            $stmt = sqlsrv_query($connect, $query_list, [$no]);
            if ($stmt === false) {
                 error_log("[Mailer] MSSQL Query Error: " . print_r(sqlsrv_errors(), true));
                 break; 
            }
            $data_list = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if (!$data_list) { error_log("[Mailer] Post not found."); break; }

            // 2. 요청자 조회
            $query_user = "SELECT EMAIL, `CALL` FROM user_info WHERE USER_NM = ?";
            $stmt_user = $connect4->prepare($query_user);
            $stmt_user->bind_param("s", $data_list['REQUESTOR']);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            $data_user = $result_user->fetch_object();

            if ($data_user && !empty($data_user->EMAIL)) {
                $h = 'htmlspecialchars';

                // [수정] 줄바꿈 처리를 위해 변수에 nl2br 적용
                $problem_html = nl2br($h($data_list['PROBLEM']));
                $solution_html = nl2br($h($data_list['SOLUTUIN']));

                $contentHtml = <<<HTML
                <p>요청하신 기술지원 건이 처리되었습니다.</p>
                <table style="width: 100%; border-collapse: collapse; font-size: 14px; margin-top: 10px;">
                    <tr>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; width: 15%; text-align: center;">NO</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; width: 35%;">{$h((string)$data_list['NO'])}</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; width: 15%; text-align: center;">완료일</td>
                        <td style="border: 1px solid #dddddd; padding: 8px; width: 35%;">{$h(date('Y-m-d'))}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #f2f2f2; font-weight: bold; text-align: center;">요청내용</td>
                        <td colspan="3" style="border: 1px solid #dddddd; padding: 8px;">{$problem_html}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #dddddd; padding: 8px; background-color: #e2e6ea; font-weight: bold; text-align: center; color: #055AAF;">처리결과</td>
                        <td colspan="3" style="border: 1px solid #dddddd; padding: 8px; font-weight: bold;">{$solution_html}</td>
                    </tr>
                </table>
HTML;
                $to = $data_user->EMAIL;
                $subject = "[FMS] 기술지원 & 문의 처리완료 - NO. " . $no;
                $systemName = '기술지원 완료';
                $title = '처리 완료 안내';
                
                // [수정] 메인 링크 생성 (자동 로그인 키는 build_email_template 함수가 처리함)
                $link = 'https://fms.iwin.kr/kjwt_todolist/todolist.php';

                $body = build_email_template($systemName, $title, $contentHtml, $link, '확인하기', $logoCid);

                if (send_system_email($to, $subject, $body, $embeddedImages)) {
                    error_log("[Mailer] Finish mail sent to " . $to);
                    echo "Todolist finish mail sent.";
                } else {
                    error_log("[Mailer] Fail: send_system_email returned false.");
                    echo "Failed to send todolist finish mail.";
                }
            } else {
                error_log("[Mailer] User info not found for finish alert: " . $data_list['REQUESTOR']);
            }
            if(isset($connect)) sqlsrv_close($connect);
            if(isset($connect4)) $connect4->close();
            break;


        default:
            http_response_code(400);
            error_log("Invalid mail type specified: " . $mail_type);
            break;
    }