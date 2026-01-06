<!-- Begin row -->
<div class="row"> 
    <div class="col-lg-12"> 
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-2">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample10t" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample10t">
                <h1 class="h6 m-0 font-weight-bold text-primary">#1. 베트남 경영</h6>
            </a>

            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample10t">
                <div class="card-body">
                    <!-- 차트 - 사무직 인원증감 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                    <div class="col-lg-12"> 
                        <!-- Collapsable Card Example -->
                        <div class="card shadow mb-2 mt-2">
                            <div class="card-header">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample101t" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample101t">
                                    <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 인원</h6>
                                </a>
                                <div class="card-tools mt-3">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#vietnam_chart" data-toggle="tab">인원(그래프)</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#vietnam_number" data-toggle="tab">인원(표)</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" id="collapseCardExample101t">                                    
                                <div class="card-body">
                                    <div class="tab-content p-0">  
                                        <div class="chart tab-pane active" id="vietnam_chart" style="position: relative; height: 300px;">
                                            <canvas id="barChartV1"></canvas> 
                                        </div>
                                        <div class="chart tab-pane" id="vietnam_number" style="position: relative;">
                                            <table class="table">
                                                <thead>
                                                    <tr style="text-align: center;">
                                                        <th scope="col">#</th>
                                                        <th scope="col">합계</th>
                                                        <th scope="col">생산야간(아이윈)</th>
                                                        <th scope="col">생산야간(파트타임)</th>
                                                        <th scope="col">생산주간(아이윈)</th>
                                                        <th scope="col">생산주간(파트타임)</th>
                                                        <th scope="col">사무직</th>
                                                        <th scope="col">기타(기숙사, 식당, 기사, 청소, 정원)</th>
                                                        <th scope="col">육아휴직</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // 금년 데이터 출력 (1월 ~ 12월)
                                                    for ($month = 1; $month <= 12; $month++) :
                                                        $data = $thisYearData[$month];
                                                        $yearMonthStr = $yyyy . sprintf('%02d', $month);
                                                    ?>
                                                    <tr style="text-align: center;">
                                                        <th scope="row"><?php echo $yearMonthStr; ?></th>
                                                        <td><?php echo $thisYearVietnamTotals[$month] ?: ''; // 합계가 0이면 빈 칸으로 표시 ?></td>
                                                        <td><?php echo $data['night_iwin']; ?></td>
                                                        <td><?php echo $data['night_part']; ?></td>
                                                        <td><?php echo $data['morning_iwin']; ?></td>
                                                        <td><?php echo $data['morning_part']; ?></td>
                                                        <td><?php echo $data['morning_office']; ?></td>
                                                        <td><?php echo $data['morning_etc']; ?></td>
                                                        <td><?php echo $data['vacation_baby']; ?></td>
                                                    </tr>
                                                    <?php endfor; ?>
                                                    
                                                    <?php
                                                    // 작년 데이터 출력 (1월 ~ 12월)
                                                    for ($month = 1; $month <= 12; $month++) :
                                                        $data = $lastYearData[$month];
                                                        $yearMonthStr = $b_yyyy . sprintf('%02d', $month);
                                                    ?>
                                                    <tr style="text-align: center;">
                                                        <th scope="row"><?php echo $yearMonthStr; ?></th>
                                                        <td><?php echo $lastYearVietnamTotals[$month] ?: ''; // 합계가 0이면 빈 칸으로 표시 ?></td>
                                                        <td><?php echo $data['night_iwin']; ?></td>
                                                        <td><?php echo $data['night_part']; ?></td>
                                                        <td><?php echo $data['morning_iwin']; ?></td>
                                                        <td><?php echo $data['morning_part']; ?></td>
                                                        <td><?php echo $data['morning_office']; ?></td>
                                                        <td><?php echo $data['morning_etc']; ?></td>
                                                        <td><?php echo $data['vacation_baby']; ?></td>
                                                    </tr>
                                                    <?php endfor; ?>                                                                                             
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
                </div>
                <!-- /.card-body -->                                                      
            </div>    
            <!-- /.Card Content - Collapse -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row --> 