<?php
class CheckAvailability {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Memeriksa apakah username sudah terdaftar
     * 
     * @param string $username Username yang akan diperiksa
     * @return bool True jika username sudah terdaftar, false jika belum
     */
    public function isUsernameExists($username) {
        $query = "SELECT * FROM pelanggan WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }
        
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
        $query = "SELECT * FROM pelanggan WHERE email_perusahaan = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        
        $stmt->close();
        
        return $exists;
    }
}
?>
