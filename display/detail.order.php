<?php
session_start();
require_once '../controllers/DetailOrderController.php';

$controller = new DetailOrderController();
$controller->index();
?>
