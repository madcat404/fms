<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.15>
	// Description:	<개인차량 연락망 (경비실용)>	
    // Last Modified: <Current Date> - Mobile Search Fixed (Method: GET)
	// =============================================
    include 'car_status.php';   

    // XSS 방지 함수
    function h($string) {
        if (!isset($string)) return '';
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>    
    <style>
        /* 모바일용 전화걸기 버튼 스타일 */
        .btn-call {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        /* [수정] 모바일 검색창 스타일 (사각형, 흰색 배경) */
        .mobile-search-input {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 0; /* 사각형 */
            background-color: #ffffff !important; /* 배경 흰색 */
            color: #495057; /* 텍스트 어두운 회색 */
            border: 1px solid #d1d3e2; /* 테두리 */
        }
        /* placeholder(안내문구) 색상 */
        .mobile-search-input::placeholder {
            color: #858796;
        }
        /* 검색 버튼 스타일 */
        .mobile-search-btn {
            width: 60px;
            border-radius: 0; /* 사각형 */
            /* btn-primary 클래스로 인해 파란색 유지 */
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">차량정보</h1>
                    </div>               

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-two" data-toggle="pill" href="#tab2">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" id="tab-one" data-toggle="pill" href="#tab1">차량 검색</a>
                                        </li>                                        
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            
                                            <div class="card shadow mb-3 d-block d-md-none border-0 bg-transparent">
                                                <form method="GET" action="">
                                                    <div class="input-group shadow-sm">
                                                        <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="차량번호 뒷자리 또는 이름" value="<?= h($search_keyword) ?>">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary mobile-search-btn" type="submit">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="card shadow mb-2">
                                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                    <h1 class="h6 m-0 font-weight-bold text-primary">차량목록</h1>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample21">
                                                    <div class="card-body p-2"> 
                                                        
                                                        <div class="d-md-none">
                                                            <?php if(empty($car_list)): ?>
                                                                <div class="text-center p-5 text-gray-500">
                                                                    <?php if($search_keyword): ?>
                                                                        <i class="fas fa-search-minus fa-2x mb-2"></i><br>
                                                                        검색 결과가 없습니다.
                                                                    <?php else: ?>
                                                                        <i class="fas fa-list fa-2x mb-2"></i><br>
                                                                        등록된 차량이 없습니다.
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <?php foreach ($car_list as $row): 
                                                                    $phone = h($row['CALL'] ?? ''); // 내선번호
                                                                    $tel_link = "tel:" . str_replace('-', '', $phone); 
                                                                ?>
                                                                <div class="card mb-2 shadow-sm border-0">
                                                                    <div class="card-body p-3">
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <div>
                                                                                <h5 class="font-weight-bold text-primary mb-1"><?= h($row['CAR_NUM']) ?></h5>
                                                                                <h6 class="text-dark font-weight-bold mb-1"><?= h($row['USER_NM']) ?> <small class="text-muted"><?= h($row['TEAM_NM']) ?></small></h6>
                                                                                <div class="small text-gray-600">
                                                                                    <?= h($row['CAR_NM']) ?>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <?php if($phone): ?>
                                                                                <a href="<?= $tel_link ?>" class="btn btn-success btn-call">
                                                                                    <i class="fas fa-phone-alt"></i>
                                                                                </a>
                                                                                <?php else: ?>
                                                                                <button class="btn btn-secondary btn-call" disabled>
                                                                                    <i class="fas fa-phone-slash"></i>
                                                                                </button>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-striped table-hover" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>이름</th>
                                                                        <th>팀명</th>
                                                                        <th>차종</th>   
                                                                        <th>차번</th>
                                                                        <th>내선</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($car_list as $row): ?>                                                                            
                                                                        <tr> 
                                                                            <td><?= h($row['USER_NM']) ?></td>                                                                                              
                                                                            <td><?= h($row['TEAM_NM']) ?></td>  
                                                                            <td><?= h($row['CAR_NM']) ?></td> 
                                                                            <td><?= h($row['CAR_NUM']) ?></td> 
                                                                            <td><?= h($row['CALL']) ?></td>    
                                                                        </tr>                                                                           
                                                                    <?php endforeach; ?>                     
                                                                </tbody>
                                                            </table>
                                                        </div> 

                                                    </div>
                                                </div>
                                            </div>                                          
                                        </div>  

                                        <div class="tab-pane fade p-2" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            [목표]<BR>
                                            - 개인차량 및 출입 차량 연락망 확인<BR><BR>   
                                            
                                            [용도]<BR>
                                            - 경비실 및 임직원용 주차 관리<BR>
                                            - 이중주차 또는 비상 시 차주에게 즉시 연락<BR><BR>

                                            [사용법]<BR>
                                            - '차량 검색' 탭에서 차량번호 뒷자리(4자리) 또는 차주 이름을 입력하세요.<BR>
                                            - 모바일에서는 우측의 초록색 전화기 버튼을 누르면 바로 연결됩니다.<BR><BR>
                                            
                                            [제작일]<BR>
                                            - 21.11.15<br><br>        
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
    <?php include '../plugin_lv1.php'; ?>
</body>
</html>

<?php 
    // 메모리 회수 (MySQLi)
    if(isset($connect4)) { mysqli_close($connect4); }	
?>