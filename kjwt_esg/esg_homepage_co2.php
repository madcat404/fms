<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.14>
	// Description:	<홈페이지 이산화탄소 배출량>	
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
                                    <a href="#collapseCardExample20" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample20">
                                        <h1 class="h6 m-0 font-weight-bold text-primary">온실가스 배출량 단위: tCO2</h6>
                                    </a>
                                    <!-- Card Header - Accordion -->
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

