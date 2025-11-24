<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.11.25>
	// Description:	<ERP 작업지시번호 라벨 & 공정진행표 라벨>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================
    include 'order_label_single_status.php';    
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_barcode.php' ?>

    <!-- 타임아웃 -->
    <script type="text/javascript">
        function move2() {
            location.href="order_label.php";
        }
    </script> 
</head>

<body>    
    <div>    
        <table style="width: 100px; height: 140px; border-collapse: collapse; text-align:center; margin:auto;">		
           	<tr>			
				<td id="bcTarget" style="text-align:center;">
					<script type="text/javascript">
                        $("#bcTarget").barcode("<?php echo $order_no?>", "datamatrix", {moduleSize: 7, showHRI: false });	
                        document.write('\n<?php echo $order_no?>\n'.fontsize(2));
					</script>
                </td>   
            </tr>           
        </table> 	
        <script type="text/javascript">
            window.print();
        </script>      
    </div>

    <?php 
        //라벨 출력 후 데이터 처리
        $in_record_query = "INSERT INTO CONNECT.dbo.FIELD_PROCESS_LABEL(ORDER_NO) VALUES(?)";              
        sqlsrv_query($connect, $in_record_query, array($order_no));
    ?>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?> 
</body>
</html>

<?php 
    echo "<script type=text/javascript>";
    echo "setTimeout(move2, 2000);";
    echo "</script>"; 
?>