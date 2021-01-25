<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Competitor extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mcompetitor');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_competitor(){
        $data = array();
        $data['page_title'] = 'Competitor';			
        $data['main_content'] = $this->load->view('admin/competitor/v_competitor', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_competitor() 
	{		
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mcompetitor->getData();
        $data = array();
        foreach($list->result() as $r) {

        	$data[] = array(					
            	$r->id,			
                $r->name,
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
	
	public function edit_competitor($id){		
        $data = array();

		$data['data'] = $this->mcompetitor->getDetail($id);	
		if ($id == 0)
		{
			$data['mode'] = 'new';
			$data['page_title'] = 'Competitor - New';	
		}
		else
		{
			$data['mode'] = 'edit';
			$data['page_title'] = 'Competitor - Edit';	
		} 
        $data['main_content'] = $this->load->view('admin/competitor/form_competitor', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function save() {
		$data = $this->input->post("data");
		
		$ret = $this->mcompetitor->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_competitor() {
		$id = $this->input->post("id");
		
		$ret = $this->mcompetitor->delete_competitor($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_competitor($id){		
        $data = array();
		$data['page_title'] = 'Competitor - View';	
		$data['mode'] = 'view';			
		        
		$data["data"] = $this->mcompetitor->getDetail($id);
        $data['main_content'] = $this->load->view('admin/competitor/form_competitor', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
}