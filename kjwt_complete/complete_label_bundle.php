<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.04.28>
	// Description:	<완성품 이동>	
    // FS > FIELD START
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================
    include 'complete_label_bundle_status.php';    
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_barcode.php' ?>

    <!-- 타임아웃 -->
    <script type="text/javascript">
        function move() {
            const params = new URLSearchParams({
                cost: <?php echo intval($cost) - 1; ?>,
                item: '<?php echo urlencode($cd_item); ?>',
                lot_size: '<?php echo urlencode($lot_size); ?>',
                remainder: '<?php echo urlencode($remainder); ?>',
                MQT: '<?php echo urlencode($MQT); ?>',
                country: '<?php echo urlencode($country); ?>',
                ends_flag: '<?php echo urlencode($ends_flag ?? ''); ?>',
                as_flag: '<?php echo urlencode($as_flag); ?>'
            });
            location.href = "complete_label_bundle.php?" + params.toString();
        }
        function move2() {
            location.href="complete_label.php";
        }
    </script> 
</head>

<body>    
    <div>    
        <table style="width: 100px; height: 140px; border-collapse: collapse; text-align:center; margin:auto;">		
        	<tr>			
				<td id="bcTarget" style="text-align:center;">
					<script type="text/javascript">
                        <?php
                            // Sanitize variables for JavaScript context
                            $js_NoHyphen_today = htmlspecialchars($NoHyphen_today ?? '', ENT_QUOTES, 'UTF-8');
                            $js_cd_item = htmlspecialchars(HyphenRemove($cd_item ?? ''), ENT_QUOTES, 'UTF-8');
                            $js_lot_num = htmlspecialchars($lot_num ?? '', ENT_QUOTES, 'UTF-8');
                            $js_lot_size = htmlspecialchars($lot_size ?? '', ENT_QUOTES, 'UTF-8');
                            $js_NoHyphen_today6 = htmlspecialchars($NoHyphen_today6 ?? '', ENT_QUOTES, 'UTF-8');
                            
                            $barcode_prefix = ($as_flag === 'Y') ? 'A' : 'M';
                            if (($ends ?? null) == 1) {
                                $barcode_prefix .= 'R';
                            }
                            $barcode_string = "{$barcode_prefix}^{$js_NoHyphen_today}^{$js_cd_item}^{$js_lot_num}^{$js_lot_size}";
                        ?>
                        $("#bcTarget").barcode("<?php echo $barcode_string; ?>", "datamatrix", { showHRI: false });	
                        document.write('\n<?php echo $js_cd_item; ?>\n'.fontsize(2));
                        document.write('<?php echo $js_NoHyphen_today6; ?>\n'.fontsize(2));
                        document.write('<?php echo $js_lot_num; ?>\n'.fontsize(2));
                        document.write('<?php echo $js_lot_size . (($ends ?? null) == 1 ? "★" : ""); ?>'.fontsize(2));
					</script>
                </td>   
            </tr>           
        </table> 	
        <script type="text/javascript">
            window.print();
        </script>      
    </div>

    <?php 
        //검사완료가 0 / 검사완료 < 로트사이즈 인 경우 (해당 조건이 없는 경우 insert 됨)
        if(($exit ?? null) != '1') {            
            //라벨 출력 후 데이터 처리
            $in_record_query = "INSERT INTO CONNECT.dbo.PACKING_LOG(COUNTRY, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS) VALUES(?, ?, ?, ?, ?)";
            $params_insert = array($country, $cd_item, $NoHyphen_today, $lot_num, $lot_size);
            sqlsrv_query($connect, $in_record_query, $params_insert);
        }

        if(($option ?? null) == 'one') {
            $cost=0;
        }
    ?>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?> 
</body>
</html>

