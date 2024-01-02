<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader

// function sendEmail($recipients, $subject, $body)
// {
$mail = new PHPMailer(true);
// $recipients = ['asanka.land@gmail.com', 'asanka.ird@gmail.com', 'asanka.inf@gmail.com'];
// $subject = 'New Project Saved';
// $body = 'A new project has been saved.';

$recipients = $_POST['recipients'];
$subject = $_POST['subject'];
$body = $_POST['body'];

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'asanka.ird@gmail.com';
    $mail->Password   = 'xgqgphwwpdwwnhor';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('common.ird23@gmail.com', 'PMS ALERT');
    foreach ($recipients as $recipient) {
        $mail->addAddress($recipient);
    }

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    $mail->send();
    echo '<script>alert("Message has been sent");</script>';
} catch (Exception $e) {
    echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
}
// }
