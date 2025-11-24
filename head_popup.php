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