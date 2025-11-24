<?php 
  // =============================================
	// Author:		<KWON SUNG KUN - cardclear@naver.com>	
	// Create date: <24.09.12>
	// Description:	<법인카드>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include_once __DIR__ . '/card_status.php';

    // Helper function for safely echoing variables to prevent XSS
    function h($variable) {
        return htmlspecialchars($variable ?? '', ENT_QUOTES, 'UTF-8');
    }
?>
<!DOCTYPE html>
<html lang="ko">

<?php if(isMobile() && empty($flag)): // ============== MOBILE INITIAL POPUP ============== ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: sans-serif; }
        .popup { display: none; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 300px; padding: 20px; background-color: white; border: 2px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000; text-align: center; box-sizing: border-box; }
        .close-btn { position: absolute; top: -15px; right: -10px; background-color: transparent; border: none; font-size: 25px; font-weight: bold; cursor: pointer; color: #333; }
        .popup button { margin: 10px; padding: 10px; cursor: pointer; width: 40%; }
        .popup-buttons { display: flex; justify-content: center; }
        .popup-background { display: none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 999; }
    </style>
</head>
<body>
    <div class="popup-background" id="popupBackground"></div>
    <div class="popup" id="popup">
        <button class="close-btn" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></button>
        <p>선택 하세요!</p>
        <div class="popup-buttons">
            <button onclick="CardOut()">사용</button>
            <button onclick="CardIn()">반납</button>
        </div>
    </div>
    <script>
        function openPopup() { document.getElementById('popupBackground').style.display = 'block'; document.getElementById('popup').style.display = 'block'; }
        function closePopup() { window.location.href = "card.php?flag=log"; }
        function CardOut() { window.location.href = "card.php?flag=out"; }
        function CardIn() { window.location.href = "card.php?flag=in"; }
        window.onload = openPopup;
    </script>
</body>

<?php else: // ============== DESKTOP & MOBILE ACTION/LOG VIEW ============== ?>
<head>
    <?php include_once __DIR__ . '/../head_lv1.php'; ?>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include_once __DIR__ . '/../nav.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <?php if(isMobile()): ?>
                            <a href="card.php?flag=<?php echo ($flag === 'log') ? '' : 'log'; ?>" class="btn btn-link mr-3" title="move_inquire">
                                <i class="fa <?php echo ($flag === 'log') ? 'fa-credit-card' : 'fa-clipboard-list'; ?> fa-2x"></i>
                            </a>
                        <?php else: ?>
                            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button"><i class="fa fa-bars"></i></button>
                        <?php endif; ?>
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">법인카드</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php if(isMobile()): // --- Mobile View --- ?>
                                <?php if($flag === 'out'): ?>
                                    <form method="POST" autocomplete="off" action="card.php?flag=out" class="card shadow mb-4 p-3">
                                        <div class="row">
                                            <div class="col-md-4 form-group"><label>카드번호(끝4자리)</label><select name="card11" class="form-control select22" required><option value="" selected>선택</option><option value="6532">[신한] 6532</option><option value="3963">[BC우리] 3963</option><option value="7938">[BC기업] 7938</option></select></div>
                                            <div class="col-md-4 form-group"><label>주민번호 앞자리</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="number" class="form-control" name="user11" required></div></div>
                                            <div class="col-md-4 form-group"><label>사유</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-pen-to-square"></i></span></div><input type="text" class="form-control" name="contents11" required></div></div>
                                            <div class="col-md-4 form-group"><label>사용일</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-rotate-left"></i></span></div><input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt); ?>" name="dt" required></div></div>
                                        </div>
                                        <div class="text-right mt-3"><button type="submit" value="on" class="btn btn-primary" name="bt11">입력</button></div>
                                    </form>
                                <?php elseif($flag === 'in'): ?>
                                    <form method="POST" autocomplete="off" action="card.php?flag=in" class="card shadow mb-4 p-3">
                                        <div class="row">
                                            <div class="col-md-4 form-group"><label>카드번호(끝4자리)</label><select name="card12" class="form-control select22" required><option value="" selected>선택</option><option value="6532">[신한] 6532</option><option value="3963">[BC우리] 3963</option><option value="7938">[BC기업] 7938</option></select></div>
                                            <div class="col-md-4 form-group"><label>주민번호 앞자리</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div><input type="number" class="form-control" name="user12" required></div></div>
                                        </div>
                                        <div class="text-right mt-3"><button type="submit" value="on" class="btn btn-primary" name="bt12">입력</button></div>
                                    </form>
                                <?php elseif($flag === 'log'): ?>
                                    <form method="POST" autocomplete="off" action="card.php?flag=log" class="card shadow mb-4 p-3">
                                        <div class="form-group"><label>검색범위</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div><input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt13); ?>" name="dt13"></div></div>
                                        <div class="text-right"><button type="submit" value="on" class="btn btn-primary" name="bt13">검색</button></div>
                                    </form>
                                    <div class="table-responsive card shadow p-3">
                                        <table class="table table-bordered table-striped" id="table1">
                                            <thead><tr><th>날짜</th><th>소속</th><th>사용자</th><th>카드번호</th><th>사유</th><th>전자결재</th><th>결재완료</th><th>사용기간</th><th>반납 예정일</th><th>반납여부</th><th>반납자</th><th>반납일</th></tr></thead>
                                            <tbody>
                                            <?php if(isset($Result_Card)): while($Data_Card = sqlsrv_fetch_array($Result_Card)): ?>
                                                <?php
                                                    // Get Department Name
                                                    $Query_Dept = "SELECT B.NM_DEPT FROM NEOE.NEOE.MA_EMP A JOIN NEOE.NEOE.MA_DEPT B ON A.CD_DEPT=B.CD_DEPT WHERE A.CD_COMPANY='1000' AND A.NM_KOR= ?";
                                                    $Result_Dept = sqlsrv_query($connect, $Query_Dept, [$Data_Card['NAME']]);
                                                    $Data_Dept = sqlsrv_fetch_array($Result_Dept);

                                                    // Get Date Diff
                                                    $limit_days = '';
                                                    if ($Data_Card['START_DT'] && $Data_Card['END_DT']) {
                                                        $limit = date_diff($Data_Card['START_DT'], $Data_Card['END_DT']);
                                                        $limit_days = $limit->days . '일';
                                                    }

                                                    // Get GW Info
                                                    $stmt_gw = $connect3->prepare("SELECT doc_title, doc_sts FROM teag_appdoc WHERE user_nm=? AND doc_no LIKE '법인카드%' ORDER BY doc_id DESC LIMIT 1");
                                                    $stmt_gw->bind_param("s", $Data_Card['NAME']);
                                                    $stmt_gw->execute();
                                                    $Result_GWInfo = $stmt_gw->get_result();
                                                    $Data_GWInfo = $Result_GWInfo->fetch_assoc();
                                                ?>
                                                <tr> 
                                                    <td><?php echo $Data_Card['SORTING_DATE'] ? $Data_Card['SORTING_DATE']->format("Y-m-d") : ''; ?></td>
                                                    <td><?php echo h($Data_Dept['NM_DEPT']); ?></td>  
                                                    <td><?php echo h($Data_Card['NAME']); ?></td> 
                                                    <td><?php echo h($Data_Card['CARD']); ?></td> 
                                                    <td><?php echo h($Data_Card['CONTENTS']); ?></td> 
                                                    <td><?php echo h($Data_GWInfo['doc_title']); ?></td> 
                                                    <td><?php echo (isset($Data_GWInfo['doc_sts']) && $Data_GWInfo['doc_sts']=='90') ? 'Y' : 'N'; ?></td> 
                                                    <td><?php echo h($limit_days); ?></td> 
                                                    <td><?php echo $Data_Card['END_DT'] ? $Data_Card['END_DT']->format("Y-m-d") : ''; ?></td> 
                                                    <td><?php echo h($Data_Card['IN_YN']); ?></td>  
                                                    <td><?php echo h($Data_Card['RETURN_USER']); ?></td>  
                                                    <td><?php echo $Data_Card['RETURN_DATE'] ? $Data_Card['RETURN_DATE']->format("Y-m-d") : ''; ?></td> 
                                                </tr>
                                            <?php endwhile; endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            <?php else: // --- Desktop View ---
                                ?><?php
