<?php

Breadcrumb::getInstanceSubDirectory(currentPage:  $current_page, menuLink: 'coursework.php', rootDirectory: false,  menuDescription: $page_title)->createBreadCrumb();

$db = Database::getInstance();


if (isset($_POST['add_coursework'])) {
    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateCourseworkForm();
    if (!array_filter($errors)) {



        $module_id = $_POST['module_id'];
        $priority_id = $_POST['priority_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $colour_tag =  $_POST['colour_tag'];
        $due_date =   $_POST['due_date']; //date('Y-m-d', strtotime(str_replace('/', '-', $_POST['due_date'])));
        $status_id = $_POST['status_id'];
        $notes = $_POST['notes'];
        $image = $_POST['image'];
        $checklist_title = $_POST['checklist_title'];

        $db
            ->addData('module_id', $module_id)
            ->addData('priority_id', $priority_id)
            ->addData('title', $title)
            ->addData('description', $description)
            ->addData('colour_tag', $colour_tag)
            ->addData('due_date', $due_date)
            ->addData('status_id', $status_id);

        if ($db->addCoursework()) {
            // add coursework and notes
            if (!empty($notes) || !empty($image)) $db->addCourseworkNotes($notes, $image);
            // addCoursework CheckList
            if (!empty($checklist_title)) $db->addCourseworkCheckList($checklist_title);
            // show success message and redirect
            Helper::setSuccessMessage('coursework added');
            Helper::goTo('coursework.php');
        }
    }
}
