<?php
// kjwt_ghp/ghp_repair_list_inc.php
if (!isset($displayList)) $displayList = [];
?>

<?php if(empty($displayList)): ?>
    <div class="text-center p-5 text-gray-500">데이터가 없습니다.</div>
<?php else: ?>
    <div class="card-body table-responsive p-0">
        <div class="d-none d-md-block">
            <table class="table table-bordered table-hover text-nowrap" id="dataTableResult" width="100%">
                <thead class="thead-light text-center">
                    <tr>
                        <th style="width: 12%">날짜</th>
                        <th style="width: 12%">GHP</th>
                        <th style="width: 10%">작업자</th>
                        <th>증상 / 조치</th>
                        <th style="width: 10%">비용</th>
                        <th style="width: 10%">사진</th>
                        <th style="width: 12%">관리</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($displayList as $row): 
                        $shareUrl = generateShareLink($row['REPAIR_SEQ'], $secret_key);
                        $isLocked = !empty($row['ADMIN_CODE']);
                    ?>
                    <tr class="clickable-row" onclick="goToView(<?=$row['REPAIR_SEQ']?>)">
                        <td class="text-center small"><?=$row['CREATE_DT']->format('Y-m-d')?></td>
                        <td class="text-center font-weight-bold"><?=$row['GHP_ID']?></td>
                        <td class="text-center"><?=$row['WORKER_NAME']?></td>
                        <td>
                            <div class="mb-1"><span class="badge badge-danger">증상</span> <?=truncateText($row['REPAIR_SYMPTOM'], 20)?></div>
                            <div><span class="badge badge-success">조치</span> <?=truncateText($row['REPAIR_CONTENT'], 20)?></div>
                        </td>
                        <td class="text-right"><?=number_format($row['REPAIR_COST'])?></td>
                        <td class="text-center">
                            <?php
                            $p_stmt = sqlsrv_query($connect, "SELECT FILE_NAME FROM GHP_REPAIR_PHOTOS WHERE REPAIR_SEQ = ?", [$row['REPAIR_SEQ']]);
                            while($p = sqlsrv_fetch_array($p_stmt, SQLSRV_FETCH_ASSOC)) { echo "<img src='/uploads/ghp/{$p['FILE_NAME']}' class='photo-thumb'>"; }
                            ?>
                        </td>
                        <td class="text-center" onclick="event.stopPropagation()">
                            <?php if($isLocked): ?>
                                <button class="btn btn-secondary btn-sm btn-circle" title="확정됨" disabled><i class="fas fa-lock"></i></button>
                            <?php else: ?>
                                <a href="ghp_edit.php?RepairSeq=<?=$row['REPAIR_SEQ']?>" class="btn btn-info btn-sm btn-circle"><i class="fas fa-edit"></i></a>
                            <?php endif; ?>
                            
                            <button class="btn btn-success btn-sm btn-circle" onclick="shareGhpLink('<?=$shareUrl?>', '<?=$row['GHP_ID']?>', '공유')"><i class="fas fa-share-alt"></i></button>
                            
                            <button class="btn btn-warning btn-sm btn-circle" onclick="sendGhpMail(<?=$row['REPAIR_SEQ']?>)" title="메일 발송"><i class="fas fa-envelope"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-md-none" id="mobile-card-container-history">
            <?php foreach ($displayList as $row): 
                $shareUrl = generateShareLink($row['REPAIR_SEQ'], $secret_key);
                $isLocked = !empty($row['ADMIN_CODE']);
            ?>
            <div class="card mobile-card mb-3 shadow-sm clickable-row" onclick="goToView(<?=$row['REPAIR_SEQ']?>)">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="font-weight-bold text-primary mb-0"><?=$row['GHP_ID']?></h5>
                        <small class="text-muted"><?=$row['CREATE_DT']->format('Y-m-d')?></small>
                    </div>
                    <div class="mb-2">
                        <strong class="text-danger">증상:</strong> <?=truncateText($row['REPAIR_SYMPTOM'], 30)?><br>
                        <strong class="text-success">조치:</strong> <?=truncateText($row['REPAIR_CONTENT'], 30)?>
                    </div>
                    <div class="d-flex justify-content-between align-items-end mt-2">
                        <div onclick="event.stopPropagation()">
                            <?php
                            $p_stmt = sqlsrv_query($connect, "SELECT FILE_NAME FROM GHP_REPAIR_PHOTOS WHERE REPAIR_SEQ = ?", [$row['REPAIR_SEQ']]);
                            while($p = sqlsrv_fetch_array($p_stmt, SQLSRV_FETCH_ASSOC)) { echo "<img src='/uploads/ghp/{$p['FILE_NAME']}' class='photo-thumb'>"; }
                            ?>
                        </div>
                        <div class="text-right">
                            <div class="font-weight-bold mb-1"><?=number_format($row['REPAIR_COST'])?>원</div>
                            <div onclick="event.stopPropagation()">
                                <?php if($isLocked): ?>
                                    <button class="btn btn-sm btn-secondary" disabled><i class="fas fa-lock"></i></button>
                                <?php else: ?>
                                    <a href="ghp_edit.php?RepairSeq=<?=$row['REPAIR_SEQ']?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-success" onclick="shareGhpLink('<?=$shareUrl?>', '<?=$row['GHP_ID']?>', '공유')"><i class="fas fa-share-alt"></i></button>
                                
                                <button class="btn btn-sm btn-warning" onclick="sendGhpMail(<?=$row['REPAIR_SEQ']?>)"><i class="fas fa-envelope"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>