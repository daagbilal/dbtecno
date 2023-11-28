<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = "";
    $mail->Host = "";
    $mail->Username = "";
    $mail->Password = "";
    $mail->CharSet = "UTF-8";
} catch (Exception $e) {
    echo "Mail Hatası: $e";
}
