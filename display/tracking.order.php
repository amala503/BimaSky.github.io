<?php
session_start();
require_once '../controllers/TrackingOrderController.php';

$controller = new TrackingOrderController();
$controller->index();
?>


