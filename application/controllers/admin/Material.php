<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('mmaterial');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_material(){
        $data = array();
        $data['page_title'] = 'Material';	
        $data['main_content'] = $this->load->view('admin/material/v_material', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_material() 
	{		
		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mmaterial->getData();
        $data = array();
        foreach($list->result() as $r) {

        	$data[] = array(			
            	$r->material,			
                $r->material_desc,
                $r->material_group,
                $r->material_group_desc,
                $r->bal,
                $r->slof,
                $r->pac,
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