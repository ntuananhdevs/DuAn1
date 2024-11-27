<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class MailService {
    public function sendActivationEmail($toEmail, $temporaryPassword) {
        $mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nguyentuananh.ndta@gmail.com';
            $mail->Password = 'pyfy qiok oeir zyia'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('nguyentuananh.ndta@gmail.com', 'WinTech'); 
            $mail->addAddress($toEmail); 

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'Activate Your Account';
            $mail->Body = "
                <h1>Activate Your Account</h1>
                <p>Thank you for your purchase, please log in again to track your order</p>
                <p>Your temporary password is: <strong>$temporaryPassword</strong></p>
                <p>Please log in and change your password immediately.</p>
                <p><a href=''>Login Here</a></p>
            ";

            $mail->send();
            echo 'Activation email sent successfully!';
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
