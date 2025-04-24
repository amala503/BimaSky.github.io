/**
 * Get new order notifications
 * @return array
 */
function get_new_order_notifications() {
    $db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $sql = "SELECT id, kode_pesanan, pelanggan_id, tanggal_pesanan, status, total_harga_akhir 
            FROM pesanan 
            WHERE status = 'Request_Aktivasi' 
            ORDER BY tanggal_pesanan DESC 
            LIMIT 10";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get customer names for each order
    if (!empty($notifications)) {
        foreach ($notifications as &$notification) {
            $pelanggan_id = $notification['pelanggan_id'];
            $stmt = $db->prepare("SELECT nama_perusahaan FROM pelanggan WHERE id = ?");
            $stmt->execute([$pelanggan_id]);
            $pelanggan = $stmt->fetch(PDO::FETCH_ASSOC);
            $notification['nama_pelanggan'] = $pelanggan ? $pelanggan['nama_perusahaan'] : 'Unknown';
        }
    }
    
    return $notifications;
}
