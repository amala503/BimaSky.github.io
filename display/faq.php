<?php
session_start();
require_once '../controllers/FAQController.php';

// Cek apakah ada keyword pencarian
if (isset($_GET['keyword'])) {
    $controller = new FAQController();
    $controller->search();
}
// Cek apakah ada filter kategori
else if (isset($_GET['category'])) {
    $controller = new FAQController();
    $controller->filterByCategory();
}
// Tampilkan semua FAQ
else {
    $controller = new FAQController();
    $controller->index();
}
