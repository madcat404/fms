<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.01.11>
	// Description:	<검교정>
    // Last Modified: <25.09.23> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include 'calibration_status.php';
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>    

    <script language="javascript">
        //이미지 확대 스크립트 (모달 사용)
        function bigimg(imageUrl){ 
            // 모달 내부의 이미지 태그의 src를 설정
            document.getElementById('bigModalImage').src = imageUrl;
            // 부트스트랩 모달을 띄움
            $('#imageModal').modal('show');
        }
    </script>
</head>

<body id="page-top">
    <script>
        // Preload instrument data for the action modal
        const instrumentData = <?php echo json_encode($title); ?>;
    </script>

    <!-- Page Wrapper -->
    <div id="wrapper">      
        
        <!-- 매뉴 -->
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">검교정</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">라벨발행</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4;?>" id="tab-four" data-toggle="pill" href="#tab4">이력</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 시험실 검교정 관리 전산화<BR><BR>   

                                            [기능]<br>
                                            1. 목록 탭<br>
                                            - [리스트] 업로드 카드에서 파일 업로드 시 성적서 열에 아이콘이 생성되고 해당 아이콘 클릭 시 파일 다운로드 가능<BR>   
                                            - [리스트] 알맞는 QR코드를 스캔하여 교정을 선택한 경우 교정일자 열과 판정 열을 업데이트 할 수 있음<BR>   
                                            - [리스트] 알맞는 QR코드를 스캔하여 반입/반출을 선택하여 반출 열을 업데이트 할 수 있음<BR><BR>                                   

                                            [히스토리]<BR>
                                            25.04.28)<BR>
                                            - 목록탭에 등록카드를 추가하였고 등록카드는 기본적으로 접혀있는 상태로 시작함<BR>
                                            - 목록탭 리스트카드에 검사완료 열을 추가함 (원칙적으로 외부업체가 검사를 하고 사용자가 판정을 해야함)<BR>
                                            - 목록탭 리스트카드의 금년 검교정 예정 카드의 숫자는 미검사 수량을 카운트하도록 함<BR>
                                            - QR코드 라벨 출력탭 생성함<BR>
                                            - 검사 Y인데 판정이 Y가 아닌경우 담당자에게 알림 (1주일 단위)<BR>
                                            - 년 변경 시 리셋 기능추가 (MSSQL 에이전트)<BR>
                                            - 교정일 1달전 메일 발송 기능추가<BR> 
                                            25.06.16)<BR>
                                            - 검사 시 QR코드를 스캔할 때 마다 팝업창의 선택버튼을 눌러야하는 불편함이 있어 연속 업무가 가능토록 토글 스위치 추가<BR><BR>                                        

                                            [참조]<BR>
                                            - 요청자: 전우준sw<br>
                                            - 사용자: 시험팀<br>
                                            - QR 예시: https://fms.iwin.kr/kjwt_calibration/calibration_pop.php?no=5 (no는 등록번호)<br>
                                            - 검교정은 무조건 1년에 1번 시행<br>
                                            - 검교정 대상 제품이 작은것도 있지만 사람이 이동하기 힘든 큰 제품도 있음 (따라서 QR코드를 출력하여 특정 제품에는 부착하고 부착하기 어려운 제품은 QR코드를 노트와 같은곳에 모아두는 형태로 관리예정)<br>
                                            - 보통 검교정은 교정 예정일 1달 전에 실시함<br>
                                            <br> 
                                            
                                            [제작일]<BR>
                                            - 25.01.11<br><br>  
                                        </div>
                                        
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">  
                                            <!-- 등록!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample20" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample20">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">등록</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="calibration.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse" id="collapseCardExample20">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">  
                                                                    <!-- Begin 대분류 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>대분류</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-th-list"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="kind20" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 대분류 -->  
                                                                    <!-- Begin 계측기명 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>계측기명</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-dice-d6"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="name20" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 계측기명 -->   
                                                                    <!-- Begin 기기번호 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>기기번호</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-list-ol"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="number20" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 기기번호 -->         
                                                                    <!-- Begin 구입처 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>구입처</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-shopping-cart"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="buy20" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 구입처 -->  
                                                                    <!-- Begin 규격 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>규격</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-ruler"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="model20" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 규격 -->  
                                                                    <!-- Begin 관리부서 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>관리부서</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-users"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="department20" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 관리부서 -->  
                                                                    <!-- Begin 해당공정(담당팀) -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>해당공정(담당팀)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-cog"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="team20" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 해당공정(담당팀) -->  
                                                                    <!-- Begin 해당공정(장소) -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>해당공정(장소)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="location20" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 해당공정(장소) -->  
                                                                    <!-- Begin Share 여부  -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Share 여부 </label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-share"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="share20">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end Share 여부 --> 
                                                                    <!-- Begin 비고 -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>비고</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-sticky-note"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="note20">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 비고 -->                                    
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">                                                                
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt20">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 
 
                                            <!-- 업로드!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">업로드</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="calibration_upload.php" enctype="multipart/form-data"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 항목선택 -->     
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>선택</label>
                                                                            <select name="title" class="form-control select2" style="width: 100%;">
                                                                                <option value="" selected="selected">선택</option>
                                                                                <?php foreach ( $title as $option ) : ?>
                                                                                    <option value="<?php echo htmlspecialchars($option['REGISTER_NO'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($option['REGISTER_NO'].'.'.$option['NAME'].'_'.$option['NUMBER'], ENT_QUOTES, 'UTF-8'); ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 항목선택 -->                                                                       
                                                                    <!-- Begin 파일선택 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>파일선택</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="file" name="file"> 
                                                                                <label class="custom-file-label" for="file">파일선택</label>
                                                                            </div>                                                      
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 파일선택 -->                                        
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

                                            <!-- 검사 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검사</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" onsubmit="return handleSubmit(event)"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample23">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">  
                                                                    <!-- Begin 대분류 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>QR코드 스캔</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-qrcode"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="QR23" id="QR23" autofocus required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 대분류 -->              
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <div class="custom-control custom-switch">
                                                                    <div class="custom-control custom-switch" style="display: inline-block; margin-right: 15px;">
                                                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="Switch1" <?php echo (isset($_GET['switch']) && $_GET['switch'] == '1') ? 'checked' : ''; ?>>
                                                                        <label class="custom-control-label" for="customSwitch1">연속검사</label>
                                                                    </div>
                                                                    <div class="custom-control custom-switch" style="display: inline-block; margin-right: 15px;">
                                                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" name="Switch2" <?php echo (isset($_GET['switch']) && $_GET['switch'] == '2') ? 'checked' : ''; ?>>
                                                                        <label class="custom-control-label" for="customSwitch2">연속반입</label>
                                                                    </div>
                                                                    <div class="custom-control custom-switch" style="display: inline-block; margin-right: 15px;">
                                                                        <input type="checkbox" class="custom-control-input" id="customSwitch3" name="Switch3" <?php echo (isset($_GET['switch']) && $_GET['switch'] == '3') ? 'checked' : ''; ?>>
                                                                        <label class="custom-control-label" for="customSwitch3">연속반출</label>
                                                                    </div>
                                                                    <div class="custom-control custom-switch" style="display: inline-block; margin-right: 15px;">
                                                                        <input type="checkbox" class="custom-control-input" id="customSwitch4" name="Switch4" <?php echo (isset($_GET['switch']) && $_GET['switch'] == '4') ? 'checked' : ''; ?>>
                                                                        <label class="custom-control-label" for="customSwitch4">연속판정</label>
                                                                    </div>
                                                                    <button type="submit" value="on" class="btn btn-primary" name="bt23">입력</button>
                                                                </div>

                                                                <script>
                                                                    // 체크박스 요소들을 가져옵니다
                                                                    const switchElements = [
                                                                        document.getElementById('customSwitch1'),
                                                                        document.getElementById('customSwitch2'),
                                                                        document.getElementById('customSwitch3'),
                                                                        document.getElementById('customSwitch4')
                                                                    ];

                                                                    // 페이지 로드 시 체크된 체크박스가 있다면 다른 체크박스들을 비활성화
                                                                    document.addEventListener('DOMContentLoaded', function() {
                                                                        switchElements.forEach((switchEl, index) => {
                                                                            if (switchEl.checked) {
                                                                                // 현재 체크된 체크박스를 제외한 나머지를 비활성화
                                                                                switchElements.forEach((otherSwitch, otherIndex) => {
                                                                                    if (index !== otherIndex) {
                                                                                        otherSwitch.disabled = true;
                                                                                    }
                                                                                });
                                                                            }
                                                                        });
                                                                    });

                                                                    // 각 체크박스에 이벤트 리스너를 추가합니다
                                                                    switchElements.forEach((switchEl, index) => {
                                                                        switchEl.addEventListener('click', function(e) {
                                                                            if (this.checked) {
                                                                                // 현재 체크된 체크박스를 제외한 나머지를 즉시 비활성화합니다
                                                                                switchElements.forEach((otherSwitch, otherIndex) => {
                                                                                    if (index !== otherIndex) {
                                                                                        otherSwitch.disabled = true;
                                                                                    }
                                                                                });
                                                                            } else {
                                                                                // 체크가 해제되면 모든 체크박스를 다시 활성화합니다
                                                                                switchElements.forEach(otherSwitch => {
                                                                                    otherSwitch.disabled = false;
                                                                                });
                                                                            }
                                                                        });
                                                                    });
                                                                </script>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <script>
                                                function handleSubmit(event) {
                                                    event.preventDefault(); // 기본 폼 제출 동작 방지
                                                    
                                                    const qrValue = document.getElementById('QR23').value;
                                                    const switch1 = document.getElementById('customSwitch1').checked;
                                                    const switch2 = document.getElementById('customSwitch2').checked;
                                                    const switch3 = document.getElementById('customSwitch3').checked;
                                                    const switch4 = document.getElementById('customSwitch4').checked;

                                                    /*if (!qrValue.startsWith('https://fms.iwin.kr/')) {
                                                        alert('유효하지 않은 QR코드 형식입니다.');
                                                        return false;
                                                    }*/

                                                    const urlParams = new URL(qrValue).searchParams;
                                                    const no = urlParams.get('no');

                                                    if (!no) {
                                                        alert('QR코드에서 등록번호를 찾을 수 없습니다.');
                                                        return false;
                                                    }

                                                    // If any continuous switch is on, redirect for direct processing
                                                    if (switch1 || switch2 || switch3 || switch4) {
                                                        const switchParams = `switch1=${switch1 ? '1' : '0'}&switch2=${switch2 ? '1' : '0'}&switch3=${switch3 ? '1' : '0'}&switch4=${switch4 ? '1' : '0'}`;
                                                        const finalUrl = `${qrValue}${qrValue.includes('?') ? '&' : '?'}${switchParams}`;
                                                        window.location.href = finalUrl;
                                                        return false;
                                                    }

                                                    // Find instrument data from preloaded array
                                                    const instrument = instrumentData.find(item => item.REGISTER_NO == no);

                                                    if (instrument) {
                                                        // Populate and show the action modal
                                                        document.getElementById('actionModalTitle').innerText = `[검교정] ${instrument.REGISTER_NO}. ${instrument.NAME}_${instrument.NUMBER}`;
                                                        
                                                        // Dynamically set button actions
                                                        document.getElementById('actionBtnInspect').onclick = function() { window.location.href = `calibration.php?registerno=${no}&flag=inspect`; };
                                                        document.getElementById('actionBtnIn').onclick = function() { window.location.href = `calibration.php?registerno=${no}&flag=in`; };
                                                        document.getElementById('actionBtnOut').onclick = function() { window.location.href = `calibration.php?registerno=${no}&flag=out`; };
                                                        document.getElementById('actionBtnJudge').onclick = function() { window.location.href = `calibration.php?registerno=${no}&flag=check`; };

                                                        $('#actionModal').modal('show');
                                                    } else {
                                                        alert('해당 등록번호의 계측기를 찾을 수 없습니다.');
                                                    }
                                                    
                                                    return false;
                                                }
                                            </script>

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">리스트</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="calibration.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body table-responsive p-2"> 
                                                                <div class="row">
                                                                    <!-- 보드 시작 -->
                                                                    <?php 
                                                                        echo BOARD2(4, "primary", "전체수량", $Count_calibration, "fas fa-list", "normal", "");
                                                                        echo BOARD2(4, "info", "금년 검교정 예정", $Count_calibration-$Count_calibrationJudege, "fas fa-wrench", "normal", "");
                                                                        echo BOARD2(4, "success", "금년 검교정 완료", $Count_calibrationJudege, "fas fa-user-check", "normal", "");
                                                                    ?>
                                                                    <!-- 보드 끝 -->
                                                                </div> 

                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>등록번호</th>
                                                                                <th>대분류</th>   
                                                                                <th>계측기명</th>
                                                                                <th>기기번호</th>
                                                                                <th>구입처</th>
                                                                                <th>규격</th>
                                                                                <th>관리부서</th>
                                                                                <th>교정주기</th>
                                                                                <th>교정일자(검사일)</th>
                                                                                <th>차기교정일</th>
                                                                                <th>검사</th>
                                                                                <th>판정</th>
                                                                                <th>반출</th>
                                                                                <th>해당공정(담당팀)</th>
                                                                                <th>해당공정(장소)</th>
                                                                                <th>Share여부</th>
                                                                                <th>비고</th>
                                                                                <th>성적서</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                while($Data_calibration = sqlsrv_fetch_array($Result_calibration))
                                                                                {
                                                                            ?>                                                                            
                                                                                <tr> 
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['REGISTER_NO'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>   
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['KIND'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                                    <td> 
                                                                                        <?php
                                                                                            $registerNo = $Data_calibration['REGISTER_NO'] ?? '';
                                                                                            $imageWebPath = ''; // This will hold the web-accessible path

                                                                                            if (!empty($registerNo)) {
                                                                                                $baseServerPath = __DIR__ . '/../img/calibration/' . $registerNo;
                                                                                                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                                                                                foreach ($allowedExtensions as $ext) {
                                                                                                    if (file_exists($baseServerPath . '.' . $ext)) {
                                                                                                        // Found the image, construct the web path
                                                                                                        $imageWebPath = '../img/calibration/' . $registerNo . '.' . $ext;
                                                                                                        break;
                                                                                                    }
                                                                                                }
                                                                                            }

                                                                                            if ($imageWebPath) {
                                                                                        ?>
                                                                                            <a href="#" onclick="bigimg('<?php echo htmlspecialchars($imageWebPath, ENT_QUOTES, 'UTF-8'); ?>'); return false;" style="cursor: pointer;">
                                                                                                <?php echo htmlspecialchars($Data_calibration['NAME'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                                                                            </a>
                                                                                        <?php
                                                                                            } else {
                                                                                                echo htmlspecialchars($Data_calibration['NAME'] ?? '', ENT_QUOTES, 'UTF-8');
                                                                                            }
                                                                                        ?>
                                                                                    </td>  
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['NUMBER'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['BUY'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['STANDARD'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['MANAGER'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['CYCLE'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td><?php echo ($Data_calibration['LastCalibrationDate']) ? htmlspecialchars(date_format($Data_calibration['LastCalibrationDate'], "Y-m-d"), ENT_QUOTES, 'UTF-8') : ''; ?></td>
                                                                                    <td><?php echo ($Data_calibration['NewDate']) ? htmlspecialchars(date_format($Data_calibration['NewDate'], "Y-m-d"), ENT_QUOTES, 'UTF-8') : ''; ?></td> 
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['INSPECT'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>    
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['JUDGMENT'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['OUT_YN'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['APPLY_TEAM'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['APPLY_LOCATION'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['SHARE'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>                                                                                      
                                                                                    <td><?php echo htmlspecialchars($Data_calibration['NOTE'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                                    <td>
                                                                                    <?php 
                                                                                        if(!empty($Data_calibration['FILE_NAME'])) {
                                                                                    ?>   
                                                                                            <a href="https://fms.iwin.kr/files/<?php echo htmlspecialchars($Data_calibration['FILE_NAME'], ENT_QUOTES, 'UTF-8');?>.<?php echo htmlspecialchars($Data_calibration['FILE_EXTENSION'], ENT_QUOTES, 'UTF-8');?>" target="_blank">
                                                                                                <span class="fa-stack fa-2x" style="text-align: center;">                                    
                                                                                                <i class="fas fa-square fa-2x"></i>
                                                                                                <i class="fas fa-file fa-stack-1x fa-inverse"></i>                                   
                                                                                                </span>    
                                                                                            </a>
                                                                                    <?php 
                                                                                        }
                                                                                    ?>
                                                                                    </td>
                                                                                </tr>                                                                           
                                                                            <?php 
                                                                                }
                                                                            ?>                     
                                                                        </tbody>
                                                                    </table>                                                                    
                                                                </div> 
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form> 
                                                </div>
                                                <!-- /.card -->
                                            </div>                                          
                                        </div>  

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three"> 
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">라벨발행</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="calibration_label_force.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                 
                                                                    <!-- Begin 항목선택 -->     
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>선택</label>
                                                                            <select name="title31" class="form-control select2" style="width: 100%;">
                                                                                <option value="" selected="selected">선택</option>
                                                                                <?php foreach ( $title as $option ) : ?>
                                                                                    <option value="<?php echo htmlspecialchars($option['REGISTER_NO'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($option['REGISTER_NO'].'.'.$option['NAME'].'_'.$option['NUMBER'], ENT_QUOTES, 'UTF-8'); ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 항목선택 --> 
                                                                </div> 
                                                                <!-- /.row -->   
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">발행</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div>  
                                        </div> 

                                        <!-- 4번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="tab4" role="tabpanel" aria-labelledby="tab-four"> 
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="calibration.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample41">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 검색범위 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <?php 
                                                                                    if($dt4!='') {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo htmlspecialchars($dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d'), ENT_QUOTES, 'UTF-8'); ?>" name="dt4">
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" name="dt4">
                                                                                <?php 
                                                                                    }
                                                                                ?>                                                                                 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 검색범위 -->                           
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt41">검색</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>  

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample42">
                                                        <div class="card-body table-responsive p-2">    
                                                            <table class="table table-bordered table-hover text-nowrap" id="table6">
                                                                <thead>
                                                                    <tr>
                                                                        <th>등록번호</th>
                                                                        <th>대분류</th>   
                                                                        <th>계측기명</th>
                                                                        <th>기기번호</th>
                                                                        <th>구입처</th>
                                                                        <th>규격</th>
                                                                        <th>관리부서</th>
                                                                        <th>교정주기</th>
                                                                        <th>교정일자(검사일)</th>
                                                                        <th>검사</th>
                                                                        <th>판정</th>
                                                                        <th>반출</th>
                                                                        <th>해당공정(담당팀)</th>
                                                                        <th>해당공정(장소)</th>
                                                                        <th>Share여부</th>
                                                                        <th>비고</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        // The $Result_Select variable is expected to be set from calibration_status.php
                                                                        if (isset($Result_Select) && $Result_Select) {
                                                                            while($Data_Select = sqlsrv_fetch_array($Result_Select))
                                                                            {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($Data_Select['REGISTER_NO'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['KIND'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>   
                                                                        <td><?php echo htmlspecialchars($Data_Select['NAME'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['NUMBER'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['BUY'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['STANDARD'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['MANAGER'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['CYCLE'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo ($Data_Select['HISTORY_DT']) ? htmlspecialchars(date_format($Data_Select['HISTORY_DT'], "Y-m-d"), ENT_QUOTES, 'UTF-8') : ''; ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['INSPECT'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['JUDGMENT'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['OUT_YN'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['APPLY_TEAM'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['APPLY_LOCATION'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['SHARE'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['NOTE'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                    </tr> 
                                                                    <?php 
                                                                            }
                                                                        }
                                                                    ?>       
                                                                </tbody>
                                                            </table>                                     
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

    <!-- Action Modal -->
    <div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="actionModalLabel">작업 선택</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <p id="actionModalTitle"></p>
            <div class="popup-buttons">            
                <button id="actionBtnInspect" class="btn btn-primary">검사</button>
                <button id="actionBtnIn" class="btn btn-info">반입</button>
                <button id="actionBtnOut" class="btn btn-warning">반출</button>
                <button id="actionBtnJudge" class="btn btn-success">판정</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="imageModalLabel">계측기 이미지</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <img src="" id="bigModalImage" class="img-fluid" alt="Instrument Image">
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>  
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); }

    //MARIA DB 메모리 회수
    mysqli_close($connect);
?>