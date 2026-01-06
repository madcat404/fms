<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.02.01>
	// Description:	<그룹웨어 일일지표 뷰어>
  // Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
	// =============================================
  include 'gw_indicator_status.php';

  // Helper function to generate weather icon
  function getWeatherIcon($status) {
      $icon_map = [
          '맑음' => 'fas fa-sun fa-3x',
          '구름 많음' => 'fas fa-cloud-sun fa-3x',
          '흐림' => 'fas fa-cloud fa-3x',
          '비' => 'fas fa-cloud-showers-heavy fa-3x',
          '비/눈' => 'fas fa-cloud-showers-heavy fa-3x',
          '눈' => 'fas fa-snowflake fa-3x',
          '소나기' => 'fas fa-cloud-showers-heavy fa-3x',
      ];
      return $icon_map[$status] ?? 'fas fa-sun fa-3x';
  }

  // Helper function to generate comparison html
  function getComparisonHtml($compare, $compare_rate) {
      $formatted_rate = number_format($compare_rate, 2);
      $image = '';
      if ($compare_rate > 0) {
          $image = '<img src="../img/up.png" width="5%">';
      } elseif ($compare_rate < 0) {
          $image = '<img src="../img/down.png" width="5%">';
      } else {
          $image = '<img src="../img/same.png" width="5%">';
      }
      return number_format($compare) . " ({$formatted_rate}%)&nbsp;{$image}";
  }

  // Helper function to generate energy status circle
  function getEnergyCircle($status) {
      if (isset($status) && $status >= 1 && $status <= 4) {
          return '<img src="../img/circle'.$status.'.png" width="20%" style="padding-top: 5%;">';
      }
      return '';
  }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
    <meta name="author" content="madcat">
    <title>FMS</title>

    <!-- style -->
    <link rel="stylesheet" href="../css/reset.css">

    <!-- Font-Awesome 아이콘 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- 파비콘 -->
    <link rel="shortcut icon" href="../icon/kjwt_favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="../icon/kjwt_ci_152.png">
    <link rel="icon" href="../icon/kjwt_favicon.png">
    <link rel="icon" href="../icon/kjwt_ci_16.png" sizes="16x16"> 
    <link rel="icon" href="../icon/kjwt_ci_32.png" sizes="32x32"> 
    <link rel="icon" href="../icon/kjwt_ci_48.png" sizes="48x48"> 
    <link rel="icon" href="../icon/kjwt_ci_64.png" sizes="64x64"> 
    <link rel="icon" href="../icon/kjwt_ci_128.png" sizes="128x128">

    <!-- 웹 폰트 -->
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">

    <!-- 차트 -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- tooltip -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript">
      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['table']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawAllTables);

      // Callback that creates and populates a data table, instantiates charts, and draws them.
      function drawAllTables() {
        drawStockTable();
        drawWeatherTable();
        drawNewsTable();
        drawEnergyTable();
      }

      function drawStockTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '종목명');
        data.addColumn('number', '주식 현재가(원)');
        data.addColumn('string', '전일대비(원)');
        data.addRows([
          [ "아이윈", <?php echo $indicator_data['stock']['iwin']['current']; ?>, '<?php echo getComparisonHtml($indicator_data['stock']['iwin']['compare'], $indicator_data['stock']['iwin']['compare_rate']); ?>']
         ]);

        var table = new google.visualization.Table(document.getElementById('table_div5'));
        table.draw(data, {allowHtml: true, width: '100%', height: '100%'});
      }

      function drawWeatherTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '');
        data.addColumn('string', '오전');
        data.addColumn('string', '오후');
        data.addColumn('number', '최저기온(°C)');
        data.addColumn('number', '최고기온(°C)');
        data.addRows([          
          ['오늘', '<i class="<?php echo getWeatherIcon($indicator_data['weather']['today_am']); ?>"></i>', '<i class="<?php echo getWeatherIcon($indicator_data['weather']['today_pm']); ?>"></i>', {v: 1, f: '<?php echo $indicator_data['weather']['today_min_temp']; ?>', p: {style: 'color: blue; text-align: center;'}}, {v: 1, f: '<?php echo $indicator_data['weather']['today_max_temp']; ?>', p: {style: 'color: red; text-align: center;'}}],
          ['내일', '<i class="<?php echo getWeatherIcon($indicator_data['weather']['tomorrow_am']); ?>"></i>', '<i class="<?php echo getWeatherIcon($indicator_data['weather']['tomorrow_pm']); ?>"></i>', {v: 1, f: '<?php echo $indicator_data['weather']['tomorrow_min_temp']; ?>', p: {style: 'color: blue; text-align: center;'}}, {v: 1, f: '<?php echo $indicator_data['weather']['tomorrow_max_temp']; ?>', p: {style: 'color: red; text-align: center;'}}]
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div4'));
        table.draw(data, {allowHtml: true, width: '100%', height: '100%'});
      }

      function drawNewsTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '헤드라인');
        data.addColumn('string', '바로가기');
        data.addRows([
            <?php foreach($indicator_data['news'] as $news_item): ?>
                ["<?php echo addslashes($news_item['title']); ?>", '<?php echo '<a href="' . $news_item['url'] . '" target="-blank"><i class="fas fa-book-open fa-2x"></i></a>'; ?>'],
            <?php endforeach; ?>
        ]);
        
        var table = new google.visualization.Table(document.getElementById('table_div6'));
        table.draw(data, {allowHtml: true, width: '100%', height: '100%'});
      }

      function drawEnergyTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '에너지 종류'); 
        data.addColumn('string', '전월 대비');
        data.addColumn('string', '금월/전월');
        data.addColumn('string', '전년동월 대비');
        data.addColumn('string', '금년/전년');
        data.addRows([          
          ['<i class="fas fa-tint fa-2x"></i> 수도',
          {v: 'Energy_water1', f: '<?php echo getEnergyCircle($indicator_data['energy']['water_vs_last_month']); ?>'},
          {v: 'Energy_water12', f: '<?php echo number_format($indicator_data['energy']['water_this_month']); ?> / <?php echo number_format($indicator_data['energy']['water_last_month']); ?> (㎥)'},
          {v: 'Energy_water2', f: '<?php echo getEnergyCircle($indicator_data['energy']['water_vs_last_year']); ?>'},
          {v: 'Energy_water22', f: '<?php echo number_format($indicator_data['energy']['water_this_month']); ?> / <?php echo number_format($indicator_data['energy']['water_last_year_month']); ?> (㎥)'}],
          ['<i class="fas fa-fire-alt fa-2x"></i> 가스', 
          {v: 'Energy_gas1', f: '<?php echo getEnergyCircle($indicator_data['energy']['gas_vs_last_month']); ?>'},
          {v: 'Energy_gas12', f: '<?php echo number_format($indicator_data['energy']['gas_this_month']); ?> / <?php echo number_format($indicator_data['energy']['gas_last_month']); ?> (㎥)'},
          {v: 'Energy_gas2', f: '<?php echo getEnergyCircle($indicator_data['energy']['gas_vs_last_year']); ?>'},
          {v: 'Energy_gas2', f: '<?php echo number_format($indicator_data['energy']['gas_this_month']); ?> / <?php echo number_format($indicator_data['energy']['gas_last_year_month']); ?> (㎥)'}],
          ['<i class="fas fa-bolt fa-2x"></i> 전기',
          {v: 'Energy_electricity1', f: '<?php echo getEnergyCircle($indicator_data['energy']['electricity_vs_last_month']); ?>'},
          {v: 'Energy_electricity12', f: '<?php echo round($indicator_data['energy']['electricity_this_month']/1000); ?> / <?php echo round($indicator_data['energy']['electricity_last_month']/1000); ?> (MWH)'},
          {v: 'Energy_electricity2', f: '<?php echo getEnergyCircle($indicator_data['energy']['electricity_vs_last_year']); ?>'},
          {v: 'Energy_electricity2', f: '<?php echo round($indicator_data['energy']['electricity_this_month']/1000); ?> / <?php echo round($indicator_data['energy']['electricity_last_year']/1000); ?> (MWH)'}]
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div7'));
        table.draw(data, {allowHtml: true, width: '100%', height: '100%'});
      }
    </script>

    <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>
</head>
  
<body style="overflow:hidden;"> 
  <div style="background-color: white; text-align: center; min-height:100vh; max-width:100vw;">
    <div style="font-weight: bold; font-size: 10px; padding-top: 7px; padding-bottom: 0px; min-height:5vh; max-width:100vw; text-align: left;">
      &nbsp &nbsp 바로가기 : 
      <a href="https://fms.iwin.kr/kjwt_report/report_body.php" target="_blank" data-toggle="tooltip" title="일일업무보고">
        <span class="fa-stack fa-2x" style="text-align: center;">                                    
          <i class="fas fa-square fa-2x"></i>
          <i class="fas fa-chart-pie fa-stack-1x fa-inverse"></i>                                   
        </span>    
      </a>
      <a href="https://fms.iwin.kr/kjwt_office_food/food.php" target="_blank" data-toggle="tooltip" title="식단표">
        <span class="fa-stack fa-2x" style="text-align: center;">                                    
          <i class="fas fa-square fa-2x"></i>
          <i class="fas fa-hamburger fa-stack-1x fa-inverse"></i>                                   
        </span>    
      </a>
      <a href="https://fms.iwin.kr/kjwt_fms/rental.php" target="_blank" data-toggle="tooltip" title="법인차 대여">
        <span class="fa-stack fa-2x" style="text-align: center;">                                    
          <i class="fas fa-square fa-2x"></i>
          <i class="fas fa-car fa-stack-1x fa-inverse"></i>                                   
        </span>    
      </a>
      <a href="https://fms.iwin.kr/kjwt_todolist/todolist.php" target="_blank" data-toggle="tooltip" title="기술지원요청">
        <span class="fa-stack fa-2x" style="text-align: center;">                                    
          <i class="fas fa-square fa-2x"></i>
          <i class="fas fa-headset fa-stack-1x fa-inverse"></i>                                   
        </span>    
      </a>
      <a href="https://fms.iwin.kr/kjwt_office_duty/duty.php" target="_blank" data-toggle="tooltip" title="당직">
        <span class="fa-stack fa-2x" style="text-align: center;">                                    
          <i class="fas fa-square fa-2x"></i>
          <i class="fas fa-user-check fa-stack-1x fa-inverse"></i>                                   
        </span>    
      </a>
      <a href="https://fms.iwin.kr/kjwt_network/network.php" target="_blank" data-toggle="tooltip" title="비상연락망">
        <span class="fa-stack fa-2x" style="text-align: center;">                                    
          <i class="fas fa-square fa-2x"></i>
          <i class="fas fa-phone fa-stack-1x fa-inverse"></i>                                   
        </span>    
      </a>
      <a href="https://fms.iwin.kr/kjwt_report/report_body.php?tab=management" target="_blank" data-toggle="tooltip" title="경영">
        <span class="fa-stack fa-2x" style="text-align: center;">                                    
          <i class="fas fa-square fa-2x"></i>
          <i class="fas fa-poll-h fa-stack-1x fa-inverse"></i>                                   
        </span>    
      </a>
      <a href="https://fms.iwin.kr/kjwt_video/video.php" target="_blank" data-toggle="tooltip" title="매뉴얼">
        <span class="fa-stack fa-2x" style="text-align: center;">                                    
          <i class="fas fa-square fa-2x"></i>
          <i class="fas fa-pen fa-stack-1x fa-inverse"></i>                                   
        </span>    
      </a>
      <a href="https://earth.nullschool.net/#current/wind/surface/level/orthographic=-226.05,30.25,1296" target="_blank" data-toggle="tooltip" title="태풍">
        <span class="fa-stack fa-2x" style="text-align: center;">                                    
          <i class="fas fa-square fa-2x"></i>
          <i class="fas fa-wind fa-stack-1x fa-inverse"></i>                                   
        </span>    
      </a>
    </div>
    <hr>
    <div style="display: inline-block; font-weight: bold; font-size: 19px; padding-top: 0px; padding-bottom: 5px; min-height:5vh; max-width:100vw;">
      <span class="fa-stack fa-lg">                                    
        <i class="fas fa-square fa-2x"></i>
        <i class="fas fa-chart-line fa-stack-1x fa-inverse"></i>                                   
      </span>    
      주요일일지표
    </div>
    <br>
    <img src="../img/circle1.png" width="3%" style="vertical-align: middle;"> 5% 초과 
    / <img src="../img/circle2.png" width="3%" style="vertical-align: middle;"> 2.5% 초과 
    / <img src="../img/circle5.png" width="3%" style="vertical-align: middle;"> 초과
    / <img src="../img/circle4.png" width="3%" style="vertical-align: middle;"> 이하
    / (전기 매월 16일 시작)
    <div id="table_div7" style="max-width:100vw;"></div><br> 
    <?php echo $indicator_data['stock']['iwin']['dt'] ." ". $indicator_data['stock']['iwin']['ti']; ?> 기준
    <div id="table_div5" style="max-width:100vw;"></div><br> 
    '아이윈' 관련 뉴스 top 3 (출처: 네이버)<br> 
    <div id="table_div6" style="max-width:100vw;"></div><br>  
    <div id="table_div4" style="max-width:100vw;"></div>
  <div>
  <!-- JavaScript Libraries -->
  <!-- 제이쿼리 -->
  <script src="../js/jquery.min_1.12.4.js"></script>
  <!-- 호환성(브라우저 기능검사) -->
  <script src="../js/modernizr-custom.js"></script>
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