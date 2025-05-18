<?php
class Home {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mendapatkan produk terbaru untuk ditampilkan di halaman home
     * 
     * @param int $limit Jumlah produk yang akan ditampilkan
     * @return array Array produk
     */
    public function getFeaturedProducts($limit = 3) {
        $query = "SELECT id, nama_produk, detail, gambar_produk, harga FROM produk LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        $stmt->close();
        return $products;
    }

    /**
     * Mendapatkan promo terbaru untuk ditampilkan di halaman home
     * 
     * @param int $limit Jumlah promo yang akan ditampilkan
     * @return array Array promo
     */
    public function getLatestPromos($limit = 3) {
        $query = "SELECT * FROM promo LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $promos = [];
        while ($row = $result->fetch_assoc()) {
            $promos[] = $row;
        }
        
        $stmt->close();
        return $promos;
    }

}
?>
