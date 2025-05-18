<?php
class PrintActivation {
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
        $sql = "SELECT p.*, pl.nama_perusahaan, pic.nama_pic, a.detail_alamat, dp.nama_produk, dp.kuantitas
                FROM pesanan p 
                LEFT JOIN pelanggan pl ON p.pelanggan_id = pl.id
                LEFT JOIN pic_perusahaan pic ON pic.pelanggan_id = p.pelanggan_id
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
     * Menghasilkan HTML untuk PDF aktivasi
     * 
     * @param array $order Data pesanan
     * @return string HTML untuk PDF
     */
    public function generateActivationHTML($order) {
        // Format tanggal
        $order_date = date('d F Y', strtotime($order['tanggal_pesanan']));
        
        // Generate HTML
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Activation Letter</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                }
                .logo {
                    max-width: 200px;
                    margin-bottom: 10px;
                }
                h1 {
                    color: #0056b3;
                    margin: 5px 0;
                }
                .content {
                    margin-bottom: 30px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
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
                .footer {
                    margin-top: 50px;
                    text-align: center;
                    font-size: 12px;
                    color: #666;
                }
                .signature {
                    margin-top: 50px;
                }
                .signature-line {
                    border-top: 1px solid #000;
                    width: 200px;
                    margin-top: 70px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <img src="https://telkomsat.co.id/wp-content/uploads/2019/07/telkomsat-logo.png" alt="Telkomsat Logo" class="logo">
                <h1>ACTIVATION LETTER</h1>
                <p>Order Reference: ' . $order['kode_pesanan'] . '</p>
            </div>
            
            <div class="content">
                <p>This letter confirms that the following service has been activated:</p>
                
                <table>
                    <tr>
                        <th>Customer Information</th>
                        <th>Details</th>
                    </tr>
                    <tr>
                        <td>Company Name</td>
                        <td>' . $order['nama_perusahaan'] . '</td>
                    </tr>
                    <tr>
                        <td>Contact Person</td>
                        <td>' . $order['nama_pic'] . '</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>' . $order['detail_alamat'] . '</td>
                    </tr>
                </table>
                
                <table>
                    <tr>
                        <th>Service Information</th>
                        <th>Details</th>
                    </tr>
                    <tr>
                        <td>Product Name</td>
                        <td>' . $order['nama_produk'] . '</td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td>' . $order['kuantitas'] . '</td>
                    </tr>
                    <tr>
                        <td>Activation Date</td>
                        <td>' . $order_date . '</td>
                    </tr>
                </table>
                
                <p>This service is now active and ready for use. If you have any questions or need assistance, please contact our customer support team.</p>
            </div>
            
            <div class="signature">
                <p>Authorized by:</p>
                <div class="signature-line"></div>
                <p>Telkomsat Representative</p>
            </div>
            
            <div class="footer">
                <p>This is an automatically generated document. No signature is required.</p>
                <p>© ' . date('Y') . ' Telkomsat. All rights reserved.</p>
            </div>
        </body>
        </html>';
        
        return $html;
    }
}
?>
