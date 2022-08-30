<?php
$current_page = 'register';
$page_title = 'Create account';
require_once 'templates/header.php';
require_once 'includes/register.inc.php';
require_once 'includes/modals.inc.php';
?>

<div class="container">
    <div class="pt-2">
        <?= Helper::breadcrumb('Register') ?>
    </div>

    <div class="py-5 text-center">
        <?php require_once 'includes/session_message.inc.php'; ?>
        <img class="d-block mx-auto mb-4" src="<?= FILE_PATH['logo'] ?>" alt="Logo" width="72" height="57">
        <h2>Create an account for free today </h2>
        <p class="lead">Being a student can be very stressful. Register an account to start organising your personal commitments and university life</p>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="errorList">
            </div>
            <div class="row g-5">
                <div class="col-md-12">
                    <h4 class="mb-3 text-success">Personal Details</h4>
                    <hr>
                    <form class="needs-validation" novalidate action="" id="register-form" method="post" autocomplete="off">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstname" class="form-label">First name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your firstname" maxlength="50" value="<?= Helper::html($_POST['firstname'] ?? ''); ?>" required>
                                <div class="col-md-12">
                                    <small class="form-text text-danger" id="firstNameErrorMessage"></small>
                                </div>
                                <div class="col-md-12">
                                    <small class="form-text text-danger"><?= $errors['firstname'] ?? '' ?></small>
                                </div>
                                <div class="invalid-feedback">
                                    firstname is required!
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="lastname" class="form-label">Last name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your lastname" value="<?= Helper::html($_POST['lastname'] ?? ''); ?>" required>
                                <div class="col-md-12">
                                    <small class="form-text text-danger" id="lastNameErrorMessage"></small>
                                </div>
                                <div class="col-md-12">
                                    <small class="form-text text-danger"><?= $errors['lastname'] ?? '' ?></small>
                                </div>
                                <div class="invalid-feedback">
                                    lastname is required!
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" placeholder="enter your email" maxlength="150" name="email" value="<?= Helper::html($_POST['email'] ?? ''); ?>" required>
                                <small id="emailHelpBlock" class="form-text text-muted">This email will be used to send you reminders</small>
                                <div class="col-md-12">
                                    <small class="form-text text-danger" id="emailErrorMessage"></small>
                                </div>
                                <div class="col-md-12">
                                    <small class="form-text text-danger"><?= $errors['email'] ?? '' ?></small>
                                </div>
                                <div class="invalid-feedback">
                                    Email is required!
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" maxlength="11" value="<?= Helper::html($_POST['phone'] ?? ''); ?>" oninput="validateNumber(this)" required>
                                <div class="col-md-12">
                                    <small class="form-text text-danger" id="phoneErrorMessage"></small>
                                </div>
                                <div class="col-md-12">
                                    <small class="form-text text-danger"><?= $errors['phone'] ?? '' ?></small>
                                </div>
                                <div class="invalid-feedback">
                                    phone is required!
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" value="<?= Helper::html($_POST['password'] ?? ''); ?>" spellcheck="false" autocorrect="off" autocapitalize="off" required>
                                    <span class="input-group-text"><i class="far fa-eye-slash" id="togglePassword"></i></span>
                                </div>
                                <div class="col-md-12">
                                    <small class="form-text text-danger" id="passwordErrorMessage"></small>
                                </div>
                                <div class="invalid-feedback">Password is required</div>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Your password must be at least 8 characters long, contain 1 upper case letter, a number, and a special character.
                                </small>
                                <!-- JS Error message-->
                                <small id="passwordErrorMessage" class="form-text text-danger"></small>
                                <div id="password_criteria">
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
                                <div class="col-md-12">
                                    <small class="form-text text-danger"><?= $errors['password'] ?? '' ?></small>
                                </div>
                            </div>
                            <hr class="my-4">
                            <h4 class="text-success">Communication Preferences</h4>
                            <hr>
                            <p>Please choose your preferred communication channels for us to contact you about coursework and task deadlines</p>
                            <p><small class="text-muted">note that email are used to send you important reminders</small></p>
                            <div class="my-3">
                                <?php foreach ($db->getCommunicationPrefs() as $row) : ?>
                                    <div class="form-check">
                                        <input id="<?= Helper::html($row['pref_id']) ?>" name="communication[]" type="checkbox" class="form-check-input" value="<?= Helper::html($row['pref_id']) ?>" id="<?= Helper::html($row['pref_id']) ?>" <?php if ($row['type'] == 'email') echo ' checked'; ?>>
                                        <label class="form-check-label" for="<?= Helper::html($row['pref_id']) ?>"><?= Helper::html($row['type']) ?></label>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please choose one communication method
                                    </div>
                                <?php endforeach; ?>
                                <div class="col-12 py-3">
                                    <h4 class="text-success text-capitalize">Terms & conditions</h4>

                                    <hr>
                                    <?php foreach ($db->termsAndConditions() as $row) : ?>
                                        <p>Last updated: <?= Helper::formatTCDate($row['last_updated']) ?></p>
                                    <div class="card cards">
                                        <div class="card-body">
                                       

                                            <div class="scrollable">
                                                <p class="card-text">
                                               
                                                    <?= $row['content'] ?>
                                                <?php endforeach ?>
                                                
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                         

                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="policy" required>
                                        <label class="form-check-label" for="policy">
                                            I agree to the terms and conditions
                                        </label>

                                        <div class="invalid-feedback">
                                            You must agree to the terms and conditions!.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-3">
                                    <button class="btn btn-success btn-lg" type="submit" name="register">Start organising my life</button>
                                    <?= Helper::getRequiredFieldMessage(); ?>
                                </div>
                            </div>
                    </form>
                </div> <!-- row g-3 -->
            </div> <!-- col-md-12 -->
        </div> <!-- row g-5 -->
    </div> <!-- card-body -->
</div> <!-- card -->
</div>
</div>


<?php require_once 'templates/footer.php'; ?>
<script src="js/checkDuplicateEmail.js"></script>
<script src="js/register.js"></script>