<?php 
/**
 * Alamat_perusahaan Page Controller
 * @category  Controller
 */
class Alamat_perusahaanController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "alamat_perusahaan";
	}
	/**
     * List page records
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("pelanggan_id", 
			"provinsi", 
			"kabupaten_kota", 
			"kecamatan", 
			"kelurahan_desa", 
			"rt_rw", 
			"detail_alamat", 
			"link_maps");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT);
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				alamat_perusahaan.pelanggan_id LIKE ? OR 
				alamat_perusahaan.provinsi LIKE ? OR 
				alamat_perusahaan.kabupaten_kota LIKE ? OR 
				alamat_perusahaan.kecamatan LIKE ? OR 
				alamat_perusahaan.kelurahan_desa LIKE ? OR 
				alamat_perusahaan.rt_rw LIKE ? OR 
				alamat_perusahaan.detail_alamat LIKE ? OR 
				alamat_perusahaan.link_maps LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			$db->where($search_condition, $search_params);
			$this->view->search_template = "alamat_perusahaan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("alamat_perusahaan.pelanggan_id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue);
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = count($records);
		$data->total_records = intval($tc->totalCount);
		$data->total_page = ceil($data->total_records / $pagination[1]);
		if($db->getLastError()){
			$this->set_page_error();
		}
		$this->view->page_title = "Alamat Perusahaan";
		$this->render_view("alamat_perusahaan/list.php", $data);
	}

	/**
     * View record detail
     */
	function view($rec_id = null, $value = null){
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("pelanggan_id", "provinsi", "kabupaten_kota", "kecamatan", "kelurahan_desa", "rt_rw", "detail_alamat", "link_maps");
		$db->where("alamat_perusahaan.pelanggan_id", $rec_id);
		$record = $db->getOne($tablename, $fields);
		if(!$record){
			$this->set_page_error("No record found");
		}
		return $this->render_view("alamat_perusahaan/view.php", $record);
	}

	/**
     * Insert new record
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$fields = array("pelanggan_id", "provinsi", "kabupaten_kota", "kecamatan", "kelurahan_desa", "rt_rw", "detail_alamat", "link_maps");
			$postdata = $this->format_request_data($formdata);
			$modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return $this->redirect("alamat_perusahaan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$this->render_view("alamat_perusahaan/add.php");
	}

	/**
     * Delete record
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("alamat_perusahaan.pelanggan_id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$this->set_flash_msg($db->getLastError(), "danger");
		}
		return $this->redirect("alamat_perusahaan");
	}
}
