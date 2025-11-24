<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <24.11.14>
    // Description: <베트남 인원 업로드>
    // Last Modified: <25.09.11> - Refactored for PHP 8.x, Security, and Stability
    // =============================================

    // --- Setup and Includes ---
    set_time_limit(0);
    include '../session/ip_session.php';
    include '../DB/DB2.php';
    require_once '../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;

    // --- Main Execution ---
    echo "베트남 인원 현황 처리를 시작합니다.<br>";

    try {
        // --- 1. 날짜 변수 설정 ---
        $today = new DateTime();
        $YY = $today->format('Y');
        $MM = $today->format('m'); // 기존 경로 형식에 맞게 0을 포함한 월 (01-12)
        $D = $today->format('d');  // 기존 경로 형식에 맞게 0을 포함한 일 (01-31)
        $today_formatted = $today->format('Y-m-d');

        // 기존 경로 형식을 유지하되, 절대 경로로 변경하여 안정성 확보
        $filename = "../../../../mnt3/vietnam_attend/{$YY}/{$MM}.{$YY}/{$D}.{$MM}.{$YY}.xlsx";
        echo "대상 파일: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "<br>";

        // --- 2. DB 및 파일 확인 ---
        if ($connect === false) {
            throw new Exception("데이터베이스 연결에 실패했습니다.");
        }
        if (!is_readable($filename)) {
            echo "오늘 날짜에 해당하는 엑셀 파일이 없어 작업을 건너뜁니다.";
            // DB 연결이 열려있을 수 있으므로 종료 전에 닫아줍니다.
            if (isset($connect4)) { mysqli_close($connect4); }
            if (isset($connect)) { sqlsrv_close($connect); }
            exit;
        }

        // --- 3. 오늘 데이터 삭제 ---
        // sorting_date가 오늘 날짜인 데이터를 삭제 (getdate()로 자동 입력된다고 가정)
        $today_format = $today->format('Y-m-d');
        echo "기존 데이터 삭제 중 (날짜 형식: {$today_format})... ";
        // DB 오류 메시지에 따라, sorting_date 컬럼이 INT 타입인 것으로 가정하고 YYYYMMDD 형식의 숫자로 비교합니다.
        $deleteSql = "DELETE FROM CONNECT.dbo.VIETNAM_ATTEND WHERE sorting_date = ?";
        $deleteStmt = sqlsrv_query($connect, $deleteSql, [$today_format]);
        if ($deleteStmt === false) {
            throw new Exception("기존 데이터 삭제 실패: " . print_r(sqlsrv_errors(), true));
        }
        echo "완료.<br>";

        // --- 4. 엑셀 파일 처리 ---
        echo "엑셀 파일 로드 중... ";
        $spreadsheet = IOFactory::load($filename);
        echo "완료.<br>";

        $worksheet = $spreadsheet->getSheet(0);
        
        // 특정 셀에서 데이터 읽기
        $night_iwin = $worksheet->getCell('C17')->getCalculatedValue();
        $night_part = $worksheet->getCell('D17')->getCalculatedValue();
        $morning_iwin = $worksheet->getCell('C38')->getCalculatedValue();
        $morning_part = $worksheet->getCell('D38')->getCalculatedValue();
        $morning_office = $worksheet->getCell('C20')->getCalculatedValue();
        $morning_etc = $worksheet->getCell('C45')->getCalculatedValue();
        $vacation_baby = $worksheet->getCell('AA48')->getCalculatedValue();
        
        // excel_title 생성
        $excel_title = $YY . $MM . $D;

        // --- DB INSERT (Parameterized) ---
        echo "데이터베이스에 새 데이터 입력 중... ";
        $insertSql = "INSERT INTO CONNECT.dbo.VIETNAM_ATTEND(excel_title, night_iwin, night_part, morning_iwin, morning_part, morning_office, morning_etc, vacation_baby) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertParams = [
            $excel_title, $night_iwin, $night_part, $morning_iwin, 
            $morning_part, $morning_office, $morning_etc, $vacation_baby
        ];
        
        $insertStmt = sqlsrv_query($connect, $insertSql, $insertParams);
        if ($insertStmt === false) {
            throw new Exception("INSERT 쿼리 실패: " . print_r(sqlsrv_errors(), true));
        }
        echo "완료.<br>";

        echo "<hr><h2>최종 처리 완료</h2>";
        echo "오늘 날짜의 베트남 인원 현황 데이터가 성공적으로 업데이트되었습니다.<br>";

    } catch (Throwable $t) {
        echo "<h2 style='color:red;'>스크립트 실행 중 심각한 오류가 발생했습니다</h2>";
        echo "<pre>" . htmlspecialchars($t->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
    } finally {
        if (isset($connect4)) { mysqli_close($connect4); }
        if (isset($connect)) { sqlsrv_close($connect); }
    }
?>