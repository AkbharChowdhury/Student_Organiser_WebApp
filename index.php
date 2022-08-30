<?php
$current_page = 'index';
$page_title = 'Homepage - Student organiser';
require_once 'templates/header.php';
require_once 'includes/contact-email.inc.php';
?>
<div id="home">
    <div class="landing-text text-center text-white">
        <h1 class="text-uppercase">Welcome to Student Planner</h1>
        <div class="border-bottom border-3 border-light custom-border"></div>
        <h3>Start organising your academic and personal life efficiently today</h3>
        <a href="#features-icons" class="btn btn-outline-light btn-lg custom-btn">Get started</a>
    </div>
</div>
<section class="features-icons bg-light text-center" id="features-icons">
    <div class="container">
        <div class="col-12">
            <h3 class="heading">Features</h3>
            <div class="heading-underline"></div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                    <div class="features-icons-icon d-flex"><i class="bi bi-calendar m-auto text-success"></i></div>
                    <h3>Calendar</h3>
                    <p class="lead mb-0">View academic and personal calendar</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                    <div class="features-icons-icon d-flex"><i class="bi bi-pencil m-auto text-success"></i></div>
                    <h3>Coursework</h3>
                    <p class="lead mb-0">Add coursework and to-do-list</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                    <div class="features-icons-icon d-flex">
                        <i class="bi bi-alarm m-auto text-success"></i>
                    </div>
                    <h3>Interactive dashboard</h3>
                    <p class="lead mb-0">track your progress and get reminders of upcoming deadlines!</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Image Showcases-->
<section class="showcase">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('https://images.unsplash.com/photo-1506784365847-bbad939e9335?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8Y2FsZW5kYXJ8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60')"></div>
            <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                <h2>Calendar</h2>
                <p class="lead mb-0">Manage your academic and personal commitments using an interactive calendars. You can customise the your academic and personal events.</p>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-6 text-white showcase-img" style="background-image: url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80')"></div>
            <div class="col-lg-6 my-auto showcase-text">
                <h2>Manage coursework</h2>
                <p class="lead mb-0">Add coursework with a to-do-list and customise notes.</p>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('https://images.unsplash.com/photo-1624969862293-b749659ccc4e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Nnx8cmVtaW5kZXJ8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60')"></div>
            <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                <h2>Live dashboard and reminders</h2>
                <p class="lead mb-0">Live interactive dashboard of upcoming events. reminders are send based on your communication preferences.</p>
            </div>
        </div>
    </div>
</section>
<section id="contact" class="bg-light">
    <div class="container">
        <h1 class="text-capitalize text-success p-2">Contact us</h1>
        <div class="border-bottom border-3 border-success"></div>
        <div class="mt-3">
            <?php require_once 'includes/session_message.inc.php'; ?>
        </div>
        <p class="lead mt-2">if you have any questions please email the <a href="mailto:<?= Mail::getInstance()->getAdminEmail() ?>">Support team</a> or fill in the contact form provided below</p>
        <form class="needs-validation" novalidate action="" method="post">
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
                    <label for="subject" class="form-label">Subject</label>
                    <input class="form-control" list="datalistSubject" name="subject" id="subject" placeholder="Enter your subject..." value="<?= Helper::html($_POST['subject'] ?? ''); ?>" required maxlength="100">
                    <datalist id="datalistSubject">
                    <option value="General Enquiry">
                        <option value="Account suspension">
                            <option value="GDPR Enquiry">
                                </datalist>
                            </div>
                            <div class="col-md-12">
                                <small class="form-text text-danger"><?= $errors['subject'] ?? '' ?></small>
                            </div>
                            <div class="invalid-feedback">
                                Subject is required!
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label text-capitalize">your message <span class="text-danger">*</span></label>
                            <textarea class="form-control editor" id="message" name="message" rows="3" placeholder="Please explain your issue in detail" required >
                        
                            </textarea>
                            <div class="col-md-12">
                                <small class="form-text text-danger"><?= $errors['message'] ?? '' ?></small>
                            </div>
                            <div class="invalid-feedback">
                                Message is required!
                            </div>
                        </div>
                        <div class="col-12 py-3">
                            <button class="btn btn-success btn-lg" type="submit" name="send_email">Send email</button>
                            <?= Helper::getRequiredFieldMessage(); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php require_once 'templates/footer.php'; ?>
    <script src="js/checklist.js"></script>
   