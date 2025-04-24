/**
 * Get new order notifications
 * @return array
 */
public function getNewOrderNotifications() {
    $db = $this->GetModel();
    $sql = "SELECT id, kode_pesanan, pelanggan_id, tanggal_pesanan, status, total_harga_akhir 
            FROM pesanan 
            WHERE status = 'Request_Aktivasi' 
            ORDER BY tanggal_pesanan DESC 
            LIMIT 10";
    
    $notifications = $db->rawQuery($sql);
    
    // Get customer names for each order
    if (!empty($notifications)) {
        foreach ($notifications as &$notification) {
            $pelanggan_id = $notification['pelanggan_id'];
            $db->where('id', $pelanggan_id);
            $pelanggan = $db->getOne('pelanggan', ['nama_perusahaan']);
            $notification['nama_pelanggan'] = $pelanggan ? $pelanggan['nama_perusahaan'] : 'Unknown';
        }
    }
    
    return $notifications;
}
