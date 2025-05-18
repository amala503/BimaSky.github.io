<?php
class AuthHelper {
    /**
     * Memulai session jika belum dimulai
     */
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Memeriksa apakah user sudah login
     * 
     * @return bool True jika user sudah login, false jika belum
     */
    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['user_id']) && isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
    }
    
    /**
     * Memeriksa apakah user sudah login dan statusnya approve
     * 
     * @return bool True jika user sudah login dan statusnya approve, false jika tidak
     */
    public static function isApproved() {
        self::startSession();
        return self::isLoggedIn() && isset($_SESSION['status']) && $_SESSION['status'] === 'approve';
    }
    
    /**
     * Memeriksa apakah user sudah login dan memiliki akses
     * Jika tidak, redirect ke halaman login
     * 
     * @param bool $requireApproval Apakah perlu status approve
     * @return void
     */
    public static function requireLogin($requireApproval = true) {
        self::startSession();
        
        $isAuthenticated = $requireApproval ? self::isApproved() : self::isLoggedIn();
        
        if (!$isAuthenticated) {
            if (!self::isLoggedIn()) {
                // User belum login sama sekali
                $_SESSION['warning'] = "Anda harus mendaftar dan login terlebih dahulu untuk melihat dan memesan produk.";
            } else if ($requireApproval && $_SESSION['status'] !== 'approve') {
                // User sudah login tapi belum diapprove
                $_SESSION['warning'] = "Akun Anda masih dalam proses verifikasi. Silakan tunggu hingga admin menyetujui akun Anda.";
            }
            
            // Simpan halaman yang ingin diakses
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            
            // Redirect ke halaman login
            header("Location: login.php");
            exit();
        }
    }
    
    /**
     * Logout user
     * 
     * @return void
     */
    public static function logout() {
        self::startSession();
        
        // Hapus semua data session
        session_unset();
        session_destroy();
        
        // Redirect ke halaman login
        header('Location: login.php');
        exit();
    }
}
?>
