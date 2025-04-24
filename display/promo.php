<?php
require_once 'check_login.php';
// Halaman Promo (promo.php)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtptelkomsat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM promo";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $promos = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $promos = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo - SkyLink Market</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .promo-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .promo-card:hover {
            transform: translateY(-5px);
        }

        .promo-card .card-body {
            color: #000000;
        }

        .promo-code-box {
            background-color: var(--space-blue);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-light);
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .promo-code-box .code-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .promo-code-box span {
            color: var(--accent-color);
            background-color: rgba(0, 180, 216, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }

        .copy-button {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: var(--text-light);
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .copy-button:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .toast {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .period-badge {
            background-color: var(--space-blue);
            color: var(--text-light);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            display: inline-block;
        }

        .period-badge i {
            color: var(--accent-color);
            margin-right: 5px;
        }

        .syarat-ketentuan {
            background-color: rgba(0, 0, 0, 0.05);
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
        }

        .syarat-ketentuan strong,
        .syarat-ketentuan p {
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
                            <a class="nav-link active" href="promo.php">
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
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5 mt-5">
        <section class="container">
            <div class="text-center mb-5">
                <h1 class="display-4 text-white mb-3">
                    <i class="bi bi-tag"></i> Special Promo
                </h1>
                <p class="lead text-white-50">Discover our latest offers and special deals</p>
            </div>

            <div class="row g-4">
                <?php if (!empty($promos)): ?>
                    <?php foreach ($promos as $promo): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="promo-card card h-100">
                                <img src="<?php echo htmlspecialchars($promo['gambar_promo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($promo['nama_promo']); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($promo['nama_promo']); ?></h5>
                                    <div class="mb-3">
                                        <span class="period-badge">
                                            <i class="bi bi-calendar"></i>
                                            <?php 
                                                $start = date('d M Y', strtotime($promo['start_date']));
                                                $end = date('d M Y', strtotime($promo['end_date']));
                                                echo "$start - $end";
                                            ?>
                                        </span>
                                    </div>
                                    <div class="promo-code-box">
                                        <div class="code-container">
                                            <strong>Kode Promo:</strong>
                                            <span class="promo-code" data-code="<?php echo htmlspecialchars($promo['kode_promo']); ?>"><?php echo htmlspecialchars($promo['kode_promo']); ?></span>
                                        </div>
                                        <button class="copy-button" onclick="copyPromoCode(this)" title="Salin kode">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                    <p class="card-text">
                                        <strong>Produk:</strong> <?php echo htmlspecialchars($promo['nama_produk']); ?>
                                    </p>
                                    <div class="syarat-ketentuan">
                                        <strong>Syarat & Ketentuan:</strong>
                                        <p class="small mb-0 mt-1"><?php echo nl2br(htmlspecialchars($promo['syarat_ketentuan'])); ?></p>
                                    </div>
                                    <!-- <div class="mt-3">
                                        <a href="produk.php" class="btn btn-primary w-100">
                                            <i class="bi bi-cart-plus"></i> Beli Sekarang
                                        </a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-tag display-1 text-white-50"></i>
                            <h3 class="mt-3 text-white">Tidak ada promo saat ini</h3>
                            <p class="text-white-50">Nantikan promo menarik dari kami segera!</p>
                        </div>
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

    <!-- Toast Container for Copy Notifications -->
    <div class="toast-container">
        <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Kode promo berhasil disalin!
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyPromoCode(button) {
            const codeElement = button.closest('.promo-code-box').querySelector('.promo-code');
            const code = codeElement.dataset.code;
            
            // Copy to clipboard
            navigator.clipboard.writeText(code).then(() => {
                // Show success toast
                const toastElement = document.querySelector('.toast');
                const toast = new bootstrap.Toast(toastElement, {
                    animation: true,
                    autohide: true,
                    delay: 2000
                });
                toast.show();
                
                // Change button icon temporarily
                const icon = button.querySelector('i');
                icon.classList.remove('bi-clipboard');
                icon.classList.add('bi-clipboard-check-fill');
                setTimeout(() => {
                    icon.classList.remove('bi-clipboard-check-fill');
                    icon.classList.add('bi-clipboard');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>
