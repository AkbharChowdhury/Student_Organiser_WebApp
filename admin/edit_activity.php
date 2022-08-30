<?php
$current_page = 'admin_dashboard';
$page_title = 'Edit activity';
require_once '../templates/header.php';
require_once 'edit_activity.inc.php';
?>

<div class="container py-5">
    <?= Helper::breadcrumb('Edit activity', 'admin_dashboard.php') ?>
    <h1 class="text-capitalize">Edit Activity</h1>
    <form class="row g-3 needs-validation" action="" method="post" autocomplete="off" novalidate>
        <div class="col-md-8">
            <label for="campus" class="form-label">Activity type</label>
            <input type="text" class="form-control" id="type" name="type" placeholder="type" value="<?= $_POST['type'] ?? $activityData['type'] ?>" autofocus required>
            <div class="invalid-feedback">Activity is required</div>
            <div class="col-md-12 pt-2">
                <small class="form-text text-danger"><?= $errors['activity_type'] ?? '' ?></small>
            </div>
        </div>

        <div class="col-md-8">
            <label for="colour_id" class="form-label">Colour preference</label>
            <select id="colour_id" name="colour_id" class="form-select">
                <option selected disabled value="">Select colour preference</option>
                <?php foreach ($db->getColours() as $row) : ?>
                    <option <?php if ($row['colour_id'] === $activityData['colour_id']) echo ' selected'; ?> value="<?= Helper::html($row['colour_id']) ?>" style="color:<?= $row['hex_colour'] ?>"><?= Helper::html($row['colour_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <small id="colourHelpBlock" class="form-text text-muted">The colour will be used to customise the the appearance of the tables to make it easier to identify your teacher</small>
        </div>
        <div class="col-12">
            <button type="submit" id="editActivity" name="editActivity" class="btn btn-warning">Update Activity</button>
        </div>
    </form>
</div>

<?php require_once '../templates/footer.php'; ?>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="../js/checklist.js"></script>