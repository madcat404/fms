<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.02.12>
	// Description:	<시험실 체크시트>	
	// =============================================
    include 'test_room_status.php';
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <!-- 헤드 -->
    <?php include '../head_lv1.php' ?>
    <?php include '../head_popup.php' ?>
    <script>
        // 팝업창 열기
        function openPopup() {
            document.getElementById('popupBackground').style.display = 'block';
            document.getElementById('popup').style.display = 'block';
        }

        // 팝업창 닫기
        function closePopup() {
            document.getElementById('popupBackground').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }

        // 입력값을 확인 버튼으로 제출하는 함수
        function submitInput() {
            const input = document.getElementById("userInput").value;
            const note = document.getElementById("noteInput").value;
            if (input) {
                document.getElementById('who21').value = input;
                document.getElementById('note21').value = note;
                document.getElementById('bt21').value = 'on';                
                document.getElementById('mainForm').submit();
            } else {
                alert("값을 입력해 주세요.");
            }
        }
    </script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">      
        
        <!-- 메뉴 -->
        <?php include '../nav.php' ?>

        <!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" title="sidebartop_button">
                            <i class="fa fa-bars"></i>
                        </button>   
                        <h1 class="h3 mb-0 text-gray-800" style="padding-top:1em; display:inline-block; vertical-align:-4px;">시험실 체크리스트</h1>
                    </div>               

                    <!-- Begin row -->
                    <div class="row"> 

                        <!-- 탭 시작 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <div class="col-lg-12"> 
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab">
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-one" data-toggle="pill" href="#tab1">공지</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab2;?>" id="tab-two" data-toggle="pill" href="#tab2">가스경보기</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab3;?>" id="tab-three" data-toggle="pill" href="#tab3">일상점검</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab4;?>" id="tab-four" data-toggle="pill" href="#tab4">점검조회</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab5;?>" id="tab-five" data-toggle="pill" href="#tab5">설비기록</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $tab6;?>" id="tab-six" data-toggle="pill" href="#tab6">설비이력</a>
                                        </li>  
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        <!-- 1번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab-one">
                                            [목표]<br>
                                            - 시험실 가스경보기 점검 및 체크리스트 전산화<br><br>

                                            [참조]<br>
                                            - 요청자: 윤지성, 전우준<br>
                                            - 사용자: 시험팀<br>
                                            * 연소성시험기 가스누출 측정기 관련 안내사항<br>
                                            - 현재 모델은 "신우전자 가스누설경보기 LPG 전용 가스누출감지기 ND114 AC220V 방수형 감지기"<br>
                                            - KCS인증 용도로 측정기 사용하여야 함<br>
                                            - 현재 모델은 KCS인증 모델이 아니므로 추후 구매시 참고하여 구매할 예정<br>
                                            - 6개월마다 1회 점검 필요(30cm 옆에서 라이터 가스만 누출시켜서 경보기 울리는지 확인)<br>
                                            - 점검일 : 2025/2/15, 2025/8/15<br>                                           
                                            - 확인자의 싸인이 x박스로 출력되는 경우 gw.iwin.kr에 로그인을 하면 된다. (FIXME)<br>
                                            - 시험실 '점검했어요' 포맥스 바코드 형식 ex) https://fms.iwin.kr/kjwt_test_room/test_room_pop.php?equipment=1<br><br> 

                                            [제작일]<br>
                                            - 25.2.12<br><br>                                         
                                        </div>
                                        
                                        <!-- 2번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab2_text;?>" id="tab2" role="tabpanel" aria-labelledby="tab-two">
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample21" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample21">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">체크리스트</h1>
                                                    </a>
                                                    <form id="mainForm" method="POST" autocomplete="off" action="test_room.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample21">
                                                            <div class="card-body table-responsive p-2">  
                                                                <div id="table" class="table-editable"> 
                                                                    <table class="table table-bordered" id="table6">
                                                                        <thead>
                                                                            <tr>                                            
                                                                                <th style="text-align: center;">착안점</th>
                                                                                <th style="text-align: center;">구분</th>
                                                                                <th style="text-align: center;">점검</th>
                                                                                <th style="text-align: center;">마지막 점검자</th>
                                                                                <th style="text-align: center;">마지막 점검일</th>
                                                                                <th style="text-align: center;">이전 점검일</th>
                                                                                <th style="text-align: center;">조치사항</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody> 
                                                                            <tr><td style="vertical-align: middle; text-align: center;">가스경보기1</td>  
                                                                                <td rowspan="2" style="vertical-align: middle; text-align: center;">성능점검 (가스 검출 시 경보음이 발생하는가?)</td> 
                                                                                <td style="text-align: center;">
                                                                                <?php 
                                                                                    if(!empty($Data_TodayCheckList['GAS_INSPECT1']) && $Data_TodayCheckList['GAS_INSPECT1']=='on') {
                                                                                ?>
                                                                                        <input type='checkbox' name='GAS_INSPECT1' style='zoom: 2;' checked></td>  
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type='checkbox' name='GAS_INSPECT1' style='zoom: 2;'></td>  
                                                                                <?php 
                                                                                    } 
                                                                                ?>
                                                                                <td style='text-align: center;'><?php echo !empty($Data_GAS_INSPECT1) ? ($Data_GAS_INSPECT1[0]['WHO'] ?? '') : ''; ?></td>
                                                                                <?php  
                                                                                    $count = 0;
                                                                                    foreach ($Data_GAS_INSPECT1 as $data) {
                                                                                        if ($count >= 2) break;
                                                                                        if ($data['INSPECT_DT'] instanceof DateTime) {
                                                                                            echo "<td style='text-align: center;'>" . date_format($data['INSPECT_DT'], "Y-m-d") . "</td>";
                                                                                        } else {
                                                                                            $date = date_create($data['INSPECT_DT']);
                                                                                            if ($date) {
                                                                                                echo "<td style='text-align: center;'>" . date_format($date, "Y-m-d") . "</td>";
                                                                                            } else {
                                                                                                echo "<td style='text-align: center;'>Invalid date</td>";
                                                                                            }
                                                                                        }
                                                                                        $count++;
                                                                                    }
                                                                                ?>   
                                                                                <td style='text-align: center;'><?php echo !empty($Data_GAS_INSPECT1) ? ($Data_GAS_INSPECT1[0]['NOTE'] ?? '') : ''; ?></td>                                                                                                         
                                                                            </tr>   
                                                                            <tr>
                                                                                <td style="vertical-align: middle; text-align: center;">가스경보기2</td>  
                                                                                <td style="text-align: center;">
                                                                                <?php 
                                                                                    if(!empty($Data_TodayCheckList['GAS_INSPECT2']) && $Data_TodayCheckList['GAS_INSPECT2']=='on') {
                                                                                ?>
                                                                                        <input type='checkbox' name='GAS_INSPECT2' style='zoom: 2;' checked></td>  
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type='checkbox' name='GAS_INSPECT2' style='zoom: 2;'></td>  
                                                                                <?php 
                                                                                    }
                                                                                ?>
                                                                                <td style='text-align: center;'><?php echo !empty($Data_GAS_INSPECT2) ? ($Data_GAS_INSPECT2[0]['WHO'] ?? '') : ''; ?></td>
                                                                                <?php  
                                                                                    $count = 0;
                                                                                    foreach ($Data_GAS_INSPECT2 as $data) {
                                                                                        if ($count >= 2) break;
                                                                                        if ($data['INSPECT_DT'] instanceof DateTime) {
                                                                                            echo "<td style='text-align: center;'>" . date_format($data['INSPECT_DT'], "Y-m-d") . "</td>";
                                                                                        } else {
                                                                                            $date = date_create($data['INSPECT_DT']);
                                                                                            if ($date) {
                                                                                                echo "<td style='text-align: center;'>" . date_format($date, "Y-m-d") . "</td>";
                                                                                            } else {
                                                                                                echo "<td style='text-align: center;'>Invalid date</td>";
                                                                                            }
                                                                                        }
                                                                                        $count++;
                                                                                    } 
                                                                                ?>  
                                                                                <td style='text-align: center;'><?php echo !empty($Data_GAS_INSPECT2) ? ($Data_GAS_INSPECT2[0]['NOTE'] ?? '') : ''; ?></td>                 
                                                                            </tr>                                                                                                                                                                                                                      
                                                                        </tbody>
                                                                    </table> 
                                                                    <!-- 사용자 입력 -->
                                                                    <input type="hidden" id="who21" name="who21">
                                                                    <input type="hidden" id="note21" name="note21">
                                                                    <input type="hidden" id="bt21" name="bt21">                                                                
                                                                </div> 
                                                            </div>
                                                            <!-- /.card-body -->

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="button" class="btn btn-primary" onclick="openPopup()">입력</button>
                                                            </div>
                                                            <!-- /.card-footer -->  
                                                        </div>
                                                        <!-- /.Card Content - Collapse -->
                                                    </form> 
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                        </div>  

                                        <!-- 3번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab3_text;?>" id="tab3" role="tabpanel" aria-labelledby="tab-three">
                                            <div class="col-lg-12"> 
                                                <form method="POST" autocomplete="off" action="test_room.php?equipment=<?php echo $equipment; ?>"> 
                                                    <div id="table" class="table-editable"> 
                                                        <?php 
                                                            if(isMobile()) {
                                                        ?>
                                                            <table class="table table-bordered col-lg-12">
                                                                <tr>
                                                                    <th style="text-align: center;"><img src="../img/equipment<?php echo $equipment;?>.jpg" style="width: 100%; height: 30%"></th>                                                                                             
                                                                </tr>  
                                                            </table>   
                                                            
                                                            <table class="table table-bordered col-lg-12">
                                                                <tr>
                                                                    <th style="text-align: center;">장비명</th>  
                                                                    <td style="text-align: center;"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['EQUIPMENT_NAME'] ?? '-') : '-';  ?></td>                                                                                           
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center;">점검일</th>  
                                                                    <td style="text-align: center;"><?php echo $Hyphen_today; ?></td>                                                                                             
                                                                </tr>  
                                                                <tr>
                                                                    <th style="text-align: center;">점검방법</th> 
                                                                    <td style="text-align: center;">기능확인</td>                                                                                                
                                                                </tr> 
                                                                <tr> 
                                                                    <th style="text-align: center;">점검주기</th> 
                                                                    <td style="text-align: center;">1회/1일</td>                                                                                                
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center; vertical-align: middle;">점검자</th> 
                                                                    <td style="text-align: center; vertical-align: middle;"><?php if($checker_pop!='') {echo $checker_pop;} elseif($checker!='') {echo $checker;} else {echo '-';} ?></td>                                                                                               
                                                                </tr> 
                                                                <tr> 
                                                                    <th style="text-align: center; vertical-align: middle;">확인자</th> 
                                                                    <td style="text-align: center;"><?php if(!empty($Data_TodayCheckList['equipment_supervisor'])) { ?> 윤지성<img src="https://fms.iwin.kr/img/윤지성.jpg" style="width: 40px; height: 30px;"> <?php } else { ?><button type="submit" class="btn btn-info" name="supervisor" value="on">입력</button><?php } ?></td>   
                                                                </tr> 
                                                            </table>
                                                        <?php 
                                                            }
                                                            else {
                                                        ?>
                                                                <table class="table table-bordered col-lg-12">
                                                                    <tr>
                                                                        <th style="text-align: center;">장비명</th>  
                                                                        <td style="text-align: center;"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['EQUIPMENT_NAME'] ?? '-') : '-';  ?></td> 
                                                                        <th style="text-align: center;">점검일</th>  
                                                                        <td style="text-align: center;"><?php echo $Hyphen_today; ?></td>                                                                                             
                                                                    </tr>  
                                                                    <tr>
                                                                        <th style="text-align: center;">점검방법</th> 
                                                                        <td style="text-align: center;">기능확인</td>  
                                                                        <th style="text-align: center;">점검주기</th> 
                                                                        <td style="text-align: center;">1회/1일</td>                                                                                                
                                                                    </tr> 
                                                                    <tr>
                                                                        <th style="text-align: center; vertical-align: middle;">점검자</th> 
                                                                        <td style="text-align: center; vertical-align: middle;"><?php if($checker_pop!='') {echo $checker_pop;} elseif($checker!='') {echo $checker;} else {echo '-';} ?></td>  
                                                                        <th style="text-align: center; vertical-align: middle;">확인자</th> 
                                                                        <td style="text-align: center;"><?php if(!empty($Data_TodayCheckList['equipment_supervisor'])) { ?> 윤지성<img src="https://fms.iwin.kr/img/윤지성.jpg" style="width: 40px; height: 30px;"> <?php } else { ?><button type="submit" class="btn btn-info" name="supervisor" value="on">입력</button><?php } ?></td>                                                                                                
                                                                    </tr> 
                                                                </table>
                                                        <?php 
                                                            }
                                                        ?>

                                                        <table class="table table-bordered col-lg-12">
                                                            <thead>
                                                                <tr>                                            
                                                                    <th style="text-align: center;">점검내용</th>
                                                                    <th style="text-align: center;">점검</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody> 
                                                                <?php 
                                                                    foreach ($Data_TodayCheckList2 as $item) {
                                                                        echo "<tr>";
                                                                        echo "<td style='text-align: center;'>{$item['CHECKLIST']}</td>";
                                                                        echo "<td style='text-align: center;'>";
                                                                        $name = 'equipment'.$item['EQUIPMENT_NUM'].$item['EQUIPMENT_SEQ'];
                                                                        if (!empty($Data_TodayCheckList) && ($Data_TodayCheckList[$name] ?? 'off') == 'on') {
                                                                            echo "<input type='checkbox' name='{$name}' style='zoom: 2;' checked>";
                                                                        } else {
                                                                            echo "<input type='checkbox' name='{$name}' style='zoom: 2;'>";
                                                                        }
                                                                        echo "</td>";
                                                                        echo "</tr>";
                                                                    }
                                                                ?>  
                                                            </tbody>
                                                        </table>  
                                                        
                                                        <?php 
                                                            if($checker_pop!='') {
                                                        ?>
                                                                <input type="hidden" value="<?php echo $checker_pop; ?>" name="checker">
                                                        <?php
                                                            }
                                                            else {
                                                        ?>
                                                                <input type="hidden" value="<?php echo $checker; ?>" name="checker">
                                                        <?php
                                                            }
                                                        ?>                                                        
                                                        <div class="footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt31">입력</button>
                                                        </div>
                                                    </div>   
                                                </form>                                                 
                                            </div>
                                        </div>   
                                        
                                        <!-- 4번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab4_text;?>" id="tab4" role="tabpanel" aria-labelledby="tab-four">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample41" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample41">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="test_room.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample41">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 검색범위 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <?php 
                                                                                    if($dt4!='') {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt4 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt4">
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" name="dt4">
                                                                                <?php 
                                                                                    }
                                                                                ?>                                                                                 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 검색범위 -->   
                                                                    <!-- Begin 설비명 -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>설비명</label>
                                                                            <select name="equipment_name" class="form-control select12" style="width: 100%;">
                                                                                <option value="ALL" selected="selected">ALL</option>			
                                                                                <option value="1">1. X-RAY</option>
                                                                                <option value="3">3. Z-FOLDING</option>
                                                                                <option value="4">4. SEAT BACK 전후 작동내구 시험기</option>
                                                                                <option value="5">5. 복합환경내구시험기</option>
                                                                                <option value="6">6. 시트 진동내구 시험기</option>
                                                                                <option value="7">7. ROBOT 승강내구1</option>
                                                                                <option value="8">8. ROBOT 승강내구2</option>
                                                                                <option value="9">9. BENDING1</option>
                                                                                <option value="10">10. BENDING２</option>
                                                                                <option value="11">11. BENDING３</option>
                                                                                <option value="12">12. ＵＴＭ</option>
                                                                                <option value="13">13. LIFE CYCLE</option>
                                                                                <option value="14">14. KNEE TEST1</option>
                                                                                <option value="15">15. KNEE TEST2</option>
                                                                                <option value="16">16. KNEE TEST3</option>
                                                                                <option value="17">17. DRY OVEN</option>
                                                                                <option value="18">18. 항온항습기1</option>
                                                                                <option value="19">19. 항온항습기2</option>
                                                                                <option value="20">20. 항온항습기3</option>
                                                                                <option value="21">21. 먼지 시험기</option>
                                                                                <option value="22">22. 열충격 시험기</option>
                                                                                <option value="24">24. 풍량 시험기</option>
                                                                                <option value="25">25. 반무향실</option>
                                                                                <option value="26">26. 워크인챔버1</option>
                                                                                <option value="27">27. 워크인챔버2</option>
                                                                                <option value="28">28. 워크인챔버3</option>
                                                                                <option value="29">29. 염수분무시험기</option>
                                                                                <option value="30">30. 연소성 시험기</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 설비명 -->                                    
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt41">검색</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>  

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample42" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample42">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h1>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample42">
                                                        <div class="card-body table-responsive p-2">    
                                                            <table class="table table-bordered table-hover text-nowrap" id="table3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>점검일</th>
                                                                        <th>설비명</th>
                                                                        <th>점검내용</th>   
                                                                        <th>점검여부</th> 
                                                                        <th>점검자</th> 
                                                                        <th>확인자</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        for($i=1; $i<=$Count_Select; $i++)
                                                                        {		
                                                                            $Data_Select = sqlsrv_fetch_array($Result_Select);

                                                                            if($equipment_name=='ALL') {
                                                                                $Query_SelectList = "SELECT * from CONNECT.dbo.TEST_ROOM_CHECKLIST";              
                                                                                $Result_SelectList = sqlsrv_query($connect, $Query_SelectList, $params, $options);	
                                                                                $Count_SelectList = sqlsrv_num_rows($Result_SelectList);
                                                                            }
                                                                            ELSE {
                                                                                $Query_SelectList = "SELECT * from CONNECT.dbo.TEST_ROOM_CHECKLIST WHERE EQUIPMENT_NUM='$equipment_name'";              
                                                                                $Result_SelectList = sqlsrv_query($connect, $Query_SelectList, $params, $options);	
                                                                                $Count_SelectList = sqlsrv_num_rows($Result_SelectList);
                                                                            }

                                                                            for($j=1; $j<=$Count_SelectList; $j++)
                                                                            {
                                                                                $Data_SelectList = sqlsrv_fetch_array($Result_SelectList);
                                                                                $merge3 = "equipment".$Data_SelectList['EQUIPMENT_NUM'].$Data_SelectList['EQUIPMENT_SEQ'];
                                                                                $merge4 = "equipment_who".$Data_SelectList['EQUIPMENT_NUM'];                                                                               
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo date_format($Data_Select['SORTING_DATE'], "Y-m-d") ; ?></td>  
                                                                        <td><?php echo $Data_SelectList['EQUIPMENT_NAME']; ?></td>  
                                                                        <td><?php echo $Data_SelectList['CHECKLIST']; ?></td>  
                                                                        <td><?php if($Data_Select[$merge3]=='on') {echo "Y";} ?></td>   
                                                                        <td><?php echo $Data_Select[$merge4]; ?></td>
                                                                        <td>윤지성<img src="https://fms.iwin.kr/img/윤지성.jpg" style="width: 40px; height: 30px;"></td>  
                                                                    </tr> 
                                                                    <?php 
                                                                            }

                                                                            if($Data_Select == false) {
                                                                                exit;
                                                                            }
                                                                        }
                                                                    ?>       
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div> 
                                        </div>

                                        <!-- 5번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab5_text;?>" id="tab5" role="tabpanel" aria-labelledby="tab-five">
                                            <div class="col-lg-12"> 
                                                <form method="POST" autocomplete="off" action="test_room.php?equipment=<?php echo $equipment; ?>"> 
                                                    <div id="table" class="table-editable"> 
                                                        <?php 
                                                            if(isMobile()) {
                                                        ?>
                                                            <table class="table table-bordered col-lg-12">
                                                                <tr>
                                                                    <th style="text-align: center;"><img src="../img/equipment<?php echo $equipment;?>.jpg" style="width: 100%; height: 30%"></th>                                                                                             
                                                                </tr>  
                                                            </table>   
                                                            
                                                            <table class="table table-bordered col-lg-12">
                                                                <tr>
                                                                    <th style="text-align: center;">장비명</th>  
                                                                    <td style="text-align: center;"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['EQUIPMENT_NAME'] ?? '-') : '-';  ?></td>                                                                                           
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center;">제작처</th>  
                                                                    <td style="text-align: center;"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['BUY'] ?? '-') : '-'; ?></td>                                                                                             
                                                                </tr>  
                                                                <tr>
                                                                    <th style="text-align: center;">연락처</th>  
                                                                    <td style="text-align: center;"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['CALL'] ?? '-') : '-'; ?></td>                                                                                               
                                                                </tr>  
                                                                <tr>
                                                                    <th style="text-align: center;">기록자</th>  
                                                                    <td style="text-align: center;"><?php if($recorder!='') {echo $recorder;} else {echo '-';} ?></td>                                                                                               
                                                                </tr>                                                               
                                                            </table>
                                                        <?php 
                                                            }
                                                            else {
                                                        ?>
                                                                <table class="table table-bordered col-lg-12">
                                                                    <tr>
                                                                        <th style="text-align: center;">장비명</th>  
                                                                        <td style="text-align: center;"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['EQUIPMENT_NAME'] ?? '-') : '-';  ?></td> 
                                                                        <th style="text-align: center;">제작처</th>  
                                                                        <td style="text-align: center;"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['BUY'] ?? '-') : '-'; ?></td>  
                                                                        <th style="text-align: center;">연락처</th>  
                                                                        <td style="text-align: center;"><?php echo !empty($Data_TodayCheckList2) ? ($Data_TodayCheckList2[0]['CALL'] ?? '-') : '-'; ?></td>  
                                                                        <th style="text-align: center;">기록자</th>  
                                                                        <td style="text-align: center;"><?php if($recorder!='') {echo $recorder;} else {echo '-';} ?></td>                                                                                                  
                                                                    </tr>                                                                      
                                                                </table>
                                                        <?php 
                                                            }
                                                        ?>

                                                                <textarea 
                                                                    class="form-control mb-3" 
                                                                    name="content51" 
                                                                    rows="3" 
                                                                    placeholder="내용을 입력하세요"
                                                                    style="width: 100%; resize: vertical;"
                                                                    id="contentTextarea"
                                                                    autofocus
                                                                ></textarea>
      
                                                                <input type="text" class="form-control mb-3" name="cost51" placeholder="수리비용"> 

                                                                <input type="hidden" value="<?php echo $recorder; ?>" name="recorder51">

                                                        <div class="footer text-right">
                                                            <button type="submit" value="on" class="btn btn-primary" name="bt51">입력</button>
                                                        </div>
                                                    </div>   
                                                </form>                                                 
                                            </div>
                                        </div>
                                        
                                        <!-- 6번째 탭 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                        <div class="tab-pane fade <?php echo $tab6_text;?>" id="tab6" role="tabpanel" aria-labelledby="tab-six">
                                            <!-- 검색 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --> 
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample61" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample61">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">검색</h1>
                                                    </a>
                                                    <form method="POST" autocomplete="off" action="test_room.php"> 
                                                        <!-- Card Content - Collapse -->
                                                        <div class="collapse show" id="collapseCardExample61">                                    
                                                            <div class="card-body">
                                                                <!-- Begin row -->
                                                                <div class="row">                                                                        
                                                                    <!-- Begin 검색범위 -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>검색범위</label>
                                                                            <div class="input-group">                                                
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                    <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <?php 
                                                                                    if($dt6!='') {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" value="<?php echo $dt6 ?: date('Y-m-d').' ~ '.date('Y-m-d'); ?>" name="dt6">
                                                                                <?php 
                                                                                    }
                                                                                    else {
                                                                                ?>
                                                                                        <input type="text" class="form-control float-right kjwt-search-date" name="dt6">
                                                                                <?php 
                                                                                    }
                                                                                ?>                                                                                 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end 검색범위 -->                                                                                                          
                                                                </div> 
                                                                <!-- /.row -->         
                                                            </div> 
                                                            <!-- /.card-body -->                                                                       

                                                            <!-- Begin card-footer --> 
                                                            <div class="card-footer text-right">
                                                                <button type="submit" value="on" class="btn btn-primary" name="bt61">검색</button>
                                                            </div>
                                                            <!-- /.card-footer -->   
                                                        </form>             
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div>  

                                            <!-- 결과!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                            <div class="col-lg-12"> 
                                                <!-- Collapsable Card Example -->
                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <a href="#collapseCardExample62" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample62">
                                                        <h1 class="h6 m-0 font-weight-bold text-primary">결과</h1>
                                                    </a>
                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample62">
                                                        <div class="card-body table-responsive p-2">    
                                                            <table class="table table-bordered table-hover text-nowrap" id="table1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>설비번호</th>
                                                                        <th>설비명</th>
                                                                        <th>내용</th>
                                                                        <th>수리비용</th>  
                                                                        <th>기록자</th>   
                                                                        <th>기록일</th>   
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        for($i=1; $i<=$Count_RecordSelect; $i++)
                                                                        {		
                                                                            $Data_RecordSelect = sqlsrv_fetch_array($Result_RecordSelect);
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $Data_RecordSelect['EQUIPMENT_NUM']; ?></td>  
                                                                        <td><?php echo $Data_RecordSelect['EQUIPMENT_NAME']; ?></td>  
                                                                        <td><?php echo $Data_RecordSelect['NOTE']; ?></td>  
                                                                        <td><?php echo $Data_RecordSelect['COST']; ?></td> 
                                                                        <td><?php echo $Data_RecordSelect['RECORDER']; ?></td>   
                                                                        <td><?php echo date_format($Data_RecordSelect['RECORD_DATE'], "Y-m-d H:i:s") ; ?></td>  
                                                                    </tr> 
                                                                    <?php 
                                                                            if($Data_RecordSelect == false) {
                                                                                exit;
                                                                            }
                                                                        }
                                                                    ?>       
                                                                </tbody>
                                                            </table>                                     
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.Card Content - Collapse -->
                                                </div>
                                                <!-- /.card -->
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   

                        <!-- end !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                    
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- 팝업창 HTML -->
    <div class="popup-background" id="popupBackground"></div>
    <div class="popup" id="popup">
        <button class="close-btn" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></button>
        <p>입력</p>
        <input type="text" id="userInput" class="input-field" placeholder="점검자" />  
        <br>
        <input type="text" id="noteInput" class="input-field" placeholder="조치사항" /> 
        <div class="popup-buttons">
            <button class="confirm-btn" onclick="submitInput()">확인</button>
            <button class="close-btn-popup" onclick="closePopup()">닫기</button>
        </div>   
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>

    <script>
        // tab-five 클릭 시 textarea에 포커스
        $(document).ready(function() {
            $('a[href="#tab5"]').on('shown.bs.tab', function (e) {
                $('#contentTextarea').focus();
            });
        });
    </script>    
</body>
</html>

<?php 
    //MARIA DB 메모리 회수
    if (isset($connect4)) { mysqli_close($connect4); }	

    //MSSQL 메모리 회수
    if(isset($connect)) { sqlsrv_close($connect); }
?>