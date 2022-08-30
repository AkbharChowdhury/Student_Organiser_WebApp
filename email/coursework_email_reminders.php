<?php
require_once '../includes/class-autoload.php';

$mail = Mail::getInstance();

$template_file = $mail->getEmailTemplateFile();
$from = $mail->getAdminEmail();
$email_to = 'mc8852u@gre.ac.uk';
$subject = 'Coursework reminder';

// create the email headers
$headers = "From: EPlanner <$from>\r\n";
$headers.= "MIME-Version: 1.0\r\n";
$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

file_exists($template_file) ? $message = file_get_contents($template_file) : die('could not load template file');

$mail->setEmailTo($email_to)
->setSubject($subject)
->setMessage($message)
->setHeaders($headers);

$mail->sendEmail()? 'the email was sent': 'unable to send email';