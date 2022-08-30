<?php
$current_page = 'profile';
$page_title = 'profile';
require_once '../templates/header.php';
require_once 'updateProfile.inc.php';
?>
<div class="container rounded bg-white">
    <?php require_once '../includes/session_message.inc.php'; ?>
    <div class="row">
        <div class="col-12 border-right">
            <div class="d-flex flex-column align-items-start text-center p-3 py-2">
                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <span class="font-weight-bold">
                    <h2><?= $student_details['firstname'] ?></h2>
                    </span><span class="text-black-50"><?= $student_details['email'] ?></span><span></span>
                </div>
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                        <hr>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="student_id" value="<?= $student_details['student_id'] ?>">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="label">FirstName <span class="text-danger">*</span></label>
                                <input type="text" name="firstname" class="form-control" placeholder="firstname" value="<?= Helper::html($_POST['firstname'] ?? $student_details['firstname']) ?>">
                                <div class="col-md-12">
                                    <small class="form-text text-danger"><?= $errors['firstname'] ?? '' ?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="label">LastName <span class="text-danger">*</span></label>
                                <input type="text" name="lastname" class="form-control" placeholder="lastname" value="<?= Helper::html($_POST['lastname'] ?? $student_details['lastname']) ?>">
                                <div class="col-md-12">
                                    <small class="form-text text-danger"><?= $errors['lastname'] ?? '' ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 pt-2">
                            <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?= Helper::html($_POST['email'] ?? $student_details['email']) ?>">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            
                            <div class="col-md-12">
                                <small class="form-text text-danger"><?= $errors['email'] ?? '' ?></small>
                                <small class="form-text text-danger" id="emailErrorMessage"></small>

                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" maxlength="11" id="phone" name="phone" aria-describedby="emailHelp" oninput="validateNumber(this)" value="<?= Helper::html($_POST['phone'] ?? $student_details['phone']) ?>">
                            <div id="phoneHelp" class="form-text">We'll use your phone to send you reminders</div>
                            <div class="col-md-12">
                                <small class="form-text text-danger"><?= $errors['phone'] ?? '' ?></small>
                            </div>
                        </div>
                        <h4 class="text-dark">Communication Preferences</h4>
                        <hr>
                        <p>Please choose your preferred communication channels for us to contact you about coursework and task deadlines</p>
                        <p><small class="text-muted">note that email are used to send you important reminders</small></p>
                        <div class="my-3">
                            <?php foreach ($db->getCommunicationPrefs() as $preference) : ?>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input id="<?= Helper::html($preference['pref_id']) ?>" name="communication[]" type="checkbox" class="form-check-input" value="<?= Helper::html($preference['pref_id']) ?>" id="<?= Helper::html($com_pref['pref_id']) ?>" <?php if (in_array($preference['pref_id'], $selectedPreferences)) echo ' checked'; ?>>
                                    <label class="form-check-label" for="<?= Helper::html($preference['pref_id']) ?>"><?= Helper::html($preference['type']) ?></label>
                                </div>
                                <div class="invalid-feedback">
                                    Please choose one communication method
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <button type="submit" name="btnUpdateProfile" class="btn btn-warning mt-3">Update Profile</button>
							<?= Helper::getRequiredFieldMessage(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php require_once '../templates/footer.php'; ?>
<script src="../js/checkDuplicateEmail.js"></script>