<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Materialgroup extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();	
		$this->load->model('mmaterialgroup');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_material_group(){
        $data = array();
        $data['page_title'] = 'Material Group';	
        $data['main_content'] = $this->load->view('admin/materialgroup/v_material_group', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_material_group() 
	{		
		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mmaterialgroup->getData();
        $data = array();
        foreach($list->result() as $r) {

        	$data[] = array(			
            	$r->code,			
                $r->name,
                $r->description,
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
	
}