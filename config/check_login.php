<?php
/**
 * File ini digunakan untuk memeriksa status login pengguna
 * dan menyimpan URL saat ini untuk redirect setelah login
 */

// Mulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Simpan URL saat ini untuk redirect setelah login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    
    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}
?>
