<?php 
  // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.03.18>
	// Description:	<마지막 사진 뷰어)>
  // Last Modified: <25.10.20> - Refactored for PHP 8.x	
	// =============================================
  include '../DB/DB1.php';
  include '../DB/DB3.php';
  include '../DB/DB6.php';
  include '../FUNCTION.php'; 

  // Helper function to fetch pictures for a given car number
  function fetch_last_pictures($connect, $car_num) {
    // First, get the S_DATE of the last damage report for the car
    $stmt1 = $connect->prepare("SELECT S_DATE FROM files WHERE IMG_TYPE='Damage' AND CAR_NUM=? ORDER BY NO DESC LIMIT 1");
    if (!$stmt1) {
        return [null, 0];
    }
    $stmt1->bind_param("s", $car_num);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $data = $result1->fetch_object();
    $stmt1->close();

    if ($data && isset($data->S_DATE)) {
        // Then, get all pictures from that same report date
        $stmt2 = $connect->prepare("SELECT * FROM files WHERE IMG_TYPE='Damage' AND CAR_NUM=? AND S_DATE=?");
        if (!$stmt2) {
            return [null, 0];
        }
        $stmt2->bind_param("ss", $car_num, $data->S_DATE);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $count = $result2->num_rows;
        return [$result2, $count];
    } else {
        return [null, 0];
    }
  }

  list($Result_LastPicData3, $Count_LastPicData3) = fetch_last_pictures($connect, 'Staria 9285');
  list($Result_LastPicData4, $Count_LastPicData4) = fetch_last_pictures($connect, 'avante 7206');
  list($Result_LastPicData5, $Count_LastPicData5) = fetch_last_pictures($connect, 'avante 7207');

?>