<?php
require_once 'check_login.php';

// Koneksi ke database dtptelkomsat
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dtptelkomsat';

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan data dari tabel produk
$queryProduk = "SELECT id, nama_produk, detail, gambar_produk, harga FROM produk WHERE id >= 12"; // ID dimulai dari 12
$resultProduk = $conn->query($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - BimaSky</title>
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
                            <a class="nav-link active" aria-current="page" href="produk.php">
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
                    <div class="d-flex">
                        <a class="nav-link text-white" href="profile.php">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5 mt-5">
        <section class="container">
            <div class="text-center mb-5">
                <h1 class="display-4 text-white mb-3">
                    <i class="bi bi-box"></i> Produk Kami
                </h1>
                <p class="lead text-white-50">Temukan berbagai solusi komunikasi satelit kami</p>
            </div>

            <div class="row">
                <?php if ($resultProduk->num_rows > 0): ?>
                    <?php while ($row = $resultProduk->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="<?php echo htmlspecialchars($row['gambar_produk']); ?>" class="card-img-top"
                                    alt="<?php echo htmlspecialchars($row['nama_produk']); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($row['detail']); ?></p>
                                    <p class="card-text">
                                        <strong>Harga: </strong>
                                        Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                                    </p>
                                    <a href="detail.produk.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-white">Tidak ada produk yang tersedia saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0 text-white"> 2025 SkyLink Market. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
