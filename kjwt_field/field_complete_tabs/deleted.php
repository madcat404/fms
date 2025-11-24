<!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
<div class="col-lg-12"> 
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample51" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample51">
            <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
        </a>
        <form method="POST" autocomplete="off" action="field_complete.php"> 
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample51">                                    
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
                                        if($dt5!='') {
                                    ?>
                                            <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt5 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt5">
                                    <?php 
                                        }
                                        else {
                                    ?>
                                            <input type="text" class="form-control float-right kjwt-search-date" name="dt5">
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
                    <button type="submit" value="on" class="btn btn-primary" name="bt51">검색</button>
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
        <a href="#collapseCardExample52" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample52">
            <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample52">
            <div class="card-body table-responsive p-2">      
                <table class="table table-bordered table-hover text-nowrap" id="table5">
                    <thead>
                        <tr>
                            <th>품번</th>
                            <th>품명</th>
                            <th>로트날짜</th>
                            <th>로트번호</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            for($j=1; $j<=$Count_Delete; $j++)
                            {		
                                $Data_Delete = sqlsrv_fetch_array($Result_Delete); //실행된 쿼리값을 읽음
                        ?>
                        <tr>
                            <td><?php echo $Data_Delete['CD_ITEM']; ?></td>  
                            <td><?php echo NM_ITEM($Data_Delete['CD_ITEM']); ?></td>  
                            <td><?php echo $Data_Delete['LOT_DATE']; ?></td>  
                            <td><?php echo $Data_Delete['LOT_NUM']; ?></td>  
                        </tr> 
                        <?php 
                                if($Data_Delete == false) {
                                    exit;
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