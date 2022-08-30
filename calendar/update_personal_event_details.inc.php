<?php

require_once '../includes/class-autoload.php';
$db = Database::getInstance();
if($_POST){

    $db->addData('title', $_POST['event_title'])
    ->addData('description', $_POST['event_description'])
    ->addData('location', $_POST['location'])
    ->addData('start', $_POST['event_start_date_time_edited'])
    ->addData('end', $_POST['event_end_date_time_edited'])
    ->addData('status_id', $_POST['event_status_id'])
    ->addData('priority_id', $_POST['event_priority_id'])
    ->addData('activity_id', $_POST['event_type_id'])
    ->addData('personal_calendar_id', $_POST['personal_calendar_id']);    
   echo json_encode($db->updatePersonalCalendar());
}

