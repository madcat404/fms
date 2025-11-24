<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <23.02.22>
	// Description:	<회사 입출문 - NFC 출문>
    // Last Modified: <25.09.29> - Refactored for PHP 8.x and security.
	// =============================================
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
</head>

<body>
    <script>
        var nameInput = prompt('이름을 입력하세요!');
      
        // Validate that the user provided a non-empty, non-whitespace value
        if (nameInput && nameInput.trim() !== '') {
            var name = nameInput.trim();
            var encodedName = encodeURIComponent(name);
            var url = 'gate.php?kind=OUT&outnfc=' + encodedName;
            location.href = url;
        } else {
            alert('이름이 입력되지 않았습니다. 입출문 페이지로 돌아갑니다.');
            location.href = 'gate.php';
        }
    </script>
    <noscript>
        <p>JavaScript가 필요합니다.</p>
    </noscript>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>
</body>

</html>