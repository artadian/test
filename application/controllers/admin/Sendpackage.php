<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendpackage extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');		
		$this->load->model('msend_package');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function send_package(){
        $data = array();
        $data['page_title'] = 'Send Package';		
        $data['main_content'] = $this->load->view('admin/sendpackage/v_send_package', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

	public function get_list_send()
    {

    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->msend_package->getData();

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
	
	public function edit_send_package($id){		
        $data = array();
        $data['page_title'] = 'Detail Send Package';				
		$data["data"] = $this->msend_package->getDetail($id);
		
		$data['userStop'] = $this->msend_package->getUserStop();
		array_unshift($data['userStop'],array('ID'=>'-', 'Nama'=>'--- Please select Next Stop ---'));
		
		//$data['courier'] = $this->msend_package->select('kurir');		
		$data['courier'] = $this->msend_package->getCourier();		
		array_unshift($data['courier'],array('ID'=>'-', 'Nama'=>'--- Please select Courier ---'));
		
        $data['main_content'] = $this->load->view('admin/sendpackage/form_send_package', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function send() {
		$data = $this->input->post("data");
		
		$ret = $this->msend_package->send($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package sent successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function stop() {
		$data = $this->input->post("data");
		
		$ret = $this->msend_package->stop($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package stopped");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function split() {
		$data = $this->input->post("data");
		
		$ret = $this->msend_package->split($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package splitted successfully. New Package : ".$ret["nopaket"]);			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
}