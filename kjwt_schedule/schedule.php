<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.26>
	// Description:	<직원차량>
    // Last Modified: <Current Date> - Mobile UI Optimization
	// =============================================
    include 'schedule_status.php';

    // XSS 방지 함수
    function h($string) {
        if (!isset($string)) return '';
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    // [데이터 전처리] 방문 일정 데이터를 배열로 저장
    $schedule_list = [];
    if (isset($Result_schedule) && $Result_schedule) {
        // DB4 연결 필요 (담당자 정보 조회용)
        include_once __DIR__ . '/../DB/DB4.php'; 

        while ($row = $Result_schedule->fetch_assoc()) {
            $emp_seq = $row['create_seq'];
            $user_nm = '';
            $user_call = '';

            // 사원번호로 로그인 ID 검색 (DB3: gw)
            $stmt_emp = $connect3->prepare("SELECT login_id FROM t_co_emp WHERE emp_seq = ?");
            $stmt_emp->bind_param('s', $emp_seq);
            if ($stmt_emp->execute()) {
                $res_emp = $stmt_emp->get_result()->fetch_assoc();
                if ($res_emp && isset($res_emp['login_id'])) {
                    // 로그인 ID로 사용자 정보 검색 (DB4: fms)
                    $login_id = $res_emp['login_id'];
                    $stmt_user = $connect4->prepare("SELECT USER_NM, `CALL` FROM user_info WHERE ENG_NM = ?");
                    $stmt_user->bind_param('s', $login_id);
                    if ($stmt_user->execute()) {
                        $res_user = $stmt_user->get_result()->fetch_assoc();
                        if ($res_user) {
                            $user_nm = $res_user['USER_NM'];
                            $user_call = $res_user['CALL'];
                        }
                    }
                    $stmt_user->close();
                }
            }
            $stmt_emp->close();

            // 날짜 포맷팅 (시간 제거)
            $start_date = new DateTime($row['start_date']);
            $end_date = new DateTime($row['end_date']);

            $schedule_list[] = [
                'START_DATE' => $start_date->format('Y-m-d'),
                'END_DATE' => $end_date->format('Y-m-d'),
                'TITLE' => $row['sch_title'],
                'USER_NM' => $user_nm,
                'CALL' => $user_call
            ];
        }
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>    
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">방문정보</h1>
                    </div>               

                    <div class="row"> 

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab2 ?? '');?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 방문자정보 공유<BR><BR>   

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 경비원<br>
                                            - 그룹웨어 방문자 일정 공유<br><br>
                                                                                   
                                            [제작일]<BR>
                                            - 22.05.26<br><br>
                                        </div>
                                        
                                        <div class="tab-pane fade <?php echo h($tab2_text ?? '');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">방문일정</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample21">
                                                    <div class="card-body p-2"> 
                                                        
                                                        <div class="d-md-none">
                                                            <?php foreach ($schedule_list as $row): ?>
                                                            <div class="card mb-2">
                                                                <div class="card-body p-3">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <h6 class="font-weight-bold text-primary mb-0"><?= h($row['TITLE']) ?></h6>
                                                                        <span class="badge badge-secondary"><?= h($row['USER_NM']) ?></span>
                                                                    </div>
                                                                    <div class="row mb-1">
                                                                        <div class="col-4 small font-weight-bold text-gray-600">방문일</div>
                                                                        <div class="col-8 small"><?= h($row['START_DATE']) ?></div>
                                                                    </div>
                                                                    <div class="row mb-1">
                                                                        <div class="col-4 small font-weight-bold text-gray-600">종료일</div>
                                                                        <div class="col-8 small"><?= h($row['END_DATE']) ?></div>
                                                                    </div>
                                                                    <div class="row mb-0 align-items-center">
                                                                        <div class="col-4 small font-weight-bold text-gray-600">내선번호</div>
                                                                        <div class="col-8 small">
                                                                            <?php if(!empty($row['CALL'])): ?>
                                                                                <a href="tel:<?= h($row['CALL']) ?>" class="text-decoration-none">
                                                                                    <i class="fas fa-phone-alt mr-1"></i><?= h($row['CALL']) ?>
                                                                                </a>
                                                                            <?php else: ?>
                                                                                -
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                            <?php if(empty($schedule_list)): ?>
                                                                <div class="text-center p-3 text-gray-500">등록된 방문 일정이 없습니다.</div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-striped" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>방문일</th>
                                                                        <th>종료일</th>   
                                                                        <th>내용</th>
                                                                        <th>담당자</th>
                                                                        <th>내선</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($schedule_list as $row): ?>                                                                            
                                                                        <tr> 
                                                                            <td><?= h($row['START_DATE']) ?></td>                                                                                              
                                                                            <td><?= h($row['END_DATE']) ?></td>  
                                                                            <td><?= h($row['TITLE']) ?></td> 
                                                                            <td><?= h($row['USER_NM']) ?></td> 
                                                                            <td><?= h($row['CALL']) ?></td> 
                                                                        </tr>                                                                           
                                                                    <?php endforeach; ?>                     
                                                                </tbody>
                                                            </table>
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
                    </div>
                </div>
            </div>
        </div>
    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    // 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }
    if(isset($connect3)) { mysqli_close($connect3); }
?>