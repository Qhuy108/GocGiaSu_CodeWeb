<?php
/**
 * MailService – Quản lý gửi email bằng PHPMailer
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Nạp tự động các thư viện qua Composer
require_once __DIR__ . '/../vendor/autoload.php';

class MailService
{
    private function getMailer(): PHPMailer
    {
        $mail = new PHPMailer(true);

        // Cấu hình Server
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'] ?? '';
        $mail->Password   = $_ENV['SMTP_PASS'] ?? '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)($_ENV['SMTP_PORT'] ?? 587);
        $mail->CharSet    = 'UTF-8';

        // Tùy chỉnh SSL (Hữu ích nếu server có chứng chỉ tự ký hoặc lỗi SSL)
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ];

        $mail->setFrom($mail->Username, 'Góc Gia Sư');
        
        return $mail;
    }

    /**
     * Gửi mã OTP
     */
    public function sendOTP(string $toEmail, string $otpCode, string $type = 'register'): bool
    {
        try {
            $mail = $this->getMailer();
            $mail->addAddress($toEmail);
            $mail->isHTML(true);

            if ($type === 'register') {
                $mail->Subject = '[Góc Gia Sư] Xác thực tài khoản của bạn';
                $mail->Body    = "
                    <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                        <h2>Chào mừng bạn đến với Góc Gia Sư!</h2>
                        <p>Mã xác thực đăng ký tài khoản của bạn là: <strong style='font-size: 1.2rem; color: #008080;'>$otpCode</strong></p>
                        <p>Mã này có hiệu lực trong vòng 15 phút. Vui lòng không chia sẻ mã này cho bất kỳ ai.</p>
                        <br>
                        <p>Trân trọng,<br>Đội ngũ Góc Gia Sư</p>
                    </div>";
            } else {
                $mail->Subject = '[Góc Gia Sư] Mã xác nhận khôi phục mật khẩu';
                $mail->Body    = "
                    <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                        <h2>Yêu cầu khôi phục mật khẩu</h2>
                        <p>Chúng tôi nhận được yêu cầu khôi phục mật khẩu cho tài khoản của bạn.</p>
                        <p>Mã xác nhận của bạn là: <strong style='font-size: 1.2rem; color: #d9534f;'>$otpCode</strong></p>
                        <p>Mã này có hiệu lực trong vòng 15 phút. Nếu bạn không yêu cầu điều này, vui lòng bỏ qua email.</p>
                        <br>
                        <p>Trân trọng,<br>Đội ngũ Góc Gia Sư</p>
                    </div>";
            }

            return $mail->send();
        } catch (Exception $e) {
            error_log("Mail Error: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Thông báo xác nhận thanh toán thành công
     */
    public function sendPaymentConfirmedEmail(string $toEmail, string $studentName, string $subjectName): bool
    {
        try {
            $mail = $this->getMailer();
            $mail->addAddress($toEmail);
            $mail->isHTML(true);
            $mail->Subject = '[Góc Gia Sư] Xác nhận thanh toán thành công';
            $mail->Body    = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h2>Chào $studentName,</h2>
                    <p>Hệ thống đã xác nhận thanh toán thành công cho yêu cầu đặt lịch môn <strong>$subjectName</strong>.</p>
                    <p>Yêu cầu của bạn đã được gửi tới gia sư. Vui lòng chờ gia sư xác nhận lịch học chính thức.</p>
                    <p>Nếu có bất kỳ vấn đề gì, vui lòng liên hệ đội ngũ hỗ trợ:</p>
                    <ul>
                        <li>Email: gocgiasu.vn@gmail.com</li>
                        <li>SĐT: 0123456789</li>
                    </ul>
                    <br>
                    <p>Trân trọng,<br>Đội ngũ Góc Gia Sư</p>
                </div>";

            return $mail->send();
        } catch (Exception $e) {
            error_log("Payment Mail Error: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Thông báo gia sư đã chấp nhận lịch học
     */
    public function sendTutorConfirmedEmail(
        string $toEmail, 
        string $studentName, 
        string $tutorName, 
        string $tutorEmail, 
        string $tutorPhone, 
        string $subjectName, 
        string $date, 
        string $time
    ): bool {
        try {
            $mail = $this->getMailer();
            $mail->addAddress($toEmail);
            $mail->isHTML(true);
            $mail->Subject = '[Góc Gia Sư] Gia sư đã chấp nhận lịch học';
            $mail->Body    = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h2>Chào $studentName,</h2>
                    <p>Gia sư <strong>$tutorName</strong> đã chấp nhận lịch học môn <strong>$subjectName</strong> của bạn.</p>
                    <p><strong>Thông tin buổi học:</strong></p>
                    <ul>
                        <li>Ngày học: $date</li>
                        <li>Giờ học: $time</li>
                    </ul>
                    <p><strong>Thông tin liên hệ gia sư:</strong></p>
                    <ul>
                        <li>Họ tên: $tutorName</li>
                        <li>Số điện thoại: $tutorPhone</li>
                        <li>Email: $tutorEmail</li>
                    </ul>
                    <p>Bạn có thể liên hệ trực tiếp với gia sư để chuẩn bị cho buổi học.</p>
                    <br>
                    <p>Trân trọng,<br>Đội ngũ Góc Gia Sư</p>
                </div>";

            return $mail->send();
        } catch (Exception $e) {
            error_log("Tutor Confirm Mail Error: {$e->getMessage()}");
            return false;
        }
    }
}
