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

    // 모바일 초기 화면 (지급/반납 선택)
    if (empty($flag)) : ?>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <style>
                .popup { display: none; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 300px; padding: 20px; background-color: white; border: 2px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000; text-align: center; box-sizing: border-box; }
                .popup-background { display: none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 999; }
                .close-btn { position: absolute; top: -15px; right: -10px; background-color: transparent; border: none; font-size: 25px; font-weight: bold; cursor: pointer; color: #333; }
                .popup button { margin: 10px; padding: 10px; cursor: pointer; }
                .popup-buttons { display: flex; justify-content: center; }
            </style>
        </head>
        <body>
            <div class="popup-background" id="popupBackground"></div>
            <div class="popup" id="popup">
                <button class="close-btn" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></button>
                <p>선택 하세요!</p>
                <div class="popup-buttons">
                    <button onclick="location.href='uniform.php?flag=out'">지급</button>
                    <button onclick="location.href='uniform.php?flag=in'">반납</button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('popupBackground').style.display = 'block';
                    document.getElementById('popup').style.display = 'block';
                });
                function closePopup() {
                    document.getElementById('popupBackground').style.display = 'none';
                    document.getElementById('popup').style.display = 'none';
                    location.href = "uniform.php?flag=log";
                }
            </script>
        </body>
    <?php 
    // 모바일 지급/반납/로그 화면
    else : ?>
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
                                <a href="uniform.php?flag=<?php echo ($flag === 'log') ? '' : 'log'; ?>" class="btn btn-link mr-3" title="move_inquire">
                                    <i class="fa <?php echo ($flag === 'log') ? 'fa-tshirt' : 'fa-clipboard-list'; ?> fa-2x"></i>
                                </a> 
                                <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">유니폼</h1>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <?php if ($flag === 'out') : ?>
                                        <form method="POST" autocomplete="off" action="uniform.php?flag=out">
                                            <div class="row">
                                                <div class="col-md-4"><div class="form-group"><label>사용자</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="text" class="form-control" name="user11" required></div></div></div>
                                                <div class="col-md-4"><div class="form-group"><label>춘추복/동복</label><select name="kind11" class="form-control select11" style="width: 100%;"><option value="" selected>선택</option><option value="춘추복">춘추복</option><option value="동복">동복</option></select></div></div>
                                                <div class="col-md-4"><div class="form-group"><label>사이즈</label><select name="size11" class="form-control select12" style="width: 100%;"><option value="" selected>선택</option><option value="S">S</option><option value="M">M</option><option value="L">L</option><option value="XL">XL</option><option value="XXL">XXL</option><option value="XXXL">XXXL</option><option value="XXXXL">XXXXL</option></select></div></div>
                                            </div>
                                            <div class="text-right mt-3"><button type="submit" value="on" class="btn btn-primary" name="bt11">지급</button></div>
                                        </form>
                                    <?php elseif ($flag === 'in') : ?>
                                        <form method="POST" autocomplete="off" action="uniform.php?flag=in">
                                            <div class="row">
                                                <div class="col-md-3"><div class="form-group"><label>사용자</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="text" class="form-control" name="user21" required></div></div></div>
                                                <div class="col-md-3"><div class="form-group"><label>춘추복/동복</label><select name="kind21" class="form-control select21" style="width: 100%;"><option value="" selected>선택</option><option value="춘추복">춘추복</option><option value="동복">동복</option></select></div></div>
                                                <div class="col-md-3"><div class="form-group"><label>사이즈</label><select name="size21" class="form-control select22" style="width: 100%;"><option value="" selected>선택</option><option value="S">S</option><option value="M">M</option><option value="L">L</option><option value="XL">XL</option><option value="XXL">XXL</option><option value="XXXL">XXXL</option><option value="XXXXL">XXXXL</option></select></div></div>
                                                <div class="col-md-3"><div class="form-group"><label>특이사항</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sticky-note"></i></span></div><input type="text" class="form-control" name="note21"></div></div></div>
                                            </div>
                                            <div class="text-right mt-3"><button type="submit" value="on" class="btn btn-primary" name="bt21">반납</button></div>
                                        </form>
                                    <?php elseif ($flag === 'log') : ?>
                                        <table class="table table-bordered table-striped" id="table1">
                                            <thead><tr><th>날짜</th><th>사용자</th><th>구분</th><th>종류</th><th>사이즈</th><th>특이사항</th></tr></thead>
                                            <tbody>
                                                <?php if (!empty($data)) : foreach ($data as $Data_Uniform2) : ?>
                                                    <tr>
                                                        <td><?= ($Data_Uniform2['SORTING_DATE']) ? $Data_Uniform2['SORTING_DATE']->format("Y-m-d") : '' ?></td>
                                                        <td><?= h($Data_Uniform2['NAME']) ?></td>
                                                        <td><?= ($Data_Uniform2['INOUT'] === 'OUT') ? '지급' : '반납' ?></td>
                                                        <td><?= h($Data_Uniform2['KIND']) ?></td>
                                                        <td><?= h($Data_Uniform2['SIZE']) ?></td>
                                                        <td><?= h($Data_Uniform2['NOTE']) ?></td>
                                                    </tr>
                                                <?php endforeach; endif; ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    <?php endif; ?>