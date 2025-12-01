<?php
    // =============================================
    // Author:      <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <22.02.15>
    // Description: <erp 엑셀 다운로드>
    // Update date: <24.09.04>
    // Description: <PHP 8.x, PhpSpreadsheet 적용>
    // =============================================

    include '../DB/DB2.php';
    require '../vendor/autoload.php'; // composer 설치 경로에 따라 조정
    include '../FUNCTION.php';
    ini_set('memory_limit', '1024M');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xls;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    //검색범위
    $s_dt3 = $_GET["s_dt"];
    $e_dt3 = $_GET["e_dt"];

    // $Minus7Day 변수가 FUNCTION.php 또는 DB2.php에 정의되어 있다고 가정합니다.
    // 만약 정의되어 있지 않다면, 아래 라인의 주석을 해제하고 설정해야 합니다.
    // $Minus7Day = date("Y-m-d", strtotime("-7 days"));

    if(isset($Minus7Day) && $s_dt3 > $Minus7Day && $e_dt3 > $Minus7Day) {
        //검사완료내역(한국)
        $Query_kFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' group by CD_ITEM, LOT_DATE";
        $Result_kFinishHistory = sqlsrv_query($connect, $Query_kFinishHistory);

        //검사완료내역(베트남)
        $Query_vFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' and QT_GOODS>0 group by CD_ITEM, LOT_DATE";
        $Result_vFinishHistory = sqlsrv_query($connect, $Query_vFinishHistory);

        //검사완료내역(중국)
        $Query_cFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' and QT_GOODS>0 group by CD_ITEM, LOT_DATE";
        $Result_cFinishHistory = sqlsrv_query($connect, $Query_cFinishHistory);
    }
    else {
        //검사완료내역(한국)
        $Query_kFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH2 WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' group by CD_ITEM, LOT_DATE";
        $Result_kFinishHistory = sqlsrv_query($connect, $Query_kFinishHistory);

        //검사완료내역(베트남)
        $Query_vFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_V2 WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' and QT_GOODS>0 group by CD_ITEM, LOT_DATE";
        $Result_vFinishHistory = sqlsrv_query($connect, $Query_vFinishHistory);

        //검사완료내역(중국)
        $Query_cFinishHistory = "SELECT CD_ITEM, LOT_DATE, SUM(QT_GOODS) AS QT_GOODS, SUM(REJECT_GOODS) AS REJECT_GOODS from CONNECT.dbo.FIELD_PROCESS_FINISH_C WHERE SORTING_DATE between '$s_dt3' and '$e_dt3' and QT_GOODS>0 group by CD_ITEM, LOT_DATE";
        $Result_cFinishHistory = sqlsrv_query($connect, $Query_cFinishHistory);
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 헤더 설정
    $sheet->setCellValue("A1", "TP_WO")
        ->setCellValue("B1", "CD_ITEM")
        ->setCellValue("C1", "QT_ITEM")
        ->setCellValue("D1", "DT_REL")
        ->setCellValue("E1", "DT_DUE")
        ->setCellValue("F1", "DC_RMK")
        ->setCellValue("G1", "PATN_ROUT")
        ->setCellValue("A2", "오더형태")
        ->setCellValue("B2", "품목")
        ->setCellValue("C2", "지시수량")
        ->setCellValue("D2", "시작일")
        ->setCellValue("E2", "종료일")
        ->setCellValue("F2", "비고")
        ->setCellValue("G2", "경로유형");

    $row = 3; // 데이터 시작 행

    // 한국 데이터 입력
    if ($Result_kFinishHistory) {
        while ($data = sqlsrv_fetch_array($Result_kFinishHistory, SQLSRV_FETCH_ASSOC)) {
            $sheet->setCellValue("A$row", "K10")
                ->setCellValue("B$row", Hyphen($data['CD_ITEM']))
                ->setCellValue("C$row", $data['QT_GOODS'])
                ->setCellValue("D$row", date("Ymd", strtotime($s_dt3)))
                ->setCellValue("E$row", date("Ymd", strtotime($e_dt3)))
                ->setCellValue("F$row", "")
                ->setCellValue("G$row", "S");
            $row++;
        }
    }

    // 베트남 데이터 입력
    if ($Result_vFinishHistory) {
        while ($data = sqlsrv_fetch_array($Result_vFinishHistory, SQLSRV_FETCH_ASSOC)) {
            $sheet->setCellValue("A$row", "K20") // 베트남 구분 코드
                ->setCellValue("B$row", Hyphen($data['CD_ITEM']))
                ->setCellValue("C$row", $data['QT_GOODS'])
                ->setCellValue("D$row", date("Ymd", strtotime($s_dt3)))
                ->setCellValue("E$row", date("Ymd", strtotime($e_dt3)))
                ->setCellValue("F$row", "")
                ->setCellValue("G$row", "S");
            $row++;
        }
    }

    // 중국 데이터 입력
    if ($Result_cFinishHistory) {
        while ($data = sqlsrv_fetch_array($Result_cFinishHistory, SQLSRV_FETCH_ASSOC)) {
            $sheet->setCellValue("A$row", "K30") // 중국 구분 코드
                ->setCellValue("B$row", Hyphen($data['CD_ITEM']))
                ->setCellValue("C$row", $data['QT_GOODS'])
                ->setCellValue("D$row", date("Ymd", strtotime($s_dt3)))
                ->setCellValue("E$row", date("Ymd", strtotime($e_dt3)))
                ->setCellValue("F$row", "")
                ->setCellValue("G$row", "S");
            $row++;
        }
    }

    $lastRow = $row - 1;

    if ($lastRow >= 2) {
        // 스타일 적용
        $sheet->getColumnDimension("A")->setWidth(10);
        $sheet->getColumnDimension("B")->setWidth(15);
        $sheet->getColumnDimension("C")->setWidth(15);
        $sheet->getColumnDimension("D")->setWidth(15);
        $sheet->getColumnDimension("E")->setWidth(15);
        $sheet->getColumnDimension("F")->setWidth(15);
        $sheet->getColumnDimension("G")->setWidth(15);

        // 정렬
        $sheet->getStyle("A1:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


        // 테두리
        $sheet->getStyle("A1:G{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // 헤더 스타일
        $sheet->getStyle("A1:G2")->getFont()->setBold(true);
        $sheet->getStyle("A1:G2")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCECBCA');

        // 내용 스타일
        if ($lastRow > 2) {
            $sheet->getStyle("A3:G{$lastRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF4F4F4');
        }
    }


    // 시트 이름
    $sheet->setTitle("검사실적");

    // 파일명 인코딩
    $filename = iconv("UTF-8", "EUC-KR", "검사실적_".date("Ymd", strtotime($s_dt3)));

    // 엑셀 파일 다운로드
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment;filename=".$filename.".xls");
    header("Cache-Control: max-age=0");

    $writer = new Xls($spreadsheet);
    $writer->save("php://output");
    exit;
?>
