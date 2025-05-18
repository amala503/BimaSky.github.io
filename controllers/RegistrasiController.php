<?php
require_once __DIR__ . '/../models/Registrasi.php';
require_once __DIR__ . '/../config/db_connection.php';

class RegistrasiController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new Registrasi($this->conn);
    }

    public function step1() {
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
            // Validasi input
            $errors = [];

            // Validasi username
            if ($this->model->isUsernameExists($_POST['username'])) {
                $errors[] = "Username sudah terdaftar. Silakan gunakan username lain.";
            }

            // Validasi email
            if ($this->model->isEmailExists($_POST['emailPerusahaan'])) {
                $errors[] = "Email perusahaan sudah terdaftar. Silakan gunakan email lain.";
            }

            if (empty($errors)) {
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
            } else {
                // Simpan error ke session
                $_SESSION['errors'] = $errors;
            }
        }

        // Tampilkan view
        require_once __DIR__ . '/../views/registrasi_step1_view.php';
    }

    public function step2() {
        // Cek apakah data step 1 sudah diisi
        if (!isset($_SESSION['jenisBisnis']) || !isset($_SESSION['namaPerusahaan'])) {
            header("Location: registrasi.1.php");
            exit();
        }

        // Ambil data yang tersimpan di session (jika ada)
        $namaPIC = isset($_SESSION['namaPIC']) ? $_SESSION['namaPIC'] : '';
        $jabatan = isset($_SESSION['jabatan']) ? $_SESSION['jabatan'] : '';
        $departemen = isset($_SESSION['departemen']) ? $_SESSION['departemen'] : '';
        $noPonsel = isset($_SESSION['noPonsel']) ? $_SESSION['noPonsel'] : '';
        $emailPIC = isset($_SESSION['emailPIC']) ? $_SESSION['emailPIC'] : '';

        // Proses penyimpanan data ke session
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Simpan data ke session
            $_SESSION['namaPIC'] = $_POST['namaPIC'];
            $_SESSION['jabatan'] = $_POST['jabatan'];
            $_SESSION['departemen'] = $_POST['departemen'];
            $_SESSION['noPonsel'] = $_POST['noPonsel'];
            $_SESSION['emailPIC'] = $_POST['emailPIC'];

            // Redirect ke halaman berikutnya
            header("Location: registrasi.3.php");
            exit();
        }

        // Tampilkan view
        require_once __DIR__ . '/../views/registrasi_step2_view.php';
    }

    public function step3() {
        // Cek apakah data step 2 sudah diisi
        if (!isset($_SESSION['namaPIC']) || !isset($_SESSION['jabatan'])) {
            header("Location: registrasi.2.php");
            exit();
        }

        // Ambil data yang tersimpan di session (jika ada)
        $provinsi = isset($_SESSION['provinsi']) ? $_SESSION['provinsi'] : '';
        $kabupaten = isset($_SESSION['kabupaten']) ? $_SESSION['kabupaten'] : '';
        $kecamatan = isset($_SESSION['kecamatan']) ? $_SESSION['kecamatan'] : '';
        $kelurahan = isset($_SESSION['kelurahan']) ? $_SESSION['kelurahan'] : '';
        $rtRw = isset($_SESSION['rtRw']) ? $_SESSION['rtRw'] : '';
        $detailAlamat = isset($_SESSION['detailAlamat']) ? $_SESSION['detailAlamat'] : '';
        $linkMaps = isset($_SESSION['linkMaps']) ? $_SESSION['linkMaps'] : '';

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
        curl_close($curl);

        $provinsi_data = [];
        if (!$err) {
            $data = json_decode($response, true);
            if (isset($data['data']['list']) && is_array($data['data']['list'])) {
                $provinsi_data = $data['data']['list'];
            }
        }

        // Proses penyimpanan data ke session dan database
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Simpan data ke session
            $_SESSION['provinsi'] = $_POST['provinsi'];
            $_SESSION['kabupaten'] = $_POST['kabupatenKota'];
            $_SESSION['kecamatan'] = $_POST['kecamatan'];
            $_SESSION['kelurahan'] = $_POST['kelurahanDesa'];
            $_SESSION['rtRw'] = $_POST['rtRw'];
            $_SESSION['detailAlamat'] = $_POST['detailAlamat'];
            $_SESSION['linkMaps'] = $_POST['linkMaps'];

            // Simpan data ke database
            $dataPelanggan = [
                'jenis_bisnis' => $_SESSION['jenisBisnis'],
                'kategori_bisnis' => $_SESSION['kategoriBisnis'],
                'nama_perusahaan' => $_SESSION['namaPerusahaan'],
                'nomor_npwp' => $_SESSION['npwp'],
                'email_perusahaan' => $_SESSION['emailPerusahaan'],
                'no_telepon' => $_SESSION['teleponPerusahaan'],
                'username' => $_SESSION['username'],
                'password' => $_SESSION['password'],
                'sumber_informasi' => $_SESSION['sumberInformasi']
            ];

            $pelangganId = $this->model->registerPelanggan($dataPelanggan);

            if ($pelangganId) {
                // Simpan data PIC
                $dataPIC = [
                    'nama_pic' => $_SESSION['namaPIC'],
                    'jabatan' => $_SESSION['jabatan'],
                    'departemen' => $_SESSION['departemen'],
                    'no_ponsel' => $_SESSION['noPonsel'],
                    'email' => $_SESSION['emailPIC']
                ];

                $this->model->registerPIC($dataPIC, $pelangganId);

                // Simpan data alamat
                $dataAlamat = [
                    'provinsi' => $_SESSION['provinsi'],
                    'kabupaten_kota' => $_SESSION['kabupaten'],
                    'kecamatan' => $_SESSION['kecamatan'],
                    'kelurahan_desa' => $_SESSION['kelurahan'],
                    'rt_rw' => $_SESSION['rtRw'],
                    'detail_alamat' => $_SESSION['detailAlamat'],
                    'link_maps' => $_SESSION['linkMaps']
                ];

                $this->model->registerAlamat($dataAlamat, $pelangganId);

                // Hapus data session
                $this->clearRegistrationSession();

                // Set session untuk login
                $_SESSION['user_id'] = $pelangganId;
                $_SESSION['username'] = $dataPelanggan['username'];
                $_SESSION['nama_pelanggan'] = $dataPelanggan['nama_perusahaan'];
                $_SESSION['pic_perusahaan'] = $dataPIC['nama_pic'];
                $_SESSION['status'] = 'active';
                $_SESSION['is_logged_in'] = true;

                // Redirect ke halaman sukses
                header("Location: registrasi.success.php");
                exit();
            } else {
                $_SESSION['errors'] = ["Gagal mendaftarkan pelanggan. Silakan coba lagi."];
            }
        }

        // Tampilkan view
        require_once __DIR__ . '/../views/registrasi_step3_api_view.php';
    }

    public function success() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        // Tampilkan view
        require_once __DIR__ . '/../views/registrasi_sukses_view.php';
    }

    private function clearRegistrationSession() {
        // Hapus data session registrasi
        unset($_SESSION['jenisBisnis']);
        unset($_SESSION['kategoriBisnis']);
        unset($_SESSION['namaPerusahaan']);
        unset($_SESSION['npwp']);
        unset($_SESSION['emailPerusahaan']);
        unset($_SESSION['teleponPerusahaan']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['sumberInformasi']);
        unset($_SESSION['namaPIC']);
        unset($_SESSION['jabatan']);
        unset($_SESSION['departemen']);
        unset($_SESSION['noPonsel']);
        unset($_SESSION['emailPIC']);
        unset($_SESSION['provinsi']);
        unset($_SESSION['kabupaten']);
        unset($_SESSION['kecamatan']);
        unset($_SESSION['kelurahan']);
        unset($_SESSION['rtRw']);
        unset($_SESSION['detailAlamat']);
        unset($_SESSION['linkMaps']);
        unset($_SESSION['errors']);
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
