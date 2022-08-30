<?php
session_start();
require_once '../includes/class-autoload.php';
$db = Database::getInstance();

if(isset($_POST['module_id']) && isset($_POST['type_id']) && isset($_POST['semester_id'])){
    $moduleID = $_POST['module_id'];
    $typeID =  $_POST['type_id'];
    $semesterID =  $_POST['semester_id'];
    echo $db->duplicateClasses($moduleID, $typeID, $semesterID);
    return;
} 
echo 'Not all variables are set';
