<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.03.27>
	// Description:	<전산실 온습도 측정>	
  // =============================================

  include './DB/DB1.php';  

  $dt = date("Y-m-d");				
  $week = date('w', strtotime($dt));
  $check_hour = date("H");

  $humidity = $_GET['humidity'];         //습도 읽어와
  $temperature = $_GET['temperature'];   //온도 읽어와
 
  $query = "insert into svr_room(humidity, temperature) values('$humidity', '$temperature')";
  $connect->query($query);  //쿼리실행
  
  IF($temperature > 25 or $temperature < 18) {
    include "measure_check_mail.php";
  }  