<?php
require_once 'check_login.php';
require_once '../controllers/PrintActivationController.php';

$controller = new PrintActivationController();
$controller->printActivation();


?>
