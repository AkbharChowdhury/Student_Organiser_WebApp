<?php
$db = Database::getInstance();
Breadcrumb::getInstanceSubDirectory($current_page, 'campus.php', null, 'Edit campus')->createBreadCrumb();

if (isset($_GET['editCampus'])) {
    Helper::validateStudentCampus($db);
    foreach ($db->getCampusesDetails($_GET['editCampus']) as $row) {
        $campus_details = [
            'campus_id' => $row['campus_id'],
            'campus' => $row['campus'],
            'address' => $row['address'],
            'city' => $row['city'],
            'postcode' => $row['postcode']
        ];
    }
} else {
    Helper::goTo('campus.php');
}


if ($_POST) {
    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        $campus_id = $_POST['campus_id'];
        $campus = trim($_POST['campus']);
        $address = $_POST['address'];
        $city = trim($_POST['city']);
        $postcode = trim($_POST['postcode']);

        $db
            ->addData('campus', $campus)
            ->addData('address', $address)
            ->addData('city', $city)
            ->addData('postcode', $postcode)
            ->addData('campus_id', $campus_id);

        if($campus !== $campus_details['campus']){
            if ($db->duplicateCampus($campus)) {
                Helper::setErrorMessage('The campus '.$campus . ' already exists. Please enter a different campus');
                return;
            }
        }
        
        if ($db->updateCampus()) {
            Helper::setWarningMessage('campus details updated');
            Helper::goTo('campus.php');
            return;
        }
        Helper::setErrorMessage('Unable to edit campus');
    }
}
