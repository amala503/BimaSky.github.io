<?php 
	require_once('vendor/setasign/fpdf/fpdf.php');
/**
 * Pesanan Page Controller
 * @category  Controller
 */
class PesananController extends BaseController {
    public $tablename; // Changed from private to public
    
    function __construct() {
        parent::__construct();
        $this->tablename = "pesanan";
    }

    /**
     * List page records
     * @param string $fieldname (filter record by a field) 
     * @param string $fieldvalue (filter field value)
     * @return BaseView
     */
    function index($fieldname = null, $fieldvalue = null) {
        $request = $this->request;
        $db = $this->GetModel();
        $tablename = $this->tablename;
        
        $fields = array(
            "id", 
            "pelanggan_id", 
            "tanggal_pesanan", 
            "status", 
            "total_harga_produk", 
            "pajak", 
            "biaya_pengiriman", 
            "total_harga_akhir", 
            "metode_pembayaran", 
            "metode_pengiriman", 
            "kode_promo", // Tambahkan kolom kode_promo
            "bukti_transfer", 
            "kode_pesanan"
        );
        
        $pagination = $this->get_pagination(MAX_RECORD_COUNT);

        // Search table record
        if (!empty($request->search)) {
            $text = trim($request->search); 
            $search_condition = "(
                pesanan.id LIKE ? OR 
                pesanan.pelanggan_id LIKE ? OR 
                pesanan.tanggal_pesanan LIKE ? OR 
                pesanan.status LIKE ? OR 
                pesanan.total_harga_produk LIKE ? OR 
                pesanan.pajak LIKE ? OR 
                pesanan.biaya_pengiriman LIKE ? OR 
                pesanan.total_harga_akhir LIKE ? OR 
                pesanan.metode_pembayaran LIKE ? OR 
                pesanan.metode_pengiriman LIKE ? OR 
                pesanan.kode_pesanan LIKE ?
            )";
            $search_params = array_fill(0, 11, "%$text%");
            $db->where($search_condition, $search_params);
            $this->view->search_template = "pesanan/search.php";
        }

        // Handle ordering
        $orderby = $request->orderby ?? "pesanan.id";
        $ordertype = $request->ordertype ?? ORDER_TYPE;
        $db->orderBy($orderby, $ordertype);

        if ($fieldname) {
            $db->where($fieldname, $fieldvalue);
        }

