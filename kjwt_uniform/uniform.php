<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <24.05.08>
	// Description:	<근무복 지급>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
	// =============================================
    include_once 'uniform_status.php';

    // Determine which UI to load based on device type
    if (isMobile()) {
        include_once 'uniform_mobile.php';
    } else {
        include_once 'uniform_desktop.php';
    }
?>

<?php 
    // DB 연결 메모리 회수
    if (isset($connect4) && $connect4) {
        mysqli_close($connect4);
    }
    if (isset($connect) && $connect) {
        sqlsrv_close($connect);
    }
?>