<!-- Begin row -->
<div class="row"> 
    <div class="col-lg-12"> 
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-2 mt-2">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample31t" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample31t">
                <h1 class="h6 m-0 font-weight-bold text-primary">#1. 근태</h6>
            </a>
            
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample31t">                                    
                <div class="card-body">  
                    <div class="col-lg-12">    
                        <div class="row">
                            <?php 
                                BOARD2(3, "info", "사무직/도급직/합계(명)", $office_staff_count." / ".$contract_staff_count." / ".$attend_total, "fas fa-user", "shortcut", "https://fms.iwin.kr/kjwt_gw/gw_attend.php");    
                                BOARD2(3, "info", "바로가기", "ESG보고서", "fas fa-solar-panel", "shortcut", "https://fms.iwin.kr/kjwt_esg/esg.php");  
                                BOARD2(3, "info", "바로가기", "전산보고서", "fas fa-file-alt", "shortcut", "https://fms.iwin.kr/kjwt_report/report_network.php"); 
                                BOARD2(3, "info", "바로가기", "경비보고서", "fas fa-user-tie", "shortcut", "https://fms.iwin.kr/kjwt_report/report_guard.php");                                                 
                            ?>
                        </div>
                    </div>                                                                
                    <!-- 차트 - 사무직 인원증감 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                    <div class="col-lg-12"> 
                        <!-- Collapsable Card Example -->
                        <div class="card shadow mb-2 mt-2">
                            <div class="card-header">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample311t" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample311t">
                                    <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 사무</h6>
                                </a>
                                <div class="card-tools mt-3">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#p_chart" data-toggle="tab">비용</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#p_number" data-toggle="tab">인원</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" id="collapseCardExample311t">                                    
                                <div class="card-body">
                                    <div class="tab-content p-0">  
                                        <div class="chart tab-pane active" id="p_chart" style="position: relative; height: 300px;">
                                            <canvas id="barChart55"></canvas>
                                        </div>
                                        <div class="chart tab-pane" id="p_number" style="position: relative; height: 300px;">
                                            <canvas id="barChart44"></canvas>
                                        </div>
                                    </div>        
                                </div> 
                                <!-- /.card-body -->              
                            </div>
                            <!-- /.Card Content - Collapse -->
                        </div>
                        <!-- /.card -->
                    </div> 
                    <!-- 차트 - 도급직 인원증감 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                    <div class="col-lg-12"> 
                        <!-- Collapsable Card Example -->
                        <div class="card shadow mb-2 mt-2">
                            <div class="card-header">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample313t" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample313t">
                                    <h1 class="h6 m-0 font-weight-bold text-primary">#1-2. 도급</h6>
                                </a>
                                <div class="card-tools mt-3">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#p2_chart" data-toggle="tab">비용</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#p2_number" data-toggle="tab">인원</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" id="collapseCardExample313t">                                    
                                <div class="card-body">
                                    <div class="tab-content p-0">  
                                        <div class="chart tab-pane active" id="p2_chart" style="position: relative; height: 300px;">
                                            <canvas id="barChart5"></canvas>
                                        </div>
                                        <div class="chart tab-pane" id="p2_number" style="position: relative; height: 300px;">
                                            <canvas id="barChart4"></canvas>
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
            </div>
        </div>
    </div>
</div>

