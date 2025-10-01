<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);     
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : '';
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : '';

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'chetan9689576210@gmail.com';
        $mail->Password = 'mgro psds qrjb qzrr'; // Replace with the actual password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('chetan9689576210@gmail.com', 'No Reply');        
        $mail->addAddress('cubarhande@gmail.com');  
       
        // Content
        $mail->isHTML(false);
        $mail->Subject = "New contact from $name";
        $mail->Body    = "Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message\n";

        $mail->send();
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
        
       
    } catch (Exception $e) {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>