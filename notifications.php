<?php
if(@$_GET['mailcmd'] != 'B$SKREBHEKE2PK7NXb%DfZ3ZjYEBsdawsyH94hYRu#NKKuWNq%kMyA4^ZZRZ%yZm9@U5eXu&7NmA$YvXmQn8Fb3xkG!*hFS!B!B'){exit("bad");}

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
#$msg2send = ($argv[1]) ? $argv[1]:"";
$msg2send = (@$_GET['msg']) ? @$_GET['msg']:"";

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->SMTPDebug = false;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'mail.valuemedia.com.ng';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = '_mainaccount@valuemedia.com.ng';                     // SMTP username
    $mail->Password   = 'S@ve@uschw1tz!';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('ademola.shasanya@valuemedia.com.ng', 'Demola');
    $mail->addAddress('ademola.shasanya@valuemedia.com.ng', 'Ademola');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Transit Media Mailer Error';
    $mail->Body    = 'Transit Media Mailer Error'."\n".$msg2send;
    $mail->AltBody = 'Transit Media Mailer Error'."\n".$msg2send;

    $mail->send();
    //echo 'Message has been sent';
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
