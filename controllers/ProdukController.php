<?php
require_once __DIR__ . '/../models/Produk.php';
require_once __DIR__ . '/../config/db_connection.php';

class ProdukController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new Produk($this->conn);
    }

    public function index() {
        // Mendapatkan semua produk
        $products = $this->model->getAllProducts();

        // Menampilkan view
        require_once __DIR__ . '/../views/produk_view.php';
    }

    public function detail() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: login.php');
            exit();
        }

        // Ambil ID dari URL
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Mendapatkan detail produk
        $product = $this->model->getProductById($id);

        if (!$product) {
            // Redirect ke halaman produk jika produk tidak ditemukan
            header('Location: produk.php');
            exit();
        }

        // Proses form pemesanan jika disubmit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processOrder($product);
        }

        // Menampilkan view
        require_once __DIR__ . '/../views/detail_produk_view.php';
    }

    private function processOrder($product) {
        try {
            // Siapkan data
            $kuantitas = intval($_POST['kuantitas']);
            $userId = $_SESSION['user_id'];

            // Tambahkan produk ke keranjang
            if ($this->model->addToCart($product['id'], $kuantitas, $userId)) {
                // Redirect ke halaman detail order
                header("Location: detail.order.php");
                exit();
            } else {
                throw new Exception("Gagal menambahkan produk ke keranjang.");
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function addToCart() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = 'produk.php';
            header('Location: login.php');
            exit();
        }

        // Cek apakah form sudah disubmit
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $userId = $_SESSION['user_id'];

            // Tambahkan produk ke keranjang
            if ($this->model->addToCart($productId, $quantity, $userId)) {
                $_SESSION['success'] = 'Produk berhasil ditambahkan ke keranjang.';
            } else {
                $_SESSION['error'] = 'Gagal menambahkan produk ke keranjang.';
            }

            // Redirect ke halaman produk
            header('Location: produk.php');
            exit();
        }
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
