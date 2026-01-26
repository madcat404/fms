<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.02.18>
    // Description:	<bb 엑셀 다운로드>
    // Last Modified: <25.09.18> - Refactored for PHP 8.x, Security, and Performance
    // =============================================

    /*
     * [보안 및 호환성 수정 사항]
     * 1. SQL Injection 방지: GET 파라미터를 직접 쿼리에 삽입하는 대신, 매개변수화된 쿼리(prepared statements)를 사용하도록 수정했습니다.
     * 2. 라이브러리 교체: 더 이상 지원되지 않는 PHPExcel 대신, 공식 후속 라이브러리인 PhpSpreadsheet를 사용하도록 변경했습니다.
     * 3. 입력 값 검증: GET으로 받은 날짜 값에 대해 기본적인 형식 검사를 수행합니다.
     * 4. 인증 문제 해결 권고:
     *    - 기존 '세션을 집어 넣으면 엑셀이 깨짐' 문제는 보통 세션 시작 후 다른 내용(예: 오류 메시지, 공백)이 출력되어 HTTP 헤더 전송에 실패하기 때문에 발생합니다.
     *    - 근본적인 해결을 위해서는 세션 로직을 포함한 후, 엑셀 데이터 전송 전에 출력 버퍼를 정리하는(ob_clean()) 등의 조치가 필요합니다.
     *    - 현재는 보안을 위해 인증 로직이 반드시 필요함을 알리는 주석을 남깁니다.
     */

    // 중요: 인증/세션 로직은 보안을 위해 반드시 활성화해야 합니다.
    require_once __DIR__ . '/../session/session_check.php';     
    // Composer autoload를 사용하여 PhpSpreadsheet 라이브러리를 로드합니다.
    require_once __DIR__ . '/../vendor/autoload.php';
    include_once __DIR__ . '/../DB/DB2.php';    
    
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    ini_set('memory_limit', '1024M');

    // --- 입력 값 검증 ---
    $s_dt3 = $_GET["s_dt"] ?? null;
    $e_dt3 = $_GET["e_dt"] ?? null;

    // Y-m-d 형식의 날짜인지 간단히 확인합니다.
    $date_regex = '/^\d{4}-\d{2}-\d{2}$/';
    if (!$s_dt3 || !$e_dt3 || !preg_match($date_regex, $s_dt3) || !preg_match($date_regex, $e_dt3)) {
        // 부적절한 파라미터에 대한 처리
        header("HTTP/1.1 400 Bad Request");
        die("오류: 날짜 범위가 잘못되었거나 누락되었습니다. (형식: YYYY-MM-DD)");
    }

    // --- 매개변수화된 쿼리로 SQL Injection 방지 ---
    $Query_FinishHistory = "SELECT CD_ITEM, SUM(COMPLETE) AS COMPLETE from CONNECT.dbo.BB_OUTPUT_LOG WHERE SORTING_DATE between ? and ? and COMPLETE > 0 group by CD_ITEM";
    $params = [$s_dt3, $e_dt3];
    // 정의되지 않은 $options 변수 제거
    $Result_FinishHistory = sqlsrv_query($connect, $Query_FinishHistory, $params);

    if ($Result_FinishHistory === false) {
        // 실제 운영 환경에서는 사용자에게 에러를 직접 노출하지 말고, 로그 파일에 기록하는 것이 좋습니다.
        // error_log(print_r(sqlsrv_errors(), true));
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
    while ($Data_FinishHistory = sqlsrv_fetch_array($Result_FinishHistory, SQLSRV_FETCH_ASSOC)) {
        $sheet->setCellValue("A" . $row_index, $Data_FinishHistory['CD_ITEM']);
        $sheet->setCellValue("B" . $row_index, $Data_FinishHistory['COMPLETE']);
        $sheet->setCellValue("C" . $row_index, "003");
        $sheet->setCellValue("D" . $row_index, "015");
        $sheet->setCellValue("E" . $row_index, "");
        $row_index++;
    }
    $last_row = $row_index - 1;

    // --- 스타일링 ---
    // 가로 넓이 조정
    $sheet->getColumnDimension("A")->setWidth(10);
    $sheet->getColumnDimension("B")->setWidth(15);
    $sheet->getColumnDimension("C")->setWidth(15);
    $sheet->getColumnDimension("D")->setWidth(15);
    $sheet->getColumnDimension("E")->setWidth(15);

    if ($last_row >= 1) {
        $style_range = "A1:E" . $last_row;
        // 전체 가운데 정렬
        $sheet->getStyle($style_range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // 전체 테두리 지정
        $sheet->getStyle($style_range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
    
    // 타이틀 부분 스타일
    $header_style_range = "A1:E2";
    $sheet->getStyle($header_style_range)->getFont()->setBold(true);
    $sheet->getStyle($header_style_range)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB("CECBCA");

    // 내용 부분 스타일 (데이터가 있을 경우)
    if ($last_row >= 3) {
        $sheet->getStyle("A3:E" . $last_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB("F4F4F4");
    }

    // 시트 이름
    $sheet->setTitle("BB출고내역");

    // 첫번째 시트로 활성화
    $spreadsheet->setActiveSheetIndex(0);

    // --- 브라우저로 파일 출력 ---
    // 파일 이름
    $filename = "BB출고_" . date("Ymd", strtotime($s_dt3));
    
    // 기존 출력 버퍼를 지워서 엑셀 파일이 깨지는 것을 방지
    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    header('Cache-Control: max-age=0');
    
    // Excel5(.xls) 대신 Excel2007(.xlsx) 포맷 사용
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    // --- 자원 해제 ---
    if (isset($connect)) {
        sqlsrv_close($connect);
    }
    exit(); // 파일 출력 후 스크립트 종료