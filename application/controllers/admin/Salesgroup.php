<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salesgroup extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mstock');
        $this->load->model('msalesgroup');			
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Sales Group';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	
    public function list_salesgroup(){
        $data = array();
        $data['page_title'] = 'Sales Group';		
		
		$data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/salesgroup/v_salesgroup', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }
    public function get_list_salesgroup() 
    {       
       

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $regionid      = $this->input->post("regionid");
        $salesofficeid = $this->input->post("salesofficeid");
        $arr           = array($salesofficeid);

        $list = $this->msalesgroup->getData($arr);
        $data = array();
        //var_dump($list);exit();
        foreach($list->result() as $r) {

            $data[] = array(  
                $r->id,           
                $r->region_name,
                $r->sales_office_name,
                $r->code,
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

    public function edit_salesgroup($id){
        $data = array();
        $data["data"] = $this->msalesgroup->getDetail($id);   
        if ($id == '0')
        {
            $data['page_title']     = 'Sales Group - New';     
            $data['mode']           = 'new';
            
            
            $data['region']         = $this->mglobal->getRegion();
            array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Please select region ---'));
           
        }
        else
        {
            $data['page_title'] = 'Sales Group - Edit';    
            $data['mode'] = 'edit'; 

            $data['SalesOffice']     = $this->msalesgroup->getSalesOffice(); 
            $data['region']         = $this->mglobal->getRegion();
            array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Please select region ---'));
          
        }   
        $data['main_content'] = $this->load->view('admin/salesgroup/form_salesgroup', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
    function getSalesOffice(){
        $regionid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesOffice($regionid);
        array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales Office ---'));        
        echo json_encode($ret);             
    }
    public function save() {
        $data = $this->input->post("data");
        //var_dump($data);exit();
        $ret = $this->msalesgroup->save($data);

        
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data saved successfully");          
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Save Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    }
    public function delete_salesgroup() {
        $id = $this->input->post("id");
        
        $ret = $this->msalesgroup->delete_salesgroup($id);
        
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data has been deleted");            
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    } 
    public function view_salesgroup($id){       
        $data = array();
        $data['page_title'] = 'Competitor - View';  
        $data['mode'] = 'view';         
               
        $data['region']             = $this->mglobal->getRegion(); 
        $data['SalesOffice']     = $this->msalesgroup->getSalesOffice();     
        $data['data'] = $this->msalesgroup->getDetail($id);
        $data['main_content'] = $this->load->view('admin/salesgroup/form_salesgroup', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
}