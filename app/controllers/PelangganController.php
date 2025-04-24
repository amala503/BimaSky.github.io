<?php 
/**
 * Pelanggan Page Controller
 * @category  Controller
 */
class PelangganController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "pelanggan";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"jenis_bisnis", 
			"kategori_bisnis", 
			"nama_perusahaan", 
			"nomor_npwp", 
			"no_telepon", 
			"password", 
			"sumber_informasi", 
			"email_perusahaan", 
			"username", 
			"pic_perusahaan", 
			"alamat_perusahaan", 
			"status");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pelanggan.id LIKE ? OR 
				pelanggan.jenis_bisnis LIKE ? OR 
				pelanggan.kategori_bisnis LIKE ? OR 
				pelanggan.nama_perusahaan LIKE ? OR 
				pelanggan.nomor_npwp LIKE ? OR 
				pelanggan.no_telepon LIKE ? OR 
				pelanggan.password LIKE ? OR 
				pelanggan.sumber_informasi LIKE ? OR 
				pelanggan.email_perusahaan LIKE ? OR 
				pelanggan.username LIKE ? OR 
				pelanggan.pic_perusahaan LIKE ? OR 
				pelanggan.alamat_perusahaan LIKE ? OR 
				pelanggan.status LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pelanggan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pelanggan.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Pelanggan";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("pelanggan/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"jenis_bisnis", 
			"kategori_bisnis", 
			"nama_perusahaan", 
			"nomor_npwp", 
			"no_telepon", 
			"password", 
			"sumber_informasi", 
			"email_perusahaan", 
			"username", 
			"pic_perusahaan", 
			"alamat_perusahaan", 
			"status");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("pelanggan.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Pelanggan";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("pelanggan/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("jenis_bisnis","kategori_bisnis","nama_perusahaan","nomor_npwp","no_telepon","password","sumber_informasi","email_perusahaan","username","pic_perusahaan","alamat_perusahaan","status");
			$postdata = $this->format_request_data($formdata);
			$cpassword = $postdata['confirm_password'];
			$password = $postdata['password'];
			if($cpassword != $password){
				$this->view->page_error[] = "Your password confirmation is not consistent";
			}
			$this->rules_array = array(
				'jenis_bisnis' => 'required',
				'kategori_bisnis' => 'required',
				'nama_perusahaan' => 'required',
				'nomor_npwp' => 'required',
				'no_telepon' => 'required',
				'password' => 'required',
				'sumber_informasi' => 'required',
				'email_perusahaan' => 'required|valid_email',
				'username' => 'required',
				// 'pic_perusahaan' => 'required',
				// 'alamat_perusahaan' => 'required',
				// 'status' => 'required',
			);
			$this->sanitize_array = array(
				'jenis_bisnis' => 'sanitize_string',
				'kategori_bisnis' => 'sanitize_string',
				'nama_perusahaan' => 'sanitize_string',
				'nomor_npwp' => 'sanitize_string',
				'no_telepon' => 'sanitize_string',
				'sumber_informasi' => 'sanitize_string',
				'email_perusahaan' => 'sanitize_string',
				'username' => 'sanitize_string',
				'pic_perusahaan' => 'sanitize_string',
				'alamat_perusahaan' => 'sanitize_string',
				'status' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$password_text = $modeldata['password'];
			//update modeldata with the password hash
			$modeldata['password'] = $this->modeldata['password'] = password_hash($password_text , PASSWORD_DEFAULT);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pelanggan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pelanggan";
		$this->render_view("pelanggan/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","jenis_bisnis","kategori_bisnis","nama_perusahaan","nomor_npwp","no_telepon","password","sumber_informasi","email_perusahaan","username","pic_perusahaan","alamat_perusahaan","status");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$cpassword = $postdata['confirm_password'];
			$password = $postdata['password'];
			if($cpassword != $password){
				$this->view->page_error[] = "Your password confirmation is not consistent";
			}
			$this->rules_array = array(
				'jenis_bisnis' => 'required',
				'kategori_bisnis' => 'required',
				'nama_perusahaan' => 'required',
				'nomor_npwp' => 'required',
				'no_telepon' => 'required',
				'password' => 'required',
				'sumber_informasi' => 'required',
				'email_perusahaan' => 'required|valid_email',
				'username' => 'required',
				'pic_perusahaan' => 'required',
				'alamat_perusahaan' => 'required',
				'status' => 'required',
			);
			$this->sanitize_array = array(
				'jenis_bisnis' => 'sanitize_string',
				'kategori_bisnis' => 'sanitize_string',
				'nama_perusahaan' => 'sanitize_string',
				'nomor_npwp' => 'sanitize_string',
				'no_telepon' => 'sanitize_string',
				'sumber_informasi' => 'sanitize_string',
				'email_perusahaan' => 'sanitize_string',
				'username' => 'sanitize_string',
				'pic_perusahaan' => 'sanitize_string',
				'alamat_perusahaan' => 'sanitize_string',
				'status' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$password_text = $modeldata['password'];
			//update modeldata with the password hash
			$modeldata['password'] = $this->modeldata['password'] = password_hash($password_text , PASSWORD_DEFAULT);
			if($this->validated()){
				$db->where("pelanggan.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pelanggan");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("pelanggan");
					}
				}
			}
		}
		$db->where("pelanggan.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pelanggan";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pelanggan/edit.php", $data);
	}
	
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id","jenis_bisnis","kategori_bisnis","nama_perusahaan","nomor_npwp","no_telepon","password","sumber_informasi","email_perusahaan","username","pic_perusahaan","alamat_perusahaan","status");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'jenis_bisnis' => 'required',
				'kategori_bisnis' => 'required',
				'nama_perusahaan' => 'required',
				'nomor_npwp' => 'required',
				'no_telepon' => 'required',
				'password' => 'required',
				'sumber_informasi' => 'required',
				'email_perusahaan' => 'required|valid_email',
				'username' => 'required',
				'pic_perusahaan' => 'required',
				'alamat_perusahaan' => 'required',
				'status' => 'required',
			);
			$this->sanitize_array = array(
				'jenis_bisnis' => 'sanitize_string',
				'kategori_bisnis' => 'sanitize_string',
				'nama_perusahaan' => 'sanitize_string',
				'nomor_npwp' => 'sanitize_string',
				'no_telepon' => 'sanitize_string',
				'sumber_informasi' => 'sanitize_string',
				'email_perusahaan' => 'sanitize_string',
				'username' => 'sanitize_string',
				'pic_perusahaan' => 'sanitize_string',
				'alamat_perusahaan' => 'sanitize_string',
				'status' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("pelanggan.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
	}
	/**
     * Update status to approved
     * @return \Redirect
     */
    function approve($rec_id = null) {
        $request = $this->request;
        $db = $this->GetModel();
        $tablename = $this->tablename;
        
        if(!empty($rec_id)){
            $db->where("id", $rec_id);
            $data = ["status" => "approve"];
            
            $bool = $db->update($tablename, $data);
            
            if($bool){
                $this->set_flash_msg("Status berhasil diubah menjadi approve", "success");
            }
            else{
                $this->set_flash_msg("Gagal mengubah status", "danger");
            }
        }
        
        return $this->redirect("pelanggan");
    }
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("pelanggan.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("pelanggan");
	}
}
