<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.06.24>
	// Description:	<홈페이지 공개데이터>	
	// =============================================
    include 'esg_status.php';   
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Begin row -->
                    <div class="row">                         
                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                        <div class="col-lg-12"> 
                            <p style="color: red; padding-top:1%;">※카드가 닫혀있습니다. 원하는 년도의 카드를 클릭하여 데이터를 열람하세요!</p>
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExample61" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExample61">
                                        <h1 class="h6 m-0 font-weight-bold text-primary">DATA SHEET (<?php echo $YY; ?>년)</h6>
                                    </a>
                                    <div class="card-tools mt-3">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#esg_e" data-toggle="tab">환경</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#esg_s" data-toggle="tab">사회</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#esg_g" data-toggle="tab">지배구조</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="collapseCardExample61">
                                    <div class="card-body">
                                        <div class="tab-content p-0">  
                                            <div class="chart tab-pane active" id="esg_e"  style="position: relative;">
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
                                                                <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                <th style="text-align: center; vertical-align: middle;">12월</th>
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
                                                                        <?php echo number_format($thisYearmonthlyOilSum['휘발유'][$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearmonthlyOilSumTotal['휘발유']); ?></td>
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
                                                                        <?php echo number_format($thisYearmonthlyOilSum['경유'][$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearmonthlyOilSumTotal['경유']); ?></td>
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
                                                                        <?php echo number_format($thisYearElectricityUsageData[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearElectricityUsageData[0]); ?></td>
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
                                                                        <?php echo number_format($thisYearmonthlyOilCO2['휘발유'][$i], 2); ?>
                                                                    </td>
                                                                <?php endfor; ?> 
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearmonthlyOilCO2Total['휘발유'], 2); ?></td>
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
                                                                        <?php echo number_format($thisYearmonthlyOilCO2['경유'][$i], 2); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearmonthlyOilCO2Total['경유'], 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 전기</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($thisYearElectricityCO2[$i], 2); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearElectricityCO2Sum, 2); ?></td>
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
                                                                        <?php echo number_format($thisYearWaterIwinUsageData[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?> 
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearWaterIwinUsageData[0] ?? 0); ?></td>
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
                                                                        <?php echo number_format($thisYearTrash[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?> 
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($thisYearTrashSum); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">폐기물 배출량(지정/유해)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">kg</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">폐기물 재활용/재사용량</td>
                                                                <td style="text-align: center; vertical-align: middle;">E-6-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
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
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">Sox(황산화물)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">VOCs(휘발성 유기화합물)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">분진 배출량</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
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
                                            <div class="chart tab-pane" id="esg_s" style="position: relative;">
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
                                                                <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                <th style="text-align: center; vertical-align: middle;">12월</th>
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
                                                                        <?php echo number_format($thisYearHeadcount[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($thisYearHeadcountAvg ?? 0); ?>)</td>
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
                                                                        <?php echo number_format($thisYearOfficeHeadcount[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($thisYearOfficeHeadcountAvg ?? 0); ?>)</td>
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
                                                                        <?php echo number_format($monthlyData['term_worker'][$i] ?? 0) ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['term_worker']); ?>)</td>
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
                                                                            <?php echo number_format($thisYearContractHeadcount[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($thisYearContractHeadcountAvg ?? 0); ?>)</td>
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
                                                                        <?php echo number_format($monthlyData['top_official'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['top_official']); ?>)</td>
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
                                                                        <?php echo number_format($monthlyData['top_official_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['top_official_woman']); ?>)</td>
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
                                                                        $total_monthly = $monthlyData['top_official'][$i] ?? 0;
                                                                        $woman_monthly = $monthlyData['top_official_woman'][$i] ?? 0;
                                                                        
                                                                        if ($total_monthly > 0) {
                                                                            $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                            echo number_format($ratio_monthly, 1); 
                                                                        } else {
                                                                            echo 0;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    (<?php 
                                                                    $total_yearly = $yearlyTotals['top_official'] ?? 0;
                                                                    $woman_yearly = $yearlyTotals['top_official_woman'] ?? 0;
                                                                    
                                                                    if ($total_yearly > 0) {
                                                                        $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                        echo number_format($ratio_yearly, 1);
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
                                                                        <?php echo number_format($monthlyData['middle_official'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['middle_official']); ?>)</td>
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
                                                                        <?php echo number_format($monthlyData['middle_official_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['middle_official_woman']); ?>)</td>
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
                                                                        $total_monthly = $monthlyData['middle_official'][$i] ?? 0;
                                                                        $woman_monthly = $monthlyData['middle_official_woman'][$i] ?? 0;
                                                                        
                                                                        if ($total_monthly > 0) {
                                                                            $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                            echo number_format($ratio_monthly, 1); 
                                                                        } else {
                                                                            echo 0;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    (<?php 
                                                                    $total_yearly = $yearlyTotals['middle_official'] ?? 0;
                                                                    $woman_yearly = $yearlyTotals['middle_official_woman'] ?? 0;
                                                                    
                                                                    if ($total_yearly > 0) {
                                                                        $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                        echo number_format($ratio_yearly, 1);
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
                                                                <?php 
                                                                $thisYearGeneralMaleSum = 0;
                                                                $thisYearGeneralFemaleSum = 0;
                                                                $monthsWithData = 0;
                                                                $monthlyMaleGeneral = [];
                                                                $monthlyFemaleGeneral = [];

                                                                for ($i = 1; $i <= 12; $i++) {
                                                                    $male_general = 0;
                                                                    $female_general = 0;
                                                                    if (isset($thisYearOfficeHeadcount[$i])) {
                                                                        $male_general = ($thisYearOfficeHeadcount[$i] - $thisYearOfficeWomenHeadcount[$i]) - ($monthlyData['top_official'][$i] ?? 0) - ($monthlyData['middle_official'][$i] ?? 0);
                                                                        $female_general = $thisYearOfficeWomenHeadcount[$i] - ($monthlyData['top_official_woman'][$i] ?? 0) - ($monthlyData['middle_official_woman'][$i] ?? 0);
                                                                        
                                                                        if (($thisYearOfficeHeadcount[$i] ?? 0) > 0 || ($thisYearContractHeadcount[$i] ?? 0) > 0) { // Consider month if there is any data
                                                                            $thisYearGeneralMaleSum += $male_general;
                                                                            $thisYearGeneralFemaleSum += $female_general;
                                                                            $monthsWithData++;
                                                                        }
                                                                    }
                                                                    $monthlyMaleGeneral[$i] = $male_general;
                                                                    $monthlyFemaleGeneral[$i] = $female_general;
                                                                }
                                                                
                                                                for ($i = 1; $i <= 12; $i++): 
                                                                ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyMaleGeneral[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($monthsWithData > 0) ? $thisYearGeneralMaleSum / $monthsWithData : 0, 0); ?>)</td>
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
                                                                        <?php echo number_format($monthlyFemaleGeneral[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($monthsWithData > 0) ? $thisYearGeneralFemaleSum / $monthsWithData : 0, 0); ?>)</td>
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
                                                                        $total_general = $monthlyMaleGeneral[$i] + $monthlyFemaleGeneral[$i];
                                                                        if ($total_general > 0) {
                                                                            echo number_format(($monthlyFemaleGeneral[$i] * 100) / $total_general, 2);
                                                                        } else {
                                                                            echo '0.00';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php $total_sum = $thisYearGeneralMaleSum + $thisYearGeneralFemaleSum; echo ($total_sum > 0) ? number_format($thisYearGeneralFemaleSum * 100 / $total_sum, 2) : '0.00'; ?>)</td>
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
                                                                $thisYearJoinSum = 0;
                                                                $thisYearResignSum = 0;
                                                                for ($i = 1; $i <= 12; $i++) {
                                                                    $thisYearJoinSum += $thisYearHiringData[$i]['Join1'] ?? 0;
                                                                    $thisYearResignSum += $thisYearHiringData[$i]['Resign'] ?? 0;
                                                                }
                                                                for ($i = 1; $i <= 12; $i++): 
                                                                ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? number_format($thisYearHiringData[$i]['Join1'] ?? 0) : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($thisYearJoinSum); ?></td>
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
                                                                        <?php echo date('n') >= $i ? number_format($thisYearHiringData[$i]['Resign'] ?? 0) : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($thisYearResignSum); ?></td>
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
                                                                $thisYearPeopleSum = 0;
                                                                for ($m = 1; $m <= date('n'); $m++) {
                                                                    $thisYearPeopleSum += $thisYearHeadcount[$m] ?? 0;
                                                                }
                                                                $avgHeadcountYTD = (date('n') > 0) ? $thisYearPeopleSum / date('n') : 0;
                                                                $turnoverRate = ($avgHeadcountYTD > 0) ? ($thisYearResignSum * 100) / $avgHeadcountYTD : 0;
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
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($thisYearWorkLengthM ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($thisYearWorkLengthM ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">년</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($thisYearWorkLengthW ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($thisYearWorkLengthW ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="9">임직원 보수</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-2</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="9">GRI 405</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">노동</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합 가입원수</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-6</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 402</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합<br>가입비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '-' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">노사협의회<br>개최</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 1 ? '1' : ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 2 ? '1' : ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 3 ? '1' : ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 4 ? '1' : ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <?php
                                                                        $sum = 0;
                                                                        if(ceil(date('n')/3) >= 1) { $sum += 1; }
                                                                        if(ceil(date('n')/3) >= 2) { $sum += 1; }
                                                                        if(ceil(date('n')/3) >= 3) { $sum += 1; }
                                                                        if(ceil(date('n')/3) >= 4) { $sum += 1; }
                                                                        echo $sum;
                                                                    ?>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="15">인권</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 고충처리<br>접수 및 처리 건수</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-5-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 2-26</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                            <?php echo number_format($monthlyData['grievance_count'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($yearlyTotals['grievance_count']); ?></td>                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">4대 법정교육<br> 수료 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">성희롱</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">-</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">GRI 404</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5"></td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">산업안전보건교육</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">개인정보 보호</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">직장내 장애인 인식</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">직장내 괴롭힘 예방</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">복리후생비</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-2-5</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($Data_Welfare['AM_CR']); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($Data_Welfare['AM_CR']); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">ERP손익계산서</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 대상인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="8">S-노동-추가2</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="8">GRI 401</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['childcare_Target_man'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_Target_man']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['childcare_Target_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_Target_woman']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['childcare_user_man'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_user_man']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['childcare_user_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_user_woman']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후 <br>복직 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['childcare_return_man'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_return_man']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['childcare_return_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_return_woman']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후<br> 복직 후<br> 12개월 이상 유지인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['childcare_return_man_year'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_return_man_year']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['childcare_return_woman_year'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['childcare_return_woman_year']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">다양성<br>및 포용성</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">장애인 근로자</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-3-3</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 405</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($thisYearHiringData[$i]['Handi'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['Handi']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">국가보훈자</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($thisYearHiringData[$i]['Bohun'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['Bohun']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                                <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">중졸/고졸</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-노동-추가1</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($thisYearHiringData[$i]['School'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['School'], 4); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="4">산업안전</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">안전점검 실시</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 403</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo date('n') >= $i ? '2' : ''; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <?php
                                                                        $sum = 0;
                                                                        if(date('n') >= 1) $sum += 2;
                                                                        if(date('n') >= 2) $sum += 2;
                                                                        if(date('n') >= 3) $sum += 2;
                                                                        if(date('n') >= 4) $sum += 2;
                                                                        if(date('n') >= 5) $sum += 2;
                                                                        if(date('n') >= 6) $sum += 2;
                                                                        if(date('n') >= 7) $sum += 2;
                                                                        if(date('n') >= 8) $sum += 2;
                                                                        if(date('n') >= 9) $sum += 2;
                                                                        if(date('n') >= 10) $sum += 2;
                                                                        if(date('n') >= 11) $sum += 2;
                                                                        if(date('n') >= 12) $sum += 2;
                                                                        echo $sum;
                                                                    ?>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;">글로벌안전공사</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">산업재해율</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-4-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['accident_rate'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['accident_rate'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">근로손실재해율(LTIFR)</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명/백만시간</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['lost_time_accident_rate'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['lost_time_accident_rate'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">안전보건경영시스템<br>(ISO 45001) 적용 사업장 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">개인정보</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보 유출 건수</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 418</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['personal_data_count'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['personal_data_count']); ?>)</td>                                                                                    
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보보호교육<br>수료 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-정보보호-추가1</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($monthlyData['mandatory_edu'][$currentMonthInt]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">지역사회</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">사회공헌(기부) 금액</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-7-1</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 413</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">백만원</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($monthlyData['donation_amount'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['donation_amount']); ?>)</td>  
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">구성원 봉사활동 참여 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-7-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 1 ? $Data_Clean1['COU'] : ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 2 ? $Data_Clean2['COU'] : ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 3 ? $Data_Clean3['COU'] : ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo ceil(date('n')/3) >= 4 ? $Data_Clean4['COU'] : ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <?php
                                                                        $sum = 0;
                                                                        $count = 0;
                                                                        if(ceil(date('n')/3) >= 1) { $sum += $Data_Clean1['COU']; $count++; }
                                                                        if(ceil(date('n')/3) >= 2) { $sum += $Data_Clean2['COU']; $count++; }
                                                                        if(ceil(date('n')/3) >= 3) { $sum += $Data_Clean3['COU']; $count++; }
                                                                        if(ceil(date('n')/3) >= 4) { $sum += $Data_Clean4['COU']; $count++; }
                                                                        echo $count > 0 ? round($sum/$count, 2) : '';
                                                                    ?>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;"><a href="https://develop.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">참여인원 바로가기</a></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>   
                                            <div class="chart tab-pane" id="esg_g" style="position: relative;">
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
                                                                <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                <th style="text-align: center; vertical-align: middle;">12월</th>
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
                                                                        <?php echo number_format($monthlyData['environmental_violation'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['environmental_violation']); ?>)</td> 
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
                                                                        <?php echo number_format($monthlyData['social_violation'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['social_violation']); ?>)</td> 
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
                                                                        <?php echo number_format($monthlyData['governance_violation'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['governance_violation']); ?>)</td> 
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
                                                                        <?php echo number_format($monthlyData['statutory_penalty'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['statutory_penalty']); ?>)</td> 
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
                                                                        <?php echo number_format($monthlyData['ethics_rate'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($yearlyAverages['ethics_rate']); ?>)</td> 
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
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo $Data_Edu['COU']?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo $Data_Edu['COU']?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><a href="https://fms.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">수료인원 바로가기</a></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                        </body>
                                                    </table> 
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

                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExample62" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExample62">
                                        <h1 class="h6 m-0 font-weight-bold text-primary">DATA SHEET (<?php echo $previousYear; ?>년)</h6>
                                    </a>
                                    <div class="card-tools mt-3">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#esg_e_last" data-toggle="tab">환경</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#esg_s_last" data-toggle="tab">사회</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#esg_g_last" data-toggle="tab">지배구조</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="collapseCardExample62">
                                    <div class="card-body">
                                        <div class="tab-content p-0">  
                                            <div class="chart tab-pane active" id="esg_e_last"  style="position: relative;">
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
                                                                <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                <th style="text-align: center; vertical-align: middle;">12월</th>
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
                                                                        <?php echo number_format($oneYearAgomonthlyOilSum['휘발유'][$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($oneYearAgomonthlyOilSumTotal['휘발유']); ?></td>
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
                                                                        <?php echo number_format($oneYearAgomonthlyOilSum['경유'][$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($oneYearAgomonthlyOilSumTotal['경유']); ?></td>
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
                                                                        <?php echo number_format($lastYearElectricityUsageData[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($lastYearElectricityUsageData[0]); ?></td>
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
                                                                        <?php echo number_format($oneYearAgomonthlyOilCO2['휘발유'][$i], 2); ?>
                                                                    </td>
                                                                <?php endfor; ?> 
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($oneYearAgomonthlyOilCO2Total['휘발유'], 2); ?></td>
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
                                                                        <?php echo number_format($oneYearAgomonthlyOilCO2['경유'][$i], 2); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($oneYearAgomonthlyOilCO2Total['경유'], 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 전기</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearElectricityCO2[$i], 2); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($lastYearElectricityCO2Sum, 2); ?></td>
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
                                                                        <?php echo number_format($lastYearWaterIwinUsageData[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?> 
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($lastYearWaterIwinUsageData[0] ?? 0); ?></td>
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
                                                                        <?php echo number_format($lastYearTrash[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?> 
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($lastYearTrashSum); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">폐기물 배출량(지정/유해)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">kg</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">폐기물 재활용/재사용량</td>
                                                                <td style="text-align: center; vertical-align: middle;">E-6-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
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
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">Sox(황산화물)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">VOCs(휘발성 유기화합물)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">분진 배출량</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
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
                                            <div class="chart tab-pane" id="esg_s_last" style="position: relative;">
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
                                                                <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                <th style="text-align: center; vertical-align: middle;">12월</th>
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
                                                                        <?php echo number_format($lastYearHeadcount[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearHeadcountAvg ?? 0); ?>)</td>
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
                                                                        <?php echo number_format($lastYearOfficeHeadcount[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearOfficeHeadcountAvg ?? 0); ?>)</td>
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
                                                                        <?php echo number_format($lastYearMonthlyData['term_worker'][$i] ?? 0) ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['term_worker']); ?>)</td>
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
                                                                            <?php echo number_format($lastYearContractHeadcount[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearContractHeadcountAvg ?? 0); ?>)</td>
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
                                                                        <?php echo number_format($lastYearMonthlyData['top_official'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['top_official']); ?>)</td>
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
                                                                        <?php echo number_format($lastYearMonthlyData['top_official_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['top_official_woman']); ?>)</td>
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
                                                                        $total_monthly = $lastYearMonthlyData['top_official'][$i] ?? 0;
                                                                        $woman_monthly = $lastYearMonthlyData['top_official_woman'][$i] ?? 0;
                                                                        
                                                                        if ($total_monthly > 0) {
                                                                            $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                            echo number_format($ratio_monthly, 1); 
                                                                        } else {
                                                                            echo 0;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    (<?php 
                                                                    $total_yearly = $lastYearYearlyTotals['top_official'] ?? 0;
                                                                    $woman_yearly = $lastYearYearlyTotals['top_official_woman'] ?? 0;
                                                                    
                                                                    if ($total_yearly > 0) {
                                                                        $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                        echo number_format($ratio_yearly, 1);
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
                                                                        <?php echo number_format($lastYearMonthlyData['middle_official'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['middle_official']); ?>)</td>
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
                                                                        <?php echo number_format($lastYearMonthlyData['middle_official_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['middle_official_woman']); ?>)</td>
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
                                                                        $total_monthly = $lastYearMonthlyData['middle_official'][$i] ?? 0;
                                                                        $woman_monthly = $lastYearMonthlyData['middle_official_woman'][$i] ?? 0;
                                                                        
                                                                        if ($total_monthly > 0) {
                                                                            $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                            echo number_format($ratio_monthly, 1); 
                                                                        } else {
                                                                            echo 0;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    (<?php 
                                                                    $total_yearly = $lastYearYearlyTotals['middle_official'] ?? 0;
                                                                    $woman_yearly = $lastYearYearlyTotals['middle_official_woman'] ?? 0;
                                                                    
                                                                    if ($total_yearly > 0) {
                                                                        $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                        echo number_format($ratio_yearly, 1);
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
                                                                <?php 
                                                                $lastYearGeneralMaleSum = 0;
                                                                $lastYearGeneralFemaleSum = 0;
                                                                $lastYearMonthsWithData = 0;
                                                                $lastYearMonthlyMaleGeneral = [];
                                                                $lastYearMonthlyFemaleGeneral = [];

                                                                for ($i = 1; $i <= 12; $i++) {
                                                                    $male_general = 0;
                                                                    $female_general = 0;
                                                                    if (isset($lastYearOfficeHeadcount[$i])) {
                                                                        $male_general = ($lastYearOfficeHeadcount[$i] - $lastYearOfficeWomenHeadcount[$i]) - ($lastYearMonthlyData['top_official'][$i] ?? 0) - ($lastYearMonthlyData['middle_official'][$i] ?? 0);
                                                                        $female_general = $lastYearOfficeWomenHeadcount[$i] - ($lastYearMonthlyData['top_official_woman'][$i] ?? 0) - ($lastYearMonthlyData['middle_official_woman'][$i] ?? 0);
                                                                        
                                                                        if (($lastYearOfficeHeadcount[$i] ?? 0) > 0 || ($lastYearContractHeadcount[$i] ?? 0) > 0) { // Consider month if there is any data
                                                                            $lastYearGeneralMaleSum += $male_general;
                                                                            $lastYearGeneralFemaleSum += $female_general;
                                                                            $lastYearMonthsWithData++;
                                                                        }
                                                                    }
                                                                    $lastYearMonthlyMaleGeneral[$i] = $male_general;
                                                                    $lastYearMonthlyFemaleGeneral[$i] = $female_general;
                                                                }
                                                                
                                                                for ($i = 1; $i <= 12; $i++): 
                                                                ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyMaleGeneral[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($lastYearMonthsWithData > 0) ? $lastYearGeneralMaleSum / $lastYearMonthsWithData : 0, 0); ?>)</td>
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
                                                                        <?php echo number_format($lastYearMonthlyFemaleGeneral[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($lastYearMonthsWithData > 0) ? $lastYearGeneralFemaleSum / $lastYearMonthsWithData : 0, 0); ?>)</td>
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
                                                                        $total_general = $lastYearMonthlyMaleGeneral[$i] + $lastYearMonthlyFemaleGeneral[$i];
                                                                        if ($total_general > 0) {
                                                                            echo number_format(($lastYearMonthlyFemaleGeneral[$i] * 100) / $total_general, 2);
                                                                        } else {
                                                                            echo '0.00';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php $total_sum = $lastYearGeneralMaleSum + $lastYearGeneralFemaleSum; echo ($total_sum > 0) ? number_format($lastYearGeneralFemaleSum * 100 / $total_sum, 2) : '0.00'; ?>)</td>
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
                                                                $lastYearJoinSum = 0;
                                                                $lastYearResignSum = 0;
                                                                for ($i = 1; $i <= 12; $i++) {
                                                                    $lastYearJoinSum += $lastYearHiringData[$i]['Join1'] ?? 0;
                                                                    $lastYearResignSum += $lastYearHiringData[$i]['Resign'] ?? 0;
                                                                }
                                                                for ($i = 1; $i <= 12; $i++): 
                                                                ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearHiringData[$i]['Join1'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearJoinSum); ?></td>
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
                                                                        <?php echo number_format($lastYearHiringData[$i]['Resign'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearResignSum); ?></td>
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
                                                                $lastYearPeopleSum = 0;
                                                                for ($m = 1; $m <= 12; $m++) {
                                                                    $lastYearPeopleSum += $lastYearHeadcount[$m] ?? 0;
                                                                }
                                                                $avgHeadcountYTD = ($lastYearPeopleSum > 0) ? $lastYearPeopleSum / 12 : 0;
                                                                $turnoverRate = ($avgHeadcountYTD > 0) ? ($lastYearResignSum * 100) / $avgHeadcountYTD : 0;
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
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearWorkLengthM ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearWorkLengthM ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">년</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearWorkLengthW ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearWorkLengthW ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="9">임직원 보수</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-2</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="9">GRI 405</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">노동</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합 가입원수</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-6</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 402</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합<br>가입비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">노사협의회<br>개최</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                <td style="text-align: center; vertical-align: middle;">4</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="15">인권</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 고충처리<br>접수 및 처리 건수</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-5-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 2-26</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                            <?php echo number_format($lastYearMonthlyData['grievance_count'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearYearlyTotals['grievance_count']); ?></td>                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">4대 법정교육<br> 수료 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">성희롱</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">-</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">GRI 404</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5"></td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">산업안전보건교육</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">개인정보 보호</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">직장내 장애인 인식</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">직장내 괴롭힘 예방</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">복리후생비</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-2-5</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearData_Welfare['AM_CR']); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearData_Welfare['AM_CR']); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">ERP손익계산서</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 대상인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="8">S-노동-추가2</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="8">GRI 401</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['childcare_Target_man'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_Target_man']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['childcare_Target_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_Target_woman']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['childcare_user_man'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_user_man']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['childcare_user_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_user_woman']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후 <br>복직 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['childcare_return_man'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_return_man']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['childcare_return_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_return_woman']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후<br> 복직 후<br> 12개월 이상 유지인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['childcare_return_man_year'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_return_man_year']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['childcare_return_woman_year'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['childcare_return_woman_year']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">다양성<br>및 포용성</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">장애인 근로자</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-3-3</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 405</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearHiringData[$i]['Handi'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['Handi']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">국가보훈자</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearHiringData[$i]['Bohun'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['Bohun']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                                <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">중졸/고졸</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-노동-추가1</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearHiringData[$i]['School'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['School'], 4); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="4">산업안전</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">안전점검 실시</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 403</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">2</td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">24</td>
                                                                <td style="text-align: center; vertical-align: middle;">글로벌안전공사</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">산업재해율</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-4-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['accident_rate'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['accident_rate'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">근로손실재해율(LTIFR)</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명/백만시간</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['lost_time_accident_rate'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['lost_time_accident_rate'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">안전보건경영시스템<br>(ISO 45001) 적용 사업장 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">개인정보</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보 유출 건수</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 418</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['personal_data_count'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['personal_data_count']); ?>)</td>                                                                                    
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보보호교육<br>수료 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-정보보호-추가1</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($lastYearMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">지역사회</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">사회공헌(기부) 금액</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-7-1</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 413</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">백만원</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($lastYearMonthlyData['donation_amount'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['donation_amount']); ?>)</td>  
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">구성원 봉사활동 참여 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-7-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean1Minus1YY['COU'] ?? ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean2Minus1YY['COU'] ?? ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean3Minus1YY['COU'] ?? ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean4Minus1YY['COU'] ?? ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <?php
                                                                        $sum = 0;
                                                                        $count = 0;
                                                                        if(isset($Data_Clean1Minus1YY['COU'])) { $sum += $Data_Clean1Minus1YY['COU']; $count++; }
                                                                        if(isset($Data_Clean2Minus1YY['COU'])) { $sum += $Data_Clean2Minus1YY['COU']; $count++; }
                                                                        if(isset($Data_Clean3Minus1YY['COU'])) { $sum += $Data_Clean3Minus1YY['COU']; $count++; }
                                                                        if(isset($Data_Clean4Minus1YY['COU'])) { $sum += $Data_Clean4Minus1YY['COU']; $count++; }
                                                                        echo $count > 0 ? round($sum/$count, 2) : '';
                                                                    ?>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;"><a href="https://develop.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">참여인원 바로가기</a></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>   
                                            <div class="chart tab-pane" id="esg_g_last" style="position: relative;">
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
                                                                <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                <th style="text-align: center; vertical-align: middle;">12월</th>
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
                                                                        <?php echo number_format($lastYearMonthlyData['environmental_violation'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['environmental_violation']); ?>)</td> 
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
                                                                        <?php echo number_format($lastYearMonthlyData['social_violation'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['social_violation']); ?>)</td> 
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
                                                                        <?php echo number_format($lastYearMonthlyData['governance_violation'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['governance_violation']); ?>)</td> 
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
                                                                        <?php echo number_format($lastYearMonthlyData['statutory_penalty'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['statutory_penalty']); ?>)</td> 
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
                                                                        <?php echo number_format($lastYearMonthlyData['ethics_rate'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($lastYearYearlyAverages['ethics_rate']); ?>)</td> 
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
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo $Data_Edu2['COU']?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo $Data_Edu2['COU']?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><a href="https://fms.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">수료인원 바로가기</a></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                        </body>
                                                    </table> 
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
                                                                        
                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExample63" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExample63">
                                        <h1 class="h6 m-0 font-weight-bold text-primary">DATA SHEET (<?php echo $twoYearsAgo; ?>년)</h6>
                                    </a>
                                    <div class="card-tools mt-3">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#esg_e_two_years_ago" data-toggle="tab">환경</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#esg_s_two_years_ago" data-toggle="tab">사회</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#esg_g_two_years_ago" data-toggle="tab">지배구조</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="collapseCardExample63">
                                    <div class="card-body">
                                        <div class="tab-content p-0">  
                                            <div class="chart tab-pane active" id="esg_e_two_years_ago"  style="position: relative;">
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
                                                                <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                <th style="text-align: center; vertical-align: middle;">12월</th>
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
                                                                        <?php echo number_format($twoYearsAgomonthlyOilSum['휘발유'][$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgomonthlyOilSumTotal['휘발유']); ?></td>
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
                                                                        <?php echo number_format($twoYearsAgomonthlyOilSum['경유'][$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgomonthlyOilSumTotal['경유']); ?></td>
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
                                                                        <?php echo number_format($twoYearsAgoElectricityUsageData[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgoElectricityUsageData[0]); ?></td>
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
                                                                        <?php echo number_format($twoYearsAgomonthlyOilCO2['휘발유'][$i], 2); ?>
                                                                    </td>
                                                                <?php endfor; ?> 
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgomonthlyOilCO2Total['휘발유'], 2); ?></td>
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
                                                                        <?php echo number_format($twoYearsAgomonthlyOilCO2['경유'][$i], 2); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgomonthlyOilCO2Total['경유'], 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">온실가스 배출량 관리 전기</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">tco2e</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoElectricityCO2[$i], 2); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgoElectricityCO2Sum, 2); ?></td>
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
                                                                        <?php echo number_format($twoYearsAgoWaterIwinUsageData[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?> 
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgoWaterIwinUsageData[0] ?? 0); ?></td>
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
                                                                        <?php echo number_format($twoYearsAgoTrash[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?> 
                                                                <td style="text-align: center; vertical-align: middle;"> <?php echo number_format($twoYearsAgoTrashSum); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">폐기물 배출량(지정/유해)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">kg</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">폐기물 재활용/재사용량</td>
                                                                <td style="text-align: center; vertical-align: middle;">E-6-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
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
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">Sox(황산화물)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">VOCs(휘발성 유기화합물)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">분진 배출량</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">ton</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
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
                                            <div class="chart tab-pane" id="esg_s_two_years_ago" style="position: relative;">
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
                                                                <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                <th style="text-align: center; vertical-align: middle;">12월</th>
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
                                                                        <?php echo number_format($twoYearsAgoHeadcount[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoHeadcountAvg ?? 0); ?>)</td>
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
                                                                        <?php echo number_format($twoYearsAgoOfficeHeadcount[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoOfficeHeadcountAvg ?? 0); ?>)</td>
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['term_worker'][$i] ?? 0) ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['term_worker']); ?>)</td>
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
                                                                            <?php echo number_format($twoYearsAgoContractHeadcount[$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoContractHeadcountAvg ?? 0); ?>)</td>
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['top_official'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['top_official']); ?>)</td>
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['top_official_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['top_official_woman']); ?>)</td>
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
                                                                        $total_monthly = $twoYearsAgoMonthlyData['top_official'][$i] ?? 0;
                                                                        $woman_monthly = $twoYearsAgoMonthlyData['top_official_woman'][$i] ?? 0;
                                                                        
                                                                        if ($total_monthly > 0) {
                                                                            $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                            echo number_format($ratio_monthly, 1); 
                                                                        } else {
                                                                            echo 0;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    (<?php 
                                                                    $total_yearly = $twoYearsAgoYearlyTotals['top_official'] ?? 0;
                                                                    $woman_yearly = $twoYearsAgoYearlyTotals['top_official_woman'] ?? 0;
                                                                    
                                                                    if ($total_yearly > 0) {
                                                                        $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                        echo number_format($ratio_yearly, 1);
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['middle_official'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['middle_official']); ?>)</td>
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['middle_official_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['middle_official_woman']); ?>)</td>
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
                                                                        $total_monthly = $twoYearsAgoMonthlyData['middle_official'][$i] ?? 0;
                                                                        $woman_monthly = $twoYearsAgoMonthlyData['middle_official_woman'][$i] ?? 0;
                                                                        
                                                                        if ($total_monthly > 0) {
                                                                            $ratio_monthly = ($woman_monthly * 100) / $total_monthly;
                                                                            echo number_format($ratio_monthly, 1); 
                                                                        } else {
                                                                            echo 0;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    (<?php 
                                                                    $total_yearly = $twoYearsAgoYearlyTotals['middle_official'] ?? 0;
                                                                    $woman_yearly = $twoYearsAgoYearlyTotals['middle_official_woman'] ?? 0;
                                                                    
                                                                    if ($total_yearly > 0) {
                                                                        $ratio_yearly = ($woman_yearly * 100) / $total_yearly;
                                                                        echo number_format($ratio_yearly, 1);
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
                                                                <?php 
                                                                $twoYearsAgoGeneralMaleSum = 0;
                                                                $twoYearsAgoGeneralFemaleSum = 0;
                                                                $twoYearsAgoMonthsWithData = 0;
                                                                $twoYearsAgoMonthlyMaleGeneral = [];
                                                                $twoYearsAgoMonthlyFemaleGeneral = [];

                                                                for ($i = 1; $i <= 12; $i++) {
                                                                    $male_general = 0;
                                                                    $female_general = 0;
                                                                    if (isset($twoYearsAgoOfficeHeadcount[$i])) {
                                                                        $male_general = ($twoYearsAgoOfficeHeadcount[$i] - $twoYearsAgoOfficeWomenHeadcount[$i]) - ($twoYearsAgoMonthlyData['top_official'][$i] ?? 0) - ($twoYearsAgoMonthlyData['middle_official'][$i] ?? 0);
                                                                        $female_general = $twoYearsAgoOfficeWomenHeadcount[$i] - ($twoYearsAgoMonthlyData['top_official_woman'][$i] ?? 0) - ($twoYearsAgoMonthlyData['middle_official_woman'][$i] ?? 0);
                                                                        
                                                                        if (($twoYearsAgoOfficeHeadcount[$i] ?? 0) > 0 || ($twoYearsAgoContractHeadcount[$i] ?? 0) > 0) { // Consider month if there is any data
                                                                            $twoYearsAgoGeneralMaleSum += $male_general;
                                                                            $twoYearsAgoGeneralFemaleSum += $female_general;
                                                                            $twoYearsAgoMonthsWithData++;
                                                                        }
                                                                    }
                                                                    $twoYearsAgoMonthlyMaleGeneral[$i] = $male_general;
                                                                    $twoYearsAgoMonthlyFemaleGeneral[$i] = $female_general;
                                                                }
                                                                
                                                                for ($i = 1; $i <= 12; $i++): 
                                                                ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyMaleGeneral[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($twoYearsAgoMonthsWithData > 0) ? $twoYearsAgoGeneralMaleSum / $twoYearsAgoMonthsWithData : 0, 0); ?>)</td>
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyFemaleGeneral[$i]); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format(($twoYearsAgoMonthsWithData > 0) ? $twoYearsAgoGeneralFemaleSum / $twoYearsAgoMonthsWithData : 0, 0); ?>)</td>
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
                                                                        $total_general = $twoYearsAgoMonthlyMaleGeneral[$i] + $twoYearsAgoMonthlyFemaleGeneral[$i];
                                                                        if ($total_general > 0) {
                                                                            echo number_format(($twoYearsAgoMonthlyFemaleGeneral[$i] * 100) / $total_general, 2);
                                                                        } else {
                                                                            echo '0.00';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php $total_sum = $twoYearsAgoGeneralMaleSum + $twoYearsAgoGeneralFemaleSum; echo ($total_sum > 0) ? number_format($twoYearsAgoGeneralFemaleSum * 100 / $total_sum, 2) : '0.00'; ?>)</td>
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
                                                                $twoYearsAgoJoinSum = 0;
                                                                $twoYearsAgoResignSum = 0;
                                                                for ($i = 1; $i <= 12; $i++) {
                                                                    $twoYearsAgoJoinSum += $twoYearsAgoHiringData[$i]['Join1'] ?? 0;
                                                                    $twoYearsAgoResignSum += $twoYearsAgoHiringData[$i]['Resign'] ?? 0;
                                                                }
                                                                for ($i = 1; $i <= 12; $i++): 
                                                                ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoHiringData[$i]['Join1'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoJoinSum); ?></td>
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
                                                                        <?php echo number_format($twoYearsAgoHiringData[$i]['Resign'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoResignSum); ?></td>
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
                                                                $twoYearsAgoPeopleSum = 0;
                                                                for ($m = 1; $m <= 12; $m++) {
                                                                    $twoYearsAgoPeopleSum += $twoYearsAgoHeadcount[$m] ?? 0;
                                                                }
                                                                $avgHeadcountYTD = ($twoYearsAgoPeopleSum > 0) ? $twoYearsAgoPeopleSum / 12 : 0;
                                                                $turnoverRate = ($avgHeadcountYTD > 0) ? ($twoYearsAgoResignSum * 100) / $avgHeadcountYTD : 0;
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
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoWorkLengthM ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoWorkLengthM ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">년</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoWorkLengthW ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoWorkLengthW ?? 0, 2); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">사무, 도급</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="9">임직원 보수</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">임원<br>(이사 이상)</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="9">S-3-2</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="9">GRI 405</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">관리직<br>(부장)</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">일반직<br>(사원~차장)</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성 평균 급여</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">남성 급여 대비<br>여성 급여 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">△</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">노동</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합 가입원수</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">S-2-6</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 402</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">노동조합<br>가입비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo '-'; ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">노사협의회<br>개최</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3">1</td>
                                                                <td style="text-align: center; vertical-align: middle;">4</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="15">인권</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">임직원 고충처리<br>접수 및 처리 건수</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-5-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 2-26</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                            <?php echo number_format($twoYearsAgoMonthlyData['grievance_count'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoYearlyTotals['grievance_count']); ?></td>                                                                                    <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">4대 법정교육<br> 수료 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">성희롱</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">-</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">GRI 404</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5"></td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="5">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">산업안전보건교육</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">개인정보 보호</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">직장내 장애인 인식</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">직장내 괴롭힘 예방</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">복리후생비</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-2-5</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">원</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoData_Welfare['AM_CR']); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoData_Welfare['AM_CR']); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">ERP손익계산서</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 대상인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="8">S-노동-추가2</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="8">GRI 401</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['childcare_Target_man'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_Target_man']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['childcare_Target_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_Target_woman']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['childcare_user_man'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_user_man']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['childcare_user_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_user_woman']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후 <br>복직 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['childcare_return_man'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_return_man']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['childcare_return_woman'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_return_woman']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">육아휴직 사용 후<br> 복직 후<br> 12개월 이상 유지인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">남성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['childcare_return_man_year'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_return_man_year']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;">여성</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['childcare_return_woman_year'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['childcare_return_woman_year']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;">2025년(육아휴직 1년6개월)</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">다양성<br>및 포용성</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">장애인 근로자</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-3-3</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="3">GRI 405</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoHiringData[$i]['Handi'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['Handi']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">국가보훈자</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoHiringData[$i]['Bohun'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['Bohun']); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                                <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">중졸/고졸</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-노동-추가1</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoHiringData[$i]['School'] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['School'], 4); ?>)</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="4">산업안전</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">안전점검 실시</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="4">GRI 403</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">2</td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">24</td>
                                                                <td style="text-align: center; vertical-align: middle;">글로벌안전공사</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">산업재해율</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-4-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['accident_rate'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['accident_rate'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">근로손실재해율(LTIFR)</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명/백만시간</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['lost_time_accident_rate'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['lost_time_accident_rate'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">안전보건경영시스템<br>(ISO 45001) 적용 사업장 비율</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">%</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">개인정보</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보 유출 건수</td>
                                                                <td style="text-align: center; vertical-align: middle;">-</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 418</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">건</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['personal_data_count'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['personal_data_count']); ?>)</td>                                                                                    
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">개인정보보호교육<br>수료 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-정보보호-추가1</td>
                                                                <td style="text-align: center; vertical-align: middle;">GRI 404</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">연간</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo number_format($twoYearsAgoMonthlyData['mandatory_edu'][12]); ?></td>
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">지역사회</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">사회공헌(기부) 금액</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-7-1</td>
                                                                <td style="text-align: center; vertical-align: middle;" rowspan="2">GRI 413</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">월간</td>
                                                                <td style="text-align: center; vertical-align: middle;">백만원</td>
                                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                    <td style="text-align: center; vertical-align: middle;">
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['donation_amount'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['donation_amount']); ?>)</td>  
                                                                <td style="text-align: center; vertical-align: middle;"></td>
                                                                <td style="text-align: center; vertical-align: middle;">x</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="2">구성원 봉사활동 참여 인원</td>
                                                                <td style="text-align: center; vertical-align: middle;">S-7-2</td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                                <td style="text-align: center; vertical-align: middle;">분기별</td>
                                                                <td style="text-align: center; vertical-align: middle;">명</td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean1Minus2YY['COU'] ?? ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean2Minus2YY['COU'] ?? ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean3Minus2YY['COU'] ?? ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;" colspan="3"><?php echo $Data_Clean4Minus2YY['COU'] ?? ''; ?></td>
                                                                <td style="text-align: center; vertical-align: middle;">
                                                                    <?php
                                                                        $sum = 0;
                                                                        $count = 0;
                                                                        if(isset($Data_Clean1Minus2YY['COU'])) { $sum += $Data_Clean1Minus2YY['COU']; $count++; }
                                                                        if(isset($Data_Clean2Minus2YY['COU'])) { $sum += $Data_Clean2Minus2YY['COU']; $count++; }
                                                                        if(isset($Data_Clean3Minus2YY['COU'])) { $sum += $Data_Clean3Minus2YY['COU']; $count++; }
                                                                        if(isset($Data_Clean4Minus2YY['COU'])) { $sum += $Data_Clean4Minus2YY['COU']; $count++; }
                                                                        echo $count > 0 ? round($sum/$count, 2) : '';
                                                                    ?>
                                                                </td>
                                                                <td style="text-align: center; vertical-align: middle;"><a href="https://develop.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">참여인원 바로가기</a></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>   
                                            <div class="chart tab-pane" id="esg_g_two_years_ago" style="position: relative;">
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
                                                                <th style="text-align: center; vertical-align: middle;">1월</th>
                                                                <th style="text-align: center; vertical-align: middle;">2월</th>
                                                                <th style="text-align: center; vertical-align: middle;">3월</th>
                                                                <th style="text-align: center; vertical-align: middle;">4월</th>
                                                                <th style="text-align: center; vertical-align: middle;">5월</th>
                                                                <th style="text-align: center; vertical-align: middle;">6월</th>
                                                                <th style="text-align: center; vertical-align: middle;">7월</th>
                                                                <th style="text-align: center; vertical-align: middle;">8월</th>
                                                                <th style="text-align: center; vertical-align: middle;">9월</th>
                                                                <th style="text-align: center; vertical-align: middle;">10월</th>
                                                                <th style="text-align: center; vertical-align: middle;">11월</th>
                                                                <th style="text-align: center; vertical-align: middle;">12월</th>
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['environmental_violation'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['environmental_violation']); ?>)</td> 
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['social_violation'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['social_violation']); ?>)</td> 
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['governance_violation'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['governance_violation']); ?>)</td> 
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['statutory_penalty'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['statutory_penalty']); ?>)</td> 
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
                                                                        <?php echo number_format($twoYearsAgoMonthlyData['ethics_rate'][$i] ?? 0); ?>
                                                                    </td>
                                                                <?php endfor; ?>
                                                                <td style="text-align: center; vertical-align: middle;">(<?php echo number_format($twoYearsAgoYearlyAverages['ethics_rate']); ?>)</td> 
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
                                                                <td style="text-align: center; vertical-align: middle;" colspan="12"><?php echo $Data_Edu3['COU']?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><?php echo $Data_Edu3['COU']?></td>
                                                                <td style="text-align: center; vertical-align: middle;"><a href="https://fms.iwin.kr/kjwt_sign/sign_select.php" style="color: blue; text-decoration: underline;">수료인원 바로가기</a></td>
                                                                <td style="text-align: center; vertical-align: middle;">ㅇ</td>
                                                            </tr>
                                                        </body>
                                                    </table> 
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
                        <!-- end !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
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
    if(isset($connect)) { sqlsrv_close($connect); }
?>

