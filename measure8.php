<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <20.11.11>
	// Description:	<자재 창고 온습도 측정>	
  // =============================================
  
  include './DB/DB1.php'; 

  $humidity = $_GET['humidity'];         //습도 읽어와
  $temperature = $_GET['temperature'];   //온도 읽어와
  
  $query = "insert into materials_storage(humidity, temperature) values('$humidity', '$temperature')";
  $connect->query($query);  //쿼리실행