<?php
Breadcrumb::getInstanceSubDirectory(currentPage: 'Coursework', menuLink: 'coursework.php', rootDirectory: false ,menuDescription: 'edit coursework')->createBreadCrumb();
$db = Database::getInstance();

if (isset($_GET['editCoursework'])) {
    foreach ($db->getCourseworkDetails($_GET['editCoursework']) as $row) {
        $coursework_data = [
            'coursework_id' => $row['coursework_id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'note_id' => $row['note_id'],
            'module_id' => $row['module_id'],
            'priority_id' => $row['priority_id'],
            'description' => $row['description'],
            'colour_tag' => $row['colour_tag'],
            'due_date' => $row['due_date'],
            'status_id' => $row['status_id'],
            'note_description' => $row['note_description'],
            'image' => $row['image'],
            'attachments' => $row['attachments']
        ];
    }
} else {
    Helper::goTo('coursework.php');
}
if (isset($_POST['updateCoursework'])) {

    $module_id = $_POST['module_id'];
    $priority_id = $_POST['priority_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $colour_tag =  $_POST['colour_tag'];
    $due_date =  $_POST['due_date'];
    $status_id = $_POST['status_id'];
    $coursework_id = $_POST['coursework_id'];
    $notes = $_POST['notes'];
    $image = $_POST['image'];
    $checklist_title =  $_POST['checklist_title'];

    $db
        ->addData('module_id', $module_id)
        ->addData('priority_id', $priority_id)
        ->addData('title', $title)
        ->addData('description', $description)
        ->addData('colour_tag', $colour_tag)
        ->addData('due_date', $due_date)
        ->addData('status_id', $status_id)
        ->addData('coursework_id', $coursework_id);


    if ($db->updateCoursework()) {
        $db->resetData();
        $db
            ->addData('note_description', $notes)
            ->addData('image', $image)
            ->addData('coursework_id', $coursework_id);
        $db->updateCourseworkNotes();

        if(!empty($_POST['checklist_title'][0])) {
            $db->updateChecklist($coursework_id, $checklist_title);


        }
        Helper::setWarningMessage('coursework updated');
        Helper::goTo('coursework.php');
        return;
    }
    Helper::setErrorMessage('unable to coursework');
}

