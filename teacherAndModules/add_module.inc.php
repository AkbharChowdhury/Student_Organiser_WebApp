<?php
ob_start();
$db = Database::getInstance();
Breadcrumb::getInstanceSubDirectory('Teachers And Modules', 'modulesAndTeachers.php', null, $page_title)->createBreadCrumb();


if (isset($_POST['addModule'])) {

    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        $module_code = trim($_POST['module_code']);
        $module_name = trim($_POST['module_name']);

        if ($db->duplicateModule($module_code)) {
            Helper::setErrorMessage($module_code . ' module code already exists! Please choose a unique module code!');
            return;
        }

        if ($db->duplicateModuleName($module_name)) {
            Helper::setErrorMessage('The module name '.$module_name . ' already exists! Please choose a unique module name!');
            return;
        }

        $db
        ->addData('module_code', $module_code)
        ->addData('module_name', $module_name)
        ->addData('student_id', $_SESSION['student_id']);
        if ($db->addModule()) {
            Helper::setSuccessMessage("The module: $module_code $module_name was successfully added");
            Helper::goTo('modulesAndTeachers.php');
            unset($_POST);

            return;
        } 
        Helper::setErrorMessage('There was an error adding module');


        
    }
}
