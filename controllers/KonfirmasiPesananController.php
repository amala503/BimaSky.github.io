<?php
require_once __DIR__ . '/../models/KonfirmasiPesanan.php';
require_once __DIR__ . '/../config/db_connection.php';

class KonfirmasiPesananController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new KonfirmasiPesanan($this->conn);
    }

    /**
     * Memproses konfirmasi pesanan
     */
    public function processConfirmation() {
        // Set header untuk JSON response
        header('Content-Type: application/json');
        
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Anda harus login terlebih dahulu.']);
            return;
        }

        // Cek apakah ada permintaan POST
        if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['konfirmasi_pesanan'])) {
            echo json_encode(['success' => false, 'message' => 'Permintaan tidak valid.']);
            return;
        }

        $kode_pesanan = $_POST['kode_pesanan'];
        $user_id = $_SESSION['user_id'];
        
        // Proses konfirmasi pesanan
        if ($this->model->confirmOrder($kode_pesanan, $user_id)) {
            echo json_encode(['success' => true, 'message' => 'Pesanan berhasil dikonfirmasi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengkonfirmasi pesanan. Silakan coba lagi.']);
        }
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
