<!-- 차트 - 사무직 인원증감 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-2 mt-2">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample50t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample50t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#1. 운반비</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#deli_chart" data-toggle="tab">차트</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#deli_table" data-toggle="tab">표</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample50t">                                    
                                                        <div class="card-body">
                                                            <!-- Begin row -->
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="deli_chart" style="position: relative; height: 300px;">                                                                                                                                                                        
                                                                    <canvas id="barChart8"></canvas>                                                                    
                                                                </div>
                                                                <div class="chart tab-pane" id="deli_table" style="position: relative;">
                                                                    <div class="table-responsive">  
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr style="text-align: center;">
                                                                                    <th scope="col">#</th>
                                                                                    <th scope="col">합계</th>
                                                                                    <?php
                                                                                    // 💡 1단계: 1월부터 12월까지의 헤더를 for문으로 생성
                                                                                    for ($month = 1; $month <= 12; $month++) {
                                                                                        echo "<th scope='col'>{$month}월</th>";
                                                                                    }
                                                                                    ?>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                // 💡 2단계: 올해와 작년 데이터를 하나의 배열로 묶어 처리
                                                                                $deliveryTableData = [
                                                                                    [
                                                                                        'label' => $currentYear, // $YY 대신 명확한 변수 사용 권장
                                                                                        'totalVar' => $Data_ThisYearFee0,
                                                                                        'monthlyPrefix' => 'Data_ThisYearFee'
                                                                                    ],
                                                                                    [
                                                                                        'label' => $previousYear, // $Minus1YY 대신 명확한 변수 사용 권장
                                                                                        'totalVar' => $Data_LastYearFee0,
                                                                                        'monthlyPrefix' => 'Data_LastYearFee'
                                                                                    ]
                                                                                ];

                                                                                // 💡 3단계: 묶은 데이터를 foreach문으로 돌면서 행(<tr>) 생성
                                                                                foreach ($deliveryTableData as $rowData) :
                                                                                ?>
                                                                                    <tr style="text-align: center;">
                                                                                        <th scope="row"><?php echo $rowData['label']; ?></th>
                                                                                        
                                                                                        <td><?php echo number_format($rowData['totalVar']['DELIVERY'] ?? 0); ?></td>

                                                                                        <?php
                                                                                        // 💡 4단계: 안쪽 for문으로 12개월치 운반비(DELIVERY)를 동적으로 생성
                                                                                        for ($month = 1; $month <= 12; $month++) {
                                                                                            $variableName = $rowData['monthlyPrefix'] . $month;
                                                                                            $deliveryValue = ${$variableName}['DELIVERY'] ?? 0;
                                                                                            echo '<td>' . number_format($deliveryValue) . '</td>';
                                                                                        }
                                                                                        ?>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
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

                                            <div class="col-lg-12">
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-2">
                                                    <div class="card-header">
                                                        <!-- Card Header - Accordion -->
                                                        <a href="#collapseCardExample51t" class="d-block card-header py-3" data-toggle="collapse"
                                                            role="button" aria-expanded="true" aria-controls="collapseCardExample51t">
                                                            <h1 class="h6 m-0 font-weight-bold text-primary">#2. 운송</h6>
                                                        </a>
                                                        <div class="card-tools mt-3">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" href="#delivery" data-toggle="tab">운송중</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="#complete" data-toggle="tab">운송완료</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample51t">        
                                                        <div class="card-body">
                                                            <div class="tab-content p-0">  
                                                                <div class="chart tab-pane active" id="delivery" style="position: relative;">   
                                                                    <div class="table-responsive">                                                                   
                                                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                                                            <thead align="center">
                                                                                <tr>
                                                                                    <th>출발&nbsp;<i class="fas fa-arrow-right"></i>&nbsp;도착</th>
                                                                                    <th>운송방식</th>  
                                                                                    <th>B/L</th>
                                                                                    <th>작업일</th>
                                                                                    <th>출항</th>
                                                                                    <th>입항</th>
                                                                                    <th>출항딜레이</th>    
                                                                                    <th>선박이름</th>                                             
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody align="center">
                                                                                <?php 
                                                                                // 국가 코드와 이미지 파일명을 매핑
                                                                                $flagImages = ['V' => 'flag_v.png', 'K' => 'flag_k.png', 'S' => 'flag_s.png', 'C' => 'flag_c.png', 'U' => 'flag_a.png'];

                                                                                // [개선] '$data_in_transit' 배열을 순회하며 데이터 출력
                                                                                foreach ($data_in_transit as $item): 
                                                                                ?>
                                                                                    <tr>
                                                                                        <td style="width: 30%;">
                                                                                            <img src="../img/<?php echo $flagImages[$item['s_country']] ?? ''; ?>" width="60em">
                                                                                            &nbsp;<i class="fas fa-arrow-right"></i>&nbsp;
                                                                                            <img src="../img/<?php echo $flagImages[$item['e_country']] ?? ''; ?>" width="60em">
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php if($item['kind'] == "해상"): ?>
                                                                                                <i class="fas fa-ship fa-2x"></i>
                                                                                            <?php elseif($item['kind'] == "항공"): ?>
                                                                                                <i class="fas fa-plane fa-2x"></i>
                                                                                            <?php endif; ?>
                                                                                        </td>
                                                                                        <td><a href=".../report_export_detail.php?bl=<?php echo $item['bl']; ?>" target="_blank"><?php echo $item['bl']; ?></a></td>
                                                                                        <td><?php echo $item['invoice_dt']; ?></td>
                                                                                        <td><?php echo $item['etd']; ?></td>
                                                                                        <td><?php echo $item['eta']; ?></td>
                                                                                        <td><?php echo $item['delay']; ?></td>
                                                                                        <td>
                                                                                            <?php // [개선] 루프 안에서 DB 쿼리 제거! 이미 가져온 'imo' 값을 사용
                                                                                            if (!empty($item['imo'])): ?>
                                                                                                <a href="https://www.vesselfinder.com/?imo=<?php echo $item['imo']; ?>" target="_blank"><?php echo $item['vessel']; ?></a>
                                                                                            <?php else: ?>
                                                                                                <?php echo $item['vessel']; ?>
                                                                                            <?php endif; ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>                                                                                                                            
                                                                    </div>
                                                                </div>
                                                                <div class="chart tab-pane" id="complete" style="position: relative;">    
                                                                    <div class="table-responsive">                                                            
                                                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                                                            <thead align="center">
                                                                                <tr>
                                                                                    <th>출발&nbsp;<i class="fas fa-arrow-right"></i>&nbsp;도착</th>
                                                                                    <th>운송방식</th>  
                                                                                    <th>작업일</th>
                                                                                    <th>출항</th>
                                                                                    <th>입항</th>
                                                                                    <th>입고일</th>  
                                                                                    <th>리드타임(출하~배송)</th>                                             
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody align="center">
                                                                                <?php
                                                                                // [개선] '$data_completed' 배열을 순회하며 데이터 출력
                                                                                foreach ($data_completed as $item):
                                                                                ?>
                                                                                    <tr>
                                                                                        <td style="width: 30%;">
                                                                                            <img src="../img/<?php echo $flagImages[$item['s_country']] ?? ''; ?>" width="60em">
                                                                                            &nbsp;<i class="fas fa-arrow-right"></i>&nbsp;
                                                                                            <img src="../img/<?php echo $flagImages[$item['e_country']] ?? ''; ?>" width="60em">
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php if($item['kind'] == "해상"): ?>
                                                                                                <i class="fas fa-ship fa-2x"></i>
                                                                                            <?php elseif($item['kind'] == "항공"): ?>
                                                                                                <i class="fas fa-plane fa-2x"></i>
                                                                                            <?php endif; ?>
                                                                                        </td>
                                                                                        <td><?php echo $item['invoice_dt']; ?></td>
                                                                                        <td><?php echo $item['etd']; ?></td>
                                                                                        <td><?php echo $item['eta']; ?></td>
                                                                                        <td><?php echo $item['complete_dt']; ?></td>
                                                                                        <td><?php echo ($item['lead_time'] < 0 || $item['lead_time'] == '#VALUE!') ? '' : $item['lead_time']; ?></td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>                                                                
                                                                    </div>   
                                                                </div>  
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div> 