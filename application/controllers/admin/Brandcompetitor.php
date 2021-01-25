<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brandcompetitor extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mbrandcompetitor');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_brand_competitor(){
        $data = array();
        $data['page_title'] = 'Brand Competitor';	
        $data['competitor'] = $this->mglobal->getCompetitor();
		array_unshift($data['competitor'],array('id'=>'-', 'name'=>'--- Select Competitor ---'));			
        $data['main_content'] = $this->load->view('admin/brandcompetitor/v_brand_competitor', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_brand_competitor() 
	{		
		$competitor = $this->input->post("competitor");	
		$arr = array($competitor);

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mbrandcompetitor->getData($arr);
        $data = array();
        foreach($list->result() as $r) {

        	$data[] = array(					
            	$r->id,			
                $r->competitor,
                $r->brand,
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
	
	public function edit_brand_competitor($id){		
        $data = array();

		$data['data'] = $this->mbrandcompetitor->getDetail($id);	
		$data['competitor'] = $this->mglobal->getCompetitor();	
		if ($id == 0)
		{
			$data['mode'] = 'new';
			$data['page_title'] = 'Brand Competitor - New';	
		}
		else
		{
			$data['mode'] = 'edit';
			$data['page_title'] = 'Brand Competitor - Edit';	
		} 
        $data['main_content'] = $this->load->view('admin/brandcompetitor/form_brand_competitor', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function save() {
		$data = $this->input->post("data");
		
		$ret = $this->mbrandcompetitor->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_brand_competitor() {
		$id = $this->input->post("id");
		
		$ret = $this->mbrandcompetitor->delete_brand_competitor($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_brand_competitor($id){		
        $data = array();
		$data['page_title'] = 'Brand Competitor - View';	
		$data['mode'] = 'view';			
		        
		$data["data"] = $this->mbrandcompetitor->getDetail($id);
		$data['competitor'] = $this->mglobal->getCompetitor();	
        $data['main_content'] = $this->load->view('admin/brandcompetitor/form_brand_competitor', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
}