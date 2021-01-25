<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Materialprice extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('mglobal');	
		$this->load->model('mmaterialprice');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_material_price(){
        $data = array();
        $data['page_title'] = 'Material Price';	
        $data['price'] = $this->mglobal->getPrice();
		array_unshift($data['price'],array('id'=>'-', 'name'=>'--- Select Price ---'));			
        $data['main_content'] = $this->load->view('admin/materialprice/v_material_price', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_material_price() 
	{		
		$price = $this->input->post("price");	
		$arr = array($price);

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mmaterialprice->getData($arr);
        $data = array();
        foreach($list->result() as $r) {

        	$data[] = array(					
            	$r->material,			
                $r->material_desc,
                $r->price,
                $r->value,
                $r->validfrom,
                $r->validto,
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