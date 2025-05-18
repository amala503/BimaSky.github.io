<?php
class TrackDetail {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // UNIT FUNCTION
    public function canConfirmOrder($current_status) {
        return strtolower($current_status) === 'dikirim';
    }

    public function getReadableStatus($status) {
        $map = [
            'pending' => 'Menunggu',
            'dikirim' => 'Sedang Dikirim',
            'diterima' => 'Telah Diterima'
        ];
        return $map[$status] ?? 'Status Tidak Dikenal';
    }

    // INTEGRATION FUNCTION
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

    public function getOrderStatus($kode_pesanan, $user_id) {
        $sql = "SELECT status FROM pesanan WHERE kode_pesanan = ? AND pelanggan_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $kode_pesanan, $user_id);
            $stmt->execute();
            $stmt->bind_result($status);
            $stmt->fetch();
            $stmt->close();
            return $status;
        }
        return null;
    }

    public function updateOrderStatusToDiterima($kode_pesanan, $user_id) {
        $sql = "UPDATE pesanan SET status = 'Diterima' WHERE kode_pesanan = ? AND pelanggan_id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $kode_pesanan, $user_id);
            return $stmt->execute();
        }
        return false;
    }
}
