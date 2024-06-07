<?php
$current_page = 'dashboard';
$page_title = 'Dashboard - my progress';
require_once '../templates/header.php';
require_once 'dashboard.inc.php';
?>

<?php require_once '../includes/modals.inc.php'; ?>
<div class="container mt-3">
    <?php require_once '../includes/session_message.inc.php'; ?>
    <section class="pt-3 pb-3">
        <h1 class="text-capitalize text-dark p-2">Dashboard</h1>
        <div class="border-bottom border-3 border-dark mb-4"></div>
        <h3 class="text-primary text-center text-capitalize">
            my coursework
        </h3>
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="text-dark">Total coursework this academic year
                    <strong>Sep <?= date('Y', strtotime('-1 year')) ?> - Aug <?= date('Y') ?></strong></p>
                <div id="coursework-bar"></div>
            </div>
            <h3 class="text-primary text-center text-capitalize">my Activities</h3>
            <div class="col-md-12 text-center">
                <p class="text-dark">My activities this year <strong>Sep <?= date('Y', strtotime('-1 year')) ?> -
                        Aug <?= date('Y') ?></strong></p>
                <div id="yearlyActivityDiv"></div>
            </div>

        </div>
        <?php require_once 'accordion_tabs.inc.php' ?>
    </section>
</div>

<?php require_once '../templates/footer.php'; ?>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="../js/chart.js"></script>