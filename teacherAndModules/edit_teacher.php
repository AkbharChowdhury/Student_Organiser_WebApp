

<?php
$current_page = 'modulesAndTeacher';
$page_title = 'Edit teacher';
require_once '../templates/header.php';
require_once 'edit_teacher.inc.php';


?>
<div class="container py-3">
    <? require_once '../includes/session_message.inc.php'; ?>
    <div class="row">
        <div class="col-md-12">
            <hr class="mb-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-outline-secondary">
                        <div class="card-header">
                            <h3 class="mb-0">Add Teacher</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" id="addTeacherForm" class="needs-validation" novalidate>
                                <input type="hidden" name="teacher_id" value="<?=Helper::html($teacher_details['teacher_id'])?>">
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">FirstName <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" maxlength="100" placeholder="Enter firstname" value="<?= Helper::html($_POST['firstname'] ?? $teacher_details['firstname']); ?>" required autofocus>
                                    <div class="invalid-feedback">FirstName is required</div>
                                    <small class="form-text text-danger"><?= $errors['firstname'] ?? '' ?></small>

                                </div>

                                <div class="mb-3">
                                    <label for="firstname" class="form-label">LastName <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" maxlength="100" placeholder="Enter lastname" value="<?= Helper::html($_POST['lastname'] ?? $teacher_details['lastname']); ?>" required>
                                    <div class="invalid-feedback">lastName is required</div>
                                    <small class="form-text text-danger"><?= $errors['lastname'] ?? '' ?></small>

                                </div>

                                <div class="mb-3">
                                    <label for="firstname" class="form-label">email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="100" placeholder="Enter email" value="<?= Helper::html($_POST['email'] ?? $teacher_details['email']); ?>">
                                    <div class="invalid-feedback">email is required</div>
                                    <small class="form-text text-danger"><?= $errors['email'] ?? '' ?></small>

                                </div>
                                <div class="mb-3">
                <label for="colour_id" class="form-label">Colour preference</label>
                <select id="colour_id" name="colour_id" class="form-select">
                    <option selected disabled value="">Select colour preference</option>
                    <?php foreach ($db->getColours() as $row) : ?>
                        <option <?php if ($row['colour_id'] === $teacher_details['colour_id']) echo ' selected'; ?> value="<?= Helper::html($row['colour_id']) ?>" style="color:<?= $row['hex_colour'] ?>"><?= Helper::html($row['colour_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <small id="colourHelpBlock" class="form-text text-muted">The colour will be used to customise the the appearance of the tables to make it easier to identify your teacher</small>

            </div>
                                <input class="btn btn-warning btn-lg" type="submit" name="updateTeacher" value="Update Teacher">
                                <?= Helper::getRequiredFieldMessage(); ?>

                            </form>
                        </div>
                        <!--/card-block-->
                    </div><!-- /form card login -->
                </div>
            </div>
        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->


<?php require_once '../templates/footer.php'; ?>
<script src="../js/checkDuplicateModuleCode.js"></script>
<?php require_once '../templates/footer.php'; ?>
<script src="../js/checkDuplicateModuleCode.js"></script>

