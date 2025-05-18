<?php
class Promo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mendapatkan semua promo
     * 
     * @return array Array promo
     */
    public function getAllPromos() {
        $query = "SELECT * FROM promo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $promos = [];
        while ($row = $result->fetch_assoc()) {
            $promos[] = $row;
        }
        
        $stmt->close();
        return $promos;
    }

    /**
     * Mendapatkan detail promo berdasarkan ID
     * 
     * @param int $id ID promo
     * @return array|null Detail promo atau null jika tidak ditemukan
     */
    public function getPromoById($id) {
        $query = "SELECT * FROM promo WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $promo = $result->fetch_assoc();
            $stmt->close();
            return $promo;
        }
        
        $stmt->close();
        return null;
    }

    /**
     * Mendapatkan produk yang terkait dengan promo
     * 
     * @param int $promoId ID promo
     * @return array Array produk
     */
    public function getPromoProducts($promoId) {
        $query = "SELECT p.* FROM produk p 
                  JOIN promo_produk pp ON p.id = pp.produk_id 
                  WHERE pp.promo_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $promoId);
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
     * Mendapatkan promo terbaru
     * 
     * @param int $limit Jumlah promo yang akan ditampilkan
     * @return array Array promo
     */
    public function getLatestPromos($limit = 3) {
        $query = "SELECT * FROM promo ORDER BY id DESC LIMIT ?";
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

    /**
     * Mendapatkan promo yang masih aktif
     * 
     * @return array Array promo
     */
    public function getActivePromos() {
        $currentDate = date('Y-m-d');
        $query = "SELECT * FROM promo WHERE start_date <= ? AND end_date >= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $currentDate, $currentDate);
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
