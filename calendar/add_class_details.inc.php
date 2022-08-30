<?php
require_once '../includes/class-autoload.php';
$db = Database::getInstance();
$db->addData('module_id', $_POST['module_id'])
->addData('semester_id', $_POST['semester_id'])
->addData('campus_id', $_POST['campus_id'])
->addData('day_id', $_POST['day_id'])
->addData('start_time', date("H:i", strtotime($_POST['start_time'])))
->addData('end_time', date("H:i", strtotime($_POST['end_time'])))
->addData('room', $_POST['room'])
->addData('colour', $_POST['colour'])
->addData('typeID', $_POST['type_id']);
echo json_encode($db->addClassDetails());
