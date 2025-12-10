<?php 
  // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.12.06>
	// Description:	<공정진행 완료 - 불량 입력 팝업 복구 및 모바일 최적화>	
    // Last Modified: <25.10.13>
	// =============================================
    include 'field_complete_status.php';

    // XSS 방지 함수
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>    

    <style>
        .chk-scale {            
            /* 확대 시 여백 조절이 필요할 수 있음 */
            margin: 10px;

            /* 기본 스타일 제거 */
            appearance: none; 
            
            /* 크기 및 테두리 설정 */
            width: 27px;
            height: 27px;
            border: 2px solid #ccc;
            border-radius: 5px; /* 둥근 모서리 */
            
            /* 체크되었을 때 스타일 */
            &:checked {
                background-color: #007bff;
                border-color: #007bff;
                
                /* 체크 표시 (이미지나 SVG 사용 가능) */
                background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
                background-size: 100% 100%;
                background-position: center;
                background-repeat: no-repeat;
            }
        }
        
        /* 모바일 검색창 스타일 */
        .mobile-search-input {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 0;
            background-color: #ffffff !important;
            color: #495057;
            border: 1px solid #d1d3e2;
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
                /* 텍스트 줄바꿈 */
                white-space: normal !important; 
                word-break: break-word;
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
            
            /* 데이터 없음 행 스타일 */
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

    <script>
    function filterTable(inputId, tableId) {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById(inputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) { // Skip header
            tr[i].style.display = "none";
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    }
                }
            }
        }
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">검사완료</h1>
                    </div>               

                    <div class="row"> 

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item"><a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a></li>
                                        <li class="nav-item"><a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">한국</a></li>  
                                        <li class="nav-item"><a class="nav-link <?php echo $tab6;?>" id="custom-tabs-one-4th-tab" data-toggle="pill" href="#custom-tabs-one-4th">베트남</a></li> 
                                        <li class="nav-item"><a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">완료내역</a></li>  
                                        <li class="nav-item"><a class="nav-link <?php echo $tab4;?>" id="custom-tabs-one-2th-tab" data-toggle="pill" href="#custom-tabs-one-2th">불량내역</a></li>
                                        <li class="nav-item"><a class="nav-link <?php echo $tab5;?>" id="custom-tabs-one-3th-tab" data-toggle="pill" href="#custom-tabs-one-3th">삭제내역</a></li>                                        
                                    </ul>
                                </div>
                                <div class="card-body p-2"> <div class="tab-content" id="custom-tabs-one-tabContent">
                                        
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 검사실적 전산화<BR><BR>
                                            [제작일]<BR>
                                            - 21.12.06
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">입력</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php"> 
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>라벨스캔</label>
                                                                <div class="input-group"><img src="../img/flag_k.webp" style="height: 38px;"><input type="text" class="form-control" id="item2" name="item2" pattern="[a-zA-Z0-9^_()_-]+" autofocus required></div>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button></div>
                                                    </div>
                                                </form>     
                                            </div>
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample21b1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">수기입력</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php">
                                                    <div class="collapse" id="collapseCardExample21b1">
                                                        <div class="card-body p-3">
                                                            <div class="row">
                                                                <div class="col-md-4 col-12 mb-2"><div class="form-group mb-0"><label>품번</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-signature"></i></span></div><input type="text" class="form-control" name="item21b1" required></div></div></div>
                                                                <div class="col-md-4 col-6 mb-2"><div class="form-group mb-0"><label>수량</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box-open"></i></span></div><input type="number" class="form-control" name="size21b1" min="1" required></div></div></div>
                                                                <div class="col-md-4 col-6 mb-2"><div class="form-group mb-0"><label>비고(수정가능)</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-sticky-note"></i></span></div><input type="text" class="form-control" name="note21b1" value="통풍모듈(현대)"></div></div></div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt21b1">입력</button></div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample21b2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">삭제</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php">
                                                    <div class="collapse" id="collapseCardExample21b2">
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-2"><label>라벨(작업지시번호)</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-qrcode"></i></span></div><input type="text" class="form-control" name="item2b" pattern="[a-zA-Z0-9^_()_-]+"></div></div>
                                                            <div class="form-group mb-0"><label>품번</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-signature"></i></span></div><input type="text" class="form-control" name="item2b2"></div></div>
                                                        </div>
                                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt21b">입력</button></div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">스캔내역</h6></a>
                                                <?php if($form2!='on') { ?><form method="POST" autocomplete="off" action="field_complete.php"><?php } ?>
                                                <div class="collapse show" id="collapseCardExample22">
                                                    <div class="card-body table-responsive p-2">
                                                        <div class="row">
                                                            <?php BOARD(6, "primary", "스캔수량", $Count_KoreaScan, "fas fa-qrcode"); BOARD(6, "primary", "실적(PCS)", $Data_KoreaTotal['QT']-$Data_KoreaTotal['RE'], "fas fa-box"); ?>
                                                        </div>
                                                        <?php ModifyData2("field_complete.php?modi=Y", "bt22", "FieldCompleteKorea"); ?>
                                                        
                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <div class="input-group shadow-sm"><input type="text" id="mobileSearchKorea" class="form-control mobile-search-input" onkeyup="filterTable('mobileSearchKorea', 'table_nosort')" placeholder="품번/품명 검색..."><div class="input-group-append"><span class="input-group-text btn-primary"><i class="fas fa-search text-white"></i></span></div></div>
                                                        </div>

                                                        <div id="table" class="table-editable">
                                                            <table class="table table-bordered table-striped mobile-responsive-table" id="table_nosort">
                                                                <thead><tr><th>품번</th><th>품명</th><th>시작일</th><th>종료일</th><th>로트번호</th><th>수량</th><th>불량</th><th>불량내용</th><th>오차</th><th>실적</th><th>작지번호</th><th>마감</th><th>구분</th><th>비고</th></tr></thead>
                                                                <tbody>
                                                                    <?php for($k=1; $k<=$Count_KoreaScan; $k++) { 
                                                                        $Data_KoreaScan = sqlsrv_fetch_array($Result_KoreaScan); 
                                                                        if(!$Data_KoreaScan) break;
                                                                        $fan1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "모듈");
                                                                        // (중간 생략: fan2~warmer1 로직 동일)
                                                                        $fan2=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "BLOW");
                                                                        $fan3=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "BLOWER");
                                                                        $bed1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "BED");
                                                                        $wheel1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "S/WHEEL");
                                                                        $wheel2=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "S/W");
                                                                        $unit1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "UNIT");
                                                                        $warmer1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "WARMER");

                                                                        if(substr(strtoupper($Data_KoreaScan['BARCODE']),0, 3)=='WMO') {
                                                                            $Query_CheckDT = "SELECT * from NEOE.NEOE.PR_WO WHERE NO_WO='$Data_KoreaScan[BARCODE]'";              
                                                                            $Result_CheckDT = sqlsrv_query($connect21, $Query_CheckDT, $params21, $options21);
                                                                            $Data_CheckDT = sqlsrv_fetch_array($Result_CheckDT);
                                                                        }
                                                                        $Query_kChkFinishedIn = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE='$Hyphen_today' AND OUT_OF='한국' AND CD_ITEM='$Data_KoreaScan[CD_ITEM]' GROUP BY CD_ITEM";              
                                                                        $Result_kChkFinishedIn = sqlsrv_query($connect21, $Query_kChkFinishedIn, $params21, $options21);		
                                                                        $Data_kChkFinishedIn = sqlsrv_fetch_array($Result_kChkFinishedIn);
                                                                        $hl = ""; 
                                                                        if(!($fan1>0 or $fan2>0 or $fan3>0 or $bed1>0 or $wheel1>0 or $wheel2>0 or $unit1>0 or $warmer1>0)) { 
                                                                            if(($Data_KoreaScan['QT_GOODS']-$Data_KoreaScan['REJECT_GOODS'])>$Data_kChkFinishedIn['QT_GOODS']) $hl = "style='background-color: #99ccff; font-weight: bold;'"; 
                                                                        }
                                                                    ?>
                                                                    <tr>
                                                                        <td data-label="품번" <?php echo $hl; ?>><?php if($modi=='Y') { echo $Data_KoreaScan['CD_ITEM']; echo "<input name='N_CD_ITEM$k' value='{$Data_KoreaScan['CD_ITEM']}' type='hidden'>"; } else { echo $Data_KoreaScan['CD_ITEM']; } ?></td>
                                                                        <td data-label="품명"><?php echo NM_ITEM($Data_KoreaScan['CD_ITEM']); ?></td>
                                                                        <td data-label="시작일"><?php echo $Data_CheckDT['DT_REL'] ?? ''; ?></td>
                                                                        <td data-label="종료일"><?php if($modi=='Y') { echo $Data_KoreaScan['LOT_DATE']; echo "<input name='N_LOT_DATE$k' value='{$Data_KoreaScan['LOT_DATE']}' type='hidden'>"; } else { echo $Data_KoreaScan['LOT_DATE']; } ?></td>
                                                                        <td data-label="로트번호"><?php if($modi=='Y') { echo $Data_KoreaScan['LOT_NUM']; echo "<input name='N_LOT_NUM$k' value='{$Data_KoreaScan['LOT_NUM']}' type='hidden'>"; } else { echo $Data_KoreaScan['LOT_NUM']; } ?></td>
                                                                        <td data-label="수량"><?php echo $Data_KoreaScan['QT_GOODS']; ?></td>
                                                                        <td data-label="불량"><?php echo $Data_KoreaScan['REJECT_GOODS']; ?></td>
                                                                        <td data-label="불량내용"><a href="field_complete.php?MODAL=on&kmodal_Delivery_ItemCode=<?php echo $Data_KoreaScan['CD_ITEM']; ?>&kmodal_Delivery_LotDate=<?php echo $Data_KoreaScan['LOT_DATE']; ?>&kmodal_Delivery_LotNum=<?php echo $Data_KoreaScan['LOT_NUM']; ?>&kmodal_Delivery_ERP=<?php echo $Data_KoreaScan['BARCODE']; ?>" class="btn btn-info btn-sm">입력</a></td>
                                                                        <td data-label="오차"><?php if($modi=='Y') { ?><div class="input-group"><button type="button" class="btn btn-info btn-sm" onclick="cal('m', this)">-</button><input type="text" class="form-control form-control-sm text-center" name="pop_out<?php echo $k; ?>" value="<?php echo $Data_KoreaScan['ERROR_GOODS']?>"><button type="button" class="btn btn-info btn-sm" onclick="cal('p', this)">+</button></div><?php } else { echo $Data_KoreaScan['ERROR_GOODS']; } ?></td>
                                                                        <td data-label="실적"><?php echo $Data_KoreaScan['QT_GOODS']-$Data_KoreaScan['REJECT_GOODS']+$Data_KoreaScan['ERROR_GOODS']; ?></td>
                                                                        <td data-label="작지번호"><?php echo $Data_KoreaScan['BARCODE']; ?></td>
                                                                        <td data-label="마감"><?php echo $Data_KoreaScan['CLOSING_YN']; ?></td>
                                                                        <td data-label="구분"><?php if($modi=='Y') { ?><select name="AS_STATUS<?php echo $k; ?>" class="form-control form-control-sm"><option value="N" <?php echo ($Data_KoreaScan['AS_YN']=='N')?'selected':''; ?>>양산</option><option value="Y" <?php echo ($Data_KoreaScan['AS_YN']=='Y')?'selected':''; ?>>A/S</option></select><?php } else { echo ($Data_KoreaScan['AS_YN']=='N')?'양산':'A/S'; } ?></td>
                                                                        <td data-label="비고"><?php if($modi=='Y') { ?><input type="text" class="form-control form-control-sm" name="NOTE<?php echo $k; ?>" value="<?php echo $Data_KoreaScan['NOTE']; ?>"><?php } else { echo $Data_KoreaScan['NOTE']; } ?></td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <input type="hidden" name="until" value="<?php echo $k; ?>">
                                                    </div>
                                                </div>
                                                <?php if($form2!='on') { ?></form><?php } ?>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="custom-tabs-one-4th" role="tabpanel" aria-labelledby="custom-tabs-one-4th-tab">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseVnInput" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">입력</h6></a>
                                                <div class="collapse show" id="collapseVnInput">
                                                    <form method="POST" autocomplete="off" action="field_complete.php">
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>라벨스캔</label>
                                                                <div class="input-group"><img src="../img/flag_v.webp" style="height: 38px;"><input type="text" class="form-control" name="item6" pattern="[a-zA-Z0-9^[)>. _-/]+" required autofocus></div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt61">입력</button></div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="card shadow mb-4">
                                                <a href="#collapseVnManualInput" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">수기입력</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php"> 
                                                    <div class="collapse" id="collapseVnManualInput">                                    
                                                        <div class="card-body p-3">
                                                            <div class="row">                                                                        
                                                                <div class="col-md-4 col-12 mb-2">
                                                                    <div class="form-group mb-0">
                                                                        <label>품번</label>
                                                                        <div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-signature"></i></span></div><input type="text" class="form-control" name="item61b1" required></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-6 mb-2">
                                                                    <div class="form-group mb-0">
                                                                        <label>수량</label>
                                                                        <div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box-open"></i></span></div><input type="number" class="form-control" name="size61b1" min="1" required></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-6 mb-2">
                                                                    <div class="form-group mb-0">
                                                                        <label>비고(수정가능)</label>
                                                                        <div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-sticky-note"></i></span></div><input type="text" class="form-control" name="note61b1" value="베트남 A/S"></div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt61b1">입력</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div>
                                            <div class="card shadow mb-4">
                                                <a href="#collapseVnDelete" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">삭제</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php"> 
                                                    <div class="collapse" id="collapseVnDelete">                                    
                                                        <div class="card-body p-3">
                                                            <div class="row">                                                                        
                                                                <div class="col-md-12 mb-2">
                                                                    <div class="form-group mb-0">
                                                                        <label>라벨스캔 (금일 입력된 해당 품번 모두 삭제 [수기입력 포함])</label>
                                                                        <div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-qrcode"></i></span></div><input type="text" class="form-control" name="item6b" pattern="[a-zA-Z0-9^[)>. _-]+"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group mb-0">
                                                                        <label>품번 (금일 입력된 해당 품번 모두 삭제 [라벨스캔 포함])</label>
                                                                        <div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-signature"></i></span></div><input type="text" class="form-control" name="item6b2"></div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt61b">입력</button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div>

                                            <div class="card shadow mb-4">
                                                <a href="#collapseVnList" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">완료내역</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php">
                                                    <div class="collapse show" id="collapseVnList">
                                                        <div class="card-body table-responsive p-2">
                                                            <div class="row">
                                                                <?php BOARD(6, "primary", "작업품목수량", $Count_VietnamScan, "fas fa-boxes"); BOARD(6, "primary", "실적(PCS)", $Data_VietnamTotal['QT']-$Data_VietnamTotal['RE'], "fas fa-box"); ?>
                                                            </div>
                                                            <?php ModifyData2("field_complete.php?Vmodi=Y", "bt62", "FieldCompleteVietnam"); ?>
                                                            
                                                            <div class="d-block d-md-none mb-3 mt-2">
                                                                <div class="input-group shadow-sm"><input type="text" id="mobileSearchVietnam" class="form-control mobile-search-input" onkeyup="filterTable('mobileSearchVietnam', 'table_nosort2')" placeholder="품번/품명 검색..."><div class="input-group-append"><span class="input-group-text btn-primary"><i class="fas fa-search text-white"></i></span></div></div>
                                                            </div>

                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped mobile-responsive-table" id="table_nosort2">
                                                                    <thead><tr><th>품번</th><th>품명</th><th>완료수량</th><th>불량</th><th>불량내용</th><th>실적</th><th>검사 시 체크</th><th>구분</th><th>비고</th></tr></thead>
                                                                    <tbody>
                                                                        <?php for($v=1; $v<=$Count_VietnamScan; $v++) { 
                                                                            $Data_VietnamScan = sqlsrv_fetch_array($Result_VietnamScan);
                                                                            if(!$Data_VietnamScan) break;
                                                                            
                                                                            $Query_vChkFinishedIn = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE='$Hyphen_today' AND OUT_OF='BB' AND CD_ITEM='$Data_VietnamScan[CD_ITEM]' GROUP BY CD_ITEM";              
                                                                            $Result_vChkFinishedIn = sqlsrv_query($connect, $Query_vChkFinishedIn, $params, $options);		
                                                                            $Data_vChkFinishedIn = sqlsrv_fetch_array($Result_vChkFinishedIn); 

                                                                            $vwheel1=strpos(strtoupper(NM_ITEM($Data_VietnamScan['CD_ITEM'])), "S/WHEEL");
                                                                            $vwheel2=strpos(strtoupper(NM_ITEM($Data_VietnamScan['CD_ITEM'])), "S/W");
                                                                            $hl = "";
                                                                            if(!($vwheel1>0 or $vwheel2>0)) {
                                                                                if(($Data_VietnamScan['QT_GOODS']-$Data_VietnamScan['REJECT_GOODS'])>$Data_vChkFinishedIn['QT_GOODS']) $hl = "style='background-color: #99ccff; font-weight: bold;'";
                                                                            }
                                                                        ?>
                                                                        <tr>
                                                                            <td data-label="품번" <?php echo $hl; ?>><?php echo $Data_VietnamScan['CD_ITEM']; if($Vmodi=='Y') echo "<input type='hidden' name='V_CD_ITEM$v' value='{$Data_VietnamScan['CD_ITEM']}'>"; ?></td>
                                                                            <td data-label="품명"><?php echo NM_ITEM($Data_VietnamScan['CD_ITEM']); ?></td>
                                                                            <td data-label="완료수량">
                                                                                <?php if($Vmodi=='Y') { ?>
                                                                                    <div class="input-group"><button type="button" class="btn btn-info btn-sm" onclick="cal('m', this)">-</button><input type="text" class="form-control form-control-sm text-center" name="pop_out2<?php echo $v; ?>" value="<?php echo h($Data_VietnamScan['QT_GOODS']); ?>"><button type="button" class="btn btn-info btn-sm" onclick="cal('p', this)">+</button></div>
                                                                                <?php } else { echo h($Data_VietnamScan['QT_GOODS']); } ?>
                                                                            </td>
                                                                            <td data-label="불량"><?php echo h($Data_VietnamScan['REJECT_GOODS']); ?></td>
                                                                            <td data-label="불량내용"><a href="field_complete.php?VMODAL=on&vmodal_Delivery_ItemCode=<?php echo h($Data_VietnamScan['CD_ITEM']); ?>&vmodal_Delivery_LotDate=<?php echo h($Data_VietnamScan['LOT_DATE']); ?>" class="btn btn-info btn-sm">입력</a></td>
                                                                            <td data-label="실적"><?php echo $Data_VietnamScan['QT_GOODS']-$Data_VietnamScan['REJECT_GOODS']; ?></td>
                                                                            <td data-label="검사체크"><input type="checkbox" class="chk-scale" name="V_CB<?php echo $v; ?>" <?php echo ($Data_VietnamScan['INSPECT_YN']=='Y')?'checked':''; ?> <?php echo ($Vmodi!='Y')?'disabled':''; ?>></td>
                                                                            <td data-label="구분"><?php if($Vmodi=='Y') { ?><select name="AS_STATUS<?php echo $v; ?>" class="form-control form-control-sm"><option value="N" <?php echo ($Data_VietnamScan['AS_YN']=='N')?'selected':''; ?>>양산</option><option value="Y" <?php echo ($Data_VietnamScan['AS_YN']=='Y')?'selected':''; ?>>A/S</option></select><?php } else { echo ($Data_VietnamScan['AS_YN']=='N')?'양산':'A/S'; } ?></td>
                                                                            <td data-label="비고"><?php if($Vmodi=='Y') { ?><input type="text" class="form-control form-control-sm" name="VNOTE<?php echo $v; ?>" value="<?php echo h($Data_VietnamScan['NOTE']); ?>"><?php } else { echo h($Data_VietnamScan['NOTE']); } ?></td>
                                                                        </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <input type="hidden" name="until6" value="<?php echo $v; ?>">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade <?php echo h($tab3_text);?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCompleteSearch" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">검색</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php"> 
                                                    <div class="collapse show" id="collapseCompleteSearch">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>검색범위</label>
                                                                <div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div><input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d')); ?>" name="dt3"></div>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-info" name="bt32">ERP 엑셀 다운로드</button>
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>  
                                            
                                            <div class="card shadow mb-4">
                                                <a href="#collapseCompleteList" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">결과</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php"> 
                                                    <div class="collapse show" id="collapseCompleteList">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap">
                                                                <thead><tr><th></th><th>시트히터</th><th>발열핸들</th><th>통풍모듈</th><th>기타</th><th>합계</th></tr></thead>
                                                                <tbody>
                                                                    <tr><td style="width: 1vw;"><img src="../img/flag_k.webp" style="width: 3vw;"> 한국 (정상/오차)</td><td><?php if($SH+$ESH>0) {echo $SH+$ESH;} else {echo 0;} ?> (<?php if($SH>0) {echo $SH;} else {echo 0;} ?> / <?php if($ESH>0) {echo $ESH;} else {echo 0;} ?>)</td><td><?php if($SW>0) {echo $SW;} else {echo 0;} ?></td><td><?php if($VT>0) {echo $VT;} else {echo 0;} ?></td><td><?php if($ETC>0) {echo $ETC;} else {echo 0;} ?></td><td><?php if($Data_PcsCount['QT_GOODS']+$Data_PcsCount['ERROR_GOODS']>0) {echo $Data_PcsCount['QT_GOODS']+$Data_PcsCount['ERROR_GOODS'];} else {echo 0;} ?></td></tr>  
                                                                    <tr><td style="width: 1vw;"><img src="../img/flag_v.webp" style="width: 3vw;"> 베트남 (유검/무검)</td><td><?php if($vSH3>0) {echo $vSH3;} else {echo 0;} ?> (<?php if($vSH>0) {echo $vSH;} else {echo 0;} ?> / <?php if($vSH2>0) {echo $vSH2;} else {echo 0;} ?>)</td><td><?php if($vSW3>0) {echo $vSW3;} else {echo 0;} ?></td><td>-</td><td><?php if($vETC3>0) {echo $vETC3;} else {echo 0;} ?></td><td><?php if($Data_vPcsCount3['QT_GOODS']>0) {echo $Data_vPcsCount3['QT_GOODS'];} else {echo 0;} ?></td></tr>
                                                                    <tr><td style="width: 1vw;"><img src="../img/flag_c.webp" style="width: 3vw;"> 중국</td><td><?php if($Data_cPcsCount['QT_GOODS']>0) {echo $Data_cPcsCount['QT_GOODS'];} else {echo 0;} ?></td><td>-</td><td>-</td><td>-</td><td><?php if($Data_cPcsCount['QT_GOODS']>0) {echo $Data_cPcsCount['QT_GOODS'];} else {echo 0;} ?></td></tr> 
                                                                    <tr><td colspan='5'> 합계</td><td><?php if($Data_PcsCount['QT_GOODS']+$Data_PcsCount['ERROR_GOODS']+$Data_vPcsCount3['QT_GOODS']+$Data_cPcsCount['QT_GOODS']>0) {echo $Data_PcsCount['QT_GOODS']+$Data_PcsCount['ERROR_GOODS']+$Data_vPcsCount3['QT_GOODS']+$Data_cPcsCount['QT_GOODS'];} else {echo 0;} ?></td></tr>
                                                                </tbody>
                                                            </table>   
                                                            <br>
                                                            
                                                            <div class="d-block d-md-none mb-3 mt-2">
                                                                <div class="input-group shadow-sm"><input type="text" id="mobileSearchHistory" class="form-control mobile-search-input" onkeyup="filterTable('mobileSearchHistory', 'table3')" placeholder="검색..."><div class="input-group-append"><span class="input-group-text btn-primary"><i class="fas fa-search text-white"></i></span></div></div>
                                                            </div>

                                                            <table class="table table-bordered table-hover text-nowrap mobile-responsive-table" id="table3">
                                                                <thead><tr><th>국가</th><th>품번</th><th>품명</th><th>로트날짜</th><th>작업개수</th><th>불량개수</th><th>ERP 작업지시번호</th><th>검사여부</th><th>비고</th></tr></thead>
                                                                <tbody>
                                                                    <?php 
                                                                        for($j=1; $j<=$Count_kFinishHistory; $j++) { $Data_kFinishHistory = sqlsrv_fetch_array($Result_kFinishHistory); ?>
                                                                        <tr><td data-label="국가">한국</td><td data-label="품번"><?php echo $Data_kFinishHistory['CD_ITEM']; ?></td><td data-label="품명"><?php echo NM_ITEM($Data_kFinishHistory['CD_ITEM']); ?></td><td data-label="로트날짜"><?php echo $Data_kFinishHistory['LOT_DATE']; ?></td><td data-label="작업개수"><?php echo $Data_kFinishHistory['QT_GOODS']; ?></td><td data-label="불량개수"><?php echo $Data_kFinishHistory['REJECT_GOODS']; ?></td><td data-label="작지번호"><?php echo $Data_kFinishHistory['BARCODE']; ?></td><td data-label="검사여부">-</td><td data-label="비고"><?php echo $Data_kFinishHistory['NOTE']; ?></td></tr> 
                                                                    <?php } ?> 
                                                                    <?php 
                                                                        for($jv=1; $jv<=$Count_vFinishHistory; $jv++) { $Data_vFinishHistory = sqlsrv_fetch_array($Result_vFinishHistory); ?>
                                                                        <tr><td data-label="국가">베트남</td><td data-label="품번"><?php echo Hyphen($Data_vFinishHistory['CD_ITEM']); ?></td><td data-label="품명"><?php echo NM_ITEM($Data_vFinishHistory['CD_ITEM']); ?></td><td data-label="로트날짜"><?php echo $Data_vFinishHistory['LOT_DATE']; ?></td><td data-label="작업개수"><?php echo $Data_vFinishHistory['QT_GOODS']; ?></td><td data-label="불량개수"><?php echo $Data_vFinishHistory['REJECT_GOODS']; ?></td><td data-label="작지번호">-</td><td data-label="검사여부"><?php echo $Data_vFinishHistory['INSPECT_YN']; ?></td><td data-label="비고"><?php echo $Data_vFinishHistory['NOTE']; ?></td></tr> 
                                                                    <?php } ?>  
                                                                    <?php 
                                                                        for($jc=1; $jc<=$Count_cFinishHistory; $jc++) { $Data_cFinishHistory = sqlsrv_fetch_array($Result_cFinishHistory); ?>
                                                                        <tr><td data-label="국가">중국</td><td data-label="품번"><?php echo Hyphen($Data_cFinishHistory['CD_ITEM']); ?></td><td data-label="품명"><?php echo NM_ITEM($Data_cFinishHistory['CD_ITEM']); ?></td><td data-label="로트날짜"><?php echo $Data_cFinishHistory['LOT_DATE']; ?></td><td data-label="작업개수"><?php echo $Data_cFinishHistory['QT_GOODS']; ?></td><td data-label="불량개수"><?php echo $Data_cFinishHistory['REJECT_GOODS']; ?></td><td data-label="작지번호">-</td><td data-label="검사여부">-</td><td data-label="비고"><?php echo $Data_cFinishHistory['NOTE']; ?></td></tr> 
                                                                    <?php } ?>       
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="custom-tabs-one-2th" role="tabpanel" aria-labelledby="custom-tabs-one-2th-tab">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseDefectSearch" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">검색</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php"> 
                                                    <div class="collapse show" id="collapseDefectSearch">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0">
                                                                <label>검색범위</label>
                                                                <div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div><input type="text" class="form-control float-right kjwt-search-date" value="<?php if($dt4!=''){echo $dt4;} elseif($hidden_dt4!=''){echo $hidden_dt4;} elseif($hidden_dt42!=''){echo $hidden_dt42;} ?>" name="dt4"></div>
                                                            </div>
                                                        </div> 
                                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt41">검색</button></div>
                                                    </div>
                                                </form>             
                                            </div> 

                                            <div class="card shadow mb-4">
                                                <a href="#collapseDefectList" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">결과</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php">
                                                    <div class="collapse show" id="collapseDefectList">
                                                        <div class="card-body table-responsive p-2">
                                                            <div class="row">
                                                                <div class="col-xl-4 col-md-4 mb-2"><div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">한국(PCS)</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($Data_RejectPcsCount['REJECT_GOODS']>0) {echo $Data_RejectPcsCount['REJECT_GOODS'];} else {echo 0;} ?></div></div><div class="col" style="text-align: right;"><img src="../img/flag_k.webp" style="width: 5vm; height: 4vh;"></div></div></div></div></div>
                                                                <div class="col-xl-4 col-md-4 mb-2"><div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">베트남(PCS)</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($Data_vRejectPcsCount['REJECT_GOODS']>0) {echo $Data_vRejectPcsCount['REJECT_GOODS'];} else {echo 0;} ?></div></div><div class="col" style="text-align: right;"><img src="../img/flag_v.webp" style="width: 5vm; height: 4vh;"></div></div></div></div></div>
                                                                <div class="col-xl-4 col-md-4 mb-2"><div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">중국(PCS)</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($Data_cRejectPcsCount['REJECT_GOODS']>0) {echo $Data_cRejectPcsCount['REJECT_GOODS'];} else {echo 0;} ?></div></div><div class="col" style="text-align: right;"><img src="../img/flag_c.webp" style="width: 5vm; height: 4vh;"></div></div></div></div></div>
                                                            </div>
                                                            
                                                            <?php ModifyData2("field_complete.php?BadWorkModi=Y&hdt4=$dt4", "bt42", "FieldCompleteBad"); ?>

                                                            <div class="d-block d-md-none mb-3 mt-2">
                                                                <div class="input-group shadow-sm"><input type="text" id="mobileSearchDefect" class="form-control mobile-search-input" onkeyup="filterTable('mobileSearchDefect', 'table4')" placeholder="검색..."><div class="input-group-append"><span class="input-group-text btn-primary"><i class="fas fa-search text-white"></i></span></div></div>
                                                            </div>

                                                            <table class="table table-bordered table-hover text-nowrap mobile-responsive-table" id="table4">
                                                                <thead><tr><th>국가</th><th>품번</th><th>품명</th><th>로트날짜</th><th>로트번호</th><th>불량내용</th><th>불량개수</th><th>비고</th><th>처리현황</th></tr></thead>
                                                                <tbody>
                                                                    <?php for($j=1; $j<=$Count_Reject; $j++) { $Data_Reject = sqlsrv_fetch_array($Result_Reject); ?>
                                                                    <tr><td>한국</td><input name='badwork_kno<?php echo $j; ?>' value='<?php echo $Data_Reject['NO']; ?>' type='hidden'><td><?php echo $Data_Reject['CD_ITEM']; ?></td><td><?php echo NM_ITEM($Data_Reject['CD_ITEM']); ?></td><td><?php echo $Data_Reject['LOT_DATE']; ?></td><td><?php echo $Data_Reject['LOT_NUM']; ?></td><td><?php echo $Data_Reject['REJECT_NOTE']; ?></td><td><?php echo $Data_Reject['REJECT_GOODS']; ?></td><td><?php echo $Data_Reject['REJECT_NOTE']; ?></td><td><?php if($BadWorkModi=='Y') { ?><select name="K_STATUS<?php echo $j; ?>" class="form-control select2"><option value="<?php echo $Data_Reject['RESULT_NOTE']?>" selected><?php echo $Data_Reject['RESULT_NOTE']?></option><option value="폐기">폐기</option><option value="리워크">리워크</option><option value="리워크완료">리워크완료</option></select><?php } else { echo $Data_Reject['RESULT_NOTE']; } ?></td></tr>
                                                                    <?php } ?>
                                                                    <?php for($jv=1; $jv<=$Count_vReject; $jv++) { $Data_vReject = sqlsrv_fetch_array($Result_vReject); ?>
                                                                    <tr><td>베트남</td><input name='badwork_vno<?php echo $jv; ?>' value='<?php echo $Data_vReject['NO']; ?>' type='hidden'><td><?php echo $Data_vReject['CD_ITEM']; ?></td><td><?php echo NM_ITEM($Data_vReject['CD_ITEM']); ?></td><td><?php echo $Data_vReject['LOT_DATE']; ?></td><td><?php echo $Data_vReject['LOT_NUM']; ?></td><td><?php echo $Data_vReject['REJECT_NOTE']; ?></td><td><?php echo $Data_vReject['REJECT_GOODS']; ?></td><td><?php echo $Data_vReject['REJECT_NOTE']; ?></td><td><?php if($BadWorkModi=='Y') { ?><select name="V_STATUS<?php echo $jv; ?>" class="form-control select2"><option value="<?php echo $Data_vReject['RESULT_NOTE']?>" selected><?php echo $Data_vReject['RESULT_NOTE']?></option><option value="폐기">폐기</option><option value="리워크">리워크</option><option value="리워크완료">리워크완료</option></select><?php } else { echo $Data_vReject['RESULT_NOTE']; } ?></td></tr>
                                                                    <?php } ?>
                                                                    <?php for($jc=1; $jc<=$Count_cReject; $jc++) { $Data_cReject = sqlsrv_fetch_array($Result_cReject); ?>
                                                                    <tr><td>중국</td><input name='badwork_cno<?php echo $jc; ?>' value='<?php echo $Data_cReject['NO']; ?>' type='hidden'><td><?php echo $Data_cReject['CD_ITEM']; ?></td><td><?php echo NM_ITEM($Data_cReject['CD_ITEM']); ?></td><td><?php echo $Data_cReject['LOT_DATE']; ?></td><td><?php echo $Data_cReject['LOT_NUM']; ?></td><td><?php echo $Data_cReject['REJECT_NOTE']; ?></td><td><?php echo $Data_cReject['REJECT_GOODS']; ?></td><td><?php echo $Data_cReject['REJECT_NOTE']; ?></td><td><?php if($BadWorkModi=='Y') { ?><select name="C_STATUS<?php echo $jc; ?>" class="form-control select2"><option value="<?php echo $Data_cReject['RESULT_NOTE']?>" selected><?php echo $Data_cReject['RESULT_NOTE']?></option><option value="폐기">폐기</option><option value="리워크">리워크</option><option value="리워크완료">리워크완료</option></select><?php } else { echo $Data_cReject['RESULT_NOTE']; } ?></td></tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                            <input type="hidden" name="until4" value="<?php echo $j; ?>">
                                                            <input type="hidden" name="vuntil4" value="<?php echo $jv; ?>">
                                                            <input type="hidden" name="cuntil4" value="<?php echo $jc; ?>">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="custom-tabs-one-3th" role="tabpanel" aria-labelledby="custom-tabs-one-3th-tab">
                                            <div class="card shadow mb-4">
                                                <a href="#collapseDeleteSearch" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">검색</h6></a>
                                                <form method="POST" autocomplete="off" action="field_complete.php"> 
                                                    <div class="collapse show" id="collapseDeleteSearch">                                    
                                                        <div class="card-body p-3">
                                                            <div class="form-group mb-0"><label>검색범위</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div><input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt5 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt5"></div></div>
                                                        </div> 
                                                        <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt51">검색</button></div>
                                                    </div>
                                                </form>             
                                            </div> 
                                            
                                            <div class="card shadow mb-4">
                                                <a href="#collapseDeleteList" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"><h6 class="m-0 font-weight-bold text-primary">결과</h6></a>
                                                <div class="collapse show" id="collapseDeleteList">
                                                    <div class="card-body table-responsive p-2">
                                                        <div class="d-block d-md-none mb-3 mt-2">
                                                            <div class="input-group shadow-sm"><input type="text" id="mobileSearchDelete" class="form-control mobile-search-input" onkeyup="filterTable('mobileSearchDelete', 'table5')" placeholder="검색..."><div class="input-group-append"><span class="input-group-text btn-primary"><i class="fas fa-search text-white"></i></span></div></div>
                                                        </div>
                                                        <div id="table" class="table-editable">
                                                            <table class="table table-bordered table-hover mobile-responsive-table" id="table5">
                                                                <thead><tr><th>국가</th><th>품번</th><th>품명</th><th>로트날짜</th><th>로트번호</th></tr></thead>
                                                                <tbody>
                                                                    <?php for($j=1; $j<=$Count_Delete; $j++) { $Data_Delete = sqlsrv_fetch_array($Result_Delete); ?>
                                                                    <tr>
                                                                        <td data-label="국가"><?php if($Data_Delete['KIND']=='K') echo "한국"; elseif($Data_Delete['KIND']=='V') echo "베트남"; else echo "중국"; ?></td>
                                                                        <td data-label="품번"><?php echo $Data_Delete['CD_ITEM']; ?></td>
                                                                        <td data-label="품명"><?php echo NM_ITEM($Data_Delete['CD_ITEM']); ?></td>
                                                                        <td data-label="로트날짜"><?php echo $Data_Delete['LOT_DATE']; ?></td>
                                                                        <td data-label="로트번호"><?php echo $Data_Delete['LOT_NUM']; ?></td>
                                                                    </tr>
                                                                    <?php } ?>
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

    <div class="modal fade" id="itemSelectionModal" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">품번 선택</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><form method="POST" action="field_complete.php"><div class="modal-body"><p>여러 개의 품번이 발견되었습니다.</p><?php if (isset($_SESSION['item_options'])) { foreach ($_SESSION['item_options'] as $option) { echo '<div class="form-check"><input class="form-check-input" type="radio" name="selected_item" id="item_'.h($option).'" value="'.h($option).'" required><label class="form-check-label" for="item_'.h($option).'">'.h($option).'</label></div>'; } } ?></div><div class="modal-footer"><input type="hidden" name="original_work_order" value="<?php echo h($_SESSION['original_work_order'] ?? ''); ?>"><button type="submit" class="btn btn-primary" name="bt21_item_selected" value="on">선택</button></div></form></div></div></div>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">불량내용</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                <form method="POST" autocomplete="off" action="field_complete.php">                                                                                               
                    <div class="modal-body">
                        <div class="form-group"><label class="col-form-label">선택:</label><br>- 품번: <?php echo $kmodal_Delivery_ItemCode; ?><br>- 로트날짜: <?php echo $kmodal_Delivery_LotDate; ?><br>- 로트번호: <?php echo $kmodal_Delivery_LotNum; ?><br>- ERP작지번호: <?php echo $kmodal_Delivery_ERP; ?></div> 
                        <div class="form-group"><label class="col-form-label">입력:</label><div class="table-responsive"><table class="table table-bordered" id="table_modal"><thead><tr><th>내용</th><th>수량</th><th>비고</th></tr></thead><tbody>
                            <tr><td>원단손상</td><td><input type="text" class="form-control" name="mi1" value="<?php echo $Data_KoreaReject1['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="mn1" value="<?php echo $Data_KoreaReject1['REJECT_NOTE']?>"></td></tr>
                            <tr><td>저항과다</td><td><input type="text" class="form-control" name="mi2" value="<?php echo $Data_KoreaReject2['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="mn2" value="<?php echo $Data_KoreaReject2['REJECT_NOTE']?>"></td></tr>
                            <tr><td>이물/오염</td><td><input type="text" class="form-control" name="mi3" value="<?php echo $Data_KoreaReject3['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="mn3" value="<?php echo $Data_KoreaReject3['REJECT_NOTE']?>"></td></tr>
                            <tr><td>봉비/봉사</td><td><input type="text" class="form-control" name="mi4" value="<?php echo $Data_KoreaReject4['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="mn4" value="<?php echo $Data_KoreaReject4['REJECT_NOTE']?>"></td></tr>
                            <tr><td>펜작동무</td><td><input type="text" class="form-control" name="mi6" value="<?php echo $Data_KoreaReject6['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="mn6" value="<?php echo $Data_KoreaReject6['REJECT_NOTE']?>"></td></tr>
                            <tr><td>박스오차</td><td><input type="text" class="form-control" name="mi7" value="<?php echo $Data_KoreaReject7['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="mn7" value="<?php echo $Data_KoreaReject7['REJECT_NOTE']?>"></td></tr>
                            <tr><td>기타(리워크)</td><td><input type="text" class="form-control" name="mi5" value="<?php echo $Data_KoreaReject5['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="mn5" value="<?php echo $Data_KoreaReject5['REJECT_NOTE']?>"></td></tr>
                            <tr><td>기타(폐기)</td><td><input type="text" class="form-control" name="mi8" value="<?php echo $Data_KoreaReject8['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="mn8" value="<?php echo $Data_KoreaReject8['REJECT_NOTE']?>"></td></tr>
                        </tbody></table></div></div>
                    </div>
                    <div class="modal-footer"><input type="hidden" name="kmodal_ItemCode" value="<?php echo $kmodal_Delivery_ItemCode; ?>"><input type="hidden" name="kmodal_LotDate" value="<?php echo $kmodal_Delivery_LotDate; ?>"><input type="hidden" name="kmodal_LotNum" value="<?php echo $kmodal_Delivery_LotNum; ?>"><input type="hidden" name="kmodal_ERP" value="<?php echo $kmodal_Delivery_ERP; ?>"><button type="submit" value="on" name="mbt1" class="btn btn-info">저장</button><button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button></div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">수량변경</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><form method="POST" action="field_complete.php"><div class="modal-body"><div class="form-group"><label>품번:</label> <?php echo $modal_Delivery_ItemCode2; ?><br><label>현재수량:</label> <?php echo $Data_KoreaPrevious["QT_GOODS"]; ?></div><div class="form-group"><label>더 할 수량:</label><div class="input-group"><button type="button" class="btn btn-info" onclick="cal('m', this)">-</button><input type="text" class="form-control text-center" name="pop_out5" value="<?php if($size>0) {echo $size;} else {echo 0;}?>"><button type="button" class="btn btn-info" onclick="cal('p', this)">+</button></div></div></div><div class="modal-footer"><input type="hidden" name="modal_ItemCode2" value="<?php echo $modal_Delivery_ItemCode2; ?>"><input type="hidden" name="modal_quantiy2" value="<?php echo $Data_KoreaPrevious['QT_GOODS']; ?>"><button type="submit" value="on" name="mbt2" class="btn btn-info">저장</button><button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button></div></form></div></div></div>
    
    <div class="modal fade" id="exampleModalV" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">불량내용</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><form method="POST" action="field_complete.php"><div class="modal-body"><div class="form-group"><label>선택:</label><br>- 품번: <?php echo $vmodal_Delivery_ItemCode; ?><br>- 로트날짜: <?php echo $vmodal_Delivery_LotDate; ?></div><div class="form-group"><label>입력:</label><div class="table-responsive"><table class="table table-bordered" id="table_modal"><thead><tr><th>내용</th><th>수량</th><th>비고</th></tr></thead><tbody>
        <tr><td>원단손상</td><td><input type="text" class="form-control" name="vmi1" value="<?php echo $Data_VietnamReject1['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="vmn1" value="<?php echo $Data_VietnamReject1['REJECT_NOTE']?>"></td></tr>
        <tr><td>저항과다</td><td><input type="text" class="form-control" name="vmi2" value="<?php echo $Data_VietnamReject2['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="vmn2" value="<?php echo $Data_VietnamReject2['REJECT_NOTE']?>"></td></tr>
        <tr><td>이물/오염</td><td><input type="text" class="form-control" name="vmi3" value="<?php echo $Data_VietnamReject3['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="vmn3" value="<?php echo $Data_VietnamReject3['REJECT_NOTE']?>"></td></tr>
        <tr><td>봉비/봉사</td><td><input type="text" class="form-control" name="vmi4" value="<?php echo $Data_VietnamReject4['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="vmn4" value="<?php echo $Data_VietnamReject4['REJECT_NOTE']?>"></td></tr>
        <tr><td>기타(폐기)</td><td><input type="text" class="form-control" name="vmi6" value="<?php echo $Data_VietnamReject6['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="vmn6" value="<?php echo $Data_VietnamReject6['REJECT_NOTE']?>"></td></tr>
        <tr><td>박스오차</td><td><input type="text" class="form-control" name="vmi7" value="<?php echo $Data_VietnamReject7['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="vmn7" value="<?php echo $Data_VietnamReject7['REJECT_NOTE']?>"></td></tr>
        <tr><td>기타(리워크)</td><td><input type="text" class="form-control" name="vmi5" value="<?php echo $Data_VietnamReject5['REJECT_GOODS']?>"></td><td><input type="text" class="form-control" name="vmn5" value="<?php echo $Data_VietnamReject5['REJECT_NOTE']?>"></td></tr>
    </tbody></table></div></div></div><div class="modal-footer"><input type="hidden" name="vmodal_ItemCode" value="<?php echo $vmodal_Delivery_ItemCode; ?>"><input type="hidden" name="vmodal_LotDate" value="<?php echo $vmodal_Delivery_LotDate; ?>"><button type="submit" value="on" name="vmbt1" class="btn btn-info">저장</button><button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button></div></form></div></div></div>

    <div class="modal fade" id="exampleModalV2" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">수량변경</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><form method="POST" action="field_complete.php"><div class="modal-body"><div class="form-group"><label>품번:</label> <?php echo $vmodal_Delivery_ItemCode2; ?><br><label>현재수량:</label> <?php echo $Data_VietnamPrevious["QT_GOODS"]; ?></div><div class="form-group"><label>더 할 수량:</label><div class="input-group"><button type="button" class="btn btn-info" onclick="cal('m', this)">-</button><input type="text" class="form-control" name="pop_out4" value="<?php if($vsize>0) {echo $vsize;} else {echo 0;}?>"><button type="button" class="btn btn-info" onclick="cal('p', this)">+</button></div></div></div><div class="modal-footer"><input type="hidden" name="vmodal_ItemCode2" value="<?php echo $vmodal_Delivery_ItemCode2; ?>"><input type="hidden" name="vmodal_quantiy2" value="<?php echo $Data_VietnamPrevious['QT_GOODS']; ?>"><button type="submit" value="on" name="vmbt2" class="btn btn-info">저장</button><button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button></div></form></div></div></div>

    <?php include '../plugin_lv1.php'; ?>

    <style>
        /* !important로 부트스트랩 테이블 스타일(table-striped)을 강제로 덮어씌움 */
        .bg-checked-orange {
            background-color: #f6b352 !important;
        }
    </style>

    <script>
        $(document).ready(function(){
            
            // [기능 1] 배경색 업데이트 함수 (공통 사용)
            function updateAllRowColors() {
                // 베트남 탭의 모든 체크박스(V_CB...)를 찾아서 처리
                $('input[name^="V_CB"]').each(function(){
                    var $checkbox = $(this);
                    var $cell = $checkbox.closest('td');
                    
                    // td가 없으면 부모 요소 찾기 (안전장치)
                    if ($cell.length === 0) {
                        $cell = $checkbox.parent();
                    }

                    // 체크 여부에 따라 클래스 토글
                    if($checkbox.is(':checked')){
                        $cell.addClass('bg-checked-orange');
                    } else {
                        $cell.removeClass('bg-checked-orange');
                    }
                });
            }

            // [기능 2] 사용자가 체크박스를 '클릭'할 때 실시간 반응
            $(document).on('change', 'input[name^="V_CB"]', function(){
                // 클릭한 그 녀석만 즉시 색상 변경
                var $cell = $(this).closest('td');
                if ($cell.length === 0) $cell = $(this).parent();

                if($(this).is(':checked')){
                    $cell.addClass('bg-checked-orange');
                } else {
                    $cell.removeClass('bg-checked-orange');
                }
            });

            // [기능 3] 핵심: 테이블이 다시 그려질 때마다(페이지 이동 등) 색상 재적용
            // 'draw.dt'는 DataTables 라이브러리가 화면을 갱신할 때 발생하는 이벤트입니다.
            $(document).on('draw.dt', '#table_nosort2', function () {
                updateAllRowColors();
            });

            // [기능 4] 최초 페이지 로딩 시 1회 실행
            setTimeout(function(){
                updateAllRowColors();
            }, 100);
        });
    </script>

    <?php if(isset($_GET['popup']) && $_GET['popup'] == 'select_item'): ?>
        <script>$('#itemSelectionModal').modal('show');</script>
    <?php elseif($kmodal=='on'): ?>      
        <script>$('#exampleModal').modal('show');</script>
    <?php elseif($kmodal2=='on'): ?>      
        <script>$('#exampleModal2').modal('show');</script>
    <?php elseif($vmodal=='on'): ?>      
        <script>$('#exampleModalV').modal('show');</script>
    <?php elseif($vmodal2=='on'): ?>      
        <script>$('#exampleModalV2').modal('show');</script>
    <?php endif; ?>      
</body>
</html>

<?php 
    if (isset($connect4)) {mysqli_close($connect4);}	
    if(isset($connect)) {sqlsrv_close($connect);}	
?>