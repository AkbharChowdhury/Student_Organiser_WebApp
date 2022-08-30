<?php
$current_page = 'admin_dashboard';
$page_title = 'Edit Semester';
require_once '../templates/header.php';
require_once 'edit_semester.inc.php';

//echo $semesterData['end_date'];
?>




<div class="container py-5">
    <?= Helper::breadcrumb('Edit Semester', 'admin_dashboard.php') ?>

    <h1 class="text-capitalize">Edit Semester</h1>

    <form class="row g-3 needs-validation" action="" method="post" autocomplete="off" novalidate>
        <div class="col-md-8">
            <label for="semester_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="type" name="semester_name" placeholder="Enter semester description" value="<?= $_POST['semester_name'] ?? $semesterData['semester_name'] ?>" autofocus required>
            <div class="invalid-feedback">Semester name is required</div>
            <div class="col-md-12 pt-2">
                <small class="form-text text-danger"><?= $errors['semester_name'] ?? '' ?></small>
            </div>

        </div>

        <div class="col-md-8">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="datetime" class="form-control" id="start" name="start_date" placeholder="Start date" value="<?=$_POST['start_date']?? $semesterData['start_date']?>">
            <div class="invalid-feedback">Semester start is required</div>
            <div class="col-md-12 pt-2">
                <small class="form-text text-danger"><?= $errors['semester_start_date'] ?? '' ?></small>
            </div>

        </div>

        <div class="col-md-8">
            <label for="end_date" class="form-label">End Date</label>
            <input type="datetime" class="form-control" id="end" name="end_date" placeholder="End date" value="<?=$_POST['end_date']?? $semesterData['end_date']?>">
            <div class="invalid-feedback">Semester end is required</div>
            <div class="col-md-12 pt-2">
                <small class="form-text text-danger"><?= $errors['semester_end_date'] ?? '' ?></small>
            </div>
        </div>



        <div class="col-12">
            <button type="submit" id="editActivity" name="editActivity" class="btn btn-warning">Update Semester</button>
        </div>
    </form>
</div>


<?php require_once '../templates/footer.php'; ?>
<script src="https://www.gstatic.com/charts/loader.js"></script>

<script src="../js/datepicker.js"></script>
