<?php 
    declare(strict_types=1);

    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.2.13>
	// Description:	<경비실 검침 전산화>
	// Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
    include 'meter_status.php';   

	/**
	 * Helper function to safely calculate monthly usage from meter data arrays.
	 * Handles null data and prevents negative usage values.
	 */
	function get_monthly_usage(?array $current, ?array $previous, string $key): float {
		$current_val = $current[$key] ?? 0;
		$previous_val = $previous[$key] ?? 0;
		$usage = (float)$current_val - (float)$previous_val;
		return $usage < 0 ? 0.0 : $usage;
	}

	// Prepare data for charts
	$monthly_data_this_year = [];
	$monthly_data_last_year = [];
	for ($m = 1; $m <= 12; $m++) {
		$monthly_data_this_year[$m] = ${"Data_ThisYear{$m}M"};
		$monthly_data_last_year[$m] = ${"Data_LastYear{$m}M"};
	}

	$this_year_water_usage = [];
	$last_year_water_usage = [];
	$this_year_gas_usage = [];
	$last_year_gas_usage = [];

	$prev_for_this_year_jan = $Data_LastYear12M;
	$prev_for_last_year_jan = $Data_BeforeLastYear12M;

	for ($m = 1; $m <= 12; $m++) {
		// This year
		$prev_month_data_this = ($m === 1) ? $prev_for_this_year_jan : $monthly_data_this_year[$m - 1];
		$this_year_water_usage[] = get_monthly_usage($monthly_data_this_year[$m], $prev_month_data_this, 'WATER_IWIN');
		$this_year_gas_usage[] = get_monthly_usage($monthly_data_this_year[$m], $prev_month_data_this, 'GAS');

		// Last year
		$prev_month_data_last = ($m === 1) ? $prev_for_last_year_jan : $monthly_data_last_year[$m - 1];
		$last_year_water_usage[] = get_monthly_usage($monthly_data_last_year[$m], $prev_month_data_last, 'WATER_IWIN');
		$last_year_gas_usage[] = get_monthly_usage($monthly_data_last_year[$m], $prev_month_data_last, 'GAS');
	}

	$this_year_electricity_usage = [];
	$last_year_electricity_usage = [];
	for ($m = 1; $m <= 12; $m++) {
		$this_year_electricity_usage[] = ${"Data_ThisYear{$m}M_E"}['ELECTRICITY'] ?? 0;
		$last_year_electricity_usage[] = ${"Data_LastYear{$m}M_E"}['ELECTRICITY'] ?? 0;
	}

	$this_year_water_js = implode(',', $this_year_water_usage);
	$last_year_water_js = implode(',', $last_year_water_usage);
	$this_year_gas_js = implode(',', $this_year_gas_usage);
	$last_year_gas_js = implode(',', $last_year_gas_usage);
	$this_year_electricity_js = implode(',', $this_year_electricity_usage);
	$last_year_electricity_js = implode(',', $last_year_electricity_usage);
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">검침</h1>
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
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">검침</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">검침내역</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 수도/가스/전기 검침 전산화<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 경비원<br><br>

                                            [제작일]<BR>
                                            - 23.02.13<br><br>

                                            [설명]<br>
                                            - 도시가스 온압보정기는 실제 가스를 사용할 때의 온도와 압력을 측정해서 0℃, 1기압 기준으로 도시가스 사용량을 보정해주는 장치입니다.</BR>
                                            - 매일 16시 경비원이 수도 및 가스 검침 후 FMS에 기록을 실시합니다. (종이에 작성하는 것을 디지털 입력으로 변경하였음 2023년 02월 경)</BR>
                                            - 전기 검침은 매일 1시에 자동으로 입력되고 전일 데이터 합계가 입력됨 (한전 API / 브릿지 서버 스케쥴러)</BR>
                                            - 전기 그래프는 전월 15일 ~ 명월 14일 사용량임 (전기 지로에서 표시되는 사용기간을 맞추기 위함)                                                                                        
                                        </div>

                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <!-- 상단정보 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <div class="row">
                                                    <!-- 보드 시작 -->
                                                    <?php 
                                                        // meter_status.php에서 변경된 변수명($data_today_meter)을 사용하고, null일 경우를 대비하여 ?? 0으로 기본값을 설정합니다.
                                                        $water_iwin = $data_today_meter['WATER_IWIN'] ?? 0;
                                                        $water_malle = $data_today_meter['WATER_MALLE'] ?? 0;
                                                        $gas = $data_today_meter['GAS'] ?? 0;
                                                        $electricity = $data_today_meter['ELECTRICITY'] ?? 0;

                                                        BOARD(3, "primary", "상수도-아이윈(㎥)", $water_iwin, "fas fa-tint");
                                                        BOARD(3, "primary", "상수도-말레(㎥)", $water_malle, "fas fa-tint");
                                                        BOARD(3, "danger", "가스(㎥)", $gas, "fas fa-fire-alt");
                                                        BOARD(3, "warning", "전기(kWh)", $electricity, "fas fa-bolt");
                                                    ?>
                                                </div>

                                            </div>
                                        
                                            <!-- 업로드 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">업로드</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="meter.php" enctype="multipart/form-data"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <!-- Begin 수도 아이윈 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>상수도 사용량 - 아이윈(㎥)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-tint"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="number" class="form-control" name="note21_a" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 수도 아이윈 -->  
                                                                    <!-- Begin 수도 말레 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>상수도 사용량 - 말레(㎥)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-tint"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="number"  class="form-control" name="note21_b" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 수도 말레 --> 
                                                                    <!-- Begin 가스 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>보정 가스 사용량(㎥)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-burn"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="number" class="form-control" name="note21_c" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 가스 --> 
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->    
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>  
                                            
                                            <!-- 차트 - 수도 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">수도사용량-아이윈(㎥)</h6>
                                                    </a>
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <div class="chart" style="height: 30vh; width: 100%;">
                                                                        <canvas id="barChart"></canvas>
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

                                            <!-- 차트 - 가스 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">가스사용량(㎥)</h6>
                                                    </a>
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample23">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <div class="chart" style="height: 30vh; width: 100%;">
                                                                        <canvas id="barChart2"></canvas>
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

                                            <!-- 차트 - 전기 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">전기사용량(KWH)</h6>
                                                    </a>
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample24">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">    
                                                                    <div class="chart" style="height: 30vh; width: 100%;">
                                                                        <canvas id="barChart3"></canvas>
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

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
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
                                                    <form method="POST" autocomplete="off" action="meter.php"> 
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
                                                                                <input type="text" class="form-control float-right kjwt-search-date" name="dt3" value="<?php echo isset($dt3_raw) ? htmlspecialchars($dt3_raw) : ''; ?>">
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
                                                    <form method="POST" action="meter.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample32">
                                                            <div class="card-body table-responsive p-2">
                                                                <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>날짜</th>
                                                                            <th>상수도-아이윈(㎥)</th>
                                                                            <th>상수도-말레(㎥)</th>
                                                                            <th>가스(㎥)</th>
                                                                            <th>전기(kWh)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            // meter_status.php에서 변경된 변수명($result_read_meter)을 사용합니다.
                                                                            // 또한, 더 안정적인 while 루프를 사용하여 결과를 표시합니다.
                                                                            if (isset($result_read_meter) && $result_read_meter) {
                                                                                while ($Data_ReadMeter = sqlsrv_fetch_array($result_read_meter, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr> 
                                                                            <td><?php echo $Data_ReadMeter['SORTING_DATE']->format("Y-m-d"); ?></td>  
                                                                            <td><?php echo $Data_ReadMeter['WATER_IWIN']; ?></td>  
                                                                            <td><?php echo $Data_ReadMeter['WATER_MALLE']; ?></td>   
                                                                            <td><?php echo $Data_ReadMeter['GAS']; ?></td>  
                                                                            <td><?php echo $Data_ReadMeter['ELECTRICITY']; ?></td>  
                                                                        </tr> 
                                                                        <?php 
                                                                                }
                                                                            }
                                                                        ?>       
                                                                    </tbody>
                                                                </table>                                     
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>
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
  //수도★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    
    // Get context with jQuery - using jQuery's .get() method.
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')

    var barChartData = {
        labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        datasets: [
        {
            label               : '<?php echo $YY?>년',
            backgroundColor     : 'rgba(75,112,221, 1)',
            borderColor         : 'rgba(75,112,221, 1)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(75,112,221, 1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(75,112,221, 1)',
            data                : [<?php echo $this_year_water_js; ?>]
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
          data                : [<?php echo $last_year_water_js; ?>]
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
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    }) 
  })

  //가스★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    
    // Get context with jQuery - using jQuery's .get() method.
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas2 = $('#barChart2').get(0).getContext('2d')

    var barChartData2 = {
      labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
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
          data                : [<?php echo $this_year_gas_js; ?>]
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
          data                : [<?php echo $last_year_gas_js; ?>]
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
      datasetFill             : false
    }

    new Chart(barChartCanvas2, {
      type: 'bar',
      data: barChartData2,
      options: barChartOptions
    }) 
  })

  //전기★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
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
      labels  : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
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
          data                : [<?php echo $this_year_electricity_js; ?>]
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
          data                : [<?php echo $last_year_electricity_js; ?>]
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
      datasetFill             : false
    }

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