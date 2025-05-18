<?php
class RequestAktivasi {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Memeriksa apakah pesanan memenuhi syarat untuk aktivasi
     *
     * @param string $kode_pesanan Kode pesanan
     * @param int $user_id ID pelanggan
     * @return bool True jika pesanan memenuhi syarat, false jika tidak
     */
    public function checkOrderStatus($kode_pesanan, $user_id) {
        $sql = "SELECT id FROM pesanan WHERE kode_pesanan = ? AND pelanggan_id = ? AND status = 'Diterima'";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $kode_pesanan, $user_id);
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        $stmt->close();

        return $count > 0;
    }

    /**
     * Meminta aktivasi untuk pesanan
     *
     * @param string $kode_pesanan Kode pesanan
     * @param int $user_id ID pelanggan
     * @return bool True jika berhasil, false jika gagal
     */
    public function requestActivation($kode_pesanan) {
        // Update status pesanan menjadi 'Request_Aktivasi'
        $sql = "UPDATE pesanan SET status = 'Request_Aktivasi' WHERE kode_pesanan = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $kode_pesanan);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            // Tambahkan notifikasi
            $pesan_notifikasi = "Pelanggan telah meminta aktivasi layanan untuk pesanan " . $kode_pesanan;

            // Periksa struktur tabel notifikasi
            $sql_check_table = "DESCRIBE notifikasi";
            $result_check = $this->conn->query($sql_check_table);
            $columns = [];
            while ($row = $result_check->fetch_assoc()) {
                $columns[] = $row['Field'];
            }

            // Buat query berdasarkan struktur tabel yang ada
            if (in_array('pesan', $columns)) {
                $sql_notifikasi = "INSERT INTO notifikasi (kode_pesanan, pesan) VALUES (?, ?)";
                $stmt_notif = $this->conn->prepare($sql_notifikasi);
                if ($stmt_notif) {
                    $stmt_notif->bind_param("ss", $kode_pesanan, $pesan_notifikasi);
                    $stmt_notif->execute();
                    $stmt_notif->close();
                } else {
                    error_log("Error preparing notification statement: " . $this->conn->error);
                }
            } else {
                $sql_notifikasi = "INSERT INTO notifikasi (kode_pesanan, nama_produk, harga, kuantitas)
                                  SELECT ?, 'Request Aktivasi', 0, 1";
                $stmt_notif = $this->conn->prepare($sql_notifikasi);
                if ($stmt_notif) {
                    $stmt_notif->bind_param("s", $kode_pesanan);
                    $stmt_notif->execute();
                    $stmt_notif->close();
                } else {
                    error_log("Error preparing notification statement: " . $this->conn->error);
                }
            }
        }

        return $result;
    }
}
?>
