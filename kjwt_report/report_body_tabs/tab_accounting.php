<!-- Begin row -->
                                            <div class="row"> 
                                                <div class="col-lg-12"> 
                                                    <!-- Collapsable Card Example -->
                                                    <div class="card shadow mb-2">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample41t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample41t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 연결 재무제표 손익계산서 주항목</h6>
                                                        </a>
                                                        
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample41t">
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row"> 
                                                                    <!-- 차트 - 재무제표 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample411t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample411t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 년도별 그래프</h6>
                                                                            </a>
                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample411t">                                    
                                                                                <div class="card-body">
                                                                                    <!-- Begin row -->
                                                                                    <div class="row">    
                                                                                        <div class="chart" style="height: 30vh; width: 100%;">
                                                                                            <canvas id="barChart6"></canvas>
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
                                                                    <!-- 재무제표 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                                                    <div class="col-lg-12"> 
                                                                        <!-- Collapsable Card Example -->
                                                                        <div class="card shadow mb-2">
                                                                            <!-- Card Header - Accordion -->
                                                                            <a href="#collapseCardExample412t" class="d-block card-header py-3" data-toggle="collapse"
                                                                                role="button" aria-expanded="true" aria-controls="collapseCardExample412t">
                                                                                <h1 class="h6 m-0 font-weight-bold text-primary">#1-2. 연결 재무제표 주항목(원)</h6>
                                                                            </a>

                                                                            <!-- Card Content - Collapse -->
                                                                            <div class="collapse show" id="collapseCardExample412t">                                    
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover text-nowrap">
                                                                                            <thead align="center">
                                                                                                <tr>
                                                                                                    <th></th>
                                                                                                    <?php
                                                                                                    // 💡 (수정!) array_reverse() 제거하여 최신순으로 정렬
                                                                                                    foreach ($years as $year) {
                                                                                                        echo '<th>' . ($financialData[$year]['매출액']['thstrm_nm'] ?? $year . '년') . '</th>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody align="right">
                                                                                                <?php
                                                                                                // 테이블에 표시할 계정 항목 순서
                                                                                                $financeAccountOrder = ['매출액', '매출원가', '판매비와관리비', '영업외이익(손실)', '당기순이익'];

                                                                                                foreach ($financeAccountOrder as $accountName):
                                                                                                ?>
                                                                                                    <tr>
                                                                                                        <td align="center"><?php echo $accountName; ?></td>
                                                                                                        <?php
                                                                                                        // 💡 (수정!) 여기도 동일하게 array_reverse() 제거
                                                                                                        foreach ($years as $year) {
                                                                                                            $amount = $financialData[$year][$accountName]['thstrm_amount'] ?? 0;
                                                                                                            echo '<td>' . number_format($amount) . '</td>';
                                                                                                        }
                                                                                                        ?>
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