// =============================================
// Author:		<KWON SUNG KUN - cardclear@naver.com>
// Create date: <24.09.12>
// Last Update: <25.09.23>
// Description:	<법인카드 - 데스크톱 UI 뷰>
// =============================================

// Helper function for safely echoing variables to prevent XSS
if (!function_exists('h')) {
    function h($variable) {
        return htmlspecialchars($variable ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>
<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab">
            <li class="nav-item"><a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">대여목록</a></li>   
            <li class="nav-item"><a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">대여현황</a></li>   
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <!-- 1번째 탭: 공지 --> 
            <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                - 카드가 빌려 있는 상태이지만 중복해서 빌릴 수 있도록 로직을 짜놓은 이유<br>
                 > 실물카드는 경영팀이 들고 갔지만 생관에서 인터넷으로 사용할 수 있음<br>
                 > 개발자는 실물카드의 in/out을 관리하려고 이것을 개발했지만 재무팀에서는 어디에서 사용을 했는가에 대해 관리하고 싶음<br>
            </div>

            <!-- 2번째 탭: 대여목록 -->         
            <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                        <h6 class="m-0 font-weight-bold text-primary">검색</h6>
                    </a>
                    <form method="POST" autocomplete="off" action="card.php">
                        <div class="collapse show" id="collapseCardExample22">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>검색범위</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo h($dt22); ?>" name="dt22">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" value="on" class="btn btn-primary" name="bt22">검색</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                        <h6 class="m-0 font-weight-bold text-primary">목록</h6>
                    </a>
                    <div class="collapse show" id="collapseCardExample21">
                        <div class="card-body table-responsive p-2">
                            <table class="table table-bordered table-striped" id="table4">
                                <thead><tr><th>날짜</th><th>소속</th><th>사용자</th><th>카드번호</th><th>사유</th><th>전자결재</th><th>결재완료</th><th>사용기간</th><th>반납 예정일</th><th>반납여부</th><th>반납자</th><th>반납일</th></tr></thead>
                                <tbody>
                                <?php if(isset($Result_Card22)): while($Data_Card = sqlsrv_fetch_array($Result_Card22)): ?>
                                    <?php
                                        // Get Department Name
                                        $Query_Dept = "SELECT B.NM_DEPT FROM NEOE.NEOE.MA_EMP A JOIN NEOE.NEOE.MA_DEPT B ON A.CD_DEPT=B.CD_DEPT WHERE A.CD_COMPANY='1000' AND A.NM_KOR= ?";
                                        $Result_Dept = sqlsrv_query($connect, $Query_Dept, [$Data_Card['NAME']]);
                                        $Data_Dept = sqlsrv_fetch_array($Result_Dept);

                                        // Get Date Diff
                                        $limit_days = '';
                                        if ($Data_Card['START_DT'] && $Data_Card['END_DT']) {
                                            $limit = date_diff($Data_Card['START_DT'], $Data_Card['END_DT']);
                                            $limit_days = $limit->days . '일';
                                        }

                                        // Get GW Info
                                        $limit_num = ($Data_Card['GW'] ?? 1) - 1;
                                        if ($limit_num < 0) { $limit_num = 0; }

                                        $stmt_gw = $connect3->prepare("SELECT doc_title, doc_sts FROM teag_appdoc WHERE user_nm=? AND doc_no LIKE '법인카드%' ORDER BY doc_id DESC LIMIT ?, 1");
                                        $doc_title = '법인카드%';
                                        $stmt_gw->bind_param("si", $Data_Card['NAME'], $limit_num);
                                        $stmt_gw->execute();
                                        $Result_GWInfo = $stmt_gw->get_result();
                                        $Data_GWInfo = $Result_GWInfo->fetch_assoc();
                                    ?>
                                    <tr> 
                                        <td><?php echo $Data_Card['SORTING_DATE'] ? $Data_Card['SORTING_DATE']->format("Y-m-d") : ''; ?></td>
                                        <td><?php echo h($Data_Dept['NM_DEPT']); ?></td>  
                                        <td><?php echo h($Data_Card['NAME']); ?></td> 
                                        <td><?php echo h($Data_Card['CARD']); ?></td> 
                                        <td><?php echo h($Data_Card['CONTENTS']); ?></td> 
                                        <td><?php echo ($Data_Dept['NM_DEPT'] != '경영팀') ? h($Data_GWInfo['doc_title']) : '-'; ?></td> 
                                        <td><?php echo ($Data_Dept['NM_DEPT'] != '경영팀') ? ((isset($Data_GWInfo['doc_sts']) && $Data_GWInfo['doc_sts']=='90') ? 'Y' : 'N') : '-';?></td> 
                                        <td><?php echo h($limit_days); ?></td> 
                                        <td><?php echo $Data_Card['END_DT'] ? $Data_Card['END_DT']->format("Y-m-d") : ''; ?></td>  
                                        <td><?php echo h($Data_Card['IN_YN']); ?></td>    
                                        <td><?php echo h($Data_Card['RETURN_USER']); ?></td>  
                                        <td><?php echo $Data_Card['RETURN_DATE'] ? $Data_Card['RETURN_DATE']->format("Y-m-d") : ''; ?></td> 
                                    </tr>
                                <?php endwhile; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3번째 탭: 대여현황 --> 
            <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                        <h6 class="m-0 font-weight-bold text-primary">대여현황</h6>
                    </a>
                    <div class="collapse show" id="collapseCardExample31">
                        <div class="card-body table-responsive p-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="text-align: center;"><th>카드사</th><th>카드번호</th><th>유효기간(MM/YY)</th><th>결재일</th><th>반납여부</th></tr>
                                </thead>
                                <tbody>
                                    <tr style="vertical-align: middle; text-align: center;"> 
                                        <td>신한카드</td><td>4518-4445-0568-6532</td><td>01/27</td><td rowspan="3" style="vertical-align: middle;">매월 23일</td> 
                                        <td><?php echo (($Data_Card6532['IN_YN'] ?? 'Y') == 'N') ? "대여" : "반납"; ?></td>   
                                    </tr>  
                                    <tr style="text-align: center;"> 
                                        <td>우리비씨카드</td><td>4101-2020-0993-3963</td><td>03/30</td>   
                                        <td><?php echo (($Data_Card3963['IN_YN'] ?? 'Y') == 'N') ? "대여" : "반납"; ?></td>  
                                    </tr> 
                                    <tr style="text-align: center;"> 
                                        <td>기업비씨카드</td><td>9430-0307-5713-7938</td><td>05/26</td>  
                                        <td><?php echo (($Data_Card7938['IN_YN'] ?? 'Y') == 'N') ? "대여" : "반납"; ?></td> 
                                    </tr>   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modals-container">
        <!-- Return User Selection Modal -->
        <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">반납자 선택</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>해당 카드를 여러 명이 대여 중입니다. 반납 처리할 사용자를 선택하세요.</p>
                    <select id="returnUserInput" class="form-control">
                    <option value="" selected>선택</option>
                    <?php if (isset($multiple_checkout_users)): ?>
                        <?php foreach($multiple_checkout_users as $user): ?>
                        <option value="<?php echo h($user); ?>"><?php echo h($user); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button type="button" class="btn btn-primary" onclick="submitReturn()">확인</button>
                </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../plugin_lv1.php'; ?>

    <?php if (isset($show_return_modal) && $show_return_modal): ?>
    <script>
        $(document).ready(function() {
            const returneeName = <?php echo json_encode($returnee_name); ?>;
            const cardToReturn = <?php echo json_encode($card_to_return); ?>;

            window.submitReturn = function() {
                const selectedUser = document.getElementById("returnUserInput").value;
                if (selectedUser) {
                    const url = `card.php?name=${encodeURIComponent(returneeName)}&card=${encodeURIComponent(cardToReturn)}&cardpopuser=${encodeURIComponent(selectedUser)}`;
                    window.location.href = url;
                } else {
                    alert("반납 처리할 사용자를 선택해 주세요.");
                }
            };

            $('#returnModal').modal('show');
        });
    </script>
    <?php endif; ?>
</body>
<?php endif; ?>
</html>
<?php 
    if(isset($connect4)) { mysqli_close($connect4); }
    if(isset($connect3)) { mysqli_close($connect3); }
    if(isset($connect)) { sqlsrv_close($connect); }
?>