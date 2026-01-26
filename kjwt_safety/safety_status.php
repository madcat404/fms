<?php
// kjwt_safety/safety_status.php
// 백엔드 로직: DB 연결, 데이터 저장(POST), 데이터 조회(GET)

// 1. DB 연결 및 설정
if (!file_exists('../DB/DB2.php')) {
    die("<div class='alert alert-danger'>DB 설정 파일이 없습니다. (../DB/DB2.php)</div>");
}
require_once __DIR__ . '/../session/session_check.php';
include_once __DIR__ . '/../DB/DB2.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. 공통 변수 및 파라미터 처리
$current_date = date('Y-m-d'); 
$location_param = isset($_GET['loc']) ? $_GET['loc'] : '';
$search_date = isset($_GET['search_date']) && !empty($_GET['search_date']) ? $_GET['search_date'] : $current_date;

$SELF = $_SERVER['PHP_SELF'];

// View로 넘겨줄 변수 초기화
$check_data = [];
$saved_note = '';
$saved_writer = '';
$safety_law_data = [];
$safety_board_data = [];

// -----------------------------------------------------------
// [POST] 데이터 저장 처리
// -----------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode'])) {
    
    // Mode 1: 체크리스트 저장 (일별)
    if ($_POST['mode'] === 'save') {
        $p_date = $_POST['check_date'];
        $p_location = $_POST['location'];
        $p_note = $_POST['note'] ?? '';
        $p_check_items = isset($_POST['check_item']) ? $_POST['check_item'] : [];
        
        $json_data = json_encode($p_check_items, JSON_UNESCAPED_UNICODE);
        $p_writer = $_SESSION['name'] ?? ($_SESSION['user_id'] ?? 'Guest');
        
        $return_url = $SELF . "?loc=" . urlencode($p_location) . "&search_date=" . urlencode($p_date) . "&tab=tab2";

        $sql_save = "
            MERGE INTO SAFETY AS target
            USING (SELECT ? AS CHECK_DATE, ? AS LOCATION) AS source
            ON (target.CHECK_DATE = source.CHECK_DATE AND target.LOCATION = source.LOCATION)
            WHEN MATCHED THEN
                UPDATE SET CHECK_DATA = ?, NOTE = ?, WRITER = ?, REG_DATE = GETDATE()
            WHEN NOT MATCHED THEN
                INSERT (CHECK_DATE, LOCATION, CHECK_DATA, NOTE, WRITER, REG_DATE)
                VALUES (?, ?, ?, ?, ?, GETDATE());
        ";
        $params_save = array($p_date, $p_location, $json_data, $p_note, $p_writer, $p_date, $p_location, $json_data, $p_note, $p_writer);
        
        if (sqlsrv_query($connect, $sql_save, $params_save) === false) {
            die("<div class='alert alert-danger'>저장 실패.<br>" . print_r(sqlsrv_errors(), true) . "</div>");
        } else {
            echo "<script>alert('점검 내용이 저장되었습니다.'); location.href = '$return_url';</script>";
            exit;
        }
    }
    
    // [중요 수정] Mode 2: 안전 신문고 신고 접수 + mailer.php 직접 연동
    if ($_POST['mode'] === 'report_save') {
        $r_location = $_POST['risk_location'];
        $r_title = $_POST['risk_title'];
        $r_content = $_POST['risk_content'];
        $r_reporter = !empty($_POST['reporter']) ? $_POST['reporter'] : '익명';
        
        $sql_report = "INSERT INTO SAFETY_BOARD (RISK_LOCATION, RISK_TITLE, RISK_CONTENT, REPORTER, STATUS, REG_DATE) VALUES (?, ?, ?, ?, '접수', GETDATE())";
        $params_report = array($r_location, $r_title, $r_content, $r_reporter);
        
        if (sqlsrv_query($connect, $sql_report, $params_report) === false) {
            die("<div class='alert alert-danger'>신고 접수 실패.</div>");
        } else {
            // --- mailer.php cURL 호출로 변경 ---
            $mailer_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/mailer.php';
            $post_data = [
                'type' => 'safety_report',
                'risk_location' => $r_location,
                'risk_title' => $r_title,
                'risk_content' => $r_content,
                'reporter' => $r_reporter,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $mailer_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // SSL 인증서 검증 건너뛰기 (내부 호출이므로)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            
            $mailer_response = curl_exec($ch);
            if(curl_errno($ch)){
                error_log('Safety Report Mailer cURL Error: ' . curl_error($ch));
            }
            curl_close($ch);
            // --- cURL 호출 종료 ---

            echo "<script>alert('안전 신문고 접수가 완료되었습니다.'); location.href = '$SELF?tab=tab4';</script>";
            exit;
        }
    }

    // Mode 3: 상태 변경
    if ($_POST['mode'] === 'status_update') {
        $p_id = $_POST['id'];
        $p_password = $_POST['password'];
        $p_comment = $_POST['comment'] ?? '';
        $admin_password = '1234';

        if ($p_password === $admin_password) {
            if (empty(trim($p_comment))) {
                echo "<script>alert('조치 내용을 입력해야 합니다.'); history.back();</script>";
                exit;
            }
            $sql_update = "UPDATE SAFETY_BOARD SET STATUS = '완료', COMMENT = ? WHERE ID = ?";
            $params_update = array($p_comment, $p_id);
            if (sqlsrv_query($connect, $sql_update, $params_update) === false) {
                echo "<script>alert('오류 발생: " . print_r(sqlsrv_errors(), true) . "'); history.back();</script>";
                exit;
            } else {
                echo "<script>alert('처리완료 상태로 변경되었습니다.'); location.href = '$SELF?tab=tab4';</script>";
                exit;
            }
        } else {
            echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
            exit;
        }
    }
}

