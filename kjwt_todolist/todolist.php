<?php 
    // Prevent caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <22.05.04>
	// Description:	<to do list>
    // Last Modified: <25.09.25> - Refactored for PHP 8.x and security.
    // Modified: <2026.01.14> - Added Multiple File Upload & Wiki Templates
	// =============================================
    include_once 'todolist_status.php';

    // Helper function for safe HTML output
    function h($s) {
        return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
    }

    // 파일 목록 가져오는 도우미 함수 (뷰용)
    function getAttachedFiles($conn, $parentNo) {
        $files = [];
        $sql = "SELECT ORIG_FILENAME, SAVED_FILENAME FROM CONNECT.dbo.TO_DO_LIST_FILES WHERE PARENT_NO = ?";
        $params = array($parentNo);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $files[] = $row;
            }
        }
        return $files;
    }

    // ★ 위키 기본 양식 정의
    $template_problem = "[현상]\n- \n\n[요청사항]\n- ";
    $template_solution = "[원인]\n- \n\n[조치내용]\n- \n\n[결과]\n- ";
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include '../head_lv1.php' ?>      
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
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">기술지원요청(장애처리현황)</h1>
                    </div>               

                    <div class="row">

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">기록</a>
                                        </li>    
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-1th-tab" data-toggle="pill" href="#custom-tabs-one-1th" role="tab" aria-controls="custom-tabs-one-1th" aria-selected="false">내역</a>
                                        </li>    
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<BR>
                                            - 기술지원요청 게시판 제작<BR><BR>
                                            [기능]<BR>
                                            - 기술지원요청 입력 시 전산담당자에게 메일 발송<BR>
                                            - 기술지원 처리현황을 Y로 수정 시 요청자에게 메일 발송<BR><BR>
                                            [참조]<BR>
                                            - 요청자: 권성근 개인 프로젝트, 회계사<br>
                                            - 사용자: 전직원<br>
                                            - 내부회계관리제도로 인하여 전산에 요청한 내용을 기록하고 분기별로 보고<br><br>
                                            [제작일]<BR>
                                            - 22.05.04<br><br> 
                                        </div>
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">입력</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="todolist.php" enctype="multipart/form-data"> 
                                                        <div class="collapse show" id="collapseCardExample21">                                    
                                                            <div class="card-body">
                                                                <div class="row">   
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>요청자</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="requestor21" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>종류</label>
                                                                            <select name="kind21" class="form-control select2" style="width: 100%;">
                                                                                <option value="ERP" selected="selected">ERP</option>
                                                                                <option value="GW">GW</option>
                                                                                <option value="NAS">NAS</option>                                                                                
                                                                                <option value="FMS">FMS</option>
                                                                                <option value="TMS">TMS</option>
                                                                                <option value="PDM">PDM</option>
                                                                                <option value="WEB">WEB</option>
                                                                                <option value="서버">서버</option>
                                                                                <option value="개발">개발</option>
                                                                                <option value="N/W">N/W</option>
                                                                                <option value="H/W">H/W</option>
                                                                                <option value="S/W">S/W</option>                                                                                
                                                                                <option value="ETC">ETC</option>                                                                                
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>중요도</label>
                                                                            <select name="IMPORTANCE21" class="form-control select2" style="width: 100%;">
                                                                                <option value="하" selected="selected">하</option>
                                                                                <option value="중">중</option>  
                                                                                <option value="상">상</option>                                                                           
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>내용</label>
                                                                            <div class="input-group">   
                                                                                <textarea rows="10" class="form-control" name="problem21" required><?php echo $template_problem; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>해결책</label>
                                                                            <div class="input-group">    
                                                                                <textarea rows="10" class="form-control" name="solution21"><?php echo $template_solution; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>첨부파일 (다중 선택 가능)</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" id="files" name="files[]" multiple onchange="updateFileLabel()"> 
                                                                                <label class="custom-file-label" id="fileLabel" for="files">파일선택</label>
                                                                            </div>                                                      
                                                                        </div>
                                                                    </div>                                
                                                                </div> 
                                                            </div> 

                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt21">입력</button>
                                                            </div>
                                                        </div>
                                                    </form>     
                                                </div>
                                            </div>

                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample22" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample22">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">처리현황</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="todolist.php"> 
                                                        <div class="collapse show" id="collapseCardExample22">
                                                            <div class="card-body table-responsive p-2">   
                                                                
                                                                <?php ModifyData2("todolist.php?modi=Y", "bt22", "Todolist"); ?>

                                                                <div id="table" class="table-editable">
                                                                    <table class="table table-bordered table-striped" id="table_nosort">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width:50px;">NO</th>
                                                                                <th>요청자</th>
                                                                                <th>종류</th>
                                                                                <th>중요도</th>   
                                                                                <th>내용</th>
                                                                                <th>첨부파일</th>
                                                                                <th>답변</th>  
                                                                                <th>요청일</th> 
                                                                                <th style="width:80px;">처리현황</th> 
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                for($i=1; $i<=$Count_NotWork; $i++) {		
                                                                                    $Data_NotWork = sqlsrv_fetch_array($Result_NotWork); 
                                                                                    $attachedFiles = getAttachedFiles($connect, $Data_NotWork['NO']);
                                                                            ?>
                                                                            <tr>
                                                                                <input name='solve_no<?php echo $i; ?>' value='<?php echo $Data_NotWork['NO']; ?>' type='hidden'>   
                                                                                <td><?php echo $Data_NotWork['NO']; ?></td>
                                                                                <td><?php echo $Data_NotWork['REQUESTOR']; ?></td>
                                                                                <td><?php echo $Data_NotWork['KIND']; ?></td>
                                                                                <td><?php echo $Data_NotWork['IMPORTANCE']; ?></td>
                                                                                <td><?php echo nl2br($Data_NotWork['PROBLEM']); ?></td>
                                                                                <td>
                                                                                    <?php 
                                                                                    if (!empty($attachedFiles)) {
                                                                                        foreach ($attachedFiles as $f) {
                                                                                            echo "<a href='../files/" . h($f['SAVED_FILENAME']) . "' target='_blank' class='d-block small text-primary'>📄 " . h($f['ORIG_FILENAME']) . "</a>";
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php if($modi=='Y') { ?> 
                                                                                        <textarea rows='10' class='form-control' name='SOLUTUIN<?php echo $i; ?>'><?php echo $Data_NotWork['SOLUTUIN'] ?: $template_solution; ?></textarea> 
                                                                                    <?php } else { echo nl2br($Data_NotWork['SOLUTUIN']); } ?>
                                                                                </td>
                                                                            
                                                                                <td><?php echo date_format($Data_NotWork['SORTING_DATE'],"Y-m-d"); ?></td>
                                                                                <td>
                                                                                <?php if($modi=='Y') { ?>
                                                                                    <select name="SOLVE_STATUS<?php echo $i; ?>" class="form-control select2" style="width: 100%;">
                                                                                        <option value="<?php echo $Data_NotWork['SOLVE']?>" selected="selected"><?php echo $Data_NotWork['SOLVE']?></option>
                                                                                        <option value="<?php echo ($Data_NotWork['SOLVE'] == 'Y' ? 'N' : 'Y'); ?>"><?php echo ($Data_NotWork['SOLVE'] == 'Y' ? 'N' : 'Y'); ?></option>                                                                                                
                                                                                    </select> 
                                                                                <?php } else { echo $Data_NotWork['SOLVE']; } ?>
                                                                                </td> 
                                                                            </tr> 
                                                                            <?php 
                                                                                    if($Data_NotWork == false) exit;
                                                                                }
                                                                            ?>                
                                                                        </tbody>
                                                                    </table>
                                                                </div>  
                                                                <input type="hidden" name="until" value="<?php echo $i; ?>">
                                                            </div>
                                                        </div>
                                                    </form> 
                                                </div>
                                            </div>                                            
                                        </div>  
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="custom-tabs-one-1th" role="tabpanel" aria-labelledby="custom-tabs-one-1th-tab">
                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample31" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample31">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h6>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="todolist.php"> 
                                                        <div class="collapse show" id="collapseCardExample31">                                    
                                                            <div class="card-body">
                                                                <div class="row">                                                                        
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt3 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt3">
                                                                            </div>
                                                                        </div>
                                                                    </div>                                   
                                                                </div> 
                                                            </div> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt31">검색</button>
                                                            </div>
                                                        </div>
                                                    </form>             
                                                </div>
                                            </div>  

                                            <div class="col-lg-12"> 
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample32" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample32">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h6>
                                                    </a>
                                                    <div class="collapse show" id="collapseCardExample32">
                                                        <div class="card-body table-responsive p-2">
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>NO</th>
                                                                        <th>요청자</th>
                                                                        <th>종류</th>
                                                                        <th>중요도</th>   
                                                                        <th>내용</th>
                                                                        <th>첨부파일</th>
                                                                        <th>답변</th>  
                                                                        <th>요청일</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        foreach ($Data_WorkHistory as $WorkHistory) 
                                                                        {		
                                                                            $files = getAttachedFiles($connect, $WorkHistory['NO']);
                                                                            $fileHtml = '';
                                                                            foreach($files as $f) {
                                                                                 $fileHtml .= "<a href='../files/" . h($f['SAVED_FILENAME']) . "' target='_blank' class='d-block small text-primary'>📄 " . h($f['ORIG_FILENAME']) . "</a>";
                                                                            }

                                                                            echo "<tr>
                                                                                    <td>" . h($WorkHistory['NO']) . "</td>
                                                                                    <td>" . h($WorkHistory['REQUESTOR']) . "</td>
                                                                                    <td>" . h($WorkHistory['KIND']) . "</td>
                                                                                    <td>" . h($WorkHistory['IMPORTANCE']) . "</td>
                                                                                    <td>" . nl2br(h($WorkHistory['PROBLEM'])) . "</td>
                                                                                    <td>" . $fileHtml . "</td>
                                                                                    <td>" . nl2br(h($WorkHistory['SOLUTUIN'])) . "</td>
                                                                                    <td>" . date_format($WorkHistory['SORTING_DATE'], "Y-m-d") . "</td>
                                                                                </tr>";                                                       
                                                                        }
                                                                    ?>     
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

    <?php include '../plugin_lv1.php'; ?> 
    
    <script>
    function updateFileLabel() {
        var input = document.getElementById('files');
        var label = document.getElementById('fileLabel');
        var count = input.files.length;
        if (count > 1) label.innerText = count + '개의 파일이 선택됨';
        else if (count === 1) label.innerText = input.files[0].name;
        else label.innerText = '파일선택';
    }
    </script>
</body>
</html>

<?php 
    if(isset($connect4)) mysqli_close($connect4);	
    if(isset($connect)) sqlsrv_close($connect);	
?>