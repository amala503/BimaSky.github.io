<?php
require_once __DIR__ . '/../models/DetailOrder.php';
require_once __DIR__ . '/../config/db_connection.php';

class DetailOrderController {
    private $model;
    private $metodePengiriman;
    private $metodePembayaran;

    public function __construct() {
        $db = Database::getConnection();
        $this->model = new DetailOrder($db);
        
        $this->metodePengiriman = [
            'Standard' => 5000,
            'Express' => 10000,
            // 'Same Day' => 20000
        ];
        
        $this->metodePembayaran = ['Transfer Bank / 21354687269'];
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }

        $pelanggan_id = $_SESSION['user_id'];
        $orderDetails = $this->model->getPendingOrders($pelanggan_id);
        
        $data = [
            'produkList' => $orderDetails['items'],
            'totalHarga' => $orderDetails['totalHarga'],
            'pajak' => $orderDetails['totalHarga'] * 0.11,
            'metodePengiriman' => $this->metodePengiriman,
            'metodePembayaran' => $this->metodePembayaran
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_item'])) {
                $this->deleteItem($_POST['detail_id'], $pelanggan_id);
            } elseif (isset($_POST['konfirmasi'])) {
                $this->processOrder($_POST, $_FILES);
            }
        }

        require_once __DIR__ . '/../views/detail_order_view.php';
    }

    private function deleteItem($detail_id, $pelanggan_id) {
        if ($this->model->deleteOrderItem($detail_id, $pelanggan_id)) {
            header('Location: detail.order.php');
            exit();
        }
        echo "<script>alert('Error: Gagal menghapus item.');</script>";
    }

    private function processOrder($postData, $files) {
        try {
            $result = $this->model->processOrder($postData, $files);
            if ($result['success']) {
                echo "<script>
                    alert('Pesanan berhasil dikonfirmasi!\\nKode Pesanan: " . $result['kode_pesanan'] . "');
                    window.location.href='tracking.order.php';
                </script>";
                exit();
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . htmlspecialchars($e->getMessage()) . "');</script>";
        }
    }
}