// -----------------------------------------------------------
// [GET] 데이터 조회 처리 (원본 로직)
// -----------------------------------------------------------
if ($location_param) {
    $sql = "SELECT CHECK_DATA, NOTE, WRITER FROM SAFETY WHERE CHECK_DATE = ? AND LOCATION = ?";
    $params = array($search_date, $location_param);
    $stmt = sqlsrv_query($connect, $sql, $params);

    if ($stmt !== false) {
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $check_data = json_decode($row['CHECK_DATA'], true);
            if (!is_array($check_data)) $check_data = [];
            $saved_note = $row['NOTE'];
            $saved_writer = $row['WRITER'];
        }
    }
}

// 법적 제재 기준 조회
$sql_law = "SELECT LAW_TYPE, CATEGORY, PENALTY_CONTENT, LEGAL_BASIS, IS_APPLICABLE, ACTION_PLAN, EVIDENCE FROM SAFETY_LAW ORDER BY LAW_TYPE ASC, ID ASC";
$stmt_law = sqlsrv_query($connect, $sql_law);
if ($stmt_law !== false) {
    while ($row_law = sqlsrv_fetch_array($stmt_law, SQLSRV_FETCH_ASSOC)) {
        array_walk($row_law, function(&$value) { if ($value === null) $value = ''; });
        $safety_law_data[] = $row_law;
    }
}

// 안전 신문고 목록 조회
$sql_board = "SELECT TOP 20 ID, RISK_LOCATION, RISK_TITLE, RISK_CONTENT, REPORTER, STATUS, REG_DATE, COMMENT FROM SAFETY_BOARD ORDER BY ID DESC";
$stmt_board = sqlsrv_query($connect, $sql_board);
if ($stmt_board !== false) {
    while ($row_board = sqlsrv_fetch_array($stmt_board, SQLSRV_FETCH_ASSOC)) {
        $safety_board_data[] = $row_board;
    }
}

