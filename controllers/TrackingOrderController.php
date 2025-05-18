<?php
require_once __DIR__ . '/../models/TrackingOrder.php';
require_once __DIR__ . '/../config/db_connection.php';

class TrackingOrderController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new TrackingOrder($this->conn);
    }

    public function index() {
        // Check login status
        if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || !isset($_SESSION['user_id'])) {
            $_SESSION['warning'] = "Anda harus login terlebih dahulu untuk melihat pesanan Anda.";
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        
        try {
            // Validasi user_id terlebih dahulu dengan fungsi unit
            $this->model->validateUserId($user_id);

            // Ambil pesanan dari model
            $orders = $this->model->getOrdersByUserId($user_id);

            // Load view
            require_once __DIR__ . '/../views/tracking_order_view.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
            header("Location: error.php");
            exit();
        }
    }
    public function __destruct() {
        Database::closeConnection();
    }
}
?>


