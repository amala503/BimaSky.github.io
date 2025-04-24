<?php
class TrackDetail {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getOrderDetails($kode_pesanan, $user_id) {
        $sql = "SELECT p.*, pl.nama_perusahaan, pl.pic_perusahaan, dp.nama_produk, dp.kuantitas, dp.harga
                FROM pesanan p 
                LEFT JOIN pelanggan pl ON p.pelanggan_id = pl.id
                LEFT JOIN detail_pesanan dp ON dp.pelanggan_id = p.pelanggan_id
                WHERE p.kode_pesanan = ? AND p.pelanggan_id = ?";

        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $kode_pesanan, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }

    public function confirmOrder($kode_pesanan, $user_id) {
        // Cek status pesanan
        $cek_sql = "SELECT status FROM pesanan WHERE kode_pesanan = ? AND pelanggan_id = ?";
        $cek_stmt = $this->conn->prepare($cek_sql);
        if ($cek_stmt) {
            $cek_stmt->bind_param("si", $kode_pesanan, $user_id);
            $cek_stmt->execute();
            $cek_stmt->bind_result($current_status);
            $cek_stmt->fetch();
            $cek_stmt->close();

            if ($current_status === 'dikirim') {
                $sql = "UPDATE pesanan SET status = 'Diterima' WHERE kode_pesanan = ? AND pelanggan_id = ?";
                $stmt = $this->conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("si", $kode_pesanan, $user_id);
                    return $stmt->execute();
                }
            }
        }
        return false;
    }
}
?>