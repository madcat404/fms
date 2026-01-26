<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.06.12>
	// Description:	<그룹웨어 캠페인>	
  // Last Modified: <25.09.30> - Refactored for PHP 8.x and security.
	// =============================================
  // ★★★ [보안 강화] 외부/내부 접속 구분 및 도메인 검증 시작 ★★★
    
    // 1. 설정: 허용할 외부 홈페이지 도메인 (반드시 실제 운영 중인 홈페이지 주소로 변경하세요)
    // 예: 홈페이지가 www.kjwt.co.kr 이라면 아래 배열에 넣습니다.
    $allowed_referers = [
        'gw.iwin.kr'
    ];

    // 2. 설정: 외부 iframe 호출 시 사용할 보안 키
    $public_access_key = "iwin_public_secure"; 

    // 3. 검증 로직
    $is_public_view = false;
    $input_token = $_GET['token'] ?? '';
    $http_referer = $_SERVER['HTTP_REFERER'] ?? ''; // 요청이 어디서 왔는지 확인

    // 토큰이 일치하는지 확인
    if ($input_token === $public_access_key) {
        
        // 리퍼러(접속 경로) 검증: 주소창에 직접 입력(null)하거나 다른 곳에서 링크 건 경우 차단
        $is_valid_origin = false;
        foreach ($allowed_referers as $domain) {
            if (strpos($http_referer, $domain) !== false) {
                $is_valid_origin = true;
                break;
            }
        }

        // 토큰도 맞고, 우리 홈페이지에서 온 요청이 맞다면 공개 모드 활성화
        if ($is_valid_origin) {
            $is_public_view = true;
        }
    }

    // 4. 내부 접속(공개 모드가 아님)일 경우에만 세션 체크 실행
    // 리퍼러가 없거나(직접 입력), 토큰이 틀리면 무조건 로그인 페이지로 튕김
    if (!$is_public_view) {
        try {
            require_once __DIR__ .'/../session/session_check.php';
        } catch (Exception $e) {
            die("Session check failed.");
        }
    }
    // ★★★ [보안 강화] 로직 끝 ★★★
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>    
</head>

<body id="page-top" style="overflow:hidden;">

    <!-- Page Wrapper -->
    <div id="wrapper">  

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">         

                    <!-- Begin row -->
                    <div class="row">  
                      
                      <!-- 보드2 -->
                      <div class="col-12" style="background-color: #ffffff;">
                        <div class="card h-100 border-0" style="background-color: #ffffff;">
                          <div class="card-body">
                              <div class="col-12">
                                  <p style="font-weight: bold; font-size: 100%; padding-left: 80px;">
                                    <img src="../files_public/snow.gif" loop="infinite" style="width: 4%;">
                                    [ESG 캠페인] 문 닫고 겨울철 적정 실내온도 20°C 이하 지키기!! 1°C 올리면 7% 에너지 절약!! Save Energy Save Earth!!
                                    <br>
                                    <img src="../files_public/monitor2.gif" loop="infinite" style="width: 4%;">
                                    [업무집중시간제] 8:30~10:30 / 13:30~15:30 / 흡연, 커피, 잡담, 사적인 인터넷과 전화, 화장실 출입 등 자제 바랍니다!!
                                  </p>
                              </div>                       
                          </div>
                        </div>
                      </div>

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