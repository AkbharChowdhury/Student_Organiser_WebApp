<?php
$_SESSION['reminder'] = 1;
$db = Database::getInstance();

/******************************* mail functionality ************************** */
$mail = Mail::getInstance();

$template_file = $mail->getEmailTemplateFile();
$from = $mail->getAdminEmail();
$subject = 'Coursework reminder';

// create the email headers
//$headers = "From: StudentPlanner <$from>\r\n";
//$headers .= "MIME-Version: 1.0\r\n";
//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
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
$percentageCompleted=0;
$progress_bar_class = '';
$cwProgressData = ['icon' => '', 'text' => ''];
$icons = ProgressBar::getIcons();
$messages = ProgressBar::messages();
if ($db->getUpcomingCourseworkByMonth()) {

    if ($db->getCourseworkStatusByMonth()) {
        foreach ($db->getCourseworkStatusByMonth() as $cwStatus) {

            $totalCW = intval($cwStatus["total_number_of_coursework"]);
            $cwProgress = [
                'total_completed' => intval($cwStatus["total_completed"]),
                'total_in_progress' => $cwStatus["total_in_progress"],
                'total_not_completed' => $cwStatus["total_not_completed"],
                'percentage_completed' => round((intval($cwStatus["total_completed"]) / $totalCW) * 100),
                'percentage_in_progress' => round((intval($cwStatus["total_in_progress"]) / $totalCW) * 100),
                'percentage_not_completed' => round((intval($cwStatus["total_not_completed"]) / $totalCW) * 100)
            ];
            $percentageCompleted = ProgressBar::calcPercentageCompleted($cwProgress['total_completed'], $totalCW);


            if ($percentageCompleted == 100) {

                $progress_bar_class = 'bg-success';
                $cwProgressData['text'] = $messages['complete'];
                $cwProgressData['icon'] = $icons['complete'];

            } else if ($percentageCompleted >= 50) {

                $progress_bar_class = 'bg-warning';
                $cwProgressData['text'] = $messages['in_progress'];
                $cwProgressData['icon'] = $icons['in_progress'];

            } else {

                $progress_bar_class = 'bg-danger';
                $cwProgressData['icon'] = $icons['incomplete'];
                $cwProgressData['text'] = $messages['incomplete'];
            }


        }
    }

}


