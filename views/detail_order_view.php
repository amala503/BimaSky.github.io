<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Order - SkyLink Market</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            color: var(--text-light);
        }

        .card-title,
        .card .card-title,
        .card-body .card-title {
            color: var(--text-light) !important;
        }

        .card-title i,
        .card .card-title i,
        .card-body .card-title i {
            color: var(--text-light) !important;
        }

        .table {
            color: var(--text-light);
        }

        .table-dark {
            background-color: rgba(26, 35, 126, 0.3);
        }

        .table-dark td,
        .table-dark th {
            color: var(--text-light);
        }

        .form-select {
            background-color: rgba(26, 35, 126, 0.3);
            color: var(--text-light);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-select:focus {
            background-color: rgba(26, 35, 126, 0.4);
            color: var(--text-light);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 180, 216, 0.25);
        }

        .form-select option {
            background-color: var(--space-dark);
            color: var(--text-light);
        }

        .total-cost {
            font-weight: bold;
            font-size: 1.2em;
            color: var(--accent-color);
        }

        .btn-primary {
            background-color: var(--accent-color);
            border: none;
        }

        .btn-primary:hover {
            background-color: #0095b5;
        }

        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-light);
        }

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: var(--text-light);
        }

        .text-muted {
            color: var(--text-gray) !important;
        }

        .custom-input {
            background-color: #2f3678;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 10px;
        }

        .custom-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .custom-input:focus {
            border-color: rgba(255, 255, 255, 0.5);
            outline: none;
        }

        .custom-file-input::file-selector-button {
            background-color: #232a5c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .custom-file-input::file-selector-button:hover {
            background-color: #1d234f;
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
                                <i class="bi bi-house"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produk.php">
                                <i class="bi bi-box"></i> Products
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
                    <div class="d-flex align-items-center">
                        <?php if (isset($_SESSION['nama_pelanggan']) && isset($_SESSION['pic_perusahaan'])): ?>
                            <span class="text-white me-3">
                                <i class="bi bi-building"></i> <?php echo htmlspecialchars($_SESSION['nama_pelanggan']); ?>
                                <small class="ms-2 text-white-50">
                                    <i class="bi bi-person"></i>
                                    <?php echo htmlspecialchars($_SESSION['pic_perusahaan']); ?>
                                </small>
                            </span>
                        <?php endif; ?>
                        <a href="logout.php" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5 mt-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold">Detail Order</h1>
                <p class="text-muted">Konfirmasi pesanan Anda</p>
            </div>

            <?php if (empty($data['produkList'])): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Tidak ada produk dalam pesanan.
                    <a href="home.php" class="btn btn-primary ms-3">Kembali ke Home</a>
                </div>
            <?php else: ?>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-cart-check me-2"></i>
                                Daftar Produk
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Kuantitas</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['produkList'] as $produk): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($produk['nama_produk']) ?></td>
                                                <td><?= $produk['kuantitas'] ?></td>
                                                <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                                                <td>Rp <?= number_format($produk['total'], 0, ',', '.') ?></td>
                                                <td>
                                                    <form method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                                        <input type="hidden" name="detail_id" value="<?= $produk['id'] ?>">
                                                        <button type="submit" name="delete_item" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">
                                        <i class="bi bi-truck me-2"></i>
                                        Metode Pengiriman
                                    </h5>
                                    <select name="metode_pengiriman" class="form-select mb-3" required>
                                        <?php foreach ($data['metodePengiriman'] as $metode => $biaya): ?>
                                            <option value="<?= $metode ?>">
                                                <?= $metode ?> - Rp <?= number_format($biaya, 0, ',', '.') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <h5 class="card-title mb-4">
                                        <i class="bi bi-credit-card me-2"></i>
                                        Metode Pembayaran
                                    </h5>
                                    <select name="metode_pembayaran" class="form-select mb-3" required>
                                        <?php foreach ($data['metodePembayaran'] as $metode): ?>
                                            <option value="<?= $metode ?>"><?= $metode ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <h5 class="card-title mb-4">
                                        <i class="bi bi-upload me-2"></i>
                                        Upload Bukti Transfer
                                    </h5>
                                    <div class="input-group mb-3">
                                        <input type="file" name="bukti_transfer" class="form-control custom-input custom-file-input"
                                               accept="image/*" required>
                                    </div>

                                    <h5 class="card-title mb-4">
                                        <i class="bi bi-ticket me-2"></i>
                                        Kode Promo
                                    </h5>
                                    <div class="input-group mb-3">
                                        <input type="text" name="kode_promo" class="form-control custom-input"
                                               placeholder="Masukkan kode promo (opsional)">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">
                                        <i class="bi bi-receipt me-2"></i>
                                        Ringkasan Biaya
                                    </h5>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Total Harga Produk:</span>
                                        <span>Rp <?= number_format($data['totalHarga'], 0, ',', '.') ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>PPN (11%):</span>
                                        <span>Rp <?= number_format($data['pajak'], 0, ',', '.') ?></span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between total-cost">
                                        <span>Total:</span>
                                        <span>Rp <?= number_format($data['totalHarga'] + $data['pajak'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="konfirmasi" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>
                            Konfirmasi Pesanan
                        </button>
                        <a href="home.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali ke Home
                        </a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0">© 2025 SkyLink Market. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>



