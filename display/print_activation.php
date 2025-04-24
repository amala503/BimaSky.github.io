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

if (isset($_GET['kode'])) {
    $kode_pesanan = $_GET['kode'];
    $user_id = $_SESSION['user_id'];
    
    // Get order and customer details
    $sql = "SELECT p.*, pl.nama_perusahaan, pic.nama_pic, a.detail_alamat, dp.nama_produk, dp.kuantitas
            FROM pesanan p 
            LEFT JOIN pelanggan pl ON p.pelanggan_id = pl.id
            LEFT JOIN pic_perusahaan pic ON pic.pelanggan_id = p.pelanggan_id
            LEFT JOIN alamat_perusahaan a ON a.pelanggan_id = p.pelanggan_id
            LEFT JOIN detail_pesanan dp ON dp.pelanggan_id = p.pelanggan_id
            WHERE p.kode_pesanan = ? AND p.pelanggan_id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $kode_pesanan, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();

        if ($order) {
            // Generate unique activation code
            $activation_code = date('Y') . 'BAA/SD/' . date('m/Y');

            // Create PDF
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);

            $dompdf = new Dompdf($options);

            // Get the HTML content
            ob_start();
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Surat Pernyataan Aktivasi Layanan</title>
                <style>
body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.2; }
.header { display: flex; align-items: center; margin-bottom: 10px; }
.title { text-align: center; font-weight: bold; margin-bottom: 15px; }
.content { margin: 10px 0; }
.signature { margin-top: 30px; text-align: right; }
table { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 12px; }
th, td { padding: 4px; text-align: left; }
                </style>
            </head>
            <body>
                <table style="width: 100%; border: 1px solid black; margin-bottom: 20px;">
                    <tr>
                        <td style="width: 30%; padding: 10px;">
                            <img src="../assets/satelit.jpg" style="width: 100px;">
                        </td>
                        <td style="width: 70%; text-align: center; padding: 10px;">
                            <h2 style="margin: 0;">Surat Pernyataan Aktivasi<br>Layanan BimaSky</h2>
                            <div style="margin-top: 5px;"><?php echo $activation_code; ?></div>
                        </td>
                    </tr>
                </table>

                <div class="content">
                    <p><strong>DATA PELANGGAN</strong></p>
                    <table>
                        <tr>
                            <td>Nama Pelanggan</td>
                            <td>: <?php echo htmlspecialchars($order['nama_perusahaan']); ?></td>
                        </tr>
                        <tr>
                            <td>PIC</td>
                            <td>: <?php echo htmlspecialchars($order['nama_pic']); ?></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>: General Manager / <?php echo htmlspecialchars($order['nama_pic']); ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: <?php echo htmlspecialchars($order['detail_alamat']); ?></td>
                        </tr>
                    </table>

                    <p><strong>LAYANAN</strong></p>
                    <table>
                        <tr>
                            <td>Jenis Pelanggan</td>
                            <td>: AKTIVA B2</td>
                        </tr>
                        <tr>
                            <td>Jenis Layanan</td>
                            <td>: SkyNet ProSat 5000 - Priority</td>
                        </tr>
                        <tr>
                            <td>ServicePlan</td>
                            <td>: Data Plan 1TB-Fixed per bulan</td>
                        </tr>
                        <tr>
                            <td>KIT Serial Number</td>
                            <td>: KITP00225041</td>
                        </tr>
                    </table>

                    <p><strong>PERNYATAAN</strong></p>
                    <p>Layanan akan selesai diaktivasi dan dapat digunakan oleh pelanggan pada tanggal aktivasi. Biaya layanan akan dihitung mulai Tanggal Aktivasi ini.</p>

                    <div class="signature">
                        <p>Depok, <?php echo date('d F Y'); ?></p>
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 50%; text-align: center;">
                                    <p><strong>PENYEDIA</strong></p>
                                    <p>PT. SKYLINK INDONESIA</p>
                                    <br><br><br>
                                    <p><strong>Rizky Pratama</strong></p>
                                    <p>Manager Service Activation</p>
                                </td>
                                <td style="width: 50%; text-align: center;">
                                    <p><strong>PELANGGAN</strong></p>
                                    <br><br><br><br>
                                    <p><strong>Nama pelanggan</strong></p>
                                    <p>General Manager</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </body>
            </html>
            <?php
            $html = ob_get_clean();

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4');
            $dompdf->render();

            // Output PDF untuk langsung diunduh
            $filename = "Surat_Aktivasi_" . $kode_pesanan . ".pdf";
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . strlen($dompdf->output()));

            echo $dompdf->output();
            exit();
        } else {
            echo "Order tidak ditemukan atau akses ditolak.";
        }
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}

$conn->close();
?>
