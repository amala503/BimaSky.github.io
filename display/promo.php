<?php
session_start();
require_once '../controllers/PromoController.php';

$controller = new PromoController();
$controller->index();

