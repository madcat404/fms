<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.07.21>
	// Description:	<경비실 당숙일지>
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
    include 'guard_status.php';

    // XSS 방지를 위한 헬퍼 함수
    function e($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    function formatDate($dateObject) {
        if ($dateObject instanceof DateTime) {
            return $dateObject->format("Y-m-d H:i:s");
        }
        return '';
    }
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
    <style>
        /* 모바일 최적화: 작은 화면에서 글자 크기 조정 */
        @media (max-width: 768px) {
            .h3 { font-size: 1.25rem; }
            .card-body, .form-control, .input-group-text, .btn { font-size: 0.9rem; }
            .table { font-size: 0.8rem; }
        }
        .mobile-search-input { height: 50px; font-size: 1.1rem; border-radius: 0; background-color: #ffffff !important; color: #495057; border: 1px solid #d1d3e2; }
        .mobile-search-input::placeholder { color: #858796; }
        .mobile-search-btn { width: 60px; border-radius: 0; }
    </style>
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">당숙일지</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 -->
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item"><a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a></li>
                                        <li class="nav-item"><a class="nav-link <?php echo $tab2_text;?>" id="tab-two" data-toggle="pill" href="#tab2">당숙일지</a></li>
                                        <li class="nav-item"><a class="nav-link <?php echo $tab3_text;?>" id="tab-three" data-toggle="pill" href="#tab3">순찰</a></li>
                                        <li class="nav-item"><a class="nav-link <?php echo $tab4_text;?>" id="tab-four" data-toggle="pill" href="#tab4">방문자</a></li>
                                        <li class="nav-item"><a class="nav-link <?php echo $tab5_text;?>" id="tab-five" data-toggle="pill" href="#tab5">방문자조회</a></li>
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭: 공지 --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 당숙일지 전산화<BR><BR>
                                            [기능]<BR>
                                            0. 공통<BR>
                                            - 방문시간 입력칸 클릭 시 방문시간을 선택할 수 있는 팝업창 생성 <BR>
                                            1. 당숙일지탭<BR>
                                            - 순찰카드 특이사항 입력 시 또는 기존입력값과 다른경우 hr@iwin.kr로 알림메일 발송 <BR><BR>
                                            [히스토리]<BR>
                                            24.02.14) 캡스, 세콤과 같이 NFC가 부착된 위치를 태그하여 경비 실적 기록<BR>
                                            23.02.20) 레포트 경영탭에 경비보고서 바로가기 카드를 생성하였는데 해당 일지에 방문자에 대한 내용 삽입하기를 원하여 해당 내용을 입력할 수 있는 방문자탭을 생성함 (변상주CJ 요청)<BR>
                                            25.02.12) 순찰 특이사항이 업데이트 될때마다 메일이 발송되었는데, 전일 특이사항이 있는 경우 당일 1회 발송되도록 함 (192.168.0.222 서버로 스케쥴링)<BR>
                                            25.06.23) 시험실 물샘 이슈와 라운지 에어컨 꺼짐을 확인하기 위한 순찰 포인트 추가<BR>
                                            - 순찰탭을 모바일에서 확인 시 심플하게 보여지도록 변경하였음<BR><BR>
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 경비원<br>
                                            - 주야 2교대 (24시간) <br>
                                            - 순찰시간 (20:00~22:00 / 05:30~06:30)<br>
                                            - nfc 삽입값 예시: https://fms.iwin.kr/kjwt_guard/guard.php?nfc=on&area=NFC8&key=6218132365<br><br>
                                            [제작일]<BR>
                                            - 23.07.21<br><br>      
                                        </div>

                                        <!-- 2번째 탭: 당숙일지 --> 
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="row">
                                                <form method="POST" autocomplete="off" action="guard.php">
                                                    <!-- 근무자 -->
                                                    <div class="col-lg-12">
                                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button></div>
                                                        <div class="card shadow mb-4">
                                                            <a href="#collapseCardExample20" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample20">
                                                                <h1 class="h6 m-0 font-weight-bold text-primary">근무자</h1>
                                                            </a>
                                                            <div class="collapse show" id="collapseCardExample20">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>선택</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                                                            <select name="guard" class="form-control">
                                                                                <option value="" <?php if (empty($Data_Guard['GUARD'])) echo 'selected'; ?>>선택</option>
                                                                                <option value="곽창욱" <?php if (($Data_Guard['GUARD'] ?? '') === '곽창욱') echo 'selected'; ?>>곽창욱</option>
                                                                                <option value="김진일" <?php if (($Data_Guard['GUARD'] ?? '') === '김진일') echo 'selected'; ?>>김진일</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- VIP 방문, 휴일방문, 법인차, 순찰 특이사항 -->
                                                    <?php 
                                                        $sections = [
                                                            'VIP방문' => ['vip', [1, 2, 3]],
                                                            '휴일방문직원' => ['week', [1, 2, 3, 4]],
                                                        ];
                                                        foreach ($sections as $title => $section) {
                                                            list($prefix, $indices) = $section;
                                                    ?>
                                                    <div class="col-lg-12">
                                                        <div class="card shadow mb-4">
                                                            <a href="#collapseCard-<?php echo $prefix; ?>" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true">
                                                                <h1 class="h6 m-0 font-weight-bold text-primary"><?php echo $title; ?></h1>
                                                            </a>
                                                            <div class="collapse show" id="collapseCard-<?php echo $prefix; ?>">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                    <?php foreach ($indices as $index) { 
                                                                        $key_base = strtoupper($prefix) . $index;
                                                                        $time_id = $prefix . 'time' . $index;
                                                                        $db_key_base = ($prefix === 'week') ? 'HOLIDAY' . $index : $key_base;
                                                                    ?>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label>대상</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                                                                    <input type="text" class="form-control" name="<?php echo $prefix . $index . '1'; ?>" value="<?php echo e($Data_Guard[$db_key_base] ?? ''); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label>방문시간</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                                                                                    <input type="text" class="form-control float-right time-range-picker" id="<?php echo $time_id; ?>" name="<?php echo $prefix . $index . '2'; ?>" value="<?php echo e($Data_Guard[$db_key_base . '_TIME'] ?? ''); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>

                                                    <div class="col-lg-12">
                                                        <div class="card shadow mb-4">
                                                            <a href="#collapseCard-car" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true">
                                                                <h1 class="h6 m-0 font-weight-bold text-primary">전산관리 외 법인차</h1>
                                                            </a>
                                                            <div class="collapse show" id="collapseCard-car">
                                                                <div class="card-body">
                                                                    <input type="text" class="form-control" name="car1" value="<?php echo e($Data_Guard['COMPANY_CAR'] ?? '3101(G90), 1156(벤츠), 5210(쏘나타), 0300(씨에나)'); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="card shadow mb-4">
                                                            <a href="#collapseCard-note" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true">
                                                                <h1 class="h6 m-0 font-weight-bold text-primary">순찰 특이사항</h1>
                                                            </a>
                                                            <div class="collapse show" id="collapseCard-note">
                                                                <div class="card-body">
                                                                    <textarea rows="5" class="form-control" name="note"><?php echo e($Data_Guard['NOTE'] ?? ''); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button></div>
                                                    </div>

                                                    
                                                </form>
                                            </div>
                                        </div>

                                        <!-- 3번째 탭: 순찰 -->
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <?php if(isMobile()): ?>
                                                <p>※ NFC 태그 위치와 순찰시간은 PC로 확인 가능합니다!</p>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th>위치</th>
                                                                <th>순찰1</th>
                                                                <th>순찰2</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php for ($i = 1; $i <= 13; $i++): ?>
                                                            <tr>
                                                                <th style="text-align: center; vertical-align: middle;"><?php echo ['','와인딩실','ECU창고','완성품창고','B/B창고','자재창고','공무실','시험실','서버실','기숙사','식당','마스크창고','시험실챔버','라운지'][$i]; ?></th>
                                                                <td style="text-align: center; vertical-align: middle;"><input type='checkbox' style='zoom: 2;' <?php echo !empty($Data_TodayCheckList["NFC{$i}_TIME1"]) ? 'checked' : ''; ?> disabled></td>
                                                                <td style="text-align: center; vertical-align: middle;"><input type='checkbox' style='zoom: 2;' <?php echo !empty($Data_TodayCheckList["NFC{$i}_TIME2"]) ? 'checked' : ''; ?> disabled></td>
                                                            </tr>
                                                            <?php endfor; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php else: ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card shadow mb-4">
                                                        <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h1 class="h6 m-0 font-weight-bold text-primary">순찰</h1></a>
                                                        <form method="POST" autocomplete="off" action="guard.php">
                                                            <div class="collapse show" id="collapseCardExample31">
                                                                <div class="card-body">
                                                                    <div class="table-responsive p-2">
                                                                        <div id="table" class="table-editable"> 
                                                                        <table class="table table-bordered" id="table6">
                                                                            <thead class="text-center">
                                                                                <tr>
                                                                                    <th>구분</th>
                                                                                    <th>NFC 위치</th>
                                                                                    <th>착안점</th>
                                                                                    <th>점검</th>
                                                                                    <th>점검시간1</th>
                                                                                    <th>점검시간2</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php 
                                                                                    $nfc_points = [
                                                                                        1 => ['와인딩실', '시건, 화재, 소등, 냉/난방기, 환풍기'], 2 => ['ECU 창고', '시건, 화재, 소등, 냉/난방기, 환풍기'],
                                                                                        3 => ['완성품 창고', '시건, 화재, 소등, 냉/난방기, 환풍기'], 4 => ['B/B 창고', '시건, 화재, 소등, 냉/난방기, 환풍기'],
                                                                                        5 => ['자재창고', '시건, 화재, 소등, 냉/난방기, 환풍기'], 6 => ['공무실', '시건, 화재, 소등, 냉/난방기, 환풍기'],
                                                                                        7 => ['시험실', '시건, 화재, 소등'], 8 => ['서버실', '화재, 소등'], 9 => ['기숙사', '시건, 화재, 소등'],
                                                                                        10 => ['식당', '시건, 화재, 소등, 물샘'], 11 => ['마스크창고', '시건, 화재, 소등, 냉/난방기, 환풍기'],
                                                                                        12 => ['시험실챔버', '누수, 화재'], 13 => ['라운지', '냉/난방기, 소등']
                                                                                    ];
                                                                                ?>
                                                                                <tr>
                                                                                    <th rowspan="13" style="vertical-align: middle; text-align: center;">NFC</th>
                                                                                    <td><?php echo $nfc_points[1][0]; ?></td>
                                                                                    <td><?php echo $nfc_points[1][1]; ?></td>
                                                                                    <td style="text-align: center;"><input type='checkbox' style='zoom: 2;' <?php echo ($Data_TodayCheckList["NFC1"] ?? '') === 'on' ? 'checked' : ''; ?> disabled></td>
                                                                                    <td><?php echo formatDate($Data_TodayCheckList["NFC1_TIME1"] ?? null); ?></td>
                                                                                    <td><?php echo formatDate($Data_TodayCheckList["NFC1_TIME2"] ?? null); ?></td>
                                                                                </tr>
                                                                                <?php for ($i = 2; $i <= 13; $i++): ?>
                                                                                <tr>
                                                                                    <td><?php echo $nfc_points[$i][0]; ?></td>
                                                                                    <td><?php echo $nfc_points[$i][1]; ?></td>
                                                                                    <td style="text-align: center;"><input type='checkbox' style='zoom: 2;' <?php echo ($Data_TodayCheckList["NFC{$i}"] ?? '') === 'on' ? 'checked' : ''; ?> disabled></td>
                                                                                    <td><?php echo formatDate($Data_TodayCheckList["NFC{$i}_TIME1"] ?? null); ?></td>
                                                                                    <td><?php echo formatDate($Data_TodayCheckList["NFC{$i}_TIME2"] ?? null); ?></td>
                                                                                </tr>
                                                                                <?php endfor; ?>
                                                                            </tbody>
                                                                        </table>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>조치사항</label>
                                                                            <textarea rows="8" class="form-control" name="note31"><?php echo e($Data_TodayCheckList['NOTE'] ?? ''); ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt31">입력</button></div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- 4번째 탭: 방문자 -->
                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="tab4" role="tabpanel" aria-labelledby="tab-four">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card shadow mb-4">
                                                        <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h1 class="h6 m-0 font-weight-bold text-primary">입력</h1></a>
                                                        <form method="POST" autocomplete="off" action="guard.php">
                                                            <div class="collapse show" id="collapseCardExample41">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>업체명</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-building"></i></span></div>
                                                                                    <input type="text" class="form-control" name="name41" autofocus required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>방문목적</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clipboard"></i></span></div>
                                                                                    <input type="text" class="form-control" name="purpose41" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>방문시간</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                                                                                    <input type="text" class="form-control float-right time-range-picker" id="time41" name="time41" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt41">입력</button></div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card shadow mb-4">
                                                        <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h1 class="h6 m-0 font-weight-bold text-primary">금일기록</h1></a>
                                                        <form method="POST" autocomplete="off" action="guard.php">
                                                            <div class="collapse show" id="collapseCardExample42">
                                                                <div class="card-body p-2">
                                                                    <?php if (function_exists('ModifyData2')) ModifyData2("guard.php?modi=Y", "bt42", "Guard"); ?>
                                                                    <?php
                                                                        $todays_guests = [];
                                                                        if (isset($Result_GuestToday)) {
                                                                            while($row = sqlsrv_fetch_array($Result_GuestToday, SQLSRV_FETCH_ASSOC)) {
                                                                                $todays_guests[] = $row;
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <?php if(isMobile()): ?>
                                                                    <!-- Mobile Card View -->
                                                                    <div class="d-md-none">
                                                                        <?php
                                                                            $i = 0;
                                                                            foreach($todays_guests as $Data_GuestToday) {
                                                                                $i++;
                                                                        ?>
                                                                        <div class="card shadow-sm mb-3">
                                                                            <div class="card-header py-3">
                                                                                <h6 class="m-0 font-weight-bold text-primary"><?php echo e($Data_GuestToday["NAME"]); ?></h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <input name='NO<?php echo $i; ?>' value='<?php echo e($Data_GuestToday["NO"]); ?>' type='hidden'>
                                                                                <?php if($modi=='Y'): ?>
                                                                                    <div class="form-group"><label>업체명</label><input value='<?php echo e($Data_GuestToday["NAME"]); ?>' name='NAME<?php echo $i; ?>' type='text' class='form-control'></div>
                                                                                    <div class="form-group"><label>방문목적</label><input value='<?php echo e($Data_GuestToday["PURPOSE"]); ?>' name='PURPOSE<?php echo $i; ?>' type='text' class='form-control'></div>
                                                                                    <div class="form-group"><label>방문시간</label><input value='<?php echo e($Data_GuestToday["DT"]); ?>' name='DT<?php echo $i; ?>' type='text' class='form-control time-range-picker'></div>
                                                                                <?php else: ?>
                                                                                    <p class="mb-1"><strong>방문목적:</strong> <?php echo e($Data_GuestToday["PURPOSE"]); ?></p>
                                                                                    <p class="mb-0"><strong>방문시간:</strong> <?php echo e($Data_GuestToday["DT"]); ?></p>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <?php else: ?>
                                                                    <!-- Desktop Table -->
                                                                    <div class="d-none d-md-block table-responsive">
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead><tr><th>업체명</th><th>방문목적</th><th>방문시간</th></tr></thead>
                                                                            <tbody>
                                                                                <?php 
                                                                                    $i = 0;
                                                                                    foreach($todays_guests as $Data_GuestToday) {
                                                                                        $i++;
                                                                                ?>
                                                                                <tr>
                                                                                    <input name='NO<?php echo $i; ?>' value='<?php echo e($Data_GuestToday["NO"]); ?>' type='hidden'>
                                                                                    <td><?php if($modi=='Y') { ?><input value='<?php echo e($Data_GuestToday["NAME"]); ?>' name='NAME<?php echo $i; ?>' type='text' class='form-control'> <?php } else { echo e($Data_GuestToday["NAME"]); } ?></td>
                                                                                    <td><?php if($modi=='Y') { ?><input value='<?php echo e($Data_GuestToday["PURPOSE"]); ?>' name='PURPOSE<?php echo $i; ?>' type='text' class='form-control'> <?php } else { echo e($Data_GuestToday["PURPOSE"]); } ?></td>
                                                                                    <td><?php if($modi=='Y') { ?><input value='<?php echo e($Data_GuestToday["DT"]); ?>' name='DT<?php echo $i; ?>' type='text' class='form-control time-range-picker'> <?php } else { echo e($Data_GuestToday["DT"]); } ?></td>
                                                                                </tr>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <?php endif; ?>
                                                                    <input type="hidden" name="until" value="<?php echo $i; ?>">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 5번째 탭: 방문자조회 -->
                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="tab5" role="tabpanel" aria-labelledby="tab-five">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card shadow mb-4">
                                                        <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h1 class="h6 m-0 font-weight-bold text-primary">검색</h1></a>
                                                        <form method="POST" autocomplete="off" action="guard.php">
                                                            <div class="collapse show" id="collapseCardExample51">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>검색범위</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                                                            <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo e($_POST['dt5'] ?? date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt5">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt51">검색</button></div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card shadow mb-4">
                                                        <a href="#collapseCardExample52" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h1 class="h6 m-0 font-weight-bold text-primary">결과</h1></a>
                                                        <div class="collapse show" id="collapseCardExample52">
                                                            <div class="card-body p-2">
                                                                <?php
                                                                    $visitor_history = [];
                                                                    if (isset($Result_GuestChk)) {
                                                                        while($row = sqlsrv_fetch_array($Result_GuestChk, SQLSRV_FETCH_ASSOC)) {
                                                                            $visitor_history[] = $row;
                                                                        }
                                                                    }
                                                                ?>
                                                                <!-- Mobile Search -->
                                                                <div class="d-md-none mb-3">
                                                                    <div class="input-group">
                                                                        <input type="text" id="mobile-search-visitor-history" class="form-control mobile-search-input" placeholder="업체명, 목적으로 검색...">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-primary mobile-search-btn" type="button"><i class="fas fa-search"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Desktop Table -->
                                                                <div class="d-none d-md-block table-responsive">
                                                                    <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                        <thead><tr><th>업체명</th><th>방문목적</th><th>방문시간</th></tr></thead>
                                                                        <tbody>
                                                                        <?php foreach($visitor_history as $Data_GuestChk): ?>
                                                                            <tr>
                                                                                <td><?php echo e($Data_GuestChk['NAME']); ?></td>
                                                                                <td><?php echo e($Data_GuestChk['PURPOSE']); ?></td>
                                                                                <td><?php echo e($Data_GuestChk['DT']); ?></td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <!-- Mobile Card View -->
                                                                <div class="d-md-none" id="mobile-card-container-visitor-history">
                                                                    <?php foreach($visitor_history as $Data_GuestChk): ?>
                                                                        <div class="card shadow-sm mb-3 mobile-card">
                                                                            <div class="card-header py-3">
                                                                                <h6 class="m-0 font-weight-bold text-primary"><?php echo e($Data_GuestChk['NAME']); ?></h6>
                                                                            </div>
                                                                            <div class="card-body p-3">
                                                                                <p class="mb-1"><strong>방문목적:</strong> <?php echo e($Data_GuestChk['PURPOSE']); ?></p>
                                                                                <p class="mb-0"><strong>방문시간:</strong> <?php echo e($Data_GuestChk['DT']); ?></p>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
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
                    </div> <!-- /.row -->
                </div> <!-- /.container-fluid -->
            </div> <!-- End of Main Content -->
        </div> <!-- End of Content Wrapper -->
    </div> <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>
    <script>
    $(function() {
        $('.time-range-picker').each(function() {
            var options = {
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 10,
                autoUpdateInput: false,
                locale: {
                    format: 'HH:mm',
                    separator: ' - ',
                    applyLabel: '확인',
                    cancelLabel: '취소',
                }
            };

            var initialVal = $(this).val();
            if (initialVal) {
                var times = initialVal.split(' - ');
                if (times.length === 2) {
                    options.startDate = moment(times[0], 'HH:mm');
                    options.endDate = moment(times[1], 'HH:mm');
                }
            }

            $(this).daterangepicker(options).on('show.daterangepicker', function(ev, picker) {
                picker.container.find(".calendar-table").hide();
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('HH:mm') + ' - ' + picker.endDate.format('HH:mm'));
            });
            
            if (!initialVal) {
                $(this).val('');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('mobile-search-visitor-history');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toUpperCase();
                const cards = document.querySelectorAll('#mobile-card-container-visitor-history .mobile-card');
                
                cards.forEach(function(card) {
                    const text = card.textContent || card.innerText;
                    if (text.toUpperCase().indexOf(filter) > -1) {
                        card.style.display = "";
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        }
    });
    </script>
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) { mysqli_close($connect4); }
    //MSSQL 메모리 회수
    if (isset($connect)) { sqlsrv_close($connect); }
?>
