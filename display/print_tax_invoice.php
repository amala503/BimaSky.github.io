<?php
require_once 'check_login.php';
require_once '../controllers/PrintTaxInvoiceController.php';

$controller = new PrintTaxInvoiceController();
$controller->printTaxInvoice();
?>