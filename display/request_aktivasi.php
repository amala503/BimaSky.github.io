<?php
require_once 'check_login.php';
require_once '../controllers/RequestActivasiController.php';

$controller = new RequestActivasiController();
$controller->processRequest();
?>
