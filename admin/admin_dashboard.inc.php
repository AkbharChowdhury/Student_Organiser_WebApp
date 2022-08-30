<?php
$db = Database::getInstance();

if (isset($_POST['btnAddSemester'])) {
    $name = Helper::html($_POST['name']);
    $start_date  = date('Y-m-d', strtotime($_POST['start']));
    $end_date  = date('Y-m-d', strtotime($_POST['end']));
    $db
        ->addData('name', $name)
        ->addData('start_date', $start_date)
        ->addData('end_date', $end_date);
    $db->addSemester() ? Helper::setSuccessMessage('semester added') : Helper::setErrorMessage('Unable to add semester');
}

if (isset($_POST['btnAddActivity'])) {
    $type = Helper::html($_POST['type']);
    $colour_id = Helper::html($_POST['colour_id']);
    $db->addData('type', $type)->addData('colour_id', $colour_id);
    $db->addActivity() ? Helper::setSuccessMessage('Activity added') : Helper::setErrorMessage('Unable to add Activity');
}


if (isset($_GET['deleteSemester'])) {
    $db->deleteSemester($_GET['deleteSemester']) ? Helper::setErrorMessage('Semester Deleted') : Helper::setErrorMessage('Unable to delete semester');
    Helper::goTo(CURRENT_FILE);
    return;
}
if (isset($_GET['deleteActivity'])) {
    $db->deleteActivity($_GET['deleteActivity']) ? Helper::setErrorMessage('Activity Deleted') : Helper::setErrorMessage('Unable to delete Activity');
    Helper::goTo(CURRENT_FILE);

    return;
}