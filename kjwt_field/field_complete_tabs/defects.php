<!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
<div class="col-lg-12"> 
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample41">
            <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample41">                                    
                <div class="card-body">
                    <!-- Begin row -->
                    <div class="row">                                                                        
                        <!-- Begin 검색범위 -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>검색범위</label>
                                <div class="input-group">                                                
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <?php 
                                        if($dt4!='') {
                                    ?>
                                            <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt4">
                                    <?php 
                                        }
                                        elseif($hidden_dt4!='') {
                                    ?>
                                            <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $hidden_dt4; ?>" name="dt4">
                                    <?php 
                                        }
                                        elseif($hidden_dt42!='') {
                                    ?>
                                            <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $hidden_dt42; ?>" name="dt4">
                                    <?php 
                                        }
                                        else {
                                    ?>
                                            <input type="text" class="form-control float-right kjwt-search-date" name="dt4">
                                    <?php 
                                        }
                                    ?>  
                                </div>
                            </div>
                        </div>
                        <!-- end 검색범위 -->                                       
                    </div> 
                    <!-- /.row -->         
                </div> 
                <!-- /.card-body -->                                                                       

                <!-- Begin card-footer --> 
                <div class="card-footer text-right">
                    <button type="submit" value="on" class="btn btn-primary" name="bt41">검색</button>
                </div>
                <!-- /.card-footer -->   
            </form>             
        </div>
        <!-- /.Card Content - Collapse -->
    </div>
    <!-- /.card -->
</div>  

