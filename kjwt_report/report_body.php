<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.09.01>
	// Description:	<레포트 리뉴얼>	
    // Last Modified: <25.10.20> - Refactored for PHP 8.x	
	// =============================================
    include 'report_body_status.php';   
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
                    </div>       

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab1;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">information</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">경영</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4;?>" id="custom-tabs-one-4th-tab" data-toggle="pill" href="#custom-tabs-one-4th">회계</a>
                                        </li>   
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="custom-tabs-one-5th-tab" data-toggle="pill" href="#custom-tabs-one-5th">물류</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab6;?>" id="custom-tabs-one-6th-tab" data-toggle="pill" href="#custom-tabs-one-6th">매출</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab7;?>" id="custom-tabs-one-7th-tab" data-toggle="pill" href="#custom-tabs-one-7th">품질</a>
                                        </li>   
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab8;?>" id="custom-tabs-one-8th-tab" data-toggle="pill" href="#custom-tabs-one-8th">수주</a>
                                        </li>     
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab9;?>" id="custom-tabs-one-9th-tab" data-toggle="pill" href="#custom-tabs-one-9th">YouTube</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab10;?>" id="custom-tabs-one-10th-tab" data-toggle="pill" href="#custom-tabs-one-10th"><img src="../img/flag_v.webp" style="width: 2vw;"> 베트남</a>
                                        </li>            
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab1_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <p style="font-weight: bold;">[변경사항]</p>
                                            <p style="color: red;">         
                                                [25.10~12]<br>
                                                - [물류] 운송 데이터 미출력 에러 해결<br>
                                                - [품질] 그래프 금년 데이터 미출력 에러 해결<br>
                                            </p>

                                            -----------------------------------------------------------------<br><br> 
                                            
                                            [개발컨셉]<br>
                                            - 과거 회장님 방에 각팀에서 A3에 출력하여 현황을 업데이트했던 것을 모티브로 임원 입장에서 궁금해할 만한 비용을 위주로 항목을 구성함<br>
                                            - 기초데이터 입력 인력이 변경되어도 해당 업무가 소실되지 않는 것을 위주로 구성<br>
                                            - 개발자가 손되지 않아도 자동으로 업데이트 되도록 개발<br><br> 
                                        
                                            -----------------------------------------------------------------<br><br> 
                                        
                                            <del>[생산]</del><br>
                                            <del> - 전일 기준</del><br><br>

                                            [경영]<br>
                                            도급비)<br>
                                            - 경비 용역비 제외<br>
                                            - 내부회계로 인하여 22년 8월부터 GW 지출결의서 작성하여 이전 데이터 없음<br>
                                            전기사용량)<br>
                                            - 한국전력공사 정책으로 인해 시작일은 16일<br>
                                            - 24.8.24 부터 모자분리로 적용 전기요금이 변경됨<br>
                                            - 적용전기요금 : 산업용(을)고압A -> 산업용(갑)고압2<br>
                                            - 기본요금 : 8,320원 -> 7,470원<br>
                                            - AMI(원격검침)은 메인 계량기에만 부착되어 있고 모자분리된 계량기에 설치되어 있지 않음<br>                                             
                                            전기비)<br>
                                            - 24년 부터 모자분리로 인하여 전기비 지출결의서가 2개가 생성이 된다.<br>
                                            - 이 때 지출결의서 상신일이 상이하므로 전기비가 갑자기 증가할 수 있다.<br>
                                            예시) 어제 3월 전기비가 300만원이었는데 오늘 조회하니 800만원으로 변경<br><br>

                                            [회계]<br>
                                            매출원가)<br>
                                            - 급여(도급), 포장비, 툴외, 유틸리티, 소모품 등<br>
                                            판매비와 관리비)<br>
                                            - 급여(사무, 이사), 전력비, 물류비, 소모품, 차량 유지 등<br>
                                            영업 외 이익)<br>
                                            - 금융수익, 금융비용, 기타수익, 기타비용, 법인세비용, 관계기업 투자손익 등<br><br>  

                                            [물류]<br>
                                            운반비)<br>
                                            - 손익계산서 판관비의 운반비<br> 
                                            - 2023년 12월, 슬로바키아로부터 항공물류비 사용금액에 대하여 보상을 받음<br> 
                                            운송 완료)<br>
                                            - 엑셀에서 표현되는 update 열(수정일) 날짜를 기준으로 현재 일로부터 3개월 분만 출력<br><br> 

                                            [YouTube]<br>
                                            - 해당 채널의 신차와 관련된 플레이 리스트만 수집하여 출력<br><br>
                                            
                                            -----------------------------------------------------------------<br><br> 

                                            [데이터 원본]<br> 
                                            <del>- 검사 및 포장 실적: FMS 검수반 입력 데이터</del><br> 
                                            <del>- 완성품 창고 출하실적: FMS 지입 기사 입력 데이터</del><br> 
                                            - 근태: 세콤 근태기 데이터<br> 
                                            - 폐기물: 한국환경공단 올바로 데이터<br> 
                                            - 도급비: GW 경영팀 입력 데이터(23년 기준 박진영sw)<br> 
                                            - 수도비: GW 경영팀 입력 데이터(23년 기준 박진영sw)<br> 
                                            - 가스비: GW 재무팀 입력 데이터(23년 기준 박민정sw)<br> 
                                            - 전기비: GW 재무팀 입력 데이터(23년 기준 박민정sw)<br> 
                                            - 수도/가스 사용량: FMS 경비원 입력 데이터<br> 
                                            - 전기 사용량: 한국전력공사 검침 데이터 / <br>
                                            - 회계: 금융감독원 DART 데이터<br>
                                            - 물류: 물류 담당자 엑셀 데이터(23년 기준 장정권dr / 선박정보 업데이트 support 이혜미sw)<br>
                                            - 매출: 매출 담당자 엑셀 데이터(23년 기준 고명빈sw)<br>
                                            - 품질: 품질 담당자 엑셀 데이터(23년 기준 우무용dr)<br>
                                            - 수주: 차종별 개발 일정 담당자 엑셀 데이터(23년 기준 민정문dr)<br>
                                            - 베트남: 베트남 인사 담당자 엑셀 데이터<br><br> 

                                            -----------------------------------------------------------------<br><br> 

                                            [관리 포인트]<br> 
                                            - 데이터 원본에서 알맞는 데이터를 가져오는가?<br> 
                                            >> 일일업무보고 엑셀 데이터를 잘 작성하는가? (양식 변경, 서식 변경 등 모니터링) <br>
                                            - 물류 선박 정보 업데이트 (VESSEL 테이블) <br> 
                                            - FMS 서버 - NAS 마운트 관리 (서버 재시작 시 DISCONNECT 됨) <br>
                                            - 년도 변경 시 사용자가 12월 집계를 마치지 않아 데이터베이스를 강제로 조정해야 함(매출, 품질)<br>
                                            - 전기사용량을 제대로 가져오지 않는 경우가 있으며 이때 파워플래너에서 해당일 데이터를 조회하여 데이터 보정을 해야함<br>
                                            - 1년 단위로 에너지마켓플레이스 정보제공동의를 해야함<br><br>     
                                            
                                            -----------------------------------------------------------------<br><br> 

                                            [ISO14001]<br>
                                            - 매출액 1억원당 이산화탄소 발생량 표 생성하기로 함<br>
                                            - ISO14001 인증 시 매년 필요한 값<br>
                                            : 전기(Kwh -> Kw)<br>
                                            전기수식(총 kwh 합계)/(365*24h)/(그해매출액/1억)<br>
                                            : 가스(㎥ -> MJ)<br>
                                            가스수식 MJ값/43.05MJ (1㎥ = 43.05MJ)<br>
                                            : 용수(㎥ -> Ton)<br>
                                            용수수식 1㎥ = 1000L = 1Ton
                                        </div>

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2 mt-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample31t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample31t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 근태</h6>
                                                        </a>
                                                        
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31t">                                    
                                                            <div class="card-body">  
                                                                <div class="col-lg-12">    
                                                                    <div class="row">
                                                                        <?php 
                                                                            //board2 펑션에서 덧셈수식을 활용하여 표시하니 앞에 사무직, 도급직 개별 숫자는 무시되어 별도로 덧셈한것을 변수에 집어 넣어 표현함
                                                                            $attend_total = $attendA_row['COU']+$attend7_row['COU'];                                                                            
                                                                            BOARD2(3, "info", "사무직/도급직/합계(명)", $attendA_row['COU']." / ".$attend7_row['COU']." / ".$attend_total, "fas fa-user", "shortcut", "https://fms.iwin.kr/kjwt_gw/gw_attend.php");    
                                                                            BOARD2(3, "info", "바로가기", "ESG보고서", "fas fa-solar-panel", "shortcut", "https://fms.iwin.kr/kjwt_esg/esg.php");  
                                                                            BOARD2(3, "info", "바로가기", "전산보고서", "fas fa-file-alt", "shortcut", "https://fms.iwin.kr/kjwt_report/report_network.php"); 
                                                                            BOARD2(3, "info", "바로가기", "경비보고서", "fas fa-user-tie", "shortcut", "https://fms.iwin.kr/kjwt_report/report_guard.php");                                                 
                                                                        ?>
                                                                    </div>
                                                                </div>                                                                
                                                                <!-- 차트 - 사무직 인원증감 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                <div class="col-lg-12"> 
                                                                    <!-- Collapsable Card Example -->
                                                                    <div class="card shadow mb-2 mt-2">
                                                                        <div class="card-header">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample311t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample311t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 사무</h6>
                                                                            </a>
                                                                            <div class="card-tools mt-3">
                                                                                <ul class="nav nav-pills ml-auto">
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link active" href="#p_chart" data-toggle="tab">비용</a>
                                                                                    </li>
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link" href="#p_number" data-toggle="tab">인원</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.card-header -->
                                                                        <!-- Card Content - Collapse -->
                                                                        <div class="collapse show" id="collapseCardExample311t">                                    
                                                                            <div class="card-body">
                                                                                <div class="tab-content p-0">  
                                                                                    <div class="chart tab-pane active" id="p_chart" style="position: relative; height: 300px;">
                                                                                        <canvas id="barChart55"></canvas>
                                                                                    </div>
                                                                                    <div class="chart tab-pane" id="p_number" style="position: relative; height: 300px;">
                                                                                        <canvas id="barChart44"></canvas>
                                                                                    </div>
                                                                                </div>        
                                                                            </div> 
                                                                            <!-- /.card-body -->              
                                                                        </div>
                                                                        <!-- /.Card Content - Collapse -->
                                                                    </div>
                                                                    <!-- /.card -->
                                                                </div> 
                                                                <!-- 차트 - 도급직 인원증감 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                <div class="col-lg-12"> 
                                                                    <!-- Collapsable Card Example -->
                                                                    <div class="card shadow mb-2 mt-2">
                                                                        <div class="card-header">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample313t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample313t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-2. 도급</h6>
                                                                            </a>
                                                                            <div class="card-tools mt-3">
                                                                                <ul class="nav nav-pills ml-auto">
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link active" href="#p2_chart" data-toggle="tab">비용</a>
                                                                                    </li>
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link" href="#p2_number" data-toggle="tab">인원</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.card-header -->
                                                                        <!-- Card Content - Collapse -->
                                                                        <div class="collapse show" id="collapseCardExample313t">                                    
                                                                            <div class="card-body">
                                                                                <div class="tab-content p-0">  
                                                                                    <div class="chart tab-pane active" id="p2_chart" style="position: relative; height: 300px;">
                                                                                        <canvas id="barChart5"></canvas>
                                                                                    </div>
                                                                                    <div class="chart tab-pane" id="p2_number" style="position: relative; height: 300px;">
                                                                                        <canvas id="barChart4"></canvas>
                                                                                    </div>
                                                                                </div>          
                                                                            </div> 
                                                                            <!-- /.card-body -->              
                                                                        </div>
                                                                        <!-- /.Card Content - Collapse -->
                                                                    </div>
                                                                    <!-- /.card -->
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <!-- Begin row -->
                                            <div class="row">   
                                                <!-- 차트 - 전기 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <div class="card-header">
                                                            <!-- Card Header - Accordion -->
                                                            <a href="#collapseCardExample321t" class="d-block card-header py-3" data-toggle="collapse"
                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample321t">
                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#2-1. 전기</h6>
                                                            </a>
                                                            <div class="card-tools mt-3">
                                                                <ul class="nav nav-pills ml-auto">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" href="#e_chart" data-toggle="tab">비용(그래프)</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#e_number" data-toggle="tab">비용(표)</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#e_use" data-toggle="tab">사용량(KWH)</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample321t">                                    
                                                            <div class="card-body">
                                                                <div class="tab-content p-0">  
                                                                    <div class="chart tab-pane active" id="e_chart" style="position: relative; height: 300px;">
                                                                        <canvas id="barChart33"></canvas>
                                                                    </div>
                                                                    <div class="chart tab-pane" id="e_number" style="position: relative; height: 300px;">
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr style="text-align: center;">
                                                                                        <?php
                                                                                        // 💡 1단계: 헤더(머리글)를 배열로 만든 후 for문으로 출력
                                                                                        $headers = ['#', '년 합계', '월 누적 합계'];
                                                                                        foreach ($headers as $header) {
                                                                                            echo "<th scope='col'>{$header}</th>";
                                                                                        }
                                                                                        // 1월부터 12월까지의 헤더를 for문으로 생성
                                                                                        for ($month = 1; $month <= 12; $month++) {
                                                                                            echo "<th scope='col'>{$month}월</th>";
                                                                                        }
                                                                                        ?>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    // 💡 2단계: 올해와 작년 데이터를 하나의 배열로 묶어 처리
                                                                                    $tableData = [
                                                                                        // 올해 데이터 정보
                                                                                        [
                                                                                            'label' => $YY,
                                                                                            'yearTotalVar' => $Data_ThisYearFee0,
                                                                                            'monthTotalVar' => $Data_ThisYearFee00,
                                                                                            'monthlyVarPrefix' => 'Data_ThisYearFee' // 월별 변수 이름의 앞부분
                                                                                        ],
                                                                                        // 작년 데이터 정보
                                                                                        [
                                                                                            'label' => $Minus1YY,
                                                                                            'yearTotalVar' => $Data_LastYearFee0,
                                                                                            'monthTotalVar' => $Data_LastYearFee00,
                                                                                            'monthlyVarPrefix' => 'Data_LastYearFee'
                                                                                        ]
                                                                                    ];

                                                                                    // 💡 3단계: 묶은 데이터를 foreach문으로 돌면서 행(<tr>) 생성
                                                                                    foreach ($tableData as $rowData) :
                                                                                    ?>
                                                                                        <tr style="text-align: center;">
                                                                                            <th scope="row"><?php echo $rowData['label']; ?></th>
                                                                                            <td><?php echo number_format($rowData['yearTotalVar']['ELECTRICITY'] ?? 0); ?></td>
                                                                                            <td><?php echo number_format($rowData['monthTotalVar']['ELECTRICITY'] ?? 0); ?></td>

                                                                                            <?php
                                                                                            // 💡 4단계: 안쪽 for문으로 12개월치 셀(<td>)을 동적으로 생성
                                                                                            for ($month = 1; $month <= 12; $month++) {
                                                                                                // '$Data_ThisYearFee' + '1' => '$Data_ThisYearFee1' 처럼 변수 이름을 동적으로 만듭니다.
                                                                                                $variableName = $rowData['monthlyVarPrefix'] . $month;
                                                                                                
                                                                                                // 동적으로 만들어진 이름의 변수에 접근하고, ELECTRICITY 값을 가져옵니다.
                                                                                                // 변수가 존재하지 않을 경우를 대비해 ?? 0으로 안전하게 처리합니다.
                                                                                                $ELECTRICITYValue = ${$variableName}['ELECTRICITY'] ?? 0;

                                                                                                echo '<td>' . number_format($ELECTRICITYValue) . '</td>';
                                                                                            }
                                                                                            ?>
                                                                                        </tr>
                                                                                    <?php endforeach; ?>
                                                                                </tbody>
                                                                            </table> 
                                                                        </div>                                                                                           
                                                                    </div>
                                                                    <div class="chart tab-pane" id="e_use" style="position: relative; height: 300px;">
                                                                        <canvas id="barChart3" height="300" style="height: 300px;"></canvas>
                                                                    </div>                                                                    
                                                                </div>       
                                                            </div> 
                                                            <!-- /.card-body -->              
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                                
                                                <!-- 차트 - 가스 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <div class="card-header">
                                                            <!-- Card Header - Accordion -->
                                                            <a href="#collapseCardExample323t" class="d-block card-header py-3" data-toggle="collapse"
                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample323t">
                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#2-2. 가스</h6>
                                                            </a>
                                                            <div class="card-tools mt-3">
                                                                <ul class="nav nav-pills ml-auto">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" href="#g_chart" data-toggle="tab">비용(그래프)</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#g_number" data-toggle="tab">비용(표)</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#g_use" data-toggle="tab">사용량(㎥)
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div><!-- /.card-header -->
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample323t">                                    
                                                            <div class="card-body">
                                                                <div class="tab-content p-0">  
                                                                    <div class="chart tab-pane active" id="g_chart" style="position: relative; height: 300px;">
                                                                        <canvas id="barChart22"></canvas>
                                                                    </div>
                                                                    <div class="chart tab-pane" id="g_number" style="position: relative; height: 300px;">
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr style="text-align: center;">
                                                                                        <?php
                                                                                        // 💡 1단계: 헤더(머리글)를 배열로 만든 후 for문으로 출력
                                                                                        $headers = ['#', '년 합계', '월 누적 합계'];
                                                                                        foreach ($headers as $header) {
                                                                                            echo "<th scope='col'>{$header}</th>";
                                                                                        }
                                                                                        // 1월부터 12월까지의 헤더를 for문으로 생성
                                                                                        for ($month = 1; $month <= 12; $month++) {
                                                                                            echo "<th scope='col'>{$month}월</th>";
                                                                                        }
                                                                                        ?>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    // 💡 2단계: 올해와 작년 데이터를 하나의 배열로 묶어 처리
                                                                                    $tableData = [
                                                                                        // 올해 데이터 정보
                                                                                        [
                                                                                            'label' => $YY,
                                                                                            'yearTotalVar' => $Data_ThisYearFee0,
                                                                                            'monthTotalVar' => $Data_ThisYearFee00,
                                                                                            'monthlyVarPrefix' => 'Data_ThisYearFee' // 월별 변수 이름의 앞부분
                                                                                        ],
                                                                                        // 작년 데이터 정보
                                                                                        [
                                                                                            'label' => $Minus1YY,
                                                                                            'yearTotalVar' => $Data_LastYearFee0,
                                                                                            'monthTotalVar' => $Data_LastYearFee00,
                                                                                            'monthlyVarPrefix' => 'Data_LastYearFee'
                                                                                        ]
                                                                                    ];

                                                                                    // 💡 3단계: 묶은 데이터를 foreach문으로 돌면서 행(<tr>) 생성
                                                                                    foreach ($tableData as $rowData) :
                                                                                    ?>
                                                                                        <tr style="text-align: center;">
                                                                                            <th scope="row"><?php echo $rowData['label']; ?></th>
                                                                                            <td><?php echo number_format($rowData['yearTotalVar']['GAS'] ?? 0); ?></td>
                                                                                            <td><?php echo number_format($rowData['monthTotalVar']['GAS'] ?? 0); ?></td>

                                                                                            <?php
                                                                                            // 💡 4단계: 안쪽 for문으로 12개월치 셀(<td>)을 동적으로 생성
                                                                                            for ($month = 1; $month <= 12; $month++) {
                                                                                                // '$Data_ThisYearFee' + '1' => '$Data_ThisYearFee1' 처럼 변수 이름을 동적으로 만듭니다.
                                                                                                $variableName = $rowData['monthlyVarPrefix'] . $month;
                                                                                                
                                                                                                // 동적으로 만들어진 이름의 변수에 접근하고, GAS 값을 가져옵니다.
                                                                                                // 변수가 존재하지 않을 경우를 대비해 ?? 0으로 안전하게 처리합니다.
                                                                                                $GASValue = ${$variableName}['GAS'] ?? 0;

                                                                                                echo '<td>' . number_format($GASValue) . '</td>';
                                                                                            }
                                                                                            ?>
                                                                                        </tr>
                                                                                    <?php endforeach; ?>
                                                                                </tbody>
                                                                            </table>     
                                                                        </div>                                                                                          
                                                                    </div>
                                                                    <div class="chart tab-pane" id="g_use" style="position: relative; height: 300px;">
                                                                        <canvas id="barChart2"></canvas>
                                                                    </div>
                                                                </div>          
                                                            </div> 
                                                            <!-- /.card-body -->              
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div> 

                                                <!-- 차트 - 수도 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->                                                                 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2 mt-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample32t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample32t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#2. 에너지</h6>
                                                        </a>
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32t">                                    
                                                            <div class="card-body">
                                                                <div class="col-lg-12"> 
                                                                    <!-- Collapsable Card Example -->
                                                                    <div class="card shadow mb-2 mt-2">
                                                                        <div class="card-header">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample336t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample325t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#2-3. 수도</h6>
                                                                            </a>
                                                                            <div class="card-tools mt-3">
                                                                                <ul class="nav nav-pills ml-auto">
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link active" href="#w_chart" data-toggle="tab">비용(그래프)</a>
                                                                                    </li>
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link" href="#w_number" data-toggle="tab">비용(표)</a>
                                                                                    </li>
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link" href="#w_use" data-toggle="tab">사용량(㎥)</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Card Content - Collapse -->
                                                                        <div class="collapse show" id="collapseCardExample325t">                                    
                                                                            <div class="card-body">
                                                                                <div class="tab-content p-0">  
                                                                                    <div class="chart tab-pane active" id="w_chart" style="position: relative; height: 300px;">
                                                                                        <canvas id="barChart11"></canvas>
                                                                                    </div>    
                                                                                    <div class="chart tab-pane" id="w_number" style="position: relative; height: 300px;">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table">
                                                                                                <thead>
                                                                                                    <tr style="text-align: center;">
                                                                                                        <?php
                                                                                                        // 💡 1단계: 헤더(머리글)를 배열로 만든 후 for문으로 출력
                                                                                                        $headers = ['#', '년 합계', '월 누적 합계'];
                                                                                                        foreach ($headers as $header) {
                                                                                                            echo "<th scope='col'>{$header}</th>";
                                                                                                        }
                                                                                                        // 1월부터 12월까지의 헤더를 for문으로 생성
                                                                                                        for ($month = 1; $month <= 12; $month++) {
                                                                                                            echo "<th scope='col'>{$month}월</th>";
                                                                                                        }
                                                                                                        ?>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <?php
                                                                                                    // 💡 2단계: 올해와 작년 데이터를 하나의 배열로 묶어 처리
                                                                                                    $tableData = [
                                                                                                        // 올해 데이터 정보
                                                                                                        [
                                                                                                            'label' => $YY,
                                                                                                            'yearTotalVar' => $Data_ThisYearFee0,
                                                                                                            'monthTotalVar' => $Data_ThisYearFee00,
                                                                                                            'monthlyVarPrefix' => 'Data_ThisYearFee' // 월별 변수 이름의 앞부분
                                                                                                        ],
                                                                                                        // 작년 데이터 정보
                                                                                                        [
                                                                                                            'label' => $Minus1YY,
                                                                                                            'yearTotalVar' => $Data_LastYearFee0,
                                                                                                            'monthTotalVar' => $Data_LastYearFee00,
                                                                                                            'monthlyVarPrefix' => 'Data_LastYearFee'
                                                                                                        ]
                                                                                                    ];

                                                                                                    // 💡 3단계: 묶은 데이터를 foreach문으로 돌면서 행(<tr>) 생성
                                                                                                    foreach ($tableData as $rowData) :
                                                                                                    ?>
                                                                                                        <tr style="text-align: center;">
                                                                                                            <th scope="row"><?php echo $rowData['label']; ?></th>
                                                                                                            <td><?php echo number_format($rowData['yearTotalVar']['WATER'] ?? 0); ?></td>
                                                                                                            <td><?php echo number_format($rowData['monthTotalVar']['WATER'] ?? 0); ?></td>

                                                                                                            <?php
                                                                                                            // 💡 4단계: 안쪽 for문으로 12개월치 셀(<td>)을 동적으로 생성
                                                                                                            for ($month = 1; $month <= 12; $month++) {
                                                                                                                // '$Data_ThisYearFee' + '1' => '$Data_ThisYearFee1' 처럼 변수 이름을 동적으로 만듭니다.
                                                                                                                $variableName = $rowData['monthlyVarPrefix'] . $month;
                                                                                                                
                                                                                                                // 동적으로 만들어진 이름의 변수에 접근하고, WATER 값을 가져옵니다.
                                                                                                                // 변수가 존재하지 않을 경우를 대비해 ?? 0으로 안전하게 처리합니다.
                                                                                                                $waterValue = ${$variableName}['WATER'] ?? 0;

                                                                                                                echo '<td>' . number_format($waterValue) . '</td>';
                                                                                                            }
                                                                                                            ?>
                                                                                                        </tr>
                                                                                                    <?php endforeach; ?>
                                                                                                </tbody>
                                                                                            </table>  
                                                                                        </div>                                                                                        
                                                                                    </div> 
                                                                                    <div class="chart tab-pane" id="w_use" style="position: relative; height: 300px;">
                                                                                        <canvas id="barChart"></canvas>
                                                                                    </div>
                                                                                </div>        
                                                                            </div> 
                                                                            <!-- /.card-body -->              
                                                                        </div>
                                                                        <!-- /.Card Content - Collapse -->
                                                                    </div>
                                                                    <!-- /.card -->
                                                                </div> 
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </div>   
                                            </div>
                                            <!-- /. row -->                                            
                                        </div>

                                        <!-- 4번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="custom-tabs-one-4th" role="tabpanel" aria-labelledby="custom-tabs-one-4th-tab">
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample41t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample41t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 연결 재무제표 손익계산서 주항목</h6>
                                                        </a>
                                                        
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample41t">
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row"> 
                                                                    <!-- 차트 - 재무제표 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample411t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample411t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 년도별 그래프</h6>
                                                                            </a>
                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample411t">                                    
                                                                                <div class="card-body">
                                                                                    <!-- Begin row -->
                                                                                    <div class="row">    
                                                                                        <div class="chart" style="height: 30vh; width: 100%;">
                                                                                            <canvas id="barChart6"></canvas>
                                                                                        </div>
                                                                                    </div> 
                                                                                    <!-- /.row -->         
                                                                                </div> 
                                                                                <!-- /.card-body -->              
                                                                            </div>
                                                                            <!-- /.Card Content - Collapse -->
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div> 
                                                                </div>

                                                                <div class="row">
                                                                    <!-- 재무제표 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample412t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample412t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-2. 연결 재무제표 주항목(원)</h6>
                                                                            </a>

                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample412t">                                    
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th></th>
                                                                                                    <?php
                                                                                                    // 💡 (수정!) array_reverse() 제거하여 최신순으로 정렬
                                                                                                    foreach ($years as $year) {
                                                                                                        echo '<th>' . ($financialData[$year]['매출액']['thstrm_nm'] ?? $year . '년') . '</th>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                                <?php
                                                                                                // 테이블에 표시할 계정 항목 순서
                                                                                                $financeAccountOrder = ['매출액', '매출원가', '판매비와관리비', '영업외이익(손실)', '당기순이익'];

                                                                                                foreach ($financeAccountOrder as $accountName):
                                                                                                ?>
                                                                                                    <tr>
                                                                                                        <td align="center"><?php echo $accountName; ?></td>
                                                                                                        <?php
                                                                                                        // 💡 (수정!) 여기도 동일하게 array_reverse() 제거
                                                                                                        foreach ($years as $year) {
                                                                                                            $amount = $financialData[$year][$accountName]['thstrm_amount'] ?? 0;
                                                                                                            echo '<td>' . number_format($amount) . '</td>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </tr>
                                                                                                <?php endforeach; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <!-- /.table-responsive --> 
                                                                                </div> 
                                                                                <!-- /.card-body -->              
                                                                            </div>
                                                                            <!-- /.Card Content - Collapse -->
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->                                                      
                                                        </div>    
                                                        <!-- /.Card Content - Collapse -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                            <!-- /.row -->     
                                        </div>

                                        <!-- 5번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="custom-tabs-one-5th" role="tabpanel" aria-labelledby="custom-tabs-one-5th-tab">
                                            <!-- 차트 - 사무직 인원증감 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-2 mt-2">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample50t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample50t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 운반비</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#deli_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#deli_table" data-toggle="tab">표</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample50t">                                    
                                                        <div class="card-body">
                                                            <!-- Begin row -->
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="deli_chart" style="position: relative; height: 300px;">                                                                                                                                                                        
                                                                    <canvas id="barChart8"></canvas>                                                                    
                                                                </div>
                                                                <div class="chart tab-pane" id="deli_table" style="position: relative;">
                                                                    <div class="table-responsive">  
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr style="text-align: center;">
                                                                                    <th scope="col">#</th>
                                                                                    <th scope="col">합계</th>
                                                                                    <?php
                                                                                    // 💡 1단계: 1월부터 12월까지의 헤더를 for문으로 생성
                                                                                    for ($month = 1; $month <= 12; $month++) {
                                                                                        echo "<th scope='col'>{$month}월</th>";
                                                                                    }
                                                                                    ?>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                // 💡 2단계: 올해와 작년 데이터를 하나의 배열로 묶어 처리
                                                                                $deliveryTableData = [
                                                                                    [
                                                                                        'label' => $currentYear, // $YY 대신 명확한 변수 사용 권장
                                                                                        'totalVar' => $Data_ThisYearFee0,
                                                                                        'monthlyPrefix' => 'Data_ThisYearFee'
                                                                                    ],
                                                                                    [
                                                                                        'label' => $previousYear, // $Minus1YY 대신 명확한 변수 사용 권장
                                                                                        'totalVar' => $Data_LastYearFee0,
                                                                                        'monthlyPrefix' => 'Data_LastYearFee'
                                                                                    ]
                                                                                ];

                                                                                // 💡 3단계: 묶은 데이터를 foreach문으로 돌면서 행(<tr>) 생성
                                                                                foreach ($deliveryTableData as $rowData) :
                                                                                ?>
                                                                                    <tr style="text-align: center;">
                                                                                        <th scope="row"><?php echo $rowData['label']; ?></th>
                                                                                        
                                                                                        <td><?php echo number_format($rowData['totalVar']['DELIVERY'] ?? 0); ?></td>

                                                                                        <?php
                                                                                        // 💡 4단계: 안쪽 for문으로 12개월치 운반비(DELIVERY)를 동적으로 생성
                                                                                        for ($month = 1; $month <= 12; $month++) {
                                                                                            $variableName = $rowData['monthlyPrefix'] . $month;
                                                                                            $deliveryValue = ${$variableName}['DELIVERY'] ?? 0;
                                                                                            echo '<td>' . number_format($deliveryValue) . '</td>';
                                                                                        }
                                                                                        ?>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <!-- /.row -->         
                                                        </div> 
                                                        <!-- /.card-body -->              
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <div class="col-lg-12">
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-2">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample51t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample51t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#2. 운송</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#delivery" data-toggle="tab">운송중</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#complete" data-toggle="tab">운송완료</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample51t">        
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="delivery" style="position: relative;">   
                                                                    <div class="table-responsive">                                                                   
                                                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                                                            <thead align="center">
                                                                                <tr>
                                                                                    <th>출발&nbsp;<i class="fas fa-arrow-right"></i>&nbsp;도착</th>
                                                                                    <th>운송방식</th>  
                                                                                    <th>B/L</th>
                                                                                    <th>작업일</th>
                                                                                    <th>출항</th>
                                                                                    <th>입항</th>
                                                                                    <th>출항딜레이</th>    
                                                                                    <th>선박이름</th>                                             
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody align="center">
                                                                                <?php 
                                                                                // 국가 코드와 이미지 파일명을 매핑
                                                                                $flagImages = ['V' => 'flag_v.png', 'K' => 'flag_k.png', 'S' => 'flag_s.png', 'C' => 'flag_c.png', 'U' => 'flag_a.png'];

                                                                                // [개선] '$data_in_transit' 배열을 순회하며 데이터 출력
                                                                                foreach ($data_in_transit as $item): 
                                                                                ?>
                                                                                    <tr>
                                                                                        <td style="width: 30%;">
                                                                                            <img src="../img/<?php echo $flagImages[$item['s_country']] ?? ''; ?>" width="60em">
                                                                                            &nbsp;<i class="fas fa-arrow-right"></i>&nbsp;
                                                                                            <img src="../img/<?php echo $flagImages[$item['e_country']] ?? ''; ?>" width="60em">
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php if($item['kind'] == "해상"): ?>
                                                                                                <i class="fas fa-ship fa-2x"></i>
                                                                                            <?php elseif($item['kind'] == "항공"): ?>
                                                                                                <i class="fas fa-plane fa-2x"></i>
                                                                                            <?php endif; ?>
                                                                                        </td>
                                                                                        <td><a href=".../report_export_detail.php?bl=<?php echo $item['bl']; ?>" target="_blank"><?php echo $item['bl']; ?></a></td>
                                                                                        <td><?php echo $item['invoice_dt']; ?></td>
                                                                                        <td><?php echo $item['etd']; ?></td>
                                                                                        <td><?php echo $item['eta']; ?></td>
                                                                                        <td><?php echo $item['delay']; ?></td>
                                                                                        <td>
                                                                                            <?php // [개선] 루프 안에서 DB 쿼리 제거! 이미 가져온 'imo' 값을 사용
                                                                                            if (!empty($item['imo'])): ?>
                                                                                                <a href="https://www.vesselfinder.com/?imo=<?php echo $item['imo']; ?>" target="_blank"><?php echo $item['vessel']; ?></a>
                                                                                            <?php else: ?>
                                                                                                <?php echo $item['vessel']; ?>
                                                                                            <?php endif; ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>                                                                                                                            
                                                                    </div>
                                                                </div>
                                                                <div class="chart tab-pane" id="complete" style="position: relative;">    
                                                                    <div class="table-responsive">                                                            
                                                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                                                            <thead align="center">
                                                                                <tr>
                                                                                    <th>출발&nbsp;<i class="fas fa-arrow-right"></i>&nbsp;도착</th>
                                                                                    <th>운송방식</th>  
                                                                                    <th>작업일</th>
                                                                                    <th>출항</th>
                                                                                    <th>입항</th>
                                                                                    <th>입고일</th>  
                                                                                    <th>리드타임(출하~배송)</th>                                             
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody align="center">
                                                                                <?php
                                                                                // [개선] '$data_completed' 배열을 순회하며 데이터 출력
                                                                                foreach ($data_completed as $item):
                                                                                ?>
                                                                                    <tr>
                                                                                        <td style="width: 30%;">
                                                                                            <img src="../img/<?php echo $flagImages[$item['s_country']] ?? ''; ?>" width="60em">
                                                                                            &nbsp;<i class="fas fa-arrow-right"></i>&nbsp;
                                                                                            <img src="../img/<?php echo $flagImages[$item['e_country']] ?? ''; ?>" width="60em">
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php if($item['kind'] == "해상"): ?>
                                                                                                <i class="fas fa-ship fa-2x"></i>
                                                                                            <?php elseif($item['kind'] == "항공"): ?>
                                                                                                <i class="fas fa-plane fa-2x"></i>
                                                                                            <?php endif; ?>
                                                                                        </td>
                                                                                        <td><?php echo $item['invoice_dt']; ?></td>
                                                                                        <td><?php echo $item['etd']; ?></td>
                                                                                        <td><?php echo $item['eta']; ?></td>
                                                                                        <td><?php echo $item['complete_dt']; ?></td>
                                                                                        <td><?php echo ($item['lead_time'] < 0 || $item['lead_time'] == '#VALUE!') ? '' : $item['lead_time']; ?></td>
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

                                        <!-- 6번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab7_text;?>" id="custom-tabs-one-6th" role="tabpanel" aria-labelledby="custom-tabs-one-6th-tab">
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <div class="col-lg-12">                                                     
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample61t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample61t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 매출</h6>
                                                        </a>
                                                        
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample61t">
                                                            <div class="card-body table-responsive p-2">
                                                                <div class="row"> 
                                                                    <!-- 차트 - 항목별(%) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-4"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample611t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample711t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 항목별</h6>
                                                                            </a>
                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample611t">                                    
                                                                                <div class="card-body">
                                                                                    <!-- Begin row -->
                                                                                    <div class="row">    
                                                                                        <div class="chart" style="height: 30vh; width: 100%;">
                                                                                            <canvas id="donutChart"></canvas>
                                                                                        </div>
                                                                                    </div> 
                                                                                    <!-- /.row -->         
                                                                                </div> 
                                                                                <!-- /.card-body -->              
                                                                            </div>
                                                                            <!-- /.Card Content - Collapse -->
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div> 
                                                                    <!-- 차트 - 년도별(원) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-8"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample612t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample612t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-2. 년도별</h6>
                                                                            </a>
                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample612t">                                    
                                                                                <div class="card-body">
                                                                                    <!-- Begin row -->
                                                                                    <div class="row">    
                                                                                        <div class="chart" style="height: 30vh; width: 100%;">
                                                                                            <canvas id="lineChart"></canvas>
                                                                                        </div>
                                                                                    </div> 
                                                                                    <!-- /.row -->         
                                                                                </div> 
                                                                                <!-- /.card-body -->              
                                                                            </div>
                                                                            <!-- /.Card Content - Collapse -->
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div>
                                                                </div>   

                                                                <div class="row">
                                                                    <!-- 차트 - 매출 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample613t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample613t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-3. 월 항목별 그래프</h6>
                                                                            </a>
                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample613t">                                    
                                                                                <div class="card-body">
                                                                                    <!-- Begin row -->
                                                                                    <div class="row">    
                                                                                        <div class="chart" style="height: 30vh; width: 100%;">
                                                                                            <canvas id="stackedBarChart"></canvas>
                                                                                        </div>
                                                                                    </div> 
                                                                                    <!-- /.row -->         
                                                                                </div> 
                                                                                <!-- /.card-body -->              
                                                                            </div>
                                                                            <!-- /.Card Content - Collapse -->
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div> 
                                                                </div>

                                                                <div class="row">
                                                                    <!-- 차트 - 매출 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample614t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample614t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-4. 매출(원)</h6>
                                                                            </a>
                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample614t">                                    
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th></th> 
                                                                                                    <th>년 실적</th> 
                                                                                                    <th>월 실적</th> 
                                                                                                    <th>일 실적</th> 
                                                                                                </tr> 
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                                <?php
                                                                                                // 💡 1단계: 테이블에 표시할 항목의 순서를 배열로 정의합니다.
                                                                                                // 순서를 바꾸거나 항목을 추가/삭제할 때 이 배열만 수정하면 됩니다.
                                                                                                $salesKinds = ['히터', '발열핸들(열선)', '통풍(이원컴포텍)', '통풍', '통합ECU', '일반ECU', '기타', '합계'];

                                                                                                // 💡 2단계: 정의한 항목 배열을 순회하며 테이블 행(<tr>)을 동적으로 생성합니다.
                                                                                                foreach ($salesKinds as $kind):
                                                                                                    // 백엔드에서 만든 $latestSalesByKind 배열에서 현재 항목의 데이터를 가져옵니다.
                                                                                                    // 데이터가 없는 항목일 경우를 대비해 '?? []'로 안전하게 처리합니다.
                                                                                                    $salesData = $latestSalesByKind[$kind] ?? [];
                                                                                                ?>
                                                                                                    <tr>
                                                                                                        <td align="center"><?php echo $kind; ?></td>
                                                                                                        
                                                                                                        <td><?php echo number_format($salesData['Y_MONEY'] ?? 0); ?></td>
                                                                                                        <td><?php echo number_format($salesData['M_MONEY'] ?? 0); ?></td>
                                                                                                        <td><?php echo number_format($salesData['D_MONEY'] ?? 0); ?></td>
                                                                                                    </tr>
                                                                                                <?php endforeach; ?>
                                                                                            </tbody>
                                                                                        </table>    
                                                                                    </div> 
                                                                                    <!-- /.table-responsive -->      
                                                                                </div> 
                                                                                <!-- /.card-body -->              
                                                                            </div>
                                                                            <!-- /.Card Content - Collapse -->
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div> 
                                                                </div>  
                                                            </div>
                                                            <!-- /.card-body -->                                                      
                                                        </div>    
                                                        <!-- /.Card Content - Collapse -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                            <!-- /.row -->                                          
                                        </div>

                                        <!-- 7번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab8_text;?>" id="custom-tabs-one-7th" role="tabpanel" aria-labelledby="custom-tabs-one-7th-tab">
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample71t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample71t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 실패비용(<?php echo $YY; ?>년)</h6>
                                                        </a>

                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample71t">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <!-- 차트 - 실패비용 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample711t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample711t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 년도별 실패비용 그래프</h6>
                                                                            </a>
                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample711t">                                    
                                                                                <div class="card-body">
                                                                                    <!-- Begin row -->
                                                                                    <div class="row">    
                                                                                        <div class="chart" style="height: 30vh; width: 100%;">
                                                                                            <canvas id="barChart7"></canvas>                                                                                            
                                                                                        </div>
                                                                                    </div> 
                                                                                    <!-- /.row -->         
                                                                                </div> 
                                                                                <!-- /.card-body -->              
                                                                            </div>
                                                                            <!-- /.Card Content - Collapse -->
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div> 
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card shadow mb-2">
                                                                            <a href="#collapseCardExample712t" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample712t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-2. 시트히터(원)</h1>
                                                                            </a>
                                                                            <div class="collapse show" id="collapseCardExample712t">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th rowspan="2"></th>
                                                                                                    <th colspan="3">한국 폐기</th>
                                                                                                    <th colspan="2">한국 리워크</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">베트남 폐기</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">중국 폐기</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">미국 폐기</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">슬로박 폐기</th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th>본사 스티칭</th>
                                                                                                    <th>본사 최종검사</th>
                                                                                                    <th>협력사 귀책</th>
                                                                                                    <th>본사</th>
                                                                                                    <th>B/B 베트남</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                            <?php
                                                                                                // ✅ 비즈니스 로직: 올해 실패비용이 작년보다 개선되었는지(작아졌는지) 확인
                                                                                                $isImproved = ($graphData[$currentYear]['시트히터'] ?? 0) < ($graphData[$previousYear]['시트히터'] ?? 0);
                                                                                                for ($month = 1; $month <= 13; $month++):
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td align="center"><?php echo ($month == 13) ? "합계" : $month . "월"; ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국폐기 본사 스티칭'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국폐기 본사 최종검사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국폐기 협력사귀책'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국리워크 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국리워크 BB베트남'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['베트남 폐기'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['중국 폐기'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['미국 폐기'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['슬로박 폐기'][$month] ?? 0); ?></td>
                                                                                                </tr>
                                                                                            <?php endfor; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card shadow mb-2">
                                                                            <a href="#collapseCardExample713t" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample713t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-3. 발열핸들(원)</h1>
                                                                            </a>
                                                                            <div class="collapse show" id="collapseCardExample713t">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th rowspan="2"></th>
                                                                                                    <th colspan="3">한국 폐기</th>
                                                                                                    <th colspan="2">한국 리워크</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">베트남 폐기</th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th>본사</th>
                                                                                                    <th>협력사 귀책</th>
                                                                                                    <th>B/B 베트남</th>
                                                                                                    <th>본사</th>
                                                                                                    <th>B/B 베트남</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                            <?php
                                                                                                // ✅ 핸들에 대한 비즈니스 로직 적용
                                                                                                $isImproved = ($graphData[$currentYear]['핸들'] ?? 0) < ($graphData[$previousYear]['핸들'] ?? 0);
                                                                                                for ($month = 1; $month <= 13; $month++):
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td align="center"><?php echo ($month == 13) ? "합계" : $month . "월"; ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국폐기 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국폐기 협력사귀책'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국폐기 BB베트남'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국리워크 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국리워크 BB베트남'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['베트남 폐기'][$month] ?? 0); ?></td>
                                                                                                </tr>
                                                                                            <?php endfor; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card shadow mb-2">
                                                                            <a href="#collapseCardExample714t" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample714t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-4. 통풍모듈(원)</h1>
                                                                            </a>
                                                                            <div class="collapse show" id="collapseCardExample714t">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th rowspan="2"></th>
                                                                                                    <th colspan="2">한국 폐기</th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th>본사</th>
                                                                                                    <th>협력사 귀책</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                            <?php
                                                                                                // ✅ 통풍에 대한 비즈니스 로직 적용
                                                                                                $isImproved = ($graphData[$currentYear]['통풍'] ?? 0) < ($graphData[$previousYear]['통풍'] ?? 0);
                                                                                                for ($month = 1; $month <= 13; $month++):
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td align="center"><?php echo ($month == 13) ? "합계" : $month . "월"; ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['통풍']['한국폐기 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['통풍']['한국폐기 협력사귀책'][$month] ?? 0); ?></td>
                                                                                                </tr>
                                                                                            <?php endfor; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!-- /.card-body -->                                                      
                                                        </div>    
                                                        <!-- /.Card Content - Collapse -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                            <!-- /.row -->  
                                        </div> 
                                        
                                        <!-- 8번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab9_text;?>" id="custom-tabs-one-8th" role="tabpanel" aria-labelledby="custom-tabs-one-8th-tab">
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample81t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample81t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 차종별 개발일정</h6>
                                                        </a>

                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample81t">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <!-- 실패비용 - 핸들 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample811t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample811t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 차종별 개발일정</h6>
                                                                            </a>

                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample811t">                                    
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th>차종</th> 
                                                                                                    <th>PROTO</th> 
                                                                                                    <th>P1</th> 
                                                                                                    <th>P2</th> 
                                                                                                    <th>M</th> 
                                                                                                    <th>SOP</th> 
                                                                                                    <th>CAR_MAKER</th> 
                                                                                                    <th>SEAT_MAKER</th> 
                                                                                                    <th>VOLUME</th> 
                                                                                                </tr> 
                                                                                            </thead>
                                                                                            <tbody align="center">
                                                                                                <?php
                                                                                                // 1. 백엔드에서 전달된 $Result_DEVELOP1 변수가 있고, 조회된 행이 있는지 확인합니다.
                                                                                                if (isset($Result_DEVELOP1) && sqlsrv_has_rows($Result_DEVELOP1)) {
                                                                                                    // 2. for 루프 대신 while 루프를 사용하여 결과셋(result set)을 한 줄씩 처리합니다.
                                                                                                    while ($row = sqlsrv_fetch_array($Result_DEVELOP1, SQLSRV_FETCH_ASSOC)) {
                                                                                                ?>
                                                                                                        <tr>
                                                                                                            <td><?php echo htmlspecialchars($row['CAR']); ?></td>
                                                                                                            <td><?php echo htmlspecialchars($row['PROTO']); ?></td>
                                                                                                            <td><?php echo htmlspecialchars($row['P1']); ?></td>
                                                                                                            <td><?php echo htmlspecialchars($row['P2']); ?></td>
                                                                                                            <td><?php echo htmlspecialchars($row['M']); ?></td>
                                                                                                            <td><?php echo htmlspecialchars($row['SOP']); ?></td>
                                                                                                            <td><?php echo htmlspecialchars($row['CAR_MAKER']); ?></td>
                                                                                                            <td><?php echo htmlspecialchars($row['SEAT_MAKER']); ?></td>
                                                                                                            <td><?php echo htmlspecialchars($row['VOLUME']); ?></td>
                                                                                                        </tr>
                                                                                                <?php
                                                                                                    } // end of while loop
                                                                                                } else {
                                                                                                    // 4. 조회된 데이터가 없을 경우, 테이블에 메시지를 표시합니다.
                                                                                                ?>
                                                                                                    <tr>
                                                                                                        <td colspan="9">조회된 개발 일정이 없습니다.</td>
                                                                                                    </tr>
                                                                                                <?php
                                                                                                } // end of if
                                                                                                ?>                                                                                          
                                                                                            </tbody>
                                                                                        </table>        
                                                                                    </div> 
                                                                                    <!-- /.table-responsive -->                                                                                      
                                                                                </div> 
                                                                                <!-- /.card-body -->              
                                                                            </div>
                                                                            <!-- /.Card Content - Collapse -->
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div> 
                                                                </div> 
                                                            </div>
                                                            <!-- /.card-body -->                                                      
                                                        </div>    
                                                        <!-- /.Card Content - Collapse -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                            <!-- /.row -->  
                                        </div>

                                        <!-- 9번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab10_text;?>" id="custom-tabs-one-9th" role="tabpanel" aria-labelledby="custom-tabs-one-9th-tab">
                                            <?php
                                                // 조회할 채널 목록을 배열로 관리합니다.
                                                $channelTitles = [
                                                    '김한용의 MOCAR',
                                                    '더드라이브 TheDriveKorea',
                                                    '남자들의 자동차 - 남차카페',
                                                    '신차열전',
                                                    'Motorian모터리언'
                                                ];

                                                foreach ($channelTitles as $channelTitle) {
                                                    $Data_Channelinfo = null; // 채널 정보 초기화
                                                    $Result_PLAYCOUNT = null; // 비디오 결과 초기화

                                                    try {
                                                        // 채널 정보 조회
                                                        $Query_Channelinfo = "SELECT * FROM YOUTUBE_CHANNEL WHERE channelTitle = ?";
                                                        // mysqli는 prepare/bind_param/execute 방식으로 쿼리 실행을 권장합니다.
                                                        // 여기서는 간결성을 위해 $connect4->query()를 사용하지만, 실제 프로덕션에서는
                                                        // 준비된 구문을 사용하는 것이 SQL 인젝션 방지에 훨씬 더 안전합니다.
                                                        // (만약 $channelTitle이 사용자 입력으로 올 가능성이 있다면 더더욱 중요합니다.)
                                                        $stmt_channel = $connect4->prepare($Query_Channelinfo);
                                                        $stmt_channel->bind_param("s", $channelTitle);
                                                        $stmt_channel->execute();
                                                        $Result_Channelinfo = $stmt_channel->get_result();
                                                        
                                                        if ($Result_Channelinfo && $Result_Channelinfo->num_rows > 0) {
                                                            $Data_Channelinfo = $Result_Channelinfo->fetch_assoc();
                                                        } else {
                                                            // 채널 정보가 없는 경우 스킵
                                                            continue; 
                                                        }

                                                        // 비디오 목록 조회 (최신 12개)
                                                        $Query_PLAYCOUNT = "SELECT * FROM PLAYITEM WHERE channelTitle = ? AND use_yn = 'Y' ORDER BY publishedAt DESC LIMIT 12";
                                                        $stmt_videos = $connect4->prepare($Query_PLAYCOUNT);
                                                        $stmt_videos->bind_param("s", $channelTitle);
                                                        $stmt_videos->execute();
                                                        $Result_PLAYCOUNT = $stmt_videos->get_result();
                                                        
                                                        // 고유한 collapse ID를 생성합니다 (예: collapseCardExample91t -> collapseCardExample_김한용의_MOCAR_t)
                                                        $collapseId = 'collapseCardExample_' . preg_replace('/[^a-zA-Z0-9]/', '_', $channelTitle) . '_t';

                                            ?>
                                                        <div class="row">
                                                            <div class="col-12 ">
                                                                <div class="card shadow mb-2">
                                                                    <a href="#<?php echo htmlspecialchars($collapseId); ?>" class="d-block card-header py-3" data-toggle="collapse"
                                                                        role="button" aria-expanded="true" aria-controls="<?php echo htmlspecialchars($collapseId); ?>">
                                                                        <div class="row">
                                                                            <img src="<?php echo htmlspecialchars($Data_Channelinfo['MAKER_PIC']); ?>" style="width: 30px; height: 30px;">
                                                                            <h1 class="h6 m-1 font-weight-bold text-primary"><?php echo htmlspecialchars($channelTitle); ?></h1>
                                                                        </div>
                                                                    </a>
                                                                    <div class="row">
                                                                        <?php
                                                                        if ($Result_PLAYCOUNT && $Result_PLAYCOUNT->num_rows > 0) {
                                                                            // mysqli_fetch_array 대신 fetch_assoc()를 사용하여 연관 배열로 가져오는 것이 일반적입니다.
                                                                            while ($Data_SubTitle = $Result_PLAYCOUNT->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="col-12 col-sx-3 col-lg-4 col-md-6 col-sm-12 collapse" id="<?php echo htmlspecialchars($collapseId); ?>">
                                                                                    <a href="./youtube_play.php?play=<?php echo htmlspecialchars($Data_SubTitle['NO']); ?>">
                                                                                        <div class="card h-100 py-2 align-items-center">
                                                                                            <div class="card-body">
                                                                                                <div class="col-auto" style="text-align: center;">
                                                                                                    <img src="https://img.youtube.com/vi/<?php echo htmlspecialchars($Data_SubTitle['videoId']); ?>/0.jpg" style="width: 100%;">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </div>
                                                                        <?php
                                                                            } // end of while loop for videos
                                                                        } else {
                                                                            // 해당 채널의 비디오가 없을 경우
                                                                        ?>
                                                                            <div class="col-12 collapse" id="<?php echo htmlspecialchars($collapseId); ?>">
                                                                                <p class="text-center mt-3">아직 등록된 영상이 없습니다.</p>
                                                                            </div>
                                                                        <?php
                                                                        } // end of if for videos
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } catch (Throwable $e) {
                                                        // 데이터베이스 쿼리 중 오류 발생 시
                                                        error_log("YouTube Channel Data Query Failed for '" . $channelTitle . "': " . $e->getMessage());
                                                        // 사용자에게는 오류 메시지를 표시하지 않고 다음 채널로 진행하거나, 적절한 오류 메시지를 보여줄 수 있습니다.
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="alert alert-danger" role="alert">
                                                                    <strong>오류 발생:</strong> 채널 '<?php echo htmlspecialchars($channelTitle); ?>'의 정보를 불러오지 못했습니다.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } finally {
                                                        // 사용한 statement와 result를 정리합니다.
                                                        if (isset($stmt_channel) && $stmt_channel) {
                                                            $stmt_channel->close();
                                                        }
                                                        if (isset($Result_Channelinfo) && $Result_Channelinfo) {
                                                            $Result_Channelinfo->free();
                                                        }
                                                        if (isset($stmt_videos) && $stmt_videos) {
                                                            $stmt_videos->close();
                                                        }
                                                        if (isset($Result_PLAYCOUNT) && $Result_PLAYCOUNT) {
                                                            $Result_PLAYCOUNT->free();
                                                        }
                                                    }
                                                } // end of foreach channelTitles
                                            ?>
                                        </div>

                                        <!-- 10번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab10_text;?>" id="custom-tabs-one-10th" role="tabpanel" aria-labelledby="custom-tabs-one-10th-tab">
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample10t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample10t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 베트남 경영</h6>
                                                        </a>

                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample10t">
                                                            <div class="card-body">
                                                                <!-- 차트 - 사무직 인원증감 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                <div class="col-lg-12"> 
                                                                    <!-- Collapsable Card Example -->
                                                                    <div class="card shadow mb-2 mt-2">
                                                                        <div class="card-header">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample101t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample101t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 인원</h6>
                                                                            </a>
                                                                            <div class="card-tools mt-3">
                                                                                <ul class="nav nav-pills ml-auto">
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link active" href="#vietnam_chart" data-toggle="tab">인원(그래프)</a>
                                                                                    </li>
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link" href="#vietnam_number" data-toggle="tab">인원(표)</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.card-header -->
                                                                        <!-- Card Content - Collapse -->
                                                                        <div class="collapse show" id="collapseCardExample101t">                                    
                                                                            <div class="card-body">
                                                                                <div class="tab-content p-0">  
                                                                                    <div class="chart tab-pane active" id="vietnam_chart" style="position: relative; height: 300px;">
                                                                                        <canvas id="barChartV1"></canvas> 
                                                                                    </div>
                                                                                    <div class="chart tab-pane" id="vietnam_number" style="position: relative;">
                                                                                        <table class="table">
                                                                                            <thead>
                                                                                                <tr style="text-align: center;">
                                                                                                    <th scope="col">#</th>
                                                                                                    <th scope="col">합계</th>
                                                                                                    <th scope="col">생산야간(아이윈)</th>
                                                                                                    <th scope="col">생산야간(파트타임)</th>
                                                                                                    <th scope="col">생산주간(아이윈)</th>
                                                                                                    <th scope="col">생산주간(파트타임)</th>
                                                                                                    <th scope="col">사무직</th>
                                                                                                    <th scope="col">기타(기숙사, 식당, 기사, 청소, 정원)</th>
                                                                                                    <th scope="col">육아휴직</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php
                                                                                                // 금년 데이터 출력 (1월 ~ 12월)
                                                                                                for ($month = 1; $month <= 12; $month++) :
                                                                                                    $data = $thisYearData[$month];
                                                                                                    $yearMonthStr = $yyyy . sprintf('%02d', $month);
                                                                                                ?>
                                                                                                <tr style="text-align: center;">
                                                                                                    <th scope="row"><?php echo $yearMonthStr; ?></th>
                                                                                                    <td><?php echo $thisYearVietnamTotals[$month] ?: ''; // 합계가 0이면 빈 칸으로 표시 ?></td>
                                                                                                    <td><?php echo $data['night_iwin']; ?></td>
                                                                                                    <td><?php echo $data['night_part']; ?></td>
                                                                                                    <td><?php echo $data['morning_iwin']; ?></td>
                                                                                                    <td><?php echo $data['morning_part']; ?></td>
                                                                                                    <td><?php echo $data['morning_office']; ?></td>
                                                                                                    <td><?php echo $data['morning_etc']; ?></td>
                                                                                                    <td><?php echo $data['vacation_baby']; ?></td>
                                                                                                </tr>
                                                                                                <?php endfor; ?>
                                                                                                
                                                                                                <?php
                                                                                                // 작년 데이터 출력 (1월 ~ 12월)
                                                                                                for ($month = 1; $month <= 12; $month++) :
                                                                                                    $data = $lastYearData[$month];
                                                                                                    $yearMonthStr = $b_yyyy . sprintf('%02d', $month);
                                                                                                ?>
                                                                                                <tr style="text-align: center;">
                                                                                                    <th scope="row"><?php echo $yearMonthStr; ?></th>
                                                                                                    <td><?php echo $lastYearVietnamTotals[$month] ?: ''; // 합계가 0이면 빈 칸으로 표시 ?></td>
                                                                                                    <td><?php echo $data['night_iwin']; ?></td>
                                                                                                    <td><?php echo $data['night_part']; ?></td>
                                                                                                    <td><?php echo $data['morning_iwin']; ?></td>
                                                                                                    <td><?php echo $data['morning_part']; ?></td>
                                                                                                    <td><?php echo $data['morning_office']; ?></td>
                                                                                                    <td><?php echo $data['morning_etc']; ?></td>
                                                                                                    <td><?php echo $data['vacation_baby']; ?></td>
                                                                                                </tr>
                                                                                                <?php endfor; ?>                                                                                             
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>                                                                                    
                                                                                </div>        
                                                                            </div> 
                                                                            <!-- /.card-body -->              
                                                                        </div>
                                                                        <!-- /.Card Content - Collapse -->
                                                                    </div>
                                                                    <!-- /.card -->
                                                                </div> 
                                                            </div>
                                                            <!-- /.card-body -->                                                      
                                                        </div>    
                                                        <!-- /.Card Content - Collapse -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                            <!-- /.row -->  
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

    <script>
        //인원증감
        const thisYearOfficeData = <?php echo json_encode($thisYearOfficeChartData); ?>;
        const lastYearOfficeData = <?php echo json_encode($lastYearOfficeChartData); ?>;
        const thisYearContractData = <?php echo json_encode($thisYearContractChartData); ?>;        
        const lastYearContractData = <?php echo json_encode($lastYearContractChartData); ?>;
        //사용량
        const thisYearWaterIwinUsageData = <?php echo json_encode($thisYearWaterIwinUsageData); ?>;
        const lastYearWaterIwinUsageData = <?php echo json_encode($lastYearWaterIwinUsageData); ?>;
        const thisYearGasUsageData = <?php echo json_encode($thisYearGasUsageData); ?>;
        const lastYearGasUsageData = <?php echo json_encode($lastYearGasUsageData); ?>;
        const thisYearElectricityUsageData = <?php echo json_encode($thisYearElectricityUsageData); ?>;
        const lastYearElectricityUsageData = <?php echo json_encode($lastYearElectricityUsageData); ?>;
        //비용
        const thisYearWaterChartData = <?php echo json_encode($thisYearWaterChartData); ?>;
        const lastYearWaterChartData = <?php echo json_encode($lastYearWaterChartData); ?>;
        const thisYearGasChartData = <?php echo json_encode($thisYearGasChartData); ?>;
        const lastYearGasChartData = <?php echo json_encode($lastYearGasChartData); ?>;
        const thisYearElecChartData = <?php echo json_encode($thisYearElecChartData); ?>;
        const lastYearElecChartData = <?php echo json_encode($lastYearElecChartData); ?>;
        const thisYearPayChartData = <?php echo json_encode($thisYearPayChartData); ?>;
        const lastYearPayChartData = <?php echo json_encode($lastYearPayChartData); ?>;
        const thisYearPay2ChartData = <?php echo json_encode($thisYearPay2ChartData); ?>;
        const lastYearPay2ChartData = <?php echo json_encode($lastYearPay2ChartData); ?>;
        const thisYearDeliChartData = <?php echo json_encode($thisYearDeliChartData); ?>;
        const lastYearDeliChartData = <?php echo json_encode($lastYearDeliChartData); ?>;
        //회계
        const financeDataCY   = <?php echo json_encode($financeDataCurrentYear  ?? []); ?>;
        const financeDataCY_1 = <?php echo json_encode($financeDataPreviousYear ?? []); ?>;
        const financeDataCY_2 = <?php echo json_encode($financeDataMinus2Year   ?? []); ?>;
        const financeDataCY_3 = <?php echo json_encode($financeDataMinus3Year   ?? []); ?>;
        //매출
        const salesDonutData = <?php echo json_encode($donutChartPercentages); ?>;
        const annualSalesLabels = <?php echo json_encode($lineChartLabels); ?>;
        const annualSalesData = <?php echo json_encode($lineChartValues); ?>;
        const heaterData        = <?php echo json_encode($chartData['heaterChartData']); ?>;
        const handleData        = <?php echo json_encode($chartData['handleChartData']); ?>;
        const iwonData          = <?php echo json_encode($chartData['iwonChartData']); ?>;
        const ventData          = <?php echo json_encode($chartData['ventChartData']); ?>;
        const integratedEcuData = <?php echo json_encode($chartData['integratedEcuChartData']); ?>;
        const generalEcuData    = <?php echo json_encode($chartData['generalEcuChartData']); ?>;
        const etcData           = <?php echo json_encode($chartData['etcChartData']); ?>;
    </script>    
    
    <script>
        //사무직 인원증감★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas44 = $('#barChart44').get(0).getContext('2d')

            var barChartData44 = {
            labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(97,175,185,1)',
                    borderColor         : 'rgba(97,175,185,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(97,175,185,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(97,175,185,1)',
                    data                : thisYearOfficeData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearOfficeData
                }
            ]
            }

            var temp0 = barChartData44.datasets[0]
            var temp1 = barChartData44.datasets[1]
            barChartData44.datasets[0] = temp1
            barChartData44.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '명';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(barChartCanvas44, {
                type: 'bar',
                data: barChartData44,
                options: barChartOptions
            }) 
        })

        //도급직 인원증감★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas4 = $('#barChart4').get(0).getContext('2d')

            var barChartData4 = {
            labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(97,175,185,1)',
                    data                : thisYearContractData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearContractData
                }
            ]
            }

            var temp0 = barChartData4.datasets[0]
            var temp1 = barChartData4.datasets[1]
            barChartData4.datasets[0] = temp1
            barChartData4.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '명';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(barChartCanvas4, {
                type: 'bar',
                data: barChartData4,
                options: barChartOptions
            }) 
        })

        //전기사용량★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas3 = $('#barChart3').get(0).getContext('2d')

            var barChartData3 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(236,194,76,1)',
                    borderColor         : 'rgba(236,194,76,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(236,194,76,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(236,194,76,1)',
                    data                : thisYearElectricityUsageData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearElectricityUsageData
                }
            ]
            }

            var temp0 = barChartData3.datasets[0]
            var temp1 = barChartData3.datasets[1]
            barChartData3.datasets[0] = temp1
            barChartData3.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += 'KWH';
                                return label;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',       // 라벨 위치 설정
                        align: 'end',        // 라벨 정렬 설정
                        formatter: function(value) {
                            if (isNaN(value)) {
                                return '';
                            }
                            else {
                                return new Intl.NumberFormat('en-US', { maximumSignificantDigits: 6 } ).format(value);                         
                            }
                        },
                        color: '#444',       // 라벨 색상 설정
                        font: {
                            weight: 'bold'
                        }
                    }
                },        
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }     
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas3, {
                type: 'bar',
                data: barChartData3,
                options: barChartOptions,
                plugins: [ChartDataLabels]  // 여기에서만 플러그인을 지정
            }) 
        })

        //가스사용량★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas2 = $('#barChart2').get(0).getContext('2d')

            var barChartData2 = {
                labels  : ['합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(232,85,70,1)',
                    borderColor         : 'rgba(232,85,70,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(232,85,70,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(232,85,70,1)',
                    data                : thisYearGasUsageData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearGasUsageData
                }
            ]
            }

            var temp0 = barChartData2.datasets[0]
            var temp1 = barChartData2.datasets[1]
            barChartData2.datasets[0] = temp1
            barChartData2.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '㎥';
                                return label;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',       // 라벨 위치 설정
                        align: 'end',        // 라벨 정렬 설정
                        formatter: function(value) {
                            if (isNaN(value)) {
                                return '';
                            }
                            else {
                                return new Intl.NumberFormat('en-US', { maximumSignificantDigits: 6 } ).format(value); // 금액 포맷                        
                            }
                        },
                        color: '#444',       // 라벨 색상 설정
                        font: {
                            weight: 'bold'
                        }
                    }
                },        
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas2, {
                type: 'bar',
                data: barChartData2,
                options: barChartOptions,
                plugins: [ChartDataLabels]  // 여기에서만 플러그인을 지정
            }) 
        })

        //수도사용량★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas = $('#barChart').get(0).getContext('2d')

            var barChartData = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(75,112,221, 1)',
                    borderColor         : 'rgba(75,112,221, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(75,112,221, 1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(75,112,221, 1)',
                    data                :  thisYearWaterIwinUsageData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : lastYearWaterIwinUsageData
                }
                ]
            }

            var temp0 = barChartData.datasets[0]
            var temp1 = barChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '㎥';
                                return label;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',       // 라벨 위치 설정
                        align: 'end',        // 라벨 정렬 설정
                        formatter: function(value) {
                            if (isNaN(value)) {
                                return '';
                            }
                            else {
                                return new Intl.NumberFormat('en-US', { maximumSignificantDigits: 5 } ).format(value); // 금액 포맷                        
                            }
                        },
                        color: '#444',       // 라벨 색상 설정
                        font: {
                            weight: 'bold'
                        }
                    }
                },        
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions,
                plugins: [ChartDataLabels]  // 여기에서만 플러그인을 지정
            }) 
        })
        
        //사무직 급여★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas55 = $('#barChart55').get(0).getContext('2d')

            var barChartData55 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(97,175,185,1)',
                    borderColor         : 'rgba(97,175,185,1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(97,175,185,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : thisYearPayChartData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearPayChartData
                }
            ]
            }

            var temp0 = barChartData55.datasets[0]
            var temp1 = barChartData55.datasets[1]
            barChartData55.datasets[0] = temp1
            barChartData55.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas55, {
                type: 'bar',
                data: barChartData55,
                options: barChartOptions
            }) 
        })

        //도급비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas5 = $('#barChart5').get(0).getContext('2d')

            var barChartData5 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : thisYearPay2ChartData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearPay2ChartData
                }
            ]
            }

            var temp0 = barChartData5.datasets[0]
            var temp1 = barChartData5.datasets[1]
            barChartData5.datasets[0] = temp1
            barChartData5.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas5, {
                type: 'bar',
                data: barChartData5,
                options: barChartOptions
            }) 
        })
        
        //전기비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas33 = $('#barChart33').get(0).getContext('2d')

            var barChartData33 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(236,194,76,1)',
                    borderColor         : 'rgba(236,194,76,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(236,194,76,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(236,194,76,1)',
                    data                : thisYearElecChartData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearElecChartData
                }
            ]
            }

            var temp0 = barChartData33.datasets[0]
            var temp1 = barChartData33.datasets[1]
            barChartData33.datasets[0] = temp1
            barChartData33.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    title: {
                        display: true,
                        align: 'end',
                        position: 'top',
                        text: '[단위: 만원]'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',       // 라벨 위치 설정
                        align: 'end',        // 라벨 정렬 설정
                        formatter: function(value) {
                            if (isNaN(value)) {
                                return '';
                            }
                            else {
                                return new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(value/10000); // 금액 포맷                        
                            }
                        },
                        color: '#444',       // 라벨 색상 설정
                        font: {
                            weight: 'bold'
                        }
                    }
                },        
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas33, {
                type: 'bar',
                data: barChartData33,
                options: barChartOptions,
                plugins: [ChartDataLabels]  // 여기에서만 플러그인을 지정
            }) 
        })

        //가스비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas22 = $('#barChart22').get(0).getContext('2d')

            var barChartData22 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(232,85,70,1)',
                    borderColor         : 'rgba(232,85,70,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(232,85,70,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(232,85,70,1)',
                    data                : thisYearGasChartData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearGasChartData
                }
            ]
            }

            var temp0 = barChartData22.datasets[0]
            var temp1 = barChartData22.datasets[1]
            barChartData22.datasets[0] = temp1
            barChartData22.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas22, {
                type: 'bar',
                data: barChartData22,
                options: barChartOptions
            }) 
        })

        //수도비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas11 = $('#barChart11').get(0).getContext('2d')

            var barChartData11 = {
                labels  : ['년 합계', '월 누적 합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(75,112,221, 1)',
                    borderColor         : 'rgba(75,112,221, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(75,112,221, 1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(75,112,221, 1)',
                    data                : thisYearWaterChartData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearWaterChartData
                }
                ]
            }

            var temp0 = barChartData11.datasets[0]
            var temp1 = barChartData11.datasets[1]
            barChartData11.datasets[0] = temp1
            barChartData11.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas11, {
                type: 'bar',
                data: barChartData11,
                options: barChartOptions
            }) 
        })  

        //운반비★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas8 = $('#barChart8').get(0).getContext('2d')

            var barChartData8 = {
                labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : thisYearDeliChartData
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : lastYearDeliChartData
                }
            ]
            }

            var temp0 = barChartData8.datasets[0]
            var temp1 = barChartData8.datasets[1]
            barChartData8.datasets[0] = temp1
            barChartData8.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                }   
            }

            new Chart(barChartCanvas8, {
                type: 'bar',
                data: barChartData8,
                options: barChartOptions
            }) 
        })

        //재무제표★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas6 = $('#barChart6').get(0).getContext('2d')

            var barChartData6 = {
                labels  : ['매출액', '매출원가', '판매비와관리비', '영업외이익(손실)', '당기순이익(손실)'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : financeDataCY
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : financeDataCY_1
                },
                {
                    label               : '<?php echo $Minus2YY?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : financeDataCY_2
                },
                {
                    label               : '<?php echo $Minus3YY?>년',
                    backgroundColor     : 'rgba(147, 156, 176, 1)',
                    borderColor         : 'rgba(147, 156, 176, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(147, 156, 176, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : financeDataCY_3
                }
            ]
            }

            var temp0 = barChartData6.datasets[0]
            var temp1 = barChartData6.datasets[1]
            var temp2 = barChartData6.datasets[2]
            var temp3 = barChartData6.datasets[3]
            barChartData6.datasets[0] = temp3
            barChartData6.datasets[1] = temp2
            barChartData6.datasets[2] = temp1
            barChartData6.datasets[3] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(barChartCanvas6, {
                type: 'bar',
                data: barChartData6,
                options: barChartOptions
            }) 
        })

        //매출 - 항목별(%)★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')

            var donutData = {
                labels  : ['히터', '발열핸들(열선)', '통풍(이원컴포텍)', '통풍', '통합ECU', '일반ECU', '기타'],
                datasets: [
                {          
                    data                : salesDonutData,
                    backgroundColor     : ['rgba(78,121,165, 1)', 
                                        'rgba(241,143,59, 1)', 
                                        'rgba(224,88,91, 1)', 
                                        'rgba(119,183,178, 1)', 
                                        'rgba(90,161,85, 1)', 
                                        'rgba(237,201,88, 1)', 
                                        'rgba(175,122,160, 1)']
                }
            ]
            }

            var donutOptions     = {
                maintainAspectRatio : false,
                responsive          : true,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed);
                                }
                                label += '%';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            }) 
        })

        //매출 - 년도별(원)★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')

            var lineChartData = {
                labels  : annualSalesLabels,
                datasets: [
                {
                    label               : '매출',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius         : 6,
                    pointStyle          : 'circle',
                    fill                : true,
                    lineTension         : 0,                      //0이면 선모양 직선
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : annualSalesData
                }
            ]
            }
            
            var lineChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true   //0부터 시작
                    }
                }     
            }    

            lineChartData.datasets[0].fill = false
            lineChartOptions.datasetFill = false

            new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })
        })

        //매출 - 월 항목별 매출 추이(원)★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')

            var stackedBarChartData = {
                labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                {
                    label               : '히터',
                    backgroundColor     : 'rgba(78,121,165, 1)',
                    borderColor         : 'rgba(78,121,165, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : heaterData
                },
                {
                    label               : '발열핸들(열선)',
                    backgroundColor     : 'rgba(241,143,59, 1)',
                    borderColor         : 'rgba(241,143,59, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : handleData
                },
                {
                    label               : '통풍(이원컴포텍)',
                    backgroundColor     : 'rgba(224,88,91, 1)',
                    borderColor         : 'rgba(224,88,91, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : iwonData
                },
                {
                    label               : '통풍',
                    backgroundColor     : 'rgba(119,183,178, 1)',
                    borderColor         : 'rgba(119,183,178, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : ventData
                },
                {
                    label               : '통합ECU',
                    backgroundColor     : 'rgba(90,161,85, 1)',
                    borderColor         : 'rgba(90,161,85, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : integratedEcuData
                },
                {
                    label               : '일반ECU',
                    backgroundColor     : 'rgba(237,201,88, 1)',
                    borderColor         : 'rgba(237,201,88, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : generalEcuData
                },
                {
                    label               : '기타',
                    backgroundColor     : 'rgba(175,122,160, 1)',
                    borderColor         : 'rgba(175,122,160, 1)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : etcData
                }
            ]
            }
            
            var stackedBarChartOptions = {
                responsive          : true,
                maintainAspectRatio : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {     
                        //툴팁 단위 원 표시  
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            },
                            //툴팁 합계 표시
                            footer: function(tooltipItems) {
                                let sum = 0;

                                tooltipItems.forEach(function(tooltipItem) {
                                    sum += tooltipItem.parsed.y;
                                });

                                return '합계: ' + Number(sum).toLocaleString() + '원';
                            }
                        },
                        //툴팁 모두 표시
                        mode: 'x'
                    }
                },
                scales: {
                x: {
                stacked: true,
                },
                y: {
                stacked: true
                }
            }
            }  

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
        
        //실패비용 ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas7 = $('#barChart7').get(0).getContext('2d')

            var barChartData7 = {
                labels  : ['합계', '시트히터', '발열핸들', '통풍시트'],
                datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(40,192,141,1)',
                    borderColor         : 'rgba(40,192,141,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(40,192,141,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(40,192,141,1)',
                    data                : <?php echo $currentYearJson; ?>
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : <?php echo $previousYearJson; ?>
                },
                {
                    label               : '<?php echo $Minus2YY?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : <?php echo $yearBeforeJson; ?>
                }
                ]
            }

            var temp0 = barChartData7.datasets[0]
            var temp1 = barChartData7.datasets[1]
            var temp2 = barChartData7.datasets[2]
            barChartData7.datasets[0] = temp2
            barChartData7.datasets[1] = temp1
            barChartData7.datasets[2] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '원';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'logarithmic',
                    }
                }
            }

            const logNumbers = (num) => {
                const data = [];

                for (let i = 0; i < num; ++i) {
                data.push(Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5)));
                }

                return data;
            };

            const actions = [
                {
                name: 'Randomize',
                handler(chart) {
                    chart.data.datasets.forEach(dataset => {
                    dataset.data = logNumbers(chart.data.labels.length);
                    });
                    chart.update();
                }
                },
            ];

            new Chart(barChartCanvas7, {
                type: 'bar',
                data: barChartData7,
                options: barChartOptions
            }) 
        })

        //베트남 인원증감★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvasV1 = $('#barChartV1').get(0).getContext('2d')

            var barChartDataV1 = {
            labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            datasets: [
                {
                    label               : '<?php echo $YY?>년',
                    backgroundColor     : 'rgba(97,175,185,1)',
                    borderColor         : 'rgba(97,175,185,1)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(97,175,185,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(97,175,185,1)',
                    data                : [<?php echo $thisYearVietnamTotals[1]; ?>, 
                                        <?php echo $thisYearVietnamTotals[2]; ?>, 
                                        <?php echo $thisYearVietnamTotals[3]; ?>, 
                                        <?php echo $thisYearVietnamTotals[4]; ?>, 
                                        <?php echo $thisYearVietnamTotals[5]; ?>, 
                                        <?php echo $thisYearVietnamTotals[6]; ?>, 
                                        <?php echo $thisYearVietnamTotals[7]; ?>, 
                                        <?php echo $thisYearVietnamTotals[8]; ?>, 
                                        <?php echo $thisYearVietnamTotals[9]; ?>, 
                                        <?php echo $thisYearVietnamTotals[10]; ?>, 
                                        <?php echo $thisYearVietnamTotals[11]; ?>,
                                        <?php echo $thisYearVietnamTotals[12]; ?>]
                },
                {
                    label               : '<?php echo $Minus1YY?>년',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : [<?php echo $lastYearVietnamTotals[1]; ?>, 
                                        <?php echo $lastYearVietnamTotals[2]; ?>, 
                                        <?php echo $lastYearVietnamTotals[3]; ?>, 
                                        <?php echo $lastYearVietnamTotals[4]; ?>, 
                                        <?php echo $lastYearVietnamTotals[5]; ?>, 
                                        <?php echo $lastYearVietnamTotals[6];; ?>, 
                                        <?php echo $lastYearVietnamTotals[7]; ?>, 
                                        <?php echo $lastYearVietnamTotals[8]; ?>, 
                                        <?php echo $lastYearVietnamTotals[9]; ?>, 
                                        <?php echo $lastYearVietnamTotals[10]; ?>, 
                                        <?php echo $lastYearVietnamTotals[11]; ?>,
                                        <?php echo $lastYearVietnamTotals[12]; ?>]
                }
            ]
            }

            var temp0 = barChartDataV1.datasets[0]
            var temp1 = barChartDataV1.datasets[1]
            barChartDataV1.datasets[0] = temp1
            barChartDataV1.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '명';
                                return label;
                            }
                        }
                    }
                }
            }

            new Chart(barChartCanvasV1, {
                type: 'bar',
                data: barChartDataV1,
                options: barChartOptions
            }) 
        })
    </script>
</body>
</html>


<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) {mysqli_close($connect4);}	

    //MSSQL 메모리 회수
    if(isset($connect)) {sqlsrv_close($connect);}
?>