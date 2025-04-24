<?php
session_start();
require_once '../controllers/TrackDetailController.php';

$controller = new TrackDetailController();
$controller->index();
?>

