-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 22, 2025 at 09:43 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dtptelkomsat`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat_perusahaan`
--

CREATE TABLE `alamat_perusahaan` (
  `id` int(11) NOT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `kabupaten_kota` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `kelurahan_desa` varchar(255) DEFAULT NULL,
  `rt_rw` varchar(20) DEFAULT NULL,
  `detail_alamat` text DEFAULT NULL,
  `link_maps` text DEFAULT NULL,
  `pelanggan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alamat_perusahaan`
--

INSERT INTO `alamat_perusahaan` (`id`, `provinsi`, `kabupaten_kota`, `kecamatan`, `kelurahan_desa`, `rt_rw`, `detail_alamat`, `link_maps`, `pelanggan_id`) VALUES
(10, '3', '69', '894', '13516', '02/01', 'jl.Pahlawan gg 5 no 10 Sampang, Madura, Jawa Timur', 'https://maps.app.goo.gl/FRDjCXQQ6XGYsL1E6', 20),
(11, '15', '239', '3535', '43497', '02/01', 'jl.Pahlawan gg 5 no 10 Sampang, Madura, Jawa Timur', 'https://maps.app.goo.gl/FRDjCXQQ6XGYsL1E6', 21),
(12, '15', '254', '3828', '48012', '0203', 'Rajawali no 38', 'https://maps.app.goo.gl/LaSHm89MTn9Ena3LA', 22),
(0, '2', '24', '291', '6518', '0203', 'Rajawali no 38', 'https://maps.app.goo.gl/LaSHm89MTn9Ena3LA', 23),
(0, '3', '57', '740', '12609', '0203', 'Rajawali no 38', 'https://maps.app.goo.gl/LaSHm89MTn9Ena3LA', 24),
(0, 'Aceh', '1', '1', '1', '0203', 'Rajawali no 38', 'https://maps.app.goo.gl/LaSHm89MTn9Ena3LA', 26),
(0, 'Aceh', 'Aceh Selatan', 'Bakongan', 'Keude Bakongan', '0203', 'Rajawali no 38', 'https://maps.app.goo.gl/LaSHm89MTn9Ena3LA', 27),
(0, 'Sumatera Utara', 'Tapanuli Tengah', 'Barus', 'Pasar Batu Gerigis', '0212', 'fsad', 'https://maps.app.goo.gl/LaSHm89MTn9Ena3LA', 47),
(0, 'Aceh', 'Aceh Selatan', 'Kluet Selatan', 'Indra Damai', '0203', 'fsadca', 'https://maps.app.goo.gl/LaSHm89MTn9Ena3LA', 48),
(0, 'Sumatera Utara', 'Tapanuli Tengah', 'Lumut', 'Aek Gambir', '0203', 'Jalan Tengku Umar No 32 dekat masjid', 'https://maps.app.goo.gl/LaSHm89MTn9Ena3LA', 51),
(0, 'Sumatera Barat', 'Solok', 'Junjung Sirih', 'Paninggahan', '0304', 'gsafsa', 'https://maps.app.goo.gl/LaSHm89MTn9Ena3LA', 52);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `nama_produk` varchar(225) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id`, `kuantitas`, `harga`, `nama_produk`, `pelanggan_id`, `status`) VALUES
(26, 1, '2147483647.00', 'Internet Satelit', 51, 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `detail_produk`
--

CREATE TABLE `detail_produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `spesifikasi_produk` text DEFAULT NULL,
  `gambar_produk` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_produk`
--

INSERT INTO `detail_produk` (`id`, `nama_produk`, `harga`, `spesifikasi_produk`, `gambar_produk`, `detail`) VALUES
(1, 'sndlkkmsd', 2000000, 'xasdaa', 'http://localhost/mytelkomsat/uploads/files/t1_w5hqzjayg3fr.jpg', 'xasdaa'),
(2, 'aaalkmkamx', 50000000, 'amxkjnakjaxkm', 'http://localhost/mytelkomsat/uploads/files/vc4ebqpo0ykfhm6.png', 'qmkemf]jsaakjfkl'),
(3, 'dffskmkdm', 40000000, 'nfjnfkjfe', 'http://localhost/mytelkomsat/uploads/files/lnuzswph8g0ay94.jpeg', 'ffjiejfkflenfkerhfuheuerr'),
(4, 'ppppppp', 2000000000, 'sangat bagus, bandwithnya tinggi. kecepatannya sangat tinggi', 'http://localhost/mytelkomsat/uploads/files/hqc4bes6ap3wof2.jpeg', 'ajahdkjahjguyyscccccccccccccccccccccc'),
(5, 'jsaaaaaaaa', 2147483647, 'hhhhhhhhhhhhhh', 'http://localhost/mytelkomsat/uploads/files/uh_089ovjq1ywal.png', 'lorem ipsum ajjiaoiy7wyqdbwhdblkfsij djwjiuj dhiwdu uwhdiuwhd uhdih idium');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jawaban` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `pertanyaan`, `jawaban`) VALUES
(1, 'Apa itu Layanan Satelit ?', 'Layanan satelit adalah sistem komunikasi yang menggunakan satelit untuk mengirim dan menerima data, termasuk televisi, internet, dan telepon.'),
(2, 'Bagaimana cara mendaftar akun?', 'Klik tombol &#34;Daftar&#34; di halaman utama, isi formulir pendaftaran dengan data yang valid, lalu verifikasi email yang dikirimkan untuk mengaktifkan akun Anda.'),
(3, 'bagaimana cara pesannya?', 'cara pesannya mudah sekali yaitu dengan melakukan registrasi dan login setelah itu memilih produknya');

