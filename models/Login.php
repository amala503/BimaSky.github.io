<?php
class Login {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Melakukan autentikasi pengguna
     * 
     * @param string $username Username pengguna
     * @param string $password Password pengguna
     * @return array|bool Data pengguna jika berhasil, false jika gagal
     */
    public function authenticate($username, $password) {
        // Cek apakah username ada
        $query = "SELECT * FROM pelanggan WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $stmt->close();
            return false;
        }
        
        $user = $result->fetch_assoc();
        $stmt->close();
        
        // Cek password
        if ($password === $user['password']) {
            return $user;
        }
        
        return false;
    }

    /**
     * Memeriksa apakah username sudah terdaftar
     * 
     * @param string $username Username yang akan diperiksa
     * @return bool True jika username sudah terdaftar, false jika belum
     */
    public function isUsernameExists($username) {
        $query = "SELECT id FROM pelanggan WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $exists = $result->num_rows > 0;
        $stmt->close();
        
        return $exists;
    }

    /**
     * Memeriksa apakah email sudah terdaftar
     * 
     * @param string $email Email yang akan diperiksa
     * @return bool True jika email sudah terdaftar, false jika belum
     */
    public function isEmailExists($email) {
        $query = "SELECT id FROM pelanggan WHERE email_perusahaan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $exists = $result->num_rows > 0;
        $stmt->close();
        
        return $exists;
    }
}
?>
