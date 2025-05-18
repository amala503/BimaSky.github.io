<?php
require_once __DIR__ . '/../models/Promo.php';
require_once __DIR__ . '/../config/db_connection.php';

class PromoController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new Promo($this->conn);
    }

    public function index() {
        // Mendapatkan semua promo
        $promos = $this->model->getAllPromos();

        // Menampilkan view
        require_once __DIR__ . '/../views/promo_view.php';
    }

    public function detail() {
        // Cek apakah ada ID promo
        if (!isset($_GET['id'])) {
            header('Location: promo.php');
            exit();
        }

        $id = intval($_GET['id']);

        // Mendapatkan detail promo
        $promo = $this->model->getPromoById($id);

        if (!$promo) {
            // Redirect ke halaman promo jika promo tidak ditemukan
            header('Location: promo.php');
            exit();
        }

        // Mendapatkan produk yang terkait dengan promo
        $products = $this->model->getPromoProducts($id);

        // Menampilkan view
        require_once __DIR__ . '/../views/detail_promo_view.php';
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
