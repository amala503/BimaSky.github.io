<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dtptelkomsat';

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah request datang dengan parameter username atau email
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $query = "SELECT * FROM pelanggan WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Username sudah digunakan!";
    } else {
        echo "available"; // Jika username tersedia
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $query = "SELECT * FROM pelanggan WHERE email_perusahaan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Email sudah digunakan!";
    } else {
        echo "available"; // Jika email tersedia
    }
}
?>
