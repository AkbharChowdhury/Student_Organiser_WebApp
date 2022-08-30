<?php
$current_page = 'modulesAndTeacher';
$page_title = 'Add module';
require_once '../templates/header.php';
require_once 'add_module.inc.php';


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
                            <h3 class="mb-0">Add Module</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" id="addModuleForm" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="module_code" class="form-label">Module Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="module_code" name="module_code" maxlength="100" placeholder="Enter module code" value="<?= Helper::html($_POST['module_code'] ?? ''); ?>" autofocus required>

                                    <div class="col-md-12 pt-2">
                                        <small class="form-text text-danger">
                                            <?= $errors['module_code'] ?? '' ?>
                                        </small>

                                        <small class="form-text text-danger" id="moduleCodeErrorMessage"></small>

                                    </div>
                                    <div class="invalid-feedback">module code is required</div>

                                </div>

                                <div class="mb-3">
                                    <label for="module_name" class="form-label">Module Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="module_name" name="module_name" maxlength="100" placeholder="Enter module name" value="<?= Helper::html($_POST['module_name'] ?? ''); ?>" required>
                                    <div class="col-md-12 pt-2">
                                        <small class="form-text text-danger">
                                            <?= $errors['module_name'] ?? '' ?>
                                        </small>
                                    </div>
                                    <div class="invalid-feedback">module name is required</div>
                                </div>
                                <input class="btn btn-success btn-lg" type="submit" name="addModule" value="Add Module">
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