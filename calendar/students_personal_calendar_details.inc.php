<?php
session_start();
date_default_timezone_set('Europe/London');
require_once '../includes/class-autoload.php';
$events = [];
$db = Database::getInstance();
foreach ($db->getPersonalCalendar() as $row) {

    $start = explode(' ', $row['start']);
    $end = explode(' ', $row['end']);
    
    $start = $start[1] == '00:00:00' ? $start[0]: $row['start'];
    $end = $end[1] == '00:00:00' ? $end[0]: $row['end'];
    
    $events[] = [
        'id' => $row['personal_calendar_id'],
        'title' => $row['title'],
        'start_date' => explode(' ', $row['start'])[0],
        'end_date' => explode(' ', $row['end'])[0],
        'start_time' => date('H:i', strtotime(explode(' ', $row['start'])[1])),
        'end_time' => date('H:i', strtotime(explode(' ', $row['start'])[1])),
        'start' => $start,
        'end' => $end,
        'color' => $row['activity_colour'], //'#424983',,
        'type' => $row['type'], //'#424983',

        'duration' => Helper::formatTime(Helper::toMinutes(date('H:i', strtotime(explode(" ", $row['start'])[1])),date('H:i', strtotime(explode(" ", $row['end'])[1])))),
    ];
}
echo json_encode($events);