<?php 
    // =============================================
	// Author: <KWON SUNG KUN - sealclear@naver.com>	
	// Create date:  <25.05.26>
	// Description:	<포장라벨 커스텀>
    // Last Modified: <25.10.13> - Refactored for PHP 8.x
	// =============================================
    // PHP 8.x compatibility and XSS protection
    $cd_item = htmlspecialchars($_GET["cd_item"] ?? '', ENT_QUOTES, 'UTF-8');
    $kind = htmlspecialchars($_GET["kind"] ?? '', ENT_QUOTES, 'UTF-8');
    $country = htmlspecialchars($_GET["country"] ?? '', ENT_QUOTES, 'UTF-8');
    $lot_size = htmlspecialchars($_GET["lot_size"] ?? '', ENT_QUOTES, 'UTF-8');
    $note = htmlspecialchars($_GET["note"] ?? '', ENT_QUOTES, 'UTF-8');
    $b_count = htmlspecialchars($_GET["b_count"] ?? '', ENT_QUOTES, 'UTF-8');
?>


<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            /* 팝업창의 기본 스타일 설정 */
            .popup {
                display: none;
                position: fixed; /* 고정 위치 */
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%); /* 중앙으로 이동 */
                width: 320px;
                padding: 20px;
                background-color: white;
                border: 2px solid #ccc;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                text-align: left;
                box-sizing: border-box; /* 패딩을 포함한 크기 조정 */
            }

            /* 입력창 스타일 */
            .input-field {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
            }

            /* 팝업창 닫기 버튼 스타일 */
            .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                background-color: transparent;
                border: none;
                font-size: 20px;
                cursor: pointer;
            }

            /* 팝업창의 배경 */
            .popup-background {
                display: none;
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            /* 팝업 버튼 스타일 */
            .popup-buttons {
                display: flex;
                justify-content: flex-end; /* 버튼 우측 정렬 */
                gap: 10px;
            }

            /* 확인 버튼 스타일 */
            .confirm-btn {
                background-color: #007bff; /* 파란색 */
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
            }

            /* 닫기 버튼 스타일 */
            .close-btn-popup {
                border: none;
                padding: 10px 15px;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
            }            

            /* 버튼들을 중앙에 배치 */
            .popup-buttons {
                display: flex;
                justify-content: right;
            }
        </style>
    </head>

    <body>

        <!-- 팝업창 HTML -->
        <div class="popup-background" id="popupBackground"></div>
        <div class="popup" id="popup">
            <!-- 우측 상단 닫기 버튼 -->
            <button class="close-btn" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></button>
            <p>품명을 선택하세요!</p>
            <select name="sign_name" id="userInput" class="input-field">
                <option value="" selected="selected">선택</option>			
                <option value="<?php echo $cd_item; ?>"><?php echo $cd_item; ?></option>
                <option value="<?php echo $cd_item.'(NA)'; ?>"><?php echo $cd_item.'(NA)'; ?></option>
            </select> 
            <div class="popup-buttons">
                <button class="confirm-btn" onclick="submitInput()">확인</button>
                <button class="close-btn-popup" onclick="closePopup()">닫기</button>
            </div>   
        </div>

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
                window.location.href = "complete_label.php";
            }

            // 입력값을 확인 버튼으로 제출하는 함수
            function submitInput() {
                const input = document.getElementById("userInput").value;
                const kind = "<?php echo $kind; ?>";
                const country = "<?php echo $country; ?>";
                const lot_size = "<?php echo $lot_size; ?>";
                const note = "<?php echo $note; ?>";
                const b_count = "<?php echo $b_count; ?>";
                
                if (input) {
                    //alert("입력된 값: " + input);  // 입력된 값을 알림으로 표시
                    window.location.href = "complete_label_force.php?kind=" + encodeURIComponent(kind) + "&country=" + encodeURIComponent(country) + "&lot_size=" + encodeURIComponent(lot_size) + "&note=" + encodeURIComponent(note) + "&b_count=" + encodeURIComponent(b_count) + "&popitem=" + encodeURIComponent(input);
                } else {
                    alert("값을 입력해 주세요.");
                }
            }

            // 페이지가 로드되자마자 팝업창을 자동으로 열기
            window.onload = function() {
                openPopup();
            };
        </script>

    </body>

    <!-- Bootstrap core JavaScript-->
    <?php include '../plugin_lv1.php'; ?>
</html>