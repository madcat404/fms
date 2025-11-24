<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.05.24>
	// Description:	<연차정보 제공 (View)>
  // Last Modified: <25.10.01> - Refactored for PHP 8.x and security.
	// =============================================
  require_once 'gw_attend_status.php';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
      /* Center align google chart table cells and set text color to black */
      .google-visualization-table-td {
        text-align: center !important;
        color: black !important;
      }
      /* Set default card body text to black */
      .card-body, .card-body p {
        color: black;
      }
    </style>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table', 'corechart']});
      google.charts.setOnLoadCallback(drawAllCharts);

      function drawAllCharts() {
        drawSummaryTable();
        drawDetailTable();
        drawRatioChart1();
        drawRatioChart4();
        drawRatioChart5();
        drawLeaveTable('annual', 'attend1', 'emp_list_display1', '※연차:');
        drawLeaveTable('official', 'attend2');
        drawLeaveTable('training', 'attend3');
        drawLeaveTable('early_leave', 'attend4');
        drawLeaveTable('business_trip', 'attend5', 'emp_list_display5', '※출장:');
        drawLeaveTable('outside_work', 'attend6');
        drawLeaveTable('yesterday_leave', 'attend8');
        drawLeaveTable('yesterday_early', 'attend7', 'emp_list_display7', '※전일 조퇴/외출:');
      }

      function drawSummaryTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '구분');
        data.addColumn('string', '총원(남자+여자)');
        data.addColumn('number', '해외파견/운전기사');
        data.addColumn('number', '현장 도급직 결근');
        data.addColumn('number', '연차');
        data.addColumn('number', '공가');
        data.addColumn('number', '교육/훈련');
        data.addColumn('number', '출장');
        data.addColumn('number', '휴직');
        data.addColumn('number', '현재원');        
        
        <?php 
          $managed_leave_total = ($attendance_data['leave_counts']['managed_annual'] ?? 0) - ($attendance_data['leave_counts']['contract_annual'] ?? 0);
          $managed_official_total = ($attendance_data['leave_counts']['managed_official'] ?? 0) - ($attendance_data['leave_counts']['contract_official'] ?? 0);
          $managed_training_total = ($attendance_data['leave_counts']['managed_training'] ?? 0) - ($attendance_data['leave_counts']['contract_training'] ?? 0);
          $managed_trip_total = ($attendance_data['leave_counts']['managed_business_trip'] ?? 0) - ($attendance_data['leave_counts']['contract_business_trip'] ?? 0);
          $managed_current = ($attendance_data['summary']['managed']['total'] ?? 0) - ($attendance_data['summary']['managed']['dispatch'] ?? 0) - ($managed_leave_total + $managed_official_total + $managed_training_total + $managed_trip_total) - 1; // 1 for 휴직
          
          $contract_leave_total = ($attendance_data['leave_counts']['contract_annual'] ?? 0) + ($attendance_data['leave_counts']['contract_official'] ?? 0) + ($attendance_data['leave_counts']['contract_training'] ?? 0) + ($attendance_data['leave_counts']['contract_business_trip'] ?? 0);
          $contract_current = ($attendance_data['summary']['contract']['total'] ?? 0) - ($attendance_data['summary']['contract']['absent'] ?? 0) - $contract_leave_total;
        ?>

        data.addRow(['관리직', 
          '<?php echo ($attendance_data['summary']['managed']['total'] ?? 0) . " (" . ($attendance_data['summary']['managed']['male'] ?? 0) . "+" . ($attendance_data['summary']['managed']['female'] ?? 0) . ")"?>', 
          <?php echo $attendance_data['summary']['managed']['dispatch'] ?? 0; ?>, 0, 
          <?php echo $managed_leave_total; ?>, 
          <?php echo $managed_official_total; ?>, 
          <?php echo $managed_training_total; ?>, 
          <?php echo $managed_trip_total; ?>, 
          1, <?php echo $managed_current; ?>]);
        data.addRow(['도급직(퍼스트인)', 
          '<?php echo ($attendance_data['summary']['contract']['total'] ?? 0) . " (" . ($attendance_data['summary']['contract']['male'] ?? 0) . "+" . ($attendance_data['summary']['contract']['female'] ?? 0) . ")"?>', 
          0, <?php echo $attendance_data['summary']['contract']['absent'] ?? 0; ?>, 
          <?php echo $attendance_data['leave_counts']['contract_annual'] ?? 0; ?>, 
          <?php echo $attendance_data['leave_counts']['contract_official'] ?? 0; ?>, 
          <?php echo $attendance_data['leave_counts']['contract_training'] ?? 0; ?>, 
          <?php echo $attendance_data['leave_counts']['contract_business_trip'] ?? 0; ?>, 
          0, <?php echo $contract_current; ?>]);
        data.addRow(['합계', 
          '<?php echo (($attendance_data['summary']['managed']['total'] ?? 0) + ($attendance_data['summary']['contract']['total'] ?? 0)) . " (" . (($attendance_data['summary']['managed']['male'] ?? 0) + ($attendance_data['summary']['contract']['male'] ?? 0)) . "+" . (($attendance_data['summary']['managed']['female'] ?? 0) + ($attendance_data['summary']['contract']['female'] ?? 0)) . ")"?>',
          <?php echo $attendance_data['summary']['managed']['dispatch'] ?? 0; ?>,
          <?php echo $attendance_data['summary']['contract']['absent'] ?? 0; ?>,
          <?php echo ($attendance_data['leave_counts']['managed_annual'] ?? 0) + ($attendance_data['leave_counts']['contract_annual'] ?? 0); ?>,
          <?php echo ($attendance_data['leave_counts']['managed_official'] ?? 0) + ($attendance_data['leave_counts']['contract_official'] ?? 0); ?>,
          <?php echo ($attendance_data['leave_counts']['managed_training'] ?? 0) + ($attendance_data['leave_counts']['contract_training'] ?? 0); ?>,
          <?php echo ($attendance_data['leave_counts']['managed_business_trip'] ?? 0) + ($attendance_data['leave_counts']['contract_business_trip'] ?? 0); ?>,
          1, <?php echo $managed_current + $contract_current; ?>]);
        
        var table = new google.visualization.Table(document.getElementById('detail'));
        table.draw(data, {width: '100%', height: '100%', allowHtml: true});
      }

      function drawDetailTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '구분');
        data.addColumn('number', '총원');
        data.addColumn('number', '생산');
        data.addColumn('number', '미화');
        data.addColumn('number', '경비');
        data.addColumn('number', '창고/공무/사무');  

        data.addRow(['퍼스트인', <?php echo $attendance_data['details']['firstin_total'] ?? 0; ?>, <?php echo $attendance_data['details']['firstin_prod'] ?? 0; ?>, 0, 0, 0]);
        data.addRow(['퍼스트인코리아', <?php echo $attendance_data['details']['firstinkorea_total'] ?? 0; ?>, 0, <?php echo $attendance_data['details']['firstinkorea_cleaning'] ?? 0; ?>, <?php echo $attendance_data['details']['firstinkorea_security'] ?? 0; ?>, <?php echo $attendance_data['details']['firstinkorea_other'] ?? 0; ?>]);
        data.addRow(['합계', 
          <?php echo ($attendance_data['details']['firstin_total'] ?? 0) + ($attendance_data['details']['firstinkorea_total'] ?? 0); ?>, 
          <?php echo $attendance_data['details']['firstin_prod'] ?? 0; ?>, 
          <?php echo $attendance_data['details']['firstinkorea_cleaning'] ?? 0; ?>, 
          <?php echo $attendance_data['details']['firstinkorea_security'] ?? 0; ?>, 
          <?php echo $attendance_data['details']['firstinkorea_other'] ?? 0; ?>]);
                    
        var table = new google.visualization.Table(document.getElementById('detai2'));
        table.draw(data, {width: '100%', height: '100%', allowHtml: true});       
      }

      function drawRatioChart1() {
        var data = new google.visualization.DataTable();
        data.addColumn('string','구분');
        data.addColumn('number','비중'); 
        data.addRows([ 
          ['관리직', <?php echo $attendance_data['summary']['managed']['total'] ?? 0; ?>],
          ['도급직', <?php echo $attendance_data['summary']['contract']['total'] ?? 0; ?>]
        ]);
        var options = { chartArea: {width: '100%', height: '75%'}, legend: {position: 'top', alignment: 'center'} };
        var chart = new google.visualization.PieChart(document.getElementById('chart1'));
        chart.draw(data, options);
        window.addEventListener('resize', drawRatioChart1, false);
      }

      function drawRatioChart4() {
        var data = new google.visualization.DataTable();
        data.addColumn('string','구분');
        data.addColumn('number','비중'); 
        data.addRows([ 
          ['관리직', <?php echo $attendance_data['summary']['managed']['total'] ?? 0; ?>],
          ['퍼스트인', <?php echo $attendance_data['details']['firstin_total'] ?? 0; ?>],
          ['퍼스트인 코리아', <?php echo $attendance_data['details']['firstinkorea_total'] ?? 0; ?>]
        ]);
        var options = { chartArea: {width: '100%', height: '75%'}, legend: {position: 'top', alignment: 'center'} };
        var chart = new google.visualization.PieChart(document.getElementById('chart4'));
        chart.draw(data, options);
        window.addEventListener('resize', drawRatioChart4, false);
      }

      function drawRatioChart5() {
        var data = new google.visualization.DataTable();
        data.addColumn('string','구분');
        data.addColumn('number','비중'); 
        data.addRows([ 
          ['남', <?php echo ($attendance_data['summary']['managed']['male'] ?? 0) + ($attendance_data['summary']['contract']['male'] ?? 0); ?>],
          ['여', <?php echo ($attendance_data['summary']['managed']['female'] ?? 0) + ($attendance_data['summary']['contract']['female'] ?? 0); ?>]
        ]);
        var options = { chartArea: {width: '100%', height: '75%'}, legend: {position: 'top', alignment: 'center'} };
        var chart = new google.visualization.PieChart(document.getElementById('chart5'));
        chart.draw(data, options);
        window.addEventListener('resize', drawRatioChart5, false);
      }

      function drawLeaveTable(leaveType, elementId, displayId = null, displayText = null) {
        var leaveData = <?php echo json_encode($attendance_data['leave_details'] ?? []); ?>;
        var rows = leaveData[leaveType];
        if (!rows || rows.length === 0) return;

        var data = new google.visualization.DataTable();
        data.addColumn('string', '이름');
        data.addColumn('string', '부서');
        data.addColumn('number', '신청일수');
        if (['annual', 'early_leave', 'yesterday_early', 'yesterday_leave'].includes(leaveType)) {
          data.addColumn('number', '연차차감');
        }
        data.addColumn('string', '시작일');
        data.addColumn('string', '종료일');
        data.addColumn('string', '제목');
        data.addColumn('string', '비고');
        
        var empNames = [];
        for (var i = 0; i < rows.length; i++) {
          var rowData = rows[i];
          var row = [rowData.emp_name, rowData.dept_name, parseFloat(rowData.day_cnt)];
          if (['annual', 'early_leave', 'yesterday_early', 'yesterday_leave'].includes(leaveType)) {
            row.push(parseFloat(rowData.annv_use_day_cnt));
          }

          var titleCell = rowData.title;
          if (rowData.doc_id) {
            var url = `https://gw.iwin.kr/eap/ea/docpop/EAAppDocViewPop.do?doc_id=${rowData.doc_id}&form_id=18`;
            titleCell = `<a href="${url}" target="_blank">${rowData.title}</a>`;
          }
          
          row.push(rowData.start_dt, rowData.end_dt, titleCell, rowData.remark);
          data.addRow(row);
          if (displayId) empNames.push(rowData.emp_name);
        }

        var table = new google.visualization.Table(document.getElementById(elementId));
        table.draw(data, {width: '100%', height: '100%', allowHtml: true});

        if (displayId && displayText) {
          document.getElementById(displayId).innerHTML = "<b>" + displayText + "</b> " + empNames.join(', ');
        }
      }
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
            <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">근태현황</h1>
          </div>               

          <!-- Begin row -->
          <div class="row"> 
            <div class="col-lg-12"> 
              <div class="card shadow mb-4">
                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">
                  <h6 class="m-0 font-weight-bold text-primary">공지</h6>
                </a>
                  <div class="collapse" id="collapseCardExample1">
                    <div class="card-body">
                      <p>
                      [목표]<BR>
                      - 근태현황 취합 자동화<BR><BR>    
                      
                      [히스토리]<BR>
                      25.08.07)<BR>
                      - 일일업무보고 엑셀파일에 이름을 일일이 KEY-IN을 하는 시간소모를 줄이기 위해 이름을 1열로 나열하는 기능을 추가하였음<BR>
                                                            
                      [참조]<BR>
                      - 요청자: 권성근 개인 프로젝트<br>
                      - 사용자: 경영팀<br>
                      ※휴직은 수동으로 입력해야 합니다. (변경사항이 발생하면 말해주세요!)<BR>                                     
                      ※세콤에서 퇴사자 등록 시 다음일에 반영되므로 요약-도급직 총원과 도급직 세부의 총원이 차이날 수 있음<BR>
                      ※세콤매니저(근태식당) 프로그램에서 퇴사자 조직과 근무형태 모두 퇴사로 변경해야 함<BR>
                      ※요약의 관리직 총원은 세콤매니저(근태.식당)프로그램에서 사원등록의 보유카드목록에 데이터가 있어야 카운트 된다<BR><br>
                              
                      [제작일]<BR>
                      - 21.05.24<br><br>  
                      </p> 
                    </div>
                  </div>
              </div>
            </div>  

            <div class="col-lg-12"> 
              <div class="card shadow mb-4">
                <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                  <h6 class="m-0 font-weight-bold text-primary">조회</h6>
                </a>
                  <div class="collapse show" id="collapseCardExample2">
                    <div class="card-body">
                      
                      <!-- Merged Content Starts Here -->
                      <p style="text-align: left; font-weight: bold;">[요약]</p>
                      <div id="detail"></div><br><br>

                      <div style="display: flex; justify-content: space-around; text-align: center;">
                        <div style="width: 33%;">
                          <p style="font-weight: bold;">[관리직&도급직 비율]</p>
                          <div id="chart1"></div>
                        </div>
                        <div style="width: 33%;">
                          <p style="font-weight: bold;">[관리직&도급직 세부 비율]</p>
                          <div id="chart4"></div>
                        </div>
                        <div style="width: 33%;">
                          <p style="font-weight: bold;">[남/여 비율]</p>
                          <div id="chart5"></div>
                        </div>
                      </div><br><br>
                      
                      <p style="text-align: left; font-weight: bold;">[도급직 세부]</p>
                      <div id="detai2"></div><br><br>
                      
                      <?php if(!empty($attendance_data['leave_details']['annual'])): ?>
                        <p style="text-align: left; font-weight: bold;">[연차]</p>
                        <div id="attend1"></div>
                        <div id="emp_list_display1" style="margin-top: 10px; font-size: 12px; text-align: left;"></div><br><br>
                      <?php endif; ?>
                      
                      <?php if(!empty($attendance_data['leave_details']['official'])): ?>
                        <p style="text-align: left; font-weight: bold;">[공가]</p>
                        <div id="attend2"></div><br><br>
                      <?php endif; ?>

                      <?php if(!empty($attendance_data['leave_details']['training'])): ?>
                        <p style="text-align: left; font-weight: bold;">[교육/훈련]</p>
                        <div id="attend3"></div><br><br>
                      <?php endif; ?>

                      <?php if(!empty($attendance_data['leave_details']['early_leave'])): ?>
                        <p style="text-align: left; font-weight: bold;">[조퇴/외출]</p>
                        <div id="attend4"></div><br><br>
                      <?php endif; ?>

                      <?php if(!empty($attendance_data['leave_details']['business_trip'])): ?>
                        <p style="text-align: left; font-weight: bold;">[출장]</p>
                        <div id="attend5"></div>
                        <div id="emp_list_display5" style="margin-top: 10px; font-size: 12px; text-align: left;"></div><br><br>
                      <?php endif; ?>

                      <?php if(!empty($attendance_data['leave_details']['outside_work'])): ?>
                        <p style="text-align: left; font-weight: bold;">[외근]</p>
                        <div id="attend6"></div><br><br> 
                      <?php endif; ?>

                      <?php if(!empty($attendance_data['leave_details']['yesterday_leave'])): ?>
                        <p style="text-align: left; font-weight: bold;">[전일 연차/공가]</p>
                        <div id="attend8"></div><br><br>  
                      <?php endif; ?>

                      <?php if(!empty($attendance_data['leave_details']['yesterday_early'])): ?>
                        <p style="text-align: left; font-weight: bold;">[전일 조퇴/외출]</p>
                        <div id="attend7"></div>
                        <div id="emp_list_display7" style="margin-top: 10px; font-size: 12px; text-align: left;"></div><br><br>
                      <?php endif; ?>

                      <?php if(!empty($attendance_data['absentees'])): ?>
                        <p style="text-align: left; font-weight: bold;">[현장 도급직 결근]</p>
                        <div style="text-align: left;">&nbsp;&nbsp;
                          <?php echo implode(', ', $attendance_data['absentees']); ?>
                        </div><br><br> 
                      <?php endif; ?>
                      <!-- Merged Content Ends Here -->

                    </div>
                  </div>
              </div>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <?php include '../plugin_lv1.php'; ?>

</body>
</html>