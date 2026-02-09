<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.02.12>
	// Description:	<시험실 체크시트>	
    // Last Modified: <Current Date> - Fixed Responsive Checkbox Sync Issue
	// =============================================
    include 'test_room_status.php';

    // [안전장치] 가스경보기 데이터 초기화
    if (!isset($Data_GAS_INSPECT1) || !is_array($Data_GAS_INSPECT1)) $Data_GAS_INSPECT1 = [];
    if (!isset($Data_GAS_INSPECT2) || !is_array($Data_GAS_INSPECT2)) $Data_GAS_INSPECT2 = [];

    // [Tab 2] 가스경보기 데이터 배열
    $alarms = [
        ['id' => '1', 'name' => '가스경보기1', 'data' => $Data_GAS_INSPECT1],
        ['id' => '2', 'name' => '가스경보기2', 'data' => $Data_GAS_INSPECT2]
    ];

    // [Tab 4] 결과 데이터 배열 저장
    $search_results_tab4 = [];
    if (isset($Result_Select) && $Count_Select > 0) {
        while ($row = sqlsrv_fetch_array($Result_Select, SQLSRV_FETCH_ASSOC)) {
            $checklist_items = [];
            if($equipment_name=='ALL') {
                $Query_List = "SELECT * from CONNECT.dbo.TEST_ROOM_CHECKLIST";              
            } ELSE {
                $Query_List = "SELECT * from CONNECT.dbo.TEST_ROOM_CHECKLIST WHERE EQUIPMENT_NUM='$equipment_name'";              
            }
            $Result_List = sqlsrv_query($connect, $Query_List, $params, $options);
            if ($Result_List) {
                while($item = sqlsrv_fetch_array($Result_List, SQLSRV_FETCH_ASSOC)){
                    $item['MERGE_KEY'] = "equipment".$item['EQUIPMENT_NUM'].$item['EQUIPMENT_SEQ'];
                    $item['WHO_KEY'] = "equipment_who".$item['EQUIPMENT_NUM'];
                    $checklist_items[] = $item;
                }
            }
            $row['CHECKLIST_ITEMS'] = $checklist_items;
            $search_results_tab4[] = $row;
        }
    }

    // [Tab 6] 설비기록 데이터 배열 저장
    $search_results_tab6 = [];
    if (isset($Result_RecordSelect) && $Count_RecordSelect > 0) {
        while ($row = sqlsrv_fetch_array($Result_RecordSelect, SQLSRV_FETCH_ASSOC)) {
            $search_results_tab6[] = $row;
        }
    }

    // [Tab 7] 설비이력2 (모든 설비의 마지막 이력) 데이터 배열 저장
    $search_results_tab7 = [];
    if (isset($Result_Tab7)) {
        while ($row = sqlsrv_fetch_array($Result_Tab7, SQLSRV_FETCH_ASSOC)) {
            $search_results_tab7[] = $row;
        }
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>
    <?php include '../head_popup.php' ?>
    <style>
        /* 모바일 선택 효과 스타일 */
        .selected-card {
            background-color: #e8f0fe !important; /* 연한 파란색 배경 */
            border: 1px solid #4e73df !important; /* 파란색 테두리 */
        }
        .cursor-pointer {
            cursor: pointer;
        }
        /* 팝업 반응형 스타일 */
        #popupEquipment {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            z-index: 99999;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        #popupEquipmentBackground {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 99998;
        }
        /* 팝업 내 Select 스타일 */
        .popup select {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: #fff;
        }
        /* PC 테이블 스타일 보정 */
        .table-info-th {
            background-color: #f8f9fc;
            vertical-align: middle !important;
            text-align: center;
            font-weight: bold;
        }
        .table-info-td {
            vertical-align: middle !important;
            text-align: center;
        }

        /* [수정] 설비 이미지 스타일 - PC용 고정 사이즈 */
        .equipment-img-pc {
            width: 100px !important;    /* 가로 고정 */
            height: 75px !important;    /* 세로 고정 */
            object-fit: contain;        /* 비율 유지하며 박스 안에 맞춤 */
            background-color: #fff;     /* 빈 공간 흰색 처리 */
            border: 1px solid #e3e6f0;  /* 테두리 */
            border-radius: 4px;
            display: block;
            margin: 0 auto;             /* 가운데 정렬 */
        }

        /* [수정] 설비 이미지 스타일 - 모바일용 고정 사이즈 */
        .equipment-img-mobile {
            width: 100%;                /* 가로는 카드 꽉 차게 */
            height: 150px;              /* 세로 높이 고정 (너무 크지 않게) */
            object-fit: contain;        /* 비율 유지하며 박스 안에 맞춤 */
            background-color: #f8f9fa;  /* 빈 공간 연한 회색 */
            border-bottom: 1px solid #e3e6f0;
            border-radius: 5px 5px 0 0; /* 상단 둥글게 */
            margin-bottom: 10px;
        }
        
        /* [추가] 모달 내 테이블 스타일 */
        #historyTable th {
            text-align: center;
            background-color: #f8f9fc;
            position: sticky;
            top: 0;
        }
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
    <script>
        // [기존] 체크리스트 입력 팝업 열기
        function openPopup() {
            const checked1 = document.querySelectorAll('input[name="GAS_INSPECT1"]:checked').length > 0;
            const checked2 = document.querySelectorAll('input[name="GAS_INSPECT2"]:checked').length > 0;

            if (!checked1 && !checked2) {
                alert("경보기를 선택해주세요.");
                return;
            }

            document.getElementById('popupBackground').style.display = 'block';
            document.getElementById('popup').style.display = 'block';
        }

        // [기존] 체크리스트 입력 팝업 닫기
        function closePopup() {
            document.getElementById('popupBackground').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }

        // [기존] 체크리스트 데이터 제출
        function submitInput() {
            const input = document.getElementById("userInput").value;
            const note = document.getElementById("noteInput").value;
            if (input) {
                document.getElementById('who21').value = input;
                document.getElementById('note21').value = note;
                document.getElementById('bt21').value = 'on';                
                document.getElementById('mainForm').submit();
            } else {
                alert("값을 입력해 주세요.");
            }
        }

        // [추가] 설비선택 팝업 열기
        let currentPopupTab = ''; 

        function openEquipmentPopup(tabNum) {
            currentPopupTab = tabNum; 
            document.getElementById('popupEquipmentBackground').style.display = 'block';
            document.getElementById('popupEquipment').style.display = 'block';
            setTimeout(function() {
                document.getElementById('equipmentInput').focus();
            }, 100);
        }

        // [추가] 설비선택 팝업 닫기
        function closeEquipmentPopup() {
            document.getElementById('popupEquipmentBackground').style.display = 'none';
            document.getElementById('popupEquipment').style.display = 'none';
        }

        // [수정] 설비번호 제출 및 페이지 이동
        function submitEquipmentInput() {
            const eqNum = document.getElementById("equipmentInput").value;
            if (eqNum) {
                let url = "https://fms.iwin.kr/kjwt_test_room/test_room.php?equipment=" + eqNum;
                if (currentPopupTab) {
                    url += "&tab=" + currentPopupTab;
                }
                location.href = url;
            } else {
                alert("설비를 선택해 주세요.");
            }
        }

        /**
         * [수정됨] 체크박스 동기화 및 스타일 업데이트 함수
         * 모바일(Card)과 PC(Table)의 체크박스를 동기화합니다.
         */
        function toggleCheckbox(element, event) {
            let checkbox;
            
            // 1. 클릭된 요소가 체크박스인지 확인
            if (event.target.type === 'checkbox') {
                checkbox = event.target;
            } else {
                // 카드/DIV 영역 클릭 시 내부 체크박스 찾기
                checkbox = element.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                }
            }

            // 2. 체크박스가 존재하면 동기화 실행
            if (checkbox) {
                syncCheckboxes(checkbox.name, checkbox.checked);
            }
        }

        // 이름이 같은 모든 체크박스의 상태를 동기화하고 스타일 적용
        function syncCheckboxes(name, isChecked) {
            // 동일한 name을 가진 모든 체크박스 선택 (모바일 + PC)
            const checkboxes = document.querySelectorAll(`input[name="${name}"]`);
            
            checkboxes.forEach(cb => {
                cb.checked = isChecked;
                
                // 스타일 업데이트 (부모 요소 중 .cursor-pointer 클래스를 가진 요소 찾기)
                const parentElement = cb.closest('.cursor-pointer');
                if (parentElement) {
                    updateCardStyle(parentElement, isChecked);
                }
            });
        }

        // 스타일 업데이트 함수
        function updateCardStyle(element, isChecked) {
            if (isChecked) {
                element.classList.add('selected-card');
            } else {
                element.classList.remove('selected-card');
            }
        }

        // [추가] 이력 조회 모달 열기 및 데이터 로드
        function openHistoryModal(eqNum, eqName) {
            $('#historyModalLabel').text(eqName + " (No." + eqNum + ") 전체 이력");
            $('#historyTableBody').html("<tr><td colspan='5' class='text-center'>데이터를 불러오는 중입니다...</td></tr>");
            $('#historyModal').modal('show');

            $.ajax({
                url: 'test_room_status.php',
                type: 'POST',
                data: {
                    ajax_history: 'yes',
                    eq_num: eqNum
                },
                success: function(response) {
                    $('#historyTableBody').html(response);
                },
                error: function() {
                    $('#historyTableBody').html("<tr><td colspan='5' class='text-center'>오류가 발생했습니다.</td></tr>");
                }
            });
        }

        // [수정] 설비기록 폼 유효성 검사 및 데이터 병합
        function validateRecord() {
            // 1. 내용 입력 확인
            const content = document.getElementById('contentTextarea').value.trim();
            if(!content) {
                alert("내용을 입력해 주세요.");
                return false;
            }

            // 2. 작성자 입력 확인 및 Hidden Field 할당
            const finalRecorder = document.getElementById('final_recorder');
            const recMobile = document.getElementById('rec_mobile');
            const recPC = document.getElementById('rec_pc');
            
            // 입력창이 존재한다면 (작성자 직접 입력 모드)
            if (recMobile || recPC) {
                let nameVal = "";
                // 화면 너비로 모바일/PC 구분 (Bootstrap d-md-none 기준 768px)
                if (window.innerWidth < 768) {
                    // 모바일 화면
                    nameVal = recMobile ? recMobile.value.trim() : "";
                } else {
                    // PC 화면
                    nameVal = recPC ? recPC.value.trim() : "";
                }

                if (!nameVal) {
                    alert("작성자 성함을 입력해 주세요.");
                    return false;
                }
                // 입력받은 값을 최종 전송될 hidden field에 넣음
                finalRecorder.value = nameVal;
            }
            
            return true;
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
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">시험실 체크리스트</h1>
                    </div>                

                    <div class="row"> 

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item"><a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a></li>
                                        <li class="nav-item"><a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">가스경보기</a></li>  
                                        
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" 
                                               <?php if(!empty($equipment)) { ?>
                                                   data-toggle="pill" href="#tab3"
                                               <?php } else { ?>
                                                   href="#" onclick="event.preventDefault(); openEquipmentPopup(3); return false;"
                                               <?php } ?>>
                                               일상점검
                                            </a>
                                        </li>  
                                        
                                        <li class="nav-item"><a class="nav-link <?php echo $tab4;?>" id="tab-four" data-toggle="pill" href="#tab4">점검조회</a></li> 
                                        
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="tab-five" 
                                               <?php if(!empty($equipment)) { ?>
                                                   data-toggle="pill" href="#tab5"
                                               <?php } else { ?>
                                                   href="#" onclick="event.preventDefault(); openEquipmentPopup(5); return false;"
                                               <?php } ?>>
                                               설비기록
                                            </a>
                                        </li>  
                                        
                                        <li class="nav-item"><a class="nav-link <?php echo $tab6;?>" id="tab-six" data-toggle="pill" href="#tab6">설비이력(날짜별)</a></li>
                                        
                                        <li class="nav-item"><a class="nav-link" id="tab-seven" data-toggle="pill" href="#tab7">설비이력(설비별)</a></li>  
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<br>
                                            - 시험실 가스경보기 점검 및 체크리스트 전산화<br><br>
                                            [참조]<br>
                                            - 요청자: 윤지성, 전우준<br>
                                            - 사용자: 시험팀<br>
                                            * 연소성시험기 가스누출 측정기 관련 안내사항<br>
                                            - 현재 모델은 "신우전자 가스누설경보기 LPG 전용 가스누출감지기 ND114 AC220V 방수형 감지기"<br>
                                            - KCS인증 용도로 측정기 사용하여야 함<br>
                                            - 현재 모델은 KCS인증 모델이 아니므로 추후 구매시 참고하여 구매할 예정<br>
                                            - 6개월마다 1회 점검 필요(30cm 옆에서 라이터 가스만 누출시켜서 경보기 울리는지 확인)<br>
                                            - 점검일 : 2025/2/15, 2025/8/15<br>                                            
                                            - 확인자의 싸인이 x박스로 출력되는 경우 gw.iwin.kr에 로그인을 하면 된다. (FIXME)<br>
                                            - 시험실 '점검했어요' 포맥스 바코드 형식 ex) https://fms.iwin.kr/kjwt_test_room/test_room_pop.php?equipment=1<br><br> 
                                            [제작일]<br>
                                            - 25.2.12<br><br>                                      
                                        </div>
                                        
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">체크리스트</h1>
                                                </a>
                                                <form id="mainForm" method="POST" autocomplete="off" action="test_room.php"> 
                                                    <div class="collapse show" id="collapseCardExample21">
                                                        <div class="card-body p-2">
                                                            <div class="d-md-none">
                                                                <?php foreach($alarms as $alarm): 
                                                                    $chk_name = 'GAS_INSPECT' . $alarm['id'];
                                                                    $is_checked_attr = (!empty($Data_TodayCheckList[$chk_name]) && $Data_TodayCheckList[$chk_name]=='on') ? 'checked' : '';
                                                                    $last_who = !empty($alarm['data']) ? ($alarm['data'][0]['WHO'] ?? '') : '';
                                                                    $last_note = !empty($alarm['data']) ? ($alarm['data'][0]['NOTE'] ?? '') : '';
                                                                    $card_class = $is_checked_attr ? 'selected-card' : '';
                                                                ?>
                                                                <div class="card mb-2 cursor-pointer <?= $card_class ?>" onclick="toggleCheckbox(this, event)">
                                                                    <div class="card-body p-3">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <h6 class="m-0 font-weight-bold text-secondary"><?= $alarm['name'] ?></h6>
                                                                            <input type="checkbox" name="<?= $chk_name ?>" style="transform: scale(2);" <?= $is_checked_attr ?>>
                                                                        </div>
                                                                        <div class="row mb-1"><div class="col-4 small text-gray-600 font-weight-bold">점검항목</div><div class="col-8 small">성능점검 (경보음 확인)</div></div>
                                                                        <div class="row mb-1"><div class="col-4 small text-gray-600 font-weight-bold">마지막점검자</div><div class="col-8 small"><?= $last_who ?></div></div>
                                                                        <div class="row mb-1"><div class="col-4 small text-gray-600 font-weight-bold">조치사항</div><div class="col-8 small"><?= $last_note ?></div></div>
                                                                        <div class="row mb-0">
                                                                            <div class="col-4 small text-gray-600 font-weight-bold">최근점검일</div>
                                                                            <div class="col-8 small">
                                                                                <?php 
                                                                                    $dates = [];
                                                                                    foreach ($alarm['data'] as $d) {
                                                                                        if (count($dates) >= 2) break;
                                                                                        $dt = $d['INSPECT_DT'] instanceof DateTime ? $d['INSPECT_DT'] : date_create($d['INSPECT_DT']);
                                                                                        if($dt) $dates[] = date_format($dt, "Y-m-d");
                                                                                    }
                                                                                    echo implode(", ", $dates);
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endforeach; ?>
                                                            </div>

                                                            <div class="table-responsive d-none d-md-block">  
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>                                     
                                                                            <th style="text-align: center;">착안점</th>
                                                                            <th style="text-align: center;">구분</th>
                                                                            <th style="text-align: center;">점검</th>
                                                                            <th style="text-align: center;">마지막 점검자</th>
                                                                            <th style="text-align: center;">마지막 점검일</th>
                                                                            <th style="text-align: center;">이전 점검일</th>
                                                                            <th style="text-align: center;">조치사항</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                        <?php foreach($alarms as $alarm): 
                                                                            $chk_name = 'GAS_INSPECT' . $alarm['id'];
                                                                            $is_checked = (!empty($Data_TodayCheckList[$chk_name]) && $Data_TodayCheckList[$chk_name]=='on') ? 'checked' : '';
                                                                        ?>
                                                                        <tr>
                                                                            <td style="vertical-align: middle; text-align: center;"><?= $alarm['name'] ?></td>  
                                                                            <td style="vertical-align: middle; text-align: center;">성능점검 (가스 검출 시 경보음이 발생하는가?)</td>
                                                                            <td style="text-align: center;"><input type='checkbox' name='<?= $chk_name ?>' style='zoom: 2;' <?= $is_checked ?> onchange="syncCheckboxes('<?= $chk_name ?>', this.checked)"></td>
                                                                            <td style='text-align: center;'><?php echo !empty($alarm['data']) ? ($alarm['data'][0]['WHO'] ?? '') : ''; ?></td>
                                                                            <?php  
                                                                                $count = 0;
                                                                                foreach ($alarm['data'] as $data) {
                                                                                    if ($count >= 2) break;
                                                                                    $date_str = ($data['INSPECT_DT'] instanceof DateTime) ? date_format($data['INSPECT_DT'], "Y-m-d") : (date_create($data['INSPECT_DT']) ? date_format(date_create($data['INSPECT_DT']), "Y-m-d") : "Invalid");
                                                                                    echo "<td style='text-align: center;'>" . $date_str . "</td>";
                                                                                    $count++;
                                                                                }
                                                                                for($k=$count; $k<2; $k++) echo "<td></td>";
                                                                            ?>    
                                                                            <td style='text-align: center;'><?php echo !empty($alarm['data']) ? ($alarm['data'][0]['NOTE'] ?? '') : ''; ?></td>                                                                            
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table> 
                                                            </div>

                                                            <input type="hidden" id="who21" name="who21">
                                                            <input type="hidden" id="note21" name="note21">
                                                            <input type="hidden" id="bt21" name="bt21">                                                         
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="button" class="btn btn-primary" onclick="openPopup()">입력</button>
                                                        </div>
                                                    </div>
                                                </form> 
                                            </div>
                                        </div>  

                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <div class="col-lg-12 p-0"> 
                                                <form method="POST" autocomplete="off" action="test_room.php?equipment=<?php echo $equipment; ?>"> 
                                                    
                                                    <div class="card shadow mb-2">
                                                        <div class="card-body p-3">
                                                            <div class="d-md-none">
                                                                <div class="text-center mb-3">
                                                                    <img src="../img/equipment<?php echo $equipment;?>.jpg" style="max-width: 100%; max-height: 200px; border-radius: 5px;">
                                                                </div>
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-4 font-weight-bold text-gray-700">장비명</div>
                                                                    <div class="col-8"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['EQUIPMENT_NAME'] ?? '-') : '-';  ?></div>
                                                                </div>
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-4 font-weight-bold text-gray-700">점검일</div>
                                                                    <div class="col-8"><?php echo $Hyphen_today; ?></div>
                                                                </div>
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-4 font-weight-bold text-gray-700">점검방법</div>
                                                                    <div class="col-8">기능확인</div>
                                                                </div>
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-4 font-weight-bold text-gray-700">점검주기</div>
                                                                    <div class="col-8">1회/1일</div>
                                                                </div>
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-4 font-weight-bold text-gray-700">점검자</div>
                                                                    <div class="col-8"><?php if($checker_pop!='') {echo $checker_pop;} elseif($checker!='') {echo $checker;} else {echo '-';} ?></div>
                                                                </div>
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-4 font-weight-bold text-gray-700">확인자</div>
                                                                    <div class="col-8">
                                                                        <?php if(!empty($Data_TodayCheckList['equipment_supervisor'])) { ?> 
                                                                            윤지성<img src="https://fms.iwin.kr/img/윤지성.jpg" style="width: 40px; height: 30px;"> 
                                                                        <?php } else { ?>
                                                                            <button type="submit" class="btn btn-sm btn-info py-0" name="supervisor" value="on">입력</button>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="d-none d-md-block">
                                                                <table class="table table-bordered">
                                                                    <colgroup>
                                                                        <col style="width: 20%">
                                                                        <col style="width: 15%">
                                                                        <col style="width: 25%">
                                                                        <col style="width: 15%">
                                                                        <col style="width: 25%">
                                                                    </colgroup>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td rowspan="3" class="text-center align-middle p-2" style="background-color: #fff;">
                                                                                <img src="../img/equipment<?php echo $equipment;?>.jpg" style="max-width: 100%; max-height: 200px;">
                                                                            </td>
                                                                            <th class="table-info-th">장비명</th>
                                                                            <td class="table-info-td"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['EQUIPMENT_NAME'] ?? '-') : '-';  ?></td>
                                                                            <th class="table-info-th">점검주기</th>
                                                                            <td class="table-info-td">1회/1일</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="table-info-th">점검일</th>
                                                                            <td class="table-info-td"><?php echo $Hyphen_today; ?></td>
                                                                            <th class="table-info-th">점검자</th>
                                                                            <td class="table-info-td"><?php if($checker_pop!='') {echo $checker_pop;} elseif($checker!='') {echo $checker;} else {echo '-';} ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="table-info-th">점검방법</th>
                                                                            <td class="table-info-td">기능확인</td>
                                                                            <th class="table-info-th">확인자</th>
                                                                            <td class="table-info-td">
                                                                                <?php if(!empty($Data_TodayCheckList['equipment_supervisor'])) { ?> 
                                                                                    윤지성<img src="https://fms.iwin.kr/img/윤지성.jpg" style="width: 40px; height: 30px;"> 
                                                                                <?php } else { ?>
                                                                                    <button type="submit" class="btn btn-sm btn-info py-0" name="supervisor" value="on">입력</button>
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card shadow mb-2">
                                                        <div class="card-body p-0">
                                                            <div class="d-md-none">
                                                                <?php foreach ($Data_TodayCheckList2 as $item): 
                                                                    $name = 'equipment'.$item['EQUIPMENT_NUM'].$item['EQUIPMENT_SEQ'];
                                                                    $checked_attr = (!empty($Data_TodayCheckList) && ($Data_TodayCheckList[$name] ?? 'off') == 'on') ? 'checked' : '';
                                                                    $row_class = $checked_attr ? 'selected-card' : '';
                                                                ?>
                                                                <div class="p-3 border-bottom d-flex justify-content-between align-items-center cursor-pointer <?= $row_class ?>" onclick="toggleCheckbox(this, event)">
                                                                    <span class="mr-2"><?= $item['CHECKLIST'] ?></span>
                                                                    <input type='checkbox' name='<?= $name ?>' style='transform: scale(1.5);' <?= $checked_attr ?>>
                                                                </div>
                                                                <?php endforeach; ?>
                                                            </div>

                                                            <div class="table-responsive d-none d-md-block p-2">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr><th class="table-info-th" style="text-align: center;">점검내용</th><th class="table-info-th" style="text-align: center; width: 100px;">점검</th></tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                        <?php foreach ($Data_TodayCheckList2 as $item): 
                                                                            $name = 'equipment'.$item['EQUIPMENT_NUM'].$item['EQUIPMENT_SEQ'];
                                                                            $checked = (!empty($Data_TodayCheckList) && ($Data_TodayCheckList[$name] ?? 'off') == 'on') ? 'checked' : '';
                                                                        ?>
                                                                        <tr>
                                                                            <td style='text-align: center;'><?= $item['CHECKLIST'] ?></td>
                                                                            <td style='text-align: center;'>
                                                                                <input type='checkbox' name='<?= $name ?>' style='zoom: 2;' <?= $checked ?> onchange="syncCheckboxes('<?= $name ?>', this.checked)">
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer text-right">
                                                            <input type="hidden" value="<?php echo $checker_pop ?: $checker; ?>" name="checker">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt31">입력</button>
                                                        </div>
                                                    </div>
                                                </form>                                             
                                            </div>
                                        </div>  
                                        
                                        <?php include 'test_room_extra_tabs.php'; // (가정: 나머지 탭 코드가 길어서 include로 표시, 실제 사용 시엔 원본 코드를 그대로 두세요) ?>
                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="tab4" role="tabpanel" aria-labelledby="tab-four">
                                            <?php /* 기존 코드 생략 없이 사용 */ ?>
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">검색</h1>
                                                </a>
                                                <form method="POST" autocomplete="off" action="test_room.php"> 
                                                    <div class="collapse show" id="collapseCardExample41">                                        
                                                        <div class="card-body p-3">
                                                            <div class="row">                                                                           
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>검색범위</label>
                                                                        <div class="input-group">                                                                       
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                                                            <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt4">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label>설비명</label>
                                                                        <select name="equipment_name" class="form-control select12" style="width: 100%;">
                                                                            <option value="ALL" selected="selected">ALL</option>            
                                                                            <option value="1">1. X-RAY</option>
                                                                            <option value="3">3. Z-FOLDING</option>
                                                                            <option value="4">4. SEAT BACK 전후 작동내구 시험기</option>
                                                                            <option value="5">5. 복합환경내구시험기</option>
                                                                            <option value="6">6. 시트 진동내구 시험기</option>
                                                                            <option value="7">7. ROBOT 승강내구1</option>
                                                                            <option value="8">8. ROBOT 승강내구2</option>
                                                                            <option value="9">9. BENDING1</option>
                                                                            <option value="10">10. BENDING２</option>
                                                                            <option value="11">11. BENDING３</option>
                                                                            <option value="12">12. ＵＴＭ</option>
                                                                            <option value="13">13. LIFE CYCLE</option>
                                                                            <option value="14">14. KNEE TEST1</option>
                                                                            <option value="15">15. KNEE TEST2</option>
                                                                            <option value="16">16. KNEE TEST3</option>
                                                                            <option value="17">17. DRY OVEN</option>
                                                                            <option value="18">18. 항온항습기1</option>
                                                                            <option value="19">19. 항온항습기2</option>
                                                                            <option value="20">20. 항온항습기3</option>
                                                                            <option value="21">21. 먼지 시험기</option>
                                                                            <option value="22">22. 열충격 시험기</option>
                                                                            <option value="24">24. 풍량 시험기</option>
                                                                            <option value="25">25. 반무향실</option>
                                                                            <option value="26">26. 워크인챔버1</option>
                                                                            <option value="27">27. 워크인챔버2</option>
                                                                            <option value="28">28. 워크인챔버3</option>
                                                                            <option value="29">29. 염수분무시험기</option>
                                                                            <option value="30">30. 연소성 시험기</option>
                                                                        </select>
                                                                    </div>
                                                                </div>                                      
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt41">검색</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">결과</h1>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample42">
                                                    <div class="card-body p-2">
                                                        <div class="d-md-none">
                                                            <?php foreach($search_results_tab4 as $res): 
                                                                $date_str = date_format($res['SORTING_DATE'], "Y-m-d");
                                                                foreach($res['CHECKLIST_ITEMS'] as $item):
                                                                    $is_checked = ($res[$item['MERGE_KEY']] == 'on') ? "Y" : "N";
                                                                    $checker_name = $res[$item['WHO_KEY']];
                                                            ?>
                                                            <div class="card mb-2">
                                                                <div class="card-body p-3">
                                                                    <div class="h6 font-weight-bold text-secondary mb-2"><?= $item['EQUIPMENT_NAME'] ?></div>
                                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">점검일</div><div class="col-8 small"><?= $date_str ?></div></div>
                                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">점검내용</div><div class="col-8 small"><?= $item['CHECKLIST'] ?></div></div>
                                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">점검여부</div><div class="col-8 small"><?= $is_checked ?></div></div>
                                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">점검자</div><div class="col-8 small"><?= $checker_name ?></div></div>
                                                                    <div class="row mb-0"><div class="col-4 small font-weight-bold text-gray-600">확인자</div><div class="col-8 small">윤지성<img src="https://fms.iwin.kr/img/윤지성.jpg" style="width: 30px;"></div></div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; endforeach; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">    
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>점검일</th><th>설비명</th><th>점검내용</th><th>점검여부</th><th>점검자</th><th>확인자</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($search_results_tab4 as $res): 
                                                                        $date_str = date_format($res['SORTING_DATE'], "Y-m-d");
                                                                        foreach($res['CHECKLIST_ITEMS'] as $item):
                                                                            $is_checked = ($res[$item['MERGE_KEY']] == 'on') ? "Y" : "";
                                                                            $checker_name = $res[$item['WHO_KEY']];
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $date_str ?></td>  
                                                                        <td><?= $item['EQUIPMENT_NAME'] ?></td>  
                                                                        <td><?= $item['CHECKLIST'] ?></td>  
                                                                        <td><?= $is_checked ?></td>   
                                                                        <td><?= $checker_name ?></td>
                                                                        <td>윤지성<img src="https://fms.iwin.kr/img/윤지성.jpg" style="width: 40px; height: 30px;"></td>  
                                                                    </tr> 
                                                                    <?php endforeach; endforeach; ?>       
                                                                </tbody>
                                                            </table>                                      
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="tab5" role="tabpanel" aria-labelledby="tab-five">
                                            <div class="col-lg-12 p-0"> 
                                                <form method="POST" autocomplete="off" action="test_room.php?equipment=<?php echo $equipment; ?>" onsubmit="return validateRecord()"> 
                                                    <div class="card shadow mb-2">
                                                        <div class="card-body p-3">
                                                            <div class="d-md-none">
                                                                <div class="text-center mb-3">
                                                                    <img src="../img/equipment<?php echo $equipment;?>.jpg" style="max-width: 100%; max-height: 200px; border-radius: 5px;">
                                                                </div>
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-4 font-weight-bold text-gray-700">기록자</div>
                                                                    <div class="col-8">
                                                                        <?php if(!empty($recorder)) { ?>
                                                                            <?php echo htmlspecialchars($recorder); ?>
                                                                        <?php } else { ?>
                                                                            <input type="text" class="form-control" id="rec_mobile" placeholder="작성자">
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="d-none d-md-block">
                                                                <table class="table table-bordered">
                                                                    <colgroup>
                                                                        <col style="width: 20%">
                                                                        <col style="width: 15%">
                                                                        <col style="width: 25%">
                                                                        <col style="width: 15%">
                                                                        <col style="width: 25%">
                                                                    </colgroup>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td rowspan="2" class="text-center align-middle p-2" style="background-color: #fff;">
                                                                                <img src="../img/equipment<?php echo $equipment;?>.jpg" style="max-width: 100%; max-height: 200px;">
                                                                            </td>
                                                                            <th class="table-info-th">장비명</th>
                                                                            <td class="table-info-td"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['EQUIPMENT_NAME'] ?? '-') : '-';  ?></td>
                                                                            <th class="table-info-th">연락처</th>
                                                                            <td class="table-info-td"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['CALL'] ?? '-') : '-'; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="table-info-th">제작처</th>
                                                                            <td class="table-info-td"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['BUY'] ?? '-') : '-'; ?></td>
                                                                            <th class="table-info-th">기록자</th>
                                                                            <td class="table-info-td">
                                                                                <?php if(!empty($recorder)) { ?>
                                                                                    <?php echo htmlspecialchars($recorder); ?>
                                                                                <?php } else { ?>
                                                                                    <input type="text" class="form-control" id="rec_pc" placeholder="작성자">
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <hr>
                                                            <div class="form-group mb-2">
                                                                <textarea class="form-control" name="content51" rows="3" placeholder="내용을 입력하세요" style="width: 100%; resize: vertical;" id="contentTextarea"></textarea>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <input type="text" class="form-control" name="cost51" placeholder="수리비용 (숫자만 입력)" oninput="this.value = this.value.replace(/[^0-9]/g, '');"> 
                                                            </div>
                                                            
                                                            <input type="hidden" name="recorder51" id="final_recorder" value="<?php echo htmlspecialchars($recorder); ?>">
                                                        </div>
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt51">입력</button>
                                                        </div>
                                                    </div>
                                                </form>                                             
                                            </div>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="tab6" role="tabpanel" aria-labelledby="tab-six">
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample61" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample61">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">검색</h1>
                                                </a>
                                                <form method="POST" autocomplete="off" action="test_room.php"> 
                                                    <div class="collapse show" id="collapseCardExample61">                                        
                                                        <div class="card-body p-3">
                                                            <div class="row">                                                                           
                                                                <div class="col-md-12">
                                                                    <div class="form-group mb-0">
                                                                        <label>검색범위</label>
                                                                        <div class="input-group">                                                                       
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                                                            <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt6 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt6">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt61">검색</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample62" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample62">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">결과</h1>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample62">
                                                    <div class="card-body p-2">
                                                        <div class="d-md-none">
                                                            <?php foreach($search_results_tab6 as $res): ?>
                                                            <div class="card mb-2">
                                                                <div class="card-body p-3">
                                                                    <div class="h6 font-weight-bold text-secondary mb-2"><?= $res['EQUIPMENT_NAME'] ?></div>
                                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">설비번호</div><div class="col-8 small"><?= $res['EQUIPMENT_NUM'] ?></div></div>
                                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">내용</div><div class="col-8 small"><?= $res['NOTE'] ?></div></div>
                                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">수리비용</div><div class="col-8 small"><?= $res['COST'] ?></div></div>
                                                                    <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">기록자</div><div class="col-8 small"><?= $res['RECORDER'] ?></div></div>
                                                                    <div class="row mb-0"><div class="col-4 small font-weight-bold text-gray-600">기록일</div><div class="col-8 small"><?= date_format($res['RECORD_DATE'], "Y-m-d H:i:s") ?></div></div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">    
                                                            <table class="table table-bordered table-hover text-nowrap" id="table1">
                                                                <thead>
                                                                    <tr><th>설비번호</th><th>설비명</th><th>내용</th><th>수리비용</th><th>기록자</th><th>기록일</th></tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($search_results_tab6 as $res): ?>
                                                                    <tr>
                                                                        <td><?= $res['EQUIPMENT_NUM'] ?></td>  
                                                                        <td><?= $res['EQUIPMENT_NAME'] ?></td>  
                                                                        <td><?= $res['NOTE'] ?></td>  
                                                                        <td><?= $res['COST'] ?></td> 
                                                                        <td><?= $res['RECORDER'] ?></td>    
                                                                        <td><?= date_format($res['RECORD_DATE'], "Y-m-d H:i:s") ?></td>  
                                                                    </tr> 
                                                                    <?php endforeach; ?>        
                                                                </tbody>
                                                            </table>                                      
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="tab-seven">
                                            <div class="card shadow mb-2">
                                                <div class="card-header py-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">설비별 마지막 이력 현황</h6>
                                                </div>
                                                <div class="card-body p-2">
                                                    <div class="d-md-none">
                                                        <?php foreach($search_results_tab7 as $res): 
                                                            $cost_formatted = is_numeric($res['COST']) ? number_format($res['COST']) : $res['COST'];
                                                        ?>
                                                        <div class="card mb-2">
                                                            <img src="../img/equipment<?= $res['EQUIPMENT_NUM'] ?>.jpg" class="equipment-img-mobile" alt="설비이미지">
                                                            
                                                            <div class="card-body p-3 pt-1">
                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                    <div class="h6 font-weight-bold text-secondary m-0"><?= $res['EQUIPMENT_NAME'] ?> (No.<?= $res['EQUIPMENT_NUM'] ?>)</div>
                                                                    <button class="btn btn-sm btn-info" onclick="openHistoryModal('<?= $res['EQUIPMENT_NUM'] ?>', '<?= $res['EQUIPMENT_NAME'] ?>')">
                                                                        <i class="fas fa-history"></i> 기록
                                                                    </button>
                                                                </div>
                                                                <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">내용</div><div class="col-8 small"><?= $res['NOTE'] ?></div></div>
                                                                <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">수리비용</div><div class="col-8 small"><?= $cost_formatted ?></div></div>
                                                                <div class="row mb-1"><div class="col-4 small font-weight-bold text-gray-600">기록자</div><div class="col-8 small"><?= $res['RECORDER'] ?></div></div>
                                                                <div class="row mb-0"><div class="col-4 small font-weight-bold text-gray-600">기록일</div><div class="col-8 small"><?= date_format($res['RECORD_DATE'], "Y-m-d") ?></div></div>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
                                                        <?php if(empty($search_results_tab7)) echo "<div class='text-center p-3'>데이터가 없습니다.</div>"; ?>
                                                    </div>

                                                    <div class="table-responsive d-none d-md-block">
                                                        <table class="table table-bordered table-hover text-nowrap" id="table_spread">
                                                            <thead>
                                                                <tr><th>설비번호</th><th>사진</th><th>설비명</th><th>내용</th><th>수리비용</th><th>기록자</th><th>기록일</th><th>이력</th></tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($search_results_tab7 as $res): 
                                                                    $cost_formatted = is_numeric($res['COST']) ? number_format($res['COST']) : $res['COST'];
                                                                ?>
                                                                <tr>
                                                                    <td class="align-middle text-center"><?= $res['EQUIPMENT_NUM'] ?></td>
                                                                    <td class="text-center align-middle" style="padding: 5px;">
                                                                        <img src="../img/equipment<?= $res['EQUIPMENT_NUM'] ?>.jpg" class="equipment-img-pc" alt="설비이미지">
                                                                    </td>
                                                                    <td class="align-middle"><?= $res['EQUIPMENT_NAME'] ?></td>
                                                                    <td class="align-middle" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($res['NOTE']) ?>">
                                                                        <?= $res['NOTE'] ?>
                                                                    </td>
                                                                    <td class="align-middle"><?= $cost_formatted ?></td>
                                                                    <td class="align-middle"><?= $res['RECORDER'] ?></td>
                                                                    <td class="align-middle"><?= date_format($res['RECORD_DATE'], "Y-m-d") ?></td>
                                                                    <td class="align-middle text-center">
                                                                        <button class="btn btn-sm btn-info" onclick="openHistoryModal('<?= $res['EQUIPMENT_NUM'] ?>', '<?= $res['EQUIPMENT_NAME'] ?>')">
                                                                            <i class="fas fa-history"></i> 기록
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                                <?php if(empty($search_results_tab7)) echo "<tr><td colspan='8' class='text-center'>데이터가 없습니다.</td></tr>"; ?>
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

    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-primary" id="historyModalLabel">설비 이력</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-nowrap mb-0" id="historyTable">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">설비번호</th>
                                    <th style="width: 40%;">내용</th>
                                    <th style="width: 15%;">수리비용</th>
                                    <th style="width: 15%;">기록자</th>
                                    <th style="width: 20%;">기록일</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody">
                                </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>

    <div class="popup-background" id="popupBackground"></div>
    <div class="popup" id="popup">
        <button class="close-btn" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></button>
        <p>입력</p>
        <input type="text" id="userInput" class="input-field" placeholder="점검자" />  
        <br>
        <input type="text" id="noteInput" class="input-field" placeholder="조치사항" /> 
        <div class="popup-buttons">
            <button class="confirm-btn" onclick="submitInput()">확인</button>
            <button class="close-btn-popup" onclick="closePopup()">닫기</button>
        </div>   
    </div>

    <div class="popup-background" id="popupEquipmentBackground"></div>
    <div class="popup" id="popupEquipment">
        <button class="close-btn" onclick="closeEquipmentPopup()"><i class="fa-solid fa-xmark"></i></button>
        <p>설비 선택</p>
        <select id="equipmentInput" class="input-field" onkeydown="if(event.keyCode==13) submitEquipmentInput();">
            <option value="" selected disabled>선택하세요</option>
            <option value="1">1. X-RAY</option>
            <option value="3">3. Z-FOLDING</option>
            <option value="4">4. SEAT BACK 전후 작동내구 시험기</option>
            <option value="5">5. 복합환경내구시험기</option>
            <option value="6">6. 시트 진동내구 시험기</option>
            <option value="7">7. ROBOT 승강내구1</option>
            <option value="8">8. ROBOT 승강내구2</option>
            <option value="9">9. BENDING1</option>
            <option value="10">10. BENDING２</option>
            <option value="11">11. BENDING３</option>
            <option value="12">12. ＵＴＭ</option>
            <option value="13">13. LIFE CYCLE</option>
            <option value="14">14. KNEE TEST1</option>
            <option value="15">15. KNEE TEST2</option>
            <option value="16">16. KNEE TEST3</option>
            <option value="17">17. DRY OVEN</option>
            <option value="18">18. 항온항습기1</option>
            <option value="19">19. 항온항습기2</option>
            <option value="20">20. 항온항습기3</option>
            <option value="21">21. 먼지 시험기</option>
            <option value="22">22. 열충격 시험기</option>
            <option value="24">24. 풍량 시험기</option>
            <option value="25">25. 반무향실</option>
            <option value="26">26. 워크인챔버1</option>
            <option value="27">27. 워크인챔버2</option>
            <option value="28">28. 워크인챔버3</option>
            <option value="29">29. 염수분무시험기</option>
            <option value="30">30. 연소성 시험기</option>
        </select>
        <div class="popup-buttons">
            <button class="confirm-btn" onclick="submitEquipmentInput()">확인</button>
            <button class="close-btn-popup" onclick="closeEquipmentPopup()">닫기</button>
        </div>   
    </div>

    <?php include '../plugin_lv1.php'; ?>

    <script>
        $(document).ready(function() {
            $('a[href="#tab5"]').on('shown.bs.tab', function (e) {
                $('#contentTextarea').focus();
            });
        });
    </script>    
</body>
</html>

<?php 
    if (isset($connect4)) { mysqli_close($connect4); }	
    if(isset($connect)) { sqlsrv_close($connect); }
?>