<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salesoffice extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mstock');	
        $this->load->model('msalesoffice');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Sales Office';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	
    public function list_salesoffice(){
        $data = array();    
        $data['page_title'] = 'Sales Office'; 

        $data['region'] = $this->mglobal->getRegion();
        array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));

        $data['main_content'] = $this->load->view('admin/Salesoffice/v_salesoffice', $data, TRUE);        
        $this->load->view('admin/index', $data);
    }
    public function get_list_salesoffice() 
    {       
       

        $draw       = intval($this->input->post("draw"));
        $start      = intval($this->input->post("start"));
        $length     = intval($this->input->post("length"));

        $regionid      = $this->input->post("regionid");
        $arr        = array($regionid);

        $list = $this->msalesoffice->getData($arr);
        $data = array();
        //var_dump($list);exit();
        foreach($list->result() as $r) {

            $data[] = array(  
                $r->id,           
                $r->region_nama,
                $r->code,
                $r->name,
                $r->lookupdesc
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
    public function edit_salesoffice($id){
        $data = array();
        $data["data"] = $this->msalesoffice->getDetail($id);   
        if ($id == '0')
        {
            $data['page_title']     = 'Sales Office - New';     
            $data['mode']           = 'new';
            
            $data['region']         = $this->mglobal->getRegion();
            array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Please select region ---'));
            $data['salesofficetype']  = $this->mglobal->getsales_office_typeClass();
            array_unshift($data['salesofficetype'],array('id'=>'-', 'name'=>'--- Please select type group ---'));
        }
        else
        {
            $data['page_title'] = 'Sales Office - Edit';    
            $data['mode'] = 'edit'; 

            $data['region']         = $this->mglobal->getRegion();
            array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Please select region ---'));
            $data['salesofficetype']  = $this->mglobal->getsales_office_typeClass();
            array_unshift($data['salesofficetype'],array('id'=>'-', 'name'=>'--- Please select type group ---'));  
        }   
        $data['main_content'] = $this->load->view('admin/salesoffice/form_salesoffice', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function save() {
        $data = $this->input->post("data");
        //var_dump($data);exit();
        $ret = $this->msalesoffice->save($data);

        
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data saved successfully");          
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Save Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    }
    public function delete_salesoffice() {
        $id = $this->input->post("id");
        
        $ret = $this->msalesoffice->delete_salesoffice($id);
        
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data has been deleted");            
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    } 
    public function view_salesoffice($id){       
        $data = array();
        $data['page_title'] = 'Competitor - View';  
        $data['mode'] = 'view';         
               
        $data['region']           = $this->mglobal->getRegion(); 
        $data['salesofficetype']  = $this->mglobal->getsales_office_typeClass();     
        $data['data'] = $this->msalesoffice->getDetail($id);
        $data['main_content'] = $this->load->view('admin/salesoffice/form_salesoffice', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
}