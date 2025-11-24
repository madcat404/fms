<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.04.06>
	// Description:	<수입검사실 온습도 측정>	
	// =============================================

  include './DB/DB1.php'; 

  $dt = date("Y-m-d");				
  $week = date('w', strtotime($dt));
  $check_hour = date("H");
  $check_month = date("m");

  $humidity = $_GET['humidity'];         //습도 읽어와
  $temperature = $_GET['temperature'];   //온도 읽어와
 
  
  $query = "insert into qc_room(humidity, temperature) values('$humidity', '$temperature')";
  $connect->query($query);  //쿼리실행
    
  IF($week > 0 and $week < 6) {
    IF($check_hour > 8 and $check_hour < 18) {
      IF($check_month > 3 and $check_month < 11) {
        IF($temperature > 28 or $temperature < 18) {
          include "measure_check_mail3.php";
        }
      }      
      ELSE {
        IF($temperature > 23 or $temperature < 13) {
          include "measure_check_mail3.php";
        }  
      }
    }
  }