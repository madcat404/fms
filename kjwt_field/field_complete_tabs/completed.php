<!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
<div class="col-lg-12"> 
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample31">
            <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample31">                                    
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
                                        if($dt3!='') {
                                    ?>
                                            <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt3">
                                    <?php 
                                        }
                                        else {
                                    ?>
                                            <input type="text" class="form-control float-right kjwt-search-date" name="dt3">
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
                    <button type="submit" value="on" class="btn btn-info" name="bt32">ERP 엑셀 다운로드</button>
                    <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
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
        <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample32">
            <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample32">
                <div class="card-body table-responsive p-2">
                    <table class="table table-bordered table-hover text-nowrap">
                        <thead>
                            <tr>
                            <th></th>   
                            <th>시트히터</th> 
                            <th>발열핸들</th> 
                            <th>통풍모듈</th> 
                            <th>기타</th> 
                            <th>합계</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 1vw;"><img src="../img/flag_k.webp" style="width: 3vw;" alt="korea_flag"> 한국 (정상/오차)</td>  
                                <td><?php if($SH+$ESH>0) {echo $SH+$ESH;} else {echo 0;} ?> (<?php if($SH>0) {echo $SH;} else {echo 0;} ?> / <?php if($ESH>0) {echo $ESH;} else {echo 0;} ?>)</td> 
                                <td><?php if($SW>0) {echo $SW;} else {echo 0;} ?></td> 
                                <td><?php if($VT>0) {echo $VT;} else {echo 0;} ?></td> 
                                <td><?php if($ETC>0) {echo $ETC;} else {echo 0;} ?></td> 
                                <td><?php if($Data_PcsCount['QT_GOODS']+$Data_PcsCount['ERROR_GOODS']>0) {echo $Data_PcsCount['QT_GOODS']+$Data_PcsCount['ERROR_GOODS'];} else {echo 0;} ?> (<?php if($Data_PcsCount['QT_GOODS']>0) {echo $Data_PcsCount['QT_GOODS'];} else {echo 0;}?> / <?php if($Data_PcsCount['ERROR_GOODS']!=0) {echo $Data_PcsCount['ERROR_GOODS'];} else {echo 0;}?>)</td>  
                            </tr>  
                            <tr>
                                <td style="width: 1vw;"><img src="../img/flag_v.webp" style="width: 3vw;" alt="vietnam_flag"> 베트남 (유검/무검)</td>  
                                <td><?php if($vSH3>0) {echo $vSH3;} else {echo 0;} ?> (<?php if($vSH>0) {echo $vSH;} else {echo 0;} ?> / <?php if($vSH2>0) {echo $vSH2;} else {echo 0;} ?>)</td> 
                                <td><?php if($vSW3>0) {echo $vSW3;} else {echo 0;} ?> (<?php if($vSW>0) {echo $vSW;} else {echo 0;} ?>/<?php if($vSW2>0) {echo $vSW2;} else {echo 0;} ?>)</td> 
                                <td>-</td> 
                                <td><?php if($vETC3>0) {echo $vETC3;} else {echo 0;} ?></td> 
                                <td><?php if($Data_vPcsCount3['QT_GOODS']>0) {echo $Data_vPcsCount3['QT_GOODS'];} else {echo 0;} ?> (<?php if($Data_vPcsCount['QT_GOODS']>0) {echo $Data_vPcsCount['QT_GOODS'];} else {echo 0;} ?> / <?php if($Data_vPcsCount2['QT_GOODS']>0) {echo $Data_vPcsCount2['QT_GOODS'];} else {echo 0;} ?>)</td>  
                            </tr>
                            <tr>
                                <td style="width: 1vw;"><img src="../img/flag_c.webp" style="width: 3vw;" alt="china_flag"> 중국</td>  
                                <td><?php if($Data_cPcsCount['QT_GOODS']>0) {echo $Data_cPcsCount['QT_GOODS'];} else {echo 0;} ?></td> 
                                <td>-</td>  
                                <td>-</td> 
                                <td>-</td> 
                                <td><?php if($Data_cPcsCount['QT_GOODS']>0) {echo $Data_cPcsCount['QT_GOODS'];} else {echo 0;} ?></td> 
                            </tr> 
                            <tr>
                                <td colspan='5'> 합계</td>  
                                <td><?php if($Data_PcsCount['QT_GOODS']+$Data_PcsCount['ERROR_GOODS']+$Data_vPcsCount3['QT_GOODS']+$Data_cPcsCount['QT_GOODS']>0) {echo $Data_PcsCount['QT_GOODS']+$Data_PcsCount['ERROR_GOODS']+$Data_vPcsCount3['QT_GOODS']+$Data_cPcsCount['QT_GOODS'];} else {echo 0;} ?></td>  
                            </tr>
                        </tbody>
                    </table>   
                    <br>                  
                    <table class="table table-bordered table-hover text-nowrap" id="table3">
                        <thead>
                            <tr>
                                <th>국가</th> 
                                <th>품번</th>
                                <th>품명</th>
                                <th>로트날짜</th>
                                <th>작업개수</th>   
                                <th>불량개수</th> 
                                <th>ERP 작업지시번호</th> 
                                <th>검사여부</th> 
                                <th>비고</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                for($j=1; $j<=$Count_kFinishHistory; $j++)
                                {		
                                    $Data_kFinishHistory = sqlsrv_fetch_array($Result_kFinishHistory); //실행된 쿼리값을 읽음
                            ?>
                            <tr>
                                <td>한국</td>  
                                <td><?php echo $Data_kFinishHistory['CD_ITEM']; ?></td>  
                                <td><?php echo NM_ITEM($Data_kFinishHistory['CD_ITEM']); ?></td>  
                                <td><?php echo $Data_kFinishHistory['LOT_DATE']; ?></td>   
                                <td><?php echo $Data_kFinishHistory['QT_GOODS']; ?></td>  
                                <td><?php echo $Data_kFinishHistory['REJECT_GOODS']; ?></td>
                                <td><?php echo $Data_kFinishHistory['BARCODE']; ?></td>  
                                <td><?php echo '-'; ?></td> 
                                <td><?php echo $Data_kFinishHistory['NOTE']; ?></td> 
                            </tr> 
                            <?php 
                                    if($Data_kFinishHistory == false) {
                                        exit;
                                    }
                                }
                            ?> 
                            <?php 
                                for($jv=1; $jv<=$Count_vFinishHistory; $jv++)
                                {		
                                    $Data_vFinishHistory = sqlsrv_fetch_array($Result_vFinishHistory); //실행된 쿼리값을 읽음
                            ?>
                            <tr>
                                <td>베트남</td>  
                                <td><?php echo Hyphen($Data_vFinishHistory['CD_ITEM']); ?></td>  
                                <td><?php echo NM_ITEM($Data_vFinishHistory['CD_ITEM']); ?></td>  
                                <td><?php echo $Data_vFinishHistory['LOT_DATE']; ?></td>   
                                <td><?php echo $Data_vFinishHistory['QT_GOODS']; ?></td>  
                                <td><?php echo $Data_vFinishHistory['REJECT_GOODS']; ?></td> 
                                <td><?php echo '-'; ?></td> 
                                <td><?php echo $Data_vFinishHistory['INSPECT_YN']; ?></td> 
                                <td><?php echo $Data_vFinishHistory['NOTE']; ?></td> 
                            </tr> 
                            <?php 
                                    if($Data_vFinishHistory == false) {
                                        exit;
                                    }
                                }
                            ?>  
                            <?php 
                                for($jc=1; $jc<=$Count_cFinishHistory; $jc++)
                                {		
                                    $Data_cFinishHistory = sqlsrv_fetch_array($Result_cFinishHistory); //실행된 쿼리값을 읽음                                                                           
                            ?>
                            <tr>
                                <td>중국</td>  
                                <td><?php echo Hyphen($Data_cFinishHistory['CD_ITEM']); ?></td>  
                                <td><?php echo NM_ITEM($Data_cFinishHistory['CD_ITEM']); ?></td>  
                                <td><?php echo $Data_cFinishHistory['LOT_DATE']; ?></td>   
                                <td><?php echo $Data_cFinishHistory['QT_GOODS']; ?></td>  
                                <td><?php echo $Data_cFinishHistory['REJECT_GOODS']; ?></td> 
                                <td><?php echo '-'; ?></td> 
                                <td><?php echo '-'; ?></td> 
                                <td><?php echo $Data_cFinishHistory['NOTE']; ?></td> 
                            </tr> 
                            <?php 
                                    if($Data_cFinishHistory == false) {
                                        exit;
                                    }
                                }
                            ?>       
                        </tbody>
                    </table>                                     
                </div>
                <!-- /.card-body -->                                                      
            </div>
        </form>     
        <!-- /.Card Content - Collapse -->
    </div>
    <!-- /.card -->
</div>