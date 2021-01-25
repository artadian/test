<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Region extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mstock');
        $this->load->model('mregion');			
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Region';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	
    public function list_region(){
        $data = array();
        $data['page_title'] = 'Region';	
        $data['main_content'] = $this->load->view('admin/Region/v_region', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }
    public function get_list_region() 
    {       
       

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mregion->getData();
        $data = array();
        //var_dump($list);exit();
        foreach($list->result() as $r) {

            $data[] = array( 
                $r->id,        
                $r->name
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

    public function edit_region($id){
        $data = array();
        $data["data"] = $this->mregion->getDetail($id);   
        if ($id == '0')
        {
            $data['page_title']     = 'Region - New';     
            $data['mode']           = 'new';
        }
        else
        {
            $data['page_title'] = 'Region - Edit';    
            $data['mode'] = 'edit'; 
        }   
        $data['main_content'] = $this->load->view('admin/region/form_region', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
    public function save() {
        $data = $this->input->post("data");
       
        $ret = $this->mregion->save($data);
        
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data saved successfully");          
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Save Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    }

    public function delete_region() {
        $id = $this->input->post("id");
        
        $ret = $this->mregion->delete_region($id);
        
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data has been deleted");            
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    } 
    public function view_region($id){       
        $data = array();
        $data['page_title'] = 'Competitor - View';  
        $data['mode'] = 'view';         
               
            
        $data['data'] = $this->mregion->getDetail($id);
        $data['main_content'] = $this->load->view('admin/region/form_region', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    
	
}