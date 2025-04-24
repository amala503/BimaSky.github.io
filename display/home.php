<?php
session_start();
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

// Query untuk mendapatkan data dari tabel produk dengan limit 3
$queryProduk = "SELECT id, nama_produk, detail, gambar_produk, harga FROM produk LIMIT 3";
$resultProduk = $conn->query($queryProduk);

// Query untuk mendapatkan data dari tabel promo dengan limit 3

$sql = "SELECT * FROM promo LIMIT 3";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $promos = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $promos = [];
}

// Ambil data FAQ dari database
$query = "SELECT pertanyaan, jawaban FROM faq";
$result = $conn->query($query);
$faqs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faqs[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyLink Market - Solusi Satelit Terbaik</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                            <a class="nav-link active" aria-current="page" href="home.php">
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
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="/skripsi/display/login.php" class="btn btn-outline-light me-3">Login</a>
                    <?php endif; ?>
                    <div class="d-flex">
                        <a class="nav-link text-white" href="profile.php">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero-section text-center" style="padding-top: 100px;">
            <div class="container">
                <div class="fade-in">
                    <h1 class="display-4 fw-bold hero-text mb-4">Selamat Datang di SkyLink Market</h1>
                    <p class="lead hero-text mb-4">Solusi Terbaik untuk Layanan Satelit Anda</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#layanan" class="btn btn-primary btn-lg">
                            <i class="bi bi-rocket"></i> Lihat Layanan
                        </a>
                        <?php if (!isset($_SESSION['user_id'])): ?>
                        <a class="btn btn-outline-light btn-lg" href="registrasi.1.php">
                            <i class="bi bi-person-plus"></i> Daftar
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 fade-in">
                    <i class="bi bi-stars"></i> Layanan Unggulan Kami
                </h2>
                <div class="row">
                    <?php if ($resultProduk->num_rows > 0): ?>
                        <?php while ($row = $resultProduk->fetch_assoc()): ?>
                            <div class="col-md-4 mb-4 fade-in">
                                <div class="card h-100">
                                    <div class="position-relative">
                                        <img src="<?php echo htmlspecialchars($row['gambar_produk']); ?>" class="card-img-top"
                                            alt="<?php echo htmlspecialchars($row['nama_produk']); ?>"
                                            style="height: 200px; object-fit: cover;">
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-primary">Featured</span>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
                                        <p class="card-text text-gray"><?php echo htmlspecialchars($row['detail']); ?></p>
                                        <p class="card-text text-center text-primary fw-bold">
                                            Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                                        </p>
                                        <div class="mt-auto text-center">
                                            <a href="detail.produk.php?id=<?php echo htmlspecialchars($row['id']); ?>"
                                                class="btn btn-primary">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>Tidak ada produk yang tersedia saat ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section id="promo" class="py-5">
            <div class="container text-center">
                <h2 class="mb-5 fade-in">
                    <i class="bi bi-gift"></i> Promo Spesial!
                </h2>
                <div class="row">
                    <?php if (!empty($promos)): ?>
                        <?php foreach ($promos as $promo): ?>
                            <div class="col-md-4 mb-4 fade-in">
                                <div class="card h-100">
                                    <div class="position-relative">
                                        <img src="<?= htmlspecialchars($promo['gambar_promo']); ?>" class="card-img-top"
                                            alt="Promo Image" style="height: 200px; object-fit: cover;">
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge bg-danger">Promo</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($promo['nama_promo']); ?></h5>
                                        <p class="card-text">
                                            <i class="bi bi-calendar-event"></i> 
                                            <?= htmlspecialchars($promo['start_date']); ?> - <?= htmlspecialchars($promo['end_date']); ?>
                                        </p>
                                        <div class="mt-auto">
                                            <a href="detail.promo.php?id=<?= htmlspecialchars($promo['id']); ?>"
                                                class="btn btn-primary">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p>Tidak ada promo saat ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mt-4 fade-in">
                    <a href="promo.php" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-arrow-right"></i> Lihat Semua Promo
                    </a>
                </div>
            </div>
        </section>

        <section class="faq-section container">
            <h2 class="text-center mb-5 fade-in">
                <i class="bi bi-question-diamond"></i> Frequently Asked Questions
            </h2>
            <?php if (!empty($faqs)): ?>
                <?php foreach ($faqs as $faq): ?>
                    <div class="faq-item fade-in">
                        <h3 class="h5 mb-3">
                            <i class="bi bi-question-circle"></i>
                            <?php echo htmlspecialchars($faq['pertanyaan']); ?>
                        </h3>
                        <p class="text-gray mb-0">
                            <?php echo htmlspecialchars($faq['jawaban']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0"> 2025 SkyLink Market. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>