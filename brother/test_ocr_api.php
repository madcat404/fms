<?php
// test_ocr_api.php
header('Content-Type: text/plain; charset=utf-8');

// ★ 사용 중인 API 키를 여기에 붙여넣으세요
$apiKey = "AIzaSyCfMRWWgIgpQiV5haRtpgm0E7mNTnv4aQw"; 

// 테스트할 모델 이름 (아까 목록에 있던 것 중 하나)
$model = "gemini-2.0-flash"; 

$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=" . $apiKey;

echo "테스트 모델: $model\n";
echo "요청 URL: $url\n\n";

// 간단한 테스트 데이터 전송
$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => "이 문장은 테스트입니다. JSON으로 {result: 'ok'} 라고 응답해줘."]
            ]
        ]
    ],
    "generationConfig" => [
        "responseMimeType" => "application/json"
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "=== 통신 에러 발생 ===\n" . $error;
} else {
    echo "=== HTTP 상태 코드: $httpCode ===\n";
    echo "=== 응답 본문 ===\n" . $response . "\n\n";

    $json = json_decode($response, true);
    if (isset($json['error'])) {
        echo ">>> 구글 API 에러 메시지:\n";
        echo "메시지: " . $json['error']['message'] . "\n";
        echo "상태: " . $json['error']['status'] . "\n";
    } elseif (isset($json['candidates'])) {
        echo ">>> 성공! API가 정상 작동 중입니다.\n";
        echo "답변: " . $json['candidates'][0]['content']['parts'][0]['text'];
    } else {
        echo ">>> 알 수 없는 응답 형식입니다.";
    }
}
?>