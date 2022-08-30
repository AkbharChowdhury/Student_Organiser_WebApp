<?php
Breadcrumb::getInstanceSubDirectory('Teacher And Modules', 'modulesAndTeachers.php', null, $page_title)->createBreadCrumb();
$db = Database::getInstance();

if (isset($_GET['editModule'])) {

    Helper::validateStudentModules($db);

    foreach ($db->getModuleDetails($_GET['editModule']) as $row) {
        $module_details = [
            'module_id' => $row['module_id'],
            'module_code' => $row['module_code'],
            'module_name' => $row['module_name']
        ];
    }
} 

else {
    Helper::goTo('modulesAndTeachers.php');
}

if (isset($_POST['update_module'])) {

    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        $module_id = $_POST['module_id'];
        $module_code = trim($_POST['module_code']);
        $module_name = trim($_POST['module_name']);

        $db
        ->addData('module_code', $module_code)
        ->addData('module_name', $module_name)
        ->addData('module_id', $module_id);
        if( $module_code !==$module_details['module_code']){
            if ($db->duplicateModule($module_code)) {
                Helper::setErrorMessage($module_code . ' module code already exists! Please choose a unique module code!');
                return;
            }

        }
        
        if ($db->duplicateModuleName($module_name)) {
            Helper::setErrorMessage('The module name '.$module_name . 
            ' already exists! Please choose a unique module name!');
            return;
        }

        if ($db->updateModule()) {
            Helper::setWarningMessage('Module details updated');
            Helper::goTo('modulesAndTeachers.php');
        } else {
            Helper::setErrorMessage('Unable to edit Module');
        }
    }
}