<?php 
    //2초후 화면이동 스크립트 실행
    //딜레이 없이 출력하면 특정 페이지 출력이 생략되는 경우가 생김
    if($cost != '0') {       
        echo "<script type=text/javascript>setTimeout(move, 2000);</script>";
    }
    else {
        //검사완료가 0 / 검사완료 < 로트사이즈 인 경우 (해당 조건이 없는 경우 update 됨)
        if(($exit ?? null) != '1') {
            $table_suffix = '';
            if ($country === 'v') {
                $table_suffix = '_V';
            } elseif ($country === 'c') {
                $table_suffix = '_C';
            }

            //한장 출력 옵션일때
            if(($option ?? null) == 'one') {
                $LOT_remains = $lot_size;

                $query_change = "SELECT NO, QT_GOODS, REJECT_GOODS, REJECT_REWORK, PRINT_QT, REJECT_WAIT FROM CONNECT.dbo.FIELD_PROCESS_FINISH{$table_suffix} WHERE PRINT_YN!='Y' AND SORTING_DATE>='2023-04-01' AND CD_ITEM=? ORDER BY NO";
                $params_change = array($cd_item);
                $result_change = sqlsrv_query($connect, $query_change, $params_change);

                if ($result_change) {
                    while (($row = sqlsrv_fetch_array($result_change, SQLSRV_FETCH_ASSOC)) && $LOT_remains > 0) {
                        $PRINT_possible = $row['QT_GOODS'] - $row['REJECT_GOODS'] + $row['REJECT_REWORK'] - $row['PRINT_QT'];
                        
                        $update_qt = 0;
                        $print_yn_status = '';

                        if ($PRINT_possible < $LOT_remains) {
                            $update_qt = $row['QT_GOODS'] - $row['REJECT_GOODS'] + $row['REJECT_REWORK'];
                            $print_yn_status = ($row['REJECT_WAIT'] > 0) ? 'W' : 'Y';
                            $LOT_remains -= $PRINT_possible;
                        } else { // $PRINT_possible >= $LOT_remains
                            $update_qt = $row['PRINT_QT'] + $LOT_remains;
                            $print_yn_status = ($PRINT_possible == $LOT_remains) ? (($row['REJECT_WAIT'] > 0) ? 'W' : 'Y') : 'P';
                            $LOT_remains = 0;
                        }
                        
                        $query_update_qt = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH{$table_suffix} SET PRINT_QT=? WHERE NO=?";
                        sqlsrv_query($connect, $query_update_qt, array($update_qt, $row['NO']));

                        $query_update_yn = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH{$table_suffix} SET PRINT_YN=? WHERE NO=?";
                        sqlsrv_query($connect, $query_update_yn, array($print_yn_status, $row['NO']));
                    }
                }
            }
            //여러장 출력 옵션 일때
            else {
                $query_change_all = "SELECT NO, QT_GOODS, REJECT_GOODS, REJECT_REWORK, REJECT_WAIT FROM CONNECT.dbo.FIELD_PROCESS_FINISH{$table_suffix} WHERE PRINT_YN!='Y' AND SORTING_DATE>='2023-04-01' AND CD_ITEM=?";
                $params_change_all = array($cd_item);
                $result_change_all = sqlsrv_query($connect, $query_change_all, $params_change_all);

                if ($result_change_all) {
                    while ($row = sqlsrv_fetch_array($result_change_all, SQLSRV_FETCH_ASSOC)) {
                        $PRINT_total_possible = $row['QT_GOODS'] - $row['REJECT_GOODS'] + $row['REJECT_REWORK'];
                        $print_yn_status = ($row['REJECT_WAIT'] > 0) ? 'W' : 'Y';

                        $query_update_qt = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH{$table_suffix} SET PRINT_QT=? WHERE NO=?";
                        sqlsrv_query($connect, $query_update_qt, array($PRINT_total_possible, $row['NO']));

                        $query_update_yn = "UPDATE CONNECT.dbo.FIELD_PROCESS_FINISH{$table_suffix} SET PRINT_YN=? WHERE NO=?";
                        sqlsrv_query($connect, $query_update_yn, array($print_yn_status, $row['NO']));
                    }
                }
            }
        }

        echo "<script type=text/javascript>setTimeout(move2, 2000);</script>"; 
    }
?>