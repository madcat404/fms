<!-- 입력 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
<div class="col-lg-12"> 
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample21">
            <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample21">                                    
                <div class="card-body">
                    <!-- Begin row -->
                    <div class="row">                                                                        
                        <!-- Begin 라벨스캔 -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>라벨스캔</label>
                                <div class="input-group">                                                
                                    <img src="../img/flag_k.webp" style="height: 38px;" alt="korea_flag">
                                    <input type="text" class="form-control" id="item2" name="item2" pattern="[a-zA-Z0-9^_()_-]+" autofocus required>
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
                    <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
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
        <a href="#collapseCardExample21b1" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample21b1">
            <h1 class="h6 m-0 font-weight-bold text-primary">수기입력</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample21b1">                                    
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
                                    <input type="text" class="form-control" name="item21b1" required>
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
                                    <input type="number" class="form-control" name="size21b1" min="1" required>
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
                                    <input type="text" class="form-control" name="note21b1" value="통풍모듈(현대)">
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
                    <button type="submit" value="on" class="btn btn-primary" name="bt21b1">입력</button>
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
        <a href="#collapseCardExample21b2" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample21b2">
            <h1 class="h6 m-0 font-weight-bold text-primary">삭제</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample21b2">                                    
                <div class="card-body">
                    <!-- Begin row -->
                    <div class="row">                                                                        
                        <!-- Begin 라벨스캔 -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>라벨스캔</label>
                                <div class="input-group">                                                
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-qrcode"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="item2b" pattern="[a-zA-Z0-9^_()_-]+">
                                </div>
                            </div>
                        </div>
                        <!-- end 라벨스캔 -->    
                        <!-- Begin 수기입력 삭제 -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>품번(수기입력 삭제)</label>
                                <div class="input-group">                                                
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-signature"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="item2b2">
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
                    <button type="submit" value="on" class="btn btn-primary" name="bt21b">입력</button>
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
        <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample22">
            <h1 class="h6 m-0 font-weight-bold text-primary">스캔내역</h6>
        </a>
        <?php 
            if($form2!='on') {
        ?>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
        <?php 
            }
        ?>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample22">
                <div class="card-body table-responsive p-2">
                    <div class="row">
                        <!-- 보드 시작 -->
                        <?php 
                            BOARD(6, "primary", "스캔수량", $Count_KoreaScan, "fas fa-qrcode");
                            BOARD(6, "primary", "실적(PCS)", $Data_KoreaTotal['QT']-$Data_KoreaTotal['RE'], "fas fa-box");
                        ?>
                        <!-- 보드 끝 -->
                    </div>  
                    <!-- Begin card-footer --> 
                    <?php 
                        ModifyData2("field_complete.php?modi=Y", "bt22", "FieldCompleteKorea");
                    ?>

                    <div id="table" class="table-editable">
                        <table class="table table-bordered table-striped" id="table_nosort">
                            <thead>
                                <tr>
                                    <th>품번</th>
                                    <th>품명</th>
                                    <th>시작일(ERP)</th> 
                                    <th>종료일(스캔일)</th>
                                    <th>로트번호</th>                                                                                
                                    <th>로트사이즈</th>  
                                    <th>불량</th>
                                    <th>불량내용</th>  
                                    <th>오차</th>
                                    <th>실적</th>
                                    <th>ERP작업지시번호</th> 
                                    <th>마감 후 검사</th> 
                                    <th>양산/AS</th> 
                                    <th>비고</th>    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    for($k=1; $k<=$Count_KoreaScan; $k++)
                                    {		
                                        $Data_KoreaScan = sqlsrv_fetch_array($Result_KoreaScan); //실행된 쿼리값을 읽음

                                        //수기입력이 아닌 경우
                                        if(substr(strtoupper($Data_KoreaScan['BARCODE']),0, 3)=='WMO') {
                                            $Query_CheckDT = "SELECT * from NEOE.NEOE.PR_WO WHERE NO_WO='$Data_KoreaScan[BARCODE]'";              
                                            $Result_CheckDT = sqlsrv_query($connect21, $Query_CheckDT, $params21, $options21);
                                            $Data_CheckDT = sqlsrv_fetch_array($Result_CheckDT);
                                        }

                                        $Query_kChkFinishedIn = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS from CONNECT.dbo.FINISHED_INPUT_LOG WHERE SORTING_DATE='$Hyphen_today' AND OUT_OF='한국' AND CD_ITEM='$Data_KoreaScan[CD_ITEM]' GROUP BY CD_ITEM";              
                                        $Result_kChkFinishedIn = sqlsrv_query($connect21, $Query_kChkFinishedIn, $params21, $options21);		
                                        $Data_kChkFinishedIn = sqlsrv_fetch_array($Result_kChkFinishedIn); 

                                        $fan1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "모듈");
                                        $fan2=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "BLOW");
                                        $fan3=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "BLOWER");
                                        $bed1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "BED");
                                        $wheel1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "S/WHEEL");
                                        $wheel2=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "S/W");
                                        $unit1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "UNIT");
                                        $warmer1=strpos(strtoupper(NM_ITEM($Data_KoreaScan['CD_ITEM'])), "WARMER");
                                ?>
                                <tr>
                                    <?php 
                                        if($fan1>0 or $fan2>0 or $fan3>0 or $bed1>0 or $wheel1>0 or $wheel2>0 or $unit1>0 or $warmer1>0) {
                                    ?> 
                                            <td>
                                    <?php 
                                        }
                                        else {                                                                                
                                            if(($Data_KoreaScan['QT_GOODS']-$Data_KoreaScan['REJECT_GOODS'])>$Data_kChkFinishedIn['QT_GOODS']) {                                                                                          
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
                                                <?php if($modi=='Y') { echo $Data_KoreaScan['CD_ITEM']; ?> <input name='N_CD_ITEM<?php echo $k; ?>' value='<?php echo $Data_KoreaScan['CD_ITEM']; ?>' type='hidden'> <?php } else {echo $Data_KoreaScan['CD_ITEM'];} ?></td>
                                    <td><?php echo NM_ITEM($Data_KoreaScan['CD_ITEM']); ?></td>  
                                    <td><?php echo $Data_CheckDT['DT_REL']; ?></td>
                                    <td><?php if($modi=='Y') { echo $Data_KoreaScan['LOT_DATE']; ?> <input name='N_LOT_DATE<?php echo $k; ?>' value='<?php echo $Data_KoreaScan['LOT_DATE']; ?>' type='hidden'> <?php } else {echo $Data_KoreaScan['LOT_DATE'];} ?></td>                                                                               
                                    <td><?php if($modi=='Y') { echo $Data_KoreaScan['LOT_NUM']; ?> <input name='N_LOT_NUM<?php echo $k; ?>' value='<?php echo $Data_KoreaScan['LOT_NUM']; ?>' type='hidden'> <?php } else {echo $Data_KoreaScan['LOT_NUM'];} ?></td>
                                    <td><?php echo $Data_KoreaScan['QT_GOODS']; ?></td>
                                    <td><?php echo $Data_KoreaScan['REJECT_GOODS']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal"><a href="field_complete.php?MODAL=on&kmodal_Delivery_ItemCode=<?php echo $Data_KoreaScan['CD_ITEM']; ?>&kmodal_Delivery_LotDate=<?php echo $Data_KoreaScan['LOT_DATE']; ?>&kmodal_Delivery_LotNum=<?php echo $Data_KoreaScan['LOT_NUM']; ?>&kmodal_Delivery_ERP=<?php echo $Data_KoreaScan['BARCODE']; ?>" style="text-decoration:none; color: white;">입력</a></button>
                                    </td>
                                    <td>
                                        <?php if($modi=='Y') { ?>
                                            <div class="input-group">                                                                                          
                                                <button type="button" class="btn btn-info" onclick="cal('m', this);">-</button>
                                                <input type="text" class="form-control" name="pop_out<?php echo $k; ?>" value="<?php echo $Data_KoreaScan['ERROR_GOODS']?>">
                                                <button type="button" class="btn btn-info" onclick="cal('p', this);">+</button> 
                                            </div>
                                        <?php } else {echo $Data_KoreaScan['ERROR_GOODS'];} ?>
                                    </td>
                                    <td><?php echo $Data_KoreaScan['QT_GOODS']-$Data_KoreaScan['REJECT_GOODS']+$Data_KoreaScan['ERROR_GOODS']; ?></td>
                                    <td><?php echo $Data_KoreaScan['BARCODE']; ?></td>
                                    <td><?php echo $Data_KoreaScan['CLOSING_YN']; ?></td>  
                                    <td>
                                    <?php 
                                        if($modi=='Y') { 
                                            if($Data_KoreaScan['AS_YN']=='N') {
                                    ?> 
                                                <select name="AS_STATUS<?php echo $k; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="<?php echo $Data_KoreaScan['AS_YN']?>" selected="selected"><?php if($Data_KoreaScan['AS_YN']=='N') {echo "양산";} elseif($Data_KoreaScan['AS_YN']=='Y') {echo "A/S";} ?></option>
                                                    <option value="N">양산</option>
                                                    <option value="Y">A/S</option>                                                                                                
                                                </select> 
                                    <?php 
                                            }
                                            else {
                                    ?>
                                                <select name="AS_STATUS<?php echo $k; ?>" class="form-control select2" style="width: 100%;">
                                                    <option value="<?php echo $Data_KoreaScan['AS_YN']?>" selected="selected"><?php if($Data_KoreaScan['AS_YN']=='N') {echo "양산";} elseif($Data_KoreaScan['AS_YN']=='Y') {echo "A/S";} ?></option>
                                                    <option value="Y">A/S</option>
                                                    <option value="N">양산</option>
                                                </select>    
                                    <?php 
                                            }
                                        } 
                                        else {
                                            if($Data_KoreaScan['AS_YN']=='N') {
                                                echo "양산";                                                                                            
                                            }
                                            elseif($Data_KoreaScan['AS_YN']=='Y') {
                                                echo "A/S";
                                            }                                                                                        
                                        } 
                                    ?>
                                    </td> 
                                    <td><?php if($modi=='Y') { ?> <input value='<?php echo $Data_KoreaScan['NOTE']; ?>' name='NOTE<?php echo $k; ?>' type='text'> <?php } else {echo $Data_KoreaScan['NOTE'];} ?></td>
                                </tr> 
                                <?php 
                                        if($Data_KoreaScan == false) {
                                            exit;
                                        }
                                    }
                                ?>                     
                            </tbody>
                        </table>
                    </div>  
                    
                    <!-- /.수정을 위해 필요 -->  
                    <input type="hidden" name="until" value="<?php echo $k; ?>">

                </div>
                <!-- /.card-body -->                                                            
            </div>
            <!-- /.Card Content - Collapse -->
        </form>  

        <!-- Begin modal --> 
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">불량내용</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form method="POST" autocomplete="off" action="field_complete.php">                                                                                               
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">선택:</label><br>
                                - 품번: <?php echo $kmodal_Delivery_ItemCode; ?><br>
                                - 로트날짜: <?php echo $kmodal_Delivery_LotDate; ?><br>
                                - 로트번호: <?php echo $kmodal_Delivery_LotNum; ?><br>
                                - ERP작지번호: <?php echo $kmodal_Delivery_ERP; ?><br>
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
                                                <td><input type="text" class="form-control" name="mi1" pattern="[0-9]+" value="<?php echo $Data_KoreaReject1['REJECT_GOODS']?>"></td>   
                                                <td><input type="text" class="form-control" name="mn1" value="<?php echo $Data_KoreaReject1['REJECT_NOTE']?>"></td> 
                                            </tr> 
                                            <tr>
                                                <td>저항과다/변동</td> 
                                                <td><input type="text" class="form-control" name="mi2" pattern="[0-9]+" value="<?php echo $Data_KoreaReject2['REJECT_GOODS']?>"></td>   
                                                <td><input type="text" class="form-control" name="mn2" value="<?php echo $Data_KoreaReject2['REJECT_NOTE']?>"></td>   
                                            </tr>  
                                            <tr>
                                                <td>이물/오염</td> 
                                                <td><input type="text" class="form-control" name="mi3" pattern="[0-9]+" value="<?php echo $Data_KoreaReject3['REJECT_GOODS']?>"></td>   
                                                <td><input type="text" class="form-control" name="mn3" value="<?php echo $Data_KoreaReject3['REJECT_NOTE']?>"></td>
                                            </tr> 
                                            <tr>
                                                <td>봉비/봉사</td> 
                                                <td><input type="text" class="form-control" name="mi4" pattern="[0-9]+" value="<?php echo $Data_KoreaReject4['REJECT_GOODS']?>"></td>   
                                                <td><input type="text" class="form-control" name="mn4" value="<?php echo $Data_KoreaReject4['REJECT_NOTE']?>"></td>
                                            </tr> 
                                            <tr>
                                                <td>펜작동무</td> 
                                                <td><input type="text" class="form-control" name="mi6" pattern="[0-9]+" value="<?php echo $Data_KoreaReject6['REJECT_GOODS']?>"></td>    
                                                <td><input type="text" class="form-control" name="mn6" value="<?php echo $Data_KoreaReject6['REJECT_NOTE']?>"></td>
                                            </tr>
                                            <tr>
                                                <td>박스오차(마이너스만)</td> 
                                                <td><input type="text" class="form-control" name="mi7" pattern="[0-9]+" value="<?php echo $Data_KoreaReject7['REJECT_GOODS']?>"></td>    
                                                <td><input type="text" class="form-control" name="mn7" value="<?php echo $Data_KoreaReject7['REJECT_NOTE']?>"></td>
                                            </tr>
                                            <tr>
                                                <td>기타(리워크)</td> 
                                                <td><input type="text" class="form-control" name="mi5" pattern="[0-9]+" value="<?php echo $Data_KoreaReject5['REJECT_GOODS']?>"></td>    
                                                <td><input type="text" class="form-control" name="mn5" value="<?php echo $Data_KoreaReject5['REJECT_NOTE']?>"></td>                                                                                           
                                            </tr>  
                                            <tr>
                                                <td>기타(폐기)</td> 
                                                <td><input type="text" class="form-control" name="mi8" pattern="[0-9]+" value="<?php echo $Data_KoreaReject8['REJECT_GOODS']?>"></td>    
                                                <td><input type="text" class="form-control" name="mn8" value="<?php echo $Data_KoreaReject8['REJECT_NOTE']?>"></td>
                                            </tr>                    
                                        </tbody>
                                    </table>
                                </div>     
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="kmodal_ItemCode" value="<?php echo $kmodal_Delivery_ItemCode; ?>">
                            <input type="hidden" name="kmodal_LotDate" value="<?php echo $kmodal_Delivery_LotDate; ?>">
                            <input type="hidden" name="kmodal_LotNum" value="<?php echo $kmodal_Delivery_LotNum; ?>">
                            <input type="hidden" name="kmodal_ERP" value="<?php echo $kmodal_Delivery_ERP; ?>">
                            <button type="submit" value="on" name="mbt1" class="btn btn-info">저장</button>
                            <button type="button" class="btn btn-secondary"><a href="field_complete.php" style="text-decoration:none; color: white;">닫기</a></button>                                                                                                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal -->

        <!-- Begin modal2 --> 
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">수량변경</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form method="POST" autocomplete="off" action="field_complete.php">                                                                                               
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">선택:</label><br>
                                - 품번: <?php echo $modal_Delivery_ItemCode2; ?><br>
                                - 현재수량: <?php echo $Data_KoreaPrevious["QT_GOODS"]; ?> 
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
                                                        <input type="text" class="form-control" name="pop_out5" value="<?php if($size>0) {echo $size;} else {echo 0;}?>">
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
                            <input type="hidden" name="modal_ItemCode2" value="<?php echo $modal_Delivery_ItemCode2; ?>">
                            <input type="hidden" name="modal_quantiy2" value="<?php echo $Data_KoreaPrevious['QT_GOODS']; ?>">
                            <button type="submit" value="on" name="mbt2" class="btn btn-info">저장</button>
                            <button type="button" class="btn btn-secondary"><a href="field_complete.php?modi=P" style="text-decoration:none; color: white;">닫기</a></button>                                                                                                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal2 -->

    </div>
    <!-- /.card -->
</div>