        try {
            $tc = $db->withTotalCount();
            $records = $db->get($tablename, $pagination, $fields);
            
            $data = new stdClass;
            $data->records = $records;
            $data->record_count = count($records);
            $data->total_records = intval($tc->totalCount);
            $data->total_page = ceil($data->total_records / $pagination[1]);

            // Set view properties
            $this->view->page_title = "Pesanan";
            $this->view->report_filename = date('Y-m-d') . '-' . $this->view->page_title;
            $this->view->report_title = $this->view->page_title;
            $this->view->report_layout = "report_layout.php";
            $this->view->report_paper_size = "A4";
            $this->view->report_orientation = "portrait";

            return $this->render_view("pesanan/list.php", $data);
        } catch (Exception $e) {
            $this->set_page_error($e->getMessage());
            return $this->render_view("pesanan/list.php", new stdClass);
        }
    }

    /**
     * View record detail 
     * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
    function view($rec_id = null, $value = null) {
        try {
            $request = $this->request;
            $db = $this->GetModel();
            $rec_id = $this->rec_id = urldecode($rec_id);
            $tablename = $this->tablename;
            
            $fields = array(
                "id", 
                "pelanggan_id", 
                "tanggal_pesanan", 
                "status", 
                "total_harga_produk", 
                "pajak", 
                "biaya_pengiriman", 
                "total_harga_akhir", 
                "metode_pembayaran", 
                "metode_pengiriman", 
                "bukti_transfer", 
                "kode_pesanan"
            );

            if ($value) {
                $db->where($rec_id, urldecode($value));
            } else {
                $db->where("pesanan.id", $rec_id);
            }

            $record = $db->getOne($tablename, $fields);
            
            if ($record) {
                $this->view->page_title = "View Pesanan";
                $this->view->report_filename = date('Y-m-d') . '-' . $this->view->page_title;
                $this->view->report_title = $this->view->page_title;
                $this->view->report_layout = "report_layout.php";
                $this->view->report_paper_size = "A4";
                $this->view->report_orientation = "portrait";
            } else {
                $this->set_page_error("No record found");
            }

            return $this->render_view("pesanan/view.php", $record);
        } catch (Exception $e) {
            $this->set_page_error($e->getMessage());
            return $this->render_view("pesanan/view.php", null);
        }
    }

    /**
     * Add new record to the database table
     * @param $formdata array() from $_POST
     * @return BaseView
     */
    function add($formdata = null) {
        try {
            if ($formdata) {
                $db = $this->GetModel();
                $tablename = $this->tablename;
                $request = $this->request;
                
                $fields = $this->fields = array(
                    "pelanggan_id",
                    "tanggal_pesanan",
                    "status",
                    "total_harga_produk",
                    "pajak",
                    "biaya_pengiriman",
                    "total_harga_akhir",
                    "metode_pembayaran",
                    "metode_pengiriman",
                    "kode_promo", // Tambahkan kolom kode_promo
                    "bukti_transfer",
                    "kode_pesanan"
                );

                $postdata = $this->format_request_data($formdata);
                
                $this->rules_array = array(
                    'pelanggan_id' => 'required|numeric',
                    'status' => 'required',
                    'total_harga_produk' => 'required|numeric',
                    'pajak' => 'required|numeric',
                    'biaya_pengiriman' => 'required|numeric',
                    'total_harga_akhir' => 'required|numeric',
                    'metode_pembayaran' => 'required',
                    'metode_pengiriman' => 'required',
                    'kode_pesanan' => 'required'
                    // bukti_transfer tidak wajib
                );
                
                $this->sanitize_array = array(
                    'pelanggan_id' => 'sanitize_string',
                    'status' => 'sanitize_string',
                    'total_harga_produk' => 'sanitize_string',
                    'pajak' => 'sanitize_string',
                    'biaya_pengiriman' => 'sanitize_string',
                    'total_harga_akhir' => 'sanitize_string',
                    'metode_pembayaran' => 'sanitize_string',
                    'metode_pengiriman' => 'sanitize_string',
                    'bukti_transfer' => 'sanitize_string',
                    'kode_pesanan' => 'sanitize_string'
                );
                
                // Konfigurasi upload file
                $file_upload_settings = array(
                    "bukti_transfer" => array(
                        "title" => "{{random}}",
                        "extensions" => ".jpg,.png,.gif,.jpeg",
                        "limit" => "1",
                        "filesize" => "3",
                        "returnfullpath" => false,
                        "filenameprefix" => "",
                        "uploadDir" => "uploads/buktitransfer/"
                    )
                );
                
                // Proses upload file jika ada
                if(!empty($_FILES['bukti_transfer']['tmp_name'])){
                    $this->file_upload_settings = $file_upload_settings;
                    $uploaded_files = $this->upload_files();
                    if(!empty($uploaded_files['bukti_transfer'])){
                        $postdata['bukti_transfer'] = $uploaded_files['bukti_transfer'];
                    }
                }
                
                $this->filter_vals = true; //set whether to remove empty fields
                $modeldata = $this->modeldata = $this->validate_form($postdata);
                
                if ($this->validated()) {
                    $rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
                    if ($rec_id) {
                        $this->set_flash_msg("Record added successfully", "success");
                        return $this->redirect("pesanan");
                    } else {
                        $this->set_page_error();
                    }
                }
            }
            
            $page_title = $this->view->page_title = "Add New Pesanan";
            return $this->render_view("pesanan/add.php");
        } catch (Exception $e) {
            $this->set_page_error($e->getMessage());
            return $this->render_view("pesanan/add.php");
        }
    }

    /**
     * Update table record with formdata
     * @param $rec_id (select record by table primary key)
     * @param $formdata array() from $_POST
     * @return array
     */
    function edit($rec_id = null, $formdata = null) {
        try {
            $request = $this->request;
            $db = $this->GetModel();
            $this->rec_id = $rec_id;
            $tablename = $this->tablename;
            
            $fields = array(
                "id",
                "pelanggan_id",
                "status",
                "total_harga_produk",
                "pajak",
                "biaya_pengiriman",
                "total_harga_akhir",
                "metode_pembayaran",
                "metode_pengiriman",
                "bukti_transfer",
                "kode_pesanan"
            );

            if ($formdata) {
                $postdata = $this->format_request_data($formdata);
                
                $this->rules_array = array(
                    'pelanggan_id' => 'required|numeric',
                    'status' => 'required',
                    'total_harga_produk' => 'required|numeric',
                    'pajak' => 'required|numeric',
                    'biaya_pengiriman' => 'required|numeric',
                    'total_harga_akhir' => 'required|numeric',
                    'metode_pembayaran' => 'required',
                    'metode_pengiriman' => 'required',
                    'kode_pesanan' => 'required'
                );
                
                $this->sanitize_array = array(
                    'pelanggan_id' => 'sanitize_string',
                    'status' => 'sanitize_string',
                    'total_harga_produk' => 'sanitize_string',
                    'pajak' => 'sanitize_string',
                    'biaya_pengiriman' => 'sanitize_string',
                    'total_harga_akhir' => 'sanitize_string',
                    'metode_pembayaran' => 'sanitize_string',
                    'metode_pengiriman' => 'sanitize_string',
                    'bukti_transfer' => 'sanitize_string',
                    'kode_pesanan' => 'sanitize_string'
                );

                $modeldata = $this->modeldata = $this->validate_form($postdata);

                if ($this->validated()) {
                    $db->where("pesanan.id", $rec_id);
                    $bool = $db->update($tablename, $modeldata);
                    $numRows = $db->getRowCount();
                    
                    if ($bool && $numRows) {
                        $this->set_flash_msg("Record updated successfully", "success");
                        return $this->redirect("pesanan");
                    } else {
                        if ($db->getLastError()) {
                            $this->set_page_error();
                        } elseif (!$numRows) {
                            $this->set_flash_msg("No record updated", "warning");
                            return $this->redirect("pesanan");
                        }
                    }
                }
            }
            
            $db->where("pesanan.id", $rec_id);
            $data = $db->getOne($tablename, $fields);
            
            if (!$data) {
                $this->set_page_error();
            }

            return $this->render_view("pesanan/edit.php", $data);
        } catch (Exception $e) {
            $this->set_page_error($e->getMessage());
            return $this->render_view("pesanan/edit.php", null);
        }
    }

    /**
     * Delete record from the database
     * @param $rec_id (select record by table primary key)
     * @return BaseView
     */
    function delete($rec_id = null) {
        try {
            $request = $this->request;
            $db = $this->GetModel();
            $tablename = $this->tablename;
            $this->rec_id = $rec_id;

            $db->where("pesanan.id", $rec_id);
            $bool = $db->delete($tablename);
            
            if ($bool) {
                $this->set_flash_msg("Record deleted successfully", "success");
            } else {
                $this->set_page_error();
            }

            return $this->redirect("pesanan");
        } catch (Exception $e) {
            $this->set_page_error($e->getMessage());
            return $this->redirect("pesanan");
        }
    }

    /**
     * Update order status via AJAX
     * @param int $rec_id Record ID
     * @return json
     */
	function updatestatus($rec_id = null) {
		header('Content-Type: application/json');
	
		try {
			if (empty($rec_id)) {
				throw new Exception("ID pesanan tidak ditemukan");
			}
	
			$db = $this->GetModel();
			$this->rec_id = filter_var(urldecode($rec_id), FILTER_SANITIZE_NUMBER_INT);
	
			if (!$this->rec_id || $this->rec_id == 0) {
				throw new Exception("ID tidak valid atau kosong");
			}
	
			// Debugging ID
			error_log("Updating status for ID: " . $this->rec_id);
	
			// Validasi status dari request
			if (!isset($_POST['status'])) {
				throw new Exception("Parameter 'status' tidak ditemukan di request");
			}
	
			$status = trim(strip_tags($_POST['status']));
	
			if (empty($status)) {
				throw new Exception("Status tidak boleh kosong");
			}
            
			// Mapping status frontend ke backend
			$status_mapping = [
				'Menunggu' => 'Pending',
				'Diproses' => 'Diproses',
				'Dikirim' => 'Dikirim',                
                'Aktifkan Layanan'=> 'Aktifkan Layanan',
				'Selesai' => 'Selesai'
			];
	
			if (array_key_exists($status, $status_mapping)) {
				$status = $status_mapping[$status];
			}
	
			// Cek apakah status sesuai dengan ENUM database
			$allowed_statuses = ['Pending', 'Diproses', 'Dikirim', 'Aktifkan Layanan','Selesai'];
			if (!in_array($status, $allowed_statuses)) {
				throw new Exception("Status tidak valid: '{$status}'");
			}

            // Ambil status saat ini dari database
$current_record = $db->where("id", $this->rec_id)->getOne($this->tablename, ["status"]);

if ($current_record) {
    $current_status = $current_record['status'];

    // Logika untuk mencegah update status yang tidak sesuai
    if ($current_status === 'Aktifkan Layanan' && $status === 'Aktifkan Layanan') {
        throw new Exception("Status setelah 'Aktifkan Layanan' harus menjadi 'Layanan Aktif' terlebih dahulu.");
    }
}
	
			$modeldata = ['status' => $status];
	
			// Debugging status sebelum update
			error_log("Final status value: " . $status);
	
			$db->where("id", $this->rec_id);
			$bool = $db->update($this->tablename, $modeldata);
	
			if ($bool) {
				echo json_encode([
					"status" => "success",
					"message" => "Status berhasil diperbarui menjadi: " . $status,
					"newStatus" => $status
				]);
			} else {
				throw new Exception("Gagal memperbarui status. Error: " . $db->getLastError());
			}
	
		} catch (Exception $e) {
			error_log("Error in updatestatus: " . $e->getMessage());
			http_response_code(400);
			echo json_encode([
				"status" => "error",
				"message" => $e->getMessage()
			]);
		}
		exit;
	}
	

    
    function pesananDenganNotifikasi($fieldname = null, $fieldvalue = null) {
        $request = $this->request;
        $db = $this->GetModel();
        $tablename = $this->tablename;
    
        // Ambil notifikasi terbaru
        $sql = "SELECT id, kode_pesanan, pesan FROM notifikasi ORDER BY id DESC LIMIT 1";
        $notifikasi = $db->rawQueryOne($sql); // Menggunakan rawQueryOne untuk satu hasil
    
        if ($notifikasi) {
            // Simpan notifikasi dalam session agar bisa ditampilkan sementara
            $_SESSION['notifikasi'] = "<div style='background: yellow; padding: 10px; border: 1px solid black;'>
                                        <p>" . htmlspecialchars($notifikasi['pesan']) . "</p>
                                       </div>";
    
            // Hapus notifikasi setelah diambil
            $delete_sql = "DELETE FROM notifikasi WHERE id = ?";
            $db->rawQuery($delete_sql, [$notifikasi['id']]);
        }
    
        // Set notifikasi ke view jika ada
        $this->view->notifikasi = $_SESSION['notifikasi'] ?? '';
    
        // ... (kode yang ada sebelumnya)
    
        try {
            $tc = $db->withTotalCount();
            $records = $db->get($tablename, $pagination, $fields);
    
            $data = new stdClass;
            $data->records = $records;
            $data->record_count = count($records);
            $data->total_records = intval($tc->totalCount);
            $data->total_page = ceil($data->total_records / $pagination[1]);
    
            // Set view properties
            $this->view->page_title = "Pesanan";
            $this->view->report_filename = date('Y-m-d') . '-' . $this->view->page_title;
            $this->view->report_title = $this->view->page_title;
            $this->view->report_layout = "report_layout.php";
            $this->view->report_paper_size = "A4";
            $this->view->report_orientation = "portrait";
    
            return $this->render_view("pesanan/list.php", $data);
        } catch (Exception $e) {
            $this->set_page_error($e->getMessage());
            return $this->render_view("pesanan/list.php", new stdClass);
        }
    }
    

	function download($pelanggan_id = null) {
		try {
			if (empty($pelanggan_id) || !is_numeric($pelanggan_id)) {
				die("ID Pelanggan tidak valid atau kosong.");
			}
	
			$db = $this->GetModel();
	
			// Ambil data pelanggan
			$db->where("id", $pelanggan_id);
			$pelanggan = $db->getOne("pelanggan");
	
			if (!$pelanggan) {
				die("Data pelanggan tidak ditemukan.");
			}
	
			// Ambil alamat perusahaan berdasarkan pelanggan_id
			$db->where("pelanggan_id", $pelanggan_id);
			$alamat = $db->getOne("alamat_perusahaan");
	
			// Ambil semua pesanan berdasarkan pelanggan_id KECUALI yang memiliki status pending
			$db->where("pelanggan_id", $pelanggan_id);
			$db->where("status", "pending", "!="); // Tambahkan kondisi ini untuk mengecualikan status pending
			$pesanan_list = $db->get("pesanan");
	
			if (!$pesanan_list || count($pesanan_list) == 0) {
				die("Tidak ada pesanan yang telah diproses untuk pelanggan ini.");
			}
	
			// Buat PDF
			$pdf = new FPDF();
			$pdf->AddPage();
			$pdf->SetMargins(10, 10, 10);
	
			// Tambahkan Logo
			if (file_exists('assets/images/logo.png')) {
				$pdf->Image('assets/images/logo.png', 10, 10, 30);
			}
	
			// Header yang lebih menarik dengan background color
			$pdf->SetFillColor(51, 153, 255); // Warna biru menarik
			$pdf->Rect(0, 0, 210, 40, 'F');
			$pdf->SetTextColor(255, 255, 255); // Warna teks putih
	
			// Judul dengan styling yang lebih menarik
			$pdf->SetFont('Arial', 'B', 18);
			$pdf->Cell(190, 15, 'LAPORAN PESANAN PELANGGAN', 0, 1, 'C');
			$pdf->SetFont('Arial', 'I', 12);
			$pdf->Cell(190, 5, 'Diterbitkan pada: ' . date("d-m-Y H:i"), 0, 1, 'C');
			$pdf->Ln(10);
	
			// Reset warna teks
			$pdf->SetTextColor(0, 0, 0);
	
			// Garis pemisah dengan styling
			$pdf->SetLineWidth(0.5);
			$pdf->SetDrawColor(51, 153, 255);
			$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); 
			$pdf->Ln(5);
	
			// Box untuk informasi pelanggan
			$pdf->SetFillColor(240, 240, 240); // Light gray background
			$startY = $pdf->GetY();
			$pdf->Rect(10, $startY, 190, 40, 'F');
	
			// Informasi Pelanggan tanpa ikon
			$pdf->SetFont('Arial', 'B', 14);
			$pdf->SetTextColor(51, 51, 153); // Dark blue text
			$pdf->Cell(190, 10, 'INFORMASI PELANGGAN', 0, 1, 'C');
			$pdf->SetTextColor(0, 0, 0); // Reset to black
			$pdf->SetFont('Arial', 'B', 12);
	
			// Tampilan data pelanggan dengan grid
			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(50, 8, 'Nama:', 0, 0);
			$pdf->Cell(140, 8, $pelanggan['username'], 0, 1);
			$pdf->Cell(50, 8, 'Alamat:', 0, 0);
			$pdf->Cell(140, 8, $alamat['detail_alamat'] ?? 'Tidak tersedia', 0, 1); // Mengambil detail alamat
			$pdf->Cell(50, 8, 'Kontak:', 0, 0);
			$pdf->Cell(140, 8, $pelanggan['no_telepon'] ?? 'Tidak tersedia', 0, 1);
	
			$pdf->Ln(10);
	
			// Tambahkan ringkasan pesanan
			$pdf->SetFont('Arial', 'B', 14);
			$pdf->SetTextColor(51, 51, 153);
			$pdf->Cell(190, 10, 'RINGKASAN PESANAN', 0, 1, 'C');
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFont('Arial', '', 11);
	
			// Informasi ringkasan
			$pdf->Cell(95, 10, 'Total Jumlah Pesanan: ' . count($pesanan_list), 0, 0, 'L');
			$pdf->Cell(95, 10, 'Periode: ' . date('M Y'), 0, 1, 'R');
	
			$pdf->Ln(5);
	
			$totalKeseluruhan = 0;
			$totalItems = 0;
	
			// Looping setiap pesanan dengan desain yang lebih baik
			foreach ($pesanan_list as $key => $pesanan) {
				// Gradient header untuk setiap pesanan
				if ($key % 2 == 0) {
					$pdf->SetFillColor(230, 240, 255); // Light blue
				} else {
					$pdf->SetFillColor(220, 255, 230); // Light green
				}
	
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->Cell(190, 10, 'Pesanan #' . $pesanan['id'] . ' | Kode: ' . $pesanan['kode_pesanan'], 1, 1, 'L', true);
	
				// Sub-header dengan detail tambahan
				$pdf->SetFont('Arial', 'I', 10);
				$pdf->SetFillColor(245, 245, 245);
				$pdf->Cell(95, 8, 'Tanggal: ' . $pesanan['tanggal_pesanan'], 1, 0, 'L', true);
				$pdf->Cell(95, 8, 'Status: ' . ($pesanan['status'] ?? 'Diproses'), 1, 1, 'R', true);
	
				// Ambil detail pesanan berdasarkan pelanggan_id
				$db->where("pelanggan_id", $pelanggan_id); // Menggunakan pelanggan_id untuk mengambil detail
				$items = $db->get("detail_pesanan");
	
				if ($items) {
					// Header Tabel dengan desain yang lebih modern
					$pdf->SetFont('Arial', 'B', 11);
					$pdf->SetFillColor(100, 149, 237); // Cornflower blue
					$pdf->SetTextColor(255, 255, 255);
					$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
					$pdf->Cell(70, 10, 'Produk', 1, 0, 'C', true);
					$pdf->Cell(30, 10, 'Jumlah', 1, 0, 'C', true);
					$pdf->Cell(40, 10, 'Harga', 1, 0, 'C', true);
					$pdf->Cell(40, 10, 'Subtotal', 1, 1, 'C', true);
	
					// Reset text color
					$pdf->SetTextColor(0, 0, 0);
	
					// Isi Tabel dengan zebra-striping
					$pdf->SetFont('Arial', '', 10);
					$totalPesanan = 0;
					$count = 0;
	
					foreach ($items as $item) {
						$count++;
						// Zebra striping
						if ($count % 2 == 0) {
							$pdf->SetFillColor(240, 240, 240);
							$fill = true;
						} else {
							$pdf->SetFillColor(255, 255, 255);
							$fill = true;
						}
	
						$subtotal = $item['kuantitas'] * $item['harga'];
						$totalPesanan += $subtotal;
						$totalItems += $item['kuantitas'];
	
						// Menampilkan nama produk dari detail_pesanan
						$pdf->Cell(10, 10, $count, 1, 0, 'C', $fill);
						$pdf->Cell(70, 10, $item['nama_produk'], 1, 0, 'L', $fill);
						$pdf->Cell(30, 10, $item['kuantitas'] . ' pcs', 1, 0, 'C', $fill);
						$pdf->Cell(40, 10, 'Rp ' . number_format($item['harga'], 0, ',', '.'), 1, 0, 'R', $fill);
						$pdf->Cell(40, 10, 'Rp ' . number_format($subtotal, 0, ',', '.'), 1, 1, 'R', $fill);
					}
	
					// Total Pesanan dengan formatting yang menarik
					$pdf->SetFont('Arial', 'B', 11);
					$pdf->SetFillColor(220, 220, 220);
					$pdf->Cell(150, 10, 'Total Pesanan:', 1, 0, 'R', true);
					$pdf->SetFillColor(255, 235, 205); // Bisque color
					$pdf->Cell(40, 10, 'Rp ' . number_format($totalPesanan, 0, ',', '.'), 1, 1, 'R', true);
				} else {
					$pdf->SetFont('Arial', 'I', 11);
					$pdf->Cell(190, 10, 'Detail pesanan kosong.', 0, 1, 'C');
				}
	
				$pdf->Ln(5);
	
				// Tambahkan total_harga_akhir dari pesanan ke total keseluruhan
				$totalKeseluruhan += $pesanan['total_harga_akhir'];
			}
	
			// Grand Total dengan highlight box
			$pdf->SetFillColor(51, 153, 255, 0.2); // Semi-transparent blue
			$startY = $pdf->GetY();
			$pdf->Rect(10, $startY, 190, 40, 'F');
	
			$pdf->SetFont('Arial', 'B', 14);
			$pdf->SetTextColor(0, 51, 153); // Dark blue text
			$pdf->Cell(190, 10, 'RINGKASAN PEMBELIAN', 0, 1, 'C');
	
			// Info statistics
			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(95, 8, 'Total Barang: ' . $totalItems . ' pcs', 0, 0);
			$pdf->Cell(95, 8, 'Total Transaksi: ' . count($pesanan_list), 0, 1);
	
			// Grand Total dengan box gradient
			$pdf->SetFont('Arial', 'B', 14);
			$pdf->SetFillColor(255, 215, 0); // Gold color
			$pdf->Cell(150, 10, 'TOTAL KESELURUHAN:', 1, 0, 'R', true);
			$pdf->SetFillColor(255, 165, 0); // Orange color
			$pdf->Cell(40, 10, 'Rp ' . number_format($totalKeseluruhan, 0, ',', '.'), 1, 1, 'R', true);
			$pdf->Ln(10);
	
			// Footer dengan informasi tambahan
			$pdf->SetFillColor(220, 220, 220);
			$pdf->Rect(10, $pdf->GetY(), 190, 40, 'F');
	
			// Tanda tangan dengan layout yang lebih baik
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(95, 10, 'PENGIRIM', 0, 0, 'C');
			$pdf->Cell(95, 10, 'MENGETAHUI', 0, 1, 'C');
	
			$pdf->Ln(15);
	
			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(95, 10, '(____________________)', 0, 0, 'C');
			$pdf->Cell(95, 10, '(____________________)', 0, 1, 'C');
	
			$pdf->SetFont('Arial', 'I', 10);
			$pdf->Cell(95, 5, 'Admin', 0, 0, 'C');
			$pdf->Cell(95, 5, 'Manager', 0, 1, 'C');
	
			// Catatan Kaki
			$pdf->Ln(10);
			$pdf->SetFont('Arial', 'I', 8);
			$pdf->SetTextColor(100, 100, 100);
			$pdf->Cell(190, 5, '* Laporan ini diterbitkan secara otomatis oleh sistem', 0, 1, 'C');
			$pdf->Cell(190, 5, '* Silakan hubungi customer service jika ada pertanyaan: cs@perusahaan.com', 0, 1, 'C');
	
			ob_end_clean();
	
			// Set header untuk output PDF
			$filename = 'Pesanan_Pelanggan_' . $pelanggan['username'] . '.pdf';
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Cache-Control: private');
			header('Pragma: public');
	
			// Tampilkan PDF
			$pdf->Output($filename, 'I');
			exit;
		} catch (Exception $e) {
			error_log("Error: " . $e->getMessage());
			die("Terjadi kesalahan: " . $e->getMessage());
		}
	}
	
}





