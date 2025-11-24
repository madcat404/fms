<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.3.13>
	// Description:	<취업규칙 의견서>
	// =============================================
    include 'sign_status.php';
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
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">           

                    <!-- Begin row -->
                    <div class="row"> 
                        <div class="col-lg-12 pt-5" style="text-align: center; font-weight: bold; font-size: 50px;"> 
                        취업규칙 의견청취서
                        </div>
                        <br>
                        <div class="col-lg-12 py-3" style="text-align: left; font-size: 20px; padding-left: 10%; padding-right: 10%;"> 
                        2025년 5월 20일자로 제시된 취업규칙에 대하여 다음과 같이 의견청취 여부에 대한 확인서를 제출합니다.
                        </div>
                        <br>
                        <div class="col-lg-12" style="padding-left: 10%; padding-right: 10%;"> 
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>이름</th>
                                        <th>서명</th> 
                                        <th>NO</th>
                                        <th>이름</th>
                                        <th>서명</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php    
                                        $flag=0;
                                        $complete_flag=0;
                                        $NO=1;

                                        for($i=1; $i<=$Count_Sign; $i += 2)
                                        {		
                                            $Data_SignF = sqlsrv_fetch_array($Result_Sign); 
                                            $Data_SignS = sqlsrv_fetch_array($Result_Sign); // 두 번째 데이터

                                            $Query_SignFLog = "SELECT * from CONNECT.dbo.SIGN_LOG WHERE TITLE='$Data_SignSelect[TITLE]' AND NAME='$Data_SignF[NAME]'";              
                                            $Result_SignFLog = sqlsrv_query($connect, $Query_SignFLog, $params, $options);
                                            $Count_SignFLog = sqlsrv_num_rows($Result_SignFLog);  

                                            //GW사번 추출
                                            $Query_EMP = "SELECT * FROM t_co_emp_multi where lang_code='kr' and emp_name='$Data_SignF[NAME]'";
                                            $Result_EMP = $connect3->query($Query_EMP);
                                            $Data_EMP = mysqli_fetch_array($Result_EMP); 

                                            //GW sign id 추출
                                            $Query_SignID = "SELECT * FROM t_co_emp where emp_seq='$Data_EMP[emp_seq]'";
                                            $Result_SignID = $connect3->query($Query_SignID);
                                            $Data_SignID = mysqli_fetch_array($Result_SignID); 

                                            $Query_SignSLog = "SELECT * from CONNECT.dbo.SIGN_LOG WHERE TITLE='$Data_SignSelect[TITLE]' AND NAME='$Data_SignS[NAME]'";              
                                            $Result_SignSLog = sqlsrv_query($connect, $Query_SignSLog, $params, $options);
                                            $Count_SignSLog = sqlsrv_num_rows($Result_SignSLog); 

                                            //GW사번 추출
                                            $Query_EMP2 = "SELECT * FROM t_co_emp_multi where lang_code='kr' and emp_name='$Data_SignS[NAME]'";
                                            $Result_EMP2 = $connect3->query($Query_EMP2);
                                            $Data_EMP2 = mysqli_fetch_array($Result_EMP2); 

                                            //GW sign id 추출
                                            $Query_SignID2 = "SELECT * FROM t_co_emp where emp_seq='$Data_EMP2[emp_seq]'";
                                            $Result_SignID2 = $connect3->query($Query_SignID2);
                                            $Data_SignID2 = mysqli_fetch_array($Result_SignID2); 

                                            
                                    ?>                                                                            
                                        <tr> 
                                            <?PHP   
                                            IF($Data_SignF['USE_YN2']=='Y') {
                                            ?>
                                            <td><?php echo $NO; ?></td> 
                                            <td><?php echo $Data_SignF['NAME']; ?></td>   
                                            <td>
                                                <?php 
                                                    if($Data_SignF['CONDITION']!='') {
                                                        echo $Data_SignF['CONDITION'];
                                                    }
                                                    elseif($Data_SignF['CONDITION']=='' and $Data_SignID['sign_file_id']!='') {
                                                        if($flag=='1' and $complete_flag=='0') {
                                                ?>         
                                                            <img src="https://gw.iwin.kr/gw/cmm/file/fileDownloadProc.do?fileId=fbbd8c52910a11ef93fc0894ef5ddfbe&fileSn=0" style="width: 40px; height: 30px;">                                                                                                                                              
                                                <?php 
                                                            $complete_flag=1;
                                                        }                                                        
                                                        else {
                                                ?>                                                                                            
                                                            <img src="https://gw.iwin.kr/gw/cmm/file/fileDownloadProc.do?fileId=<?php echo $Data_SignID['sign_file_id']; ?>&fileSn=0" style="width: 40px; height: 30px;">
                                                <?php 
                                                        }
                                                    }
                                                    elseif($Data_SignF['NAME']=='김창복') {
                                                ?>     
                                                        <img src="https://fms.iwin.kr/img/gongmu.png" style="width: 40px; height: 30px;">    
                                                <?php 
                                                    }

                                                    if($Data_SignF['NAME']=='김대현') {
                                                        $flag=1;
                                                    }
                                                ?>
                                            </td>   
                                            <?PHP
                                            $NO=$NO+1;
                                            }
                                            
                                            IF($Data_SignS['USE_YN2']=='Y') {
                                            ?>
                                            <td><?php echo $NO; ?></td> 
                                            <td><?php echo $Data_SignS['NAME']; ?></td>   
                                            <td>
                                                <?php 
                                                    if($Data_SignS['CONDITION']!='') {
                                                        echo $Data_SignS['CONDITION'];
                                                    }
                                                    elseif($Data_SignS['CONDITION']=='' and $Data_SignID2['sign_file_id']!='') {
                                                ?>                                                                                            
                                                        <img src="https://gw.iwin.kr/gw/cmm/file/fileDownloadProc.do?fileId=<?php echo $Data_SignID2['sign_file_id']; ?>&fileSn=0" style="width: 40px; height: 30px;">
                                                <?php 
                                                    }
                                                ?>
                                            </td> 
                                            <?PHP
                                            $NO=$NO+1;
                                            }
                                            ?> 
                                        </tr>                                                                           
                                    <?php                                                                                    
                                            if($Data_SignS['NO'] == '') {
                                                exit;
                                            }
                                        }   
                                    ?>                     
                                </tbody>
                            </table>                     
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
    if(isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>