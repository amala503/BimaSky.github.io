<?php
class KonfirmasiPesanan {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mengkonfirmasi pesanan
     *
     * @param string $kode_pesanan Kode pesanan
     * @param int $user_id ID pelanggan
     * @return bool True jika berhasil, false jika gagal
     */
    public function confirmOrder($kode_pesanan, $user_id) {
        // Update status menjadi 'Diterima'
        $sql = "UPDATE pesanan SET status = 'Diterima' WHERE kode_pesanan = ? AND pelanggan_id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $kode_pesanan, $user_id);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            // Dapatkan detail pesanan dari tabel pesanan dan detail_pesanan
            $sql_notif = "INSERT INTO notifikasi (kode_pesanan, nama_produk, harga, kuantitas)
                          SELECT p.kode_pesanan, dp.nama_produk, dp.harga, dp.kuantitas
                          FROM pesanan p
                          JOIN detail_pesanan dp ON p.pelanggan_id = dp.pelanggan_id
                          WHERE p.kode_pesanan = ?";

            $stmt_notif = $this->conn->prepare($sql_notif);

            // Periksa apakah prepare statement berhasil
            if ($stmt_notif) {
                $stmt_notif->bind_param("s", $kode_pesanan);
                $stmt_notif->execute();
                $stmt_notif->close();
            } else {
                // Log error untuk debugging
                error_log("Error preparing notification statement: " . $this->conn->error);
                return false;
            }
        }

        return $result;
    }
}
