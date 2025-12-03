<?php 
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>   
    // Create date: <21.10.07>
    // Description: <하이패스 리뉴얼>   
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
    // Last Modified: <Current Date> - UI Compact & Visual Separation
    // =============================================
    include 'hipass_status.php'; 

    // 모바일 뷰 반복 출력을 위한 데이터 배열 생성
    $mobile_view_data = [
        ['row' => $row1, 'user_row' => $user_row1, 'dt_row' => $dt_row1],
        ['row' => $row2, 'user_row' => $user_row2, 'dt_row' => $dt_row2],
        ['row' => $row3, 'user_row' => $user_row3, 'dt_row' => $dt_row3],
        ['row' => $row4, 'user_row' => $user_row4, 'dt_row' => $dt_row4],
    ];
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">하이패스</h1>
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
                                            <a class="nav-link <?php echo htmlspecialchars($tab2 ?? '', ENT_QUOTES, 'UTF-8');?>" id="tab-two" data-toggle="pill" href="#tab2">충전</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo htmlspecialchars($tab3 ?? '', ENT_QUOTES, 'UTF-8');?>" id="tab-three" data-toggle="pill" href="#tab3">대여 / 반납</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 하이패스카드 출납 및 내역 전산화<BR><BR>   

                                            [참조]<BR>
                                            - 현황 IN/OUT 상관없이 충전 가능<BR>
                                            - 해당 기능을 별도로 만든 이유는 카드만 빌려야 하는 예외사항이 몇번 있었기 때문 ex) 법인차 하이패스카드가 고장나서 개인출장하이패스카드를 빌려야 하는 경우 <br>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 전직원<br><br>

                                            [히스토리]<br>
                                            25.05.14<br>
                                            - 개인차량운행일지에 하이패스카드를 빌릴 수 있도록 하였는데 미숙한 사용자가 따로 입력하는 문제가 지속적으로 발생하여 해당 메뉴에서 하이패스카드를 대여, 반납 시 패스워드를 입력하도록 함 (패스워드 힌트: bc카드 패스워드 동일)<br><br>

                                            [제작일]<BR>
                                            - 21.10.07<br><br> 
                                        </div>
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text ?? '', ENT_QUOTES, 'UTF-8');?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">충전</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="hipass.php"> 
                                                    <div class="collapse show" id="collapseCardExample21">                                    
                                                        <div class="card-body">
                                                            <div class="row">    
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>카드선택</label>
                                                                        <select name="hipasscard" class="form-control select2" style="width: 100%;">
                                                                            <option value="" selected="selected">선택</option>
                                                                            <option value="1">개인출장1</option>
                                                                            <option value="2">개인출장2</option>
                                                                            <option value="3">개인출장3</option>
                                                                            <option value="4">개인출장4</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>충전금액</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="card_sum" required onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>패스워드</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                                            </div>
                                                                            <input type="password" class="form-control" name="card_admin" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt2">충전</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">현황</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample22">
                                                    <div class="card-body p-2">
                                                        <div class="d-md-none">
                                                            <?php foreach ($mobile_view_data as $data): 
                                                                $r = $data['row']; $u = $data['user_row']; $dt = $data['dt_row'];
                                                                $renter = (isset($r) && $r->CARD_CONDITION=='OUT') ? $r->USER : "없음";
                                                                $date = (isset($dt) && $dt->RETURN_DATE==NULL) ? $dt->RECORD_DATE : ($dt->RETURN_DATE ?? '');

                                                                // 색상 로직 적용 (모바일)
                                                                $kind_color = "text-secondary";
                                                                if (isset($r)) {
                                                                    if ($r->CARD_CONDITION == 'IN') $kind_color = "text-success"; // 초록색
                                                                    elseif ($r->CARD_CONDITION == 'OUT') $kind_color = "text-danger"; // 빨간색
                                                                }
                                                            ?>
                                                            <div class="card mb-2"> <div class="card-body p-3">
                                                                <div class="row no-gutters align-items-center">
                                                                    <div class="col mr-2">
                                                                        <div class="h6 font-weight-bold <?= $kind_color ?> text-uppercase mb-2">
                                                                            <?= htmlspecialchars($r->KIND ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                                        </div>
                                                                        <div class="row mb-1">
                                                                            <div class="col-4 font-weight-bold small text-gray-600">현황</div>
                                                                            <div class="col-8 small"><?= htmlspecialchars($r->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                                                        </div>
                                                                        <div class="row mb-1">
                                                                            <div class="col-4 font-weight-bold small text-gray-600">잔액</div>
                                                                            <div class="col-8 small"><?= htmlspecialchars($r->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                                                        </div>
                                                                        <div class="row mb-1">
                                                                            <div class="col-4 font-weight-bold small text-gray-600">대여자</div>
                                                                            <div class="col-8 small"><?= htmlspecialchars($renter, ENT_QUOTES, 'UTF-8') ?></div>
                                                                        </div>
                                                                        <div class="row mb-1">
                                                                            <div class="col-4 font-weight-bold small text-gray-600">마지막사용</div>
                                                                            <div class="col-8 small"><?= htmlspecialchars($u->USER ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                                                        </div>
                                                                        <div class="row mb-0">
                                                                            <div class="col-4 font-weight-bold small text-gray-600">날짜</div>
                                                                            <div class="col-8 small"><?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-hover text-nowrap" id="dataTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>카드종류</th>
                                                                        <th>마지막 사용자</th>
                                                                        <th>대여자</th>
                                                                        <th>현황</th>
                                                                        <th>잔액</th>
                                                                        <th>대여/반납일</th>    
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($mobile_view_data as $data): 
                                                                        $r = $data['row']; $u = $data['user_row']; $dt = $data['dt_row'];
                                                                        $renter = (isset($r) && $r->CARD_CONDITION=='OUT') ? $r->USER : "없음";
                                                                        $date = (isset($dt) && $dt->RETURN_DATE==NULL) ? $dt->RECORD_DATE : ($dt->RETURN_DATE ?? '');

                                                                        // [추가] 웹상 현황 색상 로직
                                                                        $status_class = "";
                                                                        if (isset($r)) {
                                                                            if ($r->CARD_CONDITION == 'IN') $status_class = "text-success font-weight-bold";
                                                                            elseif ($r->CARD_CONDITION == 'OUT') $status_class = "text-danger font-weight-bold";
                                                                        }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($r->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($u->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($renter, ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td class="<?= $status_class ?>"><?= htmlspecialchars($r->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($r->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?></td>
                                                                    </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>  

                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab3_text ?? '', ENT_QUOTES, 'UTF-8');?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">대여</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="hipass.php"> 
                                                    <div class="collapse show" id="collapseCardExample31">                                    
                                                        <div class="card-body">
                                                            <div class="row">    
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>카드선택</label>
                                                                        <select name="hipasscard31" class="form-control select2" style="width: 100%;">
                                                                            <option value="" selected="selected">선택</option>
                                                                            <?php foreach ( $in_hipass as $option ) : ?>
                                                                                <option value="<?= htmlspecialchars($option->NO ?? '', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($option->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>사용자</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="user3" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>패스워드</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                                            </div>
                                                                            <input type="password" class="form-control" name="password31" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt31">대여</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">반납</h6>
                                                </a>
                                                <form method="POST" autocomplete="off" action="hipass.php"> 
                                                    <div class="collapse show" id="collapseCardExample32">                                    
                                                        <div class="card-body">
                                                            <div class="row">    
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>카드선택</label>
                                                                        <select name="hipasscard32" class="form-control select2" style="width: 100%;">
                                                                            <option value="" selected="selected">선택</option>
                                                                            <?php foreach ( $out_hipass as $option ) : ?>
                                                                                <option value="<?= htmlspecialchars($option->NO ?? '', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($option->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>카드잔액</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="card_balance" required onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>패스워드</label>
                                                                        <div class="input-group">                                                
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                                            </div>
                                                                            <input type="password" class="form-control" name="password32" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div> 
                                                        <div class="card-footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt32">반납</button>
                                                        </div>
                                                    </div>
                                                </form>             
                                            </div>

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample33" class="d-block card-header py-3" data-toggle="collapse"
                                                    role="button" aria-expanded="true" aria-controls="collapseCardExample33">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">현황</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample33">
                                                    <div class="card-body p-2">
                                                        <div class="d-md-none">
                                                            <?php foreach ($mobile_view_data as $data): 
                                                                $r = $data['row']; $u = $data['user_row']; $dt = $data['dt_row'];
                                                                $renter = (isset($r) && $r->CARD_CONDITION=='OUT') ? $r->USER : "없음";
                                                                $date = (isset($dt) && $dt->RETURN_DATE==NULL) ? $dt->RECORD_DATE : ($dt->RETURN_DATE ?? '');

                                                                // 색상 로직 적용 (모바일)
                                                                $kind_color = "text-secondary";
                                                                if (isset($r)) {
                                                                    if ($r->CARD_CONDITION == 'IN') $kind_color = "text-success"; // 초록색
                                                                    elseif ($r->CARD_CONDITION == 'OUT') $kind_color = "text-danger"; // 빨간색
                                                                }
                                                            ?>
                                                            <div class="card mb-2">
                                                                <div class="card-body p-3">
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col mr-2">
                                                                            <div class="h6 font-weight-bold <?= $kind_color ?> text-uppercase mb-2">
                                                                                <?= htmlspecialchars($r->KIND ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                                            </div>
                                                                            <div class="row mb-1">
                                                                                <div class="col-4 font-weight-bold small text-gray-600">현황</div>
                                                                                <div class="col-8 small"><?= htmlspecialchars($r->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                                                            </div>
                                                                            <div class="row mb-1">
                                                                                <div class="col-4 font-weight-bold small text-gray-600">잔액</div>
                                                                                <div class="col-8 small"><?= htmlspecialchars($r->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                                                            </div>
                                                                            <div class="row mb-1">
                                                                                <div class="col-4 font-weight-bold small text-gray-600">대여자</div>
                                                                                <div class="col-8 small"><?= htmlspecialchars($renter, ENT_QUOTES, 'UTF-8') ?></div>
                                                                            </div>
                                                                            <div class="row mb-1">
                                                                                <div class="col-4 font-weight-bold small text-gray-600">마지막사용</div>
                                                                                <div class="col-8 small"><?= htmlspecialchars($u->USER ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                                                            </div>
                                                                            <div class="row mb-0">
                                                                                <div class="col-4 font-weight-bold small text-gray-600">날짜</div>
                                                                                <div class="col-8 small"><?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-hover text-nowrap" id="dataTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>카드종류</th>
                                                                        <th>마지막 사용자</th>
                                                                        <th>대여자</th>
                                                                        <th>현황</th>
                                                                        <th>잔액</th>
                                                                        <th>대여/반납일</th>    
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($mobile_view_data as $data): 
                                                                        $r = $data['row']; $u = $data['user_row']; $dt = $data['dt_row'];
                                                                        $renter = (isset($r) && $r->CARD_CONDITION=='OUT') ? $r->USER : "없음";
                                                                        $date = (isset($dt) && $dt->RETURN_DATE==NULL) ? $dt->RECORD_DATE : ($dt->RETURN_DATE ?? '');

                                                                        // [추가] 웹상 현황 색상 로직
                                                                        $status_class = "";
                                                                        if (isset($r)) {
                                                                            if ($r->CARD_CONDITION == 'IN') $status_class = "text-success font-weight-bold";
                                                                            elseif ($r->CARD_CONDITION == 'OUT') $status_class = "text-danger font-weight-bold";
                                                                        }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= htmlspecialchars($r->KIND ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($u->USER ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($renter, ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td class="<?= $status_class ?>"><?= htmlspecialchars($r->CARD_CONDITION ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($r->SUM ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                                        <td><?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?></td>
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

    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    //메모리 회수
    if (isset($connect)) {
        if ($connect instanceof mysqli) {
            mysqli_close($connect);
        } elseif (is_resource($connect) && get_resource_type($connect) === 'SQL Server Connection') {
            sqlsrv_close($connect);
        }
    }
?>