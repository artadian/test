<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trackingdocument extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');
		$this->load->model('mtracking_document');
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	 public function tracking_document(){		
        $data = array();
        $data['page_title'] = 'Tracking Document';
		$data['nodoc'] = $this->session->flashdata('nodoc'); 				
        $data['main_content'] = $this->load->view('admin/trackingdocument/form_tracking_document', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function search() {
		$data = $this->input->post("data");
		
		$ret = $this->mtracking_document->search($data);
		
		echo json_encode($ret); 
	}
	

}