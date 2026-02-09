<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.2.13>
	// Description:	<전산 보고서>	
    // Last Modified: <25.10.15> - Refactored for PHP 8.x	
	// =============================================
    include 'report_network_status.php';

    // Helper function for XSS protection
    function h($text) {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }

    // Data arrays for dynamic table generation
    $servers = [
        ['CAD', 'CAD 네트워크 라이선스 대여', '', 'Y', 'Y', 'WINDOW SERVER 2008 R2', '(종료)2020.01.14'],
        ['DB', '데이터베이스', '세콤, ERP, FMS, 저항검사기, 부품식별표 데이터 저장', 'Y', 'Y', 'WINDOW SERER 2019', '2029.01.09'],
        ['DNS', '도메인 네임 등록', 'URL에서 IP주소 추출하는 역할', 'Y', '', 'linux RockyOS 8.5', '2029'],
        ['ERP', '더존 ERP, SCM', '', 'Y', 'Y', 'WINDOW SERVER 2022', '2031.10.14'],
        ['FMS', '법인차관리, 공정 POP시스템, 내부회계, ESG, 기타', '', 'Y', '', 'linux RockyOS 8.5', '2029'],
        ['PDM', '도면, 문서, EO 버전 관리', '', 'Y', 'Y', 'WINDOW SERVER 2019', '2029.01.09'],
        ['SECOM', '출입통제, 식수, 근태', '', 'Y', 'Y', 'WINDOWSERVER 2012 R2', '(종료)2023.10.10'],
        ['ALTIUM', '알티움 네트워크 라이선스 대여', '', 'Y', 'Y', 'WINDOWSERVER 2008 R2', '(종료)2020.01.14'],
        ['GW', '더존 그룹웨어', '', '', '', 'linux CENTOS 7', '2024.06.30'],
        ['ZABBIX', '서버 및 네트워크 관제', '', 'Y', '', 'linux CENTOS 8', '(종료)2021.12.31'],
        ['BRIDGE', '외부 원격연결, FMS API 데이터 수집 및 알람메일 발송', '', '', '', 'WINDOWSERVER 2008 R2', '(종료)2020.01.14'],
        ['ECU', '프로그램 및 파일공유', '', '', '', 'WINDOW 10 PRO', '2025.10.14'],
        ['알약', '백신', '', '', '', 'WINDOW 10 PRO', '2025.10.14'],
        ['FAX', '신도리코 FAX 파일화', '', '', '', 'WINDOW 7 home', '2025.10.14'],
        ['전산실 NAS', '백업', '', '', '', '', ''],
        ['경비실 NAS', '파일공유', '', '', '', '', ''],
        ['베트남 NAS', '파일공유', '', '', '', '', ''],
        ['스팸아웃', '스팸메일 필터링', '', '', '', '', ''],
        ['E-Branch', '기업은행 통합자금관리', '기업은행 자산', '', '', 'WINDOW 2012 R2', '(종료)2023.10.10'],
        ['홈페이지', '홈페이지 서버', '', '', '', 'WINDOW 10 PRO', '2025.10.14'],
    ];

    $maintenance_costs = [
        ['알약(서버)', '1년', '9.30', '2,700,000', '서버 백신 (6copy)'],
        ['알약(사용자)', '1년', '1.28', '2,380,000', '사용자 백신 (70copy)'],
        ['캐드', '1년', '1.23', '1,420,000', '기술연구소 S/W'],
        ['카티아', '1년', '2.11', '33,100,000', '기술연구소 S/W'],
        ['PDM', '1년', '1.31', '9,000,000', '도면관리 프로그램'],
        ['ERP', '1년', '2.28', '22,000,000', '자원관리 프로그램'],
        ['스팸필터', '1년', '4.30', '1,150,000', '스팸메일 필터 (120유저)'],
        ['도메인1', '3년', '1.5', '70,200', 'Iwin.kr 사용료'],
        ['SSL 인증서', '1년', '5.20', '484,000', 'HTTPS 보안 인증서'],
        ['그룹웨어', '1년', '11.26', '5,614,000', '26년 그룹웨어 변경계획으로 인하여 유지보수 계약 연장 안함'],
        ['네트워크, 서버 유지보수', '1개월', '-', '1,036,666', '-'],
        ['팀즈', '1개월', '-', '5,400', '화상회의 프로그램 (1유저)'],
    ];

    $web_services = [
        ['GW (Group Ware)', '기업 등의 구성원들이 컴퓨터로 연결된 작업장에서 서로 협력하여 업무를 수행하는 그룹 작업을 지원하는 시스템', '메신저, 전자결재, 메일, 일정공유, 업무관리, 게시판, 문서공유, 근태/급여 확인, 증명서 발급', 'https://gw.iwin.kr/', '../img/gw.PNG', [
            ['해외법인주소', 'https://gw.iwin.kr/gw/bizboxLink.do?url=%2Fedms%2Fboard%2FviewPost.do%3FartNo%3D102365%26boardNo%3D900004904'],
            ['주요일일지표', 'https://gw.iwin.kr/gw/bizboxLink.do?url=%2Fedms%2Fboard%2FviewPost.do%3FartNo%3D102296%26boardNo%3D900004904']
        ]],
        ['PDM (Product Data Managemnet)', '개발 중인 제품과 관련 정보를 일괄적으로 취합해 관리하는 시스템', '설계변경(ECO, ECR), 도면/문서 버전관리, BOM, 생산이관', 'https://pdm.iwin.kr', '../img/pdm.PNG', [], '보통 PLM이라고 부르지만 당사는 Lifecycle 즉 설계/제품 수명주기까지 관리하기에 벅차 해당 모듈을 제외하여 PDM이라고 명명함'],
        ['ERP (Enterprise Resource Planning)', '기업 내 생산, 물류, 재무, 회계, 영업, 구매, 재고 등 경영 활동 프로세스들을 통합적으로 연계하는 통합정보 시스템', '인사/회계/영업/구매/자재/무역/생산/외주/원가 관리', null, '../img/erp.png', [], 'setup파일로 설치 후 접속설정에 의해 외부(해외포함)에서도 접속가능함'],
        ['SCM (supply chain management)', '협력사의 생산품(원자재)을 원하는 시간과 장소에 제공을 요구하는 공급망 관리 시스템', '발주현황, 납품계획, 납품관리, 납품현황', 'https://scm.iwin.kr', '../img/scm.PNG', [
            ['자재주문서 양식 변경', 'https://gw.iwin.kr/gw/bizboxLink.do?url=%2Fedms%2Fboard%2FviewPost.do%3FartNo%3D102635%26boardNo%3D900004904'],
            ['거래명세서 양식 추가', 'https://gw.iwin.kr/edms/board/viewPost.do?artNo=102644&boardNo=900004904']
        ]],
        ['FMS (Facility Management System)', '자체 개발한 서비스 제공', '차량, 검사기, 현장, 창고(POP - Point Of Production), 경영, 경비, 내부회계, 자동화 등', 'https://fms.iwin.kr', '../img/fms.png', [
            ['http2', 'https://gw.iwin.kr/gw/bizboxLink.do?url=%2Fedms%2Fboard%2FviewPost.do%3FartNo%3D102527%26boardNo%3D900005236']
        ], '최초에 법인차를 전사적으로 관리하기 위해 개발한 서비스라 FMS로 명명하였는데 이후 현장, 경영 등 다양한 서비스들이 추가되면서 FMS의 뜻과 알맞지는 않음'],
        ['SPAMOUT', '스팸메일 필터링 서비스 제공', '스팸메일 규칙 업데이트, 필터관리, 메일관리 등', 'http://spamout.iwin.kr', '../img/spamout.PNG', []],
        ['NAS (Network Attached Storage)', '네트워크(인터넷)으로 접속하여 데이터에 접근하는 파일서버', '파일공유, 백업', 'https://nas.iwin.kr', '../img/nas.PNG', [
            ['베트남 나스 동기화', 'https://gw.iwin.kr/gw/bizboxLink.do?url=%2Fedms%2Fboard%2FviewPost.do%3FartNo%3D101851%26boardNo%3D900005236'],
            ['시점복구 안내', 'https://gw.iwin.kr/gw/bizboxLink.do?url=%2Fedms%2Fboard%2FviewPost.do%3FartNo%3D102297%26boardNo%3D900005236'],
            ['신규 서비스 (나스 내부 폴더 동기화)', 'https://gw.iwin.kr/gw/bizboxLink.do?url=%2Fedms%2Fboard%2FviewPost.do%3FartNo%3D102631%26boardNo%3D900005236'],
            ['양방향 동기화 (한국-베트남)', 'https://gw.iwin.kr/gw/bizboxLink.do?url=%2Fedms%2Fboard%2FviewPost.do%3FartNo%3D102477%26boardNo%3D900003790']
        ]],
        ['SVN (Source Version Control System)', '서로 다른 버전으로 작업하는 불상사가 발생하지 않도록 최신 파일 동기화 서비스 제공', '소스 버전 관리', 'http://192.168.0.202:8880/svnadmin/login.php', '../img/svn.png', [], '기술연구소 ECU 펌웨어 코딩소스 관리를 목적으로 하는 시스템'],
        ['Vaultwarden', '계정/비밀번호 동기화 서비스 제공', '로그인/카드/신원 정보 관리', 'https://password.iwin.kr/', '../img/vaultwarden.PNG', []],
        ['냉난방기', '냉난방기 중앙제어 서비스 제공', '냉난방기 제어 및 통제, 스케쥴 제어, 에너지사용량 확인', null, '../img/ACP5.PNG', [], '3층 기술연구소 내부 냉난방기는 제어 안됨', [
            ['내부접속1', 'http://control1.iwin.kr'],
            ['내부접속2', 'http://control2.iwin.kr']
        ]],
        ['Zabbix', '수많은 종류의 네트워크, 서버 등을 감시, 추적하여 관리자에게 장애 발생을 신속하게 알리는 서비스 제공', '장애알림, CPU/RAM 사용률 확인', 'http://server.iwin.kr/zabbix/index.php', '../img/ZABBIX.PNG', [], '내부에서만 접속 가능'],
    ];
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

        <!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">전산 보고서</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">서버</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">개발</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4;?>" id="tab-four" data-toggle="pill" href="#tab4">자산</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="tab-five" data-toggle="pill" href="#tab5">유지</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab6;?>" id="tab-six" data-toggle="pill" href="#tab6">웹서비스</a>
                                        </li> 
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 공지!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 전산 보고서<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 경영팀<br><br>

                                            [제작일]<BR>
                                            - 24.02.13<br><br>  
                                        </div>

                                        <!-- 2번째 탭 서버!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->   
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpane2" aria-labelledby="tab-two">
                                            <!-- #1.참조!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">#1. 참조</h6>
                                                    </a> 
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample11">
                                                        <div class="card-body table-responsive p-2">  
                                                            - 25년 2월 기준<br>       
                                                            <br>
                                                            [가상화]<br>
                                                            - 이전에는 서비스당 실물 서버컴퓨터 1대씩 구매해야 했음<br>
                                                            - 가상화는 실물 서버컴퓨터 1대에 운영체제를 여러개 설치하여 여러개의 서비스를 동시에 운영할 수 있음<br>
                                                            - Vmware 사용<br>
                                                            <br>
                                                            [운영체제]<br>
                                                            - 중요도가 높은 서버에 한하여 최신 운영체제로 교체하였음<br>
                                                            - 운영체제는 지속적인 보안 업데이트를 제공하기 때문에 중요도가 높은 서버는 최신 운영체제를 유지하는 것이 중요함<br>
                                                            - PDM에서 사용하는 데이터베이스 오라클11g가 Window Server 2019까지 호환됨<br>
                                                            <br>
                                                            [서버백신]<br>
                                                            - 운영체제가 윈도우인 서버중 운영체제 서비스가 종료되어 보안이 취약하거나 중요도가 높은 서버 위주로 설치함<br>
                                                            <br>  
                                                        </div>
                                                    </div>                                                  
                                                </div>
                                                <!-- /.card -->
                                            </div>                                        

                                            <!-- #2.서버!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">#2. 서버</h6>
                                                    </a>  
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample22">
                                                        <div class="card-body table-responsive p-2">  
                                                            <div id="table" class="table-editable"> 
                                                                <table class="table table-bordered" id="table1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center;">서버명</th>
                                                                            <th style="text-align: center;">제공서비스</th>
                                                                            <th style="text-align: center;">보조설명</th>
                                                                            <th style="text-align: center;">가상화</th>
                                                                            <th style="text-align: center;">백신</th>
                                                                            <th style="text-align: center;">운영체제</th>
                                                                            <th style="text-align: center;">운영체제(연장)종료일</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                        <?php foreach ($servers as $server): ?>
                                                                        <tr style="text-align: center;">
                                                                            <td><?php echo h($server[0]); ?></td>
                                                                            <td><?php echo h($server[1]); ?></td>
                                                                            <td><?php echo h($server[2]); ?></td>
                                                                            <td><?php echo h($server[3]); ?></td>
                                                                            <td><?php echo h($server[4]); ?></td>
                                                                            <td><?php echo h($server[5]); ?></td>
                                                                            <td><?php echo h($server[6]); ?></td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card -->
                                            </div>                                        
                                        
                                            <!-- #3.서버랙 실장도!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample23" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample23">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">#3. 서버랙 실장도</h6>
                                                    </a>  
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample23">
                                                        <div class="card-body table-responsive p-2">    
                                                            <img src='../img/server rack.png' style='width: 100%; height: 100%'>    
                                                        </div>
                                                    </div>                                            
                                                </div>
                                                <!-- /.card -->
                                            </div>                                              
    
                                            <!-- #4.NAS구성도!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12" > 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample24" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample24">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">#4. NAS구성도</h6>
                                                    </a> 
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample24" >
                                                        <div class="card-body table-responsive p-2" style='text-align: center;'> 

                                                            <img src='../img/server block.png' style='width: 60%; height: 60%'>   
                                                        </div>
                                                    </div>                                      
                                                </div>
                                                <!-- /.card -->
                                            </div>                                           
                                        </div>      

                                        <!-- 3번째 탭 개발(이전POP)!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpane3" aria-labelledby="tab-three">  
                                            <h1 class="h3 text-gray-800" style="padding-top:0em; padding-bottom:0em; display:inline-block; vertical-align:-4px;">#1. 한국공장 pop 시스템 개발 실적</h1> <BR>
                                            <h7 class="h7 text-gray-800" style="padding-top:0em; padding-bottom:0em; display:inline-block; vertical-align:-4px;">- 개발완료: BB입고/출고, 완성품입고/출하, ECU입고/출고, 검사/포장실적, 마스크입고/출하</h7> <BR>
                                            <div style="width: 100%; position: relative; margin: 0px auto;">  
                                                <div style="width: 100%;">  
                                                    <img src="../img/factory.jpg">
                                                </div>
                                                <div style="position: absolute; top: 0px; left: 610px;">  
                                                    <video autoplay loop muted poster="bb_in" style="width: 600px; height: 200px;">
                                                        <source src="../img/bb_in.mp4" type="video/mp4" >
                                                    </video>
                                                </div>
                                                <div style="position: absolute; top: 0px; left: 1140px;">  
                                                    <video autoplay loop muted poster="finished_output" style="width: 600px; height: 200px;">
                                                        <source src="../img/finished_output.mp4" type="video/mp4" >
                                                    </video>
                                                </div>
                                                <div style="position: absolute; top: 180px; left: 1020px;">  
                                                    <video autoplay loop muted poster="finished_in" style="width: 300px; height: 150px;">
                                                        <source src="../img/finished_in.mp4" type="video/mp4" >
                                                    </video>
                                                </div>
                                                <div style="position: absolute; top: 490px; left: 1035px;">  
                                                    <video autoplay loop muted poster="ecu_inout" style="width: 600px; height: 200px;">
                                                        <source src="../img/ecu_inout.mp4" type="video/mp4" >
                                                    </video>
                                                </div>
                                            </div>
                                        </div> 

                                        <!-- 4번째 탭 자산 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="tab4" role="tabpane4" aria-labelledby="tab-four">
                                            <h1 class="h5 mb-0 text-gray-800" style="padding-top:1em; padding-left:1em; padding-bottom:1em; display:inline-block; vertical-align:-4px;">1. H/W</h1>               
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <!-- 보드그룹1 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                                <?php
                                                    $hw_assets = [
                                                        ['노트북', $row_n['N'] ?? 0, 'primary', 'fa-laptop'],
                                                        ['데스크탑', $row_d['D'] ?? 0, 'success', 'fa-laptop'],
                                                        ['워크스테이션', $row_w['W'] ?? 0, 'info', 'fa-laptop'],
                                                        ['미니pc', $row_m['M'] ?? 0, 'warning', 'fa-laptop'],
                                                        ['모니터', $row_mo['mo'] ?? 0, 'primary', 'fa-tv'],
                                                        ['AP', $row_ap['ap'] ?? 0, 'success', 'fa-wifi'],
                                                        ['라벨프린터', $row_l['l'] ?? 0, 'info', 'fa-print'],
                                                        ['의자', $row_c['c'] ?? 0, 'warning', 'fa-chair'],
                                                        ['키오스크', $row_k['k'] ?? 0, 'primary', 'fa-barcode'],
                                                        ['PDA', $row_pda['PDA'] ?? 0, 'success', 'fa-qrcode'],
                                                    ];
                                                ?>
                                                <?php foreach ($hw_assets as $asset): ?>
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-<?php echo h($asset[2]); ?> shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-<?php echo h($asset[2]); ?> text-uppercase mb-1"><?php echo h($asset[0]); ?></div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($asset[1]); ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas <?php echo h($asset[3]); ?> fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>

                                            </div>
                                            <!-- /.row -->


                                            <h1 class="h5 mb-0 text-gray-800" style="padding-top:1em; padding-left:1em; padding-bottom:1em; display:inline-block; vertical-align:-4px;">2. Window</h1>               
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <?php
                                                    $sw_assets_win = [
                                                        ['Window7 HOME', $row_w7h['W7H'] ?? 0, 'primary'],
                                                        ['Window7 PRO', $row_w7p['W7P'] ?? 0, 'success'],
                                                        ['Window10 HOME', $row_w10h['W10H'] ?? 0, 'info'],
                                                        ['Window10 PRO', $row_w10p['W10P'] ?? 0, 'warning'],
                                                        ['Window11 PRO', $row_w11p['W11P'] ?? 0, 'primary'],
                                                    ];
                                                ?>
                                                <?php foreach ($sw_assets_win as $asset): ?>
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-<?php echo h($asset[2]); ?> shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-<?php echo h($asset[2]); ?> text-uppercase mb-1"><?php echo h($asset[0]); ?></div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($asset[1]); ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fab fa-windows fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>

                                            </div>
                                            <!-- /.row -->


                                            <h1 class="h5 mb-0 text-gray-800" style="padding-top:1em; padding-left:1em; padding-bottom:1em; display:inline-block; vertical-align:-4px;">3. Office</h1>               
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <?php
                                                    $sw_assets_office = [
                                                        ['Office 2007', $row_o2007['O2007'] ?? 0, 'primary'],
                                                        ['Office 2010', $row_o2010['O2010'] ?? 0, 'success'],
                                                        ['Office 2013', $row_o2013['O2013'] ?? 0, 'info'],
                                                        ['Office 2021', $row_o2021['O2021'] ?? 0, 'warning'],
                                                    ];
                                                ?>
                                                <?php foreach ($sw_assets_office as $asset): ?>
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-<?php echo h($asset[2]); ?> shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-<?php echo h($asset[2]); ?> text-uppercase mb-1"><?php echo h($asset[0]); ?></div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo h($asset[1]); ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-file-excel fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>

                                            </div>
                                            <!-- /.row -->                                         
                                        </div>       

                                        <!-- 5번째 탭 유지(지출) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="tab5" role="tabpane5" aria-labelledby="tab-five">
                                            <!-- 참조!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample51">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">#1. 참조</h6>
                                                    </a>                                                    
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample51">
                                                        <div class="card-body table-responsive p-2">  
                                                            - 26년 1월 기준<br>
                                                            <br>
                                                            [알약]<br>
                                                            - 제일 저렴한 카스퍼스키 러시아 백신을 사용하다가 우크라이나 전쟁 때 외산 백신 백도어 이슈로 국산 백신으로 교체함<br>
                                                            - 아이윈오토도 카스퍼스키에서 알약으로 모두 교체함<br>
                                                            - 국제 3대 보안인증 중 VB100, ICSA 받은 것을 확인함<br>
                                                            <br>
                                                            [SSL 인증서]<br>
                                                            - 보안인증서를 도입하고 싶었지만 비용으로 인하여 도입이 연기되고 있었음<br>
                                                            - forvia 고객사에서 메일 수신 시 반드시 SSL 인증서를 사용하는 업체의 메일만 받는 이슈가 있어 SSL 인증서를 도입하게 됨<br>
                                                            - iSafe제품의 DV 인증서<br>
                                                            - Wildcard 기능을 선택함 (특정 도메인에 대해 호스트 무한으로 사용가능)<br>
                                                            <br>
                                                            [네트워크, 서버 유지보수]<br>
                                                            - 레노버 가상화 서버를 사용하고 있음<br>
                                                            - 레노버는 유지보수 계약을 지속적으로 맺지 않으면 내부부품을 교환해야 하는 문제가 발생했을 때 해당 부품을 납품하지 않음<br>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>                                        
                                        
                                            <!-- 지출리스트!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample52" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample52">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">#2. 지출리스트</h6>
                                                    </a>                                                    
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample52">
                                                        <div class="card-body table-responsive p-2">  
                                                            <div id="table" class="table-editable"> 
                                                                <table class="table table-bordered" id="table6">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center;">내용</th>
                                                                            <th style="text-align: center;">주기</th>
                                                                            <th style="text-align: center;">만료일</th>
                                                                            <th style="text-align: center;">금액(VAT별도)</th>
                                                                            <th style="text-align: center;">비고</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                        <?php foreach ($maintenance_costs as $cost): ?>
                                                                        <tr style="text-align: center;">
                                                                            <td><?php echo h($cost[0]); ?></td>
                                                                            <td><?php echo h($cost[1]); ?></td>
                                                                            <td><?php echo h($cost[2]); ?></td>
                                                                            <td><?php echo h($cost[3]); ?></td>
                                                                            <td><?php echo h($cost[4]); ?></td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                        <tr>
                                                                            <td colspan="3" style="vertical-align: middle; text-align: center;">1년 지출 금액</td>
                                                                            <td colspan="2" style="vertical-align: middle; text-align: center;">90,376,192</td>
                                                                        </tr>                                                                                                                                        
                                                                    </tbody>
                                                                </table> 
                                                            </div> 
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                        </div>    
                                        
                                        <!-- 6번째 탭 웹서비스!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->   
                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="tab6" role="tabpane6" aria-labelledby="tab-six">
                                            <?php foreach ($web_services as $index => $service): ?>
                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample6<?php echo $index + 1; ?>" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample6<?php echo $index + 1; ?>">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">#<?php echo $index + 1; ?>. <?php echo h($service[0]); ?></h1>
                                                    </a>
                                                    <div class="collapse" id="collapseCardExample6<?php echo $index + 1; ?>">
                                                        <div class="card-body table-responsive p-2">
                                                            <br>
                                                            - 설명: <?php echo h($service[1]); ?><br>
                                                            - 서비스: <?php echo h($service[2]); ?><br>
                                                            <?php if (!empty($service[3])): ?>
                                                                - URL: <a href='<?php echo h($service[3]); ?>' target='_blank'><?php echo h($service[3]); ?></a><br>
                                                            <?php endif; ?>
                                                            <?php if (isset($service[7]) && is_array($service[7])): ?>
                                                                - URL:
                                                                <?php foreach ($service[7] as $link): ?>
                                                                    <a href='<?php echo h($link[1]); ?>' target='_blank'><?php echo h($link[0]); ?>(내부에서만 접속 가능)</a>
                                                                <?php endforeach; ?><br>
                                                            <?php endif; ?>
                                                            <?php if (!empty($service[6])): ?>
                                                                - 참조: <?php echo h($service[6]); ?><br>
                                                            <?php endif; ?>
                                                            <?php if (!empty($service[5])): ?>
                                                                - 관련 게시물 링크 :<br>
                                                                <?php foreach ($service[5] as $linkIndex => $link): ?>
                                                                    &nbsp;&nbsp;<?php echo $linkIndex + 1; ?>.&nbsp;&nbsp;<a href='<?php echo h($link[1]); ?>' target='_blank'><?php echo h($link[0]); ?></a><br>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                            <br>
                                                            <img src='<?php echo h($service[4]); ?>' style='width: 100%; height: 100%'>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>   

                        <!-- end !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                    
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

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) {
    mysqli_close($connect4);
}	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>
