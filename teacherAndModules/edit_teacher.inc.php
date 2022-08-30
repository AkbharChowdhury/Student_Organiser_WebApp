<?php
Breadcrumb::getInstanceSubDirectory('Teacher And Modules', 'modulesAndTeachers.php', null, $page_title)->createBreadCrumb();
$db = Database::getInstance();

if (isset($_GET['editTeacher'])) {
    if (!$db->getTeacherDetails(Helper::html($_GET['editTeacher']))) {
        Helper::goTo('modulesAndTeachers.php');
    }

    foreach ($db->getTeacherDetails($_GET['editTeacher']) as $row) {
        $teacher_details = [
            'teacher_id' => $row['teacher_id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'email' => $row['email'],
            'colour_id' => $row['colour_id']


        ];
    }
} else {

    Helper::goTo('modulesAndTeachers.php');

}


if (isset($_POST['updateTeacher'])) {

    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $colour_id = isset($_POST['colour_id']) ? $_POST['colour_id'] : null;
        $teacher_id = trim($_POST['teacher_id']);

        $db
            ->addData('firstname', $firstname)
            ->addData('lastname', $lastname)
            ->addData('email', $email)
            ->addData('colour_id', $colour_id)
            ->addData('teacher_id', $teacher_id);

        if ($db->updateTeacher()) {
            Helper::setWarningMessage('teacher details updated');
            unset($_POST);
            Helper::goTo('modulesAndTeachers.php');

            return;
        } 
        Helper::setErrorMessage('Unable to update teacher');

    }
}
