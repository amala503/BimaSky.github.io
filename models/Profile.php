<?php
class Profile {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mendapatkan data profil pengguna berdasarkan ID
     * 
     * @param int $userId ID pengguna
     * @return array|bool Data pengguna jika berhasil, false jika gagal
     */
    public function getUserProfile($userId) {
        $query = "SELECT * FROM pelanggan WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $stmt->close();
            return false;
        }
        
        $user = $result->fetch_assoc();
        $stmt->close();
        
        return $user;
    }

    /**
     * Mendapatkan data alamat perusahaan berdasarkan ID pengguna
     * 
     * @param int $userId ID pengguna
     * @return array|bool Data alamat jika berhasil, false jika gagal
     */
    public function getUserAddress($userId) {
        $query = "SELECT * FROM alamat_perusahaan WHERE pelanggan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $stmt->close();
            return false;
        }
        
        $address = $result->fetch_assoc();
        $stmt->close();
        
        return $address;
    }

    /**
     * Mendapatkan data PIC perusahaan berdasarkan ID pengguna
     * 
     * @param int $userId ID pengguna
     * @return array|bool Data PIC jika berhasil, false jika gagal
     */
    public function getUserPIC($userId) {
        $query = "SELECT * FROM pic_perusahaan WHERE pelanggan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $stmt->close();
            return false;
        }
        
        $pic = $result->fetch_assoc();
        $stmt->close();
        
        return $pic;
    }

    /**
     * Memperbarui data profil pengguna
     * 
     * @param int $userId ID pengguna
     * @param array $data Data profil yang akan diperbarui
     * @return bool True jika berhasil, false jika gagal
     */
    public function updateProfile($userId, $data) {
        $query = "UPDATE pelanggan SET 
                  nama_perusahaan = ?, 
                  email_perusahaan = ?, 
                  no_telepon = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", 
            $data['nama_perusahaan'], 
            $data['email_perusahaan'], 
            $data['no_telepon'], 
            $userId
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    /**
     * Memperbarui password pengguna
     * 
     * @param int $userId ID pengguna
     * @param string $currentPassword Password saat ini
     * @param string $newPassword Password baru
     * @return bool True jika berhasil, false jika gagal
     */
    public function updatePassword($userId, $currentPassword, $newPassword) {
        // Cek password lama
        $query = "SELECT password FROM pelanggan WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if (!$user || $user['password'] !== $currentPassword) {
            return false;
        }

        // Update password
        $updateQuery = "UPDATE pelanggan SET password = ? WHERE id = ?";
        $updateStmt = $this->conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $newPassword, $userId);
        
        $result = $updateStmt->execute();
        $updateStmt->close();
        
        return $result;
    }
}
?>
