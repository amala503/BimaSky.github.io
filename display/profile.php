<?php
session_start();
require_once '../controllers/ProfileController.php';

$controller = new ProfileController();
$controller->index();
