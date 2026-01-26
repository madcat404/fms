<?php
// =============================================
// Author: <KWON SUNG KUN - sealclear@naver.com>
// Create date: <22.03.22>
// Description: <그룹웨어 세계시간 뷰어>
// Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
// =============================================
// ★★★ [보안 강화] 외부/내부 접속 구분 및 도메인 검증 시작 ★★★
    
    // 1. 설정: 허용할 외부 홈페이지 도메인 (반드시 실제 운영 중인 홈페이지 주소로 변경하세요)
    // 예: 홈페이지가 www.kjwt.co.kr 이라면 아래 배열에 넣습니다.
    $allowed_referers = [
        'gw.iwin.kr'
    ];

    // 2. 설정: 외부 iframe 호출 시 사용할 보안 키
    $public_access_key = "iwin_public_secure"; 

    // 3. 검증 로직
    $is_public_view = false;
    $input_token = $_GET['token'] ?? '';
    $http_referer = $_SERVER['HTTP_REFERER'] ?? ''; // 요청이 어디서 왔는지 확인

    // 토큰이 일치하는지 확인
    if ($input_token === $public_access_key) {
        
        // 리퍼러(접속 경로) 검증: 주소창에 직접 입력(null)하거나 다른 곳에서 링크 건 경우 차단
        $is_valid_origin = false;
        foreach ($allowed_referers as $domain) {
            if (strpos($http_referer, $domain) !== false) {
                $is_valid_origin = true;
                break;
            }
        }

        // 토큰도 맞고, 우리 홈페이지에서 온 요청이 맞다면 공개 모드 활성화
        if ($is_valid_origin) {
            $is_public_view = true;
        }
    }

    // 4. 내부 접속(공개 모드가 아님)일 경우에만 세션 체크 실행
    // 리퍼러가 없거나(직접 입력), 토큰이 틀리면 무조건 로그인 페이지로 튕김
    if (!$is_public_view) {
        try {
            require_once __DIR__ .'/../session/session_check.php';
        } catch (Exception $e) {
            die("Session check failed.");
        }
    }
    // ★★★ [보안 강화] 로직 끝 ★★★

include_once __DIR__ . '/../FUNCTION.php';

// --- Data and Configuration ---

