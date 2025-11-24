<?php 
  // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.11.6>
	// Description:	<esg 이산화탄소 배출량>	
	// =============================================
    include 'esg_status.php';   
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">ESG</h1>
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
                                            <a class="nav-link <?php echo $tab4;?>" id="tab-four" data-toggle="pill" href="#tab4">ESG</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="tab-five" data-toggle="pill" href="#tab5">ESG진단</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab6;?>" id="tab-six" data-toggle="pill" href="#tab6">ESG DATA 관리</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">온실가스 배출량</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-there" data-toggle="pill" href="#tab3">폐기물</a>
                                        </li>                                          
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [ESG 개요]<br>
                                            - 온실가스 배출량은 Scope1, Scope2로 분류된다<br>
                                            - Scope1은 고정연소, 이동연소, 공정배출, 폐기물 소각<br>
                                            - Scope2은 전력 사용시설, 열/스팀 사용시설<br><br>

                                            [참조]<br>
                                            0. 공용<br>
                                            - ASEM 중소기업친환경혁신센터(http://asemsmenetzero.com/sub/sub_03.php)에서 엑셀 파일을 다운로드 할 수 있다.<br>
                                            1. Scope1) 폐기물 소각<br>
                                            - 폐기물처리에서 인계일자와 등록일자는 동일함<br>
                                            - 인계량은 보통 소수점이 나오지 않음<br>  
                                            - 폐기물 온실가스 배출량(tCO2eq) = 폐기물소각량(kg) x 배출계수(해당 폐기물) x 산화계수 x 지구온난화지수(GWP)<br>   
                                            - 폐기물소각량은 ALLBARO등록량, 배출계수는 온실가스환산툴에 기타 사업장 폐기물로 계산<br>    
                                            - 폐기물 중 폐수는 하지 않음<br>   
                                            - 엑셀이랑 비교 헀을 때 소수점 차이가 나는데 정수가 일단 맞으니 패스<br> 
                                            2. Scope1) 고정연소<br>
                                            - [m³ > tCO2 환산]<br>
                                               STEP1. 사용열량(MJ) = 계량기 사용량(m³) * 발열계수(MJ/m³) OR 계량기 사용량(m³) * 발열량(MJ)<br>
                                                > 부산도시가스 1m³ = 42.73MJ(발열량)<br>
                                                > ex)1500m³ * 42.73MJ = 64095MJ<br>
                                                STEP2. 연료 사용량(Nm³) = 사용열량(MJ) / 43.1MJ/Nm³(총발열량) <br>
                                                > 에너지법 시행규칙 에너지열량 환산기준 : 도시가스(LNG) 43.1MJ/Nm³(총발열량), 38.9MJ/Nm³(순발열량) <br>
                                                > ex)64095MJ / 43.1MJ/Nm³ = 1,487.12Nm³<br>
                                                STEP3. 연료발열량(MJ) = 연료 사용량(Nm³) * 38.9MJ/Nm³(순발열량) <br>
                                                > ex)1,487.12Nm³ * 38.9MJ/Nm³ = 57,848.968MJ<br>
                                                STEP4. 탄소배출량(tC) = 연료발열량(MJ) × 탄소배출계수(15.236)(tC/TJ) / 1000000 <br>
                                                > ex)57,848.968MJ * 15.236tC/TJ / 1000000 = 0.881386876448tC<br>
                                                STEP5. 이산화탄소배출량(tCO2) = 탄소배출량(tC) × 44 / 12(이산화탄소 분자량/탄소분자량)(CO2eq/C) <br>
                                                > ex)0.881386876448tC * 44 / 12 = 3.231751880309333tCO2 <br>
                                            3. Scope1) 이동연소<br>
                                            - 산정방법 : 연료사용량(L)*순발열량(해당연료)*배출계수(해당연료)*산하계수*지구온난화지수(GWP)<br>
                                                > 휘발유 순발열량=30.4 / 배출계수=69,300<br>
                                                > 경유 순발열량=35.2 / 배출계수=74,100<br>
                                                > LPG 순발열량=45.7 / 배출계수=63,100<br>
                                                > 산하계수와 지구온난화지수는 둘다 1로 고정<br>
                                                > 위 수식대로 계산하니 http://asemsmenetzero.com/sub/sub_03.php 의 엑셀 결과값과 동일하게 하기 위해서는 10억을 나눠야 함(단위변환 과정에서 나눠줘야 되는 것으로 보임)<br>
                                            - 통근버스 월600L * 2대로 계산함(기사님들 구두정보 토대로 평균값으로 반영함)<br>
                                            - FMS 미 관리 법인차량(3101, 5210, 2103, 1156, 0300, 7730)은 월 주유량 엑셀데이터 평균값을 반영함 (all휘발유)<br>
                                            - 1L의 LNG, LPG, 휘발유, 경유는 각각 0.41, 0.60, 0.70, 0.77kg <br><br>

                                            [히스토리]<br>
                                            25.5.13<br>
                                            - 현재 월까지 데이터가 출력되도록 함 <br>
                                            - 여성직원에 아무것도 출력되지 않는 에러를 해결함 <br>
                                            - 비율에 NAN으로 출력되는 에러를 해결함 <BR>

                                        </div>

                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->        
                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="tab4" role="tabpanel" aria-labelledby="tab-four">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            
                                            [ESG 경영]<br>
                                            - 지속적으로 발전할 수 있는 형태의 경영방식<br>
                                            - E(환경) / S(사회) / G(지배구조)<br>
                                            <br>
                                            [E(환경) 배경]<br>
                                            - 유럽<br>
                                                > 제품을 탄소로 치환하고 기준값을 넘길 시 구매하지 않겠다.<br>
                                                > 원료, 제조, 수송, 사용, 폐기 전과정을 탄소로 치환<br>
                                            - 현대자동차<br>
                                                > 사용하는 원재료에 대해서는 탄소로 치환하기가 어렵다.<br>
                                                > 1, 2차사도 하도록 교육을 하자!<br>
                                                > 하지 않으면 아이템 1개씩 수주받지 못하도록 하자! (2026년 부터)<br>
                                            <br>
                                            [히스토리]<br>
                                            - 22.05 현대 트랜시스 자가진단<br>
                                            - 23.08 대한상공회의소 ESG 컨설팅<br>
                                            - 23.05 현대 트랜시스 자가진단<br>
                                            - 23.10 현대 트랜시스 ESG 컨설팅<br>
                                            - 24.04 ESG 교육 (온실가스 배출량 산정, LCA의 이해)<br>
                                            - 24.05 두올 탄소배출량 조사 대응<br>
                                            - 24.05 현대 트랜시스 ESG 컨설팅 설명회 참석<br>
                                            - 24.05~06 현대 트랜시스 자가진단 및 제출<br>
                                            - 24.07 나이스디앤비 ESG컨설팅 1차<br>
                                            - 24.08 나이스디앤비 ESG컨설팅 2차<br>
                                            - 24.09 트랜시스 ESG자가진단 결과<br>
                                            - 24.10 나이스디앤비 ESG컨설팅 3차<br>
                                            - 24.11 나이스디앤비 ESG실태표조사(결과는12월중순예정)<br>
                                            - 24.12 나이스디앤비 ESG실태표 결과나옴(A+)<br>
                                            - 25.04 에코바디스 ESG스코어카드 결과나옴(49/100)_상위 35%_정책배지 수여<br>
                                            - 25.04 현대자동차 2025 "자동차부품산업 ESG · 탄소중립 박람회 온라인 세미나" 시청<br>
                                            - 25.05 현대트랜시스 공급망 ESG 평가<br>
                                            - 25.06 케이비오토텍 ESG 협력사 진단<br>
                                            - 25.07 DH오토리드 협력사 인권 환경 리스크 진단표 제출<br>
                                            - 25.07 현대트랜시스 협력사 사업장 탄소배출량 제출<br>
                                        </div>

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->        
                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="tab5" role="tabpanel" aria-labelledby="tab-five">
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">ESG 진단</h6>
                                                    </a>                                                   
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample51">
                                                            <div class="card-body table-responsive p-2">
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                        <thead>
                                                                            <tr>                                                                                
                                                                                <th>년도</th>
                                                                                <th>구분</th>
                                                                                <th>평가 점수</th>
                                                                                <th>진단 레포트</th> 
                                                                                <th>비고</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>2023년</td>
                                                                                <td>대한상공회의소</td>
                                                                                <td>2.77/10</td>  
                                                                                <td>
                                                                                    <a href="https://fms.iwin.kr/files/2023_esg1.pdf" target="_blank">
                                                                                        <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                            <i class="fas fa-square fa-2x"></i>
                                                                                            <i class="fas fa-file fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>
                                                                                    </a>
                                                                                </td>
                                                                                <td>-</td> 
                                                                            </tr>
                                                                            <tr>
                                                                                <td>2023년</td>
                                                                                <td>현대트랜시스</td>
                                                                                <td>59.6/100</td>
                                                                                <td>
                                                                                    <a href="https://fms.iwin.kr/files/2023_esg2.pdf" target="_blank">
                                                                                        <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                            <i class="fas fa-square fa-2x"></i>
                                                                                            <i class="fas fa-file fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>
                                                                                    </a>
                                                                                </td>          
                                                                                <td>-</td>                                                               
                                                                            </tr>       
                                                                            <tr>
                                                                                <td>2024년</td>
                                                                                <td>현대트랜시스</td>
                                                                                <td>50.7/100</td>
                                                                                <td>
                                                                                    <a href="https://fms.iwin.kr/files/2024_esg2.pdf" target="_blank">
                                                                                        <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                            <i class="fas fa-square fa-2x"></i>
                                                                                            <i class="fas fa-file fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>
                                                                                    </a>
                                                                                </td>          
                                                                                <td>
                                                                                    - 지표 재정립(EU 법규 반영 등)하면서 고도화됨에 따라 전체 협력사 평균점수가 10점점도 낮게 측정됨<br>
                                                                                    - 개선과제는 고위험사 대상으로만 부여. 아이윈은 없음. BUT 내년 문항별 개선이 필요<br>
                                                                                </td>                                                               
                                                                            </tr>
                                                                            <tr>
                                                                                <td>2024년</td>
                                                                                <td>나이스디앤비</td>
                                                                                <td>A+</td>
                                                                                <td>
                                                                                    <a href="https://fms.iwin.kr/files/2024_esg_nicednb.pdf" target="_blank">
                                                                                        <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                            <i class="fas fa-square fa-2x"></i>
                                                                                            <i class="fas fa-file fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>
                                                                                    </a>
                                                                                </td> 
                                                                                <td>-</td>       
                                                                            <tr>
                                                                                <td>2025년</td>
                                                                                <td>에코바디스</td>
                                                                                <td>49/100</td>
                                                                                <td>
                                                                                    <a href="https://fms.iwin.kr/files/2025_esg_ecovadis.pdf" target="_blank">
                                                                                        <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                            <i class="fas fa-square fa-2x"></i>
                                                                                            <i class="fas fa-file fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>
                                                                                    </a>
                                                                                </td>    
                                                                                <td>상위 35%, Committed 배지 획득(45점 이상 획득 시 발행되는 카드)</td>     
                                                                            </tr>  
                                                                            <tr>
                                                                                <td>2025년</td>
                                                                                <td>현대트랜시스</td>
                                                                                <td>53.05/100</td>
                                                                                <td>
                                                                                    <a href="https://fms.iwin.kr/files/2025_esg_hyundai.pdf" target="_blank">
                                                                                        <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                            <i class="fas fa-square fa-2x"></i>
                                                                                            <i class="fas fa-file fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>
                                                                                    </a>
                                                                                </td>    
                                                                                <td>-</td>     
                                                                            </tr>            
                                                                        </tbody>
                                                                    </table>
                                                                </div>                                     
                                                            </div>
                                                            <!-- /.card-body -->                                                             
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>   
                                        </div>

                                        <!-- 4번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">  
                                            <!-- 차트 - 합계 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                    <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample20" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample20">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">이산화탄소 환산량 합계</h1>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#total_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#total_table" data-toggle="tab">표</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample20">                                    
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="total_chart" style="position: relative; height: 300px;">
                                                                    <canvas id="barChart5"></canvas>
                                                                </div>
                                                                <div class="chart tab-pane" id="total_table" style="position: relative; height: 300px;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $YY; ?></th>
                                                                                <td><?php echo number_format(
                                                                                    ($thisYearOilCO2Sum ?? 0) + 
                                                                                    ($thisYearGasCO2Sum ?? 0) + 
                                                                                    ($thisYearTrashCO2Sum ?? 0) + 
                                                                                    ($thisYearElectricityCO2Sum ?? 0), 2); ?>
                                                                                </td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format(
                                                                                        ($thisYearOilCO2[$i] ?? 0) + 
                                                                                        ($thisYearGasCO2[$i] ?? 0) + 
                                                                                        ($thisYearTrashCO2[$i] ?? 0) + 
                                                                                        ($thisYearElectricityCO2[$i] ?? 0), 2); ?>
                                                                                    </td>
                                                                                <?php endfor; ?>
                                                                                <?php for ($i = date('n') + 1; $i <= 12; $i++): ?>
                                                                                    <td></td>
                                                                                <?php endfor; ?>
                                                                            </tr>

                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $Minus1YY; ?></th>
                                                                                <td><?php echo number_format(
                                                                                    ($oneYearAgoOilCO2Sum ?? 0) + 
                                                                                    ($lastYearGasCO2Sum ?? 0) + 
                                                                                    ($lastYearTrashCO2Sum ?? 0) + 
                                                                                    ($lastYearElectricityCO2Sum ?? 0), 2); ?>
                                                                                </td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format(
                                                                                        ($oneYearAgoOilCO2[$i] ?? 0) + 
                                                                                        ($lastYearGasCO2[$i] ?? 0) + 
                                                                                        ($lastYearTrashCO2[$i] ?? 0) + 
                                                                                        ($lastYearElectricityCO2[$i] ?? 0), 2); ?>
                                                                                    </td>
                                                                                <?php endfor; ?> 
                                                                            </tr>

                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $Minus2YY; ?></th>
                                                                                <td><?php echo number_format(
                                                                                    ($twoYearsAgoOilCO2Sum ?? 0) + 
                                                                                    ($twoYearsAgoGasCO2Sum ?? 0) + 
                                                                                    ($twoYearsAgoTrashCO2Sum ?? 0) + 
                                                                                    ($twoYearsAgoElectricityCO2Sum ?? 0), 2); ?>
                                                                                </td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format(
                                                                                        ($twoYearsAgoOilCO2[$i] ?? 0) + 
                                                                                        ($twoYearsAgoGasCO2[$i] ?? 0) + 
                                                                                        ($twoYearsAgoTrashCO2[$i] ?? 0) + 
                                                                                        ($twoYearsAgoElectricityCO2[$i] ?? 0), 2); ?>
                                                                                    </td>
                                                                                <?php endfor; ?>
                                                                            </tr>

                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $Minus3YY; ?></th>
                                                                                <td><?php echo number_format(
                                                                                    ($threeYearsAgoOilCO2Sum ?? 0) + 
                                                                                    ($threeYearsAgoGasCO2Sum ?? 0) + 
                                                                                    ($threeYearsAgoTrashCO2Sum ?? 0) + 
                                                                                    ($threeYearsAgoElectricityCO2Sum ?? 0), 2); ?>
                                                                                </td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format(
                                                                                        ($threeYearsAgoOilCO2[$i] ?? 0) + 
                                                                                        ($threeYearsAgoGasCO2[$i] ?? 0) + 
                                                                                        ($threeYearsAgoTrashCO2[$i] ?? 0) + 
                                                                                        ($threeYearsAgoElectricityCO2[$i] ?? 0), 2); ?>
                                                                                    </td>
                                                                                <?php endfor; ?>
                                                                            </tr>
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
                                            <!-- 차트 - 이동연소 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                    <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">이동연소 이산화탄소 환산량</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#move_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#move_table" data-toggle="tab">표</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#move_table2" data-toggle="tab">표 - 사용량(휘발유)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#move_table3" data-toggle="tab">표 - 사용량(경유)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#move_table4" data-toggle="tab">표 - 사용량(LPG)</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="move_chart" style="position: relative; height: 300px;">
                                                                    <canvas id="barChart1"></canvas>
                                                                </div>
                                                                <div class="chart tab-pane" id="move_table" style="position: relative; height: 300px;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearOilCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearOilCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($oneYearAgoOilCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($oneYearAgoOilCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoOilCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoOilCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoOilCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoOilCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="move_table2" style="position: relative; height: 300px;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearmonthlyOilSumTotal['휘발유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearmonthlyOilSum['휘발유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($oneYearAgomonthlyOilSumTotal['휘발유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($oneYearAgomonthlyOilSum['휘발유'][$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgomonthlyOilSumTotal['휘발유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgomonthlyOilSum['휘발유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>                                                                           
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgomonthlyOilSumTotal['휘발유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgomonthlyOilSum['휘발유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="move_table3" style="position: relative; height: 300px;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearmonthlyOilSumTotal['경유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearmonthlyOilSum['경유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($oneYearAgomonthlyOilSumTotal['경유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($oneYearAgomonthlyOilSum['경유'][$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgomonthlyOilSumTotal['경유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgomonthlyOilSum['경유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>                                                                            
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgomonthlyOilSumTotal['경유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgomonthlyOilSum['경유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="move_table4" style="position: relative; height: 300px;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearmonthlyOilSumTotal['LPG'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearmonthlyOilSum['LPG'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($oneYearAgomonthlyOilSumTotal['LPG'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($oneYearAgomonthlyOilSum['LPG'][$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgomonthlyOilSumTotal['LPG'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgomonthlyOilSum['LPG'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgomonthlyOilSumTotal['LPG'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgomonthlyOilSum['LPG'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
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
                                            <!-- 차트 - 도시가스(고정연소) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">도시가스(고정연소) 이산화탄소 환산량</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#gas_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#gas_table" data-toggle="tab">표</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#gas_table2" data-toggle="tab">표 - 사용량</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample22">                                    
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="gas_chart" style="position: relative; height: 300px;">
                                                                    <canvas id="barChart2"></canvas>
                                                                </div>
                                                                                                                                <div class="chart tab-pane" id="gas_table" style="position: relative; height: 300px;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearGasCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearGasCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearGasCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearGasCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoGasCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoGasCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoGasCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoGasCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="gas_table2" style="position: relative; height: 300px;">
                                                                    <P>- 단위: m3</P>
                                                                    <P>- 단위가 Nm3인 경우 m3*0.9869*0.9472 (표준온도와 표준압력을 사용)</P>
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearGasUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearGasUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearGasUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearGasUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoGasUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoGasUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoGasUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoGasUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
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
                                            <!-- 차트 - 전기 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">전기 이산화탄소 환산량</h6>
                                                    </a>
                                                    <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#elec_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#elec_table" data-toggle="tab">표</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#elec_table2" data-toggle="tab">표 - 사용량</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample24">                                    
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="elec_chart" style="position: relative; height: 300px;">
                                                                    <canvas id="barChart4"></canvas>
                                                                </div>
                                                                <div class="chart tab-pane" id="elec_table" style="position: relative; height: 300px;">                                                                    
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearElectricityCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearElectricityCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearElectricityCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearElectricityCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoElectricityCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoElectricityCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoElectricityCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoElectricityCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="elec_table2" style="position: relative; height: 300px;">
                                                                    <P>- 단위: Kwh</P>
                                                                    <P>- 단위가 Mwh인 경우 Kwh/1000</P>
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearElectricityUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearElectricityUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearElectricityUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearElectricityUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoElectricityUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoElectricityUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoElectricityUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoElectricityUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
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
                                            <!-- 차트 - 폐기물 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">폐기물 이산화탄소 환산량</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#gar_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#gar_table" data-toggle="tab">표</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#gar_table2" data-toggle="tab">표 - 폐기량</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample23">                                    
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="gar_chart" style="position: relative; height: 300px;">
                                                                    <canvas id="barChart3"></canvas>
                                                                </div>
                                                                <div class="chart tab-pane" id="gar_table" style="position: relative; height: 300px;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearTrashCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearTrashCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearTrashCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearTrashCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoTrashCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoTrashCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoTrashCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoTrashCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="gar_table2" style="position: relative; height: 300px;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">합계</th>
                                                                                <th scope="col">1월</th>
                                                                                <th scope="col">2월</th>
                                                                                <th scope="col">3월</th>
                                                                                <th scope="col">4월</th>
                                                                                <th scope="col">5월</th>
                                                                                <th scope="col">6월</th>
                                                                                <th scope="col">7월</th>
                                                                                <th scope="col">8월</th>
                                                                                <th scope="col">9월</th>
                                                                                <th scope="col">10월</th>
                                                                                <th scope="col">11월</th>
                                                                                <th scope="col">12월</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearTrashSum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearTrash[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearTrashSum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearTrash[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoTrashSum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoTrash[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoTrashSum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoTrash[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
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

                                        <!-- 5번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->        
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="esg.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">                                    
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
                                                                                <?php 
                                                                                    if($dt3!='') {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt3">
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" name="dt3">
                                                                                <?php 
                                                                                    }
                                                                                ?> 
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
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
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <div class="row">
                                                                <!-- 보드 시작 -->
                                                                <?php 
                                                                    BOARD(4, "primary", $YY."년", round($Data_Trash1['GIVE_QUNT']/1000,1)." TON", "fas fa-trash-alt");
                                                                    BOARD(4, "primary", $Minus1YY."년", round($Data_Trash2['GIVE_QUNT']/1000,1)." TON", "fas fa-trash-alt");
                                                                    BOARD(4, "primary", $Minus2YY."년", round($Data_Trash3['GIVE_QUNT']/1000,1)." TON", "fas fa-trash-alt");
                                                                ?>
                                                                <!-- 보드 끝 -->
                                                            </div>

                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>인계량(kg)</th>
                                                                        <th>인계일자</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        // $Result_Trash 변수는 이미 모든 데이터가 담긴 배열이므로,
                                                                        // foreach 루프를 사용하여 배열의 요소를 순회합니다.
                                                                        foreach ($Result_Trash as $Data_Trash) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo round($Data_Trash['GIVE_QUNT'], 0); ?></td>
                                                                            <td><?php echo htmlspecialchars($Data_Trash['WORK_DATE']); ?></td>
                                                                        </tr>
                                                                    <?php
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

                                        <!-- 6번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->        
                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="tab6" role="tabpanel" aria-labelledby="tab-six">
                                            <p style="color: red;">※카드가 닫혀있습니다. 원하는 년도의 카드를 클릭하여 데이터를 열람하세요!</p>
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample61" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample61">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">DATA SHEET (<?php echo $YY; ?>년)</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#esg_e" data-toggle="tab">환경</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#esg_s" data-toggle="tab">사회</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#esg_g" data-toggle="tab">지배구조</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse" id="collapseCardExample61">
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="esg_e"  style="position: relative;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리대상</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">단위</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">12월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">비고</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">자동화</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3" colspan="2">에너지</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">보유 차량 휘발유 소비량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">E-4-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 302</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">L</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearmonthlyOilSum['휘발유'][$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearmonthlyOilSumTotal['휘발유']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>     
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">보유 차량 경유 소비량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">L</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearmonthlyOilSum['경유'][$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearmonthlyOilSumTotal['경유']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">사업장 내 전력 소비량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">KWH</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearElectricityUsageData[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearElectricityUsageData[0]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3" colspan="2">온실가스</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 휘발유</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">E-3-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 305</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearmonthlyOilCO2['휘발유'][$i], 2); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?> 
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearmonthlyOilCO2Total['휘발유'], 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>     
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 경유</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearmonthlyOilCO2['경유'][$i], 2); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearmonthlyOilCO2Total['경유'], 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 전기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearElectricityCO2[$i], 2); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearElectricityCO2Sum, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr> 
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">용수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">용수 사용량(상하수)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-5-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 303</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">㎥</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearWaterIwinUsageData[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?> 
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearWaterIwinUsageData[0] ?? 0); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2" rowspan="3">페기물</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">페기물 배출량(일반)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">E-6-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 306</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">kg</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearTrash[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?> 
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearTrashSum); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">폐기물 배출량(지정/유해)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">kg</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">폐기물 재활용/재사용량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-6-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2" rowspan="4">오염물질</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">Nox(질소산화물)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">E-7-1, E-7-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 303</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">Sox(황산화물)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">VOCs(휘발성 유기화합물)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">분진 배출량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">환경경영시스템</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ISO 14001 적용 사업장 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12">100</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">100</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>   
                                                                <div class="chart tab-pane" id="esg_s" style="position: relative;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리현황</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">단위</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">12월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">비고</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">자동화</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="18">임직원 현황</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">근로형태</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">총 구성원수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-7</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearHeadcount[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($thisYearHeadcountAvg ?? 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">정규직</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 401</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearOfficeHeadcount[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($thisYearOfficeHeadcountAvg ?? 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">기간제 근로자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['term_worker'][$i] ?? 0) ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['term_worker']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">기간의 정함이 없는 근로자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                             <?php echo number_format($thisYearContractHeadcount[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($thisYearContractHeadcountAvg ?? 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">도급직</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="12">GRI 405</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['top_official'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['top_official']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['top_official_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['top_official_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php 
                                                                                            $total_monthly = $monthlyData['top_official'][$i] ?? 0;
                                                                                            $woman_monthly = $monthlyData['top_official_woman'][$i] ?? 0;
                                                                                            
                                                                                            if ($total_monthly > 0) {
                                                                                                $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                                                echo number_format($ratio_monthly, 1); 
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        (<?php 
                                                                                        $total_yearly = $yearlyTotals['top_official'] ?? 0;
                                                                                        $woman_yearly = $yearlyTotals['top_official_woman'] ?? 0;
                                                                                        
                                                                                        if ($total_yearly > 0) {
                                                                                            $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                                            echo number_format($ratio_yearly, 1);
                                                                                        } else {
                                                                                            echo 0;
                                                                                        }
                                                                                        ?>)
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['middle_official'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['middle_official']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['middle_official_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['middle_official_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php 
                                                                                            $total_monthly = $monthlyData['middle_official'][$i] ?? 0;
                                                                                            $woman_monthly = $monthlyData['middle_official_woman'][$i] ?? 0;
                                                                                            
                                                                                            if ($total_monthly > 0) {
                                                                                                $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                                                echo number_format($ratio_monthly, 1); 
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        (<?php 
                                                                                        $total_yearly = $yearlyTotals['middle_official'] ?? 0;
                                                                                        $woman_yearly = $yearlyTotals['middle_official_woman'] ?? 0;
                                                                                        
                                                                                        if ($total_yearly > 0) {
                                                                                            $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                                            echo number_format($ratio_yearly, 1);
                                                                                        } else {
                                                                                            echo 0;
                                                                                        }
                                                                                        ?>)
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php 
                                                                                    $thisYearGeneralMaleSum = 0;
                                                                                    $thisYearGeneralFemaleSum = 0;
                                                                                    $monthsWithData = 0;
                                                                                    $monthlyMaleGeneral = [];
                                                                                    $monthlyFemaleGeneral = [];

                                                                                    for ($i = 1; $i <= 12; $i++) {
                                                                                        $male_general = 0;
                                                                                        $female_general = 0;
                                                                                        if (isset($thisYearOfficeHeadcount[$i])) {
                                                                                            $male_general = ($thisYearOfficeHeadcount[$i] - $thisYearOfficeWomenHeadcount[$i]) - ($monthlyData['top_official'][$i] ?? 0) - ($monthlyData['middle_official'][$i] ?? 0);
                                                                                            $female_general = $thisYearOfficeWomenHeadcount[$i] - ($monthlyData['top_official_woman'][$i] ?? 0) - ($monthlyData['middle_official_woman'][$i] ?? 0);
                                                                                            
                                                                                            if (($thisYearOfficeHeadcount[$i] ?? 0) > 0 || ($thisYearContractHeadcount[$i] ?? 0) > 0) { // Consider month if there is any data
                                                                                                $thisYearGeneralMaleSum += $male_general;
                                                                                                $thisYearGeneralFemaleSum += $female_general;
                                                                                                $monthsWithData++;
                                                                                            }
                                                                                        }
                                                                                        $monthlyMaleGeneral[$i] = $male_general;
                                                                                        $monthlyFemaleGeneral[$i] = $female_general;
                                                                                    }
                                                                                    
                                                                                    for ($i = 1; $i <= 12; $i++): 
                                                                                    ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyMaleGeneral[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($monthsWithData > 0) ? $thisYearGeneralMaleSum / $monthsWithData : 0, 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyFemaleGeneral[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($monthsWithData > 0) ? $thisYearGeneralFemaleSum / $monthsWithData : 0, 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php
                                                                                            $total_general = $monthlyMaleGeneral[$i] + $monthlyFemaleGeneral[$i];
                                                                                            if ($total_general > 0) {
                                                                                                echo number_format(($monthlyFemaleGeneral[$i] * 100) / $total_general, 2);
                                                                                            } else {
                                                                                                echo '0.00';
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php $total_sum = $thisYearGeneralMaleSum + $thisYearGeneralFemaleSum; echo ($total_sum > 0) ? number_format($thisYearGeneralFemaleSum * 100 / $total_sum, 2) : '0.00'; ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">신규입사 및 퇴직</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">신규 입사자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php 
                                                                                    $thisYearJoinSum = 0;
                                                                                    $thisYearResignSum = 0;
                                                                                    for ($i = 1; $i <= 12; $i++) {
                                                                                        $thisYearJoinSum += $thisYearHiringData[$i]['Join1'] ?? 0;
                                                                                        $thisYearResignSum += $thisYearHiringData[$i]['Resign'] ?? 0;
                                                                                    }
                                                                                    for ($i = 1; $i <= 12; $i++): 
                                                                                    ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? number_format($thisYearHiringData[$i]['Join1'] ?? 0) : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($thisYearJoinSum); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">이직/퇴직자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? number_format($thisYearHiringData[$i]['Resign'] ?? 0) : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($thisYearResignSum); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">이직/퇴직율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php
                                                                                    $thisYearPeopleSum = 0;
                                                                                    for ($m = 1; $m <= date('n'); $m++) {
                                                                                        $thisYearPeopleSum += $thisYearHeadcount[$m] ?? 0;
                                                                                    }
                                                                                    $avgHeadcountYTD = (date('n') > 0) ? $thisYearPeopleSum / date('n') : 0;
                                                                                    $turnoverRate = ($avgHeadcountYTD > 0) ? ($thisYearResignSum * 100) / $avgHeadcountYTD : 0;
                                                                                    ?>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($turnoverRate, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($turnoverRate, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">근속 연수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 401</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">년</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($thisYearWorkLengthM ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($thisYearWorkLengthM ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">년</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($thisYearWorkLengthW ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($thisYearWorkLengthW ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">임직원 보수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">GRI 405</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">노동</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합 가입원수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-6</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 402</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합<br>가입비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">노사협의회<br>개최</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 1 ? '1' : ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 2 ? '1' : ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 3 ? '1' : ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 4 ? '1' : ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        <?php
                                                                                            $sum = 0;
                                                                                            if(ceil(date('n')/3) >= 1) { $sum += 1; }
                                                                                            if(ceil(date('n')/3) >= 2) { $sum += 1; }
                                                                                            if(ceil(date('n')/3) >= 3) { $sum += 1; }
                                                                                            if(ceil(date('n')/3) >= 4) { $sum += 1; }
                                                                                            echo $sum;
                                                                                        ?>
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="15">인권</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 고충처리<br>접수 및 처리 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-5-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-26</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                             <?php echo number_format($monthlyData['grievance_count'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($yearlyTotals['grievance_count']); ?></td>                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">4대 법정교육<br> 수료 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">성희롱</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">산업안전보건교육</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">개인정보 보호</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">직장내 장애인 인식</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">직장내 괴롭힘 예방</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">복리후생비</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-2-5</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($Data_Welfare['AM_CR']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($Data_Welfare['AM_CR']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ERP손익계산서</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 대상인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="8">S-노동-추가2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="8">GRI 401</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['childcare_Target_man'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_Target_man']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['childcare_Target_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_Target_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['childcare_user_man'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_user_man']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['childcare_user_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_user_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후 <br>복직 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['childcare_return_man'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_return_man']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['childcare_return_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_return_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후<br> 복직 후<br> 12개월 이상 유지인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['childcare_return_man_year'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_return_man_year']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['childcare_return_woman_year'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_return_woman_year']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">다양성<br>및 포용성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">장애인 근로자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-3-3</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 405</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearHiringData[$i]['Handi'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['Handi']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">국가보훈자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearHiringData[$i]['Bohun'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['Bohun']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                 <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">중졸/고졸</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-노동-추가1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($thisYearHiringData[$i]['School'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['School'], 4); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">산업안전</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">안전점검 실시</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 403</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo date('n') >= $i ? '2' : ''; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        <?php
                                                                                            $sum = 0;
                                                                                            if(date('n') >= 1) $sum += 2;
                                                                                            if(date('n') >= 2) $sum += 2;
                                                                                            if(date('n') >= 3) $sum += 2;
                                                                                            if(date('n') >= 4) $sum += 2;
                                                                                            if(date('n') >= 5) $sum += 2;
                                                                                            if(date('n') >= 6) $sum += 2;
                                                                                            if(date('n') >= 7) $sum += 2;
                                                                                            if(date('n') >= 8) $sum += 2;
                                                                                            if(date('n') >= 9) $sum += 2;
                                                                                            if(date('n') >= 10) $sum += 2;
                                                                                            if(date('n') >= 11) $sum += 2;
                                                                                            if(date('n') >= 12) $sum += 2;
                                                                                            echo $sum;
                                                                                        ?>
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;">글로벌안전공사</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">산업재해율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-4-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['accident_rate'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['accident_rate'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">근로손실재해율(LTIFR)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명/백만시간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['lost_time_accident_rate'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['lost_time_accident_rate'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">안전보건경영시스템<br>(ISO 45001) 적용 사업장 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">개인정보</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보 유출 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 418</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['personal_data_count'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['personal_data_count']); ?>)</td>                                                                                    
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보보호교육<br>수료 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-정보보호-추가1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">지역사회</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">사회공헌(기부) 금액</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-7-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 413</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">백만원</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['donation_amount'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['donation_amount']); ?>)</td>  
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">구성원 봉사활동 참여 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-7-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 1 ? $Data_Clean1['COU'] : ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 2 ? $Data_Clean2['COU'] : ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 3 ? $Data_Clean3['COU'] : ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 4 ? $Data_Clean4['COU'] : ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        <?php
                                                                                            $sum = 0;
                                                                                            $count = 0;
                                                                                            if(ceil(date('n')/3) >= 1) { $sum += $Data_Clean1['COU']; $count++; }
                                                                                            if(ceil(date('n')/3) >= 2) { $sum += $Data_Clean2['COU']; $count++; }
                                                                                            if(ceil(date('n')/3) >= 3) { $sum += $Data_Clean3['COU']; $count++; }
                                                                                            if(ceil(date('n')/3) >= 4) { $sum += $Data_Clean4['COU']; $count++; }
                                                                                            echo $count > 0 ? round($sum/$count, 2) : '';
                                                                                        ?>
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><a href="https://develop.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">참여인원 바로가기</a></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>   
                                                                <div class="chart tab-pane" id="esg_g" style="position: relative;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리현황</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">단위</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">12월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">비고</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">자동화</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">이사회</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 개최</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-9</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">회</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 내 ESG 안건 심의</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-1-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-12</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 참석률</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-2-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-9</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">준법</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">환경 법규<br>위반/환경사고 발생 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-8-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 2-27</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['environmental_violation'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['environmental_violation']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">사회 법/규제<br>위반 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-9-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['social_violation'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['social_violation']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">지배구조<br>법/규제 위반 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-6-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['governance_violation'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['governance_violation']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">법규<br>위반/환경사고로 인한 벌금액</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-윤리경영-추가1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['statutory_penalty'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['statutory_penalty']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">윤리</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">윤리/준법 신고 및 처리 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-4-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-25</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($monthlyData['ethics_rate'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['ethics_rate']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 윤리 교육 수료 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo $Data_Edu['COU']?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo $Data_Edu['COU']?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><a href="https://fms.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">수료인원 바로가기</a></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                            </body>
                                                                        </table> 
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

                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample62" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample62">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">DATA SHEET (<?php echo $previousYear; ?>년)</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#esg_e_last" data-toggle="tab">환경</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#esg_s_last" data-toggle="tab">사회</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#esg_g_last" data-toggle="tab">지배구조</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse" id="collapseCardExample62">
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="esg_e_last"  style="position: relative;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리대상</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">단위</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">12월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">비고</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">자동화</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3" colspan="2">에너지</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">보유 차량 휘발유 소비량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">E-4-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 302</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">L</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($oneYearAgomonthlyOilSum['휘발유'][$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($oneYearAgomonthlyOilSumTotal['휘발유']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>     
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">보유 차량 경유 소비량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">L</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($oneYearAgomonthlyOilSum['경유'][$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($oneYearAgomonthlyOilSumTotal['경유']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">사업장 내 전력 소비량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">KWH</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearElectricityUsageData[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($lastYearElectricityUsageData[0]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3" colspan="2">온실가스</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 휘발유</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">E-3-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 305</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($oneYearAgomonthlyOilCO2['휘발유'][$i], 2); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?> 
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($oneYearAgomonthlyOilCO2Total['휘발유'], 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>     
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 경유</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($oneYearAgomonthlyOilCO2['경유'][$i], 2); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($oneYearAgomonthlyOilCO2Total['경유'], 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 전기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearElectricityCO2[$i], 2); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($lastYearElectricityCO2Sum, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr> 
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">용수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">용수 사용량(상하수)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-5-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 303</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">㎥</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearWaterIwinUsageData[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?> 
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($lastYearWaterIwinUsageData[0] ?? 0); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2" rowspan="3">페기물</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">페기물 배출량(일반)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">E-6-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 306</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">kg</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearTrash[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?> 
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($lastYearTrashSum); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">폐기물 배출량(지정/유해)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">kg</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">폐기물 재활용/재사용량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-6-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2" rowspan="4">오염물질</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">Nox(질소산화물)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">E-7-1, E-7-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 303</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">Sox(황산화물)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">VOCs(휘발성 유기화합물)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">분진 배출량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">환경경영시스템</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ISO 14001 적용 사업장 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12">100</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">100</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>   
                                                                <div class="chart tab-pane" id="esg_s_last" style="position: relative;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리현황</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">단위</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">12월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">비고</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">자동화</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="18">임직원 현황</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">근로형태</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">총 구성원수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-7</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearHeadcount[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearHeadcountAvg ?? 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">정규직</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 401</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearOfficeHeadcount[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearOfficeHeadcountAvg ?? 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">기간제 근로자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['term_worker'][$i] ?? 0) ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['term_worker']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">기간의 정함이 없는 근로자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                             <?php echo number_format($lastYearContractHeadcount[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearContractHeadcountAvg ?? 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">도급직</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="12">GRI 405</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['top_official'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['top_official']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['top_official_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['top_official_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php 
                                                                                            $total_monthly = $lastYearMonthlyData['top_official'][$i] ?? 0;
                                                                                            $woman_monthly = $lastYearMonthlyData['top_official_woman'][$i] ?? 0;
                                                                                            
                                                                                            if ($total_monthly > 0) {
                                                                                                $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                                                echo number_format($ratio_monthly, 1); 
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        (<?php 
                                                                                        $total_yearly = $lastYearYearlyTotals['top_official'] ?? 0;
                                                                                        $woman_yearly = $lastYearYearlyTotals['top_official_woman'] ?? 0;
                                                                                        
                                                                                        if ($total_yearly > 0) {
                                                                                            $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                                            echo number_format($ratio_yearly, 1);
                                                                                        } else {
                                                                                            echo 0;
                                                                                        }
                                                                                        ?>)
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['middle_official'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['middle_official']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['middle_official_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['middle_official_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php 
                                                                                            $total_monthly = $lastYearMonthlyData['middle_official'][$i] ?? 0;
                                                                                            $woman_monthly = $lastYearMonthlyData['middle_official_woman'][$i] ?? 0;
                                                                                            
                                                                                            if ($total_monthly > 0) {
                                                                                                $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                                                echo number_format($ratio_monthly, 1); 
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        (<?php 
                                                                                        $total_yearly = $lastYearYearlyTotals['middle_official'] ?? 0;
                                                                                        $woman_yearly = $lastYearYearlyTotals['middle_official_woman'] ?? 0;
                                                                                        
                                                                                        if ($total_yearly > 0) {
                                                                                            $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                                            echo number_format($ratio_yearly, 1);
                                                                                        } else {
                                                                                            echo 0;
                                                                                        }
                                                                                        ?>)
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php 
                                                                                    $lastYearGeneralMaleSum = 0;
                                                                                    $lastYearGeneralFemaleSum = 0;
                                                                                    $lastYearMonthsWithData = 0;
                                                                                    $lastYearMonthlyMaleGeneral = [];
                                                                                    $lastYearMonthlyFemaleGeneral = [];

                                                                                    for ($i = 1; $i <= 12; $i++) {
                                                                                        $male_general = 0;
                                                                                        $female_general = 0;
                                                                                        if (isset($lastYearOfficeHeadcount[$i])) {
                                                                                            $male_general = ($lastYearOfficeHeadcount[$i] - $lastYearOfficeWomenHeadcount[$i]) - ($lastYearMonthlyData['top_official'][$i] ?? 0) - ($lastYearMonthlyData['middle_official'][$i] ?? 0);
                                                                                            $female_general = $lastYearOfficeWomenHeadcount[$i] - ($lastYearMonthlyData['top_official_woman'][$i] ?? 0) - ($lastYearMonthlyData['middle_official_woman'][$i] ?? 0);
                                                                                            
                                                                                            if (($lastYearOfficeHeadcount[$i] ?? 0) > 0 || ($lastYearContractHeadcount[$i] ?? 0) > 0) { // Consider month if there is any data
                                                                                                $lastYearGeneralMaleSum += $male_general;
                                                                                                $lastYearGeneralFemaleSum += $female_general;
                                                                                                $lastYearMonthsWithData++;
                                                                                            }
                                                                                        }
                                                                                        $lastYearMonthlyMaleGeneral[$i] = $male_general;
                                                                                        $lastYearMonthlyFemaleGeneral[$i] = $female_general;
                                                                                    }
                                                                                    
                                                                                    for ($i = 1; $i <= 12; $i++): 
                                                                                    ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyMaleGeneral[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($lastYearMonthsWithData > 0) ? $lastYearGeneralMaleSum / $lastYearMonthsWithData : 0, 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyFemaleGeneral[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($lastYearMonthsWithData > 0) ? $lastYearGeneralFemaleSum / $lastYearMonthsWithData : 0, 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php
                                                                                            $total_general = $lastYearMonthlyMaleGeneral[$i] + $lastYearMonthlyFemaleGeneral[$i];
                                                                                            if ($total_general > 0) {
                                                                                                echo number_format(($lastYearMonthlyFemaleGeneral[$i] * 100) / $total_general, 2);
                                                                                            } else {
                                                                                                echo '0.00';
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php $total_sum = $lastYearGeneralMaleSum + $lastYearGeneralFemaleSum; echo ($total_sum > 0) ? number_format($lastYearGeneralFemaleSum * 100 / $total_sum, 2) : '0.00'; ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">신규입사 및 퇴직</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">신규 입사자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php 
                                                                                    $lastYearJoinSum = 0;
                                                                                    $lastYearResignSum = 0;
                                                                                    for ($i = 1; $i <= 12; $i++) {
                                                                                        $lastYearJoinSum += $lastYearHiringData[$i]['Join1'] ?? 0;
                                                                                        $lastYearResignSum += $lastYearHiringData[$i]['Resign'] ?? 0;
                                                                                    }
                                                                                    for ($i = 1; $i <= 12; $i++): 
                                                                                    ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearHiringData[$i]['Join1'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearJoinSum); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">이직/퇴직자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearHiringData[$i]['Resign'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearResignSum); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">이직/퇴직율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php
                                                                                    $lastYearPeopleSum = 0;
                                                                                    for ($m = 1; $m <= 12; $m++) {
                                                                                        $lastYearPeopleSum += $lastYearHeadcount[$m] ?? 0;
                                                                                    }
                                                                                    $avgHeadcountYTD = ($lastYearPeopleSum > 0) ? $lastYearPeopleSum / 12 : 0;
                                                                                    $turnoverRate = ($avgHeadcountYTD > 0) ? ($lastYearResignSum * 100) / $avgHeadcountYTD : 0;
                                                                                    ?>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($turnoverRate, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($turnoverRate, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">근속 연수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 401</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">년</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearWorkLengthM ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearWorkLengthM ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">년</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearWorkLengthW ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearWorkLengthW ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">임직원 보수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">GRI 405</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">노동</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합 가입원수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-6</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 402</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합<br>가입비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">노사협의회<br>개최</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">4</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="15">인권</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 고충처리<br>접수 및 처리 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-5-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-26</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                             <?php echo number_format($lastYearMonthlyData['grievance_count'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearYearlyTotals['grievance_count']); ?></td>                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">4대 법정교육<br> 수료 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">성희롱</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">산업안전보건교육</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">개인정보 보호</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">직장내 장애인 인식</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">직장내 괴롭힘 예방</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">복리후생비</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-2-5</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearData_Welfare['AM_CR']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearData_Welfare['AM_CR']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ERP손익계산서</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 대상인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="8">S-노동-추가2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="8">GRI 401</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['childcare_Target_man'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_Target_man']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['childcare_Target_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_Target_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['childcare_user_man'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_user_man']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['childcare_user_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_user_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후 <br>복직 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['childcare_return_man'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_return_man']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['childcare_return_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_return_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후<br> 복직 후<br> 12개월 이상 유지인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['childcare_return_man_year'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_return_man_year']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['childcare_return_woman_year'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_return_woman_year']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">다양성<br>및 포용성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">장애인 근로자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-3-3</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 405</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearHiringData[$i]['Handi'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['Handi']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">국가보훈자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearHiringData[$i]['Bohun'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['Bohun']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                 <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">중졸/고졸</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-노동-추가1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearHiringData[$i]['School'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['School'], 4); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">산업안전</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">안전점검 실시</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 403</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">2</td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">24</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">글로벌안전공사</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">산업재해율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-4-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['accident_rate'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['accident_rate'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">근로손실재해율(LTIFR)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명/백만시간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['lost_time_accident_rate'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['lost_time_accident_rate'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">안전보건경영시스템<br>(ISO 45001) 적용 사업장 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">개인정보</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보 유출 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 418</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['personal_data_count'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['personal_data_count']); ?>)</td>                                                                                    
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보보호교육<br>수료 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-정보보호-추가1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">지역사회</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">사회공헌(기부) 금액</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-7-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 413</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">백만원</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['donation_amount'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['donation_amount']); ?>)</td>  
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">구성원 봉사활동 참여 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-7-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean1Minus1YY['COU'] ?? ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean2Minus1YY['COU'] ?? ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean3Minus1YY['COU'] ?? ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean4Minus1YY['COU'] ?? ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        <?php
                                                                                            $sum = 0;
                                                                                            $count = 0;
                                                                                            if(isset($Data_Clean1Minus1YY['COU'])) { $sum += $Data_Clean1Minus1YY['COU']; $count++; }
                                                                                            if(isset($Data_Clean2Minus1YY['COU'])) { $sum += $Data_Clean2Minus1YY['COU']; $count++; }
                                                                                            if(isset($Data_Clean3Minus1YY['COU'])) { $sum += $Data_Clean3Minus1YY['COU']; $count++; }
                                                                                            if(isset($Data_Clean4Minus1YY['COU'])) { $sum += $Data_Clean4Minus1YY['COU']; $count++; }
                                                                                            echo $count > 0 ? round($sum/$count, 2) : '';
                                                                                        ?>
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><a href="https://develop.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">참여인원 바로가기</a></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>   
                                                                <div class="chart tab-pane" id="esg_g_last" style="position: relative;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리현황</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">단위</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">12월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">비고</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">자동화</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">이사회</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 개최</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-9</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">회</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 내 ESG 안건 심의</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-1-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-12</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 참석률</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-2-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-9</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">준법</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">환경 법규<br>위반/환경사고 발생 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-8-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 2-27</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['environmental_violation'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['environmental_violation']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">사회 법/규제<br>위반 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-9-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['social_violation'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['social_violation']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">지배구조<br>법/규제 위반 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-6-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['governance_violation'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['governance_violation']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">법규<br>위반/환경사고로 인한 벌금액</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-윤리경영-추가1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['statutory_penalty'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['statutory_penalty']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">윤리</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">윤리/준법 신고 및 처리 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-4-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-25</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($lastYearMonthlyData['ethics_rate'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['ethics_rate']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 윤리 교육 수료 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo $Data_Edu2['COU']?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo $Data_Edu2['COU']?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><a href="https://fms.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">수료인원 바로가기</a></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                            </body>
                                                                        </table> 
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
                                                                                            
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample63" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample63">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">DATA SHEET (<?php echo $twoYearsAgo; ?>년)</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#esg_e_two_years_ago" data-toggle="tab">환경</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#esg_s_two_years_ago" data-toggle="tab">사회</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#esg_g_two_years_ago" data-toggle="tab">지배구조</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse" id="collapseCardExample63">
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="esg_e_two_years_ago"  style="position: relative;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리대상</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">단위</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">12월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">비고</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">자동화</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3" colspan="2">에너지</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">보유 차량 휘발유 소비량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">E-4-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 302</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">L</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgomonthlyOilSum['휘발유'][$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgomonthlyOilSumTotal['휘발유']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>     
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">보유 차량 경유 소비량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">L</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgomonthlyOilSum['경유'][$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgomonthlyOilSumTotal['경유']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">사업장 내 전력 소비량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">KWH</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoElectricityUsageData[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgoElectricityUsageData[0]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3" colspan="2">온실가스</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 휘발유</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">E-3-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 305</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgomonthlyOilCO2['휘발유'][$i], 2); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?> 
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgomonthlyOilCO2Total['휘발유'], 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>     
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 경유</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgomonthlyOilCO2['경유'][$i], 2); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgomonthlyOilCO2Total['경유'], 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 전기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoElectricityCO2[$i], 2); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgoElectricityCO2Sum, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr> 
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">용수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">용수 사용량(상하수)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-5-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 303</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">㎥</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoWaterIwinUsageData[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?> 
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgoWaterIwinUsageData[0] ?? 0); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2" rowspan="3">페기물</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">페기물 배출량(일반)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">E-6-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 306</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">kg</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoTrash[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?> 
                                                                                    <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgoTrashSum); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">폐기물 배출량(지정/유해)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">kg</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">폐기물 재활용/재사용량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-6-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2" rowspan="4">오염물질</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">Nox(질소산화물)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">E-7-1, E-7-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 303</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">Sox(황산화물)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">VOCs(휘발성 유기화합물)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">분진 배출량</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">환경경영시스템</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ISO 14001 적용 사업장 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12">100</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">100</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>   
                                                                <div class="chart tab-pane" id="esg_s_two_years_ago" style="position: relative;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리현황</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">단위</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">12월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">비고</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">자동화</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="18">임직원 현황</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">근로형태</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">총 구성원수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-7</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoHeadcount[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoHeadcountAvg ?? 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">정규직</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 401</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoOfficeHeadcount[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoOfficeHeadcountAvg ?? 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">기간제 근로자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['term_worker'][$i] ?? 0) ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['term_worker']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">기간의 정함이 없는 근로자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                                <?php echo number_format($twoYearsAgoContractHeadcount[$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoContractHeadcountAvg ?? 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">도급직</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="12">GRI 405</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['top_official'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['top_official']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['top_official_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['top_official_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php 
                                                                                            $total_monthly = $twoYearsAgoMonthlyData['top_official'][$i] ?? 0;
                                                                                            $woman_monthly = $twoYearsAgoMonthlyData['top_official_woman'][$i] ?? 0;
                                                                                            
                                                                                            if ($total_monthly > 0) {
                                                                                                $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                                                echo number_format($ratio_monthly, 1); 
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        (<?php 
                                                                                        $total_yearly = $twoYearsAgoYearlyTotals['top_official'] ?? 0;
                                                                                        $woman_yearly = $twoYearsAgoYearlyTotals['top_official_woman'] ?? 0;
                                                                                        
                                                                                        if ($total_yearly > 0) {
                                                                                            $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                                            echo number_format($ratio_yearly, 1);
                                                                                        } else {
                                                                                            echo 0;
                                                                                        }
                                                                                        ?>)
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['middle_official'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['middle_official']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['middle_official_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['middle_official_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php 
                                                                                            $total_monthly = $twoYearsAgoMonthlyData['middle_official'][$i] ?? 0;
                                                                                            $woman_monthly = $twoYearsAgoMonthlyData['middle_official_woman'][$i] ?? 0;
                                                                                            
                                                                                            if ($total_monthly > 0) {
                                                                                                $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                                                echo number_format($ratio_monthly, 1); 
                                                                                            } else {
                                                                                                echo 0;
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        (<?php 
                                                                                        $total_yearly = $twoYearsAgoYearlyTotals['middle_official'] ?? 0;
                                                                                        $woman_yearly = $twoYearsAgoYearlyTotals['middle_official_woman'] ?? 0;
                                                                                        
                                                                                        if ($total_yearly > 0) {
                                                                                            $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                                            echo number_format($ratio_yearly, 1);
                                                                                        } else {
                                                                                            echo 0;
                                                                                        }
                                                                                        ?>)
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php 
                                                                                    $twoYearsAgoGeneralMaleSum = 0;
                                                                                    $twoYearsAgoGeneralFemaleSum = 0;
                                                                                    $twoYearsAgoMonthsWithData = 0;
                                                                                    $twoYearsAgoMonthlyMaleGeneral = [];
                                                                                    $twoYearsAgoMonthlyFemaleGeneral = [];

                                                                                    for ($i = 1; $i <= 12; $i++) {
                                                                                        $male_general = 0;
                                                                                        $female_general = 0;
                                                                                        if (isset($twoYearsAgoOfficeHeadcount[$i])) {
                                                                                            $male_general = ($twoYearsAgoOfficeHeadcount[$i] - $twoYearsAgoOfficeWomenHeadcount[$i]) - ($twoYearsAgoMonthlyData['top_official'][$i] ?? 0) - ($twoYearsAgoMonthlyData['middle_official'][$i] ?? 0);
                                                                                            $female_general = $twoYearsAgoOfficeWomenHeadcount[$i] - ($twoYearsAgoMonthlyData['top_official_woman'][$i] ?? 0) - ($twoYearsAgoMonthlyData['middle_official_woman'][$i] ?? 0);
                                                                                            
                                                                                            if (($twoYearsAgoOfficeHeadcount[$i] ?? 0) > 0 || ($twoYearsAgoContractHeadcount[$i] ?? 0) > 0) { // Consider month if there is any data
                                                                                                $twoYearsAgoGeneralMaleSum += $male_general;
                                                                                                $twoYearsAgoGeneralFemaleSum += $female_general;
                                                                                                $twoYearsAgoMonthsWithData++;
                                                                                            }
                                                                                        }
                                                                                        $twoYearsAgoMonthlyMaleGeneral[$i] = $male_general;
                                                                                        $twoYearsAgoMonthlyFemaleGeneral[$i] = $female_general;
                                                                                    }
                                                                                    
                                                                                    for ($i = 1; $i <= 12; $i++): 
                                                                                    ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyMaleGeneral[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($twoYearsAgoMonthsWithData > 0) ? $twoYearsAgoGeneralMaleSum / $twoYearsAgoMonthsWithData : 0, 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성직원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyFemaleGeneral[$i]); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($twoYearsAgoMonthsWithData > 0) ? $twoYearsAgoGeneralFemaleSum / $twoYearsAgoMonthsWithData : 0, 0); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php
                                                                                            $total_general = $twoYearsAgoMonthlyMaleGeneral[$i] + $twoYearsAgoMonthlyFemaleGeneral[$i];
                                                                                            if ($total_general > 0) {
                                                                                                echo number_format(($twoYearsAgoMonthlyFemaleGeneral[$i] * 100) / $total_general, 2);
                                                                                            } else {
                                                                                                echo '0.00';
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php $total_sum = $twoYearsAgoGeneralMaleSum + $twoYearsAgoGeneralFemaleSum; echo ($total_sum > 0) ? number_format($twoYearsAgoGeneralFemaleSum * 100 / $total_sum, 2) : '0.00'; ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">신규입사 및 퇴직</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">신규 입사자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php 
                                                                                    $twoYearsAgoJoinSum = 0;
                                                                                    $twoYearsAgoResignSum = 0;
                                                                                    for ($i = 1; $i <= 12; $i++) {
                                                                                        $twoYearsAgoJoinSum += $twoYearsAgoHiringData[$i]['Join1'] ?? 0;
                                                                                        $twoYearsAgoResignSum += $twoYearsAgoHiringData[$i]['Resign'] ?? 0;
                                                                                    }
                                                                                    for ($i = 1; $i <= 12; $i++): 
                                                                                    ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoHiringData[$i]['Join1'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoJoinSum); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">이직/퇴직자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoHiringData[$i]['Resign'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoResignSum); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">이직/퇴직율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php
                                                                                    $twoYearsAgoPeopleSum = 0;
                                                                                    for ($m = 1; $m <= 12; $m++) {
                                                                                        $twoYearsAgoPeopleSum += $twoYearsAgoHeadcount[$m] ?? 0;
                                                                                    }
                                                                                    $avgHeadcountYTD = ($twoYearsAgoPeopleSum > 0) ? $twoYearsAgoPeopleSum / 12 : 0;
                                                                                    $turnoverRate = ($avgHeadcountYTD > 0) ? ($twoYearsAgoResignSum * 100) / $avgHeadcountYTD : 0;
                                                                                    ?>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($turnoverRate, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($turnoverRate, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">근속 연수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 401</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">년</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoWorkLengthM ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoWorkLengthM ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">년</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoWorkLengthW ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoWorkLengthW ?? 0, 2); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">임직원 보수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="9">GRI 405</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">△</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">노동</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합 가입원수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-6</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 402</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합<br>가입비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo '-'; ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">노사협의회<br>개최</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">4</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="15">인권</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 고충처리<br>접수 및 처리 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-5-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-26</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                                <?php echo number_format($twoYearsAgoMonthlyData['grievance_count'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoYearlyTotals['grievance_count']); ?></td>                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">4대 법정교육<br> 수료 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">성희롱</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="5">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">산업안전보건교육</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">개인정보 보호</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">직장내 장애인 인식</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">직장내 괴롭힘 예방</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">복리후생비</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-2-5</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoData_Welfare['AM_CR']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoData_Welfare['AM_CR']); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ERP손익계산서</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 대상인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="8">S-노동-추가2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="8">GRI 401</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['childcare_Target_man'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_Target_man']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['childcare_Target_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_Target_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['childcare_user_man'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_user_man']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['childcare_user_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_user_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후 <br>복직 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['childcare_return_man'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_return_man']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['childcare_return_woman'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_return_woman']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후<br> 복직 후<br> 12개월 이상 유지인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['childcare_return_man_year'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_return_man_year']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['childcare_return_woman_year'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_return_woman_year']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">다양성<br>및 포용성</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">장애인 근로자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-3-3</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 405</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoHiringData[$i]['Handi'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['Handi']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">국가보훈자</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoHiringData[$i]['Bohun'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['Bohun']); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                    <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">중졸/고졸</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-노동-추가1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoHiringData[$i]['School'] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['School'], 4); ?>)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">산업안전</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">안전점검 실시</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 403</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">2</td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">24</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">글로벌안전공사</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">산업재해율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-4-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['accident_rate'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['accident_rate'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">근로손실재해율(LTIFR)</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명/백만시간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['lost_time_accident_rate'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['lost_time_accident_rate'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">안전보건경영시스템<br>(ISO 45001) 적용 사업장 비율</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">개인정보</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보 유출 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 418</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['personal_data_count'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['personal_data_count']); ?>)</td>                                                                                    
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보보호교육<br>수료 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-정보보호-추가1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">지역사회</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">사회공헌(기부) 금액</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-7-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 413</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">백만원</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['donation_amount'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['donation_amount']); ?>)</td>  
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">구성원 봉사활동 참여 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-7-2</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean1Minus2YY['COU'] ?? ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean2Minus2YY['COU'] ?? ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean3Minus2YY['COU'] ?? ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean4Minus2YY['COU'] ?? ''; ?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                                        <?php
                                                                                            $sum = 0;
                                                                                            $count = 0;
                                                                                            if(isset($Data_Clean1Minus2YY['COU'])) { $sum += $Data_Clean1Minus2YY['COU']; $count++; }
                                                                                            if(isset($Data_Clean2Minus2YY['COU'])) { $sum += $Data_Clean2Minus2YY['COU']; $count++; }
                                                                                            if(isset($Data_Clean3Minus2YY['COU'])) { $sum += $Data_Clean3Minus2YY['COU']; $count++; }
                                                                                            if(isset($Data_Clean4Minus2YY['COU'])) { $sum += $Data_Clean4Minus2YY['COU']; $count++; }
                                                                                            echo $count > 0 ? round($sum/$count, 2) : '';
                                                                                        ?>
                                                                                    </td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><a href="https://develop.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">참여인원 바로가기</a></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>   
                                                                <div class="chart tab-pane" id="esg_g_two_years_ago" style="position: relative;">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered text-nowrap">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리현황</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">단위</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">12월</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">비고</th>
                                                                                    <th style="text-align: center; vertical-align: middle;">자동화</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="3">이사회</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 개최</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-9</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">회</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 내 ESG 안건 심의</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-1-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-12</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 참석률</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-2-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-9</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">분기</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">%</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">준법</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">환경 법규<br>위반/환경사고 발생 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">E-8-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 2-27</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['environmental_violation'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['environmental_violation']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">사회 법/규제<br>위반 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">S-9-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['social_violation'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['social_violation']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">지배구조<br>법/규제 위반 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-6-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['governance_violation'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['governance_violation']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">법규<br>위반/환경사고로 인한 벌금액</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-윤리경영-추가1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">원</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['statutory_penalty'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['statutory_penalty']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" rowspan="2">윤리</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">윤리/준법 신고 및 처리 건수</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">G-4-1</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 2-25</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">건</td>
                                                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                        <td style="text-align: center; vertical-align: middle;">
                                                                                            <?php echo number_format($twoYearsAgoMonthlyData['ethics_rate'][$i] ?? 0); ?>
                                                                                        </td>
                                                                                    <?php endfor; ?>
                                                                                    <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['ethics_rate']); ?>)</td> 
                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">x</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 윤리 교육 수료 인원</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">-</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                                    <td style="text-align: center; vertical-align: middle;">명</td>
                                                                                    <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo $Data_Edu3['COU']?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><?php echo $Data_Edu3['COU']?></td>
                                                                                    <td style="text-align: center; vertical-align: middle;"><a href="https://fms.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">수료인원 바로가기</a></td>
                                                                                    <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                                </tr>
                                                                            </body>
                                                                        </table> 
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

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>

    <!-- Page specific script -->

    <script>  
        const thisYearOilCO2Data = <?php echo json_encode($thisYearOilCO2Data); ?>;
        const oneYearAgoOilCO2Data = <?php echo json_encode($oneYearAgoOilCO2Data); ?>;
        const twoYearsAgoOilCO2Data = <?php echo json_encode($twoYearsAgoOilCO2Data); ?>;
        const threeYearsAgoOilCO2Data = <?php echo json_encode($threeYearsAgoOilCO2Data); ?>;
        const targetOilCO2Data = <?php echo json_encode($targetOilCO2Data); ?>;

        //합계★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas5 = $('#barChart5').get(0).getContext('2d')

            var barChartData5 = {
                labels  : ['합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
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
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_ThisYear); ?>
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
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_LastYear); ?>
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
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_TwoYearsAgo); ?>
                    },
                    {
                        label               : '<?php echo $Minus3YY?>년',
                        backgroundColor     : 'rgba(155, 162, 173, 1)',
                        borderColor         : 'rgba(155, 162, 173, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(155, 162, 173, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',           
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_ThreeYearsAgo); ?>
                    },
                    {
                        label               : '<?php echo $YY; ?>년 목표 (전년대비 3%절감)',
                        type                : 'line', // 선형 그래프로 표시
                        borderColor         : 'rgba(255, 99, 132, 1)', // 선 색상
                        borderWidth         : 2, // 선 두께
                        fill                : false, // 배경 채우기 없음
                        // 👇 데이터 삽입
                        data                : <?php echo json_encode($totalCO2Data_Target); ?>
                    }
                ]
            }

            barChartData5.datasets.reverse();  

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                console.log(chart)                      

                                // 기본 범례 라벨 생성
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);

                                // 라인 차트를 마지막으로 정렬
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });

                                // 정렬된 라벨 배열 반환
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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

        //이동연소★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas1 = $('#barChart1').get(0).getContext('2d')

            var barChartData1 = {
                labels  : ['합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
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
                        data                : thisYearOilCO2Data
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
                        data                : oneYearAgoOilCO2Data
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
                        data                : twoYearsAgoOilCO2Data
                    },
                    {
                        label               : '<?php echo $Minus3YY?>년',
                        backgroundColor     : 'rgb(155, 162, 173, 1)',
                        borderColor         : 'rgb(155, 162, 173, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(155, 162, 173, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',          
                        data                : threeYearsAgoOilCO2Data
                    },
                    {
                        label               : '<?php echo $YY; ?>년 목표 (전년대비 3%절감)',
                        type                : 'line', // 선형 그래프로 표시
                        borderColor         : 'rgba(255, 99, 132, 1)', // 선 색상
                        borderWidth         : 2, // 선 두께
                        fill                : false, // 배경 채우기 없음
                        data                : targetOilCO2Data
                    }
                ]
            }

            barChartData1.datasets.reverse();   

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                console.log(chart)                      

                                // 기본 범례 라벨 생성
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);

                                // 라인 차트를 마지막으로 정렬
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });

                                // 정렬된 라벨 배열 반환
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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

            new Chart(barChartCanvas1, {
                type: 'bar',
                data: barChartData1,
                options: barChartOptions
            }) 
        })

        //가스★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas2 = $('#barChart2').get(0).getContext('2d')

            var barChartData2 = {
                labels  : ['합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    {
                        label               : '<?php echo $currentYear?>년',
                        backgroundColor     : 'rgba(232,85,70,1)',
                        borderColor         : 'rgba(232,85,70,1)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(232,85,70,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(232,85,70,1)',
                        data                : [<?php echo $thisYearGasCO2Sum; ?>, <?php echo implode(', ', $thisYearGasCO2); ?>]
                    },
                    {
                        label               : '<?php echo $previousYear?>년',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : [<?php echo $lastYearGasCO2Sum; ?>, <?php echo implode(', ', $lastYearGasCO2); ?>]
                    },
                    {
                        label               : '<?php echo $twoYearsAgo?>년',
                        backgroundColor     : 'rgba(175, 183, 197, 1)',
                        borderColor         : 'rgba(175, 183, 197, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(175, 183, 197, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',          
                        data                : [<?php echo $twoYearsAgoGasCO2Sum; ?>, <?php echo implode(', ', $twoYearsAgoGasCO2); ?>]
                    },
                    {
                        label               : '<?php echo $threeYearsAgo?>년',
                        backgroundColor     : 'rgba(155, 162, 173, 1)',
                        borderColor         : 'rgba(155, 162, 173, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(155, 162, 173, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',          
                        data                : [<?php echo $threeYearsAgoGasCO2Sum; ?>, <?php echo implode(', ', $threeYearsAgoGasCO2); ?>]
                    },
                    {
                        label               : '<?php echo $currentYear; ?>년 목표 (전년대비 3%절감)',
                        type                : 'line', // 선형 그래프로 표시
                        borderColor         : 'rgba(255, 99, 132, 1)', // 선 색상
                        borderWidth         : 2, // 선 두께
                        fill                : false, // 배경 채우기 없음
                        data                : [<?php echo implode(', ', $lastYearGasCO2Goal); ?>]
                    }
                ]
            }

            barChartData2.datasets.reverse();                     


            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                console.log(chart)                      

                                // 기본 범례 라벨 생성
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);

                                // 라인 차트를 마지막으로 정렬
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });

                                // 정렬된 라벨 배열 반환
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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

            new Chart(barChartCanvas2, {
            type: 'bar',
            data: barChartData2,
            options: barChartOptions
            }) 
        })

        //전기★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas4 = $('#barChart4').get(0).getContext('2d')

            var barChartData4 = {
                labels  : ['합계','1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    {
                        label               : '<?php echo $currentYear?>년',
                        backgroundColor     : 'rgba(236,194,76,1)',
                        borderColor         : 'rgba(236,194,76,1)',
                        pointRadius         : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(236,194,76,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(236,194,76,1)',
                        data                : [<?php echo $thisYearElectricityCO2Sum; ?>, <?php echo implode(', ', $thisYearElectricityCO2); ?>]
                    },
                    {
                        label               : '<?php echo $previousYear?>년',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',          
                        data                : [<?php echo $lastYearElectricityCO2Sum; ?>, <?php echo implode(', ', $lastYearElectricityCO2); ?>]
                    },
                    {
                    label               : '<?php echo $twoYearsAgo?>년',
                    backgroundColor     : 'rgba(175, 183, 197, 1)',
                    borderColor         : 'rgba(175, 183, 197, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(175, 183, 197, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : [<?php echo $twoYearsAgoElectricityCO2Sum; ?>, <?php echo implode(', ', $twoYearsAgoElectricityCO2); ?>]
                    },
                    {
                    label               : '<?php echo $threeYearsAgo?>년',
                    backgroundColor     : 'rgba(155, 162, 173, 1)',
                    borderColor         : 'rgba(155, 162, 173, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(155, 162, 173, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',          
                    data                : [<?php echo $threeYearsAgoElectricityCO2Sum; ?>, <?php echo implode(', ', $threeYearsAgoElectricityCO2); ?>]
                    },
                    {
                        label           : '<?php echo $currentYear?>년 목표 (전년대비 3%절감)',
                        type            : 'line', // 선형 그래프로 표시
                        borderColor     : 'rgba(255, 99, 132, 1)', // 선 색상
                        borderWidth     : 2, // 선 두께
                        fill            : false, // 배경 채우기 없음
                        data            : [<?php echo implode(', ', $lastYearElectricityCO2Goal); ?>]
                    }
                ]
            }

            barChartData4.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                //표 좌측에서 불러오는 모션 끄기
                animation: {
                    duration: 0
                },
                plugins: {
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                console.log(chart)                      

                                // 기본 범례 라벨 생성
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);

                                // 라인 차트를 마지막으로 정렬
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });

                                // 정렬된 라벨 배열 반환
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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

            new Chart(barChartCanvas4, {
                type: 'bar',
                data: barChartData4,
                options: barChartOptions
            }) 
        })

        //폐기물★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            var barChartCanvas3 = $('#barChart3').get(0).getContext('2d');

            var barChartData3 = {
                labels  : ['합계', '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                datasets: [
                    {
                        label               : '<?php echo $currentYear?>년',
                        backgroundColor     : 'rgba(40, 192, 141, 1)',
                        borderColor         : 'rgba(40, 192, 141, 1)',
                        data                : [<?php echo $thisYearTrashCO2Sum; ?>, <?php echo implode(', ', $thisYearTrashCO2); ?>]
                    },
                    {
                        label               : '<?php echo $previousYear?>년',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        data                : [<?php echo $lastYearTrashCO2Sum; ?>, <?php echo implode(', ', $lastYearTrashCO2); ?>]
                    },
                    {
                        label               : '<?php echo $twoYearsAgo?>년',
                        backgroundColor     : 'rgba(175, 183, 197, 1)',
                        borderColor         : 'rgba(175, 183, 197, 1)',
                        data                : [<?php echo $twoYearsAgoTrashCO2Sum; ?>, <?php echo implode(', ', $twoYearsAgoTrashCO2); ?>]
                    },
                    {
                        label               : '<?php echo $threeYearsAgo?>년',
                        backgroundColor     : 'rgba(155, 162, 173, 1)',
                        borderColor         : 'rgba(155, 162, 173, 1)',
                        data                : [<?php echo $threeYearsAgoTrashCO2Sum; ?>, <?php echo implode(', ', $threeYearsAgoTrashCO2); ?>]
                    },
                    {
                        label               : '<?php echo $currentYear; ?>년 목표 (전년대비 3%절감)',
                        type                : 'line',
                        borderColor         : 'rgba(255, 99, 132, 1)',
                        borderWidth         : 2,
                        fill                : false,
                        data                : [<?php echo implode(', ', $lastYearTrashCO2Goal); ?>]
                    }
                ]
            };
            
            barChartData3.datasets.reverse();

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                animation: {
                    duration: 0
                },
                plugins: {
                    legend: {
                        labels: {      
                            usePointStyle: true,              
                            generateLabels: function (chart) {
                                let labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);
                                labels.sort((a, b) => {
                                    const isALine = chart.data.datasets[a.datasetIndex].type === 'line';
                                    const isBLine = chart.data.datasets[b.datasetIndex].type === 'line';
                                    return isALine - isBLine;
                                });
                                return labels.map(label => ({
                                    ...label,
                                    pointStyle: chart.data.datasets[label.datasetIndex].type === 'line' ? 'line' : 'rect'
                                }));
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 4 } ).format(context.parsed.y);
                                }
                                label += ' tCO2';
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
            };

            new Chart(barChartCanvas3, {
                type: 'bar',
                data: barChartData3,
                options: barChartOptions
            }); 
        })    
    </script>

</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) { mysqli_close($connect4);} 	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>