<?php
$current_page = 'profile';
$page_title = 'profile';
require_once '../templates/header.php';
require_once 'updatePassword.inc.php';
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
                            <h3 class="mb-0">Update Password</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" id="updatePassword" class="needs-validation" novalidate>
                                <div class="mb-3">

                                <label for="password" class="form-label">Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" value="<?= Helper::html($_POST['password'] ?? ''); ?>" spellcheck="false" autocorrect="off" autocapitalize="off" required autofocus>
                                    <span class="input-group-text"><i class="far fa-eye-slash" id="togglePassword"></i></span>
                                    <div class="invalid-feedback">Password is required!</div>

                                </div>
                                    
                                    <div class="col-md-12 pt-2">
                                        <small class="form-text text-danger">
                                            <?= $errors['password'] ?? '' ?>
                                        </small>

                                        <small class="form-text text-danger" id="passwordError"></small>

                                    </div>
                                    <div id="password_criteria-update">
                                    <ul class="fa-ul">
                                        <li><span class="fa-li"><i id="number"></i></span>contains 1 number</li>
                                        <li><span class="fa-li"><i id="uppercase"></i></span>contains 1 upper case char</li>
                                        <li><span class="fa-li"><i id="lowercase"></i></span>contains 1 lower case char</li>
                                        <li><span class="fa-li"><i id="specialChar"></i></span>contains 1 special char</li>
                                        <li><span class="fa-li"><i id="minLength"></i></span>is at least 8 chars long</li>
                                    </ul>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                </div>

                                <input class="btn btn-warning btn-lg" type="submit" name="addModule" value="Update password">
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
<?php require_once '../templates/footer.php'; ?>

<script src="../js/register.js"></script>