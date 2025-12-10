<?php
/**
 * ESG DATA 관리 탭 (Final Fixed)
 * - 환경, 사회, 지배구조 모든 데이터 포함
 * - 반복되는 연도별 표를 루프(Loop)로 처리
 * - 각 연도별로 제각각인 변수명을 $yearConfig 배열에서 표준화된 키(key)로 매핑
 */

// 1. 데이터 매핑 설정 (연도별 변수 연결)
$yearConfig = [
    [
        'year' => $YY, // 현재 년도 (예: 2025)
        'id_suffix' => '61', // 아코디언 ID
        'show_class' => '', // 기본적으로 닫아둠
        'active_tab' => 'active', 
        
        // 환경(Environment) 데이터
        'oil_sum' => $thisYearmonthlyOilSum ?? [],
        'oil_sum_total' => $thisYearmonthlyOilSumTotal ?? [],
        'elec_usage' => $thisYearElectricityUsageData ?? [],
        'oil_co2' => $thisYearmonthlyOilCO2 ?? [],
        'oil_co2_total' => $thisYearmonthlyOilCO2Total ?? [],
        'elec_co2' => $thisYearElectricityCO2 ?? [],
        'elec_co2_sum' => $thisYearElectricityCO2Sum ?? 0,
        'water_usage' => $thisYearWaterIwinUsageData ?? [],
        'trash' => $thisYearTrash ?? [],
        'trash_sum' => $thisYearTrashSum ?? 0,
        
        // 사회(Social) 데이터
        'headcount' => $thisYearHeadcount ?? [],
        'headcount_avg' => $thisYearHeadcountAvg ?? 0,
        'office_headcount' => $thisYearOfficeHeadcount ?? [],
        'office_headcount_avg' => $thisYearOfficeHeadcountAvg ?? 0,
        'contract_headcount' => $thisYearContractHeadcount ?? [],
        'contract_headcount_avg' => $thisYearContractHeadcountAvg ?? 0,
        'hiring_data' => $thisYearHiringData ?? [],
        
        // 사회/지배구조 상세 데이터 (구조적 배열)
        'monthly_data' => $monthlyData ?? [], 
        'yearly_averages' => $yearlyAverages ?? [],
        'yearly_totals' => $yearlyTotals ?? [],
        
        // 기타 변수
        'work_length_m' => $thisYearWorkLengthM ?? 0,
        'work_length_w' => $thisYearWorkLengthW ?? 0,
        'welfare_cost' => $Data_Welfare['AM_CR'] ?? 0,
        'edu_count' => $Data_Edu['COU'] ?? 0,
        // 분기별 데이터 배열화
        'clean_data' => [$Data_Clean1 ?? [], $Data_Clean2 ?? [], $Data_Clean3 ?? [], $Data_Clean4 ?? []] 
    ],
    [
        'year' => $previousYear, // 작년 (예: 2024)
        'id_suffix' => '62',
        'show_class' => '',
        'active_tab' => '',
        
        // 데이터 매핑 (작년 변수명)
        'oil_sum' => $oneYearAgomonthlyOilSum ?? [],
        'oil_sum_total' => $oneYearAgomonthlyOilSumTotal ?? [],
        'elec_usage' => $lastYearElectricityUsageData ?? [],
        'oil_co2' => $oneYearAgomonthlyOilCO2 ?? [],
        'oil_co2_total' => $oneYearAgomonthlyOilCO2Total ?? [],
        'elec_co2' => $lastYearElectricityCO2 ?? [],
        'elec_co2_sum' => $lastYearElectricityCO2Sum ?? 0,
        'water_usage' => $lastYearWaterIwinUsageData ?? [],
        'trash' => $lastYearTrash ?? [],
        'trash_sum' => $lastYearTrashSum ?? 0,
        
        // 사회 데이터 (작년 변수명)
        'headcount' => $lastYearHeadcount ?? [],
        'headcount_avg' => $lastYearHeadcountAvg ?? 0,
        'office_headcount' => $lastYearOfficeHeadcount ?? [],
        'office_headcount_avg' => $lastYearOfficeHeadcountAvg ?? 0,
        'contract_headcount' => $lastYearContractHeadcount ?? [],
        'contract_headcount_avg' => $lastYearContractHeadcountAvg ?? 0,
        'hiring_data' => $lastYearHiringData ?? [],
        
        'monthly_data' => $lastYearMonthlyData ?? [],
        'yearly_averages' => $lastYearYearlyAverages ?? [],
        'yearly_totals' => $lastYearYearlyTotals ?? [],
        
        'work_length_m' => $lastYearWorkLengthM ?? 0,
        'work_length_w' => $lastYearWorkLengthW ?? 0,
        'welfare_cost' => $lastYearData_Welfare['AM_CR'] ?? 0,
        'edu_count' => $Data_Edu2['COU'] ?? 0,
        'clean_data' => [$Data_Clean1Minus1YY ?? [], $Data_Clean2Minus1YY ?? [], $Data_Clean3Minus1YY ?? [], $Data_Clean4Minus1YY ?? []]
    ],
    [
        'year' => $twoYearsAgo, // 재작년 (예: 2023)
        'id_suffix' => '63',
        'show_class' => '',
        'active_tab' => '',
        
        // 데이터 매핑
        'oil_sum' => $twoYearsAgomonthlyOilSum ?? [],
        'oil_sum_total' => $twoYearsAgomonthlyOilSumTotal ?? [],
        'elec_usage' => $twoYearsAgoElectricityUsageData ?? [],
        'oil_co2' => $twoYearsAgomonthlyOilCO2 ?? [],
        'oil_co2_total' => $twoYearsAgomonthlyOilCO2Total ?? [],
        'elec_co2' => $twoYearsAgoElectricityCO2 ?? [],
        'elec_co2_sum' => $twoYearsAgoElectricityCO2Sum ?? 0,
        'water_usage' => $twoYearsAgoWaterIwinUsageData ?? [],
        'trash' => $twoYearsAgoTrash ?? [],
        'trash_sum' => $twoYearsAgoTrashSum ?? 0,
        
        // 사회 데이터 (재작년 변수명)
        'headcount' => $twoYearsAgoHeadcount ?? [],
        'headcount_avg' => $twoYearsAgoHeadcountAvg ?? 0,
        'office_headcount' => $twoYearsAgoOfficeHeadcount ?? [],
        'office_headcount_avg' => $twoYearsAgoOfficeHeadcountAvg ?? 0,
        'contract_headcount' => $twoYearsAgoContractHeadcount ?? [],
        'contract_headcount_avg' => $twoYearsAgoContractHeadcountAvg ?? 0,
        'hiring_data' => $twoYearsAgoHiringData ?? [],
        
        'monthly_data' => $twoYearsAgoMonthlyData ?? [],
        'yearly_averages' => $twoYearsAgoYearlyAverages ?? [],
        'yearly_totals' => $twoYearsAgoYearlyTotals ?? [],
        
        'work_length_m' => $twoYearsAgoWorkLengthM ?? 0,
        'work_length_w' => $twoYearsAgoWorkLengthW ?? 0,
        'welfare_cost' => $twoYearsAgoData_Welfare['AM_CR'] ?? 0,
        'edu_count' => $Data_Edu3['COU'] ?? 0,
        'clean_data' => [$Data_Clean1Minus2YY ?? [], $Data_Clean2Minus2YY ?? [], $Data_Clean3Minus2YY ?? [], $Data_Clean4Minus2YY ?? []]
    ]
];
?>

