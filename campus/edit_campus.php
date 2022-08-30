<?php
$current_page = 'campus';
$page_title = 'Edit Campus';
require_once '../templates/header.php';
require_once 'edit_campus.inc.php';
?>

<div class="container py-5">
    <?php require_once '../includes/session_message.inc.php' ?>

    <h1 class="text-capitalize">Edit University Campus</h1>
    <noscript>
        <?php if (isset($campus_map)) echo $campus_map; ?>
    </noscript>
    <div id="campus_map"></div>
    <form class="row g-3 needs-validation" action="" method="post" autocomplete="off" novalidate>
        <input type="hidden" name="campus_id" value="<?= $campus_details['campus_id'] ?>">
        <div class="col-md-8">
            <label for="campus" class="form-label">Campus</label>
            <input type="text" class="form-control" id="campus" name="campus" placeholder="campus name" value="<?= $_POST['campus'] ?? $campus_details['campus'] ?>" autofocus required>
            <div class="invalid-feedback">address is required</div>
            <div class="col-md-12 pt-2">
                <small class="form-text text-danger"><?= $errors['campus'] ?? '' ?></small>
            </div>
        </div>
        <div class="col-md-8">
            <label for="address" class="form-label">Address</label>
            <input type="search" class="form-control" id="address" name="address" placeholder="address" value="<?= $_POST['address'] ?? $campus_details['address'] ?>" required>
            <div id="addressHelpBlock" class="form-text">Enter you university address</div>
            <div class="invalid-feedback">address is required</div>
            <div class="col-md-12">
                <small class="form-text text-danger"><?= $errors['address'] ?? '' ?></small>
            </div>
        </div>
        <div class="col-md-8">
            <label for="city" class="form-label">city</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="city" value="<?= $_POST['city'] ?? $campus_details['city'] ?>" required>
            <div class="invalid-feedback">city is required</div>
            <div class="col-md-12">
                <small class="form-text text-danger"><?= $errors['city'] ?? '' ?></small>
            </div>
        </div>
        <div class="col-md-8">
            <label for="postcode" class="form-label">postcode</label>
            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="postcode" value="<?= $_POST['postcode'] ?? $campus_details['postcode'] ?>" required>
            <div class="invalid-feedback">postcode is required</div>
            <div class="col-md-12">
                <small class="form-text text-danger"><?= $errors['postcode'] ?? '' ?></small>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" id="search_campus" name="search_campus" class="btn btn-dark">Search Campus</button>
        </div>
        <div class="col-12">
            <button type="submit" id="update_campus" name="update_campus" class="btn btn-warning">Update Campus details</button>
        </div>
    </form>
</div>

<?php require_once '../templates/footer.php'; ?>
<script src="../js/search_campus.js"></script>