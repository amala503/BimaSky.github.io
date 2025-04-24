<?php
session_start();

// Cek apakah ada data dari step 1
if (!isset($_SESSION['namaPerusahaan'])) {
    header("Location: registrasi.1.php");
    exit();
}

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

// Simpan data PIC Perusahaan jika formulir disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simpan data ke session
    $_SESSION['namaPIC'] = $_POST['namaPIC'];
    $_SESSION['jabatanPIC'] = $_POST['jabatanPIC'];
    $_SESSION['emailPIC'] = $_POST['emailPIC'];
    $_SESSION['teleponPIC'] = $_POST['teleponPIC'];

    // Proses upload file
    $targetDir = "uploads/";

    // Buat folder jika belum ada
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Upload dan simpan path file ke session
    if (isset($_FILES['dokumenLegalitas']) && $_FILES['dokumenLegalitas']['error'] == UPLOAD_ERR_OK) {
        $dokumenLegalitas = basename($_FILES['dokumenLegalitas']['name']);
        move_uploaded_file($_FILES['dokumenLegalitas']['tmp_name'], $targetDir . $dokumenLegalitas);
        $_SESSION['dokumenLegalitas'] = $dokumenLegalitas;
    }

    if (isset($_FILES['fotoAkta']) && $_FILES['fotoAkta']['error'] == UPLOAD_ERR_OK) {
        $fotoAkta = basename($_FILES['fotoAkta']['name']);
        move_uploaded_file($_FILES['fotoAkta']['tmp_name'], $targetDir . $fotoAkta);
        $_SESSION['fotoAkta'] = $fotoAkta;
    }

    if (isset($_FILES['fotoNIB']) && $_FILES['fotoNIB']['error'] == UPLOAD_ERR_OK) {
        $fotoNIB = basename($_FILES['fotoNIB']['name']);
        move_uploaded_file($_FILES['fotoNIB']['tmp_name'], $targetDir . $fotoNIB);
        $_SESSION['fotoNIB'] = $fotoNIB;
    }

    // Redirect ke halaman berikutnya
    header("Location: registrasi.3.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Step 2 - SkyLink Market</title>
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
            width: 66.66%;
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
                <h2 class="text-white mb-3">Buat Akun</h2>
                <p class="text-white-50">Step 2 of 3: PIC Perusahaan</p>
                <div class="progress-bar">
                    <div class="progress-step"></div>
                </div>
            </div>
            
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="namaPIC" class="form-label text-white">Nama PIC</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="namaPIC" name="namaPIC" 
                            placeholder="Enter PIC name" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="jabatanPIC" class="form-label text-white">Jabatan PIC</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-briefcase text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="jabatanPIC" name="jabatanPIC" 
                            placeholder="Enter PIC position" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="emailPIC" class="form-label text-white">Email PIC</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-envelope text-white"></i>
                        </span>
                        <input type="email" class="form-control border-start-0" id="emailPIC" name="emailPIC" 
                            placeholder="Enter PIC email" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="teleponPIC" class="form-label text-white">Nomor Telepon PIC</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-phone text-white"></i>
                        </span>
                        <input type="tel" class="form-control border-start-0" id="teleponPIC" name="teleponPIC" 
                            placeholder="Enter PIC phone number" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="dokumenLegalitas" class="form-label text-white">Upload Dokumen Legalitas</label>
                    <input type="file" class="form-control" id="dokumenLegalitas" name="dokumenLegalitas" required>
                </div>

                <div class="mb-3">
                    <label for="fotoAkta" class="form-label text-white">Upload Foto Akta Pendirian</label>
                    <input type="file" class="form-control" id="fotoAkta" name="fotoAkta" required>
                </div>

                <div class="mb-3">
                    <label for="fotoNIB" class="form-label text-white">Upload Foto NIB/ISP</label>
                    <input type="file" class="form-control" id="fotoNIB" name="fotoNIB" required>
                </div>

                <div class="d-flex gap-2">
                    <a href="registrasi.1.php" class="btn btn-outline-light btn-lg flex-grow-1">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                        Continue <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>

                <div class="text-center mt-4">
                    <a href="home.php" class="text-white-50">
                        <i class="bi bi-house me-1"></i>Back to Home
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>