<p style="color: red;">※카드가 닫혀있습니다. 원하는 년도의 카드를 클릭하여 데이터를 열람하세요!</p>

<?php foreach ($yearConfig as $config): ?>
    <?php 
        // 설정 배열을 변수에 할당
        $currentYearLabel = $config['year'];
        $collapseId = "collapseCardExample" . $config['id_suffix'];
        
        // ★★★ $d에 $config 전체 배열을 할당하여 데이터 접근 ★★★
        $d = $config; 
    ?>
    <div class="col-lg-12"> 
        <div class="card shadow mb-4">
            <div class="card-header">
                <a href="#<?php echo $collapseId; ?>" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="<?php echo $collapseId; ?>">
                    <h1 class="h6 m-0 font-weight-bold text-primary">DATA SHEET (<?php echo $currentYearLabel; ?>년)</h6>
                </a>
                <div class="card-tools mt-3">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#esg_e_<?php echo $config['id_suffix']; ?>" data-toggle="tab">환경</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#esg_s_<?php echo $config['id_suffix']; ?>" data-toggle="tab">사회</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#esg_g_<?php echo $config['id_suffix']; ?>" data-toggle="tab">지배구조</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="collapse <?php echo $config['show_class']; ?>" id="<?php echo $collapseId; ?>">
                <div class="card-body">
                    <div class="tab-content p-0">  
                        <div class="chart tab-pane active" id="esg_e_<?php echo $config['id_suffix']; ?>"  style="position: relative;">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                            <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                            <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                            <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                            <th style="text-align: center; vertical-align: middle;">관리대상</th>
                                            <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                            <th style="text-align: center; vertical-align: middle;">단위</th>
                                            <?php for($m=1; $m<=12; $m++): ?><th style="text-align: center; vertical-align: middle;"><?php echo $m; ?>월</th><?php endfor; ?>
                                            <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                            <th style="text-align: center; vertical-align: middle;">비고</th>
                                            <th style="text-align: center; vertical-align: middle;">자동화</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3" colspan="2">에너지</td>
                                            <td style="text-align: center; vertical-align: middle;">보유 차량 휘발유 소비량</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">E-4-1</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 302</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">L</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['oil_sum']['휘발유'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($d['oil_sum_total']['휘발유'] ?? 0); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>     
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">보유 차량 경유 소비량</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">L</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['oil_sum']['경유'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($d['oil_sum_total']['경유'] ?? 0); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">사업장 내 전력 소비량</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">KWH</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['elec_usage'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($d['elec_usage'][0] ?? 0); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3" colspan="2">온실가스</td>
                                            <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 휘발유</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">E-3-1</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 305</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['oil_co2']['휘발유'][$i] ?? 0, 2); ?>
                                                </td>
                                            <?php endfor; ?> 
                                            <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($d['oil_co2_total']['휘발유'] ?? 0, 2); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>     
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 경유</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['oil_co2']['경유'][$i] ?? 0, 2); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($d['oil_co2_total']['경유'] ?? 0, 2); ?></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 전기</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['elec_co2'][$i] ?? 0, 2); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($d['elec_co2_sum'] ?? 0, 2); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr> 
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">용수</td>
                                            <td style="text-align: center; vertical-align: middle;">용수 사용량(상하수)</td>
                                            <td style="text-align: center; vertical-align: middle;">E-5-1</td>
                                            <td style="text-align: center; vertical-align: middle;">GRI 303</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">㎥</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['water_usage'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?> 
                                            <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($d['water_usage'][0] ?? 0); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2" rowspan="3">페기물</td>
                                            <td style="text-align: center; vertical-align: middle;">페기물 배출량(일반)</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="2">E-6-1</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 306</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">kg</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['trash'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?> 
                                            <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($d['trash_sum']); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">폐기물 배출량(지정/유해)</td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">kg</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="13">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">폐기물 재활용/재사용량</td>
                                            <td style="text-align: center; vertical-align: middle;">E-6-2</td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">ton</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="13">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2" rowspan="4">오염물질</td>
                                            <td style="text-align: center; vertical-align: middle;">Nox(질소산화물)</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="4">E-7-1, E-7-2</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 303</td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">ton</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="13">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">Sox(황산화물)</td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">ton</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="13">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">VOCs(휘발성 유기화합물)</td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">ton</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="13">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">분진 배출량</td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">ton</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="13">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">환경경영시스템</td>
                                            <td style="text-align: center; vertical-align: middle;">ISO 14001 적용 사업장 비율</td>
                                            <td style="text-align: center; vertical-align: middle;">E-1-2</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">연간</td>
                                            <td style="text-align: center; vertical-align: middle;">%</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="12">100</td>
                                            <td style="text-align: center; vertical-align: middle;">100</td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>   

                        <div class="chart tab-pane" id="esg_s_<?php echo $config['id_suffix']; ?>" style="position: relative;">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                            <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                            <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                            <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                            <th style="text-align: center; vertical-align: middle;">관리현황</th>
                                            <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                            <th style="text-align: center; vertical-align: middle;">단위</th>
                                            <?php for($m=1; $m<=12; $m++): ?><th style="text-align: center; vertical-align: middle;"><?php echo $m; ?>월</th><?php endfor; ?>
                                            <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                            <th style="text-align: center; vertical-align: middle;">비고</th>
                                            <th style="text-align: center; vertical-align: middle;">자동화</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="18">임직원 현황</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="4">근로형태</td>
                                            <td style="text-align: center; vertical-align: middle;">총 구성원수</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;">GRI 2-7</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['headcount'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['headcount_avg'] ?? 0); ?>)</td>
                                            <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">정규직</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-2</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 401</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['office_headcount'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['office_headcount_avg'] ?? 0); ?>)</td>
                                            <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">기간제 근로자</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['term_worker'][$i] ?? 0) ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['term_worker'] ?? 0); ?>)</td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">기간의 정함이 없는 근로자</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                        <?php echo number_format($d['contract_headcount'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['contract_headcount_avg'] ?? 0); ?>)</td>
                                            <td style="text-align: center; vertical-align: middle;">도급직</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                            <td style="text-align: center; vertical-align: middle;">남성</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-1</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="12">GRI 405</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['top_official'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['top_official'] ?? 0); ?>)</td>
                                            <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">여성</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['top_official_woman'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['top_official_woman'] ?? 0); ?>)</td>
                                            <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">%</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php 
                                                    $total_monthly = $d['monthly_data']['top_official'][$i] ?? 0;
                                                    $woman_monthly = $d['monthly_data']['top_official_woman'][$i] ?? 0;
                                                    
                                                    if ($total_monthly > 0) {
                                                        echo number_format(($woman_monthly * 100) / $total_monthly, 1); 
                                                    } else {
                                                        echo 0;
                                                    }
                                                    ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">
                                                (<?php 
                                                $total_yearly = $d['yearly_totals']['top_official'] ?? 0;
                                                $woman_yearly = $d['yearly_totals']['top_official_woman'] ?? 0;
                                                
                                                if ($total_yearly > 0) {
                                                    echo number_format(($woman_yearly * 100) / $total_yearly, 1);
                                                } else {
                                                    echo 0;
                                                }
                                                ?>)
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                            <td style="text-align: center; vertical-align: middle;">남성직원</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['middle_official'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['middle_official'] ?? 0); ?>)</td>
                                            <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">여성직원</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['middle_official_woman'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['middle_official_woman'] ?? 0); ?>)</td>
                                            <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">%</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php 
                                                    $total_monthly = $d['monthly_data']['middle_official'][$i] ?? 0;
                                                    $woman_monthly = $d['monthly_data']['middle_official_woman'][$i] ?? 0;
                                                    
                                                    if ($total_monthly > 0) {
                                                        echo number_format(($woman_monthly * 100) / $total_monthly, 1); 
                                                    } else {
                                                        echo 0;
                                                    }
                                                    ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">
                                                (<?php 
                                                $total_yearly = $d['yearly_totals']['middle_official'] ?? 0;
                                                $woman_yearly = $d['yearly_totals']['middle_official_woman'] ?? 0;
                                                
                                                if ($total_yearly > 0) {
                                                    echo number_format(($woman_yearly * 100) / $total_yearly, 1);
                                                } else {
                                                    echo 0;
                                                }
                                                ?>)
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>

                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                            <td style="text-align: center; vertical-align: middle;">남성직원</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">여성직원</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;">매월 1일 기준</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">여성구성원 비율</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">%</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>

                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">신규입사 및 퇴직</td>
                                            <td style="text-align: center; vertical-align: middle;">신규 입사자</td>
                                            <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php 
                                            $joinSum = 0;
                                            $resignSum = 0;
                                            for ($k = 1; $k <= 12; $k++) {
                                                $joinSum += $d['hiring_data'][$k]['Join1'] ?? 0;
                                                $resignSum += $d['hiring_data'][$k]['Resign'] ?? 0;
                                            }
                                            for ($i = 1; $i <= 12; $i++): 
                                            ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['hiring_data'][$i]['Join1'] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;"><?php echo number_format($joinSum); ?></td>
                                            <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">이직/퇴직자</td>
                                            <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['hiring_data'][$i]['Resign'] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;"><?php echo number_format($resignSum); ?></td>
                                            <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">이직/퇴직율</td>
                                            <td style="text-align: center; vertical-align: middle;">S-1-2</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">연간</td>
                                            <td style="text-align: center; vertical-align: middle;">%</td>
                                            <?php
                                            // 퇴직율 계산
                                            $peopleSum = 0;
                                            $countMonths = 0;
                                            for ($m = 1; $m <= 12; $m++) {
                                                if(isset($d['headcount'][$m])) {
                                                    $peopleSum += $d['headcount'][$m];
                                                    $countMonths++;
                                                }
                                            }
                                            $avgHeadcount = ($countMonths > 0) ? $peopleSum / $countMonths : 0;
                                            $turnoverRate = ($avgHeadcount > 0) ? ($resignSum * 100) / $avgHeadcount : 0;
                                            ?>
                                            <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($turnoverRate, 2); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"><?php echo number_format($turnoverRate, 2); ?></td>
                                            <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="2">근속 연수</td>
                                            <td style="text-align: center; vertical-align: middle;">남성</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="2">-</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 401</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">연간</td>
                                            <td style="text-align: center; vertical-align: middle;">년</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($d['work_length_m'], 2); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"><?php echo number_format($d['work_length_m'], 2); ?></td>
                                            <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">여성</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">연간</td>
                                            <td style="text-align: center; vertical-align: middle;">년</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($d['work_length_w'], 2); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"><?php echo number_format($d['work_length_w'], 2); ?></td>
                                            <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>

                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">임직원 윤리 교육</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">수료 인원</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">연간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo $d['edu_count']; ?></td>
                                            <td style="text-align: center; vertical-align: middle;"><?php echo $d['edu_count']; ?></td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="2">지역사회</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">구성원 봉사활동 참여 인원</td>
                                            <td style="text-align: center; vertical-align: middle;">S-7-2</td>
                                            <td style="text-align: center; vertical-align: middle;">GRI 413</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">분기별</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            
                                            <?php 
                                                $cleanData = $d['clean_data']; 
                                                $sum = 0; $count = 0;
                                            ?>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $cleanData[0]['COU'] ?? ''; if(isset($cleanData[0]['COU'])){ $sum+=$cleanData[0]['COU']; $count++; } ?></td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $cleanData[1]['COU'] ?? ''; if(isset($cleanData[1]['COU'])){ $sum+=$cleanData[1]['COU']; $count++; } ?></td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $cleanData[2]['COU'] ?? ''; if(isset($cleanData[2]['COU'])){ $sum+=$cleanData[2]['COU']; $count++; } ?></td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $cleanData[3]['COU'] ?? ''; if(isset($cleanData[3]['COU'])){ $sum+=$cleanData[3]['COU']; $count++; } ?></td>
                                            
                                            <td style="text-align: center; vertical-align: middle;">
                                                <?php echo $count > 0 ? round($sum/$count, 2) : ''; ?>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>   

                        <div class="chart tab-pane" id="esg_g_<?php echo $config['id_suffix']; ?>" style="position: relative;">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;" colspan="2">항목</th>
                                            <th style="text-align: center; vertical-align: middle;">세부항목</th>
                                            <th style="text-align: center; vertical-align: middle;">한국 기준</th>
                                            <th style="text-align: center; vertical-align: middle;">글로벌 기준</th>
                                            <th style="text-align: center; vertical-align: middle;">관리현황</th>
                                            <th style="text-align: center; vertical-align: middle;">관리주기</th>
                                            <th style="text-align: center; vertical-align: middle;">단위</th>
                                            <?php for($m=1; $m<=12; $m++): ?><th style="text-align: center; vertical-align: middle;"><?php echo $m; ?>월</th><?php endfor; ?>
                                            <th style="text-align: center; vertical-align: middle;">합계/(평균)</th>
                                            <th style="text-align: center; vertical-align: middle;">비고</th>
                                            <th style="text-align: center; vertical-align: middle;">자동화</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="3">이사회</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 개최</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;">GRI 2-9</td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                            <td style="text-align: center; vertical-align: middle;">분기</td>
                                            <td style="text-align: center; vertical-align: middle;">회</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 내 ESG 안건 심의</td>
                                            <td style="text-align: center; vertical-align: middle;">G-1-1</td>
                                            <td style="text-align: center; vertical-align: middle;">GRI 2-12</td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                            <td style="text-align: center; vertical-align: middle;">분기</td>
                                            <td style="text-align: center; vertical-align: middle;">건</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">이사회 참석률</td>
                                            <td style="text-align: center; vertical-align: middle;">G-2-1</td>
                                            <td style="text-align: center; vertical-align: middle;">GRI 2-9</td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                            <td style="text-align: center; vertical-align: middle;">분기</td>
                                            <td style="text-align: center; vertical-align: middle;">%</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="3">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="4">준법</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">환경 법규<br>위반/환경사고 발생 건수</td>
                                            <td style="text-align: center; vertical-align: middle;">E-8-1</td>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 2-27</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">건</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['environmental_violation'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['environmental_violation'] ?? 0); ?>)</td> 
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">사회 법/규제<br>위반 건수</td>
                                            <td style="text-align: center; vertical-align: middle;">S-9-1</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">건</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['social_violation'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['social_violation'] ?? 0); ?>)</td> 
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">지배구조<br>법/규제 위반 건수</td>
                                            <td style="text-align: center; vertical-align: middle;">G-6-1</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">건</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['governance_violation'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['governance_violation'] ?? 0); ?>)</td> 
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">법규<br>위반/환경사고로 인한 벌금액</td>
                                            <td style="text-align: center; vertical-align: middle;">G-윤리경영-추가1</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">원</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['statutory_penalty'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['statutory_penalty'] ?? 0); ?>)</td> 
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" rowspan="2">윤리</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">윤리/준법 신고 및 처리 건수</td>
                                            <td style="text-align: center; vertical-align: middle;">G-4-1</td>
                                            <td style="text-align: center; vertical-align: middle;">GRI 2-25</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">월간</td>
                                            <td style="text-align: center; vertical-align: middle;">건</td>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <?php echo number_format($d['monthly_data']['ethics_rate'][$i] ?? 0); ?>
                                                </td>
                                            <?php endfor; ?>
                                            <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($d['yearly_averages']['ethics_rate'] ?? 0); ?>)</td> 
                                            <td style="text-align: center; vertical-align: middle;"></td>
                                            <td style="text-align: center; vertical-align: middle;">x</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 윤리 교육 수료 인원</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                            <td style="text-align: center; vertical-align: middle;">연간</td>
                                            <td style="text-align: center; vertical-align: middle;">명</td>
                                            <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo $d['edu_count']; ?></td>
                                            <td style="text-align: center; vertical-align: middle;"><?php echo $d['edu_count']; ?></td>
                                            <td style="text-align: center; vertical-align: middle;"><a href="https://fms.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">수료인원 바로가기</a></td>
                                            <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>                                   
                </div>
                </div>
            </div>
        </div>  
<?php endforeach; ?>