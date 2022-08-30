<?php
$current_page = 'admin_dashboard';
$page_title = 'Admin Dashboard';
require_once '../templates/header.php';
require_once 'editTermsAndConditions.inc.php';
?>

<div class="container py-5">
    <?= Helper::breadcrumb('terms & conditions', 'admin_dashboard.php') ?>

    <h1>Terms and conditions</h1>
    <p>Last updated: <?= Helper::formatTCDate($termsData['last_updated']) ?></p>
    <form class="row g-3" action="" method="post">
        <div class="col-12">
            <textarea class="form-control editor" id="content" name="content" rows="3" placeholder="terms and conditions" required><?= $termsData['content'] ?></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-warning">Update Terms and conditions</button>
        </div>
    </form>

</div>


<?php require_once '../templates/footer.php'; ?>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="../js/checklist.js"></script>