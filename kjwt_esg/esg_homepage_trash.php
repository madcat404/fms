<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.14>
	// Description:	<홈페이지 폐기물 >	
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
                                        <h1 class="h6 m-0 font-weight-bold text-primary">폐기물 배출 단위: Kg</h6>
                                    </a>
                                    <div class="card-tools mt-3">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#gar_chart" data-toggle="tab">차트</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#gar_table" data-toggle="tab">표</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample24">                                    
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
 //폐기물★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
 $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    
    // Get context with jQuery - using jQuery's .get() method.
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas3 = $('#barChart3').get(0).getContext('2d')

    var barChartData3 = {
        labels  : ['합계','1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        datasets: [
            {
                label               : '<?php echo $YY?>년',
                backgroundColor     : 'rgba(40,192,141,1)',
                // ... (기타 설정 동일)
                // [수정됨] 13줄의 echo를 1줄로 변경
                data                : [<?php echo implode(',', $thisYearTrash); ?>]
            },
            {
                label               : '<?php echo $Minus1YY?>년',
                backgroundColor     : 'rgba(210, 214, 222, 1)',
                // ... (기타 설정 동일)
                // [수정됨] 13줄의 echo를 1줄로 변경
                data                : [<?php echo implode(',', $lastYearTrash); ?>]
            },
            {
                label               : '<?php echo $Minus2YY?>년',
                backgroundColor     : 'rgba(175, 183, 197, 1)',
                // ... (기타 설정 동일)
                // [수정됨] 13줄의 echo를 1줄로 변경
                data                : [<?php echo implode(',', $twoYearsAgoTrash); ?>]
            },
            {
                label               : '<?php echo $YY?>년 목표 (전년대비 3%절감)',
                type                : 'line',
                borderColor         : 'rgba(255, 99, 132, 1)',
                borderWidth         : 2,
                fill                : false,
                // [수정됨] array_map을 사용해 0.97을 곱한 값을 1줄로 변경
                data                : [<?php 
                                        // $lastYearTrash 배열의 모든 요소에 0.97을 곱한 새 배열을 만듦
                                        $goalData = array_map(function($v) { 
                                            return $v * 0.97; 
                                        }, $lastYearTrash);
                                        
                                        // 새 배열을 쉼표로 연결하여 출력
                                        echo implode(',', $goalData); 
                                    ?>]
            }
        ]
    }

    var temp0 = barChartData3.datasets[0]
    var temp1 = barChartData3.datasets[1]
    var temp2 = barChartData3.datasets[2]
    var temp3 = barChartData3.datasets[3]
    barChartData3.datasets[0] = temp3
    barChartData3.datasets[1] = temp2
    barChartData3.datasets[2] = temp1
    barChartData3.datasets[3] = temp0

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
                        label += ' Kg';
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


    new Chart(barChartCanvas3, {
        type: 'bar',
        data: barChartData3,
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

