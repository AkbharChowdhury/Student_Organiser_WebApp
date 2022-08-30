<?php
//https://codepen.io/RodrigoWebDev/pen/Xqygmb
Breadcrumb::getInstanceRootDirectory('Profile', 'profile.php', null)->createBreadCrumb();

$db = Database::getInstance();

if ($_POST) {

    $reason = $_POST['reason'];
    $suggestion = $_POST['suggestion'] ?? null;
    //if(!empty($suggestion)) echo 'suggestion: '.nl2br($suggestion);
    $mail = Mail::getInstance();
    foreach ($db->getStudentDetails($_SESSION['student_id']) as $row) {
        $student_details = [
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'email' => $row['email'],
        ];
    }

    // create the email headers
    $headers = "From: {$student_details['firstname']} {$student_details['lastname']} <{$student_details['email']}>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $mail
        ->setEmailTo($mail->getAdminEmail())
        ->setSubject('Account deletion request - ' . $reason)
        ->setMessage($suggestion)
        ->setHeaders($headers);
    if ($mail->sendEmail()) {
        unset($_POST);
        $deletion_date =  date('Y/m/d', strtotime('+1 month', strtotime(date('Y/m/d h:i:s'))));
        if ($db->deactivateAccount($deletion_date)) {

            $deletion_date_str = date('l jS \of F Y', strtotime($db->getDeletionDate($_SESSION['student_id'])));

            Helper::setErrorMessage("Thank you for your feedback. your account will be deleted on <strong>{$deletion_date_str}</strong>. Please login by this date to reactivate your account");
        } else {
            Helper::setErrorMessage('We are unable to delete your student profile');
        }
    } else {
        Helper::setErrorMessage('We are unable to receive your email at this time. Please try again later...');
    }
}
