<?php
session_start();
header('Content-Type: application/json');
require_once '../controllers/ProfileController.php';

$controller = new ProfileController();
$controller->updatePassword();
?>
