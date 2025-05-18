<?php
require_once __DIR__ . '/../models/Profile.php';
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../config/check_login.php';

class ProfileController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new Profile($this->conn);
    }

    public function index() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['warning'] = "Anda harus login terlebih dahulu untuk melihat profil.";
            header("Location: login.php");
            exit();
        }

        $userId = $_SESSION['user_id'];
        
        // Mendapatkan data profil pengguna
        $user = $this->model->getUserProfile($userId);
        
        // Mendapatkan data alamat pengguna
        $address = $this->model->getUserAddress($userId);
        
        // Mendapatkan data PIC pengguna
        $pic = $this->model->getUserPIC($userId);
        
        // Jika form update profil disubmit
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
            $this->updateProfile();
        }
        
        // Tampilkan view
        require_once __DIR__ . '/../views/profile_view.php';
    }
    
    private function updateProfile() {
        $userId = $_SESSION['user_id'];
        
        $data = [
            'nama_perusahaan' => $_POST['nama_perusahaan'],
            'email_perusahaan' => $_POST['email_perusahaan'],
            'no_telepon' => $_POST['no_telepon']
        ];
        
        // Validasi input
        if (empty($data['nama_perusahaan']) || empty($data['email_perusahaan']) || empty($data['no_telepon'])) {
            $_SESSION['error'] = "Semua field harus diisi.";
            return;
        }
        
        // Update profil
        if ($this->model->updateProfile($userId, $data)) {
            $_SESSION['success'] = "Profil berhasil diperbarui.";
            
            // Update session data
            $_SESSION['nama_pelanggan'] = $data['nama_perusahaan'];
        } else {
            $_SESSION['error'] = "Gagal memperbarui profil.";
        }
        
        // Redirect untuk refresh data
        header("Location: profile.php");
        exit();
    }
    
    public function updatePassword() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Anda harus login terlebih dahulu.']);
            exit;
        }
        
        // Cek apakah request adalah AJAX
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['current_password']) || empty($_POST['new_password'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request.']);
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        
        // Update password
        if ($this->model->updatePassword($userId, $currentPassword, $newPassword)) {
            echo json_encode(['success' => true, 'message' => 'Password berhasil diperbarui.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Password saat ini tidak valid.']);
        }
        
        exit;
    }
    
    public function __destruct() {
        Database::closeConnection();
    }
}
?>
