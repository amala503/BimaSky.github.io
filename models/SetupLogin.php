<?php
class SetupLogin {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Menambahkan kolom status ke tabel pelanggan jika belum ada
     * 
     * @return bool True jika berhasil, false jika gagal
     */
    public function addStatusColumn() {
        $alterTable = "ALTER TABLE pelanggan
                      ADD COLUMN IF NOT EXISTS status ENUM('pending', 'active', 'rejected') DEFAULT 'active'";
        
        return $this->conn->query($alterTable) === TRUE;
    }

    /**
     * Mengupdate status pelanggan yang belum memiliki status
     * 
     * @return bool True jika berhasil, false jika gagal
     */
    public function updateNullStatus() {
        $updateStatus = "UPDATE pelanggan 
                        SET status = 'active'
                        WHERE status IS NULL";
        
        return $this->conn->query($updateStatus) === TRUE;
    }

    /**
     * Menambahkan kolom pic_perusahaan ke tabel pelanggan jika belum ada
     * 
     * @return bool True jika berhasil, false jika gagal
     */
    public function addPICColumn() {
        $alterTable = "ALTER TABLE pelanggan
                      ADD COLUMN IF NOT EXISTS pic_perusahaan VARCHAR(100) NULL";
        
        return $this->conn->query($alterTable) === TRUE;
    }

    /**
     * Mengupdate kolom pic_perusahaan dengan data dari tabel pic_perusahaan
     * 
     * @return bool True jika berhasil, false jika gagal
     */
    public function updatePICData() {
        $updatePIC = "UPDATE pelanggan p
                     LEFT JOIN pic_perusahaan pic ON p.id = pic.pelanggan_id
                     SET p.pic_perusahaan = pic.nama_pic
                     WHERE p.pic_perusahaan IS NULL AND pic.nama_pic IS NOT NULL";
        
        return $this->conn->query($updatePIC) === TRUE;
    }
}
?>
