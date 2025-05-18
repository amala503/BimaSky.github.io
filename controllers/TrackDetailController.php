<?php
require_once __DIR__ . '/../models/TrackDetail.php';
require_once __DIR__ . '/../config/db_connection.php';

class TrackDetailController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new TrackDetail($this->conn);
    }

    public function index() {
        if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
            header("Location: login.php");
            exit();
        }

        $order = null;
        $message = null;

        if (isset($_GET['kode'])) {
            $kode_pesanan = $_GET['kode'];
            $user_id = $_SESSION['user_id'];
            $order = $this->model->getOrderDetails($kode_pesanan, $user_id);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['konfirmasi_pesanan'])) {
            $kode_pesanan = $_POST['kode_pesanan'];
            $user_id = $_SESSION['user_id'];
            
          // 💡 Ambil status dan validasi pakai fungsi unit
          $current_status = $this->model->getOrderStatus($kode_pesanan, $user_id);
          if ($this->model->canConfirmOrder($current_status)) {
              if ($this->model->updateOrderStatusToDiterima($kode_pesanan, $user_id)) {
                  header("Location: track.detail.php?kode=" . urlencode($kode_pesanan) . "&status=success");
                  exit();
              }
          }

          // Jika gagal atau status tidak valid
          header("Location: track.detail.php?kode=" . urlencode($kode_pesanan) . "&status=error");
          exit();
        }

        require_once __DIR__ . '/../views/track_detail_view.php';
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>