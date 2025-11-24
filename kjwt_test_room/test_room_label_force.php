<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.04.03>
	// Description:	<테스트제품라벨>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================
    include 'test_room_label_force_status.php';    

    // Define variables with fallbacks to prevent errors
    $cost = $cost ?? 0;
    $cd_item = $cd_item ?? '';
    $note = $note ?? '';
    $NoHyphen_today = $NoHyphen_today ?? '';
    $lot_num = $lot_num ?? '';
    $contents41 = $contents41 ?? '';
    $test_user41 = $test_user41 ?? '';
    $sw41 = $sw41 ?? '';
    $sample_num41 = $sample_num41 ?? '';
    $purpose41 = $purpose41 ?? '';
    $hw41 = $hw41 ?? '';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_barcode.php' ?>

    <!-- 타임아웃 -->
    <script type="text/javascript">
        function move() {
            // Use urlencode for URL parameters
            location.href="test_room_label_force.php?cost=<?php echo urlencode($cost - 1); ?>&item41=<?php echo urlencode($cd_item); ?>&note41=<?php echo urlencode($note); ?>";
        }
        function move2() {
            location.href="test_room_process.php";
        }
    </script> 
</head>

<body>    
    <div>    
        <table style="width: 100px; height: 140px; border-collapse: collapse; text-align:center; margin:auto;">		
           	<tr>			
				<td id="bcTarget" style="text-align:center;">
					<script type="text/javascript">
                        // Use urlencode for URL parameters
                        const barcodeUrl = "https://fms.iwin.kr/kjwt_test_room/test_room_process.php?CD_ITEM=<?php echo urlencode($cd_item); ?>&ID=<?php echo urlencode($NoHyphen_today . $lot_num); ?>";
                        $("#bcTarget").barcode(barcodeUrl, "datamatrix", { showHRI: false });	

                        // Use json_encode to safely embed variables into JavaScript
                        document.write('\n' + <?php echo json_encode($cd_item); ?> + '\n'.fontsize(2));
                        document.write(<?php echo json_encode($NoHyphen_today); ?> + '\n'.fontsize(2));
                        document.write(<?php echo json_encode($lot_num); ?> + '\n'.fontsize(2));
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
        // Parameterize the query to prevent SQL Injection
        $in_record_query = "INSERT INTO CONNECT.dbo.TEST_ROOM_LABEL(CD_ITEM, LOT_DATE, LOT_NUM, NOTE, CONTENTS, TEST_USER, SW, SAMPLE_NUM, PURPOSE, HW) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $query_params = [
            $cd_item,
            $NoHyphen_today,
            $lot_num,
            $note,
            $contents41,
            $test_user41,
            $sw41,
            $sample_num41,
            $purpose41,
            $hw41
        ];
        // The $params and $options variables from the original code are ignored as they were used incorrectly.
        // A parameterized query passes parameters in the third argument.
        sqlsrv_query($connect, $in_record_query, $query_params);
    ?>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?> 
</body>
</html>

<?php 
    if($cost > 0) {       
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
