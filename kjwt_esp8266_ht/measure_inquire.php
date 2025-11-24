<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.19>
	// Description:	<온습도 조회>	
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include_once __DIR__ . '/measure_total_status.php';

    // Helper function for safely echoing variables to prevent XSS
    function h($variable) {
        return htmlspecialchars($variable ?? '', ENT_QUOTES, 'UTF-8');
    }
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
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">온습도 조회</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">
                                    <h6 class="m-0 font-weight-bold text-primary">공지</h6>
                                </a>
                                <div class="collapse" id="collapseCardExample1">
                                    <div class="card-body">
                                            [목표]<BR>
                                            - 온습도 검침 자동화<BR><BR>   
                                            [기능]<br>
                                            - 1시간 간격으로 온습도 측정<br>
                                            - 운영기준 온도를 벗어나면 알림메일 발송<br><br>  
                                            [운영기준]<br>
                                            - 전산실 운영기준 온습도 | 온도: 18~25(℃) / 습도: 35~55(%)<br>
                                            - 시험실 운영기준 온습도 | 온도: 21~25(℃) / 습도: 40~60(%)<br>
                                            - 현장 운영기준 온습도 | 온도: 22~28(℃) / 습도: 40~60(%)<br>
                                            - 수입검사실 운영기준 온습도(하절기 4~10월) | 온도: 18~28(℃) / 습도: 30~60(%)<br>
                                            - 수입검사실 운영기준 온습도(동절기 11~3월) | 온도: 13~23(℃) / 습도: 30~60(%)<br><br>  
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 사무직<br>
                                            - 시험실 A구역: 출입구 주변 / 시험실 B구역: 챔버 주변<br>   
                                            - WIFI모듈: ESP8266 / 온습도센서: DHT22 (온도 범위 : -40-80 ℃ ± 0.5 ℃ / 습도 범위 : 20~90% RH ± 2 % RH)<br><br>
                                            [제작일]<BR>
                                            - 21.11.18<br><br>                          
                                    </div>
                                </div>
                            </div>
                        </div>            

                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                    <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                                </a>
                                <form method="POST" autocomplete="off" action="measure_inquire.php"> 
                                    <div class="collapse show" id="collapseCardExample21">                                    
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>위치</label>
                                                        <select name="location" class="form-control select2" style="width: 100%;">
                                                            <option value="" selected="selected">선택</option>
                                                            <option value="1">생산현장</option>
                                                            <option value="2">자재창고</option>
                                                            <option value="3">B/B창고</option>
                                                            <option value="4">완성품창고</option>
                                                            <option value="5">ECU창고</option>
                                                            <option value="6">IR워머</option>
                                                            <option value="8">전산실</option>
                                                            <option value="9">시험실A구역</option>
                                                            <option value="10">시험실B구역</option>
                                                            <option value="11">수입검사실</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>검색범위</label>
                                                        <div class="input-group">                                                
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                                            <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt2); ?>" name="dt2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 
                                        <div class="card-footer text-right">
                                            <button type="submit" value="on" class="btn btn-primary" name="bt21">검색</button>
                                        </div>
                                    </div>
                                </form>             
                            </div>
                        </div>                            

                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample3" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample3">
                                    <h6 class="m-0 font-weight-bold text-primary">결과</h6>
                                </a>
                                <div class="collapse show" id="collapseCardExample3">
                                    <div class="card-body table-editable">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6 mb-2"><div class="card border-left-success shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-success text-uppercase mb-1">검색위치</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($location); ?></div></div><div class="col-auto"><i class="fas fa-map-marker-alt fa-2x text-gray-300"></i></div></div></div></div></div>
                                            <div class="col-xl-4 col-md-6 mb-2"><div class="card border-left-danger shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-danger text-uppercase mb-1">최근온도</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($row2['temperature'] ?? ''); ?></div></div><div class="col-auto"><i class="fas fa-temperature-high fa-2x text-gray-300"></i></div></div></div></div></div>
                                            <div class="col-xl-4 col-md-6 mb-2"><div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">최근습도</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($row2['humidity'] ?? ''); ?></div></div><div class="col-auto"><i class="fas fa-tint fa-2x text-gray-300"></i></div></div></div></div></div>
                                        </div>
                                        <table class="table table-bordered table-striped" id="table_ht">
                                            <thead><tr><th>측정일자</th><th>온도(℃)</th><th>습도(%)</th></tr></thead>
                                            <tbody>
                                                <?php if (isset($result1)): while($row1 = $result1->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo h($row1['DT']); ?></td>
                                                        <td><?php echo h($row1['temperature']); ?></td>
                                                        <td><?php echo h($row1['humidity']); ?></td>
                                                    </tr>
                                                <?php endwhile; endif; ?>
                                            </tbody>
                                        </table>                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
    <?php include '../plugin_lv1.php'; ?>
</body>
</html>
<?php if(isset($connect4)) { mysqli_close($connect4); } ?>