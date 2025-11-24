<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.15>
	// Description:	<자산 리뉴얼>	
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
    include 'asset_status.php';   
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">자산</h1>
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
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">요약</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th">검색</a>
                                        </li> 
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 자산정보 공유<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 사무직<br><br>

                                            [제작일]<BR>
                                            - 21.11.15<br><br>                                            
                                        </div>
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">    
                                            <h1 class="h5 mb-0 text-gray-800" style="padding-top:1em; padding-left:1em; padding-bottom:1em; display:inline-block; vertical-align:-4px;">1. H/W</h1>               
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <!-- 보드그룹1 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                                <!-- 보드1 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">노트북</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_n['N']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-laptop fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드2 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-success shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">데스크탑</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_d['D']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-laptop fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드3 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-info shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">워크스테이션</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $row_w['W']; ?></div>
                                                                        </div>                                                
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-laptop fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드4 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-warning shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">미니pc</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_m['M']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-laptop fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드5 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">모니터</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_mo['mo']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-tv fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                 <!-- 보드6 -->
                                                 <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-success shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">AP</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_ap['ap']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-wifi fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드7 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-info shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">라벨프린터</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $row_l['l']; ?></div>
                                                                        </div>                                                
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-print fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드8 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-warning shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">의자</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_c['c']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-chair fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드9 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">키오스크</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_k['k']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-barcode fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드10 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-success shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">PDA</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_pda['PDA']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-qrcode fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- /.row -->


                                            <h1 class="h5 mb-0 text-gray-800" style="padding-top:1em; padding-left:1em; padding-bottom:1em; display:inline-block; vertical-align:-4px;">2. Window</h1>               
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <!-- 보드그룹2 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                                <!-- 보드1 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Window7 HOME</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_w7h['W7H']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fab fa-windows fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드2 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-success shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Window7 PRO</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_w7p['W7P']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fab fa-windows fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드3 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-info shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Window10 HOME</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $row_w10h['W10H']; ?></div>
                                                                        </div>                                                
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fab fa-windows fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드4 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-warning shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Window10 PRO</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_w10p['W10P']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fab fa-windows fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드5 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Window11 PRO</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_w11p['W11P']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fab fa-windows fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.row -->


                                            <h1 class="h5 mb-0 text-gray-800" style="padding-top:1em; padding-left:1em; padding-bottom:1em; display:inline-block; vertical-align:-4px;">3. Office</h1>               
                                            <!-- Begin row -->
                                            <div class="row"> 
                                                <!-- 보드그룹3 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                                <!-- 보드1 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Office 2007</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_o2007['O2007']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-file-excel fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드2 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-success shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Office 2010</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row_o2010['O2010']; ?></div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-file-excel fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 보드3 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-info shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Office 2013</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $row_o2013['O2013']; ?></div>
                                                                        </div>                                                
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-file-excel fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>   
                                                
                                                <!-- 보드4 -->
                                                <div class="col-xl-3 col-md-6 mb-2">
                                                    <div class="card border-left-warning shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Office 2021</div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col-auto">
                                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $row_o2021['O2021']; ?></div>
                                                                        </div>                                                
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-file-excel fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                            <!-- /.row -->      
                                        </div> 
                                        
                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->         
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="asset.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 사용자 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>사용자 이름 또는 자산번호</label>
                                                                            <div class="input-group">  
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="fas fa-qrcode"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="user31" autofocus>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 사용자 -->                                        
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form>     
                                                </div>
                                                <!-- /.card -->
                                            </div> 

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">   
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>자산번호</th>
                                                                        <th>사용자</th>
                                                                        <th>자산종류</th>   
                                                                        <th>IP</th> 
                                                                        <th>서브넷마스크</th>
                                                                        <th>게이트웨이</th>
                                                                        <th>DNS</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        if (isset($Result_SearchAsset)) {
                                                                            while($Data_SearchAsset = sqlsrv_fetch_array($Result_SearchAsset, SQLSRV_FETCH_ASSOC)) {
                                                                                $assetNum = htmlspecialchars($Data_SearchAsset['ASSET_NUM'], ENT_QUOTES, 'UTF-8');
                                                                                $user = htmlspecialchars($Data_SearchAsset['KJWT_USER'], ENT_QUOTES, 'UTF-8');
                                                                                $kind = htmlspecialchars($Data_SearchAsset['KIND'], ENT_QUOTES, 'UTF-8');
                                                                                $ip = htmlspecialchars($Data_SearchAsset['IP'], ENT_QUOTES, 'UTF-8');
                                                                                
                                                                                $gateway = '';
                                                                                if (strpos($ip, '192.168.0.') === 0) {
                                                                                    $gateway = '192.168.0.1';
                                                                                } elseif (strpos($ip, '192.168.2.') === 0) {
                                                                                    $gateway = '192.168.2.1';
                                                                                } elseif (strpos($ip, '192.168.3.') === 0) {
                                                                                    $gateway = '192.168.3.1';
                                                                                }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $assetNum; ?></td>  
                                                                        <td><?php echo $user; ?></td>  
                                                                        <td><?php echo $kind; ?></td>   
                                                                        <td><?php echo $ip; ?></td>  
                                                                        <td>255.255.255.0</td>  
                                                                        <td><?php echo $gateway; ?></td>  
                                                                        <td>192.168.100.8</td>  
                                                                    </tr> 
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>       
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>                                                                                
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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