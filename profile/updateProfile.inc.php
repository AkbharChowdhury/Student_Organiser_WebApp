<?php
Breadcrumb::getInstanceRootDirectory('Profile', 'profile.php', null)->createBreadCrumb();
$db = Database::getInstance();
$selectedPreferences = [];

foreach ($db->getStudentDetails($_SESSION['student_id'])  as $row) {
    $student_details = [
        'student_id' => $row['student_id'],
        'firstname' => $row['firstname'],
        'lastname' => $row['lastname'],
        'email' => $row['email'],
        'phone' => $row['phone']

    ];
}
// get selected preferences
foreach ($db->getProfileComPref() as $row) {
    $selectedPreferences[] = $row['pref_id'];
}

if (isset($_POST['btnUpdateProfile'])) {
    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();

    if (!array_filter($errors)) {

        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim(trim($_POST['email']));
        $phone = trim($_POST['phone']);
        $communicationList = $_POST['communication'];

        if ($email !== $_SESSION['email']) {
            if ($db->studentEmailExists($email)) {
                Helper::setErrorMessage($email . ' already exists!');
                return;
            }
        }

        updateProfile($db, $firstname, $lastname, $email, $phone, $communicationList);
    } // filter error
} // btnUpdateProfile




function updateProfile($db, $firstname, $lastname, $email, $phone, $communicationList) {
    $db->addData('firstname', $firstname)
        ->addData('lastname', $lastname)
        ->addData('email', $email)
        ->addData('phone', $phone)
        ->addData('student_id', $_SESSION['student_id']);

    if ($db->updateProfile()) {
        $db->updatePreferences($communicationList);
        $_SESSION['email'] = $email;
        Helper::setWarningMessage('profile updated');
        Helper::goTo('profile.php');
        return;
    }
    Helper::setErrorMessage('There was an error updating your account');
}
