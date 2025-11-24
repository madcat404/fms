<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date:	<22.08.18>
	// Description:	<포장라벨 재발행>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================
    include 'complete_label_single_status.php';    
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_barcode.php' ?>

    <!-- 타임아웃 -->
    <script type="text/javascript">
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
                            // Sanitize variables for JavaScript context to prevent XSS
                            $js_lot_date = htmlspecialchars($Data_ItemSelect['LOT_DATE'] ?? '', ENT_QUOTES, 'UTF-8');
                            $js_cd_item = htmlspecialchars($Data_ItemSelect['CD_ITEM'] ?? '', ENT_QUOTES, 'UTF-8');
                            $js_lot_num = htmlspecialchars($Data_ItemSelect['LOT_NUM'] ?? '', ENT_QUOTES, 'UTF-8');
                            $js_qt_goods = htmlspecialchars($Data_ItemSelect['QT_GOODS'] ?? '', ENT_QUOTES, 'UTF-8');
                        ?>
                        $("#bcTarget").barcode("<?php echo $js_lot_date; ?>^<?php echo $js_cd_item; ?>^<?php echo $js_lot_num; ?>^<?php echo $js_qt_goods; ?>", "datamatrix", { showHRI: false });	
                        document.write('\n<?php echo $js_cd_item; ?>\n'.fontsize(2));
                        document.write('<?php echo $js_lot_date; ?>\n'.fontsize(2));
                        document.write('<?php echo $js_lot_num; ?>\n'.fontsize(2));
                        document.write('<?php echo $js_qt_goods; ?>'.fontsize(2));
					</script>
                </td>   
            </tr>           
        </table> 	
        <script type="text/javascript">
            window.print();
        </script>      
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?> 
</body>
</html>

<?php 
    echo "<script type=text/javascript>";
    echo "setTimeout(move2, 2000);";
    echo "</script>"; 
?>
