<?php
require_once '../includes/class-autoload.php';
if (isset($_POST['personal_event_id'])) echo json_encode(Database::getInstance()->deletePersonalEvent(Helper::html($_POST['personal_event_id'])));
