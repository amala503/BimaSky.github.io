<?php
class ErrorController {
    /**
     * Menampilkan halaman 404 (Not Found)
     */
    public function notFound() {
        // Kirim header 404
        header("HTTP/1.0 404 Not Found");
        
        // Tampilkan view
        require_once __DIR__ . '/../views/404_view.php';
    }
}
?>
