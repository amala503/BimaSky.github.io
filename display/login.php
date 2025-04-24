<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SkyLink Market</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('/skripsi/assets/satelit.jpg') no-repeat center center;
            background-size: cover;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
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
        .alert {
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }
        .alert-warning {
            border-left: 4px solid #ffc107;
        }
        .alert-danger {
            border-left: 4px solid #dc3545;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="text-center mb-4">
                <i class="bi bi-broadcast display-1 text-primary mb-3"></i>
                <h2 class="text-white mb-3">Login to BimaSky</h2>
                <p class="text-white-50">Selamat Datang kembali.</p>
            </div>
            
            <?php if (isset($_SESSION['warning'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <?php 
                echo $_SESSION['warning'];
                unset($_SESSION['warning']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle me-2"></i>
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <form action="login_process.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label text-white">Username atau Email Perusahaan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="username" name="username" 
                               placeholder="Masukkan username atau email perusahaan" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label text-white">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-lock text-white"></i>
                        </span>
                        <input type="password" class="form-control border-start-0" id="password" name="password" 
                               placeholder="Masukkan password" required>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-white-50">Belum punya akun? 
                        <a href="registrasi.1.php" class="text-primary">Daftar disini</a>
                    </p>
                    <a href="home.php" class="text-white-50">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Home
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
