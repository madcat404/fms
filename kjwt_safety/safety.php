<?php 
    // =============================================
    // Author: <User>
    // Create date: <2025-12-11>
    // Description: 안전 체크리스트 화면 (동적 파일명 적용)
    // =============================================
    
    // 에러 리포팅 (디버깅용, 배포 시 주석 처리)
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'safety_status.php';

    function e($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 현재 실행 중인 파일명 가져오기 (링크 깨짐 방지)
    $SELF = $_SERVER['PHP_SELF'];

    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab1';
    $tab1_class = ($active_tab === 'tab1') ? 'active show' : '';
    $tab2_class = ($active_tab === 'tab2') ? 'active show' : '';
    
    // 체크리스트 항목 정의
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
        ]
    ];

    $location_param = isset($_GET['loc']) ? $_GET['loc'] : '';
    $current_items = isset($checklist_items[$location_param]) ? $checklist_items[$location_param] : [];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../head_lv1.php' ?>
    <style>
        .big-checkbox { transform: scale(1.5); cursor: pointer; }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">      
        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em;">월별 안전 체크리스트</h1>
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
                                                    <li>매월 말일 기준 해당 구역의 안전 상태를 점검하고 기록합니다.</li>
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
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <h4 class="m-0 font-weight-bold text-primary mr-3">
                                                                <span class="badge badge-primary"><?php echo e($location_param); ?></span> 점검표
                                                            </h4>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#locationModal">
                                                                <i class="fas fa-sync"></i> 장소 변경
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <div class="form-inline justify-content-end">
                                                                <label class="mr-2">점검 월:</label>
                                                                <input type="month" class="form-control mr-2" name="check_month" 
                                                                       value="<?php echo isset($_GET['search_month']) ? $_GET['search_month'] : date('Y-m'); ?>" 
                                                                       onchange="location.href='<?php echo $SELF; ?>?tab=tab2&loc=<?php echo urlencode($location_param); ?>&search_month='+this.value">
                                                            </div>
                                                        </div>
                                                    </div>

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
                                                                        // 수정됨: 데이터가 없으면 null을 반환하여 아무것도 체크되지 않게 함 (기존: 'O')
                                                                        $val = isset($check_data[$idx]) ? $check_data[$idx] : null;
                                                                ?>
                                                                    <tr>
                                                                        <td class="text-center align-middle"><?php echo $idx; ?></td>
                                                                        <td class="align-middle"><?php echo $item; ?></td>
                                                                        <td class="text-center align-middle">
                                                                            <input type="radio" name="check_item[<?php echo $idx; ?>]" value="O" class="big-checkbox" <?php if($val == 'O') echo 'checked'; ?>>
                                                                        </td>
                                                                        <td class="text-center align-middle">
                                                                            <input type="radio" name="check_item[<?php echo $idx; ?>]" value="X" class="big-checkbox" <?php if($val == 'X') echo 'checked'; ?>>
                                                                        </td>
                                                                        <td class="text-center align-middle">
                                                                            <input type="radio" name="check_item[<?php echo $idx; ?>]" value="N/A" class="big-checkbox" <?php if($val == 'N/A') echo 'checked'; ?>>
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

                                                    <div class="form-group mt-3">
                                                        <label class="font-weight-bold">특이사항</label>
                                                        <textarea class="form-control" name="note" rows="4"><?php echo e($saved_note); ?></textarea>
                                                    </div>
                                                    
                                                    <div class="row mt-3">
                                                        <div class="col-md-6 text-left text-muted">
                                                            <small>작성자: <?php echo e($saved_writer ? $saved_writer : '-'); ?></small>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> 저장</button>
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
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('시험실'); ?>&tab=tab2" class="btn btn-outline-primary btn-lg m-2" style="min-width: 120px;">
                            <i class="fas fa-flask fa-2x d-block mb-2"></i>시험실
                        </a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('연구소'); ?>&tab=tab2" class="btn btn-outline-success btn-lg m-2" style="min-width: 120px;">
                            <i class="fas fa-microscope fa-2x d-block mb-2"></i>연구소
                        </a>
                        <a href="<?php echo $SELF; ?>?loc=<?php echo urlencode('현장'); ?>&tab=tab2" class="btn btn-outline-warning btn-lg m-2" style="min-width: 120px;">
                            <i class="fas fa-hard-hat fa-2x d-block mb-2"></i>현장
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