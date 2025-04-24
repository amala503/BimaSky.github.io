<?php
class TrackingOrder {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getOrdersByUserId($user_id) {
        $sql = "SELECT p.*, pl.nama_perusahaan as nama_pelanggan 
                FROM pesanan p 
                LEFT JOIN pelanggan pl ON p.pelanggan_id = pl.id 
                WHERE p.pelanggan_id = ?
                ORDER BY p.tanggal_pesanan DESC";
    
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $orders = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $orders;
        }
        return [];
    }
}
?>
