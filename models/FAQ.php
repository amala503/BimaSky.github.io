<?php
class FAQ {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mendapatkan semua FAQ
     *
     * @return array Array FAQ
     */
    public function getAllFAQs() {
        $query = "SELECT * FROM faq ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $faqs = [];
        while ($row = $result->fetch_assoc()) {
            $faqs[] = $row;
        }

        $stmt->close();
        return $faqs;
    }

    /**
     * Mendapatkan FAQ berdasarkan kategori
     *
     * @param string $category Kategori FAQ
     * @return array Array FAQ
     */
    public function getFAQsByCategory($category) {
        // Karena kolom kategori tidak ada, kita kembalikan semua FAQ
        return $this->getAllFAQs();
    }

    /**
     * Mendapatkan semua kategori FAQ
     *
     * @return array Array kategori
     */
    public function getAllCategories() {
        // Karena kolom kategori tidak ada, kita kembalikan array kosong
        return [];
    }

    /**
     * Mencari FAQ berdasarkan kata kunci
     *
     * @param string $keyword Kata kunci pencarian
     * @return array Array FAQ
     */
    public function searchFAQs($keyword) {
        $keyword = "%$keyword%";
        $query = "SELECT * FROM faq WHERE pertanyaan LIKE ? OR jawaban LIKE ? ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        $faqs = [];
        while ($row = $result->fetch_assoc()) {
            $faqs[] = $row;
        }

        $stmt->close();
        return $faqs;
    }
}
?>
