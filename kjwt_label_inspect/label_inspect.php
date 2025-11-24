<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.12.20>
	// Description:	<라벨중복검사기>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'label_inspect_status.php';
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>      
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">라벨검사기(Kiểm tra tem)</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지(Thông báo)</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab2, ENT_QUOTES, 'UTF-8');?>" id="tab-two" data-toggle="pill" href="#tab2">검사(Kiểm tra)</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab3, ENT_QUOTES, 'UTF-8');?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">검사내역(Nôi dung kiểm tra)</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 시트히터 완제품 라벨 중복 확인<BR><BR>

                                            [작업순서] (quy trình)<BR>
                                            1. 검사탭 입력창에 시트히터 라벨 바코드 스캔<BR>
                                             > Quét mã vạch nhãn sản phẩm trong cửa sổ đầu vào<BR>
                                            2. 스캔수량이 목표 수량(100)에 도달하면 박스 라벨이 자동 발행<BR>
                                             > Nhãn hộp được tự động in khi số lượng quét đạt đến số lượng đích (100)<BR><BR>

                                            [기능] (Chức năng)<BR>
                                            - 중복 발생 시 경고음 소리와 함께 팝업창이 뜨며 팝업창에 0를 입력해야 검사 가능<BR>
                                             > nếu bạn lặp lại quét số sản phẩm, hãy thực hiện âm thanh cảnh báo và cửa sổ bật lên. Sau đó, Bạn có thể tiếp tục kiểm tra khi nhập số 0.<BR>
                                            - 처음 스캔한 품번과 다른 제품 스캔 시 경고음 소리와 함께 팝업창이 뜨며 팝업창에 0를 입력해야 검사 가능<BR>
                                             > nếu nó là quét số sản phẩm khác nhau, hãy thực hiện âm thanh cảnh báo và cửa sổ bật lên. Bạn có thể tiếp tục kiểm tra khi nhập số 0.<BR>
                                            - 중간 출력 버튼 클릭 시 현재 스캔 수량이 입력된 라벨 발행<BR><BR>
                                        
                                            [히스토리]<BR>
                                            23.4.19)<BR>
                                            - 부품식별표 우측하단에 검사완료라벨을 붙이는데 완성품창고 입고 및 출하 시 포장라벨을 스캔하지 않고 검사완료라벨을 스캔하는 경우가 발생함<BR>
                                             > 검사완료라벨을 부품식별표 뒤에 붙이는것으로 합의함<BR>
                                             23.11.8)<BR>
                                            - 23년 11월 3주차 쯤 해당 공정이 한국에서 베트남으로 이관되고 응용하여 패킹시스템으로 활용될 예정 (정연동BJ 진행)<BR>
                                            24.1.30)<BR>
                                            - ERP 공장품목등록의 LOTSIZE를 목표수량에 연동함 (정연동BJ)<BR>
                                            25.2.3)<BR>
                                            - 스캔수량이 없을때 중간출력버튼을 눌렀을 경우 팝업창 발생<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 우무용<BR>
                                            - 사용자: 검수반<BR>
                                            - 의견: 결과적으로 제품 라벨을 출력하는 아이모션 프로그램에 문제가 있는데 왜 아이모션에 요청을 하지 않는가에 대한 질문을 품질팀에 하니 업체가 해결할 수 없다는 애매한 답변을 받았음, 
                                            또한 프로그램 개발자가 퇴사함, 프로그램 개발자가 퇴사했다고 문제점을 해결하지 못하는 것을 보면 업체가 영세하여 능력이 부족하고 프로그램을 갈아엎기에는 비용 등의 문제 등으로 인해
                                            본질적인 문제를 해결하지 못하여 불필요한 공정을 추가하여 제품 생산 코스트가 증가됐다고 볼 수 있음<BR><BR>

                                            [제작일]<BR>
                                            - 21.12.20
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text, ENT_QUOTES, 'UTF-8');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                           <!-- 카운팅 및 판정!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                           <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">출력(In)</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="label_inspect.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample23">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">  
                                                                    <!-- 보드 시작 -->
                                                                    <?php 
                                                                        $condition = "-";
                                                                        if ($Count_ScanLabel > 0 && $Data_ScanLabel2) {
                                                                            $item_name = NM_ITEM(Hyphen($Data_ScanLabel2['CD_ITEM']));
                                                                            if ($item_name == '') {
                                                                                $condition = "관리자에게 연락하세요! (Hãy liên hệ với quản trị viên của bạn!)";
                                                                                $safe_cd_item = htmlspecialchars($Data_ScanLabel2['CD_ITEM'], ENT_QUOTES, 'UTF-8');
                                                                                echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = '6218132365'; while(true) { var getpass = prompt('ERP에 등록되지 않은 품번입니다!  [{$safe_cd_item}]\n(Đây là số mặt hàng chưa đăng ký)\n본사 사업자등록번호 입력 시 제일 마지막 데이터가 삭제되고 검사를 계속할 수 있습니다!\n(Nếu bạn nhập số quản trị viên của mình, dữ liệu cuối cùng sẽ bị xóa và bạn có thể tiếp tục kiểm tra!)'); if(pass == getpass) { location.href='label_inspect.php?error=on'; break; } } };audio.play();</script>";
                                                                            } else {
                                                                                $condition = $item_name;
                                                                            }
                                                                        }
                                                                        
                                                                        BOARD(3, "warning", "품명(Tên hàng)", htmlspecialchars($condition, ENT_QUOTES, 'UTF-8'), "fas fa-tv");
                                                                        BOARD(3, "success", "스캔수량(Số lượng scan)", (int)$Count_ScanLabel, "fas fa-qrcode");
                                                                        BOARD(3, "primary", "목표수량(Số lượng mục tiêu)", ROUND($LOT,0), "fas fa-flag-checkered");
                                                                        BOARD(3, "info", "라벨발행수량(số lượng bản in)", (int)$Count_PrintLabel, "fas fa-print");    
                                                                    ?>
                                                                    <!-- 보드 끝 -->   
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt23">중간출력(Bắt buộc in)</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 
                                        
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력(Đầu vào)</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="label_inspect.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 라벨스캔 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>라벨스캔(Scan tem)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-qrcode"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="item2" pattern="[a-zA-Z0-9^_-.[)>]+" autofocus>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 라벨스캔 -->                                        
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력(Đầu vào)</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div>                                    
                                        </div>  

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab3_text, ENT_QUOTES, 'UTF-8');?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색(sự tìm kiếm)</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="label_inspect.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 검색범위 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위(tầm bắn)</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo htmlspecialchars($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d'), ENT_QUOTES, 'UTF-8'); ?>" name="dt3">
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
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">검색(sự tìm kiếm)</button>
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
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과(kết quả)</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">                                                            
                                                            <div class="row">
                                                                <!-- 보드 시작 -->
                                                                <?php 
                                                                    BOARD(6, "primary", "작업 품목수량", (int)$Count_ItemCount, "fas fa-boxes");
                                                                    BOARD(6, "primary", "작업 개별수량", (int)$Count_PcsCount, "fas fa-box");
                                                                ?>
                                                                <!-- 보드 끝 -->
                                                            </div>                                                            

                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>품번(Mã hàng)</th>
                                                                        <th>품명(Tên hàng)</th>
                                                                        <th>추적코드(Số theo dõi)</th>
                                                                        <th>박스로트날짜</th>
                                                                        <th>박스로트번호(Số theo dõi hộp)</th>
                                                                        <th>스캔일시(Ngày và giờ ghi âm)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($InspectInquire_Rows as $row):
                                                                    ?>
                                                                    <tr> 
                                                                        <td><?php echo htmlspecialchars($row['CD_ITEM'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars(NM_ITEM(Hyphen($row['CD_ITEM'])), ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars($row['TRACE_CODE'], ENT_QUOTES, 'UTF-8'); ?></td>   
                                                                        <td><?php echo htmlspecialchars($row['SORTING_DATE']->format("Y-m-d"), ENT_QUOTES, 'UTF-8'); ?></td> 
                                                                        <td><?php echo htmlspecialchars($row['BOX_LOT_NUM'], ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                        <td><?php echo htmlspecialchars($row['RECORD_DATE']->format("Y-m-d H:i:s"), ENT_QUOTES, 'UTF-8'); ?></td>  
                                                                    </tr>
                                                                    <?php endforeach;
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

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?> 
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if(isset($connect4)) { mysqli_close($connect4); } 	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>
