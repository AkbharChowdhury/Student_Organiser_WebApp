<?php
session_start();
require_once '../includes/class-autoload.php';
$db = Database::getInstance();
?>
<h4>Key:</h4>
<ul class="list-group">
    <?php if ($_POST['calenderType'] == 'academic'): ?>
        <li class="list-group-item text-white" style="background:<?= Helper::getCourseworkColour() ?>;"><small
                    class="color-text">Coursework</small></li>

        <?php foreach ($db->getAcademicCalendar() as $row) : ?>
            <li class="list-group-item text-white" style="background:<?= $row['colour'] ?>;"><small
                        class="color-text"><?= $row['module_code'] ?> <?= $row['module_name'] ?>
                    <strong><?= $row['type'] ?></strong>
                    (<?= $row['name'] ?>)</small></li>
        <?php endforeach; ?>
    <?php elseif ($_POST['calenderType'] == 'personal'): ?>
        <?php foreach ($db->getPersonalCalendarActivity() as $row) : ?>
            <li class="list-group-item text-white text-capitalize" style="background:<?= $row['activity_colour'] ?>;">
                <small class="color-text"><?= $row['type'] ?></small></li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>