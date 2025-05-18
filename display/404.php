<?php
session_start();
require_once '../controllers/ErrorController.php';

$controller = new ErrorController();
$controller->notFound();
