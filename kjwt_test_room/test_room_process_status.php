<?php   
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date: <25.04.08>
	// Description:	<시험실 qr코드 이력관리>	
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================

    //★DB연결 및 함수사용
    include '../FUNCTION.php';
    include '../DB/DB2.php';    
    include '../DB/DB3.php';  


    //★탭활성화
    $tab_sequence=2; 
    include '../TAB.php';    


    //★변수모음  
    //get
    $CD_ITEM = TRIM($_GET["CD_ITEM"]); 
    $ID = $_GET["ID"]; 
    $LOT_DATE = SUBSTR($_GET["ID"],0,8);
    $LOT_NUM = SUBSTR($_GET["ID"],8,3);

    //탭2  
    $bt21 = $_POST["bt21"]; 
    $bt22 = $_POST["bt22"];  
    $bt23 = $_POST["bt23"];  
    $bt24 = $_POST["bt24"];  
    $bt25 = $_POST["bt25"];  
    $bt26 = $_POST["bt26"];  
    $bt27 = $_POST["bt27"];  
    $bt28 = $_POST["bt28"];  
    
    //탭3
    $dt3 = htmlspecialchars($_POST['dt3'], ENT_QUOTES, 'UTF-8');
    $s_dt3 = substr($dt3, 0, 10);		
	$e_dt3 = substr($dt3, 13, 10);
    $bt31 = $_POST["bt31"]; 

    

    //★카드활성화
    $Query_ExistData = "SELECT * from CONNECT.dbo.TEST_ROOM_LABEL WHERE CD_ITEM='$CD_ITEM' AND LOT_DATE='$LOT_DATE' AND LOT_NUM='$LOT_NUM'";              
    $Result_ExistData = sqlsrv_query($connect, $Query_ExistData, $params, $options);		
    $Data_ExistData = sqlsrv_fetch_array($Result_ExistData); 	
    $Count_ExistData = sqlsrv_num_rows($Result_ExistData);  

    if($Data_ExistData['P11']!="") { $show1 = "show"; } 
    if($Data_ExistData['P21']!="") { $show2 = "show"; }
    if($Data_ExistData['P31']!="") { $show3 = "show"; }
    if($Data_ExistData['P41']!="") { $show4 = "show"; }
    if($Data_ExistData['P51']!="") { $show5 = "show"; }
    if($Data_ExistData['P61']!="") { $show6 = "show"; }
    if($Data_ExistData['P71']!="") { $show7 = "show"; }
    if($Data_ExistData['P81']!="") { $show8 = "show"; }


    //★버튼 클릭 시 실행  
    //입력 
    IF($bt21=="on") {     
        $P11 = $_POST["P11"]; 
        $P12 = $_POST["P12"];
        $P13 = $_POST["P13"];
        $P14 = $_POST["P14"];
        $P15 = $_POST["P15"];
        $P16 = $_POST["P16"];
        $P17 = $_POST["P17"];
        $P18 = $_POST["P18"];
        $P19 = $_POST["P19"];
        $P110 = $_POST["P110"];
        $P111 = $_POST["P111"];
        $P112 = $_POST["P112"]; 

        $NOTE11 = $_POST["NOTE11"]; 
        $NOTE12 = $_POST["NOTE12"];
        $NOTE13 = $_POST["NOTE13"];
        $NOTE14 = $_POST["NOTE14"];
        $NOTE15 = $_POST["NOTE15"];
        $NOTE16 = $_POST["NOTE16"];
        $NOTE17 = $_POST["NOTE17"];
        $NOTE18 = $_POST["NOTE18"];
        $NOTE19 = $_POST["NOTE19"];
        $NOTE110 = $_POST["NOTE110"];
        $NOTE111 = $_POST["NOTE111"];
        $NOTE112 = $_POST["NOTE112"]; 
        
        if($Count_ExistData>0) {
            $Query_UpdateData = "UPDATE CONNECT.dbo.TEST_ROOM_LABEL set P11='$P11', P12='$P12',P13='$P13', P14='$P14', P15='$P15', P16='$P16', P17='$P17', P18='$P18', P19='$P19', P110='$P110', P111='$P111', P112='$P112', NOTE11='$NOTE11', NOTE12='$NOTE12',NOTE13='$NOTE13', NOTE14='$NOTE14', NOTE15='$NOTE15', NOTE16='$NOTE16', NOTE17='$NOTE17', NOTE18='$NOTE18', NOTE19='$NOTE19', NOTE110='$NOTE110', NOTE111='$NOTE111', NOTE112='$NOTE112' where CD_ITEM='$CD_ITEM' AND LOT_DATE='$LOT_DATE' AND LOT_NUM='$LOT_NUM'";              
            sqlsrv_query($connect, $Query_UpdateData, $params, $options);  
            
            echo "<script>alert('입력되었습니다!');location.href='test_room_process.php?CD_ITEM=$CD_ITEM&ID=$ID';</script>";
        }
        else {     
            echo "<script>alert('해당 데이터가 없습니다!');location.href='test_room_process.php';</script>";                 
        }    
    } 
    elseif($bt22=="on") {     
        $P21 = $_POST["P21"]; 
        $P22 = $_POST["P22"];
        $P23 = $_POST["P23"];
        $P24 = $_POST["P24"];
        $P25 = $_POST["P25"];
        $P26 = $_POST["P26"];
        $P27 = $_POST["P27"];
        $P28 = $_POST["P28"];
        $P29 = $_POST["P29"];
        $P210 = $_POST["P210"];
        $P211 = $_POST["P211"];
        $P212 = $_POST["P212"];
        $P213 = $_POST["P213"];  
        $P214 = $_POST["P214"]; 

        $NOTE21 = $_POST["NOTE21"]; 
        $NOTE22 = $_POST["NOTE22"];
        $NOTE23 = $_POST["NOTE23"];
        $NOTE24 = $_POST["NOTE24"];
        $NOTE25 = $_POST["NOTE25"];
        $NOTE26 = $_POST["NOTE26"];
        $NOTE27 = $_POST["NOTE27"];
        $NOTE28 = $_POST["NOTE28"];
        $NOTE29 = $_POST["NOTE29"];
        $NOTE210 = $_POST["NOTE210"];
        $NOTE211 = $_POST["NOTE211"];
        $NOTE212 = $_POST["NOTE212"];
        $NOTE213 = $_POST["NOTE213"];  
        $NOTE214 = $_POST["NOTE214"]; 

        if($Count_ExistData>0) {
            $Query_UpdateData = "UPDATE CONNECT.dbo.TEST_ROOM_LABEL set P21='$P21', P22='$P22',P23='$P23', P24='$P24', P25='$P25', P26='$P26', P27='$P27', P28='$P28', P29='$P29', P210='$P210', P211='$P211', P212='$P212', P213='$P213', P214='$P214', NOTE21='$NOTE21', NOTE22='$NOTE22',NOTE23='$NOTE23', NOTE24='$NOTE24', NOTE25='$NOTE25', NOTE26='$NOTE26', NOTE27='$NOTE27', NOTE28='$NOTE28', NOTE29='$NOTE29', NOTE210='$NOTE210', NOTE211='$NOTE211', NOTE212='$NOTE212', NOTE213='$NOTE213', NOTE214='$NOTE214' where CD_ITEM='$CD_ITEM' AND LOT_DATE='$LOT_DATE' AND LOT_NUM='$LOT_NUM'";              
            sqlsrv_query($connect, $Query_UpdateData, $params, $options);  
            
            echo "<script>alert('입력되었습니다!');location.href='test_room_process.php?CD_ITEM=$CD_ITEM&ID=$ID';</script>";
        }
        else {     
            echo "<script>alert('해당 데이터가 없습니다!');location.href='test_room_process.php';</script>";                 
        }    
    } 
    elseif($bt23=="on") {     
        $P31 = $_POST["P31"]; 
        $P32 = $_POST["P32"];
        $P33 = $_POST["P33"];
        $P34 = $_POST["P34"];
        $P35 = $_POST["P35"];
        $P36 = $_POST["P36"]; 
        
        $NOTE31 = $_POST["NOTE31"]; 
        $NOTE32 = $_POST["NOTE32"];
        $NOTE33 = $_POST["NOTE33"];
        $NOTE34 = $_POST["NOTE34"];
        $NOTE35 = $_POST["NOTE35"];
        $NOTE36 = $_POST["NOTE36"]; 

        if($Count_ExistData>0) {
            $Query_UpdateData = "UPDATE CONNECT.dbo.TEST_ROOM_LABEL set P31='$P31', P32='$P32',P33='$P33', P34='$P34', P35='$P35', P36='$P36', NOTE31='$NOTE31', NOTE32='$NOTE32',NOTE33='$NOTE33', NOTE34='$NOTE34', NOTE35='$NOTE35', NOTE36='$NOTE36' where CD_ITEM='$CD_ITEM' AND LOT_DATE='$LOT_DATE' AND LOT_NUM='$LOT_NUM'";              
            sqlsrv_query($connect, $Query_UpdateData, $params, $options);  
            
            echo "<script>alert('입력되었습니다!');location.href='test_room_process.php?CD_ITEM=$CD_ITEM&ID=$ID';</script>";
        }
        else {     
            echo "<script>alert('해당 데이터가 없습니다!');location.href='test_room_process.php';</script>";                 
        }    
    } 
    elseif($bt24=="on") {     
        $P41 = $_POST["P41"]; 
        $P42 = $_POST["P42"];
        $P43 = $_POST["P43"];
        $P44 = $_POST["P44"];
        $P45 = $_POST["P45"];
        $P46 = $_POST["P46"];    

        $NOTE41 = $_POST["NOTE41"]; 
        $NOTE42 = $_POST["NOTE42"];
        $NOTE43 = $_POST["NOTE43"];
        $NOTE44 = $_POST["NOTE44"];
        $NOTE45 = $_POST["NOTE45"];
        $NOTE46 = $_POST["NOTE46"]; 

        if($Count_ExistData>0) {
            $Query_UpdateData = "UPDATE CONNECT.dbo.TEST_ROOM_LABEL set P41='$P41', P42='$P42',P43='$P43', P44='$P44', P45='$P45', P46='$P46', NOTE41='$NOTE41', NOTE42='$NOTE42',NOTE43='$NOTE43', NOTE44='$NOTE44', NOTE45='$NOTE45', NOTE46='$NOTE46' where CD_ITEM='$CD_ITEM' AND LOT_DATE='$LOT_DATE' AND LOT_NUM='$LOT_NUM'";              
            sqlsrv_query($connect, $Query_UpdateData, $params, $options);  
            
            echo "<script>alert('입력되었습니다!');location.href='test_room_process.php?CD_ITEM=$CD_ITEM&ID=$ID';</script>";
        }
        else {     
            echo "<script>alert('해당 데이터가 없습니다!');location.href='test_room_process.php';</script>";                 
        }    
    } 
    elseif($bt25=="on") {     
        $P51 = $_POST["P51"]; 
        $P52 = $_POST["P52"];
        $P53 = $_POST["P53"];

        $NOTE51 = $_POST["NOTE51"]; 
        $NOTE52 = $_POST["NOTE52"];
        $NOTE53 = $_POST["NOTE53"];

        if($Count_ExistData>0) {
            $Query_UpdateData = "UPDATE CONNECT.dbo.TEST_ROOM_LABEL set P51='$P51', P52='$P52',P53='$P53', NOTE51='$NOTE51', NOTE52='$NOTE52',NOTE53='$NOTE53' where CD_ITEM='$CD_ITEM' AND LOT_DATE='$LOT_DATE' AND LOT_NUM='$LOT_NUM'";              
            sqlsrv_query($connect, $Query_UpdateData, $params, $options);  
            
            echo "<script>alert('입력되었습니다!');location.href='test_room_process.php?CD_ITEM=$CD_ITEM&ID=$ID';</script>";
        }
        else {     
            echo "<script>alert('해당 데이터가 없습니다!');location.href='test_room_process.php';</script>";                 
        }    
    }
    elseif($bt26=="on") {     
        $P61 = $_POST["P61"]; 
        $P62 = $_POST["P62"];
        $P63 = $_POST["P63"];
        $P64 = $_POST["P64"];

        $NOTE61 = $_POST["NOTE61"]; 
        $NOTE62 = $_POST["NOTE62"];
        $NOTE63 = $_POST["NOTE63"];
        $NOTE64 = $_POST["NOTE64"];

        if($Count_ExistData>0) {
            $Query_UpdateData = "UPDATE CONNECT.dbo.TEST_ROOM_LABEL set P61='$P61', P62='$P62',P63='$P63',P64='$P64', NOTE61='$NOTE61', NOTE62='$NOTE62',NOTE63='$NOTE63',NOTE64='$NOTE64' where CD_ITEM='$CD_ITEM' AND LOT_DATE='$LOT_DATE' AND LOT_NUM='$LOT_NUM'";              
            sqlsrv_query($connect, $Query_UpdateData, $params, $options);  
            
            echo "<script>alert('입력되었습니다!');location.href='test_room_process.php?CD_ITEM=$CD_ITEM&ID=$ID';</script>";
        }
        else {     
            echo "<script>alert('해당 데이터가 없습니다!');location.href='test_room_process.php';</script>";                 
        }    
    } 
    elseif($bt27=="on") {     
        $P71 = $_POST["P71"]; 
        $P72 = $_POST["P72"];
        $P73 = $_POST["P73"];

        $NOTE71 = $_POST["NOTE71"]; 
        $NOTE72 = $_POST["NOTE72"];
        $NOTE73 = $_POST["NOTE73"];

        if($Count_ExistData>0) {
            $Query_UpdateData = "UPDATE CONNECT.dbo.TEST_ROOM_LABEL set P71='$P71', P72='$P72',P73='$P73', NOTE71='$NOTE71', NOTE72='$NOTE72',NOTE73='$NOTE73' where CD_ITEM='$CD_ITEM' AND LOT_DATE='$LOT_DATE' AND LOT_NUM='$LOT_NUM'";              
            sqlsrv_query($connect, $Query_UpdateData, $params, $options);  
            
            echo "<script>alert('입력되었습니다!');location.href='test_room_process.php?CD_ITEM=$CD_ITEM&ID=$ID';</script>";
        }
        else {     
            echo "<script>alert('해당 데이터가 없습니다!');location.href='test_room_process.php';</script>";                 
        }    
    } 
    elseif($bt28=="on") {     
        $P81 = $_POST["P81"]; 
        $P82 = $_POST["P82"];
        $P83 = $_POST["P83"];

        $NOTE81 = $_POST["NOTE81"]; 
        $NOTE82 = $_POST["NOTE82"];
        $NOTE83 = $_POST["NOTE83"];

        if($Count_ExistData>0) {
            $Query_UpdateData = "UPDATE CONNECT.dbo.TEST_ROOM_LABEL set P81='$P81', P82='$P82',P83='$P83', NOTE81='$NOTE81', NOTE82='$NOTE82',NOTE83='$NOTE83' where CD_ITEM='$CD_ITEM' AND LOT_DATE='$LOT_DATE' AND LOT_NUM='$LOT_NUM'";              
            sqlsrv_query($connect, $Query_UpdateData, $params, $options);  
            
            echo "<script>alert('입력되었습니다!');location.href='test_room_process.php?CD_ITEM=$CD_ITEM&ID=$ID';</script>";
        }
        else {     
            echo "<script>alert('해당 데이터가 없습니다!');location.href='test_room_process.php';</script>";                 
        }    
    } 
    //조회
    elseif($bt31=="on") {
        $tab_sequence=3; 
        include '../TAB.php';
       
        $Query_Select = "SELECT * from CONNECT.dbo.TEST_ROOM_LABEL WHERE SORTING_DATE BETWEEN '$s_dt3' AND '$e_dt3'";              
        $Result_Select = sqlsrv_query($connect, $Query_Select, $params, $options);	
        $Count_Select = sqlsrv_num_rows($Result_Select);  
    }   
    

    //★메뉴 진입 시 실행
    $Query_LEG1 = "SELECT * from CONNECT.dbo.TEST_ROOM_PROCESS where LEG='1' order by STEP asc";              
    $Result_LEG1 = sqlsrv_query($connect, $Query_LEG1, $params, $options);		
    $Data_LEG1 = [];
    while ($row = sqlsrv_fetch_array($Result_LEG1, SQLSRV_FETCH_ASSOC)) {
        $Data_LEG1[] = $row;
    }

    $Query_LEG2 = "SELECT * from CONNECT.dbo.TEST_ROOM_PROCESS where LEG='2' order by STEP asc";              
    $Result_LEG2 = sqlsrv_query($connect, $Query_LEG2, $params, $options);		
    $Data_LEG2 = [];
    while ($row = sqlsrv_fetch_array($Result_LEG2, SQLSRV_FETCH_ASSOC)) {
        $Data_LEG2[] = $row;
    }

    $Query_LEG3 = "SELECT * from CONNECT.dbo.TEST_ROOM_PROCESS where LEG='3' order by STEP asc";              
    $Result_LEG3 = sqlsrv_query($connect, $Query_LEG3, $params, $options);		
    $Data_LEG3 = [];
    while ($row = sqlsrv_fetch_array($Result_LEG3, SQLSRV_FETCH_ASSOC)) {
        $Data_LEG3[] = $row;
    }

    $Query_LEG4 = "SELECT * from CONNECT.dbo.TEST_ROOM_PROCESS where LEG='4' order by STEP asc";              
    $Result_LEG4 = sqlsrv_query($connect, $Query_LEG4, $params, $options);		
    $Data_LEG4 = [];
    while ($row = sqlsrv_fetch_array($Result_LEG4, SQLSRV_FETCH_ASSOC)) {
        $Data_LEG4[] = $row;
    }

    $Query_LEG5 = "SELECT * from CONNECT.dbo.TEST_ROOM_PROCESS where LEG='5' order by STEP asc";              
    $Result_LEG5 = sqlsrv_query($connect, $Query_LEG5, $params, $options);		
    $Data_LEG5 = [];
    while ($row = sqlsrv_fetch_array($Result_LEG5, SQLSRV_FETCH_ASSOC)) {
        $Data_LEG5[] = $row;
    }

    $Query_LEG6 = "SELECT * from CONNECT.dbo.TEST_ROOM_PROCESS where LEG='6' order by STEP asc";              
    $Result_LEG6 = sqlsrv_query($connect, $Query_LEG6, $params, $options);		
    $Data_LEG6 = [];
    while ($row = sqlsrv_fetch_array($Result_LEG6, SQLSRV_FETCH_ASSOC)) {
        $Data_LEG6[] = $row;
    }

    $Query_LEG7 = "SELECT * from CONNECT.dbo.TEST_ROOM_PROCESS where LEG='7' order by STEP asc";              
    $Result_LEG7 = sqlsrv_query($connect, $Query_LEG7, $params, $options);		
    $Data_LEG7 = [];
    while ($row = sqlsrv_fetch_array($Result_LEG7, SQLSRV_FETCH_ASSOC)) {
        $Data_LEG7[] = $row;
    }

    $Query_LEG8 = "SELECT * from CONNECT.dbo.TEST_ROOM_PROCESS where LEG='8' order by STEP asc";              
    $Result_LEG8 = sqlsrv_query($connect, $Query_LEG8, $params, $options);		
    $Data_LEG8 = [];
    while ($row = sqlsrv_fetch_array($Result_LEG8, SQLSRV_FETCH_ASSOC)) {
        $Data_LEG8[] = $row;
    }