<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fungsi untuk mengecek apakah user sudah login dan statusnya approve
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true && 
           isset($_SESSION['status']) && $_SESSION['status'] === 'approve';
}

// Jika user belum login atau status bukan approve
if (!isLoggedIn()) {
    if (!isset($_SESSION['is_logged_in']) || !isset($_SESSION['user_id'])) {
        // User belum login sama sekali
        $_SESSION['warning'] = "Anda harus mendaftar dan login terlebih dahulu untuk melihat dan memesan produk.";
    } else if ($_SESSION['status'] !== 'approve') {
        // User sudah login tapi belum diapprove
        $_SESSION['warning'] = "Akun Anda masih dalam proses verifikasi. Silakan tunggu hingga admin menyetujui akun Anda.";
    }
    
    // Simpan halaman yang ingin diakses
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    
    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}
