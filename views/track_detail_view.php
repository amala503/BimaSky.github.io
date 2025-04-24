<?php
require_once 'check_login.php';

if (!isset($order) && isset($_GET['kode'])) {
    $kode_pesanan = $_GET['kode'];
    $user_id = $_SESSION['user_id'];
    $order = $this->model->getOrderDetails($kode_pesanan, $user_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelacakan - BimaSky</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .tracking-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
            color: #333;
        }

        .tracking-card .card-title {
            color: #333;
            font-weight: 600;
            margin-top: 15px;
        }

        .tracking-card h5,
        .tracking-card h2 {
            color: #333;
            font-weight: 600;
            margin-left: 15px;
        }

        .tracking-card .col-md-6 p {
            color: #333;
        }

        .tracking-card .col-md-6 strong {
            color: #333;
            font-weight: 600;
            margin-left: 15px;
        }

        .tracking-step {
            position: relative;
            padding-left: 50px;
            margin-bottom: 30px;
            margin-left: 20px;
        }

        .tracking-step h5 {
            color: #333;
            margin-bottom: 5px;
            margin-left: 15px;
        }

        .tracking-step:before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: -30px;
            width: 2px;
            background: #dee2e6;
        }

        .tracking-step:last-child:before {
            display: none;
        }

        .tracking-step .step-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #dee2e6;
            text-align: center;
            line-height: 28px;
            color: #6c757d;
            margin-left: 15px;
        }

        .tracking-step.active .step-icon {
            background: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        .tracking-step.completed .step-icon {
            background: #198754;
            border-color: #198754;
            color: #fff;
            margin-left: 15px;
        }

        .price-details {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .price-details h5 {
            color: #333;
            font-weight: 600;
            margin-left: -1px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            color: #333;
        }

        .price-row span {
            color: #333;
        }

        .price-row.total {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 8px;
            margin-top: 8px;
            font-weight: bold;
            color: #333;
        }

        .price-row.total span {
            color: #333;
            font-weight: bold;
        }

        .tracking-card p {
            color: #333;
        }

        .tracking-card .text-muted {
            color: #666 !important;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/partials/header.php'; ?>

    <main class="py-5 mt-5">
        <div class="container">
            <?php if (isset($order)): ?>
                <div class="tracking-card">
                    <div class="card-body">
                        <!-- Card title -->
                        <h2 class="card-title mb-4">
                            <i class="bi bi-box-seam"></i>
                            Pelacakan Pesanan: <?php echo htmlspecialchars($order['kode_pesanan']); ?>
                        </h2>

                        <!-- Customer Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Informasi Pelanggan</h5>
                                <p class="mb-1">
                                    <strong>Perusahaan:</strong> <?php echo htmlspecialchars($order['nama_perusahaan']); ?>
                                </p>
                                <p class="mb-1">
                                    <strong>PIC:</strong> <?php echo htmlspecialchars($order['pic_perusahaan']); ?>
                                </p>
                                <p class="mb-1">
                                    <strong>Tanggal Pesanan:</strong>
                                    <?php echo date('d F Y H:i', strtotime($order['tanggal_pesanan'])); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5>Detail Pengiriman</h5>
                                <p class="mb-1">
                                    <strong>Metode Pengiriman:</strong>
                                    <?php echo htmlspecialchars($order['metode_pengiriman']); ?>
                                </p>
                                <p class="mb-1">
                                    <strong>Metode Pembayaran:</strong>
                                    <?php echo htmlspecialchars($order['metode_pembayaran']); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Tracking Timeline -->
                        <div class="tracking-timeline mb-4">
                            <?php
                            $steps = [
                                'pending' => ['icon' => 'bi-clock', 'text' => 'Pesanan Pending'],
                                'diproses' => ['icon' => 'bi-gear', 'text' => 'Pesanan Diproses'],
                                'dikirim' => ['icon' => 'bi-truck', 'text' => 'Dalam Pengiriman'],
                                'Diterima' => ['icon' => 'bi-check2-circle', 'text' => 'Pesanan Diterima'],
                                'request_aktivasi' => ['icon' => 'bi-bell', 'text' => 'Menunggu Aktivasi'],
                                'aktifkan_layanan' => ['icon' => 'bi-lightning', 'text' => 'Layanan Aktif'],
                                'selesai' => ['icon' => 'bi-check-circle', 'text' => 'Pesanan Selesai']
                            ];

                            $currentStatus = strtolower($order['status']);
                            $statusFound = false;

                            foreach ($steps as $status => $step):
                                $stepClass = '';
                                $statusLower = strtolower($status);
                                
                                if ($statusLower === $currentStatus) {
                                    $stepClass = 'active';
                                    $statusFound = true;
                                } elseif (!$statusFound) {
                                    $stepClass = 'completed';
                                }
                            ?>
                                <div class="tracking-step <?php echo $stepClass; ?>" data-status="<?php echo $status; ?>">
                                    <div class="step-icon">
                                        <i class="bi <?php echo $step['icon']; ?>"></i>
                                    </div>
                                    <h5>
                                        <?php echo $step['text']; ?>

                                        <?php if ($status === "dikirim" && $currentStatus === "dikirim"): ?>
                                            <form method="POST" class="konfirmasi-pesanan-form" style="display: inline;">
                                                <input type="hidden" name="kode_pesanan" 
                                                    value="<?php echo htmlspecialchars($order['kode_pesanan']); ?>">
                                                <button type="submit" name="konfirmasi_pesanan" class="btn btn-primary btn-sm ms-3">
                                                    <i class="bi bi-check-circle"></i> Konfirmasi Pesanan
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if ($status === "Diterima" && strtolower($currentStatus) === "diterima"): ?>
                                            <form method="POST" action="request_aktivasi.php" class="request-aktivasi-form" style="display: inline;">
                                                <input type="hidden" name="kode_pesanan" 
                                                    value="<?php echo htmlspecialchars($order['kode_pesanan']); ?>">
                                                <button type="submit" name="request_aktivasi" class="btn btn-primary btn-sm ms-3">
                                                    <i class="bi bi-send"></i> Request Layanan
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if ($status === "aktifkan_layanan" && $currentStatus === "aktifkan_layanan"): ?>
                                            <a href="print_activation.php?kode=<?php echo urlencode($order['kode_pesanan']); ?>" 
                                                class="btn btn-success btn-sm ms-3">
                                                <i class="bi bi-file-text"></i> Cetak Surat Aktivasi
                                            </a>
                                            <a href="print_installation.php?kode=<?php echo urlencode($order['kode_pesanan']); ?>" 
                                                class="btn btn-info btn-sm ms-3">
                                                <i class="bi bi-tools"></i> Cetak Panduan Instalasi
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($status === "selesai" && $currentStatus === "selesai"): ?>
                                            <a href="print_activation.php?kode=<?php echo urlencode($order['kode_pesanan']); ?>&download=true"
                                                class="btn btn-success btn-sm ms-3">
                                                <i class="bi bi-download"></i> Download Surat Aktivasi
                                            </a>
                                        <?php endif; ?>
                                    </h5>

                                    <p class="text-muted" style="margin-left: 15px;">
                                        <?php if ($status === $currentStatus): ?>
                                            Status saat ini
                                        <?php endif; ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Print Buttons -->
                        <?php if (isset($order) && strtolower($order['status']) === 'diproses'): ?>
                            <div class="mb-4 text-center">
                                <a href="print_tax_invoice.php?kode=<?php echo urlencode($order['kode_pesanan']); ?>"
                                    class="btn btn-primary me-2">
                                    <i class="bi bi-printer"></i> Cetak Faktur Pajak
                                </a>
                                <a href="print_receipt.php?kode=<?php echo urlencode($order['kode_pesanan']); ?>"
                                    class="btn btn-success">
                                    <i class="bi bi-receipt"></i> Cetak Tanda Terima
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Price Details -->
                        <div class="price-details">
                            <h5>Rincian Biaya</h5>
                            <div class="price-row">
                                <span>Total Harga Produk</span>
                                <span>Rp <?php echo number_format($order['total_harga_produk'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="price-row">
                                <span>Pajak (11%)</span>
                                <span>Rp <?php echo number_format($order['pajak'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="price-row">
                                <span>Biaya Pengiriman</span>
                                <span>Rp <?php echo number_format($order['biaya_pengiriman'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="price-row total">
                                <span>Total Pembayaran</span>
                                <span>Rp <?php echo number_format($order['total_harga_akhir'], 0, ',', '.'); ?></span>
                            </div>
                        </div>

                        <!-- Back Button -->
                        <div class="mt-4" style="margin-left: 15px; margin-bottom: 15px;">
                            <a href="tracking.order.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    Pesanan tidak ditemukan atau Anda tidak memiliki akses ke pesanan ini.
                </div>
                <a href="tracking.order.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
                </a>
            <?php endif; ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.konfirmasi-pesanan-form').on('submit', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const kodePesanan = form.find('input[name="kode_pesanan"]').val();
                
                $.ajax({
                    type: 'POST',
                    url: 'konfirmasi_pesanan.php',
                    data: {
                        kode_pesanan: kodePesanan,
                        konfirmasi_pesanan: true
                    },
                    success: function(response) {
                        if(response.success) {
                            $('.tracking-step').removeClass('active completed');
                            
                            const steps = ['pending', 'diproses', 'dikirim', 'Diterima', 'request_aktivasi', 'aktifkan_layanan', 'selesai'];
                            let foundDiterima = false;
                            
                            steps.forEach(function(status) {
                                const step = $('.tracking-step[data-status="' + status + '"]');
                                
                                if (status === 'Diterima') {
                                    step.addClass('active');
                                    foundDiterima = true;
                                } else if (!foundDiterima) {
                                    step.addClass('completed');
                                }
                            });
                            
                            // Sembunyikan tombol konfirmasi pesanan
                            form.hide();
                            
                            // Tambahkan tombol Request Layanan
                            const requestButton = `
                                <form method="POST" action="request_aktivasi.php" class="request-aktivasi-form" style="display: inline;">
                                    <input type="hidden" name="kode_pesanan" value="${kodePesanan}">
                                    <button type="submit" name="request_aktivasi" class="btn btn-primary btn-sm ms-3">
                                        <i class="bi bi-send"></i> Request Layanan
                                    </button>
                                </form>
                            `;
                            
                            // Tambahkan tombol ke step Diterima
                            $('.tracking-step[data-status="Diterima"] h5').append(requestButton);
                            $('.tracking-step[data-status="Diterima"] .text-muted').text('Status saat ini');
                        } else {
                            alert('Terjadi kesalahan saat mengkonfirmasi pesanan');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan pada server');
                    }
                });
            });
        });
    </script>
</body>
</html>


