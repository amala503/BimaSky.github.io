<?php
session_start();

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dtptelkomsat';

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lindungi dari SQL injection
    $username = $conn->real_escape_string($username);
    
    // Query untuk mencari user di tabel pelanggan
    $query = "SELECT * FROM pelanggan WHERE (username = ? OR email_perusahaan = ?) AND status = 'approve'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Cek password
        if ($password === $user['password']) {
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
            $_SESSION['error'] = "Password yang Anda masukkan salah.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username atau email tidak ditemukan atau akun belum disetujui.";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

$conn->close();
?>
