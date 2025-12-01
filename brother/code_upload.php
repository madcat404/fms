<?php

// ----------------------------------------------------------------------
// 1. [필수] 5개 변수 설정
// ----------------------------------------------------------------------

// DB 접속 정보
$db_host = '192.168.100.17'; // 또는 'localhost'
$db_user = 'webuser';        // DB 사용자 ID
$db_pass = 'kjwt8132365!'; // DB 비밀번호
$db_name = 'fms'; // DB 이름

// 업로드할 TXT 파일 경로
// ★★★★★ 중요: 웹 서버가 접근할 수 있는 *절대 경로*를 입력하세요.
// (예: 'C:/xampp/htdocs/BJDONG_CODE.txt' 또는 '/var/www/html/BJDONG_CODE.txt')
$txt_file_path = './CODE.txt';

// ----------------------------------------------------------------------
// 2. [선택] 스크립트 설정
// ----------------------------------------------------------------------

// 한 번에 삽입할 라인 수 (메모리가 충분하면 1000~2000 추천)
$batch_size = 1000;

// ★★★★★ 중요: 인코딩 설정 (한글 깨짐 발생 시 수정)
// 1. 'EUC-KR' (CP949): 공공데이터 원본 파일이 대부분 이 형식입니다. (기본값)
// 2. 'UTF-8': 만약 파일을 UTF-8로 저장했다면 이 값을 사용하세요.
$file_encoding = 'EUC-KR'; 

// ----------------------------------------------------------------------
// 3. 업로드 실행 코드 (이 아래는 수정하지 마세요)
// ----------------------------------------------------------------------

// 스크립트 실행 시간 제한 해제 (0 = 무제한)
set_time_limit(0);
// 메모리 제한 상향 (대용량 파일 처리)
ini_set('memory_limit', '512M');
// 브라우저에 실시간 진행 상황 출력
ob_implicit_flush(true);
ob_end_flush();

echo "<h1>법정동 코드 업로드 시작...</h1>";
echo "대상 파일: " . htmlspecialchars($txt_file_path) . "<br>";
echo "인코딩: " . $file_encoding . "<br>";
echo "---------------------------------------------------<br><br>";

try {
    // DB 연결 (PDO 사용, utf8mb4로 연결)
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    echo "DB 연결 성공.<br>";

    // 파일 열기
    $handle = fopen($txt_file_path, "r");
    if ($handle === false) {
        throw new Exception("파일을 열 수 없습니다. 경로를 확인하세요: " . htmlspecialchars($txt_file_path));
    }
    echo "파일 열기 성공. 데이터 처리를 시작합니다...<br>";

    /*
    // (선택사항) 다시 실행할 때 테이블을 비우려면 아래 주석을 해제하세요.
    $pdo->exec("TRUNCATE TABLE brother_standard_code");
    echo "테이블을 비웠습니다 (TRUNCATE).<br>";
    */

    // INSERT 쿼리 준비
    $sql_template = "INSERT INTO brother_standard_code (bjdong_code, bjdong_name, status) VALUES ";
    
    $batch_values = []; // (?, ?, ?) 플레이스홀더를 모으는 배열
    $batch_params = []; // 실제 데이터 값을 모으는 1차원 배열
    $line_number = 0;
    $total_inserted = 0;

    // 파일 한 줄씩 읽기
    while (($line = fgets($handle)) !== false) {
        $line_number++;

        // 1. 첫 번째 줄 (헤더) 건너뛰기
        if ($line_number == 1) {
            echo "헤더 라인(1줄)을 건너뛰었습니다.<br>";
            continue;
        }

        // 2. 인코딩 변환 (DB는 utf8mb4, 파일은 EUC-KR이라고 가정)
        // file_encoding이 UTF-8이 아닐 경우에만 변환 시도
        if (strcasecmp($file_encoding, 'UTF-8') != 0 && strcasecmp($file_encoding, 'UTF8') != 0) {
            $line = iconv($file_encoding, "UTF-8//IGNORE", $line);
        }
        
        $line = trim($line);

        // 3. 빈 줄 건너뛰기
        if (empty($line)) {
            continue;
        }

        // 4. 탭(TAB)으로 데이터 분리
        $columns = explode("\t", $line);

        // 5. 컬럼 수 확인 (3개가 아니면 오류 로그)
        if (count($columns) !== 3) {
            echo "<strong style='color:red;'>[오류] $line_number 번째 줄의 형식이 다릅니다 (데이터 3개 아님): " . htmlspecialchars($line) . "</strong><br>";
            continue;
        }
        
        // 6. 배치 배열에 추가
        $batch_values[] = "(?, ?, ?)";
        $batch_params[] = trim($columns[0]); // bjdong_code
        $batch_params[] = trim($columns[1]); // bjdong_name
        $batch_params[] = trim($columns[2]); // status

        // 7. 배치 크기 도달 시 DB에 삽입
        if (count($batch_values) >= $batch_size) {
            $sql = $sql_template . implode(", ", $batch_values);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($batch_params);

            $inserted_count = count($batch_values);
            $total_inserted += $inserted_count;
            
            echo "-> $total_inserted 줄 처리 완료 (배치 $inserted_count 건 삽입 성공)<br>";

            // 배치 초기화
            $batch_values = [];
            $batch_params = [];
        }
    } // end while

    // 8. 마지막 남은 배치 삽입
    if (!empty($batch_values)) {
        $sql = $sql_template . implode(", ", $batch_values);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($batch_params);

        $inserted_count = count($batch_values);
        $total_inserted += $inserted_count;
        echo "-> $total_inserted 줄 처리 완료 (마지막 배치 $inserted_count 건 삽입 성공)<br>";
    }

    fclose($handle);
    echo "<br>---------------------------------------------------<br>";
    echo "<h2>🎉 업로드 성공! 총 $total_inserted 건의 데이터가 삽입되었습니다.</h2>";

} catch (PDOException $e) {
    echo "<h2 style='color:red;'>DB 오류 발생</h2>";
    echo "<strong>오류 메시지:</strong> " . htmlspecialchars($e->getMessage()) . "<br>";
    if (isset($line)) {
        echo "<strong>오류 발생 지점 (추정):</strong><br><pre>" . htmlspecialchars($line) . "</pre>";
    }
    if (isset($sql)) {
        echo "<strong>실행 쿼리 (추정):</strong><br><pre>" . htmlspecialchars($sql) . "</pre>";
    }

} catch (Exception $e) {
    echo "<h2 style='color:red;'>일반 오류 발생</h2>";
    echo "<strong>오류 메시지:</strong> " . htmlspecialchars($e->getMessage()) . "<br>";
}

?>