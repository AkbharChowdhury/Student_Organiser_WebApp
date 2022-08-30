<?php
$db = Database::getInstance();
if (isset($_POST['admin_login'])) {
    $validation = Validation::getInstance($_POST);
    $validation->setAdditionalChecks(false);
    $errors = $validation->validateForm();

    if (!array_filter($errors)) {
        $username = trim($_POST['username']);
        $password = sha1(trim($_POST['password']) . 'ijdb');
        $db->addData('username', $username)->addData('password', $password);
        // validate student credentials
        if ($db->databaseContainsAdmin()) {

            $_SESSION['logged_in'] = true;
            $_SESSION['admin_logged_in'] = true;
            // check if page was redirected to requested page otherwise redirect to default page
            Helper::goTo('admin/admin_dashboard.php');
            return;
        }

        unset($_POST);
    }
}