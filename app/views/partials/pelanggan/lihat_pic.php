<!-- views/pelanggan/lihat_pic.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $this->view->page_title; ?></title>
    <!-- Sertakan CSS atau library lain jika diperlukan -->
</head>
<body>
    <h1><?php echo $this->view->page_title; ?></h1>
    
    <!-- Tampilkan data PIC Perusahaan -->
    <?php if(!empty($data->records)) { ?>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama PIC</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>No. Ponsel</th>
                    <th>NIK</th>
                    <th>Email</th>
                    <!-- Tambahkan kolom lain sesuai kebutuhan -->
                </tr>
            </thead>
            <tbody>
                <?php foreach($data->records as $record){ ?>
                    <tr>
                        <td><?php echo $record['id']; ?></td>
                        <td><?php echo $record['nama_pic']; ?></td>
                        <td><?php echo $record['jabatan']; ?></td>
                        <td><?php echo $record['departemen']; ?></td>
                        <td><?php echo $record['no_ponsel']; ?></td>
                        <td><?php echo $record['nik']; ?></td>
                        <td><?php echo $record['email']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Data PIC Perusahaan tidak tersedia untuk pelanggan ini.</p>
    <?php } ?>
    
    <!-- Tombol kembali ke halaman pelanggan -->
    <p><a href="<?php echo print_link('pelanggan'); ?>">Kembali ke Daftar Pelanggan</a></p>
</body>
</html>
