<?php
require_once __DIR__ . '/../models/Popup.php';
require_once __DIR__ . '/../config/db_connection.php';

class PopupController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new Popup($this->conn);
    }

    /**
     * Menampilkan detail alamat perusahaan
     */
    public function showAlamatDetail() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            echo "Anda harus login terlebih dahulu.";
            return;
        }

        $pelanggan_id = $_SESSION['user_id'];
        $data = $this->model->getAlamatPerusahaan($pelanggan_id);
        
        // Tampilkan view
        require_once __DIR__ . '/../views/popup_view.php';
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