<!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div class="col-lg-12"> 
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample42">
            <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample42">
                <div class="card-body table-responsive p-2">
                    <!-- 보드 시작 -->
                    <div class="row">
                        <!-- 보드1 -->
                        <div class="col-xl-4 col-md-4 mb-2">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">한국(PCS)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($Data_RejectPcsCount['REJECT_GOODS']>0) {echo $Data_RejectPcsCount['REJECT_GOODS'];} else {echo 0;} ?></div>
                                        </div>
                                        <div class="col" style="text-align: right;">
                                            <img src="../img/flag_k.webp" style="width: 5vm; height: 4vh;" alt="korea_flag">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 보드2 -->
                        <div class="col-xl-4 col-md-4 mb-2">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">베트남(PCS)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($Data_vRejectPcsCount['REJECT_GOODS']>0) {echo $Data_vRejectPcsCount['REJECT_GOODS'];} else {echo 0;} ?></div>
                                        </div>
                                        <div class="col" style="text-align: right;">
                                            <img src="../img/flag_v.webp" style="width: 5vm; height: 4vh;" alt="vietnam_flag">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 보드3 -->
                        <div class="col-xl-4 col-md-4 mb-2">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">중국(PCS)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($Data_cRejectPcsCount['REJECT_GOODS']>0) {echo $Data_cRejectPcsCount['REJECT_GOODS'];} else {echo 0;} ?></div>
                                        </div>
                                        <div class="col" style="text-align: right;">
                                            <img src="../img/flag_c.webp" style="width: 5vm; height: 4vh;" alt="china_flag">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 보드 끝 -->
                    
                    <!-- Begin card-footer --> 
                    <?php 
                        ModifyData2("field_complete.php?BadWorkModi=Y&hdt4=$dt4", "bt42", "FieldCompleteBad");
                    ?>

                    <table class="table table-bordered table-hover text-nowrap" id="table4">
                        <thead>
                            <tr>
                                <th>국가</th>
                                <th>품번</th>
                                <th>품명</th>
                                <th>로트날짜</th>
                                <th>로트번호</th> 
                                <th>불량내용</th>   
                                <th>불량개수</th>                                                                         
                                <th>비고</th> 
                                <th>처리현황</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                for($j=1; $j<=$Count_Reject; $j++)
                                {		
                                    $Data_Reject = sqlsrv_fetch_array($Result_Reject); //실행된 쿼리값을 읽음''
                            ?>
                            <tr>
                                <td>한국</td> 
                                <input name='badwork_kno<?php echo $j; ?>' value='<?php echo $Data_Reject['NO']; ?>' type='hidden'>      
                                <td><?php echo $Data_Reject['CD_ITEM']; ?></td>  
                                <td><?php echo NM_ITEM($Data_Reject['CD_ITEM']); ?></td>  
                                <td><?php echo $Data_Reject['LOT_DATE']; ?></td>  
                                <td><?php echo $Data_Reject['LOT_NUM']; ?></td>  
                                <td><?php IF($Data_Reject['REJECT_CODE']=='1') {ECHO "원단손상";} ELSEIF($Data_Reject['REJECT_CODE']=='2') {ECHO "저항과다/변동";} ELSEIF($Data_Reject['REJECT_CODE']=='3') {ECHO "이물/오염";} ELSEIF($Data_Reject['REJECT_CODE']=='4') {ECHO "봉비/봉사";} ELSEIF($Data_Reject['REJECT_CODE']=='5') {ECHO "기타(리워크)";} ELSEIF($Data_Reject['REJECT_CODE']=='6') {ECHO "펜작동무";} ELSEIF($Data_Reject['REJECT_CODE']=='7') {ECHO "박스오차(마이너스만)";} ELSEIF($Data_Reject['REJECT_CODE']=='8') {ECHO "기타(폐기)";}?></td>  
                                <td><?php echo $Data_Reject['REJECT_GOODS']; ?></td>  
                                <td><?php echo $Data_Reject['REJECT_NOTE']; ?></td> 
                                <td>
                                    <?php 
                                        if($BadWorkModi=='Y') { 
                                            if($Data_Reject['RESULT_NOTE']!='') {
                                    ?> 
                                                <select name="K_STATUS<?php echo $j; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="<?php echo $Data_Reject['RESULT_NOTE']?>" selected="selected"><?php echo $Data_Reject['RESULT_NOTE']?></option>
                                                    <option value="폐기">폐기</option>
                                                    <option value="리워크">리워크</option>
                                                    <option value="리워크완료">리워크완료</option>
                                                </select> 
                                    <?php 
                                            }
                                            else {
                                    ?>
                                                <select name="K_STATUS<?php echo $j; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="" selected="selected">선택</option>
                                                    <option value="폐기">폐기</option>
                                                    <option value="리워크">리워크</option>
                                                    <option value="리워크완료">리워크완료</option>
                                                </select>    
                                    <?php 
                                            }
                                        } 
                                        else {
                                            echo $Data_Reject['RESULT_NOTE'];
                                        } 
                                    ?>
                                </td>                                                                                                                                            
                            </tr> 
                            <?php 
                                    if($Data_Reject == false) {
                                        exit;
                                    }
                                }
                            ?>  
                            <?php 
                                for($jv=1; $jv<=$Count_vReject; $jv++)
                                {		
                                    $Data_vReject = sqlsrv_fetch_array($Result_vReject); //실행된 쿼리값을 읽음
                            ?>
                            <tr>
                                <td>베트남</td> 
                                <input name='badwork_vno<?php echo $jv; ?>' value='<?php echo $Data_vReject['NO']; ?>' type='hidden'> 
                                <td><?php echo $Data_vReject['CD_ITEM']; ?></td>  
                                <td><?php echo NM_ITEM($Data_vReject['CD_ITEM']); ?></td>  
                                <td><?php echo $Data_vReject['LOT_DATE']; ?></td>  
                                <td><?php echo $Data_vReject['LOT_NUM']; ?></td>  
                                <td><?php IF($Data_vReject['REJECT_CODE']=='1') {ECHO "원단손상";} ELSEIF($Data_vReject['REJECT_CODE']=='2') {ECHO "저항과다/변동";} ELSEIF($Data_vReject['REJECT_CODE']=='3') {ECHO "이물/오염";} ELSEIF($Data_vReject['REJECT_CODE']=='4') {ECHO "봉비/봉사";} ELSEIF($Data_vReject['REJECT_CODE']=='5') {ECHO "기타";} ELSEIF($Data_vReject['REJECT_CODE']=='6') {ECHO "기타(폐기)";} ELSEIF($Data_vReject['REJECT_CODE']=='7') {ECHO "박스오차(마이너스만)";}?></td>  
                                <td><?php echo $Data_vReject['REJECT_GOODS']; ?></td>  
                                <td><?php echo $Data_vReject['REJECT_NOTE']; ?></td> 
                                <td>
                                    <?php 
                                        if($BadWorkModi=='Y') { 
                                            if($Data_vReject['RESULT_NOTE']!='') {
                                    ?>
                                                <select name="V_STATUS<?php echo $jv; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="<?php echo $Data_vReject['RESULT_NOTE']?>" selected="selected"><?php echo $Data_vReject['RESULT_NOTE']?></option>
                                                    <option value="폐기">폐기</option>
                                                    <option value="리워크">리워크</option>
                                                    <option value="리워크완료">리워크완료</option>
                                                </select> 
                                    <?php 
                                            }
                                            else {
                                    ?>
                                                <select name="V_STATUS<?php echo $jv; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="" selected="selected">선택</option>
                                                    <option value="폐기">폐기</option>
                                                    <option value="리워크">리워크</option>
                                                    <option value="리워크완료">리워크완료</option>
                                                </select>    
                                    <?php 
                                            }
                                        } 
                                        else {
                                            echo $Data_vReject['RESULT_NOTE'];
                                        } 
                                    ?>
                                </td>                                                                            
                            </tr> 
                            <?php 
                                    if($Data_vReject == false) {
                                        exit;
                                    }
                                }
                            ?>  
                            <?php 
                                for($jc=1; $jc<=$Count_cReject; $jc++)
                                {		
                                    $Data_cReject = sqlsrv_fetch_array($Result_cReject); //실행된 쿼리값을 읽음
                            ?>
                            <tr>
                                <td>중국</td> 
                                <input name='badwork_cno<?php echo $jc; ?>' value='<?php echo $Data_cReject['NO']; ?>' type='hidden'>
                                <td><?php echo $Data_cReject['CD_ITEM']; ?></td>  
                                <td><?php echo NM_ITEM($Data_cReject['CD_ITEM']); ?></td>  
                                <td><?php echo $Data_cReject['LOT_DATE']; ?></td>  
                                <td><?php echo $Data_cReject['LOT_NUM']; ?></td>  
                                <td><?php IF($Data_cReject['REJECT_CODE']=='1') {ECHO "원단손상";} ELSEIF($Data_cReject['REJECT_CODE']=='2') {ECHO "저항과다/변동";} ELSEIF($Data_cReject['REJECT_CODE']=='3') {ECHO "이물/오염";} ELSEIF($Data_cReject['REJECT_CODE']=='4') {ECHO "봉비/봉사";} ELSEIF($Data_cReject['REJECT_CODE']=='5') {ECHO "기타";} ELSEIF($Data_cReject['REJECT_CODE']=='5') {ECHO "기타";} ELSEIF($Data_cReject['REJECT_CODE']=='6') {ECHO "기타(폐기)";}ELSEIF($Data_cReject['REJECT_CODE']=='7') {ECHO "박스오차(마이너스만)";}?></td>  
                                <td><?php echo $Data_cReject['REJECT_GOODS']; ?></td>  
                                <td><?php echo $Data_cReject['REJECT_NOTE']; ?></td> 
                                <td>
                                    <?php 
                                        if($BadWorkModi=='Y') { 
                                            if($Data_cReject['RESULT_NOTE']!='') {
                                    ?>
                                                <select name="C_STATUS<?php echo $jc; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="<?php echo $Data_cReject['RESULT_NOTE']?>" selected="selected"><?php echo $Data_cReject['RESULT_NOTE']?></option>
                                                    <option value="폐기">폐기</option>
                                                    <option value="리워크">리워크</option>
                                                    <option value="리워크완료">리워크완료</option>
                                                </select> 
                                    <?php 
                                            }
                                            else {
                                    ?> 
                                                <select name="C_STATUS<?php echo $jc; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="" selected="selected">선택</option>
                                                    <option value="폐기">폐기</option>
                                                    <option value="리워크">리워크</option>
                                                    <option value="리워크완료">리워크완료</option>
                                                </select>    
                                    <?php 
                                            } 
                                        } 
                                        else {
                                            echo $Data_cReject['RESULT_NOTE'];
                                        } 
                                    ?>
                                </td>
                            </tr> 
                            <?php 
                                    if($Data_cReject == false) {
                                        exit;
                                    }
                                }
                            ?>            
                        </tbody>
                    </table>                                     
                </div>
                <!-- /.card-body -->

                <!-- /. 데이터 수정 시 필요 -->
                <input type="hidden" name="until4" value="<?php echo $j; ?>">  
                <input type="hidden" name="vuntil4" value="<?php echo $jv; ?>"> 
                <input type="hidden" name="cuntil4" value="<?php echo $jc; ?>"> 
                <input type="hidden" name="hidden_dt" value="<?php echo $hidden_dt4; ?>">                                                       

            </div>
            <!-- /.Card Content - Collapse -->
        </form> 
    </div>
    <!-- /.card -->
</div>