<?php
$db = Database::getInstance();
if (isset($_GET['termsAndConditions'])) {

    foreach ($db->getTermsAndConditionsDetails($_GET['termsAndConditions']) as $row) {
        $termsData = [
            'termsAndConditions_id' => $row['termsAndConditions_id'],
            'last_updated' => $row['last_updated'],
            'content' => $row['content']
        ];
    }
} else {
    Helper::goTo('admin_dashboard.php');
}

if ($_POST) {
    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        $id = $termsData['termsAndConditions_id'];
        $content = $_POST['content'];
        if ($db->updateTermsAndConditions($id, $content)) {
            Helper::setWarningMessage('terms and conditions updated');
            Helper::goTo('admin_dashboard.php');
        } else {
            Helper::setErrorMessage('unable to update terms and conditions');
        }
    }
}
