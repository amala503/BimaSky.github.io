<?php
require_once 'check_login.php';
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtptelkomsat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order details
if (isset($_GET['kode'])) {
    $kode_pesanan = $_GET['kode'];
    $user_id = $_SESSION['user_id'];
    
    // Get order and customer details with product information
    $sql = "SELECT p.*, pl.jenis_bisnis, pl.kategori_bisnis, pl.nama_perusahaan, pl.nomor_npwp,
            pl.no_telepon, pl.email_perusahaan, ap.detail_alamat, pic.nama_pic,
            dp.nama_produk, dp.kuantitas, dp.harga
            FROM pesanan p 
            LEFT JOIN pelanggan pl ON p.pelanggan_id = pl.id
            LEFT JOIN alamat_perusahaan ap ON ap.pelanggan_id = p.pelanggan_id
            LEFT JOIN pic_perusahaan pic ON pic.pelanggan_id = p.pelanggan_id
            LEFT JOIN detail_pesanan dp ON dp.pelanggan_id = p.pelanggan_id
            WHERE p.kode_pesanan = ? AND p.pelanggan_id = ?";
            
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $kode_pesanan, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}

// Check if PDF download is requested
if (isset($_GET['download_pdf'])) {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);

    $dompdf = new Dompdf($options);
    
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tanda Terima - <?php echo htmlspecialchars($order['kode_pesanan']); ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            line-height: 1.4;
            color: #333;
            margin: 0;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a73e8;
            padding-bottom: 10px;
        }
        .receipt-header h2 {
            color: #1a73e8;
            font-size: 28px;
            margin: 0 0 10px 0;
        }
        .receipt-header p {
            font-size: 16px;
            color: #666;
            margin: 0;
        }
        .receipt-details {
            margin-bottom: 15px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
        .receipt-details p {
            margin: 3px 0;
            line-height: 1.3;
        }
        .receipt-details strong {
            color: #1a73e8;
        }
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            font-size: 15px;
        }
        .receipt-table th {
            background-color: #1a73e8;
            color: white;
            padding: 12px;
            font-weight: 500;
        }
        .receipt-table td {
            padding: 8px;
            border: 1px solid #e0e0e0;
        }
        .receipt-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .receipt-table tr:last-child {
            font-weight: bold;
            background-color: #e8f0fe;
        }
        .receipt-footer {
            margin-top: 20px;
            text-align: right;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
        }
        .receipt-footer p {
            margin: 5px 0;
        }
        .company-info {
            margin-bottom: 10px;
        }
        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php if (isset($order)): ?>
        <div class="receipt-content">
            <div class="receipt-header">
                <h2>TANDA TERIMA</h2>
                <p>BimaSky</p>
                <p>Solusi Konektivitas Satelit Anda</p>
            </div>

            <div class="receipt-details">
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <p><strong>Nomor Pesanan:</strong> <?php echo htmlspecialchars($order['kode_pesanan']); ?></p>
                            <p><strong>Tanggal:</strong> <?php echo date('d F Y H:i', strtotime($order['tanggal_pesanan'])); ?></p>
                            <p><strong>Kepada:</strong></p>
                            <p><strong>Jenis Bisnis:</strong> <?php echo htmlspecialchars($order['jenis_bisnis']); ?></p>
                            <p><strong>Kategori Bisnis:</strong> <?php echo htmlspecialchars($order['kategori_bisnis']); ?></p>
                            <p><strong>NPWP:</strong> <?php echo htmlspecialchars($order['nomor_npwp']); ?></p>
                            <p><strong>Perusahaan:</strong> <?php echo htmlspecialchars($order['nama_perusahaan']); ?></p>
                            <p><strong>PIC:</strong> <?php echo htmlspecialchars($order['nama_pic']); ?></p>
                            <p><strong>Alamat:</strong> <?php echo htmlspecialchars($order['detail_alamat']); ?></p>
                        </td>
                    </tr>
                </table>
            </div>

            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kuantitas</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($order['nama_produk']); ?></td>
                        <td><?php echo htmlspecialchars($order['kuantitas']); ?></td>
                        <td>Rp <?php echo number_format($order['harga'], 0, ',', '.'); ?></td>
                        <td>Rp <?php echo number_format($order['total_harga_produk'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Pajak (11%):</strong></td>
                        <td>Rp <?php echo number_format($order['pajak'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Biaya Pengiriman:</strong></td>
                        <td>Rp <?php echo number_format($order['biaya_pengiriman'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td><strong>Rp <?php echo number_format($order['total_harga_akhir'], 0, ',', '.'); ?></strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="receipt-footer">
                <p>Diterima oleh:</p>
                <br><br><br>

                <p><?php echo htmlspecialchars($order['nama_perusahaan']); ?></p>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
<?php
    $html = ob_get_clean();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream("tanda_terima_" . $order['kode_pesanan'] . ".pdf", array("Attachment" => true));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima - <?php echo htmlspecialchars($order['kode_pesanan']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 40px;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a73e8;
            padding-bottom: 10px;
        }
        .receipt-header h2 {
            color: #1a73e8;
            font-size: 28px;
            margin: 0 0 10px 0;
        }
        .receipt-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .table {
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .table thead th {
            background-color: #1a73e8;
            color: white;
            font-weight: 500;
            border: none;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .table tbody tr:last-child {
            font-weight: bold;
            background-color: #e8f0fe;
        }
        .receipt-footer {
            margin-top: 20px;
            text-align: right;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
        }
        @media print {
            body {
                background-color: white;
            }
            .container {
                box-shadow: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <?php if (isset($order)): ?>
            <div class="receipt-content">
                <div class="receipt-header">
                    <h2>TANDA TERIMA</h2>
                    <p>BimaSky</p>
                <p>Solusi Konektivitas Satelit Anda</p>
                </div>

                <div class="receipt-details">
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Nomor Pesanan:</strong> <?php echo htmlspecialchars($order['kode_pesanan']); ?></p>
                            <p><strong>Tanggal:</strong> <?php echo date('d F Y H:i', strtotime($order['tanggal_pesanan'])); ?></p>
                        </div>
                        <div class="col-6">
                            <p><strong>Kepada:</strong></p>
                            <p><strong>Perusahaan:</strong> <?php echo htmlspecialchars($order['nama_perusahaan']); ?></p>
                            <p><strong>PIC:</strong> <?php echo htmlspecialchars($order['nama_pic']); ?></p>
                            <p><strong>Alamat:</strong> <?php echo htmlspecialchars($order['detail_alamat']); ?></p>
                        </div>
                    </div>
                </div>

                <table class="table receipt-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kuantitas</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($order['nama_produk']); ?></td>
                            <td><?php echo htmlspecialchars($order['kuantitas']); ?></td>
                            <td>Rp <?php echo number_format($order['harga'], 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($order['total_harga_produk'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Pajak (11%):</strong></td>
                            <td>Rp <?php echo number_format($order['pajak'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Biaya Pengiriman:</strong></td>
                            <td>Rp <?php echo number_format($order['biaya_pengiriman'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>Rp <?php echo number_format($order['total_harga_akhir'], 0, ',', '.'); ?></strong></td>
                        </tr>
                    </tbody>
                </table>

                <div class="receipt-footer">
                    <p>Diterima oleh:</p>
                    <br><br><br>
                    <p><?php echo htmlspecialchars($order['nama_perusahaan']); ?></p>
                </div>

                <div class="no-print text-center mt-4 mb-4">
                    <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Cetak Tanda Terima</button>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?kode=<?php echo urlencode($order['kode_pesanan']); ?>&download_pdf=1" class="btn btn-success">Unduh PDF</a>
                    <a href="track.detail.php?kode=<?php echo urlencode($order['kode_pesanan']); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                Pesanan tidak ditemukan atau Anda tidak memiliki akses ke pesanan ini.
            </div>
            <a href="tracking.order.php" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>