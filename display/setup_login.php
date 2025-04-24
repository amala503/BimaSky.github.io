<?php
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

// Tambah kolom status jika belum ada
$alterTable = "ALTER TABLE pelanggan
               ADD COLUMN IF NOT EXISTS status ENUM('pending', 'active', 'rejected') DEFAULT 'active'";

if ($conn->query($alterTable) === TRUE) {
    echo "Kolom status berhasil ditambahkan atau sudah ada.<br>";
} else {
    echo "Error menambahkan kolom: " . $conn->error . "<br>";
}

// Set status default ke active untuk semua user yang belum memiliki status
$updateStatus = "UPDATE pelanggan 
                SET status = 'active'
                WHERE status IS NULL";

if ($conn->query($updateStatus) === TRUE) {
    echo "Status default berhasil diatur ke 'active'.<br>";
} else {
    echo "Error mengatur status default: " . $conn->error . "<br>";
}

$conn->close();

echo "Setup selesai. Sekarang Anda bisa mencoba login kembali.";
?>
