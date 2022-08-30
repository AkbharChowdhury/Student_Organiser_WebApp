<?php
$current_page = 'modulesAndTeacher';
$page_title = 'Manage my modules and teachers';
require_once '../templates/header.php';
require_once 'modules.inc.php';
?>
<section id="viewModules">
    <div class="container mt-3">
        <?php require_once '../includes/session_message.inc.php'; ?>
        <section class="pt-3 pb-3">
            <h1 class="text-capitalize p-2">My Modules</h1>
            <div class="border-bottom border-3 border-success"></div>
            <div class="col-sm-6 pt-3 pt-3">
                <span class="float-left"><a href="add_modules.php" class="btn btn-success">Add Modules</a></span>
            </div>
        </div>
        <div class="container mt-3">
            <noscript>
            <p class="text-muted mt-2"><?= '5' ?> Results found</p>
            </noscript> <!-- JS disabled -->

            <p class="text-muted" id="totalModulesCount">Total modules: <?=$db->getTotalModules()?></p>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <caption>List of Modules</caption>
                    <thead>
                        <tr>
                            <th scope="col">Module Code</th>
                            <th scope="col">Module Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($db->getTotalModules() > 0) : ?>
                        <?php foreach ($db->getModules() as $row) : ?>
                        <td><?= Helper::html($row['module_code']) ?></td>
                        <td><?= Helper::html($row['module_name']) ?></td>
                        <td>
                            <a href="edit_module.php?editModule=<?= Helper::html($row['module_id']) ?>" role="button" class="btn btn-warning m-3">Edit</a>
                            <button type="submit" class="btn btn-danger delete_module" id="deleteModule" data-module="<?= Helper::html($row['module_code']) ?> <?= Helper::html($row['module_name']) ?>" value="<?= Helper::html($row['module_id']) ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <td colspan="5"> No Modules found</td>
                    <?php endif; ?>
                </tbody>
            </table>
            </div><!-- table-responsive -->
        </section>
    </div>
</section>
<section id="manageTeachers">
    <div class="container mt-3">
        <?php require_once '../includes/session_message.inc.php'; ?>
        <section class="pt-3 pb-3">
            <h1 class="text-capitalize text-dark p-2">My Teachers</h1>
            <div class="border-bottom border-3 border-success"></div>
            <!-- <hr class="custom-line"> -->
            <div class="col-sm-6 pt-3">
                <span class="float-left"><a href="add_teacher.php" class="btn btn-success">Add Teacher</a></span>
            </div>
        </div>
        <div class="container mt-3">
            <noscript>
            <p class="text-muted mt-2"><?= '5' ?> Results found</p>
            </noscript> <!-- JS disabled -->
            <p class="text-muted mt-2" id="totalTeachersCount">Total Teachers: <?=$db->countTeachers()?></p>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <caption>List of Teachers</caption>
                    <thead>
                        <tr>
                            <th scope="col">Teacher</th>
                            <th scope="col">Email</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($db->getTotalTeachers()) : ?>
                        <?php foreach ($db->getTeachers() as $row) : ?>
                        <td><?= Helper::html($row['firstname'])?> <?= Helper::html($row['lastname'])?></td>
                        <td><?= Helper::html($row['email']) ?></td>
                        <td>
                            <a href="edit_teacher.php?editTeacher=<?= Helper::html($row['teacher_id']) ?>" role="button" class="btn btn-warning m-3">Edit</a>
                            <button type="submit" class="btn btn-danger delete_teacher" data-teacher="<?= Helper::html($row['firstname']) ?> <?= Helper::html($row['lastname']) ?>" value="<?= Helper::html($row['teacher_id']) ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <td colspan="5"> No Teachers found</td>
                    <?php endif; ?>
                </tbody>
            </table>
            </div><!-- table-responsive -->
        </section>
    </div>
</section>
<section id="manageTeachersAndModules">
    <div class="container mt-3">
        <?php require_once '../includes/session_message.inc.php'; ?>
        <section class="pt-3 pb-3">
            <h1 class="text-capitalize text-dark p-2">My Teachers And Modules</h1>
            <div class="border-bottom border-3 border-success"></div>
            <div class="col-sm-6 pt-3">
                <span class="float-left"><a href="teacher_module.php"  role="button" class="btn btn-success">Manage Teacher and module</a></span>
            </div>
        </div>
        <div class="container mt-3">
            <noscript>
            <p class="text-muted mt-2"><?= '5' ?> Results found</p>
            </noscript> <!-- JS disabled -->
            <!-- <p class="text-muted mt-2" id="totalTeachersCount">Total Teachers: <?//=$x=1//$db->countTeacherAndModules()?></p> -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <caption>List of Teachers</caption>
                    <thead>
                        <tr>
                            <th scope="col">Teacher</th>
                            <th scope="col">Email</th>
                            <th scope="col">Modules Taught</th>
                            <th scope="col">Total number of modules Taught</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($db->getTeacherAndModulesDetails()) : ?>
                        <?php foreach ($db->getTeacherAndModulesDetails() as $row) : ?>
                        <td><?= Helper::html($row['teacher_name'])?></td>
                        <td><?= Helper::html($row['email']) ?></td>
                        <td><?= Helper::html($row['modules_taught']) ?></td>
                        <td><?= Helper::html($row['total_modules']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <td colspan="5"> No Teachers and modules found</td>
                    <?php endif; ?>
                </tbody>
            </table>
            </div><!-- table-responsive -->
        </section>
    </div>
</section>
<?php require_once '../templates/footer.php'; ?>
<script src="../js/confirmDelete.js"></script>
<script src="../js/dataTable.js"></script>