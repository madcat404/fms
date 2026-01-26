<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.10.12>
	// Description:	<법인차량일지 리뉴얼>	
    // Last Modified: <25.10.20> - Refactored for PHP 8.x	
    // Last Modified: <Current Date> - Updated Notice & Added Location Button
	// =============================================
    include 'rental_status.php'; 

    // [로그인 세션 처리]
    $current_driver_name = "";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['user_id'])) {
        $session_user_id = $_SESSION['user_id'];
        $stmt_user = $connect->prepare("SELECT USER_NM FROM user_info WHERE ENG_NM = ?");
        $stmt_user->bind_param("s", $session_user_id);
        $stmt_user->execute();
        $res_user = $stmt_user->get_result();
        if($row_user = $res_user->fetch_assoc()) {
            $current_driver_name = $row_user['USER_NM'];
        }
        $stmt_user->close();
    }

    // [검색 결과 처리]
    $search_data = [];
    if(isset($Result_SearchCar) && $Result_SearchCar->num_rows > 0) {
        while($row = $Result_SearchCar->fetch_assoc()) {
            $search_data[] = $row;
        }
    }

    // [현황 데이터 정의]
    $status_cars = [
        [
            'option_val' => 'avante 7206', 
            'name' => 'avante 225하 7206', 
            'fuel' => 'LPG',
            'info' => $Data_CarInfo6, 
            'prev_info' => $Data_CarInfo66, 
            'gw' => $gw_title6 ?? '-', 
            'loc' => false
        ],
        [
            'option_val' => 'avante 7207', 
            'name' => 'avante 225하 7207', 
            'fuel' => 'LPG',
            'info' => $Data_CarInfo7, 
            'prev_info' => $Data_CarInfo77, 
            'gw' => $gw_title7 ?? '-', 
            'loc' => true // 주차 위치 확인 가능
        ],
        [
            'option_val' => 'Staria 9285', 
            'name' => 'Staria 169하 9285', 
            'fuel' => '경유',
            'info' => $Data_CarInfo2, 
            'prev_info' => $Data_CarInfo22, 
            'gw' => $gw_title2 ?? '-', 
            'loc' => false
        ],
    ];

    // [이미지 매핑 함수]
    function getCarImage($carName) {
        $name = strtolower($carName);
        if (strpos($name, 'avante') !== false) {
            return 'https://fms.iwin.kr/img/avante.png';
        } elseif (strpos($name, 'staria') !== false) {
            return 'https://fms.iwin.kr/img/staria.png';
        }
        return ''; 
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>
    
    <style>
        .mobile-status-card {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            border: 1px solid #e3e6f0;
            border-left: 5px solid #ddd;
            overflow: hidden; 
        }
        .mobile-status-card:active {
            transform: scale(0.98);
            background-color: #f8f9fc;
        }
        .mobile-status-card.status-ok {
            border-left-color: #1cc88a; 
        }
        .mobile-status-card.status-busy {
            border-left-color: #e74a3b; 
        }
        .mobile-status-card.status-check {
            border-left-color: #f6c23e; 
        }
        
        .car-image {
            width: 80px;
            height: 50px;
            object-fit: contain;
            margin-right: 10px;
        }

        .modal-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
    </style>

    <script language="javascript">
       function checkDisable(form) {
            form.hipass.disabled = form.cb.checked;
       }

       // [기능] 모바일 카드 터치 시 모달 오픈
       function openMobileModal(carValue, carName, status, startKm) {
            // 초기화
            $('#rentModal, #returnModal, #adminModal').modal('hide');

            if (status === '사용가능') {
                // [대여]
                $('#rentModalTitle').text(carName + " 대여");
                $('#rentModalCar').val(carValue);
                $('#rentModalCarDisplay').val(carName);
                $('#rentModal').modal('show');

            } else if (status === '대여중' || status === '예약') {
                // [반납]
                $('#returnModalTitle').text(carName + " 반납 (1/2)");
                $('#returnModalCar').val(carValue);
                $('#returnModalCarDisplay').val(carName);

                // 힌트 설정
                if (startKm && startKm != '0') {
                    $('input[name="end_km"]').attr('placeholder', '출발: ' + startKm + ' (이보다 큰 값 입력)');
                } else {
                    $('input[name="end_km"]').attr('placeholder', '숫자만 입력');
                }

                if (carValue === 'avante 7207') {
                    $('#returnModalLocation').show();
                } else {
                    $('#returnModalLocation').hide();
                }

                // UI 초기화
                $('#returnStep1').show();
                $('#returnStep2').hide();
                $('#btnReturnNext').show();
                $('#btnReturnSubmit').hide();
                $('#damageSelectionMobile').val('');
                $('#fileSelectionMobile').hide();
                $('#file24Mobile').val('');

                $('#returnModal').modal('show');

            } else if (status === '경비실확인') {
                // [관리자 확인 - 특정 차량]
                $('#adminModalTitle').text("관리자 확인");
                
                // SelectBox 값 설정 및 비활성화 (차량이 고정되므로)
                $('#adminModalCarSelect').val(carValue).trigger('change');

                // 옵션 자동 선택
                $('select[name="admin_condition"]').val('경비').trigger('change');
                
                $('#adminModal').modal('show');

            } else {
                alert('현재 [' + status + '] 상태입니다. 관리자 메뉴를 이용해주세요.');
            }
       }

       // [추가] 우측 상단 관리자 아이콘 클릭 시 (일반 관리자 모드)
       function openGeneralAdminModal() {
            $('#rentModal, #returnModal, #adminModal').modal('hide');
            
            $('#adminModalTitle').text("관리자 모드");
            // 차량 선택 초기화
            $('#adminModalCarSelect').val('').trigger('change');
            // 옵션 초기화
            $('select[name="admin_condition"]').val('').trigger('change');
            
            $('#adminModal').modal('show');
       }

       function goToReturnStep2() {
           var damageVal = $('#damageSelectionMobile').val();
           if (!damageVal) {
               alert('파손 유무를 선택해주세요.');
               return;
           }
           $('#returnStep1').hide();
           $('#returnStep2').show();
           $('#btnReturnNext').hide();
           $('#btnReturnSubmit').show();
           $('#returnModalTitle').text($('#returnModalCarDisplay').val() + " 반납 (2/2)");
       }

       $(document).ready(function() {
            $('#damageSelectionMobile').on('change', function() {
                if($(this).val() === 'Y') {
                    $('#fileSelectionMobile').show();
                } else {
                    $('#fileSelectionMobile').hide();
                }
            });
       });
    </script>
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">법인차 일지</h1>
                    </div>               

                    <div class="d-block d-md-none mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2 ml-1 mr-1">
                            <h6 class="text-gray-800 font-weight-bold m-0">
                                <i class="fas fa-touch-app"></i> 차량 선택 (터치하여 입력)
                            </h6>
                            <button type="button" class="btn btn-sm btn-light shadow-sm text-gray-700" onclick="openGeneralAdminModal()">
                                <i class="fas fa-users-cog"></i> 관리자
                            </button>
                        </div>

                        <div class="row px-2">
                            <?php foreach($status_cars as $car): 
                                $info = $car['info'];
                                $condition = $info->CAR_CONDITION ?? '-';
                                $img = getCarImage($car['name']); 
                                $start_km = $info->START_KM ?? '';

                                if ($condition == '사용가능') {
                                    $status_class = 'status-ok';
                                    $badge_text = '대여';
                                    $badge_color = 'badge-success';
                                    $text_class = 'text-success';
                                } elseif ($condition == '경비실확인') {
                                    $status_class = 'status-check';
                                    $badge_text = '확인'; 
                                    $badge_color = 'badge-warning';
                                    $text_class = 'text-warning';
                                } else {
                                    $status_class = 'status-busy';
                                    $badge_text = '반납';
                                    if($condition != '대여중' && $condition != '예약') $badge_text = '확인필요';
                                    $badge_color = 'badge-danger';
                                    $text_class = 'text-danger';
                                }
                            ?>
                            <div class="col-12 mb-2 px-1">
                                <div class="card shadow h-100 py-2 mobile-status-card <?= $status_class ?>" 
                                     onclick="openMobileModal('<?= $car['option_val'] ?>', '<?= $car['name'] ?>', '<?= $condition ?>', '<?= $start_km ?>')">
                                    <div class="card-body py-2 px-3">
                                        <div class="row no-gutters align-items-center">
                                            <?php if($img): ?>
                                            <div class="col-auto">
                                                <img src="<?= $img ?>" alt="car" class="car-image">
                                            </div>
                                            <?php endif; ?>
                                            
                                            <div class="col mr-2">
                                                <div class="h5 mb-1 font-weight-bold text-gray-800">
                                                    <?= $car['name'] ?>
                                                </div>
                                                <div class="text-xs text-gray-600">
                                                    <span class="<?= $text_class ?> font-weight-bold"><?= $condition ?></span>
                                                    | <?= $car['fuel'] ?> 
                                                    <?php if($condition == '대여중' || $condition == '경비실확인'): ?>
                                                        | <i class="fas fa-user"></i> <?= htmlspecialchars($info->DRIVER ?? '-') ?>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <?php if($car['loc'] && isset($Data_CarLocation->FILE_NM) && $Data_CarLocation->FILE_NM): ?>
                                                    <div class="mt-2">
                                                        <a href="https://fms.iwin.kr/files/<?= htmlspecialchars($Data_CarLocation->FILE_NM) ?>" 
                                                           class="btn btn-sm btn-outline-info py-0 px-2" 
                                                           target="_blank" 
                                                           onclick="event.stopPropagation();">
                                                           <i class="fas fa-map-marker-alt"></i> 주차위치 확인
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="col-auto">
                                                <span class="badge <?= $badge_color ?> px-2 py-2" style="font-size: 0.9em;">
                                                    <?= $badge_text ?> <i class="fas fa-chevron-right ml-1"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="alert alert-danger mt-2 mx-1 py-2 text-center" style="font-size: 0.85rem; border: 5px solid #e74a3b;">
                            <strong>※ 전화번호 터치 시 바로연결 ※</strong><br><br>
                            <strong>[avante 7206 / avante 7207]</strong><br>
                            긴급출동: <a href="tel:1670-5330" class="font-weight-bold text-danger">1670-5330</a> (오릭스 오토카) <br><br>
                            <strong>[staria 9285]</strong><br>
                            긴급출동: <a href="tel:1544-7751" class="font-weight-bold text-danger">1544-7751</a> (신한카드)
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs d-none d-md-block">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지 / 사고대처요령</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">일지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">조회</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            ★공지★ 00:00~17:30 외 시간에 대여하는 경우 경영팀확인이 필요함<BR><BR>                                             
                                            ★공지★ 만26세 이상만 운전할 것! (법인차 보험적용 나이: 만26세 이상)<BR><BR>   

                                            [avante 7206 / avante 7207]<BR> 
                                            STEP1. 경영팀 통보 (변상주CJ 051-790-2013 / 권성근DR 051-790-2077)<BR> 
                                            STEP2. 1670-5330(오릭스 오토카 서비스)<BR> 
                                            ※자기부담금: 30만원<BR><BR>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">STEP1. 대여</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="rental.php"> 
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body">
                                                            <div class="row">    
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>차량선택</label>
                                                                        <select name="car" class="form-control select2" style="width: 100%;">
                                                                            <option value="" selected="selected">선택</option>
                                                                            <?php foreach ( $in_car as $option ) : ?>
                                                                                <option value="<?php echo htmlspecialchars($option->CAR_NM); ?>"><?php echo htmlspecialchars($option->CAR_NM); ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>운전자</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="driver" required value="<?= htmlspecialchars($current_driver_name) ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>목적지</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="destination" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div> 
                                                            </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt21">대여</button>
                                                        </div>
                                                        </form>             
                                                </div>
                                                </div> 

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                    <h6 class="m-0 font-weight-bold text-primary">STEP2. 파손</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="rental.php" enctype="multipart/form-data"> 
                                                    <div class="collapse show" id="collapseCardExample24">                                    
                                                        <div class="card-body">
                                                            <p style="color: red; font-weight-bold">         
                                                                ※ "업로드 완료" 창이 뜨지 않는 경우 사진을 분할하여 업로드 바랍니다.<br>
                                                            <div class="row">    
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>차량선택</label>
                                                                        <select name="car24" class="form-control select2" style="width: 100%;">
                                                                            <option value="" selected="selected">선택</option>	
                                                                            <option value="avante 7206">Avante 7206</option>
                                                                            <option value="avante 7207">Avante 7207</option>
                                                                            <option value="Staria 9285">Staria 9285</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>파손유무</label>
                                                                        <select name="damage24" class="form-control select2" style="width: 100%;" id="damageSelection">
                                                                            <option value="" selected="selected">선택</option>		
                                                                            <option value="E">이전과 동일해요</option>	
                                                                            <option value="Y">네, 있었어요</option>
                                                                            <option value="N">아니오, 없었어요</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4" id="fileSelection" style="display: none;">
                                                                    <div class="form-group">
                                                                        <label>파일선택</label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="file24[]" id="file24" multiple> 
                                                                            <label class="custom-file-label" for="file24">파일선택</label>
                                                                        </div>                                                      
                                                                    </div>
                                                                </div>
                                                                <script>
                                                                    var damageSelection = document.getElementById('damageSelection');
                                                                    var fileSelection = document.getElementById('fileSelection');
                                                                    if(damageSelection){
                                                                        damageSelection.addEventListener('change', function() {
                                                                            var selectedDamage = damageSelection.value;
                                                                            fileSelection.style.display = 'none';
                                                                            if (selectedDamage === 'Y') {
                                                                                fileSelection.style.display = 'block';
                                                                            }
                                                                        });
                                                                    }
                                                                </script>
                                                            </div> 
                                                            </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="button" class="btn btn-info"><a href="https://fms.iwin.kr/kjwt_fms/rental_lastpic.php" style="text-decoration:none; color: white;">이전사진</a></button>
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt24">저장</button>
                                                        </div>
                                                        </div>
                                                </form>  
                                                </div> 

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">STEP3. 반납</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="rental.php" enctype="multipart/form-data"> 
                                                    <div class="collapse show" id="collapseCardExample22">                                    
                                                        <div class="card-body">
                                                            <div class="row">    
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>차량선택</label>
                                                                        <select name="arrive_car" class="form-control select2" style="width: 100%;" id="carSelection">
                                                                            <option value="" selected="selected">선택</option>
                                                                            <?php foreach ( $out_car as $option ) : ?>
                                                                                <option value="<?php echo htmlspecialchars($option->CAR_NM); ?>"><?php echo htmlspecialchars($option->CAR_NM); ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>주행후 계기판 거리</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-tachometer-alt"></i></span>
                                                                            </div>
                                                                            <input type="number" class="form-control" name="end_km" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" >
                                                                    <div class="form-group">
                                                                        <label>하이패스 잔액</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                <input type="checkbox" checked="checked" id="ex_chk3" name="cb" onClick="checkDisable(this.form)" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" disabled class="form-control" name="hipass" placeholder="체크해제 후 입력"  onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" id="NoteSelection">
                                                                    <div class="form-group">
                                                                        <label>특이사항</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="note" placeholder="경영팀 알림">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" id="LoctionSelection" style="display: none;">
                                                                    <div class="form-group">
                                                                        <label>주차위치</label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="file" name="file"> 
                                                                            <label class="custom-file-label" for="file">파일선택</label>
                                                                        </div>                                                      
                                                                    </div>
                                                                </div>
                                                                <script>
                                                                    var carSelection = document.getElementById('carSelection');
                                                                    var NoteSelection = document.getElementById('NoteSelection');
                                                                    var LoctionSelection = document.getElementById('LoctionSelection');
                                                                    if(carSelection) {
                                                                        carSelection.addEventListener('change', function() {
                                                                            var selectedCar = carSelection.value;
                                                                            NoteSelection.style.display = 'none';
                                                                            LoctionSelection.style.display = 'none';
                                                                            if (selectedCar === 'avante 7207') {
                                                                                LoctionSelection.style.display = 'block';
                                                                            } else {
                                                                                NoteSelection.style.display = 'block';
                                                                            }
                                                                        });
                                                                    }
                                                                </script>
                                                            </div> 
                                                            </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt22">반납</button>
                                                        </div>
                                                        </form>             
                                                </div>
                                                </div>                                              

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">관리자</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="rental.php"> 
                                                    <div class="collapse" id="collapseCardExample23">                                    
                                                        <div class="card-body">
                                                            <div class="row">    
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>차량선택</label>
                                                                        <select name="admin_car" class="form-control select2" style="width: 100%;">
                                                                            <option value="" selected="selected">선택</option>	
                                                                            <option value="avante 7206">Avante 7206</option>
                                                                            <option value="avante 7207">Avante 7207</option>
                                                                            <option value="Staria 9285">Staria 9285</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>옵션</label>
                                                                        <select name="admin_condition" class="form-control select2" style="width: 100%;">
                                                                            <option value="" selected="selected">선택</option>
                                                                            <option value="확인">경영팀 확인</option>
                                                                            <option value="경비">경비실 확인</option>
                                                                            <option value="취소">대여취소</option>
                                                                            <option value="취소2">예약취소</option>
                                                                            <option value="예약">예약</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>패스워드</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                <i class="fas fa-key"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="password" class="form-control" name="admin_code" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div> 
                                                            </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt23">입력</button>
                                                        </div>
                                                        </div>
                                                    </form>   
                                            </div>  

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample25" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample25">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">현황 (전체)</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample25">
                                                    <div class="card-body p-2">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped" id="table2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>차종</th>
                                                                        <th>유종</th>
                                                                        <th>상태</th>
                                                                        <th>대여일</th>
                                                                        <th>운전자</th>
                                                                        <th>목적지</th>
                                                                        <th>최종 km (이전 km)</th>
                                                                        <th>하이패스 잔액 (이전 잔액)</th> 
                                                                        <th>시간 외 근거</th> 
                                                                        <th>위치</th> 
                                                                        <th>특이사항</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>                                                             
                                                                    <?php foreach($status_cars as $car): 
                                                                        $info = $car['info'];
                                                                        $prev = $car['prev_info'];
                                                                        $condition = $info->CAR_CONDITION ?? '-';
                                                                        $cond_class = ($condition == '사용가능') ? 'text-success font-weight-bold' : 'text-danger font-weight-bold';
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $car['name'] ?></td>
                                                                        <td><?= $car['fuel'] ?></td>
                                                                        <td class="<?= $cond_class ?>"><?= htmlspecialchars($condition) ?></td>
                                                                        <td><?= htmlspecialchars($info->SEARCH_DATE ?? '-') ?></td>
                                                                        <td><?= htmlspecialchars($info->DRIVER ?? '-') ?></td>
                                                                        <td><?= htmlspecialchars($info->DESTINATION ?? '-') ?></td>
                                                                        <td><?= htmlspecialchars($info->END_KM ?? '-') ?> (<?= htmlspecialchars($prev->END_KM ?? '-') ?>)</td>
                                                                        <td><?= htmlspecialchars($info->HI_PASS ?? '-') ?> (<?= htmlspecialchars($prev->HI_PASS ?? '-') ?>)</td>
                                                                        <td><?= htmlspecialchars($car['gw']) ?></td>
                                                                        <td><?php if($car['loc']): ?><a href="/session/view_file.php?file=<?php echo htmlspecialchars($Data_CarLocation->FILE_NM ?? ''); ?>" class="btn btn-sm btn-info">보기</a><?php else: echo "-"; endif; ?></td>
                                                                        <td><?= htmlspecialchars($info->NOTE ?? '-') ?></td>
                                                                    </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>  
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="rental.php"> 
                                                    <div class="collapse show" id="collapseCardExample31">                                    
                                                        <div class="card-body">
                                                            <div class="row">    
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>차량선택</label>
                                                                        <select name="car" class="form-control select2" style="width: 100%;">
                                                                            <option value="all"  selected="selected">모든차량</option>
                                                                            <option value="avante 1296">『부산』 avante 1296</option>
                                                                            <option value="avante 1297">『부산』 avante 1297</option>
                                                                            <option value="avante 7206">『부산』 avante 7206</option>
                                                                            <option value="avante 7207">『부산』 avante 7207</option>
                                                                            <option value="K5 4639">『부산』 K5 4639</option>
                                                                            <option value="K5 4210">『부산』 K5 4210</option>
                                                                            <option value="LF 8266">『부산』 LF 8266</option>
                                                                            <option value="Starex 2918">『부산』 Starex 2918</option>
                                                                            <option value="K5 7305" style="color: red">『천안』 K5 7305</option>
                                                                        </select> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>검색범위</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                <i class="far fa-calendar-alt"></i>
                                                                                </span>
                                                                            </div>
                                                                            <?php 
                                                                                if($dt!='') {
                                                                            ?>
                                                                                    <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt">
                                                                            <?php 
                                                                                }
                                                                                else {
                                                                            ?>
                                                                                    <input type="text" class="form-control float-right kjwt-search-date" name="dt">
                                                                            <?php 
                                                                                }
                                                                            ?> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div> 
                                                            </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt3">검색</button>
                                                        </div>
                                                        </form>             
                                                </div>
                                                </div>                        

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample32">
                                                    <div class="card-body p-2">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                    <th>차종</th>
                                                                    <th>대여일</th>
                                                                    <th>반납일</th>
                                                                    <th>운전자</th>   
                                                                    <th>최종KM</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($search_data as $row): ?>
                                                                        <tr>	
                                                                            <td><?= htmlspecialchars($row['CAR_NM']) ?></td>											
                                                                            <td><?= htmlspecialchars($row['START_TIME']) ?></td>
                                                                            <td><?= empty($row['END_TIME']) ? " - " : htmlspecialchars($row['END_TIME']) ?></td> 
                                                                            <td><?= htmlspecialchars($row['DRIVER']) ?></td>
                                                                            <td><?= htmlspecialchars($row['END_KM']) ?></td>
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
                    </div>
                </div>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="rentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-primary" id="rentModalTitle">차량 대여</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" autocomplete="off" action="rental.php">
                    <div class="modal-body">
                        <input type="hidden" name="car" id="rentModalCar">
                        
                        <div class="form-group">
                            <label>차량</label>
                            <input type="text" class="form-control" id="rentModalCarDisplay" readonly>
                        </div>
                        <div class="form-group">
                            <label>운전자</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="driver" required placeholder="이름 입력" value="<?= htmlspecialchars($current_driver_name) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>목적지</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" name="destination" required placeholder="목적지 입력">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <button type="submit" value="on" class="btn btn-primary" name="bt21">대여하기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-danger" id="returnModalTitle">차량 반납</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" autocomplete="off" action="rental.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="arrive_car" id="returnModalCar">
                        <div class="form-group mb-4">
                            <label>반납 차량</label>
                            <input type="text" class="form-control" id="returnModalCarDisplay" readonly style="background-color: #f8f9fc;">
                        </div>

                        <div id="returnStep1">
                            <div class="h6 font-weight-bold text-dark mb-3">STEP 1. 파손 유무 확인</div>
                            <div class="form-group">
                                <label>파손이 있었나요?</label>
                                <select name="damage24" class="form-control" id="damageSelectionMobile">
                                    <option value="" selected>선택해주세요</option>		
                                    <option value="E">이전과 동일해요 (이상 없음)</option>	
                                    <option value="Y">네, 파손이 발생했어요</option>
                                    <option value="N">아니오, 없었어요</option>
                                </select>
                            </div>
                            <div class="form-group" id="fileSelectionMobile" style="display: none;">
                                <label class="text-danger">파손 사진을 업로드해주세요</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file24[]" id="file24Mobile" multiple> 
                                    <label class="custom-file-label" for="file24Mobile">파일선택</label>
                                </div>     
                            </div>
                            <div class="mt-3 text-right">
                                <button type="button" class="btn btn-info btn-sm" onclick="location.href='https://fms.iwin.kr/kjwt_fms/rental_lastpic.php'">이전사진 확인</button>
                            </div>
                        </div>

                        <div id="returnStep2" style="display:none;">
                             <div class="h6 font-weight-bold text-dark mb-3">STEP 2. 운행 정보 입력</div>
                            <div class="form-group">
                                <label>주행후 계기판 거리 (KM)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-tachometer-alt"></i></span>
                                    </div>
                                    <input type="number" class="form-control" name="end_km" placeholder="숫자만 입력">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>하이패스 잔액</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <input type="checkbox" checked="checked" name="cb" onClick="checkDisable(this.form)">
                                        </span>
                                    </div>
                                    <input type="text" disabled class="form-control" name="hipass" placeholder="체크해제 후 입력" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>특이사항</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="note" placeholder="경영팀 알림">
                                </div>
                            </div>
                            <div class="form-group" id="returnModalLocation" style="display:none;">
                                <label>주차위치 사진</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="modalFile" name="file"> 
                                    <label class="custom-file-label" for="modalFile">파일선택</label>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <button type="button" class="btn btn-primary" id="btnReturnNext" onclick="goToReturnStep2()">다음 (정보입력) &gt;</button>
                        <button type="submit" value="on" class="btn btn-danger" name="bt22" id="btnReturnSubmit" style="display:none;">반납완료</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-warning" id="adminModalTitle">관리자 확인</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" autocomplete="off" action="rental.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>대상 차량</label>
                            <select name="admin_car" id="adminModalCarSelect" class="form-control select2" style="width: 100%;">
                                <option value="" selected="selected">선택</option>	
                                <option value="avante 7206">Avante 7206</option>
                                <option value="avante 7207">Avante 7207</option>
                                <option value="Staria 9285">Staria 9285</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>옵션</label>
                            <select name="admin_condition" class="form-control select2" style="width: 100%;">
                                <option value="" selected>선택</option>
                                <option value="경비">경비실 확인</option>
                                <option value="확인">경영팀 확인</option>
                                <option value="취소">대여취소</option>
                                <option value="취소2">예약취소</option>
                                <option value="예약">예약</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>비밀번호</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" name="admin_code" required placeholder="관리자 암호">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <button type="submit" value="on" class="btn btn-warning" name="bt23">확인처리</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../plugin_lv1.php'; ?>
  
</body>
</html>

<?php 
    //메모리 회수
    if(isset($connect)) { mysqli_close($connect); }	
    if(isset($connect3)) { mysqli_close($connect3); }
?>