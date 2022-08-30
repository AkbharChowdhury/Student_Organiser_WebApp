<?php
$db = Database::getInstance();
if (isset($_GET['editActivity'])) {

    foreach ($db->editActivity($_GET['editActivity']) as $row) {
        $activityData = [
            'activity_id' => $row['activity_id'],
            'type' => $row['type'],
            'colour_id' => $row['colour_id']
        ];
    }
} else {
    Helper::goTo('admin_dashboard.php');
}
if ($_POST) {
    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        
        $type = $_POST['type'];
        $colour_id = $_POST['colour_id'];

        $db
        ->addData('type',$type)
        ->addData('colour_id',$colour_id)
        ->addData('activity_id',$activityData['activity_id']);

        if ($db->updateActivity()) {
            Helper::setWarningMessage('Activity updated');
            Helper::goTo('admin_dashboard.php');
        } else{
            Helper::setErrorMessage('unable to update Activity');


        }
    }
}