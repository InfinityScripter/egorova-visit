<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0; // Отключаем отладочную информацию (0 или false)
    $mail->CharSet = 'UTF-8'; // Устанавливаем кодировку
    $mail->Encoding = 'base64'; // Устанавливаем кодировку контента
    $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
    $mail->Port = 587; // TLS only
    $mail->SMTPSecure = 'tls'; // ssl is deprecated
    $mail->SMTPAuth = true;
    $mail->Username = 'your email'; // email address from which you want to send email
    $mail->Password = 'app password'; // password
    $mail->setFrom('your email', 'Zakaz'); // From email and name shod be same as SMTP credentials
    $mail->addAddress('email add adress', 'name'); // to email and name
    $mail->Subject = '=?UTF-8?B?' . base64_encode('Заказ') . '?='; // subject в кодировке UTF-8
    $mail->Body = "Имя: $name\nEmail: $email\nСообщение:\n$message";

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}
?>
