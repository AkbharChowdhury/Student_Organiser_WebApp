<?php
Breadcrumb::getInstanceRootDirectory('Teacher And Modules', 'modulesAndTeachers.php', null)->createBreadCrumb();

$db = Database::getInstance();
if (isset($_GET['deleteModuleID'])) {
    if ($db->deleteModule(Helper::html($_GET['deleteModuleID']))) {
        Helper::setErrorMessage('Module '. $_GET['module']. ' Successfully deleted');
        Helper::goTo('modulesAndTeachers.php');
        return;

    }
    Helper::setErrorMessage('Unable to Delete module');

}

if (isset($_GET['deleteTeacherID'])) {
    if ($db->deleteTeacher(Helper::html($_GET['deleteTeacherID']))) {

        Helper::setErrorMessage('Teacher '. $_GET['teacher']. ' Successfully deleted');
        Helper::goTo('modulesAndTeachers.php');
        return;

    }
    Helper::setErrorMessage('Unable to Deleted');

}