<?php
require_once 'check_login.php';
require_once '../controllers/PrintReceiptController.php';

$controller = new PrintReceiptController();
$controller->printReceipt();