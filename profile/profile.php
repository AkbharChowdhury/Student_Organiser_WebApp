<?php
$current_page = 'profile';
$page_title = 'profile';
require_once '../templates/header.php';
Breadcrumb::getInstanceRootDirectory('Profile', 'profile.php', null)->createBreadCrumb();
$db = Database::getInstance();
require_once 'profile_css.inc.php';
$studentID = $_SESSION['student_id'];
?>
<?php require_once '../includes/session_message.inc.php'; ?>
<div class="container">
    <?= Helper::getProfileDeleteMessage($db); ?>
</div>

<div class="container mt-4 mb-4 p-3 d-flex justify-content-start">

    <div class="card p-4">

        <?php foreach ($db->getStudentDetails($_SESSION['student_id']) as $row) : ?>

            <div class="image d-flex flex-column justify-content-center align-items-center"><span class="mt-3">
                    <h2><?= $row['firstname'] ?> <?= $row['lastname'] ?></h2>
                </span> <span class="text-muted"><?= $row['email'] ?></span>
                <?php foreach ($db->getCWStatus() as $status) : ?>
                    <div class="d-flex flex-row justify-content-center align-items-center mt-3"> <span class="number text-capitalize text-<?= $status['colour_class'] ?>"><?= $status['total'] ?> <span class="stats">coursework <?= $status['status_level'] ?></span></span> </div>
                <?php endforeach; ?>

                <div class="d-flex mt-2"> <a href="updateProfile.php" role="button" class="btn btn-warning">Edit Profile</a></div>
                <div class="d-flex mt-2"> <a href="updatePassword.php" role="button" class="btn btn-outline-success">Change password</a></div>

                <div class="px-2 rounded mt-4 date "> <span class="join">Joined <?= date('M, Y', strtotime($row['date_registered'])) ?></span> </div>
                <?php if (empty($db->getDeletionDate($studentID))) : ?>
                    <div class="d-flex mt-2"> <small><a href="delete_account.php" role="button" class="text-muted">I wish to delete my account</a< /small>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>