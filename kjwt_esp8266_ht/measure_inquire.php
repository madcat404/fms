<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.19>
	// Description:	<온습도 조회 - 모바일 최적화 및 Select2 스크롤 튐 방지>	
    // Last Modified: <25.09.24>
	// =============================================
    
    // 로직 파일 포함
    include_once __DIR__ . '/measure_total_status.php';

    // XSS 방지 및 데이터 전처리
    function h($variable) {
        return htmlspecialchars($variable ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 변수 초기화
    $location = $location ?? '';
    $dt2 = $dt2 ?? '';
    $row2 = $row2 ?? []; 
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>    

    <style>
        /* 모바일 검색창 스타일 */
        .mobile-search-input {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 0;
            background-color: #ffffff !important;
            color: #495057;
            border: 1px solid #d1d3e2;
        }
        .mobile-search-input::placeholder {
            color: #858796;
        }
        .mobile-search-btn {
            width: 60px;
            border-radius: 0;
        }

        /* 모바일 화면 전용 스타일 */
        @media screen and (max-width: 768px) {
            
            /* DataTables 컨트롤 숨김 */
            .dt-buttons, 
            .dataTables_filter, 
            .dataTables_length,
            .dataTables_paginate .page-item {
                display: none !important;
            }
            /* 페이징 버튼 일부만 표시 */
            .dataTables_paginate .page-item.previous,
            .dataTables_paginate .page-item.next,
            .dataTables_paginate .page-item.active {
                display: block !important;
            }
            .dataTables_paginate ul.pagination {
                justify-content: center !important;
                margin-top: 10px;
            }

            /* 테이블 카드 뷰 변환 */
            .mobile-responsive-table thead {
                display: none;
            }
            .mobile-responsive-table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #fff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .mobile-responsive-table td {
                display: block;
                text-align: right;
                font-size: 0.9rem;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                padding-top: 10px;
                padding-bottom: 10px;
            }
            .mobile-responsive-table td:last-child {
                border-bottom: 0;
            }
            .mobile-responsive-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                font-weight: 700;
                text-align: left;
                color: #4e73df;
            }

            /* 데이터 없음 행 스타일 (중앙 정렬) */
            .mobile-responsive-table td.no-data {
                text-align: center !important;
                padding-left: 0.75rem !important;
                color: #858796;
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
            .mobile-responsive-table td.no-data::before {
                content: none !important;
            }
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">온습도 조회</h1>
                    </div>               

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">
                                    <h6 class="m-0 font-weight-bold text-primary">공지</h6>
                                </a>
                                <div class="collapse" id="collapseCardExample1">
                                    <div class="card-body p-3">
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
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6 col-12 mb-2">
                                                    <div class="form-group mb-0">
                                                        <label>위치</label>
                                                        <select name="location" class="form-control select2" style="width: 100%;">
                                                            <option value="" <?php echo ($location == '') ? 'selected' : ''; ?>>선택</option>
                                                            <option value="1" <?php echo ($location == '1') ? 'selected' : ''; ?>>생산현장</option>
                                                            <option value="2" <?php echo ($location == '2') ? 'selected' : ''; ?>>자재창고</option>
                                                            <option value="3" <?php echo ($location == '3') ? 'selected' : ''; ?>>B/B창고</option>
                                                            <option value="4" <?php echo ($location == '4') ? 'selected' : ''; ?>>완성품창고</option>
                                                            <option value="5" <?php echo ($location == '5') ? 'selected' : ''; ?>>ECU창고</option>
                                                            <option value="6" <?php echo ($location == '6') ? 'selected' : ''; ?>>IR워머</option>
                                                            <option value="8" <?php echo ($location == '8') ? 'selected' : ''; ?>>전산실</option>
                                                            <option value="9" <?php echo ($location == '9') ? 'selected' : ''; ?>>시험실A구역</option>
                                                            <option value="10" <?php echo ($location == '10') ? 'selected' : ''; ?>>시험실B구역</option>
                                                            <option value="11" <?php echo ($location == '11') ? 'selected' : ''; ?>>수입검사실</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-0">
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
                                    <div class="card-body table-responsive p-2">
                                        
                                        <div class="row">
                                            <div class="col-xl-4 col-md-4 col-12 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">검색위치</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php 
                                                                        $loc_name = '';
                                                                        switch($location) {
                                                                            case '1': $loc_name = '생산현장'; break;
                                                                            case '2': $loc_name = '자재창고'; break;
                                                                            case '3': $loc_name = 'B/B창고'; break;
                                                                            case '4': $loc_name = '완성품창고'; break;
                                                                            case '5': $loc_name = 'ECU창고'; break;
                                                                            case '6': $loc_name = 'IR워머'; break;
                                                                            case '8': $loc_name = '전산실'; break;
                                                                            case '9': $loc_name = '시험실A구역'; break;
                                                                            case '10': $loc_name = '시험실B구역'; break;
                                                                            case '11': $loc_name = '수입검사실'; break;
                                                                            default: $loc_name = $location;
                                                                        }
                                                                        echo h($loc_name ?: '-'); 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 col-12 mb-2">
                                                <div class="card border-left-danger shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">최근온도</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($row2['temperature'] ?? '-'); ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-temperature-high fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 col-12 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">최근습도</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($row2['humidity'] ?? '-'); ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-tint fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="table" class="table-editable mt-1">
                                            <table class="table table-bordered table-striped mobile-responsive-table" id="table_ht">
                                                <thead>
                                                    <tr>
                                                        <th>측정일자</th>
                                                        <th>온도(℃)</th>
                                                        <th>습도(%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $hasData = false;
                                                    if (isset($result1) && $result1) { 
                                                        while($row1 = $result1->fetch_assoc()): 
                                                            $hasData = true;
                                                    ?>
                                                        <tr>
                                                            <td data-label="측정일자"><?php echo h($row1['DT']); ?></td>
                                                            <td data-label="온도(℃)"><?php echo h($row1['temperature']); ?></td>
                                                            <td data-label="습도(%)"><?php echo h($row1['humidity']); ?></td>
                                                        </tr>
                                                    <?php 
                                                        endwhile; 
                                                    } 
                                                    
                                                    if (!$hasData):
                                                    ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center no-data">데이터가 없습니다.</td>
                                                        </tr>
                                                    <?php endif; ?>
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
    </div>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
    <?php include '../plugin_lv1.php'; ?>

    <script>
    $(document).ready(function() {
        // 모바일 기기(화면 폭 768px 이하) 또는 모바일 에이전트 감지
        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth <= 768;

        if (isMobile) {
            $('.select2').each(function() {
                // Select2가 초기화되어 있다면 해제(destroy)
                // Select2 라이브러리가 로드되었는지 확인 후 실행
                if ($.fn.select2 && $(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2('destroy');
                }
                // Select2 클래스 제거하여 스타일 초기화 (기본 form-control 스타일 사용)
                $(this).removeClass('select2');
            });
        }
    });
    </script>
</body>
</html>
<?php if(isset($connect4)) { mysqli_close($connect4); } ?>