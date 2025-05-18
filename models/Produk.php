<?php
class Produk {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mendapatkan semua produk
     * 
     * @return array Array produk
     */
    public function getAllProducts() {
        $query = "SELECT id, nama_produk, detail, gambar_produk, harga FROM produk WHERE id >= 12";
        $stmt = $this->conn->prepare($query);
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
     * Mendapatkan detail produk berdasarkan ID
     * 
     * @param int $id ID produk
     * @return array|null Detail produk atau null jika tidak ditemukan
     */
    public function getProductById($id) {
        $query = "SELECT * FROM produk WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $stmt->close();
            return $product;
        }
        
        $stmt->close();
        return null;
    }

    /**
     * Menambahkan produk ke keranjang belanja
     * 
     * @param int $productId ID produk
     * @param int $quantity Jumlah produk
     * @param int $userId ID pengguna
     * @return bool True jika berhasil, false jika gagal
     */
    public function addToCart($productId, $quantity, $userId) {
        // Ambil data produk
        $product = $this->getProductById($productId);
        if (!$product) {
            return false;
        }

        // Cek apakah produk sudah ada di keranjang
        $checkQuery = "SELECT id, kuantitas FROM detail_pesanan 
                      WHERE pelanggan_id = ? AND nama_produk = ? AND status = 'pending'";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bind_param("is", $userId, $product['nama_produk']);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Update kuantitas jika produk sudah ada di keranjang
            $cartItem = $checkResult->fetch_assoc();
            $newQuantity = $cartItem['kuantitas'] + $quantity;
            
            $updateQuery = "UPDATE detail_pesanan SET kuantitas = ? WHERE id = ?";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $newQuantity, $cartItem['id']);
            $result = $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Tambahkan produk baru ke keranjang
            $insertQuery = "INSERT INTO detail_pesanan (kuantitas, harga, nama_produk, pelanggan_id, status) 
                           VALUES (?, ?, ?, ?, 'pending')";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bind_param("idsi", $quantity, $product['harga'], $product['nama_produk'], $userId);
            $result = $insertStmt->execute();
            $insertStmt->close();
        }

        $checkStmt->close();
        return $result;
    }
}
?>
