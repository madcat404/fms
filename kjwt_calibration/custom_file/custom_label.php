<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.04.28>
	// Description:	<검교정 라벨발행>	
    // =============================================

    
    $title31= $_GET['title31'];

    IF($title31=='')
    {
        $title31="1";
    }
    else {     
        $title31 = $title31 + 1;
    }   
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_barcode.php' ?>

    <!-- 타임아웃 -->
    <script type="text/javascript">
        function move() {
            location.href="https://fms.iwin.kr/index.php";
        }
        function move2() {
            location.href="custom_label.php?title31=<?php echo $title31?>";
        }
    </script> 
</head>

<body>    
    <div>    
        <table style="width: 100px; height: 140px; border-collapse: collapse; text-align:center; margin:auto;">		
            <tr>			
				<td id="bcTarget" style="text-align:center;">
					<script type="text/javascript">
                        $("#bcTarget").barcode("https://fms.iwin.kr/kjwt_calibration/calibration_pop.php?no=<?php echo $title31; ?>", "datamatrix", { showHRI: false });	
                        document.write('\n<?php echo $title31?>\n'.fontsize(2));
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
    if($title31 >= '218') {     
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