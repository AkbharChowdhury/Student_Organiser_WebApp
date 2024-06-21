<?php
$current_page = 'campus';
$page_title = 'View my Campuses';
require_once '../templates/header.php';


$breadcrumb = new Breadcrumb();
$breadcrumb->createBreadcrumb(url: 'campus.php',text: 'campus');
$db = Database::getInstance();
?>
<div class="container mt-3">
    <div id="errorMessageJS"></div>
    <?php require_once '../includes/session_message.inc.php';?>
    <section class="pt-3 pb-3">
        <h1 class="text-capitalize text-success p-2">my campuses</h1>
        <div class="border-bottom border-3 border-success"></div>
        <div class="col-sm-6 pt-3">
            <span class="float-left"><a href="add_campus.php" class="btn btn-success">Add Campuses</a></span>
        </div>
    </div>
    
    <div class="container mt-3">
        <noscript>
        <p class="text-muted mt-2"><?='5'?> Results found</p>
        </noscript> <!-- JS disabled -->
        <p class="text-muted mt-2" id="totalCampusCount"></p>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <caption>List of Campuses</caption>
                <thead>
                    <tr>
                        <th scope="col">Campuses</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($db->getTotalCampuses()) : ?>
                    <?php foreach ($db->getCampuses() as $row) : ?>
                    <td><?= Helper::html($row['campus']) ?></td>
                    <td>
                        <a href="edit_campus.php?editCampus=<?= Helper::html($row['campus_id']) ?>" role="button" class="btn btn-warning m-3">Edit</a>
                        <button class="btn btn-danger delete" id="deleteCampus" data-campus="<?=$row['campus']?>" value="<?= Helper::html($row['campus_id']) ?>">Delete</button>
                        <noscript><a href="<?=CURRENT_FILE ?>?delete=<?= Helper::html($row['campus_id']) ?>" role="button" class="btn btn-danger">Delete</a></noscript>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                <td colspan="5"> No campuses found</td>
                <?php endif; ?>
            </tbody>
        </table>
        </div><!-- table-responsive -->
        
        
    </section>
    
</div>
<?php require_once '../templates/footer.php'; ?>
<script src="../js/confirmDelete.js"></script>
<script src="../js/dataTable.js"></script>