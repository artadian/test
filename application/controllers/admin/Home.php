<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mhome');
		$this->load->model('mtransaksi');
			
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function tracking_package(){
		$data = $this->input->post("data");	
		$data = json_decode($data,true);		
		$header = $data["header"];
		$header = json_decode($header,true);	
        $this->session->set_flashdata('nopaket', $header['no']);
		$ret['status'] = 'ok';
		echo json_encode($ret); 
    }
	
	public function tracking_document(){
		$data = $this->input->post("data");	
		$data = json_decode($data,true);		
		$header = $data["header"];
		$header = json_decode($header,true);	
        $this->session->set_flashdata('nodoc', $header['no']);
		$ret['status'] = 'ok';
		echo json_encode($ret); 
    }
	
	public function count_dashboard(){
		$totalPO = $this->mtransaksi->getSumPO();
		$ret['totalPO'] = $totalPO[0]['total'];
		// $ret['data'] = $this->mhome->getCountData();
		$ret['status'] = 'ok';
		echo json_encode($ret); 
    }
	
}