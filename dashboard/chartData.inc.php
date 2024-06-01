<?php
session_start();
define('START_DATE', date('Y', strtotime('-1 year')) . '-09-01');
require '../includes/class-autoload.php';
$db = Database::getInstance();

// checklist pie chart
if (isset($_POST["action"]) &&  $_POST["action"] === 'getCWChecklist') {
    $data = $db->countCheckListItemsByCWPie($_POST['coursework_id'])[0];
    $colours = ['secondary' =>'#6c757d', 'danger' => '#FF0000'];
		$pie_chart_data = [
			'status_level' => $data["status_level"],
			'status_total' => $data["status_total"],
			'color' =>
//                $data["status_colour"]
                $data["status_colour"] === $colours['secondary'] ? $colours['danger'] : $data["status_colour"]
		];
	echo json_encode($pie_chart_data);
}

// cw chart data
if (isset($_POST["action"]) &&  $_POST["action"] === 'getCWChartData') echo json_encode($db->getTotalYearlyCW(START_DATE));


if (isset($_POST["action"]) &&  $_POST["action"] === 'getCourseworkDetails') {
	$m = $_POST['month'];
	$month = Helper::getMonth($m);
	$year = $_POST['year'];
	$start = "$year-$month-01 00:00:00";
	$lastDay = cal_days_in_month(CAL_GREGORIAN, Helper::getLastDayOfMonth($m), $year);
	$end = "$year-$month-".$lastDay .' 00:00:00';
	echo json_encode($db->getTotalYearlyCWByMonth($start, $end));
}

// yearly activities
if (isset($_POST["action"]) &&  $_POST["action"] === 'getYearlyActivities') echo json_encode($db->getTotalYearlyPCActivities(START_DATE));


