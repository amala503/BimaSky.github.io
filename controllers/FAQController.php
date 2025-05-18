<?php
require_once __DIR__ . '/../models/FAQ.php';
require_once __DIR__ . '/../config/db_connection.php';

class FAQController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new FAQ($this->conn);
    }

    public function index() {
        // Mendapatkan semua kategori
        $categories = $this->model->getAllCategories();
        
        // Mendapatkan semua FAQ
        $faqs = $this->model->getAllFAQs();
        
        // Menampilkan view
        require_once __DIR__ . '/../views/faq_view.php';
    }
    
    public function search() {
        // Cek apakah ada keyword pencarian
        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $faqs = $this->model->searchFAQs($keyword);
        } else {
            $faqs = $this->model->getAllFAQs();
        }
        
        // Mendapatkan semua kategori
        $categories = $this->model->getAllCategories();
        
        // Menampilkan view
        require_once __DIR__ . '/../views/faq_view.php';
    }
    
    public function filterByCategory() {
        // Cek apakah ada kategori yang dipilih
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $category = $_GET['category'];
            $faqs = $this->model->getFAQsByCategory($category);
        } else {
            $faqs = $this->model->getAllFAQs();
        }
        
        // Mendapatkan semua kategori
        $categories = $this->model->getAllCategories();
        
        // Menampilkan view
        require_once __DIR__ . '/../views/faq_view.php';
    }
    
    public function __destruct() {
        Database::closeConnection();
    }
}
?>
