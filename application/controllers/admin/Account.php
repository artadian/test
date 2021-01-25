<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');
		$this->load->model('maccount');
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	 public function account_setting(){		
        $data = array();
        $data['page_title'] = 'Account Setting';
		$data['main_content'] = $this->load->view('admin/account/form_account', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function change_password() {
		$data = $this->input->post("data");
		
		$ret = $this->maccount->change_password($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Password changed successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}	

}