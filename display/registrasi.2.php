<?php
session_start();
require_once '../controllers/RegistrasiController.php';

$controller = new RegistrasiController();
$controller->step2();
