<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.04.28>
	// Description:	<검교정 라벨발행>
    // Last Modified: <25.09.24> - Refactored for PHP 8.x, Security, and Performance
    // =============================================
    include 'calibration_label_force_status.php';    
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_barcode.php' ?>

    <!-- 타임아웃 -->
    <script type="text/javascript">
        function move() {
            // URL 파라미터를 안전하게 인코딩
            const cost = <?php echo (int)$cost - 1; ?>;
            const item41 = <?php echo json_encode($cd_item); ?>;
            const note41 = <?php echo json_encode($note); ?>;
            const title31 = <?php echo json_encode($title31); ?>;
            location.href=`calibration_label_force.php?cost=${cost}&item41=${item41}&note41=${note41}&title31=${title31}`;
        }
        function move2() {
            location.href="calibration.php";
        }
    </script> 
</head>

<body>    
    <div>    
        <table style="width: 100px; height: 140px; border-collapse: collapse; text-align:center; margin:auto;">		
            <tr>			
				<td id="bcTarget" style="text-align:center;">
					<script type="text/javascript">
                        // json_encode를 사용하여 XSS 방지
                        const barcodeData = <?php echo json_encode("https://fms.iwin.kr/kjwt_calibration/calibration.php?no=" . $title31); ?>;
                        const titleText = <?php echo json_encode($title31); ?>;

                        if (barcodeData && titleText) {
                            $("#bcTarget").barcode(barcodeData, "datamatrix", { showHRI: false });	
                            document.write('<br>' + titleText.fontsize(2));
                        }
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
    if($cost > 0) {       
        echo "<script type=text/javascript>setTimeout(move, 2000);</script>";
    }
    else {
        echo "<script type=text/javascript>setTimeout(move2, 2000);</script>"; 
    }
?>