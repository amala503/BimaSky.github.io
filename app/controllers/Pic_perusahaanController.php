<?php 
/**
 * Pic_perusahaan Page Controller
 * @category  Controller
 */
class Pic_perusahaanController extends SecureController {
    function __construct(){
        parent::__construct();
        $this->tablename = "pic_perusahaan";
    }

    /**
     * List page records
     */
    function index($fieldname = null , $fieldvalue = null){
        $request = $this->request;
        $db = $this->GetModel();
        $tablename = $this->tablename;
        // Hapus field "id" dari array fields
        $fields = array(
            "pelanggan_id", 
            "nama_pic", 
            "jabatan", 
            "departemen", 
            "no_ponsel", 
            "nik", 
            "dokumen_legalitas", 
            "foto_akta_pendirian", 
            "foto_nib_isp", 
            "email"
        );
        $pagination = $this->get_pagination(MAX_RECORD_COUNT);
        
        // Pencarian pada semua field (jika perlu, pastikan kondisi "id" dihapus atau disesuaikan)
        if(!empty($request->search)){
            $text = trim($request->search); 
            $search_condition = "(
                pic_perusahaan.pelanggan_id LIKE ? OR 
                pic_perusahaan.nama_pic LIKE ? OR 
                pic_perusahaan.jabatan LIKE ? OR 
                pic_perusahaan.departemen LIKE ? OR 
                pic_perusahaan.no_ponsel LIKE ? OR 
                pic_perusahaan.nik LIKE ? OR 
                pic_perusahaan.dokumen_legalitas LIKE ? OR 
                pic_perusahaan.foto_akta_pendirian LIKE ? OR 
                pic_perusahaan.foto_nib_isp LIKE ? OR 
                pic_perusahaan.email LIKE ?
            )";
            $search_params = array_fill(0, 10, "%$text%");
            $db->where($search_condition, $search_params);
            $this->view->search_template = "pic_perusahaan/search.php";
        }
        
        // Mengganti penyortiran dari "id" ke "pelanggan_id"
        if(!empty($request->orderby)){
            $orderby = $request->orderby;
            $ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
            $db->orderBy("pic_perusahaan.$orderby", $ordertype);
        } else {
            $db->orderBy("pic_perusahaan.pelanggan_id", ORDER_TYPE);
        }
        
        if($fieldname){
            $db->where($fieldname , $fieldvalue);
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
        
        $page_title = $this->view->page_title = "Pic Perusahaan";
        $this->view->report_filename = date('Y-m-d') . '-' . $page_title;
        $this->view->report_title = $page_title;
        $this->view->report_layout = "report_layout.php";
        $this->view->report_paper_size = "A4";
        $this->view->report_orientation = "portrait";
        $this->render_view("pic_perusahaan/list.php", $data);
    }

