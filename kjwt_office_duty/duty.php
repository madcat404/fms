<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.15>
	// Description:	<당직 리뉴얼>
    // Security Update: <2025.10.13> - Applied prepared statements to prevent SQL injection.
    // Last Modified: <Current Date> - Fixed Mobile Update Issue (Duplicate Input Names)
	// =============================================
    include 'duty_status.php';   

    // XSS 방지를 위한 헬퍼 함수
    function h($string) {
        if (!isset($string)) return '';
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    // [Tab 2] 현황 데이터 배열 저장
    $duty_status_data = [];
    if (isset($select_duty_result)) {
        while ($row = mysqli_fetch_array($select_duty_result)) {
            $g_date = $row['dt'];
            $g_yy = substr($g_date, 0, 4);	
            $g_mm = substr($g_date, 4, 2);
            $g_dd = substr($g_date, 6, 2);    
            $g_date2 = "$g_yy"."-"."$g_mm"."-"."$g_dd";	
            $timestamp = strtotime($g_date2);
            $w_today = ['일','월','화','수','목','금','토'][date('w', $timestamp)];

            $stmt_team = $connect->prepare("SELECT TEAM_NM FROM user_info WHERE DUTY_NUM = ?");
            $stmt_team->bind_param("s", $row['duty_num']);
            $stmt_team->execute();
            $team_result = $stmt_team->get_result();
            $team_row = mysqli_fetch_array($team_result);

            $row['FORMATTED_DATE'] = h($row['dt']) . "(" . h($w_today) . ")";
            $row['TEAM_NM'] = h($team_row['TEAM_NM'] ?? '');
            $duty_status_data[] = $row;
        }
    }

    // [Tab 3] 통계 데이터 배열 저장
    $statistics_data = [];
    if (isset($Result_DutyTarget)) {
        while($Data_DutyTarget = mysqli_fetch_array($Result_DutyTarget)) {
            $stmt_total1 = $connect->prepare("SELECT COUNT(*) AS count from duty WHERE holiday_yn='N' AND duty_change IS null and dt <= ? and duty_person=?");
            $stmt_total1->bind_param("ss", $NoHyphen_today, $Data_DutyTarget['USER_NM']);
            $stmt_total1->execute();
            $Data_DutyTotal = mysqli_fetch_array($stmt_total1->get_result()); 

            $stmt_total2 = $connect->prepare("SELECT COUNT(*) as count2 from duty WHERE holiday_yn='N' AND duty_change!='단체연차' and dt <= ? and duty_change=?");
            $stmt_total2->bind_param("ss", $NoHyphen_today, $Data_DutyTarget['USER_NM']);
            $stmt_total2->execute();
            $Data_DutyTotal2 = mysqli_fetch_array($stmt_total2->get_result()); 

            $s_dt = new DateTime($Data_DutyTarget['DUTY_START']);
            $e_dt = new DateTime($Hyphen_today);
            $duty_count = ($Data_DutyTotal['count'] ?? 0) + ($Data_DutyTotal2['count2'] ?? 0);
            $days_diff = date_diff($s_dt, $e_dt)->days;
            
            $frequency = ($duty_count > 0) ? floor($days_diff / $duty_count)."일에 1회 근무" : "-";

            $statistics_data[] = [
                'USER_NM' => h($Data_DutyTarget['USER_NM']),
                'DUTY_COUNT' => h($duty_count),
                'DUTY_START' => h($Data_DutyTarget['DUTY_START']),
                'DAYS_DIFF' => h($days_diff),
                'FREQUENCY' => $frequency
            ];
        }
    }

    // [Tab 4] 내역 데이터 배열 저장
    $history_data = [];
    if (isset($Result_DutyInquire)) {
        while($Data_DutyInquire = mysqli_fetch_array($Result_DutyInquire)) {
            $stmt_team2 = $connect->prepare("SELECT TEAM_NM FROM user_info WHERE DUTY_NUM = ?");
            $stmt_team2->bind_param("s", $Data_DutyInquire['duty_num']);
            $stmt_team2->execute();
            $team_row2 = mysqli_fetch_array($stmt_team2->get_result());

            $changeDT = date("Y-m-d", strtotime($Data_DutyInquire["dt"]));

            $Query_DutyInquire2 = "SELECT * from CONNECT.dbo.DUTY WHERE SORTING_DATE=? and OUTSIDE1 IS NULL";              
            $Result_DutyInquire2 = sqlsrv_query($connect6, $Query_DutyInquire2, [$changeDT]);		
            $duty2 = sqlsrv_has_rows($Result_DutyInquire2) ? "N" : "Y";

            $Query_DutyInquire3 = "SELECT * from CONNECT.dbo.DUTY WHERE SORTING_DATE=? and NFC1 IS NULL";              
            $Result_DutyInquire3 = sqlsrv_query($connect6, $Query_DutyInquire3, [$changeDT]);		
            $duty3 = sqlsrv_has_rows($Result_DutyInquire3) ? "N" : "Y";

            $Query_DutyInquire4 = "SELECT NOTE from CONNECT.dbo.DUTY WHERE SORTING_DATE=?";              
            $Result_DutyInquire4 = sqlsrv_query($connect6, $Query_DutyInquire4, [$changeDT]);		
            $Data_DutyInquire4 = sqlsrv_fetch_array($Result_DutyInquire4); 

            $history_data[] = [
                'DT' => h($Data_DutyInquire['dt']),
                'TEAM_NM' => h($team_row2['TEAM_NM'] ?? ''),
                'PERSON' => h($Data_DutyInquire['duty_person']),
                'CHANGE' => h($Data_DutyInquire['duty_change']),
                'CHECK_DUTY' => h($duty2),
                'CHECK_NFC' => h($duty3),
                'NOTE' => h($Data_DutyInquire4['NOTE'] ?? '')
            ];
        }
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>    
    <script>
        // [추가] 입력값 동기화 스크립트
        // 모바일/PC 화면 어디서 입력하든 실제 hidden input 값을 업데이트
        function syncNoteValue(input, idx) {
            var realInput = document.getElementById('real_NOTE_' + idx);
            if (realInput) {
                realInput.value = input.value;
            }
            // 다른 뷰의 입력창도 같이 업데이트 (선택사항: 사용자 경험 향상)
            var viewInputs = document.querySelectorAll('.view-note-' + idx);
            viewInputs.forEach(function(el) {
                if (el !== input) el.value = input.value;
            });
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
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">당직</h1>
                    </div>               

                    <div class="row"> 

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab2 ?? '');?>" id="tab-two" data-toggle="pill" href="#tab2">현황</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3 ?? '');?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">통계</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab4 ?? '');?>" id="custom-tabs-one-2th-tab" data-toggle="pill" href="#custom-tabs-one-2th">내역</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab5 ?? '');?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">당직일지</a>
                                        </li> 
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 당직안내 및 당직일지 전산화<BR><BR>
                                            [기능]<BR>
                                            - 당직일지에서 NFC 항목은 NFC 태그를 해야 체크됨<BR>
                                            - 미당직 알림 메일 발송 (경영팀)<BR>
                                            - 당직 알림 메일 발송 (2번)<BR>
                                            - 당직 자동 배정 (2개월치)<BR><BR>
                                            [규칙]<br>
                                            - 현장근무시간 종료 이후 실시<br>
                                            - 당직 미실시 시 벌당직 3일<br>
                                            - 당직대상자: 정규직 and 과장이하 and 팀원<br>
                                            - 여직원의 경우 남직원과의 연봉이 동일해진 23년 1월 1일 기준으로 실시<br>
                                            - 회장님이 출근하셨을때 경영팀은 점심시간 교대근무 안함<br>
                                            - 주말 및 휴일 당직은 경비원<br><br>
                                            [히스토리]<BR>
                                            22.03.03)<BR>
                                            - 당직 공평성에 대한 의문을 제기하여 통계탭 생성 하였음<BR>
                                            23.02.22)<BR>
                                            - 당직일지 탭 생성 (NFC 태깅 포인트 추가)<BR>
                                            23.04.01)<BR>                                            
                                            - 남직원과의 연봉차가 없어져 23년 부터 여직원도 당직 근무 시작<BR><BR>
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 당직 대상자<br>
                                            - 휴일에 대한 데이터를 확보하기 위해 공공데이터포탈 api를 사용하고 있는데 데드라인이 있어 이것을 연장하지 않으면 당직 자동생성에 문제가 발생함<br><br>
                                            [제작일]<BR>
                                            - 20.10.12<br><br>
                                        </div>
                                        
                                        <div class="tab-pane fade <?php echo h($tab2_text ?? '');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">              
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">현황</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="duty.php"> 
                                                    <div class="collapse show" id="collapseCardExample22">
                                                        <div class="card-body p-2">  
                                                            <?php 
                                                                if($modi=='Y') {
                                                                    $hidden_idx = 1;
                                                                    foreach($duty_status_data as $row) {
                                                                        // 날짜 데이터
                                                                        echo "<input type='hidden' name='DT{$hidden_idx}' value='".h($row['dt'])."'>";
                                                                        // 변경자 데이터 (수정용)
                                                                        echo "<input type='hidden' name='NOTE{$hidden_idx}' id='real_NOTE_{$hidden_idx}' value='".h($row['duty_change'])."'>";
                                                                        $hidden_idx++;
                                                                    }
                                                                }
                                                            ?>

                                                            <div class="row">
                                                                <?php 
                                                                    if(isset($Data_DutyToday['duty_change'])) {
                                                                        $title = $Data_DutyToday['duty_change'];
                                                                    } else {
                                                                        $title = $Data_DutyToday['duty_person'] ?? '';
                                                                    }
                                                                    BOARD(12, "primary", "금일당직", h($title), "fas fa-tasks");
                                                                ?>
                                                            </div> 
                                                            
                                                            <?php ModifyData2("duty.php?modi=Y", "bt22", "Duty"); ?>

                                                            <div class="d-md-none mt-2">
                                                                <?php 
                                                                    $idx = 1;
                                                                    foreach($duty_status_data as $row): 
                                                                ?>
                                                                <div class="card mb-2">
                                                                    <div class="card-body p-3">
                                                                        <div class="row mb-1">
                                                                            <div class="col-4 font-weight-bold text-gray-700">날짜</div>
                                                                            <div class="col-8"><?= $row['FORMATTED_DATE'] ?></div>
                                                                        </div>
                                                                        <div class="row mb-1"><div class="col-4 font-weight-bold text-gray-700">휴일</div><div class="col-8"><?= h($row['holiday_yn']) ?></div></div>
                                                                        <div class="row mb-1"><div class="col-4 font-weight-bold text-gray-700">팀명</div><div class="col-8"><?= $row['TEAM_NM'] ?></div></div>
                                                                        <div class="row mb-1"><div class="col-4 font-weight-bold text-gray-700">당직자</div><div class="col-8"><?= h($row['duty_person']) ?></div></div>
                                                                        <div class="row mb-0">
                                                                            <div class="col-4 font-weight-bold text-gray-700">변경자</div>
                                                                            <div class="col-8">
                                                                                <?php if($modi=='Y') { ?>
                                                                                    <input class="form-control form-control-sm view-note-<?= $idx ?>" value='<?= h($row['duty_change']) ?>' type='text' oninput="syncNoteValue(this, <?= $idx ?>)">
                                                                                <?php } else { echo h($row['duty_change']); } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php $idx++; endforeach; ?>
                                                            </div>

                                                            <div class="table-responsive d-none d-md-block mt-2">
                                                                <table class="table table-bordered table-striped" id="table3">
                                                                    <thead>
                                                                        <tr><th>날짜</th><th>휴일</th><th>팀명</th><th>당직자</th><th>변경자</th></tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $idx = 1;
                                                                            foreach($duty_status_data as $row):
                                                                        ?>  
                                                                        <tr>
                                                                            <td><?= $row['FORMATTED_DATE'] ?></td>
                                                                            <td><?= h($row['holiday_yn']) ?></td>
                                                                            <td><?= $row['TEAM_NM'] ?></td>
                                                                            <td><?= h($row['duty_person']) ?></td> 
                                                                            <td>
                                                                                <?php if($modi=='Y') { ?>
                                                                                    <input value='<?= h($row['duty_change']) ?>' type='text' class="view-note-<?= $idx ?>" oninput="syncNoteValue(this, <?= $idx ?>)">
                                                                                <?php } else { echo h($row['duty_change']); } ?>
                                                                            </td>                                   
                                                                        </tr> 
                                                                        <?php $idx++; endforeach; ?> 
                                                                    </tbody>
                                                                </table>    
                                                            </div> 

                                                            <input type="hidden" name="until" value="<?php echo $idx; ?>">
                                                        </div>
                                                    </div>
                                                </form> 
                                            </div>                                          
                                        </div>  

                                        <div class="tab-pane fade <?php echo h($tab3_text ?? '');?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">통계</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample32">
                                                    <div class="card-body p-2">      
                                                        <div class="d-md-none">
                                                            <?php foreach($statistics_data as $row): ?>
                                                            <div class="card mb-2">
                                                                <div class="card-body p-3">
                                                                    <div class="h6 font-weight-bold text-primary mb-2"><?= $row['USER_NM'] ?></div>
                                                                    <div class="row mb-1"><div class="col-7 small text-gray-600">당직횟수 (20.10.21~)</div><div class="col-5 small"><?= $row['DUTY_COUNT'] ?></div></div>
                                                                    <div class="row mb-1"><div class="col-7 small text-gray-600">기준일</div><div class="col-5 small"><?= $row['DUTY_START'] ?></div></div>
                                                                    <div class="row mb-1"><div class="col-7 small text-gray-600">기준일~현재 일수</div><div class="col-5 small"><?= $row['DAYS_DIFF'] ?></div></div>
                                                                    <div class="row mb-0"><div class="col-7 small text-gray-600">근무주기</div><div class="col-5 small"><?= $row['FREQUENCY'] ?></div></div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>이름</th>
                                                                        <th>당직횟수 (20.10.21 이후)</th>
                                                                        <th>기준일 (FMS자동화일/입사일/복귀일)</th>
                                                                        <th>기준일부터 현재까지 일수</th>   
                                                                        <th>기준일부터 현재까지 일수 / 당직횟수</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($statistics_data as $row): ?>
                                                                    <tr>
                                                                        <td><?= $row['USER_NM'] ?></td>  
                                                                        <td><?= $row['DUTY_COUNT'] ?></td>  
                                                                        <td><?= $row['DUTY_START'] ?></td>  
                                                                        <td><?= $row['DAYS_DIFF'] ?></td>  
                                                                        <td><?= $row['FREQUENCY'] ?></td> 
                                                                    </tr> 
                                                                    <?php endforeach; ?>       
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                                                                                                          
                                        </div> 

                                        <div class="tab-pane fade <?php echo h($tab4_text ?? '');?>" id="custom-tabs-one-2th" role="tabpanel" aria-labelledby="custom-tabs-one-2th-tab">
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="duty.php"> 
                                                    <div class="collapse show" id="collapseCardExample41">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>검색범위</label>
                                                                <div class="input-group">                                                
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt4">
                                                                </div>
                                                            </div>       
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt41">검색</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>

                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample42">
                                                    <div class="card-body p-2">   
                                                        <div class="d-md-none">
                                                            <?php foreach($history_data as $row): ?>
                                                            <div class="card mb-2">
                                                                <div class="card-body p-3">
                                                                    <div class="row mb-1"><div class="col-4 small text-gray-600 font-weight-bold">날짜</div><div class="col-8 small"><?= $row['DT'] ?></div></div>
                                                                    <div class="row mb-1"><div class="col-4 small text-gray-600 font-weight-bold">팀명/당직자</div><div class="col-8 small"><?= $row['TEAM_NM'] ?> / <?= $row['PERSON'] ?></div></div>
                                                                    <div class="row mb-1"><div class="col-4 small text-gray-600 font-weight-bold">변경자</div><div class="col-8 small"><?= $row['CHANGE'] ?></div></div>
                                                                    <div class="row mb-1"><div class="col-4 small text-gray-600 font-weight-bold">확인(일반/NFC)</div><div class="col-8 small"><?= $row['CHECK_DUTY'] ?> / <?= $row['CHECK_NFC'] ?></div></div>
                                                                    <div class="row mb-0"><div class="col-4 small text-gray-600 font-weight-bold">조치사항</div><div class="col-8 small"><?= $row['NOTE'] ?></div></div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table4">
                                                                <thead>
                                                                    <tr><th>날짜</th><th>팀명</th><th>당직자</th><th>변경자</th><th>당직확인</th><th>당직확인(NFC)</th><th>조치사항</th></tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($history_data as $row): ?>
                                                                    <tr>
                                                                        <td><?= $row['DT'] ?></td>
                                                                        <td><?= $row['TEAM_NM'] ?></td>
                                                                        <td><?= $row['PERSON'] ?></td> 
                                                                        <td><?= $row['CHANGE'] ?></td>     
                                                                        <td><?= $row['CHECK_DUTY'] ?></td>        
                                                                        <td><?= $row['CHECK_NFC'] ?></td>   
                                                                        <td><?= $row['NOTE'] ?></td>                      
                                                                    </tr> 
                                                                    <?php endforeach; ?>   
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 


                                        <div class="tab-pane fade <?php echo h($tab5_text ?? '');?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">  
                                            <?php if(isMobile()) { ?>
                                            <div class="card shadow mb-2">
                                                <div class="card-body p-3">
                                                    <p class="text-danger small mb-3">※ NFC 태그 위치 및 상세 착안점은 PC버전에서 확인 가능합니다.</p>
                                                    <form method="POST" autocomplete="off" action="duty.php">     
                                                        <div class="mb-3">
                                                            <h6 class="font-weight-bold text-secondary border-bottom pb-2">NFC 체크 (태그 시 자동체크)</h6>
                                                            <?php for($i=1; $i<=7; $i++): $nfc_key = "NFC$i"; ?>
                                                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom-light">
                                                                <span>NFC <?= $i ?></span>
                                                                <input type='checkbox' name='<?= $nfc_key ?>' style='transform: scale(1.5);' <?= (isset($Data_TodayCheckList[$nfc_key]) && $Data_TodayCheckList[$nfc_key]=='on') ? 'checked' : ''; ?> disabled>
                                                            </div>
                                                            <?php endfor; ?>
                                                        </div>

                                                        <div class="mb-3">
                                                            <h6 class="font-weight-bold text-secondary border-bottom pb-2">구역별 점검</h6>
                                                            <?php 
                                                                $areas = [
                                                                    'FLOOR1_1' => '사무동 1층', 'FLOOR2_1' => '사무동 2층', 
                                                                    'FLOOR3_1' => '사무동 3층', 'FLOOR4_1' => '옥상', 
                                                                    'FILED1' => '현장', 'OUTSIDE1' => '외곽'
                                                                ];
                                                                foreach($areas as $key => $label):
                                                            ?>
                                                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom-light">
                                                                <span><?= $label ?></span>
                                                                <input type='checkbox' name='<?= $key ?>' style='transform: scale(1.5);' <?= (isset($Data_TodayCheckList[$key]) && $Data_TodayCheckList[$key]=='on') ? 'checked' : ''; ?>>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                        <div class="text-right mt-3">
                                                            <input type="hidden" name="mobile" value="on">
                                                            <button type="submit" value="on" class="btn btn-primary btn-block" name="bt51">입력</button>
                                                        </div>
                                                    </form> 
                                                </div>
                                            </div>

                                            <?php } else { ?>
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">당직일지</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="duty.php"> 
                                                    <div class="collapse show" id="collapseCardExample51">
                                                        <div class="card-body table-responsive p-2">  
                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered" id="table5">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center;">구분</th>
                                                                            <th style="text-align: center;">착안점</th>
                                                                            <th style="text-align: center;">점검</th>
                                                                            <th style="text-align: center;">구분</th>
                                                                            <th style="text-align: center;">착안점</th>
                                                                            <th style="text-align: center;">점검</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                        <tr>
                                                                            <td rowspan="5" style="vertical-align: middle; text-align: center;">외곽</td>    
                                                                            <td>외등 및 창고 실내등 꺼짐 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='OUTSIDE1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE1']) && $Data_TodayCheckList['OUTSIDE1']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td rowspan="5" style="vertical-align: middle; text-align: center;">사무동3층</td>    
                                                                            <td>출입문 / 창문 잠김 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR3_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_1']) && $Data_TodayCheckList['FLOOR3_1']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr>   
                                                                        <tr>
                                                                            <td>출입문 / 셔터 / 창문 닫힘 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='OUTSIDE2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE2']) && $Data_TodayCheckList['OUTSIDE2']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td>에어컨 / 히터 꺼짐 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR3_2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_2']) && $Data_TodayCheckList['FLOOR3_2']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr>    
                                                                        <tr>
                                                                            <td>화재 / 누수 / 우수관 이상유무 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='OUTSIDE3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE3']) && $Data_TodayCheckList['OUTSIDE3']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td>화재 / 누수 이상유무 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR3_3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_3']) && $Data_TodayCheckList['FLOOR3_3']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr> 
                                                                        <tr>
                                                                            <td>외곽 수도 잠김 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='OUTSIDE4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE4']) && $Data_TodayCheckList['OUTSIDE4']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td>컴퓨터 / 모니터 꺼짐 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR3_4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_4']) && $Data_TodayCheckList['FLOOR3_4']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr> 
                                                                        <tr>
                                                                            <td>시설물 이상유무 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='OUTSIDE5' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE5']) && $Data_TodayCheckList['OUTSIDE5']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td>[식당] 가스벨브 / 수도 이상유무 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR3_5' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_5']) && $Data_TodayCheckList['FLOOR3_5']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr>  
                                                                        <tr>
                                                                            <td rowspan="3" style="vertical-align: middle; text-align: center;">사무동1층(시험실 및 탈의실 포함)</td>    
                                                                            <td>창문 잠김 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR1_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR1_1']) && $Data_TodayCheckList['FLOOR1_1']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td rowspan="2" style="vertical-align: middle; text-align: center;">사무동4층</td>    
                                                                            <td>공조실 이상유무 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR4_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR4_1']) && $Data_TodayCheckList['FLOOR4_1']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr>   
                                                                        <tr>  
                                                                            <td>전등 소등 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR1_2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR1_2']) && $Data_TodayCheckList['FLOOR1_2']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td>보일러실 이상유무 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR4_2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR4_2']) && $Data_TodayCheckList['FLOOR4_2']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr>  
                                                                        <tr>  
                                                                            <td>에어컨 / 히터 꺼짐 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR1_3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR1_3']) && $Data_TodayCheckList['FLOOR1_3']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td rowspan="4" style="vertical-align: middle; text-align: center;">공장동(현장 및 창고 포함)</td>    
                                                                            <td>출입문 / 창문 잠김 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FILED1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FILED1']) && $Data_TodayCheckList['FILED1']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr>  
                                                                        <tr> 
                                                                            <td rowspan="4" style="vertical-align: middle; text-align: center;">사무동2층</td>    
                                                                            <td>출입문 / 창문 잠김 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR2_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR2_1']) && $Data_TodayCheckList['FLOOR2_1']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td>에어컨 / 히터 꺼짐 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FILED2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FILED2']) && $Data_TodayCheckList['FILED2']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr>    
                                                                        <tr>  
                                                                            <td>에어컨 / 히터 꺼짐 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR2_2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR2_2']) && $Data_TodayCheckList['FLOOR2_2']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td>화재 / 누수 이상유무 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FILED3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FILED3']) && $Data_TodayCheckList['FILED3']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr>
                                                                        <tr>  
                                                                            <td>화재 / 누수 이상유무 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR2_3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR2_3']) && $Data_TodayCheckList['FLOOR2_3']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td>전등 소등 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FILED4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FILED4']) && $Data_TodayCheckList['FILED4']=='on') ? 'checked' : ''; ?>></td>  
                                                                        </tr>
                                                                        <tr>  
                                                                            <td>컴퓨터 / 모니터 꺼짐 확인</td> 
                                                                            <td style="text-align: center;"><input type='checkbox' name='FLOOR2_4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR2_4']) && $Data_TodayCheckList['FLOOR2_4']=='on') ? 'checked' : ''; ?>></td>  
                                                                            <td></td> 
                                                                            <td></td> 
                                                                            <td></td> 
                                                                        </tr>                                                                                                                                             
                                                                    </tbody>
                                                                </table>   
                                                                <br> 
                                                                <table class="table table-bordered" id="table6">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center;">구분</th>
                                                                            <th style="text-align: center;">NFC 위치</th>
                                                                            <th style="text-align: center;">착안점</th>
                                                                            <th style="text-align: center;">점검</th>
                                                                            <th style="text-align: center;">점검시간</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                        <?php 
                                                                        $nfc_list = [
                                                                            1 => ['1층 라운지 복도 TV 밑', '1층 라운지 및 라운지 앞 복도 소등, TV 꺼짐 확인'],
                                                                            2 => ['1층 시험실로 출입 전 좌측 냉난방기 컨트롤러 근처', '냉난방기, 환풍기 꺼짐 확인'],
                                                                            3 => ['1층 현장으로 출입 전 오른쪽 탈의실 냉난방기 컨트롤러 근처', '소등, 냉난방기 꺼짐 확인'],
                                                                            4 => ['1층 현장으로 출입 전 왼쪽 탈의실 냉난방기 컨트롤러 근처', '소등, 냉난방기 꺼짐 확인'],
                                                                            5 => ['3층 기술연구소 출입 후 왼쪽 냉난방기 컨트롤러 근처', '냉난방기 꺼짐 확인'],
                                                                            6 => ['현장 마스크 라인 문', '마스크 라인 문 안쪽 복도 소등 확인'],
                                                                            7 => ['현장 마스크 자재창고 문', '마스크 자재창고 소등 확인 및 문 닫기']
                                                                        ];
                                                                        $first = true;
                                                                        foreach($nfc_list as $num => $info):
                                                                            $key = "NFC$num";
                                                                            $time_key = "NFC{$num}_TIME";
                                                                        ?>
                                                                        <tr>
                                                                            <?php if($first): ?><td rowspan="7" style="vertical-align: middle; text-align: center;">NFC</td><?php $first=false; endif; ?>
                                                                            <td><?= $info[0] ?></td>   
                                                                            <td><?= $info[1] ?></td> 
                                                                            <td style="text-align: center;">
                                                                                <input type='checkbox' name='<?= $key ?>' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList[$key]) && $Data_TodayCheckList[$key]=='on') ? 'checked' : ''; ?> disabled></td>  
                                                                            <td><?php echo h(isset($Data_TodayCheckList[$time_key]) ? date_format($Data_TodayCheckList[$time_key],"H:i:s") : ''); ?></td>                           
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table> 
                                                                <br> 
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>조치사항</label>
                                                                        <div class="input-group">    
                                                                            <textarea rows="8" class="form-control" name="note51"><?php echo h($Data_TodayCheckList['NOTE'] ?? ''); ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt51">입력</button>
                                                        </div>
                                                    </div>
                                                </form> 
                                            </div>
                                            <?php } ?>  
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
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    // 메모리 회수
    if(isset($connect)) { mysqli_close($connect); }	
    if(isset($connect6)) { sqlsrv_close($connect6); }
?>