<?php
require_once __DIR__ . '/../models/Location.php';
require_once __DIR__ . '/../config/db_connection.php';

class LocationController {
    private $model;
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->model = new Location($this->conn);
    }

    /**
     * Mendapatkan data lokasi berdasarkan action
     */
    public function getLocationData() {
        // Cek apakah ada parameter action
        if (!isset($_POST['action'])) {
            echo "Parameter action tidak ditemukan.";
            return;
        }

        $action = $_POST['action'];

        switch ($action) {
            case 'get_kabupaten':
                $this->getKabupaten();
                break;
            case 'get_kecamatan':
                $this->getKecamatan();
                break;
            case 'get_kelurahan':
                $this->getKelurahan();
                break;
            default:
                echo "Action tidak valid.";
                break;
        }
    }

    /**
     * Mendapatkan daftar kabupaten berdasarkan ID provinsi
     */
    private function getKabupaten() {
        $provinsi_id = $_POST['provinsi_id'] ?? '';
        
        if (empty($provinsi_id)) {
            echo '<option value="">Pilih Kabupaten/Kota</option>';
            return;
        }
        
        $kabupaten = $this->model->getKabupaten($provinsi_id);
        
        $output = '<option value="">Pilih Kabupaten/Kota</option>';
        foreach ($kabupaten as $row) {
            $output .= sprintf(
                '<option value="%s">%s</option>',
                htmlspecialchars($row['id_kabupaten']),
                htmlspecialchars($row['nama_kabupaten'])
            );
        }
        
        echo $output;
    }

    /**
     * Mendapatkan daftar kecamatan berdasarkan ID kabupaten
     */
    private function getKecamatan() {
        $kabupaten_id = $_POST['kabupaten_id'] ?? '';
        
        if (empty($kabupaten_id)) {
            echo '<option value="">Pilih Kecamatan</option>';
            return;
        }
        
        $kecamatan = $this->model->getKecamatan($kabupaten_id);
        
        $output = '<option value="">Pilih Kecamatan</option>';
        foreach ($kecamatan as $row) {
            $output .= sprintf(
                '<option value="%s">%s</option>',
                htmlspecialchars($row['id_kecamatan']),
                htmlspecialchars($row['nama_kecamatan'])
            );
        }
        
        echo $output;
    }

    /**
     * Mendapatkan daftar kelurahan berdasarkan ID kecamatan
     */
    private function getKelurahan() {
        $kecamatan_id = $_POST['kecamatan_id'] ?? '';
        
        if (empty($kecamatan_id)) {
            echo '<option value="">Pilih Kelurahan/Desa</option>';
            return;
        }
        
        $kelurahan = $this->model->getKelurahan($kecamatan_id);
        
        $output = '<option value="">Pilih Kelurahan/Desa</option>';
        foreach ($kelurahan as $row) {
            $output .= sprintf(
                '<option value="%s">%s</option>',
                htmlspecialchars($row['id_kelurahan']),
                htmlspecialchars($row['nama_kelurahan'])
            );
        }
        
        echo $output;
    }

    public function __destruct() {
        Database::closeConnection();
    }
}
?>
