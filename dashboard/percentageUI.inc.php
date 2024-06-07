<?= $cwProgressData['icon'] ?>
<?php if ($db->getUpcomingCourseworkByMonth()) : ?>
    <div class="col-md-10">
        <div class="progress mt-3">
            <div class="progress-bar <?= $progress_bar_class ?>" role="progressbar"
                 style="width: <?= $percentageCompleted ?>%;"
                 aria-valuenow="<?= $percentageCompleted ?>" aria-valuemin="0"
                 aria-valuemax="100">
                <?= $percentageCompleted ?>%
            </div>
        </div>
        <?= $cwProgressData['text']; ?>
        <?php if (intval($percentageCompleted) !== 100) : ?>
            <div class="progress" aria-valuemax="100">
                <div class="progress-bar bg-danger" role="progressbar"
                     style="width: <?= $cwProgress['percentage_not_completed'] ?>%"
                     aria-valuenow="<?= $cwProgress['percentage_not_completed'] ?>"
                     aria-valuemin="0">
                    <?= $cwProgress['percentage_not_completed'] ?>% not completed (
                    <?= $cwProgress['total_not_completed'] ?>)
                </div>
                <div class="progress-bar bg-warning" role="progressbar"
                     style="width: <?= $cwProgress['percentage_in_progress'] ?>%"
                     aria-valuenow="<?= $cwProgress['percentage_in_progress'] ?>"
                     aria-valuemin="0">
                    <?= $cwProgress['percentage_in_progress'] ?>% in progress (
                    <?= $cwProgress['total_in_progress'] ?>)
                </div>
                <div class="progress-bar bg-success" role="progressbar"
                     style="width: <?= $cwProgress['percentage_completed'] ?>%"
                     aria-valuenow="<?= $cwProgress['percentage_completed'] ?>"
                     aria-valuemin="0">
                    <?= $cwProgress['percentage_completed'] ?>% completed (
                    <?= $cwProgress['total_completed'] ?>)
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3" id="productsList">
        <?php require_once 'coursework_card_reminder.inc.php' ?>
    </div>
<?php endif; ?>
</div>