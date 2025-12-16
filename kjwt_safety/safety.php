<?php
    // =============================================
    // Author: <User>
    // Create date: <2025-12-15>
    // Description: 안전 체크리스트 (상세 점검 항목 적용 완료)
    // =============================================

    // 에러 리포팅
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (!file_exists('../DB/DB2.php')) {
        die("<div class='alert alert-danger'>DB 설정 파일이 없습니다. (../DB/DB2.php)</div>");
    }
    include '../DB/DB2.php';
    include_once '../FUNCTION.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function e($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    $SELF = $_SERVER['PHP_SELF'];
    $is_mobile = isMobile();

    // 1. 파라미터 처리
    $current_month = date('Y-m');
    $location_param = isset($_GET['loc']) ? $_GET['loc'] : '';
    // 검색 월 (GET 파라미터가 최우선)
    $search_month = isset($_GET['search_month']) && !empty($_GET['search_month']) ? $_GET['search_month'] : $current_month;
    
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab1';
    $tab1_class = ($active_tab === 'tab1') ? 'active show' : '';
    $tab2_class = ($active_tab === 'tab2') ? 'active show' : '';

    // 2. 변수 초기화
    $check_data = [];
    $saved_note = '';
    $saved_writer = '';

    // 3. 데이터 조회 (SAFETY 테이블)
    if ($location_param) {
        $sql = "SELECT CHECK_DATA, NOTE, WRITER FROM SAFETY WHERE CHECK_MONTH = ? AND LOCATION = ?";
        $params = array($search_month, $location_param);
        
        $stmt = sqlsrv_query($connect, $sql, $params);

        if ($stmt === false) {
            die("조회 오류: " . print_r(sqlsrv_errors(), true));
        }

        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // JSON 처리
            $check_data = json_decode($row['CHECK_DATA'], true);
            if (!is_array($check_data)) $check_data = [];
            
            $saved_note = $row['NOTE'];
            $saved_writer = $row['WRITER'];
        }
    }

    // 4. 데이터 저장 로직 (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode']) && $_POST['mode'] === 'save') {
        $p_month = $_POST['check_month'];
        $p_location = $_POST['location'];
        $p_note = $_POST['note'] ?? '';
        $p_check_items = isset($_POST['check_item']) ? $_POST['check_item'] : [];
        
        $json_data = json_encode($p_check_items, JSON_UNESCAPED_UNICODE);
        $p_writer = $_SESSION['name'] ?? ($_SESSION['user_id'] ?? 'Guest');

        // 저장 후 리다이렉트
        $return_url = $SELF . "?loc=" . urlencode($p_location) . "&search_month=" . urlencode($p_month) . "&tab=tab2";

        $sql_save = "
            MERGE INTO SAFETY AS target
            USING (SELECT ? AS CHECK_MONTH, ? AS LOCATION) AS source
            ON (target.CHECK_MONTH = source.CHECK_MONTH AND target.LOCATION = source.LOCATION)
            WHEN MATCHED THEN
                UPDATE SET CHECK_DATA = ?, NOTE = ?, WRITER = ?, REG_DATE = GETDATE()
            WHEN NOT MATCHED THEN
                INSERT (CHECK_MONTH, LOCATION, CHECK_DATA, NOTE, WRITER, REG_DATE)
                VALUES (?, ?, ?, ?, ?, GETDATE());
        ";

        $params_save = array(
            $p_month, $p_location,
            $json_data, $p_note, $p_writer,
            $p_month, $p_location, $json_data, $p_note, $p_writer
        );

        $stmt_save = sqlsrv_query($connect, $sql_save, $params_save);

        if ($stmt_save === false) {
            die("<div class='alert alert-danger'>저장 실패.<br>" . print_r(sqlsrv_errors(), true) . "</div>");
        } else {
            echo "<script>alert('저장되었습니다.'); location.href = '$return_url';</script>";
            exit;
        }
    }

    // 5. 체크리스트 항목 정의 (요청하신 내용 적용됨)
    $checklist_items = [
        '시험실' => [
            '[인터록] 로봇팔 울타리 출입문을 열면 로봇이 즉시 멈추는가?',
            '[비상정지] 로봇 및 각 시험기의 비상정지 버튼을 눌렀을 때 즉각 동작이 멈추는가?',
            '[국소배기] 연소 시 발생하는 연기가 외부로 새어 나오지 않고 후드로 잘 빨려 나가는가?',
            '[가스누출] 누출경보기 점검을 실시했는가?',
            '[소화설비] 연소 시험기 옆 소화기가 비치되어 있고 압력은 정상인가?',
            '[과열방지] 설정 온도 이상으로 올라갔을때 자동으로 전원을 차단하는 과열 방지 장치가 설정되어 있는가?',
            '[화상주의] 항온항습기에 "고온주의" 경고 표지가 부착되어 있는가?',
            '[보호구] 적절한 보호구가 비치되어 있고 작업자가 착용하는가?'
        ],
        '연구소' => [
            '[정리정돈] 책상 위, 통로, 바닥에 불필요한 물건이 방치되어 있는가?',
            '[출입구] 출입구 주변에 적재물이 쌓여 대피를 방해하지 않는가?',
            '[배선] 문어발식 배선을 사용하고 있지 않은가?',
            '[전선상태] 전선의 피복이 벗겨지거나 그을린 흔적이 없는가?'
        ],
        '현장' => [
            '[비상정지] 스티칭기 \'비상정지 버튼\'이 정상 작동하는가?',
            '[화재예방] 부직포 롤 주변 및 기계 하부에 먼지나 오일이 쌓여 화재 위험은 없는가?',
            '[절단도구] 컷팅 시 작업자가 장갑을 착용하는가?',
            '[국소배기] 납땜 작업 시 덕트는 정상동작 하는가?',
            '[전기안전] 납땜 인두기와 열풍기의 전선 피복은 녹거나 벗겨진 곳이 없는가?',
            '[화상/화재] 인두기와 열풍기 미사용 시 전용 거치대에 안전하게 두는가?',
            '[보호구] 납땜 작업자가 방진 마스크를 올바르게 착용하고 있는가?',
            '[고열주의] 글루건 사용 시 화상 주의 표지가 부착되어 있고 글루건 노즐 상태는 양호한가?',
            '[방호장치] 광전자식 안전 센서가 정상 작동하는가?',
            '[조작방식] 양수 조작 버튼이 정상인가?',
            '[금형고정] 목형 조정 볼트가 풀려 있거나 유격이 발생하지 않는가?',
            '[이물질제거] 펀칭기 내부 이물질 제거 시 반드시 전원을 끄고 수공구를 사용하는가?',
            '[적재안전] 소화전이나 배전반 앞을 가리지 않도록 적재하였는가?'
        ],
        '공무실' => [
            '[기계안전] 탁상 그라인더의 덮개는 부착되어 있고, 워크레스트(작업받침대)와 휠의 간격은 3mm 이내로 조정되어 있는가?',
            '[기계안전] 탁상 그라인더 사용 시 비산먼지나 파편을 막아주는 투명 보안판(Eye Shield)은 깨끗하게 유지되고 있는가?',
            '[수공구] 망치, 렌치, 드라이버 등 수공구의 손잡이가 깨지거나 헐거워 작업 중 빠질 위험은 없는가?',
            '[전기안전] 작업용 릴선(이동 전선)의 피복이 손상된 곳은 없으며, 반드시 접지형 콘센트를 사용하는가?',
            '[전기안전] 휴대용 전동공구(핸드 그라인더, 드릴)의 전원 코드 피복이 벗겨져 감전 위험은 없는가?',
            '[화학물질] WD-40, 세척제, 절삭유 등 소분 용기에 경고 표지(MSDS 스티커)가 부착되어 있는가?',
            '[정리정돈] 작업대 위에 날카로운 공구나 자재(볼트, 너트, 전선 등)가 어지럽게 방치되어 낙하할 위험은 없는가?'
        ],
        '자재창고' => [
            '[적재설비] 랙(Rack)의 기둥이나 프레임이 지게차 충돌 등으로 휘거나 파손된 곳은 없는가?',
            '[적재방법] 무거운 자재는 하단에, 가벼운 자재는 상단에 적재(중량물 하부 원칙)하였는가?',
            '[낙하방지] 파레트나 자재가 랙 밖으로 불안정하게 튀어나와 낙하할 위험은 없는가?',
            '[통로확보] 지게차 이동 통로와 보행자 통로(구획선)에 자재가 방치되어 있지 않은가?',
            '[소방시설] 소화기나 소화전 앞을 자재로 가로막아 비상시 사용을 방해하고 있지 않은가?',
            '[화재예방] 박스, 비닐 등 포장 폐기물은 즉시 지정된 장소로 배출하여 화재 위험을 없앴는가?',
            '[전기안전] 배전반 문이 잘 닫혀 있고, 배전반 앞 1m 이내에 적재물이 없는가?',
            '[정리정돈] 바닥에 포장용 끈(밴딩끈), 오일, 물기 등이 방치되어 미끄러짐/전도 위험은 없는가?',
            '[보호구] 창고 내 작업 시 안전화 및 안전모(필요 시)를 올바르게 착용하고 있는가?'
        ],
        'bb창고' => [
            '[외부환경] 외부 하역장의 바닥이 지게차 운행에 지장 없이 평탄하고(포트홀 등 없음) 결빙된 곳은 없는가?',
            '[신호수] 지게차와 보행자가 혼재하는 하역 작업 시 유도자(신호수)가 배치되어 있거나 통제 조치가 되었는가?',
            '[적재상태] 파레트 위의 박스들은 랩핑(Wrapping) 또는 밴딩 처리가 견고하여 이송 중 쏟아질 위험이 없는가?',
            '[파레트] 파레트 자체가 파손되거나 균열이 있어 랙 적재 시 붕괴될 위험은 없는가?',
            '[지게차] 지게차의 전조등, 후미등, 후진경보음 및 경광등(또는 후방감지기)이 정상 작동하는가?',
            '[랙설비] 랙의 기둥 보호대(Post Guard)가 설치되어 있고, 지게차 충돌로 인한 파손은 없는가?',
            '[낙하방지] 랙에 파레트를 넣을 때 빔 밖으로 불안정하게 튀어나오거나 비스듬하게 놓이지 않았는가?',
            '[충전설비] 충전 케이블의 피복이 벗겨져 있거나 커넥터 연결 부위가 파손되어 감전 위험은 없는가?',
            '[과열방지] 충전기 본체나 배터리에서 타는 냄새나 이상 발열이 발생하지 않는가?',
            '[충전구역] 충전 구역 주변에 가연성 물질(박스, 비닐 등)이 적치되어 있지 않으며 소화기가 바로 옆에 있는가?'
        ],
        '완성품창고' => [
            '[적재하중] 랙의 선반(Shelf)이 박스 무게를 이기지 못해 아래로 처지거나 휘어져 있지 않은가?',
            '[설비안전] 랙의 프레임이나 기둥을 손으로 흔들었을 때 유격이 없이 바닥에 단단히 고정되어 있는가?',
            '[통로확보] 박스를 들고 이동하는 작업 동선에 걸려 넘어질 수 있는 이물질이나 포장 끈이 없는가?',
            '[보호구] 박스 모서리에 베이거나 미끄러지지 않도록 코팅 장갑을 착용하고 있는가?',
            '[보호구] 중량물 낙하에 대비하여 작업자는 안전화를 신고 있는가?',
            '[화재예방] 종이 박스가 밀집된 곳이므로 소화기 위치가 잘 보이고 접근이 쉬운가?',
            '[조명상태] 랙의 안쪽이나 하단까지 라벨과 적재 상태를 확인할 수 있도록 조명이 충분히 밝은가?',
            '[정리정돈] 파손되거나 찌그러진 박스를 랙에 그대로 적재하여 붕괴를 유발하고 있지 않은가?'
        ],
        'ecu창고' => [
            '[근골격계] 하단부 박스를 들 때 허리만 굽히지 않고 무릎을 굽혀(스쿼트 자세) 작업하는가?',
            '[용기상태] 플라스틱 박스의 손잡이나 모서리가 깨져서 손을 베일 위험은 없는가?',
            '[적재상태] 플라스틱 박스의 결합 홈(Interlocking)이 파손되지 않아 흔들림 없이 견고하게 쌓여 있는가?',
            '[이동수단] 박스를 들고 이동하기보다 가능한 한 대차(Dolly)나 핸드카를 이용하여 운반하는가?',
            '[화재예방] 다량의 플라스틱 박스 보관 구역이므로 소화기가 즉시 사용할 수 있는 위치에 있는가?'
        ]
    ];

    $current_items = isset($checklist_items[$location_param]) ? $checklist_items[$location_param] : [];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>
    <style>
        .big-checkbox { transform: scale(1.5); cursor: pointer; }
        .check-card { border: 1px solid #e3e6f0; border-radius: 0.35rem; margin-bottom: 1rem; padding: 1rem; background: #fff; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); }
        .check-question { font-weight: bold; margin-bottom: 0.8rem; font-size: 1.1em; color: #4e73df; }
        .btn-group-toggle .btn { width: 32%; font-weight: bold; }
        .btn-group-toggle .btn.active { box-shadow: inset 0 3px 5px rgba(0,0,0,0.125); }
        .btn-loc { min-width: 100px; margin: 5px; }
        .table th { vertical-align: middle; background-color: #f8f9fc; }
        .table td { vertical-align: middle; }
    </style>
    <script>
        // 페이지 이동 스크립트 (날짜 변경용)
        function changeDate() {
            var dateVal = document.getElementById('search_month_input').value;
            var loc = "<?php echo urlencode($location_param); ?>";
            if(!loc) {
                alert("장소를 먼저 선택해주세요.");
                return;
            }
            location.href = "<?php echo $SELF; ?>?tab=tab2&loc=" + loc + "&search_month=" + dateVal;
        }
    </script>
</head>

<body id="page-top">
    <div id="wrapper">      
        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em;">
                            <?php echo $is_mobile ? '안전 점검' : '월별 안전 체크리스트'; ?>
                        </h1>
                        <?php if($is_mobile && !empty($location_param)): ?>
                            <div class="mt-2 input-group">
                                <input type="month" id="search_month_input_m" class="form-control" value="<?php echo $search_month; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="location.href='<?php echo $SELF; ?>?tab=tab2&loc=<?php echo urlencode($location_param); ?>&search_month='+document.getElementById('search_month_input_m').value">이동</button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>              

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab1_class; ?>" href="<?php echo $SELF; ?>?tab=tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2_class; ?>" href="#" onclick="openLocationModal(); return false;">체크리스트</a>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade <?php echo $tab1_class; ?>" id="tab1" role="tabpanel">
                                            <div class="alert alert-info">
                                                <h5><i class="icon fas fa-info"></i> 사용 가이드</h5>
                                                <ul>
                                                    <li><strong>체크리스트</strong> 탭을 클릭하여 장소를 선택하세요.</li>
                                                    <li>매월 말일 기준 해당 구역의 안전 상태를 점검합니다.</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab2_class; ?>" id="tab2" role="tabpanel">
                                            <?php if (empty($location_param)): ?>
                                                <div class="text-center py-5">
                                                    <h4 class="text-gray-500 mb-4">점검할 장소를 선택해주세요.</h4>
                                                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#locationModal">
                                                        <i class="fas fa-map-marker-alt"></i> 장소 선택하기
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                
                                                <form method="POST" action="<?php echo $SELF; ?>" onsubmit="return confirm('저장하시겠습니까?');">
                                                    <input type="hidden" name="mode" value="save">
                                                    <input type="hidden" name="location" value="<?php echo e($location_param); ?>">
                                                    <input type="hidden" name="check_month" value="<?php echo $search_month; ?>">

                                                    <?php if(!$is_mobile): ?>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <h4 class="m-0 font-weight-bold text-primary mr-3">
                                                                <span class="badge badge-primary"><?php echo e($location_param); ?></span> 점검표
                                                            </h4>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary mr-2" data-toggle="modal" data-target="#locationModal">
                                                                <i class="fas fa-sync"></i> 장소 변경
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <div class="form-inline justify-content-end">
                                                                <label class="mr-2 font-weight-bold">조회 월:</label>
                                                                <div class="input-group">
                                                                    <input type="month" id="search_month_input" class="form-control" value="<?php echo $search_month; ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary" type="button" onclick="changeDate()">조회</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>

                                                    <?php if ($is_mobile): ?>
                                                        <div class="mobile-checklist-area">
                                                            <?php 
                                                            $idx = 1;
                                                            if (count($current_items) > 0) {
                                                                foreach ($current_items as $item) {
                                                                    $idx_key = (string)$idx; 
                                                                    $val = isset($check_data[$idx_key]) ? trim($check_data[$idx_key]) : '';
                                                            ?>
                                                                <div class="check-card">
                                                                    <div class="check-question">
                                                                        <span class="badge badge-secondary mr-1"><?php echo $idx; ?></span>
                                                                        <?php echo $item; ?>
                                                                    </div>
                                                                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                                                        <label class="btn btn-outline-success <?php if($val === 'O') echo 'active'; ?>">
                                                                            <input type="radio" name="check_item[<?php echo $idx; ?>]" value="O" <?php if($val === 'O') echo 'checked'; ?>> 양호
                                                                        </label>
                                                                        <label class="btn btn-outline-danger <?php if($val === 'X') echo 'active'; ?>">
                                                                            <input type="radio" name="check_item[<?php echo $idx; ?>]" value="X" <?php if($val === 'X') echo 'checked'; ?>> 불량
                                                                        </label>
                                                                        <label class="btn btn-outline-secondary <?php if($val === 'N/A') echo 'active'; ?>">
                                                                            <input type="radio" name="check_item[<?php echo $idx; ?>]" value="N/A" <?php if($val === 'N/A') echo 'checked'; ?>> N/A
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            <?php 
                                                                    $idx++; 
                                                                }
                                                            } else {
                                                                echo "<div class='alert alert-warning'>등록된 항목이 없습니다.</div>";
                                                            }
                                                            ?>
                                                        </div>

                                                    <?php else: ?>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead class="thead-light text-center">
                                                                    <tr>
                                                                        <th style="width: 50px;">NO</th>
                                                                        <th>점검 항목</th>
                                                                        <th style="width: 100px;">양호</th>
                                                                        <th style="width: 100px;">불량</th>
                                                                        <th style="width: 100px;">N/A</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    $idx = 1;
                                                                    if (count($current_items) > 0) {
                                                                        foreach ($current_items as $item) { 
                                                                            $idx_key = (string)$idx;
                                                                            $val = isset($check_data[$idx_key]) ? trim($check_data[$idx_key]) : '';
                                                                    ?>
                                                                        <tr>
                                                                            <td class="text-center align-middle"><?php echo $idx; ?></td>
                                                                            <td class="align-middle"><?php echo $item; ?></td>
                                                                            <td class="text-center align-middle">
                                                                                <input type="radio" name="check_item[<?php echo $idx; ?>]" value="O" class="big-checkbox" <?php if($val === 'O') echo 'checked="checked"'; ?>>
                                                                            </td>
                                                                            <td class="text-center align-middle">
                                                                                <input type="radio" name="check_item[<?php echo $idx; ?>]" value="X" class="big-checkbox" <?php if($val === 'X') echo 'checked="checked"'; ?>>
                                                                            </td>
                                                                            <td class="text-center align-middle">
                                                                                <input type="radio" name="check_item[<?php echo $idx; ?>]" value="N/A" class="big-checkbox" <?php if($val === 'N/A') echo 'checked="checked"'; ?>>
                                                                            </td>
                                                                        </tr>
                                                                    <?php 
                                                                            $idx++; 
                                                                        } 
                                                                    } else {
                                                                        echo "<tr><td colspan='5' class='text-center'>등록된 점검 항목이 없습니다.</td></tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="form-group mt-3">
                                                        <label class="font-weight-bold">특이사항</label>
                                                        <textarea class="form-control" name="note" rows="3" placeholder="특이사항 입력"><?php echo e($saved_note); ?></textarea>
                                                    </div>
                                                    
                                                    <div class="row mt-3 mb-5">
                                                        <div class="col-6 text-left text-muted">
                                                            <small>작성자: <?php echo e($saved_writer ? $saved_writer : '-'); ?></small>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                                <i class="fas fa-save"></i> 저장
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div>
        </div>
    </div>

    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">점검 장소 선택</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-4">점검하려는 장소를 선택해주세요.</p>
                    <div class="d-flex justify-content-center flex-wrap">
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('시험실'); ?>&tab=tab2&search_month=<?php echo $search_month; ?>" class="btn btn-outline-primary btn-lg btn-loc">
                            <i class="fas fa-flask fa-2x d-block mb-2"></i>시험실
                        </a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('연구소'); ?>&tab=tab2&search_month=<?php echo $search_month; ?>" class="btn btn-outline-success btn-lg btn-loc">
                            <i class="fas fa-microscope fa-2x d-block mb-2"></i>연구소
                        </a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('현장'); ?>&tab=tab2&search_month=<?php echo $search_month; ?>" class="btn btn-outline-warning btn-lg btn-loc">
                            <i class="fas fa-hard-hat fa-2x d-block mb-2"></i>현장
                        </a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('공무실'); ?>&tab=tab2&search_month=<?php echo $search_month; ?>" class="btn btn-outline-primary btn-lg btn-loc">
                            <i class="fas fa-tools fa-2x d-block mb-2"></i>공무실
                        </a>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center flex-wrap">
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('자재창고'); ?>&tab=tab2&search_month=<?php echo $search_month; ?>" class="btn btn-outline-info btn-lg btn-loc">
                            <i class="fas fa-boxes fa-2x d-block mb-2"></i>자재창고
                        </a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('bb창고'); ?>&tab=tab2&search_month=<?php echo $search_month; ?>" class="btn btn-outline-secondary btn-lg btn-loc">
                            <i class="fas fa-warehouse fa-2x d-block mb-2"></i>BB창고
                        </a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('완성품창고'); ?>&tab=tab2&search_month=<?php echo $search_month; ?>" class="btn btn-outline-dark btn-lg btn-loc">
                            <i class="fas fa-box-open fa-2x d-block mb-2"></i>완성품
                        </a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('ecu창고'); ?>&tab=tab2&search_month=<?php echo $search_month; ?>" class="btn btn-outline-danger btn-lg btn-loc">
                            <i class="fas fa-microchip fa-2x d-block mb-2"></i>ECU창고
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../plugin_lv1.php'; ?>
    <script>
        function openLocationModal() {
            $('#locationModal').modal('show');
        }
        $(document).ready(function() {
            var activeTab = "<?php echo $active_tab; ?>";
            var loc = "<?php echo $location_param; ?>";
            if (activeTab === 'tab2' && !loc) {
                $('#locationModal').modal('show');
            }
        });
    </script>
</body>
</html>