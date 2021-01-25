<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ongoingpackage extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');
		$this->load->model('mlist_ongoing');				
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function list_ongoing(){
        $data = array();
        $data['page_title'] = 'On Going Package';		
        $data['main_content'] = $this->load->view('admin/ongoingpackage/v_list_ongoing', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function get_list()
    {

    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mlist_ongoing->getData();

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->ID,					
                    $r->No,
                    $r->Tanggal,
                    $r->Dari,
                    $r->Pengirim,
					$r->NextStop,
					$r->Kurir,
					$r->Keterangan
            );
        }

		$output = array(
              	"draw" => $draw,
                 "recordsTotal" => $list->num_rows(),
                 "recordsFiltered" => $list->num_rows(),
                 "data" => $data
       	);
        echo json_encode($output);
        exit();
    }
	 
	public function receive_package() {
		$idcheck = $this->input->post("idcheck");
		
		$ret = $this->mlist_ongoing->receive($idcheck);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package has been received");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Received Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}    
	
}