<!-- Begin row -->
<div class="row">   
    <!-- 차트 - 전기 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
    <div class="col-lg-12"> 
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-2">
            <div class="card-header">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample321t" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample321t">
                    <h1 class="h6 m-0 font-weight-bold text-primary">#2-1. 전기</h6>
                </a>
                <div class="card-tools mt-3">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#e_chart" data-toggle="tab">비용(그래프)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#e_number" data-toggle="tab">비용(표)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#e_use" data-toggle="tab">사용량(KWH)</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample321t">                                    
                <div class="card-body">
                    <div class="tab-content p-0">  
                        <div class="chart tab-pane active" id="e_chart" style="position: relative; height: 300px;">
                            <canvas id="barChart33"></canvas>
                        </div>
                        <div class="chart tab-pane" id="e_number" style="position: relative; height: 300px;">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <?php
                                            // 💡 1단계: 헤더(머리글)를 배열로 만든 후 for문으로 출력
                                            $headers = ['#', '년 합계', '월 누적 합계'];
                                            foreach ($headers as $header) {
                                                echo "<th scope='col'>{$header}</th>";
                                            }
                                            // 1월부터 12월까지의 헤더를 for문으로 생성
                                            for ($month = 1; $month <= 12; $month++) {
                                                echo "<th scope='col'>{$month}월</th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // 💡 2단계: 올해와 작년 데이터를 하나의 배열로 묶어 처리
                                        $tableData = [
                                            // 올해 데이터 정보
                                            [
                                                'label' => $YY,
                                                'yearTotalVar' => $Data_ThisYearFee0,
                                                'monthTotalVar' => $Data_ThisYearFee00,
                                                'monthlyVarPrefix' => 'Data_ThisYearFee' // 월별 변수 이름의 앞부분
                                            ],
                                            // 작년 데이터 정보
                                            [
                                                'label' => $Minus1YY,
                                                'yearTotalVar' => $Data_LastYearFee0,
                                                'monthTotalVar' => $Data_LastYearFee00,
                                                'monthlyVarPrefix' => 'Data_LastYearFee'
                                            ],
                                            // 2년 전 데이터 정보
                                            [
                                                'label' => $Minus2YY,
                                                'yearTotalVar' => $Data_YearBeforeFee0,
                                                'monthTotalVar' => $Data_YearBeforeFee00,
                                                'monthlyVarPrefix' => 'Data_YearBeforeFee'
                                            ]
                                        ];

                                        // 💡 3단계: 묶은 데이터를 foreach문으로 돌면서 행(<tr>) 생성
                                        foreach ($tableData as $rowData) :
                                        ?>
                                            <tr style="text-align: center;">
                                                <th scope="row"><?php echo $rowData['label']; ?></th>
                                                <td><?php echo number_format($rowData['yearTotalVar']['ELECTRICITY'] ?? 0); ?></td>
                                                <td><?php echo number_format($rowData['monthTotalVar']['ELECTRICITY'] ?? 0); ?></td>

                                                <?php
                                                // 💡 4단계: 안쪽 for문으로 12개월치 셀(<td>)을 동적으로 생성
                                                for ($month = 1; $month <= 12; $month++) {
                                                    // '$Data_ThisYearFee' + '1' => '$Data_ThisYearFee1' 처럼 변수 이름을 동적으로 만듭니다.
                                                    $variableName = $rowData['monthlyVarPrefix'] . $month;
                                                    
                                                    // 동적으로 만들어진 이름의 변수에 접근하고, ELECTRICITY 값을 가져옵니다.
                                                    // 변수가 존재하지 않을 경우를 대비해 ?? 0으로 안전하게 처리합니다.
                                                    $ELECTRICITYValue = ${$variableName}['ELECTRICITY'] ?? 0;

                                                    echo '<td>' . number_format($ELECTRICITYValue) . '</td>';
                                                }
                                                ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table> 
                            </div>                                                                                           
                        </div>
                        <div class="chart tab-pane" id="e_use" style="position: relative; height: 300px;">
                            <canvas id="barChart3" height="300" style="height: 300px;"></canvas>
                        </div>                                                                    
                    </div>       
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
        <div class="card shadow mb-2">
            <div class="card-header">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample323t" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample323t">
                    <h1 class="h6 m-0 font-weight-bold text-primary">#2-2. 가스</h6>
                </a>
                <div class="card-tools mt-3">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#g_chart" data-toggle="tab">비용(그래프)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#g_number" data-toggle="tab">비용(표)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#g_use" data-toggle="tab">사용량(㎥)
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample323t">                                    
                <div class="card-body">
                    <div class="tab-content p-0">  
                        <div class="chart tab-pane active" id="g_chart" style="position: relative; height: 300px;">
                            <canvas id="barChart22"></canvas>
                        </div>
                        <div class="chart tab-pane" id="g_number" style="position: relative; height: 300px;">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <?php
                                            // 💡 1단계: 헤더(머리글)를 배열로 만든 후 for문으로 출력
                                            $headers = ['#', '년 합계', '월 누적 합계'];
                                            foreach ($headers as $header) {
                                                echo "<th scope='col'>{$header}</th>";
                                            }
                                            // 1월부터 12월까지의 헤더를 for문으로 생성
                                            for ($month = 1; $month <= 12; $month++) {
                                                echo "<th scope='col'>{$month}월</th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // 💡 2단계: 올해와 작년 데이터를 하나의 배열로 묶어 처리
                                        $tableData = [
                                            // 올해 데이터 정보
                                            [
                                                'label' => $YY,
                                                'yearTotalVar' => $Data_ThisYearFee0,
                                                'monthTotalVar' => $Data_ThisYearFee00,
                                                'monthlyVarPrefix' => 'Data_ThisYearFee' // 월별 변수 이름의 앞부분
                                            ],
                                            // 작년 데이터 정보
                                            [
                                                'label' => $Minus1YY,
                                                'yearTotalVar' => $Data_LastYearFee0,
                                                'monthTotalVar' => $Data_LastYearFee00,
                                                'monthlyVarPrefix' => 'Data_LastYearFee'
                                            ],
                                            // 2년 전 데이터 정보
                                            [
                                                'label' => $Minus2YY,
                                                'yearTotalVar' => $Data_YearBeforeFee0,
                                                'monthTotalVar' => $Data_YearBeforeFee00,
                                                'monthlyVarPrefix' => 'Data_YearBeforeFee'
                                            ]
                                        ];

                                        // 💡 3단계: 묶은 데이터를 foreach문으로 돌면서 행(<tr>) 생성
                                        foreach ($tableData as $rowData) :
                                        ?>
                                            <tr style="text-align: center;">
                                                <th scope="row"><?php echo $rowData['label']; ?></th>
                                                <td><?php echo number_format($rowData['yearTotalVar']['GAS'] ?? 0); ?></td>
                                                <td><?php echo number_format($rowData['monthTotalVar']['GAS'] ?? 0); ?></td>

                                                <?php
                                                // 💡 4단계: 안쪽 for문으로 12개월치 셀(<td>)을 동적으로 생성
                                                for ($month = 1; $month <= 12; $month++) {
                                                    // '$Data_ThisYearFee' + '1' => '$Data_ThisYearFee1' 처럼 변수 이름을 동적으로 만듭니다.
                                                    $variableName = $rowData['monthlyVarPrefix'] . $month;
                                                    
                                                    // 동적으로 만들어진 이름의 변수에 접근하고, GAS 값을 가져옵니다.
                                                    // 변수가 존재하지 않을 경우를 대비해 ?? 0으로 안전하게 처리합니다.
                                                    $GASValue = ${$variableName}['GAS'] ?? 0;

                                                    echo '<td>' . number_format($GASValue) . '</td>';
                                                }
                                                ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>     
                            </div>                                                                                          
                        </div>
                        <div class="chart tab-pane" id="g_use" style="position: relative; height: 300px;">
                            <canvas id="barChart2"></canvas>
                        </div>
                    </div>          
                </div> 
                <!-- /.card-body -->              
            </div>
            <!-- /.Card Content - Collapse -->
        </div>
        <!-- /.card -->
    </div> 

    <!-- 차트 - 수도 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->                                                                 
    <div class="col-lg-12"> 
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-2 mt-2">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample32t" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample32t">
                <h1 class="h6 m-0 font-weight-bold text-primary">#2. 에너지</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample32t">                                    
                <div class="card-body">
                    <div class="col-lg-12"> 
                        <!-- Collapsable Card Example -->
                        <div class="card shadow mb-2 mt-2">
                            <div class="card-header">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample336t" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample325t">
                                    <h1 class="h6 m-0 font-weight-bold text-primary">#2-3. 수도</h6>
                                </a>
                                <div class="card-tools mt-3">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#w_chart" data-toggle="tab">비용(그래프)</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#w_number" data-toggle="tab">비용(표)</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#w_use" data-toggle="tab">사용량(㎥)</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" id="collapseCardExample325t">                                    
                                <div class="card-body">
                                    <div class="tab-content p-0">  
                                        <div class="chart tab-pane active" id="w_chart" style="position: relative; height: 300px;">
                                            <canvas id="barChart11"></canvas>
                                        </div>    
                                        <div class="chart tab-pane" id="w_number" style="position: relative; height: 300px;">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr style="text-align: center;">
                                                            <?php
                                                            // 💡 1단계: 헤더(머리글)를 배열로 만든 후 for문으로 출력
                                                            $headers = ['#', '년 합계', '월 누적 합계'];
                                                            foreach ($headers as $header) {
                                                                echo "<th scope='col'>{$header}</th>";
                                                            }
                                                            // 1월부터 12월까지의 헤더를 for문으로 생성
                                                            for ($month = 1; $month <= 12; $month++) {
                                                                echo "<th scope='col'>{$month}월</th>";
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // 💡 2단계: 올해와 작년, 재작년 데이터를 하나의 배열로 묶어 처리
                                                        $tableData = [
                                                            // 올해 데이터 정보
                                                            [
                                                                'label' => $YY,
                                                                'yearTotalVar' => $Data_ThisYearFee0,
                                                                'monthTotalVar' => $Data_ThisYearFee00,
                                                                'monthlyVarPrefix' => 'Data_ThisYearFee' // 월별 변수 이름의 앞부분
                                                            ],
                                                            // 작년 데이터 정보
                                                            [
                                                                'label' => $Minus1YY,
                                                                'yearTotalVar' => $Data_LastYearFee0,
                                                                'monthTotalVar' => $Data_LastYearFee00,
                                                                'monthlyVarPrefix' => 'Data_LastYearFee'
                                                            ],
                                                            // 2년 전 데이터 정보
                                                            [
                                                                'label' => $Minus2YY,
                                                                'yearTotalVar' => $Data_YearBeforeFee0,
                                                                'monthTotalVar' => $Data_YearBeforeFee00,
                                                                'monthlyVarPrefix' => 'Data_YearBeforeFee'
                                                            ]
                                                        ];

                                                        // 💡 3단계: 묶은 데이터를 foreach문으로 돌면서 행(<tr>) 생성
                                                        foreach ($tableData as $rowData) :
                                                        ?>
                                                            <tr style="text-align: center;">
                                                                <th scope="row"><?php echo $rowData['label']; ?></th>
                                                                <td><?php echo number_format($rowData['yearTotalVar']['WATER'] ?? 0); ?></td>
                                                                <td><?php echo number_format($rowData['monthTotalVar']['WATER'] ?? 0); ?></td>

                                                                <?php
                                                                // 💡 4단계: 안쪽 for문으로 12개월치 셀(<td>)을 동적으로 생성
                                                                for ($month = 1; $month <= 12; $month++) {
                                                                    // '$Data_ThisYearFee' + '1' => '$Data_ThisYearFee1' 처럼 변수 이름을 동적으로 만듭니다.
                                                                    $variableName = $rowData['monthlyVarPrefix'] . $month;
                                                                    
                                                                    // 동적으로 만들어진 이름의 변수에 접근하고, WATER 값을 가져옵니다.
                                                                    // 변수가 존재하지 않을 경우를 대비해 ?? 0으로 안전하게 처리합니다.
                                                                    $waterValue = ${$variableName}['WATER'] ?? 0;

                                                                    echo '<td>' . number_format($waterValue) . '</td>';
                                                                }
                                                                ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>  
                                            </div>                                                                                        
                                        </div> 
                                        <div class="chart tab-pane" id="w_use" style="position: relative; height: 300px;">
                                            <canvas id="barChart"></canvas>
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
            </div> 
        </div> 
    </div>   
</div>
<!-- /. row -->   