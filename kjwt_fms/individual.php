<?php 
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>    
    // Create date: <21.10.12>
    // Description: <개인차량운행일지 리뉴얼 (정산 완료 시에만 환산표기)>
    // Last Modified: <Current Date> - PC View: Background Color Only / Mobile: Border Keep
    // =============================================
    include 'individual_status.php';   

    // 금일 유가가 업데이트 되었는지 확인
    $stmt = $connect->prepare("SELECT 1 FROM oil_call_check WHERE DT = ?");
    $stmt->bind_param("s", $select_date);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows < 1) {
        echo "<script>location.href='individual_oil_date.php';</script>";
        exit;
    }

    // 이미지 파일명 가져오는 함수
    function get_image_filename($connect, $car_num, $binding_num, $img_type) {
        $stmt = $connect->prepare("SELECT FILE_NM FROM files WHERE CAR_NUM = ? AND BINDING_NUM = ? AND IMG_TYPE = ? AND VIEW_YN = 'Y' ORDER BY NO DESC LIMIT 1");
        $stmt->bind_param("sis", $car_num, $binding_num, $img_type);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row['FILE_NM'] ?? null;
    }

    // 현황 데이터를 배열로 저장 (모바일/PC 뷰 공용)
    $status_data = [];
    if ($result1) {
        while ($row = $result1->fetch_assoc()) {
            // 사용자 이름 가져오기
            $user_stmt = $connect->prepare("SELECT USER_NM FROM user_info WHERE CAR_NUM = ?");
            $user_stmt->bind_param("s", $row['CAR_NUM']);
            $user_stmt->execute();
            $user_res = $user_stmt->get_result();
            $user_row = $user_res->fetch_assoc();
            $row['USER_NM'] = $user_row['USER_NM'] ?? '';

            // 이미지 파일명 가져오기
            $row['FILE_KM'] = get_image_filename($connect, $row['CAR_NUM'], $row['NO'], 'Km');
            $row['FILE_TOLL'] = get_image_filename($connect, $row['CAR_NUM'], $row['NO'], 'TollGate');

            $status_data[] = $row;
        }
    }

    // 로그인 사용자의 데이터를 리스트 최상단으로 정렬
    if (!empty($login_user_car_num)) {
        usort($status_data, function($a, $b) use ($login_user_car_num) {
            $a_is_me = ($a['CAR_NUM'] == $login_user_car_num);
            $b_is_me = ($b['CAR_NUM'] == $login_user_car_num);

            if ($a_is_me && !$b_is_me) return -1; // 내 데이터는 무조건 위로
            if (!$a_is_me && $b_is_me) return 1;  // 상대 데이터는 아래로
            return strcmp($a['CAR_NUM'], $b['CAR_NUM']);
        });
    }

    // *** 뷰 계산용 휘발유 가격 확보 ***
    $gasoline_price_for_view = $row11->OIL_PRICE ?? 0;
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>
    
    <style>
        /* [수정] PC 테이블 뷰: 테두리 제거하고 배경색만 변경 */
        tr.my-car-row > td {
            background-color: #ffecec !important; /* 연한 빨간색 배경 */
        }
    </style>
    
    <script language="javascript">
        function checkDisable(form)
        {
            form.tollgate.disabled = form.cb2.checked;
            form.tollgate2.disabled = form.cb3.checked;
        }
        // 이미지 확대 스크립트
        function bigimg(filepath){
            if (filepath) {
                window.open("../files/" + filepath, "bigimg", "width=800,height=800,scrollbars=yes"); 
            }
        }
        
        // 수정 모달 열기 함수
        function openEditModal(no, departure, destination, km, toll, car_num) {
            $('#edit_no').val(no);
            $('#edit_car_num').val(car_num);
            $('#edit_departure').val(departure);
            $('#edit_destination').val(destination);
            $('#edit_km').val(km);
            $('#edit_tollgate').val(toll);
            
            // 모달 띄우기
            $('#editModal').modal('show');
        }
    </script>
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">개인차 일지</h1>
                    </div>               

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">
                                    <h6 class="m-0 font-weight-bold text-primary">공지</h6>
                                </a>
                                <div class="collapse" id="collapseCardExample1">
                                    <div class="card-body p-3">
                                        <p class="mb-0 small">
                                            - 주행거리나 잔액을 잘못 입력했을 시 올바른 데이터를 한번 더 입력하시면 수정이 가능합니다.<br>   
                                            - 도착을 입력해야 회사 하이패스카드가 반납됩니다.<br>
                                            - 카카오맵, T맵, 네이버지도 등과 같은 앱을 캡처하여 업로드 바랍니다.<br> 
                                            - 사진 파일만 업로드 가능합니다.<br>
                                            - 기름티켓이 발급되면 현황에서 데이터가 사라집니다.<br>
                                            - [휘발유, 경유, LPG] 계산식 [정산=roundup((주행거리/10)+(톨비/자차유종가격))]<br>
                                            - [전기] 계산식 [정산=(주행거리/5*평균요금)+(톨비)]<br>
                                             ※ 무공해차 통합누리집 급속 비회원 평균요금으로 계산<br>
                                             ※ 검색 시 나오는 평균 연비 5km/kWh 적용 (25.12.26)<br>
                                            - 장안주유소 및 선암가스충전소 실시간 유가를 출력합니다.(한국석유공사 제공)<br>
                                            - ★장안주유소 주소: 부산광역시 기장군 장안읍 기장대로 1673<br>
                                            - ★선암가스충전소 주소: 부산광역시 기장군 장안읍 기장대로 1451<br>   
                                        </p>                                                    
                                    </div>
                                </div>
                            </div>
                        </div>            

                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                                    <h6 class="m-0 font-weight-bold text-primary">출발</h6>
                                </a>
                                <form method="POST" autocomplete="off" action="">
                                    <div class="collapse show" id="collapseCardExample2">                                   
                                        <div class="card-body p-3">
                                            <div class="row"> 
                                                <div class="col-md-3"><div class="form-group"><label>차량번호</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-car"></i></span></div><input type="number" maxlength="4" class="form-control" name="my_car_num1" required value="<?php echo htmlspecialchars($login_user_car_num); ?>"></div></div></div>
                                                <div class="col-md-3"><div class="form-group"><label>출발지</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span></div><input type="text" class="form-control" name="my_departure" required></div></div></div>
                                                <div class="col-md-3"><div class="form-group"><label>경유지/목적지</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-route"></i></span></div><input type="text" class="form-control" name="my_destination" required></div></div></div>
                                                <div class="col-md-3"><div class="form-group"><label>회사하이패스</label><select name="my_hipasscard" class="form-control select2" style="width: 100%;"><option value="" selected="selected">선택</option><option value="">회사하이패스 미사용</option><?php foreach ( $hipass_cards as $option ) : ?><option value="<?php echo htmlspecialchars((string)$option->NO, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($option->KIND, ENT_QUOTES, 'UTF-8'); ?></option><?php endforeach; ?></select></div></div>
                                            </div> 
                                        </div> 
                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt1">입력</button></div>
                                    </div>
                                </form>             
                            </div>
                        </div>                        

                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample3" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample3">
                                    <h6 class="m-0 font-weight-bold text-primary">도착</h6>
                                </a>
                                <form method="POST" autocomplete="off" action="">
                                    <div class="collapse show" id="collapseCardExample3">                                   
                                        <div class="card-body p-3">
                                            <div class="row">    
                                                <div class="col-md-3"><div class="form-group"><label>차량번호</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-car"></i></span></div><input type="number" maxlength="4" class="form-control" name="my_car_num2" required value="<?php echo htmlspecialchars($login_user_car_num); ?>"></div></div></div>
                                                <div class="col-md-3"><div class="form-group"><label>주행거리</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-exchange-alt"></i></span></div><input type="number" class="form-control" name="my_km" step="0.1" required></div></div></div>
                                                <div class="col-md-3"><div class="form-group"><label>회사 하이패스 잔액</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" checked="checked" name="cb2" onClick="checkDisable(this.form)"></span></div><input type="number" disabled class="form-control" name="tollgate" placeholder="사용 시 체크해제 후 입력"></div></div></div>
                                                <div class="col-md-3"><div class="form-group"><label>톨게이트비(개인지출비)</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" checked="checked" name="cb3" onClick="checkDisable(this.form)"></span></div><input type="number" disabled class="form-control" name="tollgate2" placeholder="발생 시 체크해제 후 입력"></div></div></div>
                                            </div> 
                                        </div> 
                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt2">입력</button></div>
                                    </div>
                                </form>             
                            </div>
                        </div>  
                        
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample4" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample4">
                                    <h6 class="m-0 font-weight-bold text-primary">증빙</h6>
                                </a>
                                <form method="POST" autocomplete="off" action="" enctype="multipart/form-data"> 
                                    <div class="collapse show" id="collapseCardExample4">                                   
                                        <div class="card-body p-3">
                                            <div class="row">    
                                                <div class="col-md-4"><div class="form-group"><label>차량번호</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-car"></i></span></div><input type="number" maxlength="4" class="form-control" name="my_car_num3" required value="<?php echo htmlspecialchars($login_user_car_num); ?>"></div></div></div>
                                                <div class="col-md-4"><div class="form-group"><label>업로드 파일종류</label><select name="img_type" class="form-control select2" style="width: 100%;"><option value="" selected="selected">선택</option><option value="Km">주행거리</option><option value="TollGate">톨게이트비</option></select></div></div>
                                                <div class="col-md-4"><div class="form-group"><label>파일선택</label><div class="custom-file"><input type="file" class="custom-file-input" id="file" name="file" required><label class="custom-file-label" for="file">파일선택</label></div></div></div>
                                            </div> 
                                        </div> 
                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt3">업로드</button></div>
                                    </div>
                                </form>             
                            </div>
                        </div> 
                        
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample6" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample6">
                                    <h6 class="m-0 font-weight-bold text-primary">관리자</h6>
                                </a>
                                <form method="POST" autocomplete="off" action=""> 
                                    <div class="collapse" id="collapseCardExample6">                                   
                                        <div class="card-body p-3">
                                            <div class="row">    
                                                <div class="col-md-6"><div class="form-group"><label>차량번호 또는 all 명령어</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-car"></i></span></div><input type="text" maxlength="4" class="form-control" name="my_car_num5" required></div></div></div>
                                                <div class="col-md-6"><div class="form-group"><label>패스워드</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div><input type="password" class="form-control" name="my_admin_code"></div></div></div>
                                            </div> 
                                        </div> 
                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt4">입력</button></div>
                                    </div>
                                </form>             
                            </div>
                        </div> 
                        
                        <div class="col-xl-3 col-md-6 mb-2">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">휘발유</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($row11->OIL_PRICE ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?> 원</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-oil-can fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-2">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">경유</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($row22->OIL_PRICE ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?> 원</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-oil-can fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-2">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">LPG</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($row33->OIL_PRICE ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?> 원</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-gas-pump fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-2">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">전기 (급속/비회원)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($row44->OIL_PRICE ?? '0', ENT_QUOTES, 'UTF-8'); ?> 원</div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-bolt fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-2">
                                <a href="#collapseCardExample5" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample5">
                                    <h6 class="m-0 font-weight-bold text-primary">현황</h6>
                                </a>
                                <div class="collapse show" id="collapseCardExample5">
                                    <div class="card-body p-2">
                                        <div class="d-md-none">
                                            <?php foreach ($status_data as $row): ?>
                                            <div class="card mb-2" <?php if(!empty($login_user_car_num) && $row['CAR_NUM'] == $login_user_car_num) echo 'style="border: 2px solid red;"'; ?>>
                                                <div class="card-body p-3">
                                                    <div class="h6 font-weight-bold text-secondary text-uppercase mb-2">
                                                        <?= htmlspecialchars($row['USER_NM']) ?> (<?= htmlspecialchars($row['CAR_NUM']) ?>)
                                                    </div>
                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">유종</div><div class="col-8 small"><?= htmlspecialchars($row['CAR_OIL']) ?></div></div>
                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">경로</div><div class="col-8 small"><?= htmlspecialchars($row['DEPARTURE']) ?> → <?= htmlspecialchars($row['DESTINATION']) ?></div></div>
                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">주행/톨비</div><div class="col-8 small"><?= htmlspecialchars($row['KM']) ?> / <?= htmlspecialchars($row['TOLL_GATE']) ?></div></div>
                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">기록일</div><div class="col-8 small"><?= htmlspecialchars($row['SEARCH_DATE']) ?></div></div>
                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">정산</div>
                                                        <div class="col-8 small">
                                                            <?php 
                                                                if ($row['CAR_OIL'] === '전기') {
                                                                    echo htmlspecialchars($row['GIVE_OIL']) . " 원";
                                                                    if ($row['GIVE_CHECK'] === 'Y') {
                                                                        $km = (float)$row['KM'];
                                                                        $toll = (int)$row['TOLL_GATE'];
                                                                        $gPrice = ($gasoline_price_for_view > 0) ? $gasoline_price_for_view : 1;
                                                                        $literEquiv = ceil(($km / 10) + ($toll / $gPrice));
                                                                        echo " <span class='text-primary'>(" . $literEquiv . " L)</span>";
                                                                    }
                                                                } else {
                                                                    echo htmlspecialchars($row['GIVE_OIL']) . " L";
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4 small font-weight-bold text-gray-600">사진</div>
                                                        <div class="col-8 small">
                                                            <?php if($row['FILE_KM']): ?>
                                                                <button class="btn btn-sm btn-info py-0 mr-1" onclick="bigimg('<?= htmlspecialchars($row['FILE_KM']) ?>')">KM</button>
                                                            <?php endif; ?>
                                                            <?php if($row['FILE_TOLL']): ?>
                                                                <button class="btn btn-sm btn-secondary py-0" onclick="bigimg('<?= htmlspecialchars($row['FILE_TOLL']) ?>')">Toll</button>
                                                            <?php endif; ?>
                                                            <?php if(!$row['FILE_KM'] && !$row['FILE_TOLL']) echo "-"; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if(!empty($login_user_car_num) && $row['CAR_NUM'] == $login_user_car_num): ?>
                                                        <?php if($row['GIVE_CHECK'] !== 'Y'): ?>
                                                            <button class="btn btn-sm btn-warning btn-block" onclick="openEditModal(
                                                                '<?= $row['NO'] ?>',
                                                                '<?= htmlspecialchars($row['DEPARTURE'], ENT_QUOTES) ?>',
                                                                '<?= htmlspecialchars($row['DESTINATION'], ENT_QUOTES) ?>',
                                                                '<?= $row['KM'] ?>',
                                                                '<?= $row['TOLL_GATE'] ?>',
                                                                '<?= htmlspecialchars($row['CAR_NUM'], ENT_QUOTES) ?>'
                                                            )">수정</button>
                                                        <?php else: ?>
                                                            <button class="btn btn-sm btn-secondary btn-block" disabled>정산완료</button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            <?php if(empty($status_data)): ?>
                                                <div class="text-center p-3 small text-gray-500">데이터가 없습니다.</div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="table-responsive d-none d-md-block">
                                            <table class="table table-bordered table-hover text-nowrap" id="dataTable">
                                                <thead>
                                                    <tr><th>이름</th><th>차번</th><th>유종</th><th>출발지</th><th>경유/목적지</th><th>주행거리</th><th>톨비</th><th>주행거리사진</th><th>톨비사진</th><th>기록일</th><th>정산</th><th>관리</th></tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($status_data as $row): ?>
                                                        <tr <?php if(!empty($login_user_car_num) && $row['CAR_NUM'] == $login_user_car_num) echo 'class="my-car-row"'; ?>>
                                                            <td><?= htmlspecialchars($row['USER_NM']) ?></td>
                                                            <td><?= htmlspecialchars($row['CAR_NUM']) ?></td>
                                                            <td><?= htmlspecialchars($row['CAR_OIL']) ?></td>
                                                            <td><?= htmlspecialchars($row['DEPARTURE']) ?></td>
                                                            <td><?= htmlspecialchars($row['DESTINATION']) ?></td>
                                                            <td><?= htmlspecialchars($row['KM']) ?></td>
                                                            <td><?= htmlspecialchars($row['TOLL_GATE']) ?></td>
                                                            <td>
                                                                <?php if($row['FILE_KM']): ?>
                                                                    <img src="../files/<?= htmlspecialchars($row['FILE_KM']) ?>" style="max-width: 100px; height: auto; cursor: pointer;" onclick="bigimg('<?= htmlspecialchars($row['FILE_KM']) ?>')">
                                                                <?php else: echo "없음"; endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if($row['FILE_TOLL']): ?>
                                                                    <img src="../files/<?= htmlspecialchars($row['FILE_TOLL']) ?>" style="max-width: 100px; height: auto; cursor: pointer;" onclick="bigimg('<?= htmlspecialchars($row['FILE_TOLL']) ?>')">
                                                                <?php else: echo "없음"; endif; ?>
                                                            </td>
                                                            <td><?= htmlspecialchars($row['SEARCH_DATE']) ?></td>
                                                            <td>
                                                                <?php 
                                                                    if ($row['CAR_OIL'] === '전기') {
                                                                        echo htmlspecialchars($row['GIVE_OIL']) . " 원";
                                                                        if ($row['GIVE_CHECK'] === 'Y') {
                                                                            $km = (float)$row['KM'];
                                                                            $toll = (int)$row['TOLL_GATE'];
                                                                            $gPrice = ($gasoline_price_for_view > 0) ? $gasoline_price_for_view : 1;
                                                                            $literEquiv = ceil(($km / 10) + ($toll / $gPrice));
                                                                            echo "<br><small class='text-primary'>(" . $literEquiv . " L)</small>";
                                                                        }
                                                                    } else {
                                                                        echo htmlspecialchars($row['GIVE_OIL']) . " L";
                                                                    }
                                                                ?>
                                                            </td>
                                                            
                                                            <td class="text-center align-middle">
                                                                <?php if(!empty($login_user_car_num) && $row['CAR_NUM'] == $login_user_car_num): ?>
                                                                    <?php if($row['GIVE_CHECK'] !== 'Y'): ?>
                                                                        <button class="btn btn-sm btn-warning" onclick="openEditModal(
                                                                            '<?= $row['NO'] ?>',
                                                                            '<?= htmlspecialchars($row['DEPARTURE'], ENT_QUOTES) ?>',
                                                                            '<?= htmlspecialchars($row['DESTINATION'], ENT_QUOTES) ?>',
                                                                            '<?= $row['KM'] ?>',
                                                                            '<?= $row['TOLL_GATE'] ?>',
                                                                            '<?= htmlspecialchars($row['CAR_NUM'], ENT_QUOTES) ?>'
                                                                        )">수정</button>
                                                                    <?php else: ?>
                                                                        <span class="badge badge-secondary">정산완료</span>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <span class="text-gray-400">-</span>
                                                                <?php endif; ?>
                                                            </td>
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">운행일지 수정</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="edit_no" id="edit_no">
                        <input type="hidden" name="edit_car_num" id="edit_car_num">
                        
                        <div class="form-group">
                            <label>출발지</label>
                            <input type="text" class="form-control" name="edit_departure" id="edit_departure" required>
                        </div>
                        <div class="form-group">
                            <label>경유지/목적지</label>
                            <input type="text" class="form-control" name="edit_destination" id="edit_destination" required>
                        </div>
                        <div class="form-group">
                            <label>주행거리 (Km)</label>
                            <input type="number" step="0.1" class="form-control" name="edit_km" id="edit_km" required>
                        </div>
                        <div class="form-group">
                            <label>톨게이트비</label>
                            <input type="number" class="form-control" name="edit_tollgate" id="edit_tollgate" required>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>주행거리 사진 수정 (선택)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="edit_file_km" id="edit_file_km">
                                <label class="custom-file-label" for="edit_file_km">파일 선택</label>
                            </div>
                            <small class="form-text text-muted">새 파일을 선택하면 기존 사진이 교체됩니다.</small>
                        </div>
                        <div class="form-group">
                            <label>톨게이트 사진 수정 (선택)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="edit_file_toll" id="edit_file_toll">
                                <label class="custom-file-label" for="edit_file_toll">파일 선택</label>
                            </div>
                            <small class="form-text text-muted">새 파일을 선택하면 기존 사진이 교체됩니다.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <button type="submit" name="bt_edit" class="btn btn-primary">수정 완료</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <?php include '../plugin_lv1.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($pending_arrival): ?>
                if (typeof $ !== 'undefined') {
                    $('#collapseCardExample1').collapse('hide');
                    $('#collapseCardExample2').collapse('hide');
                }
                var arrivalCard = document.getElementById('collapseCardExample3');
                if (arrivalCard) {
                    var cardContainer = arrivalCard.closest('.card');
                    if (cardContainer) {
                        setTimeout(function() {
                            cardContainer.scrollIntoView({behavior: 'smooth', block: 'start'});
                        }, 300);
                    }
                }
            <?php elseif ($pending_upload): ?>
                if (typeof $ !== 'undefined') {
                    $('#collapseCardExample1').collapse('hide');
                    $('#collapseCardExample2').collapse('hide');
                    $('#collapseCardExample3').collapse('hide');
                }
                var uploadCard = document.getElementById('collapseCardExample4');
                if (uploadCard) {
                    var cardContainer = uploadCard.closest('.card');
                    if (cardContainer) {
                        setTimeout(function() {
                            cardContainer.scrollIntoView({behavior: 'smooth', block: 'start'});
                        }, 300);
                    }
                }
            <?php endif; ?>
            
            // 파일 입력 라벨 변경 스크립트 (Bootstrap custom file input)
            if(typeof $ !== 'undefined') {
                $(".custom-file-input").on("change", function() {
                    var fileName = $(this).val().split("\\").pop();
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });
            }
        });
    </script>
</body>
</html>

<?php 
    if (isset($connect) && $connect instanceof mysqli) {
        mysqli_close($connect);
    }
?>