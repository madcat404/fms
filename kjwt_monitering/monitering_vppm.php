<?php 
  // =============================================
  // Author: <KWON SUNG KUN - sealclear@naver.com>	
  // Create date: <21.11.23>
  // Description:	<베트남 DPMO>		
  // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
  // =============================================
  include 'pu_vppm_status.php';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>    

    <!-- Google Charts Loader -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- 차트 스크립트 -->
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawAllCharts);

        function drawAllCharts() {
            drawDailyChart();
            drawWeeklyChart();
        }

        // 1. 일별 차트 그리기
        function drawDailyChart() {
            var chartData = <?php echo json_encode($dailyData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

            var data = new google.visualization.DataTable();
            data.addColumn('string', '날짜');
            data.addColumn('number', '불량율 (PPM)');
            data.addColumn('number', '목표 불량율 (PPM)');
            data.addColumn('number', '검사수량 (K PCS)');
            data.addRows(chartData);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 
                1, { calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 
                2, { calc: "stringify", sourceColumn: 2, type: "string", role: "annotation" },
                3, { calc: "stringify", sourceColumn: 3, type: "string", role: "annotation" }
            ]);

            var options = {
                seriesType: 'bars',
                series: {0: {type: 'bar'}, 1: {type: 'line'}, 2: {type: 'line'}},
                chartArea: {left: 50, top: 30, width: '85%', height: '70%'},
                legend: {position: 'top', maxLines: 3, alignment: 'center'},
                chart: {
                    title: '베트남 공장 바이벡 DPMO'
                }
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_daily'));
            chart.draw(view, options);
        }

        // 2. 주차별 차트 그리기
        function drawWeeklyChart() {
            var chartData = <?php echo json_encode($weeklyData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

            var data = new google.visualization.DataTable();
            data.addColumn('string', '주차');
            data.addColumn('number', '불량율 (PPM)');
            data.addColumn('number', '목표 불량율 (PPM)');
            data.addColumn('number', '검사수량 (K PCS)');
            data.addRows(chartData);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 
                1, { calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 
                2, { calc: "stringify", sourceColumn: 2, type: "string", role: "annotation" },
                3, { calc: "stringify", sourceColumn: 3, type: "string", role: "annotation" }
            ]);

            var options = {
                seriesType: 'bars',
                series: {0: {type: 'bar'}, 1: {type: 'line'}, 2: {type: 'line'}},
                chartArea: {left: 50, top: 30, width: '85%', height: '70%'},
                legend: {position: 'top', maxLines: 3, alignment: 'center'},
                chart: {
                    title: '베트남 공장 바이벡 DPMO'
                }
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_weekly'));
            chart.draw(view, options);
        }

        // 창 크기 변경 시 차트 다시 그리기
        window.addEventListener('resize', drawAllCharts, false);

    </script>
</head>
  
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">   
    <!-- 메뉴 -->
    <?php include '../nav.php' ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>   
            <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">베트남 DPMO</h1>
          </div>               

          <!-- Begin row -->
          <div class="row"> 
            <div class="col-lg-12"> 
              <!-- Collapsable Card Example -->
              <div class="card shadow mb-4">
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
                        - 베트남 DPMO 시각화<BR><BR>   
                                                     
                        [참조]<BR>
                        - 요청자: 정연동BJ<br>
                        - 사용자: 품질팀<br>
                        - DPMO란? Defects Per Million Opportunities의 약자로, 기회 백만 개당 결함 수를 의미<br>
                        - ERP 데이터를 기반으로 제작됨<br><br> 
                        
                        [제작일]<BR>
                        - 21.11.23<br><br>                                        
                      </p> 
                    </div>
                     <!-- /.card-body -->
                  </div>
                  <!-- /.Card Content - Collapse -->
              </div>
              <!-- /.card -->
            </div>  

            <!-- 일별 차트 -->
            <div class="col-lg-6">
              <div class="card shadow mb-2">
                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                  <h6 class="m-0 font-weight-bold text-primary">일별</h6>
                </a>
                <div class="collapse show" id="collapseCardExample31">
                  <div class="card-body">
                    <div id="chart_daily" style="width: 100%; height: 400px;"></div>
                  </div>
                </div>
              </div>
            </div>
                        
            <!-- 주별 차트 -->
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                  role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                  <h6 class="m-0 font-weight-bold text-primary">주별</h6>
                </a>
                <div class="collapse show" id="collapseCardExample32">
                  <div class="card-body">
                    <div id="chart_weekly" style="width: 100%; height: 400px;"></div>
                  </div>
                </div>
              </div>
            </div> 

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

  <!-- Bootstrap core JavaScript-->
  <?php include '../plugin_lv1.php'; ?>

</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) {
        mysqli_close($connect4);
    }

    //MSSQL 메모리 회수
    if(isset($connect)) { 
        sqlsrv_close($connect); 
    }
?>
