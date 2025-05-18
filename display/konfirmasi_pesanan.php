<?php
require_once 'check_login.php';
require_once '../controllers/KonfirmasiPesananController.php';

$controller = new KonfirmasiPesananController();
$controller->processConfirmation();
?>
