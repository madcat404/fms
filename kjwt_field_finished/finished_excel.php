<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.08.24>
	// Description:	<finished 엑셀 다운로드>
    // Last Modified: <25.09.25> - Upgraded to PhpSpreadsheet, Refactored for PHP 8.x and Security
    // =============================================	  
    
    // 중요: 인증/세션 로직은 보안을 위해 반드시 활성화해야 합니다.
    require_once __DIR__ .'/../session/session_check.php';
    require_once __DIR__ .'/../vendor/autoload.php';
    include_once __DIR__ . '/../DB/DB2.php'; 
    include_once __DIR__ . '/../FUNCTION.php'; 

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    ini_set('memory_limit', '1024M');

    // --- 입력 값 검증 ---
    $s_dt3 = $_GET["s_dt"] ?? null;
    $e_dt3 = $_GET["e_dt"] ?? null;

    $date_regex = '/^\d{4}-\d{2}-\d{2}$/';
    if (!$s_dt3 || !$e_dt3 || !preg_match($date_regex, $s_dt3) || !preg_match($date_regex, $e_dt3)) {
        header("HTTP/1.1 400 Bad Request");
        die("오류: 날짜 범위가 잘못되었거나 누락되었습니다. (형식: YYYY-MM-DD)");
    }

    $ClosingDT = date('Y-m-d', strtotime($s_dt3 . ' -1 day'));

    // --- 매개변수화된 쿼리로 SQL Injection 방지 ---
    $sql = "SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS, AS_YN 
            FROM CONNECT.dbo.FINISHED_INPUT_LOG 
            WHERE SORTING_DATE BETWEEN ? AND ? AND QT_GOODS > 0 AND CLOSING_YN='N' 
            GROUP BY CD_ITEM, AS_YN
            UNION ALL
            SELECT CD_ITEM, SUM(QT_GOODS) AS QT_GOODS, AS_YN 
            FROM CONNECT.dbo.FINISHED_INPUT_LOG 
            WHERE SORTING_DATE = ? AND QT_GOODS > 0 AND CLOSING_YN='Y' 
            GROUP BY CD_ITEM, AS_YN";

    $params = [$s_dt3, $e_dt3, $ClosingDT];
    $stmt = sqlsrv_query($connect, $sql, $params);

    if ($stmt === false) {
        die("데이터베이스 쿼리 실행에 실패했습니다.");
    }

    // --- PhpSpreadsheet를 사용한 엑셀 생성 ---
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 헤더 설정
    $sheet->setCellValue("A1", "CD_ITEM")
          ->setCellValue("B1", "QT_GOOD_INV")
          ->setCellValue("C1", "GI_SL")
          ->setCellValue("D1", "GR_SL")
          ->setCellValue("E1", "DC_RMK");

    $sheet->setCellValue("A2", "품목코드")
          ->setCellValue("B2", "이동수량")
          ->setCellValue("C2", "출고창고코드")
          ->setCellValue("D2", "입고창고코드")
          ->setCellValue("E2", "비고");

    // 데이터 채우기
    $row_index = 3; // 데이터는 3번째 행부터 시작
    while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $outstorage = ('A' == $data['AS_YN'] || 'AR' == $data['AS_YN']) ? "016" : "001";
        
        $sheet->setCellValue("A" . $row_index, Hyphen($data['CD_ITEM']));
        $sheet->setCellValue("B" . $row_index, $data['QT_GOODS']);
        $sheet->setCellValue("C" . $row_index, "010");
        $sheet->setCellValue("D" . $row_index, $outstorage);
        $sheet->setCellValue("E" . $row_index, "");
        $row_index++;
    }
    $last_row = $row_index - 1;

    // --- 스타일링 ---
    $sheet->getColumnDimension("A")->setWidth(15);
    $sheet->getColumnDimension("B")->setWidth(15);
    $sheet->getColumnDimension("C")->setWidth(15);
    $sheet->getColumnDimension("D")->setWidth(15);
    $sheet->getColumnDimension("E")->setWidth(15);

    if ($last_row >= 1) {
        $style_range = "A1:E" . $last_row;
        $sheet->getStyle($style_range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($style_range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
    
    $header_style_range = "A1:E2";
    $sheet->getStyle($header_style_range)->getFont()->setBold(true);
    $sheet->getStyle($header_style_range)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB("CECBCA");

    if ($last_row >= 3) {
        $sheet->getStyle("A3:E" . $last_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB("F4F4F4");
    }

    $sheet->setTitle("완성품입고");
    $spreadsheet->setActiveSheetIndex(0);

    // --- 브라우저로 파일 출력 ---
    $filename = "완성품입고_" . date("Ymd", strtotime($s_dt3));
    
    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    // --- 자원 해제 ---
    if (isset($connect)) {
        sqlsrv_close($connect);
    }
    exit();
?>