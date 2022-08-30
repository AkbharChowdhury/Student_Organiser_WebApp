<?php
$current_page = 'coursework';
$page_title = 'View coursework';
require_once '../templates/header.php';
Breadcrumb::getInstanceRootDirectory('View coursework', 'coursework.php', null)->createBreadCrumb();
$db = Database::getInstance();
?>
<div class="container mt-3">
    <?php require_once '../includes/session_message.inc.php'; ?>
    <div id="errorMessageJS"></div>
    <section class="pt-3 pb-3">
        <h1 class="text-capitalize text-success p-2">My Coursework</h1>
        <div class="border-bottom border-3 border-success"></div>
        <div class="col-sm-6 pt-3">
            <span class="float-left text-capitalize"><a href="add_coursework.php" class="btn btn-success">Add Coursework</a></span>
        </div>
        <div class="container" id="search">
            <form class="row g-3">
                <div class="col-md-6 pt-3">
                    <label for="module_id_search" class="form-label">Module</label>
                    <select id="module_id_search" class="form-select form_data" name="module_id_search" required>
                        <option selected value="">View All modules</option>
                        <?php foreach ($db->getModuleCoursework() as $row) : ?>
                            <option value="<?= $row['module_id']; ?>"><?= $row['module_code']; ?> <?= $row['module_name']; ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="col-md-6 pt-3">
                    <label for="coursework_title" class="form-label">Coursework title</label>
                    <input type="text" class="form-control" id="coursework_title" name="coursework_title" placeholder="search by coursework title" autofocus>
                </div>

            </form>
            <!-- coursework search result  -->
            <div id="courseworkList"></div>

        </div>
    </section>
</div>
<?php require_once '../includes/session_message.inc.php'; ?>
<?php require_once '../templates/footer.php'; ?>
<script src="../js/confirmDelete.js"></script>
<script src="../js/search_coursework.js"></script>