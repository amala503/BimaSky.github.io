<?php
// Start output buffering
ob_start();

session_start();

// Pastikan data dari step sebelumnya tersedia
if (!isset($_SESSION['namaPerusahaan']) || !isset($_SESSION['namaPIC'])) {
    header("Location: registrasi.1.php");
    exit();
}

// Debug mode
$debug = true;
$debug_messages = [];
function debug_log($message) {
    global $debug, $debug_messages;
    if ($debug) {
        $debug_messages[] = $message;
    }
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

// Mengambil daftar provinsi dari API
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://strayneko.fly.dev/api/provinsi',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
$err = curl_error($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

debug_log("Provinsi API Response Code: " . $http_code);
if ($err) {
    debug_log("Curl Error: " . $err);
}
debug_log("Provinsi API Response: " . $response);

$provinsi_data = [];
if ($err) {
    echo "<script>console.error('Error mengambil data provinsi: " . $err . "');</script>";
} else {
    $data = json_decode($response, true);
    if (isset($data['data']['list']) && is_array($data['data']['list'])) {
        $provinsi_data = $data['data']['list'];
        debug_log("Jumlah provinsi: " . count($provinsi_data));
    } else {
        debug_log("Format data provinsi tidak sesuai");
        debug_log($data);
    }
}

// Inisialisasi array untuk data wilayah
$kabupaten_kota_data = [];
$kecamatan_data = [];
$kelurahan_desa_data = [];

// Jika ada request POST, ambil data wilayah yang dipilih
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data kabupaten/kota jika provinsi dipilih
    if (!empty($_POST['provinsi'])) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://strayneko.fly.dev/api/kabupaten/' . urlencode($_POST['provinsi']),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        debug_log("Kabupaten API Response Code: " . $http_code);
        if ($err) {
            debug_log("Curl Error: " . $err);
        }
        debug_log("Kabupaten API Response: " . $response);

        if (!$err) {
            $data = json_decode($response, true);
            if (isset($data['data']['list']) && is_array($data['data']['list'])) {
                $kabupaten_kota_data = $data['data']['list'];
                debug_log("Jumlah kabupaten/kota: " . count($kabupaten_kota_data));
            } else {
                debug_log("Format data kabupaten/kota tidak sesuai");
                debug_log($data);
            }
        }
    }

    // Mengambil data kecamatan jika kabupaten dipilih
    if (!empty($_POST['kabupatenKota'])) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://strayneko.fly.dev/api/kecamatan/' . urlencode($_POST['kabupatenKota']),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        debug_log("Kecamatan API Response Code: " . $http_code);
        if ($err) {
            debug_log("Curl Error: " . $err);
        }
        debug_log("Kecamatan API Response: " . $response);

        if (!$err) {
            $data = json_decode($response, true);
            if (isset($data['data']['list']) && is_array($data['data']['list'])) {
                $kecamatan_data = $data['data']['list'];
                debug_log("Jumlah kecamatan: " . count($kecamatan_data));
            } else {
                debug_log("Format data kecamatan tidak sesuai");
                debug_log($data);
            }
        }
    }

    // Mengambil data kelurahan jika kecamatan dipilih
    if (!empty($_POST['kecamatan'])) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://strayneko.fly.dev/api/kelurahan/' . urlencode($_POST['kecamatan']),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        debug_log("Kelurahan API Response Code: " . $http_code);
        if ($err) {
            debug_log("Curl Error: " . $err);
        }
        debug_log("Kelurahan API Response: " . $response);

        if (!$err) {
            $data = json_decode($response, true);
            if (isset($data['data']['list']) && is_array($data['data']['list'])) {
                $kelurahan_desa_data = $data['data']['list'];
                debug_log("Jumlah kelurahan/desa: " . count($kelurahan_desa_data));
            } else {
                debug_log("Format data kelurahan/desa tidak sesuai");
                debug_log($data);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->begin_transaction();
    try {
        // 1. Simpan data pelanggan (Step 1)
        if (!isset($_SESSION['jenisBisnis']) || !isset($_SESSION['kategoriBisnis']) || !isset($_SESSION['namaPerusahaan']) 
            || !isset($_SESSION['npwp']) || !isset($_SESSION['emailPerusahaan']) || !isset($_SESSION['teleponPerusahaan']) 
            || !isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION['sumberInformasi'])) {
            throw new Exception("Data pelanggan tidak lengkap");
        }
        
        $stmt = $conn->prepare("INSERT INTO pelanggan (jenis_bisnis, kategori_bisnis, nama_perusahaan, nomor_npwp, email_perusahaan, no_telepon, username, password, sumber_informasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparing pelanggan statement: " . $conn->error);
        }
        
        $stmt->bind_param("sssssssss", 
            $_SESSION['jenisBisnis'],
            $_SESSION['kategoriBisnis'],
            $_SESSION['namaPerusahaan'],
            $_SESSION['npwp'],
            $_SESSION['emailPerusahaan'],
            $_SESSION['teleponPerusahaan'],
            $_SESSION['username'],
            $_SESSION['password'],
            $_SESSION['sumberInformasi']
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing pelanggan statement: " . $stmt->error);
        }
        $pelanggan_id = $conn->insert_id;
        $stmt->close();

        // 2. Simpan data PIC perusahaan (Step 2)
        if (!isset($_SESSION['namaPIC']) || !isset($_SESSION['jabatanPIC']) || !isset($_SESSION['emailPIC']) 
            || !isset($_SESSION['teleponPIC']) || !isset($_SESSION['dokumenLegalitas']) || !isset($_SESSION['fotoAkta']) 
            || !isset($_SESSION['fotoNIB'])) {
            throw new Exception("Data PIC tidak lengkap");
        }
        
        $stmt = $conn->prepare("INSERT INTO pic_perusahaan (pelanggan_id, nama_pic, jabatan, email, no_ponsel, dokumen_legalitas, foto_akta_pendirian, foto_nib_isp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparing PIC statement: " . $conn->error);
        }
        
        $stmt->bind_param("isssssss", 
            $pelanggan_id,
            $_SESSION['namaPIC'],
            $_SESSION['jabatanPIC'],
            $_SESSION['emailPIC'],
            $_SESSION['teleponPIC'],
            $_SESSION['dokumenLegalitas'],
            $_SESSION['fotoAkta'],
            $_SESSION['fotoNIB']
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing PIC statement: " . $stmt->error);
        }
        $stmt->close();

        // 3. Simpan data alamat (Step 3)
        $provinsi = $_POST['provinsi'] ?? '';
        $kabupaten_kota = $_POST['kabupatenKota'] ?? '';
        $kecamatan = $_POST['kecamatan'] ?? '';
        $kelurahan_desa = $_POST['kelurahanDesa'] ?? '';
        $rt_rw = $_POST['rtRw'] ?? '';
        $detail_alamat = $_POST['detailAlamat'] ?? '';
        $link_maps = $_POST['linkMaps'] ?? '';

        if (empty($provinsi) || empty($kabupaten_kota) || empty($kecamatan) || empty($kelurahan_desa) 
            || empty($rt_rw) || empty($detail_alamat)) {
            throw new Exception("Data alamat tidak lengkap");
        }

        // Mencari nama-nama wilayah dari data API
        $provinsi_name = '';
        $kabupaten_name = '';
        $kecamatan_name = '';
        $kelurahan_name = '';

        foreach ($provinsi_data as $prov) {
            if ($prov['id'] == $provinsi) {
                $provinsi_name = $prov['nama'];
                break;
            }
        }
        foreach ($kabupaten_kota_data as $kab) {
            if ($kab['id'] == $kabupaten_kota) {
                $kabupaten_name = $kab['nama'];
                break;
            }
        }
        foreach ($kecamatan_data as $kec) {
            if ($kec['id'] == $kecamatan) {
                $kecamatan_name = $kec['nama'];
                break;
            }
        }
        foreach ($kelurahan_desa_data as $kel) {
            if ($kel['id'] == $kelurahan_desa) {
                $kelurahan_name = $kel['nama'];
                break;
            }
        }

        if (empty($provinsi_name) || empty($kabupaten_name) || empty($kecamatan_name) || empty($kelurahan_name)) {
            throw new Exception("Gagal mendapatkan nama wilayah dari API");
        }

        $stmt = $conn->prepare("INSERT INTO alamat_perusahaan (pelanggan_id, provinsi, kabupaten_kota, kecamatan, kelurahan_desa, rt_rw, detail_alamat, link_maps) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparing alamat statement: " . $conn->error);
        }
        
        $stmt->bind_param("isssssss", 
            $pelanggan_id,
            $provinsi_name,
            $kabupaten_name,
            $kecamatan_name,
            $kelurahan_name,
            $rt_rw,
            $detail_alamat,
            $link_maps
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Error executing alamat statement: " . $stmt->error);
        }
        $stmt->close();

        // Commit transaksi jika semua operasi berhasil
        $conn->commit();
        
        // Hapus semua data session registrasi
        $session_keys = [
            'jenisBisnis', 'kategoriBisnis', 'namaPerusahaan', 'npwp', 'emailPerusahaan', 
            'teleponPerusahaan', 'username', 'password', 'sumberInformasi',
            'namaPIC', 'jabatanPIC', 'emailPIC', 'teleponPIC', 'dokumenLegalitas', 
            'fotoAkta', 'fotoNIB'
        ];
        foreach ($session_keys as $key) {
            unset($_SESSION[$key]);
        }
        
        // Redirect ke halaman sukses
        header("Location: registrasi.sukses.php");
        exit();

    } catch (Exception $e) {
        // Rollback jika terjadi error
        $conn->rollback();
        $error = "Terjadi kesalahan saat menyimpan data: " . $e->getMessage();
        echo "<script>alert('" . htmlspecialchars($error) . "');</script>";
    }
}
$conn->close();
?>

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
                            placeholder="Masukkan alamat lengkap" rows="3" required></textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="linkMaps" class="form-label text-white">Link Maps</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-pin-map text-white"></i>
                        </span>
                        <input type="url" class="form-control border-start-0" id="linkMaps" name="linkMaps" 
                            placeholder="Masukkan link Google Maps" required>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="registrasi.2.php" class="btn btn-outline-light btn-lg flex-grow-1">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                        Complete <i class="bi bi-check2-circle ms-2"></i>
                    </button>
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

            // Fungsi untuk mengisi dropdown dengan data
            function populateDropdown(dropdown, data, defaultText = 'Pilih...') {
                debugLog('Populating dropdown:', dropdown.attr('id'));
                debugLog('Data:', data);
                
                dropdown.html('<option value="">' + defaultText + '</option>');
                if (data && Array.isArray(data)) {
                    data.forEach(function (item) {
                        dropdown.append('<option value="' + item.id + '">' + item.nama + '</option>');
                    });
                    debugLog('Added ' + data.length + ' options to dropdown');
                } else {
                    debugLog('No data or invalid data format');
                }
                dropdown.prop('disabled', false);
            }

            // Fungsi untuk melakukan AJAX request
            function fetchData(url, dropdown, defaultText) {
                debugLog('Fetching data from:', url);
                dropdown.prop('disabled', true);
                dropdown.html('<option value="">Loading...</option>');

                return $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    timeout: 30000, // 30 detik timeout
                    beforeSend: function() {
                        debugLog('Starting AJAX request to ' + url);
                    }
                })
                .done(function(response) {
                    debugLog('Response received:', response);
                    if (response && response.data && response.data.list) {
                        populateDropdown(dropdown, response.data.list, defaultText);
                    } else {
                        handleError(dropdown, 'Invalid data format');
                    }
                })
                .fail(function(xhr, status, error) {
                    debugLog('AJAX Error:', {xhr: xhr, status: status, error: error});
                    handleError(dropdown, error);
                })
                .always(function() {
                    debugLog('AJAX request completed');
                });
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
                    fetchData(
                        'https://strayneko.fly.dev/api/kabupaten/' + encodeURIComponent(provinsi_id),
                        kabupatenSelect,
                        'Pilih Kabupaten/Kota'
                    );
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
                    fetchData(
                        'https://strayneko.fly.dev/api/kecamatan/' + encodeURIComponent(kabupaten_id),
                        kecamatanSelect,
                        'Pilih Kecamatan'
                    );
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
                    fetchData(
                        'https://strayneko.fly.dev/api/kelurahan/' + encodeURIComponent(kecamatan_id),
                        kelurahanSelect,
                        'Pilih Kelurahan/Desa'
                    );
                }
            });

            // Add loading state to buttons
            $('form').on('submit', function() {
                $(this).find('button[type="submit"]').html('<span class="spinner-border spinner-border-sm me-2"></span>Loading...');
                $(this).find('button[type="submit"]').prop('disabled', true);
            });

            // Debug initial state
            debugLog('Initial provinsi data:', $('#provinsi option').length - 1);
        });
    </script>
</body>
</html>

<?php
// Output debug messages
if ($debug && !empty($debug_messages)) {
    echo "<script>\n";
    foreach ($debug_messages as $message) {
        echo "console.log(" . json_encode($message) . ");\n";
    }
    echo "</script>\n";
}

// Flush output buffer
ob_end_flush();
?>
