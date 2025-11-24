<?php
// --- 설정 ---
error_reporting(0); // 경고 메시지 숨기기 (Base64 디코딩 오류 등)
set_time_limit(300); // 실행 시간 5분으로 늘리기

// 1. .eml 파일이 있는 디렉토리 경로
$emlDirectory = '../eml';

// 2. 검색할 키워드
$keyword = '';
if (isset($_GET['keyword']) && !empty(trim($_GET['keyword']))) {
    $keyword = trim($_GET['keyword']);
}

// 3. 검색 결과를 저장할 배열
$foundFiles = [];
$error = '';

// --- 필수 확장 모듈 확인 ---
if (!function_exists('mb_decode_mimeheader')) {
    $error = "오류: 'mbstring' PHP 확장 모듈이 서버에 설치(활성화)되지 않았습니다. 한글을 검색할 수 없습니다.";
}

// --- 로직 ---
if (!empty($keyword) && empty($error)) {
    if (is_dir($emlDirectory)) {
        if ($handle = opendir($emlDirectory)) {
            while (false !== ($fileName = readdir($handle))) {
                $filePath = $emlDirectory . '/' . $fileName;

                if (is_file($filePath) && strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) == 'eml') {
                    
                    $content = @file_get_contents($filePath);
                    if ($content === false) continue; 

                    $found = false; // 이 파일에서 찾았는지 여부

                    // --- [검색 1] 디코딩된 '제목'에서 검색 ---
                    if (preg_match('/^Subject: (.*)$/mi', $content, $matches)) {
                        $decodedSubject = mb_decode_mimeheader($matches[1]);
                        if (mb_stripos($decodedSubject, $keyword) !== false) {
                            $found = true;
                        }
                    }

                    // --- [검색 2] '원본(Raw)' 텍스트에서 검색 ---
                    // (영문, URL, 인코딩되지 않은 문자열)
                    if (!$found && stripos($content, $keyword) !== false) {
                        $found = true;
                    }

                    // --- [검색 3] 'Quoted-Printable' 디코딩 후 본문 검색 ---
                    if (!$found) {
                        $decodedBodyQP = quoted_printable_decode($content);
                        // 원본 인코딩(EUC-KR 등)을 UTF-8로 변환 시도
                        $decodedBodyQP_UTF8 = mb_convert_encoding($decodedBodyQP, 'UTF-8', 'UTF-8, EUC-KR, CP949');
                        
                        if (mb_stripos($decodedBodyQP_UTF8, $keyword) !== false) {
                            $found = true;
                        }
                    }

                    // --- [검색 4] 'Base64' 디코딩 후 본문 검색 ---
                    if (!$found) {
                        // 'Content-Transfer-Encoding: base64' 이후의 블록들을 찾음
                        if (preg_match_all(
                            '/Content-Transfer-Encoding:\s*base64\s*[\r\n]+([a-zA-Z0-9+\/=\s\r\n]+)(?=\r?\n\r?\n|--)/m',
                            $content,
                            $base64Matches
                        )) {
                            foreach ($base64Matches[1] as $encodedBlock) {
                                // 공백/줄바꿈 제거
                                $cleanedBlock = preg_replace('/\s+/', '', $encodedBlock);
                                $decodedBodyB64 = base64_decode($cleanedBlock);
                                
                                // 원본 인코딩(EUC-KR 등)을 UTF-8로 변환 시도
                                $decodedBodyB64_UTF8 = mb_convert_encoding($decodedBodyB64, 'UTF-8', 'UTF-8, EUC-KR, CP949');

                                if (mb_stripos($decodedBodyB64_UTF8, $keyword) !== false) {
                                    $found = true;
                                    break; // 이 파일에서 찾았으므로 다음 파일로
                                }
                            }
                        }
                    }

                    // 4가지 검색 중 하나라도 성공했다면 결과에 추가
                    if ($found) {
                        $foundFiles[] = $fileName;
                    }
                }
            }
            closedir($handle);
        }
    } else {
        $error = "오류: EML 디렉토리를 찾을 수 없습니다. (경로: " . htmlspecialchars($emlDirectory) . ")";
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EML 메일 검색기 (v3 - 본문 포함)</title>
    <style>
        /* (스타일은 이전과 동일) */
        body { font-family: -apple-system, BlinkMacSystemFont, "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        form { margin-bottom: 20px; display: flex; }
        input[type="text"] { flex-grow: 1; padding: 10px; border: 2px solid #ccc; border-radius: 5px; }
        button { padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px; }
        button:hover { background: #0056b3; }
        h2 { border-bottom: 1px solid #eee; padding-bottom: 10px; }
        ul { list-style: none; padding-left: 0; }
        li { background: #f9f9f9; border: 1px solid #eee; padding: 12px; margin-bottom: 8px; border-radius: 5px; }
        .error { color: red; font-weight: bold; background: #ffebeb; padding: 10px; border-radius: 5px; }
        .no-result { color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📨 EML 메일 검색기 (v3 - 본문 포함)</h1>
        <form action="" method="GET">
            <input type="text" name="keyword" placeholder="검색할 키워드(제목, 본문, 주소 등)를 입력하세요" value="<?php echo htmlspecialchars($keyword); ?>">
            <button type="submit">검색</button>
        </form>

        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        
        <?php elseif (!empty($keyword)) : ?>
            <h2>검색 결과 (키워드: <strong><?php echo htmlspecialchars($keyword); ?></strong>)</h2>
            
            <?php if (!empty($foundFiles)) : ?>
                <p><?php echo count($foundFiles); ?>개의 메일을 찾았습니다.</p>
                <ul>
                    <?php foreach ($foundFiles as $file) : ?>
                        <li><?php echo htmlspecialchars($file); ?></li>
                    <?php endforeach; ?>
                </ul>
            
            <?php else : ?>
                <p class="no-result">"'<?php echo htmlspecialchars($keyword); ?>'" 키워드가 포함된 메일을 찾지 못했습니다.</p>
            <?php endif; ?>
            
        <?php endif; ?>
    </div>
</body>
</html>