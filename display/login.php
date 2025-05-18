<?php
session_start();
require_once '../controllers/LoginController.php';

$controller = new LoginController();
$controller->index();
?>

