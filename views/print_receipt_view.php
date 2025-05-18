<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima - SkyLink Market</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .receipt-content {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .receipt-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }
        .receipt-info {
            margin-bottom: 20px;
        }
        .receipt-info p {
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
            font-size: 1.1em;
        }
        .total-section p:last-child {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.2em;
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
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #fff;
            }
            .receipt-content {
                box-shadow: none;
                max-width: 100%;
                padding: 0;
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
                
                <div class="receipt-body">
                    <div class="receipt-info">
                        <p><strong>Kode Pesanan:</strong> <?= $order['kode_pesanan'] ?></p>
                        <p><strong>Tanggal:</strong> <?= date('d F Y', strtotime($order['tanggal_pesanan'])) ?></p>
                        <p><strong>Pelanggan:</strong> <?= $order['nama_perusahaan'] ?></p>
                        <p><strong>PIC:</strong> <?= $order['pic_perusahaan'] ?></p>
                        <p><strong>Alamat:</strong> <?= $order['detail_alamat'] ?></p>
                    </div>
                    
                    <?php
                    // Hitung total
                    $subtotal = $order['kuantitas'] * $order['harga'];
                    $ppn = $subtotal * 0.11;
                    $total = $subtotal + $ppn;
                    ?>
                    
                    <table class="table table-bordered">
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
                                <td><?= $order['nama_produk'] ?></td>
                                <td><?= $order['kuantitas'] ?></td>
                                <td>Rp <?= number_format($order['harga'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="total-section">
                        <p><strong>Subtotal:</strong> Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
                        <p><strong>PPN (11%):</strong> Rp <?= number_format($ppn, 0, ',', '.') ?></p>
                        <p><strong>Total:</strong> Rp <?= number_format($total, 0, ',', '.') ?></p>
                    </div>
                </div>
                
                <div class="signature-section">
                    <div class="signature-box">
                        <p>Penerima</p>
                        <div class="signature-line"></div>
                        <p><?= $order['pic_perusahaan'] ?></p>
                    </div>
                    <div class="signature-box">
                        <p>Hormat Kami</p>
                        <div class="signature-line"></div>
                        <p>BimaSky</p>
                    </div>
                </div>
                
                <div class="no-print text-center mt-4 mb-4">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="bi bi-printer me-2"></i>Cetak Tanda Terima
                    </button>
                    <a href="<?= $_SERVER['PHP_SELF'] ?>?kode=<?= urlencode($order['kode_pesanan']) ?>&download_pdf=1" class="btn btn-success">
                        <i class="bi bi-download me-2"></i>Unduh PDF
                    </a>
                    <a href="track.detail.php?kode=<?= urlencode($order['kode_pesanan']) ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                Pesanan tidak ditemukan atau Anda tidak memiliki akses ke pesanan ini.
            </div>
            <a href="tracking.order.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Pesanan
            </a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