    /**
     * View record detail 
     */
    function view($rec_id = null, $value = null){
        $request = $this->request;
        $db = $this->GetModel();
        $rec_id = $this->rec_id = urldecode($rec_id);
        $tablename = $this->tablename;
        // Hapus field "id" dan gunakan "pelanggan_id"
        $fields = array(
            "pelanggan_id", 
            "nama_pic", 
            "jabatan", 
            "departemen", 
            "no_ponsel", 
            "nik", 
            "dokumen_legalitas", 
            "foto_akta_pendirian", 
            "foto_nib_isp", 
            "email"
        );
        if($value){
            $db->where($rec_id, urldecode($value));
        }
        else{
            $db->where("pic_perusahaan.pelanggan_id", $rec_id);
        }
        $record = $db->getOne($tablename, $fields);
        if($record){
            $page_title = $this->view->page_title = "View Pic Perusahaan";
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
        return $this->render_view("pic_perusahaan/view.php", $record);
    }

    /**
     * Insert new record to the database table
     */
    function add($formdata = null){
        if($formdata){
            $db = $this->GetModel();
            $tablename = $this->tablename;
            $request = $this->request;
            // Field yang dapat diisi, tanpa field "id"
            $fields = $this->fields = array("pelanggan_id","nama_pic","jabatan","departemen","no_ponsel","nik","dokumen_legalitas","foto_akta_pendirian","foto_nib_isp","email");
            $postdata = $this->format_request_data($formdata);
            $this->rules_array = array(
                'pelanggan_id' => 'required|numeric',
                'nama_pic' => 'required',
                'jabatan' => 'required',
                'departemen' => 'required',
                'no_ponsel' => 'required',
                'nik' => 'required',
                'dokumen_legalitas' => 'required',
                'foto_akta_pendirian' => 'required',
                'foto_nib_isp' => 'required',
                'email' => 'required|valid_email',
            );
            $this->sanitize_array = array(
                'pelanggan_id' => 'sanitize_string',
                'nama_pic' => 'sanitize_string',
                'jabatan' => 'sanitize_string',
                'departemen' => 'sanitize_string',
                'no_ponsel' => 'sanitize_string',
                'nik' => 'sanitize_string',
                'dokumen_legalitas' => 'sanitize_string',
                'foto_akta_pendirian' => 'sanitize_string',
                'foto_nib_isp' => 'sanitize_string',
                'email' => 'sanitize_string',
            );
            $this->filter_vals = true;
            $modeldata = $this->modeldata = $this->validate_form($postdata);
            if($this->validated()){
                $rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
                if($rec_id){
                    $this->set_flash_msg("Record added successfully", "success");
                    return $this->redirect("pic_perusahaan");
                }
                else{
                    $this->set_page_error();
                }
            }
        }
        $page_title = $this->view->page_title = "Add New Pic Perusahaan";
        $this->render_view("pic_perusahaan/add.php");
    }

    /**
     * Update table record with formdata
     */
    function edit($rec_id = null, $formdata = null){
        $request = $this->request;
        $db = $this->GetModel();
        $this->rec_id = $rec_id;
        $tablename = $this->tablename;
        // Field yang dapat diupdate, tanpa "id"
        $fields = $this->fields = array("pelanggan_id","nama_pic","jabatan","departemen","no_ponsel","nik","dokumen_legalitas","foto_akta_pendirian","foto_nib_isp","email");
        if($formdata){
            $postdata = $this->format_request_data($formdata);
            $this->rules_array = array(
                'pelanggan_id' => 'required|numeric',
                'nama_pic' => 'required',
                'jabatan' => 'required',
                'departemen' => 'required',
                'no_ponsel' => 'required',
                'nik' => 'required',
                'dokumen_legalitas' => 'required',
                'foto_akta_pendirian' => 'required',
                'foto_nib_isp' => 'required',
                'email' => 'required|valid_email',
            );
            $this->sanitize_array = array(
                'pelanggan_id' => 'sanitize_string',
                'nama_pic' => 'sanitize_string',
                'jabatan' => 'sanitize_string',
                'departemen' => 'sanitize_string',
                'no_ponsel' => 'sanitize_string',
                'nik' => 'sanitize_string',
                'dokumen_legalitas' => 'sanitize_string',
                'foto_akta_pendirian' => 'sanitize_string',
                'foto_nib_isp' => 'sanitize_string',
                'email' => 'sanitize_string',
            );
            $modeldata = $this->modeldata = $this->validate_form($postdata);
            if($this->validated()){
                // Ganti kondisi primary key menjadi pelanggan_id
                $db->where("pic_perusahaan.pelanggan_id", $rec_id);
                $bool = $db->update($tablename, $modeldata);
                $numRows = $db->getRowCount();
                if($bool && $numRows){
                    $this->set_flash_msg("Record updated successfully", "success");
                    return $this->redirect("pic_perusahaan");
                }
                else{
                    if($db->getLastError()){
                        $this->set_page_error();
                    }
                    elseif(!$numRows){
                        $page_error = "No record updated";
                        $this->set_page_error($page_error);
                        $this->set_flash_msg($page_error, "warning");
                        return $this->redirect("pic_perusahaan");
                    }
                }
            }
        }
        $db->where("pic_perusahaan.pelanggan_id", $rec_id);
        $data = $db->getOne($tablename, $fields);
        $page_title = $this->view->page_title = "Edit Pic Perusahaan";
        if(!$data){
            $this->set_page_error();
        }
        return $this->render_view("pic_perusahaan/edit.php", $data);
    }

    /**
     * Update single field
     */
    function editfield($rec_id = null, $formdata = null){
        $db = $this->GetModel();
        $this->rec_id = $rec_id;
        $tablename = $this->tablename;
        // Field editable, tanpa "id"
        $fields = $this->fields = array("pelanggan_id","nama_pic","jabatan","departemen","no_ponsel","nik","dokumen_legalitas","foto_akta_pendirian","foto_nib_isp","email");
        $page_error = null;
        if($formdata){
            $postdata = array();
            $fieldname = $formdata['name'];
            $fieldvalue = $formdata['value'];
            $postdata[$fieldname] = $fieldvalue;
            $postdata = $this->format_request_data($postdata);
            $this->rules_array = array(
                'pelanggan_id' => 'required|numeric',
                'nama_pic' => 'required',
                'jabatan' => 'required',
                'departemen' => 'required',
                'no_ponsel' => 'required',
                'nik' => 'required',
                'dokumen_legalitas' => 'required',
                'foto_akta_pendirian' => 'required',
                'foto_nib_isp' => 'required',
                'email' => 'required|valid_email',
            );
            $this->sanitize_array = array(
                'pelanggan_id' => 'sanitize_string',
                'nama_pic' => 'sanitize_string',
                'jabatan' => 'sanitize_string',
                'departemen' => 'sanitize_string',
                'no_ponsel' => 'sanitize_string',
                'nik' => 'sanitize_string',
                'dokumen_legalitas' => 'sanitize_string',
                'foto_akta_pendirian' => 'sanitize_string',
                'foto_nib_isp' => 'sanitize_string',
                'email' => 'sanitize_string',
            );
            $this->filter_rules = true;
            $modeldata = $this->modeldata = $this->validate_form($postdata);
            if($this->validated()){
                // Update dengan kondisi primary key pelanggan_id
                $db->where("pic_perusahaan.pelanggan_id", $rec_id);
                $bool = $db->update($tablename, $modeldata);
                $numRows = $db->getRowCount();
                if($bool && $numRows){
                    return render_json(
                        array(
                            'num_rows' => $numRows,
                            'rec_id' => $rec_id,
                        )
                    );
                } else {
                    if($db->getLastError()){
                        $page_error = $db->getLastError();
                    } elseif(!$numRows){
                        $page_error = "No record updated";
                    }
                    render_error($page_error);
                }
            } else {
                render_error($this->view->page_error);
            }
        }
        return null;
    }

    /**
     * Delete record from the database
     */
    function delete($rec_id = null){
        Csrf::cross_check();
        $request = $this->request;
        $db = $this->GetModel();
        $tablename = $this->tablename;
        $this->rec_id = $rec_id;
        // Memisahkan multiple id jika diperlukan
        $arr_rec_id = array_map('trim', explode(",", $rec_id));
        // Ganti kondisi dari id ke pelanggan_id
        $db->where("pic_perusahaan.pelanggan_id", $arr_rec_id, "in");
        $bool = $db->delete($tablename);
        if($bool){
            $this->set_flash_msg("Record deleted successfully", "success");
        } elseif($db->getLastError()){
            $page_error = $db->getLastError();
            $this->set_flash_msg($page_error, "danger");
        }
        return $this->redirect("pic_perusahaan");
    }
}
?>
