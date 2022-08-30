<?php

require_once '../includes/class-autoload.php';
$db = Database::getInstance();

if (isset($_POST['coursework_id'])) echo  $db->deleteCourseworkID($_POST['coursework_id']) ? 'coursework deleted': 'unable to delete coursework';

