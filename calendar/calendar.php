<?php
if (isset($_GET['calendar']) && $_GET['calendar'] === 'personal') $calendarType = ['calendar' => 'personal'];
$current_page = 'calendar';
$page_title = 'View academic and personal calendar';
require_once '../templates/header.php';
$breadcrumb = new Breadcrumb();
$breadcrumb->createBreadcrumb(url: 'calendar.php',text: 'calendar');
$db = Database::getInstance();
?>


<div class="container my-5" id="calendarUI">
    <?php if (empty($db->getTotalModules()) || empty($db->getTotalCampuses())) echo '<div id="instructions"></div>'; ?>
    <h1 class="text-capitalize text-success p-2">Calendar</h1>
    <div class="border-bottom border-3 border-success"></div>
    <form class="row g-3 pt-3">
        <div class="col-md-6">
            <label for="calender_type" class="form-label">Select Calendar type:</label>
            <select id="calender_type" class="form-select">
                <option selected value="academic_calendar">Academic Calendar</option>
                <option value="personal_calendar" <?php if (isset($calendarType) && array_key_exists('calendar', $calendarType)) echo 'selected'; ?>>Personal Calendar</option>
            </select>
        </div>
    </form>
    <div class="row">
        <div class="col-9">
            <div id="calendar_content"></div>
        </div>
        <div class="col-md-10">
            <div id="academic_calendar"></div>
            <div id="personal_calendar"></div>
        </div>
        <div class="col-sm-2" id="key"></div>
    </div>
</div>
<?php require_once '../includes/modals.inc.php'; ?>
<?php require_once '../templates/footer.php'; ?>
<script src="../js/calendar.js"></script>
