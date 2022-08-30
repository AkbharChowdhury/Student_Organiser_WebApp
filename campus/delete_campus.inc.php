<?php

require_once '../includes/class-autoload.php';
$db = Database::getInstance();

if (isset($_POST['campus_id'])) {

    $campus = $_POST['campus_id'];
    if($db->deleteCampus($campus)){
        echo 'campus deleted';
    } else{
         echo 'unable to delete';
    }
    //echo Database::getInstance()->deleteCampus(Helper::html($_POST['campus_id']))? 'Campus deleted' : 'unable to delete campus';
    // if(Database::getInstance()->deleteCampus(Helper::html($_POST['campus_id']))){
    //     echo 'Campus deleted';
    //     return;
    // }
    // echo 'unable to delete campus';

}
