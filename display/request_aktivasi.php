<?php
require_once 'check_login.php';
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtptelkomsat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_aktivasi'])) {
    $kode_pesanan = $_POST['kode_pesanan'];
    $user_id = $_SESSION['user_id'];
    
    // Cek status pesanan saat ini
    $check_sql = "SELECT id FROM pesanan WHERE kode_pesanan = ? AND pelanggan_id = ? AND status = 'Diterima'";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $kode_pesanan, $user_id);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        $check_stmt->bind_result($pesanan_id);
        $check_stmt->fetch();
        
        // Update status menjadi 'Request_Aktivasi'
        $sql = "UPDATE pesanan SET status = 'Request_Aktivasi' WHERE kode_pesanan = ?";
        $stmt_update = $conn->prepare($sql);
        $stmt_update->bind_param("s", $kode_pesanan);
        
        if ($stmt_update->execute()) {
            // Tambahkan notifikasi
            $pesan_notifikasi = "Pelanggan telah meminta aktivasi layanan untuk pesanan " . $kode_pesanan;
            
            // Periksa struktur tabel notifikasi
            $sql_check_table = "DESCRIBE notifikasi";
            $result_check = $conn->query($sql_check_table);
            $columns = [];
            while ($row = $result_check->fetch_assoc()) {
                $columns[] = $row['Field'];
            }
            
            // Buat query berdasarkan struktur tabel yang ada
            if (in_array('pesan', $columns)) {
                $sql_notifikasi = "INSERT INTO notifikasi (kode_pesanan, pesan) VALUES (?, ?)";
                $stmt_notif = $conn->prepare($sql_notifikasi);
                if ($stmt_notif) {
                    $stmt_notif->bind_param("ss", $kode_pesanan, $pesan_notifikasi);
                    $stmt_notif->execute();
                } else {
                    error_log("Error preparing notification statement: " . $conn->error);
                }
            } else {
                $sql_notifikasi = "INSERT INTO notifikasi (kode_pesanan, nama_produk, harga, kuantitas) 
                                  SELECT ?, 'Request Aktivasi', 0, 1";
                $stmt_notif = $conn->prepare($sql_notifikasi);
                if ($stmt_notif) {
                    $stmt_notif->bind_param("s", $kode_pesanan);
                    $stmt_notif->execute();
                } else {
                    error_log("Error preparing notification statement: " . $conn->error);
                }
            }

            // Redirect dengan notifikasi sukses
            header("Location: track.detail.php?kode=" . urlencode($kode_pesanan) . "&request=success");
            exit();
        } else {
            header("Location: track.detail.php?kode=" . urlencode($kode_pesanan) . "&request=error");
            exit();
        }
    } else {
        header("Location: track.detail.php?kode=" . urlencode($kode_pesanan) . "&request=invalid");
        exit();
    }
}

$conn->close();
?>
