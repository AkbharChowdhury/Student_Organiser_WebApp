<?php
$current_page = 'modulesAndTeacher';
$page_title = 'manage teacher and modules';
require_once '../templates/header.php';
require_once 'manage_teacher_module.inc.php';
?>

<div class="container py-5">
    <?php require_once '../includes/session_message.inc.php'; ?>
    <section>
        <h1 class="text-success">Manage Teachers and Modules</h1>
        <hr>
        <p class="text-muted text-break fs-5">You can assign a teacher to a module by selecting the teacher from the checkbox list. Please note that once you have assigned a teacher you <strong>must have one teacher assigned to a module so the information can be displayed on your academic calendar.</strong></p>
        <p class="text-muted" id="totalModulesCount">Total modules: <?= $db->getTotalModules() ?></p>

        <div class="container">
            <div class="row g-3">
                <?php foreach ($db->getModules() as $module) : ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <form action="" method="post" class="needs-validation" novalidate>
                                    <input type="hidden" name="module_id" value="<?= Helper::html($module['module_id']) ?>">
                                    <h5 class="card-title"><strong><?= Helper::html($module['module_code']) . ' ' . Helper::html($module['module_name']) ?></strong></h5>
                                    <p class="card-text">
                                        <?php foreach ($db->getTeachers() as $teacher) : ?>

                                            <?php $random_id = rand(0, 999999); ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="module_teacher_list[]" value="<?= $teacher['teacher_id'] ?>" id="<?= $random_id ?>" 
                                        <?= in_array([$module['module_id'], $teacher['teacher_id']], $selectedModuleTeachers) ? 'checked' : '' ?>>
                                        <label class="form-check-label text-capitalize" for="<?= $random_id ?>">
                                            <?= Helper::html($teacher['firstname']) . ' ' . Helper::html($teacher['lastname']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                                </p>
                                <button type="submit" class="btn btn-success">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</div>
<?php require_once '../templates/footer.php'; ?>
<script src="../js/checkDuplicateModuleCode.js"></script>
<script src="../js/confirmDelete.js"></script>
<script src="../js/dataTable.js"></script>