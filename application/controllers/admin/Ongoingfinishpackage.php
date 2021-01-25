<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ongoingfinishpackage extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');
		$this->load->model('mlist_ongoingfinish');				
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function list_ongoingfinish(){
        $data = array();
        $data['page_title'] = 'Received On Going Package';		
        $data['main_content'] = $this->load->view('admin/ongoingfinishpackage/v_list_ongoingfinish', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function get_list()
    {

    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mlist_ongoingfinish->getData();

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
					$r->Keterangan,
					$r->Status,
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
	 
	public function cancel_receive() {
		$idcheck = $this->input->post("idcheck");
		
		$ret = $this->mlist_ongoingfinish->cancel($idcheck);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package has been cancelled and moved to On Progress - On Going Package");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Cancelled Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}    
	
}