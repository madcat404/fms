<?php
declare(strict_types=1);

// =============================================
// Author: <KWON SUNG KUN - sealclear@naver.com>
// Create date: <25.10.22>
// Description: <통합 메일 발송 서비스 엔진>
// Last Modified: <25.10.22>
// =============================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/PHPMailer-master/src/Exception.php';

/**
 * 시스템 전반에서 사용할 이메일을 발송합니다.
 * SMTP 설정은 환경 변수에서 가져옵니다.
 *
 * @param string|array $to 받는 사람 이메일 주소 (배열 또는 단일 문자열)
 * @param string $subject 메일 제목
 * @param string $body 메일 본문 (HTML)
 * @param array $embeddedImages 메일에 포함할 이미지 배열. 각 요소는 ['path' => '이미지 경로', 'cid' => 'CID'] 형태여야 합니다.
 * @return bool 성공 시 true, 실패 시 false
 */
function send_system_email(string|array $to, string $subject, string $body, array $embeddedImages = []): bool
{
    $mail = new PHPMailer(true);

    try {
        // 서버 설정
        $mail->SMTPDebug = 0; // 디버그 출력 비활성화
        $mail->isSMTP();
        $mail->Host = getenv('SMTP_HOST') ?: 'smtp.naver.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME');
        $mail->Password = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int)getenv('SMTP_PORT') ?: 587;
        $mail->CharSet = "utf-8";

        // 보내는 사람
        $mail->setFrom('sealclear@naver.com', "Iwin-Fms");

        // 받는 사람
        if (is_array($to)) {
            foreach ($to as $recipient) {
                $mail->addAddress($recipient);
            }
        } else {
            $mail->addAddress($to);
        }

        // 이미지 포함
        foreach ($embeddedImages as $image) {
            if (isset($image['path']) && isset($image['cid'])) {
                if (file_exists($image['path'])) {
                    $mail->addEmbeddedImage($image['path'], $image['cid']);
                } else {
                    error_log("Embedded image not found at path: " . $image['path']);
                }
            }
        }

        // 내용
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // 프로덕션 환경에서는 에러를 로그 파일에 기록합니다.
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}