-- --------------------------------------------------------

--
-- Table structure for table `kabupaten`
--

CREATE TABLE `kabupaten` (
  `id` int(11) NOT NULL,
  `nama_kabupaten` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `nama_kecamatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id` int(11) NOT NULL,
  `nama_kelurahan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_management`
--

CREATE TABLE `order_management` (
  `id` int(11) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `email_penerima` varchar(100) DEFAULT NULL,
  `nomor_telepon_penerima` varchar(15) DEFAULT NULL,
  `alamat_pengiriman` varchar(255) NOT NULL,
  `kota_pengiriman` varchar(100) DEFAULT NULL,
  `provinsi_pengiriman` varchar(100) DEFAULT NULL,
  `kode_pos_pengiriman` varchar(10) DEFAULT NULL,
  `negara_pengiriman` varchar(100) DEFAULT 'Indonesia',
  `detail_pesanan` text NOT NULL,
  `status_order` enum('Pending','Diproses','Dikirim','Selesai','Dibatalkan') DEFAULT 'Pending',
  `tanggal_order` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `jenis_bisnis` enum('B2B','B2C') NOT NULL,
  `kategori_bisnis` varchar(255) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `nomor_npwp` varchar(20) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `sumber_informasi` varchar(255) DEFAULT NULL,
  `email_perusahaan` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pic_perusahaan` varchar(225) NOT NULL,
  `alamat_perusahaan` varchar(255) DEFAULT NULL,
  `status` enum('pending','approve') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `jenis_bisnis`, `kategori_bisnis`, `nama_perusahaan`, `nomor_npwp`, `no_telepon`, `password`, `sumber_informasi`, `email_perusahaan`, `username`, `pic_perusahaan`, `alamat_perusahaan`, `status`) VALUES
(20, 'B2B', 'starlink', 'Brawijaya University', '011096187 622 000', '081805479617', 'mahasiswaUB', 'Rekomendasi', 'telkomsatelit@telkom.com', 'username', '', NULL, 'approve'),
(21, 'B2C', 'personal', 'Brawijaya University', '011096187 622 000', '081805479617', 'mahasiswaUB', 'Website', 'telkomsatelit@telkom.com', 'username', '', NULL, 'approve'),
(22, 'B2B', 'Bisnis daerah', 'PDAM Sampang', '877321824213', '09736274213', '12345', 'Media Sosial', 'perumdaairminumtrunojoyo@gmail.com', 'pdamsampang', '', NULL, 'approve'),
(23, 'B2B', 'Bisnis daerah', 'PDAM Sampang', '877321824213', '09736274213', '12345', 'Media Sosial', 'perumdaairminumtrunojoyo@gmail.com', 'pdamsampang', '', NULL, 'approve'),
(24, 'B2C', 'apasaja', 'fsajjdajfsa', '2342441', '42211312', '12345', 'Rekomendasi', 'fsadafsa@gmail.com', 'kemal', '', NULL, 'approve'),
(25, 'B2B', 'apasajafsdsacvsa', 'fsaacsacsaf', '32421321312', '423132341', 'gfsadsacsa', 'Website', 'gdsfasdw@gmail.com', 'suhidin', '', NULL, 'approve'),
(26, 'B2B', 'bxszcasf', 'vxasczv', '632423142341', '492421421', 'gfsadsacsa', 'Media Sosial', 'bnvasadsaf@gmail.com', 'bbek', '', NULL, 'approve'),
(27, 'B2B', 'bxszcasf3', 'vxasczv4', '6324231423413', '4924214212', 'gfsadsacsa', 'Media Sosial', 'bnvasadsaf3@gmail.com', 'bbek3', '', NULL, 'approve'),
(47, 'B2B', '2', 'Riskiya celll', '089721341', '0892312441', '12345', 'Website', 'riskiyacell@gmail.com', 'riskiya', '', NULL, 'approve'),
(48, 'B2C', 'Bisnis daerah', 'Riskiya Cell', '082983921783', '42211312', '123456', 'Website', 'kdmafksjfsa@gmail.com', 'user', '', NULL, 'approve'),
(51, 'B2B', 'kopluwak', 'kopiluwak', '082983921783', '24213121', '12345', 'Website', 'kemaltrad123@gmail.com', 'kopiluwak', '', NULL, 'approve'),
(52, 'B2B', 'Retail', 'Aqua', '087281342421', '2423123', '12345', 'Website', 'perumdaairminumtrunojoyo@gmail.com', 'qqqq', '', NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `tanggal_bayar` datetime DEFAULT current_timestamp(),
  `status` enum('Belum Dibayar','Dibayar') DEFAULT 'Belum Dibayar',
  `total_bayar` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id` int(11) NOT NULL,
  `nama_pengiriman` varchar(255) NOT NULL,
  `biaya` decimal(10,2) NOT NULL,
  `estimasi_waktu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `tanggal_pesanan` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Diproses','Dikirim','Selesai') DEFAULT 'Pending',
  `total_harga_produk` int(11) NOT NULL,
  `pajak` int(11) NOT NULL,
  `biaya_pengiriman` int(11) NOT NULL,
  `total_harga_akhir` int(11) NOT NULL,
  `metode_pembayaran` enum('Transfer') NOT NULL DEFAULT 'Transfer',
  `metode_pengiriman` varchar(50) DEFAULT NULL,
  `kode_pesanan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `pelanggan_id`, `tanggal_pesanan`, `status`, `total_harga_produk`, `pajak`, `biaya_pengiriman`, `total_harga_akhir`, `metode_pembayaran`, `metode_pengiriman`, `kode_pesanan`) VALUES
(14, 51, '2025-02-20 12:22:40', 'Selesai', 2147483647, 236223201, 5000, 2147483647, '', 'Standard', 'ORD-20250220-bd1df'),
(15, 51, '2025-02-20 13:34:43', 'Pending', 2147483647, 236223201, 5000, 2147483647, '', 'Standard', 'ORD-20250220-93ee2'),
(16, 51, '2025-02-22 15:37:34', 'Pending', 2147483647, 236223201, 5000, 2147483647, '', 'Standard', 'ORD-20250222-6fef4');

-- --------------------------------------------------------

--
-- Table structure for table `pic_perusahaan`
--

CREATE TABLE `pic_perusahaan` (
  `id` int(11) NOT NULL,
  `nama_pic` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `departemen` varchar(255) DEFAULT NULL,
  `no_ponsel` varchar(20) DEFAULT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `dokumen_legalitas` varchar(255) DEFAULT NULL,
  `foto_akta_pendirian` varchar(255) DEFAULT NULL,
  `foto_nib_isp` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `pelanggan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pic_perusahaan`
--

INSERT INTO `pic_perusahaan` (`id`, `nama_pic`, `jabatan`, `departemen`, `no_ponsel`, `nik`, `dokumen_legalitas`, `foto_akta_pendirian`, `foto_nib_isp`, `email`, `pelanggan_id`) VALUES
(20, 'mala', 'Mahasiswa', 'it', '0987677', '3527034201030004', 'materai.jpeg', 'materai.jpeg', 'materai.jpeg', 'amalazkr8@gmail.com', 20),
(22, 'albab', 'Mahasiswa', 'it', '0987677', '3527034201030004', 'KTM.jpg', 'KTM.jpg', 'KTM.jpg', 'amalazkr8@gmail.com', 21),
(0, 'PDAM', 'Staf Hublang', 'Hublang', '08972631231', '0977626312432', 'vsadscsazxca.PNG', 'LOGO3333.jpg', 'app absensi.jpg', 'kemaltrader123@gmail.com', 22),
(0, 'PDAM', 'Staf IT', 'IT', '08972631231', '12345', 'vasfsqasd.PNG', 'vasfsqasd.PNG', 'vasfsqasd.PNG', 'firdaus2024@gmail.com', 23),
(0, 'fsca', 'vsxac', 'ssacsa', '2421321', '525421321321', 'vsasdcsa.PNG', 'fvsadasd.PNG', 'Scan.jpg', 'admin@admin.com', 24),
(0, 'pdamfhjfshajdfb', 'Staf Hublang', 'fasf', '08972631231', 'fsadwqsad', 'vnsahdfjfsha.PNG', 'LOGO3333.jpg', 'fvsadfsa.PNG', 'admin2@gmail.com', 25),
(0, 'PDAM', 'Staf IT', 'fsfs', '08972631231', '0023', 'vsadaf.PNG', 'vasdffasda.PNG', 'vsadsasfsads.PNG', 'dian@gmail.com', 26),
(0, 'vdvcasa', 'vasscxz', 'xcbfeas', 'vxzasd', '12345', 'fvsadasd.PNG', 'ffscadsa.PNG', 'fsadfsad.PNG', 'admin3@gmail.com', 27),
(0, 'riskiya', 'Kasir', NULL, '08972342413', NULL, 'vsadsasfsads.PNG', 'app absensi ui ux.cdr', 'fsadafsad.PNG', 'riskiya@gmail.com', 47),
(0, 'pdamfhjfshajdfb', 'Kasubid', NULL, '0896776211', NULL, 'vxadscsa.PNG', 'vsadsasfsads.PNG', 'vsadscsazxca.PNG', 'fiman@gmail.com', 48),
(0, 'kopiluwak', 'manajer', NULL, '08972342413', NULL, 'bdvadsa.PNG', 'vsadsasfsads.PNG', 'fvsadfsa.PNG', 'kopiluwakenak@gmail.com', 51),
(0, 'aqua', 'Kasir', NULL, '0876213241', NULL, 'fsadasa.PNG', 'vcsasdqas.PNG', 'fsadwasfsad.PNG', 'aqua@gmail.com', 52);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `spesifikasi_produk` varchar(255) NOT NULL,
  `gambar_produk` tinyblob DEFAULT NULL,
  `detail` text NOT NULL,
  `keunggulan_produk` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `harga`, `spesifikasi_produk`, `gambar_produk`, `detail`, `keunggulan_produk`) VALUES
(12, 'Internet Satelit', 2147483647, 'Teknologi: VSAT (Very Small Aperture Terminal) Kecepatan Unduh: 100 Mbps Kecepatan Unggah: 20 Mbps Jangkauan: Nasional Latensi: ', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f706f616c31783934753238645f65682e6a7067, 'SatLink Pro 100 adalah layanan internet satelit berbasis teknologi VSAT yang menyediakan koneksi cepat dan stabil di area yang sulit dijangkau jaringan fiber optik. Dengan kapasitas bandwidth yang besar, layanan ini cocok untuk perusahaan, lembaga pemerintah, atau wilayah terpencil yang memerlukan koneksi internet tanpa gangguan.', 'Koneksi internet cepat hingga 100 Mbps untuk mendukung aktivitas bisnis dan operasional\r\nKecepatan unggah yang stabil untuk kebutuhan video conference atau pengunggahan data besar'),
(13, 'Streaming Satelit', 200000000, 'Teknologi: Ku-Band Kecepatan Unduh: 50 Mbps Kecepatan Unggah: 10 Mbps Jangkauan: Nasional Latensi: ', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f68793067786662647a7469776c73722e6a7067, 'SatStream 50 menawarkan solusi koneksi satelit dengan kecepatan tinggi untuk layanan streaming video berkualitas HD dan 4K. Dengan latensi yang rendah, layanan ini ideal untuk streaming media dan hiburan tanpa gangguan.', 'Kecepatan unduh 50 Mbps untuk pengalaman streaming tanpa buffering\r\nLatensi rendah, ideal untuk penggunaan hiburan\r\nTerjangkau dengan kuota 50 GB per bulan'),
(14, 'SatConnect Business', 2147483647, 'Jenis Layanan: Koneksi Internet Satelit untuk Bisnis Teknologi: L-band Kecepatan Unduh: 200 Mbps Kecepatan Unggah: 50 Mbps Jangkauan: Nasional dan Internasional Latensi: ', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f7a6c64627566357469306d677934682e6a7067, 'SatConnect Business memberikan koneksi internet cepat dan stabil untuk perusahaan besar yang membutuhkan bandwidth besar untuk operasi harian dan aplikasi bisnis kritikal. Layanan ini mendukung koneksi di area terpencil dan wilayah dengan infrastruktur jaringan terbatas.', 'Kecepatan tinggi untuk mendukung aplikasi bisnis dan komunikasi video\r\nLatensi rendah yang sangat penting untuk aplikasi real-time\r\nBandwidth besar untuk operasional tanpa hambatan\r\nDukungan instalasi dan pemeliharaan terintegrasi'),
(15, 'SatEdu 30', 1500000, 'Jenis Layanan: Internet Satelit untuk Pendidikan Teknologi: Ka-Band Kecepatan Unduh: 30 Mbps Kecepatan Unggah: 5 Mbps Jangkauan: Nasional Latensi: ', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f6f6433365f676273783135306632342e6a7067, 'SatEdu 30 adalah layanan internet satelit yang dirancang untuk mendukung kegiatan pendidikan di daerah terpencil dengan kecepatan yang memadai untuk mengakses materi online, video pembelajaran, dan aplikasi e-learning.', 'Kecepatan cukup untuk mendukung pembelajaran jarak jauh\r\nLatensi rendah untuk interaksi waktu nyata seperti video conference\r\nBiaya terjangkau untuk lembaga pendidikan dan sekolah\r\nAkses mudah ke materi pembelajaran online'),
(16, 'SatSecure', 6000000, 'Jenis Layanan: Koneksi Internet Satelit untuk Keamanan Teknologi: HTS (High Throughput Satellite) Kecepatan Unduh: 150 Mbps Kecepatan Unggah: 30 Mbps Jangkauan: Nasional dan Internasional', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f7a38626f666a3175717335677961762e6a7067, 'SatSecure adalah layanan internet satelit yang dirancang khusus untuk industri keamanan, termasuk pengawasan jarak jauh dan sistem monitoring CCTV. Layanan ini memberikan koneksi yang aman dan stabil untuk transmisi data sensitif.', 'Kecepatan tinggi dan latensi rendah untuk mendukung pemantauan real-time\r\nEnkripsi data yang kuat untuk menjaga kerahasiaan informasi\r\nBandwidth besar untuk pengiriman data video dan alarm secara cepat'),
(17, 'SatCloud 200', 8000000, 'Jenis Layanan: Koneksi Internet Satelit untuk Penyimpanan Cloud Teknologi: C-band Kecepatan Unduh: 200 Mbps Kecepatan Unggah: 100 Mbps Jangkauan: Nasional Latensi: ', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f6a786b74767134626c655f6e3967332e6a7067, 'SatCloud 200 menawarkan konektivitas internet cepat untuk layanan penyimpanan dan backup cloud dengan kapasitas besar. Layanan ini cocok untuk perusahaan yang mengelola data besar dan memerlukan akses cepat dan aman ke server cloud.', 'Kecepatan unggah 100 Mbps untuk backup data cepat\r\nLatensi rendah ideal untuk pemrosesan data cloud\r\nBandwidth besar untuk mengelola data dalam jumlah besar\r\nKeamanan data terjamin dengan enkripsi cloud'),
(18, 'mangostar', 700000000, 'Jenis Layanan: Koneksi Internet Satelit untuk Bisnis Teknologi: L-band Kecepatan Unduh: 200 Mbps Kecepatan Unggah: 50 Mbps Jangkauan: Nasional dan Internasional Latensi: ', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f62736c32343674726e693166756a612e6a7067, 'Detail: SatLink Pro 100 adalah layanan internet satelit berbasis teknologi VSAT yang menyediakan koneksi cepat dan stabil di area yang sulit dijangkau jaringan fiber optik. Dengan kapasitas bandwidth yang besar, layanan ini cocok untuk perusahaan, lembaga pemerintah, atau wilayah terpencil yang memerlukan koneksi internet tanpa gangguan.', 'Koneksi internet cepat hingga 100 Mbps untuk mendukung aktivitas bisnis dan operasional Kecepatan unggah yang stabil untuk kebutuhan video conference atau pengunggahan data besar');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `id` int(11) NOT NULL,
  `nama_promo` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `kode_promo` varchar(7) NOT NULL,
  `syarat_ketentuan` varchar(255) NOT NULL,
  `gambar_promo` tinyblob DEFAULT NULL,
  `nama_produk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`id`, `nama_promo`, `start_date`, `end_date`, `kode_promo`, `syarat_ketentuan`, `gambar_promo`, `nama_produk`) VALUES
(1, 'Diskon Akhir Tahun', '2025-12-01 00:00:00', '2025-12-31 00:00:00', 'AKHIRTH', 'Diskon 25% untuk semua produk dengan pembelian minimal Rp 500.000. Berlaku 1 kali per akun.', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f32336d3534715f66676378706e79772e6a7067, 'SatCloud 200'),
(2, 'Promo Hari Kemerdekaan', '2025-08-01 00:00:00', '2025-08-17 00:00:00', 'MERDEKA', 'Diskon 45% untuk produk tertentu. Tidak dapat digabung dengan promo lain.', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f76356f6162716979776573337064672e6a7067, 'SatCloud 200'),
(3, 'Cashback Spesial', '2025-06-01 00:00:00', '2025-06-15 00:00:00', 'CASHBAC', 'Dapatkan cashback 50% hingga Rp 100.000 untuk pembelian menggunakan e-wallet. Berlaku 1 kali per akun.', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f366b7134657a696f6d726a375f35742e6a7067, 'SatConnect Business'),
(4, 'Diskon New Member', '2025-01-01 00:00:00', '2025-12-31 00:00:00', 'WELCOME', 'Diskon 20% untuk pengguna baru. Berlaku hanya untuk transaksi pertama.', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f5f6c6463726b7a736675336777616e2e6a7067, 'Streaming Satelit'),
(5, 'Flash Sale Spesial', '2025-03-01 00:00:00', '2025-03-03 00:00:00', 'FLASHSA', 'Diskon tambahan 10% untuk produk di kategori tertentu. Berlaku selama jam promo.', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f6434657479383976306d7370625f692e6a7067, 'SatCloud 200'),
(6, 'Promo Spesial Ramadhan', '2025-04-01 00:00:00', '2025-04-30 00:00:00', 'RAMADHA', '1.Diskon 15% untuk produk makanan & minuman. Berlaku hanya untuk transaksi minimal Rp 300.000. 2. fdf', 0x687474703a2f2f6c6f63616c686f73742f736b796c696e6b6d61726b65742f75706c6f6164732f66696c65732f6f35317375637a37666d346e3369302e6a7067, 'Streaming Satelit');

-- --------------------------------------------------------

--
-- Table structure for table `promo_produk`
--

CREATE TABLE `promo_produk` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id` int(11) NOT NULL,
  `nama_provinsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `urutan` int(11) NOT NULL,
  `tombol_aksi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `nama`, `urutan`, `tombol_aksi`) VALUES
