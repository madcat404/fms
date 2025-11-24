<?php
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <24.05.08>
    // Description:	<근무복>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
    // =============================================

    // Helper function for safe HTML output
    function h($s) {
        return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
    }
?>
<head>
    <?php include_once '../head_lv1.php'; ?>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include_once '../nav.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button"><i class="fa fa-bars"></i></button>
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">유니폼</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item"><a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a></li>
                                        <li class="nav-item"><a class="nav-link <?= h($tab2) ?>" id="tab-two" data-toggle="pill" href="#tab2">지급/반납</a></li>
                                        <li class="nav-item"><a class="nav-link <?= h($tab3) ?>" id="tab-three" data-toggle="pill" href="#tab3">검색</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>- 유니폼 지급현황 전산화<BR><BR>
                                            [참조]<BR>- 요청자: 권성근 개인 프로젝트<br>- 사용자: 사무직<br><br>
                                            [업데이트]<BR>- 25.01.23 시큐어코딩 및 코드리팩토링<br><br>
                                            [제작일]<BR>- 24.05.08<br><br>
                                        </div>
                                        <div class="tab-pane fade <?= h($tab2_text) ?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample11" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample11"><h1 class="h6 m-0 font-weight-bold text-primary">지급</h1></a>
                                                    <form method="POST" autocomplete="off" action="uniform.php">
                                                        <div class="collapse show" id="collapseCardExample11">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-4"><div class="form-group"><label>사용자</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="text" class="form-control" name="user11" required></div></div></div>
                                                                    <div class="col-md-4"><div class="form-group"><label>춘추복/동복</label><select name="kind11" class="form-control select11" style="width: 100%;"><option value="" selected>선택</option><option value="춘추복">춘추복</option><option value="동복">동복</option></select></div></div>
                                                                    <div class="col-md-4"><div class="form-group"><label>사이즈</label><select name="size11" class="form-control select12" style="width: 100%;"><option value="" selected>선택</option><option value="S">S</option><option value="M">M</option><option value="L">L</option><option value="XL">XL</option><option value="XXL">XXL</option><option value="XXXL">XXXL</option><option value="XXXXL">XXXXL</option></select></div></div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt11">지급</button></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21"><h1 class="h6 m-0 font-weight-bold text-primary">반납</h1></a>
                                                    <form method="POST" autocomplete="off" action="uniform.php">
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-3"><div class="form-group"><label>사용자</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="text" class="form-control" name="user21" required></div></div></div>
                                                                    <div class="col-md-3"><div class="form-group"><label>춘추복/동복</label><select name="kind21" class="form-control select21" style="width: 100%;"><option value="" selected>선택</option><option value="춘추복">춘추복</option><option value="동복">동복</option></select></div></div>
                                                                    <div class="col-md-3"><div class="form-group"><label>사이즈</label><select name="size21" class="form-control select22" style="width: 100%;"><option value="" selected>선택</option><option value="S">S</option><option value="M">M</option><option value="L">L</option><option value="XL">XL</option><option value="XXL">XXL</option><option value="XXXL">XXXL</option><option value="XXXXL">XXXXL</option></select></div></div>
                                                                    <div class="col-md-3"><div class="form-group"><label>특이사항</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sticky-note"></i></span></div><input type="text" class="form-control" name="note21"></div></div></div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt21">반납</button></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample23"><h1 class="h6 m-0 font-weight-bold text-primary">현황</h1></a>
                                                    <div class="collapse show" id="collapseCardExample23">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-striped" id="table1">
                                                                <thead><tr><th>종류</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>XXXXL</th></tr></thead>
                                                                <tbody>
                                                                    <?php if (!empty($Data_Uniform)) : foreach ($Data_Uniform as $Uniform) : ?>
                                                                        <tr>
                                                                            <td><?= h($Uniform['KIND']) ?></td>
                                                                            <td><?= h($Uniform['S']) ?></td>
                                                                            <td><?= h($Uniform['M']) ?></td>
                                                                            <td><?= h($Uniform['L']) ?></td>
                                                                            <td><?= h($Uniform['XL']) ?></td>
                                                                            <td><?= h($Uniform['XXL']) ?></td>
                                                                            <td><?= h($Uniform['XXXL']) ?></td>
                                                                            <td><?= h($Uniform['XXXXL']) ?></td>
                                                                        </tr>
                                                                    <?php endforeach; endif; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade <?= h($tab3_text) ?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample31"><h1 class="h6 m-0 font-weight-bold text-primary">검색</h1></a>
                                                    <form method="POST" autocomplete="off" action="uniform.php">
                                                        <div class="collapse show" id="collapseCardExample31">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?= h($dt3) ?>" name="dt3">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-right"><button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample32"><h1 class="h6 m-0 font-weight-bold text-primary">결과</h1></a>
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead><tr><th>날짜</th><th>사용자</th><th>구분</th><th>종류</th><th>사이즈</th><th>특이사항</th></tr></thead>
                                                                <tbody>
                                                                    <?php if (!empty($data)) : foreach ($data as $Data_UniformChk) : ?>
                                                                        <tr>
                                                                            <td><?= ($Data_UniformChk['SORTING_DATE']) ? $Data_UniformChk['SORTING_DATE']->format("Y-m-d") : '' ?></td>
                                                                            <td><?= h($Data_UniformChk['NAME']) ?></td>
                                                                            <td><?= ($Data_UniformChk['INOUT'] === 'OUT') ? '지급' : '반납' ?></td>
                                                                            <td><?= h($Data_UniformChk['KIND']) ?></td>
                                                                            <td><?= h($Data_UniformChk['SIZE']) ?></td>
                                                                            <td><?= h($Data_UniformChk['NOTE']) ?></td>
                                                                        </tr>
                                                                    <?php endforeach; endif; ?>
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
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
    <?php include_once '../plugin_lv1.php'; ?>
</body>
</html>