<?php
session_start();
unset($_SESSION['logged_in']);
unset($_SESSION['admin_logged_in']);
if (isset($_SESSION['student_id'])) unset($_SESSION['student_id']);
if (isset($_SESSION['email'])) unset($_SESSION['email']);
$_SESSION['message'] = 'You have been logged out';
$_SESSION['msg_type'] = 'success';
$_SESSION['msg_icon'] = 'check-circle-fill';
header('location: login.php');