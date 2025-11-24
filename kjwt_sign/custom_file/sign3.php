<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.10.17>
	// Description:	<회람 전산화>
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
                        인권침해 예방교육
                        </div>
                        <div class="col-lg-12 py-3" style="text-align: right; font-weight: bold; font-size: 20px;"> 
                        2023.  1.  11.  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="col-lg-12"> 
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

                                        for($i=1; $i<=$Count_Sign; $i++)
                                        {		
                                            $Query_SignF = "SELECT * from CONNECT.dbo.SIGN WHERE NO='$i'";              
                                            $Result_SignF = sqlsrv_query($connect, $Query_SignF, $params, $options);
                                            $Data_SignF = sqlsrv_fetch_array($Result_SignF);  

                                            //GW사번 추출
                                            $Query_EMP = "SELECT * FROM t_co_emp_multi where lang_code='kr' and emp_name='$Data_SignF[NAME]'";
                                            $Result_EMP = $connect3->query($Query_EMP);
                                            $Data_EMP = mysqli_fetch_array($Result_EMP); 

                                            //GW sign id 추출
                                            $Query_SignID = "SELECT * FROM t_co_emp where emp_seq='$Data_EMP[emp_seq]'";
                                            $Result_SignID = $connect3->query($Query_SignID);
                                            $Data_SignID = mysqli_fetch_array($Result_SignID); 
                                            
                                            if($i==1) {
                                                $j=$Count_Sign+1;
                                            }
                                            else {
                                                $j=$j+1;
                                            }

                                            $Query_SignS = "SELECT * from CONNECT.dbo.SIGN where NO='$j'";              
                                            $Result_SignS = sqlsrv_query($connect, $Query_SignS, $params, $options);	
                                            $Data_SignS = sqlsrv_fetch_array($Result_SignS);  
                                            
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
                                            <td><?php echo $Data_SignF['NO']; ?></td> 
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
                                            <td><?php echo $Data_SignS['NO']; ?></td> 
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