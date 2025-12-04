<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <24.08.21>
    // Description: <관리자 화면>
    // Last Modified: <25.09.11> - Refactored for PHP 8.x, Security, and Stability
    // =============================================
    include_once realpath('admin_status.php');

    //renderStatus() 함수: 상태 확인 로직을 함수로 추출
    function renderStatus($condition) {
        $condition = filter_var($condition, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        return $condition ? "<td style='text-align: center; background-color: red;'>비정상</td>" : "<td style='text-align: center;'>정상</td>";
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include_once realpath('../head_lv1.php'); ?> 
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">      
        <!-- 매뉴 -->
        <?php include_once realpath('../nav.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">일일체크리스트</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2; ?>" id="tab-two" data-toggle="pill" href="#tab2">체크리스트</a>
                                        </li>    
                                    </ul>
                                </div>

                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 -->
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 전산 담당자가 확인해야 하는 체크리스트<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 경영팀<br><br>

                                            [제작일]<BR>
                                            - 24.08.21<br><br>
                                        </div>

                                        <!-- 2번째 탭 -->
                                        <div class="tab-pane fade <?php echo $tab2_text; ?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">체크리스트</h1>
                                                    </a>

                                                    <form method="POST" autocomplete="off" action="admin.php">
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="text-align: center;">분류</th>
                                                                                <th style="text-align: center;">설명</th>
                                                                                <th style="text-align: center;">체크</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody> 
                                                                        <?php 
                                                                            $statuses = [
                                                                                ['분류' => '홈페이지', '설명' => '홈페이지 접속확인', '상태' => homepage('https://www.iwin.kr/index') < 200 || homepage('https://www.iwin.kr/index') >= 400],
                                                                                ['분류' => 'API', '설명' => '휘발유, 경유, LPG 가격 데이터 획득 여부', '상태' => empty($oilGasolineData) || empty($oilDieselData) || empty($oilLpgData) || ($oilGasolineData['PRICE'] < $oilDieselData['PRICE'])],
                                                                                ['분류' => '현장', '설명' => '데이터 출력 속도 증가를 위한 DB의 전일 데이터 이동 유무 (검사-베트남)', '상태' => $Count_FieldVietnam > 0],
                                                                                ['분류' => '', '설명' => '데이터 출력 속도 증가를 위한 DB의 전일 데이터 이동 유무 (검사-한국)', '상태' => $Count_FieldKorea > 0],
                                                                                ['분류' => '', '설명' => '데이터 출력 속도 증가를 위한 DB의 전일 데이터 이동 유무 (완성품 입고)', '상태' => $Count_FieldInput > 0],
                                                                                ['분류' => '', '설명' => '데이터 출력 속도 증가를 위한 DB의 전일 데이터 이동 유무 (완성품 출하)', '상태' => $Count_FieldOutput > 0],
                                                                                ['분류' => '레포트', '설명' => '수도 비용 업데이트 유무', '상태' => $Data_Fee['WATER'] == ''],
                                                                                ['분류' => '', '설명' => '가스 비용 업데이트 유무', '상태' => $Data_Fee['GAS'] == ''],
                                                                                ['분류' => '', '설명' => '전기 비용 업데이트 유무', '상태' => $Data_Fee['ELECTRICITY'] == ''],
                                                                                ['분류' => '', '설명' => '급여 비용 업데이트 유무', '상태' => $Data_Fee['PAY'] == ''],
                                                                                ['분류' => '', '설명' => '도급비 비용 업데이트 유무', '상태' => $Data_Fee['PAY2'] == ''],
                                                                                ['분류' => '', '설명' => '선박이름 비용 업데이트 유무', '상태' => $Data_Fee['vessel'] == ''],
                                                                                ['분류' => '온습도', '설명' => '현장', '상태' => $humidityCounts['f_count'] == ''],
                                                                                ['분류' => '', '설명' => '자재창고', '상태' => $humidityCounts['m_count'] == ''],
                                                                                ['분류' => '', '설명' => '바이백창고', '상태' => $humidityCounts['b_count'] == ''],
                                                                                ['분류' => '', '설명' => '완성품창고', '상태' => $humidityCounts['fs_count'] == ''],
                                                                                ['분류' => '', '설명' => 'ECU창고', '상태' => $humidityCounts['e_count'] == ''],
                                                                                ['분류' => '', '설명' => '마스크창고', '상태' => $humidityCounts['ms_count'] == ''],
                                                                                ['분류' => '', '설명' => '전산실', '상태' => $humidityCounts['srv_count'] == ''],
                                                                                ['분류' => '', '설명' => '시험실A구역', '상태' => $humidityCounts['testA_count'] == ''],
                                                                                ['분류' => '', '설명' => '시험실B구역', '상태' => $humidityCounts['testB_count'] == ''],
                                                                                ['분류' => '', '설명' => '수입검사실', '상태' => $humidityCounts['qc_count'] == ''],
                                                                                // Add more rows as needed...
                                                                            ];

                                                                            foreach ($statuses as $status) {
                                                                                echo "<tr>";
                                                                                if($status['분류']=='현장') {
                                                                                    echo "<td rowspan=4 style='text-align: center; vertical-align: middle;'>" . htmlspecialchars($status['분류'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                                                }
                                                                                elseif($status['분류']=='레포트') {
                                                                                    echo "<td rowspan=6 style='text-align: center; vertical-align: middle;'>" . htmlspecialchars($status['분류'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                                                }
                                                                                elseif($status['분류']=='온습도') {
                                                                                    echo "<td rowspan=10 style='text-align: center; vertical-align: middle;'>" . htmlspecialchars($status['분류'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                                                }                                                                                
                                                                                elseif($status['분류']!='') {
                                                                                    echo "<td style='text-align: center; vertical-align: middle;'>" . htmlspecialchars($status['분류'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                                                }
                                                                                echo "<td>" . htmlspecialchars($status['설명'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                                                echo renderStatus($status['상태']);
                                                                                echo "</tr>";
                                                                            }
                                                                            ?>     
                                                                        </tbody>
                                                                    </table>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </form> 
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
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include_once realpath('../plugin_lv1.php'); ?>
</body>
</html>

<?php 
    // 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }
    if(isset($connect)) { sqlsrv_close($connect); }
?>