<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportsent extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');		
		$this->load->model('mreport_sent');
	}

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
		
	public function list_sent(){
        $data = array();
        $data['page_title'] = 'Sent';		
        $data['main_content'] = $this->load->view('admin/reportsent/v_report_sent', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function get_list_sent()
    {

    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mreport_sent->getData();

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->ID,					
                    $r->No,
					$r->Status,
                    $r->Tanggal,                    
                    $r->Pengirim,
					$r->FinalStop,					
					$r->Keterangan,
					$r->Kurir,
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

	public function edit_sent($id){		
        $data = array();
        $data['page_title'] = 'Detail Sent Package';				
		$data["data"] = $this->mreport_sent->getDetail($id);	
				
        $data['main_content'] = $this->load->view('admin/reportsent/form_report_sent', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	
	
}