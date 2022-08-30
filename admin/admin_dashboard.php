<?php
$current_page = 'admin_dashboard';
$page_title = 'Admin Dashboard';
require_once '../templates/header.php';
require_once 'admin_dashboard.inc.php';
?>
<?php require_once '../includes/modals.inc.php'; ?>
<div class="container mt-3">
    <?php require_once '../includes/session_message.inc.php'; ?>
    <section class="pt-3 pb-3" id="title">
        <h1 class="text-capitalize text-dark p-2">Admin Panel</h1>
        <div class="border-bottom border-3 border-dark mb-4"></div>

        <section class="pt-3 pb-3" id="students">
            <h1 class="text-capitalize p-2">Students</h1>
            <div class="border-bottom border-3 border-success"></div>

</div>
<div class="container mt-3">
    <noscript>
        <p class="text-muted mt-2"><?= '5' ?> Results found</p>
    </noscript> <!-- JS disabled -->

    <p class="text-muted" id="totalModulesCount">Total students: <?= $db->getTotalStudents() ?></p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <caption>List of Students</caption>
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Account Suspended</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($db->viewAllStudents()) : ?>
                    <?php foreach ($db->viewAllStudents() as $row) : ?>
                        <td><?= Helper::html($row['firstname']) . ' ' . Helper::html($row['lastname'])  ?></td>
                        <td><?= Helper::html($row['email']) ?></td>
                        <td><?= Helper::html($row['phone']) ?></td>
                        <td <?php if (!empty($row['student_account_deleted'])) echo 'class="table-danger"' ?>><?= !empty($row['student_account_deleted']) ? 'Yes' : 'No' ?></td>
                        <td>
                            <a href="review_suspension.php?student_id=<?= Helper::html($row['student_id']) ?>" role="button" class="btn btn-warning m-3">Review suspension</a>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <td colspan="5"> No Students</td>
                <?php endif; ?>
            </tbody>
        </table>
    </div><!-- table-responsive -->
    </section>


    <section class="pt-3 pb-3" id="semester">
        <h1 class="text-capitalize p-2">Semester</h1>
        <div class="border-bottom border-3 border-success"></div>
        <div class="col-sm-6 pt-3">
            <span class="float-left text-capitalize">
                <button type="button" id="btnShowSemesterModal" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSemesterModal">
                    Add Semester
                </button>
            </span>



        </div>

</div>
<div class="container mt-3">
    <noscript>
        <p class="text-muted mt-2"><?= '5' ?> Results found</p>
    </noscript> <!-- JS disabled -->

    <p class="text-muted" id="totalModulesCount">Total Semester: <?= $db->getTotalSemester() ?></p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <caption>List of Semester</caption>
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>

                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($db->getTotalSemester() > 0) : ?>
                    <?php foreach ($db->getSemester() as $row) : ?>
                        <td><?= Helper::html($row['name']) ?></td>
                        <td><?= Helper::formatDate($row['start_date']) ?> - <?= Helper::formatDate($row['end_date']) ?></td>


                        <td>

                            <a href="edit_semester.php?editSemester=<?= Helper::html($row['semester_id']) ?>" role="button" class="btn btn-warning m-3">Edit Semester</a>

                            <button type="button" class="btn btn-danger" name="btnDeleteSemester" id="btnDeleteSemester" onclick="deleteSemester('<?= $row['name'] ?>', <?= $row['semester_id'] ?>)">Delete Semester</button>


                        </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <td colspan="5"> No Semester data found</td>
                <?php endif; ?>
            </tbody>
        </table>
    </div><!-- table-responsive -->
    </section>




    <section class="pt-3 pb-3" id="semester">
        <h1 class="text-capitalize p-2">Activity</h1>
        <div class="border-bottom border-3 border-success"></div>
        <div class="col-sm-6 pt-3">
            <span class="float-left text-capitalize">
                <button type="button" id="btnShowPModal" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                    Add Activity
                </button>
            </span>
        </div>

</div>
<div class="container mt-3">
    <noscript>
        <p class="text-muted mt-2"><?= '5' ?> Results found</p>
    </noscript> <!-- JS disabled -->

    <p class="text-muted" id="totalModulesCount">Total activity: <?= $db->getTotalActivities() ?></p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <caption>List of Activities</caption>
            <thead>
                <tr>
                    <th scope="col">Name</th>

                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($db->getTotalActivities() > 0) : ?>
                    <?php foreach ($db->getActivity() as $row) : ?>
                        <td class="table-<?= $row['colour_class'] ?> text-capitalize"><?= Helper::html($row['type']) ?></td>


                        <td>
                            <a href="edit_activity.php?editActivity=<?= Helper::html($row['activity_id']) ?>" role="button" class="btn btn-warning m-3">Edit Activity</a>
                            <button type="button" class="btn btn-danger" onclick="deleteActivity('<?= $row['type'] ?>', <?= $row['activity_id'] ?>)">Delete Activity</button>

                        </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <td colspan="5"> No activity data found</td>
                <?php endif; ?>
            </tbody>
        </table>
    </div><!-- table-responsive -->
    </section>

    <h1>Terms and conditions</h1>
    <?php foreach ($db->termsAndConditions() as $row) : ?>
        <p>Last updated: <?= Helper::formatTCDate($row['last_updated']) ?></p>

        <a href="editTermsAndConditions.php?termsAndConditions=<?= Helper::html($row['termsAndConditions_id']) ?>" role="button" class="btn btn-warning m-3">Edit Terms and conditions</a>

        <div class="card">
            <div class="card-body">
                <?= $row['content'] ?>
            </div>
        </div>
    <?php endforeach ?>
</div>
</div>
</section>
</div>



</div>

<?php require_once '../templates/footer.php'; ?>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="../js/dataTable.js"></script>
<script src="../js/confirmDelete.js"></script>
<script src="../js/datepicker.js"></script>