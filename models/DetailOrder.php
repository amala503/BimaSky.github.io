<?php
class DetailOrder {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPendingOrders($pelanggan_id) {
        $query = "SELECT * FROM detail_pesanan WHERE pelanggan_id = ? AND status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $pelanggan_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        $totalHarga = 0;
        
        while ($row = $result->fetch_assoc()) {
            $row['total'] = $row['kuantitas'] * $row['harga'];
            $totalHarga += $row['total'];
            $items[] = $row;
        }
        
        return [
            'items' => $items,
            'totalHarga' => $totalHarga
        ];
    }

    public function deleteOrderItem($detail_id, $pelanggan_id) {
        $query = "DELETE FROM detail_pesanan WHERE id = ? AND pelanggan_id = ? AND status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $detail_id, $pelanggan_id);
        return $stmt->execute();
    }

    public function processOrder($postData, $files) {
        try {
            $this->conn->begin_transaction();

            // Ambil pelanggan_id
            $pelanggan_id = $_SESSION['user_id'];
            
            // Hitung total harga dan pajak SEBELUM mengubah status
            $orderDetails = $this->getPendingOrders($pelanggan_id);
            $total_harga_produk = $orderDetails['totalHarga'];
            $pajak = $total_harga_produk * 0.11;
            
            // Ambil metode pembayaran dan pengiriman
            $metode_pembayaran = $postData['metode_pembayaran'];
            
            // Buat kode pesanan
            $kode_pesanan = 'ORD-' . date('Ymd') . '-' . substr(uniqid(), -5);
            
            // Tambahkan notifikasi untuk setiap item pesanan
            foreach ($orderDetails['items'] as $item) {
                $sql_notifikasi = "INSERT INTO notifikasi (nama_produk, harga, kuantitas, kode_pesanan) VALUES (?, ?, ?, ?)";
                $stmt_notif = $this->conn->prepare($sql_notifikasi);
                $stmt_notif->bind_param("ssss", $item['nama_produk'], $item['harga'], $item['kuantitas'], $kode_pesanan);
                $stmt_notif->execute();
            }
            $metode_pengiriman = $postData['metode_pengiriman'];
            
            // Hitung biaya pengiriman
            $biaya_pengiriman = 5000; // Default untuk Standard
            if ($metode_pengiriman == 'Express') {
                $biaya_pengiriman = 10000;
            } elseif ($metode_pengiriman == 'Same Day') {
                $biaya_pengiriman = 20000;
            }
            $total_harga_akhir = $total_harga_produk + $pajak + $biaya_pengiriman;
            
            // Debug untuk memeriksa nilai
            error_log("Total Harga Produk: " . $total_harga_produk);
            error_log("Pajak: " . $pajak);
            error_log("Total Akhir: " . $total_harga_akhir);
            
            // Pastikan nilai tidak 0 sebelum insert
            if ($total_harga_produk <= 0) {
                throw new Exception("Total harga produk tidak valid");
            }
            
            // Upload bukti transfer jika ada
            $bukti_transfer_path = null;
            $bukti_transfer_db_path = null;
            if (isset($files['bukti_transfer']) && $files['bukti_transfer']['error'] == 0) {
                // Tentukan path root untuk kedua proyek
                $root_path = $_SERVER['DOCUMENT_ROOT'];
                // Path absolut ke folder upload di proyek skylink
                $upload_dir = $root_path . '/skylink/uploads/buktitransfer/';
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_name = time() . '_' . basename($files['bukti_transfer']['name']);
                $target_file = $upload_dir . $file_name;
                
                if (move_uploaded_file($files['bukti_transfer']['tmp_name'], $target_file)) {
                    // Path lengkap untuk penyimpanan file
                    $bukti_transfer_path = $target_file;
                    // Path relatif untuk database (yang akan digunakan oleh admin)
                    $bukti_transfer_db_path = '/skylink/uploads/buktitransfer/' . $file_name;
                } else {
                    throw new Exception("Gagal mengupload bukti transfer");
                }
            }

            // Ambil kode promo jika ada
            $kode_promo = null;
            if (isset($postData['kode_promo']) && !empty($postData['kode_promo'])) {
                $kode_promo = $postData['kode_promo'];
            }

            // Insert ke tabel pesanan dengan bukti transfer dan kode promo
            $insert_query = "INSERT INTO pesanan (pelanggan_id, total_harga_produk, pajak, biaya_pengiriman, 
                             total_harga_akhir, metode_pembayaran, metode_pengiriman, kode_pesanan, status, 
                             bukti_transfer, kode_promo) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?, ?)";
            $stmt = $this->conn->prepare($insert_query);
            $stmt->bind_param("idddssssss", $pelanggan_id, $total_harga_produk, $pajak, $biaya_pengiriman, 
                              $total_harga_akhir, $metode_pembayaran, $metode_pengiriman, $kode_pesanan, 
                              $bukti_transfer_db_path, $kode_promo);
            $stmt->execute();
            
            // Update detail_pesanan dengan bukti transfer dan kode promo
            $update_query = "UPDATE detail_pesanan SET bukti_transfer = ?, kode_promo = ?, status = 'confirmed' 
                             WHERE pelanggan_id = ? AND status = 'pending'";
            $stmt = $this->conn->prepare($update_query);
            $stmt->bind_param("ssi", $bukti_transfer_db_path, $kode_promo, $pelanggan_id);
            $stmt->execute();

            $this->conn->commit();
            return ['success' => true, 'kode_pesanan' => $kode_pesanan];
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }
}











