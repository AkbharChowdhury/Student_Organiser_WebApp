<?php
$current_page = 'profile';
$page_title = 'Delete profile';
require_once '../templates/header.php';
require_once 'delete_account.inc.php';
$svg = [
    'width' => 60,
    'height' => 60
];
?>
<style>
    @charset "utf-8";

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }   
</style>

<?php require_once '../includes/session_message.inc.php'; ?>

<div class="container mt-4 mb-4 p-3">
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-emoji-frown-fill" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm-2.715 5.933a.5.5 0 0 1-.183-.683A4.498 4.498 0 0 1 8 9.5a4.5 4.5 0 0 1 3.898 2.25.5.5 0 0 1-.866.5A3.498 3.498 0 0 0 8 10.5a3.498 3.498 0 0 0-3.032 1.75.5.5 0 0 1-.683.183zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z" />
    </svg>
    <h1 class="text-danger">We are sorry you are leaving</h1>
    <h3>Please choose a reason why you want to leave</h3>
    <hr>
    <form action="" method="post">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-9">
                    <label class="custom-radio-button__container" for="noLongerNeeded">
                        <input type="radio" name="reason" value="I no longer use this website" id="noLongerNeeded" onchange="notRequired('#notRequiredTxt')">
                        <span class="custom-radio-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                            I no longer use this website
                        </span>
                    </label>
                    <div id="notRequiredTxt"></div>
                </div>
                <div class="col-9 mt-3">
                    <label class="custom-radio-button__container" for="spamLabel">
                        <input type="radio" name="reason" value="I receive too many spam email/ sms" id="spamLabel" onchange="spam('#spamTxt')">
                        <span class="custom-radio-button">
                        
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-envelope-slash" viewBox="0 0 16 16">
                                <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z" />
                                <path d="M14.975 10.025a3.5 3.5 0 1 0-4.95 4.95 3.5 3.5 0 0 0 4.95-4.95Zm-4.243.707a2.501 2.501 0 0 1 3.147-.318l-3.465 3.465a2.501 2.501 0 0 1 .318-3.147Zm.39 3.854 3.464-3.465a2.501 2.501 0 0 1-3.465 3.465Z" />
                            </svg>

                            I receive too many spam email/ sms
                        </span>
                    </label>
                    <div id="spamTxt"></div>
                </div>
                <div class="col-9 mt-3">
                    <label class="custom-radio-button__container" for="o">
                        <input type="radio" name="reason" id="o" value="Other" onchange="other('#otherTxt')">
                        <span class="custom-radio-button designer">

                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                            </svg>
                            Something else...
                        </span>
                    </label>
                    <div id="otherTxt"></div>
                </div>
            </div>
        </div>


        <div class="mt-2">
            <h2 class="text-danger">Warning</h2>
            <p class="text-muted">We strongly recommend against deleting your account. Once you request your account deletion we'll retain your account for up to <b>1 month</b> before deleting it. During this time, if you change your mind, you may log back in to reactivate your account and your account will <strong>NOT</strong> be deleted</p>
            <p class="lead">By deleting your account you will lose access to the following</p>
            <div class="list-group">
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h4>Coursework data</h4>
                    </div>
                    <p>this includes all you saved coursework data and dashboard statistics</p>
                </div>

                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h4>Calendar functionality</h4>
                    </div>
                    <p>You will lose access to your academic and personal calendar</p>
                </div>

            </div>

        </div>
        <button type="submit" class="btn btn-outline-danger mt-3">Request account deletion</button>
    </form>



</div>




<?php require_once '../templates/footer.php'; ?>
<script src="../js/deleteAccount.js" defer></script>