<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receivepackage extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');		
		$this->load->model('mreceive_package');
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
		
	public function toreceive_package(){
        $data = array();
        $data['page_title'] = 'Receive Package';		
        $data['main_content'] = $this->load->view('admin/receivepackage/v_receive_package', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function get_list_receive()
    {

    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mreceive_package->getData();

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

	public function edit_receive_package($id){		
        $data = array();
        $data['page_title'] = 'Detail Receive Package';				
		$data["data"] = $this->mreceive_package->getDetail($id);	
				
        $data['main_content'] = $this->load->view('admin/receivepackage/form_receive_package', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function finish() {
		$data = $this->input->post("data");
		
		$ret = $this->mreceive_package->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package completed successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
}