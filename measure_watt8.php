<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <21.01.15>
	// Description:	<시험실 설비 전류 측정8 항온항습기 #1>	
	// =============================================

  include './DB/DB1.php';   

  $dt = date("Y-m-d");				
  $week = date('w', strtotime($dt));
  $check_hour = date("H");

  $watt = abs($_GET['watt']); 
 
  $query = "insert into experiment_equipment8(WATT) values('$watt')";
  $connect->query($query);  //쿼리실행 

  $check_query = "select count(*) from equipment_worktime where DT='$dt' and kind='experiment8'";
  $check_result = $connect->query($check_query);  //쿼리실행 
  $num_result = $check_result->num_rows;

  IF($num_result>0) {
    $query2 = "insert into equipment_worktime(kind, work_time) values('experiment8', '0')";
    $connect->query($query2);  //쿼리실행 
  }

  IF($watt>=250) {
    $query1 = "update equipment_worktime set work_time=work_time+1 where DT='$dt' and kind='experiment8'";
    $connect->query($query1);  //쿼리실행 
  }
?>