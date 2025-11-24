<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.15>
	// Description:	<당직 리뉴얼>
    // Security Update: <2025.10.13> - Applied prepared statements to prevent SQL injection.
	// =============================================
    include 'duty_status.php';   

    // XSS 방지를 위한 헬퍼 함수
    function h($string) {
        if (!isset($string)) return '';
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- 메뉴 -->
        <?php include '../nav.php' ?>

        <!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">당직</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

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
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
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
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo h($tab2_text ?? '');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">              
                                            <!-- 현황!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">현황</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="duty.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body table-responsive p-2">  
                                                                <div class="row">
                                                                    <!-- 보드 시작 -->
                                                                    <?php 
                                                                        if(isset($Data_DutyToday['duty_change'])) {
                                                                            $title = $Data_DutyToday['duty_change'];
                                                                        } else {
                                                                            $title = $Data_DutyToday['duty_person'] ?? '';
                                                                        }
                                                                        // XSS 방지를 위해 h() 함수 사용
                                                                        BOARD(12, "primary", "금일당직", h($title), "fas fa-tasks");
                                                                    ?>
                                                                    <!-- 보드 끝 -->
                                                                </div> 
                                                                
                                                                <!-- Begin card-footer --> 
                                                                <?php 
                                                                    ModifyData2("duty.php?modi=Y", "bt22", "Duty");
                                                                ?>


                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table3">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>날짜</th>
                                                                                <th>휴일</th>
                                                                                <th>팀명</th>
                                                                                <th>당직자</th>
                                                                                <th>변경자</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                for($i=1; $i<=$num_result; $i++)
                                                                                {		
                                                                                    $row1 = mysqli_fetch_array($select_duty_result);

                                                                                    //날짜 형태 변환 (이런것들을 함수로 만들면 좋을텐데...)
                                                                                    $g_date = $row1['dt'];
                                                                                        
                                                                                    //날짜형태변환
                                                                                    $g_yy = substr($g_date, 0, 4);	
                                                                                    $g_mm = substr($g_date, 4, 2);
                                                                                    $g_dd = substr($g_date, 6, 2);    
                                                                                    $g_date2 = "$g_yy"."-"."$g_mm"."-"."$g_dd";	

                                                                                    //요일
                                                                                    $s_weekend = date('w', strtotime($g_date2));

                                                                                    if($s_weekend==0) {
                                                                                        $w_today='일';
                                                                                    }
                                                                                    else if($s_weekend==1) {
                                                                                        $w_today='월';
                                                                                    }
                                                                                    else if($s_weekend==2) {
                                                                                        $w_today='화';
                                                                                    }
                                                                                    else if($s_weekend==3) {
                                                                                        $w_today='수';
                                                                                    }
                                                                                    else if($s_weekend==4) {
                                                                                        $w_today='목';
                                                                                    }
                                                                                    else if($s_weekend==5) {
                                                                                        $w_today='금';
                                                                                    }
                                                                                    else if($s_weekend==6) {
                                                                                        $w_today='토';
                                                                                    }

                                                                                    // Prepared Statement로 변경
                                                                                    $stmt_team = $connect->prepare("SELECT TEAM_NM FROM user_info WHERE DUTY_NUM = ?");
                                                                                    $stmt_team->bind_param("s", $row1['duty_num']);
                                                                                    $stmt_team->execute();
                                                                                    $team_result = $stmt_team->get_result();
                                                                                    $team_row = mysqli_fetch_array($team_result);
                                                                            ?>  
                                                                            <tr>
                                                                                <td><?php if($modi=='Y') { echo h($row1['dt']); ?>(<?php echo h($w_today); ?>) <input name='DT<?php echo $i; ?>' value='<?php echo h($row1['dt']); ?>' type='hidden'> <?php } else {echo h($row1['dt']);?>(<?php echo h($w_today); ?>)<?php } ?></td>
                                                                                <td><?php echo h($row1['holiday_yn']); ?></td>
                                                                                <td><?php echo h($team_row['TEAM_NM'] ?? ''); ?></td>
                                                                                <td><?php echo h($row1['duty_person']); ?></td> 
                                                                                <td><?php if($modi=='Y') { ?> <input value='<?php echo h($row1['duty_change']); ?>' name='NOTE<?php echo $i; ?>' type='text'> <?php } else {echo h($row1['duty_change']);} ?></td>                                   
                                                                            </tr> 
                                                                            <?php 
                                                                                    if($row1 == false) {
                                                                                        break; // exit 대신 break 사용
                                                                                    }
                                                                                }
                                                                            ?> 
                                                                        </tbody>
                                                                    </table>    
                                                                </div> 

                                                                <!-- /.수정을 위해 필요 -->  
                                                                <input type="hidden" name="until" value="<?php echo h($i); ?>">

                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form> 
                                                </div>
                                                <!-- /.card -->
                                            </div>                                            
                                        </div>  

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo h($tab3_text ?? '');?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <!-- 통계!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">통계</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">      
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
                                                                    <?php 
                                                                        for($i=1; $i<=$Count_DutyTarget; $i++)
                                                                        {		
                                                                            $Data_DutyTarget =  mysqli_fetch_array($Result_DutyTarget); 

                                                                            // Prepared Statement로 변경
                                                                            $stmt_total1 = $connect->prepare("SELECT COUNT(*) AS count from duty WHERE holiday_yn='N' AND duty_change IS null and dt <= ? and duty_person=?");
                                                                            $stmt_total1->bind_param("ss", $NoHyphen_today, $Data_DutyTarget['USER_NM']);
                                                                            $stmt_total1->execute();
                                                                            $Result_DutyTotal = $stmt_total1->get_result();
                                                                            $Data_DutyTotal =  mysqli_fetch_array($Result_DutyTotal); 

                                                                            // Prepared Statement로 변경
                                                                            $stmt_total2 = $connect->prepare("SELECT COUNT(*) as count2 from duty WHERE holiday_yn='N' AND duty_change!='단체연차' and dt <= ? and duty_change=?");
                                                                            $stmt_total2->bind_param("ss", $NoHyphen_today, $Data_DutyTarget['USER_NM']);
                                                                            $stmt_total2->execute();
                                                                            $Result_DutyTotal2 = $stmt_total2->get_result();
                                                                            $Data_DutyTotal2 =  mysqli_fetch_array($Result_DutyTotal2); 

                                                                            $s_dt = new DateTime($Data_DutyTarget['DUTY_START']);
                                                                            $e_dt = new DateTime($Hyphen_today);
                                                                            $duty_count = ($Data_DutyTotal['count'] ?? 0) + ($Data_DutyTotal2['count2'] ?? 0);
                                                                            $days_diff = date_diff($s_dt, $e_dt)->days;
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo h($Data_DutyTarget['USER_NM']); ?></td>  
                                                                        <td><?php echo h($duty_count); ?></td>  
                                                                        <td><?php echo h($Data_DutyTarget['DUTY_START']); ?></td>  
                                                                        <td><?php echo h($days_diff); ?></td>  
                                                                        <td><?php if ($duty_count > 0) { echo floor($days_diff / $duty_count)."일에 1회 근무"; } ?></td> 
                                                                    </tr> 
                                                                    <?php 
                                                                            if($Data_DutyTarget == false) {
                                                                                break; // exit 대신 break 사용
                                                                            }
                                                                        }
                                                                    ?>       
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>                                                                                                                            
                                        </div> 

                                        <!-- 4번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo h($tab4_text ?? '');?>" id="custom-tabs-one-2th" role="tabpanel" aria-labelledby="custom-tabs-one-2th-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="duty.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample41">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 검색범위 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt4">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 검색범위 -->                                       
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt41">검색</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>  

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample42">
                                                        <div class="card-body table-responsive p-2">   
                                                            <table class="table table-bordered table-hover text-nowrap" id="table4">
                                                                <thead>
                                                                    <tr>
                                                                        <th>날짜</th>
                                                                        <th>팀명</th>
                                                                        <th>당직자</th>
                                                                        <th>변경자</th>                                                                        
                                                                        <th>당직확인</th>
                                                                        <th>당직확인(NFC)</th>
                                                                        <th>조치사항</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if (isset($Count_DutyInquire)) {
                                                                            for($i=1; $i<=$Count_DutyInquire; $i++)
                                                                            {		
                                                                                $Data_DutyInquire =  mysqli_fetch_array($Result_DutyInquire); 

                                                                                $stmt_team2 = $connect->prepare("SELECT TEAM_NM FROM user_info WHERE DUTY_NUM = ?");
                                                                                $stmt_team2->bind_param("s", $Data_DutyInquire['duty_num']);
                                                                                $stmt_team2->execute();
                                                                                $team_result2 = $stmt_team2->get_result();
                                                                                $team_row2 = mysqli_fetch_array($team_result2);

                                                                                //데이터 형태 변환
                                                                                $changeDT = date("Y-m-d", strtotime($Data_DutyInquire["dt"]));

                                                                                //당직확인
                                                                                $Query_DutyInquire2 = "SELECT * from CONNECT.dbo.DUTY WHERE SORTING_DATE=? and OUTSIDE1 IS NULL";              
                                                                                $Result_DutyInquire2 = sqlsrv_query($connect6, $Query_DutyInquire2, [$changeDT]);		
                                                                                $has_rows2 = sqlsrv_has_rows($Result_DutyInquire2);  
                                                                                $duty2 = $has_rows2 ? "N" : "Y";

                                                                                //당직확인(NFC)
                                                                                $Query_DutyInquire3 = "SELECT * from CONNECT.dbo.DUTY WHERE SORTING_DATE=? and NFC1 IS NULL";              
                                                                                $Result_DutyInquire3 = sqlsrv_query($connect6, $Query_DutyInquire3, [$changeDT]);		
                                                                                $has_rows3 = sqlsrv_has_rows($Result_DutyInquire3);
                                                                                $duty3 = $has_rows3 ? "N" : "Y";

                                                                                //조치사항
                                                                                $Query_DutyInquire4 = "SELECT NOTE from CONNECT.dbo.DUTY WHERE SORTING_DATE=?";              
                                                                                $Result_DutyInquire4 = sqlsrv_query($connect6, $Query_DutyInquire4, [$changeDT]);		
                                                                                $Data_DutyInquire4 = sqlsrv_fetch_array($Result_DutyInquire4); 
                                                                        ?>  
                                                                        <tr>
                                                                            <td><?php echo h($Data_DutyInquire['dt']); ?></td>
                                                                            <td><?php echo h($team_row2['TEAM_NM'] ?? ''); ?></td>
                                                                            <td><?php echo h($Data_DutyInquire['duty_person']); ?></td> 
                                                                            <td><?php echo h($Data_DutyInquire['duty_change']); ?></td>     
                                                                            <td><?php echo h($duty2); ?></td>        
                                                                            <td><?php echo h($duty3); ?></td>   
                                                                            <td><?php echo h($Data_DutyInquire4['NOTE'] ?? ''); ?></td>                      
                                                                        </tr> 
                                                                    <?php 
                                                                            if($Data_DutyInquire == false) {
                                                                                break; // exit 대신 break 사용
                                                                            }
                                                                        }
                                                                    } //end if
                                                                    ?>   
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                        </div> 


                                        <!-- 5번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo h($tab5_text ?? '');?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">  
                                            <?php  
                                                if(isMobile()) {  
                                            ?>
                                            <p>※ NFC 태그 위치 및 착안점은 PC로 확인 가능합니다!</p>
                                            <table class="table table-bordered col-lg-12">
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">NFC1</th>  
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC1']) && $Data_TodayCheckList['NFC1']=='on') ? 'checked' : ''; ?> disabled></td>  
                                                    </td>                                                                                       
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">NFC2</th>  
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC2']) && $Data_TodayCheckList['NFC2']=='on') ? 'checked' : ''; ?> disabled></td>  
                                                    </td>                                                                                       
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">NFC3</th>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC3']) && $Data_TodayCheckList['NFC3']=='on') ? 'checked' : ''; ?> disabled></td>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">NFC4</th>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC4']) && $Data_TodayCheckList['NFC4']=='on') ? 'checked' : ''; ?> disabled></td>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">NFC5</th>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC5' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC5']) && $Data_TodayCheckList['NFC5']=='on') ? 'checked' : ''; ?> disabled></td>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">NFC6</th>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC6' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC6']) && $Data_TodayCheckList['NFC6']=='on') ? 'checked' : ''; ?> disabled></td>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">NFC7</th>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC7' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC7']) && $Data_TodayCheckList['NFC7']=='on') ? 'checked' : ''; ?> disabled></td>
                                                    </td>
                                                </tr>
                                            </table>   
                                            
                                            <form method="POST" autocomplete="off" action="duty.php">     
                                                <table class="table table-bordered col-lg-12">
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;">사무동1층</th>  
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <input type='checkbox' name='FLOOR1_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR1_1']) && $Data_TodayCheckList['FLOOR1_1']=='on') ? 'checked' : ''; ?>></td>  
                                                        </td>                                                                                       
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;">사무동2층</th>  
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <input type='checkbox' name='FLOOR2_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR2_1']) && $Data_TodayCheckList['FLOOR2_1']=='on') ? 'checked' : ''; ?>></td>  
                                                        </td>                                                                                       
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;">사무동3층</th>  
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <input type='checkbox' name='FLOOR3_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_1']) && $Data_TodayCheckList['FLOOR3_1']=='on') ? 'checked' : ''; ?>></td>  
                                                        </td>                                                                                       
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;">옥상</th>  
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <input type='checkbox' name='FLOOR4_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR4_1']) && $Data_TodayCheckList['FLOOR4_1']=='on') ? 'checked' : ''; ?>></td>  
                                                        </td>                                                                                       
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;">현장</th>  
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <input type='checkbox' name='FILED1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FILED1']) && $Data_TodayCheckList['FILED1']=='on') ? 'checked' : ''; ?>></td>  
                                                        </td>                                                                                       
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: center; vertical-align: middle;">외곽</th>  
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <input type='checkbox' name='OUTSIDE1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE1']) && $Data_TodayCheckList['OUTSIDE1']=='on') ? 'checked' : ''; ?>></td>  
                                                        </td>                                                                                       
                                                    </tr>
                                                </table> 

                                                <!-- Begin card-footer --> 
                                                <div class="text-right">
                                                    <input type="hidden" name="mobile" value="on">
                                                    <button type="submit" value="on" class="btn btn-primary" name="bt51">입력</button>
                                                </div>
                                                <!-- /.card-footer --> 
                                            </form> 

                                            <?php  
                                                } else {  
                                            ?>
                                            <!-- 당직일지!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">당직일지</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="duty.php"> 
                                                        <!-- Card Content - Collapse -->
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
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='OUTSIDE1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE1']) && $Data_TodayCheckList['OUTSIDE1']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td rowspan="5" style="vertical-align: middle; text-align: center;">사무동3층</td>    
                                                                                <td>출입문 / 창문 잠김 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR3_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_1']) && $Data_TodayCheckList['FLOOR3_1']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr>   
                                                                            <tr>
                                                                                <td>출입문 / 셔터 / 창문 닫힘 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='OUTSIDE2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE2']) && $Data_TodayCheckList['OUTSIDE2']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td>에어컨 / 히터 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR3_2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_2']) && $Data_TodayCheckList['FLOOR3_2']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr>    
                                                                            <tr>
                                                                                <td>화재 / 누수 / 우수관 이상유무 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='OUTSIDE3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE3']) && $Data_TodayCheckList['OUTSIDE3']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td>화재 / 누수 이상유무 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR3_3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_3']) && $Data_TodayCheckList['FLOOR3_3']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr> 
                                                                            <tr>
                                                                                <td>외곽 수도 잠김 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='OUTSIDE4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE4']) && $Data_TodayCheckList['OUTSIDE4']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td>컴퓨터 / 모니터 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR3_4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_4']) && $Data_TodayCheckList['FLOOR3_4']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr> 
                                                                            <tr>
                                                                                <td>시설물 이상유무 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='OUTSIDE5' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['OUTSIDE5']) && $Data_TodayCheckList['OUTSIDE5']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td>[식당] 가스벨브 / 수도 이상유무 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR3_5' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR3_5']) && $Data_TodayCheckList['FLOOR3_5']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr>  
                                                                            <tr>
                                                                                <td rowspan="3" style="vertical-align: middle; text-align: center;">사무동1층(시험실 및 탈의실 포함)</td>    
                                                                                <td>창문 잠김 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR1_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR1_1']) && $Data_TodayCheckList['FLOOR1_1']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td rowspan="2" style="vertical-align: middle; text-align: center;">사무동4층</td>    
                                                                                <td>공조실 이상유무 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR4_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR4_1']) && $Data_TodayCheckList['FLOOR4_1']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr>   
                                                                            <tr>  
                                                                                <td>전등 소등 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR1_2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR1_2']) && $Data_TodayCheckList['FLOOR1_2']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td>보일러실 이상유무 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR4_2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR4_2']) && $Data_TodayCheckList['FLOOR4_2']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr>  
                                                                            <tr>  
                                                                                <td>에어컨 / 히터 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR1_3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR1_3']) && $Data_TodayCheckList['FLOOR1_3']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td rowspan="4" style="vertical-align: middle; text-align: center;">공장동(현장 및 창고 포함)</td>    
                                                                                <td>출입문 / 창문 잠김 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FILED1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FILED1']) && $Data_TodayCheckList['FILED1']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr>  
                                                                            <tr> 
                                                                                <td rowspan="4" style="vertical-align: middle; text-align: center;">사무동2층</td>    
                                                                                <td>출입문 / 창문 잠김 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR2_1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR2_1']) && $Data_TodayCheckList['FLOOR2_1']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td>에어컨 / 히터 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FILED2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FILED2']) && $Data_TodayCheckList['FILED2']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr>    
                                                                            <tr>  
                                                                                <td>에어컨 / 히터 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR2_2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR2_2']) && $Data_TodayCheckList['FLOOR2_2']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td>화재 / 누수 이상유무 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FILED3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FILED3']) && $Data_TodayCheckList['FILED3']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr>
                                                                            <tr>  
                                                                                <td>화재 / 누수 이상유무 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR2_3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR2_3']) && $Data_TodayCheckList['FLOOR2_3']=='on') ? 'checked' : ''; ?>></td>  
                                                                                <td>전등 소등 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FILED4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FILED4']) && $Data_TodayCheckList['FILED4']=='on') ? 'checked' : ''; ?>></td>  
                                                                            </tr>
                                             <tr>  
                                                                                <td>컴퓨터 / 모니터 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='FLOOR2_4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['FLOOR2_4']) && $Data_TodayCheckList['FLOOR2_4']=='on') ? 'checked' : ''; ?>></td>  
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
                                                                            <tr>
                                                                                <td rowspan="7" style="vertical-align: middle; text-align: center;">NFC</td>  
                                                                                <td>1층 라운지 복도 TV 밑</td>   
                                                                                <td>1층 라운지 및 라운지 앞 복도 소등, TV 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='NFC1' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC1']) && $Data_TodayCheckList['NFC1']=='on') ? 'checked' : ''; ?> disabled></td>  
                                                                                <td><?php echo h(isset($Data_TodayCheckList['NFC1_TIME']) ? date_format($Data_TodayCheckList['NFC1_TIME'],"H:i:s") : ''); ?></td>                           
                                                                            </tr>   
                                                                            <tr>
                                                                                <td>1층 시험실로 출입 전 좌측 냉난방기 컨트롤러 근처</td> 
                                                                                <td>냉난방기, 환풍기 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='NFC2' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC2']) && $Data_TodayCheckList['NFC2']=='on') ? 'checked' : ''; ?> disabled></td>  
                                                                                <td><?php echo h(isset($Data_TodayCheckList['NFC2_TIME']) ? date_format($Data_TodayCheckList['NFC2_TIME'],"H:i:s") : ''); ?></td>                             
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1층 현장으로 출입 전 오른쪽 탈의실 냉난방기 컨트롤러 근처</td> 
                                                                                <td>소등, 냉난방기 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='NFC3' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC3']) && $Data_TodayCheckList['NFC3']=='on') ? 'checked' : ''; ?> disabled></td>  
                                                                                <td><?php echo h(isset($Data_TodayCheckList['NFC3_TIME']) ? date_format($Data_TodayCheckList['NFC3_TIME'],"H:i:s") : ''); ?></td>                                
                                                                            </tr> 
                                                                            <tr>
                                                                                <td>1층 현장으로 출입 전 왼쪽 탈의실 냉난방기 컨트롤러 근처</td> 
                                                                                <td>소등, 냉난방기 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='NFC4' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC4']) && $Data_TodayCheckList['NFC4']=='on') ? 'checked' : ''; ?> disabled></td>  
                                                                                <td><?php echo h(isset($Data_TodayCheckList['NFC4_TIME']) ? date_format($Data_TodayCheckList['NFC4_TIME'],"H:i:s") : ''); ?></td>                             
                                                                            </tr> 
                                                                            <tr>
                                                                                <td>3층 기술연구소 출입 후 왼쪽 냉난방기 컨트롤러 근처</td> 
                                                                                <td>냉난방기 꺼짐 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='NFC5' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC5']) && $Data_TodayCheckList['NFC5']=='on') ? 'checked' : ''; ?> disabled></td>  
                                                                                <td><?php echo h(isset($Data_TodayCheckList['NFC5_TIME']) ? date_format($Data_TodayCheckList['NFC5_TIME'],"H:i:s") : ''); ?></td>                          
                                                                            </tr>  
                                                                            <tr>
                                                                                <td>현장 마스크 라인 문</td> 
                                                                                <td>마스크 라인 문 안쪽 복도 소등 확인</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='NFC6' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC6']) && $Data_TodayCheckList['NFC6']=='on') ? 'checked' : ''; ?> disabled></td>  
                                                                                <td><?php echo h(isset($Data_TodayCheckList['NFC6_TIME']) ? date_format($Data_TodayCheckList['NFC6_TIME'],"H:i:s") : ''); ?></td>                          
                                                                            </tr>  
                                                                            <tr>
                                                                                <td>현장 마스크 자재창고 문</td> 
                                                                                <td>마스크 자재창고 소등 확인 및 문 닫기</td> 
                                                                                <td style="text-align: center;">
                                                                                    <input type='checkbox' name='NFC7' style='zoom: 2;' <?php echo (isset($Data_TodayCheckList['NFC7']) && $Data_TodayCheckList['NFC7']=='on') ? 'checked' : ''; ?> disabled></td>  
                                                                                <td><?php echo h(isset($Data_TodayCheckList['NFC7_TIME']) ? date_format($Data_TodayCheckList['NFC7_TIME'],"H:i:s") : ''); ?></td>                          
                                                                            </tr>                                                                                                                                             
                                                                        </tbody>
                                                                    </table> 
                                                                    <br> 
                                                                    <!-- Begin 조치사항 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>조치사항</label>
                                                                            <div class="input-group">    
                                                                                <textarea rows="8" class="form-control" name="note51"><?php echo $Data_TodayCheckList['NOTE'] ?? ''; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 조치사항 --> 
                                                                </div> 
                                                            </div>
                                                            <!-- /.card-body -->

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt51">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->  
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form> 
                                                </div>
                                                <!-- /.card -->
                                            </div> 
                                            <?php  
                                                } 
                                            ?>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   

                        <!-- end !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if(isset($connect)) { mysqli_close($connect); }	

    //MSSQL 메모리 회수
    if(isset($connect6)) { sqlsrv_close($connect6); }
?>
