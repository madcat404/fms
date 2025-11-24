<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.10.27>
	// Description:	<포장라벨 커스텀>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================
    include 'complete_label_force_status.php';    
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_barcode.php' ?>

    <!-- 타임아웃 -->
    <script type="text/javascript">
        function move() {
            // URL-encode parameters to prevent XSS and URL corruption
            var url = "complete_label_force.php?cost=<?php echo urlencode($cost - 1); ?>&kind51=<?php echo urlencode($kind); ?>&country51=<?php echo urlencode($country); ?>&item51=<?php echo urlencode($cd_item); ?>&size51=<?php echo urlencode($lot_size); ?>&note51=<?php echo urlencode($note); ?>";
            location.href = url;
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
                            $js_kind = htmlspecialchars($kind ?? '', ENT_QUOTES, 'UTF-8');
                            $js_NoHyphen_today = htmlspecialchars($NoHyphen_today ?? '', ENT_QUOTES, 'UTF-8');
                            $js_cd_item = htmlspecialchars(HyphenRemove($cd_item ?? ''), ENT_QUOTES, 'UTF-8');
                            $js_lot_num = htmlspecialchars($lot_num ?? '', ENT_QUOTES, 'UTF-8');
                            $js_lot_size = htmlspecialchars($lot_size ?? '', ENT_QUOTES, 'UTF-8');
                            $js_NoHyphen_today6 = htmlspecialchars($NoHyphen_today6 ?? '', ENT_QUOTES, 'UTF-8');
                        ?>
                        $("#bcTarget").barcode("<?php echo $js_kind; ?>^<?php echo $js_NoHyphen_today; ?>^<?php echo $js_cd_item; ?>^<?php echo $js_lot_num; ?>^<?php echo $js_lot_size; ?>", "datamatrix", { showHRI: false });	
                        document.write('\n<?php echo $js_cd_item; ?>\n'.fontsize(2));
                        document.write('<?php echo $js_NoHyphen_today6; ?>\n'.fontsize(2));
                        document.write('<?php echo $js_lot_num; ?>\n'.fontsize(2));
                        document.write('<?php echo $js_lot_size; ?>'.fontsize(2));
					</script>
                </td>   
            </tr>           
        </table> 	
        <script type="text/javascript">
            window.print();
        </script>      
    </div>

    <?php         
        //라벨 출력 후 데이터 처리 (Parameterized Query)
        $in_record_query = "INSERT INTO CONNECT.dbo.PACKING_LOG(COUNTRY, CD_ITEM, LOT_DATE, LOT_NUM, QT_GOODS, NOTE) VALUES(?, ?, ?, ?, ?, ?)";
        $note_text = ($kind ?? '') . ' 커스텀라벨';
        $params_insert = array($country, $cd_item, $NoHyphen_today, $lot_num, $lot_size, $note_text);
        sqlsrv_query($connect, $in_record_query, $params_insert);
    ?>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?> 
</body>
</html>

<?php 
    if($cost!='0') {       
        echo "<script type=text/javascript>";
        echo "setTimeout(move, 2000);";
        echo "</script>";
    }
    else {
        echo "<script type=text/javascript>";
        echo "setTimeout(move2, 2000);";
        echo "</script>"; 
    }
?>
