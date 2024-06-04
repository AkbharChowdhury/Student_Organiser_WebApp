<?php
require_once '../includes/class-autoload.php';
$db = Database::getInstance();

if (isset($_POST['personalEventDetails'])) {
    $data = json_decode($_POST['personalEventDetails'], true);

    $db->addData('start', $data['start']);
    $db->addData('end', $data['end']);
    $db->addData('personal_calendar_id', $data['personal_calendar_id']);
    echo $db->updatePersonalCalendarEndDate();
}