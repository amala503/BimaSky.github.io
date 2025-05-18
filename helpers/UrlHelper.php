<?php
/**
 * Helper class untuk mengelola URL
 */
class UrlHelper {
    /**
     * Menghasilkan URL bersih tanpa ekstensi .php
     * 
     * @param string $page Nama halaman (tanpa ekstensi .php)
     * @param array $params Parameter URL (opsional)
     * @return string URL yang dihasilkan
     */
    public static function url($page, $params = []) {
        // Base URL
        $baseUrl = '/skripsi';
        
        // URL dasar
        $url = $baseUrl . '/' . $page;
        
        // Tambahkan parameter jika ada
        if (!empty($params)) {
            // Jika hanya ada satu parameter dan namanya 'id', gunakan format URL yang lebih bersih
            if (count($params) === 1 && isset($params['id'])) {
                $url .= '/' . $params['id'];
            } else {
                // Jika ada lebih dari satu parameter atau bukan 'id', gunakan format query string
                $url .= '?' . http_build_query($params);
            }
        }
        
        return $url;
    }
    
    /**
     * Menghasilkan URL untuk asset (CSS, JS, gambar, dll)
     * 
     * @param string $path Path relatif ke file asset
     * @return string URL asset yang dihasilkan
     */
    public static function asset($path) {
        // Base URL
        $baseUrl = '/skripsi';
        
        return $baseUrl . '/' . ltrim($path, '/');
    }
    
    /**
     * Menghasilkan URL untuk gambar
     * 
     * @param string $path Path relatif ke file gambar
     * @return string URL gambar yang dihasilkan
     */
    public static function image($path) {
        return self::asset('assets/' . ltrim($path, '/'));
    }
    
    /**
     * Menghasilkan URL untuk CSS
     * 
     * @param string $path Path relatif ke file CSS
     * @return string URL CSS yang dihasilkan
     */
    public static function css($path) {
        return self::asset('css/' . ltrim($path, '/'));
    }
    
    /**
     * Menghasilkan URL untuk JavaScript
     * 
     * @param string $path Path relatif ke file JavaScript
     * @return string URL JavaScript yang dihasilkan
     */
    public static function js($path) {
        return self::asset('js/' . ltrim($path, '/'));
    }
    
    /**
     * Redirect ke URL tertentu
     * 
     * @param string $page Nama halaman (tanpa ekstensi .php)
     * @param array $params Parameter URL (opsional)
     * @return void
     */
    public static function redirect($page, $params = []) {
        $url = self::url($page, $params);
        header("Location: $url");
        exit();
    }
    
    /**
     * Mendapatkan URL saat ini
     * 
     * @return string URL saat ini
     */
    public static function currentUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        
        return "$protocol://$host$uri";
    }
}
