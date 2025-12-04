<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.17>
	// Description:	<회람 전산화>	
    // Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
    // Last Modified: <Current Date> - Fixed Mobile Empty Link Behavior
	// =============================================
    include 'sign_select_status.php';   

    // XSS 방지 함수
    function h($string) {
        if (!isset($string)) return '';
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    // [데이터 전처리] 결과 데이터를 배열로 저장 (모바일/PC 공용)
    $sign_list = [];
    if (isset($Result_Sign) && $Result_Sign) {
        while ($row = sqlsrv_fetch_array($Result_Sign, SQLSRV_FETCH_ASSOC)) {
            $sign_list[] = $row;
        }
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>    
    <style>
        /* 팝업창 스타일 (반응형 적용) */
        .sign-popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 90%; /* 모바일 대응 */
            max-width: 350px; /* PC 최대 너비 */
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            text-align: left;
            box-sizing: border-box;
        }
        /* 입력창 스타일 */
        .sign-input-field {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #d1d3e2;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }
        /* 팝업창 닫기 버튼 (X) */
        .sign-close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background-color: transparent;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #858796;
        }
        /* 팝업 배경 */
        .sign-popup-background {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        /* 팝업 버튼 영역 */
        .sign-popup-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        /* 확인 버튼 */
        .sign-confirm-btn {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        /* 닫기 버튼 */
        .sign-close-btn-popup {
            background-color: #f8f9fc;
            border: 1px solid #d1d3e2;
            color: #858796;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .name-selection label {
            display: block;
            padding: 5px 0;
            cursor: pointer;
        }
        
        /* 아이콘 스타일 보정 (겹침 방지) */
        .action-icon-wrapper {
            display: flex;
            flex-direction: column; /* 수직 배열 */
            align-items: center;    /* 중앙 정렬 */
            text-align: center;     /* 텍스트 중앙 정렬 */
            color: #4e73df;
            text-decoration: none !important;
            width: 50px; /* 고정 너비로 간격 유지 */
        }
        .action-icon-wrapper i {
            margin-bottom: 5px; /* 아이콘 아래 간격 추가 */
            font-size: 1.2rem;  /* 아이콘 크기 조정 */
        }
        .action-icon-wrapper span {
            font-size: 0.7rem;
            color: #858796;
            display: block;     
            width: 100%;        
            white-space: nowrap; 
            overflow: hidden;    
            text-overflow: ellipsis; 
        }
        
        /* [추가] 비활성화 스타일 (클릭 방지) */
        .pointer-events-none {
            pointer-events: none; /* 클릭 이벤트 차단 */
            cursor: default;
            opacity: 0.6; /* 시각적으로 비활성화됨을 표시 */
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">회람</h1>
                    </div>               

                    <div class="row"> 

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab2 ?? '');?>" id="tab-two" data-toggle="pill" href="#tab2">발송</a>
                                        </li>                                   
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<br>
                                            - 회람 전산화<br><br>

                                            [기능]<br>
                                            발송탭)<br>
                                            [회람 생성 목록] 업로드 카드에서 제목, 회람 기준일, 자료 링크(url/미입력 가능)을 입력하면 데이터가 생성된다.<br>
                                            [회람 생성 목록] 업로드 카드에서 자료링크에 url을 입력하면 자료 열에 아이콘이 생성된다.<br>
                                            [회람 생성 목록] 자료 열 아이콘을 클릭하면 링크된 URL로 연결된다.<br>
                                            [회람 생성 목록] 서명 열 아이콘을 클릭하면 생년월일을 등록하라는 팝업창이 생성되며 ERP 사원등록되어 있는 생년월일인 경우 링크된 URL로 연결되고 확인/출력 열과 확인/출력(싸인일시포함) 열의 아이콘을 클릭했을 경우 해당 생년월일을 가지고 있는 직원 이름 옆에 싸인이 되어 있다.<br>
                                            [회람 생성 목록] 확인/출력 열 아이콘 클릭 시 싸인한 인원 내역을 확인할 수 있다.<br>
                                            [회람 생성 목록] 확인/출력(싸인일시포함) 열 아이콘 클릭 시 싸인한 인원 내역과 싸인 일시를 확인할 수 있다.<br>

                                            [참조]<br>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 사무직<br><br>

                                            [제작일]<br>
                                            - 24.10.17<br><br>                                            
                                        </div>
                                        <div class="tab-pane fade <?php echo h($tab2_text ?? '');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">              
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">업로드</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="sign_select.php"> 
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body p-3">
                                                            <div class="row">                                                                        
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>제목</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                                                            <input type="text" class="form-control" name="request21" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>회람 기준일</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-days"></i></span></div>
                                                                            <input type="text" class="form-control" value="<?= date('Y') ?>-" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm" data-mask2 name="calendar21" minlength="7" maxlength="7" required>                                                                           
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>자료</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-link"></i></span></div>
                                                                            <input type="text" class="form-control" name="link21" placeholder="http:// or https:// or 공백">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div>

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">회람 생성 목록</h6>
                                                </a>                                                   
                                                <div class="collapse show" id="collapseCardExample22">
                                                    <div class="card-body p-2">
                                                        
                                                        <div class="d-md-none">
                                                            <?php foreach ($sign_list as $row): ?>
                                                            <div class="card mb-2 shadow-sm border-0">
                                                                <div class="card-body p-3">
                                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                                        <h6 class="font-weight-bold text-dark mb-0" style="line-height: 1.4;"><?= h($row['TITLE']) ?></h6>
                                                                        <span class="badge badge-light text-secondary border ml-2">NO.<?= h($row['NO']) ?></span>
                                                                    </div>
                                                                    <div class="small text-gray-600 mb-3">
                                                                        기준일: <?= h($row['DT']) ?> 
                                                                        <?php if ($row['SORTING_DATE'] instanceof DateTime): ?>
                                                                            | 생성: <?= h($row['SORTING_DATE']->format("y.m.d")) ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    
                                                                    <div class="d-flex justify-content-between border-top pt-3">
                                                                        <?php
                                                                            $has_report = !empty($row['REPORT']);
                                                                            $report_link = $has_report ? h($row['REPORT']) : 'javascript:void(0);';
                                                                            $report_target = $has_report ? '_blank' : '_self';
                                                                            $report_class = $has_report ? '' : 'text-gray-300 pointer-events-none';
                                                                            $report_onclick = $has_report ? '' : 'onclick="return false;"';
                                                                        ?>
                                                                        <a href="<?= $report_link ?>" target="<?= $report_target ?>" class="action-icon-wrapper <?= $report_class ?>" <?= $report_onclick ?>>
                                                                            <i class="fas fa-scroll fa-lg"></i>
                                                                            <span>보고서</span>
                                                                        </a>

                                                                        <?php
                                                                            $has_link = !empty($row['LINK']);
                                                                            $link_url = $has_link ? h($row['LINK']) : 'javascript:void(0);';
                                                                            $link_target = $has_link ? '_blank' : '_self';
                                                                            $link_class = $has_link ? '' : 'text-gray-300 pointer-events-none';
                                                                            $link_onclick = $has_link ? '' : 'onclick="return false;"';
                                                                        ?>
                                                                        <a href="<?= $link_url ?>" target="<?= $link_target ?>" class="action-icon-wrapper <?= $link_class ?>" <?= $link_onclick ?>>
                                                                            <i class="fas fa-file fa-lg"></i>
                                                                            <span>자료</span>
                                                                        </a>

                                                                        <a href="#" onclick="openSignPopup(<?= h(json_encode($row['NO'])) ?>, <?= h(json_encode($row['TITLE'])) ?>); return false;" class="action-icon-wrapper text-danger">
                                                                            <i class="fas fa-signature fa-lg"></i>
                                                                            <span>서명</span>
                                                                        </a>

                                                                        <a href="/kjwt_sign/sign.php?no=<?= h($row['NO']) ?>" target="_blank" class="action-icon-wrapper text-success">
                                                                            <i class="fas fa-print fa-lg"></i>
                                                                            <span>출력</span>
                                                                        </a>
                                                                        
                                                                        <a href="/kjwt_sign/sign.php?no=<?= h($row['NO']) ?>&show_dt=1" target="_blank" class="action-icon-wrapper text-info">
                                                                            <i class="fas fa-clock fa-lg"></i>
                                                                            <span>상세</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table_sign">
                                                                <thead>
                                                                    <tr>
                                                                        <th>NO</th>
                                                                        <th>제목</th>
                                                                        <th>기준일</th> 
                                                                        <th>생성일</th>
                                                                        <th>보고서</th> 
                                                                        <th>자료</th> 
                                                                        <th>서명</th> 
                                                                        <th>확인/출력</th>
                                                                        <th>확인/출력(싸인일시포함)</th>                                                                                
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($sign_list as $Data_Sign): ?>
                                                                    <tr>
                                                                        <td><?= h($Data_Sign['NO']) ?></td>                                                                                
                                                                        <td><?= h($Data_Sign['TITLE']) ?></td>  
                                                                        <td><?= h($Data_Sign['DT']) ?></td> 
                                                                        <td><?php if ($Data_Sign['SORTING_DATE'] instanceof DateTime) { echo h($Data_Sign['SORTING_DATE']->format("Y-m-d")); } ?></td> 
                                                                        <td> 
                                                                            <a href="<?= h($Data_Sign['REPORT']) ?>" target="_blank">
                                                                                <?php if(!empty($Data_Sign['REPORT'])) : ?>
                                                                                    <span class="fa-stack fa-lg" style="text-align: center;">                                    
                                                                                    <i class="fas fa-square fa-stack-2x text-gray-200"></i>
                                                                                    <i class="fas fa-scroll fa-stack-1x text-primary"></i>                                   
                                                                                    </span>   
                                                                                <?php endif; ?>  
                                                                            </a>
                                                                        </td>
                                                                        <td> 
                                                                            <a href="<?= h($Data_Sign['LINK']) ?>" target="_blank">
                                                                                <?php if(!empty($Data_Sign['LINK'])) : ?>
                                                                                    <span class="fa-stack fa-lg" style="text-align: center;">                                    
                                                                                    <i class="fas fa-square fa-stack-2x text-gray-200"></i>
                                                                                    <i class="fas fa-file fa-stack-1x text-primary"></i>                                   
                                                                                    </span>   
                                                                                <?php endif; ?> 
                                                                            </a>
                                                                        </td>
                                                                        <td> 
                                                                            <a href="#" onclick="openSignPopup(<?= h(json_encode($Data_Sign['NO'])) ?>, <?= h(json_encode($Data_Sign['TITLE'])) ?>); return false;">
                                                                                <span class="fa-stack fa-lg" style="text-align: center;">                                    
                                                                                <i class="fas fa-square fa-stack-2x text-gray-200"></i>
                                                                                <i class="fas fa-signature fa-stack-1x text-danger"></i>                                   
                                                                                </span>    
                                                                            </a>
                                                                        </td>  
                                                                        <td> 
                                                                            <a href="/kjwt_sign/sign.php?no=<?= h($Data_Sign['NO']) ?>" target="_blank">
                                                                                <span class="fa-stack fa-lg" style="text-align: center;">                                    
                                                                                <i class="fas fa-square fa-stack-2x text-gray-200"></i>
                                                                                <i class="fas fa-print fa-stack-1x text-success"></i>                                   
                                                                                </span>    
                                                                            </a>
                                                                        </td>  
                                                                        <td> 
                                                                            <a href="/kjwt_sign/sign.php?no=<?= h($Data_Sign['NO']) ?>&show_dt=1" target="_blank">
                                                                                <span class="fa-stack fa-lg" style="text-align: center;">                                    
                                                                                <i class="fas fa-square fa-stack-2x text-gray-200"></i>
                                                                                <i class="fas fa-clock fa-stack-1x text-info"></i>                                   
                                                                                </span>    
                                                                            </a>
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
                    </div>
                </div>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="sign-popup-background" id="signPopupBackground"></div>
    <div class="sign-popup" id="signPopup">
        <button class="sign-close-btn" onclick="closeSignPopup()"><i class="fa-solid fa-xmark"></i></button>
        <h6 class="font-weight-bold text-primary mb-3">[회람] <span id="signPopupTitle" class="text-dark"></span></h6>
        <input type="hidden" id="signPopupNo" value="" />
        <input type="text" id="signPopupUserInput" class="sign-input-field" placeholder="주민번호 앞 6자리" />   
        <div class="sign-popup-buttons">
            <button class="sign-confirm-btn" onclick="submitSignInput()">확인</button>
            <button class="sign-close-btn-popup" onclick="closeSignPopup()">닫기</button>
        </div>   
    </div>

    <div class="sign-popup-background" id="namePopupBackground"></div>
    <div class="sign-popup" id="namePopup">
        <p class="font-weight-bold mb-3">동명이인 선택</p>
        <p class="small mb-3">동일한 생년월일을 가진 직원이 여러 명 있습니다.<br>본인을 선택해주세요.</p>
        <div class="name-selection mb-3" id="nameSelectionContainer">
            </div>
        <div class="sign-popup-buttons">
            <button class="sign-confirm-btn" onclick="submitNameSelection()">확인</button>
        </div>
    </div>

    <script>
        function openSignPopup(no, title) {
            document.getElementById('signPopupTitle').innerText = title;
            document.getElementById('signPopupNo').value = no;
            document.getElementById('signPopupBackground').style.display = 'block';
            document.getElementById('signPopup').style.display = 'block';
        }

        function closeSignPopup() {
            document.getElementById('signPopupBackground').style.display = 'none';
            document.getElementById('signPopup').style.display = 'none';
        }

        function submitSignInput() {
            const input = document.getElementById("signPopupUserInput").value;
            const no = document.getElementById("signPopupNo").value;
            
            if (input) {
                window.location.href = "sign_select.php?listno=" + encodeURIComponent(no) + "&input=" + encodeURIComponent(input);
            } else {
                alert("값을 입력해 주세요.");
            }
        }

        function openNameSelectionPopup(listno, names) {
            const container = document.getElementById('nameSelectionContainer');
            container.innerHTML = ''; 
            names.forEach(name => {
                const label = document.createElement('label');
                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = 'employee_name';
                radio.value = name;
                radio.className = 'mr-2';
                label.appendChild(radio);
                label.appendChild(document.createTextNode(name));
                container.appendChild(label);
            });

            document.getElementById('namePopupBackground').style.display = 'block';
            document.getElementById('namePopup').style.display = 'block';
        }

        function submitNameSelection() {
            const selected_radio = document.querySelector('#namePopup input[name="employee_name"]:checked');
            if (selected_radio) {
                const selected_name = selected_radio.value;
                const listno = <?php echo json_encode($listno ?? null); ?>;
                if (listno) {
                    window.location.href = "sign_select.php?listno=" + encodeURIComponent(listno) + "&input2=" + encodeURIComponent(selected_name);
                }
            } else {
                alert("이름을 선택해주세요.");
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.querySelector('input[name="calendar21"]');
            if (dateInput) {
                dateInput.addEventListener('input', function(e) {
                    let value = e.target.value;
                    if (value.length === 4 && e.inputType !== 'deleteContentBackward') {
                        e.target.value = value + '-';
                    }
                });
            }
        });

        <?php
        if (!empty($duplicate_names)) {
            $safe_listno = json_encode($listno ?? null);
            $safe_duplicate_names = json_encode($duplicate_names);
            echo "window.onload = function() { openNameSelectionPopup($safe_listno, $safe_duplicate_names); };";
        }
        ?>
    </script>

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    // 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }	
    if(isset($connect)) { mysqli_close($connect); }	
    if(isset($connect6)) { sqlsrv_close($connect6); }
?>