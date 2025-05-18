<?php
require_once __DIR__ . '/../models/RequestAktivasi.php';
require_once __DIR__ . '/../config/db_connection.php';

class RequestActivasiController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new RequestAktivasi($this->conn);
    }

    /**
     * Memproses permintaan aktivasi
     */
    public function processRequest() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        // Cek apakah ada permintaan POST
        if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['request_aktivasi'])) {
            header("Location: tracking.order.php");
            exit();
        }

        $kode_pesanan = $_POST['kode_pesanan'];
        $user_id = $_SESSION['user_id'];

        // Cek status pesanan
        if (!$this->model->checkOrderStatus($kode_pesanan, $user_id)) {
            header("Location: track.detail.php?kode=" . urlencode($kode_pesanan) . "&request=invalid");
            exit();
        }

        // Proses permintaan aktivasi
        if ($this->model->requestActivation($kode_pesanan)) {
            header("Location: track.detail.php?kode=" . urlencode($kode_pesanan) . "&request=success");
            exit();
        } else {
            header("Location: track.detail.php?kode=" . urlencode($kode_pesanan) . "&request=error");
            exit();
        }
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
