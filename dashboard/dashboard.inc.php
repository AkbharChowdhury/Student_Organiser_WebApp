<?php
$db = Database::getInstance();
/******************************* mail functionality ************************** */
$mail = Mail::getInstance();
$template_file = $mail->getEmailTemplateFile();
$from = $mail->getAdminEmail();
$subject = 'Coursework reminder';
$headers = $mail->createHeaders(LOGO_TEXT . " <$from>");
// // check if there are upcoming coursework this month
if ($db->getUpcomingCourseworkByMonth()) {

    if ($_SESSION['reminder'] == 1) {
        if ($db->communicationType('email')) {

            // send email reminder
            $mail->setEmailTo($_SESSION['email'])
                ->setSubject($subject)
                ->setMessage($mail->renderCourseworkEmailReminder($db))
                ->setHeaders($headers);
            $mail->sendEmail();
        }

        if ($db->communicationType('phone')) {
            // send sms reminder
        }
    }

}
/******************************* items completed ************************** */

if (isset($_POST['btnSetCompleted'])) {
    $coursework_id = trim($_POST['coursework_id']);
    $title = trim($_POST['title']);
    if ($db->setCWStatusToCompleted($coursework_id)) {
        Helper::setSuccessMessage($title . ' coursework has been completed');
    } else {
        Helper::setErrorMessage('cannot set coursework status');
    }
}

if (isset($_POST['btnSetCompletedPersonal'])) {
    $personal_calendar_id = trim($_POST['personal_calendar_id']);
    $title = trim($_POST['title']);
    if ($db->setPCStatusToCompleted($personal_calendar_id)) {
        Helper::setSuccessMessage($title . ' event has been completed');
    } else {
        Helper::setErrorMessage('cannot set personal event status');
    }
}
/******************************* items completed ends here ************************** */


/******************************* coursework progress bars ************************** */
$progress = new ProgressBar($db);
$percentageCompleted = 0;
$cwProgressData = ['class' => '', 'icon' => '', 'text' => ''];
if ($db->getUpcomingCourseworkByMonth()) {
    if ($db->getCourseworkStatusByMonth()) {
        foreach ($db->getCourseworkStatusByMonth() as $cwStatus) {
            $totalCW = intval($cwStatus["total_number_of_coursework"]);
            $cwProgress = [
                'total_completed' => intval($cwStatus["total_completed"]),
                'total_in_progress' => intval($cwStatus["total_in_progress"]),
                'total_not_completed' => intval($cwStatus["total_not_completed"]),
                'percentage_completed' => ProgressBar::calcPercentage($cwStatus["total_completed"], $totalCW),
                'percentage_in_progress' => ProgressBar::calcPercentage($cwStatus["total_in_progress"], $totalCW),
                'percentage_not_completed' => ProgressBar::calcPercentage($cwStatus["total_not_completed"], $totalCW)
            ];
            $percentageCompleted = ProgressBar::calcPercentage($cwProgress['total_completed'], $totalCW);
            $cwProgressData = ProgressBar::getPercentageData($percentageCompleted);
        }
    }
}


