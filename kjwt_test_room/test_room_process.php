<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.04.08>
	// Description:	<시험실 qr코드 이력관리>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'test_room_process_status.php';

    // Helper function to render the LEG form, reducing massive code duplication.
    function renderLegForm($legNumber, $legData, $existData, $showClass, $cdItem, $id) {
        $cdItemEscaped = htmlspecialchars($cdItem ?? '', ENT_QUOTES, 'UTF-8');
        $idEscaped = htmlspecialchars($id ?? '', ENT_QUOTES, 'UTF-8');
        $actionUrl = "test_room_process.php?CD_ITEM={$cdItemEscaped}&ID={$idEscaped}";
?>
        <div class="card shadow mb-4">
            <a href="#collapseCardExample2<?php echo $legNumber; ?>" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2<?php echo $legNumber; ?>">
                <h1 class="h6 m-0 font-weight-bold text-primary">LEG<?php echo $legNumber; ?></h1>
            </a>
            <form method="POST" autocomplete="off" action="<?php echo $actionUrl; ?>">
                <div class="collapse <?php echo htmlspecialchars($showClass ?? ''); ?>" id="collapseCardExample2<?php echo $legNumber; ?>">
                    <div class="card-body table-responsive p-2">
                        <div id="table" class="table-editable">
                            <table class="table table-bordered" id="table_test_room_process_<?php echo $legNumber; ?>">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">순서</th>
                                        <th style="text-align: center;">시험명</th>
                                        <th style="text-align: center;">판정</th>
                                        <th style="text-align: center;">특이사항</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $flag = 0;
                                    if (!empty($legData)) {
                                        foreach ($legData as $item) {
                                            $leg = $item['LEG'] ?? '';
                                            $step = $item['STEP'] ?? '';
                                            $process = $item['PROCESS'] ?? '';
                                            $stepId = $leg . $step;

                                            $currentValue = $existData["P{$stepId}"] ?? null;
                                            $currentValueNOTE = $existData["NOTE{$stepId}"] ?? null;
                                            $nextStepJs = (int)$step + 1;

                                            $isDisabled = ($flag === 1 && empty($currentValue));
                                            $disabledAttr = $isDisabled ? "disabled" : "";

                                            if (empty($currentValue)) {
                                                $flag = 1;
                                            }
                                    ?>
                                        <tr>
                                            <td style='text-align: center;'><?php echo htmlspecialchars($step); ?></td>
                                            <td style='text-align: center;'><?php echo htmlspecialchars($process); ?></td>
                                            <td style='text-align: center;'>
                                                <select id='P<?php echo $stepId; ?>' name='P<?php echo $stepId; ?>' style='width: 100%;' <?php echo $disabledAttr; ?> onchange='updateSelectState("P<?php echo $stepId; ?>", "P<?php echo $leg . $nextStepJs; ?>")'>
                                                    <option value='' <?php echo ($currentValue == '') ? "selected" : ""; ?>></option>
                                                    <option value='NA' <?php echo ($currentValue == 'NA') ? "selected" : ""; ?>>N/A(생략)</option>
                                                    <option value='불합격' <?php echo ($currentValue == '불합격') ? "selected" : ""; ?>>불합격</option>
                                                    <option value='합격' <?php echo ($currentValue == '합격') ? "selected" : ""; ?>>합격</option>
                                                </select>
                                            </td>
                                            <td style='text-align: center;'>
                                                <input type='text' name='NOTE<?php echo $stepId; ?>' style='width: 100%;' <?php echo $disabledAttr; ?> value='<?php echo htmlspecialchars($currentValueNOTE ?? '', ENT_QUOTES); ?>'>
                                            </td>
                                        </tr>
                                    <?php } }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" value="on" class="btn btn-primary" name="bt2<?php echo $legNumber; ?>">입력</button>
                    </div>
                </div>
            </form>
        </div>
<?php
    }
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">시험 이력 관리</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 
                        <?php 
                            if(isMobile())  {
                        ?>
                            <div class="col-lg-12"> 
                                <?php 
                                for ($i = 1; $i <= 8; $i++) {
                                    $legDataVar = "Data_LEG{$i}";
                                    $showVar = "show{$i}";
                                    renderLegForm($i, $$legDataVar ?? [], $Data_ExistData ?? [], $$showVar ?? '', $CD_ITEM ?? '', $ID ?? '');
                                }
                                ?>
                            </div>
                        <?php 
                            } else {
                        ?>
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4 ?? '';?>" id="tab-four" data-toggle="pill" href="#tab4">라벨발행</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2 ?? '';?>" id="tab-two" data-toggle="pill" href="#tab2">이력관리</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3 ?? '';?>" id="tab-three" data-toggle="pill" href="#tab3">이력조회</a>
                                        </li>  
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [안내]<br>
                                            - 시험 이력 관리를 위한 페이지입니다.
                                        </div>
                                        
                                        <div class="tab-pane fade <?php echo $tab2_text ?? '';?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="col-lg-12"> 
                                                <?php 
                                                for ($i = 1; $i <= 8; $i++) {
                                                    $legDataVar = "Data_LEG{$i}";
                                                    $showVar = "show{$i}";
                                                    renderLegForm($i, $$legDataVar ?? [], $Data_ExistData ?? [], $$showVar ?? '', $CD_ITEM ?? '', $ID ?? '');
                                                }
                                                ?>
                                            </div>
                                        </div>  

                                        <div class="tab-pane fade <?php echo $tab3_text ?? '';?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="test_room_process.php"> 
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <div class="row">                                                                        
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo htmlspecialchars($dt3 ?? ''); ?>" name="dt3">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
                                                            </div>   
                                                        </div>
                                                    </form>             
                                                </div>
                                            </div>  

                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h1>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">    
                                                            <table class="table table-bordered table-hover text-nowrap" id="table6">
                                                                <thead>
                                                                    <tr>
                                                                        <th>품명</th><th>라벨발행일</th><th>라벨번호</th><th>시험품사양</th><th>시험자</th><th>SW</th><th>샘플번호</th><th>시험목적</th><th>HW</th><th>비고</th>
                                                                        <?php 
                                                                            // Dynamically generate headers
                                                                            for ($l=1; $l<=8; $l++) {
                                                                                for ($s=1; $s<=14; $s++) {
                                                                                    echo "<th>LEG{$l}/{$s} 판정</th><th>LEG{$l}/{$s} 특이사항</th>";
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        if(isset($Result_Select)) {
                                                                            while($Data_Select = sqlsrv_fetch_array($Result_Select, SQLSRV_FETCH_ASSOC))
                                                                            {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo htmlspecialchars($Data_Select['CD_ITEM'] ?? ''); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['LOT_DATE'] ?? ''); ?></td>   
                                                                        <td><?php echo htmlspecialchars($Data_Select['LOT_NUM'] ?? ''); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['CONTENTS'] ?? ''); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['TEST_USER'] ?? ''); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['SW'] ?? ''); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['SAMPLE_NUM'] ?? ''); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['PURPOSE'] ?? ''); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['HW'] ?? ''); ?></td> 
                                                                        <td><?php echo htmlspecialchars($Data_Select['NOTE'] ?? ''); ?></td> 
                                                                        <?php 
                                                                            // Dynamically generate cells
                                                                            for ($l=1; $l<=8; $l++) {
                                                                                for ($s=1; $s<=14; $s++) {
                                                                                    echo "<td>" . htmlspecialchars($Data_Select["P{$l}{$s}"] ?? '') . "</td>";
                                                                                    echo "<td>" . htmlspecialchars($Data_Select["NOTE{$l}{$s}"] ?? '') . "</td>";
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </tr> 
                                                                    <?php 
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

                                        <div class="tab-pane fade <?php echo $tab4_text ?? '';?>" id="tab4" role="tabpanel" aria-labelledby="tab-four"> 
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">라벨발행</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" name="pop_form" action="test_room_label_force.php" target="_blank"> 
                                                        <div class="collapse show" id="collapseCardExample41">                                    
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-4"><div class="form-group"><label>품명</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-signature"></i></span></div><input type="text" class="form-control" name="item41" required></div></div></div>
                                                                    <div class="col-md-4"><div class="form-group"><label>출력 라벨 수량</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-barcode"></i></span></div><input type="number" class="form-control" name="label41" min="1" value="1" required></div></div></div>
                                                                    <div class="col-md-4"><div class="form-group"><label>비고</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-sticky-note"></i></span></div><input type="text" class="form-control" name="note41"></div></div></div>
                                                                    <div class="col-md-4"><div class="form-group"><label>시험품 사양</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-ruler-combined"></i></span></div><input type="text" class="form-control" name="contents41" required placeholder="EX) SHVU_FR"></div></div></div>
                                                                    <div class="col-md-4"><div class="form-group"><label>시험자</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="text" class="form-control" name="test_user41" required></div></div></div>
                                                                    <div class="col-md-4"><div class="form-group"><label>SW</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-windows"></i></span></div><input type="text" class="form-control" name="sw41" required placeholder="EX) 25410"></div></div></div>
                                                                    <div class="col-md-4
                                                                    <div class="col-md-4"><div class="form-group"><label>샘플번호</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-tag"></i></span></div><input type="text" class="form-control" name="sample_num41" placeholder="EX) #5-1"></div></div></div>
                                                                    <div class="col-md-4"><div class="form-group"><label>시험목적</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-flag-checkered"></i></span></div><select name='purpose41' class="form-control" required><option value='DV'>DV</option><option value='PV'>PV</option><option value='4M변경'>4M변경</option><option value='정기시험'>정기시험</option></select></div></div></div>
                                                                    <div class="col-md-4"><div class="form-group"><label>HW</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hdd"></i></span></div><input type="text" class="form-control" name="hw41" required placeholder="EX) 1.00"></div></div></div>
                                                                </div> 
                                                            </div>
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt41">발행</button>
                                                            </div>   
                                                        </div>
                                                    </form>     
                                                </div>
                                            </div>  
                                        </div> 

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateSelectState(currentId, nextId) {
            const currentElement = document.getElementById(currentId);
            const nextElement = document.getElementById(nextId);
            if (!nextElement) return; // 다음 요소가 없으면 종료

            const nextInput = document.querySelector(`input[name="NOTE${nextId.replace('P', '')}"]`);

            if (currentElement.value !== '') {
                nextElement.disabled = false;
                if (nextInput) nextInput.disabled = false;
            } else {
                nextElement.disabled = true;
                nextElement.value = '';
                if (nextInput) {
                    nextInput.disabled = true;
                    nextInput.value = '';
                }
                // 이후의 모든 select와 input도 비활성화 및 초기화
                let currentLeg = nextId.charAt(1);
                let currentStep = parseInt(nextId.substring(2));
                let nextEl = document.getElementById(`P${currentLeg}${currentStep}`);
                while(nextEl) {
                    nextEl.disabled = true;
                    nextEl.value = '';
                    let nextInputEl = document.querySelector(`input[name="NOTE${currentLeg}${currentStep}"]`);
                    if(nextInputEl) {
                        nextInputEl.disabled = true;
                        nextInputEl.value = '';
                    }
                    currentStep++;
                    nextEl = document.getElementById(`P${currentLeg}${currentStep}`);
                }
            }
        }
    </script>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>