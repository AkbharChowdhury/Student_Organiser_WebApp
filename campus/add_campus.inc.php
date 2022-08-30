<noscript>
    <?php
    if (isset($_POST['search_campus'])) {

        $address = trim(str_replace(' ', '+', $_POST['address']));

        $campus_map = '
        <div class="ratio ratio-16x9">
      <iframe src="https://maps.google.com/maps?q=' . $address . '&output=embed" title="campus map" allow="geolocation"></iframe>
    </div>
     ';
    }
    ?>
</noscript>
<?php
Breadcrumb::getInstanceSubDirectory($current_page, 'campus.php', null, 'add campus')->createBreadCrumb();
$db = Database::getInstance();

if (isset($_POST['add_campus'])) {

    $validation = Validation::getInstance($_POST);
    $errors = $validation->validateForm();
    if (!array_filter($errors)) {
        $campus = trim($_POST['campus']);
        $address = $_POST['address'];
        $city = trim($_POST['city']);
        $postcode = trim($_POST['postcode']);

        $db->addData('student_id', $_SESSION['student_id'])
            ->addData('campus', $campus)
            ->addData('address', $address)
            ->addData('city', $city)
            ->addData('postcode', $postcode);

        if($db->duplicateCampus($campus)){
            Helper::setErrorMessage($campus.' already exists. Please enter a different campus');
            return;
        }
        if ($db->addCampus()) {
            Helper::setSuccessMessage('campus added');
            Helper::goTo('campus.php');
            return;
        }
        Helper::setErrorMessage('Unable to add campus');
    }
}

