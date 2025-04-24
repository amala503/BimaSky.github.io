<?php

class Product {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getAllProducts() {
        // Query disesuaikan dengan nama tabel "produk"
        $query = "SELECT * FROM produk";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
