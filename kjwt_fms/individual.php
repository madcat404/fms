<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.10.12>
	// Description:	<개인차량운행일지 리뉴얼>
    // Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
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
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
    
    <script language="javascript">
        function checkDisable(form)
        {
            form.tollgate.disabled = form.cb2.checked;
            form.tollgate2.disabled = form.cb3.checked;
        }
        // 이미지 확대 스크립트 (하나의 함수로 통합)
        function bigimg(filepath){
            if (filepath) {
                window.open("../files/" + filepath, "bigimg", "width=800,height=800,scrollbars=yes"); 
            }
        }
    </script>
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
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">개인차 일지</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 카드1: 공지 -->
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-4">
                                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">
                                    <h6 class="m-0 font-weight-bold text-primary">공지</h6>
                                </a>
                                <div class="collapse" id="collapseCardExample1">
                                    <div class="card-body">
                                        <p>
                                            - 주행거리나 잔액을 잘못 입력했을 시 올바른 데이터를 한번 더 입력하시면 수정이 가능합니다.<br>   
                                            - 도착을 입력해야 회사 하이패스카드가 반납됩니다.<br>
                                            - 카카오맵, T맵, 네이버지도 등과 같은 앱을 캡처하여 업로드 바랍니다.<br> 
                                            - 사진 파일만 업로드 가능합니다.<br>
                                            - 기름티켓이 발급되면 현황에서 데이터가 사라집니다.<br>
                                            - 계산식 [정산=roundup((주행거리/10)+(톨비/자차유종가격))]<br>
                                            - 장안주유소 및 선암가스충전소 실시간 유가를 출력합니다.(한국석유공사 제공)<br>
                                            - ★장안주유소 주소: 부산광역시 기장군 장안읍 기장대로 1673<br>
                                            - ★선암가스충전소 주소: 부산광역시 기장군 장안읍 기장대로 1451                                            
                                        </p>                                            
                                    </div>
                                </div>
                            </div>
                        </div>            

                        <!-- 카드2: 출발 -->
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-4">
                                <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                                    <h6 class="m-0 font-weight-bold text-primary">출발</h6>
                                </a>
                                <form method="POST" autocomplete="off" action="">
                                    <div class="collapse show" id="collapseCardExample2">                                    
                                        <div class="card-body">
                                            <div class="row"> 
                                                <div class="col-md-3"><div class="form-group"><label>차량번호</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-car"></i></span></div><input type="number" maxlength="4" class="form-control" name="my_car_num1" required></div></div></div>
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

                        <!-- 카드3: 도착 -->
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-4">
                                <a href="#collapseCardExample3" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample3">
                                    <h6 class="m-0 font-weight-bold text-primary">도착</h6>
                                </a>
                                <form method="POST" autocomplete="off" action="">
                                    <div class="collapse show" id="collapseCardExample3">                                    
                                        <div class="card-body">
                                            <div class="row">    
                                                <div class="col-md-3"><div class="form-group"><label>차량번호</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-car"></i></span></div><input type="number" maxlength="4" class="form-control" name="my_car_num2" required></div></div></div>
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
                        
                        <!-- 카드4: 증빙 -->
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-4">
                                <a href="#collapseCardExample4" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample4">
                                    <h6 class="m-0 font-weight-bold text-primary">증빙</h6>
                                </a>
                                <form method="POST" autocomplete="off" action="" enctype="multipart/form-data"> 
                                    <div class="collapse show" id="collapseCardExample4">                                    
                                        <div class="card-body">
                                            <div class="row">    
                                                <div class="col-md-4"><div class="form-group"><label>차량번호</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-car"></i></span></div><input type="number" maxlength="4" class="form-control" name="my_car_num3" required></div></div></div>
                                                <div class="col-md-4"><div class="form-group"><label>업로드 파일종류</label><select name="img_type" class="form-control select2" style="width: 100%;"><option value="" selected="selected">선택</option><option value="Km">주행거리</option><option value="TollGate">톨게이트비</option></select></div></div>
                                                <div class="col-md-4"><div class="form-group"><label>파일선택</label><div class="custom-file"><input type="file" class="custom-file-input" id="file" name="file" required><label class="custom-file-label" for="file">파일선택</label></div></div></div>
                                            </div> 
                                        </div> 
                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt3">업로드</button></div>
                                    </div>
                                </form>             
                            </div>
                        </div> 
                        
                        <!-- 카드6: 관리자 -->
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-4">
                                <a href="#collapseCardExample6" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample6">
                                    <h6 class="m-0 font-weight-bold text-primary">관리자</h6>
                                </a>
                                <form method="POST" autocomplete="off" action=""> 
                                    <div class="collapse" id="collapseCardExample6">                                    
                                        <div class="card-body">
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

                        <!-- 보드 -->
                        <div class="col-xl-3 col-md-6 mb-4"><div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">결재 및 정산 대기</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $num_result; ?></div></div><div class="col-auto"><i class="fas fa-tasks fa-2x text-gray-300"></i></div></div></div></div></div>
                        <div class="col-xl-3 col-md-6 mb-4"><div class="card border-left-success shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-success text-uppercase mb-1">휘발유</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($row11->OIL_PRICE ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></div></div><div class="col-auto"><i class="fas fa-oil-can fa-2x text-gray-300"></i></div></div></div></div></div>
                        <div class="col-xl-3 col-md-6 mb-4"><div class="card border-left-info shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-info text-uppercase mb-1">경유</div><div class="row no-gutters align-items-center"><div class="col-auto"><div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo htmlspecialchars($row22->OIL_PRICE ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></div></div></div></div><div class="col-auto"><i class="fas fa-oil-can fa-2x text-gray-300"></i></div></div></div></div></div>
                        <div class="col-xl-3 col-md-6 mb-4"><div class="card border-left-warning shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-warning text-uppercase mb-1">LPG</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($row33->OIL_PRICE ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></div></div><div class="col-auto"><i class="fas fa-oil-can fa-2x text-gray-300"></i></div></div></div></div></div>
                        
                        <!-- 카드5: 현황 -->
                        <div class="col-lg-12"> 
                            <div class="card shadow mb-4">
                                <a href="#collapseCardExample5" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample5">
                                    <h6 class="m-0 font-weight-bold text-primary">현황</h6>
                                </a>
                                <div class="collapse show" id="collapseCardExample5">
                                    <div class="card-body table-responsive p-2">
                                        <table class="table table-bordered table-hover text-nowrap" id="dataTable">
                                            <thead>
                                                <tr><th>이름</th><th>차번</th><th>유종</th><th>출발지</th><th>경유/목적지</th><th>주행거리</th><th>톨비</th><th>주행거리사진</th><th>톨비사진</th><th>기록일</th><th>정산(L)</th></tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    function display_image_cell($connect, $car_num, $binding_num, $img_type) {
                                                        $img_stmt = $connect->prepare("SELECT FILE_NM FROM files WHERE CAR_NUM = ? AND BINDING_NUM = ? AND IMG_TYPE = ? AND VIEW_YN = 'Y' ORDER BY NO DESC LIMIT 1");
                                                        $img_stmt->bind_param("sis", $car_num, $binding_num, $img_type);
                                                        $img_stmt->execute();
                                                        $img_res = $img_stmt->get_result();
                                                        if ($img_row = $img_res->fetch_assoc()) {
                                                            $file_path = '../files/' . htmlspecialchars($img_row['FILE_NM'], ENT_QUOTES, 'UTF-8');
                                                            $onclick_js = "bigimg('" . htmlspecialchars($img_row['FILE_NM'], ENT_QUOTES, 'UTF-8') . "')";
                                                            echo "<td><img src='{$file_path}' style='max-width: 100px; height: auto; cursor: pointer;' onclick=\"{$onclick_js}\"></td>";
                                                        } else {
                                                            echo "<td>없음</td>";
                                                        }
                                                    }

                                                    if ($result1) {
                                                        while ($user_car_row = $result1->fetch_assoc()) {
                                                            echo "<tr>";

                                                            $user_stmt = $connect->prepare("SELECT USER_NM FROM user_info WHERE CAR_NUM = ?");
                                                            $user_stmt->bind_param("s", $user_car_row['CAR_NUM']);
                                                            $user_stmt->execute();
                                                            $user_res = $user_stmt->get_result();
                                                            $user_row = $user_res->fetch_assoc();
                                                            echo "<td>" . htmlspecialchars($user_row['USER_NM'] ?? '', ENT_QUOTES, 'UTF-8') . "</td>";

                                                            echo "<td>" . htmlspecialchars($user_car_row['CAR_NUM'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                            echo "<td>" . htmlspecialchars($user_car_row['CAR_OIL'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                            echo "<td>" . htmlspecialchars($user_car_row['DEPARTURE'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                            echo "<td>" . htmlspecialchars($user_car_row['DESTINATION'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                            echo "<td>" . htmlspecialchars($user_car_row['KM'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                            echo "<td>" . htmlspecialchars($user_car_row['TOLL_GATE'], ENT_QUOTES, 'UTF-8') . "</td>";

                                                            display_image_cell($connect, $user_car_row['CAR_NUM'], $user_car_row['NO'], 'Km');
                                                            display_image_cell($connect, $user_car_row['CAR_NUM'], $user_car_row['NO'], 'TollGate');

                                                            echo "<td>" . htmlspecialchars($user_car_row['SEARCH_DATE'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                            echo "<td>" . htmlspecialchars($user_car_row['GIVE_OIL'], ENT_QUOTES, 'UTF-8') . "</td>";

                                                            echo "</tr>";
                                                        }
                                                    }
                                                ?>    
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

<?php 
    if (isset($connect) && $connect instanceof mysqli) {
        mysqli_close($connect);
    }
?>