<?php 
    // =============================================
	// Author:		<KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.03.30>
	// Description:	<finished 뷰어>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    include 'finished_view_status.php';
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
    <meta http-equiv="refresh" content="300;"> 
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

                    <!-- Begin row -->
                    <div class="row">                        
                        <div class="col-lg-12 mt-2"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                    <h6 class="m-0 font-weight-bold text-primary">출고 (<?php echo $DT; ?> 기준)</h6>
                                </a>

                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample21">
                                    <div class="card-body">
                                        <div class="row"> 
                                            <!-- 보드1-1 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">지입기사</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">옥해종</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드1-2 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">출하오더(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order11['QT_GOODS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드1-3 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">출하실적(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order12['PCS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드1-4 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">출문</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo (isset($Data_Order13) && isset($Data_Order13['RECORD_DATE'])) ? date_format(date_create($Data_Order13['RECORD_DATE']), 'H:i:s') : 'X'; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 
                                        
                                        <div class="row"> 
                                            <!-- 보드2-1 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">지입기사</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">손규백</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드2-2 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">출하오더(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order21['QT_GOODS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드2-3 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">출하실적(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order22['PCS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드2-4 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">출문</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo (isset($Data_Order23) && isset($Data_Order23['RECORD_DATE'])) ? date_format(date_create($Data_Order23['RECORD_DATE']), 'H:i:s') : 'X'; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>     

                                        <div class="row"> 
                                            <!-- 보드3-1 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">지입기사</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">최기완</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드3-2 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">출하오더(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order31['QT_GOODS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드3-3 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">출하실적(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order32['PCS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드3-4 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">출문</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo (isset($Data_Order33) && isset($Data_Order33['RECORD_DATE'])) ? date_format(date_create($Data_Order33['RECORD_DATE']), 'H:i:s') : 'X'; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>     

                                        <div class="row"> 
                                            <!-- 보드4-1 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">지입기사</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">조근선</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드4-2 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">출하오더(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order41['QT_GOODS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드4-3 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">출하실적(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order42['PCS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드4-4 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">출문</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo (isset($Data_Order43) && isset($Data_Order43['RECORD_DATE'])) ? date_format(date_create($Data_Order43['RECORD_DATE']), 'H:i:s') : 'X'; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>  
                                        
                                        <div class="row"> 
                                            <!-- 보드5-1 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">지입기사</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">박정민</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드5-2 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">출하오더(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order51['QT_GOODS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드5-3 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">출하실적(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order52['PCS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드5-4 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">출문</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo (isset($Data_Order53) && isset($Data_Order53['RECORD_DATE'])) ? date_format(date_create($Data_Order53['RECORD_DATE']), 'H:i:s') : 'X'; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 

                                        <div class="row"> 
                                            <!-- 보드6-1 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">지입기사</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">김영민</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드6-2 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">출하오더(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order61['QT_GOODS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드6-3 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">출하실적(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order62['PCS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드6-4 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">출문</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo (isset($Data_Order63) && isset($Data_Order63['RECORD_DATE'])) ? date_format(date_create($Data_Order63['RECORD_DATE']), 'H:i:s') : 'X'; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 

                                        <div class="row"> 
                                            <!-- 보드7-1 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">지입기사</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">기타</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드7-2 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">출하오더(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order71['QT_GOODS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드7-3 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">출하실적(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order72['PCS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드7-4 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">출문</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "X"; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 

                                        <div class="row"> 
                                            <!-- 보드8-1 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">지입기사</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">천안</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-user fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드8-2 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-primary shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">출하오더(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order81['QT_GOODS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드8-3 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-info shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">출하실적(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order82['PCS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- 보드8-4 -->
                                            <div class="col-xl-3 col-md-3 mb-2">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">출문</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "X"; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 

                                        <div class="row"> 
                                            <!-- 보드9-1 -->
                                            <div class="col-xl-6 col-md-6 mb-2">
                                                <div class="card border-left-danger shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="h5 mt-2 mb-0 font-weight-bold text-gray-800">합계</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-shipping-fast fa-2x text-gray-300 mt-2"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- 보드9-2 -->
                                            <div class="col-xl-6 col-md-6 mb-2">
                                                <div class="card border-left-danger shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">출하실적(PCS)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Data_Order92['PCS']; ?></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                             
                                        </div> 

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.Card Content - Collapse -->                                                                                   
                            </div>
                            <!-- /.card -->
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