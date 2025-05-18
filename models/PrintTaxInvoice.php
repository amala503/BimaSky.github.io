<?php
class PrintTaxInvoice {
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
        $sql = "SELECT p.*, pl.nama_perusahaan, pl.alamat_perusahaan, pl.pic_perusahaan, pl.nomor_npwp,
                dp.nama_produk, dp.kuantitas, dp.harga
                FROM pesanan p 
                LEFT JOIN pelanggan pl ON p.pelanggan_id = pl.id
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
     * Menghasilkan HTML untuk PDF faktur pajak
     * 
     * @param array $order Data pesanan
     * @param string $qrCodeData Data QR code dalam format base64
     * @return string HTML untuk PDF
     */
    public function generateTaxInvoiceHTML($order, $qrCodeData) {
        // Format tanggal
        $order_date = date('d F Y', strtotime($order['tanggal_pesanan']));
        
        // Generate HTML
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Faktur Pajak</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                .invoice-box { width: 100%; border: 1px solid #000; }
                .header { text-align: center; font-size: 18px; font-weight: bold; padding: 10px; border-bottom: 1px solid #000; }
                .section { padding: 10px; border-bottom: 1px solid #000; }
                .grid-container { display: grid; grid-template-columns: 1fr; gap: 10px; }
                .company-info { margin-bottom: 10px; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                th, td { padding: 8px; border: 1px solid #000; }
                .text-right { text-align: right; }
                .qr-code { text-align: center; margin-top: 20px; }
                .section:last-child {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 20px;
                    padding: 20px;
                    align-items: center;
                }
                .qr-code {
                    text-align: left;
                    margin: 10px;
                }
                .footer {
                    text-align: right;
                    margin-right: 20px;
                }
                .signature-text {
                    margin-bottom: 50px;
                }
                .signature-line {
                    border-bottom: 1px solid #000;
                    width: 200px;
                    margin-left: auto; 
                    margin-right: 30px;
                }
                .signature-name {
                    margin-top: 5px;
                    margin-right: 110px;
                }
            </style>
        </head>
        <body>
            <div class="invoice-box">
                <div class="header">Faktur Pajak</div>
                <div class="section">
                    <div>Kode dan Nomor Seri Faktur Pajak: ' . htmlspecialchars($order["kode_pesanan"]) . '</div>
                </div>
                <div class="section">
                    <div class="grid-container">
                        <div class="company-info">
                            <strong>Pengusaha Kena Pajak</strong><br>
                            Nama: PT. TELKOM SATELIT INDONESIA<br>
                            Alamat: Jl. Telekomunikasi No. 1, Dayeuhkolot, Bandung<br>
                            NPWP: 01.106.112.0-093.000<br>
                            NPPKP: 01.106.112.0-093.000
                        </div>
                        <div class="company-info">
                            <strong>Pembeli Barang Kena Pajak / Penerima Jasa Kena Pajak</strong><br>
                            Nama: ' . htmlspecialchars($order["nama_perusahaan"]) . '<br>
                            Alamat: ' . htmlspecialchars($order["alamat_perusahaan"]) . '<br>
                            NPWP: ' . htmlspecialchars($order["nomor_npwp"]) . '
                        </div>
                    </div>
                </div>
                <div class="section">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Barang / Jasa</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Harga Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>' . htmlspecialchars($order["nama_produk"]) . '</td>
                                <td class="text-right">Rp ' . number_format($order["harga"], 0, ',', '.') . '</td>
                                <td class="text-right">' . htmlspecialchars($order["kuantitas"]) . '</td>
                                <td class="text-right">Rp ' . number_format($order["harga"] * $order["kuantitas"], 0, ',', '.') . '</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Harga Jual/Penggantian</td>
                                <td class="text-right">Rp ' . number_format($order["harga"] * $order["kuantitas"], 0, ',', '.') . '</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Dikurangi Potongan Harga</td>
                                <td class="text-right">Rp 0</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Dikurangi Uang Muka</td>
                                <td class="text-right">Rp 0</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Dasar Pengenaan Pajak</td>
                                <td class="text-right">Rp ' . number_format($order["harga"] * $order["kuantitas"], 0, ',', '.') . '</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">PPN = 11% x Dasar Pengenaan Pajak</td>
                                <td class="text-right">Rp ' . number_format($order["harga"] * $order["kuantitas"] * 0.11, 0, ',', '.') . '</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Total PPnBM</td>
                                <td class="text-right">Rp 0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="section">
                    <div class="footer">
                        <div class="signature-text">Bandung, ' . $order_date . '</div>
                        <div class="signature-line">_________________________</div>
                    </div>
                    <div class="qr-code">
                        <img src="data:image/png;base64,' . $qrCodeData . '" style="width: 100px; height: 100px;"/>
                        <div>SBS-9999-123_PT. RAJAWALI PRIMA MANUFACTURING</div>
                    </div>
                </div>
            </div>
        </body>
        </html>';
        
        return $html;
    }
}
?>
