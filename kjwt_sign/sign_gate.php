<?php
    // =============================================
    // Author: <KWON SUNG KUN - sealclear@naver.com>
    // Create date: <25.10.29>
    // Description: <회람 QR 접속>
    // =============================================
    
    // sign_select_status.php에 DB 연결 로직이 포함되어 있다고 가정합니다.
    include 'sign_select_status.php';

    $title = '';
    $no = $_GET['no'] ?? null;

    if ($no && isset($connect)) {
        // SQL 인젝션 방지를 위해 no를 정수형으로 캐스팅합니다.
        $no = (int)$no;
        
        // 제목을 가져오기 위한 쿼리
        $query = "SELECT TITLE FROM CONNECT.dbo.SIGN2 WHERE NO = ?";
        $params = array($no);
        $stmt = sqlsrv_query($connect, $query, $params);

        if ($stmt && sqlsrv_fetch($stmt)) {
            $title = sqlsrv_get_field($stmt, 0);
        }
    }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회람 서명</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fc;
        }
        .sign-popup {
            display: block;
            position: relative;
            width: 320px;
            padding: 20px;
            background-color: white;
            border: 2px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            text-align: left;
            box-sizing: border-box;
        }
        .sign-input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .sign-popup-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .sign-confirm-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .sign-close-btn-popup {
            border: 1px solid #ccc;
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="sign-popup" id="signPopup">
        <p>[회람] <span id="signPopupTitle"><?php echo htmlspecialchars($title); ?></span></p>
        <input type="hidden" id="signPopupNo" value="<?php echo htmlspecialchars($no); ?>" />
        <input type="text" id="signPopupUserInput" class="sign-input-field" placeholder="주민번호 앞 6자리" />
        <div class="sign-popup-buttons">
            <button class="sign-confirm-btn" onclick="submitSignInput()">확인</button>
        </div>
    </div>

    <script>
        function submitSignInput() {
            const input = document.getElementById("signPopupUserInput").value;
            const no = document.getElementById("signPopupNo").value;

            if (input) {
                // sign_select.php로 리디렉션하여 서명 처리
                window.location.href = "sign_select.php?listno=" + encodeURIComponent(no) + "&input=" + encodeURIComponent(input);
            } else {
                alert("값을 입력해 주세요.");
            }
        }
    </script>

</body>
</html>
