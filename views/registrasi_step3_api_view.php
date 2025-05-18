<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Step 3 - SkyLink Market</title>
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
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent-color);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(0, 180, 216, 0.25);
        }
        .form-control::placeholder, .form-select::placeholder {
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
            width: 100%;
            height: 100%;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }
        .input-group-text {
            background: transparent;
            border-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .form-select::-ms-expand {
            display: none;
        }
        .form-select option {
            background: #1a237e;
            color: white;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="text-center mb-4">
                <i class="bi bi-broadcast display-1 text-primary mb-3"></i>
                <h2 class="text-white mb-3">Buat akun</h2>
                <p class="text-white-50">Step 3 of 3: Alamat</p>
                <div class="progress-bar">
                    <div class="progress-step"></div>
                </div>
            </div>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="provinsi" class="form-label text-white">Provinsi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-map text-white"></i>
                        </span>
                        <select class="form-select border-start-0" id="provinsi" name="provinsi" required>
                            <option value="">Pilih Provinsi</option>
                            <?php foreach ($provinsi_data as $provinsi) { ?>
                                <option value="<?= htmlspecialchars($provinsi['id']) ?>"><?= htmlspecialchars($provinsi['nama']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="kabupatenKota" class="form-label text-white">Kabupaten/Kota</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-building text-white"></i>
                        </span>
                        <select class="form-select border-start-0" id="kabupatenKota" name="kabupatenKota" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="kecamatan" class="form-label text-white">Kecamatan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-geo text-white"></i>
                        </span>
                        <select class="form-select border-start-0" id="kecamatan" name="kecamatan" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="kelurahanDesa" class="form-label text-white">Kelurahan/Desa</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-house text-white"></i>
                        </span>
                        <select class="form-select border-start-0" id="kelurahanDesa" name="kelurahanDesa" required>
                            <option value="">Pilih Kelurahan/Desa</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="rtRw" class="form-label text-white">RT/RW</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-signpost text-white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="rtRw" name="rtRw" 
                            placeholder="Contoh: 001/002" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="detailAlamat" class="form-label text-white">Detail Alamat</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-geo-alt text-white"></i>
                        </span>
                        <textarea class="form-control border-start-0" id="detailAlamat" name="detailAlamat" 
                            placeholder="Masukkan detail alamat" rows="3" required></textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="linkMaps" class="form-label text-white">Link Google Maps (Opsional)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-pin-map text-white"></i>
                        </span>
                        <input type="url" class="form-control border-start-0" id="linkMaps" name="linkMaps" 
                            placeholder="https://maps.google.com/...">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="registrasi.2" class="btn btn-outline-light btn-lg flex-grow-1">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                        <i class="bi bi-check-circle me-2"></i>Finish
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Debug mode
            const debug = true;
            function debugLog(message) {
                if (debug) {
                    console.log(message);
                }
            }

            // Fungsi untuk menonaktifkan dropdown yang bergantung
            function resetDropdown(dropdown, message = 'Pilih...') {
                dropdown.html('<option value="">' + message + '</option>');
                dropdown.prop('disabled', true);
            }

            // Fungsi untuk menangani error
            function handleError(dropdown, error) {
                debugLog('Error:', error);
                dropdown.html('<option value="">Error loading data</option>');
                dropdown.prop('disabled', false);
            }

            // Event handler untuk perubahan provinsi
            $('#provinsi').change(function () {
                const provinsi_id = $(this).val();
                debugLog('Provinsi changed:', provinsi_id);

                const kabupatenSelect = $('#kabupatenKota');
                const kecamatanSelect = $('#kecamatan');
                const kelurahanSelect = $('#kelurahanDesa');

                // Reset dropdown yang bergantung
                resetDropdown(kabupatenSelect, 'Pilih Kabupaten/Kota');
                resetDropdown(kecamatanSelect, 'Pilih Kecamatan');
                resetDropdown(kelurahanSelect, 'Pilih Kelurahan/Desa');

                if (provinsi_id) {
                    // Ambil data kabupaten
                    $.ajax({
                        url: 'get_location_data',
                        type: 'POST',
                        data: {
                            action: 'get_kabupaten',
                            provinsi_id: provinsi_id
                        },
                        success: function(response) {
                            kabupatenSelect.html(response);
                            kabupatenSelect.prop('disabled', false);
                        },
                        error: function(xhr, status, error) {
                            handleError(kabupatenSelect, error);
                        }
                    });
                }
            });

            // Event handler untuk perubahan kabupaten
            $('#kabupatenKota').change(function () {
                const kabupaten_id = $(this).val();
                debugLog('Kabupaten changed:', kabupaten_id);

                const kecamatanSelect = $('#kecamatan');
                const kelurahanSelect = $('#kelurahanDesa');

                // Reset dropdown yang bergantung
                resetDropdown(kecamatanSelect, 'Pilih Kecamatan');
                resetDropdown(kelurahanSelect, 'Pilih Kelurahan/Desa');

                if (kabupaten_id) {
                    // Ambil data kecamatan
                    $.ajax({
                        url: 'get_location_data',
                        type: 'POST',
                        data: {
                            action: 'get_kecamatan',
                            kabupaten_id: kabupaten_id
                        },
                        success: function(response) {
                            kecamatanSelect.html(response);
                            kecamatanSelect.prop('disabled', false);
                        },
                        error: function(xhr, status, error) {
                            handleError(kecamatanSelect, error);
                        }
                    });
                }
            });

            // Event handler untuk perubahan kecamatan
            $('#kecamatan').change(function () {
                const kecamatan_id = $(this).val();
                debugLog('Kecamatan changed:', kecamatan_id);

                const kelurahanSelect = $('#kelurahanDesa');

                // Reset dropdown yang bergantung
                resetDropdown(kelurahanSelect, 'Pilih Kelurahan/Desa');

                if (kecamatan_id) {
                    // Ambil data kelurahan
                    $.ajax({
                        url: 'get_location_data',
                        type: 'POST',
                        data: {
                            action: 'get_kelurahan',
                            kecamatan_id: kecamatan_id
                        },
                        success: function(response) {
                            kelurahanSelect.html(response);
                            kelurahanSelect.prop('disabled', false);
                        },
                        error: function(xhr, status, error) {
                            handleError(kelurahanSelect, error);
                        }
                    });
                }
            });

            // Add loading state to buttons
            $('form').on('submit', function() {
                $(this).find('button[type="submit"]').html('<span class="spinner-border spinner-border-sm me-2"></span>Loading...');
                $(this).find('button[type="submit"]').prop('disabled', true);
            });
        });
    </script>
</body>
</html>
