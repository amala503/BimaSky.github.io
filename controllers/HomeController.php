<?php
require_once __DIR__ . '/../models/Home.php';
require_once __DIR__ . '/../config/db_connection.php';

class HomeController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new Home($this->conn);
    }

    public function index() {
        // Mendapatkan produk terbaru
        $products = $this->model->getFeaturedProducts(3);
        
        // Mendapatkan promo terbaru
        $promos = $this->model->getLatestPromos(3);
                 
        // Menampilkan view
        require_once __DIR__ . '/../views/home_view.php';
    }
    
    public function __destruct() {
        Database::closeConnection();
    }
}
?>
