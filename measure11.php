<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.11.11>
	// Description:	<마스크 공정 온습도 측정>	
  // =============================================

  include './DB/DB1.php';  

  $humidity = $_GET['humidity'];         //습도 읽어와
  $temperature = $_GET['temperature'];   //온도 읽어와
  
  $query = "insert into mask_filed(humidity, temperature) values('$humidity', '$temperature')";
  $connect->query($query);  //쿼리실행