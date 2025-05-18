<?php
session_start();
require_once '../controllers/PopupController.php';

$controller = new PopupController();
$controller->showAlamatDetail();

