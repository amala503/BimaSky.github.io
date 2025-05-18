<?php
require_once __DIR__ . '/../models/SetupLogin.php';
require_once __DIR__ . '/../config/db_connection.php';

class SetupLoginController {
    private $model;
    private $conn;
    private $messages = [];

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new SetupLogin($this->conn);
    }

    /**
     * Menjalankan setup login
     */
    public function setup() {
        // Tambah kolom status jika belum ada
        if ($this->model->addStatusColumn()) {
            $this->messages[] = "Kolom status berhasil ditambahkan atau sudah ada.";
        } else {
            $this->messages[] = "Error menambahkan kolom status: " . $this->conn->error;
        }

        // Set status default ke active untuk semua user yang belum memiliki status
        if ($this->model->updateNullStatus()) {
            $this->messages[] = "Status default berhasil diupdate.";
        } else {
            $this->messages[] = "Error mengupdate status default: " . $this->conn->error;
        }

        // Tambah kolom pic_perusahaan jika belum ada
        if ($this->model->addPICColumn()) {
            $this->messages[] = "Kolom pic_perusahaan berhasil ditambahkan atau sudah ada.";
        } else {
            $this->messages[] = "Error menambahkan kolom pic_perusahaan: " . $this->conn->error;
        }

        // Update data PIC dari tabel pic_perusahaan
        if ($this->model->updatePICData()) {
            $this->messages[] = "Data PIC berhasil diupdate.";
        } else {
            $this->messages[] = "Error mengupdate data PIC: " . $this->conn->error;
        }

        // Tampilkan view
        require_once __DIR__ . '/../views/setup_login_view.php';
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
