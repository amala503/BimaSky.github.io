<?php

/**
 * Info Contoller Class
 * @category  Controller
 */

class ApiController extends BaseController
{

	/**
	 * call model action to retrieve data
	 * @return json data
	 */

	function json($action, $arg1 = null, $arg2 = null)
	{
		$model = new SharedController;
		$args = array($arg1, $arg2);
		$data = call_user_func_array(array($model, $action), $args);
		render_json($data);
	}

	/**
	 * Get notifications for AJAX refresh
	 * @return json
	 */
	function get_notifications() {
		$controller = new BaseController();
		$notifications = $controller->getNewOrderNotifications();
		$notificationCount = count($notifications);
		
		// Generate HTML
		ob_start();
		?>
		<h6 class="dropdown-header">
			Notifikasi Request Aktivasi
		</h6>
		
		<?php if($notificationCount > 0): ?>
			<div class="notification-items">
				<?php foreach($notifications as $notification): ?>
				<a class="dropdown-item d-flex align-items-center" href="<?php echo SITE_ADDR; ?>pesanan/view/<?php echo $notification['id']; ?>">
					<div class="mr-3">
						<div class="icon-circle bg-primary">
							<i class="fa fa-file-alt text-white"></i>
						</div>
					</div>
					<div>
						<div class="small text-gray-500"><?php echo date('d M Y', strtotime($notification['tanggal_pesanan'])); ?></div>
						<span class="font-weight-bold">Pesanan #<?php echo $notification['kode_pesanan']; ?></span>
						<div class="text-truncate"><?php echo $notification['nama_pelanggan']; ?></div>
						<div class="small text-gray-500">
							<span class="badge badge-warning">Request Aktivasi</span>
							Rp <?php echo number_format($notification['total_harga_akhir'], 0, ',', '.'); ?>
						</div>
					</div>
				</a>
				<?php endforeach; ?>
			</div>
			<a class="dropdown-item text-center small text-gray-500" href="<?php echo SITE_ADDR; ?>pesanan?status=Request_Aktivasi">
				Lihat Semua Request Aktivasi
			</a>
		<?php else: ?>
			<div class="dropdown-item text-center">
				<span class="text-gray-500">Tidak ada request aktivasi</span>
			</div>
		<?php endif; ?>
		<?php
		$html = ob_get_clean();
		
		// Return JSON response
		$this->respond(json_encode([
			'success' => true,
			'html' => $html,
			'count' => $notificationCount
		]));
	}
}
