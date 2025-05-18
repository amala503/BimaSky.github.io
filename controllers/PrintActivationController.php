<?php
require_once __DIR__ . '/../models/PrintActivation.php';
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class PrintActivationController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new PrintActivation($this->conn);
    }

    /**
     * Mencetak surat aktivasi
     */
    public function printActivation() {
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
        
        // Generate HTML untuk PDF
        $html = $this->model->generateActivationHTML($order);
        
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
        $dompdf->stream("activation_letter_" . $kode_pesanan . ".pdf", [
            "Attachment" => false
        ]);
        
        exit();
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
