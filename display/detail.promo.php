<?php
require_once 'check_login.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dtptelkomsat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    header("Location: promo.php");
    exit;
}

$id = $conn->real_escape_string($_GET['id']);
$sql = "SELECT * FROM promo WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: promo.php");
    exit;
}

$promo = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Promo - SkyLink Market</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0a1628;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: rgba(13, 28, 52, 0.9);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 600;
            color: #3b82f6;
        }

        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #3b82f6 !important;
        }

        .nav-link.active {
            color: #3b82f6 !important;
        }

        .promo-detail-card {
            background: linear-gradient(145deg, #0f2744, #1a365d);
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .promo-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .promo-content {
            padding: 2rem;
        }

        .period-badge {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .btn-back {
            background-color: transparent;
            border: 2px solid #3b82f6;
            color: #3b82f6;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background-color: #3b82f6;
            color: #ffffff;
        }

        .description {
            color: #cbd5e1;
            line-height: 1.7;
        }

        footer {
            background-color: rgba(13, 28, 52, 0.9);
            padding: 1rem 0;
            margin-top: auto;
        }

        .page-header {
            background: linear-gradient(to right, #1a365d, #0f2744);
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
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
                            <a class="nav-link active" href="promo.php">
                                <i class="bi bi-tag"></i> Promo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faq.php">
                                <i class="bi bi-question-circle"></i> FAQ
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <a href="profil.php" class="btn btn-outline-light btn-sm me-2">
                            <i class="bi bi-person"></i>
                            <?php echo isset($_SESSION['nama_pelanggan']) ? $_SESSION['nama_pelanggan'] : 'Profile'; ?>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow-1 pt-5 mt-4">
        <div class="page-header">
            <div class="container">
                <div class="d-flex align-items-center">
                    <a href="promo.php" class="btn btn-back me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="display-4 fw-bold text-white mb-2">Detail Promo</h1>
                        <p class="text-light mb-0">Informasi lengkap tentang promo</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="promo-detail-card">
                        <img src="<?= htmlspecialchars($promo['gambar_promo']); ?>" 
                             class="promo-image" 
                             alt="<?= htmlspecialchars($promo['nama_promo']); ?>">
                        
                        <div class="promo-content">
                            <div class="period-badge">
                                <i class="bi bi-calendar-event me-2"></i>
                                Periode: <?= htmlspecialchars($promo['start_date']); ?> - <?= htmlspecialchars($promo['end_date']); ?>
                            </div>
                            
                            <h2 class="fw-bold mb-4"><?= htmlspecialchars($promo['nama_promo']); ?></h2>
                            
                            <?php if (!empty($promo['deskripsi'])): ?>
                            <div class="description mb-4">
                                <?= nl2br(htmlspecialchars($promo['deskripsi'])); ?>
                            </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="produk.php" class="btn btn-primary">
                                    <i class="bi bi-box me-2"></i>Lihat Produk
                                </a>
                                <a href="promo.php" class="btn btn-back">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0 text-white-50"> 2025 SkyLink Market. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
