<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://strayneko.fly.dev/api/kecamatan/1',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;




// Periksa apakah respons valid
if ($response) {
    // Decode JSON ke array asosiatif
    $data = json_decode($response, true);

    // Pastikan data adalah array dan ada data yang bisa diakses
    if (isset($data['data']['list']) && is_array($data['data']['list'])) {
        // Tampilkan nama provinsi
        foreach ($data['data']['list'] as $kecamatan) {
            echo $kecamatan['nama'] . "<br>";
        }
    } else {
        echo "Data kecamatan tidak ditemukan.";
    }
} else {
    echo "Gagal mendapatkan respons dari API.";
}
?>
