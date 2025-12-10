<!-- Begin row -->
<div class="row"> 
    <div class="col-lg-12">                                                     
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-2">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample61t" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample61t">
                <h1 class="h6 m-0 font-weight-bold text-primary">#1. 매출</h6>
            </a>
            
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample61t">
                <div class="card-body table-responsive p-2">
                    <div class="row"> 
                        <!-- 차트 - 항목별(%) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-4"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-2">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample611t" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample711t">
                                    <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 항목별</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample611t">                                    
                                    <div class="card-body">
                                        <!-- Begin row -->
                                        <div class="row">    
                                            <div class="chart" style="height: 30vh; width: 100%;">
                                                <canvas id="donutChart"></canvas>
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
                        <!-- 차트 - 년도별(원) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-8"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-2">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample612t" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample612t">
                                    <h1 class="h6 m-0 font-weight-bold text-primary">#1-2. 년도별</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample612t">                                    
                                    <div class="card-body">
                                        <!-- Begin row -->
                                        <div class="row">    
                                            <div class="chart" style="height: 30vh; width: 100%;">
                                                <canvas id="lineChart"></canvas>
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
                        <!-- 차트 - 매출 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-2">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample613t" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample613t">
                                    <h1 class="h6 m-0 font-weight-bold text-primary">#1-3. 월 항목별 그래프</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample613t">                                    
                                    <div class="card-body">
                                        <!-- Begin row -->
                                        <div class="row">    
                                            <div class="chart" style="height: 30vh; width: 100%;">
                                                <canvas id="stackedBarChart"></canvas>
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
                        <!-- 차트 - 매출 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-2">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample614t" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample614t">
                                    <h1 class="h6 m-0 font-weight-bold text-primary">#1-4. 매출(원)</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample614t">                                    
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover text-nowrap">
                                                <thead align="center">
                                                    <tr>
                                                        <th></th> 
                                                        <th>년 실적</th> 
                                                        <th>월 실적</th> 
                                                        <th>일 실적</th> 
                                                    </tr> 
                                                </thead>
                                                <tbody align="right">
                                                    <?php
                                                    // 💡 1단계: 테이블에 표시할 항목의 순서를 배열로 정의합니다.
                                                    // 순서를 바꾸거나 항목을 추가/삭제할 때 이 배열만 수정하면 됩니다.
                                                    $salesKinds = ['히터', '발열핸들(열선)', '통풍(이원컴포텍)', '통풍', '통합ECU', '일반ECU', '기타', '합계'];

                                                    // 💡 2단계: 정의한 항목 배열을 순회하며 테이블 행(<tr>)을 동적으로 생성합니다.
                                                    foreach ($salesKinds as $kind):
                                                        // 백엔드에서 만든 $latestSalesByKind 배열에서 현재 항목의 데이터를 가져옵니다.
                                                        // 데이터가 없는 항목일 경우를 대비해 '?? []'로 안전하게 처리합니다.
                                                        $salesData = $latestSalesByKind[$kind] ?? [];
                                                    ?>
                                                        <tr>
                                                            <td align="center"><?php echo $kind; ?></td>
                                                            
                                                            <td><?php echo number_format($salesData['Y_MONEY'] ?? 0); ?></td>
                                                            <td><?php echo number_format($salesData['M_MONEY'] ?? 0); ?></td>
                                                            <td><?php echo number_format($salesData['D_MONEY'] ?? 0); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>    
                                        </div> 
                                        <!-- /.table-responsive -->      
                                    </div> 
                                    <!-- /.card-body -->              
                                </div>
                                <!-- /.Card Content - Collapse -->
                            </div>
                            <!-- /.card -->
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