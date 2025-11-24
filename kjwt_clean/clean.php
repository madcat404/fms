<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.07.17>
	// Description:	<미화원 실적>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
	// =============================================
    include 'clean_status.php';
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">미화원 실적</h1>
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
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">청소</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 미화원 청소 실적 전산화<BR><BR>

                                            [히스토리]<BR>
                                            25.07.18)<BR>
                                            - 미화원의 뚜꺼운 핸드폰케이스를 사용하여 nfc 인식이 안됨 (일단 사용 보류)<BR><BR>

                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트<br>
                                            - 사용자: 미화원<br>  <BR>                                          

                                            [제작일]<BR>
                                            - 25.07.17<br><br>                                        
                                        </div>

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <?php  
                                                if(isMobile()) {  
                                            ?>
                                            <p>※ 청소시간은 PC로 확인 가능합니다!</p>
                                            <table class="table table-bordered col-lg-12">
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">위치</th>
                                                    <th style="text-align: center; vertical-align: middle;">청소</th>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">현장 화장실1</th>  
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC11' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC1_TIME']) ? 'checked' : ''; ?> disabled></td>  
                                                    </td>                                                                                                                                          
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">현장 화장실2</th>  
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC21' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC2_TIME']) ? 'checked' : ''; ?> disabled></td>  
                                                    </td>                                                                                     
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">1층 화장실</th>  
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC31' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC3_TIME']) ? 'checked' : ''; ?> disabled></td>  
                                                    </td>                                                                                      
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">2층 화장실</th>  
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC41' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC4_TIME']) ? 'checked' : ''; ?> disabled></td>  
                                                    </td>                                                                                      
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">3층 화장실</th>  
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC51' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC5_TIME']) ? 'checked' : ''; ?> disabled></td>  
                                                    </td>                                                                                       
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">3층 샤워장/화장실</th>  
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC61' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC6_TIME']) ? 'checked' : ''; ?> disabled></td>  
                                                    </td>                                                                                      
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;">기숙사</th>  
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <input type='checkbox' name='NFC71' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC7_TIME']) ? 'checked' : ''; ?> disabled></td>  
                                                    </td>                                                                                      
                                                </tr> 
                                            </table>

                                        
                                            <?php  
                                                } else {  
                                            ?>
                                            <!-- 청소!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">청소</h6>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample31">
                                                        <div class="card-body table-responsive p-2">  
                                                            <div id="table" class="table-editable"> 
                                                                <table class="table table-bordered" id="table6">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center;">구분</th>
                                                                            <th style="text-align: center;">NFC 위치</th>
                                                                            <th style="text-align: center;">청소</th>
                                                                            <th style="text-align: center;">청소시간</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                        <tr>
                                                                            <td rowspan="7" style="vertical-align: middle; text-align: center;">NFC</td>  
                                                                            <td>현장 화장실1</td>   
                                                                            <td style="text-align: center;">
                                                                                <input type='checkbox' name='NFC1' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC1']) && $Data_Clean['NFC1']=='on' ? 'checked' : ''; ?> disabled></td>  
                                                                            <td><?php echo !empty($Data_Clean['NFC1_TIME']) ? $Data_Clean['NFC1_TIME']->format('Y-m-d H:i:s') : ''; ?></td>                          
                                                                        </tr>   
                                                                        <tr>
                                                                            <td>현장 화장실2</td> 
                                                                            <td style="text-align: center;">
                                                                                <input type='checkbox' name='NFC2' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC2']) && $Data_Clean['NFC2']=='on' ? 'checked' : ''; ?> disabled></td>  
                                                                            <td><?php echo !empty($Data_Clean['NFC2_TIME']) ? $Data_Clean['NFC2_TIME']->format('Y-m-d H:i:s') : ''; ?></td>                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1층 화장실</td> 
                                                                            <td style="text-align: center;">
                                                                                <input type='checkbox' name='NFC3' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC3']) && $Data_Clean['NFC3']=='on' ? 'checked' : ''; ?> disabled></td>  
                                                                            <td><?php echo !empty($Data_Clean['NFC3_TIME']) ? $Data_Clean['NFC3_TIME']->format('Y-m-d H:i:s') : ''; ?></td>                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2층 화장실</td> 
                                                                            <td style="text-align: center;">
                                                                                <input type='checkbox' name='NFC4' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC4']) && $Data_Clean['NFC4']=='on' ? 'checked' : ''; ?> disabled></td>  
                                                                            <td><?php echo !empty($Data_Clean['NFC4_TIME']) ? $Data_Clean['NFC4_TIME']->format('Y-m-d H:i:s') : ''; ?></td>                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3층 화장실</td> 
                                                                            <td style="text-align: center;">
                                                                                <input type='checkbox' name='NFC5' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC5']) && $Data_Clean['NFC5']=='on' ? 'checked' : ''; ?> disabled></td>  
                                                                            <td><?php echo !empty($Data_Clean['NFC5_TIME']) ? $Data_Clean['NFC5_TIME']->format('Y-m-d H:i:s') : ''; ?></td>                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3층 샤워장/화장실</td> 
                                                                            <td style="text-align: center;">
                                                                                <input type='checkbox' name='NFC6' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC6']) && $Data_Clean['NFC6']=='on' ? 'checked' : ''; ?> disabled></td>  
                                                                            <td><?php echo !empty($Data_Clean['NFC6_TIME']) ? $Data_Clean['NFC6_TIME']->format('Y-m-d H:i:s') : ''; ?></td>                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>기숙사</td> 
                                                                            <td style="text-align: center;">
                                                                                <input type='checkbox' name='NFC7' style='zoom: 2;' <?php echo !empty($Data_Clean['NFC7']) && $Data_Clean['NFC7']=='on' ? 'checked' : ''; ?> disabled></td>  
                                                                            <td><?php echo !empty($Data_Clean['NFC7_TIME']) ? $Data_Clean['NFC7_TIME']->format('Y-m-d H:i:s') : ''; ?></td>                            
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
                                            <?php  
                                                }  
                                            ?>
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