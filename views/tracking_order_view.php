<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - SkyLink Market</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .order-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
            color: #000000;
        }

        .card-title {
            color: #000000;
            font-weight: 600;
        }

        .card-body {
            color: #000000;
            margin: 20px;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #000000;
        }

        .price-details {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            color: #000000;
        }

        .price-row span {
            color: #000000;
        }

        .price-row strong {
            color: #000000;
        }

        .price-row.total {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 8px;
            margin-top: 8px;
            font-weight: bold;
            color: #000000;
        }

        .price-row.total span {
            color: #000000;
        }

        .order-details {
            color: #000000;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="bi bi-broadcast"></i> BimaSky
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">
                                <i class="bi bi-house"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produk.php">
                                <i class="bi bi-box"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="promo.php">
                                <i class="bi bi-tag"></i> Promo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faq.php">
                                <i class="bi bi-question-circle"></i> FAQ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="tracking.order.php">
                                <i class="bi bi-cart"></i> Pesanan
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a class="nav-link text-white" href="profile.php">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5 mt-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="display-4 text-white mb-3">
                    <i class="bi bi-cart"></i> Pesanan Saya
                </h1>               
            </div>

            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-box-seam"></i> 
                                    Kode Pesanan: <?php echo htmlspecialchars($order['kode_pesanan']); ?>
                                </h5>
                                <span class="status-badge status-<?php echo strtolower($order['status']); ?>">
                                    <?php echo htmlspecialchars($order['status']); ?>
                                </span>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="mb-1 order-details">
                                        <i class="bi bi-calendar3"></i>
                                        <strong>Tanggal:</strong> <?php echo date('d F Y H:i', strtotime($order['tanggal_pesanan'])); ?>
                                    </p>
                                    <p class="mb-1 order-details">
                                        <i class="bi bi-truck"></i>
                                        <strong>Pengiriman:</strong> <?php echo htmlspecialchars($order['metode_pengiriman']); ?>
                                    </p>
                                    <p class="mb-0 order-details">
                                        <i class="bi bi-credit-card"></i>
                                        <strong>Pembayaran:</strong> <?php echo htmlspecialchars($order['metode_pembayaran']); ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="price-details">
                                        <div class="price-row">
                                            <span><strong>Total Produk</strong></span>
                                            <span>Rp <?php echo number_format($order['total_harga_produk'], 0, ',', '.'); ?></span>
                                        </div>
                                        <div class="price-row">
                                            <span><strong>Pajak</strong></span>
                                            <span>Rp <?php echo number_format($order['pajak'], 0, ',', '.'); ?></span>
                                        </div>
                                        <div class="price-row">
                                            <span><strong>Pengiriman</strong></span>
                                            <span>Rp <?php echo number_format($order['biaya_pengiriman'], 0, ',', '.'); ?></span>
                                        </div>
                                        <div class="price-row total">
                                            <span><strong>Total</strong></span>
                                            <span>Rp <?php echo number_format($order['total_harga_akhir'], 0, ',', '.'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="track.detail.php?kode=<?php echo urlencode($order['kode_pesanan']); ?>" 
                                   class="btn btn-primary">
                                    <i class="bi bi-truck"></i> Lacak Pesanan
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-orders">
                    <i class="bi bi-cart-x"></i>
                    <h3 class="text-white">Belum ada pesanan</h3>
                    <p class="text-white-50">Anda belum memiliki pesanan. Silakan berbelanja terlebih dahulu.</p>
                    <a href="produk.php" class="btn btn-primary">
                        <i class="bi bi-cart-plus"></i> Mulai Berbelanja
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0"> 2025 SkyLink Market. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

