<?php
require_once '../includes/class-autoload.php';
$db = Database::getInstance();

if (isset($_POST['personalEventDetails'])) {
    $decoded = json_decode($_POST['personalEventDetails'], true);

    $db->addData('start', $decoded['start']);
    $db->addData('end', $decoded['end']);
    $db->addData('personal_calendar_id', $decoded['personal_calendar_id']);
    echo $db->updatePersonalCalendarEndDate();
}