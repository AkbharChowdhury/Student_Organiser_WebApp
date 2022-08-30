<?php
Breadcrumb::getInstanceSubDirectory('Teachers And Modules', 'modulesAndTeachers.php', null, 'manage teacher and modules')->createBreadCrumb();
$db = Database::getInstance();
$selectedModuleTeachers = [];
foreach ($db->getTeachersAndModuleList() as $row) $selectedModuleTeachers[] = [$row['module_id'], $row['teacher_id']];

if ($_POST) {

    if (!isset($_POST['module_teacher_list'])) {
        Helper::setErrorMessage('you must choose at least one teacher for ' . $db->getModuleName($_POST['module_id']));
    } else {
        $module_teacher_list = $_POST['module_teacher_list'];
        $module_id = $_POST['module_id'];

        if ($db->manageTeacherToModules($module_teacher_list, $module_id)) {
            Helper::setSuccessMessage('module teacher updated');
            Helper::goTo('teacher_module.php');
        }
    }
}
