<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.17>
	// Description:	<회람 전산화>	
    // Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
	// =============================================
    include 'sign_select_status.php';   
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>    
    <style>
        /* 팝업창의 기본 스타일 설정 */
        .sign-popup {
            display: none;
            position: fixed; /* 고정 위치 */
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%); /* 중앙으로 이동 */
            width: 320px;
            padding: 20px;
            background-color: white;
            border: 2px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            text-align: left;
            box-sizing: border-box; /* 패딩을 포함한 크기 조정 */
        }
        /* 입력창 스타일 */
        .sign-input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        /* 팝업창 닫기 버튼 스타일 */
        .sign-close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }
        /* 팝업창의 배경 */
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
        /* 팝업 버튼 스타일 */
        .sign-popup-buttons {
            display: flex;
            justify-content: flex-end; /* 버튼 우측 정렬 */
            gap: 10px;
        }
        /* 확인 버튼 스타일 */
        .sign-confirm-btn {
            background-color: #007bff; /* 파란색 */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        /* 닫기 버튼 스타일 */
        .sign-close-btn-popup {
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .name-selection label {
            display: block;
            margin-bottom: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- 메뉴 -->
        <?php include '../nav.php' ?>

        <!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">회람</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2 ?? '';?>" id="tab-two" data-toggle="pill" href="#tab2">발송</a>
                                        </li>                                   
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
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
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab2_text ?? '';?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">              
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">업로드</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="sign_select.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 요청자 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>제목</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="request21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 요청자 -->   
                                                                    <!-- Begin 일자 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>회람 기준일</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-calendar-days"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" value="<?= date('Y') ?>-" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm" data-mask2 name="calendar21" minlength="7" maxlength="7" required>                                                                           
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 일자 -->                                                                       
                                                                    <!-- Begin 자료 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>자료</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-link"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="link21" placeholder="http:// or https:// or 공백">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 자료 -->                                      
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">회람 생성 목록</h6>
                                                    </a>                                                   
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body table-responsive p-2">
                                                                <div id="table" class="table-editable">
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
                                                                            <?php 
                                                                                if (isset($Result_Sign)) {
                                                                                    while($Data_Sign = sqlsrv_fetch_array($Result_Sign, SQLSRV_FETCH_ASSOC))
                                                                                    {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo htmlspecialchars($Data_Sign['NO']); ?></td>                                                                                
                                                                                <td><?php echo htmlspecialchars($Data_Sign['TITLE']); ?></td>  
                                                                                <td><?php echo htmlspecialchars($Data_Sign['DT']); ?></td> 
                                                                                <td><?php if ($Data_Sign['SORTING_DATE'] instanceof DateTime) { echo htmlspecialchars($Data_Sign['SORTING_DATE']->format("Y-m-d")); } ?></td> 
                                                                                <td> 
                                                                                    <a href="<?php echo htmlspecialchars($Data_Sign['REPORT']); ?>" target="_blank">
                                                                                        <?php if(!empty($Data_Sign['REPORT'])) : ?>
                                                                                            <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                            <i class="fas fa-square fa-2x"></i>
                                                                                            <i class="fas fa-scroll fa-stack-1x fa-inverse"></i>                                   
                                                                                            </span>   
                                                                                        <?php endif; ?>  
                                                                                    </a>
                                                                                </td>
                                                                                <td> 
                                                                                    <a href="<?php echo htmlspecialchars($Data_Sign['LINK']); ?>" target="_blank">
                                                                                        <?php if(!empty($Data_Sign['LINK'])) : ?>
                                                                                            <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                            <i class="fas fa-square fa-2x"></i>
                                                                                            <i class="fas fa-file fa-stack-1x fa-inverse"></i>                                   
                                                                                            </span>   
                                                                                        <?php endif; ?> 
                                                                                    </a>
                                                                                </td>
                                                                                <td> 
                                                                                    <a href="#" onclick="openSignPopup(<?php echo htmlspecialchars(json_encode($Data_Sign['NO']), ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars(json_encode($Data_Sign['TITLE']), ENT_QUOTES, 'UTF-8'); ?>); return false;">
                                                                                        <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                        <i class="fas fa-square fa-2x"></i>
                                                                                        <i class="fas fa-signature fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>    
                                                                                    </a>
                                                                                </td>  
                                                                                <td> 
                                                                                    <a href="/kjwt_sign/sign.php?no=<?php echo htmlspecialchars($Data_Sign['NO']); ?>" target="_blank">
                                                                                        <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                        <i class="fas fa-square fa-2x"></i>
                                                                                        <i class="fas fa-print fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>    
                                                                                    </a>
                                                                                </td>  
                                                                                <td> 
                                                                                    <a href="/kjwt_sign/sign.php?no=<?php echo htmlspecialchars($Data_Sign['NO']); ?>&show_dt=1" target="_blank">
                                                                                        <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                        <i class="fas fa-square fa-2x"></i>
                                                                                        <i class="fas fa-print fa-stack-1x fa-inverse"></i>                                   
                                                                                        </span>    
                                                                                    </a>
                                                                                </td>                                                                                 
                                                                            </tr> 
                                                                            <?php 
                                                                                    }
                                                                                }
                                                                            ?>                     
                                                                        </tbody>
                                                                    </table>
                                                                </div>                                     
                                                            </div>
                                                            <!-- /.card-body -->                                                             
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>                                          
                                        </div>                                           
                                    </div>
                                </div>
                            </div>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- 회람 서명 팝업 HTML -->
    <div class="sign-popup-background" id="signPopupBackground"></div>
    <div class="sign-popup" id="signPopup">
        <button class="sign-close-btn" onclick="closeSignPopup()"><i class="fa-solid fa-xmark"></i></button>
        <p>[회람] <span id="signPopupTitle"></span></p>
        <input type="hidden" id="signPopupNo" value="" />
        <input type="text" id="signPopupUserInput" class="sign-input-field" placeholder="주민번호 앞 6자리" />   
        <div class="sign-popup-buttons">
            <button class="sign-confirm-btn" onclick="submitSignInput()">확인</button>
            <button class="sign-close-btn-popup" onclick="closeSignPopup()">닫기</button>
        </div>   
    </div>

    <!-- 이름 선택 팝업 HTML -->
    <div class="sign-popup-background" id="namePopupBackground"></div>
    <div class="sign-popup" id="namePopup">
        <p>동일한 생년월일을 가진 직원이 여러 명 있습니다. 본인을 선택해주세요.</p>
        <div class="name-selection" id="nameSelectionContainer">
            <!-- 이름 목록이 여기에 동적으로 추가됩니다. -->
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
                // sign_select_status.php에서 처리를 위해 GET 파라미터와 함께 페이지를 다시 로드합니다.
                window.location.href = "sign_select.php?listno=" + encodeURIComponent(no) + "&input=" + encodeURIComponent(input);
            } else {
                alert("값을 입력해 주세요.");
            }
        }

        function openNameSelectionPopup(listno, names) {
            const container = document.getElementById('nameSelectionContainer');
            container.innerHTML = ''; // 이전 목록을 지웁니다.
            names.forEach(name => {
                const label = document.createElement('label');
                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = 'employee_name';
                radio.value = name;
                label.appendChild(radio);
                label.appendChild(document.createTextNode(' ' + name));
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
                    // Automatically add a hyphen after the year (4 digits)
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
    //MARIA DB 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }	

    //MARIA DB 메모리 회수
    mysqli_close($connect);	

    //MSSQL 메모리 회수
    if(isset($connect6)) { sqlsrv_close($connect6); }
?>