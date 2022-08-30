<?php
$db = Database::getInstance();
if (isset($_GET['student_id'])) {
    $studentID = $_GET['student_id'];

    foreach ($db->getStudentDetails($studentID) as $row) {
        $studentData = [

            'student_id' => $row['student_id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'email' => $row['email'],
            'student_account_deleted' => $row['student_account_deleted'],
            'reason' => $row['reason']
        ];
    }
} else {
    Helper::goTo('admin_dashboard.php');
}
// send email
if ($_POST) {
    $db = Database::getInstance();
    $mail = Mail::getInstance();

    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();

    if (!array_filter($errors)) {
        // if there are no errors in form then redirect and insert values

        $account_suspended = trim($_POST['account_suspended']);
        $reason = trim($_POST['reason']);
        $action_taken = trim(trim($_POST['action_taken']));

        $subject = trim($reason);
        $message = nl2br($action_taken);

        // create the email headers
        $headers = "From: StudentPlanner <{$mail->getAdminEmail()}>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $mail
            ->setEmailTo($mail->getAdminEmail())
            ->setSubject($subject)
            ->setMessage($message)
            ->setHeaders($headers);
        if ($mail->sendEmail()) {

            if ($db->reviewStudentAccount($studentData['student_id'], $account_suspended, $reason)) {
                Helper::setSuccessMessage('Account reviewed');
            }
        } else {
            Helper::setErrorMessage('problem with account review');
        }
    }
}
