<?php
class detail
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getPendingOrders($pelanggan_id)
    {
        $query = "SELECT * FROM detail_pesanan WHERE pelanggan_id = ? AND status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $pelanggan_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function deleteOrderItem($detail_id, $pelanggan_id)
    {
        $query = "DELETE FROM detail_pesanan WHERE id = ? AND pelanggan_id = ? AND status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $detail_id, $pelanggan_id);
        return $stmt->execute();
    }

    public function confirmOrders($pelanggan_id)
    {
        $query = "UPDATE detail_pesanan SET status = 'confirmed' WHERE pelanggan_id = ? AND status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $pelanggan_id);
        return $stmt->execute();
    }
}
?>
