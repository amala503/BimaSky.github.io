<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pelanggan - BimaSky</title>
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            padding-top: 76px;
            background-color: #f8f9fa;
        }

        .profile-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .profile-section h2 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            width: 30%;
            background-color: #f8f9fa;
        }

        .btn-edit {
            padding: 0.375rem 1rem;
            font-size: 0.875rem;
        }

        .password-form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        .password-form .form-label {
            color: #000;
            font-weight: 500;
        }

        .alert {
            display: none;
            margin-top: 15px;
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="home">
                                <i class="bi bi-house"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produk">
                                <i class="bi bi-box"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="promo">
                                <i class="bi bi-tag"></i> Promo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faq">
                                <i class="bi bi-question-circle"></i> FAQ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tracking.order">
                                <i class="bi bi-cart"></i> Pesanan
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a class="nav-link active text-white" href="profile">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h1 class="text-center mb-4">
                    <i class="bi bi-person-circle"></i> Profil Pelanggan
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <!-- Informasi Pelanggan -->
                <div class="profile-section">
                    <h2><i class="bi bi-person"></i> Informasi Pelanggan</h2>
                    <table class="table">
                        <tr>
                            <th>Jenis Bisnis</th>
                            <td><?php echo htmlspecialchars($user['jenis_bisnis']); ?></td>
                        </tr>
                        <tr>
                            <th>Kategori Bisnis</th>
                            <td><?php echo htmlspecialchars($user['kategori_bisnis']); ?></td>
                        </tr>
                        <tr>
                            <th>Nama Perusahaan</th>
                            <td><?php echo htmlspecialchars($user['nama_perusahaan']); ?></td>
                        </tr>
                        <tr>
                            <th>Nomor NPWP</th>
                            <td><?php echo htmlspecialchars($user['nomor_npwp']); ?></td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td><?php echo htmlspecialchars($user['no_telepon']); ?></td>
                        </tr>
                        <tr>
                            <th>Email Perusahaan</th>
                            <td><?php echo htmlspecialchars($user['email_perusahaan']); ?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                        </tr>
                    </table>
                </div>

                <!-- PIC Perusahaan -->
                <?php if ($pic): ?>
                <div class="profile-section">
                    <h2><i class="bi bi-person-badge"></i> PIC Perusahaan</h2>
                    <table class="table">
                        <tr>
                            <th>Nama PIC</th>
                            <td><?php echo htmlspecialchars($pic['nama_pic']); ?></td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td><?php echo htmlspecialchars($pic['jabatan']); ?></td>
                        </tr>
                        <tr>
                            <th>Departemen</th>
                            <td><?php echo htmlspecialchars($pic['departemen']); ?></td>
                        </tr>
                        <tr>
                            <th>No Ponsel</th>
                            <td><?php echo htmlspecialchars($pic['no_ponsel']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($pic['email']); ?></td>
                        </tr>
                    </table>
                </div>
                <?php endif; ?>

                <!-- Alamat Perusahaan -->
                <?php if ($address): ?>
                <div class="profile-section">
                    <h2><i class="bi bi-geo-alt"></i> Alamat Perusahaan</h2>
                    <table class="table">
                        <tr>
                            <th>Provinsi</th>
                            <td><?php echo htmlspecialchars($address['provinsi']); ?></td>
                        </tr>
                        <tr>
                            <th>Kabupaten/Kota</th>
                            <td><?php echo htmlspecialchars($address['kabupaten_kota']); ?></td>
                        </tr>
                        <tr>
                            <th>Kecamatan</th>
                            <td><?php echo htmlspecialchars($address['kecamatan']); ?></td>
                        </tr>
                        <tr>
                            <th>Kelurahan/Desa</th>
                            <td><?php echo htmlspecialchars($address['kelurahan_desa']); ?></td>
                        </tr>
                        <tr>
                            <th>RT/RW</th>
                            <td><?php echo htmlspecialchars($address['rt_rw']); ?></td>
                        </tr>
                        <tr>
                            <th>Detail Alamat</th>
                            <td><?php echo htmlspecialchars($address['detail_alamat']); ?></td>
                        </tr>
                        <?php if (!empty($address['link_maps'])): ?>
                            <tr>
                                <th>Link Maps</th>
                                <td><a href="<?php echo htmlspecialchars($address['link_maps']); ?>"
                                        target="_blank" class="text-primary">
                                        <i class="bi bi-geo-alt-fill"></i> Lihat di Maps
                                    </a></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <!-- Password Update Section -->
                <div class="profile-section">
                    <h2><i class="bi bi-key"></i> Update Password</h2>
                    <form id="passwordUpdateForm" class="password-form">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control" id="currentPassword" name="current_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="newPassword" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-check-circle"></i> Update Password
                        </button>
                    </form>
                    <div class="alert" role="alert"></div>
                    <a href="logout" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
                <div class="col-md-12">
                    <a href="helpdesk" class="btn btn-primary w-100">
                        <i class="bi bi-info-circle"></i> Helpdesk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0"> 2025 SkyLink Market. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('passwordUpdateForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const alert = document.querySelector('.alert');

            // Validasi password
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                alert.style.display = 'block';
                alert.className = 'alert alert-danger';
                alert.textContent = 'Password baru dan konfirmasi password tidak sama.';
                return;
            }

            fetch('update_password', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alert.style.display = 'block';
                    if (data.success) {
                        alert.className = 'alert alert-success';
                        alert.textContent = data.message;
                        this.reset();
                    } else {
                        alert.className = 'alert alert-danger';
                        alert.textContent = data.message;
                    }
                })
                .catch(error => {
                    alert.style.display = 'block';
                    alert.className = 'alert alert-danger';
                    alert.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                });
        });
    </script>
</body>

</html>
