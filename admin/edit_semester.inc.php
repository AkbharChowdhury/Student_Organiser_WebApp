<?php

$db = Database::getInstance();
if (isset($_GET['editSemester'])) {
   
    foreach ($db->editSemester($_GET['editSemester']) as $row) {
        $semesterData = [
            'semester_id' => $row['semester_id'],
            'semester_name' => $row['name'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date']

        ];
    }
} else {
    Helper::goTo('admin_dashboard.php');
}

if ($_POST) {
    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {

        $name = trim($_POST['semester_name']);
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];    
        $db
        ->addData('name',$name)
        ->addData('start_date',$start_date)
        ->addData('end_date',$end_date)
        ->addData('semester_id',$semesterData['semester_id']);

        if ($db->updateSemester()) {
            Helper::setWarningMessage('Semester updated');
            Helper::goTo('admin_dashboard.php');
        } else {
            Helper::setErrorMessage('unable to update semester');
        }

    }
}