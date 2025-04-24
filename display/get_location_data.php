<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dtptelkomsat';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'get_kabupaten':
        $provinsi_id = $_POST['provinsi_id'] ?? '';
        if ($provinsi_id) {
            $query = "SELECT * FROM kabupaten WHERE provinsi_id = ? ORDER BY nama_kabupaten";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $provinsi_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $output = '<option value="">Pilih Kabupaten/Kota</option>';
            while ($row = $result->fetch_assoc()) {
                $output .= sprintf(
                    '<option value="%s">%s</option>',
                    htmlspecialchars($row['id_kabupaten']),
                    htmlspecialchars($row['nama_kabupaten'])
                );
            }
            echo $output;
            $stmt->close();
        }
        break;

    case 'get_kecamatan':
        $kabupaten_id = $_POST['kabupaten_id'] ?? '';
        if ($kabupaten_id) {
            $query = "SELECT * FROM kecamatan WHERE kabupaten_id = ? ORDER BY nama_kecamatan";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $kabupaten_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $output = '<option value="">Pilih Kecamatan</option>';
            while ($row = $result->fetch_assoc()) {
                $output .= sprintf(
                    '<option value="%s">%s</option>',
                    htmlspecialchars($row['id_kecamatan']),
                    htmlspecialchars($row['nama_kecamatan'])
                );
            }
            echo $output;
            $stmt->close();
        }
        break;

    case 'get_kelurahan':
        $kecamatan_id = $_POST['kecamatan_id'] ?? '';
        if ($kecamatan_id) {
            $query = "SELECT * FROM kelurahan WHERE kecamatan_id = ? ORDER BY nama_kelurahan";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $kecamatan_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $output = '<option value="">Pilih Kelurahan/Desa</option>';
            while ($row = $result->fetch_assoc()) {
                $output .= sprintf(
                    '<option value="%s">%s</option>',
                    htmlspecialchars($row['id_kelurahan']),
                    htmlspecialchars($row['nama_kelurahan'])
                );
            }
            echo $output;
            $stmt->close();
        }
        break;
}

$conn->close();
