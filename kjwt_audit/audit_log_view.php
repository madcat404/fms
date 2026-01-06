<?php
// =============================================
// Author:  AI Assistant
// Create date: 2025-12-08
// Description: DB 변경 로그(Audit Log) 조회 페이지
// Note: MSSQL TB_AUDIT_LOG_HISTORY 테이블 조회
// UI Style: audit.php 완벽 동기화 + 버튼 색상 통일 (회색 스타일) + Bootstrap Grid Layout
// =============================================

// DB 연결 설정 파일 포함
include '../DB/DB2.php'; 
// 공통 함수 포함
include '../FUNCTION.php';

// 날짜 초기값 설정 (오늘 - 오늘)
$today = date("Y-m-d");
$searchRange = isset($_POST['search_range']) ? $_POST['search_range'] : "$today - $today";

// 날짜 파싱 (FUNCTION.php의 CropDate 로직 참고)
$startDate = substr($searchRange, 0, 10);
$endDate = substr($searchRange, 13, 10);

// 조회 결과 배열 초기화
$logData = [];

// DB 연결 확인 및 쿼리 실행
if (isset($connect) && $connect) {
    try {
        // 검색 쿼리 작성 (T-SQL, TOP 1000 제한, 날짜 범위 검색)
        $query = "SELECT
                    [LogID], 
                    [EventTime], 
                    [ActionID], 
                    [UserName], 
                    [TableName], 
                    [QueryText], 
                    [NOTE]
                  FROM [CONNECT].[dbo].[TB_AUDIT_LOG_HISTORY]
                  WHERE [EventTime] BETWEEN ? AND ?
                  AND [ActionID] IN ('IN', 'UP', 'DL')
                  ORDER BY [EventTime] DESC";

        // 파라미터 바인딩
        $params = [
            $startDate . ' 00:00:00.000',
            $endDate . ' 23:59:59.999'
        ];

        // 쿼리 준비 및 실행
        $stmt = sqlsrv_prepare($connect, $query, $params);

        if ($stmt === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        $result = sqlsrv_execute($stmt);

        if ($result === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        // 데이터 Fetch
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $logData[] = $row;
        }

        // 리소스 해제
        sqlsrv_free_stmt($stmt);

    } catch (Exception $e) {
        $errorMessage = "데이터 조회 중 오류가 발생했습니다: " . $e->getMessage();
    }
} else {
    $errorMessage = "데이터베이스 연결에 실패했습니다.";
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="max-age=31536000"/>
    <?php include '../head_lv1.php' ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css"/>

    <style>
        /* 긴 쿼리 텍스트 말줄임 처리 스타일 */
        .text-truncate-custom {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            vertical-align: middle;
        }
        /* 검색창 우측 정렬 보정 */
        div.dataTables_filter {
            text-align: right;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include '../nav.php' ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">DB 변경 로그 조회</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="tab-one" data-toggle="pill" href="#tab1">로그 조회</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            
                                            <div class="col-lg-12">
                                                <P>데이터조작(DML): IN 데이터 삽입 / UP 데이터 수정 / DL 데이터 삭제
                                                </P>
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseSearch" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseSearch">
                                                        <h6 class="m-0 font-weight-bold text-primary">검색 조건</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                        <div class="collapse show" id="collapseSearch">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control float-right" id="reservation" name="search_range" value="<?php echo htmlspecialchars($searchRange); ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-right">
                                                                <button type="submit" class="btn btn-primary">조회</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <?php if (isset($errorMessage)): ?>
                                                <div class="col-lg-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <?php echo $errorMessage; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="col-lg-12">
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseResult" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseResult">
                                                        <h6 class="m-0 font-weight-bold text-primary">조회 결과</h6>
                                                    </a>
                                                    
                                                    <div class="collapse show" id="collapseResult">
                                                        <div class="card-body table-responsive p-2">
                                                            <div id="table" class="table-editable">
                                                                <table class="table table-bordered table-striped mobile-responsive-table" id="table1" width="100%" cellspacing="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 5%;">ID</th>
                                                                            <th style="width: 15%;">발생 시간</th>
                                                                            <th style="width: 10%;">유형</th>
                                                                            <th style="width: 10%;">사용자</th>
                                                                            <th style="width: 15%;">테이블명</th>
                                                                            <th style="width: 35%;">쿼리 내용</th>     
                                                                            <th style="width: 35%;">비고</th>  
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php if (count($logData) > 0): ?>
                                                                            <?php foreach ($logData as $row): ?>
                                                                                <tr>
                                                                                    <td><?php echo htmlspecialchars($row['LogID']); ?></td>
                                                                                    <td>
                                                                                        <?php 
                                                                                            if ($row['EventTime'] instanceof DateTime) {
                                                                                                echo $row['EventTime']->format('Y-m-d H:i:s');
                                                                                            } else {
                                                                                                echo htmlspecialchars($row['EventTime']);
                                                                                            }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <?php 
                                                                                            $action = htmlspecialchars($row['ActionID']);
                                                                                            $badgeClass = 'secondary';
                                                                                            if ($action == 'INSERT') $badgeClass = 'success';
                                                                                            elseif ($action == 'UPDATE') $badgeClass = 'warning';
                                                                                            elseif ($action == 'DELETE') $badgeClass = 'danger';
                                                                                        ?>
                                                                                        <span class="badge badge-<?php echo $badgeClass; ?>"><?php echo $action; ?></span>
                                                                                    </td>
                                                                                    <td><?php echo htmlspecialchars($row['UserName']); ?></td>
                                                                                    <td><?php echo htmlspecialchars($row['TableName']); ?></td>
                                                                                    <td title="<?php echo htmlspecialchars($row['QueryText']); ?>">
                                                                                        <span class="text-truncate-custom">
                                                                                            <?php echo htmlspecialchars($row['QueryText']); ?>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td><?php echo htmlspecialchars($row['NOTE']); ?></td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include '../plugin_lv1.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            // 1. Date Range Picker 설정
            $('#reservation').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' - ',
                    applyLabel: "적용",
                    cancelLabel: "취소",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    daysOfWeek: ["일", "월", "화", "수", "목", "금", "토"],
                    monthNames: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
                    firstDay: 1
                },
                startDate: '<?php echo $startDate; ?>',
                endDate: '<?php echo $endDate; ?>'
            });            
            
            // 버튼 스타일 강제 보정 (Bootstrap 테마와 충돌 방지)
            $('.dt-buttons .btn').removeClass('btn-secondary').addClass('btn-secondary btn-sm');
        });
    </script>

</body>

</html>

<?php
    // DB 연결 종료
    if(isset($connect)) { sqlsrv_close($connect); } 
?>