// 체크리스트 정의 (기존 유지)https://antigravity.google/
$checklist_items_map = [
    '시험실' => ['[인터록] 로봇팔 울타리 출입문을 열면 로봇이 즉시 멈추는가?', '[비상정지] 로봇 및 각 시험기의 비상정지 버튼을 눌렀을 때 즉각 동작이 멈추는가?', '[국소배기] 연소 시 발생하는 연기가 외부로 새어 나오지 않고 후드로 잘 빨려 나가는가?', '[가스누출] 누출경보기 점검을 실시했는가?', '[소화설비] 연소 시험기 옆 소화기가 비치되어 있고 압력은 정상인가?', '[과열방지] 설정 온도 이상으로 올라갔을때 자동으로 전원을 차단하는 과열 방지 장치가 설정되어 있는가?', '[화상주의] 항온항습기에 "고온주의" 경고 표지가 부착되어 있는가?', '[보호구] 적절한 보호구가 비치되어 있고 작업자가 착용하는가?', '[안전표지] 안전표지판과 비상시대처 요령은 게시가 되어 있는가?', '[작업통로] 작업통로 내부에 장애물 및 이물질 방치 유무'],
    '연구소' => ['[정리정돈] 책상 위, 통로, 바닥에 불필요한 물건이 방치되어 있는가?', '[출입구] 출입구 주변에 적재물이 쌓여 대피를 방해하지 않는가?', '[배선] 문어발식 배선을 사용하고 있지 않은가?', '[전선상태] 전선의 피복이 벗겨지거나 그을린 흔적이 없는가?'],
    '현장' => ['[비상정지] 스티칭기 \'비상정지 버튼\'이 정상 작동하는가?', '[화재예방] 부직포 롤 주변 및 기계 하부에 먼지나 오일이 쌓여 화재 위험은 없는가?', '[절단도구] 컷팅 시 작업자가 장갑을 착용하는가?', '[국소배기] 납땜 작업 시 덕트는 정상동작 하는가?', '[전기안전] 납땜 인두기와 열풍기의 전선 피복은 녹거나 벗겨진 곳이 없는가?', '[화상/화재] 인두기와 열풍기 미사용 시 전용 거치대에 안전하게 두는가?', '[보호구] 납땜 작업자가 방진 마스크를 올바르게 착용하고 있는가?', '[고열주의] 글루건 사용 시 화상 주의 표지가 부착되어 있고 글루건 노즐 상태는 양호한가?', '[방호장치] 광전자식 안전 센서가 정상 작동하는가?', '[조작방식] 양수 조작 버튼이 정상인가?', '[금형고정] 목형 조정 볼트가 풀려 있거나 유격이 발생하지 않는가?', '[이물질제거] 펀칭기 내부 이물질 제거 시 반드시 전원을 끄고 수공구를 사용하는가?', '[적재안전] 소화전이나 배전반 앞을 가리지 않도록 적재하였는가?'],
    '공무실' => ['[기계안전] 탁상 그라인더의 덮개는 부착되어 있고, 워크레스트(작업받침대)와 휠의 간격은 3mm 이내로 조정되어 있는가?', '[기계안전] 탁상 그라인더 사용 시 비산먼지나 파편을 막아주는 투명 보안판(Eye Shield)은 깨끗하게 유지되고 있는가?', '[수공구] 망치, 렌치, 드라이버 등 수공구의 손잡이가 깨지거나 헐거워 작업 중 빠질 위험은 없는가?', '[수공구] 연삭기류의 숯돌의 파송상태는 정상인가?', '[전기안전] 작업용 릴선(이동 전선)의 피복이 손상된 곳은 없으며, 반드시 접지형 콘센트를 사용하는가?', '[전기안전] 휴대용 전동공구(핸드 그라인더, 드릴)의 전원 코드 피복이 벗겨져 감전 위험은 없는가?', '[화학물질] WD-40, 세척제, 절삭유 등 소분 용기에 경고 표지(MSDS 스티커)가 부착되어 있는가?', '[화학물질] 락카 사용 시 보호구착용 및 개방된 공간에서 실시하는가?', '[정리정돈] 작업대 위에 날카로운 공구나 자재(볼트, 너트, 전선 등)가 어지럽게 방치되어 낙하할 위험은 없는가?'],
    '자재창고' => ['[적재설비] 랙(Rack)의 기둥이나 프레임이 지게차 충돌 등으로 휘거나 파손된 곳은 없는가?', '[적재방법] 무거운 자재는 하단에, 가벼운 자재는 상단에 적재(중량물 하부 원칙)하였는가?', '[낙하방지] 파레트나 자재가 랙 밖으로 불안정하게 튀어나와 낙하할 위험은 없는가?', '[통로확보] 지게차 이동 통로와 보행자 통로(구획선)에 자재가 방치되어 있지 않은가?', '[소방시설] 소화기나 소화전 앞을 자재로 가로막아 비상시 사용을 방해하고 있지 않은가?', '[화재예방] 박스, 비닐 등 포장 폐기물은 즉시 지정된 장소로 배출하여 화재 위험을 없앴는가?', '[전기안전] 배전반 문이 잘 닫혀 있고, 배전반 앞 1m 이내에 적재물이 없는가?', '[정리정돈] 바닥에 포장용 끈(밴딩끈), 오일, 물기 등이 방치되어 미끄러짐/전도 위험은 없는가?', '[추락예방] 이동식 사다리 작업 시 2인1조 공동작업실시 여부', '[보호구] 창고 내 작업 시 안전화 및 안전모(필요 시)를 올바르게 착용하고 있는가?', '[보호구] 안전모착용 유무, 안전대 및 추락방지용안전벨트 사용유무, 최상단작업유무,답단의 이물질 및 견고성유무'],
    'bb창고' => ['[외부환경] 외부 하역장의 바닥이 지게차 운행에 지장 없이 평탄하고(포트홀 등 없음) 결빙된 곳은 없는가?', '[신호수] 지게차와 보행자가 혼재하는 하역 작업 시 유도자(신호수)가 배치되어 있거나 통제 조치가 되었는가?', '[적재상태] 파레트 위의 박스들은 랩핑(Wrapping) 또는 밴딩 처리가 견고하여 이송 중 쏟아질 위험이 없는가?', '[파레트] 파레트 자체가 파손되거나 균열이 있어 랙 적재 시 붕괴될 위험은 없는가?', '[지게차] 지게차의 전조등, 후미등, 후진경보음 및 경광등(또는 후방감지기)이 정상 작동하는가?', '[지게차] 작업종료 후 정위치 및 key 분리조치 실시유무', '[랙설비] 랙의 기둥 보호대(Post Guard)가 설치되어 있고, 지게차 충돌로 인한 파손은 없는가?', '[낙하방지] 랙에 파레트를 넣을 때 빔 밖으로 불안정하게 튀어나오거나 비스듬하게 놓이지 않았는가?', '[충전설비] 충전 케이블의 피복이 벗겨져 있거나 커넥터 연결 부위가 파손되어 감전 위험은 없는가?', '[과열방지] 충전기 본체나 배터리에서 타는 냄새나 이상 발열이 발생하지 않는가?', '[충전구역] 충전 구역 주변에 가연성 물질(박스, 비닐 등)이 적치되어 있지 않으며 소화기가 바로 옆에 있는가?'],
    '완성품창고' => ['[적재하중] 랙의 선반(Shelf)이 박스 무게를 이기지 못해 아래로 처지거나 휘어져 있지 않은가?', '[설비안전] 랙의 프레임이나 기둥을 손으로 흔들었을 때 유격이 없이 바닥에 단단히 고정되어 있는가?', '[통로확보] 박스를 들고 이동하는 작업 동선에 걸려 넘어질 수 있는 이물질이나 포장 끈이 없는가?', '[보호구] 박스 모서리에 베이거나 미끄러지지 않도록 코팅 장갑을 착용하고 있는가?', '[보호구] 중량물 낙하에 대비하여 작업자는 안전화를 신고 있는가?', '[화재예방] 종이 박스가 밀집된 곳이므로 소화기 위치가 잘 보이고 접근이 쉬운가?', '[조명상태] 랙의 안쪽이나 하단까지 라벨과 적재 상태를 확인할 수 있도록 조명이 충분히 밝은가?', '[정리정돈] 파손되거나 찌그러진 박스를 랙에 그대로 적재하여 붕괴를 유발하고 있지 않은가?'],
    'ecu창고' => ['[근골격계] 하단부 박스를 들 때 허리만 굽히지 않고 무릎을 굽혀(스쿼트 자세) 작업하는가?', '[용기상태] 플라스틱 박스의 손잡이나 모서리가 깨져서 손을 베일 위험은 없는가?', '[적재상태] 플라스틱 박스의 결합 홈(Interlocking)이 파손되지 않아 흔들림 없이 견고하게 쌓여 있는가?', '[이동수단] 박스를 들고 이동하기보다 가능한 한 대차(Dolly)나 핸드카를 이용하여 운반하는가?', '[화재예방] 다량의 플라스틱 박스 보관 구역이므로 소화기가 즉시 사용할 수 있는 위치에 있는가?']
];

$current_items = isset($checklist_items_map[$location_param]) ? $checklist_items_map[$location_param] : [];
?>