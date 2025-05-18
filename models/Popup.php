<?php
class Popup {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mendapatkan data alamat perusahaan berdasarkan ID pelanggan
     * 
     * @param int $pelanggan_id ID pelanggan
     * @return array|false Data alamat perusahaan atau false jika tidak ditemukan
     */
    public function getAlamatPerusahaan($pelanggan_id) {
        $query = "SELECT * FROM alamat_perusahaan WHERE pelanggan_id = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param("i", $pelanggan_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        $stmt->close();
        
        return $data;
    }
}
?>
