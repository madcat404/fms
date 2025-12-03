<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.07.18>
	// Description:	<이달의 생일자>
    // Last Modified: <Current Date> - Mobile Search Fixed (Method: GET)
	// =============================================
    include_once __DIR__ . '/birthday_status.php';

    // XSS 방지 함수
    function h($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }

    // [데이터 전처리] 결과 데이터를 배열로 저장 (모바일/PC 공용)
    $birthday_list = [];
    if (isset($Result_birthday) && $Result_birthday) {
        while ($row = sqlsrv_fetch_array($Result_birthday, SQLSRV_FETCH_ASSOC)) {
            if (!empty($row['NM_KOR'])) {
                $birthday_list[] = $row;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include_once __DIR__ . '/../head_lv1.php'; ?>    
    <style>
        /* [수정] 모바일 검색창 스타일 (사각형, 흰색 배경) */
        .mobile-search-input {
            height: 50px;
            font-size: 1.1rem;
            border-radius: 0; /* 사각형 */
            background-color: #ffffff !important; /* 배경 흰색 */
            color: #495057; /* 텍스트 어두운 회색 */
            border: 1px solid #d1d3e2; /* 테두리 */
        }
        .mobile-search-input::placeholder {
            color: #858796;
        }
        .mobile-search-btn {
            width: 60px;
            border-radius: 0; /* 사각형 */
            /* btn-primary 클래스로 인해 파란색 유지 */
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">      
        
        <?php include_once __DIR__ . '/../nav.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">생년월일</h1>
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
                                            <a class="nav-link <?php echo htmlspecialchars($tab2 ?? '', ENT_QUOTES, 'UTF-8'); ?>" id="tab-two" data-toggle="pill" href="#tab2">목록</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade p-2" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<br>
                                            - 직원 생일 알림<br><br>

                                            [기능]<br>
                                            - 매월 1일 당월 생일자 알림 메일 발송 (hr@iwin.kr)<br><br>

                                            [참조]<br>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 경영팀<br><br>

                                            [제작일]<br>
                                            - 24.07.18<br><br>
                                        </div>
                                        
                                        <div class="tab-pane fade <?php echo htmlspecialchars($tab2_text ?? '', ENT_QUOTES, 'UTF-8'); ?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">               
                                            
                                            <div class="card shadow mb-3 d-block d-md-none border-0 bg-transparent">
                                                <form method="GET" action="birthday.php">
                                                    <div class="input-group shadow-sm">
                                                        <input type="text" class="form-control mobile-search-input" name="search_keyword" placeholder="이름 검색" value="<?= h($search_keyword) ?>">
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
                                                    <h6 class="m-0 font-weight-bold text-primary">명단</h6>
                                                </a>
                                                <div class="collapse show" id="collapseCardExample21">
                                                    <div class="card-body p-2">
                                                        
                                                        <div class="d-md-none">
                                                            <?php foreach ($birthday_list as $row): ?>
                                                            <div class="card mb-2">
                                                                <div class="card-body p-3">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <h6 class="font-weight-bold text-primary mb-0">
                                                                            <?= h($row['NM_KOR']) ?>
                                                                        </h6>
                                                                        <span class="small text-gray-600 font-weight-bold">
                                                                            <?= h(substr($row['NO_RES'] ?? '', 2, 4)) ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                            <?php if(empty($birthday_list)): ?>
                                                                <div class="text-center p-3 text-gray-500">
                                                                    <?php if($search_keyword): ?>
                                                                        검색 결과가 없습니다.
                                                                    <?php else: ?>
                                                                        이번 달 생일자가 없습니다.
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="table-responsive d-none d-md-block">
                                                            <table class="table table-bordered table-striped" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>이름</th>
                                                                        <th>생년월일</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($birthday_list as $row): ?>
                                                                    <tr> 
                                                                        <td><?php echo h($row['NM_KOR']); ?></td>
                                                                        <td><?php echo h(substr($row['NO_RES'] ?? '', 2, 4)); ?></td>
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
    <?php include_once __DIR__ . '/../plugin_lv1.php'; ?>
</body>
</html>