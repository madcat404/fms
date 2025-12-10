<!-- Begin row -->
                                            <div class="row"> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample71t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample71t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 실패비용(<?php echo $YY; ?>년)</h6>
                                                        </a>

                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample71t">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <!-- 차트 - 실패비용 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample711t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample711t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 년도별 실패비용 그래프</h6>
                                                                            </a>
                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample711t">                                    
                                                                                <div class="card-body">
                                                                                    <!-- Begin row -->
                                                                                    <div class="row">    
                                                                                        <div class="chart" style="height: 30vh; width: 100%;">
                                                                                            <canvas id="barChart7"></canvas>                                                                                            
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
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card shadow mb-2">
                                                                            <a href="#collapseCardExample712t" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample712t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-2. 시트히터(원)</h1>
                                                                            </a>
                                                                            <div class="collapse show" id="collapseCardExample712t">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th rowspan="2"></th>
                                                                                                    <th colspan="3">한국 폐기</th>
                                                                                                    <th colspan="2">한국 리워크</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">베트남 폐기</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">중국 폐기</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">미국 폐기</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">슬로박 폐기</th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th>본사 스티칭</th>
                                                                                                    <th>본사 최종검사</th>
                                                                                                    <th>협력사 귀책</th>
                                                                                                    <th>본사</th>
                                                                                                    <th>B/B 베트남</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                            <?php
                                                                                                // ✅ 비즈니스 로직: 올해 실패비용이 작년보다 개선되었는지(작아졌는지) 확인
                                                                                                $isImproved = ($graphData[$currentYear]['시트히터'] ?? 0) < ($graphData[$previousYear]['시트히터'] ?? 0);
                                                                                                for ($month = 1; $month <= 13; $month++):
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td align="center"><?php echo ($month == 13) ? "합계" : $month . "월"; ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국폐기 본사 스티칭'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국폐기 본사 최종검사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국폐기 협력사귀책'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국리워크 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국리워크 BB베트남'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['베트남 폐기'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['중국 폐기'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['미국 폐기'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['슬로박 폐기'][$month] ?? 0); ?></td>
                                                                                                </tr>
                                                                                            <?php endfor; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card shadow mb-2">
                                                                            <a href="#collapseCardExample713t" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample713t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-3. 발열핸들(원)</h1>
                                                                            </a>
                                                                            <div class="collapse show" id="collapseCardExample713t">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th rowspan="2"></th>
                                                                                                    <th colspan="3">한국 폐기</th>
                                                                                                    <th colspan="2">한국 리워크</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">베트남 폐기</th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th>본사</th>
                                                                                                    <th>협력사 귀책</th>
                                                                                                    <th>B/B 베트남</th>
                                                                                                    <th>본사</th>
                                                                                                    <th>B/B 베트남</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                            <?php
                                                                                                // ✅ 핸들에 대한 비즈니스 로직 적용
                                                                                                $isImproved = ($graphData[$currentYear]['핸들'] ?? 0) < ($graphData[$previousYear]['핸들'] ?? 0);
                                                                                                for ($month = 1; $month <= 13; $month++):
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td align="center"><?php echo ($month == 13) ? "합계" : $month . "월"; ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국폐기 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국폐기 협력사귀책'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국폐기 BB베트남'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국리워크 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국리워크 BB베트남'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['베트남 폐기'][$month] ?? 0); ?></td>
                                                                                                </tr>
                                                                                            <?php endfor; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card shadow mb-2">
                                                                            <a href="#collapseCardExample714t" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample714t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-4. 통풍모듈(원)</h1>
                                                                            </a>
                                                                            <div class="collapse show" id="collapseCardExample714t">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th rowspan="2"></th>
                                                                                                    <th colspan="2">한국 폐기</th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th>본사</th>
                                                                                                    <th>협력사 귀책</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                            <?php
                                                                                                // ✅ 통풍에 대한 비즈니스 로직 적용
                                                                                                $isImproved = ($graphData[$currentYear]['통풍'] ?? 0) < ($graphData[$previousYear]['통풍'] ?? 0);
                                                                                                for ($month = 1; $month <= 13; $month++):
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td align="center"><?php echo ($month == 13) ? "합계" : $month . "월"; ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['통풍']['한국폐기 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['통풍']['한국폐기 협력사귀책'][$month] ?? 0); ?></td>
                                                                                                </tr>
                                                                                            <?php endfor; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                                            <!-- /.row -->  <!-- Begin row -->
                                            <div class="row"> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample71t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample71t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 실패비용(<?php echo $YY; ?>년)</h6>
                                                        </a>

                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample71t">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <!-- 차트 - 실패비용 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample711t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample711t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 년도별 실패비용 그래프</h6>
                                                                            </a>
                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample711t">                                    
                                                                                <div class="card-body">
                                                                                    <!-- Begin row -->
                                                                                    <div class="row">    
                                                                                        <div class="chart" style="height: 30vh; width: 100%;">
                                                                                            <canvas id="barChart7"></canvas>                                                                                            
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
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card shadow mb-2">
                                                                            <a href="#collapseCardExample712t" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample712t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-2. 시트히터(원)</h1>
                                                                            </a>
                                                                            <div class="collapse show" id="collapseCardExample712t">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th rowspan="2"></th>
                                                                                                    <th colspan="3">한국 폐기</th>
                                                                                                    <th colspan="2">한국 리워크</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">베트남 폐기</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">중국 폐기</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">미국 폐기</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">슬로박 폐기</th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th>본사 스티칭</th>
                                                                                                    <th>본사 최종검사</th>
                                                                                                    <th>협력사 귀책</th>
                                                                                                    <th>본사</th>
                                                                                                    <th>B/B 베트남</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                            <?php
                                                                                                // ✅ 비즈니스 로직: 올해 실패비용이 작년보다 개선되었는지(작아졌는지) 확인
                                                                                                $isImproved = ($graphData[$currentYear]['시트히터'] ?? 0) < ($graphData[$previousYear]['시트히터'] ?? 0);
                                                                                                for ($month = 1; $month <= 13; $month++):
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td align="center"><?php echo ($month == 13) ? "합계" : $month . "월"; ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국폐기 본사 스티칭'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국폐기 본사 최종검사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국폐기 협력사귀책'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국리워크 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['한국리워크 BB베트남'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['베트남 폐기'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['중국 폐기'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['미국 폐기'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['시트히터']['슬로박 폐기'][$month] ?? 0); ?></td>
                                                                                                </tr>
                                                                                            <?php endfor; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card shadow mb-2">
                                                                            <a href="#collapseCardExample713t" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample713t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-3. 발열핸들(원)</h1>
                                                                            </a>
                                                                            <div class="collapse show" id="collapseCardExample713t">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th rowspan="2"></th>
                                                                                                    <th colspan="3">한국 폐기</th>
                                                                                                    <th colspan="2">한국 리워크</th>
                                                                                                    <th rowspan="2" style="vertical-align: middle;">베트남 폐기</th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th>본사</th>
                                                                                                    <th>협력사 귀책</th>
                                                                                                    <th>B/B 베트남</th>
                                                                                                    <th>본사</th>
                                                                                                    <th>B/B 베트남</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                            <?php
                                                                                                // ✅ 핸들에 대한 비즈니스 로직 적용
                                                                                                $isImproved = ($graphData[$currentYear]['핸들'] ?? 0) < ($graphData[$previousYear]['핸들'] ?? 0);
                                                                                                for ($month = 1; $month <= 13; $month++):
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td align="center"><?php echo ($month == 13) ? "합계" : $month . "월"; ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국폐기 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국폐기 협력사귀책'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국폐기 BB베트남'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국리워크 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['한국리워크 BB베트남'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['핸들']['베트남 폐기'][$month] ?? 0); ?></td>
                                                                                                </tr>
                                                                                            <?php endfor; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="card shadow mb-2">
                                                                            <a href="#collapseCardExample714t" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample714t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-4. 통풍모듈(원)</h1>
                                                                            </a>
                                                                            <div class="collapse show" id="collapseCardExample714t">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th rowspan="2"></th>
                                                                                                    <th colspan="2">한국 폐기</th>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th>본사</th>
                                                                                                    <th>협력사 귀책</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                            <?php
                                                                                                // ✅ 통풍에 대한 비즈니스 로직 적용
                                                                                                $isImproved = ($graphData[$currentYear]['통풍'] ?? 0) < ($graphData[$previousYear]['통풍'] ?? 0);
                                                                                                for ($month = 1; $month <= 13; $month++):
                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td align="center"><?php echo ($month == 13) ? "합계" : $month . "월"; ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['통풍']['한국폐기 본사'][$month] ?? 0); ?></td>
                                                                                                    <td><?php echo number_format($monthlyData['통풍']['한국폐기 협력사귀책'][$month] ?? 0); ?></td>
                                                                                                </tr>
                                                                                            <?php endfor; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                                            <!-- /.row -->  