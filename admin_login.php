<?php
$current_page = 'login';
$page_title = 'Login Student Planner';
require_once 'templates/header.php';
require_once 'includes/admin_login.inc.php';

?>
<div class="container py-4">
    <?= Helper::breadcrumb('Admin Login') ?>

    <h1>Administrator Login</h1>

    <?php require_once 'includes/session_message.inc.php'; ?>
    <form class="row g-3 needs-validation" action="" method="post" novalidate>
        <div class="col-md-8">
            <label for="username" class="form-label">username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="username" value="<?= Helper::html($_POST['email'] ?? ''); ?>" autofocus required>
            <small class="form-text text-danger"><?= $errors['username'] ?? '' ?></small>
            <div class="invalid-feedback">username is required</div>
        </div>
        <div class="col-md-8">
            <label for="password" class="form-label">password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
            <small class="form-text text-danger"><?= $errors['password'] ?? '' ?></small>
            <div class="invalid-feedback">password is required</div>
        </div>
        <div class="col-12">
            <input type="submit" class="btn btn-success" name="admin_login" value="Login">
            <?php if ($db->getErrorMessage()) : ?>
                <p class="text-danger mt-3"><?= $db->getErrorMessage(); ?></p>
            <?php endif; ?>
        </div>
    </form>
</div>
<?php require_once 'templates/footer.php'; ?>