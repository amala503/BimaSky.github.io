<?php
require_once __DIR__ . '/../models/PrintReceipt.php';
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class PrintReceiptController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new PrintReceipt($this->conn);
    }

    /**
     * Mencetak tanda terima
     */
    public function printReceipt() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            echo "Anda harus login terlebih dahulu.";
            return;
        }

        // Cek apakah ada parameter kode pesanan
        if (!isset($_GET['kode'])) {
            echo "Kode pesanan tidak ditemukan.";
            return;
        }

        $kode_pesanan = $_GET['kode'];
        $user_id = $_SESSION['user_id'];
        
        // Ambil data pesanan
        $order = $this->model->getOrderData($kode_pesanan, $user_id);
        
        if (!$order) {
            echo "Data pesanan tidak ditemukan.";
            return;
        }
        
        // Cek apakah request untuk download PDF
        if (isset($_GET['download_pdf']) && $_GET['download_pdf'] == 1) {
            $this->generatePDF($order);
        } else {
            // Tampilkan view
            require_once __DIR__ . '/../views/print_receipt_view.php';
        }
    }

    /**
     * Menghasilkan PDF tanda terima
     * 
     * @param array $order Data pesanan
     */
    private function generatePDF($order) {
        // Generate HTML untuk PDF
        $html = $this->model->generateReceiptHTML($order);
        
        // Konfigurasi DOMPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        // Inisialisasi DOMPDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream("receipt_" . $order['kode_pesanan'] . ".pdf", [
            "Attachment" => true
        ]);
        
        exit();
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
