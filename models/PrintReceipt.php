<?php
class PrintReceipt {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mendapatkan data pesanan berdasarkan kode pesanan dan ID pelanggan
     * 
     * @param string $kode_pesanan Kode pesanan
     * @param int $user_id ID pelanggan
     * @return array|false Data pesanan atau false jika tidak ditemukan
     */
    public function getOrderData($kode_pesanan, $user_id) {
        $sql = "SELECT p.*, pl.nama_perusahaan, pl.pic_perusahaan, a.detail_alamat, dp.nama_produk, dp.kuantitas, dp.harga
                FROM pesanan p 
                LEFT JOIN pelanggan pl ON p.pelanggan_id = pl.id
                LEFT JOIN alamat_perusahaan a ON a.pelanggan_id = p.pelanggan_id
                LEFT JOIN detail_pesanan dp ON dp.pelanggan_id = p.pelanggan_id
                WHERE p.kode_pesanan = ? AND p.pelanggan_id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param("si", $kode_pesanan, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        
        return $order;
    }

    /**
     * Menghasilkan HTML untuk PDF tanda terima
     * 
     * @param array $order Data pesanan
     * @return string HTML untuk PDF
     */
    public function generateReceiptHTML($order) {
        // Format tanggal
        $order_date = date('d F Y', strtotime($order['tanggal_pesanan']));
        
        // Hitung total
        $subtotal = $order['kuantitas'] * $order['harga'];
        $ppn = $subtotal * 0.11;
        $total = $subtotal + $ppn;
        
        // Generate HTML
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Tanda Terima</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                }
                .receipt-content {
                    max-width: 800px;
                    margin: 0 auto;
                    border: 1px solid #ddd;
                    padding: 20px;
                }
                .receipt-header {
                    text-align: center;
                    margin-bottom: 20px;
                    border-bottom: 2px solid #ddd;
                    padding-bottom: 10px;
                }
                .receipt-header h2 {
                    margin: 0;
                    color: #333;
                }
                .receipt-body {
                    margin-bottom: 20px;
                }
                .receipt-info {
                    margin-bottom: 20px;
                }
                .receipt-info p {
                    margin: 5px 0;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                table, th, td {
                    border: 1px solid #ddd;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .total-section {
                    margin-top: 20px;
                    text-align: right;
                }
                .signature-section {
                    margin-top: 50px;
                    display: flex;
                    justify-content: space-between;
                }
                .signature-box {
                    width: 45%;
                    text-align: center;
                }
                .signature-line {
                    margin-top: 50px;
                    border-top: 1px solid #000;
                }
                @media print {
                    .no-print {
                        display: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="receipt-content">
                <div class="receipt-header">
                    <h2>TANDA TERIMA</h2>
                    <p>BimaSky</p>
                    <p>Solusi Konektivitas Satelit Anda</p>
                </div>
                
                <div class="receipt-body">
                    <div class="receipt-info">
                        <p><strong>Kode Pesanan:</strong> ' . $order['kode_pesanan'] . '</p>
                        <p><strong>Tanggal:</strong> ' . $order_date . '</p>
                        <p><strong>Pelanggan:</strong> ' . $order['nama_perusahaan'] . '</p>
                        <p><strong>PIC:</strong> ' . $order['pic_perusahaan'] . '</p>
                        <p><strong>Alamat:</strong> ' . $order['detail_alamat'] . '</p>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>' . $order['nama_produk'] . '</td>
                                <td>' . $order['kuantitas'] . '</td>
                                <td>Rp ' . number_format($order['harga'], 0, ',', '.') . '</td>
                                <td>Rp ' . number_format($subtotal, 0, ',', '.') . '</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="total-section">
                        <p><strong>Subtotal:</strong> Rp ' . number_format($subtotal, 0, ',', '.') . '</p>
                        <p><strong>PPN (11%):</strong> Rp ' . number_format($ppn, 0, ',', '.') . '</p>
                        <p><strong>Total:</strong> Rp ' . number_format($total, 0, ',', '.') . '</p>
                    </div>
                </div>
                
                <div class="signature-section">
                    <div class="signature-box">
                        <p>Penerima</p>
                        <div class="signature-line"></div>
                        <p>' . $order['pic_perusahaan'] . '</p>
                    </div>
                    <div class="signature-box">
                        <p>Hormat Kami</p>
                        <div class="signature-line"></div>
                        <p>BimaSky</p>
                    </div>
                </div>
            </div>
        </body>
        </html>';
        
        return $html;
    }
}
?>
