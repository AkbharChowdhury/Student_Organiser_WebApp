<?php
require_once '../includes/class-autoload.php';
if (isset($_POST['class_id'])) echo json_encode(Database::getInstance()->deleteClass(Helper::html($_POST['class_id'])));
