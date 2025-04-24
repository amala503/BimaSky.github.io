<?php
session_start();
header('Content-Type: application/json');

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dtptelkomsat';

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Koneksi gagal: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $userId = $_SESSION['user_id'];

    // Validasi password baru dan konfirmasi password
    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Password baru dan konfirmasi password tidak cocok']);
        exit;
    }

    // Cek password lama
    $query = "SELECT password FROM pelanggan WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || $user['password'] !== $currentPassword) {
        echo json_encode(['success' => false, 'message' => 'Password saat ini tidak valid']);
        exit;
    }

    // Update password
    $updateQuery = "UPDATE pelanggan SET password = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("si", $newPassword, $userId);
    
    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Password berhasil diperbarui']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui password']);
    }
    
    $updateStmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid']);
}

$conn->close();
?>