(1, 'Pesanan Diproses', 1, 'Download Faktur Pajak'),
(2, 'Faktur Pajak, Tanda Terima, Receipt', 2, ''),
(3, 'Mengirim Produk', 3, 'konfirmasi penerimaan'),
(4, 'Menerima Produk ', 4, 'Request Layanan'),
(5, 'Request Layanan Dikirim', 5, 'Menunggu admin'),
(6, 'Layanan Aktif', 6, 'Download Surat Pernyataan Aktivasi'),
(7, 'Surat Pernyataan Aktivasi ', 7, 'Download Dumen BAA'),
(8, 'Dokumen BAA', 8, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `login_session_key` varchar(255) DEFAULT NULL,
  `email_status` varchar(255) DEFAULT NULL,
  `password_expire_date` datetime DEFAULT '2025-04-30 00:00:00',
  `password_reset_key` varchar(255) DEFAULT NULL,
  `level` varchar(255) NOT NULL,
  `account_status` varchar(255) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `login_session_key`, `email_status`, `password_expire_date`, `password_reset_key`, `level`, `account_status`) VALUES
(1, 'mala', '$2y$10$DAD1rnl1yQ11EQ1Akr8L9.ie67Qf6siq2hVGraSrPYT053un4T7hO', 'amalazkr8@gmail.com', NULL, NULL, '2025-04-30 00:00:00', NULL, 'Operasional', 'Pending'),
(2, 'albab', '$2a$12$8nEVgadwbjAh0Pfbx9sxe..UghufYfaCOuVsTCyVOpDFaIBA68iLm', 'albabamero@gmail.com', NULL, NULL, '2025-04-30 00:00:00', NULL, 'Account Manager', 'Pending'),
(3, 'siti', '$2y$10$DAD1rnl1yQ11EQ1Akr8L9.ie67Qf6siq2hVGraSrPYT053un4T7hO', 'siti@gmail.com', NULL, NULL, '2025-04-30 00:00:00', NULL, 'Operasional', 'Pending'),
(5, 'ernaherawati', '$2a$12$8nEVgadwbjAh0Pfbx9sxe..UghufYfaCOuVsTCyVOpDFaIBA68iLm', 'ernaherawati@gmail.com', NULL, 'Not Verified', '2025-04-30 00:00:00', NULL, 'pelanggan', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat_perusahaan`
--
ALTER TABLE `alamat_perusahaan`
  ADD PRIMARY KEY (`pelanggan_id`),
  ADD KEY `fk_pelanggan_alamat` (`pelanggan_id`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_pesanan_pelanggan` (`pelanggan_id`);

--
-- Indexes for table `detail_produk`
--
ALTER TABLE `detail_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_management`
--
ALTER TABLE `order_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pesanan` (`kode_pesanan`),
  ADD UNIQUE KEY `kode_pesanan_2` (`kode_pesanan`),
  ADD KEY `fk_pesanan_pelanggan` (`pelanggan_id`);

--
-- Indexes for table `pic_perusahaan`
--
ALTER TABLE `pic_perusahaan`
  ADD PRIMARY KEY (`pelanggan_id`),
  ADD KEY `fk_pelanggan` (`pelanggan_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo_produk`
--
ALTER TABLE `promo_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `detail_produk`
--
ALTER TABLE `detail_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kabupaten`
--
ALTER TABLE `kabupaten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_management`
--
ALTER TABLE `order_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `promo_produk`
--
ALTER TABLE `promo_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamat_perusahaan`
--
ALTER TABLE `alamat_perusahaan`
  ADD CONSTRAINT `fk_pelanggan_alamat` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `fk_detail_pesanan_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `pic_perusahaan`
--
ALTER TABLE `pic_perusahaan`
  ADD CONSTRAINT `fk_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
