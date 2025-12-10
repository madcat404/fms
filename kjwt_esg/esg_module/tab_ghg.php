<!-- 차트 - 합계 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                    <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample20" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample20">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">이산화탄소 환산량 합계</h1>
                                                        </a>
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

                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $Minus3YY; ?></th>
                                                                                <td><?php echo number_format(
                                                                                    ($threeYearsAgoOilCO2Sum ?? 0) + 
                                                                                    ($threeYearsAgoGasCO2Sum ?? 0) + 
                                                                                    ($threeYearsAgoTrashCO2Sum ?? 0) + 
                                                                                    ($threeYearsAgoElectricityCO2Sum ?? 0), 2); ?>
                                                                                </td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format(
                                                                                        ($threeYearsAgoOilCO2[$i] ?? 0) + 
                                                                                        ($threeYearsAgoGasCO2[$i] ?? 0) + 
                                                                                        ($threeYearsAgoTrashCO2[$i] ?? 0) + 
                                                                                        ($threeYearsAgoElectricityCO2[$i] ?? 0), 2); ?>
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
                                            <!-- 차트 - 이동연소 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                    <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">이동연소 이산화탄소 환산량</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#move_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#move_table" data-toggle="tab">표</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#move_table2" data-toggle="tab">표 - 사용량(휘발유)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#move_table3" data-toggle="tab">표 - 사용량(경유)</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#move_table4" data-toggle="tab">표 - 사용량(LPG)</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="move_chart" style="position: relative; height: 300px;">
                                                                    <canvas id="barChart1"></canvas>
                                                                </div>
                                                                <div class="chart tab-pane" id="move_table" style="position: relative; height: 300px;">
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
                                                                                <td><?php echo number_format($thisYearOilCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearOilCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($oneYearAgoOilCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($oneYearAgoOilCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoOilCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoOilCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoOilCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoOilCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="move_table2" style="position: relative; height: 300px;">
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
                                                                                <td><?php echo number_format($thisYearmonthlyOilSumTotal['휘발유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearmonthlyOilSum['휘발유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($oneYearAgomonthlyOilSumTotal['휘발유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($oneYearAgomonthlyOilSum['휘발유'][$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgomonthlyOilSumTotal['휘발유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgomonthlyOilSum['휘발유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>                                                                           
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgomonthlyOilSumTotal['휘발유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgomonthlyOilSum['휘발유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="move_table3" style="position: relative; height: 300px;">
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
                                                                                <td><?php echo number_format($thisYearmonthlyOilSumTotal['경유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearmonthlyOilSum['경유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($oneYearAgomonthlyOilSumTotal['경유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($oneYearAgomonthlyOilSum['경유'][$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgomonthlyOilSumTotal['경유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgomonthlyOilSum['경유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>                                                                            
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgomonthlyOilSumTotal['경유'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgomonthlyOilSum['경유'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="move_table4" style="position: relative; height: 300px;">
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
                                                                                <td><?php echo number_format($thisYearmonthlyOilSumTotal['LPG'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearmonthlyOilSum['LPG'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($oneYearAgomonthlyOilSumTotal['LPG'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($oneYearAgomonthlyOilSum['LPG'][$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgomonthlyOilSumTotal['LPG'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgomonthlyOilSum['LPG'][$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgomonthlyOilSumTotal['LPG'], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgomonthlyOilSum['LPG'][$i], 2); ?></td>
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
                                            <!-- 차트 - 도시가스(고정연소) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">도시가스(고정연소) 이산화탄소 환산량</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#gas_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#gas_table" data-toggle="tab">표</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#gas_table2" data-toggle="tab">표 - 사용량</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample22">                                    
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="gas_chart" style="position: relative; height: 300px;">
                                                                    <canvas id="barChart2"></canvas>
                                                                </div>
                                                                                                                                <div class="chart tab-pane" id="gas_table" style="position: relative; height: 300px;">
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
                                                                                <td><?php echo number_format($thisYearGasCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearGasCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearGasCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearGasCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoGasCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoGasCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoGasCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoGasCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="gas_table2" style="position: relative; height: 300px;">
                                                                    <P>- 단위: m3</P>
                                                                    <P>- 단위가 Nm3인 경우 m3*0.9869*0.9472 (표준온도와 표준압력을 사용)</P>
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
                                                                                <td><?php echo number_format($thisYearGasUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearGasUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearGasUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearGasUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoGasUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoGasUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoGasUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoGasUsageData[$i], 2); ?></td>
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
                                            <!-- 차트 - 전기 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">전기 이산화탄소 환산량</h6>
                                                    </a>
                                                    <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#elec_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#elec_table" data-toggle="tab">표</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#elec_table2" data-toggle="tab">표 - 사용량</a>
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
                                                                                <th scope="row"><?php echo $currentYear; ?></th>
                                                                                <td><?php echo number_format($thisYearElectricityCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearElectricityCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearElectricityCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearElectricityCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoElectricityCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoElectricityCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoElectricityCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoElectricityCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="elec_table2" style="position: relative; height: 300px;">
                                                                    <P>- 단위: Kwh</P>
                                                                    <P>- 단위가 Mwh인 경우 Kwh/1000</P>
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
                                                                                <td><?php echo number_format($thisYearElectricityUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearElectricityUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearElectricityUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearElectricityUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoElectricityUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoElectricityUsageData[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoElectricityUsageData[0], 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoElectricityUsageData[$i], 2); ?></td>
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
                                            <!-- 차트 - 폐기물 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">폐기물 이산화탄소 환산량</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#gar_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#gar_table" data-toggle="tab">표</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#gar_table2" data-toggle="tab">표 - 폐기량</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample23">                                    
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
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoTrashCO2Sum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoTrashCO2[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="chart tab-pane" id="gar_table2" style="position: relative; height: 300px;">
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
                                                                                <td><?php echo number_format($thisYearTrashSum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= date('n'); $i++): ?>
                                                                                    <td><?php echo number_format($thisYearTrash[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $previousYear; ?></th>
                                                                                <td><?php echo number_format($lastYearTrashSum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($lastYearTrash[$i], 2); ?></td>
                                                                                <?php endfor; ?> 
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $twoYearsAgo; ?></th>
                                                                                <td><?php echo number_format($twoYearsAgoTrashSum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($twoYearsAgoTrash[$i], 2); ?></td>
                                                                                <?php endfor; ?>
                                                                            </tr>
                                                                            <tr style="text-align: center;">
                                                                                <th scope="row"><?php echo $threeYearsAgo; ?></th>
                                                                                <td><?php echo number_format($threeYearsAgoTrashSum, 2); ?></td>
                                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                                    <td><?php echo number_format($threeYearsAgoTrash[$i], 2); ?></td>
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