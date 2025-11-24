<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.14>
	// Description:	<홈페이지 용수 사용량>	
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

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                        <h1 class="h6 m-0 font-weight-bold text-primary">용수 사용량 단위: ㎥</h6>
                                    </a>
                                    <div class="card-tools mt-3">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#water_chart" data-toggle="tab">차트</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#water_table" data-toggle="tab">표</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample22">                                    
                                    <div class="card-body">
                                        <div class="tab-content p-0">  
                                            <div class="chart tab-pane active" id="water_chart" style="position: relative; height: 300px;">
                                                <canvas id="barChart2"></canvas>
                                            </div>
                                            <div class="chart tab-pane" id="water_table" style="position: relative; height: 300px;">
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
                                                            <?php
                                                            $i = 0; // 0번 인덱스(합계)부터 시작
                                                            while ($i <= 12) { // 12번 인덱스(12월)까지 반복
                                                                // $thisYearWaterIwinUsageData와 $thisYearWaterMalleUsageData의 값을 합산
                                                                $value = $thisYearWaterIwinUsageData[$i] ?? 0;
                                                                echo '<td>' . number_format($value, 0) . '</td>';
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tr>
                                                        <tr style="text-align: center;">
                                                            <th scope="row"><?php echo $Minus1YY; ?></th>
                                                            <?php
                                                            $i = 0;
                                                            while ($i <= 12) {
                                                                // $lastYear... 두 변수의 값을 합산
                                                                $value = $lastYearWaterIwinUsageData[$i] ?? 0;
                                                                echo '<td>' . number_format($value, 0) . '</td>';
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tr>
                                                        <tr style="text-align: center;">
                                                            <th scope="row"><?php echo $Minus2YY; ?></th>
                                                            <?php
                                                            $i = 0;
                                                            while ($i <= 12) {
                                                                // $twoYearsAgo... 두 변수의 값을 합산
                                                                $value = $twoYearsAgoWaterIwinUsageData[$i] ?? 0;
                                                                echo '<td>' . number_format($value, 0) . '</td>';
                                                                $i++;
                                                            }
                                                            ?>
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
  $(function () {
    var barChartCanvas2 = $('#barChart2').get(0).getContext('2d')

    var barChartData2 = {
        labels  : ['합계','1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        datasets: [
            {
                label                : '<?php echo $YY?>년',
                backgroundColor      : 'rgba(75,112,221, 1)',
                borderColor          : 'rgba(75,112,221, 1)',
                pointRadius          : false,
                pointColor           : '#3b8bba',
                pointStrokeColor     : 'rgba(75,112,221, 1)',
                pointHighlightFill   : '#fff',
                pointHighlightStroke: 'rgba(75,112,221, 1)',
                // ★ 수정: $thisYearWaterIwinUsageData와 $thisYearWaterMalleUsageData를 합산
                data                 : <?php
                                            $thisYearWater = [];
                                            for ($i = 0; $i <= 12; $i++) {
                                                // 0번(합계)부터 12번(12월)까지 각 인덱스의 값을 더함
                                                $thisYearWater[$i] = $thisYearWaterIwinUsageData[$i] ?? 0;
                                            }
                                            echo json_encode(array_values($thisYearWater), JSON_NUMERIC_CHECK);
                                        ?>
            },
            {
                label                : '<?php echo $Minus1YY?>년',
                backgroundColor      : 'rgba(210, 214, 222, 1)',
                borderColor          : 'rgba(210, 214, 222, 1)',
                pointRadius          : false,
                pointColor           : 'rgba(210, 214, 222, 1)',
                pointStrokeColor     : '#c1c7d1',
                pointHighlightFill   : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                // ★ 수정: $lastYearWaterIwinUsageData와 $lastYearWaterMalleUsageData를 합산
                data                 : <?php
                                            $lastYearWater = [];
                                            for ($i = 0; $i <= 12; $i++) {
                                                $lastYearWater[$i] = $lastYearWaterIwinUsageData[$i] ?? 0;
                                            }
                                            echo json_encode(array_values($lastYearWater), JSON_NUMERIC_CHECK);
                                        ?>
            },
            {
                label                : '<?php echo $Minus2YY?>년',
                backgroundColor      : 'rgba(175, 183, 197, 1)',
                borderColor          : 'rgba(175, 183, 197, 1)',
                pointRadius          : false,
                pointColor           : 'rgba(175, 183, 197, 1)',
                pointStrokeColor     : '#c1c7d1',
                pointHighlightFill   : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                // ★ 수정: $twoYearsAgoWaterIwinUsageData와 $twoYearsAgoWaterMalleUsageData를 합산
                data                 : <?php
                                            $twoYearsAgoWater = [];
                                            for ($i = 0; $i <= 12; $i++) {
                                                $twoYearsAgoWater[$i] = $twoYearsAgoWaterIwinUsageData[$i] ?? 0;
                                            }
                                            echo json_encode(array_values($twoYearsAgoWater), JSON_NUMERIC_CHECK);
                                        ?>
            },
            {
                label                : '<?php echo $YY?>년 목표 (전년대비 3%절감)',
                type                 : 'line', // 선형 그래프로 표시
                borderColor          : 'rgba(255, 99, 132, 1)', // 선 색상
                borderWidth          : 2, // 선 두께
                fill                 : false, // 배경 채우기 없음
                // ★ 수정: $lastYear... (전년도) 합산 데이터 기준으로 목표치 계산
                data                 : <?php
                                            $goalData = [];
                                            // 1. 전년도 합산 배열($lastYearWater)을 먼저 계산
                                            $lastYearSummed = [];
                                            for ($i = 0; $i <= 12; $i++) {
                                                $lastYearSummed[$i] = $lastYearWaterIwinUsageData[$i] ?? 0;
                                            }
                                            
                                            // 2. 합산 배열 기준으로 목표치(97%) 계산
                                            foreach ($lastYearSummed as $value) {
                                                $goalData[] = $value * 0.97;
                                            }
                                            echo json_encode($goalData, JSON_NUMERIC_CHECK);
                                        ?>
            }
        ]
    }

    var temp0 = barChartData2.datasets[0]
    var temp1 = barChartData2.datasets[1]
    var temp2 = barChartData2.datasets[2]
    var temp3 = barChartData2.datasets[3]
    barChartData2.datasets[0] = temp3
    barChartData2.datasets[1] = temp2
    barChartData2.datasets[2] = temp1
    barChartData2.datasets[3] = temp0

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
                        label += ' ㎥';
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
</script>

</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) {
    mysqli_close($connect4);
}	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>

