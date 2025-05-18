<?php
class Location {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mendapatkan daftar kabupaten berdasarkan ID provinsi
     * 
     * @param string $provinsi_id ID provinsi
     * @return array Daftar kabupaten
     */
    public function getKabupaten($provinsi_id) {
        $query = "SELECT * FROM kabupaten WHERE provinsi_id = ? ORDER BY nama_kabupaten";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return [];
        }
        
        $stmt->bind_param("s", $provinsi_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $kabupaten = [];
        while ($row = $result->fetch_assoc()) {
            $kabupaten[] = $row;
        }
        
        $stmt->close();
        
        return $kabupaten;
    }

    /**
     * Mendapatkan daftar kecamatan berdasarkan ID kabupaten
     * 
     * @param string $kabupaten_id ID kabupaten
     * @return array Daftar kecamatan
     */
    public function getKecamatan($kabupaten_id) {
        $query = "SELECT * FROM kecamatan WHERE kabupaten_id = ? ORDER BY nama_kecamatan";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return [];
        }
        
        $stmt->bind_param("s", $kabupaten_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $kecamatan = [];
        while ($row = $result->fetch_assoc()) {
            $kecamatan[] = $row;
        }
        
        $stmt->close();
        
        return $kecamatan;
    }

    /**
     * Mendapatkan daftar kelurahan berdasarkan ID kecamatan
     * 
     * @param string $kecamatan_id ID kecamatan
     * @return array Daftar kelurahan
     */
    public function getKelurahan($kecamatan_id) {
        $query = "SELECT * FROM kelurahan WHERE kecamatan_id = ? ORDER BY nama_kelurahan";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return [];
        }
        
        $stmt->bind_param("s", $kecamatan_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $kelurahan = [];
        while ($row = $result->fetch_assoc()) {
            $kelurahan[] = $row;
        }
        
        $stmt->close();
        
        return $kelurahan;
    }
}
?>
