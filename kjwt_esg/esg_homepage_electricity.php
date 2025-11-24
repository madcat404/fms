<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.14>
	// Description:	<홈페이지 전기 사용량>	
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
                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                        <h1 class="h6 m-0 font-weight-bold text-primary">전기 사용량 단위: Kwh</h6>
                                    </a>
                                    <div class="card-tools mt-3">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#elec_chart" data-toggle="tab">차트</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#elec_table" data-toggle="tab">표</a>
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
                                                            <th scope="row"><?php echo $YY; ?></th>
                                                            <?php
                                                            $i = 0; // 0번 인덱스(합계)부터 시작
                                                            while ($i <= 12) { // 12번 인덱스(12월)까지 반복
                                                                echo '<td>' . number_format($thisYearElectricityUsageData[$i], 0) . '</td>';
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tr>
                                                        <tr style="text-align: center;">
                                                            <th scope="row"><?php echo $Minus1YY; ?></th>
                                                            <?php
                                                            $i = 0;
                                                            while ($i <= 12) {
                                                                // 백엔드 변수명 $lastYearElectricityUsageData 사용
                                                                echo '<td>' . number_format($lastYearElectricityUsageData[$i], 0) . '</td>';
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tr>
                                                        <tr style="text-align: center;">
                                                            <th scope="row"><?php echo $Minus2YY; ?></th>
                                                            <?php
                                                            $i = 0;
                                                            while ($i <= 12) {
                                                                // 백엔드 변수명 $twoYearsAgoElectricityUsageData 사용
                                                                echo '<td>' . number_format($twoYearsAgoElectricityUsageData[$i], 0) . '</td>';
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
  //전기★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
  $(function () {
    var barChartCanvas4 = $('#barChart4').get(0).getContext('2d')

    var barChartData4 = {
        labels  : ['합계','1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        datasets: [
            {
                label                : '<?php echo $YY?>년',
                backgroundColor      : 'rgba(236,194,76,1)',
                borderColor          : 'rgba(236,194,76,1)',
                pointRadius          : false,
                pointColor           : '#3b8bba',
                pointStrokeColor     : 'rgba(236,194,76,1)',
                pointHighlightFill   : '#fff',
                pointHighlightStroke: 'rgba(236,194,76,1)',
                // ★ 수정: $thisYearElectricityUsageData 배열의 값(0:합계, 1~12:월)을 json으로 변환
                data                 : <?php echo json_encode(array_values($thisYearElectricityUsageData), JSON_NUMERIC_CHECK); ?>
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
                // ★ 수정: 백엔드의 $lastYearElectricityUsageData 변수 사용
                data                 : <?php echo json_encode(array_values($lastYearElectricityUsageData), JSON_NUMERIC_CHECK); ?>
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
                // ★ 수정: $twoYearsAgoElectricityUsageData 변수 사용
                data                 : <?php echo json_encode(array_values($twoYearsAgoElectricityUsageData), JSON_NUMERIC_CHECK); ?>
            },
            {
                label                : '<?php echo $YY?>년 목표 (전년대비 3%절감)',
                type                 : 'line', // 선형 그래프로 표시
                borderColor          : 'rgba(255, 99, 132, 1)', // 선 색상
                borderWidth          : 2, // 선 두께
                fill                 : false, // 배경 채우기 없음
                // ★ 수정: $lastYearElectricityUsageData (전년도 사용량)를 기반으로 목표치 배열 계산
                data                 : <?php
                                            $goalData = [];
                                            if (isset($lastYearElectricityUsageData) && is_array($lastYearElectricityUsageData)) {
                                                // 0번(합계)부터 12번(12월)까지 각 값에 0.97을 곱함
                                                foreach (array_values($lastYearElectricityUsageData) as $value) {
                                                    $goalData[] = $value * 0.97;
                                                }
                                            }
                                            echo json_encode($goalData, JSON_NUMERIC_CHECK);
                                        ?>
            }
        ]
    }

    var temp0 = barChartData4.datasets[0]
    var temp1 = barChartData4.datasets[1]
    var temp2 = barChartData4.datasets[2]
    var temp3 = barChartData4.datasets[3]
    barChartData4.datasets[0] = temp3
    barChartData4.datasets[1] = temp2
    barChartData4.datasets[2] = temp1
    barChartData4.datasets[3] = temp0
    

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
                        label += ' Kwh';
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

