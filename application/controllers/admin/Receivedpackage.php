<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receivedpackage extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');		
		$this->load->model('mreceived_package');
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
		
	public function received_package(){
        $data = array();
        $data['page_title'] = 'Receive Package';		
        $data['main_content'] = $this->load->view('admin/receivedpackage/v_received_package', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function get_list_received()
    {

    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mreceived_package->getData();

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->ID,					
                    $r->No,
                    $r->Tanggal,
                    $r->Dari,
                    $r->Pengirim,
					$r->FinalStop,					
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

	public function edit_received_package($id){		
        $data = array();
        $data['page_title'] = 'Detail Received Package';				
		$data["data"] = $this->mreceived_package->getDetail($id);	
				
        $data['main_content'] = $this->load->view('admin/receivedpackage/form_received_package', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function cancel() {
		$data = $this->input->post("data");
		
		$ret = $this->mreceived_package->cancel($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package has been cancelled and moved to On Progress - Receive Package");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
}