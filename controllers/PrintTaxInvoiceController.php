<?php
require_once __DIR__ . '/../models/PrintTaxInvoice.php';
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/phpqrcode/qrlib.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class PrintTaxInvoiceController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new PrintTaxInvoice($this->conn);
    }

    /**
     * Mencetak faktur pajak
     */
    public function printTaxInvoice() {
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
        
        // Generate QR code
        $qrCodeData = $this->generateQRCode($kode_pesanan);
        
        // Generate HTML untuk PDF
        $html = $this->model->generateTaxInvoiceHTML($order, $qrCodeData);
        
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
        $dompdf->stream("tax_invoice_" . $kode_pesanan . ".pdf", [
            "Attachment" => true
        ]);
        
        exit();
    }

    /**
     * Menghasilkan QR code untuk faktur pajak
     * 
     * @param string $kode_pesanan Kode pesanan
     * @return string Data QR code dalam format base64
     */
    private function generateQRCode($kode_pesanan) {
        ob_start();
        \QRcode::png($kode_pesanan, null, QR_ECLEVEL_L, 4);
        $qrCodeData = base64_encode(ob_get_clean());
        
        return $qrCodeData;
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
