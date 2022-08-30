<?php
Breadcrumb::getInstanceRootDirectory('Profile', 'profile.php', null)->createBreadCrumb();
$db = Database::getInstance();
if($_POST){
    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        $password = trim($_POST['password'] . 'ijdb');
        if ($db->updatePassword($password)) {
            Helper::setWarningMessage('password has been updated');
            Helper::goTo('profile.php');
        }
    }
}