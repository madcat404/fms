<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.18>
	// Description:	<온습도 리뷰>	
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include_once 'measure_total_status.php';
    function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>    
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include '../nav.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button"><i class="fa fa-bars"></i></button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">온습도</h1>
                    </div>               
                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1"><h6 class="m-0 font-weight-bold text-primary">공지</h6></a>
                                <div class="collapse" id="collapseCardExample1">
                                    <div class="card-body">
                                            [목표]<BR>
                                            - 온습도 검침 자동화<BR><BR>   
                                            [기능]<br>
                                            - 1시간 간격으로 온습도 측정<br>
                                            - 운영기준 온도를 벗어나면 알림메일 발송 (현장예외)<br><br>   
                                            [운영기준]<br>
                                            - 전산실 운영기준 온습도 | 온도: 18~25(℃) / 습도: 35~55(%)<br>
                                            - 시험실 운영기준 온습도 | 온도: 21~25(℃) / 습도: 40~60(%)<br>
                                            - 현장 운영기준 온습도 | 온도: 22~28(℃) / 습도: 40~60(%)<br>
                                            - 수입검사실 운영기준 온습도(하절기 4~10월) | 온도: 18~28(℃) / 습도: 30~60(%)<br>
                                            - 수입검사실 운영기준 온습도(동절기 11~3월) | 온도: 13~23(℃) / 습도: 30~60(%)<br>
                                            - 자재창고/B/B창고 온습도(하절기 4~10월) | 온도: 10~30(℃) / 습도: 25~90(%)
                                            - 자재창고/B/B창고 온습도(동절기 11~3월) | 온도: 5~20(℃) / 습도: 25~60(%)<br><br>     
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 사무직<br>
                                            - 시험실 A구역: 출입구 주변 / 시험실 B구역: 챔버 주변<br>   
                                            - 그래프 색상은 정성형 배합을 사용했고 matplotlib의 new Tableau 10을 참조하였음<br>
                                            - WIFI모듈: ESP8266 / 온습도센서: DHT22(온도 범위 : -40-80 ℃ ± 0.5 ℃ / 습도 범위 : 20~90% RH ± 2 % RH)<br>
                                            - 외부 평균 온습도는 공공데이터 포털 api 정보를 참조함<br><br>
                                            [제작일]<BR>
                                            - 21.11.18<br><br>                                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $indoor_temp_sum = 0;
                            $indoor_hum_sum = 0;
                            $valid_sensor_count = 0;
                            foreach($latest_readings as $prefix => $readings) {
                                if (!empty($readings)) {
                                    $indoor_temp_sum += $readings[0]['TEMPERATURE'];
                                    $indoor_hum_sum += $readings[0]['HUMIDITY'];
                                    $valid_sensor_count++;
                                }
                            }
                            $avg_temp = $valid_sensor_count > 0 ? floor($indoor_temp_sum / $valid_sensor_count) : 0;
                            $avg_hum = $valid_sensor_count > 0 ? floor($indoor_hum_sum / $valid_sensor_count) : 0;
                        ?>
                        <div class="col-xl-3 col-md-6 mb-2"><div class="card border-left-danger shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-danger text-uppercase mb-1">실내 평균 온도</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($avg_temp); ?></div></div><div class="col-auto"><i class="fas fa-temperature-high fa-2x text-gray-300"></i></div></div></div></div></div>
                        <div class="col-xl-3 col-md-6 mb-2"><div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">실내 평균 습도</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($avg_hum); ?></div></div><div class="col-auto"><i class="fas fa-tint fa-2x text-gray-300"></i></div></div></div></div></div>
                        <div class="col-xl-3 col-md-6 mb-2"><div class="card border-left-danger shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-danger text-uppercase mb-1">외부 최고 온도</div><div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo h(floor($tweather_row['fcstValue'] ?? 0)); ?></div></div><div class="col-auto"><i class="fas fa-temperature-high fa-2x text-gray-300"></i></div></div></div></div></div>
                        <div class="col-xl-3 col-md-6 mb-2"><div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">외부 최고 습도</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h(floor($hweather_row['fcstValue'] ?? 0)); ?></div></div><div class="col-auto"><i class="fas fa-tint fa-2x text-gray-300"></i></div></div></div></div></div>
                        
                        <div class="col-lg-6"><div class="card shadow mb-2"><a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">온도</h6></a><div class="collapse show" id="collapseCardExample31"><div class="card-body"><div class="chart" style="height: 62vh; width: 100%;"><canvas id="lineChart1"></canvas></div></div></div></div></div>
                        <div class="col-lg-6"><div class="card shadow mb-2"><a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">습도</h6></a><div class="collapse show" id="collapseCardExample32"><div class="card-body"><div class="chart" style="height: 62vh; width: 100%;"><canvas id="lineChart2"></canvas></div></div></div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../plugin_lv1.php'; ?>
    <script>
    <?php
        // Prepare data for Chart.js
        $chart_labels = ['6시간 전', '5시간 전', '4시간 전', '3시간 전', '2시간 전', '1시간 전', '방금전'];
        $chart_datasets_temp = [];
        $chart_datasets_hum = [];

        $dataset_map = [
            'f' => ['label' => '생산현장', 'color' => 'rgba(78,121,165, 1)'],
            'm' => ['label' => '자재창고', 'color' => 'rgba(241,143,59, 1)'],
            'b' => ['label' => 'BB창고', 'color' => 'rgba(224,88,91, 1)'],
            'fs' => ['label' => '완성품창고', 'color' => 'rgba(119,183,178, 1)'],
            'e' => ['label' => 'ECU창고', 'color' => 'rgba(90,161,85, 1)'],
            'ms' => ['label' => 'IR워머', 'color' => 'rgba(237,201,88, 1)'],
            'srv' => ['label' => '전산실', 'color' => 'rgba(175,122,160, 1)'],
            'testA' => ['label' => '시험실A', 'color' => 'rgba(254,158,168, 1)'],
            'testB' => ['label' => '시험실B', 'color' => 'rgba(156,117,97, 1)'],
            'qc' => ['label' => '수입검사실', 'color' => 'rgba(186,176,172, 1)'],
        ];

        foreach ($dataset_map as $prefix => $details) {
            $readings = $latest_readings[$prefix] ?? [];
            $readings = array_reverse($readings);

            $temp_data = array_pad(array_column($readings, 'TEMPERATURE'), 7, null);
            $hum_data = array_pad(array_column($readings, 'HUMIDITY'), 7, null);

            $dataset_template = [
                'label' => $details['label'],
                'backgroundColor' => $details['color'],
                'borderColor' => $details['color'],
                'pointRadius' => false,
                'fill' => false,
            ];

            $chart_datasets_temp[] = array_merge($dataset_template, ['data' => $temp_data]);
            $chart_datasets_hum[] = array_merge($dataset_template, ['data' => $hum_data]);
        }
    ?>

    function createChart(canvasId, chartData) {
        var canvas = $('#' + canvasId).get(0).getContext('2d');
        new Chart(canvas, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }
        });
    }

    $(function () {
        createChart('lineChart1', {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: <?php echo json_encode($chart_datasets_temp, JSON_NUMERIC_CHECK); ?>
        });
        createChart('lineChart2', {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: <?php echo json_encode($chart_datasets_hum, JSON_NUMERIC_CHECK); ?>
        });
    });
    </script>
</body>
</html>
<?php if(isset($connect4)) { mysqli_close($connect4); } ?>