// Central configuration for all locations
$locations = [
    'korea' => [
        'flag' => 'flag_k.png',
        'timezone' => 'Asia/Seoul',
        'address' => [
            "부산광역시 기장군 장안읍 장안산단",
            "9로 110, 아이윈",
            "우편번호: 46034",
            "TEL. 051-711-2222",
            "FAX. 051-790-2525",
        ],
        'schedule_kst' => [
            'work' => [['08:30', '10:29'], ['10:41', '12:29'], ['13:31', '15:29'], ['15:41', '17:30']],
            'break' => [['10:30', '10:40'], ['12:30', '13:30'], ['15:30', '15:40']],
        ],
        'schedule_info' => [
            "근무시간 : 08:30 ~ 17:30",
            "쉬는시간(오전) : 10:30 ~ 10:40",
            "쉬는시간(오후) : 15:30 ~ 15:40",
            "점심시간 : 12:30 ~ 13:30",
        ]
    ],
    'vietnam' => [
        'flag' => 'flag_v.png',
        'timezone' => 'Asia/Ho_Chi_Minh',
        'address' => [
            "IWIN VIETNAM CO., LTD.",
            "BEAUTIFUL CITY CORP INDUSTRIAL",
            "COMPLEX, ONG DONG QUARTER,",
            "TAN HIEP WARD, HOCHIMINH CITY,",
            "VIETNAM",
            "zip code. 822460",
            "TEL. 84-274-6258-328",
            "FAX. 84-274-6258-324",
        ],
        'schedule_kst' => [
            'work_day' => [['10:00', '11:59'], ['12:11', '13:59'], ['15:01', '16:59'], ['17:11', '19:30'], ['20:01', '23:00']],
            'break_day' => [['12:00', '12:10'], ['14:00', '15:00'], ['17:00', '17:10'], ['19:30', '20:00']],
            'work_night' => [['23:00', '23:59'], ['00:00', '01:00'], ['01:16', '03:00'], ['04:01', '06:00'], ['06:16', '08:00'], ['08:11', '10:00']],
            'break_night' => [['01:01', '01:15'], ['03:01', '04:00'], ['06:01', '06:15'], ['08:01', '08:10']],
        ],
        'schedule_info' => [
            "(한국시간 기준)",
            "- 주간",
            "근무시간 : 10:00 ~ 23:00",
            "쉬는시간(주간1) : 12:00 ~ 12:10",
            "점심시간 : 14:00 ~ 15:00",
            "쉬는시간(주간2) : 17:00 ~ 17:10",
            "석식시간 : 19:30 ~ 20:00",
            "- 야간",
            "근무시간 : 23:00 ~ 10:00",
            "쉬는시간(야간1) : 01:00 ~ 01:15",
            "쉬는시간(야간2) : 03:00 ~ 04:00",
            "쉬는시간(야간3) : 06:00 ~ 06:15",
            "쉬는시간(야간4) : 08:00 ~ 08:10",
        ]
    ],
    'china' => [
        'flag' => 'flag_c.png',
        'timezone' => 'Asia/Shanghai',
        'address' => [
            "北京市顺义区南彩镇顺平辅路181",
            "号路星公司院内运动中心3号厅.",
            "Hall 3, Sports Center, Star Company,",
            "No. 181 Shunpingfu Road, Nancai",
            "Town, Shunyi District, Bei Jing,China",
            "zip code. 101300",
            "TEL. 86-10-8947-3752",
            "FAX. 86-10-8947-3753",
        ],
        'schedule_kst' => [
            'work' => [['09:00', '10:59'], ['11:11', '12:54'], ['13:56', '15:54'], ['16:06', '17:50']],
            'break' => [['11:00', '11:10'], ['12:55', '13:55'], ['15:55', '16:05']],
        ],
        'schedule_info' => [
            "(한국시간 기준)",
            "근무시간 : 09:00 ~ 17:50",
            "쉬는시간(오전) : 11:00 ~ 11:10",
            "쉬는시간(오후) : 15:55 ~ 16:05",
            "점심시간 : 12:55 ~ 13:50",
        ]
    ],
    'slovakia' => [
        'flag' => 'flag_s.png',
        'timezone' => 'Europe/Bratislava',
        'address' => [
            "KWANGJIN WINTEC SLOVAKIA",
            "S.R.O., PAVLA MUDRONA 5, 010",
            "01 ZILINA, SLOVAKIA",
            "zip code. 01001",
            "TEL. +421 41 3247 291",
        ],
        'schedule_kst' => [
            'work' => [['12:30', '15:29'], ['15:41', '16:29'], ['17:31', '19:29'], ['19:41', '21:30']],
            'break' => [['15:30', '15:40'], ['16:30', '17:30'], ['19:30', '19:40']],
        ],
        'schedule_info' => [
            "(한국시간 기준)",
            "근무시간 : 12:30 ~ 9:30 오전",
            "쉬는시간(오전) : 03:30 ~ 03:40",
            "쉬는시간(오후) : 07:30 ~ 07:40",
            "점심시간 : 04:30 ~ 05:30",
        ]
    ],
    'usa' => [
        'flag' => 'flag_a.png',
        'timezone' => 'America/Chicago',
        'address' => [
            "KJ USA INC.",
            "1305 WILBANKS STREET,",
            "MONTGOMERY, AL 36108",
            "zip code. 36108",
            "TEL. 334 652 2386",
            "FAX. 334 819 8695",
        ],
        'schedule_kst' => [
            'summertime_work' => [['21:30', '23:59'], ['00:00', '07:00']],
            'summertime_off' => [['07:01', '21:29']],
            'wintertime_work' => [['22:30', '23:59'], ['00:00', '08:00']],
            'wintertime_off' => [['08:01', '22:29']],
        ],
        'schedule_info' => [
            "(한국시간 기준)",
            "- 서머타임 적용 시 : 21:30 ~ 07:00",
            "- 서머타임 해제 시 : 22:30 ~ 08:00",
            "쉬는시간, 점심시간 : 정해진것 없음",
            "* 썸머타임",
            ": 매년 3월 2주차부터 11월",
            "  1주차까지 한시간씩 앞당겨짐",
            "* 2025.03.09~2025.11.02",
        ]
    ],
];

