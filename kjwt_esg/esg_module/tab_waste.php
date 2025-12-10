<!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="esg.php"> 
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
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <div class="row">
                                                                <!-- 보드 시작 -->
                                                                <?php 
                                                                    BOARD(4, "primary", $YY."년", round($Data_Trash1['GIVE_QUNT']/1000,1)." TON", "fas fa-trash-alt");
                                                                    BOARD(4, "primary", $Minus1YY."년", round($Data_Trash2['GIVE_QUNT']/1000,1)." TON", "fas fa-trash-alt");
                                                                    BOARD(4, "primary", $Minus2YY."년", round($Data_Trash3['GIVE_QUNT']/1000,1)." TON", "fas fa-trash-alt");
                                                                ?>
                                                                <!-- 보드 끝 -->
                                                            </div>

                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>인계량(kg)</th>
                                                                        <th>인계일자</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        // $Result_Trash 변수는 이미 모든 데이터가 담긴 배열이므로,
                                                                        // foreach 루프를 사용하여 배열의 요소를 순회합니다.
                                                                        foreach ($Result_Trash as $Data_Trash) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo round($Data_Trash['GIVE_QUNT'], 0); ?></td>
                                                                            <td><?php echo htmlspecialchars($Data_Trash['WORK_DATE']); ?></td>
                                                                        </tr>
                                                                    <?php
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