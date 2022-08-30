<?php

require_once '../includes/class-autoload.php';
$db = Database::getInstance();

if (isset($_POST['checklist_id'])) echo $db->deleteCheckListID($_POST['checklist_id']) ? 'item deleted': 'unable to delete item';

