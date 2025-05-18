<?php
session_start();
require_once '../controllers/SetupLoginController.php';

$controller = new SetupLoginController();
$controller->setup();
?>
