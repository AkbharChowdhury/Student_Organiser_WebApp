<?php
session_start();
require_once '../includes/class-autoload.php'; 
$db = Database::getInstance();
echo $db->getTotalCampuses().' campuses found';