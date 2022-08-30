<?php
require_once '../includes/class-autoload.php';
$db = Database::getInstance();
echo json_encode($db->getStatus());