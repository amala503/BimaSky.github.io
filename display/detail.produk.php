<?php
session_start();
require_once '../controllers/ProdukController.php';

$controller = new ProdukController();
$controller->detail();

