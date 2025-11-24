<?php
// =============================================
// Author: KWON SUNG KUN - sealclear@naver.com
// Create date: 25.04.22
// Description: 로그아웃 프로세스
// =============================================
session_start();
session_unset();
session_destroy();

// 로그아웃 메시지와 함께 리다이렉트
header("Location: login.php?message=" . urlencode("로그아웃 되었습니다."));
exit;