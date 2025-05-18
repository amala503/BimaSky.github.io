<?php
class Registrasi {
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

    /**
     * Mendaftarkan pelanggan baru
     * 
     * @param array $data Data pelanggan
     * @return int|bool ID pelanggan jika berhasil, false jika gagal
     */
    public function registerPelanggan($data) {
        // Mulai transaksi
        $this->conn->begin_transaction();
        
        try {
            // Insert data pelanggan
            $query = "INSERT INTO pelanggan (
                jenis_bisnis, 
                kategori_bisnis, 
                nama_perusahaan, 
                nomor_npwp, 
                email_perusahaan, 
                no_telepon, 
                username, 
                password, 
                sumber_informasi,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(
                "sssssssss", 
                $data['jenis_bisnis'], 
                $data['kategori_bisnis'], 
                $data['nama_perusahaan'], 
                $data['nomor_npwp'], 
                $data['email_perusahaan'], 
                $data['no_telepon'], 
                $data['username'], 
                $data['password'], 
                $data['sumber_informasi']
            );
            
            $stmt->execute();
            $pelangganId = $stmt->insert_id;
            $stmt->close();
            
            // Commit transaksi
            $this->conn->commit();
            
            return $pelangganId;
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            $this->conn->rollback();
            return false;
        }
    }

    /**
     * Mendaftarkan PIC perusahaan
     * 
     * @param array $data Data PIC
     * @param int $pelangganId ID pelanggan
     * @return bool True jika berhasil, false jika gagal
     */
    public function registerPIC($data, $pelangganId) {
        $query = "INSERT INTO pic_perusahaan (
            pelanggan_id, 
            nama_pic, 
            jabatan, 
            departemen, 
            no_ponsel, 
            email
        ) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "isssss", 
            $pelangganId, 
            $data['nama_pic'], 
            $data['jabatan'], 
            $data['departemen'], 
            $data['no_ponsel'], 
            $data['email']
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    /**
     * Mendaftarkan alamat perusahaan
     * 
     * @param array $data Data alamat
     * @param int $pelangganId ID pelanggan
     * @return bool True jika berhasil, false jika gagal
     */
    public function registerAlamat($data, $pelangganId) {
        $query = "INSERT INTO alamat_perusahaan (
            pelanggan_id, 
            provinsi, 
            kabupaten_kota, 
            kecamatan, 
            kelurahan_desa, 
            rt_rw, 
            detail_alamat, 
            link_maps
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "isssssss", 
            $pelangganId, 
            $data['provinsi'], 
            $data['kabupaten_kota'], 
            $data['kecamatan'], 
            $data['kelurahan_desa'], 
            $data['rt_rw'], 
            $data['detail_alamat'], 
            $data['link_maps']
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }
}
?>
