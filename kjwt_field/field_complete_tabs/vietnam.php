<!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
<div class="col-lg-12"> 
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample61" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample61">
            <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample61">                                    
                <div class="card-body">
                    <!-- Begin row -->
                    <div class="row">                                                                        
                        <!-- Begin 라벨스캔 -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>라벨스캔</label>
                                <div class="input-group">                                                
                                    <img src="../img/flag_v.webp" style="height: 38px;" alt="vietnam_flag">
                                    <input type="text" class="form-control" name="item6" pattern="[a-zA-Z0-9^[)>. _-/]+" required autofocus>
                                </div>
                            </div>
                        </div>
                        <!-- end 라벨스캔 -->                                        
                    </div> 
                    <!-- /.row -->         
                </div> 
                <!-- /.card-body -->                                                                       

                <!-- Begin card-footer --> 
                <div class="card-footer text-right">
                    <button type="submit" value="on" class="btn btn-primary" name="bt61">입력</button>
                </div>
                <!-- /.card-footer -->   
            </div>
            <!-- /.Card Content - Collapse -->
        </form>     
    </div>
    <!-- /.card -->
</div> 

<!-- 수기입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
<div class="col-lg-12"> 
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample61b1" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample61b1">
            <h1 class="h6 m-0 font-weight-bold text-primary">수기입력</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample61b1">                                    
                <div class="card-body">
                    <!-- Begin row -->
                    <div class="row">                                                                        
                        <!-- Begin 품번 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>품번</label>
                                <div class="input-group">                                                
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-signature"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="item61b1" required>
                                </div>
                            </div>
                        </div>
                        <!-- end 품번 -->
                        <!-- Begin 로트사이즈 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>수량</label>
                                <div class="input-group">                                                
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-box-open"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" name="size61b1" min="1" required>
                                </div>
                            </div>
                        </div>
                        <!-- end 로트사이즈 --> 
                        <!-- Begin 비고 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>비고(수정가능)</label>
                                <div class="input-group">                                                
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="far fa-sticky-note"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="note61b1" value="베트남 A/S">
                                </div>
                            </div>
                        </div>
                        <!-- end 비고 -->  
                    </div> 
                    <!-- /.row -->         
                </div> 
                <!-- /.card-body -->                                                                       

                <!-- Begin card-footer --> 
                <div class="card-footer text-right">
                    <button type="submit" value="on" class="btn btn-primary" name="bt61b1">입력</button>
                </div>
                <!-- /.card-footer -->   
            </div>
            <!-- /.Card Content - Collapse -->
        </form>     
    </div>
    <!-- /.card -->
</div> 

