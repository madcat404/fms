<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.18>
	// Description:	<설비가동률 리뷰>	
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance	
	// =============================================
    include 'measure_total_watt_status.php';   
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">시험실 설비 가동률</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 카드1 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-2">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample1">
                                    <h6 class="m-0 font-weight-bold text-primary">공지</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="collapseCardExample1">
                                    <div class="card-body">
                                        <p>
                                            [목표]<BR>
                                            - 설비 가동시간 측정 자동화<BR><BR>                                                                          
                                            
                                            [가동시간기준]<br>
                                            - 10Hour/Day | 챔버<br>
                                            - 20Hour/Day | Robot, Knee, 시트진동내구, 열충격내구, 항온항습기<br><br>

                                            [히스토리]<br>   
                                            25.1.22)<br>
                                            - 전우준sw 요청에 의해 복구함 (챔버3대에 대해서만 측정 / 전류 기준값 250이상인 경우 동작)<BR>
                                            - 전류가 절대값으로 250인 경우 ON으로 표시(항온항습기)<BR><br>
                                            
                                            [참조]<br>  
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 시험팀<br> 
                                            - WIFI모듈: ESP8266 / 전류센서: SCT013(100A)<br>
                                            - 1분 간격으로 전류 측정<br>
                                            - 실제 가동/비가동시간을 확인하여 설비마다 가동 시 얼마만큼의 전류가 흐르는지 알아야 정확한 가동률 산출이 가능한데 시험일정으로 인하여 이것을 측정할 수 없었음<BR>
                                             > 예시로 선풍기 회전속도 1단과 3단의 소비 전류는 다름, 따라서 설비를 다양하게 조작해보아야 함<BR>
                                            - DB에 기록되는 데이터를 분석하여 주말/야간 이후 전류가 높아지는 부분을 가동이라 가정하고 가동시간을 추출하여 가동률을 계산함<BR>
                                            - 따라서 정확한 가동률이라 보기 어려움<BR><BR>

                                            [제작일]<BR>
                                            - 21.11.18<br><br>  
                                        </p>                                            
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.Card Content - Collapse -->
                            </div>
                             <!-- /.card -->
                        </div>              

                        <!-- 보드 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <!-- 보드1 -->
                        <div class="col-xl-4 col-md-6 mb-2">
                            <div class="card border-left shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #BC6FF1;">(실시간) 항온항습기 #1</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $WATT8; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-flask fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 보드2 -->
                        <div class="col-xl-4 col-md-6 mb-2">
                            <div class="card border-left shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #892CDC;">(실시간) 항온항습기 #2</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $WATT9; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-flask fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 보드3 -->
                        <div class="col-xl-4 col-md-6 mb-2">
                            <div class="card border-left shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #52057B;">(실시간) 항온항습기 #3</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $WATT7; ?></div>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-flask fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 카드2 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-6"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-2">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                    <h6 class="m-0 font-weight-bold text-primary">주간 가동률</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample21">
                                    <div class="card-body">
                                        <!-- Begin row -->
                                        <div class="row">    
                                            <div class="chart" style="height: 62vh; width: 100%;">
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

                        <!-- 카드3 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-6"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-2">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                    <h6 class="m-0 font-weight-bold text-primary">월간 가동률</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample31">
                                    <div class="card-body">
                                        <!-- Begin row -->
                                        <div class="row">    
                                            <div class="chart" style="height: 62vh; width: 100%;">
                                                <canvas id="barChart5"></canvas>
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
        //월간 가동률★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            /* ChartJS
            * -------
            * Here we will create a few charts using ChartJS
            */
            
            // Get context with jQuery - using jQuery's .get() method.
            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas5 = $('#barChart5').get(0).getContext('2d')

            var barChartData5 = {
            labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            datasets: [
                {
                label               : '항온항습기 #1',
                backgroundColor     : 'rgba(118,111,241,1)',
                borderColor         : 'rgba(118,111,241,1)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(118,111,241,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(118,111,241,1)',
                data                : [<?php echo ROUND(($monthlyData[8][1]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear1M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][2]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear2M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][3]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear3M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][4]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear4M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][5]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear5M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][6]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear6M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][7]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear7M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][8]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear8M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][9]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear9M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][10]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear10M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][11]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear11M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo ROUND(($monthlyData[8][12]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear12M_FirstDay, 'day')/24*100, 1); ?>]
                },
                {
                label               : '항온항습기 #2',
                backgroundColor     : 'rgba(137,44,220,1)',
                borderColor         : 'rgba(137,44,220,1)',
                pointRadius         : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(137,44,220,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(137,44,220,1)',
                data                : [ <?php echo round(($monthlyData[9][1]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear1M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][2]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear2M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][3]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear3M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][4]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear4M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][5]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear5M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][6]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear6M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][7]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear7M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][8]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear8M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][9]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear9M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][10]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear10M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][11]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear11M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[9][12]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear12M_FirstDay, 'day')/24*100, 1); ?>]
                },
                {
                label               : '항온항습기 #3',
                backgroundColor     : 'rgba(82,5,123,1)',
                borderColor         : 'rgba(82,5,123,1)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(82,5,123,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(82,5,123,1)',
                data                : [ <?php echo round(($monthlyData[7][1]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear1M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][2]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear2M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][3]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear3M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][4]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear4M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][5]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear5M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][6]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear6M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][7]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear7M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][8]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear8M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][9]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear9M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][10]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear10M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][11]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear11M_FirstDay, 'day')/24*100, 1); ?>,
                                        <?php echo round(($monthlyData[7][12]['work_time'] ?? 0)/60/DateConversion($Hyphen_ThisYear12M_FirstDay, 'day')/24*100, 1); ?>]
                }
            ]}

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
                                label += '%';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'linear',
                        ticks: {
                            stepSize: 10 // y축을 10씩 증가하여 표현
                        }  
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


        //주간 가동률★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        $(function () {
            /* ChartJS
            * -------
            * Here we will create a few charts using ChartJS
            */
            
            // Get context with jQuery - using jQuery's .get() method.
            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas6 = $('#barChart6').get(0).getContext('2d')

            var barChartData6 = {
            labels  : ['<?php echo $week6."주차"?>', '<?php echo $week5."주차"?>', '<?php echo $week4."주차"?>', '<?php echo $week3."주차"?>', '<?php echo $week2."주차"?>', '<?php echo $week1."주차"?>', '<?php echo $week."주차"?>'],
            datasets: [
                {
                label               : '항온항습기 #1',
                backgroundColor     : 'rgba(118,111,241,1)',
                borderColor         : 'rgba(118,111,241,1)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(118,111,241,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(118,111,241,1)',
                data                : [ <?php echo ROUND(($weeklyData[8][7]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo ROUND(($weeklyData[8][6]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo ROUND(($weeklyData[8][5]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo ROUND(($weeklyData[8][4]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo ROUND(($weeklyData[8][3]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo ROUND(($weeklyData[8][2]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo ROUND(($weeklyData[8][1]['work_time'] ?? 0)/60/7/24*100, 1); ?>]
                },
                {
                label               : '항온항습기 #2',
                backgroundColor     : 'rgba(137,44,220,1)',
                borderColor         : 'rgba(137,44,220,1)',
                pointRadius         : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(137,44,220,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(137,44,220,1)',
                data                : [ <?php echo round(($weeklyData[9][7]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[9][6]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[9][5]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[9][4]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[9][3]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[9][2]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[9][1]['work_time'] ?? 0)/60/7/24*100, 1); ?>]
                },
                {
                label               : '항온항습기 #3',
                backgroundColor     : 'rgba(82,5,123,1)',
                borderColor         : 'rgba(82,5,123,1)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(82,5,123,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(82,5,123,1)',
                data                : [ <?php echo round(($weeklyData[7][7]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[7][6]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[7][5]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[7][4]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[7][3]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[7][2]['work_time'] ?? 0)/60/7/24*100, 1); ?>,
                                        <?php echo round(($weeklyData[7][1]['work_time'] ?? 0)/60/7/24*100, 1); ?>]
                }
            ]}

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
                                    label += new Intl.NumberFormat('en-US', { maximumSignificantDigits: 8 } ).format(context.parsed.y);
                                }
                                label += '%';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        display: true,
                        type: 'linear',
                        ticks: {
                            stepSize: 10 // y축을 10씩 증가하여 표현
                        }  
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

            new Chart(barChartCanvas6, {
            type: 'bar',
            data: barChartData6,
            options: barChartOptions
            }) 
        })
    </script>    

</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) {mysqli_close($connect4);}
?>