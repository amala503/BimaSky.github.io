<?php
require_once __DIR__ . '/../models/CheckAvailability.php';
require_once __DIR__ . '/../config/db_connection.php';

class CheckAvailabilityController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new CheckAvailability($this->conn);
    }

    /**
     * Memeriksa ketersediaan username
     */
    public function checkUsername() {
        header('Content-Type: application/json');
        
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $exists = $this->model->isUsernameExists($username);
            
            if ($exists) {
                echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan!']);
            } else {
                echo json_encode(['status' => 'success', 'message' => 'available']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Parameter username tidak ditemukan']);
        }
    }

    /**
     * Memeriksa ketersediaan email
     */
    public function checkEmail() {
        header('Content-Type: application/json');
        
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $exists = $this->model->isEmailExists($email);
            
            if ($exists) {
                echo json_encode(['status' => 'error', 'message' => 'Email sudah digunakan!']);
            } else {
                echo json_encode(['status' => 'success', 'message' => 'available']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Parameter email tidak ditemukan']);
        }
    }

    /**
     * Memeriksa ketersediaan username atau email berdasarkan parameter yang dikirim
     */
    public function check() {
        if (isset($_POST['username'])) {
            $this->checkUsername();
        } else if (isset($_POST['email'])) {
            $this->checkEmail();
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Parameter tidak valid']);
        }
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
