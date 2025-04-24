<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil - SkyLink Market</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('/skripsi/assets/satelit.jpg') no-repeat center center;
            background-size: cover;
        }
        .success-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: scaleIn 0.5s ease-out;
        }
        .success-icon i {
            font-size: 50px;
            color: white;
        }
        .success-title {
            color: white;
            font-size: 2rem;
            margin-bottom: 1rem;
            animation: fadeInUp 0.5s ease-out 0.3s both;
        }
        .success-message {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            animation: fadeInUp 0.5s ease-out 0.6s both;
        }
        .btn-home {
            animation: fadeInUp 0.5s ease-out 0.9s both;
        }
        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .countdown {
            color: var(--primary-color);
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <i class="bi bi-check-lg"></i>
            </div>
            <h1 class="success-title">Registrasi Berhasil!</h1>
            <p class="success-message">
                Terima kasih telah mendaftar di BimSky. Silahkan menunggu Admin untuk memverifikasi akun Anda.
                <br><br>
                Anda akan diarahkan ke halaman login dalam <span class="countdown">5</span> detik.
            </p>
            <div class="btn-home">
                <a href="login.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login Sekarang
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let countdown = 5;
            const countdownElement = $('.countdown');
            
            const timer = setInterval(function() {
                countdown--;
                countdownElement.text(countdown);
                
                if (countdown <= 0) {
                    clearInterval(timer);
                    window.location.href = 'login.php';
                }
            }, 1000);
        });
    </script>
</body>
</html>
