<?php
$current_page = 'login';
$page_title = 'Login Student Planner';
require_once 'templates/header.php';
require_once 'includes/login.inc.php';
?>
<div class="container py-4">
  <?=Helper::breadcrumb('Student Login')?>

  <h1>Student Login</h1>
  <div class="d-flex justify-content-between align-items-center mb-2">
      <a href="admin_login.php" class="text-capitalize">Login as administrator</a>
    </div>
  <?php require_once 'includes/session_message.inc.php'; ?>
  <form class="row g-3 needs-validation" action="" method="post" novalidate>
    <div class="col-md-8">
      <label for="email" class="form-label">email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?= Helper::html($_POST['email'] ?? ''); ?>" autofocus required>
      <small class="form-text text-danger"><?= $errors['email'] ?? '' ?></small>
      <div class="invalid-feedback">email is required</div>
    </div>
    <div class="col-md-8">
      <label for="password" class="form-label">password</label>
      <input type="password" class="form-control" maxlength="20" id="password" name="password" placeholder="password" required>
      <small class="form-text text-danger"><?= $errors['password'] ?? '' ?></small>
      <div class="invalid-feedback">password is required</div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-2">
      <a href="#">Forgot password?</a>
    </div>
    <div class="col-12">
      <input type="submit" class="btn btn-success" name="login" value="Login">
      <?php if ($db->getErrorMessage()) : ?>
      <p class="text-danger mt-3"><?= $db->getErrorMessage(); ?></p>
      <?php endif; ?>
      <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="register.php" class="link-success">Register</a></p>
    </div>
  </form>
</div>
<?php require_once 'templates/footer.php'; ?>