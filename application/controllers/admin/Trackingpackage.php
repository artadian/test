<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trackingpackage extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');
		$this->load->model('mtracking_package');
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	 public function tracking_package(){		
        $data = array();
        $data['page_title'] = 'Tracking Package';
		$data['nopaket'] = $this->session->flashdata('nopaket'); 
        $data['main_content'] = $this->load->view('admin/trackingpackage/form_tracking_package', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function search() {
		$data = $this->input->post("data");
		
		$ret = $this->mtracking_package->search($data);
		
		echo json_encode($ret); 
	}
	

}