<!-- 삭제 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
<div class="col-lg-12"> 
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample61b" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample61b">
            <h1 class="h6 m-0 font-weight-bold text-primary">삭제</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample61b">                                    
                <div class="card-body">
                    <!-- Begin row -->
                    <div class="row">                                                                        
                        <!-- Begin 라벨스캔 -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>라벨스캔 (금일 입력된 해당 품번 모두 삭제 [수기입력 포함])</label>
                                <div class="input-group">                                                
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-qrcode"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="item6b" pattern="[a-zA-Z0-9^[)>. _-]+">
                                </div>
                            </div>
                        </div>
                        <!-- end 라벨스캔 -->   
                        <!-- Begin 수기입력 삭제 -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>품번 (금일 입력된 해당 품번 모두 삭제 [라벨스캔 포함])</label>
                                <div class="input-group">                                                
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-signature"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="item6b2">
                                </div>
                            </div>
                        </div>
                        <!-- end 수기입력 삭제 -->                                     
                    </div> 
                    <!-- /.row -->         
                </div> 
                <!-- /.card-body -->                                                                       

                <!-- Begin card-footer --> 
                <div class="card-footer text-right">
                    <button type="submit" value="on" class="btn btn-primary" name="bt61b">입력</button>
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
        <a href="#collapseCardExample62" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample62">
            <h1 class="h6 m-0 font-weight-bold text-primary">완료내역</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample62">
                <div class="card-body table-responsive p-2">
                    <div class="row">
                        <!-- 보드 시작 -->
                        <?php 
                            BOARD(6, "primary", "작업품목수량", $Count_VietnamScan, "fas fa-boxes");
                            BOARD(6, "primary", "실적(PCS)", $Data_VietnamTotal['QT']-$Data_VietnamTotal['RE'], "fas fa-box");
                        ?>
                        <!-- 보드 끝 -->                                                                   
                    </div>
                    <!-- Begin card-footer --> 
                    <?php 
                        ModifyData2("field_complete.php?Vmodi=Y", "bt62", "FieldCompleteVietnam");
                    ?>

                    <div id="table" class="table-editable">
                        <table class="table table-bordered table-striped" id="table_nosort2">
                            <thead>
                                <tr>
                                    <th>품번</th>
                                    <th>품명</th>                                                                               
                                    <th>완료수량</th>  
                                    <th>불량</th>
                                    <th>불량내용</th>  
                                    <th>실적</th>
                                    <th>검사 시 체크</th>  
                                    <th>양산/AS</th> 
                                    <th>비고</th>                                                                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    for($v=1; $v<=$Count_VietnamScan; $v++)
                                    {		
                                        $Data_VietnamScan = sqlsrv_fetch_array($Result_VietnamScan); //실행된 쿼리값을 읽음

                                        $Query_vChkFinishedIn = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE='$Hyphen_today' AND OUT_OF='BB' AND CD_ITEM='$Data_VietnamScan[CD_ITEM]' GROUP BY CD_ITEM";              
                                        $Result_vChkFinishedIn = sqlsrv_query($connect, $Query_vChkFinishedIn, $params, $options);		
                                        $Data_vChkFinishedIn = sqlsrv_fetch_array($Result_vChkFinishedIn); 

                                        $Query_vChkFinishedIn = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE='$Hyphen_today' AND OUT_OF='BB' AND CD_ITEM='$Data_VietnamScan[CD_ITEM]' GROUP BY CD_ITEM";              
                                        $Result_vChkFinishedIn = sqlsrv_query($connect, $Query_vChkFinishedIn, $params, $options);		
                                        $Data_vChkFinishedIn = sqlsrv_fetch_array($Result_vChkFinishedIn); 

                                        $vwheel1=strpos(strtoupper(NM_ITEM($Data_VietnamScan['CD_ITEM'])), "S/WHEEL");
                                        $vwheel2=strpos(strtoupper(NM_ITEM($Data_VietnamScan['CD_ITEM'])), "S/W");
                                ?>
                                <tr>
                                    <?php 
                                        if($vwheel1>0 or $vwheel2>0) {
                                    ?> 
                                            <td>
                                    <?php   
                                        }
                                        else {  
                                            if(($Data_VietnamScan['QT_GOODS']-$Data_VietnamScan['REJECT_GOODS'])>$Data_vChkFinishedIn['QT_GOODS']) {                                                                                          
                                    ?>
                                                <td style="background-color: #99ccff; font-weight: bold;">
                                    <?php 
                                            }
                                            else {
                                    ?>
                                                <td>
                                    <?php 
                                            }
                                        }
                                    ?>                                                                                
                                                <?php if($Vmodi=='Y') { echo $Data_VietnamScan['CD_ITEM']; ?> <input name='V_CD_ITEM<?php echo $v; ?>' value='<?php echo $Data_VietnamScan['CD_ITEM']; ?>' type='hidden'> <?php } else {echo $Data_VietnamScan['CD_ITEM'];} ?></td>
                                    <td><?php echo NM_ITEM($Data_VietnamScan['CD_ITEM']); ?></td>   
                                    <td>
                                        <?php if($Vmodi=='Y') { ?>
                                            <div class="input-group">                                                                                          
                                                <button type="button" class="btn btn-info" onclick="cal('m', this);">-</button>
                                                <input type="text" class="form-control" name="pop_out2<?php echo $v; ?>" value="<?php echo $Data_VietnamScan['QT_GOODS']?>">
                                                <button type="button" class="btn btn-info" onclick="cal('p', this);">+</button> 
                                            </div>
                                        <?php } else {echo $Data_VietnamScan['QT_GOODS'];} ?>
                                    </td>
                                    <td><?php echo $Data_VietnamScan['REJECT_GOODS']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalV"><a href="field_complete.php?VMODAL=on&vmodal_Delivery_ItemCode=<?php echo $Data_VietnamScan['CD_ITEM']; ?>&vmodal_Delivery_LotDate=<?php echo $Data_VietnamScan['LOT_DATE']; ?>" style="text-decoration:none; color: white;">입력</a></button>
                                    </td>
                                    
                                    <?php 
                                        if($Data_VietnamScan['INSPECT_YN']=='Y') {                                                                                          
                                    ?>
                                            <td style="background-color: #f6b352;">
                                    <?php 
                                        }
                                        else {
                                    ?>
                                            <td>
                                    <?php 
                                        }
                                            echo $Data_VietnamScan['QT_GOODS']-$Data_VietnamScan['REJECT_GOODS'] ?>
                                    </td>
                                    <?php 
                                        if($Vmodi=='Y') { 
                                            if($Data_VietnamScan['INSPECT_YN']=='Y') {                                                                                            
                                    ?>
                                                <td style="background-color: #f6b352;">
                                                    <input type='checkbox' name='V_CB<?php echo $v; ?>' style='zoom: 2;' CHECKED>
                                    <?php 
                                            }
                                            else {
                                    ?>
                                                <td>
                                                    <input type='checkbox' name='V_CB<?php echo $v; ?>' style='zoom: 2;'>
                                    <?php 
                                            } 
                                        }
                                        else { 
                                            if($Data_VietnamScan['INSPECT_YN']=='Y') {     
                                    ?>
                                                <td style="background-color: #f6b352;">
                                                    <input type='checkbox' name='V_CB<?php echo $v; ?>' style='zoom: 2;' CHECKED disabled> 
                                    <?php 
                                            }
                                            else {
                                    ?>
                                                <td>
                                                    <input type='checkbox' name='V_CB<?php echo $v; ?>' style='zoom: 2;' disabled>
                                    <?php 
                                            }
                                        }
                                    ?>
                                    </td>
                                    <td>
                                    <?php 
                                        if($Vmodi=='Y') { 
                                            if($Data_VietnamScan['AS_YN']=='N') {
                                    ?> 
                                                <select name="AS_STATUS<?php echo $v; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="<?php echo $Data_VietnamScan['AS_YN']?>" selected="selected"><?php if($Data_VietnamScan['AS_YN']=='N') {echo "양산";} elseif($Data_VietnamScan['AS_YN']=='Y') {echo "A/S";} ?></option>
                                                    <option value="N">양산</option>
                                                    <option value="Y">A/S</option>                                                                                                
                                                </select> 
                                    <?php 
                                            }
                                            else {
                                    ?>
                                                <select name="AS_STATUS<?php echo $v; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="<?php echo $Data_VietnamScan['AS_YN']?>" selected="selected"><?php if($Data_VietnamScan['AS_YN']=='N') {echo "양산";} elseif($Data_VietnamScan['AS_YN']=='Y') {echo "A/S";} ?></option>
                                                    <option value="Y">A/S</option>
                                                    <option value="N">양산</option>
                                                </select>    
                                    <?php 
                                            }
                                        } 
                                        else {
                                            if($Data_VietnamScan['AS_YN']=='N') {
                                                echo "양산";                                                                                            
                                            }
                                            elseif($Data_VietnamScan['AS_YN']=='Y') {
                                                echo "A/S";
                                            }                                                                                        
                                        } 
                                    ?>
                                    </td> 
                                    <td><?php if($Vmodi=='Y') { ?> <input value='<?php echo $Data_VietnamScan['NOTE']; ?>' name='VNOTE<?php echo $v; ?>' type='text'> <?php } else {echo $Data_VietnamScan['NOTE'];} ?></td>
                                </tr> 
                                <?php 
                                        if($Data_VietnamScan == false) {
                                            exit;
                                        }
                                    }
                                ?>                     
                            </tbody>
                        </table>
                    </div>                                     
                </div>
                <!-- /.card-body -->

                <!-- /. 데이터 수정 시 필요 -->
                <input type="hidden" name="until6" value="<?php echo $v; ?>">
                
            </div>
            <!-- /.Card Content - Collapse -->
        </form>  

        <!-- Begin modal --> 
        <div class="modal fade" id="exampleModalV" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelv" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelv">불량내용</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form method="POST" autocomplete="off" action="field_complete.php">                                                                                               
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">선택:</label><br>
                                - 품번: <?php echo $vmodal_Delivery_ItemCode; ?><br>
                                - 로트날짜: <?php echo $vmodal_Delivery_LotDate; ?><br>
                            </div> 
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">입력:</label>
                                <div id="table" class="table-editable">
                                    <table class="table table-bordered" id="table_modal">
                                        <thead>
                                            <tr>
                                                <th>불량내용</th>
                                                <th>수량</th>  
                                                <th>비고</th>                                                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>원단손상</td> 
                                                <td><input type="text" class="form-control" name="vmi1" pattern="[0-9]+" value="<?php echo $Data_VietnamReject1['REJECT_GOODS']?>"></td>   
                                                <td><input type="text" class="form-control" name="vmn1" value="<?php echo $Data_VietnamReject1['REJECT_NOTE']?>"></td> 
                                            </tr> 
                                            <tr>
                                                <td>저항과다/변동</td> 
                                                <td><input type="text" class="form-control" name="vmi2" pattern="[0-9]+" value="<?php echo $Data_VietnamReject2['REJECT_GOODS']?>"></td>   
                                                <td><input type="text" class="form-control" name="vmn2" value="<?php echo $Data_VietnamReject2['REJECT_NOTE']?>"></td>   
                                            </tr>  
                                            <tr>
                                                <td>이물/오염</td> 
                                                <td><input type="text" class="form-control" name="vmi3" pattern="[0-9]+" value="<?php echo $Data_VietnamReject3['REJECT_GOODS']?>"></td>   
                                                <td><input type="text" class="form-control" name="vmn3" value="<?php echo $Data_VietnamReject3['REJECT_NOTE']?>"></td>
                                            </tr> 
                                            <tr>
                                                <td>봉비/봉사</td> 
                                                <td><input type="text" class="form-control" name="vmi4" pattern="[0-9]+" value="<?php echo $Data_VietnamReject4['REJECT_GOODS']?>"></td>   
                                                <td><input type="text" class="form-control" name="vmn4" value="<?php echo $Data_VietnamReject4['REJECT_NOTE']?>"></td>
                                            </tr> 
                                            <tr>
                                                <td>기타(폐기)</td> 
                                                <td><input type="text" class="form-control" name="vmi6" pattern="[0-9]+" value="<?php echo $Data_VietnamReject6['REJECT_GOODS']?>"></td>    
                                                <td><input type="text" class="form-control" name="vmn6" value="<?php echo $Data_VietnamReject6['REJECT_NOTE']?>"></td>
                                            </tr> 
                                            <tr>
                                                <td>박스오차(마이너스만)</td> 
                                                <td><input type="text" class="form-control" name="vmi7" pattern="[0-9]+" value="<?php echo $Data_VietnamReject7['REJECT_GOODS']?>"></td>    
                                                <td><input type="text" class="form-control" name="vmn7" value="<?php echo $Data_VietnamReject7['REJECT_NOTE']?>"></td>
                                            </tr>
                                            <tr>
                                                <td>기타(리워크)</td> 
                                                <td><input type="text" class="form-control" name="vmi5" pattern="[0-9]+" value="<?php echo $Data_VietnamReject5['REJECT_GOODS']?>"></td> 
                                                <td><input type="text" class="form-control" name="vmn5" value="<?php echo $Data_VietnamReject5['REJECT_NOTE']?>"></td>                                                                                               
                                            </tr>                     
                                        </tbody>
                                    </table>
                                 </div>     
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="vmodal_ItemCode" value="<?php echo $vmodal_Delivery_ItemCode; ?>">
                            <input type="hidden" name="vmodal_LotDate" value="<?php echo $vmodal_Delivery_LotDate; ?>">
                            <button type="submit" value="on" name="vmbt1" class="btn btn-info">저장</button>
                            <button type="button" class="btn btn-secondary"><a href="field_complete.php?Vmodi=P" style="text-decoration:none; color: white;">닫기</a></button>                                                                                                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal -->

        <!-- Begin modal2 --> 
        <div class="modal fade" id="exampleModalV2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabe2">수량변경</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form method="POST" autocomplete="off" action="field_complete.php">                                                                                               
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">선택:</label><br>
                                - 품번: <?php echo $vmodal_Delivery_ItemCode2; ?><br>
                                - 현재수량: <?php echo $Data_VietnamPrevious["QT_GOODS"]; ?> 
                            </div> 
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">입력:</label>
                                <div id="table" class="table-editable">
                                    <table class="table table-bordered" id="table_modal">
                                        <thead>
                                            <tr>
                                                <th>더 할 수량</th>                                                                                  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="input-group">                                                                                          
                                                        <button type="button" class="btn btn-info" onclick="cal('m', this);">-</button>
                                                        <input type="text" class="form-control" name="pop_out4" value="<?php if($vsize>0) {echo $vsize;} else {echo 0;}?>">
                                                        <button type="button" class="btn btn-info" onclick="cal('p', this);">+</button> 
                                                    </div>
                                                </td> 
                                            </tr>                                                                                                             
                                        </tbody>
                                    </table>
                                 </div>     
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="vmodal_ItemCode2" value="<?php echo $vmodal_Delivery_ItemCode2; ?>">
                            <input type="hidden" name="vmodal_quantiy2" value="<?php echo $Data_VietnamPrevious['QT_GOODS']; ?>">
                            <button type="submit" value="on" name="vmbt2" class="btn btn-info">저장</button>
                            <button type="button" class="btn btn-secondary"><a href="field_complete.php?Vmodi=P" style="text-decoration:none; color: white;">닫기</a></button>                                                                                                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal2 -->

    </div>
    <!-- /.card -->
</div>