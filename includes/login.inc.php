<?php

declare(strict_types=1);
error_reporting(0);
$db = Database::getInstance();
$mail = Mail::getInstance();

$_SESSION['attempts'];
$_SESSION['accountLocked'];
$_SESSION['lockedTime'];
$attempts_interval = [3, 6];
$minutes_intervals = [5];
if ($_POST) {

    Helper::checkStudentDeletion(trim($_POST['email']),$db);
    $validation = Validation::getInstance($_POST);
    $validation->setAdditionalChecks(false);
    $errors = $validation->validateForm();

    if (!array_filter($errors)) {

        $email = trim($_POST['email']);
        $password = sha1(trim($_POST['password']) . 'ijdb');
        $db->addData('email', $email)->addData('password', $password);


        // checks if account is suspended
        if ($db->isAccountSuspended($email)) {
            Helper::setErrorMessage('Your account has been suspended. Please contact please contact our  <a href="mailto:' . $mail->getAdminEmail() . '" class="alert-link">support team</a> to request login access');
            return;
        }
        // validate student credentials
        if ($db->databaseContainsStudent()) {
            unset($_SESSION['attempts']);
            unset($_SESSION['accountLocked']);

            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['student_id'] = $db->getStudentID($email);
            $_SESSION['admin_logged_in'] = false;

            // reactivate student account if they have deactivated it
            if (!empty($db->getDeletionDate($db->getStudentID($email)))) $db->activateAccount($db->getStudentID($email));


            // check if page was redirected to requested page otherwise redirect to default page
            $redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : FILE_PATH['dashboard'];
            Helper::goTo($redirect);
            return;
        }

        // check if email is correct and displays login attempt actions
        if ($db->emailIsCorrect($email)) {

            if (isset($_SESSION['accountLocked']) &&  $_SESSION['accountLocked'] !== false) {
                if (filter_var($_SESSION['accountLocked'], FILTER_VALIDATE_BOOLEAN)) {
                    if (accountUnlockedTimeLeft($_SESSION['account_unlocked_time']) !== '0 Minutes') {
                        Helper::setErrorMessage('Your account has been locked for <strong>' . $_SESSION['lockedTime'] . '  minutes</strong> Please try again within <strong>' . accountUnlockedTimeLeft($_SESSION['account_unlocked_time']) . '</strong> (' . date('g:i a', strtotime("{$_SESSION['account_unlocked_time']} UTC")) . ')');
                        unset($_POST);
                        return;
                    }
                    $_SESSION['accountLocked'] = false;
                    return;
                }
            }

            $_SESSION['attempts']++;
            in_array(intval(intval($_SESSION['attempts'])), $attempts_interval) ? $_SESSION['accountLocked'] = true : false;
            displayMessage($minutes_intervals, $mail, $db, $email);
        }
        unset($_POST);
    }
}

// display login attempt error messages
function displayMessage($minutesIntervals, $mail, $db, $email) {
    switch (intval($_SESSION['attempts'])) {
        case 2:
            Helper::setWarningMessage('you only have one more attempt left before your account is locked temporarily for  <strong>' . $minutesIntervals[0] . ' minutes!</strong>');
            break;
        case 3:
            $_SESSION['account_unlocked_time'] = add_time_in_minutes(date('Y-m-d H:i'), $minutesIntervals[0]);
            $_SESSION['lockedTime'] = $minutesIntervals[0];
            Helper::setErrorMessage('Your account has been locked for <strong>' . $minutesIntervals[0] . '  minutes</strong>Please try again within <strong>' . accountUnlockedTimeLeft($_SESSION['account_unlocked_time']) . '</strong> (' . date('g:i a', strtotime("{$_SESSION['account_unlocked_time']} UTC")) . ')');
            break;
        case 5:
            Helper::setWarningMessage('You only have one more attempt left before your account is locked and you will need to contact the admin');
            break;
        case 6:
            unset($_SESSION['attempts']);
            unset($_SESSION['accountLocked']);
            unset($_SESSION['lockedTime']);
            if ($db->suspendAccount($email, 'Too many failed login attempts')) Helper::setErrorMessage('There are too many failed login attempts. Your account has been suspended. Please contact our <a href="mailto:' . $mail->getAdminEmail() . '" class="alert-link">support team</a> to request login access');
    }
}

// add number of minutes to wait until the student can attempt to login again
function add_time_in_minutes($time, $plusMinutes) {
    $endTime = strtotime('+' . $plusMinutes . ' minutes', strtotime($time));
    return date('H:i:s', $endTime);
}
// displays the number of minutes left until the student can login
function accountUnlockedTimeLeft($time) {
    $currentDateTime = date_create(date('H:i:s'));
    $interval = date_diff($currentDateTime, date_create($time));
    return $interval->format('%h' == 1 ? '%h Hour' : '%i Minutes');
}
