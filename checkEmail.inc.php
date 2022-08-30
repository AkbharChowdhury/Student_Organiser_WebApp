<?php
require_once 'includes/class-autoload.php';
echo Database::getInstance()->studentEmailExists($_POST['email']);