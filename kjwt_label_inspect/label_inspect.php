<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.12.20>
	// Description:	<라벨중복검사기 - 모바일 최적화 및 기능 복구>
    // Last Modified: <25.10.13>
	// =============================================
    
    // 로직 파일 포함
    include 'label_inspect_status.php';

    // XSS 방지 및 데이터 전처리
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // [Tab 3] 검사내역 검색 필터링 로직 추가
    $search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : '';
    
    // 원본 데이터($InspectInquire_Rows)를 필터링하여 새로운 배열($filtered_rows)에 담습니다.
    $filtered_rows = [];
    if (isset($InspectInquire_Rows) && is_array($InspectInquire_Rows)) {
        foreach ($InspectInquire_Rows as $row) {
            if ($search_keyword) {
                // 품번, 품명, 추적코드, 박스로트번호 등으로 검색
                $item_nm = NM_ITEM(Hyphen($row['CD_ITEM']));
                if (strpos($row['CD_ITEM'], $search_keyword) !== false || 
                    strpos($item_nm, $search_keyword) !== false ||
                    strpos($row['TRACE_CODE'], $search_keyword) !== false ||
                    strpos($row['BOX_LOT_NUM'], $search_keyword) !== false) {
                    $filtered_rows[] = $row;
                }
            } else {
                $filtered_rows[] = $row;
            }
        }
    } else {
        // 데이터가 없거나 배열이 아닌 경우 처리
        $InspectInquire_Rows = []; 
    }
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>      

    <style>
        /* 모바일 검색창 스타일 */
        .mobile-search-input {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 0;
            background-color: #ffffff !important;
            color: #495057;
            border: 1px solid #d1d3e2;
        }
        .mobile-search-input::placeholder {
            color: #858796;
        }
        .mobile-search-btn {
            width: 60px;
            border-radius: 0;
        }

        /* 모바일 화면 전용 스타일 */
        @media screen and (max-width: 768px) {
            
            /* DataTables 컨트롤 숨김 */
            .dt-buttons, 
            .dataTables_filter, 
            .dataTables_length,
            .dataTables_paginate .page-item {
                display: none !important;
            }
            /* 페이징 버튼 일부만 표시 */
            .dataTables_paginate .page-item.previous,
            .dataTables_paginate .page-item.next,
            .dataTables_paginate .page-item.active {
                display: block !important;
            }
            .dataTables_paginate ul.pagination {
                justify-content: center !important;
                margin-top: 10px;
            }

            /* 테이블 카드 뷰 변환 */
            .mobile-responsive-table thead {
                display: none;
            }
            .mobile-responsive-table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #fff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .mobile-responsive-table td {
                display: block;
                text-align: right;
                font-size: 0.9rem;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                padding-top: 10px;
                padding-bottom: 10px;
            }
            .mobile-responsive-table td:last-child {
                border-bottom: 0;
            }
            .mobile-responsive-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                font-weight: 700;
                text-align: left;
                color: #4e73df;
            }

            /* 데이터 없음 행 스타일 (중앙 정렬) */
            .mobile-responsive-table td.no-data {
                text-align: center !important;
                padding-left: 0.75rem !important;
                color: #858796;
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
            .mobile-responsive-table td.no-data::before {
                content: none !important;
            }
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">라벨검사기(Kiểm tra tem)</h1>
                    </div>               

                    <div class="row"> 

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지(Thông báo)</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab2);?>" id="tab-two" data-toggle="pill" href="#tab2">검사(Kiểm tra)</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo h($tab3);?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">검사내역(Nôi dung kiểm tra)</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body p-2"> <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
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

                                        <div class="tab-pane fade <?php echo h($tab2_text);?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                           <div class="card shadow mb-2">
                                                <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                    <h6 class="m-0 font-weight-bold text-primary">출력(In)</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="label_inspect.php"> 
                                                    <div class="collapse show" id="collapseCardExample23">                                    
                                                        <div class="card-body p-2">
                                                            <div class="row">  
                                                                <?php 
                                                                    $condition = "-";
                                                                    if ($Count_ScanLabel > 0 && $Data_ScanLabel2) {
                                                                        $item_name = NM_ITEM(Hyphen($Data_ScanLabel2['CD_ITEM']));
                                                                        if ($item_name == '') {
                                                                            $condition = "관리자에게 연락하세요! (Hãy liên hệ với quản trị viên của bạn!)";
                                                                            $safe_cd_item = h($Data_ScanLabel2['CD_ITEM']);
                                                                            echo "<script>var audio = new Audio('ng.wav'); audio.onended = function() { var pass = '6218132365'; while(true) { var getpass = prompt('ERP에 등록되지 않은 품번입니다!  [{$safe_cd_item}]\n(Đây là số mặt hàng chưa đăng ký)\n본사 사업자등록번호 입력 시 제일 마지막 데이터가 삭제되고 검사를 계속할 수 있습니다!\n(Nếu bạn nhập số quản trị viên của mình, dữ liệu cuối cùng sẽ bị xóa và bạn có thể tiếp tục kiểm tra!)'); if(pass == getpass) { location.href='label_inspect.php?error=on'; break; } } };audio.play();</script>";
                                                                        } else {
                                                                            $condition = $item_name;
                                                                        }
                                                                    }
                                                                    
                                                                    // 보드 배치 (모바일 고려하여 col-12 또는 col-6으로 조정 가능하나, BOARD 함수 내부 로직을 따름)
                                                                    BOARD(3, "warning", "품명(Tên hàng)", h($condition), "fas fa-tv");
                                                                    BOARD(3, "success", "스캔수량(Số lượng scan)", (int)$Count_ScanLabel, "fas fa-qrcode");
                                                                    BOARD(3, "primary", "목표수량(Số lượng mục tiêu)", ROUND($LOT,0), "fas fa-flag-checkered");
                                                                    BOARD(3, "info", "라벨발행수량(số lượng bản in)", (int)$Count_PrintLabel, "fas fa-print");    
                                                                ?>
                                                                </div>      
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt23">중간출력(Bắt buộc in)</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div>
                                        
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h6 class="m-0 font-weight-bold text-primary">입력(Đầu vào)</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="label_inspect.php"> 
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body p-3"> <div class="form-group mb-0">
                                                                <label>라벨스캔(Scan tem)</label>
                                                                <div class="input-group">                                                
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="item2" pattern="[a-zA-Z0-9^_-.[)>]+" autofocus>
                                                                </div>
                                                            </div>       
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt21">입력(Đầu vào)</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div>                                   
                                        </div>  

                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h6 class="m-0 font-weight-bold text-primary">검색(sự tìm kiếm)</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="label_inspect.php"> 
                                                    <div class="collapse show" id="collapseCardExample31">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>검색범위(tầm bắn)</label>
                                                                <div class="input-group">                                                
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt3">
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt31">검색(sự tìm kiếm)</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>  

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                    <h6 class="m-0 font-weight-bold text-primary">결과(kết quả)</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample32">
                                                    <div class="card-body table-responsive p-2">                                                            
                                                        <div class="row">
                                                            <?php 
                                                                BOARD(6, "primary", "작업 품목수량", (int)$Count_ItemCount, "fas fa-boxes");
                                                                BOARD(6, "primary", "작업 개별수량", (int)$Count_PcsCount, "fas fa-box");
                                                            ?>
                                                            </div>                                                            

                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <form method="GET" action="label_inspect.php">
                                                                <input type="hidden" name="tab" value="history">
                                                                <div class="input-group shadow-sm">
                                                                    <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="Tìm kiếm (품번, 로트)..." value="<?= h($search_keyword) ?>">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary mobile-search-btn" type="submit">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <table class="table table-bordered table-striped mobile-responsive-table" id="table3">
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
                                                                <?php foreach ($filtered_rows as $row): ?>
                                                                <tr> 
                                                                    <td data-label="품번(Mã hàng)"><?php echo h($row['CD_ITEM']); ?></td>  
                                                                    <td data-label="품명(Tên hàng)"><?php echo h(NM_ITEM(Hyphen($row['CD_ITEM']))); ?></td>  
                                                                    <td data-label="추적코드(Số theo dõi)"><?php echo h($row['TRACE_CODE']); ?></td>   
                                                                    <td data-label="박스로트날짜"><?php echo h(is_object($row['SORTING_DATE']) ? $row['SORTING_DATE']->format("Y-m-d") : $row['SORTING_DATE']); ?></td> 
                                                                    <td data-label="박스로트번호"><?php echo h($row['BOX_LOT_NUM']); ?></td>  
                                                                    <td data-label="스캔일시"><?php echo h(is_object($row['RECORD_DATE']) ? $row['RECORD_DATE']->format("Y-m-d H:i:s") : $row['RECORD_DATE']); ?></td>  
                                                                </tr>
                                                                <?php endforeach; ?>
                                                                <?php if(empty($filtered_rows)): ?>
                                                                    <tr>
                                                                        <td colspan="6" class="text-center no-data">Không có dữ liệu (No Data)</td>
                                                                    </tr>
                                                                <?php endif; ?>
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
                    
                    </div> </div> </div> </div> </div> <?php include '../plugin_lv1.php'; ?> 

    <script>
    $(document).ready(function() {
        // 검색 실행 시 탭 유지
        var searchParam = new URLSearchParams(window.location.search).get('search_keyword');
        var tabParam = new URLSearchParams(window.location.search).get('tab');
        
        if (searchParam || tabParam === 'history') {
            $('#custom-tabs-one-1th-tab').tab('show');
        }
    });
    </script>
</body>
</html>

<?php 
    // DB 자원 해제
    if(isset($connect4)) { mysqli_close($connect4); } 	
    if(isset($connect)) { sqlsrv_close($connect); }
?>