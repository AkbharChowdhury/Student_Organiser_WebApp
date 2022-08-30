<?php
session_start();
require_once '../includes/class-autoload.php';
$db = Database::getInstance();

if(isset($_POST['module_code'])) echo $db->duplicateModule(trim($_POST['module_code']));