// --- Helper Functions ---

/**
 * Determines the current work status (work, break, off) based on time ranges.
 * @param string $now_hm - Current time in 'H:i' format.
 * @param array $schedule - Array of time ranges for different statuses.
 * @return string - CSS color class.
 */
function get_status_color(string $now_hm, array $schedule): string
{
    foreach (['work', 'break', 'work_day', 'break_day', 'work_night', 'break_night'] as $status_type) {
        if (isset($schedule[$status_type])) {
            foreach ($schedule[$status_type] as $range) {
                if ($now_hm >= $range[0] && $now_hm <= $range[1]) {
                    if (str_contains($status_type, 'work')) return '#00B050'; // Green for work
                    if (str_contains($status_type, 'break')) return '#FFC000'; // Yellow for break
                }
            }
        }
    }
    
    // Special handling for Vietnam night shift
    if (isset($schedule['work_night'])) {
        $is_night_shift_time = false;
        foreach ($schedule['work_night'] as $range) {
            if ($now_hm >= $range[0] && $now_hm <= $range[1]) $is_night_shift_time = true;
        }
        foreach ($schedule['break_night'] as $range) {
            if ($now_hm >= $range[0] && $now_hm <= $range[1]) $is_night_shift_time = true;
        }
        if ($is_night_shift_time) return '#058DF6'; // Blue for night shift
    }

    return '#FF0000'; // Red for off-hours
}

/**
 * Renders a location card with its time and status.
 * @param array $location - The configuration array for a single location.
 * @param DateTimeImmutable $now_utc - The current time in UTC.
 */
function render_location_card(array $location, DateTimeImmutable $now_utc)
{
    $local_time = $now_utc->setTimezone(new DateTimeZone($location['timezone']));
    $kst_time = $now_utc->setTimezone(new DateTimeZone('Asia/Seoul'));
    $now_hm_kst = $kst_time->format('H:i');

    $color = '#FF0000'; // Default to off-hours

    if ($location['timezone'] === 'America/Chicago') {
        $is_summertime = SummerTime($location['timezone']);
        $work_key = $is_summertime ? 'summertime_work' : 'wintertime_work';
        $is_working = false;
        foreach($location['schedule_kst'][$work_key] as $range) {
            if ($now_hm_kst >= $range[0] && $now_hm_kst <= $range[1]) {
                $is_working = true;
                break;
            }
        }
        $color = $is_working ? '#00B050' : '#FF0000';
    } else {
        $schedule = $location['schedule_kst'];
        $color = get_status_color($now_hm_kst, $schedule);
    }
    
    $address_html = implode("<br>", $location['address']);
    $schedule_html = implode("<br>", $location['schedule_info']);

    echo <<<HTML
    <div class="col-xl-2-5 col-md-2-5 mr-3">
        <div class="card border-left shadow h-100">
            <div class="card-body mt-2 ml-2">
                <div class="row no-gutters align-items-center">
                    <div class="col" style="text-align: left;">
                        <img src="../img/{$location['flag']}" style="width: 4.2em;">
                    </div>
                    <div class="col">
                        <div class="h6 mb-0 ml-2 font-weight-bold text-800" style="color: {$color};">
                            {$local_time->format('m-d')}<br>{$local_time->format('H:i')}
                        </div>
                    </div>
                </div>
                <br>
                <p style="font-size: 10px; padding-top: 1px;">
                    {$address_html}<br><br>
                    {$schedule_html}
                </p>
            </div>
        </div>
    </div>
HTML;
}

$now_utc = new DateTimeImmutable("now", new DateTimeZone("UTC"));

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php require_once __DIR__ . '/../head_lv1.php'; ?>
</head>
<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid pt-3">
                    <div class="row justify-content-center">
                        <?php
                        // Adjust the order of locations for display
                        $display_order = ['korea', 'vietnam', 'china', 'slovakia', 'usa'];
                        foreach ($display_order as $key) {
                            if (isset($locations[$key])) {
                                render_location_card($locations[$key], $now_utc);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once __DIR__ . '/../plugin_lv1.php'; ?>
</body>
</html>
