<?php
$_SESSION['reminder'] = 1;
$db = Database::getInstance();

/******************************* mail functionality ************************** */
$mail = Mail::getInstance();

$template_file = $mail->getEmailTemplateFile();
$from = $mail->getAdminEmail();
$subject = 'Coursework reminder';

// create the email headers
$headers = "From: StudentPlanner <$from>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
// // check if there are upcoming coursework this month
if ($db->getUpcomingCourseworkByMonth()) {

    if($_SESSION['reminder'] == 1){
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
$percentageCompleted = 0;
$progress_bar_class = '';
$cwProgressData = ['icon' => '', 'text' => ''];

// check if cw exists
if ($db->getUpcomingCourseworkByMonth()) {
    
    if($db->getCourseworkStatusByMonth()){
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
    $percentageCompleted = round(($cwProgress['total_completed'] / $totalCW) * 100);

    $width = 40;
    $height = 40;

    if ($percentageCompleted == 100) {

        $progress_bar_class = 'bg-success';
        $cwProgressData['text'] =
            '<p class="text-success"><strong>Hurray, you have completed all your coursework</strong> <br>
                Tip:try proofreading your coursework using <a href="https://www.grammarly.com" class="link-success">Grammarly</a>
            </p>';

        $cwProgressData['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
          </svg>';

    } else if ($percentageCompleted >= 50) {
        $progress_bar_class = 'bg-warning';
        $cwProgressData['text'] =
            '<p class="text-warning"><strong>You are on task, Keep going! you are almost done!</strong></p>';
        $cwProgressData['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" fill="currentColor" class="bi bi-emoji-neutral" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M4 10.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5zm3-4C7 5.672 6.552 5 6 5s-1 .672-1 1.5S5.448 8 6 8s1-.672 1-1.5zm4 0c0-.828-.448-1.5-1-1.5s-1 .672-1 1.5S9.448 8 10 8s1-.672 1-1.5z"/>
          </svg>';
    } else {
        // default progress
        $progress_bar_class = 'bg-danger';
        $cwProgressData['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
      </svg>';

        $cwProgressData['text'] = '<p class="text-danger"><strong>you need to make more effort</p>';
        }
    }
}
} 

