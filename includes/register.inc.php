<?php
$db = Database::getInstance();
if ($_POST) {

    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        // if there are no errors in form then redirect and insert values

        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $phone = trim($_POST['phone']);
        $email = trim(trim($_POST['email']));
        $password = trim($_POST['password'] . 'ijdb');
        $com_pref_list = $_POST['communication'];

        if ($db->studentEmailExists($email)) {
            Helper::setErrorMessage($email. ' already exists!');
            return;
        }

        $db->addData('firstname', $firstname)
            ->addData('lastname', $lastname)
            ->addData('phone', $phone)
            ->addData('email', $email)
            ->addData('password', $password);

            if($db->addStudent()){
            	if(!empty($com_pref_list)) $db->addCommunicationPreferences($com_pref_list);
                
                $_SESSION['account_created'] = true;
                Helper::goTo('thankyou.php');

            }
        Helper::setErrorMessage('There was an error creating your account');

    }
}
