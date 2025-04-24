<?php
class Database
{
    private static $host = 'localhost';
    private static $username = 'root';
    private static $password = '';
    private static $database = 'dtptelkomsat';
    private static $conn = null;

    // Private constructor untuk mencegah instansiasi langsung
    private function __construct() {}

    // Fungsi untuk mendapatkan koneksi database
    public static function getConnection()
    {
        if (self::$conn === null) {
            self::$conn = new mysqli(self::$host, self::$username, self::$password, self::$database);

            // Cek koneksi
            if (self::$conn->connect_error) {
                die("Koneksi gagal: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }

    // Fungsi untuk menutup koneksi
    public static function closeConnection()
    {
        if (self::$conn !== null) {
            self::$conn->close();
            self::$conn = null;
        }
    }
}
?>
