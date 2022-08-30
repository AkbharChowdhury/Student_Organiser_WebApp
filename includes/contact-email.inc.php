<?php

// send email
if ($_POST) {
    $db = Database::getInstance();
    $mail = Mail::getInstance();

    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();

    if (!array_filter($errors)) {
        // if there are no errors in form then redirect and insert values

        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim(trim($_POST['email']));
        $subject = trim($_POST['subject']);
        $message = nl2br($_POST['message']);

        // create the email headers
        $headers = "From: $firstname $lastname <$email>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $mail
        ->setEmailTo($mail->getAdminEmail())
        ->setSubject($subject)
        ->setMessage($message)
        ->setHeaders($headers);
        if($mail->sendEmail()){
            unset($_POST);
            Helper::setSuccessMessage("Thank you for contacting us. Your email has been sent. We'll try email you back within 3-5 days");
            
        } else{
            Helper::setErrorMessage("We are unable to receive your email at this time. Please try again later...");
        }

    }
}