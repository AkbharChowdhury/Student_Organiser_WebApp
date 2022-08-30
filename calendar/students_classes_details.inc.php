<?php
session_start();
date_default_timezone_set('Europe/London');
require_once '../includes/class-autoload.php';
$events = [];
$db = Database::getInstance();

// get class details
foreach ($db->getAcademicCalendar() as $row) {
    $events[] = [
        'isCoursework' => false,
        'id' => $row['class_id'],
        'title' => $row['module_code'] . ' ' . $row['module_name'],
        'start' => date('H:i', strtotime($row['start_time'])),
        'end' => date("H:i", strtotime($row['end_time'])),
        'dow' => $row['day_id'],
        'color' => $row['colour'],
        'type' => $row['type'],
        'teacher_name' => $row['teacher_name'],
        'room' => $row['room'],
        'duration' => Helper::formatTime(Helper::toMinutes($row['start_time'], $row['end_time'])),
        'ranges' => [0 => ['start' => $row['semester_start'], 'end' => $row['semester_end']]]
    ];
}

// get coursework details
foreach ($db->getCoursework() as $coursework) {
    $events[] = [
        'isCoursework' => true,
        'id' => $coursework['coursework_id'],
        'title' => $coursework['module_code'] . ' ' . $coursework['module_name'],
        'cwTitle' => $coursework['title'],
        'due' => Helper::formatDueDate($coursework['due_date']),
        'start' => $coursework['due_date'],
        'end' => $coursework['due_date'],
        'color' => Helper::getCWColour()
    ];
}

echo json_encode($events);
