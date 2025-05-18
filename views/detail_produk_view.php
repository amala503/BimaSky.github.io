<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - SkyLink Market</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="bi bi-broadcast"></i> BimaSky
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                            <a class="nav-link" href="tracking.order.php">
                                <i class="bi bi-cart"></i> Pesanan
                            </a>
                        </li>
                    </ul>
                    <?php if (isset($_SESSION['nama_pelanggan']) && isset($_SESSION['pic_perusahaan'])): ?>
                    <div class="d-flex align-items-center">
                        <span class="text-white me-3">
                            <i class="bi bi-building"></i> <?php echo $_SESSION['nama_pelanggan']; ?> 
                            <small class="ms-2 text-white-50">
                                <i class="bi bi-person"></i> <?php echo $_SESSION['pic_perusahaan']; ?>
                            </small>
                        </span>
                        <a href="logout.php" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="d-flex">
                        <a class="nav-link text-white" href="profile.php">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5 mt-5">
        <div class="container">
            <?php if ($product): ?>
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo htmlspecialchars($product['gambar_produk']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($product['nama_produk']); ?>">
                </div>
                <div class="col-md-6">
                    <h1><?php echo htmlspecialchars($product['nama_produk']); ?></h1>
                    <p class="lead"><?php echo htmlspecialchars($product['detail']); ?></p>
                    <h3 class="text-primary">Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></h3>
                    
                    <div class="mt-4">
                        <h4>Spesifikasi Produk</h4>
                        <p><?php echo nl2br(htmlspecialchars($product['spesifikasi_produk'])); ?></p>
                    </div>

                    <div class="mt-4">
                        <h4>Keunggulan Produk</h4>
                        <p><?php echo nl2br(htmlspecialchars($product['keunggulan_produk'])); ?></p>
                    </div>
                    
                    <form method="POST" action="detail.produk.php?id=<?php echo $product['id']; ?>">
                        <div class="mb-3">
                            <label for="kuantitas" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="kuantitas" name="kuantitas" value="1" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-cart-plus"></i> Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-danger">
                Produk tidak ditemukan.
            </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0 text-white"> 2025 SkyLink Market. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
