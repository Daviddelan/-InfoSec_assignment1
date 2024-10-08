<?php
// email_utils.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer

function send_otp_via_email($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yanneykelvin72@gmail.com'; // Your email
        $mail->Password   = 'xflh hstk wxsd gsih'; // Your password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('yanneykelvin72@gmail.com', 'mail');
        $mail->addAddress($email); // Add recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is <b>$otp</b>. It is valid for 2 minutes.";
        $mail->AltBody = "Your OTP code is $otp. It is valid for 2 minutes.";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>