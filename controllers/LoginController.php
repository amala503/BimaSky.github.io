<?php
require_once __DIR__ . '/../models/Login.php';
require_once __DIR__ . '/../config/db_connection.php';

class LoginController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new Login($this->conn);
    }

    public function index() {
        // Jika user sudah login, redirect ke halaman home
        if (isset($_SESSION['user_id'])) {
            header('Location: home.php');
            exit();
        }

        // Jika form login disubmit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
        }

        // Tampilkan view
        require_once __DIR__ . '/../views/login_view.php';
    }

    private function processLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validasi input
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Username dan password harus diisi.";
            return;
        }

        // Autentikasi user
        $user = $this->model->authenticate($username, $password);

        if ($user) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_pelanggan'] = $user['nama_perusahaan'];
            $_SESSION['pic_perusahaan'] = $user['pic_perusahaan'];
            $_SESSION['status'] = $user['status'];
            $_SESSION['is_logged_in'] = true;

            // Redirect ke halaman yang diminta sebelumnya atau ke home.php
            $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'home.php';
            unset($_SESSION['redirect_after_login']); // Clear the redirect
            header("Location: " . $redirect);
            exit();
        } else {
            $_SESSION['error'] = "Username atau password salah.";
        }
    }

    public function logout() {
        // Hapus semua data session
        session_unset();
        session_destroy();

        // Redirect ke halaman login
        header('Location: login.php');
        exit();
    }

    public function processLoginAjax() {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("Location: login.php");
            exit();
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validasi input
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Username dan password harus diisi.";
            header("Location: login.php");
            exit();
        }

        // Autentikasi user
        $user = $this->model->authenticate($username, $password);

        if ($user) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_pelanggan'] = $user['nama_perusahaan'];
            $_SESSION['pic_perusahaan'] = $user['pic_perusahaan'];
            $_SESSION['status'] = $user['status'];
            $_SESSION['is_logged_in'] = true;

            // Redirect ke halaman yang diminta sebelumnya atau ke home.php
            $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'home.php';
            unset($_SESSION['redirect_after_login']); // Clear the redirect
            header("Location: " . $redirect);
            exit();
        } else {
            $_SESSION['error'] = "Username atau password salah.";
            header("Location: login.php");
            exit();
        }
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
