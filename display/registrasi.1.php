<?php
session_start();

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dtptelkomsat';

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data yang tersimpan di session (jika ada)
$jenisBisnis = isset($_SESSION['jenisBisnis']) ? $_SESSION['jenisBisnis'] : '';
$kategoriBisnis = isset($_SESSION['kategoriBisnis']) ? $_SESSION['kategoriBisnis'] : '';
$namaPerusahaan = isset($_SESSION['namaPerusahaan']) ? $_SESSION['namaPerusahaan'] : '';
$npwp = isset($_SESSION['npwp']) ? $_SESSION['npwp'] : '';
$emailPerusahaan = isset($_SESSION['emailPerusahaan']) ? $_SESSION['emailPerusahaan'] : '';
$teleponPerusahaan = isset($_SESSION['teleponPerusahaan']) ? $_SESSION['teleponPerusahaan'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
$sumberInformasi = isset($_SESSION['sumberInformasi']) ? $_SESSION['sumberInformasi'] : '';

// Proses penyimpanan data ke session
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simpan data ke session
    $_SESSION['jenisBisnis'] = $_POST['jenisBisnis'];
    $_SESSION['kategoriBisnis'] = $_POST['kategoriBisnis'];
    $_SESSION['namaPerusahaan'] = $_POST['namaPerusahaan'];
    $_SESSION['npwp'] = $_POST['npwp'];
    $_SESSION['emailPerusahaan'] = $_POST['emailPerusahaan'];
    $_SESSION['teleponPerusahaan'] = $_POST['teleponPerusahaan'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['sumberInformasi'] = $_POST['sumberInformasi'];

    // Redirect ke halaman berikutnya
    header("Location: registrasi.2.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SkyLink Market</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('/skripsi/assets/satelit.jpg') no-repeat center center;
            background-size: cover;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent-color);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(0, 180, 216, 0.25);
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        .progress-bar {
            height: 8px;
            margin: 20px 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-step {
            width: 33.33%;
            height: 100%;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="text-center mb-4">
                <i class="bi bi-broadcast display-1 text-primary mb-3"></i>
                <h2 class="text-white mb-3">Create Account</h2>
                <p class="text-white-50">Step 1 of 3: Personal Information</p>
                <div class="progress-bar">
                    <div class="progress-step"></div>
                </div>
            </div>
            
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="jenisBisnis" class="form-label text-white">Jenis Bisnis</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person text-white"></i>
                        </span>
                        <select class="form-select border-start-0" id="jenisBisnis" name="jenisBisnis" required>
                            <option value="">Pilih Jenis Bisnis</option>
                            <option value="B2B" <?= $jenisBisnis == 'B2B' ? 'selected' : '' ?>>B2B</option>
                            <option value="B2C" <?= $jenisBisnis == 'B2C' ? 'selected' : '' ?>>B2C</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="kategoriBisnis" class="form-label text-white">Kategori Bisnis</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="kategoriBisnis" name="kategoriBisnis" placeholder="Enter your kategori bisnis" value="<?= $kategoriBisnis ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="namaPerusahaan" class="form-label text-white">Nama Perusahaan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="namaPerusahaan" name="namaPerusahaan" placeholder="Enter your nama perusahaan" value="<?= $namaPerusahaan ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="npwp" class="form-label text-white">Nomor NPWP</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="npwp" name="npwp" placeholder="Enter your nomor npwp" value="<?= $npwp ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="emailPerusahaan" class="form-label text-white">Email Perusahaan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-envelope text-white"></i>
                        </span>
                        <input type="email" class="form-control border-start-0" id="emailPerusahaan" name="emailPerusahaan" placeholder="Enter your email perusahaan" value="<?= $emailPerusahaan ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="teleponPerusahaan" class="form-label text-white">Nomor Telepon Perusahaan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-phone text-white"></i>
                        </span>
                        <input type="tel" class="form-control border-start-0" id="teleponPerusahaan" name="teleponPerusahaan" placeholder="Enter your telepon perusahaan" value="<?= $teleponPerusahaan ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label text-white">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="username" name="username" placeholder="Enter your username" value="<?= $username ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-white">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-lock text-white"></i>
                        </span>
                        <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Enter your password" value="<?= $password ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sumberInformasi" class="form-label text-white">Sumber Informasi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person text-white"></i>
                        </span>
                        <select class="form-select border-start-0" id="sumberInformasi" name="sumberInformasi" required>
                            <option value="">Pilih Sumber Informasi</option>
                            <option value="Media Sosial" <?= $sumberInformasi == 'Media Sosial' ? 'selected' : '' ?>>Media Sosial</option>
                            <option value="Website" <?= $sumberInformasi == 'Website' ? 'selected' : '' ?>>Website</option>
                            <option value="Rekomendasi" <?= $sumberInformasi == 'Rekomendasi' ? 'selected' : '' ?>>Rekomendasi</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Continue <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-white-50">Already have an account? 
                        <a href="login.php" class="text-primary">Login here</a>
                    </p>
                    <a href="home.php" class="text-white-50">
                        <i class="bi bi-arrow-left me-1"></i>Back to Home
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
