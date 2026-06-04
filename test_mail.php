<?php
/**
 * Script này dùng để kiểm tra lỗi gửi mail chi tiết.
 * Hãy chạy file này bằng cách truy cập: http://localhost:8080/test_mail.php
 */

require_once __DIR__ . '/core/Connect_DataBase.php'; // Để load .env
require_once __DIR__ . '/core/MailService.php';
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

echo "<h1>Kiểm tra cấu hình Email</h1>";

if (empty($_ENV['SMTP_USER']) || empty($_ENV['SMTP_PASS'])) {
    echo "<p style='color:red;'>LỖI: Chưa cấu hình SMTP_USER hoặc SMTP_PASS trong file .env</p>";
    exit;
}

echo "<ul>";
echo "<li>SMTP Host: " . htmlspecialchars($_ENV['SMTP_HOST'] ?? 'Chưa cấu hình') . "</li>";
echo "<li>SMTP User: " . htmlspecialchars($_ENV['SMTP_USER']) . "</li>";
echo "<li>SMTP Port: " . htmlspecialchars($_ENV['SMTP_PORT'] ?? '587') . "</li>";
echo "</ul>";

$mail = new PHPMailer(true);

try {
    // Bật debug mức độ cao nhất để xem log chi tiết
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
    $mail->Debugoutput = function($str, $level) {
        echo "<pre style='background:#f4f4f4; padding:10px; border:1px solid #ddd;'>DEBUG: $str</pre>";
    };

    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USER'];
    $mail->Password   = $_ENV['SMTP_PASS'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = (int)($_ENV['SMTP_PORT'] ?? 587);
    $mail->CharSet    = 'UTF-8';

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->setFrom($mail->Username, 'Góc Gia Sư Test');
    $mail->addAddress($mail->Username); // Gửi thử cho chính mình
    $mail->Subject = 'Kiểm tra kết nối SMTP - Góc Gia Sư';
    $mail->Body    = 'Nếu bạn thấy email này, cấu hình SMTP của bạn đã hoạt động chính xác!';

    echo "<h3>Đang thử kết nối...</h3>";
    if ($mail->send()) {
        echo "<h2 style='color:green;'>THÀNH CÔNG! Email đã được gửi.</h2>";
    }
} catch (Exception $e) {
    echo "<h2 style='color:red;'>THẤT BẠI! Lỗi gửi mail.</h2>";
    echo "<p>Thông báo lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
}
