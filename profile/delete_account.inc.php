<?php
//https://codepen.io/RodrigoWebDev/pen/Xqygmb
Breadcrumb::getInstanceRootDirectory('Profile', 'profile.php', null)->createBreadCrumb();

$db = Database::getInstance();

if ($_POST) {

    $reason = $_POST['reason'];
    $suggestion = $_POST['suggestion'] ?? null;
    //if(!empty($suggestion)) echo 'suggestion: '.nl2br($suggestion);
    $mail = Mail::getInstance();
    $student = $db->getStudentDetails($_SESSION['student_id'])[0];
    $student_details = [
        'firstname' => $student ['firstname'],
        'lastname' => $student ['lastname'],
        'email' => $student ['email'],
    ];
//    foreach ($db->getStudentDetails($_SESSION['student_id']) as $row) {
//        $student_details = [
//            'firstname' => $row['firstname'],
//            'lastname' => $row['lastname'],
//            'email' => $row['email'],
//        ];
//    }

    // create the email headers
    $from = "{$student_details['firstname']} {$student_details['lastname']} <{$student_details['email']}>";
//    $headers = "From: {$student_details['firstname']} {$student_details['lastname']} <{$student_details['email']}>";


    $mail
        ->setEmailTo($mail->getAdminEmail())
        ->setSubject('Account deletion request - ' . $reason)
        ->setMessage($suggestion)
        ->setHeaders($mail->createHeaders($from));
    if ($mail->sendEmail()) {
        unset($_POST);
        $deletion_date = date('Y/m/d', strtotime('+1 month', strtotime(date('Y/m/d h:i:s'))));
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
