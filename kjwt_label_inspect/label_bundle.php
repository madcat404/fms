<?php
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.12.20>
	// Description:	<라벨중복검사기 라벨>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
    // =============================================
    include 'label_bundle_status.php';    
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- 헤드 -->
    <?php include '../head_barcode.php' ?>  	

    <!-- 화면이동 -->
    <script type="text/javascript">
        function move() {
            location.href="label_inspect.php";
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
                            // XSS 방지를 위해 htmlspecialchars 사용
                            $safe_NoHyphen_today = htmlspecialchars($NoHyphen_today ?? '', ENT_QUOTES, 'UTF-8');
                            $safe_cd_item = htmlspecialchars($cd_item ?? '', ENT_QUOTES, 'UTF-8');
                            $safe_lot_num = htmlspecialchars($lot_num ?? '', ENT_QUOTES, 'UTF-8');
                            $safe_qt_goods = htmlspecialchars($qt_goods ?? '', ENT_QUOTES, 'UTF-8');
                        ?>
                        $("#bcTarget").barcode("V^<?php echo $safe_NoHyphen_today; ?>^<?php echo $safe_cd_item; ?>^<?php echo $safe_lot_num; ?>^<?php echo $safe_qt_goods; ?>", "datamatrix", { showHRI: false });	
                        document.write('\n<?php echo $safe_cd_item; ?>\n'.fontsize(2));
                        document.write('<?php echo $safe_NoHyphen_today; ?>\n'.fontsize(2));
                        document.write('<?php echo $safe_lot_num; ?>\n'.fontsize(2));	
                        document.write('<?php echo $safe_qt_goods; ?>\n'.fontsize(2));
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
        // SQL Injection 방지를 위해 파라미터화된 쿼리 사용
        $Query_DataUpdate = "UPDATE CONNECT.dbo.LABEL_INSPECT SET PRINT_YN='Y', BOX_LOT_NUM=? WHERE PRINT_YN='N'";
        $params_update = array($lot_num);
        $result_update = sqlsrv_query($connect, $Query_DataUpdate, $params_update, $options);

        if ($result_update === false) {
            // 쿼리 실패 시 오류 처리
            // 실제 운영 환경에서는 오류를 로그 파일에 기록하는 것이 좋습니다.
            // die("데이터베이스 업데이트에 실패했습니다.");
        }
    ?> 

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?> 
</body>
</html>

<?php
    //2초후 화면이동 스크립트 실행
    //딜레이 없이 출력하면 특정 페이지 출력이 생략되는 경우가 생김
    echo "<script type=text/javascript>";
    echo "setTimeout(move, 2000);";
    echo "</script>"; 
?>
