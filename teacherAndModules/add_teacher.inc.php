<?php
$db = Database::getInstance();

Breadcrumb::getInstanceSubDirectory('teachers and modules', 'modulesAndTeachers.php', null, 'Add teachers and modules')->createBreadCrumb();
if (isset($_POST['addTeacher'])) {

    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $colour_id = isset($_POST['colour_id']) ? $_POST['colour_id'] : null;
        

        $db->addData('student_id', $_SESSION['student_id'])
            ->addData('firstname', $firstname)
            ->addData('lastname', $lastname)
            ->addData('email', $email)
            ->addData('colour_id', $colour_id);

        if ($db->addTeacher()) {
        Helper::setSuccessMessage('teacher added');
        unset($_POST);
        Helper::goTo('modulesAndTeachers.php');

        } else {
            Helper::setErrorMessage('unable to add teacher');

        }
    }
}
