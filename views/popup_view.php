<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Alamat Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            background: #495057;
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }
        .form-control {
            background-color: #6c757d;
            color: #ffffff;
            border: 1px solid #ced4da;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Detail Alamat Perusahaan</h2>
        <?php if ($data): ?>
            <div class="mb-3">
                <label class="form-label">Provinsi</label>
                <input type="text" class="form-control" value="<?= $data['provinsi']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Kabupaten/Kota</label>
                <input type="text" class="form-control" value="<?= $data['kabupaten_kota']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Kecamatan</label>
                <input type="text" class="form-control" value="<?= $data['kecamatan']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Kelurahan/Desa</label>
                <input type="text" class="form-control" value="<?= $data['kelurahan_desa']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">RT/RW</label>
                <input type="text" class="form-control" value="<?= $data['rt_rw']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Detail Alamat</label>
                <textarea class="form-control" rows="3" readonly><?= $data['detail_alamat']; ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Google Maps</label>
                <a href="<?= $data['link_maps']; ?>" target="_blank" class="btn btn-light w-100">Lihat di Google Maps</a>
            </div>
        <?php else: ?>
            <p class="text-center">Data alamat tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>

</html>
