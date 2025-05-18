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
            
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="namaPIC" class="form-label text-white">Nama PIC</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="namaPIC" name="namaPIC" 
                            placeholder="Enter PIC name" value="<?= $namaPIC ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="jabatan" class="form-label text-white">Jabatan PIC</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-briefcase text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="jabatan" name="jabatan" 
                            placeholder="Enter PIC position" value="<?= $jabatan ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="departemen" class="form-label text-white">Departemen</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-building text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="departemen" name="departemen" 
                            placeholder="Enter department" value="<?= $departemen ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="noPonsel" class="form-label text-white">Nomor Ponsel PIC</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-phone text-white"></i>
                        </span>
                        <input type="tel" class="form-control border-start-0" id="noPonsel" name="noPonsel" 
                            placeholder="Enter PIC mobile number" value="<?= $noPonsel ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="emailPIC" class="form-label text-white">Email PIC</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-envelope text-white"></i>
                        </span>
                        <input type="email" class="form-control border-start-0" id="emailPIC" name="emailPIC" 
                            placeholder="Enter PIC email" value="<?= $emailPIC ?>" required>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="registrasi.1" class="btn btn-outline-light btn-lg flex-grow-1">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                        Continue <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>

                <div class="text-center mt-4">
                    <a href="home" class="text-white-50">
                        <i class="bi bi-house me-1"></i>Back to Home
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
