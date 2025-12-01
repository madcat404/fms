<!-- Begin row -->
<div class="row"> 
    <div class="col-lg-12"> 
        <!-- Collapsable Card Example -->
        <div class="card shadow mb-2">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample81t" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample81t">
                <h1 class="h6 m-0 font-weight-bold text-primary">#1. 차종별 개발일정</h6>
            </a>

            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample81t">
                <div class="card-body">
                    <div class="row">
                        <!-- 실패비용 - 핸들 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                        <div class="col-lg-12"> 
                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-2">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample811t" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample811t">
                                    <h1 class="h6 m-0 font-weight-bold text-primary">#1-1. 차종별 개발일정</h6>
                                </a>

                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample811t">                                    
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover text-nowrap">
                                                <thead align="center">
                                                    <tr>
                                                        <th>차종</th> 
                                                        <th>PROTO</th> 
                                                        <th>P1</th> 
                                                        <th>P2</th> 
                                                        <th>M</th> 
                                                        <th>SOP</th> 
                                                        <th>CAR_MAKER</th> 
                                                        <th>SEAT_MAKER</th> 
                                                        <th>VOLUME</th> 
                                                    </tr> 
                                                </thead>
                                                <tbody align="center">
                                                    <?php
                                                    // 1. 백엔드에서 전달된 $Result_DEVELOP1 변수가 있고, 조회된 행이 있는지 확인합니다.
                                                    if (isset($Result_DEVELOP1) && sqlsrv_has_rows($Result_DEVELOP1)) {
                                                        // 2. for 루프 대신 while 루프를 사용하여 결과셋(result set)을 한 줄씩 처리합니다.
                                                        while ($row = sqlsrv_fetch_array($Result_DEVELOP1, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($row['CAR']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['PROTO']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['P1']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['P2']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['M']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['SOP']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['CAR_MAKER']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['SEAT_MAKER']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['VOLUME']); ?></td>
                                                            </tr>
                                                    <?php
                                                        } // end of while loop
                                                    } else {
                                                        // 4. 조회된 데이터가 없을 경우, 테이블에 메시지를 표시합니다.
                                                    ?>
                                                        <tr>
                                                            <td colspan="9">조회된 개발 일정이 없습니다.</td>
                                                        </tr>
                                                    <?php
                                                    } // end of if
                                                    ?>                                                                                          
                                                </tbody>
                                            </table>        
                                        </div> 
                                        <!-- /.table-responsive -->                                                                                      
                                    </div> 
                                    <!-- /.card-body -->              
                                </div>
                                <!-- /.Card Content - Collapse -->
                            </div>
                            <!-- /.card -->
                        </div> 
                    </div> 
                </div>
                <!-- /.card-body -->                                                      
            </div>    
            <!-- /.Card Content - Collapse -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row -->