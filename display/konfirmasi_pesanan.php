<?php
require_once 'check_login.php';
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtptelkomsat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed']));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['konfirmasi_pesanan'])) {
    $kode_pesanan = $_POST['kode_pesanan'];
    $user_id = $_SESSION['user_id'];

    // Update status menjadi 'Diterima'
    $sql = "UPDATE pesanan SET status = 'Diterima' WHERE kode_pesanan = ? AND pelanggan_id = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $kode_pesanan, $user_id);
        
        if ($stmt->execute()) {
            // Dapatkan detail pesanan dari tabel pesanan dan detail_pesanan
            $sql_notif = "INSERT INTO notifikasi (kode_pesanan, nama_produk, harga, kuantitas) 
                          SELECT p.kode_pesanan, dp.nama_produk, dp.harga, dp.kuantitas 
                          FROM pesanan p
                          JOIN detail_pesanan dp ON p.pelanggan_id = dp.pelanggan_id
                          WHERE p.kode_pesanan = ?";
            
            $stmt_notif = $conn->prepare($sql_notif);
            
            // Periksa apakah prepare statement berhasil
            if ($stmt_notif) {
                $stmt_notif->bind_param("s", $kode_pesanan);
                $stmt_notif->execute();
                echo json_encode(['success' => true]);
            } else {
                // Log error untuk debugging
                error_log("Error preparing notification statement: " . $conn->error);
                echo json_encode(['success' => false, 'message' => 'Notification statement preparation failed: ' . $conn->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Update failed: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Statement preparation failed: ' . $conn->error]);
    }
}

$conn->close();
?>
