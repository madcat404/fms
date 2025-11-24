<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.03.30>
	// Description:	<시험실 온습도 측정>	
  // =============================================

  include './DB/DB1.php'; 

  $dt = date("Y-m-d");				
  $week = date('w', strtotime($dt));
  $check_hour = date("H");

  $humidity = $_GET['humidity'];         //습도 읽어와
  $temperature = $_GET['temperature'];   //온도 읽어와
  
  $query = "insert into experiment_room(humidity, temperature) values('$humidity', '$temperature')";
  $connect->query($query);  //쿼리실행

  /*
  IF($week > 0 and $week < 6) {
    IF($check_hour > 8 and $check_hour < 18) {
      IF($temperature > 25 or $temperature < 21) {
        include "measure_check_mail2.php";
      }
    }
  }
  */